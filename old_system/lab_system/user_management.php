<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>


<?php
include 'auth.php';
include "../../Connections/dbname.php";

$message = '';
$error = '';

// Handle form submissions
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // --- ADD USER LOGIC ---
    if (isset($_POST['add_user'])) {
        $username = trim($_POST['username']);
        $password = $_POST['password'];
        $full_name = trim($_POST['full_name']);
        $role = $_POST['role'];
        
        if (empty($username) || empty($password) || empty($full_name)) {
            $error = "All fields are required";
        } else {
            // Check if username exists using a prepared statement
            $stmt_check = mysqli_prepare($conn, "SELECT user_id FROM ".$_SESSION['my_tables']."_laboratory.users WHERE username = ?");
            mysqli_stmt_bind_param($stmt_check, "s", $username);
            mysqli_stmt_execute($stmt_check);
            $result_check = mysqli_stmt_get_result($stmt_check);
            
            if (mysqli_num_rows($result_check) > 0) {
                $error = "Username already exists";
            } else {
                // Securely hash the password
                $password_hash = password_hash($password, PASSWORD_BCRYPT);
                
                // Use a prepared statement to insert the new user
                $sql = "INSERT INTO ".$_SESSION['my_tables']."_laboratory.users (username, password_hash, full_name, role) VALUES (?, ?, ?, ?)";
                $stmt_insert = mysqli_prepare($conn, $sql);
                mysqli_stmt_bind_param($stmt_insert, "ssss", $username, $password_hash, $full_name, $role);
                
                if (mysqli_stmt_execute($stmt_insert)) {
                    $message = "User added successfully";
                } else {
                    $error = "Error adding user: " . mysqli_error($conn);
                }
                mysqli_stmt_close($stmt_insert);
            }
            mysqli_stmt_close($stmt_check);
        }
    } 
    // --- UPDATE USER LOGIC ---
    elseif (isset($_POST['update_user'])) {
        $user_id = (int)$_POST['user_id'];
        $full_name = trim($_POST['full_name']);
        $role = $_POST['role'];
        $password = $_POST['password'];
        
        if (empty($full_name)) {
            $error = "Full name is required";
        } else {
            // Build the query dynamically and securely
            $sql = "UPDATE ".$_SESSION['my_tables']."_laboratory.users SET full_name = ?, role = ?";
            $bind_types = "ss";
            $bind_values = [$full_name, $role];

            if (!empty($password)) {
                $password_hash = password_hash($password, PASSWORD_BCRYPT);
                $sql .= ", password_hash = ?";
                $bind_types .= "s";
                $bind_values[] = $password_hash;
            }
            
            $sql .= " WHERE user_id = ?";
            $bind_types .= "i";
            $bind_values[] = $user_id;
            
            $stmt_update = mysqli_prepare($conn, $sql);
            mysqli_stmt_bind_param($stmt_update, $bind_types, ...$bind_values);
            
            if (mysqli_stmt_execute($stmt_update)) {
                $message = "User updated successfully";
            } else {
                $error = "Error updating user: " . mysqli_error($conn);
            }
            mysqli_stmt_close($stmt_update);
        }
    }
} 
// --- DELETE USER LOGIC ---
elseif (isset($_GET['delete'])) {
    $user_id = (int)$_GET['delete'];
    
    if ($user_id == $_SESSION['user_id']) {
        $error = "You cannot delete your own account";
    } else {
        // Use a prepared statement to delete the user
        $sql = "DELETE FROM ".$_SESSION['my_tables']."_laboratory.users WHERE user_id = ?";
        $stmt_delete = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt_delete, "i", $user_id);
        
        if (mysqli_stmt_execute($stmt_delete)) {
            $message = "User deleted successfully";
        } else {
            $error = "Error deleting user: " . mysqli_error($conn);
        }
        mysqli_stmt_close($stmt_delete);
    }
}

