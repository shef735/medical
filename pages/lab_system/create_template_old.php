<style>
/* Base Styles */
body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    color: #333;
    background-color: #f5f7fa;
    padding: 20px;
    max-width: 1000px;
    margin: 0 auto;
}

h2 {
    color: #2c3e50;
    margin-bottom: 20px;
    padding-bottom: 10px;
    border-bottom: 2px solid #eaecef;
}

h3 {
    color: #34495e;
    margin: 25px 0 15px 0;
}

/* Form Styles */
form {
    background: #fff;
    padding: 25px;
    border-radius: 8px;
    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
}

label {
    display: block;
    margin-bottom: 8px;
    font-weight: 600;
    color: #4a5568;
}

input[type="text"],
textarea,
select {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 4px;
    margin-bottom: 15px;
    font-size: 16px;
    transition: border-color 0.3s;
}

input[type="text"]:focus,
textarea:focus,
select:focus {
    border-color: #4299e1;
    outline: none;
    box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.2);
}

textarea {
    min-height: 100px;
    resize: vertical;
}

/* Field Group Styles */
.field-group {
    background: #f8fafc;
    padding: 15px;
    border-radius: 6px;
    margin-bottom: 15px;
    border: 1px solid #edf2f7;
}

.field-group > div {
    margin-bottom: 10px;
}

.options-container {
    margin-top: 10px;
    padding: 10px;
    background: #ebf8ff;
    border-radius: 4px;
}

/* Button Styles */
button {
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 16px;
    font-weight: 600;
    transition: all 0.3s;
    margin-right: 10px;
}

button[type="submit"] {
    background-color: #4299e1;
    color: white;
}

button[type="submit"]:hover {
    background-color: #3182ce;
}

#add-field {
    background-color: #e2e8f0;
    color: #2d3748;
}

#add-field:hover {
    background-color: #cbd5e0;
}

/* Message Styles */
p {
    padding: 10px 15px;
    border-radius: 4px;
    margin-bottom: 20px;
}

p:empty {
    display: none;
}

/* Success/Error Messages */
p {
    background-color: #ebf8ff;
    color: #2b6cb0;
    border-left: 4px solid #4299e1;
}

p:empty {
    display: none;
}

/* Responsive Design */
@media (max-width: 768px) {
    body {
        padding: 10px;
    }
    
    form {
        padding: 15px;
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

<?php
include 'templates.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $template_name = $_POST['template_name'];
    $description = $_POST['description'];
    
    $template_id = createTestTemplate($template_name, $description);
    
    if ($template_id) {
        // Process fields
        foreach ($_POST['field_name'] as $index => $field_name) {
            $field_type = $_POST['field_type'][$index];
            $options = isset($_POST['field_options'][$index]) ? $_POST['field_options'][$index] : '';
            addTemplateField($template_id, $field_name, $field_type, $options, $index);
        }
        
        echo "<p>Template created successfully!</p>";
    } else {
        echo "<p>Error creating template.</p>";
    }
}
?>
    <a style="float: right;" href="dashboard.php" class="btn btn-add"><b>HOME</b></a>

<h2>Create New Test Template</h2>

<form method="post">
    <div>
        <label>Template Name:</label>
        <input type="text" name="template_name" required>
    </div>
    <div>
        <label>Description:</label>
        <textarea name="description"></textarea>
    </div>
    
    <h3>Fields</h3>
    <div id="fields-container">
        <div class="field-group">
            <div>
                <label>Field Name:</label>
                <input type="text" name="field_name[]" required>
            </div>
            <div>
                <label>Field Type:</label>
                <select name="field_type[]">
                    <option value="text">Text</option>
                    <option value="number">Number</option>
                    <option value="dropdown">Dropdown</option>
                    <option value="textarea">Text Area</option>
                </select>
            </div>
            <div class="options-container" style="display:none;">
                <label>Options (comma separated):</label>
                <input type="text" name="field_options[]">
            </div>
        </div>
    </div>
    
    <button type="button" id="add-field">Add Field</button>
    <button type="submit">Create Template</button>

</form>

<script>
document.getElementById('add-field').addEventListener('click', function() {
    const container = document.getElementById('fields-container');
    const newField = container.firstElementChild.cloneNode(true);
    newField.querySelectorAll('input').forEach(input => input.value = '');
    container.appendChild(newField);
});

// Show options when dropdown is selected
document.addEventListener('change', function(e) {
    if (e.target.name === 'field_type[]') {
        const optionsContainer = e.target.closest('.field-group').querySelector('.options-container');
        optionsContainer.style.display = e.target.value === 'dropdown' ? 'block' : 'none';
    }
});
</script>