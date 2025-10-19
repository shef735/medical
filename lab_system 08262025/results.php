<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

<?php
include "../../Connections/dbname.php";
include 'templates.php';

// Function to save test results
 function saveTestResults($template_id, $patient_id, $field_values) {
    global $conn;
    
    $patient_id = (int)$patient_id;
    $test_date = date('Y-m-d');
    
    $sql = "INSERT INTO ".$_SESSION['my_tables']."_laboratory.test_results (template_id, patient_id, test_date)
            VALUES ($template_id, $patient_id, '$test_date')";
    
    if (mysqli_query($conn, $sql)) {
        $result_id = mysqli_insert_id($conn);
        
        foreach ($field_values as $field_id => $value) {
            $field_id = (int)$field_id;
            $value = mysqli_real_escape_string($conn, $value);
            
            $sql = "INSERT INTO ".$_SESSION['my_tables']."_laboratory.result_values (result_id, field_id, field_value)
                    VALUES ($result_id, $field_id, '$value')";
            mysqli_query($conn, $sql);
        }
        
        return $result_id;
    }
    
    return false;
}

// Function to get test results
function getTestResults($template_id = null) {
    global $conn;
    
    $sql = "SELECT tr.*, tt.template_name FROM ".$_SESSION['my_tables']."_laboratory.test_results tr
            JOIN ".$_SESSION['my_tables']."_laboratory.test_templates tt ON tr.template_id = tt.template_id";
    
    if ($template_id !== null) {
        $template_id = (int)$template_id;
        $sql .= " WHERE tr.template_id = $template_id";
    }
    
    $sql .= " ORDER BY tr.test_date DESC";
    
    $result = mysqli_query($conn, $sql);
    
    $tests = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $tests[] = $row;
    }
    return $tests;
}



// Function to get result details
function getResultDetails($result_id) {
    global $conn;
    $result_id = (int)$result_id;
    
    // Get test info
   /* $sql = "SELECT tr.*, tt.template_name, tt.description 
            FROM ".$_SESSION['my_tables']."_laboratory.test_results tr
            JOIN ".$_SESSION['my_tables']."_laboratory.test_templates tt ON tr.template_id = tt.template_id
            WHERE tr.result_id = $result_id";
    $test_info = mysqli_fetch_assoc(mysqli_query($conn, $sql)); */

    // Get test info with patient details
$sql = "SELECT tr.*, tt.template_name, tt.description, 
               p.*, CONCAT(p.last_name,', ',p.first_name) AS patient_name 
        FROM ".$_SESSION['my_tables']."_laboratory.test_results tr
        JOIN ".$_SESSION['my_tables']."_laboratory.test_templates tt 
          ON tr.template_id = tt.template_id
        JOIN ".$_SESSION['my_tables']."_resources.patient_info  p
          ON tr.patient_id = p.patient_id
        WHERE tr.result_id = $result_id";

$test_info = mysqli_fetch_assoc(mysqli_query($conn, $sql));
    
    if (!$test_info) return false;
    
    // Get field values
    $sql = "SELECT tf.field_id, tf.field_name, tf.field_type, rv.field_value, tf.normal_range 
            FROM ".$_SESSION['my_tables']."_laboratory.result_values rv
            JOIN ".$_SESSION['my_tables']."_laboratory.template_fields tf ON rv.field_id = tf.field_id
            WHERE rv.result_id = $result_id
            ORDER BY tf.field_order";
    $result = mysqli_query($conn, $sql);
    
    $fields = array();
    while ($row = mysqli_fetch_assoc($result)) {
        $fields[] = $row;
    }
    
    return array(
        'test_info' => $test_info,
        'fields' => $fields
    );
}
?>