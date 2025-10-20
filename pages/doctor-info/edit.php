<?php
include 'db.php';
$message = "";
$id = ""; // This is now the auto-increment `id`

// Check if ID is set in URL
if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // Fetch existing data using the `id`
    $sql = "SELECT * FROM doctor_info WHERE id = '$id'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
    } else {
        $message = "Error: Doctor not found.";
        $row = null; // No data to show
    }
}

// Handle form submission for UPDATE
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get ID from hidden form field
    $id = mysqli_real_escape_string($conn, $_POST['id']);
    
    // Get all other data
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
    
    // Get current photo name from hidden field
    $current_photo = mysqli_real_escape_string($conn, $_POST['current_photo']);
    $photo_name = $current_photo; // Default to old photo

    // File upload logic (same as before)
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0 && !empty($_FILES['photo']['name'])) {
        $target_dir = "../../uploads/";
        $photo_name = time() . '_' . basename($_FILES["photo"]["name"]);
        $target_file = $target_dir . $photo_name;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        $check = getimagesize($_FILES["photo"]["tmp_name"]);
        if ($check !== false) {
            if ($_FILES["photo"]["size"] <= 5000000) {
                if (in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
                    if (move_uploaded_file($_FILES["photo"]["tmp_name"], $target_file)) {
                        if (!empty($current_photo) && file_exists($target_dir . $current_photo)) {
                            unlink($target_dir . $current_photo);
                        }
                    } else {
                        $message = "Error: Sorry, there was an error uploading your new file.";
                        $photo_name = $current_photo; 
                    }
                } else {
                    $message = "Error: Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
                    $photo_name = $current_photo;
                }
            } else {
                $message = "Error: Sorry, your file is too large.";
                $photo_name = $current_photo;
            }
        } else {
            $message = "Error: File is not an image.";
            $photo_name = $current_photo;
        }
    }

    // Only update if there was no new upload error
    if (empty($message)) {
        // Update query now uses `id` in the WHERE clause
        $sql = "UPDATE doctor_info SET 
                    suffix = '$suffix', 
                    last_name = '$last_name', 
                    first_name = '$first_name', 
                    middle_name = '$middle_name', 
                    specialists = '$specialists', 
                    address = '$address', 
                    phone = '$phone', 
                    sex = '$sex', 
                    email = '$email', 
                    birthday = '$birthday', 
                    photo = '$photo_name' 
                WHERE id = '$id'"; // Use the `id`
        
        if (mysqli_query($conn, $sql)) {
            header("Location: index.php?msg=" . urlencode("Doctor profile updated successfully!"));
            exit();
        } else {
            if (mysqli_errno($conn) == 1062) {
                $message = "Error: A doctor with this Email already exists.";
            } else {
                $message = "Error updating record: " . mysqli_error($conn);
            }
        }
    }
    
    // Refetch data after failed update to show correct form values
    $sql_refetch = "SELECT * FROM doctor_info WHERE id = '$id'";
    $result_refetch = mysqli_query($conn, $sql_refetch);
    $row = mysqli_fetch_assoc($result_refetch);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Doctor Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .card-header { background-color: #007bff; color: white; }
        .current-photo { max-width: 150px; height: auto; border-radius: 8px; border: 1px solid #ddd; margin-top: 10px; }
    </style>
</head>
<body>

    <div class="container mt-5 mb-5" style="max-width: 900px;">
        <div class="card shadow-sm">
            <div class="card-header">
                <h4 class="mb-0"><i class="fas fa-edit"></i> Edit Doctor Profile</h4>
            </div>
            <div class="card-body">

                <?php if (!empty($message)): ?>
                    <div class="alert alert-danger"><?php echo $message; ?></div>
                <?php endif; ?>

                <?php if ($row): // Only show form if doctor was found ?>
                <form action="edit.php?id=<?php echo urlencode($id); ?>" method="POST" enctype="multipart/form-data" class="row g-3">
                    
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
                    <input type="hidden" name="current_photo" value="<?php echo htmlspecialchars($row['photo']); ?>">

                    <div class="col-md-12">
                        <label for="user_id_display" class="form-label"><b>Doctor ID</b></label>
                        <input type="text" class="form-control" id="user_id_display" value="<?php echo htmlspecialchars($row['user_id']); ?>" disabled readonly>
                        <small class="form-text text-muted">Doctor ID is auto-generated and cannot be changed.</small>
                    </div>

                    <div class="col-md-5">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($row['first_name']); ?>" required>
                    </div>
                    <div class="col-md-5">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($row['last_name']); ?>" required>
                    </div>
                    <div class="col-md-2">
                        <label for="suffix" class="form-label">Suffix</label>
                        <input type="text" class="form-control" id="suffix" name="suffix" value="<?php echo htmlspecialchars($row['suffix']); ?>">
                    </div>
                    
                    <div class="col-md-6">
                        <label for="middle_name" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?php echo htmlspecialchars($row['middle_name']); ?>">
                    </div>
                     <div class="col-md-6">
                        <label for="specialists" class="form-label">Specialty</label>
                        <input type="text" class="form-control" id="specialists" name="specialists" value="<?php echo htmlspecialchars($row['specialists']); ?>">
                    </div>

                    <div class="col-md-6">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($row['email']); ?>">
                    </div>
                     <div class="col-md-6">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($row['phone']); ?>">
                    </div>

                    <div class="col-md-6">
                        <label for="birthday" class="form-label">Birthday</label>
                        <input type="date" class="form-control" id="birthday" name="birthday" value="<?php echo htmlspecialchars($row['birthday']); ?>">
                    </div>
                    <div class="col-md-6">
                        <label for="sex" class="form-label">Sex</label>
                        <select id="sex" name="sex" class="form-select">
                            <option value="" <?php echo ($row['sex'] == '') ? 'selected' : ''; ?>>Choose...</option>
                            <option value="Male" <?php echo ($row['sex'] == 'Male') ? 'selected' : ''; ?>>Male</option>
                            <option value="Female" <?php echo ($row['sex'] == 'Female') ? 'selected' : ''; ?>>Female</option>
                            <option value="Other" <?php echo ($row['sex'] == 'Other') ? 'selected' : ''; ?>>Other</option>
                        </select>
                    </div>

                    <div class="col-12">
                        <label for="address" class="form-label">Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3"><?php echo htmlspecialchars($row['address']); ?></textarea>
                    </div>
                    
                    <div class="col-12">
                        <label for="photo" class="form-label">Change Photo</label>
                        <input type="file" class="form-control" id="photo" name="photo">
                        <small class="form-text text-muted">Leave blank to keep the current photo.</small>
                        <?php if (!empty($row['photo']) && file_exists("../../uploads/" . $row['photo'])): ?>
                            <div class="mt-2">
                                <img src="../../uploads/<?php echo htmlspecialchars($row['photo']); ?>" alt="Current Photo" class="current-photo">
                                <p class="mb-0"><small>Current Photo</small></p>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="col-12 mt-4">
                        <button type="submit" class="btn btn-primary me-2"><i class="fas fa-sync-alt"></i> Update Profile</button>
                        <a href="index.php" class="btn btn-secondary"><i class="fas fa-times"></i> Cancel</a>
                    </div>
                </form>
                <?php else: ?>
                    <p>Doctor not found. <a href="index.php">Go back to list.</a></p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</body>
</html>