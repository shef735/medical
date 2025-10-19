<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>


<?php

$_SESSION['patient_id']=$_GET['id'];
//echo $_SESSION['patient_id'];
echo "<script>window.location = 'patient-dashboard.php'</script>";


?>
