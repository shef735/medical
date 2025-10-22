<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

<?php
include "../../Connections/dbname.php";

// Function to create a new test template
function createTestTemplate($name, $description) {
    global $conn;
    $name = mysqli_real_escape_string($conn, $name);
    $description = mysqli_real_escape_string($conn, $description);
    
    $sql = "INSERT INTO ".$_SESSION['my_tables']."_laboratory.test_templates (template_name, description) VALUES ('$name', '$description')";
    if (mysqli_query($conn, $sql)) {
        return mysqli_insert_id($conn);
    } else {
        return false;
    }
}

// Function to add fields to a template
function addTemplateField($template_id, $field_name, $field_type = 'text', $options = '', $order = 0) {
    global $conn;
    $template_id = (int)$template_id;
    $field_name = mysqli_real_escape_string($conn, $field_name);
    $field_type = mysqli_real_escape_string($conn, $field_type);
    $options = mysqli_real_escape_string($conn, $options);
    $order = (int)$order;
    
    $sql = "INSERT INTO ".$_SESSION['my_tables']."_laboratory.template_fields (template_id, field_name, field_type, field_options, field_order) 
            VALUES ($template_id, '$field_name', '$field_type', '$options', $order)";
    return mysqli_query($conn, $sql);
}

// Function to get all templates
function getAllTemplates() {
    global $conn;
    $sql = "SELECT * FROM ".$_SESSION['my_tables']."_laboratory.test_templates ORDER BY template_name";
    $result = mysqli_query($conn, $sql);
    
    $templates = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $templates[] = $row;
    }
    return $templates;
}

// Function to get template fields
function getTemplateFields($template_id) {
    global $conn;
    $template_id = (int)$template_id;
    $sql = "SELECT * FROM ".$_SESSION['my_tables']."_laboratory.template_fields WHERE template_id = $template_id ORDER BY field_order";
    $result = mysqli_query($conn, $sql);
    
    $fields = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $fields[] = $row;
    }
    return $fields;
}

// Function to get template by ID
function getTemplateById($template_id) {
    global $conn;
    $template_id = (int)$template_id;
    $sql = "SELECT * FROM ".$_SESSION['my_tables']."_laboratory.test_templates WHERE template_id = $template_id";
    $result = mysqli_query($conn, $sql);
    return mysqli_fetch_assoc($result);
}
?>