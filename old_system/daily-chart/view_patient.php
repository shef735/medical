<?php
include 'config.php';
 
 $med_ctr=0;
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit;
}

$patient_id = $_GET['id'];
$sql = "SELECT * FROM patient_info WHERE id = $patient_id";
$result = mysqli_query($conn, $sql);
$patient = mysqli_fetch_assoc($result);

if (!$patient) {
    header("Location: index.php");
    exit;
}

// Get all test results for this patient
// Ensure session variable for table prefix is set, otherwise use a default or handle error
$table_prefix = isset($_SESSION['my_tables']) ? $_SESSION['my_tables'] : 'default_prefix'; // Added default prefix or error handling

$sql = "SELECT r.*, t.template_name 
        FROM ".$table_prefix."_laboratory.test_results r
        JOIN ".$table_prefix."_laboratory.test_templates t ON r.template_id = t.template_id
        WHERE r.patient_id = $patient_id
        ORDER BY r.test_date DESC";

$result = mysqli_query($conn, $sql);
$test_results = array();
if ($result) { // Check if query was successful
    while ($row = mysqli_fetch_assoc($result)) {
        $test_results[] = $row;
    }
} else {
    // Handle query error, e.g., log it or display a message
    error_log("Error fetching test results: " . mysqli_error($conn));
}


$user_id = $patient['user_id'];
$_SESSION['patient_user_id']=$user_id; // Consider security implications of setting session variables like this

$sql = "SELECT * FROM patient_record WHERE user_id = '".mysqli_real_escape_string($conn, $user_id)."'";
$result = mysqli_query($conn, $sql);
$patient_record = mysqli_fetch_assoc($result);

$sql = "SELECT * FROM patient_details WHERE user_id = '".mysqli_real_escape_string($conn, $user_id)."'";
$result = mysqli_query($conn, $sql);
$patient_details = mysqli_fetch_assoc($result);

$sql = "SELECT * FROM visit_documents WHERE user_id = '".mysqli_real_escape_string($conn, $user_id)."'";
$result = mysqli_query($conn, $sql);
$patient_documents = array();
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $patient_documents[] = $row;
    }
} else {
    error_log("Error fetching visit documents: " . mysqli_error($conn));
}


$sql = "SELECT * FROM record_chief_complaint WHERE user_id = '".mysqli_real_escape_string($conn, $user_id)."'";
$result = mysqli_query($conn, $sql);
$patient_complaint = array();
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $patient_complaint[] = $row;
    }
} else {
    error_log("Error fetching chief complaints: " . mysqli_error($conn));
}


$sql = "SELECT * FROM record_notes WHERE user_id = '".mysqli_real_escape_string($conn, $user_id)."'";
$result = mysqli_query($conn, $sql);
$patient_other_notes = array();
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $patient_other_notes[] = $row;
    }
} else {
    error_log("Error fetching record notes: " . mysqli_error($conn));
}



$sql = "SELECT * FROM record_complications WHERE user_id = '".mysqli_real_escape_string($conn, $user_id)."'";
$result = mysqli_query($conn, $sql);
$patient_complications = array();
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $patient_complications[] = $row;
    }
} else {
    error_log("Error fetching record complications: " . mysqli_error($conn));
}


$sql = "SELECT * FROM record_diagnosis WHERE user_id = '".mysqli_real_escape_string($conn, $user_id)."'";
$result = mysqli_query($conn, $sql);
$patient_diagnosis = array();
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
       $patient_diagnosis[] = $row;
    }
} else {
    error_log("Error fetching record diagnosis: " . mysqli_error($conn));
}


$sql = "SELECT * FROM patient_notes WHERE user_id = '".mysqli_real_escape_string($conn, $user_id)."'";
$result = mysqli_query($conn, $sql);
$patient_notes = array();
$note_ctr='';
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $patient_notes[] = $row;
        $note_ctr='Y';
    }
} else {
    error_log("Error fetching patient notes: " . mysqli_error($conn));
}


$sql = "SELECT * FROM patient_biological WHERE user_id = '".mysqli_real_escape_string($conn, $user_id)."'";
$result = mysqli_query($conn, $sql);
$patient_biological = array();
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $patient_biological[] = $row;
    }
} else {
    error_log("Error fetching patient biological data: " . mysqli_error($conn));
}


// Fetch clinical readings
$sql = "SELECT * FROM clinical_readings WHERE user_id = '".mysqli_real_escape_string($conn, $user_id)."' ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
$patient_readings = array();
$reading_ctr='';
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $patient_readings[] = $row;
        $reading_ctr='Y';
    }
} else {
    error_log("Error fetching clinical readings: " . mysqli_error($conn));
}


// Fetch findings
$sql = "SELECT * FROM clinic_visits WHERE user_id = '".mysqli_real_escape_string($conn, $user_id)."'";
$result = mysqli_query($conn, $sql);
$patient_visits = array();
$visits_ctr='';
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $patient_visits[] = $row;
        $visits_ctr='Y';
    }
} else {
    error_log("Error fetching clinic visits: " . mysqli_error($conn));
}


// Fetch lab request
$sql = "SELECT * FROM lab_requests WHERE user_id = '".mysqli_real_escape_string($conn, $user_id)."' ORDER BY request_date DESC";
$result = mysqli_query($conn, $sql);
$patient_lab_request = array();
$lab_request_ctr=''; // This seems to be a flag, consider using count($patient_lab_request) > 0 instead
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $patient_lab_request[] = $row;
        $lab_request_ctr='Y';
    }
} else {
    error_log("Error fetching lab requests: " . mysqli_error($conn));
}


// Fetch medication
$sql = "SELECT * FROM medications WHERE user_id = '".mysqli_real_escape_string($conn, $user_id)."' ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
$patient_medication = array();
$medication_ctr=''; // This seems to be a flag, consider using count($patient_medication) > 0 instead
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $patient_medication[] = $row;
        $medication_ctr='Y';
        $med_ctr=$med_ctr+1;
    }
} else {
    error_log("Error fetching medications: " . mysqli_error($conn));
}


// Fetch documents
// Fetch documents from both tables
$sql = "SELECT * FROM documents_forms WHERE user_id = '".mysqli_real_escape_string($conn, $user_id)."'
        UNION ALL
        SELECT * FROM visit_documents WHERE user_id = '".mysqli_real_escape_string($conn, $user_id)."'
        ORDER BY created_at DESC";
        
$result = mysqli_query($conn, $sql);
$patient_document = array();
$document_ctr = ''; // Consider using a boolean flag instead

if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $patient_document[] = $row;
        $document_ctr = 'Y'; // This will be set to 'Y' if any records exist
    }
} else {
    error_log("Error fetching documents: " . mysqli_error($conn));
}


// general well
$sql = "SELECT * FROM record_general_well WHERE user_id = '".mysqli_real_escape_string($conn, $user_id)."'";
$result = mysqli_query($conn, $sql);
$patient_general_well = array();
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $patient_general_well[] = $row;
    }
} else {
    error_log("Error fetching record_general_well: " . mysqli_error($conn));
}


// MAYO
$sql = "SELECT * FROM record_mayo WHERE user_id = '".mysqli_real_escape_string($conn, $user_id)."'";
$result = mysqli_query($conn, $sql);
$patient_mayo = array();
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $patient_mayo[] = $row;
    }
} else {
    error_log("Error fetching record_mayo: " . mysqli_error($conn));
}


// Format birthdate for age calculation
$birthday = new DateTime($patient['birthday']);
$today = new DateTime();
$age = $today->diff($birthday)->y;

// It's good practice to include files at the top if they don't produce output directly
// or are essential for subsequent logic.
include "load-values.php"; // Assuming this file sets variables like $complains, $lab_ctr, $medication_details etc.
                           // Ensure these variables are initialized if the include file might not define them.
                           // e.g., $complains = $complains ?? 'N/A';
$complains = $complains ?? ''; // Initialize if not set in load-values.php
$lab_ctr = $lab_ctr ?? 0; // Initialize if not set
$medication_details = $medication_details ?? 'N/A'; // Initialize if not set

// Initialize $my_tables_use if it's set in load-values.php or config.php
// This is crucial for the dynamic queries in the modals.
$my_tables_use = $my_tables_use ?? (isset($_SESSION['my_tables']) ? $_SESSION['my_tables'] : 'default_prefix');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
 <style>
