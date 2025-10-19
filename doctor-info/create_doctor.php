<?php
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Generate user_id
    $user_id = generateUserId($conn);
    
    // Handle photo upload
    $photoPath = '';
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] == UPLOAD_ERR_OK) {
        $targetDir = "uploads/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $fileName = basename($_FILES["photo"]["name"]);
        $targetFilePath = $targetDir . $user_id . '_' . $fileName;
        $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
        
        // Allow certain file formats
        $allowTypes = array('jpg', 'png', 'jpeg', 'gif');
        if (in_array($fileType, $allowTypes)) {
            if (move_uploaded_file($_FILES["photo"]["tmp_name"], $targetFilePath)) {
                $photoPath = $targetFilePath;
            }
        }
    }

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO doctor_info (date, user_id, suffix, last_name, first_name, middle_name, specialists, address, phone, sex, email, birthday, photo) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sisssssssssss", $date, $user_id, $suffix, $last_name, $first_name, $middle_name, $specialists, $address, $phone, $sex, $email, $birthday, $photoPath);
    
    // Set parameters and execute
    $date = date('Y-m-d H:i:s');
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
        $success_message = "New doctor record created successfully. User ID: " . $user_id;
         header("Location: index.php");
    } else {
        $error_message = "Error: " . $stmt->error;
    }
    
    $stmt->close();
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor Registration</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .registration-card {
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
        .btn-submit {
            background-color: #0d6efd;
            border: none;
            padding: 10px 25px;
            font-weight: 600;
        }
        .btn-submit:hover {
            background-color: #0b5ed7;
        }
        .required-field::after {
            content: "*";
            color: red;
            margin-left: 4px;
        }
    </style>
</head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card registration-card">
                    <div class="card-header form-header py-3">
                        <h3 class="mb-0 text-center"><i class="fas fa-user-md me-2"></i>Doctor Registration Form</h3>
                    </div>
                    <div class="card-body p-4">
                        <?php if(isset($success_message)): ?>
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <?php echo $success_message; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        
                        <?php if(isset($error_message)): ?>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <?php echo $error_message; ?>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        <?php endif; ?>
                        
                        <form action="create_doctor.php" method="post" enctype="multipart/form-data">
                            <div class="row g-3">
                                <div class="col-md-2">
                                    <label for="suffix" class="form-label">Suffix</label>
                                    <select class="form-select" id="suffix" name="suffix">
                                        <option value="">None</option>
                                        <option value="Dr.">Dr.</option>
                                        <option value="Prof.">Prof.</option>
                                        <option value="Mr.">Mr.</option>
                                        <option value="Mrs.">Mrs.</option>
                                        <option value="Ms.">Ms.</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-5">
                                    <label for="last_name" class="form-label required-field">Last Name</label>
                                    <input type="text" class="form-control" id="last_name" name="last_name" required>
                                </div>
                                
                                <div class="col-md-5">
                                    <label for="first_name" class="form-label required-field">First Name</label>
                                    <input type="text" class="form-control" id="first_name" name="first_name" required>
                                </div>
                                
                                <div class="col-md-12">
                                    <label for="middle_name" class="form-label">Middle Name</label>
                                    <input type="text" class="form-control" id="middle_name" name="middle_name">
                                </div>
                                
                                <div class="col-md-12">
                                    <label for="specialists" class="form-label required-field">Specialization</label>
                                    <input type="text" class="form-control" id="specialists" name="specialists" required>
                                    <div class="form-text">E.g., Cardiologist, Neurologist, Pediatrician, etc.</div>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="sex" class="form-label required-field">Gender</label>
                                    <select class="form-select" id="sex" name="sex" required>
                                        <option value="" selected disabled>Select gender</option>
                                        <option value="male">Male</option>
                                        <option value="female">Female</option>
                                        <option value="other">Other</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="birthday" class="form-label required-field">Date of Birth</label>
                                    <input type="date" class="form-control" id="birthday" name="birthday" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="email" class="form-label required-field">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="phone" class="form-label required-field">Phone</label>
                                    <input type="tel" class="form-control" id="phone" name="phone" required>
                                </div>
                                
                                <div class="col-12">
                                    <label for="address" class="form-label required-field">Address</label>
                                    <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                                </div>
                                
                                <div class="col-12">
                                    <label for="photo" class="form-label">Profile Photo</label>
                                    <input class="form-control" type="file" id="photo" name="photo" accept="image/*">
                                    <div class="form-text">Accepted formats: JPG, PNG, JPEG, GIF. Max size: 5MB.</div>
                                </div>
                                
                                <div class="col-12 mt-4">
                                    <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                        <button type="reset" class="btn btn-outline-secondary me-md-2">
                                            <i class="fas fa-undo me-1"></i> Reset
                                        </button>
                                        <button type="submit" class="btn btn-submit text-white">
                                            <i class="fas fa-save me-1"></i> Submit
                                        </button>

                                             <a style="background-color:green" href="../index.php" class="btn  text-white btn-outline-secondary me-md-2"><i class="fas fa-home"></i> Home</a>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>