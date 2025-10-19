<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>


<?php
include 'auth.php';
include 'patients.php';
include 'results.php';

if(!isset($_SESSION['user_name'])) {
  header('Location: login.php');
    exit;

}

// Get recent test results with patient information
$sql = "SELECT r.*, p.first_name, p.last_name, t.template_name 
        FROM ".$_SESSION['my_tables']."_laboratory.test_results r
        JOIN ".$_SESSION['my_tables']."_resources.patient_info p ON r.patient_id = p.id
        JOIN ".$_SESSION['my_tables']."_laboratory.test_templates t ON r.template_id = t.template_id
        ORDER BY r.test_date DESC
        LIMIT 100"; // Increased limit for DataTables
$result = mysqli_query($conn, $sql);

$recent_tests = array();
while ($row = mysqli_fetch_assoc($result)) {
    $recent_tests[] = $row;
}

// Get recent patients (increased limit for DataTables)
$recent_patients = getAllPatients(100);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laboratory Management System - Dashboard</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --accent-color: #e74c3c;
            --light-color: #ecf0f1;
            --dark-color: #2c3e50;
            --success-color: #2ecc71;
            --warning-color: #f39c12;
            --danger-color: #e74c3c;
            --border-radius: 4px;
            --box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background-color: #f5f7fa;
            margin: 0;
            padding: 0;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }
        
        header {
            background-color: white;
            padding: 20px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        
        h1 {
            color: var(--dark-color);
            margin: 0;
            font-size: 1.8rem;
        }
        
        .welcome-message {
            font-size: 1rem;
            color: #7f8c8d;
        }
        
        .welcome-message strong {
            color: var(--dark-color);
        }
        
        .quick-actions {
            display: flex;
            gap: 10px;
            margin: 20px 0;
            flex-wrap: wrap;
        }
        
        .quick-action-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 15px;
            background: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: var(--border-radius);
            transition: var(--transition);
            font-size: 0.9rem;
        }
        
        .quick-action-btn:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .quick-action-btn i {
            font-size: 0.9rem;
        }
        
        .admin-action {
            background: var(--dark-color);
        }
        
        .admin-action:hover {
            background: #34495e;
        }
        
        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }
        
        @media (max-width: 992px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }
        
        .dashboard-card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 20px;
            transition: var(--transition);
        }
        
        .dashboard-card:hover {
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }
        
        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
        }
        
        .card-title {
            font-size: 1.2rem;
            color: var(--dark-color);
            margin: 0;
        }
        
        .action-link {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.85rem;
            transition: var(--transition);
            margin-left: 10px;
        }
        
        .action-link:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }
        
        .pdf-link {
            color: var(--accent-color);
        }
        
        .badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 600;
            background-color: var(--light-color);
            color: var(--dark-color);
        }
        
        .dataTables_wrapper {
            margin-top: 15px;
        }
        
        .dataTables_filter input {
            padding: 5px 10px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
        }
        
        .dataTables_paginate .paginate_button {
            padding: 5px 10px;
            margin-left: 5px;
            border-radius: var(--border-radius);
            border: 1px solid #ddd;
        }
        
        .dataTables_paginate .paginate_button.current {
            background: var(--primary-color);
            color: white !important;
            border-color: var(--primary-color);
        }
        
        .status-pending {
            color: var(--warning-color);
            font-weight: 600;
        }
        
        .status-completed {
            color: var(--success-color);
            font-weight: 600;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div>
                <h1>Laboratory Management System</h1>
                <div class="welcome-message">
                    Welcome back, <strong><?php echo htmlspecialchars($_SESSION['full_name']); ?></strong>
                    <span class="badge"><?php echo ucfirst($_SESSION['role']); ?></span>
                </div>
            </div>
            <div>
                <a href="../index.php" class="action-link"><i class="fas fa-sign-out-alt"></i> Home</a>
            </div>
        </header>
        
        <div class="quick-actions">
            <a href="template-list.php" class="quick-action-btn">
                <i class="fas fa-flask"></i> Laboratory Tests
            </a>
            <a href="patient_form.php" class="quick-action-btn">
                <i class="fas fa-user-plus"></i> Add Patient
            </a>
            <a href="create_template.php" class="quick-action-btn">
                <i class="fas fa-file-medical"></i> New Template
            </a>
            <a href="search.php" class="quick-action-btn">
                <i class="fas fa-search"></i> Search Records
            </a>
            <?php if (hasRole('admin')): ?>
                <a href="list.php" class="quick-action-btn admin-action">
                    <i class="fas fa-users-cog"></i> Results List
                </a>
            <?php endif; ?>
        </div>
        
        <div class="dashboard-grid">
            <div class="dashboard-card">
                <div class="card-header">
                    <h2 class="card-title">Recent Test Results</h2>
                    <a href="template-list.php" class="action-link">Template List</a>
                </div>
                <?php if (!empty($recent_tests)): ?>
                    <table id="testsTable" class="display compact" style="width:100%">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Patient</th>
                                <th>Test</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_tests as $test): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($test['test_date'] ?? 'N/A'); ?></td>
                                    <td>
                                        <?php 
                                        $patientName = '';
                                        if (isset($test['first_name']) && isset($test['last_name'])) {
                                            $patientName = htmlspecialchars($test['first_name'] . ' ' . $test['last_name']);
                                        }
                                        echo $patientName ?: 'Unknown Patient';
                                        ?>
                                    </td>
                                    <td><?php echo htmlspecialchars($test['template_name'] ?? 'Unknown Test'); ?></td>
                                    <td>
                                        <?php 
                                        $status = $test['status'] ?? 'completed';
                                        $statusClass = $status === 'pending' ? 'status-pending' : 'status-completed';
                                        ?>
                                        <span class="<?php echo $statusClass; ?>">
                                            <?php echo ucfirst($status); ?>
                                        </span>
                                    </td>
                                    <td>
                                        <a   href="view_result.php?id=<?php echo $test['result_id']; ?>" class="action-link" title="View">
                                            <i class="fas fa-eye"></i> View
                                        </a>
                                        
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No recent test results found.</p>
                <?php endif; ?>
            </div>
            
            <div class="dashboard-card">
                <div class="card-header">
                    <h2 class="card-title">Recent Patients</h2>
                    <a href="../patient-info/" class="action-link">View All</a>
                </div>
                <?php if (!empty($recent_patients)): ?>
                    <table id="patientsTable" class="display compact" style="width:100%">
                        <thead>
                            <tr>
                                <th>Code</th>
                                <th>Name</th>
                                <th>DOB</th>
                                <th>Gender</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($recent_patients as $patient): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($patient['patient_code'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars(($patient['first_name'] ?? '') . ' ' . ($patient['last_name'] ?? '')); ?></td>
                                    <td><?php echo htmlspecialchars($patient['date_of_birth'] ?? ''); ?></td>
                                    <td><?php echo htmlspecialchars($patient['gender'] ?? ''); ?></td>
                                    <td>
                                        <a href="patient_form.php?id=<?php echo $patient['patient_id']; ?>" class="action-link" title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="patient_results.php?id=<?php echo $patient['patient_id']; ?>" class="action-link" title="Tests">
                                            <i class="fas fa-vial"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                <?php else: ?>
                    <p>No recent patients found.</p>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#testsTable').DataTable({
                responsive: true,
                pageLength: 5,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                order: [[0, 'desc']],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search tests...",
                }
            });
            
            $('#patientsTable').DataTable({
                responsive: true,
                pageLength: 5,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                order: [[0, 'desc']],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search patients...",
                }
            });
        });
    </script>
</body>
</html>