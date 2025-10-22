<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Generate patient code
    $patient_code = generatePatientCode($conn);
    
    // Basic Information
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
    $nickname = mysqli_real_escape_string($conn, $_POST['nickname']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
    $occupation = mysqli_real_escape_string($conn, $_POST['occupation']);
    
    // Contact Information
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $referred_by = mysqli_real_escape_string($conn, $_POST['referred_by']);
    $other_mds = mysqli_real_escape_string($conn, $_POST['other_mds']);
    
    // Address Information
    $NoBldgName = mysqli_real_escape_string($conn, $_POST['NoBldgName']);
    $StreetName = mysqli_real_escape_string($conn, $_POST['StreetName']);
    $psgc_barangay = mysqli_real_escape_string($conn, $_POST['psgc_barangay']);
    $psgc_municipality = mysqli_real_escape_string($conn, $_POST['psgc_municipality']);
    $psgc_province = mysqli_real_escape_string($conn, $_POST['psgc_province']);
    $psgc_region = mysqli_real_escape_string($conn, $_POST['psgc_region']);
    $ZipCode = mysqli_real_escape_string($conn, $_POST['ZipCode']);
    
    // Medical History
    $family_medical_history = mysqli_real_escape_string($conn, $_POST['family_medical_history']);
    $smoking_history = mysqli_real_escape_string($conn, $_POST['smoking_history']);
    $social_history = mysqli_real_escape_string($conn, $_POST['social_history']);
    $alcohol_history = mysqli_real_escape_string($conn, $_POST['alcohol_history']);
    $immunization_history = mysqli_real_escape_string($conn, $_POST['immunization_history']);
    $diabetes_history = mysqli_real_escape_string($conn, $_POST['diabetes_history']);
    $hypertension_history = mysqli_real_escape_string($conn, $_POST['hypertension_history']);
    $cancer_history = mysqli_real_escape_string($conn, $_POST['cancer_history']);
    $golder_history = mysqli_real_escape_string($conn, $_POST['golder_history']);
    $menstrual_history = mysqli_real_escape_string($conn, $_POST['menstrual_history']);
    
    // Overview
    $new_chart = mysqli_real_escape_string($conn, $_POST['new_chart']);
    $new_id_chart = mysqli_real_escape_string($conn, $_POST['new_id_chart']);
    $new_lab_summary = mysqli_real_escape_string($conn, $_POST['new_lab_summary']);
    
    // Diagnosis and Notes
    $diagnosis = mysqli_real_escape_string($conn, $_POST['diagnosis']);
    $pint = mysqli_real_escape_string($conn, $_POST['pint']);
    $adverse_drug_reactions = mysqli_real_escape_string($conn, $_POST['adverse_drug_reactions']);
    $other_notes = mysqli_real_escape_string($conn, $_POST['other_notes']);
    
    // Physical Attributes
    $height_cm = mysqli_real_escape_string($conn, $_POST['height_cm']);
    $weight_kg = mysqli_real_escape_string($conn, $_POST['weight_kg']);
    $blood_group = mysqli_real_escape_string($conn, $_POST['blood_group']);
    $civil_status = mysqli_real_escape_string($conn, $_POST['civil_status']);
    
    // Calculate BMI
    $bmi = $weight_kg / (($height_cm/100) * ($height_cm/100));
    
    // Handle file upload
    $photo = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $target_dir = "../../uploads/patients/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
        $photo = $target_file;
    }
    
    // Insert query
    $sql = "INSERT INTO patient_info (
        patient_code, user_id, last_name, first_name, middle_name, nickname,
        gender, sex, birthday, date_of_birth, occupation, phone, email,
        referred_by, other_mds, NoBldgName, StreetName, psgc_barangay,
        psgc_municipality, psgc_province, psgc_region, ZipCode,
        family_medical_history, smoking_history, social_history, alcohol_history,
        immunization_history, diabetes_history, hypertension_history, cancer_history,
        golder_history, menstrual_history, new_chart, new_id_chart, new_lab_summary,
        diagnosis, pint, adverse_drug_reactions, other_notes, height_cm, weight_kg,
        bmi, blood_group, civil_status, photo, created_at
    ) VALUES (
        '$patient_code', '$patient_code', '$last_name', '$first_name', '$middle_name', '$nickname',
        '$gender', '$gender', '$birthday', '$birthday', '$occupation', '$phone', '$email',
        '$referred_by', '$other_mds', '$NoBldgName', '$StreetName', '$psgc_barangay',
        '$psgc_municipality', '$psgc_province', '$psgc_region', '$ZipCode',
        '$family_medical_history', '$smoking_history', '$social_history', '$alcohol_history',
        '$immunization_history', '$diabetes_history', '$hypertension_history', '$cancer_history',
        '$golder_history', '$menstrual_history', '$new_chart', '$new_id_chart', '$new_lab_summary',
        '$diagnosis', '$pint', '$adverse_drug_reactions', '$other_notes', '$height_cm', '$weight_kg',
        '$bmi', '$blood_group', '$civil_status', '$photo', NOW()
    )";
    
    if (mysqli_query($conn, $sql)) {
        $patient_id = mysqli_insert_id($conn);
        // Update patient_id with the auto-increment ID
        mysqli_query($conn, "UPDATE patient_info SET patient_id = $patient_id WHERE id = $patient_id");
        header("Location: view_patient.php?id=$patient_id&message=Patient added successfully");
    } else {
        $error = "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Patient</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
        }
        h2 {
            color: #3498db;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            margin-top: 30px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="date"],
        input[type="email"],
        input[type="tel"],
        input[type="number"],
        select,
        textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        textarea {
            min-height: 80px;
        }
        .photo-preview {
            max-width: 150px;
            max-height: 150px;
            margin: 10px 0;
        }
        .row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -10px;
        }
        .col {
            flex: 1;
            padding: 0 10px;
            min-width: 200px;
        }
        .action-buttons {
            margin-top: 20px;
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 10px 15px;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            font-size: 14px;
            border: none;
            cursor: pointer;
        }
        .btn-save {
            background: #2ecc71;
        }
        .btn-save:hover {
            background: #27ae60;
        }
        .btn-cancel {
            background: #95a5a6;
        }
        .btn-cancel:hover {
            background: #7f8c8d;
        }
        .error {
            color: #e74c3c;
            margin-bottom: 15px;
        }
        .section {
            margin-bottom: 30px;
        }
        .required:after {
            content: " *";
            color: #e74c3c;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add New Patient</h1>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="post" action="create.php" enctype="multipart/form-data">
            <div class="section">
                <h2>Basic Information</h2>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="last_name" class="required">Last Name</label>
                            <input type="text" id="last_name" name="last_name" required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="first_name" class="required">First Name</label>
                            <input type="text" id="first_name" name="first_name" required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="middle_name">Middle Name</label>
                            <input type="text" id="middle_name" name="middle_name">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="nickname">Nickname</label>
                            <input type="text" id="nickname" name="nickname">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="gender" class="required">Gender</label>
                            <select id="gender" name="gender" required>
                                <option value="">Select Gender</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="birthday" class="required">Birthdate</label>
                            <input type="date" id="birthday" name="birthday" required>
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="occupation">Occupation</label>
                    <input type="text" id="occupation" name="occupation">
                </div>
                
                <div class="form-group">
                    <label for="photo">Photo</label>
                    <input type="file" id="photo" name="photo">
                </div>
            </div>
            
            <div class="section">
                <h2>Contact Information</h2>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="phone" class="required">Phone Number</label>
                            <input type="tel" id="phone" name="phone" required>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="referred_by">Referred By</label>
                            <input type="text" id="referred_by" name="referred_by">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="other_mds">Other MDs</label>
                            <input type="text" id="other_mds" name="other_mds">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="section">
                <h2>Address Information</h2>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="NoBldgName">Building/House No.</label>
                            <input type="text" id="NoBldgName" name="NoBldgName">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="StreetName">Street Name</label>
                            <input type="text" id="StreetName" name="StreetName">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="psgc_barangay">Barangay</label>
                            <input type="text" id="psgc_barangay" name="psgc_barangay">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="psgc_municipality">Municipality/City</label>
                            <input type="text" id="psgc_municipality" name="psgc_municipality">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="psgc_province">Province</label>
                            <input type="text" id="psgc_province" name="psgc_province">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="psgc_region">Region</label>
                            <input type="text" id="psgc_region" name="psgc_region">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="ZipCode">Zip Code</label>
                            <input type="text" id="ZipCode" name="ZipCode">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="section">
                <h2>Medical History</h2>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="family_medical_history">Family Medical History (FMHx)</label>
                            <textarea id="family_medical_history" name="family_medical_history"></textarea>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="smoking_history">Smoking History</label>
                            <textarea id="smoking_history" name="smoking_history"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="social_history">Social History (SHx)</label>
                            <textarea id="social_history" name="social_history"></textarea>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="alcohol_history">Alcohol History</label>
                            <textarea id="alcohol_history" name="alcohol_history"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="immunization_history">Immunization History</label>
                            <textarea id="immunization_history" name="immunization_history"></textarea>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="diabetes_history">Diabetes History (DM)</label>
                            <textarea id="diabetes_history" name="diabetes_history"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="hypertension_history">Hypertension History (HTN)</label>
                            <textarea id="hypertension_history" name="hypertension_history"></textarea>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="cancer_history">Cancer History</label>
                            <textarea id="cancer_history" name="cancer_history"></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="golder_history">Golder History</label>
                            <textarea id="golder_history" name="golder_history"></textarea>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="menstrual_history">OB Menstrual History</label>
                            <textarea id="menstrual_history" name="menstrual_history"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="section">
                <h2>Physical Attributes</h2>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="height_cm">Height (cm)</label>
                            <input type="number" step="0.1" id="height_cm" name="height_cm">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="weight_kg">Weight (kg)</label>
                            <input type="number" step="0.1" id="weight_kg" name="weight_kg">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="blood_group">Blood Group</label>
                            <select id="blood_group" name="blood_group">
                                <option value="">Select Blood Group</option>
                                <option value="A+">A+</option>
                                <option value="A-">A-</option>
                                <option value="B+">B+</option>
                                <option value="B-">B-</option>
                                <option value="AB+">AB+</option>
                                <option value="AB-">AB-</option>
                                <option value="O+">O+</option>
                                <option value="O-">O-</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="civil_status">Civil Status</label>
                            <select id="civil_status" name="civil_status">
                                <option value="">Select Civil Status</option>
                                <option value="Single">Single</option>
                                <option value="Married">Married</option>
                                <option value="Divorced">Divorced</option>
                                <option value="Widowed">Widowed</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="section">
                <h2>Overview</h2>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="new_chart">New Chart</label>
                            <select id="new_chart" name="new_chart">
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="new_id_chart">New ID Chart</label>
                            <select id="new_id_chart" name="new_id_chart">
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="new_lab_summary">New Lab Summary</label>
                            <select id="new_lab_summary" name="new_lab_summary">
                                <option value="No">No</option>
                                <option value="Yes">Yes</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="section">
                <h2>Diagnosis and Notes</h2>
                <div class="form-group">
                    <label for="diagnosis">Diagnosis</label>
                    <textarea id="diagnosis" name="diagnosis"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="pint">Pint</label>
                    <textarea id="pint" name="pint"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="adverse_drug_reactions">Adverse Drug Reactions</label>
                    <textarea id="adverse_drug_reactions" name="adverse_drug_reactions"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="other_notes">Other Notes</label>
                    <textarea id="other_notes" name="other_notes"></textarea>
                </div>
            </div>
            
            <div class="action-buttons">
                <button type="submit" class="btn btn-save">Save Patient</button>
                <a href="index.php" class="btn btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>