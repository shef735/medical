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

$age = calculateAge($result['test_info']['date_of_birth']);

// --- LOGIC TO CHECK IF REFERENCE INTERVAL COLUMN IS NEEDED ---
$show_range_column = false;
if (!empty($result['fields'])) {
    foreach ($result['fields'] as $field) {
        if (!empty(trim($field['normal_range']))) {
            $show_range_column = true;
            break; 
        }
    }
}

// ---------------------------------------------------------
//  1. EXTEND THE TCPDF CLASS TO CREATE CUSTOM HEADER/FOOTER
// ---------------------------------------------------------

class MYPDF extends TCPDF {

    //Page header
    public function Header() {
        // Logo
        // Make sure to replace 'your-logo.png' with your actual logo file
        $image_file = 'your-logo.png';
        $this->Image($image_file, 15, 10, 40, '', 'PNG', '', 'T', false, 300, '', false, false, 0, false, false, false);
        
        // Set font
        $this->SetFont('helvetica', '', 9);
        
        // Lab Details
        $labDetails = "123 Health St., Medical City, 12345\nPhone: (123) 456-7890\nEmail: contact@yourlab.com\nLicense No: DOH-123456789";
        
        // MultiCell for lab details on the right
        $this->SetXY(120, 12);
        $this->MultiCell(75, 15, $labDetails, 0, 'R', 0, 1, '', '', true);

        // Header bottom border
        $this->Line(15, 30, $this->getPageWidth() - 15, 30);
    }

    // Page footer
    public function Footer() {
        // Position at 30 mm from bottom
        $this->SetY(-30);
        
        // Set font
        $this->SetFont('helvetica', '', 9);

        // Footer top border
        $this->Line(15, $this->GetY(), $this->getPageWidth() - 15, $this->GetY());
        $this->Ln(5);

        // Signature Boxes
        $this->Cell(60, 15, "Pathologist Name\nLicense No. 0012345", 0, false, 'C', 0, '', 1);
        $this->Cell(60, 15, "Medical Technologist\nLicense No. 0054321", 0, false, 'C', 0, '', 1);

        // Signature lines (drawn above the text)
        $this->Line(25, $this->GetY() - 5, 65, $this->GetY() - 5);
        $this->Line(85, $this->GetY() - 5, 125, $this->GetY() - 5);

        // Timestamp and page number
        $dateGenerated = 'Date Generated: ' . date('Y-m-d H:i:s');
        $this->SetXY(130, -25);
        $this->Cell(0, 10, $dateGenerated, 0, false, 'R', 0, '', 0, false, 'T', 'M');
        $this->Ln(4);
        $this->SetX(130);
        $this->Cell(0, 10, 'Page '.$this->getAliasNumPage().'/'.$this->getAliasNbPages(), 0, false, 'R', 0, '', 0, false, 'T', 'M');
    }
}

// ---------------------------------------------------------
//  2. CREATE PDF DOCUMENT USING THE CUSTOM CLASS
// ---------------------------------------------------------

$pdf = new MYPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// Set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Your Laboratory Name');
$pdf->SetTitle('Laboratory Report - ' . htmlspecialchars($result['test_info']['patient_name']));

// Set margins
$pdf->SetMargins(15, 35, 15); // Left, Top, Right
$pdf->SetHeaderMargin(10);
$pdf->SetFooterMargin(30);

// Set auto page breaks
$pdf->SetAutoPageBreak(TRUE, 35);

// Add a page
$pdf->AddPage();

// ---------------------------------------------------------
//  3. ADD CONTENT TO THE PDF
// ---------------------------------------------------------

// --- PATIENT INFORMATION BOX ---
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetTextColor(0, 90, 156); // Primary Color
$pdf->Cell(0, 8, 'Patient Information', 0, 1, 'L');
$pdf->Ln(2);

// Draw the rounded rectangle
$pdf->SetFillColor(255, 255, 255);
$pdf->SetDrawColor(222, 226, 230); // Border color
$pdf->RoundedRect($pdf->GetX(), $pdf->GetY(), 180, 20, 3.5, '1111', 'DF');

// Patient details inside the box
$pdf->SetFont('helvetica', '', 10);
$pdf->SetTextColor(33, 37, 41); // Text color

