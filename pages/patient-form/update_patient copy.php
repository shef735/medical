<?php
session_start();
ob_start();


ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "db.php";

// Function to calculate BMI
function calculateBMI($weight_kg, $height_cm) {
    if($height_cm > 0 && $weight_kg > 0) {
        $height_m = $height_cm / 100;
        return round($weight_kg / ($height_m * $height_m), 2);
    }
    return 0;
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $patient_id = intval($_POST['patient_id']);
        
        // Prepare data
        $date = mysqli_real_escape_string($conn, $_POST['date']);
        $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
        $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
        $middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
        $phone = mysqli_real_escape_string($conn, $_POST['phone']);
        $sex = mysqli_real_escape_string($conn, $_POST['sex']);
        $height_cm = floatval($_POST['height_cm']);
        $weight_kg = floatval($_POST['weight_kg']);
        $blood_group = mysqli_real_escape_string($conn, $_POST['blood_group']);
        $civil_status = mysqli_real_escape_string($conn, $_POST['civil_status']);
        $psgc_region = mysqli_real_escape_string($conn, $_POST['psgc_region']);
        $psgc_province = mysqli_real_escape_string($conn, $_POST['psgc_province']);
        $psgc_municipality = mysqli_real_escape_string($conn, $_POST['psgc_municipality']);
        $psgc_barangay = mysqli_real_escape_string($conn, $_POST['psgc_barangay']);
        $ZipCode = mysqli_real_escape_string($conn, $_POST['ZipCode']);
        $NoBldgName = mysqli_real_escape_string($conn, $_POST['NoBldgName']);
        $StreetName = mysqli_real_escape_string($conn, $_POST['StreetName']);
        $photo = mysqli_real_escape_string($conn, $_POST['patient_photo']);

      
        
        // Calculate BMI
        $bmi = calculateBMI($weight_kg, $height_cm);
        
        // Concatenate address
        $address = $NoBldgName . ", " . $StreetName;
        
      
        // Generate nickname (first name + first letter of last name)
        $nickname = $first_name . " " . substr($last_name, 0, 1) . ".";
       
        // Update query
        $query = "UPDATE patient_info SET 
            date = ?, 
            nickname = ?, 
            last_name = ?, 
            first_name = ?, 
            middle_name = ?, 
            address = ?, 
            phone = ?, 
            sex = ?, 
            gender = ?, 
            email = ?, 
            birthday = ?, 
            date_of_birth = ?, 
            height_cm = ?, 
            weight_kg = ?, 
            photo = ?, 
            bmi = ?, 
            blood_group = ?, 
            civil_status = ?, 
            psgc_barangay = ?, 
            psgc_municipality = ?, 
            psgc_province = ?, 
            psgc_region = ?, 
            ZipCode = ?, 
            NoBldgName = ?, 
            StreetName = ? 
            WHERE id = ?";
        
 
       
        $stmt = mysqli_prepare($conn, $query);

      
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . mysqli_error($conn));
        }
        
        $bind_result = mysqli_stmt_bind_param($stmt, "sssssssssssssssssssssssssi", 
            $date, $nickname, $last_name, $first_name, $middle_name, $address, $phone, 
            $sex, $sex, $email, $birthday, $birthday, $height_cm, $weight_kg, $photo, 
            $bmi, $blood_group, $civil_status, $psgc_barangay, $psgc_municipality, 
            $psgc_province, $psgc_region, $ZipCode, $NoBldgName, $StreetName, $patient_id
        );

     
        
        if (!$bind_result) {
            throw new Exception("Bind failed: " . mysqli_stmt_error($stmt));
        }
        
        if(mysqli_stmt_execute($stmt)) {
            $_SESSION['update_success'] = true;
            $_SESSION['patient_id'] = $patient_id;
            $_SESSION['patient_name'] = $first_name . " " . $last_name;
            header("Location: update_success.php");
            exit();
        } else {
            throw new Exception("Error updating patient information: " . mysqli_stmt_error($stmt));
        }
        
        mysqli_stmt_close($stmt);
        
    } catch (Exception $e) {
        $error = $e->getMessage();
        $_SESSION['update_error'] = $error;
       // header("Location: edit_patient_form.php?id=" . $patient_id);
        exit();
    }
}
?>