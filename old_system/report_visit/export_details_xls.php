<?php
// export_details_xls.php
session_start();
include 'db_connection.php';

// --- 1. GET FILTERS & SORTING ---
$date_from = $_GET['date_from'] ?? date('Y-m-01');
$date_to = $_GET['date_to'] ?? date('Y-m-t');
$search_term = $_GET['search_term'] ?? '';
$sort_whitelist = ['visit_date', 'patient_name', 'assessment'];
$sort_column = isset($_GET['sort']) && in_array($_GET['sort'], $sort_whitelist) ? $_GET['sort'] : 'visit_date';
$sort_order = isset($_GET['order']) && strtolower($_GET['order']) === 'asc' ? 'ASC' : 'DESC';
$sort_map = [
    'visit_date' => 'cv.visit_date',
    'patient_name' => 'p.last_name, p.first_name',
    'assessment' => 'cv.assessment'
];
$sort_sql = $sort_map[$sort_column];

// --- 2. BUILD SQL QUERY ---
$base_sql = "FROM clinic_visits cv LEFT JOIN patient_info p ON cv.patient_id = p.patient_id";
$where_conditions = [];
$bind_types = 'ss';
$bind_values = [$date_from, $date_to];
$where_conditions[] = "cv.visit_date BETWEEN ? AND ?";
if (!empty($search_term)) {
    $where_conditions[] = "(p.first_name LIKE ? OR p.last_name LIKE ? OR cv.case_number LIKE ? OR cv.review_of_systems LIKE ? OR cv.objective LIKE ? OR cv.assessment LIKE ? OR cv.plans LIKE ?)";
    $search_like = "%{$search_term}%";
    $bind_types .= 'sssssss';
    array_push($bind_values, $search_like, $search_like, $search_like, $search_like, $search_like, $search_like, $search_like);
}
$where_sql = 'WHERE ' . implode(' AND ', $where_conditions);

// --- 3. FETCH ALL DATA FOR EXPORT ---
$data_sql = "SELECT 
                cv.visit_date AS VisitDate,
                CONCAT(p.first_name, ' ', p.last_name) AS PatientName,
                cv.review_of_systems AS Subjective,
                cv.objective AS Objective,
                cv.assessment AS Assessment,
                cv.plans AS Plans
            " . $base_sql . " " . $where_sql . " ORDER BY {$sort_sql} {$sort_order}";

$stmt = mysqli_prepare($conn, $data_sql);
mysqli_stmt_bind_param($stmt, $bind_types, ...$bind_values);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

// --- 4. GENERATE XLS OUTPUT ---
$filename = "Clinical_Case_Log_" . date('Y-m-d') . ".xls";
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=\"$filename\"");

$header_printed = false;
while ($row = mysqli_fetch_assoc($result)) {
    // **MODIFIED**: Added '??' to safely handle potential NULL values before trimming.
    if (empty(trim($row['PatientName'] ?? ''))) {
        continue;
    }
    
    if (!$header_printed) {
        echo implode("\t", array_keys($row)) . "\n";
        $header_printed = true;
    }

    array_walk($row, function(&$value) {
        $safe_value = $value ?? '';
        $value = preg_replace("/\t|\r?\n/", " ", $safe_value); 
    });
    
    echo implode("\t", array_values($row)) . "\n";
}
exit();
?>