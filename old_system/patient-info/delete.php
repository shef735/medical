<?php
include 'config.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];

// Check if patient exists
$check_sql = "SELECT * FROM patient_info WHERE id = $id";
$check_result = mysqli_query($conn, $check_sql);

if (mysqli_num_rows($check_result) == 0) {
    header("Location: index.php");
    exit;
}

// Delete patient
$delete_sql = "DELETE FROM patient_info WHERE id = $id";
if (mysqli_query($conn, $delete_sql)) {
    header("Location: index.php?message=Patient deleted successfully");
} else {
    echo "Error deleting record: " . mysqli_error($conn);
}

mysqli_close($conn);
?>