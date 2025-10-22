<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

<?php

include "../../Connections/dbname.php";
//include 'auth.php';

function addPatient($data) {
    global $conn;
    
    $fields = [
        'patient_code' => mysqli_real_escape_string($conn, $data['patient_code']),
        'first_name' => mysqli_real_escape_string($conn, $data['first_name']),
        'last_name' => mysqli_real_escape_string($conn, $data['last_name']),
        'date_of_birth' => mysqli_real_escape_string($conn, $data['date_of_birth']),
        'gender' => mysqli_real_escape_string($conn, $data['gender']),
        'address' => mysqli_real_escape_string($conn, $data['address'] ?? ''),
        'phone' => mysqli_real_escape_string($conn, $data['phone'] ?? ''),
        'email' => mysqli_real_escape_string($conn, $data['email'] ?? '')
    ];
    
    $sql = "INSERT INTO ".$_SESSION['my_tables']."_resources.patient_info (" . implode(', ', array_keys($fields)) . ") 
            VALUES ('" . implode("', '", $fields) . "')";
    
    return mysqli_query($conn, $sql) ? mysqli_insert_id($conn) : false;
}

function updatePatient($patient_id, $data) {
    global $conn;
    
    $patient_id = (int)$patient_id;
    $updates = [];
    
    foreach ($data as $key => $value) {
        $updates[] = "$key = '" . mysqli_real_escape_string($conn, $value) . "'";
    }
    
    $sql = "UPDATE ".$_SESSION['my_tables']."_resources.patient_info  SET " . implode(', ', $updates) . " WHERE patient_id = $patient_id";
    return mysqli_query($conn, $sql);
}

function getPatient($patient_id) {
    global $conn;
    $patient_id = (int)$patient_id;
    $sql = "SELECT * FROM ".$_SESSION['my_tables']."_resources.patient_info  WHERE patient_id = $patient_id";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}

function searchPatients($search_term) {
    global $conn;
    $search_term = mysqli_real_escape_string($conn, $search_term);
    
    $sql = "SELECT * FROM ".$_SESSION['my_tables']."_resources.patient_info  
            WHERE patient_code LIKE '%$search_term%' 
            OR first_name LIKE '%$search_term%' 
            OR last_name LIKE '%$search_term%' 
            OR phone LIKE '%$search_term%'
            ORDER BY last_name, first_name";
    
    $result = mysqli_query($conn, $sql);
    
    $patients = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $patients[] = $row;
    }
    return $patients;
}

function getAllPatients() {
    global $conn;
    $sql = "SELECT * FROM ".$_SESSION['my_tables']."_resources.patient_info  GROUP BY user_id ORDER BY last_name, first_name";
    $result = mysqli_query($conn, $sql);
    
    $patients = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $patients[] = $row;
    }
    return $patients;
}

function calculateAge($date_of_birth) {
    $dob = new DateTime($date_of_birth);
    $now = new DateTime();
    $interval = $now->diff($dob);
    return $interval->y;
}
?>