// First Column
$pdf->SetXY($pdf->GetX() + 5, $pdf->GetY() + 4);
$pdf->Cell(25, 5, 'Patient Name:', 0, 0);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(65, 5, htmlspecialchars($result['test_info']['patient_name']), 0, 0);

// Second Column
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(20, 5, 'Test Date:', 0, 0);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(40, 5, date("F j, Y", strtotime($result['test_info']['test_date'])), 0, 1);

// Move to next line inside the box
$pdf->SetX($pdf->GetX() + 5);
$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(25, 5, 'Age / Gender:', 0, 0);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(65, 5, $age . " / " . htmlspecialchars($result['test_info']['gender']), 0, 0);

$pdf->SetFont('helvetica', '', 10);
$pdf->Cell(20, 5, 'Report ID:', 0, 0);
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Cell(40, 5, htmlspecialchars($result_id), 0, 1);
$pdf->Ln(10);


// --- RESULTS TABLE ---
$pdf->SetFont('helvetica', 'B', 12);
$pdf->SetTextColor(33, 37, 41);
$pdf->Cell(0, 8, htmlspecialchars($result['test_info']['template_name']) . ' Results', 0, 1, 'L');
$pdf->Ln(2);

// Table Header
$pdf->SetFont('helvetica', 'B', 10);
$pdf->SetFillColor(248, 249, 250); // Light gray background
$pdf->SetTextColor(80, 80, 80);
$col1_width = $show_range_column ? 70 : 90;
$col2_width = $show_range_column ? 50 : 90;
$pdf->Cell($col1_width, 8, 'Test', 'B', 0, 'L', 1);
$pdf->Cell($col2_width, 8, 'Result', 'B', 0, 'L', 1);
if ($show_range_column) {
    $pdf->Cell(60, 8, 'Reference Interval', 'B', 0, 'L', 1);
}
$pdf->Ln();

// Table Rows
$pdf->SetFont('helvetica', '', 10);
$pdf->SetTextColor(33, 37, 41);

foreach ($result['fields'] as $field) {
    // Save current Y position to draw bottom border later
    $startY = $pdf->GetY();
    
    // Prepare data for MultiCell to allow text wrapping
    $testCell = $field['field_name'];
    $resultCell = $field['field_value'];
    $rangeCell = $show_range_column ? $field['normal_range'] : '';

    // Calculate max height of the row
    $h1 = $pdf->getStringHeight($col1_width, $testCell);
    $h2 = $pdf->getStringHeight($col2_width, $resultCell);
    $h3 = $show_range_column ? $pdf->getStringHeight(60, $rangeCell) : 0;
    $rowHeight = max($h1, $h2, $h3) + 4; // Add padding

    // Render cells
    $pdf->MultiCell($col1_width, $rowHeight, $testCell, 0, 'L', false, 0);
    $pdf->MultiCell($col2_width, $rowHeight, $resultCell, 0, 'L', false, 0);
    if ($show_range_column) {
        $pdf->MultiCell(60, $rowHeight, $rangeCell, 0, 'L', false, 0);
    }
    $pdf->Ln();

    // Draw the bottom border for the row
    $pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX() + 180, $pdf->GetY());
}

// ---------------------------------------------------------
//  4. OUTPUT THE PDF
// ---------------------------------------------------------

// Clean any previous output
ob_end_clean();

// Define file path on server
$pdf_path = 'reports/report_' . $result_id . '.pdf';
if (!is_dir(__DIR__ . '/reports')) {
    mkdir(__DIR__ . '/reports', 0755, true);
}

// Save PDF to server (F)
$pdf->Output(__DIR__ . '/' . $pdf_path, 'F');

// Update database with the PDF path
// Make sure your database connection ($conn) is available
if (isset($conn)) {
    $safe_pdf_path = mysqli_real_escape_string($conn, $pdf_path);
    $sql = "UPDATE ".$_SESSION['my_tables']."_laboratory.test_results SET pdf_report_path = '$safe_pdf_path' WHERE result_id = $result_id";
    mysqli_query($conn, $sql);
}

// Output PDF to browser for viewing (I)
$pdf->Output('lab_report_' . $result_id . '.pdf', 'I');

?>