body {
    font-family: Arial, sans-serif;
    line-height: 1.6;
    margin: 0;
    padding: 20px;
    color: #333;
    background-color: #f4f7f6; /* Light background for the page */
}
.container {
    max-width: 90%;
    margin: 0 auto;
    background: #fff;
    padding: 20px;
    box-shadow: 0 0 15px rgba(0,0,0,0.15); /* Softer shadow */
    border-radius: 8px; /* Rounded corners for the container */
}
h1 {
    color: #2c3e50;
    margin-bottom: 5px;
    font-size: 24px;
}
h2 {
    color: #3498db;
    border-bottom: 2px solid #3498db; /* Stronger border for h2 */
    padding-bottom: 8px; /* Increased padding */
    margin-top: 25px; /* Increased margin */
    font-size: 20px; /* Slightly larger h2 */
}
.patient-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
}
.status-active {
    color: #2ecc71;
    font-weight: bold;
    background-color: #e8f9e9; /* Light green background for status */
    padding: 5px 10px;
    border-radius: 4px;
}
.details-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); /* Responsive grid */
    gap: 20px; /* Increased gap */
    margin-bottom: 20px; /* Increased margin */
}
.detail-item {
    display: flex;
    flex-direction: column;
    margin-bottom: 12px; /* Increased margin */
}
.detail-label {
    font-weight: bold;
    color: #555; /* Darker label color */
    font-size: 0.9em;
    margin-bottom: 5px; /* Increased margin */
}
.detail-value {
    padding: 8px 10px; /* Increased padding */
    background: #f9f9f9;
    border: 1px solid #e0e0e0; /* Subtle border */
    border-radius: 4px; /* Rounded corners */
    min-height: 22px; /* Adjusted min-height */
    font-size: 0.95em; /* Slightly larger value font */
}
.section {
    margin-bottom: 30px;
}
.divider {
    border-top: 1px dashed #ccc; /* Lighter divider */
    margin: 30px 0; /* Increased margin */
}
.action-buttons {
    margin-top: 20px;
    margin-bottom: 20px; /* Added margin below buttons */
    display: flex;
    gap: 10px;
    flex-wrap: wrap;
}
.btn {
    padding: 10px 18px; /* Larger buttons */
    border-radius: 5px; /* Slightly more rounded */
    text-decoration: none;
    color: white;
    font-size: 14px;
    cursor: pointer;
    border: none;
    transition: all 0.3s ease;
    display: inline-flex; /* For icon alignment */
    align-items: center; /* For icon alignment */
}
.btn i { /* Style for icons in buttons */
    margin-right: 6px;
}
.btn-edit {
    background: #3498db;
}
.btn-edit:hover {
    background: #2980b9;
    transform: translateY(-2px); /* Slight lift on hover */
}
.btn-visits {
    background: #9b59b6;
}
.btn-visits:hover {
    background: #8e44ad;
    transform: translateY(-2px);
}
.btn-back {
    background: #7f8c8d;
}
.btn-back:hover {
    background: #6c7a7b;
    transform: translateY(-2px);
}
.btn-modal {
    background: #e67e22;
}
.btn-modal:hover {
    background: #d35400;
    transform: translateY(-2px);
}
.diagnosis-section {
    background: #fdfdfd; /* Slightly off-white */
    padding: 20px; /* Increased padding */
    border-radius: 6px; /* Rounded corners */
    margin-top: 20px;
    border: 1px solid #eee; /* Subtle border */
}
.three-column-section, .two-column-section, .one-column-section {
    display: grid;
    gap: 25px; /* Increased gap */
}
.three-column-section { grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); }
.two-column-section { grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); }
.one-column-section { grid-template-columns: 1fr; }

.column {
    display: flex;
    flex-direction: column;
}

/* Modal styles */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgba(0,0,0,0.5); /* Darker backdrop */
}
.modal-content {
    background-color: #fefefe;
    margin: 5% auto;
    padding: 25px; /* Increased padding */
    border: 1px solid #bbb; /* Softer border */
    width: 85%; /* Adjusted width */
    max-width: 900px;
    border-radius: 8px; /* Rounded corners */
    max-height: 85vh; /* Adjusted max height */
    overflow-y: auto;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2); /* Modal shadow */
    position: relative; /* Make it a positioning context for the close button */
}

/* Modal title with flexbox for "Add" button */
.modal-content h2 {
    margin-top: 0;
    padding-bottom: 10px;
    border-bottom: 1px solid #eee;
    margin-bottom: 20px;
    display: flex; /* Enable flexbox */
    justify-content: space-between; /* Space out title and add button */
    align-items: center; /* Vertically align items */
    padding-right: 40px; /* Make space for the close button */
}

/* Close button - adjusted to be absolutely positioned */
.close {
    color: #777; /* Lighter close button */
    font-size: 32px; /* Larger close icon */
    font-weight: bold;
    cursor: pointer;
    line-height: 1; /* Ensure proper vertical alignment */
    position: absolute; /* Position absolutely within the modal-content */
    top: 15px; /* Adjust top padding */
    right: 20px; /* Adjust right padding */
    z-index: 10; /* Ensure it's above other content */
}
.close:hover, .close:focus { /* Added focus state */
    color: #333; /* Darker on hover/focus */
    text-decoration: none;
}

/* Add button in modal header */
.modal-content h2 .btn-edit {
    font-size: 0.8em; /* Smaller add button */
    padding: 6px 12px;
    margin-left: auto; /* Push the add button to the right, separate from title */
}

/* Table styles */
.detail-item table {
    width: 100%;
    border-collapse: collapse;
    margin: 15px 0;
    font-size: 0.9em;
    font-family: Arial, sans-serif;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.05); /* Softer shadow */
    border-radius: 6px; /* Rounded corners */
    overflow: hidden; /* Ensures border-radius is applied to corners */
}
.detail-item thead tr {
    background-color: #3498db;
    color: #ffffff;
    text-align: left;
    font-weight: bold;
}
.detail-item th,
.detail-item td {
    padding: 12px 15px;
    vertical-align: middle;
    border-bottom: 1px solid #e0e0e0; /* Lighter border for rows */
}
.detail-item tbody tr {
    transition: background-color 0.2s ease; /* Smoother hover transition */
}
.detail-item tbody tr:nth-of-type(even) {
    background-color: #f8f9fa;
}
.detail-item tbody tr:last-of-type {
    border-bottom: 2px solid #3498db; /* Stronger border for last row */
}
.detail-item tbody tr:hover {
    background-color: #e9f5ff;
    /* transform: scale(1.005); // Removed for less jarring hover */
    /* box-shadow: 0 2px 5px rgba(0,0,0,0.1); // Removed for less jarring hover */
}
.detail-item .actions {
    display: flex;
    gap: 8px;
    flex-wrap: nowrap; /* Prevent wrapping if possible */
}
.detail-item .btn { /* Button style within tables */
    padding: 6px 10px;
    border-radius: 4px;
    text-decoration: none;
    color: white;
    font-size: 0.85em; /* Adjusted font size */
    display: inline-flex;
    align-items: center;
    transition: background-color 0.2s ease;
}
.detail-item .pdf-icon {
    margin-left: 5px; /* Adjusted margin */
    font-size: 1em; /* Adjusted icon size */
}

/* Responsive adjustments */
@media (max-width: 992px) { /* Adjusted breakpoint */
    .modal-content {
        width: 90%;
    }
}

@media (max-width: 768px) {
    .details-grid, .three-column-section, .two-column-section {
        grid-template-columns: 1fr;
    }
    .detail-item table { /* Enable horizontal scroll for tables on small screens */
        display: block;
        overflow-x: auto;
        white-space: nowrap; /* Prevent content wrapping in cells */
    }
    .detail-item .actions {
        flex-direction: row; /* Keep actions in a row if possible */
        gap: 5px;
    }
    .detail-item .btn {
        width: auto; /* Allow buttons to size to content */
        text-align: center;
        justify-content: center;
    }
    .modal-content {
        width: 95%;
        margin: 10% auto;
        padding: 15px; /* Reduced padding for smaller modals */
    }
    .patient-header {
        flex-direction: column;
        align-items: flex-start;
    }
    .patient-header h1 {
        margin-bottom: 10px;
    }
    .action-buttons {
        justify-content: center; /* Center buttons on small screens */
    }
}

/* Summary cards */
.summary-cards {
    display: grid;
    /* This will create columns that are at least 200px wide, and as wide as possible up to 1 fraction of the available space */
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 15px; /* Slightly reduced gap for better fit */
    margin: 25px 0;
}

