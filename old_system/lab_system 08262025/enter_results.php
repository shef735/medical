<?php
include 'auth.php';
//include 'templates.php';
include 'results.php';
include 'patients.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$patient_id = isset($_GET['patient_id']) ? (int)$_GET['patient_id'] : 0;
$patient = $patient_id ? getPatient($patient_id) : null;

$template_id = isset($_GET['template_id']) ? (int)$_GET['template_id'] : 0;
$template = $template_id ? getTemplateById($template_id) : null;
$fields = $template_id ? getTemplateFields($template_id) : array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the selected patient ID from the form
    $patient_id = (int)$_POST['patient_id'];
    $patient = getPatient($patient_id);
    
    if (!$patient) {
        die("Invalid patient selected");
    }

    // Prepare field values
    $field_values = array();
    foreach ($_POST['field'] as $field_id => $value) {
        $field_values[$field_id] = $value;
    }
    
    // Save test results
    $result_id = saveTestResults($template_id, $patient_id, $field_values);
    
    if ($result_id) {
        header("Location: view_result.php?id=$result_id");
        exit;
    } else {
        $error = "Error saving test results";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Enter Test Results</title>
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        :root {
            --primary-color: #4361ee;
            --primary-hover: #3a56d4;
            --secondary-color: #3f37c9;
            --success-color: #4cc9f0;
            --text-color: #2b2d42;
            --light-gray: #f8f9fa;
            --medium-gray: #e9ecef;
            --dark-gray: #adb5bd;
            --border-radius: 8px;
            --box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --transition: all 0.3s ease;
        }
        
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--text-color);
            background-color: var(--light-gray);
            padding: 0;
            margin: 0;
        }
        
        .container {
            max-width: 900px;
            margin: 2rem auto;
            padding: 0 1rem;
        }
        
        .card {
            background-color: white;
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
            padding: 2rem;
            margin-bottom: 2rem;
        }
        
        h2 {
            color: var(--primary-color);
            margin-bottom: 1.5rem;
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        h2:before {
            content: "";
            display: inline-block;
            width: 5px;
            height: 24px;
            background-color: var(--primary-color);
            border-radius: 3px;
        }
        
        h3.section-title {
            color: var(--secondary-color);
            margin: 2rem 0 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--medium-gray);
            font-weight: 500;
        }
        
        .form-group {
            margin-bottom: 1.5rem;
        }
        
        label {
            display: block;
            margin-bottom: 0.5rem;
            font-weight: 500;
            color: var(--text-color);
        }
        
        .input-wrapper {
            position: relative;
        }
        
        input, select, textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--medium-gray);
            border-radius: var(--border-radius);
            font-family: inherit;
            font-size: 1rem;
            transition: var(--transition);
            background-color: white;
        }
        
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }
        
        input[type="number"] {
            padding-right: 3rem;
        }
        
        .normal-range {
            display: block;
            font-size: 0.85rem;
            color: var(--dark-gray);
            margin-top: 0.25rem;
            font-weight: normal;
        }
        
        .normal-range:before {
            content: "ⓘ ";
        }
        
        button {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.75rem 1.5rem;
            background-color: var(--primary-color);
            color: white;
            border: none;
            border-radius: var(--border-radius);
            font-size: 1rem;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
        }
        
        button:hover {
            background-color: var(--primary-hover);
            transform: translateY(-1px);
        }
        
        button:active {
            transform: translateY(0);
        }
        
        .error {
            color: #e63946;
            background-color: rgba(230, 57, 70, 0.1);
            padding: 1rem;
            border-radius: var(--border-radius);
            margin-bottom: 1.5rem;
            border-left: 4px solid #e63946;
        }
        
        .error:before {
            content: "⚠ ";
        }
        
        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 1.5rem;
        }
        
        /* Select2 customization */
        .select2-container--default .select2-selection--single {
            height: auto;
            padding: 0.6rem 1rem;
            border: 1px solid var(--medium-gray);
            border-radius: var(--border-radius);
        }
        
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 100%;
            right: 8px;
        }
        
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            padding: 0;
            line-height: 1.5;
        }
        
        .select2-container--default.select2-container--focus .select2-selection--single {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.1);
        }
        
        .select2-dropdown {
            border: 1px solid var(--medium-gray);
            border-radius: var(--border-radius);
            box-shadow: var(--box-shadow);
        }
        
        .select2-results__option--highlighted {
            background-color: var(--primary-color) !important;
        }
        
        @media (max-width: 768px) {
            .container {
                padding: 0 1rem;
            }
            
            .card {
                padding: 1.5rem;
            }
            
            .form-grid {
                grid-template-columns: 1fr;
            }
        }

          .btn {
            padding: 8px 15px;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            font-size: 14px;
            display: inline-block;
        }
        .btn-add {
            background: #2ecc71;
        }
        .btn-add:hover {
            background: #27ae60;
        }
    </style>
