<?php
include 'config.php';

if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$id = $_GET['id'];
$sql = "SELECT * FROM patient_info WHERE id = $id";
$result = mysqli_query($conn, $sql);
$patient = mysqli_fetch_assoc($result);

if (!$patient) {
    header("Location: index.php");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare data
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $gender = mysqli_real_escape_string($conn, $_POST['gender']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
    $height_cm = mysqli_real_escape_string($conn, $_POST['height_cm']);
    $weight_kg = mysqli_real_escape_string($conn, $_POST['weight_kg']);
    $blood_group = mysqli_real_escape_string($conn, $_POST['blood_group']);
    $civil_status = mysqli_real_escape_string($conn, $_POST['civil_status']);
    $psgc_barangay = mysqli_real_escape_string($conn, $_POST['psgc_barangay']);
    $psgc_municipality = mysqli_real_escape_string($conn, $_POST['psgc_municipality']);
    $psgc_province = mysqli_real_escape_string($conn, $_POST['psgc_province']);
    $psgc_region = mysqli_real_escape_string($conn, $_POST['psgc_region']);
    $ZipCode = mysqli_real_escape_string($conn, $_POST['ZipCode']);
    $NoBldgName = mysqli_real_escape_string($conn, $_POST['NoBldgName']);
    $StreetName = mysqli_real_escape_string($conn, $_POST['StreetName']);
    
    // Calculate BMI
    $bmi =0;
   if((float)$weight_kg>0) { 
     $bmi = $weight_kg / (($height_cm/100) * ($height_cm/100));
   }

    // Handle file upload
    $photo = $patient['photo'];
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $target_dir = "../../uploads/patient-form/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
        $photo =  basename($_FILES["photo"]["name"]);;
    }
    
    // Update query
    $sql = "UPDATE patient_info SET 
        last_name = '$last_name',
        first_name = '$first_name',
        middle_name = '$middle_name',
        address = '$address',
        phone = '$phone',
        sex = '$gender',
        gender = '$gender',
        email = '$email',
        birthday = '$birthday',
        date_of_birth = '$birthday',
        height_cm = '$height_cm',
        weight_kg = '$weight_kg',
        blood_group = '$blood_group',
        civil_status = '$civil_status',
        psgc_barangay = '$psgc_barangay',
        psgc_municipality = '$psgc_municipality',
        psgc_province = '$psgc_province',
        psgc_region = '$psgc_region',
        ZipCode = '$ZipCode',
        NoBldgName = '$NoBldgName',
        StreetName = '$StreetName',
        photo = '$photo',
        bmi = '$bmi'
        WHERE id = $id";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: view.php?id=$id&message=Patient updated successfully");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>
 

 <!DOCTYPE html>