/* Further adjustment for very small screens if necessary, though minmax should handle most cases */
@media (max-width: 500px) {
    .summary-cards {
        grid-template-columns: 1fr; /* Stack cards vertically on very small screens */
    }
}

.summary-card {
    background: #fff;
    border-radius: 8px;
    padding: 20px; /* Increased padding */
    box-shadow: 0 3px 8px rgba(0,0,0,0.08); /* Softer, more spread shadow */
    transition: all 0.3s ease;
    cursor: pointer;
    border-left: 5px solid #3498db; /* Thicker accent border */
}
.summary-card:hover {
    transform: translateY(-4px); /* Slightly more lift */
    box-shadow: 0 6px 12px rgba(0,0,0,0.12); /* Enhanced shadow on hover */
}
.summary-card h3 {
    margin-top: 0;
    color: #3498db;
    font-size: 17px; /* Slightly larger card title */
    margin-bottom: 10px; /* Added margin */
}
.summary-card .count {
    font-size: 28px; /* Larger count */
    font-weight: bold;
    margin: 10px 0 15px 0; /* Adjusted margin */
    color: #2c3e50; /* Darker count color */
}
.summary-card .view-link {
    color: #3498db;
    text-decoration: none;
    font-size: 14px;
    display: flex;
    align-items: center;
    font-weight: 500; /* Slightly bolder link */
}
.summary-card .view-link i {
    margin-left: 8px; /* Increased icon margin */
    transition: transform 0.2s ease; /* Icon animation */
}
.summary-card:hover .view-link i {
    transform: translateX(3px); /* Move icon on hover */
}

/* Form styles */
.detail-value input[type="text"],
.detail-value input[type="number"],
.detail-value input[type="date"],
.detail-value input[type="datetime-local"],
.detail-value input[type="file"],
.detail-value select,
.detail-value textarea,
input[type="text"].detail-value, /* For inputs directly using class */
input[type="number"].detail-value,
input[type="date"].detail-value,
input[type="datetime-local"].detail-value,
input[type="file"].detail-value,
select.detail-value,
textarea.detail-value {
    width: 100%;
    padding: 10px; /* Increased padding */
    border: 1px solid #ccc; /* Standard border */
    border-radius: 4px;
    font-family: inherit;
    font-size: 0.95em; /* Consistent font size */
    box-sizing: border-box; /* Important for width calculation */
    margin-top: 5px; /* Add some space above the input */
}

.detail-value textarea, textarea.detail-value {
    min-height: 120px; /* Increased min-height */
    resize: vertical;
}

.detail-value input[type="file"], input[type="file"].detail-value {
    padding: 8px; /* Adjusted padding for file input */
    background: #f9f9f9;
}
.modal-content .action-buttons { /* Ensure modal buttons are spaced */
    margin-top: 20px;
    display: flex;
    justify-content: flex-end; /* Align buttons to the right */
    gap: 10px;
}
.modal-content .btn-back { /* Specific style for cancel/back in modal */
    background-color: #bdc3c7;
}
.modal-content .btn-back:hover {
    background-color: #95a5a6;
}

 </style>
