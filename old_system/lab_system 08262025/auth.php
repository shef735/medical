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
    
    $username = mysqli_real_escape_string($conn, $username);
    $full_name = mysqli_real_escape_string($conn, $full_name);
    $role = mysqli_real_escape_string($conn, $role);
    $password_hash = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO ".$_SESSION['my_tables']."_laboratory.users (username, password_hash, full_name, role) 
            VALUES ('$username', '$password_hash', '$full_name', '$role')";
    
    return mysqli_query($conn, $sql);
}

function loginUser($username, $password) {
    global $conn;
    
    $username = mysqli_real_escape_string($conn, $username);
    $sql = "SELECT * FROM ".$_SESSION['my_tables']."_laboratory.users WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    
    if ($user = mysqli_fetch_assoc($result)) {
        if ($password==$user['password_hash']) {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['full_name'] = $user['full_name'];
            return true;
        }
    }
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