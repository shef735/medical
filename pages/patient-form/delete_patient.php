<?php
session_start();
ob_start();
include "db.php";

if(isset($_GET['id'])) {
    $patient_id = intval($_GET['id']);
    
    // Soft delete (you can change to hard delete if preferred)
    $query = "UPDATE patient_info SET deleted_at = NOW() WHERE id = ?";
    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "i", $patient_id);
    
    if(mysqli_stmt_execute($stmt)) {
        $_SESSION['delete_success'] = true;
    } else {
        $_SESSION['delete_error'] = "Error deleting patient: " . mysqli_error($conn);
    }
    
    header("Location: edit_patient.php");
    exit();
}
?>