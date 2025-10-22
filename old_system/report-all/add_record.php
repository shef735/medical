<?php
include ("../../Connections/dbname.php");

$data = json_decode(file_get_contents('php://input'), true);

$fullname = $data['fullname'];
$age = $data['age'];
$sex = $data['sex'];
$contactnumber = $data['contactnumber'];
// Add more fields as needed
$filetoresult=ltrim($main_table_use).'_resources.patient_record';

$sql = "INSERT INTO ".$filetoresult." (fullname, age, sex, contactnumber) VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("siss", $fullname, $age, $sex, $contactnumber);

if ($stmt->execute()) {
    $newRecordId = $stmt->insert_id; // Get the ID of the newly inserted record
    echo json_encode(['success' => true, 'newRecordId' => $newRecordId]);
} else {
    echo json_encode(['success' => false, 'message' => $stmt->error]);
}

$stmt->close();
$conn->close();
?>

