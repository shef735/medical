<?php

include "../../Connections/dbname.php";

// Function to generate user_id
function generateUserId($conn) {
    $sql = "SELECT MAX(user_id) as max_id FROM doctor_info";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    return $row['max_id'] ? $row['max_id'] + 1 : 10001;
}

?>