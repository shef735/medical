<?php
// Include the database connection file
include ("../../Connections/dbname.php");


// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

// Check if the required fields are present
if (isset($data['id'], $data['date'], $data['fullname'], $data['age'])) {
    // Sanitize the input data
    $id = intval($data['id']); // Ensure ID is an integer
    $date = mysqli_real_escape_string($conn, $data['date']); // Escape special characters
    $fullname = mysqli_real_escape_string($conn, $data['fullname']); // Escape special characters
    $age = intval($data['age']); // Ensure age is an integer
$filetoresult=ltrim($main_table_use).'_resources.patient_record';
    // Prepare the SQL query
    $sql = "UPDATE ".$filetoresult." SET date = '$date', fullname = '$fullname', age = $age WHERE id = $id";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        // Return a success response
        echo json_encode(['success' => true, 'message' => 'Record updated successfully.']);
    } else {
        // Return an error response
        echo json_encode(['success' => false, 'message' => 'Error updating record: ' . mysqli_error($conn)]);
    }
} else {
    // Return an error response if required fields are missing
    echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
}

// Close the database connection
mysqli_close($conn);
?>