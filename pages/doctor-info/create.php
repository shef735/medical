<?php
include 'db.php';
$message = "";

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Get data from form
    $suffix = mysqli_real_escape_string($conn, $_POST['suffix']);
    $last_name = mysqli_real_escape_string($conn, $_POST['last_name']);
    $first_name = mysqli_real_escape_string($conn, $_POST['first_name']);
    $middle_name = mysqli_real_escape_string($conn, $_POST['middle_name']);
    $specialists = mysqli_real_escape_string($conn, $_POST['specialists']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $sex = mysqli_real_escape_string($conn, $_POST['sex']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $birthday = mysqli_real_escape_string($conn, $_POST['birthday']);
    
    $photo_name = "";
    
    // File upload logic (happens first)
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
        $target_dir = "../../uploads/";
        $photo_name = time() . '_' . basename($_FILES["photo"]["name"]);
        $target_file = $target_dir . $photo_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if ($check !== false) {
            if ($_FILES["photo"]["size"] <= 5000000) {
                if (in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
                    if (!move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                        $message = "Error: Sorry, there was an error uploading your file.";
                    }
                } else {
                    $message = "Error: Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                }
            } else {
                $message = "Error: Sorry, your file is too large.";
            }
        } else {
            $message = "Error: File is not an image.";
        }
    }

    // Only proceed if file upload was successful (or no file was uploaded)
    if (empty($message)) {
        
        // --- Step 1: INSERT the doctor info (without user_id) ---
        $sql_insert = "INSERT INTO doctor_info (suffix, last_name, first_name, middle_name, specialists, address, phone, sex, email, birthday, photo) 
                       VALUES ('$suffix', '$last_name', '$first_name', '$middle_name', '$specialists', '$address', '$phone', '$sex', '$email', '$birthday', '$photo_name')";
        
        if (mysqli_query($conn, $sql_insert)) {
            
            // --- Step 2: Get the new auto-increment `id` ---
            $new_auto_increment_id = mysqli_insert_id($conn);
            
            // --- Step 3: Generate the new `user_id` code ---
            // Format: "DR-" followed by the ID, padded with zeros to 5 digits (e.g., DR-00001, DR-00123)
            $new_user_id_code = "DR-" . str_pad($new_auto_increment_id, 5, '0', STR_PAD_LEFT);

            // --- Step 4: UPDATE the record with the new code ---
            $sql_update = "UPDATE doctor_info 
                           SET user_id = '$new_user_id_code' 
                           WHERE id = $new_auto_increment_id";
                           
            if (mysqli_query($conn, $sql_update)) {
                // Success! Redirect to index page.
                header("Location: index.php?msg=" . urlencode("New doctor added with ID: $new_user_id_code"));
                exit();
            } else {
                // This is bad, the user was created but the ID was not set.
                // For a real app, you'd handle this (e.g., delete the user record).
                $message = "Error setting doctor ID: " . mysqli_error($conn);
            }
            
        } else {
            // Check for duplicate email
            if (mysqli_errno($conn) == 1062) {
                $message = "Error: A doctor with this Email already exists.";
            } else {
                $message = "Error creating record: " . mysqli_error($conn);
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Doctor</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .card-header { background-color: #28a745; color: white; }
    </style>
</head>
<body>
    <div class="container mt-5 mb-5" style="max-width: 900px;">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-plus-circle"></i> Add New Doctor Profile</h4>
            </div>
            <div class="card-body">

                <?php if (!empty($message)): ?>
                    <div class="alert alert-danger"><?php echo $message; ?></div>
                <?php endif; ?>

                <form action="create.php" method="POST" enctype="multipart/form-data" class="row g-3">
                    
                    <div class="col-md-5">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" required>
                    </div>
                    <div class="col-md-5">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" required>
                    </div>
                    <div class="col-md-2">
                        <label for="suffix" class="form-label">Suffix (e.g., Jr., MD)</label>
                        <input type="text" class="form-control" id="suffix" name="suffix">
                    </div>
                    
                    <div class="col-md-6">
                        <label for="middle_name" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="middle_name" name="middle_name">
                    </div>
                     <div class="col-md-6">
                        <label for="specialists" class="form-label">Specialty (e.g., Cardiology)</label>
                        <input type="text" class="form-control" id="specialists" name="specialists">
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                     <div class="col-md-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" class="form-control" id="phone" name="phone">
                    </div>

                    <div class="col-md-4">
                        <label for="birthday" class="form-label">Birthday</label>
                        <input type="date" class="form-control" id="birthday" name="birthday">
                    </div>
                    <div class="col-md-4">
                        <label for="sex" class="form-label">Sex</label>
                        <select id="sex" name="sex" class="form-select">
                            <option value="" selected>Choose...</option>
                            <option value="Male">Male</option>
                            <option value="Female">Female</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label for="photo" class="form-label">Photo</label>
                        <input type="file" class="form-control" id="photo" name="photo">
                    </div>

                    <div class="col-12">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3"></textarea>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-success me-2"><i class="fas fa-save"></i> Save Doctor</button>
                        <a href="index.php" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>