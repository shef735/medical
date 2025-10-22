<?php
include 'config.php';
 

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
$sql = "SELECT r.*, t.template_name 
        FROM ".$_SESSION['my_tables']."_laboratory.test_results r
        JOIN ".$_SESSION['my_tables']."_laboratory.test_templates t ON r.template_id = t.template_id
        WHERE r.patient_id = $patient_id
        ORDER BY r.test_date DESC";

$result = mysqli_query($conn, $sql);
$test_results = array();
while ($row = mysqli_fetch_assoc($result)) {
    $test_results[] = $row;
}

$user_id = $patient['user_id'];
$sql = "SELECT * FROM patient_record WHERE user_id = '".$user_id."'";
$result = mysqli_query($conn, $sql);
$patient_record = mysqli_fetch_assoc($result);

$sql = "SELECT * FROM patient_details WHERE user_id = '".$user_id."'";
$result = mysqli_query($conn, $sql);
$patient_details = mysqli_fetch_assoc($result);

$sql = "SELECT * FROM visit_documents WHERE user_id = '".$user_id."'";
$result = mysqli_query($conn, $sql);
$patient_documents = array();
while ($row = mysqli_fetch_assoc($result)) {
    $patient_documents[] = $row;
}

$sql = "SELECT * FROM patient_notes WHERE user_id = '".$user_id."'";
$result = mysqli_query($conn, $sql);
$patient_notes = array();
$note_ctr='';
while ($row = mysqli_fetch_assoc($result)) {
    $patient_notes[] = $row;
    $note_ctr='Y';
}

// Fetch clinical readings
$sql = "SELECT * FROM clinical_readings WHERE user_id = '".$user_id."' ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
$patient_readings = array();
$reading_ctr='';
while ($row = mysqli_fetch_assoc($result)) {
    $patient_readings[] = $row;
    $reading_ctr='Y';
}

// Fetch findings
$sql = "SELECT * FROM clinic_visits WHERE user_id = '".$user_id."'";
$result = mysqli_query($conn, $sql);
$patient_visits = array();
$visits_ctr='';
while ($row = mysqli_fetch_assoc($result)) {
    $patient_visits[] = $row;
    $visits_ctr='Y';
}

// Fetch lab request
$sql = "SELECT * FROM lab_requests WHERE user_id = '".$user_id."' ORDER BY request_date DESC";
$result = mysqli_query($conn, $sql);
$patient_lab_request = array();
$lab_request_ctr='';
while ($row = mysqli_fetch_assoc($result)) {
    $patient_lab_request[] = $row;
    $lab_request_ctr='Y';
}

// Fetch medication
$sql = "SELECT * FROM medications WHERE user_id = '".$user_id."' ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
$patient_medication = array();
$medication_ctr='';
while ($row = mysqli_fetch_assoc($result)) {
    $patient_medication[] = $row;
    $medication_ctr='Y';
}

// Fetch documents
$sql = "SELECT * FROM visit_documents WHERE user_id = '".$user_id."' ORDER BY created_at DESC";
$result = mysqli_query($conn, $sql);
$patient_document = array();
$document_ctr='';
while ($row = mysqli_fetch_assoc($result)) {
    $patient_document[] = $row;
    $document_ctr='Y';
}

 

              
// Format birthdate for age calculation
$birthday = new DateTime($patient['birthday']);
$today = new DateTime();
$age = $today->diff($birthday)->y;

