<?php
include 'auth.php';
include "../../Connections/dbname.php";
include 'patients.php';
//include 'templates.php';
include 'results.php';
  

// Set default date range (last 30 days)
$start_date = isset($_GET['start_date']) ? $_GET['start_date'] : date('Y-m-d', strtotime('-30 days'));
$end_date = isset($_GET['end_date']) ? $_GET['end_date'] : date('Y-m-d');
$search_terms = isset($_GET['search']) ? trim($_GET['search']) : '';

// Process search terms
$keywords = [];
if (!empty($search_terms)) {
    $keywords = array_map('trim', explode(',', $search_terms));
    $keywords = array_filter($keywords); // Remove empty values
}

// Build the base query
$sql = "SELECT 
            p.patient_id,
            CONCAT(p.first_name, ' ', p.last_name) AS patient_name,
            p.first_name,
            p.last_name,
            p.date_of_birth,
            p.gender,
            tt.template_id,
            tt.template_name AS lab_title,
            tr.test_date,
            tr.result_id,
            GROUP_CONCAT(
                CONCAT(tf.field_name, ': ', rv.field_value) 
                ORDER BY tf.field_order SEPARATOR ' | '
            ) AS results,
            COUNT(rv.value_id) AS result_count
        FROM ".$_SESSION['my_tables']."_laboratory.test_results tr
        JOIN ".$_SESSION['my_tables']."_resources.patient_info p ON tr.patient_id = p.patient_id
        JOIN ".$_SESSION['my_tables']."_laboratory.test_templates tt ON tr.template_id = tt.template_id
        JOIN ".$_SESSION['my_tables']."_laboratory.result_values rv ON tr.result_id = rv.result_id
        JOIN ".$_SESSION['my_tables']."_laboratory.template_fields tf ON rv.field_id = tf.field_id
        WHERE tr.test_date BETWEEN '$start_date' AND '$end_date'";

// Add search conditions if keywords exist
if (!empty($keywords)) {
    $search_conditions = [];
    foreach ($keywords as $keyword) {
        $safe_keyword = mysqli_real_escape_string($conn, $keyword);
        $search_conditions[] = "(
            p.first_name LIKE '%$safe_keyword%' OR 
             p.sex LIKE '%$safe_keyword%' OR 
            p.last_name LIKE '%$safe_keyword%' OR 
            tt.template_name LIKE '%$safe_keyword%' OR 
            tf.field_name LIKE '%$safe_keyword%' OR 
            rv.field_value LIKE '%$safe_keyword%'
        )";
    }
    $sql .= " AND (" . implode(' OR ', $search_conditions) . ")";
}

$sql .= " GROUP BY tr.result_id
          ORDER BY tr.test_date DESC, p.last_name, p.first_name";