<html>
<head>
    <title>Edit Patient</title>
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --accent-color: #e74c3c;
            --light-gray: #f5f5f5;
            --medium-gray: #e0e0e0;
            --dark-gray: #333;
            --white: #fff;
            --success-color: #2ecc71;
            --warning-color: #f39c12;
            --border-radius: 4px;
            --box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background-color: #f8f9fa;
            color: var(--dark-gray);
            line-height: 1.6;
            padding: 20px;
        }

        .container {
            max-width: 1000px;
            margin: 0 auto;
            background: var(--white);
            padding: 30px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }

        h2 {
            color: var(--primary-color);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--medium-gray);
        }

        .form-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-row {
            display: flex;
            flex-wrap: wrap;
            margin: 0 -15px;
        }

        .form-col {
            flex: 1;
            min-width: 250px;
            padding: 0 15px;
            margin-bottom: 15px;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #555;
        }

        input[type="text"],
        input[type="email"],
        input[type="date"],
        input[type="number"],
        input[type="tel"],
        select {
            width: 100%;
            padding: 10px 15px;
            border: 1px solid var(--medium-gray);
            border-radius: var(--border-radius);
            font-size: 16px;
            transition: border-color 0.3s;
        }

        input:focus,
        select:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }

        .photo-upload {
            display: flex;
            align-items: center;
            gap: 20px;
        }

        .current-photo {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--medium-gray);
        }

        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: var(--primary-color);
            color: var(--white);
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-size: 16px;
            font-weight: 600;
            text-align: center;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: var(--secondary-color);
        }

        .btn-cancel {
            background-color: var(--medium-gray);
            color: var(--dark-gray);
            margin-left: 10px;
        }

        .btn-cancel:hover {
            background-color: #d0d0d0;
        }

        .form-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--medium-gray);
        }

        .required-field::after {
            content: " *";
            color: var(--accent-color);
        }

        @media (max-width: 768px) {
            .form-col {
                flex: 100%;
            }
            
            .form-actions {
                flex-direction: column;
                gap: 10px;
            }
            
            .btn, .btn-cancel {
                width: 100%;
                margin-left: 0;
            }
        }

        /* Status message styling */
        .status-message {
            padding: 10px 15px;
            margin-bottom: 20px;
            border-radius: var(--border-radius);
            font-weight: 500;
        }

        .success {
            background-color: rgba(46, 204, 113, 0.2);
            color: var(--success-color);
            border-left: 4px solid var(--success-color);
        }

        .error {
            background-color: rgba(231, 76, 60, 0.2);
            color: var(--accent-color);
            border-left: 4px solid var(--accent-color);
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="form-header">
            <h2>Edit Patient Information</h2>
        </div>

        <?php if (isset($_GET['message'])): ?>
            <div class="status-message success">
                <?php echo htmlspecialchars($_GET['message']); ?>
            </div>
        <?php endif; ?>

        <form method="post" action="edit.php?id=<?php echo $id; ?>" enctype="multipart/form-data">
            <div class="form-row">
                <div class="form-col">
                    <label class="required-field">Last Name</label>
                    <input type="text" name="last_name" value="<?php echo htmlspecialchars($patient['last_name']); ?>" required>
                </div>
                <div class="form-col">
                    <label class="required-field">First Name</label>
                    <input type="text" name="first_name" value="<?php echo htmlspecialchars($patient['first_name']); ?>" required>
                </div>
                <div class="form-col">
                    <label>Middle Name</label>
                    <input type="text" name="middle_name" value="<?php echo htmlspecialchars($patient['middle_name']); ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <label class="required-field">Gender</label>
                    <select name="gender" required>
                        <option value="Male" <?php echo $patient['gender'] == 'Male' ? 'selected' : ''; ?>>Male</option>
                        <option value="Female" <?php echo $patient['gender'] == 'Female' ? 'selected' : ''; ?>>Female</option>
                        <option value="Other" <?php echo $patient['gender'] == 'Other' ? 'selected' : ''; ?>>Other</option>
                    </select>
                </div>
                <div class="form-col">
                    <label class="required-field">Birthday</label>
                    <input type="date" name="birthday" value="<?php echo $patient['birthday']; ?>" required>
                </div>
                <div class="form-col">
                    <label class="required-field">Civil Status</label>
                    <select name="civil_status">
                        <option value="Single" <?php echo $patient['civil_status'] == 'Single' ? 'selected' : ''; ?>>Single</option>
                        <option value="Married" <?php echo $patient['civil_status'] == 'Married' ? 'selected' : ''; ?>>Married</option>
                        <option value="Divorced" <?php echo $patient['civil_status'] == 'Divorced' ? 'selected' : ''; ?>>Divorced</option>
                        <option value="Widowed" <?php echo $patient['civil_status'] == 'Widowed' ? 'selected' : ''; ?>>Widowed</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <label class="required-field">Email</label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($patient['email']); ?>" required>
                </div>
                <div class="form-col">
                    <label class="required-field">Phone</label>
                    <input type="tel" name="phone" value="<?php echo htmlspecialchars($patient['phone']); ?>" required>
                </div>
                <div class="form-col">
                    <label>Blood Group</label>
                    <select name="blood_group">
                        <option value="A+" <?php echo $patient['blood_group'] == 'A+' ? 'selected' : ''; ?>>A+</option>
                        <option value="A-" <?php echo $patient['blood_group'] == 'A-' ? 'selected' : ''; ?>>A-</option>
                        <option value="B+" <?php echo $patient['blood_group'] == 'B+' ? 'selected' : ''; ?>>B+</option>
                        <option value="B-" <?php echo $patient['blood_group'] == 'B-' ? 'selected' : ''; ?>>B-</option>
                        <option value="AB+" <?php echo $patient['blood_group'] == 'AB+' ? 'selected' : ''; ?>>AB+</option>
                        <option value="AB-" <?php echo $patient['blood_group'] == 'AB-' ? 'selected' : ''; ?>>AB-</option>
                        <option value="O+" <?php echo $patient['blood_group'] == 'O+' ? 'selected' : ''; ?>>O+</option>
                        <option value="O-" <?php echo $patient['blood_group'] == 'O-' ? 'selected' : ''; ?>>O-</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <label class="required-field">Height (cm)</label>
                    <input type="number" name="height_cm" step="0.1" value="<?php echo $patient['height_cm']; ?>" required>
                </div>
                <div class="form-col">
                    <label class="required-field">Weight (kg)</label>
                    <input type="number" name="weight_kg" step="0.1" value="<?php echo $patient['weight_kg']; ?>" required>
                </div>
                <div class="form-col">
                    <label>BMI</label>
                    <?php 
                     $bmi_val=0;
                            if((float)$patient['weight_kg']>0 AND (float)$patient['height_cm']>0){                  
                              $bmi_val=number_format((float)$patient['weight_kg'] / (((float)$patient['height_cm']/100) * ((float)$patient['height_cm']/100)), 2); 
                            }
                        ?>
                    <input type="text" value="<?php echo $bmi_val ?>" readonly>
                </div>
            </div>

            <div class="form-group">
                <label class="required-field">Address</label>
                <input type="text" name="address" value="<?php echo htmlspecialchars($patient['address']); ?>" required>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <label>No/Bldg Name</label>
                    <input type="text" name="NoBldgName" value="<?php echo htmlspecialchars($patient['NoBldgName']); ?>">
                </div>
                <div class="form-col">
                    <label>Street Name</label>
                    <input type="text" name="StreetName" value="<?php echo htmlspecialchars($patient['StreetName']); ?>">
                </div>
                <div class="form-col">
                    <label>Barangay</label>
                    <input type="text" name="psgc_barangay" value="<?php echo htmlspecialchars($patient['psgc_barangay']); ?>">
                </div>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <label>Municipality</label>
                    <input type="text" name="psgc_municipality" value="<?php echo htmlspecialchars($patient['psgc_municipality']); ?>">
                </div>
                <div class="form-col">
                    <label>Province</label>
                    <input type="text" name="psgc_province" value="<?php echo htmlspecialchars($patient['psgc_province']); ?>">
                </div>
                <div class="form-col">
                    <label>Region</label>
                    <input type="text" name="psgc_region" value="<?php echo htmlspecialchars($patient['psgc_region']); ?>">
                </div>
            </div>

            <div class="form-col">
                <label>Zip Code</label>
                <input type="text" name="ZipCode" value="<?php echo htmlspecialchars($patient['ZipCode']); ?>">
            </div>

            <div class="form-group">
                <label>Photo</label>
                <div class="photo-upload">
                    <?php if ($patient['photo']): ?>
                        <img src="../../uploads/patient-form/<?php echo $patient['photo']; ?>" class="current-photo" alt="Current Patient Photo">
                    <?php endif; ?>
                    <input type="file" name="photo">
                </div>
            </div>

            <div class="form-actions">
                <a href="../lab_system/dashboard.php" class="btn btn-cancel">Cancel</a>
                <button type="submit" class="btn">Update Patient</button>
            </div>
        </form>
    </div>
</body>
</html>