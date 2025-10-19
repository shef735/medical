<?php
include 'config.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_id = $_POST['patient_id'];
    $note_content = mysqli_real_escape_string($conn, $_POST['note_content']);
    $user_id = $_SESSION['patient_user_id']; // Assuming you have user authentication
    
    $sql = "INSERT INTO patient_notes (patient_id, user_id, note_content, created_by, created_date) 
            VALUES ('$patient_id','$user_id ', '$note_content', '".$_SESSION['user_name']."', NOW())";
    
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