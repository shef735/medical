<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Generate patient code
    $patient_code = generatePatientCode($conn);
    
    // Prepare data
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
    $password = password_hash(mysqli_real_escape_string($conn, $_POST['password']), PASSWORD_DEFAULT);
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
    $bmi = $weight_kg / (($height_cm/100) * ($height_cm/100));
    
    // Handle file upload
    $photo = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $target_dir = "../patient-form/uploads/";
        $target_file = $target_dir . basename($_FILES["photo"]["name"]);
        move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file);
        $photo = $target_file;
    }
    
    // Insert query
    $sql = "INSERT INTO patient_info (
        patient_id, patient_code, user_id, last_name, first_name, middle_name, 
        password, address, phone, sex, gender, email, birthday, date_of_birth, 
        height_cm, weight_kg, blood_group, civil_status, psgc_barangay, 
        psgc_municipality, psgc_province, psgc_region, ZipCode, NoBldgName, 
        StreetName, photo, bmi, created_at
    ) VALUES (
        NULL, '$patient_code', '$patient_code', '$last_name', '$first_name', '$middle_name', 
        '$password', '$address', '$phone', '$gender', '$gender', '$email', '$birthday', '$birthday', 
        '$height_cm', '$weight_kg', '$blood_group', '$civil_status', '$psgc_barangay', 
        '$psgc_municipality', '$psgc_province', '$psgc_region', '$ZipCode', '$NoBldgName', 
        '$StreetName', '$photo', '$bmi', NOW()
    )";
    
    if (mysqli_query($conn, $sql)) {
        $patient_id = mysqli_insert_id($conn);
        // Update patient_id with the auto-increment ID
        mysqli_query($conn, "UPDATE patient_info SET patient_id = $patient_id WHERE id = $patient_id");
        header("Location: index.php?message=Patient added successfully");
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add New Patient</title>
</head>
<body>
    <h2>Add New Patient</h2>
    <form method="post" action="create.php" enctype="multipart/form-data">
        <!-- Form fields would go here -->
        <label>Last Name: <input type="text" name="last_name" required></label><br>
        <label>First Name: <input type="text" name="first_name" required></label><br>
        <label>Middle Name: <input type="text" name="middle_name"></label><br>
        <label>Password: <input type="password" name="password" required></label><br>
        <label>Address: <input type="text" name="address" required></label><br>
        <label>Phone: <input type="text" name="phone" required></label><br>
        <label>Gender:
            <select name="gender" required>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
                <option value="Other">Other</option>
            </select>
        </label><br>
        <label>Email: <input type="email" name="email" required></label><br>
        <label>Birthday: <input type="date" name="birthday" required></label><br>
        <label>Height (cm): <input type="number" name="height_cm" step="0.1" required></label><br>
        <label>Weight (kg): <input type="number" name="weight_kg" step="0.1" required></label><br>
        <label>Blood Group:
            <select name="blood_group">
                <option value="A+">A+</option>
                <option value="A-">A-</option>
                <option value="B+">B+</option>
                <option value="B-">B-</option>
                <option value="AB+">AB+</option>
                <option value="AB-">AB-</option>
                <option value="O+">O+</option>
                <option value="O-">O-</option>
            </select>
        </label><br>
        <label>Civil Status:
            <select name="civil_status">
                <option value="Single">Single</option>
                <option value="Married">Married</option>
                <option value="Divorced">Divorced</option>
                <option value="Widowed">Widowed</option>
            </select>
        </label><br>
        <label>Photo: <input type="file" name="photo"></label><br>
        <!-- Add more fields as needed -->
        <button type="submit">Add Patient</button>
    </form>
    <a href="index.php">Back to List</a>
</body>
</html>