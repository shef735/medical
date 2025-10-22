<?php
include 'config.php';

$sql = "SELECT * FROM doctor_info ORDER BY last_name, first_name";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doctor List</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --accent-color: #e74c3c;
            --light-gray: #f8f9fa;
            --medium-gray: #e9ecef;
            --dark-gray: #495057;
            --text-color: #333;
            --white: #fff;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Roboto', sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--light-gray);
            padding: 20px;
        }
        
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background-color: var(--white);
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }
        
        h2 {
            color: var(--primary-color);
            margin-bottom: 20px;
            padding-bottom: 10px;
            border-bottom: 1px solid var(--medium-gray);
        }
        
        .header-actions {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: var(--primary-color);
            color: var(--white);
            text-decoration: none;
            border-radius: 4px;
            transition: background-color 0.3s;
            border: none;
            cursor: pointer;
            font-size: 14px;
        }
        
        .btn:hover {
            background-color: var(--secondary-color);
        }
        
        .btn-danger {
            background-color: var(--accent-color);
        }
        
        .btn-danger:hover {
            background-color: #c0392b;
        }
        
        .btn i {
            margin-right: 5px;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 14px;
        }
        
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid var(--medium-gray);
        }
        
        th {
            background-color: var(--primary-color);
            color: var(--white);
            font-weight: 500;
            text-transform: uppercase;
            font-size: 12px;
            letter-spacing: 0.5px;
        }
        
        tr:hover {
            background-color: rgba(52, 152, 219, 0.05);
        }
        
        .action-links a {
            color: var(--primary-color);
            text-decoration: none;
            margin-right: 10px;
            transition: color 0.3s;
        }
        
        .action-links a:hover {
            color: var(--secondary-color);
            text-decoration: underline;
        }
        
        .action-links a.delete {
            color: var(--accent-color);
        }
        
        .action-links a.delete:hover {
            color: #c0392b;
        }
        
        .doctor-photo {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid var(--medium-gray);
        }
        
        .no-photo {
            display: inline-block;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background-color: var(--medium-gray);
            text-align: center;
            line-height: 60px;
            color: var(--dark-gray);
            font-size: 12px;
        }
        
        .status-badge {
            display: inline-block;
            padding: 3px 8px;
            border-radius: 12px;
            font-size: 12px;
            font-weight: 500;
        }
        
        .status-active {
            background-color: #d4edda;
            color: #155724;
        }
        
        .status-inactive {
            background-color: #f8d7da;
            color: #721c24;
        }
        
        .search-container {
            margin-bottom: 20px;
            position: relative;
        }
        
        .search-input {
            padding: 10px 15px 10px 40px;
            width: 300px;
            border: 1px solid var(--medium-gray);
            border-radius: 4px;
            font-size: 14px;
            transition: all 0.3s;
        }
        
        .search-input:focus {
            border-color: var(--primary-color);
            outline: none;
            box-shadow: 0 0 0 2px rgba(52, 152, 219, 0.2);
        }
        
        .search-icon {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--dark-gray);
        }
        
        .no-results {
            display: none;
            text-align: center;
            padding: 20px;
            color: var(--accent-color);
            font-weight: 500;
        }
        
        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
        }
        
        .pagination li {
            margin: 0 5px;
        }
        
        .pagination a {
            display: block;
            padding: 8px 12px;
            background-color: var(--white);
            border: 1px solid var(--medium-gray);
            border-radius: 4px;
            color: var(--primary-color);
            text-decoration: none;
        }
        
        .pagination a.active {
            background-color: var(--primary-color);
            color: var(--white);
            border-color: var(--primary-color);
        }
        
        @media (max-width: 768px) {
            table {
                display: block;
                overflow-x: auto;
            }
            
            .header-actions {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .search-container {
                width: 100%;
                margin-bottom: 15px;
            }
            
            .search-input {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="container">
     <a style="float: right; background-color:green" href="../index.php" class="btn"><i class="fas fa-home"></i> Home</a>
        <h2><i class="fas fa-user-md"></i> Doctor Management</h2>
        
        <div class="header-actions">
            <div class="search-container">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" id="doctorSearch" placeholder="Search doctors...">
            </div>
            <a href="create_doctor.php" class="btn"><i class="fas fa-plus"></i> Add New Doctor</a>
            
        </div>
        
        <div class="no-results" id="noResults">
            <i class="fas fa-exclamation-circle"></i> No doctors found matching your search
        </div>
        
        <table id="doctorTable">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Specialty</th>
                    <th>Contact</th>
                    <th>Details</th>
                    <th>Photo</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>
                            <td>".$row['user_id']."</td>
                            <td>
                                <strong>".$row['suffix']." ".$row['last_name'].", ".$row['first_name']." ".$row['middle_name']."</strong>
                            </td>
                            <td>".$row['specialists']."</td>
                            <td>
                                <div><i class='fas fa-phone'></i> ".$row['phone']."</div>
                                <div><i class='fas fa-envelope'></i> ".$row['email']."</div>
                            </td>
                            <td>
                                <div><i class='fas fa-venus-mars'></i> ".$row['sex']."</div>
                                <div><i class='fas fa-birthday-cake'></i> ".$row['birthday']."</div>
                                <div><i class='fas fa-map-marker-alt'></i> ".$row['address']."</div>
                            </td>
                            <td>";
                        if ($row['photo']) {
                            echo "<img src='".$row['photo']."' alt='Doctor Photo' class='doctor-photo'>";
                        } else {
                            echo "<div class='no-photo'>No photo</div>";
                        }
                        echo "</td>
                            <td class='action-links'>
                                <a href='update_doctor.php?id=".$row['user_id']."' title='Edit'><i class='fas fa-edit'></i> Edit</a>
                                <a href='delete_doctor.php?id=".$row['user_id']."' class='delete' title='Delete' onclick='return confirm(\"Are you sure you want to delete this doctor?\")'><i class='fas fa-trash-alt'></i> Delete</a>
                            </td>
                        </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' style='text-align: center;'>No doctors found in the database</td></tr>";
                }
                $conn->close();
                ?>
            </tbody>
        </table>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('doctorSearch');
            const table = document.getElementById('doctorTable');
            const noResults = document.getElementById('noResults');
            const rows = table.getElementsByTagName('tbody')[0].getElementsByTagName('tr');
            
            searchInput.addEventListener('input', function() {
                const searchTerm = this.value.toLowerCase();
                let hasResults = false;
                
                for (let i = 0; i < rows.length; i++) {
                    const row = rows[i];
                    const cells = row.getElementsByTagName('td');
                    let rowMatches = false;
                    
                    // Skip the "No doctors found" row if it exists
                    if (cells.length <= 1) continue;
                    
                    // Check each cell in the row (except the last one with actions)
                    for (let j = 0; j < cells.length - 1; j++) {
                        const cellText = cells[j].textContent.toLowerCase();
                        if (cellText.includes(searchTerm)) {
                            rowMatches = true;
                            break;
                        }
                    }
                    
                    if (rowMatches) {
                        row.style.display = '';
                        hasResults = true;
                    } else {
                        row.style.display = 'none';
                    }
                }
                
                // Show/hide no results message
                if (!hasResults && searchTerm.length > 0) {
                    noResults.style.display = 'block';
                    table.style.display = 'none';
                } else {
                    noResults.style.display = 'none';
                    table.style.display = 'table';
                }
            });
        });
    </script>
</body>
</html>