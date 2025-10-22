<?php
// Ensure errors are not displayed on the final report
error_reporting(0);
ini_set('display_errors', 0);

include 'results.php';
include 'patients.php';

$result_id = 0;
if(isset($_GET['result_id'])) {
    $result_id = (int)$_GET['result_id'];
} elseif(isset($_GET['id'])) {
    $result_id = (int)$_GET['id'];
}

if (!$result_id) {
    // A more user-friendly error
    echo "<p style='font-family: Arial, sans-serif; text-align: center; padding: 20px;'>Invalid Report ID provided.</p>";
    exit;
}

$result = getResultDetails($result_id);

if (!$result) {
    echo "<p style='font-family: Arial, sans-serif; text-align: center; padding: 20px;'>Report not found. Please check the ID and try again.</p>";
    exit;
}

$age = calculateAge($result['test_info']['date_of_birth']);

// --- LOGIC TO CHECK IF REFERENCE INTERVAL COLUMN IS NEEDED ---
$show_range_column = false;
if (!empty($result['fields'])) {
    foreach ($result['fields'] as $field) {
        // Use trim() to ensure spaces aren't counted as a value
        if (!empty(trim($field['normal_range']))) {
            $show_range_column = true;
            break; // Found one, no need to check further
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laboratory Report - <?php echo htmlspecialchars($result['test_info']['patient_name']); ?></title>
<style>
    :root {
        --primary-color: #005a9c;
        --border-color: #dee2e6;
        --text-color: #333;
    }
    
    /* --- SCREEN STYLES --- */
    body {
        font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
        background-color: #f4f4f4;
        margin: 0;
        padding: 20px 0;
        color: var(--text-color);
        font-size: 10pt;
        line-height: 1.5;
        box-sizing: border-box;
    }
    .page {
        background: white;
        width: 210mm;
        margin: 0 auto;
        padding: 15mm;
        box-shadow: 0 0 10px rgba(0,0,0,0.1);
        border: 1px solid var(--border-color);
        box-sizing: border-box;
    }
    .report-header {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        border-bottom: 3px solid var(--primary-color);
        padding-bottom: 10px;
        margin-bottom: 20px;
    }
    .report-header .logo img {
        max-height: 70px;
    }
    .lab-details {
        text-align: right;
        font-size: 9pt;
        line-height: 1.4;
    }
    .patient-info-box {
        border: 1px solid var(--border-color);
        border-radius: 5px;
        padding: 10px 15px;
        margin-bottom: 20px;
    }
    .patient-info-box h2 {
        font-size: 14pt;
        margin: 0 0 10px 0;
        color: var(--primary-color);
    }
    .info-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 5px 20px;
    }
    .info-grid p { margin: 0; }
    .info-grid p strong {
        display: inline-block;
        width: 100px;
    }
    .results-section h2 {
        font-size: 13pt;
        margin: 20px 0 10px 0;
        border-bottom: 1px solid var(--border-color);
        padding-bottom: 5px;
        text-transform: uppercase;
    }
    .results-table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
    }
    .results-table th, .results-table td {
        text-align: left;
        padding: 8px 5px;
        border-bottom: 1px solid var(--border-color);
    }
    .results-table th {
        font-weight: 600;
        background-color: #f9f9f9;
    }
    .results-table tr:last-child td {
        border-bottom: none;
    }
    .test-name { font-weight: 500; }
    .result-value { white-space: pre-wrap; }
    .report-footer {
        margin-top: 40px;
        padding-top: 20px;
        border-top: 1px solid var(--border-color);
    }
    .signatures {
         display: flex;
         justify-content: space-between;
         margin-bottom: 20px;
    }
    .signature-box {
        text-align: center;
        font-size: 9pt;
        color: #666;
    }
    .signature-line {
        border-bottom: 1px solid #999;
        width: 280px;
        margin-bottom: 5px;
        height: 40px;
    }
    .footer-notes {
        text-align: center;
        font-size: 8pt;
        color: #555;
        margin-top: 20px;
    }
    .footer-notes p, .footer-notes em { margin: 2px 0; }
    .no-print {
        position: fixed;
        top: 10px;
        right: 10px;
    }
    .btn {
        background: var(--primary-color);
        color: white;
        padding: 10px 20px;
        border-radius: 5px;
        text-decoration: none;
        border: none;
        cursor: pointer;
        font-size: 11pt;
        margin-left: 10px;
    }

    /* --- PRINT STYLES --- */
    @media print {
        @page {
            /* 1. MAXIMIZE SPACE: Reduced margins */
            margin: 10mm 10mm 15mm 10mm;
        }
        body {
            background: #fff !important;
            padding: 0;
            font-size: 9pt;
        }
        .no-print {
            display: none;
        }
        .page {
            box-shadow: none !important;
            margin: 0 !important;
            width: 100% !important;
            border: none !important;
            padding: 0;
        }

        /* 2. REPEATING PAGE HEADER */
        .repeating-header-print {
            position: fixed;
            top: 0;
            width: 100%;
            background-color: white; 
            z-index: 100;
        }
        main {
            /* Add space to avoid overlapping with fixed header */
            padding-top: 220px; /* Adjust this value if your header height changes */
        }
        
        /* 3. REPEATING TABLE HEADER */
        .results-table thead {
            display: table-header-group;
        }

        .report-footer {
            page-break-inside: avoid;
        }
    }
</style>
</head>
<body>
    <div class="no-print">
        <a href="dashboard.php" class="btn">Home</a>
        <button onclick="window.print()" class="btn">Print Report</button>
    </div>

    <div class="page">
        <div class="repeating-header-print">
            <header class="report-header">
                <div class="logo">
                    <img src="../../uploads/logo/logo_GH.png" alt="Laboratory Logo" style="max-height: 100px; margin-top:-20px">
                </div>
                <div class="lab-details">
                    GASTROHEP, Gen. Miguel Malvar Hospital <br>
                    Old Balara, Quezon City, Philippines<br>
                    Phone: (0935) 365-4165 | Email: malvargastrohep@gmail.com<br>
                    Gastroscopy - Colonoscopy - ERCP - EUS
                </div>
            </header>

            <section class="patient-info-box">
                <h2>Patient Information</h2>
                <div class="info-grid">
                    <p><strong>Patient Name:</strong> <?php echo htmlspecialchars($result['test_info']['patient_name']); ?></p>
                    <p><strong>Date / Time:</strong> <?php echo date("M j, Y", strtotime($result['test_info']['test_date'])).' '.$result['test_info']['test_time']; ?></p>
                    <p><strong>Age / Gender:</strong> <?php echo $age . " / " . htmlspecialchars($result['test_info']['gender']); ?></p>
                    <p><strong>Report ID:</strong> <?php echo htmlspecialchars($result_id); ?></p>
                </div>
            </section>
        </div>

        <main>
            <section class="results-section">
                <h2 style="text-align: center;"><?php echo htmlspecialchars($result['test_info']['template_name']); ?> </h2>
                <table class="results-table">
                    <thead>
                        <tr>
                            <th width="<?php echo $show_range_column ? '35%' : '35%'; ?>"></th>
                            <th width="<?php echo $show_range_column ? '30%' : '65%'; ?>"></th>
                            <?php if ($show_range_column): ?>
                                <th width="35%">Reference Interval</th>
                            <?php endif; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($result['fields'])): ?>
                            <tr>
                                <td colspan="<?php echo $show_range_column ? '3' : '2'; ?>" style="text-align: center;">No results found.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($result['fields'] as $field): ?>
                            <tr>
                                <td class="test-name"><?php echo htmlspecialchars($field['field_name']); ?></td>
                                <td class="result-value"><?php echo nl2br(htmlspecialchars($field['field_value'])); ?></td>
                                <?php if ($show_range_column): ?>
                                    <td><?php echo htmlspecialchars($field['normal_range']); ?></td>
                                <?php endif; ?>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </section>
        </main>

        <footer class="report-footer">
            <div class="signatures">
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <strong>JOSE D. SOLLANO M.D./REI JOSEPH PRIETO,MD</strong><br>
                    ENDOSCOPIST
                </div>
                <div class="signature-box">
                    <div class="signature-line"></div>
                    <strong>JOAN U. VILLAFUERTE, R. N.</strong><br>
                    GI ASSIST
                </div>
            </div>
            <div class="footer-notes">
                <?php 
                    // Set the timezone to Asia/Manila for accurate local time
                    date_default_timezone_set('Asia/Manila'); 
                ?>
                <p>Date Generated: <?php echo date('Y-m-d H:i:s'); ?></p>
                <em>*** This is an electronically generated report. ***</em>
            </div>
        </footer>
        
    </div> </body>
</html>