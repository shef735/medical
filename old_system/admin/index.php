<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>



<?php

$presentdate=date('Y-m-d');
if(!isset($_SESSION['user_name'])) {

    echo "<script>window.location = 'source/login.php'</script>";


}
else
{

  echo "<script>window.location = 'source/'</script>";
}

?>
