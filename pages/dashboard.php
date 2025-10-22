<?php
session_start();
ini_set('memory_limit', '-1');
include ("config.php");

// Pagination settings
$records_per_page = 10;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max(1, $page); // Ensure page is at least 1
$offset = ($page - 1) * $records_per_page;

// Search and filter parameters
$patient_search = isset($_GET['patient_search']) ? mysqli_real_escape_string($conn, $_GET['patient_search']) : '';
$general_search = isset($_GET['general_search']) ? mysqli_real_escape_string($conn, $_GET['general_search']) : '';
$age_filter = isset($_GET['age_filter']) ? $_GET['age_filter'] : '';
$date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
$date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';
$complications_filter = isset($_GET['complications_filter']) ? $_GET['complications_filter'] : '';

// Build the base query
$sql = "
    SELECT 
        pr.*, 
        pr.user_id AS id_pat,
        CONCAT(pr.last_name, ', ', pr.first_name) AS fullname, 
        eims.eims1,
        com.complications,
        sur.surgery,
        beh.behaviorcd,
        man.management,
        mayo.mayoscore,
        DATE_FORMAT(pr.birthday, '%m/%d/%Y') AS formatted_bday,
        DATE_FORMAT(pr.date, '%m/%d/%Y') AS formatted_date,
        TIMESTAMPDIFF(YEAR, pr.birthday, CURDATE()) AS age,
        
        -- Latest clinic visit data
        cv_latest.review_of_systems AS latest_review_of_systems,
        cv_latest.objective AS latest_objective,
        cv_latest.assessment AS latest_assessment,
        cv_latest.plans AS latest_plans,
        cv_latest.visit_date AS latest_visit_date,
        cv_latest.notes AS latest_visit_notes,
        
        GROUP_CONCAT(DISTINCT 
            CONCAT(
                DATE_FORMAT(pn.created_date, '%m/%d/%Y %h:%i %p'), 
                ' - ', 
                pn.note_content 
            ) 
            SEPARATOR '</br>'
        ) AS formatted_notes,
         
        GROUP_CONCAT(DISTINCT 
            CONCAT(
                vd.notes, '</br>', vd.document_type, '</br>', vd.file_path
            )
            SEPARATOR '</br>'
        ) AS visit_documents_data,

        GROUP_CONCAT(DISTINCT 
            CONCAT(
                CASE WHEN rcc.chiefcomplaint != '' THEN CONCAT(rcc.chiefcomplaint,'- ') ELSE '' END,
                CASE WHEN rcc.othersymptoms1 != '' THEN CONCAT(rcc.othersymptoms1,'- ') ELSE '' END,
                CASE WHEN rcc.othersymptoms2  != '' THEN CONCAT(rcc.othersymptoms2) ELSE '' END
            )
            SEPARATOR '</br>'
        ) AS chief_complaints_data,
        
        GROUP_CONCAT(DISTINCT 
            CONCAT(
                rd.diagnosis1, ' ', rd.attending, ' ', rd.hospital 
            )
            SEPARATOR '</br>'
        ) AS diagnoses_data,

        GROUP_CONCAT(DISTINCT 
            CONCAT(
                pit.initialtreatment,
                CASE WHEN pit.improvement != '' THEN CONCAT(' Improvement: ', pit.improvement) ELSE '' END,
                CASE WHEN pit.additionaltreatment != '' THEN CONCAT(' Additional: ', pit.additionaltreatment) ELSE '' END
            )
            SEPARATOR '</br>'
        ) AS treatment,
        
        GROUP_CONCAT(DISTINCT 
            CONCAT(
               cr.created_at, ' ', 'BP: ',cr.bp, ' ', 'WT:',cr.weight_kg, ' ', 'HT:',cr.height_cm 
            )
            SEPARATOR '</br>'
        ) AS clinical_readings_data,
        
        GROUP_CONCAT(DISTINCT
            CONCAT(
                cv.review_of_systems, '</br>',cv.objective, '</br>',cv.assessment, '</br>',cv.plans, '</br>', cv.visit_date, '</br>', cv.notes 
            )
            SEPARATOR '</br>'
        ) AS clinic_visits_data,
        
        GROUP_CONCAT(DISTINCT
            CONCAT(
                lr.tests_requested, '</br>', 
                lr.request_date, '</br>', 
                lr.lab_notes, '</br>', 
                lr.created_at
            )
            SEPARATOR '</br>'
        ) AS lab_requests_data,
        
        GROUP_CONCAT(DISTINCT 
            CONCAT(
                m.medication_name, '', m.dosage, ' ', m.frequency 
            )
            SEPARATOR '</br>'
        ) AS medications_data,
        
        GROUP_CONCAT(DISTINCT 
            CONCAT(
                df.document_name, '</br>', df.document_type, '</br>', df.file_path, '</br>', df.notes, '</br>', df.created_at 
            )
            SEPARATOR '</br>'
        ) AS documents_forms_data
        
    FROM 
        ".$main_table_use."_resources.patient_info pr
    
    -- Join for latest clinic visit
    LEFT JOIN (
        SELECT 
            cv1.user_id,
            cv1.patient_id,
            cv1.review_of_systems,
            cv1.objective,
            cv1.assessment,
            cv1.plans,
            cv1.visit_date,
            cv1.notes
        FROM clinic_visits cv1
        INNER JOIN (
            SELECT user_id,
                patient_id, 
                MAX(visit_date) as max_visit_date
            FROM clinic_visits 
            GROUP BY user_id
        ) cv2 ON cv1.user_id = cv2.user_id AND cv1.visit_date = cv2.max_visit_date
    ) cv_latest ON pr.user_id = cv_latest.user_id
    
    LEFT JOIN ".$main_table_use."_resources.patient_record pd ON COALESCE(pr.user_id, '') = COALESCE(pd.user_id, '')
    LEFT JOIN ".$main_table_use."_resources.patient_notes pn ON pr.user_id = pn.patient_id
    LEFT JOIN ".$main_table_use."_resources.record_treatment pit ON pr.user_id = pit.user_id
    LEFT JOIN ".$main_table_use."_resources.record_eims eims ON pr.user_id = eims.user_id
    LEFT JOIN ".$main_table_use."_resources.record_behaviour beh ON pr.user_id = beh.user_id
    LEFT JOIN ".$main_table_use."_resources.record_surgical sur ON pr.user_id = sur.user_id
    LEFT JOIN ".$main_table_use."_resources.record_management man ON pr.user_id = man.user_id
    LEFT JOIN ".$main_table_use."_resources.record_complications com ON pr.user_id = com.user_id
    LEFT JOIN ".$_SESSION['my_tables']."_laboratory.test_results tr ON pr.user_id = tr.patient_id
    LEFT JOIN ".$_SESSION['my_tables']."_resources.record_mayo mayo ON pr.user_id = mayo.user_id
    LEFT JOIN visit_documents vd ON pr.user_id = vd.user_id
    LEFT JOIN record_chief_complaint rcc ON pr.user_id = rcc.user_id
    LEFT JOIN record_diagnosis rd ON pr.user_id = rd.user_id
    LEFT JOIN clinical_readings cr ON pr.user_id = cr.user_id
    LEFT JOIN clinic_visits cv ON pr.user_id = cv.user_id
    LEFT JOIN lab_requests lr ON pr.user_id = lr.user_id
    LEFT JOIN medications m ON pr.user_id = m.user_id
    LEFT JOIN documents_forms df ON pr.user_id = df.user_id
    
    WHERE 1=1
