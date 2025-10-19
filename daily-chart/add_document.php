<?php
if (!isset($_SESSION)) {
    session_start();
    ob_start();
}
?>

<?php
include 'config.php';

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header("Location: view_patient.php?id=" . $_POST['patient_id'] . "&error=invalid_request");
    exit;
}

// Validate required fields
// We check if the 'name' array inside document_file is not empty
if (empty($_POST['patient_id']) || empty($_POST['document_date']) || empty($_POST['document_type']) || empty($_FILES['document_file']['name'][0])) {
    header("Location: view_patient.php?id=" . $_POST['patient_id'] . "&error=missing_fields");
    exit;
}

$patient_id = mysqli_real_escape_string($conn, $_POST['patient_id']);
$test_date = mysqli_real_escape_string($conn, $_POST['document_date']); // Note: This date applies to all uploaded docs in this batch
$test_type = mysqli_real_escape_string($conn, $_POST['document_type']);
$notes = isset($_POST['notes']) ? mysqli_real_escape_string($conn, $_POST['notes']) : '';
$document_name = $_POST['document_name']; // Note: This name applies to all uploaded docs in this batch
$puser = $_SESSION['patient_user_id'];

$uploadDir = '../../uploads/documents/';
$allowedTypes = array('pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx');
$upload_success = false;

// Loop through each file that was uploaded
foreach ($_FILES['document_file']['name'] as $key => $name) {
    // Skip empty file inputs
    if ($_FILES['document_file']['error'][$key] !== UPLOAD_ERR_OK) {
        continue;
    }
    
    $tmpFilePath = $_FILES['document_file']['tmp_name'][$key];

    // Generate a unique file name to prevent overwriting
    $fileName = uniqid() . '_' . basename($name);
    $targetFilePath = $uploadDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Check if file type is allowed
    if (!in_array(strtolower($fileType), $allowedTypes)) {
        // You could log this error or skip the file
        error_log("Skipped file '$name' due to invalid file type.");
        continue; // Skip to the next file
    }

    // Upload file to server
    if (move_uploaded_file($tmpFilePath, $targetFilePath)) {
        // Insert file information into the database
        $sql = "INSERT INTO documents_forms (
            user_id, 
            document_type, 
            document_name, 
            file_path, 
            notes, 
            created_at
        ) VALUES (
            '$puser', 
            '$test_type', 
            '$document_name', 
            '$targetFilePath', 
            '$notes', 
            NOW()
        )";

        if (mysqli_query($conn, $sql)) {
            $upload_success = true;
        } else {
            // Database insert failed, so delete the file that was just uploaded
            unlink($targetFilePath);
            error_log("Database insert failed for file '$name': " . mysqli_error($conn));
        }
    } else {
        error_log("File upload failed for '$name'.");
    }
}

// Redirect after the loop has finished
if ($upload_success) {
    header("Location: view_patient.php?id=" . $patient_id . "&success=lab_result_added");
} else {
    header("Location: view_patient.php?id=" . $patient_id . "&error=upload_failed");
}

exit;
?>