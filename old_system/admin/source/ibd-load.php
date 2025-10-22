<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

<?php

$_SESSION['ibd']=$_GET['ibd'];

echo "<script>window.location = 'ibd-list.php'</script>";


?>
