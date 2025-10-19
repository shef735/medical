<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

<?php
include 'config.php';
 

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: view_patient.php?id=" . ($_POST['patient_id'] ?? '') . "&error=invalid_request");
    exit;
}

// Validate required fields
$required_fields = ['patient_id', 'diagnosis', 'diagnosisyear', 'doctor', 'hospital'];
foreach ($required_fields as $field) {
    if (empty($_POST[$field])) {
        header("Location: view_patient.php?id=" . $_POST['patient_id'] . "&error=missing_$field");
        exit;
    }
}

// Sanitize input data
$patient_id = mysqli_real_escape_string($conn, $_POST['patient_id']);
$diagnosis = mysqli_real_escape_string($conn, $_POST['diagnosis']);
$diagnosisyear = mysqli_real_escape_string($conn, $_POST['diagnosisyear']);
$doctor = mysqli_real_escape_string($conn, $_POST['doctor']);
$hospital = mysqli_real_escape_string($conn, $_POST['hospital']);
$notes = isset($_POST['notes']) ? mysqli_real_escape_string($conn, $_POST['notes']) : '';
$created_by = $_SESSION['user_name'] ?? 'System'; // Assuming you have user session

// Validate diagnosis year format (YYYY)
if (!preg_match('/^\d{4}$/', $diagnosisyear)) {
    header("Location: view_patient.php?id=" . $patient_id . "&error=invalid_year");
    exit;
}

 $user_id = $_SESSION['patient_user_id']; 

// Prepare the SQL query
$sql = "INSERT INTO record_diagnosis (
    user_id,
    diagnosis1,
    diagnosisyear,
    attending,
    hospital,
    note 
) VALUES (
    '$user_id ',
    '$diagnosis',
    '$diagnosisyear',
    '$doctor',
    '$hospital',
    '$notes' 
)";

// Execute the query
if (mysqli_query($conn, $sql)) {
   
    
    header("Location: view_patient.php?id=" . $patient_id . "&success=diagnosis_added");
} else {
    header("Location: view_patient.php?id=" . $patient_id . "&error=db_error&message=" . urlencode(mysqli_error($conn)));
}

exit;
?>