</head>
<body>
    <div class="container">
    
        <div class="card">
            <a style="float: right;" href="template-list.php" class="btn btn-add">BACK TO LIST</a>

            <h2>Enter Test Results: <?php echo $template ? htmlspecialchars($template['template_name']) : 'Select Template'; ?></h2>
            
            <?php if (isset($error)): ?>
                <div class="error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <form method="post">
                <div class="form-group">
                    <label for="patient_id">Patient</label>
                    <select name="patient_id" id="patient_id" class="js-select2" required>
                        <option value="">Select Patient</option>
                        <?php foreach (getAllPatients() as $p): ?>
                            <option value="<?php echo $p['patient_id']; ?>" 
                                <?php echo $patient && $patient['patient_id'] == $p['patient_id'] ? 'selected' : ''; ?>>
                                <?php echo htmlspecialchars($p['patient_code'] . ' - ' . $p['first_name'] . ' ' . $p['last_name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                
                <?php if ($template): ?>
                    <h3 class="section-title">Test Results</h3>
                    
                    <div class="form-grid">
                        <?php foreach ($fields as $field): ?>
                            <div class="form-group">
                                <label for="field_<?php echo $field['field_id']; ?>">
                                    <?php echo htmlspecialchars($field['field_name']); ?>
                                    <?php if (!empty($field['normal_range'])): ?>
                                        <span class="normal-range">Normal range: <?php echo htmlspecialchars($field['normal_range']); ?></span>
                                    <?php endif; ?>
                                </label>
                                
                                <div class="input-wrapper">
                                    <?php if ($field['field_type'] === 'text'): ?>
                                        <input type="text" 
                                               id="field_<?php echo $field['field_id']; ?>" 
                                               name="field[<?php echo $field['field_id']; ?>]" 
                                               required>
                                    <?php elseif ($field['field_type'] === 'number'): ?>
                                        <input type="number" 
                                               id="field_<?php echo $field['field_id']; ?>" 
                                               name="field[<?php echo $field['field_id']; ?>]" 
                                               step="<?php echo strpos($field['normal_range'] ?? '', '.') !== false ? '0.01' : '1'; ?>" 
                                               required>
                                    <?php elseif ($field['field_type'] === 'dropdown'): ?>
                                        <select id="field_<?php echo $field['field_id']; ?>" 
                                                name="field[<?php echo $field['field_id']; ?>]" 
                                                class="js-select2"
                                                required>
                                            <?php 
                                            $options = explode(',', $field['field_options']);
                                            foreach ($options as $option): ?>
                                                <option value="<?php echo htmlspecialchars(trim($option)); ?>">
                                                    <?php echo htmlspecialchars(trim($option)); ?>
                                                </option>
                                            <?php endforeach; ?>
                                        </select>
                                    <?php elseif ($field['field_type'] === 'textarea'): ?>
                                        <textarea id="field_<?php echo $field['field_id']; ?>" 
                                                  name="field[<?php echo $field['field_id']; ?>]" 
                                                  rows="3" 
                                                  required></textarea>
                                    <?php endif; ?>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    
                    <div class="form-group" style="margin-top: 2rem;">
                        <button type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" style="margin-right: 0.5rem;">
                                <path d="M2 1a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H9.5a1 1 0 0 0-1 1v7.293l2.646-2.647a.5.5 0 0 1 .708.708l-3.5 3.5a.5.5 0 0 1-.708 0l-3.5-3.5a.5.5 0 1 1 .708-.708L7.5 9.293V2a2 2 0 0 1 2-2H14a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2h2.5a.5.5 0 0 1 0 1H2z"/>
                            </svg>
                            Save Results
                        </button>


                    </div>
                <?php else: ?>
                    <div class="form-group">
                        <p>Please select a test template first.</p>
                    </div>
                <?php endif; ?>
            </form>
        </div>
    </div>

    <!-- jQuery (required for Select2) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            // Initialize Select2 for all select elements with class js-select2
            $('.js-select2').select2({
                width: '100%',
                placeholder: function() {
                    return $(this).data('placeholder') || 'Select an option';
                },
                allowClear: Boolean($(this).data('allow-clear')),
                minimumResultsForSearch: 5 // Show search only if more than 5 options
            });
            
            // Style Select2 dropdown to match our theme
            $('.select2-container--default .select2-selection--single').css({
                'height': 'auto',
                'padding': '0.6rem 1rem'
            });
        });
    </script>
</body>
</html>