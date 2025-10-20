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

// Function to handle photo upload
function handlePhotoUpload($conn, $patient_id) {
    $photo_path = '';
    
    // Check if base64 photo exists (from camera)
    if (!empty($_POST['patient_photo_base64'])) {
        $base64_image = $_POST['patient_photo_base64'];
        
        // Remove data:image/jpeg;base64, prefix
        if (strpos($base64_image, 'base64,') !== false) {
            $base64_image = explode('base64,', $base64_image)[1];
        }
        
        // Decode base64 image
        $image_data = base64_decode($base64_image);
        
        if ($image_data !== false) {
            // Generate unique filename
            $filename = 'patient_' . $patient_id . '_' . time() . '.jpg';
            $upload_dir = '../../uploads/';
            
            // Create directory if it doesn't exist
            if (!is_dir($upload_dir)) {
                mkdir($upload_dir, 0755, true);
            }
            
            $file_path = $upload_dir . $filename;
            
            // Save the image file
            if (file_put_contents($file_path, $image_data)) {
                $photo_path = $file_path;
            }
        }
    }
    // Check if file upload exists
    elseif (!empty($_FILES['patient_photo_file']['name']) && $_FILES['patient_photo_file']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../../uploads/';
        
        // Create directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        $filename = 'patient_' . $patient_id . '_' . time() . '_' . $_FILES['patient_photo_file']['name'];
        $file_path = $upload_dir . $filename;
        
        // Validate file type
        $allowed_types = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        $file_type = $_FILES['patient_photo_file']['type'];
        
        if (in_array($file_type, $allowed_types)) {
            // Validate file size (max 5MB)
            if ($_FILES['patient_photo_file']['size'] <= 5 * 1024 * 1024) {
                if (move_uploaded_file($_FILES['patient_photo_file']['tmp_name'], $file_path)) {
                    $photo_path = $file_path;
                }
            }
        }
    }
    
    return $photo_path;
}

// Safe escape function that handles null values
function safe_escape($conn, $value) {
    if ($value === null || $value === '') {
        return '';
    }
    return mysqli_real_escape_string($conn, $value);
}

if($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $patient_id = intval($_POST['patient_id']);
        
        // Handle photo upload FIRST
        $photo_path = handlePhotoUpload($conn, $patient_id);
        
        // If no new photo was uploaded, keep the existing one
        if (empty($photo_path)) {
            // Get the current photo path from database
            $current_photo_query = "SELECT photo FROM patient_info WHERE id = ?";
            $current_stmt = mysqli_prepare($conn, $current_photo_query);
            mysqli_stmt_bind_param($current_stmt, "i", $patient_id);
            mysqli_stmt_execute($current_stmt);
            $result = mysqli_stmt_get_result($current_stmt);
            $current_data = mysqli_fetch_assoc($result);
            $photo_path = $current_data['photo'] ?? '';
        }
        
        // Prepare data with safe escaping
        $date = safe_escape($conn, $_POST['date'] ?? '');
        $last_name = safe_escape($conn, $_POST['last_name'] ?? '');
        $first_name = safe_escape($conn, $_POST['first_name'] ?? '');
        $middle_name = safe_escape($conn, $_POST['middle_name'] ?? '');
        $email = safe_escape($conn, $_POST['email'] ?? '');
        $birthday = safe_escape($conn, $_POST['birthday'] ?? '');
        $phone = safe_escape($conn, $_POST['phone'] ?? '');
        $sex = safe_escape($conn, $_POST['sex'] ?? '');
        $height_cm = floatval($_POST['height_cm'] ?? 0);
        $weight_kg = floatval($_POST['weight_kg'] ?? 0);
        $blood_group = safe_escape($conn, $_POST['blood_group'] ?? '');
        $civil_status = safe_escape($conn, $_POST['civil_status'] ?? '');
        $psgc_region = safe_escape($conn, $_POST['psgc_region'] ?? '');
        $psgc_province = safe_escape($conn, $_POST['psgc_province'] ?? '');
        $psgc_municipality = safe_escape($conn, $_POST['psgc_municipality'] ?? '');
        $psgc_barangay = safe_escape($conn, $_POST['psgc_barangay'] ?? '');
        $ZipCode = safe_escape($conn, $_POST['ZipCode'] ?? '');
        $NoBldgName = safe_escape($conn, $_POST['NoBldgName'] ?? '');
        $StreetName = safe_escape($conn, $_POST['StreetName'] ?? '');
        
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
            $sex, $sex, $email, $birthday, $birthday, $height_cm, $weight_kg, $photo_path, 
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
            $_SESSION['patient_photo'] = $photo_path;
            header("Location: update_success.php");
            exit();
        } else {
            throw new Exception("Error updating patient information: " . mysqli_stmt_error($stmt));
        }
        
        mysqli_stmt_close($stmt);
        
    } catch (Exception $e) {
        $error = $e->getMessage();
        $_SESSION['update_error'] = $error;
        header("Location: edit_patient_form.php?id=" . $patient_id);
        exit();
    }
}
?>