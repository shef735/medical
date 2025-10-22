<?php
include 'config.php';

// Fetch all patients
$sql = "SELECT * FROM patient_info ORDER BY id DESC";
$result = mysqli_query($conn, $sql);

// Check for messages
$message = isset($_GET['message']) ? $_GET['message'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Management System</title>
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
        
        h1 {
            color: var(--dark-color);
            margin-top: 0;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
        }
        
        .alert {
            padding: 12px 20px;
            margin-bottom: 20px;
            border-radius: var(--border-radius);
            background-color: var(--success-color);
            color: white;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .alert i {
            font-size: 1.2rem;
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
            background: var(--danger-color);
        }
        
        .btn-danger:hover {
            background: #c0392b;
        }
        
        .action-link {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: var(--light-color);
            color: var(--dark-color);
            margin-right: 5px;
            transition: var(--transition);
        }
        
        .action-link:hover {
            background-color: var(--primary-color);
            color: white;
            text-decoration: none;
        }
        
        .view-link:hover {
            background-color: var(--success-color);
        }
        
        .edit-link:hover {
            background-color: var(--warning-color);
        }
        
        .delete-link:hover {
            background-color: var(--danger-color);
        }
        
        .dataTables_wrapper {
            margin-top: 20px;
        }
        
        .dataTables_filter input {
            padding: 5px 10px;
            border: 1px solid #ddd;
            border-radius: var(--border-radius);
            margin-left: 10px;
        }
        
        .dataTables_length select {
            padding: 5px;
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
        
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }
            
            .btn {
                width: 100%;
                justify-content: center;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <h1><i class="fas fa-user-injured"></i> Patient Management</h1>
        
        <?php if ($message): ?>
            <div class="alert">
                <i class="fas fa-check-circle"></i>
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>
        
        <a href="create.php" class="btn">
            <i class="fas fa-user-plus"></i> Add New Patient
        </a>

        <a href="../lab_system/dashboard.php" class="btn">
            <i class="fas fa-home"></i> Home
        </a>
        
        <table id="patientsTable" class="display" style="width:100%">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Patient Code</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['id']); ?></td>
                    <td><?php echo htmlspecialchars($row['patient_code']); ?></td>
                    <td>
                        <?php 
                        $name = htmlspecialchars($row['last_name']) . ', ' . 
                                htmlspecialchars($row['first_name']) . ' ' . 
                                htmlspecialchars($row['middle_name']);
                        echo trim($name);
                        ?>
                    </td>
                    <td><?php echo htmlspecialchars($row['gender']); ?></td>
                    <td><?php echo htmlspecialchars($row['phone']); ?></td>
                    <td><?php echo htmlspecialchars($row['email']); ?></td>
                    <td>
                        <a href="view.php?id=<?php echo $row['id']; ?>" class="action-link view-link" title="View">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="action-link edit-link" title="Edit">
                            <i class="fas fa-edit"></i>
                        </a>
                        <a href="delete.php?id=<?php echo $row['id']; ?>" class="action-link delete-link" title="Delete" onclick="return confirm('Are you sure you want to delete this patient?')">
                            <i class="fas fa-trash-alt"></i>
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#patientsTable').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [[5, 10, 25, 50, -1], [5, 10, 25, 50, "All"]],
                order: [[0, 'desc']],
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search patients...",
                    lengthMenu: "Show _MENU_ patients per page",
                    zeroRecords: "No patients found",
                    info: "Showing _START_ to _END_ of _TOTAL_ patients",
                    infoEmpty: "No patients available",
                    infoFiltered: "(filtered from _MAX_ total patients)",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                }
            });
        });
    </script>
</body>
</html>