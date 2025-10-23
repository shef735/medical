<?php
session_start();
ob_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


// Database connection
include "db.php";

// Function to generate patient code
function generatePatientCode($conn) {
    $prefix = "PAT";
    $year = date('Y');
    
    // Get the last patient code for this year
    $query = "SELECT patient_code FROM patient_info WHERE patient_code LIKE '$prefix$year%' ORDER BY id DESC LIMIT 1";
    $result = mysqli_query($conn, $query);
    
    if(mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $last_code = $row['patient_code'];
        $last_number = intval(substr($last_code, -4));
        $new_number = str_pad($last_number + 1, 4, '0', STR_PAD_LEFT);
    } else {
        $new_number = '0001';
    }
    
    return $prefix . $year . $new_number;
}

// Function to calculate BMI
function calculateBMI($weight_kg, $height_cm) {
    if($height_cm > 0 && $weight_kg > 0) {
        $height_m = $height_cm / 100;
        return round($weight_kg / ($height_m * $height_m), 2);
    }
    return 0;
}


// Function to handle photo upload
function handlePhotoUpload($conn) {
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
            $filename = 'patient_' . time() . '_' . uniqid() . '.jpg';
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
    elseif (!empty($_FILES['patient_photo_file']['name'])) {
        $upload_dir = '../../uploads/';
        
        // Create directory if it doesn't exist
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }
        
        $filename = 'patient_' . time() . '_' . uniqid() . '_' . $_FILES['patient_photo_file']['name'];
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

// Check if form was already submitted to prevent duplicate entries
if(isset($_SESSION['form_submitted']) && $_SESSION['form_submitted'] === true) {
  //   header("Location: index.php");
  //  exit();
}


if($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {

         $_SESSION['form_submitted'] = true;
        // Generate patient code
        $patient_code = generatePatientCode($conn);

          $photo_path = handlePhotoUpload($conn);

          $_SESSION['user_id']=$patient_code;
        
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
        $StreetName = '';
         
        // Calculate BMI
        $bmi = calculateBMI($weight_kg, $height_cm);
        
        // Concatenate address
        $address = $NoBldgName . ", " . $StreetName;
        
        // Generate nickname (first name + first letter of last name)
        $nickname = $first_name . " " . substr($last_name, 0, 1) . ".";
        
        // Generate default password (patient_code + last 4 digits of phone)
        $phone_last_four = substr($phone, -4);
        $default_password = password_hash($patient_code . $phone_last_four, PASSWORD_DEFAULT);
        
        // First insert with NULL for patient_id (auto-increment will handle it)
        $query = "INSERT INTO patient_info (
            patient_id, date, patient_code, user_id, nickname, last_name, first_name, middle_name, 
            password, address, phone, sex, gender, email, birthday, date_of_birth, 
            height_cm, weight_kg, photo, bmi, blood_group, civil_status, 
            psgc_barangay, psgc_municipality, psgc_province, psgc_region, ZipCode, NoBldgName, StreetName, created_at
        ) VALUES (
            '', ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW()
        )";
        
        $stmt = mysqli_prepare($conn, $query);
        
        if (!$stmt) {
            throw new Exception("Prepare failed: " . mysqli_error($conn));
        }
        
        // Count the number of parameters needed (29 question marks in the query)
        $bind_result = mysqli_stmt_bind_param($stmt, "ssssssssssssssssssssdsssssss", 
            $date, $patient_code, $patient_code, $nickname, $last_name, $first_name, $middle_name,
            $default_password, $address, $phone, $sex, $sex, $email, $birthday, $birthday,
            $height_cm, $weight_kg, $photo_path, $bmi, $blood_group, $civil_status,
            $psgc_barangay, $psgc_municipality, $psgc_province, $psgc_region, $ZipCode, $NoBldgName, $StreetName
        );
        
        if (!$bind_result) {
            throw new Exception("Bind failed: " . mysqli_stmt_error($stmt));
        }
        
        if(mysqli_stmt_execute($stmt)) {
            $patient_id = mysqli_insert_id($conn);
            
            // Update patient_id to match id
            $update_query = "UPDATE patient_info SET patient_id = ? WHERE id = ?";
            $update_stmt = mysqli_prepare($conn, $update_query);
            mysqli_stmt_bind_param($update_stmt, "ii", $patient_id, $patient_id);
            mysqli_stmt_execute($update_stmt);
            
            // Store in session for questions.php
            $_SESSION['patient_id'] = $patient_id;
            $_SESSION['patient_code'] = $patient_code;
            $_SESSION['patient_name'] = $first_name . " " . $last_name;
             $_SESSION['patient_photo'] = $photo_path;
            
            $success = true;
        } else {
            throw new Exception("Error saving patient information: " . mysqli_stmt_error($stmt));
        }
        
        mysqli_stmt_close($stmt);
        
    } catch (Exception $e) {
        $error = $e->getMessage();
        $success = false;

         unset($_SESSION['form_submitted']);
    }
} else {
    // If page is accessed directly without POST, check if we have saved data to display
    if(isset($_SESSION['saved_data'])) {
        $saved_data = $_SESSION['saved_data'];
        $patient_code = $saved_data['patient_code'];
        $first_name = $saved_data['first_name'];
        $last_name = $saved_data['last_name'];
        $email = $saved_data['email'];
        $phone = $saved_data['phone'];
        $bmi = $saved_data['bmi'];
        $photo_path = $saved_data['photo_path'];
        $success = true;
    } else {
        // Redirect to form if no saved data and no POST
        header("Location: index.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Information Saved</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        
        .container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 40px;
            max-width: 700px;
            width: 100%;
            text-align: center;
            animation: fadeIn 0.6s ease-out;
        }
        
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(30px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .status-icon {
            font-size: 80px;
            margin-bottom: 20px;
        }
        
        .success { color: #28a745; }
        .error { color: #dc3545; }
        
        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 32px;
            font-weight: 700;
        }
        
        .message {
            font-size: 18px;
            color: #555;
            margin-bottom: 30px;
            line-height: 1.6;
        }
        
        .patient-info {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
            margin: 25px 0;
            border-left: 5px solid #3498db;
        }
        
        .info-item {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e9ecef;
        }
        
        .info-item:last-child {
            margin-bottom: 0;
            padding-bottom: 0;
            border-bottom: none;
        }
        
        .info-label {
            font-weight: 600;
            color: #495057;
        }
        
        .info-value {
            color: #212529;
            font-weight: 500;
        }
        
        .photo-section {
            margin: 20px 0;
            padding: 20px;
            background: #f8f9fa;
            border-radius: 10px;
            border: 2px dashed #dee2e6;
        }
        
        .photo-title {
            font-weight: 600;
            color: #495057;
            margin-bottom: 15px;
            font-size: 18px;
        }
        
        .patient-photo {
            max-width: 200px;
            max-height: 200px;
            border-radius: 10px;
            border: 3px solid #3498db;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
        
        .no-photo {
            padding: 40px;
            color: #6c757d;
            font-style: italic;
            background: #e9ecef;
            border-radius: 8px;
        }
        
        .button-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            margin-top: 30px;
            flex-wrap: wrap;
        }
        
        .btn {
            padding: 15px 30px;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            min-width: 200px;
            justify-content: center;
        }
        
        .btn-primary {
            background: linear-gradient(135deg, #3498db, #2980b9);
            color: white;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(52, 152, 219, 0.3);
        }
        
        .btn-secondary {
            background: #6c757d;
            color: white;
        }
        
        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
        }
        
        .btn-success {
            background: linear-gradient(135deg, #28a745, #218838);
            color: white;
        }
        
        .btn-success:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(40, 167, 69, 0.3);
        }
        
        .bmi-indicator {
            display: inline-block;
            padding: 5px 15px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
            margin-left: 10px;
        }
        
        .bmi-normal { background: #d4edda; color: #155724; }
        .bmi-underweight { background: #fff3cd; color: #856404; }
        .bmi-overweight { background: #ffeaa7; color: #8a6d03; }
        .bmi-obese { background: #f8d7da; color: #721c24; }
        
        @media (max-width: 768px) {
            .container {
                padding: 30px 20px;
            }
            
            .button-group {
                flex-direction: column;
            }
            
            .btn {
                min-width: 100%;
            }
            
            h1 {
                font-size: 28px;
            }
            
            .patient-photo {
                max-width: 150px;
                max-height: 150px;
            }
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
        
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
        
        .warning-message {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            color: #856404;
            padding: 15px;
            border-radius: 8px;
            margin: 20px 0;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="container">
        <?php if(isset($success) && $success): ?>
            <!-- Success State -->
            <div class="status-icon success">
                <i class="fas fa-check-circle pulse"></i>
            </div>
            
            <h1>Patient Information Saved Successfully!</h1>
            
            <div class="message">
                Patient information has been successfully saved to the database. 
                You can now proceed to the medical questionnaire or return to the main menu.

                <?php if(!empty($photo_path)): ?>
                    <br><strong>Photo saved:</strong> <?php echo basename($photo_path); ?>
                <?php else: ?>
                    <br><em>No photo was uploaded.</em>
                <?php endif; ?>
            </div>

             <!-- Photo Display Section -->
            <div class="photo-section">
                <div class="photo-title">Patient Photo</div>
                <?php if(!empty($photo_path) && file_exists($photo_path)): ?>
                    <img src="<?php echo $photo_path; ?>" alt="Patient Photo" class="patient-photo">
                <?php else: ?>
                    <div class="no-photo">
                        <i class="fas fa-user-circle fa-3x"></i>
                        <p>No photo available</p>
                    </div>
                <?php endif; ?>
            </div>
            
            <div class="patient-info">
                <div class="info-item">
                    <span class="info-label">Patient ID:</span>
                    <span class="info-value"><?php echo $patient_code; ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Name:</span>
                    <span class="info-value"><?php echo htmlspecialchars($first_name . ' ' . $last_name); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Email:</span>
                    <span class="info-value"><?php echo htmlspecialchars($email); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">Phone:</span>
                    <span class="info-value"><?php echo htmlspecialchars($phone); ?></span>
                </div>
                <div class="info-item">
                    <span class="info-label">BMI:</span>
                    <span class="info-value">
                        <?php echo $bmi; ?>
                        <?php if($bmi > 0): ?>
                            <?php
                            $bmi_class = '';
                            if($bmi < 18.5) {
                                $bmi_class = 'bmi-underweight';
                                $bmi_status = 'Underweight';
                            } else if($bmi < 25) {
                                $bmi_class = 'bmi-normal';
                                $bmi_status = 'Normal';
                            } else if($bmi < 30) {
                                $bmi_class = 'bmi-overweight';
                                $bmi_status = 'Overweight';
                            } else {
                                $bmi_class = 'bmi-obese';
                                $bmi_status = 'Obese';
                            }
                            ?>
                            <span class="bmi-indicator <?php echo $bmi_class; ?>"><?php echo $bmi_status; ?></span>
                        <?php endif; ?>
                    </span>
                </div>
            </div>

            
            
            <div class="button-group">
                <a href="../questions/" class="btn btn-success">
                    <i class="fas fa-clipboard-list"></i>
                    Proceed to Medical Questions
                </a>
                
                <a href="../index.php" class="btn btn-secondary">
                    <i class="fas fa-home"></i>
                    Return to Home
                </a>
                
                <a href="index.php" class="btn btn-primary">
                    <i class="fas fa-user-plus"></i>
                    Add Another Patient
                </a>
            </div>
            
        <?php else: ?>
            <!-- Error State -->
            <div class="status-icon error">
                <i class="fas fa-exclamation-circle"></i>
            </div>
            
            <h1>Error Saving Information</h1>
            
            <div class="message">
                <?php echo isset($error) ? htmlspecialchars($error) : 'An unknown error occurred.'; ?>
            </div>
            
            <div class="button-group">
                <a href="patient_form.php" class="btn btn-primary">
                    <i class="fas fa-arrow-left"></i>
                    Go Back to Form
                </a>
                
                <a href="index.php" class="btn btn-secondary">
                    <i class="fas fa-home"></i>
                    Return to Home
                </a>
            </div>
        <?php endif; ?>
    </div>
<script>
        // Prevent form resubmission when refreshing
        if (window.history.replaceState) {
            window.history.replaceState(null, null, window.location.href);
        }

        // Disable back button functionality
        window.onload = function() {
            window.history.forward();
        };

        // Auto-redirect to questions after 10 seconds if user doesn't choose
        

        // Prevent accidental page refresh
        window.addEventListener('beforeunload', function(e) {
            <?php if(isset($success) && $success): ?>
            e.preventDefault();
            e.returnValue = 'Are you sure you want to leave? Your data has been saved but you may lose this confirmation page.';
            <?php endif; ?>
        });
    </script>
</body>
</html>