<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

<?php

$_SESSION['biological']=$_GET['biological'];

echo "<script>window.location = 'biological-list.php'</script>";


?>
