<?php
// Configuration and security checks
include 'config.php';

// Validate visit_id parameter
if (!isset($_GET['visit_id']) || !is_numeric($_GET['visit_id'])) {
    header("Location: index.php");
    exit;
}

$visit_id = intval($_GET['visit_id']);
$message = isset($_GET['message']) ? htmlspecialchars($_GET['message']) : '';

// --- Database functions (unchanged) ---
function fetchVisitDetails($conn, $visit_id) {
    $sql = "SELECT cv.*, pi.first_name, pi.last_name 
            FROM clinic_visits cv
            JOIN patient_info pi ON cv.patient_id = pi.id
            WHERE cv.id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $visit_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function fetchClinicalReadings($conn, $visit_id) {
    $sql = "SELECT * FROM clinical_readings WHERE visit_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $visit_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function fetchLabRequests($conn, $visit_id) {
    $sql = "SELECT * FROM lab_requests WHERE visit_id = ?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $visit_id);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function fetchMedications($conn, $visit_id) {
    $sql = "SELECT * FROM medications WHERE visit_id = ? ORDER BY id";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $visit_id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

function fetchDocuments($conn, $visit_id) {
    $sql = "SELECT * FROM visit_documents WHERE visit_id = ? ORDER BY id";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "i", $visit_id);
    mysqli_stmt_execute($stmt);
    return mysqli_stmt_get_result($stmt);
}

// Fetch data
$visit = fetchVisitDetails($conn, $visit_id);

if (!$visit) {
    header("Location: index.php");
    exit;
}

$readings = fetchClinicalReadings($conn, $visit_id);
$lab = fetchLabRequests($conn, $visit_id);
$meds_result = fetchMedications($conn, $visit_id);
$docs_result = fetchDocuments($conn, $visit_id);

// --- Helper functions for display (unchanged) ---
function displayDate($date) {
    return $date ? date('F j, Y', strtotime($date)) : 'N/A';
}

function displayIfSet($value, $default = 'No data provided.') {
    return isset($value) && !empty(trim($value)) ? htmlspecialchars($value) : $default;
}

function displayMultiline($text, $default = 'No data provided.') {
    $text = displayIfSet($text, $default);
    if ($text !== 'No data provided.') {
         return nl2br($text);
    }
    return "<span style='color: #888;'>$default</span>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visit Dashboard - <?php echo displayIfSet($visit['case_number']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-color: #f4f7f6;
            --card-bg-color: #ffffff;
            --primary-text: #2d3748;
            --secondary-text: #718096;
            --border-color: #e2e8f0;
            --accent-color: #4A90E2; /* A professional blue */
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            --border-radius: 10px;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            background-color: var(--bg-color);
            color: var(--primary-text);
            margin: 0;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
        }

        /* Patient Banner */
        .patient-banner {
            background: var(--card-bg-color);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            padding: 25px;
            margin-bottom: 30px;
            border-left: 5px solid var(--accent-color);
        }
        .patient-banner h1 {
            margin: 0 0 5px 0;
            font-size: 2rem;
        }
        .patient-banner .sub-header {
            color: var(--secondary-text);
            font-size: 1.1rem;
            margin: 0;
        }
        .patient-banner .info-grid {
            margin-top: 20px;
            display: flex;
            flex-wrap: wrap;
            gap: 30px;
        }
        .patient-banner .info-item {
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.95rem;
        }
        .patient-banner .info-item i {
            color: var(--accent-color);
        }

        /* Layout */
        .content-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 30px;
        }

        /* Card styles */
        .card {
            background: var(--card-bg-color);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            margin-bottom: 30px;
        }
        .card-header {
            padding: 15px 20px;
            border-bottom: 1px solid var(--border-color);
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .card-header h3 {
            margin: 0;
            font-size: 1.1rem;
            color: var(--primary-text);
        }
        .card-body {
            padding: 20px;
        }

        /* Vitals Specific Styles */
        .vitals-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            gap: 15px;
        }
        .vital-item {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--bg-color);
            padding: 12px;
            border-radius: 8px;
        }
        .vital-item i {
            font-size: 1.5rem;
            color: var(--accent-color);
            width: 30px;
            text-align: center;
        }
        .vital-info .value {
            font-size: 1.25rem;
            font-weight: 600;
        }
        .vital-info .value small {
            font-size: 0.8rem;
            font-weight: 400;
            color: var(--secondary-text);
        }
        .vital-info .label {
            font-size: 0.85rem;
            color: var(--secondary-text);
        }

        /* SOAP Notes Styles */
        .soap-section { margin-bottom: 20px; }
        .soap-section:last-child { margin-bottom: 0; }
        .soap-section .label { font-weight: 600; margin-bottom: 8px; }
        .soap-section .content {
            padding: 15px;
            background-color: var(--bg-color);
            border-radius: 8px;
            border-left: 3px solid var(--accent-color);
        }
        
        /* Medication & Lab List Styles */
        .list-item {
            padding: 15px 0;
            border-bottom: 1px solid var(--border-color);
        }
        .list-item:first-child { padding-top: 0; }
        .list-item:last-child { padding-bottom: 0; border-bottom: none; }
        .list-item .label { font-size: 0.85rem; color: var(--secondary-text); }
        .list-item .value { font-size: 1rem; font-weight: 500; }
        .med-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
            gap: 10px;
        }

        /* Table styles */
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px 15px; text-align: left; border-bottom: 1px solid var(--border-color); }
        th { font-size: 0.85rem; color: var(--secondary-text); text-transform: uppercase; }
        tbody tr:hover { background-color: #f8fafc; }
        
        /* Action Buttons */
        .action-btns { margin-top: 10px; display: flex; gap: 10px; }
        .btn {
            background: var(--accent-color); color: white;
            padding: 10px 20px; border: none; border-radius: 8px;
            text-decoration: none; font-weight: 500;
            display: inline-flex; align-items: center; gap: 8px;
            cursor: pointer; transition: all 0.2s;
        }
        .btn:hover { opacity: 0.85; transform: translateY(-1px); }
        .btn-secondary { background: #a0aec0; }

        /* Responsive */
        @media (max-width: 1024px) {
            .content-layout { grid-template-columns: 1fr; }
            .sidebar-column { order: -1; } /* Puts vitals and meds on top on mobile */
        }
        
        .success-message {
            color: #155724; background-color: #d4edda;
            padding: 15px; border-radius: 8px; margin-bottom: 20px;
        }

    </style>
</head>
<body>
<div class="container">

    <?php if ($message): ?>
        <div class="success-message"><?php echo $message; ?></div>
    <?php endif; ?>

    <header class="patient-banner">

     <div class="action-btns" style="float: right;">
                <a href="edit_visit.php?visit_id=<?php echo $visit_id; ?>" class="btn">
                    <i class="fa-solid fa-pencil"></i> Edit Visit
                </a>
                <a href="patient_visits.php?patient_id=<?php echo $visit['patient_id']; ?>" class="btn btn-secondary">
                    <i class="fa-solid fa-arrow-left"></i> Back to All Visits
                </a>
            </div>
             
        <h1><?php echo displayIfSet($visit['last_name'] . ', ' . $visit['first_name']); ?></h1>
        <p class="sub-header">Clinical Visit Dashboard</p>
        <div class="info-grid">
            <div class="info-item"><i class="fa-solid fa-hashtag"></i> <strong>Case No:</strong> <?php echo displayIfSet($visit['case_number']); ?></div>
<div class="info-item" id="visit-date-display"><i class="fa-solid fa-calendar-day"></i> <strong>Visit Date:</strong> <?php echo displayDate($visit['visit_date']); ?></div>
            <div class="info-item"><i class="fa-solid fa-calendar-check"></i> <strong>Next Visit:</strong> <?php echo displayDate($visit['next_visit']); ?></div>
        </div>

         
    </header>

    <div class="content-layout">
        <main class="main-column">
            <div class="card">
                <div class="card-header"><h3><i class="fa-solid fa-notes-medical"></i> SOAP Notes</h3></div>
                <div class="card-body">
                    <div class="soap-section"><div class="label">Subjective</div><div class="content"><?php echo displayMultiline($visit['review_of_systems']); ?></div></div>
                    <div class="soap-section"><div class="label">Objective</div><div class="content"><?php echo displayMultiline($visit['objective']); ?></div></div>
                    <div class="soap-section"><div class="label">Assessment</div><div class="content"><?php echo displayMultiline($visit['assessment']); ?></div></div>
                    <div class="soap-section"><div class="label">Plans</div><div class="content"><?php echo displayMultiline($visit['plans']); ?></div></div>
                    <div class="soap-section"><div class="label">Additional Notes</div><div class="content"><?php echo displayMultiline($visit['notes']); ?></div></div>
                </div>
            </div>

            <?php if (mysqli_num_rows($docs_result) > 0): ?>
            <div class="card">
                <div class="card-header"><h3><i class="fa-solid fa-file-lines"></i> Documents & Forms</h3></div>
                <div class="card-body" style="padding:0;">
                    <table>
                        <thead><tr><th>Type</th><th>Name</th><th>Notes</th><th></th></tr></thead>
                        <tbody>
                        <?php while ($doc = mysqli_fetch_assoc($docs_result)): ?>
                            <tr>
                                <td><?php echo displayIfSet($doc['document_type']); ?></td>
                                <td><?php echo displayIfSet($doc['document_name']); ?></td>
                                <td><?php echo displayMultiline($doc['notes'], 'N/A'); ?></td>
                                <td><a href="<?php echo htmlspecialchars($doc['file_path']); ?>" target="_blank">View</a></td>
                            </tr>
                        <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <?php endif; ?>
        </main>

        <aside class="sidebar-column">
            <?php if ($readings): ?>
            <div class="card">
                <div class="card-header"><h3><i class="fa-solid fa-heart-pulse"></i> Vitals</h3></div>
                <div class="card-body">
                    <div class="vitals-grid">
                        <div class="vital-item"><i class="fa-solid fa-gauge-high"></i><div class="vital-info"><div class="value"><?php echo displayIfSet($readings['bp'], 'N/A'); ?></div><div class="label">Blood Pressure</div></div></div>
                        <div class="vital-item"><i class="fa-solid fa-heart"></i><div class="vital-info"><div class="value"><?php echo displayIfSet($readings['heart_rate'], 'N/A'); ?> <small>bpm</small></div><div class="label">Heart Rate</div></div></div>
                        <div class="vital-item"><i class="fa-solid fa-weight-scale"></i><div class="vital-info"><div class="value"><?php echo displayIfSet($readings['weight_kg'], 'N/A'); ?> <small>kg</small></div><div class="label">Weight</div></div></div>
                        <div class="vital-item"><i class="fa-solid fa-ruler-vertical"></i><div class="vital-info"><div class="value"><?php echo displayIfSet($readings['height_cm'], 'N/A'); ?> <small>cm</small></div><div class="label">Height</div></div></div>
                        <div class="vital-item"><i class="fa-solid fa-calculator"></i><div class="vital-info"><div class="value"><?php echo displayIfSet($readings['bmi'], 'N/A'); ?></div><div class="label">BMI</div></div></div>
                    </div>
                </div>
            </div>
            <?php endif; ?>

           <?php if (mysqli_num_rows($meds_result) > 0): ?>
            <div class="card" id="medications-card">
                <div class="card-header" style="justify-content: space-between;">
                    <h3><i class="fa-solid fa-pills"></i> Medications</h3>
                    <button class="btn btn-sm" onclick="handlePrintFromView()" style="padding: 5px 12px; font-size: 0.8rem;">
                        <i class="fa-solid fa-print"></i> Print
                    </button>
                </div>
                <div class="card-body">
                    <?php mysqli_data_seek($meds_result, 0); // Reset result pointer ?>
                    <?php while ($med = mysqli_fetch_assoc($meds_result)): ?>
                    <div class="list-item">
                        <div class="value med-name"><?php echo displayIfSet($med['medication_name']); ?></div>
                        <div class="med-grid">
                            <div><div class="label">Dosage</div><span class="med-dosage"><?php echo displayIfSet($med['dosage']); ?></span></div>
                             <div><div class="label">Frequency</div><span class="med-frequency"><?php echo displayIfSet($med['frequency']); ?></span></div>
                        </div>
                         <div style="margin-top: 8px;"><div class="label">Instructions</div><span class="med-instructions"><?php echo displayMultiline($med['instructions']); ?></span></div>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
            <?php endif; ?>

            <?php if ($lab): ?>
            <div class="card">
                <div class="card-header"><h3><i class="fa-solid fa-vial"></i> Lab Requests</h3></div>
                <div class="card-body">
                    <div class="list-item">
                        <div class="label">Request Date</div>
                        <div class="value"><?php echo displayDate($lab['request_date']); ?></div>
                    </div>
                     <div class="list-item">
                        <div class="label">Tests Requested</div>
                        <div class="value"><?php echo displayMultiline($lab['tests_requested']); ?></div>
                    </div>
                     <div class="list-item">
                        <div class="label">Lab Notes</div>
                        <div class="value"><?php echo displayMultiline($lab['lab_notes']); ?></div>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </aside>
    </div>

  

</div>

<script src="prescription-printer.js"></script>

<script>
        // NEW HELPER FUNCTION FOR THIS PAGE
        function handlePrintFromView() {
            const patientName = document.querySelector('.patient-banner h1').textContent.trim();
            const visitDate = document.getElementById('visit-date-display').textContent.replace('Visit Date:', '').trim();

            const medicationNodes = document.querySelectorAll('#medications-card .list-item');
            const medicationsData = [];

            medicationNodes.forEach(item => {
                medicationsData.push({
                    name: item.querySelector('.med-name').textContent.trim(),
                    dosage: item.querySelector('.med-dosage').textContent.trim(),
                    frequency: item.querySelector('.med-frequency').textContent.trim(),
                    instructions: item.querySelector('.med-instructions').innerHTML.trim()
                });
            });
            
            // Call the function from the external file
            printPrescription(patientName, visitDate, medicationsData);
        }
    </script>
    
    
</body>
</html>