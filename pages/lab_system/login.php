<?php
include 'auth.php';

/*
if (isLoggedIn()) {
    header('Location: dashboard.php');
    exit;
} */


unset($_SESSION['user_name']);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if (loginUser($username, $password)) {

        $_SESSION['user_name']=$username;
        header('Location: ../index.php');
        exit;
    } else {
        $error = "Invalid username or password";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-dark: #3a56d4;
            --error-color: #ef233c;
            --text-color: #2b2d42;
            --light-gray: #edf2f4;
            --white: #ffffff;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --border-radius: 8px;
            --transition: all 0.3s ease;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            color: var(--text-color);
            line-height: 1.6;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            padding: 20px;
        }

        .login-container {
            background-color: var(--white);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            width: 100%;
            max-width: 420px;
            padding: 40px;
            transition: var(--transition);
        }

        .login-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .login-header h2 {
            color: var(--primary-color);
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .login-header p {
            color: #6c757d;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 14px;
            color: var(--text-color);
        }

        .form-group input {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #ced4da;
            border-radius: var(--border-radius);
            font-size: 15px;
            transition: var(--transition);
        }

        .form-group input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.2);
        }

        .error {
            color: var(--error-color);
            font-size: 14px;
            margin-bottom: 15px;
            text-align: center;
            padding: 10px;
            background-color: rgba(239, 35, 60, 0.1);
            border-radius: var(--border-radius);
        }

        .login-button {
            width: 100%;
            padding: 12px;
            background-color: var(--primary-color);
            color: var(--white);
            border: none;
            border-radius: var(--border-radius);
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            margin-top: 10px;
        }

        .login-button:hover {
            background-color: var(--primary-dark);
        }

        .forgot-password {
            text-align: center;
            margin-top: 20px;
        }

        .forgot-password a {
            color: #6c757d;
            text-decoration: none;
            font-size: 14px;
            transition: var(--transition);
        }

        .forgot-password a:hover {
            color: var(--primary-color);
        }

        @media (max-width: 480px) {
            .login-container {
                padding: 30px 20px;
            }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-header">
            <h2>Welcome Back</h2>
            <p>Please enter your credentials to login</p>
        </div>
        
        <?php if (isset($error)): ?>
            <p class="error"><?php echo $error; ?></p>
        <?php endif; ?>
        
        <form method="post">
            <div class="form-group">
                <label for="username">Username</label>
                <input type="text" id="username" name="username" required placeholder="Enter your username">
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" id="password" name="password" required placeholder="Enter your password">
            </div>
            
            <button type="submit" class="login-button">Login</button>
            
            <div class="forgot-password">
                <a href="#">Forgot password?</a>
            </div>
        </form>
    </div>
</body>
</html>