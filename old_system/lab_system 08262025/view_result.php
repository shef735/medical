<?php
include 'results.php';
include 'patients.php';

if(isset($_GET['result_id'])) {
    $result_id = isset($_GET['result_id']) ? (int)$_GET['result_id'] : 0;
}

if(isset($_GET['id'])) {
    $result_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
}

$result = getResultDetails($result_id);

if (!$result) {
    echo "<p>Result not found.</p>";
    exit;
}

$age = calculateAge($result['test_info']['date_of_birth']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Test Result: <?php echo htmlspecialchars($result['test_info']['template_name']); ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.3;
            color: #000;
            margin: 0;
            padding: 5mm;
            font-size: 11pt;
        }
        
        .result-container {
            width: 100%;
        }
        
        h2 {
            font-size: 14pt;
            margin: 5px 0;
            padding-bottom: 3px;
            border-bottom: 1px solid #000;
        }
        
        h3 {
            font-size: 12pt;
            margin: 8px 0 5px 0;
        }
        
        .patient-info {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 5px;
            margin-bottom: 5px;
        }
        
        .patient-info p {
            margin: 2px 0;
            padding: 3px 0;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 5px 0;
            font-size: 10pt;
        }
        
        th {
            background-color: #f0f0f0;
            padding: 4px 6px;
            text-align: left;
            border: 1px solid #ddd;
        }
        
        td {
            padding: 4px 6px;
            border: 1px solid #ddd;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
        }
        
        .footer {
            margin-top: 10px;
            font-size: 9pt;
            text-align: center;
        }
        
        @page {
            size: A4;
            margin: 10mm;
        }
        
        @media print {
            body {
                padding: 0;
            }
            
            .no-print {
                display: none;
            }
            
            table {
                page-break-inside: avoid;
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
        
        @media (max-width: 768px) {
            .patient-info {
                grid-template-columns: 1fr 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="result-container">
        <div class="header">
            <div>
                <h2>Result for : <?php echo htmlspecialchars($result['test_info']['template_name']); ?></h2>
                <p style="font-size: 10pt; margin: 2px 0;"><strong>Report ID:</strong> <?php echo htmlspecialchars($result_id); ?></p>
            </div>
            <div class="no-print">
                <button  onclick="window.print()" style="padding: 3px 8px; font-size: 10pt;">Print Report</button>
                      <a href="dashboard.php" class="btn btn-add">HOME</a>

            </div>
        </div>
        
        <h3>Patient Information</h3>
        <div class="patient-info">
            <p><strong>Name:</strong> <?php echo htmlspecialchars($result['test_info']['patient_name']); ?></p>
            <p><strong>Age:</strong> <?php echo $age; ?></p>
            <p><strong>Gender:</strong> <?php echo htmlspecialchars($result['test_info']['gender']); ?></p>
            <p><strong>Test Date:</strong> <?php echo htmlspecialchars($result['test_info']['test_date']); ?></p>
        </div>
        
        <h3>Laboratory Results</h3>
        <table>
            <thead>
                <tr>
                    <th width="20%">Test</th>
                    <th width="40%">Result</th>
                    <th width="40%">Reference Interval</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($result['fields'] as $field): ?>
                <tr>
                    <td><?php echo htmlspecialchars($field['field_name']); ?></td>
                    <td><?php echo htmlspecialchars($field['field_value']); ?></td>
                    <td><?php echo htmlspecialchars($field['normal_range']); ?></td>

                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        
        <div class="footer">
            <p>Electronically generated report - <?php echo date('Y-m-d H:i:s'); ?></p>
        </div>
    </div>
</body>
</html>