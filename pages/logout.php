<?php
// 1. Initialize the session
// This is necessary to access the session.
if (!isset($_SESSION)) {
    session_start();
}

// 2. Unset all session variables
// This clears all the data stored in the session, like user ID and permissions.
$_SESSION = array();

// 3. Destroy the session
// This completely removes the session from the server.
session_destroy();

// 4. Redirect to the login page
// After logging out, the user is sent back to the login screen.
header("location: login.php");
exit;
?>