</head>
<body>
    <div class="container">
        <div class="action-buttons">
            <a href="edit_patient.php?id=<?php echo htmlspecialchars($patient_id); ?>" class="btn btn-edit"><i class="fas fa-user-edit"></i>Edit Patient</a>
            <a href="patient_visits.php?patient_id=<?php echo htmlspecialchars($patient_id); ?>" class="btn btn-visits"><i class="fas fa-calendar-check"></i>View Visits</a>
            <button onclick="openModal('complaintsModal')" class="btn btn-modal"><i class="fas fa-head-side-cough"></i>Complaints</button>
            <button onclick="openModal('labModal')" class="btn btn-modal"><i class="fas fa-flask"></i>Lab Results</button>
            <button onclick="openModal('medicationModal')" class="btn btn-modal"><i class="fas fa-pills"></i>Medications</button>
            <a href="../admin/source/all-patients.php" class="btn btn-back"><i class="fas fa-arrow-left"></i>Back to List</a>
        </div>

    <br>
        <div class="patient-header">
            <h1><?php echo htmlspecialchars($user_id).' - '.htmlspecialchars($patient['last_name']) . ', ' . htmlspecialchars($patient['first_name']) . ' ' . htmlspecialchars($patient['middle_name']); ?></h1>
            <span class="status-active">Active</span>
        </div>

        <div class="section">
            <h2>Patient Details</h2>
            <div class="details-grid">
                <div class="column">
                    <div class="detail-item">
                        <?php
                            $photo="default.png";
                            if(!empty($patient['photo'])) { // Check if photo is not empty
                                $photo_path = "../../uploads/patient-form/".$patient['photo'];
                                if (file_exists($photo_path)) { // Check if file exists
                                     $photo = $patient['photo'];
                                } else {
                                    // Optionally log that the photo file was not found
                                    error_log("Photo not found for patient ID {$patient_id}: {$photo_path}");
                                }
                            }
                        ?>                       
                       <img src="../../uploads/patient-form/<?php echo $photo; ?>" alt="Patient Photo" style="width: 100%; max-width: 250px; border-radius: 8px; border: 1px solid #ddd;" onerror="this.onerror=null;this.src='../../uploads/patient-form/default.png';">
                    </div>
                </div>
                
                <div class="column">
                    <div class="detail-item">
                        <span class="detail-label">Age (Birthdate)</span>
                        <div class="detail-value"><?php echo htmlspecialchars($age) . ' ('.date('M d, Y', strtotime($patient['birthday'])).')'; ?></div>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">Gender</span>
                        <div class="detail-value"><?php echo htmlspecialchars($patient['gender']); ?></div>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">Contact</span>
                        <div class="detail-value"><?php echo !empty($patient['phone']) ? htmlspecialchars($patient['phone']) : 'N/A'; ?></div>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">Email</span>
                        <div class="detail-value"><?php echo !empty($patient['email']) ? htmlspecialchars($patient['email']) : 'N/A'; ?></div>
                    </div>
                </div>
                
                <div class="column">
                    <div class="detail-item">
                        <span class="detail-label">Occupation</span>
                        <div class="detail-value"><?php echo !empty($patient['occupation']) ? htmlspecialchars($patient['occupation']) : 'N/A'; ?></div>
                    </div>

                    <div class="detail-item" style="display: none;">
                        <span class="detail-label">Referred by</span>
                        <div class="detail-value"><?php echo !empty($patient['referred_by']) ? htmlspecialchars($patient['referred_by']) : 'N/A'; ?></div>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">Other MDs</span>
                        <div class="detail-value"><?php echo !empty($patient['other_mds']) ? htmlspecialchars($patient['other_mds']) : 'N/A'; ?></div>
                    </div>
                    

                    <div class="detail-item">
                        <span class="detail-label">Address</span>
                        <div class="detail-value">
                            <?php 
                                echo htmlspecialchars($patient['NoBldgName'] ?? '').' ';  
                                echo htmlspecialchars($patient['StreetName'] ?? '').' ';   
                                echo htmlspecialchars(substr($patient['psgc_barangay'] ?? '', (strpos($patient['psgc_barangay'] ?? '', '~') ?: -1) + 1)).' '; 
                                echo htmlspecialchars(substr($patient['psgc_municipality'] ?? '', (strpos($patient['psgc_municipality'] ?? '', '~') ?: -1) + 1)).' '; 
                                echo htmlspecialchars(substr($patient['psgc_province'] ?? '', (strpos($patient['psgc_province'] ?? '', '~') ?: -1) + 1)); 
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="divider"></div>

        <div class="summary-cards">
            <div class="summary-card" onclick="openModal('complaintsModal')">
                <h3><i class="fas fa-head-side-cough"></i> Complaints / Symptoms</h3>
                <div class="count"><?php echo !empty($complains) ? count(array_filter(explode(',', $complains))) : '0'; ?></div>
                <a class="view-link">View Details <i class="fas fa-chevron-right"></i></a>
            </div>
            
            <div class="summary-card" onclick="openModal('labModal')">
                <h3><i class="fas fa-flask"></i> Laboratory / Procedure</h3>
                <div class="count"><?php echo htmlspecialchars($lab_ctr); // $lab_ctr should be an integer from load-values.php or calculated ?></div>
                <a class="view-link">View Details <i class="fas fa-chevron-right"></i></a>
            </div>
            
            <div class="summary-card" onclick="openModal('medicationModal')">
                <h3><i class="fas fa-pills"></i> Medication & Prescription</h3>
                <div class="count"><?php echo htmlspecialchars($med_ctr); ?></div>
                <a class="view-link">View Details <i class="fas fa-chevron-right"></i></a>
            </div>
            
            <div class="summary-card" onclick="openModal('readingsModal')">
                <h3><i class="fas fa-heartbeat"></i> Clinical Readings</h3>
                <div class="count"><?php echo count($patient_readings); ?></div>
                <a class="view-link">View Details <i class="fas fa-chevron-right"></i></a>
            </div>
        </div>

       <div class="summary-cards">    
            <div  class="summary-card" onclick="openModal('documentsModal')">
                <h3><i class="fas fa-file-alt"></i> Documents & Forms</h3>
                <div class="count"><?php echo count($patient_document); ?></div>
                <a class="view-link">View Details <i class="fas fa-chevron-right"></i></a>
            </div>
            
            <div class="summary-card" onclick="openModal('diagnosisModal')">
                <h3><i class="fas fa-stethoscope"></i> Diagnosis</h3>
                <div class="count"><?php echo count($patient_diagnosis); ?></div>
                <a class="view-link">View Details <i class="fas fa-chevron-right"></i></a>
            </div>

            <div class="summary-card" onclick="openModal('notesModal')">
                <h3><i class="fas fa-notes-medical"></i> Doctor's / Nurse's Notes</h3>
                <div class="count"><?php echo count($patient_notes); ?></div>
                <a class="view-link">View Details <i class="fas fa-chevron-right"></i></a>
            </div>

             <div class="summary-card" >
              
         
                 
            </div>
        </div>

        <div class="divider"></div>

        <div class="diagnosis-section">
             <h2>Medical Overview</h2>
            <div class="two-column-section">
                  <div class="column">
                    <h3>Medical History</h3>
                    <div class="detail-item">
                        <span class="detail-label">Family History:</span>
                        <div class="detail-value"><?php echo !empty($patient_details['family_history']) ? nl2br(htmlspecialchars($patient_details['family_history'])) : 'N/A'; ?></div>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Smoking:</span>
                        <?php
                            $smoker='N/A'; // Default value
                            if(isset($patient_details['smoker']) && $patient_details['smoker'] !== '') {
                                $smoker_parts = [];
                                $smoker_parts[] = htmlspecialchars($patient_details['smoker']);
                                if(isset($patient_details['pack_per_day']) && (float)$patient_details['pack_per_day'] > 0) {
                                    $smoker_parts[] = htmlspecialchars($patient_details['pack_per_day']).' pack/day' ;
                                }
                                if(isset($patient_details['years_smoking']) && $patient_details['years_smoking'] !== '') {
                                    $smoker_parts[] = htmlspecialchars($patient_details['years_smoking']).' years';
                                }
                                $smoker = implode(', ', $smoker_parts);
                            }
                        ?>
                        <div class="detail-value"><?php echo $smoker; ?></div>
                    </div>

                      <div class="detail-item">
                        <span class="detail-label">Alcohol:</span>
                        <div class="detail-value"><?php echo !empty($patient_details['alcohol_history']) ? nl2br(htmlspecialchars($patient_details['alcohol_history'])) : 'N/A'; ?></div>
                    </div>
                </div>
                
                <div class="column">
                     <h3>Adverse Drug Reactions</h3>
                    <div class="detail-value"><?php echo !empty($patient_details['adverse_drug_reactions']) ? nl2br(htmlspecialchars($patient_details['adverse_drug_reactions'])) : 'No adverse reactions recorded'; ?></div>
                          
               
                      <h3>Other Notes</h3>
                        <div class="detail-value" style="white-space: pre-wrap;">
                            <?php 
                            $other_notes_content = '';
                            foreach ($patient_biological as $pat_bnotes): 
                                if(!empty($pat_bnotes['onset_var'])) {
                                    $other_notes_content .= '<b>ONSET:</b> '.htmlspecialchars($pat_bnotes['onset_var'])."\n";  
                                }    
                                if(!empty($pat_bnotes['onset'])) {
                                    $other_notes_content .= '<b>ONSET:</b> '.htmlspecialchars($pat_bnotes['onset'])."\n";  
                                }
                                if(!empty($pat_bnotes['obstruction'])) {
                                    $other_notes_content .= htmlspecialchars($pat_bnotes['obstruction'])."\n";  
                                }
                                if(!empty($pat_bnotes['surgery'])) {                           
                                    $other_notes_content .= '<b>SURGERY:</b> '.htmlspecialchars($pat_bnotes['surgery'])."\n";  
                                }
                                if(!empty($pat_bnotes['note'])) {
                                    $other_notes_content .= htmlspecialchars($pat_bnotes['note'])."\n";  
                                }
                                if(!empty($pat_bnotes['indication']) && $pat_bnotes['indication']!='0000-00-00') {
                                    $other_notes_content .=  '<b>INDICATION:</b> '.htmlspecialchars($pat_bnotes['indication'])."\n";    
                                }           
                            endforeach; 
                           
                            foreach ($patient_other_notes as $pconotes): 
                                if (!empty($pconotes['notes'])) {
                                    $other_notes_content .=  htmlspecialchars($pconotes['notes'])."\n";
                                }
                            endforeach;

                            foreach ($patient_general_well as $pcgenwell): 
                                if(!empty($pcgenwell['frequencyofstools'])) {
                                    $other_notes_content .= '<b>FREQUENCY OF STOOLS:</b> '.htmlspecialchars($pcgenwell['frequencyofstools'])."\n";  
                                }   
                                if(!empty($pcgenwell['abdominalpain'])) {
                                    $other_notes_content .= '<b>ABDOMINAL PAIN:</b> '.htmlspecialchars($pcgenwell['abdominalpain'])."\n";  
                                }    
                                if(!empty($pcgenwell['generalwellbeing'])) {
                                    $other_notes_content .= '<b>GENERAL WELL BEING:</b> '.htmlspecialchars($pcgenwell['generalwellbeing'])."\n";  
                                }   
                            endforeach;

                            foreach ($patient_mayo as $pcmayo): 
                                if(!empty($pcmayo['mayoscore'])) {
                                    $other_notes_content .= '<b>MAYO SCORE:</b> '.htmlspecialchars($pcmayo['mayoscore'])."\n";  
                                }   
                            endforeach;

                            echo !empty(trim($other_notes_content)) ? trim($other_notes_content) : 'N/A';
                            ?> 
                        </div>
                 </div>
            </div>
        </div>
    </div>

    <div id="complaintsModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('complaintsModal')">&times;</span>
            <h2>Complaints/Symptoms 
                <button class="btn btn-edit" onclick="openAddModal('addComplaintModal')"><i class="fas fa-plus"></i> Add</button>
            </h2>
            <div class="one-column-section">
                <div class="column">
                    <div class="detail-item">
                        <div class="detail-value" style="white-space: pre-wrap; min-height: 100px;"><?php 
                            $complaints_display = !empty($complains) ? htmlspecialchars($complains) : 'No complaints recorded.';
                            echo nl2br($complaints_display); // Use nl2br if complaints can have newlines
                        ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="labModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('labModal')">&times;</span>
            <h2>Laboratory/Procedure Results
                 <button class="btn btn-edit" onclick="openAddModal('addLabModal')"><i class="fas fa-plus"></i> Add</button>
            </h2>
            <div class="one-column-section">
                <div class="column">
                    <div class="detail-item">
                        <?php if (empty($test_results) && empty($patient_documents) && (empty($patient_record['proceduredone']) || $patient_record['proceduredone']=='') && (empty($patient_record['hgblevels']) || ltrim($patient_record['hgblevels'])=='')): ?>
                            <div class="detail-value">No laboratory or procedure results found.</div>
                        <?php else: ?>
                        <table style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="text-align: left;">Date</th>
                                    <th style="text-align: left;">Type</th>
                                    <th style="text-align: left;">Particulars/Notes</th>
                                    <th style="text-align: left;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($test_results as $test): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars(date('M d, Y', strtotime($test['test_date']))); ?></td>
                                        <td><?php echo htmlspecialchars($test['template_name']); ?></td>
                                        <td><?php echo !empty($test['notes']) ? htmlspecialchars($test['notes']) : 'N/A'; ?></td>
                                        <td class="actions">
                                            <a target="_blank" class="btn btn-edit" href="../lab_system/view_result.php?id=<?php echo htmlspecialchars($test['result_id']); ?>"><i class="fas fa-eye"></i> View</a>
                                            <a class="btn btn-visits" target="_blank" href="../lab_system/pdf_report.php?id=<?php echo htmlspecialchars($test['result_id']); ?>"><i class="fas fa-file-pdf"></i> PDF</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                               <?php foreach ($patient_documents as $docs): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars(date('M d, Y', strtotime($docs['created_at']))); ?></td>
                                        <td><?php echo htmlspecialchars($docs['document_type']); ?></td>
                                        <td><?php echo nl2br(htmlspecialchars($docs['notes'])); ?></td>
                                        <td class="actions">
                                            <?php
                                            if (!empty($docs['file_path'])) {
                                                $files = json_decode($docs['file_path'], true);
                                                if (is_array($files)) {
                                                    foreach ($files as $file_item) {
                                                        if (isset($file_item['path']) && isset($file_item['originalName'])) {
                                                            // Assuming the path is relative to the current script's directory or a base URL
                                                            // Adjust the base path if necessary e.g., '../' or your specific uploads folder path
                                                            $filePath = htmlspecialchars($file_item['path']);
                                                            $fileName = htmlspecialchars($file_item['originalName']);
                                                            echo '<a class="btn btn-edit" href="' . $filePath . '" target="_blank" title="View ' . $fileName . '"><i class="fas fa-eye"></i> ' . $fileName . '</a> ';
                                                        }
                                                    }
                                                } elseif (is_string($docs['file_path'])) { // Fallback for single, non-JSON path
                                                    echo '<a class="btn btn-edit" href="' . htmlspecialchars($docs['file_path']) . '" target="_blank"><i class="fas fa-eye"></i></a> ';
                                                } else {
                                                    echo 'N/A';
                                                }
                                            } else {
                                                echo 'N/A';
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <?php if(isset($patient_record['proceduredone']) && $patient_record['proceduredone']!=''): ?>
                                    <tr>
                                        <td><?php echo !empty($patient_record['dateofcolonoscopy']) ? htmlspecialchars(date('M d, Y', strtotime($patient_record['dateofcolonoscopy']))) : 'N/A'; ?></td>
                                        <td>Procedure: <?php echo htmlspecialchars($patient_record['proceduredone']); ?></td>
                                        <td><?php echo 'Endoscopic: '.htmlspecialchars($patient_record['endoscopicfindings'] ?? '').'<br>'.
                                            'Histopath 1: '.htmlspecialchars($patient_record['histopathfindings1'] ?? '').'<br>'.
                                            'Histopath 2: '.htmlspecialchars($patient_record['histopathfindings2'] ?? '').'<br>'.
                                            'Histopath 3: '.htmlspecialchars($patient_record['histopathfindings3'] ?? '').'<br>'.
                                            'Behavior CD: '.htmlspecialchars($patient_record['behaviorcd'] ?? '').'<br>'.
                                            'Montreal Extent UC: '.htmlspecialchars($patient_record['montrealextentforuc'] ?? ''); ?></td>
                                        <td>N/A</td>
                                    </tr>
                                <?php endif; ?>

                                <?php if(isset($patient_record['hgblevels']) && ltrim($patient_record['hgblevels'])!=''): ?>
                                    <tr>
                                        <td>N/A</td>
                                        <td>CBC (Blood Test - Manual Entry)</td>
                                        <td>
                                            HGB: <?php echo htmlspecialchars($patient_record['hgblevels']); ?><br>
                                            Platelet Count: <?php echo htmlspecialchars($patient_record['plateletcount'] ?? 'N/A'); ?><br>
                                            Albumin: <?php echo htmlspecialchars($patient_record['albumin'] ?? 'N/A'); ?><br>
                                            CRP Level: <?php echo htmlspecialchars($patient_record['crplevel'] ?? 'N/A'); ?><br>
                                            ESR: <?php echo htmlspecialchars($patient_record['esr'] ?? 'N/A'); ?>                
                                        </td>
                                        <td>N/A</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="medicationModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('medicationModal')">&times;</span>
        <h2>Medications & Prescriptions
            <button class="btn btn-edit" onclick="openAddModal('addMedicationModal')"><i class="fas fa-plus"></i> Add</button>
        </h2>
        <div class="one-column-section">
            <div class="column">
                <div class="detail-item">
                    <span class="detail-label">Current Medication Summary (from patient details):</span>
                    <div class="detail-value" style="white-space: pre-wrap; min-height: 80px;"><?php echo !empty($medication_details) ? nl2br(htmlspecialchars($medication_details)) : 'N/A'; ?></div>
                </div>
            </div>
        </div>
        
        <?php if($medication_ctr > 0 || !empty($patient_medication)): ?>
        <div class="one-column-section">
            <div class="column">
                <div class="detail-item">
                    <span class="detail-label">Medication History:</span>
                    <table style="width: 100%;" id="medicationHistoryTable">
                        <thead>
                            <tr>
                                <th style="width: 30px;"><input type="checkbox" onclick="toggleAllMedCheckboxes(this)"></th>
                                <th>Date Added</th>
                                <th>Medication</th>
                                <th>Dosage</th>
                                <th>Frequency</th>
                                <th>Instructions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($patient_medication as $pat_med): ?>
                                <tr class="medication-row">
                                    <td><input type="checkbox" class="med-checkbox"></td>
                                    <td class="med-date"><?php echo htmlspecialchars(date('M d, Y', strtotime($pat_med['created_at']))); ?></td>
                                    <td class="med-name"><?php echo htmlspecialchars($pat_med['medication_name']); ?></td>
                                    <td class="med-dosage"><?php echo htmlspecialchars($pat_med['dosage']); ?></td>
                                    <td class="med-frequency"><?php echo htmlspecialchars($pat_med['frequency']); ?></td>
                                    <td class="med-instructions"><?php echo nl2br(htmlspecialchars($pat_med['instructions'])); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <div class="action-buttons" style="justify-content: flex-end; margin-top: 15px;">
                        <button class="btn btn-visits" onclick="handlePrintFromModal()"><i class="fas fa-print"></i> Print Selected</button>
                    </div>

                </div>
            </div>
        </div>
        <?php else: ?>
            <div class="detail-value">No detailed medication history found.</div>
        <?php endif; ?>
    </div>
</div>
      <div id="notesModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('notesModal')">&times;</span>
            <h2>Doctor's / Nurse's Notes
                 <button class="btn btn-edit" onclick="openAddModal('addNoteModal')"><i class="fas fa-plus"></i> Add</button>
            </h2>
            <div class="one-column-section">
                <div class="column">
                    <div class="detail-item">
                        <?php if (empty($patient_notes)): ?>
                            <div class="detail-value">No notes found.</div>
                        <?php else: ?>
                        <table style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Notes</th>
                                    <th>Created by</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($patient_notes as $pat_notes): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars(date('M d, Y H:i', strtotime($pat_notes['created_date']))); ?></td>
                                        <td style="white-space: pre-wrap;"><?php echo nl2br(htmlspecialchars($pat_notes['note_content'])); ?></td>
                                        <td><?php echo htmlspecialchars($pat_notes['created_by']); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="readingsModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('readingsModal')">&times;</span>
            <h2>Clinical Readings
                 <button class="btn btn-edit" onclick="openAddModal('addReadingModal')"><i class="fas fa-plus"></i> Add</button>
            </h2>
            <div class="one-column-section">
                <div class="column">
                    <div class="detail-item">
                         <?php if (empty($patient_readings)): ?>
                            <div class="detail-value">No clinical readings found.</div>
                        <?php else: ?>
                        <table style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Visit Date</th>
                                    <th>Blood Pressure</th>
                                    <th>Heart Rate</th>
                                    <th>Weight</th>
                                    <th>Height</th>
                                    <th>BMI</th>
                                    <th>Notes</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($patient_readings as $pat_read): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars(date('M d, Y H:i', strtotime($pat_read['created_at']))); ?></td>
                                        <td><?php echo !empty($pat_read['bp']) ? htmlspecialchars($pat_read['bp']) : 'N/A'; ?></td>
                                        <td><?php echo !empty($pat_read['heart_rate']) ? htmlspecialchars($pat_read['heart_rate']) . ' bpm' : 'N/A'; ?></td>
                                        <td><?php echo !empty($pat_read['weight_kg']) ? htmlspecialchars($pat_read['weight_kg']) . ' kg' : 'N/A'; ?></td>
                                        <td><?php echo !empty($pat_read['height_cm']) ? htmlspecialchars($pat_read['height_cm']) . ' cm' : 'N/A'; ?></td>
                                        <td><?php echo !empty($pat_read['bmi']) ? htmlspecialchars($pat_read['bmi']) : 'N/A'; ?></td>
                                        <td style="white-space: pre-wrap;"><?php echo !empty($pat_read['notes']) ? nl2br(htmlspecialchars($pat_read['notes'])) : 'N/A'; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

 <div id="documentsModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('documentsModal')">&times;</span>
        <h2>Documents & Forms
            <button class="btn btn-edit" onclick="openAddModal('addDocumentModal')"><i class="fas fa-plus"></i> Add</button>
        </h2>
        <div class="one-column-section">
            <div class="column">
                <div class="detail-item">
                    <?php if (empty($patient_document)): ?>
                            <div class="detail-value">No documents or forms found.</div>
                    <?php else: ?>
                    <table style="width: 100%;">
                        <thead>
                            <tr>
                                <th>Date Added</th>
                                <th>Type</th>
                                <th>Name</th>
                                <th>Notes</th>
                                <th style="text-align: left;">Attachments</th> </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($patient_document as $doc): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars(date('M d, Y H:i', strtotime($doc['created_at']))); ?></td>
                                    <td><?php echo htmlspecialchars($doc['document_type']); ?></td>
                                    <td><?php echo htmlspecialchars($doc['document_name']); ?></td>
                                    <td style="white-space: pre-wrap;"><?php echo nl2br(htmlspecialchars($doc['notes'])); ?></td>
                                    <td class="actions">
                                        <?php
                                        if (!empty($doc['file_path'])) {
                                            $files = json_decode($doc['file_path'], true); // Decode the JSON string

                                            if (is_array($files) && !empty($files)) {
                                                foreach ($files as $file_item) {
                                                    if (isset($file_item['path']) && isset($file_item['originalName'])) {
                                                        $filePath = htmlspecialchars($file_item['path']);
                                                        $fileName = htmlspecialchars($file_item['originalName']);
                                                        $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                                                        // Determine appropriate icon
                                                        $iconClass = 'fas fa-file'; // Default icon
                                                        if ($fileExtension == 'pdf') {
                                                            $iconClass = 'fas fa-file-pdf';
                                                        } elseif (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'bmp'])) {
                                                            $iconClass = 'fas fa-file-image';
                                                        } elseif (in_array($fileExtension, ['doc', 'docx'])) {
                                                            $iconClass = 'fas fa-file-word';
                                                        }

                                                        // Output a button-like link for each file
                                                        echo '<a class="btn btn-edit" href="' . $filePath . '" target="_blank" title="View ' . $fileName . '" style="margin-bottom: 5px; margin-right: 5px;">';
                                                        echo '<i class="' . $iconClass . '"></i> ' . $fileName; // Display icon and filename
                                                        echo '</a>';
                                                    }
                                                }
                                            } else if (is_string($doc['file_path'])) { // Fallback for single, non-JSON path (for old data)
                                                $filePath = htmlspecialchars($doc['file_path']);
                                                $fileName = basename($filePath); // Get filename from path for old entries
                                                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                                                $iconClass = 'fas fa-file';
                                                if ($fileExtension == 'pdf') {
                                                    $iconClass = 'fas fa-file-pdf';
                                                } elseif (in_array($fileExtension, ['jpg', 'jpeg', 'png', 'gif', 'bmp'])) {
                                                    $iconClass = 'fas fa-file-image';
                                                } elseif (in_array($fileExtension, ['doc', 'docx'])) {
                                                    $iconClass = 'fas fa-file-word';
                                                }

                                                echo '<a class="btn btn-edit" href="' . $filePath . '" target="_blank" title="View ' . $fileName . '">';
                                                echo '<i class="' . $iconClass . '"></i> View File'; // You can customize text here
                                                echo '</a>';
                                            } else {
                                                echo 'N/A';
                                            }
                                        } else {
                                            echo 'N/A';
                                        }
                                        ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

    <div id="diagnosisModal" class="modal">
          <div class="modal-content">
            <span class="close" onclick="closeModal('diagnosisModal')">&times;</span> <h2>Diagnosis
                 <button class="btn btn-edit" onclick="openAddModal('addDiagnosisModal')"><i class="fas fa-plus"></i> Add</button>
            </h2>
            <div class="one-column-section">
                <div class="column">
                    <div class="detail-item">
                         <?php if (empty($patient_diagnosis)): ?>
                            <div class="detail-value">No diagnosis records found.</div>
                        <?php else: ?>
                        <table style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Year</th>
                                    <th>Diagnosis</th>
                                    <th>Attending Doctor</th>
                                    <th>Hospital</th>
                                    <th>Note</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($patient_diagnosis as $diag): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($diag['diagnosisyear']); ?></td>
                                        <td><?php echo htmlspecialchars($diag['diagnosis1']); ?></td>
                                        <td><?php echo htmlspecialchars($diag['attending']); ?></td>
                                        <td><?php echo htmlspecialchars($diag['hospital']); ?></td>
                                       <td style="white-space: pre-wrap;"><?php echo nl2br(htmlspecialchars($diag['note'])); ?></td>
                                     </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="addComplaintModal" class="modal">
    <div class="modal-content" style="max-width: 600px;">
        <span class="close" onclick="closeModal('addComplaintModal')">&times;</span>
        <h2>Add New Complaint/Symptom</h2>
        <form id="complaintForm" action="add_complaint.php" method="POST">
            <input type="hidden" name="patient_id" value="<?php echo htmlspecialchars($patient_id); ?>">
             <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>"> <div class="detail-item">
                <span class="detail-label">Complaint Details</span>
                <textarea name="complaint_details" class="detail-value" style="height: 150px;" required></textarea>
            </div>
            <div class="action-buttons">
                <button type="submit" class="btn btn-edit"><i class="fas fa-save"></i> Save</button>
                <button type="button" class="btn btn-back" onclick="closeModal('addComplaintModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>

