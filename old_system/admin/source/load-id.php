<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>



<?php
$_SESSION['selected_id']='';


if(isset($_GET['id'])) {
        $_SESSION['selected_id']=$_GET['id'];
        if(isset($_GET['transaction'])) {
                echo "<script>window.location = '".$_GET['transaction'].".php'</script>";
        }       
}

 



?>