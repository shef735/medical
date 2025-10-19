<?php
// case_log_report.php
session_start();
include 'db_connection.php'; 

// --- 1. GET FILTERS, SORTING, PAGINATION, AND VIEW PARAMETERS ---
$date_from = $_GET['date_from'] ?? date('Y-m-01');
$date_to = $_GET['date_to'] ?? date('Y-m-t');
$search_term = $_GET['search_term'] ?? '';

// **MODIFIED**: Whitelist remains the same for the URL parameter
$sort_whitelist = ['visit_date', 'patient_name', 'assessment'];
$sort_column = isset($_GET['sort']) && in_array($_GET['sort'], $sort_whitelist) ? $_GET['sort'] : 'visit_date';
$sort_order = isset($_GET['order']) && strtolower($_GET['order']) === 'asc' ? 'ASC' : 'DESC';

// **NEW**: Map the URL parameter to the actual SQL sort expression for security and flexibility
$sort_map = [
    'visit_date' => 'cv.visit_date',
    'patient_name' => 'p.last_name, p.first_name', // Improved sorting
    'assessment' => 'cv.assessment'
];
$sort_sql = $sort_map[$sort_column];


$records_per_page = 10;
$current_page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
if ($current_page < 1) { $current_page = 1; }
$offset = ($current_page - 1) * $records_per_page;
$view_mode = $_GET['view'] ?? 'table';

// --- 2. BUILD DYNAMIC SQL QUERY ---
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

// --- 3. FETCH DATA ---
$count_sql = "SELECT COUNT(cv.id) as total " . $base_sql . " " . $where_sql;
$stmt_count = mysqli_prepare($conn, $count_sql);
mysqli_stmt_bind_param($stmt_count, $bind_types, ...$bind_values);
mysqli_stmt_execute($stmt_count);
$total_records = mysqli_fetch_assoc(mysqli_stmt_get_result($stmt_count))['total'] ?? 0;
$total_pages = ceil($total_records / $records_per_page);

// **MODIFIED**: Using the safe $sort_sql variable in the ORDER BY clause
$data_sql = "SELECT cv.visit_date, cv.review_of_systems, cv.objective, cv.assessment, cv.plans,
                    CONCAT(p.first_name, ' ', p.last_name) as patient_name
            " . $base_sql . " " . $where_sql . " ORDER BY {$sort_sql} {$sort_order} LIMIT ?, ?";
$stmt_data = mysqli_prepare($conn, $data_sql);
$final_bind_types = $bind_types . 'ii';
$final_bind_values = array_merge($bind_values, [$offset, $records_per_page]);
mysqli_stmt_bind_param($stmt_data, $final_bind_types, ...$final_bind_values);
mysqli_stmt_execute($stmt_data);
$visit_data = mysqli_fetch_all(mysqli_stmt_get_result($stmt_data), MYSQLI_ASSOC);

