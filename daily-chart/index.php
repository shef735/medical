<?php
include 'config.php';

// Handle patient deletion
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];
    $sql = "DELETE FROM patient_info WHERE id = $delete_id";
    if (mysqli_query($conn, $sql)) {
        $message = "Patient deleted successfully";
    } else {
        $message = "Error deleting patient: " . mysqli_error($conn);
    }
}

// Search functionality
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
$where = $search ? "WHERE last_name LIKE '%$search%' OR first_name LIKE '%$search%' OR patient_code LIKE '%$search%'" : '';

// Fetch all patients with search filter
$sql = "SELECT * FROM patient_info $where ORDER BY last_name, first_name";
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
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
        }
        .action-buttons {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        .btn {
            padding: 8px 15px;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            font-size: 14px;
            display: inline-block;
        }
        .btn-add {
            background: #2ecc71;
        }
        .btn-add:hover {
            background: #27ae60;
        }
        .search-form {
            display: flex;
            gap: 10px;
        }
        .search-input {
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            min-width: 250px;
        }
        .search-btn {
            background: #3498db;
            border: none;
            color: white;
            padding: 8px 15px;
            border-radius: 4px;
            cursor: pointer;
        }
        .search-btn:hover {
            background: #2980b9;
        }
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }
        th {
            background-color: #3498db;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f2f2f2;
        }
        tr:hover {
            background-color: #e9e9e9;
        }
        .action-cell {
            white-space: nowrap;
        }
        .action-link {
            padding: 5px 10px;
            border-radius: 3px;
            text-decoration: none;
            margin-right: 5px;
            font-size: 13px;
            display: inline-block;
        }
        .view-link {
            background: #3498db;
            color: white;
        }
        .view-link:hover {
            background: #2980b9;
        }
        .edit-link {
            background: #f39c12;
            color: white;
        }
        .edit-link:hover {
            background: #e67e22;
        }
        .delete-link {
            background: #e74c3c;
            color: white;
        }
        .delete-link:hover {
            background: #c0392b;
        }
        .patient-code {
            font-family: monospace;
            color: #2c3e50;
            font-weight: bold;
        }
        .no-patients {
            padding: 20px;
            text-align: center;
            color: #7f8c8d;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Patient Management System</h1>
        
        <?php if ($message): ?>
            <div class="message <?php echo strpos($message, 'Error') !== false ? 'error' : 'success'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <div class="action-buttons">
            <a href="create.php" class="btn btn-add">Add New Patient</a>
            
            <form method="get" action="index.php" class="search-form">
                <input type="text" name="search" class="search-input" placeholder="Search patients..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="search-btn">Search</button>
                <?php if ($search): ?>
                    <a href="index.php" style="padding: 8px 15px; background: #95a5a6; color: white; border-radius: 4px; text-decoration: none;">Clear</a>
                <?php endif; ?>
            </form>
        </div>
        
        <?php if (mysqli_num_rows($result) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Patient Code</th>
                    <th>Name</th>
                    <th>Gender</th>
                    <th>Age</th>
                    <th>Phone</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)): 
                    $birthday = new DateTime($row['birthday']);
                    $today = new DateTime();
                    $age = $today->diff($birthday)->y;
                ?>
                <tr>
                    <td class="patient-code"><?php echo $row['patient_code']; ?></td>
                    <td><?php echo $row['last_name'] . ', ' . $row['first_name'] . ' ' . $row['middle_name']; ?></td>
                    <td><?php echo $row['gender']; ?></td>
                    <td><?php echo $age; ?></td>
                    <td><?php echo $row['phone']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td class="action-cell">
                        <a href="view_patient.php?id=<?php echo $row['id']; ?>" class="action-link view-link">View</a>
                        <a href="edit_patient.php?id=<?php echo $row['id']; ?>" class="action-link edit-link">Edit</a>
                        <a href="index.php?delete_id=<?php echo $row['id']; ?>" 
                           class="action-link delete-link" 
                           onclick="return confirm('Are you sure you want to delete this patient?')">Delete</a>
                    </td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        <?php else: ?>
        <div class="no-patients">
            <?php echo $search ? 'No patients found matching your search.' : 'No patients found. Add your first patient!'; ?>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>