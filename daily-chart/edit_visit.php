<?php
// --- PHP Backend Logic (Same as before, with security enhancements) ---
include 'config.php';

// Validate visit_id parameter
if (!isset($_GET['visit_id']) || !is_numeric($_GET['visit_id'])) {
    header("Location: index.php");
    exit;
}
$visit_id = intval($_GET['visit_id']);

// --- Fetching Functions (using Prepared Statements) ---
function fetchRow($conn, $sql, $params = [], $types = "") {
    $stmt = mysqli_prepare($conn, $sql);
    if ($params) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function fetchAll($conn, $sql, $params = [], $types = "") {
    $stmt = mysqli_prepare($conn, $sql);
    if ($params) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_all($result, MYSQLI_ASSOC);
}

// Fetch existing data
$visit = fetchRow($conn, "SELECT cv.*, pi.first_name, pi.last_name, pi.user_id FROM clinic_visits cv JOIN patient_info pi ON cv.patient_id = pi.id WHERE cv.id = ?", [$visit_id], "i");
if (!$visit) {
    header("Location: index.php");
    exit;
}
$readings = fetchRow($conn, "SELECT * FROM clinical_readings WHERE visit_id = ?", [$visit_id], "i");
$lab = fetchRow($conn, "SELECT * FROM lab_requests WHERE visit_id = ?", [$visit_id], "i");
$medications = fetchAll($conn, "SELECT * FROM medications WHERE visit_id = ? ORDER BY id", [$visit_id], "i");
$documents = fetchAll($conn, "SELECT * FROM visit_documents WHERE visit_id = ? ORDER BY id", [$visit_id], "i");
$user_id = $visit['user_id'];

// --- Handle Form Submission (Same secure logic) ---
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $conn->begin_transaction();
    try {
        // Update clinic_visits table
        $stmt = $conn->prepare("UPDATE clinic_visits SET user_id=?, visit_date=?, case_number=?, review_of_systems=?, objective=?, assessment=?, plans=?, next_visit=?, notes=?, professional_fee=? WHERE id=?");
        $stmt->bind_param("ssssssssdii", $user_id, $_POST['visit_date'], $_POST['case_number'], $_POST['review_of_systems'], $_POST['objective'], $_POST['assessment'], $_POST['plans'], $_POST['next_visit'], $_POST['notes'], $_POST['professional_fee'], $visit_id);
        $stmt->execute();

        // Update or Insert clinical_readings
        if ($readings) {
            $stmt = $conn->prepare("UPDATE clinical_readings SET user_id=?, bp=?, heart_rate=?, weight_kg=?, height_cm=?, bmi=?, waist_cm=?, hip_cm=?, whr=?, hba1c=? WHERE visit_id=?");
            $stmt->bind_param("ssddddddddi", $user_id, $_POST['bp'], $_POST['heart_rate'], $_POST['weight_kg'], $_POST['height_cm'], $_POST['bmi'], $_POST['waist_cm'], $_POST['hip_cm'], $_POST['whr'], $_POST['hba1c'], $visit_id);
        } else {
            $stmt = $conn->prepare("INSERT INTO clinical_readings (user_id, visit_id, bp, heart_rate, weight_kg, height_cm, bmi, waist_cm, hip_cm, whr, hba1c) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sisdddddddd", $user_id, $visit_id, $_POST['bp'], $_POST['heart_rate'], $_POST['weight_kg'], $_POST['height_cm'], $_POST['bmi'], $_POST['waist_cm'], $_POST['hip_cm'], $_POST['whr'], $_POST['hba1c']);
        }
        $stmt->execute();

        // Update or Insert lab_requests
        if ($lab) {
            $stmt = $conn->prepare("UPDATE lab_requests SET user_id=?, request_date=?, tests_requested=?, lab_notes=? WHERE visit_id=?");
            $stmt->bind_param("ssssi", $user_id, $_POST['request_date'], $_POST['tests_requested'], $_POST['lab_notes'], $visit_id);
        } else {
            $stmt = $conn->prepare("INSERT INTO lab_requests (user_id, visit_id, request_date, tests_requested, lab_notes) VALUES (?, ?, ?, ?, ?)");
            $stmt->bind_param("sisss", $user_id, $visit_id, $_POST['request_date'], $_POST['tests_requested'], $_POST['lab_notes']);
        }
        $stmt->execute();

        // Update medications (Delete all then re-insert)
        $stmt = $conn->prepare("DELETE FROM medications WHERE visit_id = ?");
        $stmt->bind_param("i", $visit_id);
        $stmt->execute();

        if (!empty($_POST['medications'])) {
            $stmt = $conn->prepare("INSERT INTO medications (user_id, visit_id, medication_name, dosage, frequency, instructions) VALUES (?, ?, ?, ?, ?, ?)");
            foreach ($_POST['medications'] as $med) {
                if (!empty($med['name'])) {
                    $stmt->bind_param("sissss", $user_id, $visit_id, $med['name'], $med['dosage'], $med['frequency'], $med['instructions']);
                    $stmt->execute();
                }
            }
        }
        
        // Handle file uploads
        if (!empty($_FILES['documents']['name'][0])) {
            $stmt = $conn->prepare("INSERT INTO visit_documents (user_id, visit_id, document_type, document_name, file_path, notes) VALUES (?, ?, ?, ?, ?, ?)");
            foreach ($_FILES['documents']['name'] as $key => $name) {
                if ($_FILES['documents']['error'][$key] == 0) {
                    $target_dir = "../../uploads/documents/";
                    $file_name = time() . '_' . basename($name);
                    $target_file = $target_dir . $file_name;
                    if (move_uploaded_file($_FILES["documents"]["tmp_name"][$key], $target_file)) {
                        $stmt->bind_param("sissss", $user_id, $visit_id, $_POST['document_types'][$key], $name, $target_file, $_POST['document_notes'][$key]);
                        $stmt->execute();
                    }
                }
            }
        }
        
        $conn->commit();
        header("Location: view_visit.php?visit_id=$visit_id&message=Visit updated successfully");
        exit;

    } catch (mysqli_sql_exception $exception) {
        $conn->rollback();
        $error = "Error updating record: " . $exception->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Visit - <?php echo htmlspecialchars($visit['case_number']); ?></title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --bg-color: #f7fafc;
            --primary-color: #2c5282; /* A deep blue */
            --accent-color: #4299e1; /* A brighter blue */
            --text-color: #2d3748;
            --border-color: #e2e8f0;
            --card-bg: #ffffff;
            --danger-color: #e53e3e;
            --shadow: 0 4px 6px -1px rgba(0,0,0,0.1), 0 2px 4px -1px rgba(0,0,0,0.06);
            --radius: 8px;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            background-color: var(--bg-color);
            color: var(--text-color);
            margin: 0;
        }

        .container {
            max-width: 900px;
            margin: 30px auto;
            padding: 20px;
        }
        
        .page-header h1 { margin: 0; font-size: 2rem; color: var(--primary-color); }
        .page-header p { margin: 5px 0 30px 0; font-size: 1.1rem; color: #718096; }

        .accordion-item {
            background-color: var(--card-bg);
            border: 1px solid var(--border-color);
            border-radius: var(--radius);
            margin-bottom: 15px;
            box-shadow: var(--shadow);
            transition: margin-bottom 0.3s ease;
        }

        .accordion-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 18px 20px;
            cursor: pointer;
            user-select: none;
            border-radius: var(--radius);
        }
        .accordion-header h3 { margin: 0; font-size: 1.2rem; display: flex; align-items: center; gap: 10px; }
        .accordion-header .icon {
            font-size: 1.2rem;
            color: #a0aec0;
            transition: transform 0.3s ease;
        }

        .accordion-content {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease, padding 0.3s ease;
        }

        .accordion-content-inner { padding: 0 20px 20px 20px; }

        .accordion-item.active { margin-bottom: 25px; }
        .accordion-item.active .accordion-header {
            border-bottom: 1px solid var(--border-color);
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }
        .accordion-item.active .accordion-header .icon {
            transform: rotate(180deg);
            color: var(--accent-color);
        }

        /* Form styling */
        .form-group { margin-bottom: 20px; }
        label { display: block; font-weight: 600; margin-bottom: 6px; font-size: 0.9rem; }
        input[type="text"], input[type="date"], input[type="number"], input[type="file"], textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid var(--border-color);
            border-radius: 6px;
            font-size: 1rem;
        }
        input:focus, textarea:focus {
            outline: 2px solid var(--accent-color);
            border-color: var(--accent-color);
        }
        textarea { min-height: 100px; }
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
        }
        
        /* Dynamic Items */
        .dynamic-item {
            background: var(--bg-color);
            padding: 20px;
            border-radius: var(--radius);
            margin-bottom: 15px;
            border: 1px solid var(--border-color);
            position: relative;
        }
        .add-btn {
            background: #edf2f7; color: var(--text-color);
            border: 1px solid var(--border-color);
            width: 100%; padding: 10px; border-radius: 6px;
            cursor: pointer; font-weight: 600;
        }
        .remove-btn {
            position: absolute; top: 10px; right: 10px;
            background: transparent; border: none; color: #a0aec0;
            font-size: 1.2rem; cursor: pointer;
        }
        .existing-doc { font-size: 0.9rem; padding-left: 0; padding-right: 0;}
        .existing-doc a { color: var(--accent-color); text-decoration: none; font-weight: 600;}
        .existing-doc a.delete { color: var(--danger-color); }
        
        /* Actions */
        .form-actions {
            margin-top: 30px; padding: 20px;
            background: var(--card-bg); border-radius: var(--radius);
            box-shadow: var(--shadow); display: flex;
            justify-content: flex-end; gap: 15px;
        }
        .btn {
            padding: 12px 25px; border: none; border-radius: 6px;
            font-weight: 600; font-size: 1rem; cursor: pointer;
            text-decoration: none;
        }
        .btn-primary { background: var(--accent-color); color: white; }
        .btn-secondary { background: #e2e8f0; color: var(--text-color); }
    </style>
</head>
<body>
    <div class="container">
        <div class="page-header" style="margin-left: 20px;">
            <h1>Edit Clinic Visit</h1>
            <p>Patient: <?php echo htmlspecialchars($visit['last_name'] . ', ' . $visit['first_name']); ?></p>
        </div>
        

        <form method="post" enctype="multipart/form-data"  >

        <div class="form-actions">
                <a href="view_visit.php?visit_id=<?php echo $visit_id; ?>" class="btn btn-secondary">Cancel</a>
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
            </br>
            <div id="form-accordion">
                <div class="accordion-item active">
                    <div class="accordion-header"><h3><i class="fa-solid fa-calendar-day"></i> Visit Information</h3> <i class="fa-solid fa-chevron-down icon"></i></div>
                    <div class="accordion-content">
                        <div class="accordion-content-inner">
                         </br>
                             <div class="form-grid">
                            
                                <div class="form-group"><label for="visit_date">Visit Date</label><input type="date" id="visit_date" name="visit_date" required value="<?php echo htmlspecialchars($visit['visit_date']); ?>"></div>
                                <div class="form-group"><label for="case_number">Case Number</label><input readonly type="text" id="case_number" name="case_number" value="<?php echo htmlspecialchars($visit['case_number']); ?>"></div>
                                <div class="form-group"><label for="next_visit">Next Visit</label><input type="date" id="next_visit" name="next_visit" value="<?php echo htmlspecialchars($visit['next_visit']); ?>"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <div class="accordion-header"><h3><i class="fa-solid fa-heart-pulse"></i> Clinical Readings</h3> <i class="fa-solid fa-chevron-down icon"></i></div>
                    <div class="accordion-content">
                        <div class="accordion-content-inner">
                        </br>
                            <div class="form-grid">
                                <div class="form-group"><label for="bp">Blood Pressure</label><input type="text" id="bp" name="bp" value="<?php echo htmlspecialchars($readings['bp'] ?? ''); ?>"></div>
                                <div class="form-group"><label for="heart_rate">Heart Rate (bpm)</label><input type="number" id="heart_rate" name="heart_rate" value="<?php echo htmlspecialchars($readings['heart_rate'] ?? ''); ?>"></div>
                                <div class="form-group"><label for="weight_kg">Weight (kg)</label><input type="number" step="0.1" id="weight_kg" name="weight_kg" value="<?php echo htmlspecialchars($readings['weight_kg'] ?? ''); ?>"></div>
                                <div class="form-group"><label for="height_cm">Height (cm)</label><input type="number" step="0.1" id="height_cm" name="height_cm" value="<?php echo htmlspecialchars($readings['height_cm'] ?? ''); ?>"></div>
                                <div class="form-group"><label for="bmi">BMI</label><input type="text" id="bmi" name="bmi" readonly value="<?php echo htmlspecialchars($readings['bmi'] ?? ''); ?>"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <div class="accordion-header"><h3><i class="fa-solid fa-notes-medical"></i> SOAP Notes</h3> <i class="fa-solid fa-chevron-down icon"></i></div>
                    <div class="accordion-content">
                        <div class="accordion-content-inner">
                        </br>
                            <div class="form-group"><label for="review_of_systems">Subjective</label><textarea id="review_of_systems" name="review_of_systems"><?php echo htmlspecialchars($visit['review_of_systems']); ?></textarea></div>
                            <div class="form-group"><label for="objective">Objective</label><textarea id="objective" name="objective"><?php echo htmlspecialchars($visit['objective']); ?></textarea></div>
                            <div class="form-group"><label for="assessment">Assessment</label><textarea id="assessment" name="assessment"><?php echo htmlspecialchars($visit['assessment']); ?></textarea></div>
                            <div class="form-group"><label for="plans">Plans</label><textarea id="plans" name="plans"><?php echo htmlspecialchars($visit['plans']); ?></textarea></div>
                        </div>
                    </div>
                </div>

                <div class="accordion-item">
                    <div class="accordion-header"><h3><i class="fa-solid fa-pills"></i> Medications</h3> <i class="fa-solid fa-chevron-down icon"></i></div>
                    <div class="accordion-content">
                        <div class="accordion-content-inner">
                            <div id="medications-container">
                                <?php foreach ($medications as $index => $med): ?>
                                <div class="dynamic-item">
                                    <button type="button" class="remove-btn" onclick="this.parentNode.remove()">×</button>
                                    <div class="form-grid">
                                        <div class="form-group"><label>Medication Name</label><input type="text" name="medications[<?php echo $index; ?>][name]" value="<?php echo htmlspecialchars($med['medication_name']); ?>"></div>
                                        <div class="form-group"><label>Dosage</label><input type="text" name="medications[<?php echo $index; ?>][dosage]" value="<?php echo htmlspecialchars($med['dosage']); ?>"></div>
                                        <div class="form-group"><label>Frequency</label><input type="text" name="medications[<?php echo $index; ?>][frequency]" value="<?php echo htmlspecialchars($med['frequency']); ?>"></div>
                                    </div>
                                    <div class="form-group" style="margin-bottom:0;"><label>Instructions</label><textarea name="medications[<?php echo $index; ?>][instructions]"><?php echo htmlspecialchars($med['instructions']); ?></textarea></div>
                                </div>
                                <?php endforeach; ?>
                            </div>
                            <button type="button" class="add-btn" onclick="addMedication()"><i class="fa-solid fa-plus"></i> Add Medication</button>
                        </div>
                    </div>
                </div>
                
                <div class="accordion-item">
                    <div class="accordion-header"><h3><i class="fa-solid fa-file-lines"></i> Documents</h3> <i class="fa-solid fa-chevron-down icon"></i></div>
                    <div class="accordion-content">
                         <div class="accordion-content-inner">
                            <?php if (!empty($documents)): ?>
                                <label style="margin-bottom: 15px;">Existing Documents</label>
                                <?php foreach ($documents as $doc): ?>
                                <div class="dynamic-item existing-doc">
                                    <strong><?php echo htmlspecialchars($doc['document_name']); ?></strong> (<?php echo htmlspecialchars($doc['document_type']); ?>)<br>
                                    <a href="<?php echo htmlspecialchars($doc['file_path']); ?>" target="_blank">View</a> | 
                                    <a href="delete_document.php?doc_id=<?php echo $doc['id']; ?>&visit_id=<?php echo $visit_id; ?>" class="delete" onclick="return confirm('Are you sure?')">Delete</a>
                                </div>
                                <?php endforeach; ?>
                            <?php endif; ?>
                            <hr style="border:none; border-top: 1px solid var(--border-color); margin: 25px 0;">
                            <label style="margin-bottom: 15px;">Add New Documents</label>
                            <div id="documents-container"></div>
                            <button type="button" class="add-btn" onclick="addDocument()"><i class="fa-solid fa-plus"></i> Add Document</button>
                        </div>
                    </div>
                </div>

            </div>
            
             <input type="hidden" name="professional_fee" value="<?php echo htmlspecialchars($visit['professional_fee'] ?? '0'); ?>">
            <input type="hidden" name="waist_cm" value="<?php echo htmlspecialchars($readings['waist_cm'] ?? ''); ?>">
            <input type="hidden" name="hip_cm" value="<?php echo htmlspecialchars($readings['hip_cm'] ?? ''); ?>">
            <input type="hidden" name="whr" value="<?php echo htmlspecialchars($readings['whr'] ?? ''); ?>">
            <input type="hidden" name="hba1c" value="<?php echo htmlspecialchars($readings['hba1c'] ?? ''); ?>">
            <input type="hidden" name="request_date" value="<?php echo htmlspecialchars($lab['request_date'] ?? date('Y-m-d')); ?>">
            <input type="hidden" name="tests_requested" value="<?php echo htmlspecialchars($lab['tests_requested'] ?? ''); ?>">
            <input type="hidden" name="lab_notes" value="<?php echo htmlspecialchars($lab['lab_notes'] ?? ''); ?>">

            
        </form>
    </div>
    
    <script>
        // --- Accordion functionality ---
        const accordionItems = document.querySelectorAll('.accordion-item');
        accordionItems.forEach(item => {
            const header = item.querySelector('.accordion-header');
            const content = item.querySelector('.accordion-content');

            header.addEventListener('click', () => {
                const isActive = item.classList.contains('active');
                
                accordionItems.forEach(i => {
                    i.classList.remove('active');
                    i.querySelector('.accordion-content').style.maxHeight = '0px';
                });

                if (!isActive) {
                    item.classList.add('active');
                    content.style.maxHeight = content.scrollHeight + 'px';
                }
            });

            if(item.classList.contains('active')){
                 content.style.maxHeight = content.scrollHeight + 'px';
            }
        });

        // --- Dynamic fields and calculations ---
        let medCounter = <?php echo count($medications); ?>;
        
        function addMedication() {
            const container = document.getElementById('medications-container');
            const newMed = document.createElement('div');
            newMed.className = 'dynamic-item';
            newMed.innerHTML = `
                <button type="button" class="remove-btn" onclick="this.parentNode.remove()">×</button>
                <div class="form-grid">
                    <div class="form-group"><label>Medication Name</label><input type="text" name="medications[${medCounter}][name]"></div>
                    <div class="form-group"><label>Dosage</label><input type="text" name="medications[${medCounter}][dosage]"></div>
                    <div class="form-group"><label>Frequency</label><input type="text" name="medications[${medCounter}][frequency]"></div>
                </div>
                <div class="form-group" style="margin-bottom:0;"><label>Instructions</label><textarea name="medications[${medCounter}][instructions]"></textarea></div>
            `;
            container.appendChild(newMed);
            medCounter++;

            // --- FIX: Recalculate the accordion's height ---
            const accordionContent = container.closest('.accordion-content');
            accordionContent.style.maxHeight = accordionContent.scrollHeight + 'px';
        }
        
        function addDocument() {
            const container = document.getElementById('documents-container');
            const newDoc = document.createElement('div');
            newDoc.className = 'dynamic-item';
            newDoc.innerHTML = `
                <button type="button" class="remove-btn" onclick="this.parentNode.remove()">×</button>
                <div class="form-grid">
                    <div class="form-group"><label>Document Type</label><input type="text" name="document_types[]" placeholder="e.g., Prescription"></div>
                    <div class="form-group"><label>File</label><input type="file" name="documents[]"></div>
                </div>
                <div class="form-group" style="margin-bottom:0;"><label>Notes</label><textarea name="document_notes[]"></textarea></div>
            `;
            container.appendChild(newDoc);
            
            // --- FIX: Recalculate the accordion's height ---
            const accordionContent = container.closest('.accordion-content');
            accordionContent.style.maxHeight = accordionContent.scrollHeight + 'px';
        }

        // --- Auto-calculate BMI ---
        const weightInput = document.getElementById('weight_kg');
        const heightInput = document.getElementById('height_cm');
        const bmiInput = document.getElementById('bmi');
        
        function calculateBMI() {
            const weight = parseFloat(weightInput.value);
            const height = parseFloat(heightInput.value);
            if (weight > 0 && height > 0) {
                const bmi = weight / Math.pow(height / 100, 2);
                bmiInput.value = bmi.toFixed(1);
            } else {
                bmiInput.value = '';
            }
        }
        
        weightInput.addEventListener('input', calculateBMI);
        heightInput.addEventListener('input', calculateBMI);
    </script>
</body>
</html>