";

// Add search filters - SEPARATED searches
if (!empty($patient_search)) {
    $sql .= " AND (
        pr.last_name LIKE '%$patient_search%' 
        OR pr.first_name LIKE '%$patient_search%' 
        OR CONCAT(pr.last_name, ', ', pr.first_name) LIKE '%$patient_search%'
    )";
}

if (!empty($general_search)) {
    $sql .= " AND (
        pr.address LIKE '%$general_search%'
        OR pr.email LIKE '%$general_search%'
        OR eims.eims1 LIKE '%$general_search%'
        OR com.complications LIKE '%$general_search%'
        OR sur.surgery LIKE '%$general_search%'
        OR beh.behaviorcd LIKE '%$general_search%'
        OR man.management LIKE '%$general_search%'
        OR mayo.mayoscore LIKE '%$general_search%'
        OR pn.note_content LIKE '%$general_search%'
        OR vd.notes LIKE '%$general_search%'
        OR vd.document_type LIKE '%$general_search%'
        OR rcc.chiefcomplaint LIKE '%$general_search%'
        OR rcc.othersymptoms1 LIKE '%$general_search%'
        OR rcc.othersymptoms2 LIKE '%$general_search%'
        OR rd.diagnosis1 LIKE '%$general_search%'
        OR rd.attending LIKE '%$general_search%'
        OR rd.hospital LIKE '%$general_search%'
        OR pit.initialtreatment LIKE '%$general_search%'
        OR pit.improvement LIKE '%$general_search%'
        OR pit.additionaltreatment LIKE '%$general_search%'
        OR cr.bp LIKE '%$general_search%'
        OR cr.weight_kg LIKE '%$general_search%'
        OR cr.height_cm LIKE '%$general_search%'
        OR cv.review_of_systems LIKE '%$general_search%'
        OR cv.objective LIKE '%$general_search%'
        OR cv.assessment LIKE '%$general_search%'
        OR cv.plans LIKE '%$general_search%'
        OR cv.notes LIKE '%$general_search%'
        OR lr.tests_requested LIKE '%$general_search%'
        OR lr.lab_notes LIKE '%$general_search%'
        OR m.medication_name LIKE '%$general_search%'
        OR m.dosage LIKE '%$general_search%'
        OR m.frequency LIKE '%$general_search%'
        OR df.document_name LIKE '%$general_search%'
        OR df.document_type LIKE '%$general_search%'
        OR df.notes LIKE '%$general_search%'
    )";
}

