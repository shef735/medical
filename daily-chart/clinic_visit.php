<?php
include 'config.php';

// Check if patient ID is provided
if (!isset($_GET['patient_id'])) {
    header("Location: index.php");
    exit;
}


function cleanfile($string) {
   // Replace single quotes with backticks
    $string = str_replace('\'', '`', $string);
    
    // Replace double quotes with double backticks
    $string = str_replace('"', '``', $string);
    
    return $string;
} 


$patient_id = $_GET['patient_id'];

// Fetch patient information
$patient_sql = "SELECT * FROM ".$_SESSION['my_tables']."_resources.patient_info WHERE id = $patient_id";
$patient_result = mysqli_query($conn, $patient_sql);
$patient = mysqli_fetch_assoc($patient_result);

if (!$patient) {
    header("Location: index.php");
    exit;
}

$user_id=$patient['user_id'];

// Fetch the last case number for this patient
$last_case_sql = "SELECT case_number FROM ".$_SESSION['my_tables']."_resources.clinic_visits 
                  WHERE patient_id = $patient_id 
                  ORDER BY id DESC LIMIT 1";
$last_case_result = mysqli_query($conn, $last_case_sql);
$last_case = mysqli_fetch_assoc($last_case_result);

// Generate new case number
if ($last_case && preg_match('/^(\d{4}-\d{2}-)(\d+)$/', $last_case['case_number'], $matches)) {
    $prefix = $matches[1];
    $number = intval($matches[2]) + 1;
    $case_number = $prefix . str_pad($number, 3, '0', STR_PAD_LEFT);
} else {
    // First case for this patient - start with current year-month-001
    $case_number = date('Y-m') . '-001';
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Insert clinic visit
    $visit_date = mysqli_real_escape_string($conn, $_POST['visit_date']);
    $case_number = mysqli_real_escape_string($conn, $_POST['case_number']);
    $review_of_systems = cleanfile(mysqli_real_escape_string($conn, $_POST['review_of_systems']));
    $objective = cleanfile(mysqli_real_escape_string($conn, $_POST['objective']));
    $assessment = cleanfile(mysqli_real_escape_string($conn, $_POST['assessment']));
    $plans = cleanfile(mysqli_real_escape_string($conn, $_POST['plans']));
    $next_visit = cleanfile(mysqli_real_escape_string($conn, $_POST['next_visit']));
    $notes = cleanfile(mysqli_real_escape_string($conn, $_POST['notes']));
    $professional_fee = mysqli_real_escape_string($conn, $_POST['professional_fee']);
    
    $visit_sql = "INSERT INTO ".$_SESSION['my_tables']."_resources.clinic_visits (user_id, patient_id, visit_date, 
    case_number, review_of_systems, next_visit, notes, professional_fee, objective, assessment, plans) 
                  VALUES ('$user_id', $patient_id, '$visit_date', 
                  '$case_number', '$review_of_systems', '$next_visit', '$notes', '$professional_fee', '$objective', '$assessment', '$plans')";
    
    if (mysqli_query($conn, $visit_sql)) {
        $visit_id = mysqli_insert_id($conn);
        
        // Insert clinical readings
        $bp = mysqli_real_escape_string($conn, $_POST['bp']);
        $heart_rate = mysqli_real_escape_string($conn, $_POST['heart_rate']);
        $c8g = mysqli_real_escape_string($conn, $_POST['c8g']);
        $weight_kg = mysqli_real_escape_string($conn, $_POST['weight_kg']);
        $height_cm = cleanfile(mysqli_real_escape_string($conn, $_POST['height_cm']));
        $bmi = mysqli_real_escape_string($conn, $_POST['bmi']);
        $waist_cm = mysqli_real_escape_string($conn, $_POST['waist_cm']);
        $hip_cm = mysqli_real_escape_string($conn, $_POST['hip_cm']);
        $whr = cleanfile(mysqli_real_escape_string($conn, $_POST['whr']));
        $hba1c = cleanfile(mysqli_real_escape_string($conn, $_POST['hba1c']));
        
        $readings_sql = "INSERT INTO ".$_SESSION['my_tables']."_resources.clinical_readings (user_id, visit_id, bp, heart_rate, c8g, weight_kg, height_cm, bmi, waist_cm, hip_cm, whr, hba1c)
                         VALUES ('$user_id', $visit_id, '$bp', '$heart_rate', '$c8g', '$weight_kg', '$height_cm', '$bmi', '$waist_cm', '$hip_cm', '$whr', '$hba1c')";
        mysqli_query($conn, $readings_sql);
        
        // Insert lab requests
        if (!empty($_POST['tests_requested'])) {
            $tests_requested = mysqli_real_escape_string($conn, $_POST['tests_requested']);
            $lab_notes = mysqli_real_escape_string($conn, $_POST['lab_notes']);
            $request_date = mysqli_real_escape_string($conn, $_POST['request_date']);
            
            $lab_sql = "INSERT INTO ".$_SESSION['my_tables']."_resources.lab_requests (user_id, visit_id, request_date, tests_requested, lab_notes)
                         VALUES ('$user_id', $visit_id, '$request_date', '$tests_requested', '$lab_notes')";
            mysqli_query($conn, $lab_sql);
        }
        
        // Insert medications
        if (!empty($_POST['medications'])) {
            foreach ($_POST['medications'] as $med) {
                if (!empty($med['name'])) {
                    $name = mysqli_real_escape_string($conn, $med['name']);
                    $dosage = mysqli_real_escape_string($conn, $med['dosage']);
                    $frequency = mysqli_real_escape_string($conn, $med['frequency']);
                    $instructions = mysqli_real_escape_string($conn, $med['instructions']);
                    
                    $med_sql = "INSERT INTO ".$_SESSION['my_tables']."_resources.medications (user_id, visit_id, medication_name, dosage, frequency, instructions)
                                 VALUES ('$user_id', $visit_id, '$name', '$dosage', '$frequency', '$instructions')";
                    mysqli_query($conn, $med_sql);
                }
            }
        }
        
        // Handle file uploads
        if (!empty($_FILES['documents']['name'][0])) {
            foreach ($_FILES['documents']['name'] as $key => $name) {
                if ($_FILES['documents']['error'][$key] == 0) {
                    $target_dir = "../../uploads/documents/";
                    $target_file = $target_dir . basename($_FILES["documents"]["name"][$key]);
                    move_uploaded_file($_FILES["documents"]["tmp_name"][$key], $target_file);
                    
                    $doc_type = mysqli_real_escape_string($conn, $_POST['document_types'][$key]);
                    $doc_notes = mysqli_real_escape_string($conn, $_POST['document_notes'][$key]);
                    
                    $doc_sql = "INSERT INTO ".$_SESSION['my_tables']."_resources.visit_documents (user_id, visit_id, document_type, document_name, file_path, notes)
                                VALUES ('$user_id', $visit_id, '$doc_type', '$name', '$target_file', '$doc_notes')";
                    mysqli_query($conn, $doc_sql);
                }
            }
        }
        
        header("Location: view_visit.php?visit_id=$visit_id&message=Visit recorded successfully");
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}
?>
 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clinic Visit Entry</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root {
            --primary-color: #3498db;
            --secondary-color: #2980b9;
            --accent-color: #2ecc71;
            --danger-color: #e74c3c;
            --light-gray: #f8f9fa;
            --dark-gray: #343a40;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f5f5f5;
            color: #333;
        }
        
        .card {
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
            border: none;
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid rgba(0, 0, 0, 0.08);
            font-weight: 600;
            padding: 15px 20px;
        }
        
        .card-body {
            padding: 20px;
        }
        
        .nav-tabs {
            border-bottom: 2px solid #dee2e6;
        }
        
        .nav-tabs .nav-link {
            color: #495057;
            font-weight: 500;
            border: none;
            padding: 12px 20px;
            margin-right: 5px;
        }
        
        .nav-tabs .nav-link.active {
            color: var(--primary-color);
            background-color: transparent;
            border-bottom: 3px solid var(--primary-color);
        }
        
        .nav-tabs .nav-link:hover {
            border-color: transparent;
            color: var(--secondary-color);
        }
        
        .form-control, .form-select {
            padding: 10px 15px;
            border-radius: 6px;
            border: 1px solid #ced4da;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 0.25rem rgba(52, 152, 219, 0.25);
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
            padding: 10px 20px;
        }
        
        .btn-primary:hover {
            background-color: var(--secondary-color);
            border-color: var(--secondary-color);
        }
        
        .btn-success {
            background-color: var(--accent-color);
            border-color: var(--accent-color);
        }
        
        .btn-danger {
            background-color: var(--danger-color);
            border-color: var(--danger-color);
        }
        
        .patient-header {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08);
            margin-bottom: 20px;
        }
        
        .section-title {
            color: var(--dark-gray);
            font-weight: 600;
            margin-bottom: 15px;
            font-size: 1.1rem;
        }
        
        .dynamic-item {
            background-color: var(--light-gray);
            border-radius: 6px;
            padding: 15px;
            margin-bottom: 15px;
            position: relative;
        }
        
        .remove-btn {
            position: absolute;
            top: 10px;
            right: 10px;
        }
        
        .tab-content {
            background-color: white;
            border-radius: 0 0 8px 8px;
            padding: 20px;
            border-left: 1px solid #dee2e6;
            border-right: 1px solid #dee2e6;
            border-bottom: 1px solid #dee2e6;
        }

        
        
        @media (max-width: 768px) {
            .nav-tabs .nav-link {
                padding: 10px 15px;
                font-size: 0.9rem;
            }
        }
    </style>
