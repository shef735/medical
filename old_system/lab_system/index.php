<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>



<?php
 
  echo "<script>window.location = 'dashboard.php'</script>";
 

?>
