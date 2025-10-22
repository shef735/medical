<?php
include ("../../Connections/dbname.php");

$data = json_decode(file_get_contents('php://input'), true);
$recordId = $data['id'];
$filetoresult=ltrim($main_table_use).'_resources.patient_record';
// Prepare and execute the delete query
$sql = "DELETE FROM ".$filetoresult." WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $recordId);

if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>