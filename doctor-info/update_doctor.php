<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $sql = "SELECT * FROM doctor_info WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $doctor = $result->fetch_assoc();
    $stmt->close();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    
    // Handle photo upload
    $photoPath = $_POST['existing_photo'];
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        $fileName = basename($_FILES["photo"]["name"]);
        $targetFilePath = $targetDir . $user_id . '_' . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath)) {
                // Delete old photo if exists
                if ($photoPath && file_exists($photoPath)) {
                    unlink($photoPath);
                }
                $photoPath = $targetFilePath;
            }
        }
    }

    // Prepare and bind
    $stmt = $conn->prepare("UPDATE doctor_info SET suffix=?, last_name=?, first_name=?, middle_name=?, specialists=?, address=?, phone=?, sex=?, email=?, birthday=?, photo=? WHERE user_id=?");
    $stmt->bind_param("sssssssssssi", $suffix, $last_name, $first_name, $middle_name, $specialists, $address, $phone, $sex, $email, $birthday, $photoPath, $user_id);
    
    // Set parameters and execute
    $suffix = $_POST['suffix'];
    $last_name = $_POST['last_name'];
    $first_name = $_POST['first_name'];
    $middle_name = $_POST['middle_name'];
    $specialists = $_POST['specialists'];
    $address = $_POST['address'];
    $phone = $_POST['phone'];
    $sex = $_POST['sex'];
    $email = $_POST['email'];
    $birthday = $_POST['birthday'];
    
    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Doctor record updated successfully";
    } else {
        $_SESSION['error_message'] = "Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Doctor Information</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .update-card {
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.1);
            border: none;
        }
        .form-header {
            background-color: #0d6efd;
            color: white;
            border-radius: 15px 15px 0 0 !important;
        }
        .form-control:focus {
            border-color: #0d6efd;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }
        .btn-update {
            background-color: #0d6efd;
            border: none;
            padding: 10px 25px;
            font-weight: 600;
        }
        .btn-update:hover {
            background-color: #0b5ed7;
        }
        .required-field::after {
            content: "*";
            color: red;
            margin-left: 4px;
        }
        .current-photo {
            max-width: 150px;
            border-radius: 5px;
            margin-bottom: 10px;
            border: 2px solid #dee2e6;
        }
        .photo-container {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card update-card">
                    <div class="card-header form-header py-3">
                        <h3 class="mb-0 text-center"><i class="fas fa-user-md me-2"></i>Update Doctor Information</h3>
                    </div>
                    <div class="card-body p-4">
                        <?php if (isset($doctor)): ?>
                        <form action="update_doctor.php" method="post" enctype="multipart/form-data">
                            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($doctor['user_id']); ?>">
                            <input type="hidden" name="existing_photo" value="<?php echo htmlspecialchars($doctor['photo']); ?>">
                            
                            <div class="row g-3">
                                <div class="col-md-2">
                                    <label for="suffix" class="form-label">Suffix</label>
                                    <select class="form-select" id="suffix" name="suffix">
                                        <option value="">None</option>
                                        <option value="Dr." <?php echo ($doctor['suffix'] == 'Dr.') ? 'selected' : ''; ?>>Dr.</option>
                                        <option value="Prof." <?php echo ($doctor['suffix'] == 'Prof.') ? 'selected' : ''; ?>>Prof.</option>
                                        <option value="Mr." <?php echo ($doctor['suffix'] == 'Mr.') ? 'selected' : ''; ?>>Mr.</option>
                                        <option value="Mrs." <?php echo ($doctor['suffix'] == 'Mrs.') ? 'selected' : ''; ?>>Mrs.</option>
                                        <option value="Ms." <?php echo ($doctor['suffix'] == 'Ms.') ? 'selected' : ''; ?>>Ms.</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-5">
                                    <label for="last_name" class="form-label required-field">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($doctor['last_name']); ?>" required>
                                </div>
                                
                                <div class="col-md-5">
                                    <label for="first_name" class="form-label required-field">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($doctor['first_name']); ?>" required>
                                </div>
                                
                                <div class="col-md-12">
                                    <label for="middle_name" class="form-label">Middle Name</label>
                                    <input type="text" class="form-control" id="middle_name" name="middle_name" value="<?php echo htmlspecialchars($doctor['middle_name']); ?>">
                                </div>
                                
                                <div class="col-md-12">
                                    <label for="specialists" class="form-label required-field">Specialization</label>
                                    <input type="text" class="form-control" id="specialists" name="specialists" value="<?php echo htmlspecialchars($doctor['specialists']); ?>" required>
                                    <div class="form-text">E.g., Cardiologist, Neurologist, Pediatrician, etc.</div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="sex" class="form-label required-field">Gender</label>
                                    <select class="form-select" id="sex" name="sex" required>
                                        <option value="male" <?php echo ($doctor['sex'] == 'male') ? 'selected' : ''; ?>>Male</option>
                                        <option value="female" <?php echo ($doctor['sex'] == 'female') ? 'selected' : ''; ?>>Female</option>
                                        <option value="other" <?php echo ($doctor['sex'] == 'other') ? 'selected' : ''; ?>>Other</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="birthday" class="form-label required-field">Date of Birth</label>
                                    <input type="date" class="form-control" id="birthday" name="birthday" value="<?php echo htmlspecialchars($doctor['birthday']); ?>" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="email" class="form-label required-field">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($doctor['email']); ?>" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="phone" class="form-label required-field">Phone</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($doctor['phone']); ?>" required>
                                </div>
                                
                                <div class="col-12">
                                    <label for="address" class="form-label required-field">Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="3" required><?php echo htmlspecialchars($doctor['address']); ?></textarea>
                                </div>
                                
                                <div class="col-12">
                                    <div class="photo-container">
                                        <?php if ($doctor['photo']): ?>
                                            <img src="<?php echo htmlspecialchars($doctor['photo']); ?>" class="current-photo" alt="Current Photo">
                                            <p class="text-muted">Current Photo</p>
                                        <?php endif; ?>
                                    </div>
                                    <label for="photo" class="form-label">Change Photo</label>
                                    <input class="form-control" type="file" id="photo" name="photo" accept="image/*">
                                    <div class="form-text">Accepted formats: JPG, PNG, JPEG, GIF. Max size: 5MB.</div>
                                </div>
                                
                                <div class="col-12 mt-4">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                                        <a href="index.php" class="btn btn-outline-secondary">
                                            <i class="fas fa-arrow-left me-1"></i> Back to List
                                        </a>
                                        <div>
                                            <button type="reset" class="btn btn-outline-secondary me-md-2">
                                                <i class="fas fa-undo me-1"></i> Reset
                                            </button>
                                            <button type="submit" class="btn btn-update text-white">
                                                <i class="fas fa-save me-1"></i> Update
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <?php else: ?>
                            <div class="alert alert-danger">
                                <i class="fas fa-exclamation-circle me-2"></i> Doctor not found.
                            </div>
                            <a href="index.php" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-1"></i> Back to List
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>