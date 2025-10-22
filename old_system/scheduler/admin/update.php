<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

<?php

 
include "../../../Connections/dbname.php";
 
$id=$_SESSION['edit_id'];
 
    $sql = "UPDATE ".$my_tables_use."_schedule.appointments 
            SET status = '".$_POST['status']."'   
            WHERE id = '$id'";
   $result = mysqli_query($conn, $sql);

   echo "<script>window.location = 'index.php'</script>";



?>