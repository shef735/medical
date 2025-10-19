<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>


<?php


mysqli_report(MYSQLI_REPORT_OFF);

set_time_limit(0);


 
set_time_limit(0);

$presentdate=date('Y-m-d');
 
  include ("../../Connections/dbname.php"); 
$my_tables_use=$main_table_use;

function repstring($value){
		$title = str_replace( array( '\'', '"', '#', '!','&' , ';', '<', '>',' ','-' ), '', $value);
		$title=str_replace( array('ñ','Ñ' ), 'N', $title);
return $title;
	}
	


$filetoresult=ltrim($my_tables_use).'_resources.patient_info';
		$resultat = mysqli_query($conn, "CREATE TABLE IF NOT EXISTS $filetoresult (
			  id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					date date,
					user_id varchar(30) NOT NULL,
					last_name LONGTEXT NOT NULL,
					first_name  LONGTEXT NOT NULL,
					middle_name LONGTEXT NOT NULL,
					password LONGTEXT NOT NULL,
					address LONGTEXT NOT NULL,
					phone LONGTEXT NOT NULL,
					sex varchar(10) NOT NULL,
					email LONGTEXT NOT NULL,
					birthday date,
					height_cm varchar(11) NOT NULL,
					weight_kg varchar(11) NOT NULL,
					prev_consults LONGTEXT NOT NULL,					
					photo LONGTEXT NOT NULL,
					bmi varchar(11) NOT NULL)");


					
$filetoresult=ltrim($my_tables_use).'_resources.company';
		$resultat = mysqli_query($conn, "CREATE TABLE IF NOT EXISTS $filetoresult (
			  id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,					 
					code varchar(10) NOT NULL,
					company LONGTEXT NOT NULL,
					address  LONGTEXT NOT NULL,
					telno LONGTEXT NOT NULL,
					email LONGTEXT NOT NULL)");


					$filetoresult=ltrim($my_tables_use).'_laboratory.test_type';
		$resultat = mysqli_query($conn, "CREATE TABLE IF NOT EXISTS $filetoresult (
			  id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,					 
					code varchar(10) NOT NULL,
					details LONGTEXT NOT NULL )");


			 


$filetoresult=ltrim($my_tables_use).'_resources.diagnosis';
		$resultat = mysqli_query($conn, "CREATE TABLE IF NOT EXISTS $filetoresult (
			  id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,					 
					code varchar(10) NOT NULL,
					details LONGTEXT NOT NULL)");


 

$filetoresult=ltrim($my_tables_use).'_resources.patient_details';
		$resultat = mysqli_query($conn, "CREATE TABLE IF NOT EXISTS $filetoresult (
			  id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					date date,
					user_id varchar(30) NOT NULL,
					 first_attack date,
					frequency_pain LONGTEXT NOT NULL,
					stool_per_day LONGTEXT NOT NULL,
					chief_complain LONGTEXT NOT NULL,
					other_symptoms LONGTEXT NOT NULL,
					other_symptoms_others LONGTEXT NOT NULL,
					medical_history LONGTEXT NOT NULL,
					any_operation LONGTEXT NOT NULL,
					family_history  varchar(3) NOT NULL,
					smoker varchar(15) NOT NULL,
					pack_per_day LONGTEXT NOT NULL,
					years_smoking LONGTEXT NOT NULL,
					pain_rate varchar(2) NOT NULL,
					general_well varchar(15) NOT NULL,
					behavioral_health LONGTEXT NOT NULL,
					laboratories LONGTEXT NOT NULL,
					lab_files LONGTEXT NOT NULL,
					vaccines LONGTEXT NOT NULL,
					vac_files LONGTEXT NOT NULL,
					medications LONGTEXT NOT NULL,
					med_files LONGTEXT NOT NULL,
					imaging LONGTEXT NOT NULL,
					ima_files LONGTEXT NOT NULL,
					imaging_others LONGTEXT NOT NULL,
					other_files LONGTEXT NOT NULL															
					)");			





