<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Make sure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Include your database connection file
require_once 'config.php'; // Change this to your actual connection file

// Fetch all possible menu items from the database
$all_menus = [];
$sql = "SELECT name, description, url, icon_class, menu_identifier FROM ".$my_tables."_resources.menus ORDER BY id";
$result = mysqli_query($conn, $sql);
if ($result) {
    while ($row = mysqli_fetch_assoc($result)) {
        $all_menus[] = $row;
    }
}

 
// Get the user's access list from the session
$user_access = isset($_SESSION['user_access']) ? $_SESSION['user_access'] : [];


$header_company_code=0;
$company_address = '';
$company_name_full = 'Your Company'; // Default
$my_nc = ltrim($main_table_use) . '_resources.company';
$cdquery_main = "SELECT * FROM " . $my_nc . " WHERE id > ? LIMIT 1";
$stmt_company = mysqli_prepare($conn, $cdquery_main);
mysqli_stmt_bind_param($stmt_company, "s", $header_company_code);
mysqli_stmt_execute($stmt_company);
$company_res = mysqli_stmt_get_result($stmt_company);
if ($row_series = mysqli_fetch_assoc($company_res)) {

    $header_company_code=$row_series['code'];
    $company_name_full = $row_series['company'];
    $company_address = $row_series['address'];
}

