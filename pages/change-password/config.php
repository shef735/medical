<?php
if(!isset($_SESSION)) {
session_start();
ob_start();
}
?>


<?php

include '../../Connections/dbname.php';

$link=$conn;
$customer_table = $my_tables . "_resources.user_data";

 
?>