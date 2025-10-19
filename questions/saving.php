<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

<?php

include "../../Connections/dbname.php";

function clean($string) {
    // Replace all spaces with double spaces first
    $string = str_replace(' ', '  ', $string);

    // Replace single quotes with backticks and double quotes with double backticks
    $string = str_replace('\'', '`', $string); // Replace ' with `
    $string = str_replace('"', '``', $string); // Replace " with ``

    // Modify the regex to include the tilde in the allowed characters
    $string = preg_replace('/[^A-Za-z0-9\-\~`]/', ' ', $string); // Keeps ~ and ` (backtick) and removes other special chars

    // Replace multiple hyphens with a single space
    return preg_replace('/-+/', ' ', $string); // Replaces multiple hyphens with a space
} 

 
 /////////////////////////        
 
$mark_save='';


 $result_trans90_check= mysqli_query($conn,"DELETE FROM  ".$my_tables_use_check."_resources.patient_details
		WHERE date='".$_SESSION['date']."' AND  user_id='".$_SESSION['user_id']."'");
 
$query_price = "INSERT INTO ".$my_tables_use_check."_resources.patient_details  SET ";
                    if(isset($_SESSION['date'])) { $query_price .= "date = '" .$_SESSION['date']. "', "; }
					if(isset($_SESSION['user_id'])) { $query_price .= "user_id = '" .$_SESSION['user_id']. "', "; }
					 if(isset($_SESSION['first_attack'])) { $query_price .= "first_attack = '" .$_SESSION['first_attack']. "', "; }
					if(isset($_SESSION['frequency_pain'])) { $query_price .= "frequency_pain = '" . clean($_SESSION['frequency_pain']). "', "; }
					if(isset($_SESSION['stool_per_day'])) { $query_price .= "stool_per_day = '" . clean($_SESSION['stool_per_day']). "', "; }
					if(isset($_SESSION['chief_complain'])) { $query_price .= "chief_complain = '" . clean($_SESSION['chief_complain']). "', "; }
					if(isset($_SESSION['other_symptoms'])) { $query_price .= "other_symptoms = '" . clean($_SESSION['other_symptoms']). "', "; }
					if(isset($_SESSION['other_symptoms_others'])) { $query_price .= "other_symptoms_others = '" . clean($_SESSION['other_symptoms_others']). "', "; }
					if(isset($_SESSION['medical_history'])) { $query_price .= "medical_history = '" . clean($_SESSION['medical_history']). "', "; }
					if(isset($_SESSION['any_operation'])) { $query_price .= "any_operation = '" . clean($_SESSION['any_operation']). "', "; }
					if(isset($_SESSION['family_history'])) { $query_price .= "family_history = '" . clean($_SESSION['family_history']). "', "; }
					if(isset($_SESSION['smoker'])) { $query_price .= "smoker = '" . clean($_SESSION['smoker']). "', "; }
					if(isset($_SESSION['pack_per_day'])) { $query_price .= "pack_per_day = '" . clean($_SESSION['pack_per_day']). "', "; }
					if(isset($_SESSION['years_smoking'])) { $query_price .= "years_smoking = '" . clean($_SESSION['years_smoking']). "', "; }
					if(isset($_SESSION['pain_rate'])) { $query_price .= "pain_rate = '" . clean($_SESSION['pain_rate']). "', "; }
					if(isset($_SESSION['general_well'])) { $query_price .= "general_well = '" . clean($_SESSION['general_well']). "', "; }
					if(isset($_SESSION['behavioral_health'])) { $query_price .= "behavioral_health = '" . clean($_SESSION['behavioral_health']). "', "; }
					if(isset($_SESSION['laboratories'])) { $query_price .= "laboratories = '" . clean($_SESSION['laboratories']). "', "; }
					if(isset($_SESSION['files_lab'])) { $query_price .= "lab_files = '" . $_SESSION['files_lab']. "', "; }              
					if(isset($_SESSION['vaccines'])) { $query_price .= "vaccines= '" . clean($_SESSION['vaccines']). "', "; }
					if(isset($_SESSION['files_vac'])) { $query_price .= "vac_files = '" . $_SESSION['files_vac']. "', "; }              
                    if(isset($_SESSION['medications'])) { $query_price .= "medications = '" . clean($_SESSION['medications']). "', "; }
                   	if(isset($_SESSION['files_med'])) { $query_price .= "med_files = '" . $_SESSION['files_med']. "', "; }              
                    if(isset($_SESSION['imaging'])) { $query_price .= "imaging= '" . clean($_SESSION['imaging']). "', "; }
                    if(isset($_SESSION['files_ima'])) { $query_price .= "ima_files = '" . $_SESSION['files_ima']. "', "; }              
					if(isset($_SESSION['imaging_others'])) { $query_price .= "imaging_others= '" . clean($_SESSION['imaging_others']). "', "; }
					if(isset($mark_save)) { $query_price .= "mark_save= '" . $mark_save. "' "; }



//echo $query_price;

$query_price = mysqli_query($db_connection, $query_price);

    





 echo "<script>window.location = 'complete.php'</script>";
?>


