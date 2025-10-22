<?php
// --- ROBUST JSON ERROR HANDLER ---
// This block ensures that any error, even fatal ones,
// will be caught and returned as a valid JSON object.
// This prevents the "Unexpected token '<'" error in JavaScript.
ini_set('display_errors', 0); // Turn off default HTML error output
error_reporting(E_ALL);

// Error handlers... (code unchanged)
function handle_error($errno, $errstr, $errfile, $errline) {
    http_response_code(500);
    echo json_encode(['status' => 'error','message' => 'A server error occurred.','detail' => ['error' => $errstr,'file' => $errfile,'line' => $errline]]);
    exit;
}
function handle_fatal_error() {
    $error = error_get_last();
    if ($error !== null && in_array($error['type'], [E_ERROR, E_CORE_ERROR, E_COMPILE_ERROR, E_USER_ERROR])) {
        http_response_code(500);
        header('Content-Type: application/json; charset=UTF-8');
        echo json_encode(['status' => 'error','message' => 'A fatal server error occurred.','detail' => ['error' => $error['message'],'file' => $error['file'],'line' => $error['line']]]);
        exit;
    }
}
set_error_handler('handle_error');
register_shutdown_function('handle_fatal_error');

header('Content-Type: application/json');
require_once 'db_connect.php';

// --- NEW DEBUGGING BLOCK ---
// This code will create a file named 'debug_log.txt' in the same 'api/' directory.
// It will log the contents of the $_POST array every time this script is called.
// This is the best way to see if your frontend is sending the data correctly.
$log_file = 'debug_log.txt';
$post_data_log = print_r($_POST, true); // Get a string representation of the array
$current_time = date('Y-m-d H:i:s');
file_put_contents($log_file, "[$current_time] Received POST data:\n$post_data_log\n\n", FILE_APPEND);
// --- END DEBUGGING BLOCK ---


$conn = db_connect();

// Get the ID from the POST request, ensuring it's an integer
$id = isset($_POST['id']) && !empty($_POST['id']) ? (int)$_POST['id'] : null;

// --- GATHER FORM DATA ---
$patient_id = isset($_POST['patient_id']) && !empty($_POST['patient_id']) ? (int)$_POST['patient_id'] : null;
$ailment = $_POST['ailment'] ?? '';
$status = isset($_POST['status']) ? (int)$_POST['status'] : 0; // Assuming 0 is a valid default status
$date_only = $_POST['date_only'] ?? '';
$time_only = $_POST['time_only'] ?? '';
$fullname = $_POST['fullname'] ?? '';
$user_id = $_POST['user_id'] ?? '1'; // Defaulting to '1', assuming it's a string from form
$doctor = $_POST['doctor'] ?? null;
$remarks = $_POST['remarks'] ?? null;
$findings = $_POST['findings'] ?? null;
$bp = $_POST['bp'] ?? null;
$weight_kg = $_POST['weight_kg'] ?? null;
$phone = $_POST['phone'] ?? null;
$email = $_POST['email'] ?? null;

$date_sched = ($date_only && $time_only) ? "$date_only $time_only" : null;

if ($id) {
    // --- UPDATE ---
    $sql = "UPDATE appointments SET patient_id=?, ailment=?, status=?, date_sched=?, date_only=?, time_only=?, fullname=?, user_id=?, doctor=?, remarks=?, findings=?, bp=?, weight_kg=?, phone=?, email=? WHERE id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'isissssssssssssi', $patient_id, $ailment, $status, $date_sched, $date_only, $time_only, $fullname, $user_id, $doctor, $remarks, $findings, $bp, $weight_kg, $phone, $email, $id);

} else {
    // --- INSERT ---
    $sql = "INSERT INTO appointments (patient_id, ailment, status, date_sched, date_only, time_only, fullname, user_id, doctor, remarks, findings, bp, weight_kg, phone, email, date_created) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'isissssssssssss', $patient_id, $ailment, $status, $date_sched, $date_only, $time_only, $fullname, $user_id, $doctor, $remarks, $findings, $bp, $weight_kg, $phone, $email);
}

if (mysqli_stmt_execute($stmt)) {
    $message = $id ? 'Appointment updated successfully.' : 'Appointment created successfully.';
    echo json_encode(['status' => 'success', 'message' => $message]);
} else {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Database statement error: ' . mysqli_stmt_error($stmt)]);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>