// --- HELPER FUNCTION FOR SORTING LINKS ---
function sortableHeader($title, $column, $current_sort, $current_order, $context = 'default') {
    $order = ($current_sort === $column && $current_order === 'ASC') ? 'desc' : 'asc';
    $icon_class = '';
    if ($current_sort === $column) {
        $icon_class = ($current_order === 'ASC') ? 'fas fa-sort-up' : 'fas fa-sort-down';
    }
    $query_params = http_build_query(array_merge($_GET, ['sort' => $column, 'order' => $order, 'page' => 1]));
    $link_class = ($context === 'table_header') ? "text-white text-decoration-none" : "text-decoration-none";
    return "<a href=\"?{$query_params}\" class=\"{$link_class}\">{$title} <i class=\"{$icon_class}\"></i></a>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinical Case Log</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        body { background-color: #f8f9fa; }
        .card { border: 0; box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075); border-radius: 0.5rem; }
        .main-header { border-bottom: 1px solid #dee2e6; padding-bottom: 1rem; }
        .log-entry { margin-bottom: 1.5rem; }
        .log-header { background-color: #f8f9fa; border-bottom: 1px solid #dee2e6; }
        .log-body .row { padding-bottom: 0.75rem; margin-bottom: 0.75rem; border-bottom: 1px solid #e9ecef; }
        .log-body .row:last-child { border-bottom: 0; margin-bottom: 0; padding-bottom: 0; }
        .log-label { font-weight: 600; color: #6c757d; font-size: 0.9rem; }
        .table { vertical-align: middle; }
        .table thead { position: sticky; top: 0; }
    </style>
</head>
<body>
<div class="container-fluid my-4">
    <div class="main-header d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0 h2 text-primary-emphasis"><i class="fas fa-book-medical me-2"></i> Clinical Case Log</h1>
        <div class="text-end text-muted">
            <strong></strong> GASTROHEP ENDOSCOPY UNIT <br>
            <strong>Date:</strong> <?= date("F j, Y") ?>
        </div>
    </div>
    <div class="card mb-4">
        <div class="card-body p-4">
            <form method="GET" action="" class="row g-3 align-items-end">
                <div class="col-md-3"><label for="date_from" class="form-label">From</label><input type="date" class="form-control" name="date_from" value="<?= htmlspecialchars($date_from ?? '') ?>"></div>
                <div class="col-md-3"><label for="date_to" class="form-label">To</label><input type="date" class="form-control" name="date_to" value="<?= htmlspecialchars($date_to ?? '') ?>"></div>
                <div class="col-md-3"><label for="search_term" class="form-label">Search Patient / Notes</label><input type="search" class="form-control" name="search_term" placeholder="e.g., John Doe, headache" value="<?= htmlspecialchars($search_term ?? '') ?>"></div>
                <div class="col-md-3 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100"><i class="fas fa-filter"></i> Apply</button>
                    <a href="index.php" class="btn btn-outline-secondary w-100">Reset</a>
                     <a href="../index.php" class="btn btn-outline-success w-100">Home</a>
                </div>
            </form>
        </div>
    </div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div class="text-muted">
            <strong>Sort by:</strong> 
            <?= sortableHeader('Visit Date', 'visit_date', $sort_column, $sort_order) ?> | 
            <?= sortableHeader('Patient Name', 'patient_name', $sort_column, $sort_order) ?>
        </div>
        <div class="d-flex align-items-center gap-2">
             <div class="btn-group" role="group">
                <a href="?<?= http_build_query(array_merge($_GET, ['view' => 'cards'])) ?>" class="btn btn-sm <?= $view_mode === 'cards' ? 'btn-dark' : 'btn-outline-secondary' ?>"><i class="fas fa-grip-vertical"></i> Card View</a>
                <a href="?<?= http_build_query(array_merge($_GET, ['view' => 'table'])) ?>" class="btn btn-sm <?= $view_mode === 'table' ? 'btn-dark' : 'btn-outline-secondary' ?>"><i class="fas fa-table"></i> Table View</a>
            </div>
            <a href="export_details_xls.php?<?= http_build_query($_GET) ?>" class="btn btn-success btn-sm"><i class="fas fa-file-excel"></i> Export All to XLS</a>
        </div>
    </div>

    <?php if (empty($visit_data)): ?>
        <div class="alert alert-info text-center">No visit records found for the selected criteria.</div>
    <?php else: ?>
        <?php if ($view_mode === 'cards'): ?>
            <?php foreach ($visit_data as $row): ?>
               <?php if($row['patient_name']=='') { continue; } ?>
            <div class="card log-entry">
                <div class="card-header log-header d-flex justify-content-between">
                    <h5 class="mb-0"><strong>Patient:</strong> <?= htmlspecialchars($row['patient_name'] ?? '') ?></h5>
                    <h5 class="mb-0 text-muted"><strong>Visit:</strong> <?= htmlspecialchars($row['visit_date'] ?? '') ?></h5>
                </div>
                <div class="card-body log-body p-4">
                    <div class="row"><div class="col-md-2 log-label">Subjective</div><div class="col-md-10"><?= nl2br(htmlspecialchars($row['review_of_systems'] ?? '')) ?></div></div>
                    <div class="row"><div class="col-md-2 log-label">Objective</div><div class="col-md-10"><?= nl2br(htmlspecialchars($row['objective'] ?? '')) ?></div></div>
                    <div class="row"><div class="col-md-2 log-label">Assessment</div><div class="col-md-10"><strong><?= nl2br(htmlspecialchars($row['assessment'] ?? '')) ?></strong></div></div>
                    <div class="row"><div class="col-md-2 log-label">Plans</div><div class="col-md-10"><?= nl2br(htmlspecialchars($row['plans'] ?? '')) ?></div></div>
                </div>
            </div>
            <?php endforeach; ?>

        <?php elseif ($view_mode === 'table'): ?>
            <div class="card">
                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered mb-0">
                        <thead class="table-dark">
                            <tr>
                                <th><?= sortableHeader('Visit Date', 'visit_date', $sort_column, $sort_order, 'table_header') ?></th>
                                <th><?= sortableHeader('Patient Name', 'patient_name', $sort_column, $sort_order, 'table_header') ?></th>
                                <th>Subjective</th>
                                <th>Objective</th>
                                <th><?= sortableHeader('Assessment', 'assessment', $sort_column, $sort_order, 'table_header') ?></th>
                                <th>Plans</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($visit_data as $row): ?>
                            <?php if($row['patient_name']=='') { continue; } ?>
                            <tr>
                                <td style="width: 10%;"><?= htmlspecialchars($row['visit_date'] ?? '') ?></td>
                                <td style="width: 15%;"><?= htmlspecialchars($row['patient_name'] ?? '') ?></td>
                                <td><small><?= nl2br(htmlspecialchars($row['review_of_systems'] ?? '')) ?></small></td>
                                <td><small><?= nl2br(htmlspecialchars($row['objective'] ?? '')) ?></small></td>
                                <td style="width: 15%;"><strong><?= nl2br(htmlspecialchars($row['assessment'] ?? '')) ?></strong></td>
                                <td><small><?= nl2br(htmlspecialchars($row['plans'] ?? '')) ?></small></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        <?php endif; ?>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mt-3">
        <span class="text-muted">Showing <?= $total_records > 0 ? $offset + 1 : 0 ?> to <?= min($offset + $records_per_page, $total_records) ?> of <?= $total_records ?> entries</span>
        <?php if ($total_pages > 1): ?>
        <nav>
            <ul class="pagination mb-0">
                <li class="page-item <?= ($current_page <= 1) ? 'disabled' : '' ?>"><a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $current_page - 1])) ?>">Prev</a></li>
                <li class="page-item <?= ($current_page >= $total_pages) ? 'disabled' : '' ?>"><a class="page-link" href="?<?= http_build_query(array_merge($_GET, ['page' => $current_page + 1])) ?>">Next</a></li>
            </ul>
        </nav>
        <?php endif; ?>
    </div>
</div>
</body>
</html>