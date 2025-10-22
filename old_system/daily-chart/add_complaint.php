<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>


<?php
include 'config.php';


if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_id = $_POST['patient_id'];
    $note_content = mysqli_real_escape_string($conn, $_POST['complaint_details']);
    $user_id = $_SESSION['patient_user_id']; // Assuming you have user authentication
    
    $sql = "INSERT INTO record_chief_complaint (user_id, othersymptoms1, date) 
            VALUES ('$user_id ', '$note_content', NOW())";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: view_patient.php?id=$patient_id&success=note_added");
    } else {
        header("Location: view_patient.php?id=$patient_id&error=note_failed");
    }
} else {
    header("Location: index.php");
}
exit;
?>