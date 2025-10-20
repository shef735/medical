<?php
session_start();
// Add logic here to ensure only admins can access this page
require_once 'config.php';

// Initialize alert variables
$alert_type = '';
$alert_message = '';
$user_id = 0;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = (int)$_POST['user_id'];
    $assigned_menus = isset($_POST['menus']) ? $_POST['menus'] : [];

    if ($user_id > 0) {
        // Start a transaction
        mysqli_begin_transaction($conn);

        try {
            // 1. Delete all existing permissions for this user
            $sql_delete = "DELETE FROM ".$my_tables."_resources.user_menu_access WHERE user_id = ?";
            $stmt_delete = mysqli_prepare($conn, $sql_delete);
            mysqli_stmt_bind_param($stmt_delete, "i", $user_id);
            mysqli_stmt_execute($stmt_delete);

            // 2. Insert the new permissions
            if (!empty($assigned_menus)) {
                $sql_insert = "INSERT INTO ".$my_tables."_resources.user_menu_access (user_id, menu_id) VALUES (?, ?)";
                $stmt_insert = mysqli_prepare($conn, $sql_insert);
                
                foreach ($assigned_menus as $menu_id) {
                    $menu_id_int = (int)$menu_id;
                    mysqli_stmt_bind_param($stmt_insert, "ii", $user_id, $menu_id_int);
                    mysqli_stmt_execute($stmt_insert);
                }
            }

            // If everything is OK, commit the transaction
            mysqli_commit($conn);
            
            $alert_type = 'success';
            $alert_message = 'User permissions have been updated successfully!';

        } catch (mysqli_sql_exception $exception) {
            // If anything fails, roll back
            mysqli_rollback($conn);
            $alert_type = 'error';
            $alert_message = 'Error updating permissions: ' . $exception->getMessage();
        }
    } else {
        $alert_type = 'error';
        $alert_message = 'Invalid user selected.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Save Access - Management System</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        min-height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .alert-container {
        max-width: 500px;
        width: 100%;
    }

    .alert-card {
        background: white;
        border-radius: 16px;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
        padding: 40px;
        text-align: center;
        animation: slideIn 0.5s ease-out;
    }

    .alert-icon {
        width: 80px;
        height: 80px;
        margin: 0 auto 20px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
    }

    .alert-success .alert-icon {
        background: #d4edda;
        color: #28a745;
    }

    .alert-error .alert-icon {
        background: #f8d7da;
        color: #dc3545;
    }

    .alert-title {
        font-size: 1.5rem;
        font-weight: 600;
        margin-bottom: 15px;
        color: #2c3e50;
    }

    .alert-message {
        color: #6c757d;
        margin-bottom: 30px;
        line-height: 1.6;
    }

    .btn-group {
        display: flex;
        gap: 15px;
        justify-content: center;
        flex-wrap: wrap;
    }

    .btn {
        padding: 12px 30px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        font-weight: 500;
        cursor: pointer;
        text-decoration: none;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .btn-primary {
        background: linear-gradient(135deg, #3498db, #2980b9);
        color: white;
        box-shadow: 0 4px 15px rgba(52, 152, 219, 0.3);
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
        box-shadow: 0 4px 15px rgba(108, 117, 125, 0.3);
    }

    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
    }

    .btn:active {
        transform: translateY(0);
    }

    .alert-success {
        border-left: 5px solid #28a745;
    }

    .alert-error {
        border-left: 5px solid #dc3545;
    }

    @keyframes slideIn {
        from {
            opacity: 0;
            transform: translateY(-30px) scale(0.9);
        }
        to {
            opacity: 1;
            transform: translateY(0) scale(1);
        }
    }

    @keyframes pulse {
        0% { transform: scale(1); }
        50% { transform: scale(1.05); }
        100% { transform: scale(1); }
    }

    .pulse {
        animation: pulse 2s infinite;
    }

    @media (max-width: 576px) {
        .alert-card {
            padding: 30px 20px;
        }
        
        .btn-group {
            flex-direction: column;
        }
        
        .btn {
            width: 100%;
        }
    }
    </style>
</head>
<body>
    <div class="alert-container">
        <div class="alert-card <?php echo $alert_type === 'success' ? 'alert-success' : 'alert-error'; ?>">
            <div class="alert-icon">
                <?php if ($alert_type === 'success'): ?>
                    ✓
                <?php else: ?>
                    ⚠
                <?php endif; ?>
            </div>
            
            <h2 class="alert-title">
                <?php echo $alert_type === 'success' ? 'Success!' : 'Oops!'; ?>
            </h2>
            
            <p class="alert-message"><?php echo htmlspecialchars($alert_message); ?></p>
            
            <div class="btn-group">
                <?php if ($alert_type === 'success' && $user_id > 0): ?>
                    <a href="index.php" class="btn btn-primary pulse">
                        ← Back to Home
                    </a>
                <?php endif; ?>
                
                <a href="manage_access.php" class="btn btn-secondary">
                    Manage Different User
                </a>
                
                <?php if ($alert_type === 'error'): ?>
                    <button onclick="window.history.back()" class="btn btn-secondary">
                        Try Again
                    </button>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <script>
    // Auto-redirect on success after 3 seconds
    <?php if ($alert_type === 'success' && $user_id > 0): ?>
        setTimeout(function() {
            window.location.href = 'manage_access.php?user_id=<?php echo $user_id; ?>';
        }, 9000);
    <?php endif; ?>

    // Add some interactive effects
    document.addEventListener('DOMContentLoaded', function() {
        const buttons = document.querySelectorAll('.btn');
        buttons.forEach(button => {
            button.addEventListener('mouseenter', function() {
                this.style.transform = 'translateY(-2px)';
            });
            button.addEventListener('mouseleave', function() {
                this.style.transform = 'translateY(0)';
            });
        });
    });
    </script>
</body>
</html>