if (!empty($age_filter)) {
    switch($age_filter) {
        case 'child': $sql .= " AND TIMESTAMPDIFF(YEAR, pr.birthday, CURDATE()) < 18"; break;
        case 'adult': $sql .= " AND TIMESTAMPDIFF(YEAR, pr.birthday, CURDATE()) BETWEEN 18 AND 65"; break;
        case 'senior': $sql .= " AND TIMESTAMPDIFF(YEAR, pr.birthday, CURDATE()) > 65"; break;
    }
}

if (!empty($date_from)) {
    $sql .= " AND pr.date >= '$date_from'";
}

if (!empty($date_to)) {
    $sql .= " AND pr.date <= '$date_to'";
}

if (!empty($complications_filter)) {
    $sql .= " AND com.complications LIKE '%$complications_filter%'";
}

$sql .= " GROUP BY pr.user_id ORDER BY pr.last_name";

// Get total count for pagination
$count_sql = "SELECT COUNT(DISTINCT pr.user_id) as total 
    FROM ".$main_table_use."_resources.patient_info pr
    LEFT JOIN (
        SELECT 
            cv1.user_id,
            cv1.patient_id,
            cv1.review_of_systems,
            cv1.objective,
            cv1.assessment,
            cv1.plans,
            cv1.visit_date,
            cv1.notes
        FROM clinic_visits cv1
        INNER JOIN (
            SELECT user_id,
                patient_id, 
                MAX(visit_date) as max_visit_date
            FROM clinic_visits 
            GROUP BY patient_id
        ) cv2 ON cv1.user_id = cv2.user_id AND cv1.visit_date = cv2.max_visit_date
    ) cv_latest ON pr.user_id = cv_latest.user_id
    LEFT JOIN ".$main_table_use."_resources.patient_record pd ON COALESCE(pr.user_id, '') = COALESCE(pd.user_id, '')
    LEFT JOIN ".$main_table_use."_resources.patient_notes pn ON pr.user_id = pn.patient_id
    LEFT JOIN ".$main_table_use."_resources.record_treatment pit ON pr.user_id = pit.user_id
    LEFT JOIN ".$main_table_use."_resources.record_eims eims ON pr.user_id = eims.user_id
    LEFT JOIN ".$main_table_use."_resources.record_behaviour beh ON pr.user_id = beh.user_id
    LEFT JOIN ".$main_table_use."_resources.record_surgical sur ON pr.user_id = sur.user_id
    LEFT JOIN ".$main_table_use."_resources.record_management man ON pr.user_id = man.user_id
    LEFT JOIN ".$main_table_use."_resources.record_complications com ON pr.user_id = com.user_id
    LEFT JOIN ".$_SESSION['my_tables']."_laboratory.test_results tr ON pr.user_id = tr.patient_id
    LEFT JOIN ".$_SESSION['my_tables']."_resources.record_mayo mayo ON pr.user_id = mayo.user_id
    LEFT JOIN visit_documents vd ON pr.user_id = vd.user_id
    LEFT JOIN record_chief_complaint rcc ON pr.user_id = rcc.user_id
    LEFT JOIN record_diagnosis rd ON pr.user_id = rd.user_id
    LEFT JOIN clinical_readings cr ON pr.user_id = cr.user_id
    LEFT JOIN clinic_visits cv ON pr.user_id = cv.patient_id
    LEFT JOIN lab_requests lr ON pr.user_id = lr.user_id
    LEFT JOIN medications m ON pr.user_id = m.user_id
    LEFT JOIN documents_forms df ON pr.user_id = df.user_id
    WHERE 1=1";

