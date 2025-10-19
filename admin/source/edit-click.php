<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>


<?php
unset($_SESSION['add_click']);
$_SESSION['edit_click']='Y';

echo "<script>window.location = 'patient-dashboard.php'</script>";
?>