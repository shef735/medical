<?php
include 'auth.php';
include 'templates.php';

/*if (!isLoggedIn() || !hasRole('admin')) {
    header('Location: login.php');
    exit;
} */

$message = '';
$error = '';

// Handle template deletion
if (isset($_GET['delete'])) {
    $template_id = (int)$_GET['delete'];
    
    // Check if template exists
    $template = getTemplateById($template_id);
    if ($template) {
        $sql = "DELETE FROM ".$_SESSION['my_tables']."_laboratory.test_templates WHERE template_id = $template_id";
        if (mysqli_query($conn, $sql)) {
            $message = "Template deleted successfully";
        } else {
            $error = "Error deleting template: " . mysqli_error($conn);
        }
    } else {
        $error = "Template not found";
    }
}

// Get all templates
$templates = getAllTemplates();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Manage Labs Templates</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 20px;
            background-color: #f5f5f5;
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            background-color: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 {
            margin-top: 0;
            color: #333;
        }
        .message {
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .success {
            background-color: #dff0d8;
            color: #3c763d;
        }
        .error {
            background-color: #f2dede;
            color: #a94442;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        tr:hover {
            background-color: #f9f9f9;
        }
        .actions {
            white-space: nowrap;
        }
        .btn {
            display: inline-block;
            padding: 6px 12px;
            margin-bottom: 0;
            font-size: 14px;
            font-weight: 400;
            line-height: 1.42857143;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            cursor: pointer;
            border: 1px solid transparent;
            border-radius: 4px;
            text-decoration: none;
        }
        .btn-primary {
            color: #fff;
            background-color: #337ab7;
            border-color: #2e6da4;
        }
        .btn-primary:hover {
            background-color: #286090;
            border-color: #204d74;
        }
        .btn-success {
            color: #fff;
            background-color: #5cb85c;
            border-color: #4cae4c;
        }
        .btn-success:hover {
            background-color: #449d44;
            border-color: #398439;
        }
        .btn-danger {
            color: #fff;
            background-color: #d9534f;
            border-color: #d43f3a;
        }
        .btn-danger:hover {
            background-color: #c9302c;
            border-color: #ac2925;
        }
        .btn-sm {
            padding: 5px 10px;
            font-size: 12px;
            line-height: 1.5;
            border-radius: 3px;
        }
        .header-actions {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .search-box {
            display: flex;
            gap: 10px;
        }
        .search-box input {
            padding: 6px 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .search-box button {
            padding: 6px 12px;
        }
    </style>
</head>
<body>
                <a style="float: right;" href="dashboard.php" class="btn btn-success">HOME</a>

    <div class="container">

        <div class="header-actions">
            <h1>Laboratory Templates</h1>
            <a href="create_template.php" class="btn btn-primary">Add New Template</a>
            
        </div>
        
        <?php if ($message): ?>
            <div class="message success"><?php echo $message; ?></div>
        <?php endif; ?>
        
        <?php if ($error): ?>
            <div class="message error"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <div class="search-box">
            <input type="text" id="searchInput" placeholder="Search templates...">
            <button onclick="searchTemplates()" class="btn btn-primary">Search</button>
        </div>
        
        <?php if (empty($templates)): ?>
            <p>No templates found. <a href="template_editor.php">Create your first template</a>.</p>
        <?php else: ?>
            <table id="templatesTable">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Template Name</th>
                        <th>Description</th>
                        <th>Fields</th>
                        <th>Created</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($templates as $template): ?>
                        <tr>
                            <td><?php echo $template['template_id']; ?></td>
                            <td><?php echo htmlspecialchars($template['template_name']); ?></td>
                            <td><?php echo htmlspecialchars($template['description']); ?></td>
                            <td>
                                <?php 
                                $fields = getTemplateFields($template['template_id']);
                                echo count($fields);
                                ?>
                            </td>
                            <td><?php echo date('M j, Y', strtotime($template['created_at'])); ?></td>
                            <td class="actions">
                                <a href="template_editor.php?id=<?php echo $template['template_id']; ?>" class="btn btn-primary btn-sm">Edit</a>
                                <a href="enter_results.php?template_id=<?php echo $template['template_id']; ?>" class="btn btn-success btn-sm">Use</a>
                                <a href="template-list.php?delete=<?php echo $template['template_id']; ?>" class="btn btn-danger btn-sm" 
                                   onclick="return confirm('Are you sure you want to delete this template? All associated fields and results will be deleted.');">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>

    <script>
        function searchTemplates() {
            const input = document.getElementById('searchInput');
            const filter = input.value.toUpperCase();
            const table = document.getElementById('templatesTable');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                const tdName = tr[i].getElementsByTagName('td')[1];
                const tdDesc = tr[i].getElementsByTagName('td')[2];
                if (tdName || tdDesc) {
                    const txtValueName = tdName.textContent || tdName.innerText;
                    const txtValueDesc = tdDesc.textContent || tdDesc.innerText;
                    if (txtValueName.toUpperCase().indexOf(filter) > -1 || 
                        txtValueDesc.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = '';
                    } else {
                        tr[i].style.display = 'none';
                    }
                }
            }
        }

        // Trigger search on Enter key
        document.getElementById('searchInput').addEventListener('keyup', function(event) {
            if (event.key === 'Enter') {
                searchTemplates();
            }
        });
    </script>
</body>
</html>