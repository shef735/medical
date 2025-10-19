<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

<?php

 
include "../../../Connections/dbname.php";
 
$id=$_SESSION['selected_id'];
 
   $query = "UPDATE ".$my_tables_use."_schedule.appointments SET ";       
					if(isset($_POST['status'])) { $query .= "status = '" .$_POST['status']. "', "; }	
               	if(isset($_POST['bp'])) { $query .= "bp = '" .$_POST['bp']. "', "; }	
                  if(isset($_POST['weight_kg'])) { $query .= "weight_kg = '" .$_POST['weight_kg']. "', "; }						
					if(isset($_POST['doctor_id'])) { $query .= "doctor  = '" .$_POST['doctor_id']. "', "; }					
                    if(isset($_POST['findings'])) { $query .= " findings = '" .$_POST['findings']. "' "; }
			 
        $query.=" WHERE id = '$id'";
   $result = mysqli_query($conn, $query);


     $query_price = "INSERT INTO ".$my_tables_use."_resources.record_weight  SET ";
    if(isset($_POST['weight_kg'])) { $query_price .= "weight_kg = '" .$_POST['weight_kg']. "', "; }
    if(isset($_POST['app_date'])) { $query_price .= "date= '" .$_POST['app_date']. "', "; }
if(isset( $_SESSION['load_username'])) { $query_price .= "user_id = '" . $_SESSION['load_username']. "' "; }
       $result = mysqli_query($conn, $query_price );


         $query_price = "INSERT INTO ".$my_tables_use."_resources.record_bp  SET ";
    if(isset($_POST['bp'])) { $query_price .= "bp = '" .$_POST['bp']. "', "; }
    if(isset($_POST['app_date'])) { $query_price .= "date= '" .$_POST['app_date']. "', "; }
        if(isset($_POST['app_time'])) { $query_price .= "bp_time= '" .$_POST['app_time']. "', "; }
if(isset( $_SESSION['load_username'])) { $query_price .= "user_id = '" . $_SESSION['load_username']. "' "; }
       $result = mysqli_query($conn, $query_price );

   echo "<script>window.location = 'index.php'</script>";



?>