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
	<!-- Bootstrap CSS -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">
	<!-- Font Awesome Icons -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
	<!-- Simplebar CSS -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/simplebar/6.0.0/simplebar.min.css" rel="stylesheet">
	<!-- Perfect Scrollbar CSS -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/perfect-scrollbar/1.5.0/perfect-scrollbar.min.css" rel="stylesheet">
	<!-- Pace CSS -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/pace/1.2.4/themes/blue/pace-theme-minimal.min.css" rel="stylesheet">
	<title><?php echo $_SESSION['company_name'] ?></title>
	
	<style>
		/* Basic styling to replace some of the custom CSS files */
		body {
			font-family: 'Roboto', sans-serif;
		}
		.wrapper {
			min-height: 100vh;
		}
		.header-wrapper {
			position: relative;
		}
		.page-wrapper {
			flex: 1;
		}
		.page-content {
			padding: 20px;
		}
	</style>
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
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
	<!-- Simplebar JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/simplebar/6.0.0/simplebar.min.js"></script>
	<!-- Perfect Scrollbar JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/perfect-scrollbar/1.5.0/perfect-scrollbar.min.js"></script>
	<!-- Chart.js -->
	<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
	<!-- Pace JS -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/pace/1.2.4/pace.min.js"></script>

	<script>
		// Initialize Pace page loader
		paceOptions = {
			ajax: false,
			document: false,
			eventLag: false
		};

		// Basic initialization for any custom functionality
		document.addEventListener('DOMContentLoaded', function() {
			// Add any initialization code that was in your index.js or app.js files here
			console.log('Page loaded successfully');
		});
	</script>
</body>

</html>