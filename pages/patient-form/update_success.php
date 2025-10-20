<?php
session_start();
if(!isset($_SESSION['update_success'])) {
    header("Location: ../patient_list.php");
    exit();
}

$patient_id = $_SESSION['patient_id'];
$patient_name = $_SESSION['patient_name'];

// Clear session variables
unset($_SESSION['update_success']);
unset($_SESSION['patient_id']);
unset($_SESSION['patient_name']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Successful</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Use the same styles as saving.php success page */
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
            max-width: 600px;
            width: 100%;
            text-align: center;
            animation: fadeIn 0.6s ease-out;
        }
        
        .status-icon {
            font-size: 80px;
            margin-bottom: 20px;
            color: #28a745;
        }
        
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
        
        .btn-success {
            background: linear-gradient(135deg, #28a745, #218838);
            color: white;
        }
        
        .pulse {
            animation: pulse 2s infinite;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="status-icon">
            <i class="fas fa-check-circle pulse"></i>
        </div>
        
        <h1>Patient Information Updated!</h1>
        
        <div class="message">
            The information for <strong><?php echo htmlspecialchars($patient_name); ?></strong> has been successfully updated in the system.
        </div>
        
        <div class="button-group">
            <a href="edit_patient_form.php?id=<?php echo $patient_id; ?>" class="btn btn-primary">
                <i class="fas fa-edit"></i>
                Edit Again
            </a>
            
            <a href="../patient-list.php" class="btn btn-success">
                <i class="fas fa-list"></i>
                Back to Patient List
            </a>
            
            <a href="../index.php" class="btn" style="background: #6c757d; color: white;">
                <i class="fas fa-home"></i>
                Return to Home
            </a>
        </div>
    </div>
</body>
</html>