<div id="addLabModal" class="modal">
    <div class="modal-content" style="max-width: 800px;">
        <span class="close" onclick="closeModal('addLabModal')">&times;</span>
        <h2>Add New Lab Result / Procedure</h2>
        <form id="labForm" action="add_lab_result.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="patient_id" value="<?php echo htmlspecialchars($patient_id); ?>">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>"> <div class="two-column-section">
                <div class="column">
                    <div class="detail-item">
                        <span class="detail-label">Test/Procedure Date</span>
                        <input type="date" name="test_date" class="detail-value" required value="<?php echo date('Y-m-d'); ?>">
                    </div> 
                    <div class="detail-item">
                        <span class="detail-label">Test/Procedure Type</span>
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <select name="test_type" id="testTypeSelect" class="detail-value" style="flex: 1;" required>
                                <option value="">Select...</option>
                                <?php
                                // Ensure $conn and $my_tables_use are available and initialized
                                if (isset($conn) && isset($my_tables_use)) {
                                    $cdquery = "SELECT * FROM ".$my_tables_use."_laboratory.test_type ORDER BY details ASC";
                                    $cdresult = mysqli_query($conn, $cdquery);
                                    if ($cdresult) {
                                        while ($cdrow = mysqli_fetch_array($cdresult)) {
                                            $cdTitle = htmlspecialchars(strtoupper($cdrow["details"]));
                                            // $dept = $cdrow["code"].' - '.strtoupper($cdrow["details"]); // Using just title for value
                                            echo "<option value=\"".$cdTitle."\">". $cdTitle."</option>";
                                        }
                                    } else {
                                        echo "<option value=''>Error loading types</option>";
                                        error_log("Error fetching test types: " . mysqli_error($conn));
                                    }
                                } else {
                                     echo "<option value=''>DB connection error</option>";
                                }
                                ?>
                                <option value="other">Other (Add New)</option>
                            </select>
                        </div>
                        <div id="newTestTypeContainer" style="display: none; margin-top: 10px;">
                            <input type="text" name="new_test_type" id="newTestTypeInput" class="detail-value" placeholder="Enter new test/procedure type">
                        </div>
                    </div>
                </div>
                <div class="column">
                    <div class="detail-item">
                        <span class="detail-label">Notes / Particulars</span>
                        <textarea name="notes_lab" class="detail-value" style="height: 100px;"></textarea>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Upload File(s) (Optional)</span>
                        <input type="file" name="lab_file[]" class="detail-value" multiple> <small>You can select multiple files.</small>
                    </div>
                </div>
            </div>
            <div class="action-buttons">
                <button type="submit" class="btn btn-edit"><i class="fas fa-save"></i> Save</button>
                <button type="button" class="btn btn-back" onclick="closeModal('addLabModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>

