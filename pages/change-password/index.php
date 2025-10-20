<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

<!doctype html>
<html lang="en">

<head>
	<!-- Required meta tags -->
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!--favicon-->
	<link rel="icon" href="assets/images/favicon-32x32.png" type="image/png" />
	<!--plugins-->
	<link href="../../assets/plugins/vectormap/jquery-jvectormap-2.0.2.css" rel="stylesheet"/>
	<link href="../../assets/plugins/simplebar/css/simplebar.css" rel="stylesheet" />
	<link href="../../assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet"/>
	<!-- loader-->
	<link href="../../assets/css/pace.min.css" rel="stylesheet" />
 	<!-- Bootstrap CSS -->
	<link href="../../assets/css/bootstrap.min.css" rel="stylesheet">
	<link href="../../assets/css/bootstrap-extended.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<link href="../../assets/css/app.css" rel="stylesheet">
	<link href="../../assets/css/icons.css" rel="stylesheet">
	<!-- Theme Style CSS -->
	<link rel="stylesheet" href="../../assets/css/dark-theme.css" />
	<link rel="stylesheet" href="../../assets/css/semi-dark.css" />
	<link rel="stylesheet" href="../../assets/css/header-colors.css" />
	<title><?php echo $_SESSION['company_name'] ?></title>
</head>

<?php 
 

ini_set('display_errors', 1);
error_reporting(E_ALL);

 	include 'config.php';
	
?>

<body>
	<!--wrapper-->
	<div class="wrapper">
	 <!--start header wrapper-->	
	  <div class="header-wrapper">
		<!--start header -->
		<?php // include "../includes/header-menu.php" ?>
		<!--end header -->
		<!--navigation-->
		  <?php // include "../includes/menu.php" ?>
		<!--end navigation-->
	   </div>
	   <!--end header wrapper-->
	
<!--start page wrapper -->
		<div class="page-wrapper">
			<div class="page-content" style="margin-top: -200px;">
				<?php include "details.php" ?>
            </div>
        </div>

  		 

	</div>
	<!--end wrapper-->

	 

  	<!-- Bootstrap JS -->
 	<!--plugins-->
	 
	<script src="../../assets/plugins/simplebar/js/simplebar.min.js"></script>
	<script src="../../assets/plugins/perfect-scrollbar/js/perfect-scrollbar.js"></script>
	<script src="../../assets/plugins/vectormap/jquery-jvectormap-2.0.2.min.js"></script>
    <script src="../../assets/plugins/vectormap/jquery-jvectormap-world-mill-en.js"></script>
	<script src="../../assets/plugins/chartjs/js/chart.js"></script>
	<script src="../../assets/js/index.js"></script>
	<!--app JS-->
	<script src="../../assets/js/app.js"></script>

	 
</body>

</html>