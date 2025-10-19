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
?>

 <!DOCTYPE html>
<html>
<head>
    <title>View Patient</title>
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

        h1 {
            color: var(--primary-color);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--medium-gray);
        }

        .patient-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 25px;
        }

        .patient-photo {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid var(--medium-gray);
        }

        .patient-details {
            flex: 1;
            margin-right: 30px;
        }

        .detail-row {
            display: flex;
            flex-wrap: wrap;
            margin-bottom: 15px;
            padding-bottom: 15px;
            border-bottom: 1px solid var(--light-gray);
        }

        .detail-group {
            flex: 1;
            min-width: 250px;
            padding: 0 15px;
            margin-bottom: 10px;
        }

        .detail-label {
            font-weight: 600;
            color: #555;
            margin-bottom: 5px;
        }

        .detail-value {
            padding: 8px 0;
            color: var(--dark-gray);
        }

        .actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid var(--medium-gray);
            gap: 10px;
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
            text-decoration: none;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: var(--secondary-color);
        }

        .btn-secondary {
            background-color: var(--medium-gray);
            color: var(--dark-gray);
        }

        .btn-secondary:hover {
            background-color: #d0d0d0;
        }

        .bmi-indicator {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 600;
            margin-left: 8px;
        }

        .bmi-normal {
            background-color: rgba(46, 204, 113, 0.2);
            color: var(--success-color);
        }

        .bmi-warning {
            background-color: rgba(241, 196, 15, 0.2);
            color: var(--warning-color);
        }

        .bmi-danger {
            background-color: rgba(231, 76, 60, 0.2);
            color: var(--accent-color);
        }

        @media (max-width: 768px) {
            .patient-header {
                flex-direction: column;
            }
            
            .patient-photo {
                margin-bottom: 20px;
                align-self: center;
            }
            
            .patient-details {
                margin-right: 0;
            }
            
            .actions {
                flex-direction: column;
            }
            
            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="patient-header">
            <div class="patient-details">
                <h1>Patient Details</h1>
                <div class="detail-row">
                    <div class="detail-group">
                        <div class="detail-label">Patient Code</div>
                        <div class="detail-value"><?php echo htmlspecialchars($patient['patient_code']); ?></div>
                    </div>
                    <div class="detail-group">
                        <div class="detail-label">Date Created</div>
                        <div class="detail-value"><?php echo htmlspecialchars($patient['created_at']); ?></div>
                    </div>
                </div>
            </div>
            
            <?php if ($patient['photo']): ?>
                <img src="../../uploads/patient-form/<?php echo htmlspecialchars($patient['photo']); ?>" class="patient-photo" alt="Patient Photo">
            <?php endif; ?>
        </div>

        <div class="detail-row">
            <div class="detail-group">
                <div class="detail-label">Full Name</div>
                <div class="detail-value">
                    <?php echo htmlspecialchars($patient['last_name']) . ', ' . 
                          htmlspecialchars($patient['first_name']) . ' ' . 
                          htmlspecialchars($patient['middle_name']); ?>
                </div>
            </div>
            <div class="detail-group">
                <div class="detail-label">Gender</div>
                <div class="detail-value"><?php echo htmlspecialchars($patient['gender']); ?></div>
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-group">
                <div class="detail-label">Birthday</div>
                <div class="detail-value"><?php echo htmlspecialchars($patient['birthday']); ?></div>
            </div>
            <div class="detail-group">
                <div class="detail-label">Civil Status</div>
                <div class="detail-value"><?php echo htmlspecialchars($patient['civil_status']); ?></div>
            </div>
            <div class="detail-group">
                <div class="detail-label">Blood Group</div>
                <div class="detail-value"><?php echo htmlspecialchars($patient['blood_group']); ?></div>
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-group">
                <div class="detail-label">Contact Information</div>
                <div class="detail-value">
                    <div><?php echo htmlspecialchars($patient['phone']); ?></div>
                    <div><?php echo htmlspecialchars($patient['email']); ?></div>
                </div>
            </div>
            <div class="detail-group">
                <div class="detail-label">Address</div>
                <div class="detail-value"><?php echo nl2br(htmlspecialchars($patient['address'])); ?></div>
            </div>
        </div>

        <div class="detail-row">
            <div class="detail-group">
                <div class="detail-label">Height</div>
                <div class="detail-value"><?php echo htmlspecialchars($patient['height_cm']); ?> cm</div>
            </div>
            <div class="detail-group">
                <div class="detail-label">Weight</div>
                <div class="detail-value"><?php echo htmlspecialchars($patient['weight_kg']); ?> kg</div>
            </div>
            <div class="detail-group">
                <div class="detail-label">BMI</div>
                <div class="detail-value">
                    <?php 
                        $bmi = $patient['bmi'];
                        echo number_format((float)$bmi, 2);
                        
                        // Add BMI classification
                        if ($bmi < 18.5) {
                            echo '<span class="bmi-indicator bmi-warning">Underweight</span>';
                        } elseif ($bmi >= 18.5 && $bmi < 25) {
                            echo '<span class="bmi-indicator bmi-normal">Normal</span>';
                        } elseif ($bmi >= 25 && $bmi < 30) {
                            echo '<span class="bmi-indicator bmi-warning">Overweight</span>';
                        } else {
                            echo '<span class="bmi-indicator bmi-danger">Obese</span>';
                        }
                    ?>
                </div>
            </div>
        </div>

        <div class="actions">
            <a href="index.php" class="btn btn-secondary">Back to List</a>
            <a href="edit.php?id=<?php echo $patient['id']; ?>" class="btn">Edit Patient</a>
        </div>
    </div>
</body>
</html>