<div id="addMedicationModal" class="modal">
    <div class="modal-content" style="max-width: 700px;">
        <span class="close" onclick="closeModal('addMedicationModal')">&times;</span>
        <h2>Add New Medication</h2>
        <form id="medicationForm" action="add_medication.php" method="POST">
            <input type="hidden" name="patient_id" value="<?php echo htmlspecialchars($patient_id); ?>">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>"> <div class="two-column-section">
                <div class="column">
                    <div class="detail-item">
                        <span class="detail-label">Medication Name</span>
                        <input type="text" name="medication_name" class="detail-value" required>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Dosage</span>
                        <input type="text" name="dosage" class="detail-value" required>
                    </div>
                </div>
                <div class="column">
                    <div class="detail-item">
                        <span class="detail-label">Frequency</span>
                        <input type="text" name="frequency" class="detail-value" required>
                    </div>
                     <div class="detail-item">
                        <span class="detail-label">Date Added</span>
                        <input type="datetime-local" name="medication_date" class="detail-value" value="<?php echo date('Y-m-d\TH:i'); ?>" required>
                    </div>
                </div>
            </div>
             <div class="detail-item">
                <span class="detail-label">Instructions</span>
                <textarea name="instructions" class="detail-value" style="height: 100px;"></textarea>
            </div>
            <div class="action-buttons">
                <button type="submit" class="btn btn-edit"><i class="fas fa-save"></i> Save</button>
                <button type="button" class="btn btn-back" onclick="closeModal('addMedicationModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>