// Add the same WHERE conditions to count query
if (!empty($patient_search)) {
    $count_sql .= " AND (
        pr.last_name LIKE '%$patient_search%' 
        OR pr.first_name LIKE '%$patient_search%' 
        OR CONCAT(pr.last_name, ', ', pr.first_name) LIKE '%$patient_search%'
    )";
}

if (!empty($general_search)) {
    $count_sql .= " AND (
        pr.address LIKE '%$general_search%'
        OR pr.email LIKE '%$general_search%'
        OR eims.eims1 LIKE '%$general_search%'
        OR com.complications LIKE '%$general_search%'
        OR sur.surgery LIKE '%$general_search%'
        OR beh.behaviorcd LIKE '%$general_search%'
        OR man.management LIKE '%$general_search%'
        OR mayo.mayoscore LIKE '%$general_search%'
        OR pn.note_content LIKE '%$general_search%'
        OR vd.notes LIKE '%$general_search%'
        OR vd.document_type LIKE '%$general_search%'
        OR rcc.chiefcomplaint LIKE '%$general_search%'
        OR rcc.othersymptoms1 LIKE '%$general_search%'
        OR rcc.othersymptoms2 LIKE '%$general_search%'
        OR rd.diagnosis1 LIKE '%$general_search%'
        OR rd.attending LIKE '%$general_search%'
        OR rd.hospital LIKE '%$general_search%'
        OR pit.initialtreatment LIKE '%$general_search%'
        OR pit.improvement LIKE '%$general_search%'
        OR pit.additionaltreatment LIKE '%$general_search%'
        OR cr.bp LIKE '%$general_search%'
        OR cr.weight_kg LIKE '%$general_search%'
        OR cr.height_cm LIKE '%$general_search%'
        OR cv.review_of_systems LIKE '%$general_search%'
        OR cv.objective LIKE '%$general_search%'
        OR cv.assessment LIKE '%$general_search%'
        OR cv.plans LIKE '%$general_search%'
        OR cv.notes LIKE '%$general_search%'
        OR lr.tests_requested LIKE '%$general_search%'
        OR lr.lab_notes LIKE '%$general_search%'
        OR m.medication_name LIKE '%$general_search%'
        OR m.dosage LIKE '%$general_search%'
        OR m.frequency LIKE '%$general_search%'
        OR df.document_name LIKE '%$general_search%'
        OR df.document_type LIKE '%$general_search%'
        OR df.notes LIKE '%$general_search%'
    )";
}

if (!empty($age_filter)) {
    switch($age_filter) {
        case 'child': $count_sql .= " AND TIMESTAMPDIFF(YEAR, pr.birthday, CURDATE()) < 18"; break;
        case 'adult': $count_sql .= " AND TIMESTAMPDIFF(YEAR, pr.birthday, CURDATE()) BETWEEN 18 AND 65"; break;
        case 'senior': $count_sql .= " AND TIMESTAMPDIFF(YEAR, pr.birthday, CURDATE()) > 65"; break;
    }
}

