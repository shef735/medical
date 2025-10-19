<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>


<?php
/**
 * Establishes a connection to the MySQL database.
 * * This function connects to the database using the provided credentials.
 * It's included by all other API files to interact with the database.
 * * IMPORTANT: Replace the placeholder credentials ($servername, $username, 
 * $password, $dbname) with your actual database information.
 */


function db_connect() {
    $servername = $_SESSION['dbhost'];
    $username = $_SESSION['dbuser'];
    $password = $_SESSION['dbpass'];
    $dbname = $_SESSION['dbname'];

    // Create connection using MySQLi procedural style
    $conn = mysqli_connect($servername, $username, $password, $dbname);

    // Check the connection
    if (!$conn) {
        // Stop script execution and return a detailed error message.
        // In a live production environment, it's better to log this error 
        // to a file rather than displaying it to the end-user.
        http_response_code(503); // Service Unavailable
        die("Database Connection Failed: " . mysqli_connect_error());
    }
    
    // Set character set to utf8mb4 for full Unicode support
    mysqli_set_charset($conn, "utf8mb4");
    
    return $conn;
}
?>
