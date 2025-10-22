<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>


<?php

include "Connections/dbname.php";

$presentdate=date('Y-m-d');
 
   $total_update_sql= "UPDATE  ".$my_tables_use_check."_resources.patient_info  
      SET  patient_id=id,
          patient_code=user_id,
          gender=sex,
          date_of_birth=birthday";
	$total_query = mysqli_query($db_connection,  $total_update_sql);

  echo "<script>window.location = 'pages/index.php'</script>";
 

?>
