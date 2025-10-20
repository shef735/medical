<?php
// create_user.php
require_once 'user_crud.php';

$message = '';
$message_type = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $lastname = trim($_POST['lastname']);
    $firstname = trim($_POST['firstname']);
    $middlename = trim($_POST['middlename']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $email = trim($_POST['email']);
    
    // Validation
    if (empty($username) || empty($lastname) || empty($firstname) || empty($password) || empty($email)) {
        $message = "All required fields must be filled!";
        $message_type = "danger";
    } elseif ($password !== $confirm_password) {
        $message = "Passwords do not match!";
        $message_type = "danger";
    } elseif (strlen($password) < 6) {
        $message = "Password must be at least 6 characters long!";
        $message_type = "danger";
    } elseif ($userCRUD->usernameExists($username)) {
        $message = "Username already exists! Please choose a different username.";
        $message_type = "danger";
    } elseif ($userCRUD->emailExists($email)) {
        $message = "Email already exists! Please use a different email address.";
        $message_type = "danger";
    } else {
        $result = $userCRUD->create($username, $lastname, $firstname, $middlename, $password, $email);
        if ($result) {
            $message = "User created successfully!";
            $message_type = "success";
            // Clear form
            $_POST = array();
        } else {
            $message = "Error creating user!";
            $message_type = "danger";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New User</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .password-strength {
            margin-top: 0.5rem;
            padding: 0.5rem;
            border-radius: 5px;
            font-size: 0.9rem;
        }
        .strength-weak { background-color: #f8d7da; color: #721c24; }
        .strength-medium { background-color: #fff3cd; color: #856404; }
        .strength-strong { background-color: #d1edff; color: #0c5460; }
        .strength-very-strong { background-color: #d4edda; color: #155724; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Add New User</h1>
            <p>Create a new user account</p>
        </div>

        <?php if ($message): ?>
            <div class="alert alert-<?php echo $message_type; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <div class="card">
            <div class="card-body">
                <form method="POST" action="" id="userForm">
                    <div class="form-group">
                        <label for="username">Username *</label>
                        <input type="text" class="form-control" id="username" name="username" 
                               value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>" 
                               required 
                               placeholder="Enter unique username">
                        <small class="form-text text-muted">Username must be unique and cannot be changed later.</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="lastname">Last Name *</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" 
                               value="<?php echo isset($_POST['lastname']) ? htmlspecialchars($_POST['lastname']) : ''; ?>" 
                               required>
                    </div>
                    
                    <div class="form-group">
                        <label for="firstname">First Name *</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" 
                               value="<?php echo isset($_POST['firstname']) ? htmlspecialchars($_POST['firstname']) : ''; ?>" 
                               required>
                    </div>
                    
                    <div class="form-group">
                        <label for="middlename">Middle Name</label>
                        <input type="text" class="form-control" id="middlename" name="middlename" 
                               value="<?php echo isset($_POST['middlename']) ? htmlspecialchars($_POST['middlename']) : ''; ?>" 
                               placeholder="Optional">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" 
                               required 
                               placeholder="Enter valid email address">
                    </div>
                    
                    <div class="form-group">
                        <label for="password">Password *</label>
                        <input type="password" class="form-control" id="password" name="password" 
                               required 
                               placeholder="Minimum 6 characters">
                        <div id="passwordStrength" class="password-strength" style="display: none;"></div>
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password">Confirm Password *</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                               required 
                               placeholder="Re-enter password">
                        <div id="passwordMatch" style="margin-top: 0.5rem;"></div>
                    </div>
                    
                    <button type="submit" class="btn btn-success">Create User</button>
                    <a href="users.php" class="btn btn-primary">Back to List</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');
            const passwordStrength = document.getElementById('passwordStrength');
            const passwordMatch = document.getElementById('passwordMatch');
            
            // Password strength checker
            password.addEventListener('input', function() {
                const pwd = password.value;
                let strength = '';
                let strengthClass = '';
                
                if (pwd.length === 0) {
                    passwordStrength.style.display = 'none';
                    return;
                }
                
                if (pwd.length < 6) {
                    strength = 'Weak - too short';
                    strengthClass = 'strength-weak';
                } else if (pwd.length < 8) {
                    strength = 'Medium';
                    strengthClass = 'strength-medium';
                } else if (/[A-Z]/.test(pwd) && /[0-9]/.test(pwd)) {
                    strength = 'Strong';
                    strengthClass = 'strength-strong';
                } else {
                    strength = 'Medium';
                    strengthClass = 'strength-medium';
                }
                
                if (pwd.length >= 10 && /[A-Z]/.test(pwd) && /[0-9]/.test(pwd) && /[^A-Za-z0-9]/.test(pwd)) {
                    strength = 'Very Strong';
                    strengthClass = 'strength-very-strong';
                }
                
                passwordStrength.textContent = 'Password Strength: ' + strength;
                passwordStrength.className = 'password-strength ' + strengthClass;
                passwordStrength.style.display = 'block';
            });
            
            // Password match checker
            confirmPassword.addEventListener('input', function() {
                if (confirmPassword.value.length === 0) {
                    passwordMatch.textContent = '';
                    return;
                }
                
                if (password.value === confirmPassword.value) {
                    passwordMatch.textContent = '✓ Passwords match';
                    passwordMatch.style.color = 'green';
                } else {
                    passwordMatch.textContent = '✗ Passwords do not match';
                    passwordMatch.style.color = 'red';
                }
            });
            
            // Auto-focus on username field
            document.getElementById('username').focus();
        });
    </script>
</body>
</html>