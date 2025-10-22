<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

<?php

include "../../Connections/dbname.php";

function registerUser($username, $password, $full_name, $role) {
    global $conn;
    
    // 1. Securely hash the password (your original code was correct here).
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
    // 2. Use a prepared statement to prevent SQL injection.
    $sql = "INSERT INTO ".$_SESSION['my_tables']."_laboratory.users (username, password_hash, full_name, role) 
            VALUES (?, ?, ?, ?)";
    
    $stmt = mysqli_prepare($conn, $sql);
    // Bind parameters: s = string
    mysqli_stmt_bind_param($stmt, "ssss", $username, $password_hash, $full_name, $role);
    
    return mysqli_stmt_execute($stmt);
}

function loginUser($username, $password) {
    global $conn;
    
    // 1. Use a prepared statement to securely fetch the user.
    $sql = "SELECT * FROM ".$_SESSION['my_tables']."_laboratory.users WHERE username = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "s", $username);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if ($user = mysqli_fetch_assoc($result)) {
        // 2. Securely verify the submitted password against the stored hash.
        if (password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['full_name'] = $user['full_name'];
            return true;
        }
    }
    // Return false if user not found or password is incorrect.
    return false;
}


function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

function logoutUser() {
    session_unset();
    session_destroy();
}

function hasRole($role) {
    return isset($_SESSION['role']) && $_SESSION['role'] === $role;
}

function getCurrentUserId() {
    return $_SESSION['user_id'] ?? null;
}
?>