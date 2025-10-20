<?php
session_start();


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Add logic here to ensure only admins can access this page
require_once 'config.php';

// Fetch all users
$users = mysqli_query($conn, "SELECT id, username, firstname, lastname FROM ".$my_tables."_resources.user_data ORDER BY lastname");

// Fetch all menus
$menus = mysqli_query($conn, "SELECT id, name FROM ".$my_tables."_resources.menus ORDER BY name");

$selected_user_id = isset($_GET['user_id']) ? (int)$_GET['user_id'] : 0;
$user_permissions = [];

if ($selected_user_id > 0) {
    $sql = "SELECT menu_id FROM ".$my_tables."_resources.user_menu_access WHERE user_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $selected_user_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    while($row = mysqli_fetch_assoc($result)) {
        $user_permissions[] = $row['menu_id'];
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Manage User Access</title>
    <style>
/* Modern CSS Reset and Base Styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    background: linear-gradient(135deg, #667eea 0%, #e9e9e9ff 100%);
    min-height: 100vh;
    padding: 20px;
    line-height: 1.6;
}

.container {
    max-width: 800px;
    margin: 0 auto;
}

/* Card Styles */
.card {
    background: white;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    padding: 30px;
    margin-bottom: 25px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.card:hover {
    transform: translateY(-2px);
    box-shadow: 0 15px 40px rgba(0, 0, 0, 0.15);
}

/* Header Styles */
h2 {
    color: #2c3e50;
    margin-bottom: 20px;
    font-size: 1.8rem;
    font-weight: 600;
    border-bottom: 2px solid #3498db;
    padding-bottom: 10px;
}

h3 {
    color: #2c3e50;
    margin-bottom: 20px;
    font-size: 1.4rem;
    font-weight: 500;
}

/* Form Elements */
.form-group {
    margin-bottom: 20px;
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: 500;
    color: #34495e;
}

select {
    width: 100%;
    padding: 12px 15px;
    border: 2px solid #e1e8ed;
    border-radius: 8px;
    font-size: 16px;
    background: white;
    transition: all 0.3s ease;
    cursor: pointer;
}

select:focus {
    outline: none;
    border-color: #3498db;
    box-shadow: 0 0 0 3px rgba(52, 152, 219, 0.1);
}

/* Checkbox Group */
.checkbox-group {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 15px;
    margin: 20px 0;
}

.checkbox-group label {
    display: flex;
    align-items: center;
    padding: 12px 15px;
    background: #f8f9fa;
    border: 2px solid #e9ecef;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
    margin-bottom: 0;
}

.checkbox-group label:hover {
    background: #e3f2fd;
    border-color: #3498db;
    transform: translateY(-1px);
}

.checkbox-group input[type="checkbox"] {
    margin-right: 12px;
    transform: scale(1.2);
    accent-color: #3498db;
}

/* Button Styles */
.btn {
    display: inline-block;
    padding: 12px 30px;
    background: linear-gradient(135deg, #3498db, #2980b9);
    color: white;
    text-decoration: none;
    border: none;
    border-radius: 8px;
    font-size: 16px;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
}

.btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(52, 152, 219, 0.4);
    background: linear-gradient(135deg, #2980b9, #3498db);
}

.btn:active {
    transform: translateY(0);
}

/* User Selection Form */
.user-selection-form {
    text-align: center;
}

/* Permissions Section */
.permissions-section {
    animation: fadeIn 0.5s ease-in;
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Selected User Info */
.selected-user-info {
    background: linear-gradient(135deg, #74b9ff, #0984e3);
    color: white;
    padding: 15px;
    border-radius: 8px;
    margin-bottom: 20px;
    text-align: center;
}

/* Responsive Design */
@media (max-width: 768px) {
    .container {
        max-width: 95%;
    }
    
    .card {
        padding: 20px;
    }
    
    .checkbox-group {
        grid-template-columns: 1fr;
    }
    
    h2 {
        font-size: 1.5rem;
    }
    
    h3 {
        font-size: 1.2rem;
    }
}

/* Loading State */
.loading {
    opacity: 0.7;
    pointer-events: none;
}

/* Success Message */
.success-message {
    background: #d4edda;
    color: #155724;
    padding: 15px;
    border-radius: 8px;
    border: 1px solid #c3e6cb;
    margin-bottom: 20px;
    text-align: center;
}
</style>
</head>
<body>
    <div class="container">
     
        <div class="card user-selection-form">

          <a href="index.php" style="margin-bottom: 30px;" class="btn btn-sucess">Back to Home</a>
          <br>
            <form method="GET" action="">
                <h3>Select User to Manage</h3>
                <div class="form-group">
                    <label for="user_id">Choose User:</label>
                    <select name="user_id" id="user_id" onchange="this.form.submit()">
                        <option value="">-- Select a User --</option>
                        <?php while ($user = mysqli_fetch_assoc($users)) : ?>
                            <option value="<?php echo $user['id']; ?>" <?php if ($selected_user_id == $user['id']) echo 'selected'; ?>>
                                <?php echo htmlspecialchars($user['lastname'] . ', ' . $user['firstname'] . ' (' . $user['username'] . ')'); ?>
                            </option>
                        <?php endwhile; ?>
                    </select>
                </div>
            </form>
        </div>

        <?php if ($selected_user_id > 0) : ?>
            <div class="card permissions-section">
                <form method="POST" action="save_access.php">
                    <h3>Menu Access Permissions</h3>
                    <input type="hidden" name="user_id" value="<?php echo $selected_user_id; ?>">
                    
                    <div class="checkbox-group">
                        <?php mysqli_data_seek($menus, 0); // Reset pointer ?>
                        <?php while ($menu = mysqli_fetch_assoc($menus)) : ?>
                            <label>
                                <input type="checkbox" name="menus[]" value="<?php echo $menu['id']; ?>" 
                                    <?php if (in_array($menu['id'], $user_permissions)) echo 'checked'; ?>>
                                <?php echo htmlspecialchars($menu['name']); ?>
                            </label>
                        <?php endwhile; ?>
                    </div>
                    
                    <div style="text-align: center; margin-top: 25px;">
                        <button type="submit" class="btn">Save Permissions</button>
                    </div>
                </form>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>