if (!empty($date_from)) {
    $count_sql .= " AND pr.date >= '$date_from'";
}

if (!empty($date_to)) {
    $count_sql .= " AND pr.date <= '$date_to'";
}

if (!empty($complications_filter)) {
    $count_sql .= " AND com.complications LIKE '%$complications_filter%'";
}

$count_result = mysqli_query($conn, $count_sql);
if ($count_result && mysqli_num_rows($count_result) > 0) {
    $total_count_data = mysqli_fetch_assoc($count_result);
    $total_count = $total_count_data['total'];
} else {
    $total_count = 0;
}

$total_pages = ceil($total_count / $records_per_page);

// Add pagination to main query
$sql .= " LIMIT $offset, $records_per_page";

// Execute query
$result = mysqli_query($conn, $sql);
$displayed_patients = $result ? mysqli_num_rows($result) : 0;

// Analysis data
$analysis_sql = "SELECT 
    COUNT(*) as total,
    AVG(TIMESTAMPDIFF(YEAR, birthday, CURDATE())) as avg_age,
    COUNT(DISTINCT CASE WHEN com.complications IS NOT NULL AND com.complications != '' THEN pr.user_id END) as with_complications,
    COUNT(DISTINCT CASE WHEN sur.surgery IS NOT NULL AND sur.surgery != '' THEN pr.user_id END) as with_surgery
    FROM ".$main_table_use."_resources.patient_info pr
    LEFT JOIN ".$main_table_use."_resources.record_complications com ON pr.user_id = com.user_id
    LEFT JOIN ".$main_table_use."_resources.record_surgical sur ON pr.user_id = sur.user_id";

