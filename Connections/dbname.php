<?php
if(!isset($_SESSION)){		
session_start();
ob_start();	
}
?>



<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

date_default_timezone_set("Asia/Manila"); 
	//header("Content-Type: text/html;charset=utf-8");


// LOCALHOST
	$host = "localhost";
	$uname = "root";
	$pass = "";
	
	$main_table_use='medical';
	$database = $main_table_use."_resources";
	$my_tables_use_check=$main_table_use;
	$my_tables_use=$main_table_use;  



/// SERVER
	/*	$host = "localhost";
		$uname = "root";
		$pass = "KnVnC#*6S#Kz4D]@HyY5my]";
		$database = "solutions_resources";
		$main_table_use='solutions';
		$my_tables_use_check=$main_table_use;
		$my_tables_use=$main_table_use; 
*/


 
//// LOCALHOST		
	 
	 
		 
		 
	 
		 
		 
		
		
		
			$host = "localhost";
		$uname = "root";
		$pass = "";
		
		$main_table_use='medical';
		$database = $main_table_use."_resources";
		$my_tables_use_check=$main_table_use;
		$my_tables_use=$main_table_use; 
		$my_tables=$main_table_use;

//MySQLi Procedural
$conn = mysqli_connect($host,$uname,$pass,$database) or die("connection in not ready <br>");
$db_connection=$conn;
	mysqli_set_charset($conn,'utf8');
	mysqli_query($conn,"SET NAMES 'utf8'");	

 
 $_SESSION['dbhost']=$host;
 $_SESSION['dbuser']=$uname;
 $_SESSION['dbpass']=$pass;
 $_SESSION['my_tables']=$my_tables;
  $_SESSION['dbname']=$database ;
$_SESSION['conn']=$conn;
$_SESSION["page_location"]='';
 
 
mysqli_query($conn,"SET sql_mode = '' ");	
mysqli_query($conn,"SET GLOBAL sql_mode=(SELECT REPLACE(@@sql_mode,'ONLY_FULL_GROUP_BY','')) ");	
mysqli_query($conn,"SET GLOBAL sql_mode = 'NO_ENGINE_SUBSTITUTION' ");	



//}
?>