$filetoresult=ltrim($my_tables_use).'_resources.patient_record';
		$resultat = mysqli_query($conn, "CREATE TABLE IF NOT EXISTS $filetoresult (
			  id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					date date,
					user_id varchar(30) NOT NULL,					 															
fullname LONGTEXT NOT NULL,
age varchar(11) NOT NULL,
sex  varchar(10) NOT NULL,
height_cm varchar(11) NOT NULL,
weight_kg varchar(11) NOT NULL,
bmi varchar(11) NOT NULL,
birthday date,
dateofdiagnosis date,
diagnosisyear LONGTEXT NOT NULL,
diagnosis1 LONGTEXT NOT NULL,
contactnumber LONGTEXT NOT NULL,
attending LONGTEXT NOT NULL,
hospital LONGTEXT NOT NULL,
smokinghx LONGTEXT NOT NULL,
smokingpackyears LONGTEXT NOT NULL,
familyhxofibd LONGTEXT NOT NULL,
pastmedhxv LONGTEXT NOT NULL,
appendectomy LONGTEXT NOT NULL,
ocpuse LONGTEXT NOT NULL,
chiefcomplaint LONGTEXT NOT NULL,
othersymptoms1 LONGTEXT NOT NULL,
othersymptoms2 LONGTEXT NOT NULL,
extraintestinalmanifestations1 LONGTEXT NOT NULL,
hepavaccination LONGTEXT NOT NULL,
hepbvaccination LONGTEXT NOT NULL,
reactive LONGTEXT NOT NULL,
hgblevels LONGTEXT NOT NULL,
typeofanemia LONGTEXT NOT NULL,
plateletcount LONGTEXT NOT NULL,
albumin LONGTEXT NOT NULL,
crplevel LONGTEXT NOT NULL,
esr LONGTEXT NOT NULL,
cdifficileinfxn LONGTEXT NOT NULL,
proceduredone LONGTEXT NOT NULL,
dateofprocedure date,
endoscopicfindings LONGTEXT NOT NULL,
lesion1 LONGTEXT NOT NULL,
lesion2 LONGTEXT NOT NULL,
lesion3 LONGTEXT NOT NULL,
colonoscopicfindings LONGTEXT NOT NULL,
distribution LONGTEXT NOT NULL,
diagnosis2 LONGTEXT NOT NULL,
histopathfindings1 LONGTEXT NOT NULL,
histopathfindings2 LONGTEXT NOT NULL,
histopathfindings3 LONGTEXT NOT NULL,
histopathfinding LONGTEXT NOT NULL,
initialtreatment LONGTEXT NOT NULL,
duration LONGTEXT NOT NULL,
dateoffollowup LONGTEXT NOT NULL,
improvement LONGTEXT NOT NULL,
additionaltreatment LONGTEXT NOT NULL,
repeatcolonoscopy LONGTEXT NOT NULL,
dateofcolonoscopy date,
mayoscore LONGTEXT NOT NULL,
frequencyofstools LONGTEXT NOT NULL,
abdominalpain  LONGTEXT NOT NULL,
generalwellbeing LONGTEXT NOT NULL,
extraintestinalmanifestations2 LONGTEXT NOT NULL,
montrealextentforuc LONGTEXT NOT NULL,
severityinuc LONGTEXT NOT NULL,
locationcd LONGTEXT NOT NULL,
behaviorcd LONGTEXT NOT NULL,
complications LONGTEXT NOT NULL,
surgery LONGTEXT NOT NULL,
notes LONGTEXT NOT NULL,
management LONGTEXT NOT NULL,
useofprolongedsteroids LONGTEXT NOT NULL,
biologics LONGTEXT NOT NULL,
typeofbiologics	 LONGTEXT NOT NULL

 )");		



