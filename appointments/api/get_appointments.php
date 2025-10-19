<?php
/**
 * Fetches all appointments from the database.
 * * This script queries the 'appointments' table, retrieves all records,
 * and returns them as a JSON array, which FullCalendar can understand.
 */

// Set the content type to JSON for the response
header('Content-Type: application/json');

// Include the database connection file
require_once 'db_connect.php';

// Establish the database connection
$conn = db_connect();
$appointments = [];

// SQL query to select all necessary fields from the appointments table
$sql = "SELECT id, patient_id, ailment, status, date_only, time_only, fullname, user_id, doctor, 
    remarks, findings, bp, weight_kg, phone, email FROM appointments";

// Execute the query
$result = mysqli_query($conn, $sql);

if ($result) {
    // Fetch all results into an associative array
    while($row = mysqli_fetch_assoc($result)) {
        $appointments[] = $row;
    }
    // Free the result set from memory
    mysqli_free_result($result);
} else {
    // If the query fails, return a 500 server error
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Failed to fetch appointments: ' . mysqli_error($conn)]);
    mysqli_close($conn);
    exit; // Stop further execution
}

// Encode the final array as JSON and output it
echo json_encode($appointments);

// Close the database connection
mysqli_close($conn);
?>
