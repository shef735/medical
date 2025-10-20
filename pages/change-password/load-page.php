<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>


<?php 
if(isset($_GET['id'])) {
	$_SESSION['menu_id']=$_GET['id'];
}

 include '../../Connections/dbname.php';
	include "../includes/load-sessions.php"; 
    include "../includes/load-transaction-values.php"; 
	 
 echo "<script>window.location = 'index.php'</script>";
?>
