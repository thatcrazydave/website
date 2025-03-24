<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Community</title>
    <style>
        body {
            font-family: 'Open Sans', sans-serif;
        }
        .form-container {
            width: 100%;
            max-width: 400px;
            margin: 50px auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-top: 70px;
        }
        .form-container h2{
            text-align: center;
        }
        .form-group {
            margin-bottom: 1rem;
        }
        .form-group label {
            display: block;
            margin-bottom: 0.5rem;
        }
        .gen{
            margin-top: 30px;
        }
        .form-control {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 10px;
            height: 40px;
            min-width: 300px;
        }
        form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .category-select {
            width: 80%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 10px;
            height: 40px;
            min-width: 300px;
        }
        .category-select option {
            padding: 1rem;
        }
        .category-select option:hover {
            background-color: #f0f0f0;
        }
        button[type="submit"] {
            width: 50%;
            padding: 1rem;
            background-color: #5cb85c;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
        }
        button[type="submit"]:hover {
            background: #0056b3;
        }

        header .container {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 30px;
        }

        header .logo {
            color: #5d5d5d;
            font-style: italic;
            text-transform: uppercase;
            font-size: 20px;
        }
        a{
            text-decoration: none;
        }
        ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        * {
            box-sizing: border-box;
        }
        .container {
            padding-left: 15px;
            padding-right: 15px;
            margin-left: auto;
            margin-right: auto;
            max-width: 1170px; /* Added max-width */
        }
    </style>
</head>
<body>
<header>
            <div class="container">
                <a href="../welcome.php" class="logo">AP<b>OLO</b></a>
                <ul class="links">
                </ul>
            </div>
        </header>
    <div class="form-container">
        <h2>Join The Family</h2>
        <form action="workpro.php" method="POST" autocomplete="off" novalidate >
            <div class="form-group">
                <!-- <label>Full Name:</label> -->
                <input type="text" name="fullname" placeholder="Full name" required class="form-control">
            </div>
            
            <div class="form-group">
                <!-- <label>Email:</label> -->
                <input type="email" name="email" placeholder="Email" required class="form-control">
            </div>

            <div class="form-group">
                <!-- <label>Email:</label> -->
                <input type="number" name="phone" placeholder="Phone number" required class="form-control">
            </div>

            <div class="form-group">
                <!-- <label>Select Community Category:</label> -->
                <select name="category" class="category-select">
                    <option value=""> Community Category:</option>
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