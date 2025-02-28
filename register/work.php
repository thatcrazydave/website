<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Community</title>
    <style>
        .form-container {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            background: #f4f4f4;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
        }
        .form-control {
            width: 100%;
            padding: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .category-select {
            width: 100%;
            padding: 1rem;
            border: 1px solid #ddd;
            border-radius: 5px;
            background-color: #fff;
            cursor: pointer;
        }
        .category-select option {
            padding: 1rem;
        }
        .category-select option:hover {
            background-color: #f0f0f0;
        }
        button[type="submit"] {
            width: 100%;
            padding: 1rem;
            background: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Join Our Community</h2>
        <form action="workpro.php" method="POST">
            <div class="form-group">
                <label>Full Name:</label>
                <input type="text" name="fullname" required class="form-control">
            </div>
            
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" required class="form-control">
            </div>

            <div class="form-group">
                <label>Select Community Category:</label>
                <select name="category" class="category-select">
                    <option value="">Select a category</option>
                    <option value="web-development">Web Development</option>
                    <option value="data-science">Data Science</option>
                    <option value="digital-marketing">Digital Marketing</option>
                </select>
            </div>

            <button type="submit">Join Community</button>
        </form>
    </div>
</body>
</html>