$analysis_result = mysqli_query($conn, $analysis_sql);
$analysis_data = $analysis_result ? mysqli_fetch_assoc($analysis_result) : ['total' => 0, 'avg_age' => 0, 'with_complications' => 0, 'with_surgery' => 0];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Report Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .dashboard-card {
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .dashboard-card:hover {
            transform: translateY(-5px);
        }
        .patient-table {
            font-size: 0.9rem;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(0,0,0,0.075);
        }
        .search-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }
        .stat-card {
            text-align: center;
            padding: 15px;
        }
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .collapse-content {
            max-height: 200px;
            overflow-y: auto;
            background: #f8f9fa;
            padding: 10px;
            border-radius: 5px;
            font-size: 0.85rem;
        }
        .badge-custom {
            font-size: 0.75rem;
        }
        .pagination .page-link {
            border-radius: 5px;
            margin: 0 2px;
        }
        .pagination-info {
            font-size: 0.9rem;
            color: #6c757d;
        }
        .clinic-visit-section {
            background: #f8f9fa;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container-fluid py-4">
        <!-- Header -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="h3 text-primary">
                        <i class="fas fa-heartbeat me-2"></i>Patient Report Dashboard
                    </h1>

                     
                    <div class="text-muted">
                        
                        

                         <a href="index.php" class="btn btn-success">
                            <i class="fas fa-home me-1"></i>Home <i class="fas fa-calendar me-1"></i><?php echo date('F j, Y'); ?>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Analysis Dashboard -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card dashboard-card border-primary">
                    <div class="card-body stat-card">
                        <div class="stat-number text-primary"><?php echo $analysis_data['total']; ?></div>
                        <div class="text-muted">Total Patients</div>
                        <i class="fas fa-users fa-2x text-primary mt-2"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card dashboard-card border-success">
                    <div class="card-body stat-card">
                        <div class="stat-number text-success"><?php echo round($analysis_data['avg_age'], 1); ?></div>
                        <div class="text-muted">Average Age</div>
                        <i class="fas fa-chart-line fa-2x text-success mt-2"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card dashboard-card border-warning">
                    <div class="card-body stat-card">
                        <div class="stat-number text-warning"><?php echo $analysis_data['with_complications']; ?></div>
                        <div class="text-muted">With Complications</div>
                        <i class="fas fa-exclamation-triangle fa-2x text-warning mt-2"></i>
                    </div>
                </div>
            </div>
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card dashboard-card border-info">
                    <div class="card-body stat-card">
                        <div class="stat-number text-info"><?php echo $analysis_data['with_surgery']; ?></div>
                        <div class="text-muted">Underwent Surgery</div>
                        <i class="fas fa-procedures fa-2x text-info mt-2"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Search and Filter Section -->
        <div class="search-section text-white mb-4">
            <form method="GET" action="" class="row g-3">
                <!-- Separate Patient Name Search -->
                <div class="col-md-2">
                    <label class="form-label">
                        <i class="fas fa-user me-1"></i>Search Patient Name
                    </label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="patient_search" value="<?php echo htmlspecialchars($patient_search); ?>"  >
                        <button class="btn btn-light" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <small class="form-text" style="color: white;">Search by first name or last name only</small>
                </div>
                
                <!-- General Search (for all other fields) -->
                <div class="col-md-2">
                    <label class="form-label">
                        <i class="fas fa-search me-1"></i>Search All Other Fields
                    </label>
                    <div class="input-group">
                        <input type="text" class="form-control" name="general_search" value="<?php echo htmlspecialchars($general_search); ?>" >
                        <button class="btn btn-light" type="submit">
                            <i class="fas fa-search"></i>
                        </button>
                    </div>
                    <small class="form-text" style="color: white;">Searches diagnoses, medications, notes, complications, etc.</small>
                </div>
                
                <div class="col-md-2">
                    <label class="form-label">Age Group</label>
                    <select class="form-select" name="age_filter">
                        <option value="">All Ages</option>
                        <option value="child" <?php echo $age_filter == 'child' ? 'selected' : ''; ?>>Child (<18)</option>
                        <option value="adult" <?php echo $age_filter == 'adult' ? 'selected' : ''; ?>>Adult (18-65)</option>
                        <option value="senior" <?php echo $age_filter == 'senior' ? 'selected' : ''; ?>>Senior (>65)</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Date From</label>
                    <input type="date" class="form-control" name="date_from" value="<?php echo $date_from; ?>">
                </div>
                <div class="col-md-2">
                    <label class="form-label">Date To</label>
                    <input type="date" class="form-control" name="date_to" value="<?php echo $date_to; ?>">
                </div>
                <div class="col-md-2">
                 <label class="form-label">Action</label>
                    <div class="d-flex gap-2">
                    
                        <button type="submit" class="btn btn-light">
                            <i class="fas fa-filter me-1"></i>Apply Filters
                        </button>
                        <a href="?" class="btn btn-outline-light">
                            <i class="fas fa-redo me-1"></i>Reset
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Results Summary -->
        <div class="row mb-3">
            <div class="col-12">
                <div class="alert alert-info d-flex justify-content-between align-items-center">
                    <div>
                        <i class="fas fa-info-circle me-2"></i>
                        Showing <strong><?php echo $displayed_patients; ?></strong> of <strong><?php echo $total_count; ?></strong> patients
                        (Page <?php echo $page; ?> of <?php echo $total_pages; ?>)
                        <?php if($patient_search || $general_search || $age_filter || $date_from || $date_to || $complications_filter): ?>
                            - <em>filtered results</em>
                        <?php endif; ?>
                    </div>
                    <button class="btn btn-sm btn-outline-info" onclick="exportToExcel()">
                        <i class="fas fa-download me-1"></i>Export
                    </button>
                </div>
            </div>
        </div>

        <!-- Patient Table -->
        <div class="card">
            <div class="card-header bg-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-table me-2"></i>Patient Records
                </h5>
                <div class="pagination-info">
                    Page <?php echo $page; ?> of <?php echo $total_pages; ?> | 
                    <?php echo $total_count; ?> total records
                </div>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover patient-table mb-0">
                        <thead class="table-light">
                            <tr>
                                <th>#</th>
                                <th>Patient Name</th>
                                <th>Age</th>
                                <th>Birthday</th>
                                <th>Registration Date</th>
                                <th>Mayo Score</th>
                                <th>Complications</th>
                                <th>Surgery</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($displayed_patients > 0): ?>
                                <?php $counter = ($page - 1) * $records_per_page + 1; ?>
                                <?php while($row = mysqli_fetch_assoc($result)): ?>
                                    <tr>
                                        <td><?php echo $counter++; ?></td>
                                        <td>
                                            <strong><?php echo htmlspecialchars($row['fullname']); ?></strong>
                                            <?php if($row['eims1']): ?>
                                                <span class="badge bg-primary badge-custom ms-1">EIMS</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo $row['age']; ?></td>
                                        <td><?php echo $row['formatted_bday']; ?></td>
                                        <td><?php echo $row['formatted_date']; ?></td>
                                        <td>
                                            <?php if($row['mayoscore']): ?>
                                                <span class="badge bg-info"><?php echo $row['mayoscore']; ?></span>
                                            <?php else: ?>
                                                <span class="text-muted">N/A</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($row['complications']): ?>
                                                <span class="badge bg-warning">Yes</span>
                                            <?php else: ?>
                                                <span class="text-muted">None</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <?php if($row['surgery']): ?>
                                                <span class="badge bg-success">Yes</span>
                                            <?php else: ?>
                                                <span class="text-muted">No</span>
                                            <?php endif; ?>
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-outline-primary" 
                                                    onclick="showPatientDetails(<?php echo htmlspecialchars(json_encode($row)); ?>)">
                                                <i class="fas fa-eye"></i> View
                                            </button>
                                        </td>
                                    </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="9" class="text-center py-4 text-muted">
                                        <i class="fas fa-search fa-2x mb-3"></i><br>
                                        No patients found matching your criteria.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            
            <!-- Pagination -->
            <?php if($total_pages > 1): ?>
            <div class="card-footer bg-white">
                <nav aria-label="Patient pagination">
                    <ul class="pagination justify-content-center mb-0">
                        <!-- Previous Page -->
                        <li class="page-item <?php echo $page <= 1 ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?<?php echo buildPaginationUrl($page-1); ?>" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        
                        <!-- Page Numbers -->
                        <?php
                        $start_page = max(1, $page - 2);
                        $end_page = min($total_pages, $page + 2);
                        
                        if($start_page > 1) {
                            echo '<li class="page-item"><a class="page-link" href="?' . buildPaginationUrl(1) . '">1</a></li>';
                            if($start_page > 2) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                        }
                        
                        for($i = $start_page; $i <= $end_page; $i++): ?>
                            <li class="page-item <?php echo $i == $page ? 'active' : ''; ?>">
                                <a class="page-link" href="?<?php echo buildPaginationUrl($i); ?>"><?php echo $i; ?></a>
                            </li>
                        <?php endfor;
                        
                        if($end_page < $total_pages) {
                            if($end_page < $total_pages - 1) echo '<li class="page-item disabled"><span class="page-link">...</span></li>';
                            echo '<li class="page-item"><a class="page-link" href="?' . buildPaginationUrl($total_pages) . '">' . $total_pages . '</a></li>';
                        }
                        ?>
                        
                        <!-- Next Page -->
                        <li class="page-item <?php echo $page >= $total_pages ? 'disabled' : ''; ?>">
                            <a class="page-link" href="?<?php echo buildPaginationUrl($page+1); ?>" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Patient Details Modal -->
    <div class="modal fade" id="patientModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title">Patient Details</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="patientDetails">
                    <!-- Details will be loaded here -->
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function showPatientDetails(patient) {
            const details = `
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="border-bottom pb-2">Basic Information</h6>
                        <p><strong>Name:</strong> ${patient.fullname}</p>
                        <p><strong>Age:</strong> ${patient.age}</p>
                        <p><strong>Birthday:</strong> ${patient.formatted_bday}</p>
                
                    </div>
                    <div class="col-md-6">
                        <h6 class="border-bottom pb-2">Medical Information</h6>
                        <p><strong>Mayo Score:</strong> ${patient.mayoscore || 'N/A'}</p>
                        <p><strong>Behavior:</strong> ${patient.behaviorcd || 'N/A'}</p>
                        <p><strong>Management:</strong> ${patient.management || 'N/A'}</p>
                    </div>
                </div>
                
                <!-- Latest Clinic Visit Section -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="clinic-visit-section">
                            <h6 class="border-bottom pb-2 text-primary">
                                <i class="fas fa-calendar-check me-2"></i>Latest Clinic Visit
                                ${patient.latest_visit_date ? `(${patient.latest_visit_date})` : ''}
                            </h6>
                            <div class="row">
                                <div class="col-md-6">
                                    <h6 class="text-muted">Subjective</h6>
                                    <div class="collapse-content" style="min-height: 100px;">
                                        ${patient.latest_review_of_systems || 'No data available'}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted">Objective</h6>
                                    <div class="collapse-content" style="min-height: 100px;">
                                        ${patient.latest_objective || 'No data available'}
                                    </div>
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <h6 class="text-muted">Assessment</h6>
                                    <div class="collapse-content" style="min-height: 100px;">
                                        ${patient.latest_assessment || 'No data available'}
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <h6 class="text-muted">Plans</h6>
                                    <div class="collapse-content" style="min-height: 100px;">
                                        ${patient.latest_plans || 'No data available'}
                                    </div>
                                </div>
                            </div>
                            ${patient.latest_visit_notes ? `
                            <div class="row mt-2">
                                <div class="col-12">
                                    <h6 class="text-muted">Visit Notes</h6>
                                    <div class="collapse-content">
                                        ${patient.latest_visit_notes}
                                    </div>
                                </div>
                            </div>
                            ` : ''}
                        </div>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-12">
                        <h6 class="border-bottom pb-2">Chief Complaints</h6>
                        <div class="collapse-content">${patient.chief_complaints_data || 'No data available'}</div>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-6">
                        <h6 class="border-bottom pb-2">Diagnoses</h6>
                        <div class="collapse-content">${patient.diagnoses_data || 'No data available'}</div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="border-bottom pb-2">Treatment</h6>
                        <div class="collapse-content">${patient.treatment || 'No data available'}</div>
                    </div>
                </div>
                
                <div class="row mt-3">
                    <div class="col-md-6">
                        <h6 class="border-bottom pb-2">Clinical Readings</h6>
                        <div class="collapse-content">${patient.clinical_readings_data || 'No data available'}</div>
                    </div>
                    <div class="col-md-6">
                        <h6 class="border-bottom pb-2">Medications</h6>
                        <div class="collapse-content">${patient.medications_data || 'No data available'}</div>
                    </div>
                </div>
                
               
                <div class="row mt-3">
                    <div class="col-12">
                        <h6 class="border-bottom pb-2">Clinical Notes</h6>
                        <div class="collapse-content">${patient.formatted_notes || 'No notes available'}</div>
                    </div>
                </div>
            `;
            
            document.getElementById('patientDetails').innerHTML = details;
            const modal = new bootstrap.Modal(document.getElementById('patientModal'));
            modal.show();
        }

        function exportToExcel() {
            // Simple Excel export - you might want to use a library for more complex exports
            const table = document.querySelector('.patient-table');
            let csv = [];
            
            // Add headers
            let headers = [];
            for (let i = 0; i < table.rows[0].cells.length - 1; i++) { // -1 to exclude actions column
                headers.push(table.rows[0].cells[i].textContent.trim());
            }
            csv.push(headers.join(','));
            
            // Add rows
            for (let i = 1; i < table.rows.length; i++) {
                let row = [];
                for (let j = 0; j < table.rows[i].cells.length - 1; j++) { // -1 to exclude actions column
                    row.push(table.rows[i].cells[j].textContent.trim().replace(/,/g, ';'));
                }
                csv.push(row.join(','));
            }
            
            const csvContent = "data:text/csv;charset=utf-8," + csv.join('</br>');
            const encodedUri = encodeURI(csvContent);
            const link = document.createElement("a");
            link.setAttribute("href", encodedUri);
            link.setAttribute("download", "patient_report_<?php echo date('Y-m-d'); ?>.csv");
            document.body.appendChild(link);
            link.click();
        }
    </script>
</body>
</html>

<?php
// Helper function to build pagination URLs
function buildPaginationUrl($page) {
    $params = $_GET;
    $params['page'] = $page;
    return http_build_query($params);
}

if ($conn) {
    mysqli_close($conn);
}
?>