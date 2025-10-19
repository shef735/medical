<?php
include ("../../Connections/dbname.php");
$filetoresult=ltrim($main_table_use).'_resources.patient_record';
// Fetch data from the database
$sql = "SELECT * FROM ".$filetoresult."";
$result = mysqli_query($conn, $sql);

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
    $data[] = $row;
}

// Return data as JSON
echo json_encode($data);

mysqli_close($conn);
?>