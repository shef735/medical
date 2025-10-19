<?php
if(!isset($_SESSION)){
    session_start();
    // ob_start(); 
}

include 'config.php'; // Database connection

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    $redirect_url = "index.php?error=invalid_request"; 
    if (isset($_POST['patient_id'])) { 
        $redirect_url = "view_patient.php?id=" . urlencode($_POST['patient_id']) . "&error=invalid_request";
    } elseif (isset($_GET['patient_id'])) { 
         $redirect_url = "view_patient.php?id=" . urlencode($_GET['patient_id']) . "&error=invalid_request";
    }
    header("Location: " . $redirect_url);
    exit;
}

// Validate required POST fields
if (empty($_POST['patient_id']) || empty($_POST['user_id']) || empty($_POST['test_date']) || !isset($_POST['test_type'])) {
    $patient_id_for_redirect = isset($_POST['patient_id']) ? urlencode($_POST['patient_id']) : '';
    $_SESSION['upload_errors'] = ["Critical information missing from the form."];
    header("Location: view_patient.php?id=" . $patient_id_for_redirect . "&error=missing_fields");
    exit;
}

// Sanitize and assign POST variables
$patient_id_form = mysqli_real_escape_string($conn, $_POST['patient_id']); 
$user_id_patient = mysqli_real_escape_string($conn, $_POST['user_id']);   
$test_date = mysqli_real_escape_string($conn, $_POST['test_date']);
$notes = isset($_POST['notes_lab']) ? mysqli_real_escape_string($conn, $_POST['notes_lab']) : '';
$submitted_test_type_value = $_POST['test_type']; 

// Handle test type (New or Existing)
$final_test_type_name = '';
if ($submitted_test_type_value === 'other') {
    if (isset($_POST['new_test_type']) && !empty(trim($_POST['new_test_type']))) {
        $final_test_type_name = trim(mysqli_real_escape_string($conn, $_POST['new_test_type']));
        
        $check_sql = "SELECT details FROM ".$_SESSION['my_tables']."_laboratory.test_type WHERE UPPER(details) = UPPER(?)";
        $stmt_check = mysqli_prepare($conn, $check_sql);
        if ($stmt_check) {
            mysqli_stmt_bind_param($stmt_check, "s", $final_test_type_name);
            mysqli_stmt_execute($stmt_check);
            mysqli_stmt_store_result($stmt_check);
            if (mysqli_stmt_num_rows($stmt_check) == 0) {
                $insert_type_sql = "INSERT INTO ".$_SESSION['my_tables']."_laboratory.test_type (details) VALUES (?)";
                $stmt_insert_type = mysqli_prepare($conn, $insert_type_sql);
                if ($stmt_insert_type) {
                    mysqli_stmt_bind_param($stmt_insert_type, "s", $final_test_type_name);
                    mysqli_stmt_execute($stmt_insert_type);
                    mysqli_stmt_close($stmt_insert_type);
                } else {
                    error_log("MySQLi prepare error (insert_type_sql): " . mysqli_error($conn));
                }
            }
            mysqli_stmt_close($stmt_check);
        } else {
            error_log("MySQLi prepare error (check_sql): " . mysqli_error($conn));
        }
    } else {
        $_SESSION['upload_errors'] = ["'Other' test type selected, but no new type name was provided."];
        header("Location: view_patient.php?id=" . $patient_id_form . "&error=new_test_type_missing");
        exit;
    }
} else if (!empty($submitted_test_type_value)) {
    $final_test_type_name = mysqli_real_escape_string($conn, $submitted_test_type_value);
}

if (empty($final_test_type_name)) {
    $_SESSION['upload_errors'] = ["Test type is missing or could not be determined."];
    header("Location: view_patient.php?id=" . $patient_id_form . "&error=missing_test_type");
    exit;
}

