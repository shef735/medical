<?php
// edit_user.php
require_once 'user_crud.php';

if (!isset($_GET['username'])) {
    header("Location: users.php");
    exit();
}

$username = $_GET['username'];
$user = $userCRUD->read($username);

if (!$user) {
    header("Location: users.php");
    exit();
}

$message = '';
$message_type = '';

// Get return URL from referrer or default to users.php
$return_url = 'users.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $lastname = trim($_POST['lastname']);
    $firstname = trim($_POST['firstname']);
    $middlename = trim($_POST['middlename']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    
    // Validation
    if (empty($lastname) || empty($firstname) || empty($email)) {
        $message = "All required fields must be filled!";
        $message_type = "danger";
    } elseif (!empty($password) && $password !== $confirm_password) {
        $message = "Passwords do not match!";
        $message_type = "danger";
    } elseif (!empty($password) && strlen($password) < 6) {
        $message = "Password must be at least 6 characters long!";
        $message_type = "danger";
    } elseif ($userCRUD->emailExists($email, $username)) {
        $message = "Email already exists! Please use a different email address.";
        $message_type = "danger";
    } else {
        // Update with or without password change
        $result = $userCRUD->update($username, $lastname, $firstname, $middlename, $email, $password);
        if ($result) {
            $message = "User updated successfully!" . (!empty($password) ? " Password has been updated." : "");
            $message_type = "success";
            // Refresh user data
            $user = $userCRUD->read($username);
        } else {
            $message = "Error updating user!";
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
    <title>Edit User</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .username-display {
            background-color: #f8f9fa;
            border: 2px solid #667eea;
            border-radius: 5px;
            padding: 0.75rem;
            font-weight: bold;
            color: #495057;
            font-size: 1.1rem;
        }
        .password-note {
            background-color: #fff3cd;
            border-left: 4px solid #ffc107;
            padding: 1rem;
            margin-bottom: 1rem;
            border-radius: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Edit User</h1>
            <p>Update user information</p>
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
                        <label>Username</label>
                        <div class="username-display">
                            <?php echo htmlspecialchars($user['username']); ?>
                        </div>
                        <small class="form-text text-muted">Username cannot be changed.</small>
                    </div>
                    
                    <div class="form-group">
                        <label for="lastname">Last Name *</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" 
                               value="<?php echo htmlspecialchars($user['lastname']); ?>" 
                               required>
                    </div>
                    
                    <div class="form-group">
                        <label for="firstname">First Name *</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" 
                               value="<?php echo htmlspecialchars($user['firstname']); ?>" 
                               required>
                    </div>
                    
                    <div class="form-group">
                        <label for="middlename">Middle Name</label>
                        <input type="text" class="form-control" id="middlename" name="middlename" 
                               value="<?php echo htmlspecialchars($user['middlename']); ?>" 
                               placeholder="Optional">
                    </div>
                    
                    <div class="form-group">
                        <label for="email">Email *</label>
                        <input type="email" class="form-control" id="email" name="email" 
                               value="<?php echo htmlspecialchars($user['email']); ?>" 
                               required>
                    </div>
                    
                    <div class="password-note">
                        <strong>Password Update:</strong> Leave password fields blank if you don't want to change the password.
                    </div>
                    
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" class="form-control" id="password" name="password" 
                               placeholder="Leave blank to keep current password">
                    </div>
                    
                    <div class="form-group">
                        <label for="confirm_password">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirm_password" name="confirm_password" 
                               placeholder="Leave blank to keep current password">
                    </div>
                    
                    <button type="submit" class="btn btn-success">Update User</button>
                    <a href="<?php echo htmlspecialchars($return_url); ?>" class="btn btn-primary">Back to List</a>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const password = document.getElementById('password');
            const confirmPassword = document.getElementById('confirm_password');
            
            // Password match checker
            function checkPasswordMatch() {
                if (password.value && confirmPassword.value) {
                    if (password.value === confirmPassword.value) {
                        confirmPassword.style.borderColor = 'green';
                    } else {
                        confirmPassword.style.borderColor = 'red';
                    }
                } else {
                    confirmPassword.style.borderColor = '';
                }
            }
            
            password.addEventListener('input', checkPasswordMatch);
            confirmPassword.addEventListener('input', checkPasswordMatch);
            
            // Auto-focus on first name field
            document.getElementById('lastname').focus();
        });
    </script>
</body>
</html>