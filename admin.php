<?php
session_start();
// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header('Location: login.php'); // Redirect to login if not logged in
    exit();
}
// fetch_all_users.php - Fetch all user details from the database
include 'database.php';

// Handle delete action
if (isset($_GET['delete_id'])) {
    $delete_id = (int)$_GET['delete_id'];
    $delete_query = "DELETE FROM users WHERE id = $delete_id";
    if ($conn->query($delete_query)) {
        header("Location: admin.php?delete_success=1");
        exit();
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}

// Pagination logic
$limit = 10; // Number of records per page
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $limit;

// Search functionality
$search = isset($_GET['search']) ? $_GET['search'] : '';
$searchCondition = $search ? "WHERE user_fullname LIKE '%$search%' OR user_email LIKE '%$search%'" : '';

// Fetch total number of records for pagination
$totalRecordsQuery = "SELECT COUNT(*) as total FROM users $searchCondition";
$totalRecordsResult = $conn->query($totalRecordsQuery);
$totalRecords = $totalRecordsResult->fetch_assoc()['total'];
$totalPages = ceil($totalRecords / $limit);

// Fetch users with pagination and search
$sql = "SELECT * FROM users $searchCondition LIMIT $limit OFFSET $offset";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Users</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            font-family: 'Arial', sans-serif;
        }
        .container {
            margin-top: 50px;
        }
        .table {
            background-color: #fff;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        .table th {
            background-color: #007bff;
            color: #fff;
            font-weight: 600;
            text-transform: uppercase;
        }
        .table td, .table th {
            padding: 12px;
            vertical-align: middle;
        }
        .table tr:hover {
            background-color: #f1f1f1;
        }
        .search-box {
            margin-bottom: 20px;
        }
        .pagination {
            justify-content: center;
            margin-top: 20px;
        }
        .pagination .page-item.active .page-link {
            background-color: #007bff;
            border-color: #007bff;
        }
        .pagination .page-link {
            color: #007bff;
        }
        .btn-delete {
            background-color: #dc3545;
            color: #fff;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn-delete:hover {
            background-color: #c82333;
        }
        a{
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1 class="text-center mb-4">All Users</h1>

        <!-- Search Box -->
        <div class="search-box">
            <form method="GET" action="">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" name="search" placeholder="Search by name or email" value="<?php echo htmlspecialchars($search); ?>">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </form>
        </div>

        <!-- User Table -->
        <?php if ($result->num_rows > 0): ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Username</th>
                        <th>Email</th> 
                        <!-- <th>Password</th> -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($user = $result->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['id']); ?></td>
                            <td><?php echo htmlspecialchars($user['user_fullname']); ?></td>
                            <td><?php echo htmlspecialchars($user['user_uid']); ?></td>
                            <td><?php echo htmlspecialchars($user['user_email']); ?></td>
                            <!-- <td><?php echo htmlspecialchars($user['user_pwd']); ?></td> -->
                            <td>
                                <a href="?delete_id=<?php echo $user['id']; ?>" class="btn-delete" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p class="text-center">No users found.</p>
        <?php endif; ?>

        <!-- Pagination -->
        <?php if ($totalPages > 1): ?>
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <li class="page-item <?php echo $i === $page ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>&search=<?php echo urlencode($search); ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                </ul>
            </nav>
        <?php endif; ?>
    </div>

    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- <button disabled="disabled">home</button> -->
     <div class="bt">
     <button><a href="logout.php">Logout</button>
     </div>
<style>
    .bt button{
        margin-left: 50%;
        margin-top: 20px;
        background-color: #007BFF;
        color: #fff;
        width: 100px;
        border-radius: 10px;
        border: 0;
    }
    .bt button a{
        color: #fff;
    }
</style>
</body>
</html>