$result = mysqli_query($conn, $sql);
$report_data = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Calculate keyword counts if searching
$keyword_counts = [];
if (!empty($keywords)) {
    foreach ($keywords as $keyword) {
        $count = 0;
        $safe_keyword = mysqli_real_escape_string($conn, $keyword);
        
        // Count in patients
        $sql = "SELECT COUNT(*) as count FROM ".$_SESSION['my_tables']."_resources.patient_info
                WHERE first_name LIKE '%$safe_keyword%' OR last_name LIKE '%$safe_keyword%'";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($res);
        $count += $row['count'];
        
        // Count in templates
        $sql = "SELECT COUNT(*) as count FROM ".$_SESSION['my_tables']."_laboratory.test_templates 
                WHERE template_name LIKE '%$safe_keyword%'";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($res);
        $count += $row['count'];
        
        // Count in results
        $sql = "SELECT COUNT(*) as count FROM ".$_SESSION['my_tables']."_laboratory.result_values rv
                JOIN ".$_SESSION['my_tables']."_laboratory.template_fields tf ON rv.field_id = tf.field_id
                WHERE rv.field_value LIKE '%$safe_keyword%' OR tf.field_name LIKE '%$safe_keyword%'";
        $res = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($res);
        $count += $row['count'];
        
        $keyword_counts[$keyword] = $count;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Laboratory Test Results Report</title>
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
            margin-top: 0;
            color: #333;
        }
        .filter-form {
            background-color: #f9f9f9;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 10px;
        }
        label {
            display: inline-block;
            width: 100px;
        }
        input[type="date"], input[type="text"], select {
            padding: 6px;
            border: 1px solid #ddd;
            border-radius: 4px;
            width: 200px;
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
        .action-link {
            color: #2196F3;
            text-decoration: none;
            margin-right: 10px;
        }
        .action-link:hover {
            text-decoration: underline;
        }
        .pdf-link {
            color: #e74c3c;
        }
        .age {
            white-space: nowrap;
        }
        .search-highlight {
            background-color: yellow;
            font-weight: bold;
        }
        .keyword-summary {
            background-color: #e6f7ff;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 15px;
        }
        .keyword-tag {
            display: inline-block;
            background-color: #d4edff;
            padding: 3px 8px;
            border-radius: 3px;
            margin-right: 5px;
            margin-bottom: 5px;
        }
        .keyword-count {
            font-weight: bold;
            color: #0056b3;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Laboratory Test Results Report</h1>
        
        <div class="filter-form">
            <form method="get">
                <div class="form-group">
                    <label for="start_date">From:</label>
                    <input type="date" id="start_date" name="start_date" value="<?php echo $start_date; ?>">
                </div>
                <div class="form-group">
                    <label for="end_date">To:</label>
                    <input type="date" id="end_date" name="end_date" value="<?php echo $end_date; ?>">
                </div>
                <div class="form-group">
                    <label for="search">Search:</label>
                    <input type="text" id="search" name="search" value="<?php echo htmlspecialchars($search_terms); ?>" 
                           placeholder="Enter keywords separated by commas">
                </div>
                <button style="background-color: blue;" class="btn-close" type="submit">Filter</button>
                 <a href="index.php" class="btn-close">Home</a>
                <!-- <a href="report_export.php?start_date=<?php  //echo $start_date; ?>&end_date=<?php // echo $end_date; ?>&search=<?php echo urlencode($search_terms); ?>" 
                   class="action-link pdf-link" style="margin-left: 20px;">Export to PDF</a> -->
            </form>
        </div>
        
        <?php if (!empty($keywords)): ?>
            <div class="keyword-summary">
                <h3>Search Results Summary</h3>
                <p>Found <?php echo count($report_data); ?> records matching:</p>
                <?php // foreach ($keyword_counts as $keyword => $count): ?>
                   <!-- <span class="keyword-tag">
                        "<?php // echo htmlspecialchars($keyword); ?>" 
                        <span class="keyword-count">(<?php // echo $count; ?> matches)</span>
                    </span> -->
                <?php // endforeach; ?>
            </div>
        <?php endif; ?>
        
        <table>
            <thead>
                <tr>
                    <th>Patient Name</th>
                    <th>Age</th>
                    <th>Gender</th>
                    <th>Lab Test</th>
                    <th>Test Date</th>
                    <th>Results</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($report_data as $row): ?>
                    <tr>
                        <td>
                            <?php 
                            $patient_name = htmlspecialchars($row['patient_name']);
                            if (!empty($keywords)) {
                                foreach ($keywords as $keyword) {
                                    $patient_name = preg_replace(
                                        "/(" . preg_quote($keyword, '/') . ")/i", 
                                        '<span class="search-highlight">$1</span>', 
                                        $patient_name
                                    );
                                }
                            }
                            echo $patient_name;
                            ?>
                        </td>
                        <td class="age">
                            <?php 
                            if (!empty($row['date_of_birth'])) {
                                $dob = new DateTime($row['date_of_birth']);
                                $now = new DateTime();
                                echo $dob->diff($now)->y;
                            } else {
                                echo 'N/A';
                            }
                            ?>
                        </td>
                        <td><?php echo htmlspecialchars($row['gender']); ?></td>
                        <td>
                            <?php 
                            $lab_title = htmlspecialchars($row['lab_title']);
                            if (!empty($keywords)) {
                                foreach ($keywords as $keyword) {
                                    $lab_title = preg_replace(
                                        "/(" . preg_quote($keyword, '/') . ")/i", 
                                        '<span class="search-highlight">$1</span>', 
                                        $lab_title
                                    );
                                }
                            }
                            echo $lab_title;
                            ?>
                        </td>
                        <td><?php echo date('M j, Y', strtotime($row['test_date'])); ?></td>
                        <td>
                            <?php 
                            // Highlight keywords in results
                            $results = explode(' | ', $row['results']);
                            $max_preview = 3;
                            $display_results = array_slice($results, 0, $max_preview);
                            
                            foreach ($display_results as &$result) {
                                $result = htmlspecialchars($result);
                                if (!empty($keywords)) {
                                    foreach ($keywords as $keyword) {
                                        $result = preg_replace(
                                            "/(" . preg_quote($keyword, '/') . ")/i", 
                                            '<span class="search-highlight">$1</span>', 
                                            $result
                                        );
                                    }
                                }
                            }
                            
                            echo implode(' | ', $display_results);
                            
                            if (count($results) > $max_preview) {
                                echo '... <a href="view_result.php?id='.$row['result_id'].'" class="action-link">(Show all '.$row['result_count'].')</a>';
                            }
                            ?>
                        </td>
                        <td>
                            <a target="_blank" href="view_result.php?id=<?php echo $row['result_id']; ?>" class="action-link">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <?php if (empty($report_data)): ?>
            <p style="text-align: center; margin-top: 20px;">
                No test results found <?php echo !empty($search_terms) ? 'matching your search criteria' : 'for the selected date range'; ?>.
            </p>
        <?php endif; ?>
    </div>
</body>
</html>