// Get all users
$sql = "SELECT * FROM ".$_SESSION['my_tables']."_laboratory.users ORDER BY role, full_name";
$result = mysqli_query($conn, $sql);
$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Management</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            margin-top: 0;
            color: #333;
        }
        .message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .success {
            background-color: #dff0d8;
            color: #3c763d;
        }
        .error {
            background-color: #f2dede;
            color: #a94442;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        .actions {
            white-space: nowrap;
        }
        .btn {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            cursor: pointer;
            border: 1px solid transparent;
            border-radius: 4px;
            text-decoration: none;
        }
        .btn-primary {
            color: #fff;
            background-color: #337ab7;
            border-color: #2e6da4;
        }
        .btn-primary:hover {
            background-color: #286090;
            border-color: #204d74;
        }
        .btn-success {
            color: #fff;
            background-color: #5cb85c;
            border-color: #4cae4c;
        }
        .btn-success:hover {
            background-color: #449d44;
            border-color: #398439;
        }
        .btn-danger {
            color: #fff;
            background-color: #d9534f;
            border-color: #d43f3a;
        }
        .btn-danger:hover {
            background-color: #c9302c;
            border-color: #ac2925;
        }
        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
            line-height: 1.5;
            border-radius: 3px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 5px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover {
            color: black;
        }
        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container">

      <a href="../index.php" class="btn btn-success">
            <i class="fas fa-home"></i> Home
        </a>
        
        <hr/>
        <div class="header-actions">
            <h1>User Management</h1>
            <button onclick="openAddUserModal()" class="btn btn-primary">Add New User</button>
        </div>
        
        <?php if ($message): ?>
            <div class="message success"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Full Name</th>
                    <th>Role</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td><?php echo $user['user_id']; ?></td>
                        <td><?php echo htmlspecialchars($user['username']); ?></td>
                        <td><?php echo htmlspecialchars($user['full_name']); ?></td>
                        <td><?php echo ucfirst($user['role']); ?></td>
                        <td class="actions">
                            <button onclick="openEditUserModal(
                                <?php echo $user['user_id']; ?>,
                                '<?php echo htmlspecialchars($user['username'], ENT_QUOTES); ?>',
                                '<?php echo htmlspecialchars($user['full_name'], ENT_QUOTES); ?>',
                                '<?php echo $user['role']; ?>'
                            )" class="btn btn-primary btn-sm">Edit</button>
                            
                            <a href="user_management.php?delete=<?php echo $user['user_id']; ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Are you sure you want to delete this user?');">
                                Delete
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- Add User Modal -->
    <div id="addUserModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeAddUserModal()">&times;</span>
            <h2>Add New User</h2>
            <form method="post">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="password">Password:</label>
                    <input type="password" id="password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="full_name">Full Name:</label>
                    <input type="text" id="full_name" name="full_name" required>
                </div>
                <div class="form-group">
                    <label for="role">Role:</label>
                    <select id="role" name="role" required>
                        <option value="admin">Admin</option>
                        <option value="technician">Technician</option>
                        <option value="doctor">Doctor</option>
                    </select>
                </div>
                <button type="submit" name="add_user" class="btn btn-success">Add User</button>
            </form>
        </div>
    </div>

    <!-- Edit User Modal -->
    <div id="editUserModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeEditUserModal()">&times;</span>
            <h2>Edit User</h2>
            <form method="post">
                <input type="hidden" id="edit_user_id" name="user_id">
                <div class="form-group">
                    <label for="edit_username">Username:</label>
                    <input type="text" id="edit_username" readonly>
                </div>
                <div class="form-group">
                    <label for="edit_password">New Password (leave blank to keep current):</label>
                    <input type="password" id="edit_password" name="password">
                </div>
                <div class="form-group">
                    <label for="edit_full_name">Full Name:</label>
                    <input type="text" id="edit_full_name" name="full_name" required>
                </div>
                <div class="form-group">
                    <label for="edit_role">Role:</label>
                    <select id="edit_role" name="role" required>
                        <option value="admin">Admin</option>
                        <option value="technician">Technician</option>
                        <option value="doctor">Doctor</option>
                    </select>
                </div>
                <button type="submit" name="update_user" class="btn btn-primary">Update User</button>
            </form>
        </div>
    </div>

    <script>
        // Add User Modal functions
        function openAddUserModal() {
            document.getElementById('addUserModal').style.display = 'block';
        }
        
        function closeAddUserModal() {
            document.getElementById('addUserModal').style.display = 'none';
        }
        
        // Edit User Modal functions
        function openEditUserModal(user_id, username, full_name, role) {
            document.getElementById('edit_user_id').value = user_id;
            document.getElementById('edit_username').value = username;
            document.getElementById('edit_full_name').value = full_name;
            document.getElementById('edit_role').value = role;
            document.getElementById('editUserModal').style.display = 'block';
        }
        
        function closeEditUserModal() {
            document.getElementById('editUserModal').style.display = 'none';
        }
        
        // Close modals when clicking outside
        window.onclick = function(event) {
            if (event.target.className === 'modal') {
                event.target.style.display = 'none';
            }
        }
    </script>
</body>
</html>