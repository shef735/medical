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
     $user_id = $_SESSION['patient_user_id']; // Assuming you have user authentication

    $medication_name=$_POST['medication_name'];
    $dosage= $_POST['dosage'];
    $frequency= $_POST['frequency'];
    $instructions=$_POST['instructions'];

    $sql = "INSERT INTO medications (user_id, medication_name, dosage, frequency, instructions, created_at) 
            VALUES ('$user_id ', '$medication_name','$dosage','$frequency','$instructions', NOW())";
    
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