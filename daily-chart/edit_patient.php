<?php
include 'config.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$patient_id = $_GET['id'];
$sql = "SELECT * FROM patient_info WHERE id = $patient_id";
$result = mysqli_query($conn, $sql);
$patient = mysqli_fetch_assoc($result);

if (!$patient) {
    header("Location: index.php");
    exit;
}


$user_id = $patient['user_id'];
$sql = "SELECT * FROM patient_details WHERE user_id = '".$user_id."'";
$result = mysqli_query($conn, $sql);
$patient_details = mysqli_fetch_assoc($result);

 //echo $patient_details['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
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
    $goiter_history = mysqli_real_escape_string($conn, $_POST['goiter_history']);
    $menstrual_history = mysqli_real_escape_string($conn, $_POST['menstrual_history']);
    
    
    
    // Diagnosis and Notes
    $diagnosis = mysqli_real_escape_string($conn, $_POST['diagnosis']);
    $adverse_drug_reactions = mysqli_real_escape_string($conn, $_POST['adverse_drug_reactions']);
    $other_notes = mysqli_real_escape_string($conn, $_POST['other_notes']);
    
    // Handle photo upload
    $photo = $patient['photo'];
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $target_dir = "../../uploads/patient-form/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
        $photo = basename($_FILES["photo"]["name"]);
    }
    
    $sql =  mysqli_query($conn, "UPDATE patient_info SET
            last_name = '$last_name',
            first_name = '$first_name',
            middle_name = '$middle_name',
            nickname = '$nickname',
            gender = '$gender',
            sex = '$gender',
            birthday = '$birthday',
            date_of_birth = '$birthday',
            occupation = '$occupation',
            phone = '$phone',
            email = '$email',
            referred_by = '$referred_by',
            other_mds = '$other_mds',
            NoBldgName = '$NoBldgName',
            StreetName = '$StreetName',
            psgc_barangay = '$psgc_barangay',
            psgc_municipality = '$psgc_municipality',
            psgc_province = '$psgc_province',
            psgc_region = '$psgc_region',
            ZipCode = '$ZipCode',
                photo = '$photo' 
              WHERE id = $patient_id");

       /*   $sql =  "UPDATE patient_details SET
             family_history = '$family_medical_history',
                smoker = '$smoking_history',
                social_history = '$social_history',
                alcohol_history = '$alcohol_history',
                immunization_history = '$immunization_history',
                diabetes_history = '$diabetes_history',
                hypertension_history = '$hypertension_history',
                cancer_history = '$cancer_history',
                goiter_history = '$goiter_history',
                menstrual_history = '$menstrual_history',      
                diagnosis = '$diagnosis',
                adverse_drug_reactions = '$adverse_drug_reactions',
                other_notes = '$other_notes'     
                WHERE user_id = '$user_id'";

                
    
    if (mysqli_query($conn, $sql)) { */
        header("Location: view_patient.php?id=$patient_id&message=Patient updated successfully");
  /*  } else {
        $error = "Error updating record: " . mysqli_error($conn);
    } */
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Patient</title>
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
            background: #e74c3c;
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
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Patient: <?php echo $patient['last_name'] . ', ' . $patient['first_name']; ?></h1>
        
        <?php if (isset($error)): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="post" action="edit_patient.php?id=<?php echo $patient_id; ?>" enctype="multipart/form-data">
            <div class="section">
                <h2>Basic Information</h2>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="last_name">Last Name</label>
                            <input type="text" id="last_name" name="last_name" required value="<?php echo $patient['last_name']; ?>">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="first_name">First Name</label>
                            <input type="text" id="first_name" name="first_name" required value="<?php echo $patient['first_name']; ?>">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="middle_name">Middle Name</label>
                            <input type="text" id="middle_name" name="middle_name" value="<?php echo $patient['middle_name']; ?>">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="nickname">Nickname</label>
                            <input type="text" id="nickname" name="nickname" value="<?php echo $patient['nickname']; ?>">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="gender">Gender</label>
                            <select id="gender" name="gender" required>
                                <option value="Male" <?php echo $patient['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                                <option value="Female" <?php echo $patient['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                                <option value="Other" <?php echo $patient['gender'] == 'Other' ? 'selected' : ''; ?>>Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="birthday">Birthdate</label>
                            <input type="date" id="birthday" name="birthday" required value="<?php echo $patient['birthday']; ?>">
                        </div>
                    </div>
                </div>
                
                <div class="form-group">
                    <label for="occupation">Occupation</label>
                    <input type="text" id="occupation" name="occupation" value="<?php echo $patient['occupation']; ?>">
                </div>
                
                <div class="form-group">
                    <label for="photo">Photo</label>
                    <input type="file" id="photo" name="photo">
                    <?php if ($patient['photo']): ?>
                        <img src="../../uploads/patient-form/<?php echo $patient['photo']; ?>" class="photo-preview">
                    <?php endif; ?>
                </div>
            </div>
            
            <div class="section">
                <h2>Contact Information</h2>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="phone">Phone Number</label>
                            <input type="tel" id="phone" name="phone" value="<?php echo $patient['phone']; ?>">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="<?php echo $patient['email']; ?>">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col" style="display: none;">
                        <div class="form-group">
                            <label for="referred_by">Referred By</label>
                            <input type="text" id="referred_by" name="referred_by" value="<?php echo $patient['referred_by']; ?>">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="other_mds">Other MDs</label>
                            <input type="text" id="other_mds" name="other_mds" value="<?php echo $patient['other_mds']; ?>">
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
                            <input type="text" id="NoBldgName" name="NoBldgName" value="<?php echo $patient['NoBldgName']; ?>">
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="StreetName">Street Name</label>
                            <input type="text" id="StreetName" name="StreetName" value="<?php echo $patient['StreetName']; ?>">
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="psgc_barangay">Barangay</label>
                            <input type="text" id="psgc_barangay" name="psgc_barangay" 
                            value="<?php echo substr($patient['psgc_barangay'], (strpos($patient['psgc_barangay'], '~') ?: -1) + 1); ?>">
 
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="psgc_municipality">Municipality/City</label>
                            <input type="text" id="psgc_municipality" name="psgc_municipality"
                             value="<?php echo substr($patient['psgc_municipality'], (strpos($patient['psgc_municipality'], '~') ?: -1) + 1); ?>">

                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="psgc_province">Province</label>
                            <input type="text" id="psgc_province" name="psgc_province" 
                            value="<?php echo substr($patient['psgc_province'], (strpos($patient['psgc_province'], '~') ?: -1) + 1); ?>">

                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="psgc_region">Region</label>
                            <input type="text" id="psgc_region" name="psgc_region" 
                             value="<?php echo substr($patient['psgc_region'], (strpos($patient['psgc_region'], '~') ?: -1) + 1); ?>">

                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="ZipCode">Zip Code</label>
                            <input type="text" id="ZipCode" name="ZipCode" value="<?php echo $patient['ZipCode']; ?>">
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="section" style="display: none;">
                <h2>Medical History</h2>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="family_medical_history">Family Medical History (FMHx)</label>
                            <textarea id="family_medical_history" name="family_medical_history"><?php echo $patient_details['family_history'] ?? 'N/A'; ?></textarea>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="smoking_history">Smoking History</label>

                            <?php
                            $smoker='';
                            if(isset($patient_details['smoker'])) {

                                $smoker.=$patient_details['smoker'];
                            }

                            if(isset($patient_details['pack_per_day'])) {

                                $smoker.=$patient_details['pack_per_day'].' pack/day';
                            }


                            if(isset($patient_details['years_smoking'])) {

                                $smoker.=$patient_details['years_smoking'].' years';
                            }



                            ?>
                            <textarea id="smoking_history" name="smoking_history"><?php echo $smoker ?></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="social_history">Social History (SHx)</label>
                            <textarea id="social_history" name="social_history"><?php echo $patient_details['social_history'] ?? 'N/A'; ?></textarea>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="alcohol_history">Alcohol History</label>
                            <textarea id="alcohol_history" name="alcohol_history"><?php echo $patient_details['alcohol_history'] ?? 'N/A' ?></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="immunization_history">Immunization History</label>
                            <textarea id="immunization_history" name="immunization_history"><?php echo $patient_details['immunization_history'] ?? 'N/A'; ?></textarea>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="diabetes_history">Diabetes History (DM)</label>
                            <textarea id="diabetes_history" name="diabetes_history"><?php echo $patient_details['diabetes_history'] ?? 'N/A'; ?></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="hypertension_history">Hypertension History (HTN)</label>
                            <textarea id="hypertension_history" name="hypertension_history"><?php echo $patient_details['hypertension_history'] ?? 'N/A'; ?></textarea>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="cancer_history">Cancer History</label>
                            <textarea id="cancer_history" name="cancer_history"><?php echo $patient_details['cancer_history'] ?? 'N/A'; ?></textarea>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="goiter_history">Goiter History</label>
                            <textarea id="goiter_history" name="goiter_history"><?php echo $patient_details['goiter_history'] ?? 'N/A'; ?></textarea>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="menstrual_history">OB Menstrual History</label>
                            <textarea id="menstrual_history" name="menstrual_history"><?php echo $patient_details['menstrual_history'] ?? 'N/A'; ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            
            
            
            <div class="section"  style="display: none;">
             <!--   <h2>Diagnosis and Notes</h2> -->
               <div class="form-group" style="display: none;">
                    <label for="diagnosis">Diagnosis</label>
                    <textarea id="diagnosis" name="diagnosis"><?php echo $patient_details['diagnosis'] ?? 'N/A'; ?></textarea>
                </div>  
                
              
                
                <div class="form-group">
                    <label for="adverse_drug_reactions">Adverse Drug Reactions</label>
                    <textarea id="adverse_drug_reactions" name="adverse_drug_reactions"><?php echo $patient_details['adverse_drug_reactions'] ?? 'N/A'; ?></textarea>
                </div>
                
                <div class="form-group" style="display: none;">
                    <label for="other_notes">Other Notes</label>
                    <textarea id="other_notes" name="other_notes"><?php echo $patient_details['other_notes'] ?? 'N/A'; ?></textarea>
                </div>
            </div>
            
            <div class="action-buttons">
                <button type="submit" class="btn btn-save">Save Changes</button>
                <a href="view_patient.php?id=<?php echo $patient_id; ?>" class="btn btn-cancel">Cancel</a>
            </div>
        </form>
    </div>
</body>
</html>