<div id="addReadingModal" class="modal">
    <div class="modal-content" style="max-width: 600px;">
        <span class="close" onclick="closeModal('addReadingModal')">&times;</span>
        <h2>Add Clinical Reading</h2>
        <form id="readingForm" action="add_reading.php" method="POST">
            <input type="hidden" name="patient_id" value="<?php echo htmlspecialchars($patient_id); ?>">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>"> <div class="two-column-section">
                <div class="column">
                    <div class="detail-item">
                        <span class="detail-label">Date & Time</span>
                        <input type="datetime-local" name="reading_date" class="detail-value" value="<?php echo date('Y-m-d\TH:i'); ?>" required>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Blood Pressure (e.g., 120/80)</span>
                        <input type="text" name="bp" class="detail-value" placeholder="e.g., 120/80 mmHg">
                    </div>
                     <div class="detail-item">
                        <span class="detail-label">Heart Rate (bpm)</span>
                        <input type="number" name="heart_rate" class="detail-value" placeholder="e.g., 70">
                    </div>
                </div>
                <div class="column">
                   
                    <div class="detail-item">
                        <span class="detail-label">Weight (kg)</span>
                        <input type="number" step="0.1" name="weight_kg" class="detail-value" placeholder="e.g., 65.5">
                    </div>

                     <div class="detail-item">
                        <span class="detail-label">Height (cm)</span>
                        <input type="number" step="0.1" name="height_cm" class="detail-value" placeholder="e.g., 170">
                    </div>
                     <div class="detail-item">
                        <span class="detail-label">BMI (auto-calculated if W & H provided)</span>
                        <input type="text" name="bmi" id="bmi_display" class="detail-value" placeholder="BMI" readonly>
                    </div>
                </div>
            </div>
            <div class="detail-item">
                <span class="detail-label">Notes</span>
                <textarea name="notes" class="detail-value" style="height: 100px;"></textarea>
            </div>
            <div class="action-buttons">
                <button type="submit" class="btn btn-edit"><i class="fas fa-save"></i> Save</button>
                <button type="button" class="btn btn-back" onclick="closeModal('addReadingModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>

<div id="addDocumentModal" class="modal">
    <div class="modal-content" style="max-width: 700px;">
        <span class="close" onclick="closeModal('addDocumentModal')">&times;</span>
        <h2>Add Document</h2>
        <form id="documentForm" action="add_document.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="patient_id" value="<?php echo htmlspecialchars($patient_id); ?>">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>">
            <div class="two-column-section">
                <div class="column">
                    <div class="detail-item">
                        <span class="detail-label">Document Type</span>
                        <select name="document_type" class="detail-value" required>
                            <option value="">Select Type</option>
                            <option value="Prescription">Prescription</option>
                            <option value="Lab Result">Lab Result</option>
                            <option value="Procedure Result">Procedure Result</option>
                            <option value="Referral Letter">Referral Letter</option>
                            <option value="Medical Certificate">Medical Certificate</option>
                            <option value="Imaging Result">Imaging Result (X-Ray, CT, MRI)</option>
                            <option value="Consent Form">Consent Form</option>
                            <option value="Insurance Form">Insurance Form</option>
                            <option value="Other">Other</option>
                        </select>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Document Name / Title</span>
                        <input type="text" name="document_name" class="detail-value" required>
                    </div>
                </div>
                <div class="column">
                    <div class="detail-item">
                        <span class="detail-label">Upload File(s)</span>
                        <input type="file" name="document_file[]" class="detail-value" required multiple>
                        <small>You can select multiple files.</small>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Document Date</span>
                        <input type="date" name="document_date" class="detail-value" value="<?php echo date('Y-m-d'); ?>" required>
                    </div>
                </div>
            </div>
            <div class="detail-item">
                <span class="detail-label">Notes</span>
                <textarea name="notes" class="detail-value" style="height: 100px;"></textarea>
            </div>
            <div class="action-buttons">
                <button type="submit" class="btn btn-edit"><i class="fas fa-save"></i> Save</button>
                <button type="button" class="btn btn-back" onclick="closeModal('addDocumentModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>

<div id="addDiagnosisModal" class="modal">
    <div class="modal-content" style="max-width: 700px;">
        <span class="close" onclick="closeModal('addDiagnosisModal')">&times;</span>
        <h2>Add/Update Diagnosis</h2>
        <form id="diagnosisForm" action="add_diagnosis.php" method="POST">
           <input type="hidden" name="patient_id" value="<?php echo htmlspecialchars($patient_id); ?>">
           <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>"> <div class="two-column-section">
                <div class="column">
                    <div class="detail-item">
                        <span class="detail-label">Diagnosis</span>
                        <select name="diagnosis" class="detail-value" required>                                                                  
                            <?php
                            echo '<option value="">Select...</option>';
                            if (isset($conn) && isset($my_tables_use)) {
                                $cdquery="SELECT * FROM ".$my_tables_use."_resources.diagnosis ORDER BY details ASC";
                                $cdresult=mysqli_query($conn, $cdquery) ;
                                if ($cdresult) {
                                    while ($cdrow=mysqli_fetch_array($cdresult)) {
                                        $cdTitle=htmlspecialchars(strtoupper($cdrow["details"]));
                                        $dept_val = htmlspecialchars(strtoupper($cdrow["code"])) . ' - ' . $cdTitle;
                                        echo "<option value=\"".$dept_val."\">". $cdTitle."</option>";
                                    }
                                } else {
                                    error_log("Error fetching diagnosis list: " . mysqli_error($conn));
                                }
                            }
                            ?>
                        </select>
                     </div>
                    <div class="detail-item">
                        <span class="detail-label">Year of Diagnosis</span>
                        <input type="text" name="diagnosisyear" class="detail-value" placeholder="YYYY" pattern="\d{4}" title="Enter a 4-digit year" required>
                    </div>
                </div>
                <div class="column">
                    <div class="detail-item">
                        <span class="detail-label">Attending Doctor</span>
                       <select name="doctor" class="detail-value" required>                                                                  
                        <?php
                            echo '<option value="">Select...</option>';
                            if (isset($conn) && isset($my_tables_use)) {
                                $cdquery="SELECT * FROM ".$my_tables_use."_resources.doctor_info ORDER BY last_name ASC, first_name ASC";
                                $cdresult=mysqli_query($conn, $cdquery) ;
                                if ($cdresult) {
                                    while ($cdrow=mysqli_fetch_array($cdresult)) {
                                        $cdTitle=htmlspecialchars(strtoupper($cdrow["last_name"].', '.$cdrow["first_name"]));
                                        $dept_val=htmlspecialchars(strtoupper($cdrow["user_id"])) . ' - ' . $cdTitle;
                                        echo "<option value=\"".$dept_val."\">". $cdTitle."</option>";
                                    }
                                } else {
                                     error_log("Error fetching doctor list: " . mysqli_error($conn));
                                }
                            }
                        ?>
                        </select>
                    </div>
                    <div class="detail-item">
                        <span class="detail-label">Hospital/Clinic</span>
                        <select name="hospital" class="detail-value" required>                                                                  
                            <?php
                            echo '<option value="">Select...</option>';
                            if (isset($conn) && isset($my_tables_use)) {
                                $cdquery="SELECT * FROM ".$my_tables_use."_resources.hospital ORDER BY hospital ASC";
                                $cdresult=mysqli_query($conn, $cdquery) ;
                                if ($cdresult) {
                                    while ($cdrow=mysqli_fetch_array($cdresult)) {
                                        $cdTitle=htmlspecialchars(strtoupper($cdrow["hospital"]));
                                        $dept_val=htmlspecialchars(strtoupper($cdrow["code"])) . ' - ' . $cdTitle;
                                        echo "<option value=\"".$dept_val."\">". $cdTitle."</option>";
                                    }
                                } else {
                                     error_log("Error fetching hospital list: " . mysqli_error($conn));
                                }
                            }
                            ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="detail-item">
                <span class="detail-label">Notes</span>
                <textarea name="notes" class="detail-value" style="height: 100px;"></textarea>
            </div>
            <div class="action-buttons">
                <button type="submit" class="btn btn-edit"><i class="fas fa-save"></i> Save</button>
                <button type="button" class="btn btn-back" onclick="closeModal('addDiagnosisModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>

