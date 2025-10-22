<?php
require_once 'tcpdf/tcpdf.php';
include 'auth.php';
include 'results.php';
include 'patients.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$result_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$result = getResultDetails($result_id);

if (!$result) {
    die("Result not found");
}

$patient = getPatient($result['test_info']['patient_id']);
$age = calculateAge($patient['date_of_birth']);

// Create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Medical Laboratory System');
$pdf->SetTitle('Lab Test Report - ' . $result['test_info']['template_name']);
$pdf->SetSubject('Lab Test Results');

// Set margins
$pdf->SetMargins(15, 15, 15);
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(10);

// Add a page
$pdf->AddPage();

// Logo and header
$pdf->SetFont('helvetica', 'B', 16);
$pdf->Cell(0, 10, 'MEDICAL LABORATORY REPORT', 0, 1, 'C');
$pdf->SetFont('helvetica', '', 12);
$pdf->Cell(0, 10, $result['test_info']['template_name'], 0, 1, 'C');
$pdf->Ln(10);

// Patient information
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Patient Information', 0, 1);
$pdf->SetFont('helvetica', '', 12);

$patient_info = [
    'Patient Code' => $patient['patient_code'],
    'Name' => $patient['first_name'] . ' ' . $patient['last_name'],
    'Date of Birth' => $patient['date_of_birth'] . ' (Age: ' . $age . ')',
    'Gender' => $patient['gender'],
    'Test Date' => $result['test_info']['test_date']
];

foreach ($patient_info as $label => $value) {
    $pdf->Cell(50, 7, $label . ':', 0, 0);
    $pdf->Cell(0, 7, $value, 0, 1);
}

$pdf->Ln(10);

// Test results table
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(0, 10, 'Test Results', 0, 1);
$pdf->SetFont('helvetica', '', 12);

// Table header
$pdf->SetFillColor(240, 240, 240);
$pdf->SetFont('helvetica', 'B', 12);
$pdf->Cell(80, 10, 'Test', 1, 0, 'L', 1);
$pdf->Cell(50, 10, 'Result', 1, 0, 'L', 1);
$pdf->Cell(50, 10, 'Normal Range', 1, 1, 'L', 1);
$pdf->SetFont('helvetica', '', 12);

// Table rows
foreach ($result['fields'] as $field) {
    $field_name = $field['field_name'];
    $field_value = $field['field_value'];
    
    // Get normal range from template_fields if available
    $normal_range = '';
    if (isset($field['normal_range'])) {
        $normal_range = $field['normal_range'];
    }
    
    // Highlight abnormal results (simple example - would need proper logic for each test)
    if (!empty($normal_range)) {
        if (is_numeric($field_value)) {
            $range_parts = explode('-', $normal_range);
            if (count($range_parts) === 2) {
                $min = trim($range_parts[0]);
                $max = trim($range_parts[1]);
                if ($field_value < $min || $field_value > $max) {
                    $pdf->SetTextColor(255, 0, 0); // Red for abnormal
                }
            }
        }
    }
    
    $pdf->Cell(80, 10, $field_name, 1);
    $pdf->Cell(50, 10, $field_value, 1);
    $pdf->Cell(50, 10, $normal_range, 1);
    $pdf->SetTextColor(0, 0, 0); // Reset color
    $pdf->Ln();
}

// Footer
$pdf->Ln(15);
$pdf->Cell(0, 10, 'Technician: ________________________', 0, 1, 'R');
$pdf->Cell(0, 10, 'Date: ' . date('Y-m-d'), 0, 1, 'R');
$pdf->Cell(0, 10, 'Signature: ________________________', 0, 1, 'R');

// Save PDF to server
ob_end_clean();

$pdf_path = 'reports/report_' . $result_id . '.pdf';
$pdf->Output(__DIR__ . '/' . $pdf_path, 'F');

// Update database with PDF path
$sql = "UPDATE ".$_SESSION['my_tables']."_laboratory.test_results SET pdf_report_path = '$pdf_path' WHERE result_id = $result_id";
mysqli_query($conn, $sql);

// Output PDF to browser
$pdf->Output('lab_report_' . $result_id . '.pdf', 'I');
?>