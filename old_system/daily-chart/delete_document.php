<?php
include 'config.php';

if (!isset($_GET['doc_id']) || !isset($_GET['visit_id'])) {
    header("Location: index.php");
    exit;
}

$doc_id = $_GET['doc_id'];
$visit_id = $_GET['visit_id'];

// Fetch document info to get file path
$doc_sql = "SELECT * FROM visit_documents WHERE id = $doc_id";
$doc_result = mysqli_query($conn, $doc_sql);
$document = mysqli_fetch_assoc($doc_result);

if ($document) {
    // Delete the file
    if (file_exists($document['file_path'])) {
        unlink($document['file_path']);
    }
    
    // Delete the database record
    $delete_sql = "DELETE FROM visit_documents WHERE id = $doc_id";
    mysqli_query($conn, $delete_sql);
}

header("Location: edit_visit.php?visit_id=$visit_id&message=Document deleted successfully");
?>