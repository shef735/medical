<?php

include "../../Connections/dbname.php";

// Function to generate patient code
function generatePatientCode($conn) {
    $query = "SELECT MAX(patient_id) as max_id FROM patient_info";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $max_id = $row['max_id'] ? $row['max_id'] : 0;
    $next_id = $max_id + 1;
    return "MH-GH" . str_pad($next_id, 5, '0', STR_PAD_LEFT);
}
?>