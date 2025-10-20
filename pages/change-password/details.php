<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}

include ("../../../Connections/dbname.php"); 

// --- This part for fetching logo is fine ---
$logo_width=0;
$my_nc = ltrim($main_table_use).'_resources.company';
$cdquery_main = "SELECT code, logo_width FROM " . $my_nc ." LIMIT 1";
$sql = mysqli_query($conn, $cdquery_main);

if (mysqli_num_rows($sql) > 0) {
     $row_series = mysqli_fetch_assoc($sql);        
    $company_code=$row_series['code'];
     $logo_width=$row_series['logo_width'];
}
if((float)$logo_width==0) { $logo_width=160; }

$error = '';
$success = '';

// Check if form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    
    // Validate inputs
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $error = 'Please fill in all fields';
    } elseif ($new_password !== $confirm_password) {
        $error = 'New passwords do not match';
    } else {
        // Check if user is logged in
        if (isset($_SESSION['main_user_name'])) {
            $username = $_SESSION['main_user_name'];
            
            // First verify current password using a prepared statement
            $stmt = $conn->prepare("SELECT password FROM user_data WHERE username = ?");
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows === 1) {
                $user = $result->fetch_assoc();
                
                // 1. Securely verify the current password against the stored hash
                if (!password_verify($current_password, $user['password'])) {
                    $error = 'Current password is incorrect';
                } else {
                    // Current password is correct, proceed with update
                    
                    // 2. Securely hash the new password before saving
                    $hashed_password = password_hash($new_password, PASSWORD_BCRYPT); 
                    
                    $update_stmt = $conn->prepare("UPDATE user_data SET password = ? WHERE username = ?");
                    $update_stmt->bind_param("ss", $hashed_password, $username);
                    
                    if ($update_stmt->execute()) {
                        $success = 'Password changed successfully!';
                    } else {
                        $error = 'Error updating password: ' . $conn->error;
                    }
                    
                    $update_stmt->close();
                }
            } else {
                $error = 'User not found';
            }
            
            $stmt->close();
        } else {
            $error = 'User not identified. Please login again.';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--favicon-->
     <!-- loader-->
    <link href="../assets/css/pace.min.css" rel="stylesheet" />
    <script src="../assets/js/pace.min.js"></script>
    <!-- Bootstrap CSS -->
    <link href="../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
    <link href="../assets/css/app.css" rel="stylesheet">
    <link href="../assets/css/icons.css" rel="stylesheet">
    <title>Change Password</title>
</head>

<body>
    <!-- wrapper -->
    <div class="wrapper">
        <div  class="authentication-reset-password d-flex align-items-center justify-content-center">
         <div class="container">
            <div class="row row-cols-1 row-cols-lg-2 row-cols-xl-3">
                <div class="col mx-auto">
                    <div class="card">
                        <div class="card-body">
                            <div class="p-4">
                                <div class="mb-4 text-center">
                                   <img src="../../../uploads/logo/logo_<?php echo  $company_code ?>.png" style="width:<?php echo $logo_width ?>px" alt="" />

                                </div>
                                <div class="text-start mb-4">
                                    <h5 class="">Change Password</h5>
                                    <p class="mb-0">Please enter your current password and set a new password.</p>
                                </div>
                                
                                <?php if ($error): ?>
                                    <div class="alert alert-danger"><?php echo $error; ?></div>
                                <?php endif; ?>
                                
                                <?php if ($success): ?>
                                    <div class="alert alert-success"><?php echo $success; ?></div>
                                <?php endif; ?>
                                
                                <form method="POST" action="">
                                    <div class="mb-3">
                                        <label class="form-label">Current Password</label>
                                        <input type="password" class="form-control" name="current_password" placeholder="Enter current password" required />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">New Password</label>
                                        <input type="password" class="form-control" name="new_password" placeholder="Enter new password" required />
                                    </div>
                                    <div class="mb-4">
                                        <label class="form-label">Confirm New Password</label>
                                        <input type="password" class="form-control" name="confirm_password" placeholder="Confirm new password" required />
                                    </div>
                                    <div class="d-grid gap-2">
                                        <button type="submit" class="btn btn-primary">Change Password</button> 
                                        <a href="../index.php" class="btn btn-success"><i class='bx bx-home mr-1'></i>Home</a>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>
    <!-- end wrapper -->
    
    <!-- Bootstrap JS -->
    <script src="../assets/js/bootstrap.bundle.min.js"></script>
</body>
</html>