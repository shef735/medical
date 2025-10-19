<?php
include 'auth.php';
include 'patients.php';
include 'results.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$search_term = $_GET['q'] ?? '';
$results = [];

if (!empty($search_term)) {
    // Search patients
    $patients = searchPatients($search_term);
    
    // Search test results
    $sql = "SELECT r.*, p.first_name, p.last_name, t.template_name 
            FROM ".$_SESSION['my_tables']."_laboratory.test_results r
            JOIN ".$_SESSION['my_tables']."_resources.patient_info p ON r.patient_id = p.patient_id
            JOIN ".$_SESSION['my_tables']."_laboratory.test_templates t ON r.template_id = t.template_id
            WHERE p.first_name LIKE '%" . mysqli_real_escape_string($conn, $search_term) . "%'
            OR p.last_name LIKE '%" . mysqli_real_escape_string($conn, $search_term) . "%'
            OR p.patient_code LIKE '%" . mysqli_real_escape_string($conn, $search_term) . "%'
            OR t.template_name LIKE '%" . mysqli_real_escape_string($conn, $search_term) . "%'
            OR CONCAT(p.first_name, ' ', p.last_name) LIKE '%" . mysqli_real_escape_string($conn, $search_term) . "%'
            ORDER BY r.test_date DESC";
    
    $result = mysqli_query($conn, $sql);
    while ($row = mysqli_fetch_assoc($result)) {
        $results[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results - Laboratory System</title>
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
            padding: 20px;
        }
        
        .container {
            max-width: 1400px;
            margin: 0 auto;
            background-color: white;
            padding: 30px;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }
        
        h1, h2, h3, h4 {
            color: var(--dark-color);
            margin-top: 0;
        }
        
        .search-box {
            margin-bottom: 30px;
            display: flex;
            gap: 10px;
            max-width: 600px;
        }
        
        .search-input {
            flex: 1;
            padding: 12px 15px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            font-size: 1rem;
            transition: var(--transition);
        }
        
        .search-input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }
        
        .search-btn {
            padding: 12px 20px;
            background: var(--primary-color);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            cursor: pointer;
            font-size: 1rem;
            transition: var(--transition);
            display: flex;
            align-items: center;
            gap: 8px;
        }
        
        .search-btn:hover {
            background: var(--secondary-color);
        }
        
        .results-section {
            margin-top: 30px;
        }
        
        .section-title {
            padding-bottom: 10px;
            border-bottom: 1px solid #eee;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .section-title i {
            color: var(--primary-color);
        }
        
        .no-results {
            padding: 20px;
            background-color: var(--light-color);
            border-radius: var(--border-radius);
            text-align: center;
            color: #666;
        }
        
        table.dataTable {
            width: 100% !important;
            margin: 20px 0 !important;
            border-collapse: collapse !important;
        }
        
        table.dataTable thead th {
            background-color: var(--primary-color);
            color: white;
            padding: 12px 15px;
            text-align: left;
        }
        
        table.dataTable tbody td {
            padding: 12px 15px;
            border-bottom: 1px solid #eee;
        }
        
        table.dataTable tbody tr:hover {
            background-color: rgba(52, 152, 219, 0.05);
        }
        
        .action-link {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 6px 12px;
            background-color: var(--light-color);
            color: var(--dark-color);
            border-radius: var(--border-radius);
            text-decoration: none;
            margin-right: 5px;
            transition: var(--transition);
            font-size: 0.85rem;
        }
        
        .action-link:hover {
            text-decoration: none;
        }
        
        .view-link {
            background-color: rgba(46, 204, 113, 0.1);
            color: var(--success-color);
        }
        
        .view-link:hover {
            background-color: var(--success-color);
            color: white;
        }
        
        .edit-link {
            background-color: rgba(243, 156, 18, 0.1);
            color: var(--warning-color);
        }
        
        .edit-link:hover {
            background-color: var(--warning-color);
            color: white;
        }
        
        .pdf-link {
            background-color: rgba(231, 76, 60, 0.1);
            color: var(--danger-color);
        }
        
        .pdf-link:hover {
            background-color: var(--danger-color);
            color: white;
        }
        
        .search-term {
            color: var(--primary-color);
            font-weight: bold;
        }
        
        .dataTables_wrapper .dataTables_filter input {
            margin-left: 10px;
            padding: 5px 10px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button {
            padding: 5px 10px;
            border-radius: var(--border-radius);
            border: 1px solid #ddd;
            margin-left: 5px;
        }
        
        .dataTables_wrapper .dataTables_paginate .paginate_button.current {
            background: var(--primary-color);
            color: white !important;
            border-color: var(--primary-color);
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            
            .search-box {
                flex-direction: column;
            }
            
            .action-link {
                margin-bottom: 5px;
                display: inline-flex;
            }
        }

         .btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 15px;
            background: var(--primary-color);
            color: white;
            text-decoration: none;
            border-radius: var(--border-radius);
            transition: var(--transition);
            margin-bottom: 20px;
            border: none;
            cursor: pointer;
            font-size: 0.9rem;
        }
        
        .btn:hover {
            background: var(--secondary-color);
            transform: translateY(-2px);
        }
        
        .btn i {
            font-size: 0.9rem;
        }
        
        .btn-danger {
            background: var(--success-color);
        }
        
        .btn-danger:hover {
            background: #c0392b;
        }
    </style>
</head>
<body>
    <div class="container">

         <a style="float: right;" href="../lab_system/dashboard.php" class="btn btn-danger">
            <i class="fas fa-home"></i> Home
        </a>
        

        <h1><i class="fas fa-search"></i> Search Laboratory Records</h1>
        
        <div class="search-box">
            <form method="get" action="search.php" style="display: flex; width: 100%;">
                <input type="text" name="q" class="search-input" placeholder="Search patients, tests, or results..." 
                       value="<?php echo htmlspecialchars($search_term); ?>" required>
                <button type="submit" class="search-btn">
                    <i class="fas fa-search"></i> Search
                </button>
            </form>
        </div>

        
        
        <?php if (!empty($search_term)): ?>
            <h3>Results for "<span class="search-term"><?php echo htmlspecialchars($search_term); ?></span>"</h3>
            
            <?php if (empty($patients) && empty($results)): ?>
                <div class="no-results">
                    <i class="fas fa-exclamation-circle" style="font-size: 2rem; margin-bottom: 10px;"></i>
                    <p>No matching records found for your search.</p>
                    <p>Try different search terms or check your spelling.</p>
                </div>
            <?php else: ?>
                <?php if (!empty($patients)): ?>
                    <div class="results-section">
                        <h4 class="section-title"><i class="fas fa-user-injured"></i> Patients</h4>
                        <table id="patientsTable" class="display">
                            <thead>
                                <tr>
                                    <th>Code</th>
                                    <th>Name</th>
                                    <th>Date of Birth</th>
                                    <th>Gender</th>
                                    <th>Phone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($patients as $patient): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($patient['patient_code']); ?></td>
                                        <td><?php echo htmlspecialchars($patient['first_name']) . ' ' . htmlspecialchars($patient['last_name']); ?></td>
                                        <td><?php echo htmlspecialchars($patient['date_of_birth']); ?></td>
                                        <td><?php echo htmlspecialchars($patient['gender']); ?></td>
                                        <td><?php echo htmlspecialchars($patient['phone']); ?></td>
                                        <td>
                                            <a href="patient_form.php?id=<?php echo $patient['patient_id']; ?>" class="action-link edit-link">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <a href="patient_results.php?id=<?php echo $patient['patient_id']; ?>" class="action-link view-link">
                                                <i class="fas fa-vial"></i> Tests
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
                
                <?php if (!empty($results)): ?>
                    <div class="results-section">
                        <h4 class="section-title"><i class="fas fa-flask"></i> Test Results</h4>
                        <table id="resultsTable" class="display">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Patient</th>
                                    <th>Test Type</th>
                                    <th>Status</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($results as $result): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($result['test_date']); ?></td>
                                        <td><?php echo htmlspecialchars($result['first_name'] . ' ' . htmlspecialchars($result['last_name'])); ?></td>
                                        <td><?php echo htmlspecialchars($result['template_name']); ?></td>
                                        <td>
                                            <?php 
                                            $status = $result['status'] ?? 'completed';
                                            $statusClass = $status === 'pending' ? 'status-pending' : 'status-completed';
                                            ?>
                                            <span class="<?php echo $statusClass; ?>">
                                                <?php echo ucfirst($status); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <a target="_blank" href="view_result.php?id=<?php echo $result['result_id']; ?>" class="action-link view-link">
                                                <i class="fas fa-eye"></i> View
                                            </a>
                                            <?php  if (hasRole('admin') || hasRole('technician')): ?>
                                                <a  target="_blank" href="pdf_report.php?id=<?php echo $result['result_id']; ?>" class="action-link pdf-link">
                                                    <i class="fas fa-file-pdf"></i> PDF
                                                </a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        <?php else: ?>
            <div class="no-results">
                <i class="fas fa-search" style="font-size: 2rem; margin-bottom: 10px;"></i>
                <p>Enter a search term to find patients or test results.</p>
                <p>You can search by patient name, code, or test type.</p>
            </div>
        <?php endif; ?>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#patientsTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Filter patients...",
                    lengthMenu: "Show _MENU_ patients",
                    zeroRecords: "No matching patients found",
                    info: "Showing _START_ to _END_ of _TOTAL_ patients",
                    infoEmpty: "No patients available",
                    infoFiltered: "(filtered from _MAX_ total patients)"
                }
            });
            
            $('#resultsTable').DataTable({
                responsive: true,
                pageLength: 10,
                order: [[0, 'desc']],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Filter results...",
                    lengthMenu: "Show _MENU_ results",
                    zeroRecords: "No matching results found",
                    info: "Showing _START_ to _END_ of _TOTAL_ results",
                    infoEmpty: "No results available",
                    infoFiltered: "(filtered from _MAX_ total results)"
                }
            });
        });
    </script>
</body>
</html>