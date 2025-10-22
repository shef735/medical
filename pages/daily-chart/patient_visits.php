<?php
include 'config.php';

if (!isset($_GET['patient_id'])) {
    header("Location: index.php");
    exit;
}

$patient_id = $_GET['patient_id'];

// Fetch patient information
$patient_sql = "SELECT * FROM patient_info WHERE id = $patient_id";
$patient_result = mysqli_query($conn, $patient_sql);
$patient = mysqli_fetch_assoc($patient_result);

if (!$patient) {
    header("Location: index.php");
    exit;
}

// Fetch all visits for this patient
$visits_sql = "SELECT * FROM clinic_visits WHERE patient_id = $patient_id ORDER BY visit_date DESC";
$visits_result = mysqli_query($conn, $visits_sql);

// Check for messages
$message = isset($_GET['message']) ? $_GET['message'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Visits</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; }
        .container { max-width: 1000px; margin: 0 auto; padding: 20px; }
        h1, h2 { color: #2c3e50; }
        .success-message { color: green; margin-bottom: 20px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .action-btns { margin-top: 20px; }
        .btn { padding: 8px 15px; border-radius: 4px; text-decoration: none; display: inline-block; }
        .btn-add { background: #2ecc71; color: white; }
        .btn-add:hover { background: #27ae60; }
        .btn-view { background: #3498db; color: white; }
        .btn-view:hover { background: #2980b9; }
        .btn-back { background: #95a5a6; color: white; }
        .btn-back:hover { background: #7f8c8d; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Patient Visits</h1>
        <h2><?php echo $patient['last_name'] . ', ' . $patient['first_name']; ?></h2>
        
        <?php if ($message): ?>
            <div class="success-message"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <div class="action-btns">
            <a href="clinic_visit.php?patient_id=<?php echo $patient_id; ?>" class="btn btn-add">Add New Visit</a>
            <a href="view_patient.php?id=<?php echo $patient_id; ?>" class="btn btn-back">Back to Patient</a>
        </div>
        
        <hr>
        <?php if (mysqli_num_rows($visits_result) > 0): ?>
        <table>
            <tr>
                <th>Visit Date</th>
                <th>Case Number</th>
                <th>Next Visit</th>
                 <th>Actions</th>
            </tr>
            <?php while ($visit = mysqli_fetch_assoc($visits_result)): ?>
            <tr>
                <td><?php echo date('M d, Y', strtotime($visit['visit_date'])); ?></td>
                <td><?php echo $visit['case_number']; ?></td>
                <td><?php echo $visit['next_visit'] ? date('M d, Y', strtotime($visit['next_visit'])) : 'Not scheduled'; ?></td>
                 <td>
                    <a href="view_visit.php?visit_id=<?php echo $visit['id']; ?>" class="btn btn-view">View</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <?php else: ?>
        <p>No visits found for this patient.</p>
        <?php endif; ?>
    </div>
</body>
</html>