<div id="addNoteModal" class="modal">
    <div class="modal-content" style="max-width: 600px;">
        <span class="close" onclick="closeModal('addNoteModal')">&times;</span>
        <h2>Add Doctor's / Nurse's Note</h2>
        <form id="noteForm" action="add_note.php" method="POST">
            <input type="hidden" name="patient_id" value="<?php echo htmlspecialchars($patient_id); ?>">
            <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($user_id); ?>"> <input type="hidden" name="created_by" value="CurrentLoggedInUser"> <div class="detail-item">
                <span class="detail-label">Note Content</span>
                <textarea name="note_content" class="detail-value" style="height: 200px;" required></textarea>
            </div>
            <div class="action-buttons">
                <button type="submit" class="btn btn-edit"><i class="fas fa-save"></i> Save</button>
                <button type="button" class="btn btn-back" onclick="closeModal('addNoteModal')">Cancel</button>
            </div>
        </form>
    </div>
</div>

    <script src="prescription-printer.js"></script>


    <script>

/**
     * Toggles all medication checkboxes based on the state of the header checkbox.
     * @param {HTMLInputElement} source - The header checkbox that was clicked.
     */
    function toggleAllMedCheckboxes(source) {
        const checkboxes = document.querySelectorAll('#medicationHistoryTable .med-checkbox');
        for (let i = 0; i < checkboxes.length; i++) {
            checkboxes[i].checked = source.checked;
        }
    }

    /**
     * Gathers data from selected medications in the modal and prints a prescription.
     */
    function handlePrintFromModal() {
        const patientName = document.querySelector('.patient-header h1').textContent.trim();
        // Use the current date for the prescription
        const visitDate = new Date().toLocaleDateString('en-US', {
            year: 'numeric', month: 'long', day: 'numeric'
        });

        const medicationsData = [];
        // Find only the checkboxes that are checked within the table body
        const checkedRows = document.querySelectorAll('#medicationHistoryTable tbody .med-checkbox:checked');

        if (checkedRows.length === 0) {
            alert('Please select at least one medication to print.');
            return;
        }

        checkedRows.forEach(checkbox => {
            // Get the parent table row (tr) of the checkbox
            const row = checkbox.closest('.medication-row');
            if (row) {
                medicationsData.push({
                    name: row.querySelector('.med-name').textContent.trim(),
                    dosage: row.querySelector('.med-dosage').textContent.trim(),
                    frequency: row.querySelector('.med-frequency').textContent.trim(),
                    // Use innerHTML to preserve line breaks from nl2br()
                    instructions: row.querySelector('.med-instructions').innerHTML.trim()
                });
            }
        });
        
        // Call the global function from prescription-printer.js
        printPrescription(patientName, visitDate, medicationsData);
    }

    // General Modal Functions
    function openModal(modalId) {
        // Close any other open modals first to prevent overlap
        var currentlyOpenModals = document.querySelectorAll('.modal');
        currentlyOpenModals.forEach(function(mod) {
            if (mod.id !== modalId) { // Don't close the one we are about to open
                 // mod.style.display = 'none'; // This line was causing issues, removed.
            }
        });
        var modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'block';
        }
    }

    function closeModal(modalId) {
        var modal = document.getElementById(modalId);
        if (modal) {
            modal.style.display = 'none';
        }
    }

    function openAddModal(modalId) {
        // This function is specifically for "Add" modals.
        // It first ensures all other modals are closed.
        var allModals = document.getElementsByClassName('modal');
        for (var i = 0; i < allModals.length; i++) {
            allModals[i].style.display = 'none';
        }
        // Then opens the requested "Add" modal
        var modalToOpen = document.getElementById(modalId);
        if (modalToOpen) {
            modalToOpen.style.display = 'block';
        }
    }
    
    // Close modal when clicking outside of it (on the semi-transparent background)
    window.onclick = function(event) {
        if (event.target.classList.contains('modal')) {
            event.target.style.display = 'none';
        }
    }

    // Close modal with Escape key
    document.addEventListener('keydown', function(event) {
        if (event.key === "Escape") {
            var modals = document.getElementsByClassName('modal');
            for (var i = 0; i < modals.length; i++) {
                if (modals[i].style.display === 'block') {
                    modals[i].style.display = 'none';
                }
            }
        }
    });

    document.addEventListener('DOMContentLoaded', function() {
        // Script for "Add Lab Result" modal - new test type
        const testTypeSelect = document.getElementById('testTypeSelect');
        const newTestTypeContainer = document.getElementById('newTestTypeContainer');
        const newTestTypeInput = document.getElementById('newTestTypeInput');
        
        if (testTypeSelect) {
            testTypeSelect.addEventListener('change', function() {
                if (this.value === 'other') {
                    if(newTestTypeContainer) newTestTypeContainer.style.display = 'block';
                    if(newTestTypeInput) newTestTypeInput.required = true;
                } else {
                    if(newTestTypeContainer) newTestTypeContainer.style.display = 'none';
                    if(newTestTypeInput) newTestTypeInput.required = false;
                }
            });
        }
        
        // Form submission validation for new test type
        const labForm = document.getElementById('labForm');
        if (labForm) {
            labForm.addEventListener('submit', function(e) {
                if (testTypeSelect && testTypeSelect.value === 'other' && newTestTypeInput && !newTestTypeInput.value.trim()) {
                    e.preventDefault();
                    // Replace alert with a more user-friendly notification if possible
                    alert('Please enter the new test/procedure type or select an existing one.');
                    newTestTypeInput.focus();
                }
            });
        }

        // BMI Calculation for "Add Clinical Reading" modal
        const weightInput = document.querySelector('input[name="weight_kg"]');
        const heightInput = document.querySelector('input[name="height_cm"]');
        const bmiDisplay = document.getElementById('bmi_display');

        function calculateBMI() {
            if (weightInput && heightInput && bmiDisplay) {
                const weight = parseFloat(weightInput.value);
                const height = parseFloat(heightInput.value);

                if (weight > 0 && height > 0) {
                    const heightInMeters = height / 100;
                    const bmi = weight / (heightInMeters * heightInMeters);
                    bmiDisplay.value = bmi.toFixed(2);
                } else {
                    bmiDisplay.value = '';
                }
            }
        }

        if (weightInput) weightInput.addEventListener('input', calculateBMI);
        if (heightInput) heightInput.addEventListener('input', calculateBMI);


        

    });
</script>
</body>
</html>