$filetoresult=ltrim($my_tables_use).'_resources.patient_biological';
		$resultat = mysqli_query($conn, "CREATE TABLE IF NOT EXISTS $filetoresult (
			  id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					date date,
					user_id varchar(30) NOT NULL,	
					fullname LONGTEXT NOT NULL,	
					age varchar(30) NOT NULL,	
					sex varchar(10) NOT NULL,	
					diagnosis LONGTEXT NOT NULL,	
					indication date,	
					complication LONGTEXT NOT NULL,	
					eims LONGTEXT NOT NULL,	
					onset_var LONGTEXT NOT NULL,	
					fistula LONGTEXT NOT NULL,	
					onset LONGTEXT NOT NULL,	
					obstruction LONGTEXT NOT NULL,	
					surgery LONGTEXT NOT NULL,	
					outcome LONGTEXT NOT NULL,
					biological  LONGTEXT NOT NULL,
					note  LONGTEXT NOT NULL  
 )");	



$filetoresult=ltrim($my_tables_use).'_resources.record_bp';
		$resultat = mysqli_query($conn, "CREATE TABLE IF NOT EXISTS $filetoresult (
			  id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					date date,
					user_id varchar(30) NOT NULL,	
					bp LONGTEXT NOT NULL,					 	
					bp_time LONGTEXT NOT NULL
 )");	

 $filetoresult=ltrim($my_tables_use).'_resources.doctor_info';
		$resultat = mysqli_query($conn, "CREATE TABLE IF NOT EXISTS $filetoresult (
			  id int(11) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					date date,
					user_id varchar(30) NOT NULL,
					suffix LONGTEXT NOT NULL,
					last_name LONGTEXT NOT NULL,
					first_name  LONGTEXT NOT NULL,
					middle_name LONGTEXT NOT NULL,		
					specialists LONGTEXT NOT NULL,			
					address LONGTEXT NOT NULL,
					phone LONGTEXT NOT NULL,
					sex varchar(10) NOT NULL,
					email LONGTEXT NOT NULL,
					birthday date,						
					photo LONGTEXT NOT NULL)");


							   	$prefix=ltrim($main_table_use).'_schedule.appointments';
										  $col_name = 'doctor';
										  $column_attr = "LONGTEXT NOT NULL";
										  $col = mysqli_query($conn,"SELECT ".$col_name." FROM ".$prefix);
										  if (!$col){
											  mysqli_query($conn,"ALTER TABLE ".$prefix." ADD ".$col_name." ". $column_attr );
											  echo $col_name.' added </br>';			
										  }
										  else
										  {
											  echo $col_name.' already exists! </br>';
										  }	

										  
							   	$prefix=ltrim($main_table_use).'_schedule.appointments';
										  $col_name = 'remarks';
										  $column_attr = "LONGTEXT NOT NULL";
										  $col = mysqli_query($conn,"SELECT ".$col_name." FROM ".$prefix);
										  if (!$col){
											  mysqli_query($conn,"ALTER TABLE ".$prefix." ADD ".$col_name." ". $column_attr );
											  echo $col_name.' added </br>';			
										  }
										  else
										  {
											  echo $col_name.' already exists! </br>';
										  }	


										     	$prefix=ltrim($main_table_use).'_schedule.appointments';
										  $col_name = 'findings';
										  $column_attr = "LONGTEXT NOT NULL";
										  $col = mysqli_query($conn,"SELECT ".$col_name." FROM ".$prefix);
										  if (!$col){
											  mysqli_query($conn,"ALTER TABLE ".$prefix." ADD ".$col_name." ". $column_attr );
											  echo $col_name.' added </br>';			
										  }
										  else
										  {
											  echo $col_name.' already exists! </br>';
										  }	

										     	$prefix=ltrim($main_table_use).'_schedule.appointments';
										  $col_name = 'bp';
										  $column_attr = "VARCHAR(11) NOT NULL";
										  $col = mysqli_query($conn,"SELECT ".$col_name." FROM ".$prefix);
										  if (!$col){
											  mysqli_query($conn,"ALTER TABLE ".$prefix." ADD ".$col_name." ". $column_attr );
											  echo $col_name.' added </br>';			
										  }
										  else
										  {
											  echo $col_name.' already exists! </br>';
										  }	

										     	$prefix=ltrim($main_table_use).'_schedule.appointments';
										  $col_name = 'weight_kg';
										  $column_attr = "VARCHAR(11) NOT NULL";
										  $col = mysqli_query($conn,"SELECT ".$col_name." FROM ".$prefix);
										  if (!$col){
											  mysqli_query($conn,"ALTER TABLE ".$prefix." ADD ".$col_name." ". $column_attr );
											  echo $col_name.' added </br>';			
										  }
										  else
										  {
											  echo $col_name.' already exists! </br>';
										  }	


	     								$prefix=ltrim($main_table_use).'_resources.clinic_visits';
										  $col_name = 'objective';
										  $column_attr = "LONGTEXT NOT NULL";
										  $col = mysqli_query($conn,"SELECT ".$col_name." FROM ".$prefix);
										  if (!$col){
											  mysqli_query($conn,"ALTER TABLE ".$prefix." ADD ".$col_name." ". $column_attr );
											  echo $col_name.' added </br>';			
										  }
										  else
										  {
											  echo $col_name.' already exists! </br>';
										  }	

										  $prefix=ltrim($main_table_use).'_resources.clinic_visits';
										  $col_name = 'assessment';
										  $column_attr = "LONGTEXT NOT NULL";
										  $col = mysqli_query($conn,"SELECT ".$col_name." FROM ".$prefix);
										  if (!$col){
											  mysqli_query($conn,"ALTER TABLE ".$prefix." ADD ".$col_name." ". $column_attr );
											  echo $col_name.' added </br>';			
										  }
										  else
										  {
											  echo $col_name.' already exists! </br>';
										  }	

										  $prefix=ltrim($main_table_use).'_resources.clinic_visits';
										  $col_name = 'plans';
										  $column_attr = "LONGTEXT NOT NULL";
										  $col = mysqli_query($conn,"SELECT ".$col_name." FROM ".$prefix);
										  if (!$col){
											  mysqli_query($conn,"ALTER TABLE ".$prefix." ADD ".$col_name." ". $column_attr );
											  echo $col_name.' added </br>';			
										  }
										  else
										  {
											  echo $col_name.' already exists! </br>';
										  }	



				$prefix=ltrim($main_table_use).'_resources.clinic_visits';
										  $col_name = 'last_name';
										  $column_attr = "LONGTEXT NOT NULL";
										  $col = mysqli_query($conn,"SELECT ".$col_name." FROM ".$prefix);
										  if (!$col){
											  mysqli_query($conn,"ALTER TABLE ".$prefix." ADD ".$col_name." ". $column_attr );
											  echo $col_name.' added </br>';			
										  }
										  else
										  {
											  echo $col_name.' already exists! </br>';
										  }	


										  $prefix=ltrim($main_table_use).'_resources.clinic_visits';
										  $col_name = 'first_name';
										  $column_attr = "LONGTEXT NOT NULL";
										  $col = mysqli_query($conn,"SELECT ".$col_name." FROM ".$prefix);
										  if (!$col){
											  mysqli_query($conn,"ALTER TABLE ".$prefix." ADD ".$col_name." ". $column_attr );
											  echo $col_name.' added </br>';			
										  }
										  else
										  {
											  echo $col_name.' already exists! </br>';
										  }	


