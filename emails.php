<?php
require 'data.php';

// Pagination settings
$limit = 5; // Number of emails per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search functionality
$search = '';
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

// Prepare the SQL query
$query = "SELECT * FROM users WHERE email LIKE :search LIMIT :limit OFFSET :offset";
$stmt = $pdo->prepare($query);
$stmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
$stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
$stmt->execute();
$emails = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Count total emails for pagination
$countQuery = "SELECT COUNT(*) FROM users WHERE email LIKE :search";
$countStmt = $pdo->prepare($countQuery);
$countStmt->bindValue(':search', '%' . $search . '%', PDO::PARAM_STR);
$countStmt->execute();
$totalEmails = $countStmt->fetchColumn();
$totalPages = ceil($totalEmails / $limit);

// Handle email deletion
if (isset($_GET['delete'])) {
    $idToDelete = (int)$_GET['delete'];
    $deleteStmt = $pdo->prepare("DELETE FROM users WHERE id = :id");
    $deleteStmt->bindParam(':id', $idToDelete);
    $deleteStmt->execute();
    header('Location: emails.php'); // Redirect to avoid resubmission
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stored Emails</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .container {
            background-color: #ffffff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }
        .table th, .table td {
            vertical-align: middle;
        }
        .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
        }
        .form-inline .form-control {
            width: auto;
            flex: 1;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }
        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }
        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }
        .btn-secondary {
            background-color: #6c757d;
            border-color: #6c757d;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
            border-color: #545b62;
        }
    </style>
</head>
<body>
    <div class="container mt-5">
        <h2 class="mb-4">Stored Emails</h2>
        
        <!-- Search Form -->
        <form class="form-inline mb-3" method="GET" action="emails.php">
            <input type="text" name="search" class="form-control mr-2" placeholder="Search emails" value="<?php echo htmlspecialchars($search); ?>" autocomplete="off">
            <button type="submit" class="btn btn-primary">Search</button>
        </form>

        <!-- Logout Button -->
        <form method="POST" action="index.php" class="mb-3">
            <button type="submit" class="btn btn-secondary">Logout</button>
        </form>

        <table class="table table-striped table-hover">
            <thead class="thead-dark">
                <tr>
                    <th>ID</th>
                    <th>Email</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($emails): ?>
                    <?php foreach ($emails as $email): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($email['id']); ?></td>
                            <td><?php echo htmlspecialchars($email['email']); ?></td>
                            <td><?php echo htmlspecialchars($email['created_at']); ?></td>
                            <td>
                                <a href="?delete=<?php echo $email['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this email?');">Delete</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="text-center">No emails found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Pagination -->
        <nav>
            <ul class="pagination justify-content-center">
                <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                    <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                        <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                    </li>
                <?php endfor; ?>
            </ul>
        </nav>
    </div>
</body>
</html>