// File upload settings
$uploadDir = '../../uploads/documents/'; 
if (!is_dir($uploadDir)) {
    if (!mkdir($uploadDir, 0755, true)) { 
        $_SESSION['upload_errors'] = ["Failed to create upload directory: " . $uploadDir . ". Please check server permissions."];
        header("Location: view_patient.php?id=" . $patient_id_form . "&error=upload_dir_error");
        exit;
    }
}
$allowedTypes = array('pdf', 'jpg', 'jpeg', 'png', 'doc', 'docx', 'txt', 'xls', 'xlsx', 'gif', 'bmp', 'tiff'); 
$error_messages_for_user = [];
$uploaded_file_details = []; // To store path and original name of successfully uploaded files
$at_least_one_file_selected_by_user = false; 

// Process uploaded files
if (isset($_FILES['lab_file']['name']) && is_array($_FILES['lab_file']['name'])) {
    $file_count = count($_FILES['lab_file']['name']);

    for ($i = 0; $i < $file_count; $i++) {
        if ($_FILES['lab_file']['error'][$i] === UPLOAD_ERR_NO_FILE) {
            continue; 
        }
        $at_least_one_file_selected_by_user = true; 

        if ($_FILES['lab_file']['error'][$i] !== UPLOAD_ERR_OK) {
            $error_messages_for_user[] = "Error with file '" . htmlspecialchars($_FILES['lab_file']['name'][$i]) . "': Upload error code " . $_FILES['lab_file']['error'][$i] . ".";
            continue; 
        }

        $original_fileName = basename($_FILES['lab_file']['name'][$i]);
        $tmp_filePath = $_FILES['lab_file']['tmp_name'][$i];
        
        $sanitized_original_fileName = preg_replace("/[^a-zA-Z0-9\._\s-]/", "_", $original_fileName); 
        $fileName_unique = uniqid() . '_' . $sanitized_original_fileName;
        $targetFilePath = $uploadDir . $fileName_unique;
        $fileType = strtolower(pathinfo($original_fileName, PATHINFO_EXTENSION)); 

        if (!in_array($fileType, $allowedTypes)) {
            $error_messages_for_user[] = "Invalid file type for '" . htmlspecialchars($original_fileName) . "'. Allowed types: " . implode(', ', $allowedTypes) . ".";
            continue; 
        }

        if (move_uploaded_file($tmp_filePath, $targetFilePath)) {
            $uploaded_file_details[] = [
                'path' => $targetFilePath,
                'originalName' => $original_fileName 
            ];
        } else {
            $error_messages_for_user[] = "Failed to move uploaded file '" . htmlspecialchars($original_fileName) . "'. Please check server permissions for directory: " . $uploadDir;
        }
    }
}

// Database insertion logic (single record)
$db_insert_successful = false;
$file_path_for_db = NULL; // Default to NULL if no files or all uploads failed

if (!empty($uploaded_file_details)) {
    // Files were successfully uploaded and moved
    $file_path_for_db = json_encode($uploaded_file_details);
    $document_name_for_db = "Lab Result - " . $final_test_type_name . " (" . date('M d, Y', strtotime($test_date)) . ") - Multiple Files";
    if (count($uploaded_file_details) === 1) { // If only one file, use its name
        $document_name_for_db = "Lab Result - " . $final_test_type_name . " (" . date('M d, Y', strtotime($test_date)) . ") - " . $uploaded_file_details[0]['originalName'];
    }
} elseif ($at_least_one_file_selected_by_user && empty($uploaded_file_details)) {
    // User selected files, but all of them failed to upload/move. Errors are in $error_messages_for_user.
    // No database record will be created in this case, as there are no files to associate.
    // The errors will be shown to the user.
} else {
    // No files were selected by the user, or an empty file input was submitted.
    // Create a record for the lab event itself, possibly with notes.
    $file_path_for_db = json_encode([]); // Store an empty JSON array for consistency
    $document_name_for_db = "Lab Result - " . $final_test_type_name . " (" . date('M d, Y', strtotime($test_date)) . ")";
}


