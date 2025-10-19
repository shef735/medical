<?php
if(!isset($_SESSION)){		
session_start();
ob_start();	
}
?>

<?php

  
 

// Database configuration
$host = $_SESSION['dbhost'];        // Database host, e.g. 'localhost'
$db_username = $_SESSION['dbuser']; // Database username
$db_password = $_SESSION['dbpass']; // Database password
$db_name = 'medical_schedule';      // Database name

// Create connection
$conn = new mysqli($host, $db_username, $db_password, $db_name);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Set character set to utf8
$conn->set_charset("utf8");
?>