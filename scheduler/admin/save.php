<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

<?php



ini_set('display_errors', 1);
error_reporting(E_ALL);

function clean($string) {
    // Replace all spaces with double spaces first
    $string = str_replace(' ', '  ', $string);

    // Replace single quotes with backticks and double quotes with double backticks
    $string = str_replace('\'', '`', $string); // Replace ' with `
    $string = str_replace('"', '``', $string); // Replace " with ``

    // Modify the regex to include the tilde in the allowed characters
    $string = preg_replace('/[^A-Za-z0-9\-\~`]/', ' ', $string); // Keeps ~ and ` (backtick) and removes other special chars

    // Replace multiple hyphens with a single space
    return preg_replace('/-+/', ' ', $string); // Replaces multiple hyphens with a space
} 

include "../../../Connections/dbname.php";

if (isset($_POST['date']) && isset($_POST['time']) && isset($_POST['patient_id'])) {
        $date = $_POST['date'];
        $time = $_POST['time'];
        $patient_id = $_POST['patient_id'];
        $remarks= clean($_POST['remarks']);
        $user_id= strtok($_POST['patient_id']," ");

        // Combine date and time into one datetime string
        $date_time = $date . ' ' . $time;

        $phone='';
        $email='';

        $result_trans90_check= mysqli_query($conn, "SELECT * 
				 FROM ".$my_tables_use_check."_resources.patient_info WHERE user_id='$patient_id'  LIMIT 1");
			
				 		$row_series = mysqli_fetch_assoc($result_trans90_check);			
				$my_total_records_check=mysqli_num_rows($result_trans90_check);
				
				  if ($my_total_records_check>0) {
                        $phone=$row_series['phone'];
                        $email=$row_series['email'];


                  }

        // Prepare the SQL statement to prevent SQL injection
        $status=1;
       
       $query_price = "INSERT INTO ".$my_tables_use_check."_schedule.appointments  SET ";
    if(isset($_POST['date'])) { $query_price .= "date_only = '" .$_POST['date']. "', "; }
    if(isset($_POST['time'])) { $query_price .= "time_only= '" .$_POST['time']. "', "; }
    if(isset($date_time)) { $query_price .= "date_sched = '" .$date_time. "', "; }
if(isset($user_id)) { $query_price .= "user_id = '" .$user_id. "', "; }

if(isset($phone)) { $query_price .= "phone = '" .$phone. "', "; }
if(isset($email)) { $query_price .= "email = '" .$email. "', "; }

    
      if(isset($_POST['doctor_id'])) { $query_price .= "doctor= '" .$_POST['doctor_id']. "', "; }
 if(isset($_POST['patient_id'])) { $query_price .= "fullname= '" .$_POST['patient_id']. "', "; }
  if(isset($remarks)) { $query_price .= "remarks= '" .$remarks. "', "; }
     if(isset($status)) { $query_price .= "status= '" .$status. "' "; }
    
    
$query_price = mysqli_query($db_connection, $query_price);	

 echo "<script>window.location = 'index.php'</script>";
        // Execute the statement
       
}

?>