// Proceed with DB insertion only if:
// 1. Files were successfully uploaded OR
// 2. No files were selected by the user (for a notes-only entry) AND no critical file processing errors occurred for selected files
$should_insert_db_record = !empty($uploaded_file_details) || !$at_least_one_file_selected_by_user;


if ($should_insert_db_record) {
    $sql_insert_doc = "INSERT INTO visit_documents (
        user_id, document_type, document_name, file_path, notes, created_at
    ) VALUES (?, ?, ?, ?, ?, NOW())";
    
    $stmt_insert = mysqli_prepare($conn, $sql_insert_doc);
    if ($stmt_insert) {
        mysqli_stmt_bind_param($stmt_insert, "sssss", $user_id_patient, $final_test_type_name, $document_name_for_db, $file_path_for_db, $notes);
        if (mysqli_stmt_execute($stmt_insert)) {
            $db_insert_successful = true;
        } else {
            $error_messages_for_user[] = "Database error saving lab record: " . mysqli_stmt_error($stmt_insert);
            // If DB insert fails, delete any files that were successfully moved for this attempt
            if (!empty($uploaded_file_details)) {
                foreach ($uploaded_file_details as $file_detail) {
                    if (file_exists($file_detail['path'])) {
                        unlink($file_detail['path']);
                    }
                }
            }
        }
        mysqli_stmt_close($stmt_insert);
    } else {
         $error_messages_for_user[] = "Database prepare error for lab record: " . mysqli_error($conn);
         // Also delete files if prepare fails
         if (!empty($uploaded_file_details)) {
            foreach ($uploaded_file_details as $file_detail) {
                 if (file_exists($file_detail['path'])) {
                    unlink($file_detail['path']);
                }
            }
        }
    }
}


// Final redirection logic
if (!empty($error_messages_for_user)) {
    $_SESSION['upload_errors'] = $error_messages_for_user;
    // If a DB record was made despite some file errors (e.g. notes-only entry succeeded but a previous file attempt had an error message)
    // it's a partial success. Otherwise, it's a failure.
    if ($db_insert_successful && $at_least_one_file_selected_by_user) { // Files were selected, some failed, but DB record for successful ones (or notes) was made
        header("Location: view_patient.php?id=" . $patient_id_form . "&warning=lab_results_partial_success");
    } else if ($db_insert_successful && !$at_least_one_file_selected_by_user) { // Notes-only entry succeeded, no file errors to report
         header("Location: view_patient.php?id=" . $patient_id_form . "&success=lab_record_notes_added_successfully");
    }
    else { // No DB record made, or DB record failed, and there are errors
        header("Location: view_patient.php?id=" . $patient_id_form . "&error=lab_results_processing_failed");
    }
} else {
    // No errors were added to $error_messages_for_user.
    if ($db_insert_successful) {
        $success_message = !empty($uploaded_file_details) ? "lab_results_added_successfully" : "lab_record_notes_added_successfully";
        header("Location: view_patient.php?id=" . $patient_id_form . "&success=" . $success_message);
    } else if ($at_least_one_file_selected_by_user && empty($uploaded_file_details) && empty($error_messages_for_user)) {
        // This case: user selected files, all failed to move (but not due to type/upload error that adds to $error_messages_for_user), 
        // so $uploaded_file_details is empty, and $db_insert_successful is false.
        // This implies a move_uploaded_file failure not caught by $error_messages_for_user, which is unlikely with current code.
        // However, to be safe:
        $_SESSION['upload_errors'] = ["Files were selected but could not be processed. No record saved."];
        header("Location: view_patient.php?id=" . $patient_id_form . "&error=lab_file_processing_issue");
    }
    else {
        // Fallback for unexpected scenarios where no specific error was set, but also no clear success.
        $_SESSION['upload_errors'] = ["An unexpected issue occurred. Please check if the lab result was saved."];
        header("Location: view_patient.php?id=" . $patient_id_form . "&error=lab_results_unknown_issue");
    }
}
exit;
?>
