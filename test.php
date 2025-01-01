<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Settings</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: black;
            margin: 0;
            padding: 0;
            color: white;
        }
        .container {
            width: 50%;
            margin: 50px auto;
            background: gray;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
        }
        h2 {
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group button {
            padding: 10px 15px;
            background: #007BFF;
            color: #fff;
            border: none;
            cursor: pointer;
            border-radius: 5px;
        }
        .form-group button:hover {
            background: #0056b3;
        }
        .form-group1 button {
            padding: 10px 15px;
            background: #007BFF;
            color: #fff;
            border: none;
            cursor: pointer;
            float: right;
        }
        .form-group1 button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>User Settings</h2>
        <form id="settingsForm" method="POST" action="save_settings.php">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required>
            </div>
            <div class="form-group">
                <label for="language">Preferred Language</label>
                <select id="language" name="language">
                    <option value="en">English</option>
                    <option value="es">Spanish</option>
                    <option value="fr">French</option>
                </select>
            </div>
            <div class="form-group">
                <label for="timezone">Timezone</label>
                <select id="timezone" name="timezone">
                    <option value="UTC-5">UTC-5</option>
                    <option value="UTC+0">UTC+0</option>
                    <option value="UTC+5">UTC+5</option>
                </select>
            </div>
            <div class="form-group">
                <label for="theme">Theme</label>
                <select id="theme" name="theme">
                    <option value="light">Light</option>
                    <option value="dark">Dark</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit">Save Settings</button>
            </div>
            <div class="form-group">
            <button type="button" id="themeToggle">Toggle Theme</button>
        </div>
        </form>
    </div>

    <script>
        document.getElementById('settingsForm').addEventListener('submit', function(event) {
            event.preventDefault();
            alert('Settings saved successfully!');
            // Here you can add AJAX call to save settings without reloading the page
        });

        const themeToggle = document.getElementById('themeToggle');
        const body = document.body;
        const themeSelect = document.getElementById('theme');

        function applyTheme(theme) {
            if (theme === 'dark') {
                body.style.backgroundColor = 'black';
                body.style.color = 'white';
            } else {
                body.style.backgroundColor = 'white';
                body.style.color = 'black';
            }
        }

        themeToggle.addEventListener('click', function() {
            const currentTheme = body.style.backgroundColor === 'black' ? 'light' : 'dark';
            applyTheme(currentTheme);
            localStorage.setItem('theme', currentTheme);
            themeSelect.value = currentTheme;
        });

        themeSelect.addEventListener('change', function() {
            applyTheme(this.value);
            localStorage.setItem('theme', this.value);
        });

        // Load saved theme from localStorage
        const savedTheme = localStorage.getItem('theme') || 'light';
        applyTheme(savedTheme);
        themeSelect.value = savedTheme;
    </script>
</body>
</html>
