<?php
/**
 * Deletes an appointment from the database.
 * * It expects an 'id' from a POST request and deletes the
 * corresponding record from the 'appointments' table.
 */

header('Content-Type: application/json');
require_once 'db_connect.php';

$conn = db_connect();

// Get the ID from the POST request, ensuring it's an integer
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0;

if ($id > 0) {
    // Use a prepared statement to prevent SQL injection
    $sql = "DELETE FROM appointments WHERE id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    
    // Bind the integer ID to the statement
    mysqli_stmt_bind_param($stmt, 'i', $id);

    // Execute the statement
    if (mysqli_stmt_execute($stmt)) {
        echo json_encode(['status' => 'success', 'message' => 'Appointment deleted successfully.']);
    } else {
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Failed to delete appointment: ' . mysqli_stmt_error($stmt)]);
    }
    mysqli_stmt_close($stmt);
} else {
    // If the ID is invalid or not provided, return a 400 bad request error
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid ID provided for deletion.']);
}

mysqli_close($conn);
?>
