<?php
// Start the session to access session variables
if(!isset($_SESSION)){
    session_start();
}

// If the user is already logged in, redirect them to the menu
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true) {
    header("location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        :root {
            --primary-color: #007AFF;
            --background-color: #F2F2F7;
            --card-color: #FFFFFF;
            --text-color: #000000;
            --subtext-color: #8E8E93;
            --border-radius: 18px;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        body {
            background-color: var(--background-color);
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .login-container {
            background-color: var(--card-color);
            padding: 40px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            width: 100%;
            max-width: 400px;
            text-align: center;
        }

        .company-logo {
            max-width: 200px;
            margin-bottom: 25px;
        }

        h2 {
            color: var(--text-color);
            margin-bottom: 10px;
            font-size: 1.8rem;
        }

        p {
            color: var(--subtext-color);
            margin-bottom: 30px;
        }

        .input-group {
            position: relative;
            margin-bottom: 20px;
        }

        .input-group i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--subtext-color);
        }

        .input-field {
            width: 100%;
            padding: 15px 15px 15px 45px;
            border: 1px solid #E5E5EA;
            border-radius: 12px;
            background-color: #F2F2F7;
            font-size: 1rem;
            transition: border-color 0.3s;
        }

        .input-field:focus {
            outline: none;
            border-color: var(--primary-color);
        }

        .login-button {
            width: 100%;
            padding: 15px;
            border: none;
            border-radius: 12px;
            background-color: var(--primary-color);
            color: white;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .login-button:hover {
            background-color: #0056b3;
        }

        .error-message {
            background-color: #FF3B301A;
            color: #FF3B30;
            padding: 12px;
            border-radius: 10px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 0.9rem;
            border: 1px solid #FF3B3033;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <img src="../../uploads/logo/logo_RMQ.png" alt="Company Logo" class="company-logo">
        
        <h2>Welcome Back</h2>
        <p>Please enter your credentials to log in.</p>

        <?php 
        if (!empty($_SESSION['login_error'])) {
            echo '<div class="error-message">' . $_SESSION['login_error'] . '</div>';
            unset($_SESSION['login_error']); // Clear the error message after displaying
        }
        ?>

        <form action="process_login.php" method="post">
            <div class="input-group">
                <i class="fas fa-user"></i>
                <input type="text" name="username" class="input-field" placeholder="Username" required>
            </div>
            <div class="input-group">
                <i class="fas fa-lock"></i>
                <input type="password" name="password" class="input-field" placeholder="Password" required>
            </div>
            <button type="submit" class="login-button">Log In</button>
        </form>
    </div>
</body>
</html>