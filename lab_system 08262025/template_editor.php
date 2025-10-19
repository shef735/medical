<?php
include 'auth.php';
include 'templates.php';

if (!isLoggedIn() || !hasRole('admin')) {
    header('Location: login.php');
    exit;
}

$template_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$template = $template_id ? getTemplateById($template_id) : null;
$fields = $template_id ? getTemplateFields($template_id) : [];

$error = '';
$message = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update_template'])) {
        // Update template name/description
        $template_name = trim($_POST['template_name']);
        $description = trim($_POST['description']);
        
        if (empty($template_name)) {
            $error = "Template name is required";
        } else {
            $sql = "UPDATE ".$_SESSION['my_tables']."_laboratory.test_templates SET 
                    template_name = '" . mysqli_real_escape_string($conn, $template_name) . "',
                    description = '" . mysqli_real_escape_string($conn, $description) . "'
                    WHERE template_id = $template_id";
            
            if (mysqli_query($conn, $sql)) {
                $message = "Template updated successfully";
                $template['template_name'] = $template_name;
                $template['description'] = $description;
            } else {
                $error = "Error updating template: " . mysqli_error($conn);
            }
        }
    } 
    elseif (isset($_POST['add_field'])) {
        // Add new field
        $field_name = trim($_POST['new_field_name']);
        $field_type = $_POST['new_field_type'];
        $normal_range = trim($_POST['new_normal_range']);
        $field_options = trim($_POST['new_field_options']);
        
        if (empty($field_name)) {
            $error = "Field name is required";
        } else {
            // Get next field order
            $sql = "SELECT MAX(field_order) as max_order FROM ".$_SESSION['my_tables']."_laboratory.template_fields WHERE template_id = $template_id";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            $field_order = $row['max_order'] + 1;
            
            $sql = "INSERT INTO ".$_SESSION['my_tables']."_laboratory.template_fields 
                    (template_id, field_name, field_type, field_options, normal_range, field_order)
                    VALUES (
                        $template_id,
                        '" . mysqli_real_escape_string($conn, $field_name) . "',
                        '" . mysqli_real_escape_string($conn, $field_type) . "',
                        '" . mysqli_real_escape_string($conn, $field_options) . "',
                        '" . mysqli_real_escape_string($conn, $normal_range) . "',
                        $field_order
                    )";
            
            if (mysqli_query($conn, $sql)) {
                $message = "Field added successfully";
                $fields = getTemplateFields($template_id); // Refresh fields
            } else {
                $error = "Error adding field: " . mysqli_error($conn);
            }
        }
    } 
    elseif (isset($_POST['update_fields'])) {
        // Update existing fields
        foreach ($_POST['field'] as $field_id => $field_data) {
            $field_id = (int)$field_id;
            $field_name = trim($field_data['name']);
            $field_type = $field_data['type'];
            $normal_range = trim($field_data['normal_range']);
            $field_options = trim($field_data['options']);
            $field_order = (int)$field_data['order'];
            
            $sql = "UPDATE ".$_SESSION['my_tables']."_laboratory.template_fields SET
                    field_name = '" . mysqli_real_escape_string($conn, $field_name) . "',
                    field_type = '" . mysqli_real_escape_string($conn, $field_type) . "',
                    normal_range = '" . mysqli_real_escape_string($conn, $normal_range) . "',
                    field_options = '" . mysqli_real_escape_string($conn, $field_options) . "',
                    field_order = $field_order
                    WHERE field_id = $field_id AND template_id = $template_id";
            
            mysqli_query($conn, $sql);
        }
        
        $message = "Fields updated successfully";
        $fields = getTemplateFields($template_id); // Refresh fields
    } 
    elseif (isset($_POST['delete_field'])) {
        // Delete a field
        $field_id = (int)$_POST['delete_field'];
        
        $sql = "DELETE FROM ".$_SESSION['my_tables']."_laboratory.template_fields WHERE field_id = $field_id AND template_id = $template_id";
        if (mysqli_query($conn, $sql)) {
            $message = "Field deleted successfully";
            $fields = getTemplateFields($template_id); // Refresh fields
        } else {
            $error = "Error deleting field: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Template</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1, h2 {
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input, select, textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button, .btn {
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 14px;
        }
        button:hover, .btn:hover {
            background-color: #45a049;
        }
        .btn-danger {
            background-color: #f44336;
        }
        .btn-danger:hover {
            background-color: #d32f2f;
        }
        .btn-secondary {
            background-color: #2196F3;
        }
        .btn-secondary:hover {
            background-color: #0b7dda;
        }
        .error {
            color: red;
            margin-bottom: 15px;
        }
        .success {
            color: green;
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        .field-type-options {
            display: none;
            margin-top: 5px;
        }
        .actions {
            white-space: nowrap;
        }
        .sortable-handle {
            cursor: move;
            padding: 0 10px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.13.1/jquery-ui.min.js"></script>
    <script>
        $(function() {
            // Show/hide options based on field type
            $('select[name="new_field_type"]').change(function() {
                toggleFieldOptions($(this).val(), '#new_field_options_container');
            });
            
            $('select[name^="field["][name$="[type]"]').change(function() {
                var container = $(this).closest('tr').find('.field-options-container');
                toggleFieldOptions($(this).val(), container);
            });
            
            // Initialize field options visibility
            $('select[name^="field["][name$="[type]"]').each(function() {
                var container = $(this).closest('tr').find('.field-options-container');
                toggleFieldOptions($(this).val(), container);
            });
            
            // Make fields sortable
            $("#fields-table tbody").sortable({
                handle: ".sortable-handle",
                update: function(event, ui) {
                    // Update order numbers after sorting
                    $("#fields-table tbody tr").each(function(index) {
                        $(this).find('input[name$="[order]"]').val(index + 1);
                    });
                }
            });
        });
        
        function toggleFieldOptions(type, container) {
            if (type === 'dropdown') {
                $(container).show();
            } else {
                $(container).hide();
            }
        }
    </script>
</head>
<body>
    <div class="container">
        <a href="template-list.php" class="btn btn-secondary">Back to Templates</a>
        <h1>Edit Template: <?php echo $template ? htmlspecialchars($template['template_name']) : 'New Template'; ?></h1>
        
        <?php if ($error): ?>
            <div class="error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <?php if ($message): ?>
            <div class="success"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <?php if ($template): ?>
            <form method="post">
                <div class="form-group">
                    <label>Template Name:</label>
                    <input type="text" name="template_name" required 
                           value="<?php echo htmlspecialchars($template['template_name']); ?>">
                </div>
                
                <div class="form-group">
                    <label>Description:</label>
                    <textarea name="description"><?php echo htmlspecialchars($template['description']); ?></textarea>
                </div>
                
                <button type="submit" name="update_template">Update Template</button>
            </form>
            
            <h2>Fields</h2>
            
            <form method="post" id="fields-form">
                <table id="fields-table">
                    <thead>
                        <tr>
                            <th width="30px"></th>
                            <th>Field Name</th>
                            <th>Type</th>
                            <th>Normal Range</th>
                            <th>Options</th>
                            <th>Order</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($fields as $field): ?>
                            <tr>
                                <td class="sortable-handle">☰</td>
                                <td>
                                    <input type="text" name="field[<?php echo $field['field_id']; ?>][name]" 
                                           value="<?php echo htmlspecialchars($field['field_name']); ?>" required>
                                </td>
                                <td>
                                    <select name="field[<?php echo $field['field_id']; ?>][type]">
                                        <option value="text" <?php echo $field['field_type'] === 'text' ? 'selected' : ''; ?>>Text</option>
                                        <option value="number" <?php echo $field['field_type'] === 'number' ? 'selected' : ''; ?>>Number</option>
                                        <option value="dropdown" <?php echo $field['field_type'] === 'dropdown' ? 'selected' : ''; ?>>Dropdown</option>
                                        <option value="textarea" <?php echo $field['field_type'] === 'textarea' ? 'selected' : ''; ?>>Text Area</option>
                                    </select>
                                </td>
                                <td>
                                    <input type="text" name="field[<?php echo $field['field_id']; ?>][normal_range]" 
                                           value="<?php echo  $field['normal_range'] ; ?>">
                                </td>
                                <td>
                                    <div class="field-options-container" style="<?php echo $field['field_type'] !== 'dropdown' ? 'display:none;' : ''; ?>">
                                        <input type="text" name="field[<?php echo $field['field_id']; ?>][options]" 
                                               value="<?php echo htmlspecialchars($field['field_options']); ?>"
                                               placeholder="Comma separated values">
                                    </div>
                                </td>
                                <td>
                                    <input type="number" name="field[<?php echo $field['field_id']; ?>][order]" 
                                           value="<?php echo $field['field_order']; ?>" class="order-input">
                                </td>
                                <td class="actions">
                                    <button type="submit" name="delete_field" value="<?php echo $field['field_id']; ?>" 
                                            class="btn-danger" onclick="return confirm('Are you sure you want to delete this field?');">
                                        Delete
                                    </button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                
                <button type="submit" name="update_fields">Save Field Changes</button>
            </form>
            
            <h2>Add New Field</h2>
            
            <form method="post">
                <div class="form-group">
                    <label>Field Name:</label>
                    <input type="text" name="new_field_name" required>
                </div>
                
                <div class="form-group">
                    <label>Field Type:</label>
                    <select name="new_field_type" id="new_field_type">
                        <option value="text">Text</option>
                        <option value="number">Number</option>
                        <option value="dropdown">Dropdown</option>
                        <option value="textarea">Text Area</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Normal Range:</label>
                    <input type="text" name="new_normal_range" placeholder="e.g., 0-100, >200, Negative/Positive">
                </div>
                
                <div class="form-group" id="new_field_options_container" style="display:none;">
                    <label>Dropdown Options (comma separated):</label>
                    <input type="text" name="new_field_options" placeholder="e.g., Option 1, Option 2, Option 3">
                </div>
                
                <button type="submit" name="add_field">Add Field</button>
            </form>
            
        <?php else: ?>
            <div class="error">Template not found</div>
        <?php endif; ?>
    </div>
</body>
</html>