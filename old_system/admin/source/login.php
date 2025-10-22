<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>


<?php
unset($_SESSION['user_name']);
$_SESSION['system_name']='M-One Solutions';
$_SESSION['company']='Logic Plus Solutions Inc.';

  include ("../../../Connections/dbname.php"); 

$result_trans90_check= mysqli_query($conn,"SELECT * 
		FROM  ".$my_tables_use."_resources.company LIMIT 1");			 				
				$my_total_records_check=mysqli_num_rows($result_trans90_check);
				
				  if ($my_total_records_check>0) {
            $row_series = mysqli_fetch_assoc($result_trans90_check);	

           $_SESSION['company']=$row_series['company'];

          }



?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">
     <title><?php echo $_SESSION['system_name'] ?></title>
    <!-- shortcut icon-->
    <link rel="shortcut icon" href="../assets/images/logo/icon-logo.png" type="image/x-icon">
    <!-- Fonts css-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <!-- Font awesome -->
    <link href="../assets/css/vendor/font-awesome.css" rel="stylesheet">
    <link href="../assets/css/vendor/themify-icons.css" rel="stylesheet">
    <link href="../assets/css/vendor/icoicon.css" rel="stylesheet">
    <!-- Scrollbar-->
    <link href="../assets/css/vendor/simplebar.css" rel="stylesheet">
    <!-- Bootstrap css-->
    <link href="../assets/css/vendor/bootstrap.css" rel="stylesheet">
    <!-- Custom css-->
    <link href="../assets/css/style.css" rel="stylesheet">
  </head>
  <body>  
    <!-- Login Start-->
    <div class="auth-main">
      <div class="codex-authbox">
        <div class="auth-header">
          <div class="codex-brand"><a href="index.php">
          <img class="img-fluid light-logo" style="width: 40%;" src="../assets/images/logo/logo.png" alt=""></a></div>
          <h3><?php echo  $_SESSION['company'] ?></h3>
          <p>don't have an account? <a class="text-primary" href="register.php">create an account</a></p>
        </div> 


    <form class="main-form"  method="post" action="check-password.php" enctype="multipart/form-data">

          <div class="form-group">
            <label class="form-label">Email</label>
            <input class="form-control" name="username" id="username" type="text" required placeholder="Enter Your Email">
          </div>
          <div class="form-group">
            <label class="form-label">Password</label>
            <div class="input-group group-input">
              <input class="form-control showhide-password" name="password" id="password"  type="password" placeholder="Enter Your Password" required=""><span class="input-group-text toggle-show fa fa-eye"></span>
            </div>
          </div>
          <div class="form-group mb-0">
            <div class="auth-remember">                    
              <div class="form-check custom-chek">
               <!-- <input class="form-check-input" id="agree" type="checkbox" value="" required="">
                <label class="form-check-label" for="agree">Remember me</label> -->
              </div><a class="text-primary f-pwd" href="forgot-password.php">Forgot your password?</a>
            </div>
          </div>
          <div class="form-group">
            <button class="btn btn-primary" type="submit"><i class="fa fa-sign-in"></i> Login</button>
          </div>
        </form>
       <!-- <div class="auth-footer">
          <h5 class="auth-with">Or login in with     </h5>
          <ul class="login-list">
            <li><a class="bg-fb" href="javascript:void(0);"> <img class="img-fluid" src="../assets/images/auth/1.png" alt="facebook">facebook</a></li>
            <li><a class="bg-google" href="javascript:void(0);"> <img class="img-fluid" src="../assets/images/auth/2.png" alt="google">google</a></li>
          </ul>
        </div> -->
      </div>
    </div>
    <!-- Login End-->
      <!-- main jquery-->
      <script src="../assets/js/jquery-3.7.0.min.js"></script>
      <!-- Feather iocns js-->
      <script src="../assets/js/icons/feather-icon/feather.js"></script>
      <!-- Bootstrap js-->
      <script src="../assets/js/bootstrap.bundle.min.js"></script>
      <script src="../assets/js/vendors/notify/bootstrap-notify.js"></script>
      <script src="../assets/js/vendors/notify/bootstrap-customnotify.js"></script>
      <!-- customizer-->
      <script src="../assets/js/customizer.js"></script>
      <!-- Scrollbar-->
      <script src="../assets/js/vendors/simplebar.js"></script>
      <!-- Custom script-->
      <script src="../assets/js/custom-script.js"></script>
  </body>
</html>