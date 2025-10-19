<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>


<?php

$look_id=$_GET['id'];
//echo $_SESSION['patient_id'];

include ("../../Connections/dbname.php");
$filetoresult=ltrim($main_table_use).'_resources.patient_info';

 $user_id='';

$result_trans90_check= mysqli_query($conn,"SELECT id , user_id 
		FROM  ".$filetoresult." 
		WHERE id='".$look_id."' LIMIT 1");
	 
$row_series = mysqli_fetch_assoc($result_trans90_check);			
$my_total_records_check=mysqli_num_rows($result_trans90_check);
				
if ($my_total_records_check>0) {
	 $user_id=$row_series['id'];
					
}
				  

echo "<script>window.location = '../daily-chart/view_patient.php?id=".$user_id."'</script>";

 

?>