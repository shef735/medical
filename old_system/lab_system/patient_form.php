<style>
 .btn {
            padding: 8px 15px;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            font-size: 14px;
            display: inline-block;
        }
        .btn-close {
            background:rgb(255, 0, 0);
        }
        .btn-close:hover {
            background:rgb(255, 0, 0);
        }

        .btn-save {
            background:rgb(43, 153, 0);
        }
        .btn-save:hover {
            background:rgb(43, 153, 0);
        }

</style>

<?php
include 'auth.php';
include 'patients.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$patient_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$patient = $patient_id ? getPatient($patient_id) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = [
        'patient_code' => $_POST['patient_code'],
        'first_name' => $_POST['first_name'],
        'last_name' => $_POST['last_name'],
        'date_of_birth' => $_POST['date_of_birth'],
        'gender' => $_POST['gender'],
        'address' => $_POST['address'],
        'phone' => $_POST['phone'],
        'email' => $_POST['email']
    ];
    
    if ($patient_id) {
        if (updatePatient($patient_id, $data)) {
            $message = "Patient updated successfully!";
            $patient = getPatient($patient_id);
        } else {
            $error = "Error updating patient.";
        }
    } else {
        if ($new_id = addPatient($data)) {
            $message = "Patient added successfully!";
            header("Location: patient_form.php?id=$new_id");
            exit;
        } else {
            $error = "Error adding patient.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title><?php echo $patient ? 'Edit' : 'Add'; ?> Patient</title>
    <style>
        body { font-family: Arial, sans-serif; max-width: 800px; margin: 0 auto; padding: 20px; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; font-weight: bold; }
        input, select, textarea { width: 100%; padding: 8px; box-sizing: border-box; }
        button { padding: 10px 15px; background: #007bff; color: white; border: none; cursor: pointer; }
        .error { color: red; }
        .success { color: green; }
        .form-row { display: flex; gap: 15px; }
        .form-row .form-group { flex: 1; }
    </style>
</head>
<body>
    <h2><?php echo $patient ? 'Edit' : 'Add'; ?> Patient</h2>
    
    <?php if (isset($error)): ?>
        <p class="error"><?php echo $error; ?></p>
    <?php endif; ?>
    
    <?php if (isset($message)): ?>
        <p class="success"><?php echo $message; ?></p>
    <?php endif; ?>
    
    <form method="post">
        <div class="form-row">
            <div class="form-group">
                <label>Patient Code:</label>
                <input type="text" name="patient_code" required 
                       value="<?php echo htmlspecialchars($patient['patient_code'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label>Date of Birth:</label>
                <input type="date" name="date_of_birth" required 
                       value="<?php echo htmlspecialchars($patient['date_of_birth'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label>Gender:</label>
                <select name="gender" required>
                    <option value="Male" <?php echo ($patient['gender'] ?? '') === 'Male' ? 'selected' : ''; ?>>Male</option>
                    <option value="Female" <?php echo ($patient['gender'] ?? '') === 'Female' ? 'selected' : ''; ?>>Female</option>
                    <option value="Other" <?php echo ($patient['gender'] ?? '') === 'Other' ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>First Name:</label>
                <input type="text" name="first_name" required 
                       value="<?php echo htmlspecialchars($patient['first_name'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label>Last Name:</label>
                <input type="text" name="last_name" required 
                       value="<?php echo htmlspecialchars($patient['last_name'] ?? ''); ?>">
            </div>
        </div>
        
        <div class="form-group">
            <label>Address:</label>
            <textarea name="address"><?php echo htmlspecialchars($patient['address'] ?? ''); ?></textarea>
        </div>
        
        <div class="form-row">
            <div class="form-group">
                <label>Phone:</label>
                <input type="text" name="phone" 
                       value="<?php echo htmlspecialchars($patient['phone'] ?? ''); ?>">
            </div>
            <div class="form-group">
                <label>Email:</label>
                <input type="email" name="email" 
                       value="<?php echo htmlspecialchars($patient['email'] ?? ''); ?>">
            </div>
        </div>
        
        <button class="btn btn-save" type="submit">Save Patient</button>
        <a class="btn btn-close" href="dashboard.php" style="margin-left: 10px;">Back to List</a>
    </form>
</body>
</html>