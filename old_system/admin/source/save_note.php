<?php
session_start();
include "../../../Connections/dbname.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_id = $_POST['patient_id'];
    $note_content = $_POST['note_content'];
    $created_by = $_SESSION['user_name']; // Assuming you have user session
    $created_date = date('Y-m-d H:i:s');

    $presentdate=date('Y-m-d');

    $user_id='';

    $queryss = "SELECT user_id FROM ".$my_tables_use_check."_resources.patient_info WHERE id='".$patient_id."'";  
    $sql = mysqli_query($conn, $queryss);
    if (mysqli_num_rows($sql) > 0) {
		$row_series = mysqli_fetch_assoc($sql);		

        $user_id=$row_series['user_id'];


    }
 
    
    // Insert into notes table (you'll need to create this table)
    $query = "INSERT INTO ".$my_tables_use_check."_resources.patient_notes 
              (date, user_id, patient_id, note_content, created_by, created_date) 
              VALUES ('".$presentdate."', '".$user_id."', ?, ?, ?, ?)";
              
    $stmt = mysqli_prepare($db_connection, $query);
    mysqli_stmt_bind_param($stmt, 'isss', $patient_id,  $note_content, $created_by, $created_date);
    
    if (mysqli_stmt_execute($stmt)) {
        echo "Note saved successfully ".$patient_id;
    } else {
        echo "Error: " . mysqli_error($db_connection);
    }
    
    mysqli_stmt_close($stmt);
    mysqli_close($db_connection);
}
?>
