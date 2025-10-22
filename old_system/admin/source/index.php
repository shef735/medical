<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>


<?php
$_SESSION['system_name']="M-One Solutions";
	$presentdate=date('Y-m-d');


  function formatDate($dateString) {
    // Convert the date string to a timestamp
    $timestamp = strtotime($dateString);
    if ($timestamp === false) {
        return "Invalid date format";
    }

    // Format the timestamp into the desired output
    return date("M d, Y", $timestamp);
}



 

$presentdate=date('Y-m-d');
if(!isset($_SESSION['user_name'])) {

    echo "<script>window.location = 'login.php'</script>";


} 
else
{
    echo "<script>window.location = 'main.php'</script>";
}
 

?>