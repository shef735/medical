<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>


<?php 

unset($_SESSION['user_name']);


$username=$_POST['username'];
$password=$_POST['password'];

if($username=='admin@test.com' AND $password=='admin@gh') {

$_SESSION['user_name']=$username;

 echo "<script>window.location = 'index.php'</script>";

}
else
{

    $message =  'INVALID EMAIL / PASSWORD';
	echo "<script type='text/javascript'>alert('$message');</script>";	

     echo "<script>window.location = 'login.php'</script>";	
																	

}

?>

