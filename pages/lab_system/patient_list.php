<?php
include 'auth.php';
include 'patients.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

// Pagination settings
$patients_per_page = 15;
$current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($current_page < 1) $current_page = 1;

// Search functionality
$search_term = isset($_GET['search']) ? trim($_GET['search']) : '';
$total_patients = 0;

if (!empty($search_term)) {
    $patients = searchPatients($search_term);
    $total_patients = count($patients);
} else {
    // Get total count for pagination
    $sql = "SELECT COUNT(*) as total FROM ".$_SESSION['my_tables']."_resources.patient_info";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);
    $total_patients = $row['total'];
    
    // Calculate pagination
    $total_pages = ceil($total_patients / $patients_per_page);
    if ($current_page > $total_pages && $total_pages > 0) {
        $current_page = $total_pages;
    }
    
    $offset = ($current_page - 1) * $patients_per_page;
    
    // Get patients for current page
    $sql = "SELECT * FROM ".$_SESSION['my_tables']."_resources.patient_info ORDER BY last_name, first_name LIMIT $offset, $patients_per_page";
    $result = mysqli_query($conn, $sql);
    
    $patients = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $patients[] = $row;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Patient List</title>
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
        .search-box {
            margin-bottom: 20px;
            display: flex;
            gap: 10px;
        }
        .search-box input {
            flex: 1;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .search-box button {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
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
        .pagination {
            display: flex;
            justify-content: center;
            gap: 5px;
            margin-top: 20px;
        }
        .pagination a, .pagination span {
            padding: 8px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            text-decoration: none;
            color: #333;
        }
        .pagination a:hover {
            background-color: #f2f2f2;
        }
        .pagination .current {
            background-color: #4CAF50;
            color: white;
            border-color: #4CAF50;
        }
        .add-patient {
            display: inline-block;
            padding: 10px 15px;
            background-color:rgb(36, 140, 251);
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .add-patient:hover {
            background-color: rgb(36, 140, 251);
        }
        .patient-count {
            color: #666;
            margin-bottom: 20px;
        }

         .btn {
            padding: 8px 15px;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            font-size: 14px;
            display: inline-block;
        }
        .btn-close {
            display: inline-block;
            padding: 10px 15px;
            background-color: #4CAF50;
            color: white;
            text-decoration: none;
            border-radius: 4px;
            margin-bottom: 20px;
        }
        .btn-close:hover {
            background-color: #45a049;
        }

    </style>
</head>
<body>
    <div class="container">
        <h1>Patient List</h1>
        
        <a href="patient_form.php" class="add-patient">Add New Patient</a>
                <a href="dashboard.php" class="btn-close">Home</a>

        
        <div class="patient-count">
            <?php echo "Total patients: " . $total_patients; ?>
        </div>
        
        <form method="get" action="patient_list.php" class="search-box">
            <input type="text" name="search" placeholder="Search patients..." 
                   value="<?php echo htmlspecialchars($search_term); ?>">
            <button type="submit">Search</button>
            <?php if (!empty($search_term)): ?>
                <a href="patient_list.php" style="padding: 8px 15px; background-color: #f44336; color: white; text-decoration: none; border-radius: 4px;">Clear</a>
            <?php endif; ?>
        </form>
        
        <table>
            <thead>
                <tr>
                    <th>Patient Code</th>
                    <th>Name</th>
                    <th>Date of Birth</th>
                    <th>Gender</th>
                    <th>Phone</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($patients)): ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">No patients found</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($patients as $patient): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($patient['patient_code']); ?></td>
                            <td><?php echo htmlspecialchars($patient['first_name'] . ' ' . $patient['last_name']); ?></td>
                            <td><?php echo htmlspecialchars($patient['date_of_birth']); ?></td>
                            <td><?php echo htmlspecialchars($patient['gender']); ?></td>
                            <td><?php echo htmlspecialchars($patient['phone']); ?></td>
                            <td class="actions">
                                <a href="../patient-info/edit.php?id=<?php echo $patient['patient_id']; ?>">Edit</a>
                                <a href="patient_results.php?id=<?php echo $patient['patient_id']; ?>">View Tests</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        
        <?php if (empty($search_term) && $total_pages > 1): ?>
            <div class="pagination">
                <?php if ($current_page > 1): ?>
                    <a href="patient_list.php?page=1">First</a>
                    <a href="patient_list.php?page=<?php echo $current_page - 1; ?>">Previous</a>
                <?php endif; ?>
                
                <?php 
                // Show page numbers
                $start_page = max(1, $current_page - 2);
                $end_page = min($total_pages, $current_page + 2);
                
                if ($start_page > 1) {
                    echo '<a href="patient_list.php?page=1">1</a>';
                    if ($start_page > 2) {
                        echo '<span>...</span>';
                    }
                }
                
                for ($i = $start_page; $i <= $end_page; $i++) {
                    if ($i == $current_page) {
                        echo '<span class="current">' . $i . '</span>';
                    } else {
                        echo '<a href="patient_list.php?page=' . $i . '">' . $i . '</a>';
                    }
                }
                
                if ($end_page < $total_pages) {
                    if ($end_page < $total_pages - 1) {
                        echo '<span>...</span>';
                    }
                    echo '<a href="patient_list.php?page=' . $total_pages . '">' . $total_pages . '</a>';
                }
                ?>
                
                <?php if ($current_page < $total_pages): ?>
                    <a href="patient_list.php?page=<?php echo $current_page + 1; ?>">Next</a>
                    <a href="patient_list.php?page=<?php echo $total_pages; ?>">Last</a>
                <?php endif; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>