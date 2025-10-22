<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

<?php
$_SESSION['add_click']='Y';

  echo "<script>window.location = 'patient-dashboard.php'</script>";           


?>