include "load-values.php";
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
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: #fff;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            color: #2c3e50;
            margin-bottom: 5px;
            font-size: 24px;
        }
        h2 {
            color: #3498db;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            margin-top: 20px;
            font-size: 18px;
        }
        .patient-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        .status-active {
            color: #2ecc71;
            font-weight: bold;
        }
        .details-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 15px;
        }
        .detail-item {
            display: flex;
            flex-direction: column;
            margin-bottom: 10px;
        }
        .detail-label {
            font-weight: bold;
            color: #7f8c8d;
            font-size: 0.9em;
            margin-bottom: 3px;
        }
        .detail-value {
            padding: 5px;
            background: #f9f9f9;
            border-radius: 3px;
            min-height: 20px;
        }
        .section {
            margin-bottom: 30px;
        }
        .divider {
            border-top: 1px dashed #ddd;
            margin: 20px 0;
        }
        .action-buttons {
            margin-top: 20px;
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
        }
        .btn {
            padding: 8px 15px;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            font-size: 14px;
            cursor: pointer;
            border: none;
            transition: all 0.3s ease;
        }
        .btn-edit {
            background: #3498db;
        }
        .btn-edit:hover {
            background: #2980b9;
        }
        .btn-visits {
            background: #9b59b6;
        }
        .btn-visits:hover {
            background: #8e44ad;
        }
        .btn-back {
            background: #95a5a6;
        }
        .btn-back:hover {
            background: #7f8c8d;
        }
        .btn-modal {
            background: #e67e22;
        }
        .btn-modal:hover {
            background: #d35400;
        }
        .diagnosis-section {
            background: #f9f9f9;
            padding: 15px;
            border-radius: 4px;
            margin-top: 20px;
        }
        .three-column-section {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
        }
        .two-column-section {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        .one-column-section {
            display: grid;
            grid-template-columns: 1fr;
            gap: 20px;
        }
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
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 5% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 900px;
            border-radius: 5px;
            max-height: 80vh;
            overflow-y: auto;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover {
            color: black;
        }
        
        /* Table styles */
        .detail-item table {
            width: 100%;
            border-collapse: collapse;
            margin: 15px 0;
            font-size: 0.9em;
            font-family: Arial, sans-serif;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
            overflow: hidden;
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
        }
        .detail-item tbody tr {
            border-bottom: 1px solid #dddddd;
            transition: all 0.2s ease;
        }
        .detail-item tbody tr:nth-of-type(even) {
            background-color: #f8f9fa;
        }
        .detail-item tbody tr:last-of-type {
            border-bottom: 2px solid #3498db;
        }
        .detail-item tbody tr:hover {
            background-color: #e9f5ff;
            transform: scale(1.005);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .detail-item .actions {
            display: flex;
            gap: 8px;
            flex-wrap: wrap;
        }
        .detail-item .btn {
            padding: 6px 10px;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            font-size: 0.8em;
            display: inline-flex;
            align-items: center;
            transition: all 0.2s ease;
        }
        .detail-item .pdf-icon {
            margin-left: 4px;
            font-size: 0.9em;
        }
        
        /* Responsive adjustments */
        @media (max-width: 768px) {
            .details-grid, .three-column-section, .two-column-section {
                grid-template-columns: 1fr;
            }
            .detail-item table {
                display: block;
                overflow-x: auto;
            }
            .detail-item .actions {
                flex-direction: column;
                gap: 5px;
            }
            .detail-item .btn {
                width: 100%;
                text-align: center;
                justify-content: center;
            }
            .modal-content {
                width: 95%;
                margin: 10% auto;
            }
        }
        
        /* Animation for hover effects */
        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }
        .detail-item tbody tr {
            animation: fadeIn 0.3s ease-in;
        }
        
        /* Summary cards */
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }
        .summary-card {
            background: #fff;
            border-radius: 8px;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            transition: all 0.3s ease;
            cursor: pointer;
            border-left: 4px solid #3498db;
        }
        .summary-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .summary-card h3 {
            margin-top: 0;
            color: #3498db;
            font-size: 16px;
        }
        .summary-card .count {
            font-size: 24px;
            font-weight: bold;
            margin: 10px 0;
        }
        .summary-card .view-link {
            color: #3498db;
            text-decoration: none;
            font-size: 14px;
            display: flex;
            align-items: center;
        }
        .summary-card .view-link i {
            margin-left: 5px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="patient-header">
            <h1><?php echo $user_id.' - '.$patient['last_name'] . ', ' . $patient['first_name'] . ' ' . $patient['middle_name']; ?></h1>
            <span class="status-active">active</span>
        </div>

        <div class="section">
            <h2>Details</h2>
            <div class="three-column-section">
                <div class="column">
                    <div class="detail-item">
                        <?php
                            $photo="default.png";
                            if($patient['photo']!='') {
                                $photo=$patient['photo'];
                            }
                        ?>                       
                       <img src="../patient-form/uploads/<?php echo $photo ?>" style="width: 95%; max-width: 300px; border-radius: 5px;" >
                    </div>
                </div>
                
                <div class="column">
                    <div class="detail-item">
                        <span class="detail-label">Age (Birthdate)</span>
                        <div class="detail-value"><?php echo $age . ' ('.date('M d, Y', strtotime($patient['birthday'])).')'; ?></div>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">Gender</span>
                        <div class="detail-value"><?php echo $patient['gender']; ?></div>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">Contact</span>
                        <div class="detail-value"><?php echo $patient['phone'] ? $patient['phone'] : 'n/a'; ?>, n/a</div>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">Email</span>
                        <div class="detail-value"><?php echo $patient['email'] ?? 'N/A'; ?></div>
                    </div>
                </div>
                
                <div class="column">
                    <div class="detail-item">
                        <span class="detail-label">Occupation</span>
                        <div class="detail-value"><?php echo $patient['occupation'] ?? 'N/A'; ?></div>
                    </div>

                    <div class="detail-item">
                        <span class="detail-label">Referred by</span>
                        <div class="detail-value"><?php echo $patient['referred_by'] ?? 'N/A'; ?></div>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">Other MDs</span>
                        <div class="detail-value"><?php echo $patient['other_mds'] ?? 'N/A'; ?></div>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">Address</span>
                        <div class="detail-value">
                            <?php 
                            echo $patient['NoBldgName'] ? $patient['NoBldgName'] . ', ' : '';
                            echo $patient['StreetName'] ? $patient['StreetName'] . ', ' : '';
                            echo $patient['psgc_barangay'] ? $patient['psgc_barangay'] . ', ' : '';
                            echo $patient['psgc_municipality'] ? $patient['psgc_municipality'] . ', ' : '';
                            echo $patient['psgc_province'] ?? '';
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="divider"></div>

        <!-- Summary Cards -->
     <!-- In the summary-cards section, replace all count checks with null-safe versions -->

<div class="summary-cards">
    <div class="summary-card" onclick="openModal('complaintsModal')">
        <h3>Complaints/Symptoms</h3>
        <div class="count"><?php echo !empty($complains) ? count(explode(',', $complains)) : '0'; ?></div>
        <a class="view-link">View Details <i class="fas fa-chevron-right"></i></a>
    </div>
    
    <div class="summary-card" onclick="openModal('labModal')">
        <h3>Laboratory / Procedure Results</h3>
        <div class="count"><?php echo  $lab_ctr; ?></div>
        <a class="view-link">View Details <i class="fas fa-chevron-right"></i></a>
    </div>
    
    <div class="summary-card" onclick="openModal('medicationModal')">
        <h3>Medications & Prescriptions</h3>
        <div class="count"><?php echo $med_ctr; ?></div>
        <a class="view-link">View Details <i class="fas fa-chevron-right"></i></a>
    </div>
    
    <div class="summary-card" onclick="openModal('readingsModal')">
        <h3>Clinical Readings</h3>
        <div class="count"><?php echo count($patient_readings); ?></div>
        <a class="view-link">View Details <i class="fas fa-chevron-right"></i></a>
    </div>
    
    <div class="summary-card" onclick="openModal('documentsModal')">
        <h3>Documents & Forms</h3>
        <div class="count"><?php echo count($patient_document); ?></div>
        <a class="view-link">View Details <i class="fas fa-chevron-right"></i></a>
    </div>
    
    <div class="summary-card" onclick="openModal('diagnosisModal')">
        <h3>Diagnosis & Medical History</h3>
        <div class="count"><?php echo !empty($diagnosis) ? '1' : '0'; ?></div>
        <a class="view-link">View Details <i class="fas fa-chevron-right"></i></a>
    </div>

    <div class="summary-card" onclick="openModal('notesModal')">
        <h3>Doctors / Nurses Notes</h3>
        <div class="count"><?php echo count($patient_notes); ?></div>
        <a class="view-link">View Details <i class="fas fa-chevron-right"></i></a>
    </div>

    
</div>

        <div class="divider"></div>

        <div class="diagnosis-section">
            <div class="two-column-section">
                <div class="column">
                    <h2>Diagnosis</h2>
                  
                    <div class="detail-value"><?php echo $diagnosis ? $diagnosis : 'No diagnosis recorded'; ?></div>
                </div>
                
                <div class="column">
                    <h2>Other Notes</h2>
                    
                    <div class="detail-value"><?php echo $notes ? $notes : 'No additional notes'; ?></div>
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <a href="edit_patient.php?id=<?php echo $patient_id; ?>" class="btn btn-edit">Edit Patient</a>
            <a href="patient_visits.php?patient_id=<?php echo $patient_id; ?>" class="btn btn-visits">View Visits</a>
            <button onclick="openModal('complaintsModal')" class="btn btn-modal">View Complaints</button>
            <button onclick="openModal('labModal')" class="btn btn-modal">View Lab Results</button>
            <button onclick="openModal('medicationModal')" class="btn btn-modal">View Medications</button>
            <a href="../admin/source/all-patients.php" class="btn btn-back">Back to List</a>
        </div>
    </div>

    <!-- Complaints/Symptoms Modal -->
    <div id="complaintsModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('complaintsModal')">&times;</span>
            <h2>Complaints/Symptoms</h2>
            <div class="one-column-section">
                <div class="column">
                    <div class="detail-item">
                     
                        <div class="detail-value" style="white-space: pre-wrap;"><?php echo $complains ?? 'N/A'; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lab Results Modal -->
    <div id="labModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('labModal')">&times;</span>
            <h2>Laboratory/Procedure Results</h2>
            <div class="one-column-section">
                <div class="column">
                    <div class="detail-item">
                        <table style="width: 100%;">
                            <thead>
                                <tr>
                                    <th style="text-align: left;">Date</th>
                                    <th style="text-align: left;">Type</th>
                                    <th style="text-align: left;">Particulars</th>
                                    <th style="text-align: left;"></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($test_results as $test): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($test['test_date']); ?></td>
                                        <td><?php echo htmlspecialchars($test['template_name']); ?></td>
                                        <td></td>
                                        <td class="actions">
                                            <a target="_blank" class="btn btn-edit" href="../lab_system/view_result.php?id=<?php echo $test['result_id']; ?>">View Details</a>
                                            <a class="btn btn-visits" target="_blank" href="../lab_system/pdf_report.php?id=<?php echo $test['result_id']; ?>">PDF <span class="pdf-icon">📄</span></a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <?php foreach ($patient_documents as $docs): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($docs['created_at']); ?></td>
                                        <td><?php echo htmlspecialchars($docs['document_type']); ?></td>
                                        <td></td>
                                        <td class="actions">
                                            <a class="btn btn-edit" href="<?php echo $docs['file_path']; ?>" target="_blank">View</a> 
                                        </td>
                                    </tr>
                                <?php endforeach; ?>

                                <?php if(isset($patient_record['proceduredone']) AND $patient_record['proceduredone']!=''): ?>
                                    <tr>
                                        <td><?php echo $patient_record['dateofcolonoscopy']; ?></td>
                                        <td><?php echo $patient_record['proceduredone']; ?></td>
                                        <td><?php echo $patient_record['endoscopicfindings'].'</br>'.
                                            $patient_record['histopathfindings1'].' '.
                                            $patient_record['histopathfindings2'].' '.
                                            $patient_record['histopathfindings3'].' '.
                                            $patient_record['behaviorcd'].' '.$patient_record['montrealextentforuc']; ?></td>
                                        <td></td>
                                    </tr>
                                <?php endif; ?>

                                <?php if(isset($patient_record['hgblevels']) AND ltrim($patient_record['hgblevels'])!=''): ?>
                                    <tr>
                                        <td>N/A</td>
                                        <td>CBC (BLOOD TEST)</td>
                                        <td>
                                            HGB: <?php echo $patient_record['hgblevels']; ?></br>
                                            Platelet Count: <?php echo $patient_record['plateletcount']; ?></br>
                                            Albumin: <?php echo $patient_record['albumin']; ?></br>
                                            CRP Level: <?php echo $patient_record['crplevel']; ?></br>
                                            ESR: <?php echo $patient_record['esr']; ?>                
                                        </td>
                                        <td></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Medications Modal -->
    <div id="medicationModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('medicationModal')">&times;</span>
            <h2>Medications & Prescriptions</h2>
            <div class="one-column-section">
                <div class="column">
                    <div class="detail-item">
                     
                        <div class="detail-value"><?php echo $medication_details ?? 'N/A'; ?></div>
                    </div>
                </div>
            </div>
            
            <?php if($medication_ctr!=''): ?>
            <div class="one-column-section">
                <div class="column">
                    <div class="detail-item">
                        <table style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Created At</th>
                                    <th>Medication</th>
                                    <th>Dosage</th>
                                    <th>Frequency</th>
                                    <th>Instructions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($patient_medication as $pat_med): ?>
                                    <tr>
                                        <td><?php echo $pat_med['created_at']; ?></td>
                                        <td><?php echo $pat_med['medication_name']; ?></td>
                                        <td><?php echo $pat_med['dosage']; ?></td>
                                        <td><?php echo $pat_med['frequency']; ?></td>
                                        <td><?php echo $pat_med['instructions']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>

      <!-- Patient Notes Modal -->
      <div id="notesModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('notesModal')">&times;</span>
            <h2>Doctors / Nurses Notes</h2>
            <div class="one-column-section">
                <div class="column">
                    <div class="detail-item">
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
                                        <td><?php echo $pat_notes['created_date']; ?></td>
                                        <td><?php echo $pat_notes['note_content']; ?></td>
                                        <td><?php echo $pat_notes['created_by']; ?></td>
                                         
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Clinical Readings Modal -->
    <div id="readingsModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('readingsModal')">&times;</span>
            <h2>Clinical Readings</h2>
            <div class="one-column-section">
                <div class="column">
                    <div class="detail-item">
                        <table style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Visit Date</th>
                                    <th>Blood Pressure</th>
                                    <th>Heart Rate</th>
                                    <th>Weight</th>
                                    <th>Height</th>
                                    <th>BMI</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($patient_readings as $pat_read): ?>
                                    <tr>
                                        <td><?php echo $pat_read['created_at']; ?></td>
                                        <td><?php echo $pat_read['bp']; ?></td>
                                        <td><?php echo $pat_read['heart_rate']; ?> bpm</td>
                                        <td><?php echo $pat_read['weight_kg']; ?> kg</td>
                                        <td><?php echo $pat_read['height_cm']; ?> cm</td>
                                        <td><?php echo $pat_read['bmi']; ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Documents Modal -->
    <div id="documentsModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('documentsModal')">&times;</span>
            <h2>Documents & Forms</h2>
            <div class="one-column-section">
                <div class="column">
                    <div class="detail-item">
                        <table style="width: 100%;">
                            <thead>
                                <tr>
                                    <th>Date</th>
                                    <th>Type</th>
                                    <th>Name</th>
                                    <th>Notes</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($patient_document as $doc): ?>
                                    <tr>
                                        <td><?php echo $doc['created_at']; ?></td>
                                        <td><?php echo $doc['document_type']; ?></td>
                                        <td><?php echo $doc['document_name']; ?></td>
                                        <td><?php echo nl2br($doc['notes']); ?></td>
                                        <td><a href="<?php echo $doc['file_path']; ?>" target="_blank">View</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Diagnosis Modal -->
    <div id="diagnosisModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('diagnosisModal')">&times;</span>
            <h2>Diagnosis & Medical History</h2>
            <div class="three-column-section">
                <div class="column">
                    <h3>Diagnosis</h3>
                    <div class="detail-value"><?php echo $diagnosis ? $diagnosis : 'No diagnosis recorded'; ?></div>
                    
                    <h3>Adverse Drug Reactions</h3>
                    <div class="detail-value"><?php echo $patient_details['adverse_drug_reactions'] ?? 'No adverse reactions recorded'; ?></div>
                </div>
                
                <div class="column">
                    <h3>Medical History</h3>
                    <div class="detail-item">
                        <span class="detail-label">FMHx:</span>
                        <div class="detail-value"><?php echo $patient_details['family_history'] ?? 'N/A'; ?></div>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">SHx:</span>
                        <div class="detail-value"><?php echo $patient_details['social_history'] ?? 'N/A'; ?></div>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">Immunization:</span>
                        <div class="detail-value"><?php echo $patient_details['immunization_history'] ?? 'N/A'; ?></div>
                    </div>
                </div>
                
                <div class="column">
                    <div class="detail-item">
                        <span class="detail-label">Smoking:</span>
                        <?php
                            $smoker='';
                            if(isset($patient_details['smoker'])) {
                                $smoker.=$patient_details['smoker'];
                            }
                            if(isset($patient_details['pack_per_day']) AND (float)$patient_details['pack_per_day']>0) {
                                $smoker.=' '.$patient_details['pack_per_day'].' pack/day ' ;
                            }
                            if(isset($patient_details['years_smoking'])) {
                                $smoker.=$patient_details['years_smoking'].' years';
                            }
                        ?>
                        <div class="detail-value"><?php echo $smoker ?? 'N/A'; ?></div>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">Alcohol:</span>
                        <div class="detail-value"><?php echo $patient_details['alcohol_history'] ?? 'N/A'; ?></div>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">DM:</span>
                        <div class="detail-value"><?php echo $patient_details['diabetes_history'] ?? 'N/A'; ?></div>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">HTN:</span>
                        <div class="detail-value"><?php echo $patient_details['hypertension_history'] ?? 'N/A'; ?></div>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">Cancer:</span>
                        <div class="detail-value"><?php echo $patient_details['cancer_history'] ?? 'N/A'; ?></div>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">Goiter:</span>
                        <div class="detail-value"><?php echo $patient_details['goiter_history'] ?? 'N/A'; ?></div>
                    </div>
                    
                    <div class="detail-item">
                        <span class="detail-label">OB Menstrual Hx:</span>
                        <div class="detail-value"><?php echo $patient_details['menstrual_history'] ?? 'N/A'; ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Modal functions
        function openModal(modalId) {
            document.getElementById(modalId).style.display = 'block';
        }
        
        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }
        
        // Close modal when clicking outside of it
        window.onclick = function(event) {
            if (event.target.className === 'modal') {
                event.target.style.display = 'none';
            }
        }
    </script>
</body>
</html>