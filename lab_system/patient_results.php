<?php
include 'auth.php';
include 'patients.php';
include 'results.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$patient_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$patient = getPatient($patient_id);

if (!$patient) {
    die("Patient not found");
}

// Get all test results for this patient
$sql = "SELECT r.*, t.template_name 
        FROM ".$_SESSION['my_tables']."_laboratory.test_results r
        JOIN ".$_SESSION['my_tables']."_laboratory.test_templates t ON r.template_id = t.template_id
        WHERE r.patient_id = $patient_id
        ORDER BY r.test_date DESC";

$result = mysqli_query($conn, $sql);
$test_results = array();
while ($row = mysqli_fetch_assoc($result)) {
    $test_results[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Test Results for <?php echo htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #333;
            margin-top: 0;
        }
        .patient-info {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .patient-info p {
            margin: 5px 0;
        }
        .patient-info strong {
            display: inline-block;
            width: 120px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        .actions a {
            color: #2196F3;
            text-decoration: none;
            margin-right: 10px;
        }
        .actions a:hover {
            text-decoration: underline;
        }
        .back-link {
            display: inline-block;
            margin-bottom: 20px;
            color: #2196F3;
            text-decoration: none;
        }
        .back-link:hover {
            text-decoration: underline;
        }
        .no-results {
            text-align: center;
            color: #666;
            padding: 20px;
        }
        .pdf-icon {
            color: #e74c3c;
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="dashboard.php" class="back-link">← Back to Patient List</a>
        
        <h1>Test Results for <?php echo htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']); ?></h1>
        
        <div class="patient-info">
            <p><strong>Patient Code:</strong> <?php echo htmlspecialchars($patient['patient_code']); ?></p>
            <p><strong>Date of Birth:</strong> <?php echo htmlspecialchars($patient['date_of_birth']) . ' (Age: ' . calculateAge($patient['date_of_birth']) . ')'; ?></p>
            <p><strong>Gender:</strong> <?php echo htmlspecialchars($patient['gender']); ?></p>
            <p><strong>Phone:</strong> <?php echo htmlspecialchars($patient['phone']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($patient['email']); ?></p>
        </div>
        
        <?php if (empty($test_results)): ?>
            <div class="no-results">
                <p>No test results found for this patient.</p>
              <!--  <a href="enter_results.php?patient_id=<?php echo $patient_id; ?>" class="add-test">Add New Test</a> -->
            </div>
        <?php else: ?>
            <table>
                <thead>
                    <tr>
                        <th>Test Date</th>
                        <th>Test Type</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($test_results as $test): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($test['test_date']); ?></td>
                            <td><?php echo htmlspecialchars($test['template_name']); ?></td>
                            <td class="actions">
                                <a   href="view_result.php?id=<?php echo $test['result_id']; ?>">View Details</a>
                                
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            
           <!-- <div style="margin-top: 20px;">
                <a href="enter_results.php?patient_id=<?php echo $patient_id; ?>" class="add-test" style="padding: 10px 15px; background-color: #4CAF50; color: white; text-decoration: none; border-radius: 4px; display: inline-block;">Add New Test</a>
            </div> -->
        <?php endif; ?>
    </div>
</body>
</html>