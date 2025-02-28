<?php
session_start();

// Generate a CSRF token if it doesn't exist
if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup | Site</title>
    <link rel="stylesheet" href="signup.css">
    <style>
        .error-message {
            color: #ff4d4d;
            font-size: 16px;
            font-weight: 600;
            text-align: center;
            padding: 15px;
            border: 1px solid #ff4d4d;
            border-radius: 5px;
            background-color: #ffe6e6;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
            display: none;
            transition: all 0.3s ease-in-out;
        }

        .error-message.show {
            display: block;
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .toggle-password {
            display: flex;
            align-items: center;
            margin-top: 10px;
        }

        .toggle-password input[type="checkbox"] {
            display: none;
        }

        .toggle-password label {
            display: flex;
            align-items: center;
            cursor: pointer;
            font-size: 14px;
            color: #333;
        }

        .toggle-password label::before {
            content: '';
            display: inline-block;
            width: 20px;
            height: 20px;
            margin-right: 10px;
            border: 2px solid #333;
            border-radius: 4px;
            background-color: #fff;
            transition: background-color 0.3s, border-color 0.3s;
        }

        .toggle-password input[type="checkbox"]:checked + label::before {
            background-color: #333;
            border-color: #333;
        }

        .toggle-password label span {
            display: inline-block;
            vertical-align: middle;
        }
    </style>
</head>
<body>
    <div class="gen">
        <header>
            <div class="container">
                <a href="../index.php" class="logo">AP<b>OLO</b></a>
                <ul class="links">
                </ul>
            </div>
        </header>
        <main>
            <?php if (isset($_SESSION['error_messages'])): ?>
                <div class="error-message show">
                    <?php foreach ($_SESSION['error_messages'] as $error): ?>
                        <p><?php echo htmlspecialchars($error); ?></p>
                    <?php endforeach; ?>
                </div>
                <?php unset($_SESSION['error_messages']); ?>
            <?php endif; ?>

            <?php if (isset($_SESSION['success_message'])): ?>
                <div class="success-message show">
                    <p><?php echo htmlspecialchars($_SESSION['success_message']); ?></p>
                </div>
                <?php unset($_SESSION['success_message']); ?>
            <?php endif; ?>

            <section class="container1">
                <h2>Create Account</h2>
                <form action="signpro.php" method="POST" autocomplete="off" novalidate>
                    <input type="text" id="fullname" name="fullname" placeholder="Full Name" value="<?php echo isset($_SESSION['input_data']['fullname']) ? htmlspecialchars($_SESSION['input_data']['fullname']) : ''; ?>" autocomplete="off">
                    <br>
                    <input type="text" id="username" name="uid" placeholder="Username" value="<?php echo isset($_SESSION['input_data']['username']) ? htmlspecialchars($_SESSION['input_data']['username']) : ''; ?>" autocomplete="off">
                    <br>
                    <input type="email" id="email" name="mail" placeholder="Email" value="<?php echo isset($_SESSION['input_data']['email']) ? htmlspecialchars($_SESSION['input_data']['email']) : ''; ?>" autocomplete="off">
                    <br>
                    <input type="password" id="password" name="pwd" placeholder="Password" value="<?php echo isset($_SESSION['input_data']['password']) ? htmlspecialchars($_SESSION['input_data']['password']) : ''; ?>" autocomplete="off">
                    <br>
                    <input type="password" id="passwordRepeat" name="pwdrepeat" placeholder="Repeat Password" autocomplete="off">
                    <br>
                    <div class="toggle-password">
                        <input type="checkbox" id="showPassword">
                        <label for="showPassword"><span>Show Password</span></label>
                    </div>
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <br>
                    <button type="submit">Submit</button>
                    <p>Have an account? <a href="login.php">Login</a>.</p>
                </form>
            </section>
        </main>
    </div>
    <script>
        document.getElementById('showPassword').addEventListener('change', function() {
            const passwordFields = [document.getElementById('password'), document.getElementById('passwordRepeat')];
            passwordFields.forEach(field => {
                field.type = this.checked ? 'text' : 'password';
            });
        });
    </script>
</body>
</html>