$prefix=ltrim($main_table_use).'_resources.clinic_visits';
										  $col_name = 'middle_name';
										  $column_attr = "LONGTEXT NOT NULL";
										  $col = mysqli_query($conn,"SELECT ".$col_name." FROM ".$prefix);
										  if (!$col){
											  mysqli_query($conn,"ALTER TABLE ".$prefix." ADD ".$col_name." ". $column_attr );
											  echo $col_name.' added </br>';			
										  }
										  else
										  {
											  echo $col_name.' already exists! </br>';
										  }	

										  $prefix=ltrim($main_table_use).'_resources.clinic_visits';
										  $col_name = 'patient_code';
										  $column_attr = "LONGTEXT NOT NULL";
										  $col = mysqli_query($conn,"SELECT ".$col_name." FROM ".$prefix);
										  if (!$col){
											  mysqli_query($conn,"ALTER TABLE ".$prefix." ADD ".$col_name." ". $column_attr );
											  echo $col_name.' added </br>';			
										  }
										  else
										  {
											  echo $col_name.' already exists! </br>';
										  }	




										     	$prefix=ltrim($main_table_use).'_schedule.appointments';
										  $col_name = 'phone';
										  $column_attr = "LONGTEXT NOT NULL";
										  $col = mysqli_query($conn,"SELECT ".$col_name." FROM ".$prefix);
										  if (!$col){
											  mysqli_query($conn,"ALTER TABLE ".$prefix." ADD ".$col_name." ". $column_attr );
											  echo $col_name.' added </br>';			
										  }
										  else
										  {
											  echo $col_name.' already exists! </br>';
										  }	

										  $prefix=ltrim($main_table_use).'_schedule.appointments';
										  $col_name = 'email';
										  $column_attr = "LONGTEXT NOT NULL";
										  $col = mysqli_query($conn,"SELECT ".$col_name." FROM ".$prefix);
										  if (!$col){
											  mysqli_query($conn,"ALTER TABLE ".$prefix." ADD ".$col_name." ". $column_attr );
											  echo $col_name.' added </br>';			
										  }
										  else
										  {
											  echo $col_name.' already exists! </br>';
										  }	

	     	$prefix=ltrim($main_table_use).'_resources.patient_info';
										  $col_name = 'blood_group';
										  $column_attr = "VARCHAR(11) NOT NULL";
										  $col = mysqli_query($conn,"SELECT ".$col_name." FROM ".$prefix);
										  if (!$col){
											  mysqli_query($conn,"ALTER TABLE ".$prefix." ADD ".$col_name." ". $column_attr );
											  echo $col_name.' added </br>';			
										  }
										  else
										  {
											  echo $col_name.' already exists! </br>';
										  }	

										  $prefix=ltrim($main_table_use).'_resources.patient_info';
										  $col_name = 'civil_status';
										  $column_attr = "VARCHAR(30) NOT NULL";
										  $col = mysqli_query($conn,"SELECT ".$col_name." FROM ".$prefix);
										  if (!$col){
											  mysqli_query($conn,"ALTER TABLE ".$prefix." ADD ".$col_name." ". $column_attr );
											  echo $col_name.' added </br>';			
										  }
										  else
										  {
											  echo $col_name.' already exists! </br>';
										  }	


										  $prefix=ltrim($main_table_use).'_resources.patient_info';
										  $col_name = 'psgc_barangay';
										  $column_attr = "LONGTEXT NOT NULL";
										  $col = mysqli_query($conn,"SELECT ".$col_name." FROM ".$prefix);
										  if (!$col){
											  mysqli_query($conn,"ALTER TABLE ".$prefix." ADD ".$col_name." ". $column_attr );
											  echo $col_name.' added </br>';			
										  }
										  else
										  {
											  echo $col_name.' already exists! </br>';
										  }	


										  	  $prefix=ltrim($main_table_use).'_resources.patient_details';
										  $col_name = 'mark_save';
										  $column_attr = "VARCHAR(1) NOT NULL";
										  $col = mysqli_query($conn,"SELECT ".$col_name." FROM ".$prefix);
										  if (!$col){
											  mysqli_query($conn,"ALTER TABLE ".$prefix." ADD ".$col_name." ". $column_attr );
											  echo $col_name.' added </br>';			
										  }
										  else
										  {
											  echo $col_name.' already exists! </br>';
										  }


 										$prefix=ltrim($main_table_use).'_resources.record_notes';
										  $col_name = 'doctor_notes';
										  $column_attr = "LONGTEXT NOT NULL";
										  $col = mysqli_query($conn,"SELECT ".$col_name." FROM ".$prefix);
										  if (!$col){
											  mysqli_query($conn,"ALTER TABLE ".$prefix." ADD ".$col_name." ". $column_attr );
											  echo $col_name.' added </br>';			
										  }
										  else
										  {
											  echo $col_name.' already exists! </br>';
										  }


									 

										  $prefix=ltrim($main_table_use).'_resources.patient_info';
										  $col_name = 'psgc_municipality';
										  $column_attr = "LONGTEXT NOT NULL";
										  $col = mysqli_query($conn,"SELECT ".$col_name." FROM ".$prefix);
										  if (!$col){
											  mysqli_query($conn,"ALTER TABLE ".$prefix." ADD ".$col_name." ". $column_attr );
											  echo $col_name.' added </br>';			
										  }
										  else
										  {
											  echo $col_name.' already exists! </br>';
										  }

										    $prefix=ltrim($main_table_use).'_resources.patient_info';
										  $col_name = 'psgc_province';
										  $column_attr = "LONGTEXT NOT NULL";
										  $col = mysqli_query($conn,"SELECT ".$col_name." FROM ".$prefix);
										  if (!$col){
											  mysqli_query($conn,"ALTER TABLE ".$prefix." ADD ".$col_name." ". $column_attr );
											  echo $col_name.' added </br>';			
										  }
										  else
										  {
											  echo $col_name.' already exists! </br>';
										  }

										    $prefix=ltrim($main_table_use).'_resources.patient_info';
										  $col_name = 'psgc_region';
										  $column_attr = "LONGTEXT NOT NULL";
										  $col = mysqli_query($conn,"SELECT ".$col_name." FROM ".$prefix);
										  if (!$col){
											  mysqli_query($conn,"ALTER TABLE ".$prefix." ADD ".$col_name." ". $column_attr );
											  echo $col_name.' added </br>';			
										  }
										  else
										  {
											  echo $col_name.' already exists! </br>';
										  }

										    $prefix=ltrim($main_table_use).'_resources.patient_info';
										  $col_name = 'ZipCode';
										  $column_attr = "LONGTEXT NOT NULL";
										  $col = mysqli_query($conn,"SELECT ".$col_name." FROM ".$prefix);
										  if (!$col){
											  mysqli_query($conn,"ALTER TABLE ".$prefix." ADD ".$col_name." ". $column_attr );
											  echo $col_name.' added </br>';			
										  }
										  else
										  {
											  echo $col_name.' already exists! </br>';
										  }
										

										   $prefix=ltrim($main_table_use).'_resources.patient_info';
										  $col_name = 'NoBldgName';
										  $column_attr = "LONGTEXT NOT NULL";
										  $col = mysqli_query($conn,"SELECT ".$col_name." FROM ".$prefix);
										  if (!$col){
											  mysqli_query($conn,"ALTER TABLE ".$prefix." ADD ".$col_name." ". $column_attr );
											  echo $col_name.' added </br>';			
										  }
										  else
										  {
											  echo $col_name.' already exists! </br>';
										  }

										  
										   $prefix=ltrim($main_table_use).'_resources.patient_info';
										  $col_name = 'StreetName';
										  $column_attr = "LONGTEXT NOT NULL";
										  $col = mysqli_query($conn,"SELECT ".$col_name." FROM ".$prefix);
										  if (!$col){
											  mysqli_query($conn,"ALTER TABLE ".$prefix." ADD ".$col_name." ". $column_attr );
											  echo $col_name.' added </br>';			
										  }
										  else
										  {
											  echo $col_name.' already exists! </br>';
										  }
										 

										 
	$filetoresult=ltrim($my_tables_use).'_resources.visit_documents';
	$sql1 =mysqli_query($conn, "ALTER TABLE $filetoresult MODIFY file_path LONGTEXT NOT NULL ");	

 
$prefix=ltrim($my_tables_use).'_laboratory.test_results';
										  $col_name = 'test_time';
										  $column_attr = "TIME NOT NULL";
										  $col = mysqli_query($conn,"SELECT ".$col_name." FROM ".$prefix);
										  if (!$col){
											  mysqli_query($conn,"ALTER TABLE ".$prefix." ADD ".$col_name." ". $column_attr );
											  echo $col_name.' added </br>';			
										  }
										  else
										  {
											  echo $col_name.' already exists! </br>';
										  }
	
echo 'done';
?>