$_SESSION['company_name']=$header_company_code.' - '.$company_name_full;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }

        :root {
            --primary-color: #007AFF;
            --background-color: #F2F2F7;
            --card-color: #FFFFFF;
            --text-color: #000000;
            --subtext-color: #8E8E93;
            --border-radius: 18px;
            --shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        }

        body {
            background-color: var(--background-color);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 10px;
        }

        .container {
            max-width: 1400px;
            margin: 0 auto;
            width: 100%;
        }

        header {
            text-align: center;
            padding: 10px 0;
        }

        .logo-container {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom:30px;
        }

        .company-logo {
            max-width: 300px;
            width: auto;
            height: auto;
            object-fit: contain;
        }

        .subtitle {
            color: var(--subtext-color);
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto;
            margin-bottom: 20px;
        }

        .menu-container {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 25px;
            margin-bottom: 40px;
        }

        .menu-item {
            background-color: var(--card-color);
            border-radius: var(--border-radius);
            padding: 25px;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            text-decoration: none;
            color: inherit;
        }

        .menu-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.12);
        }

        .menu-item:active {
            transform: scale(0.98);
        }

        .icon-container {
            width: 80px;
            height: 80px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 20px;
            background: linear-gradient(135deg, var(--primary-color), #5AC8FA);
            color: white;
            font-size: 32px;
        }

        .menu-item:nth-child(2) .icon-container {
            background: linear-gradient(135deg, #4CD964, #34C759);
        }

        .menu-item:nth-child(3) .icon-container {
            background: linear-gradient(135deg, #FF9500, #FFCC00);
        }

        .menu-item:nth-child(4) .icon-container {
            background: linear-gradient(135deg, #FF2D55, #FF6B9C);
        }

        .menu-item:nth-child(5) .icon-container {
            background: linear-gradient(135deg, #5856D6, #AF52DE);
        }

        .menu-item:nth-child(6) .icon-container {
            background: linear-gradient(135deg, #FF3B30, #FF6B6B);
        }

        .menu-item:nth-child(7) .icon-container {
            background: linear-gradient(135deg, #5AC8FA, #007AFF);
        }

        .menu-item:nth-child(8) .icon-container {
            background: linear-gradient(135deg, #8E8E93, #AEAEB2);
        }

        .menu-item:nth-child(9) .icon-container {
            background: linear-gradient(135deg, #FF3B30, #FF9500);
        }

         .menu-item:nth-child(10) .icon-container {
            background: linear-gradient(135deg, #199384ff, #dfc094ff);
        }

           .menu-item:nth-child(11) .icon-container {
            background: linear-gradient(135deg, #a07df8ff, #dfc094ff);
        }


                  .menu-item:nth-child(12) .icon-container {
            background: linear-gradient(135deg, #3dc3deff, #f7f7f7ff);
        }


                  .menu-item:nth-child(13) .icon-container {
            background: linear-gradient(135deg, #db3b3bff, #b33b3bff);
        }

                .menu-item:nth-child(14) .icon-container {
            background: linear-gradient(135deg, #e5ff1eff, #b33b3bff);
        }

        .menu-title {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .menu-description {
            color: var(--subtext-color);
            font-size: 0.95rem;
            line-height: 1.4;
        }

        .badge {
            position: absolute;
            top: 15px;
            right: 15px;
            background-color: var(--primary-color);
            color: white;
            font-size: 0.7rem;
            padding: 3px 8px;
            border-radius: 10px;
        }

        .footer-menu {
            background-color: var(--card-color);
            border-radius: var(--border-radius);
            padding: 20px;
            box-shadow: var(--shadow);
            margin-top: auto;
        }

        .footer-nav {
            display: flex;
            justify-content: space-around;
            align-items: center;
        }

        .footer-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px 15px;
            border-radius: 12px;
            transition: background-color 0.2s;
            cursor: pointer;
            text-decoration: none;
            color: inherit;
        }

        .footer-nav-item:hover {
            background-color: rgba(0, 122, 255, 0.1);
        }

        .footer-nav-item.active {
            color: var(--primary-color);
        }

        .footer-icon {
            font-size: 22px;
            margin-bottom: 5px;
        }

        .footer-label {
            font-size: 0.8rem;
            font-weight: 500;
        }

        @media (max-width: 1200px) {
            .menu-container {
                grid-template-columns: repeat(4, 1fr);
            }
        }

        @media (max-width: 992px) {
            .menu-container {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .menu-container {
                grid-template-columns: repeat(2, 1fr);
                gap: 20px;
            }
            
            .company-logo {
                max-width: 250px;
            }
            
            .subtitle {
                font-size: 1rem;
            }
            
            .icon-container {
                width: 70px;
                height: 70px;
                font-size: 28px;
            }
            
            .menu-title {
                font-size: 1.2rem;
            }
        }

        @media (max-width: 480px) {
            .menu-container {
                grid-template-columns: 1fr;
                gap: 15px;
            }
            
            .company-logo {
                max-width: 200px;
            }
            
            .footer-nav {
                flex-wrap: wrap;
            }
            
            .footer-nav-item {
                width: 25%;
                margin-bottom: 10px;
            }
            
            .icon-container {
                width: 65px;
                height: 65px;
                font-size: 26px;
            }
            
            .menu-title {
                font-size: 1.1rem;
            }
        }

        .notification {
            position: fixed;
            bottom: 100px;
            left: 50%;
            transform: translateX(-50%);
            background-color: #333;
            color: white;
            padding: 12px 20px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
            opacity: 0;
            transition: opacity 0.3s;
            z-index: 1000;
        }

        .notification.show {
            opacity: 1;
        }
    </style>
</head>
<body>
    <div class="container">
        <header>
            <div class="logo-container">
            
                <img src="../uploads/logo/logo_<?php echo strtok($_SESSION['company_name'], " ") ?>.png" alt="Company Logo" class="company-logo">
            </div>
        </header>

        <div class="menu-container">
            <?php foreach ($all_menus as $menu) : ?>
                <?php // Check if the user's access list contains this menu's identifier ?>
                <?php if (in_array($menu['menu_identifier'], $user_access)) : ?>
                    <a href="<?php echo htmlspecialchars($menu['url']); ?>" class="menu-item">
                        <div class="icon-container">
                            <i class="<?php echo htmlspecialchars($menu['icon_class']); ?>"></i>
                        </div>
                        <h3 class="menu-title"><?php echo htmlspecialchars($menu['name']); ?></h3>
                        <p class="menu-description"><?php echo htmlspecialchars($menu['description']); ?></p>
                    </a>
                <?php endif; ?>
            <?php endforeach; ?>
        </div>

        <div class="notification" id="notification"></div>
    </div>

    <script>
        function showNotification(message) {
            const notification = document.getElementById('notification');
            notification.textContent = message;
            notification.classList.add('show');
            
            setTimeout(() => {
                notification.classList.remove('show');
            }, 2000);
        }

        // Add active state to footer menu items
        const footerItems = document.querySelectorAll('.footer-nav-item');
        footerItems.forEach(item => {
            item.addEventListener('click', function() {
                footerItems.forEach(i => i.classList.remove('active'));
                this.classList.add('active');
            });
        });

        // Add click effect to menu items
        const menuItems = document.querySelectorAll('.menu-item');
        menuItems.forEach(item => {
            item.addEventListener('click', function(e) {
                // For demo purposes, prevent actual navigation
                e.preventDefault();
                
                const menuTitle = this.querySelector('.menu-title').textContent;
                showNotification(`Opening ${menuTitle} page...`);
                
                // In a real implementation, you would allow the link to proceed
                // For now, we'll simulate navigation after a delay
                setTimeout(() => {
                    // Uncomment the line below to enable actual navigation
                    window.location.href = this.href;
                }, 1000);
            });
        });
    </script>
</body>
</html>