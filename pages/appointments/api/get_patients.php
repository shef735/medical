<?php
/**
 * Fetches patient information for the Select2 dropdown.
 * * This script searches the 'patient_info' table based on a query string.
 * It concatenates the first and last names for the display text.
 * It also returns the email and phone number to auto-populate the form.
 * The result is returned as a JSON array formatted for Select2.
 */

header('Content-Type: application/json');
require_once 'db_connect.php';

$conn = db_connect();
$patients = [];

// Get the search term from Select2, and sanitize it to prevent SQL injection.
$searchTerm = isset($_GET['q']) ? mysqli_real_escape_string($conn, $_GET['q']) : '';

// SQL query to search for patients by first name or last name.
// It returns the user_id as 'id' and the concatenated name as 'text'
// which is the format required by Select2. It now also includes email and phone.
$sql = "SELECT user_id as id, CONCAT(first_name, ' ', last_name) as text, email, phone FROM patient_info WHERE first_name LIKE '%$searchTerm%' OR last_name LIKE '%$searchTerm%' LIMIT 20";

$result = mysqli_query($conn, $sql);

if ($result) {
    while($row = mysqli_fetch_assoc($result)) {
        $patients[] = $row;
    }
    mysqli_free_result($result);
} else {
    // In case of an SQL error, you might want to log it.
    // For now, we'll just return an empty array.
}

echo json_encode($patients);
mysqli_close($conn);
?>