</head>
<body>
    <div class="container py-4">
        <div class="patient-header">
            <h1 class="h3 mb-0">Clinic Visit Entry</h1>
            <h2 class="h4 text-muted mt-2">Patient: <?php echo htmlspecialchars($patient['last_name']) . ', ' . htmlspecialchars($patient['first_name']); ?></h2>
            
            <?php if (isset($error)): ?>
                <div class="alert alert-danger mt-3"><?php echo htmlspecialchars($error); ?></div>
            <?php endif; ?>
        </div>
        
        <form method="post" action="clinic_visit.php?patient_id=<?php echo $patient_id; ?>" enctype="multipart/form-data">
            <ul class="nav nav-tabs" id="visitTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="info-tab" data-bs-toggle="tab" data-bs-target="#info" type="button" role="tab">Visit Information</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="readings-tab" data-bs-toggle="tab" data-bs-target="#readings" type="button" role="tab">Clinical Readings</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="lab-tab" data-bs-toggle="tab" data-bs-target="#lab" type="button" role="tab">Lab Requests</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="meds-tab" data-bs-toggle="tab" data-bs-target="#meds" type="button" role="tab">Medications</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="docs-tab" data-bs-toggle="tab" data-bs-target="#docs" type="button" role="tab">Documents</button>
                </li>
            </ul>
            
            <div class="tab-content" id="visitTabsContent">
                <!-- Visit Information Tab -->
                <div class="tab-pane fade show active" id="info" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="visit_date" class="form-label">Visit Date</label>
                                <input type="date" class="form-control" id="visit_date" name="visit_date" required value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="case_number" class="form-label">Case Number</label>
                                <input type="text" class="form-control" id="case_number" name="case_number" value="<?php echo htmlspecialchars($case_number); ?>" readonly>
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="review_of_systems" class="form-label" style="font-weight: bold;"  >Subjective</label>
                        <textarea class="form-control" id="review_of_systems" name="review_of_systems" rows="3"></textarea>
                    </div>

                     <div class="mb-3">
                        <label for="review_of_systems" class="form-label" style="font-weight: bold;" >Objective</label>
                        <textarea class="form-control" id="objective" name="objective" rows="3"></textarea>
                    </div>

                     <div class="mb-3">
                        <label for="review_of_systems" class="form-label" style="font-weight: bold;" >Assessment</label>
                        <textarea class="form-control" id="assessment" name="assessment" rows="3"></textarea>
                    </div>

                     <div class="mb-3">
                        <label for="review_of_systems" class="form-label" style="font-weight: bold;" >Plans</label>
                        <textarea class="form-control" id="plans" name="plans" rows="3"></textarea>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="next_visit" class="form-label">Next Visit</label>
                                <input type="date" class="form-control" id="next_visit" name="next_visit">
                            </div>
                        </div>
                        <div class="col-md-6" style="display: none;">
                            <div class="mb-3">
                                <label for="professional_fee" class="form-label">Professional Fee</label>
                                <input type="number" step="0.01" class="form-control" id="professional_fee" name="professional_fee" value="0.00">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes" class="form-label">Notes</label>
                        <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                    </div>
                </div>
                
                <!-- Clinical Readings Tab -->
                <div class="tab-pane fade" id="readings" role="tabpanel">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="bp" class="form-label">Blood Pressure</label>
                                <input type="text" class="form-control" id="bp" name="bp" placeholder="e.g., 120/80">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="heart_rate" class="form-label">Heart Rate</label>
                                <input type="number" class="form-control" id="heart_rate" name="heart_rate" placeholder="bpm">
                            </div>
                        </div>
                        <div class="col-md-4" style="display: none;">
                            <div class="mb-3">
                                <label for="c8g" class="form-label">C8G</label>
                                <input type="text" class="form-control" id="c8g" name="c8g">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="weight_kg" class="form-label">Weight (kg)</label>
                                <input type="number" step="0.1" class="form-control" id="weight_kg" name="weight_kg">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="height_cm" class="form-label">Height (cm)</label>
                                <input type="number" step="0.1" class="form-control" id="height_cm" name="height_cm">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="bmi" class="form-label">BMI</label>
                                <input type="number" step="0.1" class="form-control" id="bmi" name="bmi" readonly>
                            </div>
                        </div>
                        <div class="col-md-3" style="display: none;">
                            <div class="mb-3">
                                <label for="hba1c" class="form-label">HbA1c</label>
                                <input type="number" step="0.1" class="form-control" id="hba1c" name="hba1c">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row"  style="display: none;">
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="waist_cm" class="form-label">Waist (cm)</label>
                                <input type="number" step="0.1" class="form-control" id="waist_cm" name="waist_cm">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="hip_cm" class="form-label">Hip (cm)</label>
                                <input type="number" step="0.1" class="form-control" id="hip_cm" name="hip_cm">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="mb-3">
                                <label for="whr" class="form-label">WHR</label>
                                <input type="number" step="0.01" class="form-control" id="whr" name="whr" readonly>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Lab Requests Tab -->
                <div class="tab-pane fade" id="lab" role="tabpanel">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="request_date" class="form-label">Request Date</label>
                                <input type="date" class="form-control" id="request_date" name="request_date" value="<?php echo date('Y-m-d'); ?>">
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="tests_requested" class="form-label">Tests Requested</label>
                        <textarea class="form-control" id="tests_requested" name="tests_requested" rows="3" placeholder="e.g., FBS, BUN, CREA; Lipid profile; AST, ALT; HbA1c; etc."></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label for="lab_notes" class="form-label">Lab Notes</label>
                        <textarea class="form-control" id="lab_notes" name="lab_notes" rows="3"></textarea>
                    </div>
                </div>
                
                <!-- Medications Tab -->
                <div class="tab-pane fade" id="meds" role="tabpanel">
                    <div id="medications-container">
                        <div class="dynamic-item">
                            <button type="button" class="btn btn-danger btn-sm remove-btn" onclick="this.parentNode.remove()">×</button>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Medication Name</label>
                                        <input type="text" class="form-control" name="medications[0][name]" placeholder="e.g., Levothyroxine 100 ug">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Dosage</label>
                                        <input type="text" class="form-control" name="medications[0][dosage]" placeholder="e.g., 2 tabs">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Frequency</label>
                                        <input type="text" class="form-control" name="medications[0][frequency]" placeholder="e.g., once daily">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Instructions</label>
                                <textarea class="form-control" name="medications[0][instructions]" rows="2" placeholder="e.g., taken at least 30min prebreakfast with water"></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary mt-2" onclick="addMedication()">+ Add Medication</button>
                <button type="button" class="btn btn-secondary mt-2" onclick="handlePrintFromForm()">🖨️ Print Prescription</button>

                </div>
                
                <!-- Documents Tab -->
                <div class="tab-pane fade" id="docs" role="tabpanel">
                    <div id="documents-container">
                        <div class="dynamic-item">
                            <button type="button" class="btn btn-danger btn-sm remove-btn" onclick="this.parentNode.remove()">×</button>
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Document Type</label>
                                        <input type="text" class="form-control" name="document_types[]" placeholder="e.g., Prescription, Lab Result">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label class="form-label">Document</label>
                                        <input type="file" class="form-control" name="documents[]">
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label">Notes</label>
                                <textarea class="form-control" name="document_notes[]" rows="2"></textarea>
                            </div>
                        </div>
                    </div>
                    <button type="button" class="btn btn-primary mt-2" onclick="addDocument()">+ Add Document</button>
                </div>
            </div>
            
            <div class="d-flex justify-content-between mt-4">
                <a href="patient_visits.php?patient_id=<?php echo $patient_id; ?>" class="btn btn-outline-secondary">Cancel</a>
                <button type="submit" class="btn btn-success">Save Visit</button>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script src="prescription-printer.js"></script>
    <script>
        let medCounter = 1;
        let docCounter = 1;
        
        function addMedication() {
            const container = document.getElementById('medications-container');
            const newMed = document.createElement('div');
            newMed.className = 'dynamic-item';
            newMed.innerHTML = `
                <button type="button" class="btn btn-danger btn-sm remove-btn" onclick="this.parentNode.remove()">×</button>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Medication Name</label>
                            <input type="text" class="form-control" name="medications[${medCounter}][name]" placeholder="e.g., Levothyroxine 100 ug">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Dosage</label>
                            <input type="text" class="form-control" name="medications[${medCounter}][dosage]" placeholder="e.g., 2 tabs">
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Frequency</label>
                            <input type="text" class="form-control" name="medications[${medCounter}][frequency]" placeholder="e.g., once daily">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Instructions</label>
                    <textarea class="form-control" name="medications[${medCounter}][instructions]" rows="2" placeholder="e.g., taken at least 30min prebreakfast with water"></textarea>
                </div>
            `;
            container.appendChild(newMed);
            medCounter++;
        }
        
        function addDocument() {
            const container = document.getElementById('documents-container');
            const newDoc = document.createElement('div');
            newDoc.className = 'dynamic-item';
            newDoc.innerHTML = `
                <button type="button" class="btn btn-danger btn-sm remove-btn" onclick="this.parentNode.remove()">×</button>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Document Type</label>
                            <input type="text" class="form-control" name="document_types[]" placeholder="e.g., Prescription, Lab Result">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label class="form-label">Document</label>
                            <input type="file" class="form-control" name="documents[]">
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">Notes</label>
                    <textarea class="form-control" name="document_notes[]" rows="2"></textarea>
                </div>
            `;
            container.appendChild(newDoc);
            docCounter++;
        }
        
        // Auto-calculate BMI when weight or height changes
        document.getElementById('weight_kg').addEventListener('change', calculateBMI);
        document.getElementById('height_cm').addEventListener('change', calculateBMI);
        
        function calculateBMI() {
            const weight = parseFloat(document.getElementById('weight_kg').value);
            const height = parseFloat(document.getElementById('height_cm').value);
            
            if (weight && height) {
                const bmi = weight / Math.pow(height/100, 2);
                document.getElementById('bmi').value = bmi.toFixed(1);
                
                // Auto-calculate WHR if waist is entered
                const waist = parseFloat(document.getElementById('waist_cm').value);
                const hip = parseFloat(document.getElementById('hip_cm').value);
                
                if (waist && hip) {
                    document.getElementById('whr').value = (waist/hip).toFixed(2);
                }
            }
        }
        
        // Auto-calculate WHR when waist or hip changes
        document.getElementById('waist_cm').addEventListener('change', calculateWHR);
        document.getElementById('hip_cm').addEventListener('change', calculateWHR);
        
        function calculateWHR() {
            const waist = parseFloat(document.getElementById('waist_cm').value);
            const hip = parseFloat(document.getElementById('hip_cm').value);
            
            if (waist && hip) {
                document.getElementById('whr').value = (waist/hip).toFixed(2);
            }
        }


// NEW HELPER FUNCTION FOR THIS PAGE
         function handlePrintFromForm() {
            const patientName = document.querySelector('.patient-header h2').textContent.replace('Patient: ', '').trim();
            const visitDate = new Date(document.getElementById('visit_date').value).toLocaleDateString('en-US', {
                year: 'numeric', month: 'long', day: 'numeric'
            });
            
            const medicationNodes = document.querySelectorAll('#medications-container .dynamic-item');
            const medicationsData = [];
            
            medicationNodes.forEach(item => {
                medicationsData.push({
                    name: item.querySelector('input[name*="[name]"]').value,
                    dosage: item.querySelector('input[name*="[dosage]"]').value,
                    frequency: item.querySelector('input[name*="[frequency]"]').value,
                    instructions: item.querySelector('textarea[name*="[instructions]"]').value
                });
            });
            
            // Call the function from the external file
            printPrescription(patientName, visitDate, medicationsData);
        }
        
    </script>
</body>
</html>