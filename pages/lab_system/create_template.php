<?php
// create_template.php

// Assuming auth.php starts the session and connects to the DB ($conn)
include 'auth.php'; 

 
$error = '';

// Handle form submission to create the new template
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $template_name = trim($_POST['template_name']);
    $description = trim($_POST['description']);

    // Simple validation
    if (empty($template_name)) {
        $error = "Template name is required.";
    } else {
        // Prepare the SQL query to insert the new template
        $sql = "INSERT INTO ".$_SESSION['my_tables']."_laboratory.test_templates (template_name, description) VALUES (
                    '" . mysqli_real_escape_string($conn, $template_name) . "',
                    '" . mysqli_real_escape_string($conn, $description) . "'
                )";

        // Execute the query
        if (mysqli_query($conn, $sql)) {
            // Get the ID of the newly created template
            $new_template_id = mysqli_insert_id($conn);
            
            // Redirect to the main editor to add fields to the new template
            header('Location: template_editor.php?id=' . $new_template_id . '&status=created');
            exit;
        } else {
            // Display an error if the query fails
            $error = "Error creating template: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Create New Template</title>
    <style>
        /* Reusing styles from your editor for a consistent look */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background-color: white;
            padding: 20px 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
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
        input, textarea {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        button, .btn {
            padding: 10px 15px;
            background-color: #2196F3; /* Blue for create */
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
        }
        button:hover, .btn:hover {
            background-color: #0b7dda;
        }
        .btn-secondary {
            background-color: #6c757d;
            float: right;
        }
        .btn-secondary:hover {
            background-color: #5a6268;
        }
        .error {
            color: #721c24;
            background-color: #f8d7da;
            border: 1px solid #f5c6cb;
            padding: 10px;
            border-radius: 4px;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="template-list.php" class="btn btn-secondary">Back to Templates</a>
        <h1>Create New Template</h1>
        <hr>

        <?php if ($error): ?>
            <div class="error"><?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <form method="post" action="create_template.php">
            <div class="form-group">
                <label for="template_name">Template Name</label>
                <input type="text" id="template_name" name="template_name" required>
            </div>
            
            <div class="form-group">
                <label for="description">Description (Optional)</label>
                <textarea id="description" name="description" rows="4"></textarea>
            </div>
            
            <button type="submit">Create and Add Fields</button>
        </form>
    </div>
</body>
</html>