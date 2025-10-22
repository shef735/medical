<?php
include 'auth.php';
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
$fields = $template_id ? getTemplateFields($template_id) : [];

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $patient_id = (int)$_POST['patient_id'];
    $patient = getPatient($patient_id);
    
    if (!$patient) {
        $error = "An invalid patient was selected. Please try again.";
    } else {
        $test_date = $_POST['test_date'];
        $test_time = $_POST['test_time'];
        
        $field_values = [];
        if (isset($_POST['field'])) {
            foreach ($_POST['field'] as $field_id => $value) {
                $field_values[$field_id] = $value;
            }
        }
        
        $result_id = saveTestResults($template_id, $patient_id, $field_values, $test_date, $test_time);
        
        if ($result_id) {
            header("Location: view_result.php?id=$result_id");
            exit;
        } else {
            $error = "There was an error saving the test results.";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enter Test Results - <?php echo $template ? htmlspecialchars($template['template_name']) : 'Select Template'; ?></title>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        :root {
            --primary-color: #20c997; /* Teal for a clinical yet modern feel */
            --primary-hover: #1baa80;
            --secondary-color: #6c757d; /* Muted gray for secondary actions/text */
            --background-color: #f8f9fa; /* Light gray background */
            --surface-color: #ffffff; /* Card background */
            --border-color: #dee2e6;
            --text-color: #212529; /* Darker gray for primary text */
            --text-muted: #6c757d;
            --font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            --border-radius: 8px;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
        }

        *, *::before, *::after {
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-family);
            background-color: var(--background-color);
            color: var(--text-color);
            margin: 0;
            padding: 2rem;
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            margin: 0 auto;
        }

        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .page-title {
            font-size: 1.75rem;
            font-weight: 600;
            color: var(--text-color);
        }

        .card {
            background-color: var(--surface-color);
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            margin-bottom: 2rem;
        }
        
        .card-body {
            padding: 2rem;
        }

        .form-section + .form-section {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid var(--border-color);
        }
        
        .section-title {
            font-size: 1.2rem;
            font-weight: 500;
            color: var(--text-color);
            margin: 0 0 1.5rem 0;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 1.5rem;
        }
        
        .form-group {
            display: flex;
            flex-direction: column;
        }
        
        label {
            margin-bottom: 0.5rem;
            font-weight: 500;
            font-size: 0.9rem;
        }
        
        input, select, textarea {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            font-size: 1rem;
            background-color: #fff;
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(32, 201, 151, 0.15);
        }

        .normal-range {
            font-size: 0.8rem;
            color: var(--text-muted);
            margin-top: 0.5rem;
        }
        
        .form-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 2rem;
        }

        .btn {
            padding: 0.75rem 1.5rem;
            border-radius: var(--border-radius);
            text-decoration: none;
            font-size: 1rem;
            border: 1px solid transparent;
            cursor: pointer;
            font-weight: 500;
            transition: all 0.2s ease-in-out;
        }
        .btn-primary {
            background-color: var(--primary-color);
            color: white;
        }
        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 4px 8px rgba(32, 201, 151, 0.2);
        }
        .btn-secondary {
            background-color: transparent;
            border-color: var(--border-color);
            color: var(--text-color);
        }
        .btn-secondary:hover {
            background-color: var(--background-color);
            border-color: #c6cdd5;
        }
        
        .error-message {
            padding: 1rem;
            margin-bottom: 1.5rem;
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
            border-radius: var(--border-radius);
        }

        /* Select2 Customization */
        .select2-container .select2-selection--single {
            height: calc(1.5em + 1.5rem + 2px); /* Match input height */
            padding: 0.75rem 1rem;
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
        }
        .select2-container .select2-selection--single .select2-selection__rendered {
            padding-left: 0;
            padding-right: 0;
            line-height: 1.6;
        }
        .select2-container .select2-selection--single .select2-selection__arrow {
            height: calc(1.5em + 1.5rem);
        }
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 4px rgba(32, 201, 151, 0.15);
        }
        .select2-dropdown {
            border: 1px solid var(--border-color);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
        }
        .select2-results__option--highlighted[aria-selected] {
            background-color: var(--primary-color);
        }

        @media (max-width: 768px) {
            body { padding: 1rem; }
            .form-grid { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="container">
        <header class="page-header">
            <h1 class="page-title">Enter Test Results</h1>
            <a href="template-list.php" class="btn btn-secondary">Back to Templates</a>
        </header>

        <?php if ($error): ?>
            <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <div class="card">
            <form method="post" id="results-form">
                <div class="card-body">
                    <section class="form-section">
                        <h2 class="section-title">Test & Patient Details</h2>
                        <div class="form-grid">
                            <div class="form-group">
                                <label for="patient_id">Patient</label>
                                <select name="patient_id" id="patient_id" required>
                                    <option value="">Select a Patient...</option>
                                    <?php foreach (getAllPatients() as $p): ?>
                                        <option value="<?php echo $p['patient_id']; ?>" 
                                            <?php echo ($patient && $patient['patient_id'] == $p['patient_id']) ? 'selected' : ''; ?>>
                                            <?php echo htmlspecialchars($p['patient_code'] . ' - ' . $p['first_name'] . ' ' . $p['last_name']); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="test_date">Test Date</label>
                                <input type="date" id="test_date" name="test_date" value="<?php echo date('Y-m-d'); ?>" required>
                            </div>
                            <div class="form-group">
                                <label for="test_time">Test Time</label>
                                <input type="time" id="test_time" name="test_time" value="<?php echo date('H:i'); ?>" required>
                            </div>
                        </div>
                    </section>
                    
                    <?php if ($template): ?>
                        <section class="form-section">
                            <h2 class="section-title">
                                Results for: <?php echo htmlspecialchars($template['template_name']); ?>
                            </h2>
                            <div class="form-grid">
                                <?php foreach ($fields as $field): ?>
                                    <div class="form-group">
                                        <label for="field_<?php echo $field['field_id']; ?>">
                                            <?php echo htmlspecialchars($field['field_name']); ?>
                                        </label>
                                        
                                        <?php if ($field['field_type'] === 'text'): ?>
                                            <input type="text" id="field_<?php echo $field['field_id']; ?>" name="field[<?php echo $field['field_id']; ?>]">
                                        <?php elseif ($field['field_type'] === 'number'): ?>
                                            <input type="number" id="field_<?php echo $field['field_id']; ?>" name="field[<?php echo $field['field_id']; ?>]" step="any">
                                        <?php elseif ($field['field_type'] === 'dropdown'): ?>
                                            <select id="field_<?php echo $field['field_id']; ?>" name="field[<?php echo $field['field_id']; ?>]">
                                                <?php $options = explode(',', $field['field_options']); ?>
                                                <?php foreach ($options as $option): ?>
                                                    <option value="<?php echo htmlspecialchars(trim($option)); ?>">
                                                        <?php echo htmlspecialchars(trim($option)); ?>
                                                    </option>
                                                <?php endforeach; ?>
                                            </select>
                                        <?php elseif ($field['field_type'] === 'textarea'): ?>
                                            <textarea id="field_<?php echo $field['field_id']; ?>" name="field[<?php echo $field['field_id']; ?>]" rows="3"></textarea>
                                        <?php endif; ?>

                                        <?php if (!empty($field['normal_range'])): ?>
                                            <p class="normal-range">Ref. Interval: <?php echo htmlspecialchars($field['normal_range']); ?></p>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </section>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary">Save Results</button>
                        </div>
                    <?php else: ?>
                        <p>Please go back and select a test template to begin.</p>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#patient_id').select2({
                width: '100%',
                placeholder: 'Select a Patient...',
                // This makes the dropdown match the new theme
                dropdownParent: $('#patient_id').parent() 
            });
        });
    </script>
</body>
</html>