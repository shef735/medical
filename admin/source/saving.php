<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

<?php



include "../../../Connections/dbname.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$presentdate=date('Y-m-d');
$fullname='';
$last_name=$_POST['last_name'];
$first_name=$_POST['first_name'];
$middle_name=$_POST['middle_name'];
$birthday=$_POST['birthday'];
$gender=$_POST['gender'];
 
$address=$_POST['address'];
$email=$_POST['email'];
$contact=$_POST['contact'];
$height_cm=$_POST['height_cm'];
$weight_kg=$_POST['weight_kg'];
$bmi=$_POST['bmi'];

 $condition='';


$xcommand="INSERT INTO ";

    if(isset($_SESSION['edit_click']) AND $_SESSION['edit_click']=='Y') {
                 $user_id=$_SESSION['patient_id'];
                $condition="WHERE user_id='".$user_id."' LIMIT 1";

                $xcommand="UPDATE ";
              
          }



 if(isset($_SESSION['add_click']) AND $_SESSION['add_click']=='Y') {
           $my_series_search='10001';
                                                
                                            
                                    do {
                                        $page_reference_code='0';
                                        $branch_save='MH';
                                            
                                        $my_reference=$branch_save.'-'.$page_reference_code.(string)$my_series_search;
                                            
                                        $result_trans90= mysqli_query($db_connection,"SELECT user_id 
                                        FROM ".$main_table_use."_resources.patient_info
                                            WHERE user_id='$my_reference' LIMIT 1");					
                                            $my_total_records_series=mysqli_num_rows($result_trans90);
                                            
                                            if ($my_total_records_series>0) {
                                                    
                                                        $my_series_search=(float)$my_series_search+1;		
                                                                
                                            }
                                            else
                                            {
                                                    break;
                                            }

                                    } while (true);

                                     $user_id= $my_reference;
                                   $_SESSION['patient_id']=$user_id;

 }


unset($_SESSION['edit_click']);
unset($_SESSION['add_click']);


 



$query_price = $xcommand." ".$my_tables_use_check."_resources.patient_info SET ";
                     if(isset($user_id)) { $query_price .= "user_id= '" .$user_id. "', "; }
                    if(isset($last_name)) { $query_price .= "last_name= '" .$last_name. "', "; }
					if(isset($first_name)) { $query_price .= "first_name = '" .$first_name. "', "; }
					 if(isset($middle_name)) { $query_price .= "middle_name = '" .$middle_name. "', "; }
					if(isset($birthday)) { $query_price .= "birthday = '" . $birthday. "', "; }
					if(isset($gender)) { $query_price .= "sex = '" . $gender. "', "; }
					if(isset($address)) { $query_price .= "address = '" . $address. "', "; }
					if(isset($email)) { $query_price .= "email = '" . $email. "', "; }
					if(isset($contact)) { $query_price .= "phone = '" . $contact. "', "; }
					if(isset($height_cm)) { $query_price .= "height_cm = '" . $height_cm. "', "; }
					if(isset($weight_kg)) { $query_price .= "weight_kg = '" .$weight_kg. "', "; }
					if(isset($bmi)) { $query_price .= "bmi = '" . $bmi. "' "; }
$query_price.=$condition;        

 	
$query_price = mysqli_query($db_connection, $query_price);


 
$record_date='';
$dateofdiagnosis=$presentdate;
$diagnosisyear=$_POST['diagnosisyear'];
$diagnosis1=$_POST['diagnosis1'];
$attending=$_POST['attending'];
$hospital=$_POST['hospital'];

$appendectomy1=$_POST['appendectomy1'];

 
$smokinghx='';
$smokingpackyears='';
$familyhxofibd='';
$pastmedhxv='';


$ocpuse=$_POST['ocpuse'];
$chiefcomplaint=$_POST['chiefcomplaint'];
$othersymptoms1=$_POST['othersymptoms1'];
$othersymptoms2='';
$eims1=$_POST['eims1'];
$hepavaccination=$_POST['hepavaccination'];
$hepbvaccination=$_POST['hepbvaccination'];
$reactive=$_POST['reactive'];
$hgblevels=$_POST['hgblevels'];
$typeofanemia=$_POST['typeofanemia'];
$plateletcount=$_POST['plateletcount'];
$albumin=$_POST['albumin'];
$crplevel=$_POST['crplevel'];
$esr=$_POST['esr'];
$cdifficileinfxn=$_POST['cdifficileinfxn'];
$proceduredone=$_POST['proceduredone'];
$dateofprocedure=$_POST['dateofprocedure'];
$endoscopicfindings=$_POST['endoscopicfindings'];
$lesion1=$_POST['lesion'];
$lesion2=$_POST['lesion'];
$lesion3=$_POST['lesion'];
$colonoscopicfindings=$_POST['colonoscopicfindings'];
$distribution=$_POST['distribution'];
$diagnosis2=$_POST['diagnosis1'];
$histopathfindings1=$_POST['histopathdetails'];
$histopathfindings2='';
$histopathfindings3='';
$histopathfinding='';
$initialtreatment=$_POST['initialtreatment'];
$duration=$_POST['duration'];
$dateoffollowup='';
$improvement=$_POST['improvement'];
$additionaltreatment=$_POST['additionaltreatment'];
$repeatcolonoscopy='';
$dateofcolonoscopy='';
$mayoscore=$_POST['mayoscore'];
$frequencyofstools=$_POST['frequencyofstools'];
$abdominalpain=$_POST['abdominalpain'];
$generalwellbeing=$_POST['generalwellbeing'];
$eims2='';
$montrealextentforuc=$_POST['montrealextentforuc'];
$severityinuc=$_POST['severityinuc'];
$locationcd=$_POST['locationcd'];
$behaviorcd=$_POST['behaviorcd'];
$complications=$_POST['complications'];
$surgery=$_POST['surgery'];
$notes=$_POST['notes'];
 $doctor_notes=$_POST['doctor_notes'];
$management=$_POST['management'];
$useofprolongedsteroids=$_POST['useofprolongedsteroids'];
$biologics=$_POST['biologics'];
$typeofbiologics ='';
$histopathdetails=$_POST['histopathdetails'];
$lesion=$_POST['lesion'];
$bp=$_POST['bp'];
$bp_date='';
$bp_time='';


$xcommand="INSERT INTO ";
$condition='';

$query_price = $xcommand." ".$my_tables_use_check."_resources.record_weight SET ";
                if(isset($user_id)) { $query_price .= "user_id= '" .$user_id. "', "; }
                if(isset($presentdate)) { $query_price .= "date= '" .$presentdate. "', "; }
                    if(isset($bmi)) { $query_price .= "bmi= '" .$bmi. "', "; }
					if(isset($weight_kg)) { $query_price .= "weight_kg = '" .$weight_kg. "' "; }			 
$query_price.=$condition;              	
$query_price = mysqli_query($db_connection, $query_price);
          
if($bp=='') {
}
else
{
      $query_price = $xcommand." ".$my_tables_use_check."_resources.record_bp SET ";
                      if(isset($user_id)) { $query_price .= "user_id= '" .$user_id. "', "; }
                        if(isset($presentdate)) { $query_price .= "date= '" .$presentdate. "', "; }               
                          if(isset($bp)) { $query_price .= "bp= '" .$bp. "' "; }			 		 
      $query_price.=$condition;              	
      $query_price = mysqli_query($db_connection, $query_price);
}

if($diagnosis1=='') {
}
else
{
    $query_price = $xcommand." ".$my_tables_use_check."_resources.record_diagnosis SET ";
                  if(isset($user_id)) { $query_price .= "user_id= '" .$user_id. "', "; }
                    if(isset($dateofdiagnosis)) { $query_price .= "date= '" .$dateofdiagnosis. "', "; }
                    if(isset( $diagnosisyear)) { $query_price .= "diagnosisyear= '" . $diagnosisyear. "', "; }	
                    if(isset($diagnosis1)) { $query_price .= "diagnosis1= '" .$diagnosis1. "', "; }	
                    if(isset($attending)) { $query_price .= "attending= '" .$attending. "', "; }	
                    if(isset($hospital)) { $query_price .= "hospital= '" .$hospital. "' "; }		 		 
    $query_price.=$condition;              	
    $query_price = mysqli_query($db_connection, $query_price);
}


if($appendectomy1=='') {
}
else
{
   $query_price = $xcommand." ".$my_tables_use_check."_resources.record_appendect SET ";
                 if(isset($user_id)) { $query_price .= "user_id= '" .$user_id. "', "; }
                if(isset($presentdate)) { $query_price .= "date= '" .$presentdate. "', "; } 
                if(isset( $appendectomy1)) { $query_price .= "appendectomy1 ='" . $appendectomy1. "' "; }	
             		 		 
$query_price.=$condition;              	
$query_price = mysqli_query($db_connection, $query_price);
}


if($chiefcomplaint=='' AND $othersymptoms1=='') {
}
else
{
 $query_price = $xcommand." ".$my_tables_use_check."_resources.record_chief_complaint SET ";
                 if(isset($user_id)) { $query_price .= "user_id= '" .$user_id. "', "; }
                if(isset($presentdate)) { $query_price .= "date= '" .$presentdate. "', "; } 
                if(isset( $chiefcomplaint)) { $query_price .= " chiefcomplaint= '" . $chiefcomplaint. "', "; }	
             	  if(isset($othersymptoms1)) { $query_price .= "othersymptoms1 ='" .$othersymptoms1. "' "; }

$query_price.=$condition;              	
$query_price = mysqli_query($db_connection, $query_price);
}

if($eims1=='' AND $eims2=='') {
}
else
{
  $query_price = $xcommand." ".$my_tables_use_check."_resources.record_eims SET ";
                 if(isset($user_id)) { $query_price .= "user_id= '" .$user_id. "', "; }
                if(isset($presentdate)) { $query_price .= "date= '" .$presentdate. "', "; } 
                if(isset($eims1)) { $query_price .= "eims1='" . $eims1. "', "; }	
             	  if(isset($eims2)) { $query_price .= "eims2= '" .$eims2. "' "; }
$query_price.=$condition;              	
$query_price = mysqli_query($db_connection, $query_price); 
}


if($hepavaccination=='' AND $hepbvaccination=='') {
}
else
{
  $query_price = $xcommand." ".$my_tables_use_check."_resources.record_hepa SET ";
                 if(isset($user_id)) { $query_price .= "user_id= '" .$user_id. "', "; }
                if(isset($presentdate)) { $query_price .= "date= '" .$presentdate. "', "; } 
                 if(isset($hepbvaccination)) { $query_price .= "hepbvaccination ='" .$hepbvaccination. "', "; }

              	  if(isset($hepavaccination)) { $query_price .= "hepavaccination ='" .$hepavaccination. "' "; }
$query_price.=$condition;              	
$query_price = mysqli_query($db_connection, $query_price); 
}      


if($reactive=='' AND $hgblevels=='' AND  $typeofanemia=='' AND $plateletcount=='' AND 
    $albumin=='' AND $crplevel=='' AND $esr=='' AND $cdifficileinfxn=='') {
}
else
{
   $query_price = $xcommand." ".$my_tables_use_check."_resources.record_blood SET ";
                 if(isset($user_id)) { $query_price .= "user_id= '" .$user_id. "', "; }
                if(isset($presentdate)) { $query_price .= "date= '" .$presentdate. "', "; } 
                if(isset($reactive)) { $query_price .= "reactive='" .$reactive. "', "; }	
             	if(isset($hgblevels)) { $query_price .= "hgblevels ='" .$hgblevels. "', "; }
                if(isset($typeofanemia)) { $query_price .= "typeofanemia ='" .$typeofanemia. "', "; }
                if(isset($plateletcount)) { $query_price .= "plateletcount= '" .$plateletcount. "', "; }
                if(isset($albumin)) { $query_price .= "albumin ='" .$albumin. "', "; }
                if(isset($crplevel)) { $query_price .= "crplevel ='" .$crplevel. "', "; }
                if(isset($esr)) { $query_price .= "esr='" .$esr. "', "; }
                 if(isset($cdifficileinfxn)) { $query_price .= "cdifficileinfxn='" .$cdifficileinfxn. "' "; }               
$query_price.=$condition;              	
$query_price = mysqli_query($db_connection, $query_price); 
}

if($proceduredone=='' AND $endoscopicfindings=='' AND $lesion=='' AND $colonoscopicfindings=='' AND
    $histopathdetails=='' AND $histopathfinding=='' AND $distribution=='') {
}
else
{
   $query_price = $xcommand." ".$my_tables_use_check."_resources.record_procedure SET ";
                 if(isset($user_id)) { $query_price .= "user_id= '" .$user_id. "', "; }
                if(isset($dateofprocedure)) { $query_price .= "date= '" .$dateofprocedure. "', "; } 
                if(isset($proceduredone)) { $query_price .= "proceduredone='" .$proceduredone. "', "; }	
             	if(isset($endoscopicfindings)) { $query_price .= "endoscopicfindings= '" .$endoscopicfindings. "', "; }
                if(isset($lesion)) { $query_price .= "lesion1= '" .$lesion. "', "; }
           
                if(isset($colonoscopicfindings)) { $query_price .= "colonoscopicfindings= '" .$colonoscopicfindings. "', "; }
                  if(isset($histopathdetails)) { $query_price .= "histopathfindings1='" .$histopathdetails. "', "; }      

                
               if(isset($histopathfinding)) { $query_price .= "histopathfinding='" .$histopathfinding. "', "; }               
                   if(isset($distribution)) { $query_price .= "distribution='" .$distribution. "' "; }   

$query_price.=$condition;              	
$query_price = mysqli_query($db_connection, $query_price); 
}
        
if($initialtreatment=='' AND $duration=='' AND $improvement=='' AND $additionaltreatment=='') {
}
else {
  $query_price = $xcommand." ".$my_tables_use_check."_resources.record_treatment SET ";
                 if(isset($user_id)) { $query_price .= "user_id= '" .$user_id. "', "; }
                if(isset($presentdate)) { $query_price .= "date= '" .$presentdate. "', "; } 
                if(isset($initialtreatment)) { $query_price .= "initialtreatment='" .$initialtreatment. "', "; }	
             	if(isset($duration)) { $query_price .= "duration= '" .$duration. "', "; }
                if(isset($improvement)) { $query_price .= "improvement= '" .$improvement. "', "; }
                if(isset($additionaltreatment)) { $query_price .= "additionaltreatment ='" .$additionaltreatment. "' "; }
                
$query_price.=$condition;              	
$query_price = mysqli_query($db_connection, $query_price); 
}


if($mayoscore!='') {
  $query_price = $xcommand." ".$my_tables_use_check."_resources.record_mayo SET ";
                 if(isset($user_id)) { $query_price .= "user_id= '" .$user_id. "', "; }
                if(isset($presentdate)) { $query_price .= "date= '" .$presentdate. "', "; } 
                if(isset($mayoscore)) { $query_price .= "mayoscore='" .$mayoscore. "' "; }	
              
$query_price.=$condition;              	
$query_price = mysqli_query($db_connection, $query_price); 
}

 if($frequencyofstools=='' AND $abdominalpain=='' AND $generalwellbeing=='') {
 }
 else
 {
   $query_price = $xcommand." ".$my_tables_use_check."_resources.record_general_well SET ";
                 if(isset($user_id)) { $query_price .= "user_id= '" .$user_id. "', "; }
                if(isset($presentdate)) { $query_price .= "date= '" .$presentdate. "', "; } 
                if(isset($frequencyofstools)) { $query_price .= "frequencyofstools= '" .$frequencyofstools. "', "; }
                if(isset($abdominalpain)) { $query_price .= "abdominalpain= '" .$abdominalpain. "', "; }	
                  if(isset($generalwellbeing)) { $query_price .= "generalwellbeing = '" .$generalwellbeing. "' "; }	
              
$query_price.=$condition;              	
$query_price = mysqli_query($db_connection, $query_price); 
 }

 if($montrealextentforuc!='') {         
   $query_price = $xcommand." ".$my_tables_use_check."_resources.record_montreal SET ";
                 if(isset($user_id)) { $query_price .= "user_id= '" .$user_id. "', "; }
                if(isset($presentdate)) { $query_price .= "date= '" .$presentdate. "', "; } 
                if(isset( $montrealextentforuc)) { $query_price .= "montrealextentforuc='" .$montrealextentforuc. "' "; }
             
$query_price.=$condition;              	
$query_price = mysqli_query($db_connection, $query_price); 
 }
 
 if($severityinuc!='') {
   $query_price = $xcommand." ".$my_tables_use_check."_resources.record_severity SET ";
                 if(isset($user_id)) { $query_price .= "user_id= '" .$user_id. "', "; }
                if(isset($presentdate)) { $query_price .= "date= '" .$presentdate. "', "; } 
                if(isset($severityinuc)) { $query_price .= "severityinuc='" .$severityinuc. "' "; }
             
$query_price.=$condition;              	
$query_price = mysqli_query($db_connection, $query_price); 
 }

if($locationcd!='') {
    $query_price = $xcommand." ".$my_tables_use_check."_resources.record_location SET ";
                 if(isset($user_id)) { $query_price .= "user_id= '" .$user_id. "', "; }
                if(isset($presentdate)) { $query_price .= "date= '" .$presentdate. "', "; } 
                if(isset( $locationcd)) { $query_price .= "locationcd='" . $locationcd. "' "; }
             
$query_price.=$condition;              	
$query_price = mysqli_query($db_connection, $query_price); 
}



  if($behaviorcd!='') {
    $query_price = $xcommand." ".$my_tables_use_check."_resources.record_behaviour SET ";
                 if(isset($user_id)) { $query_price .= "user_id= '" .$user_id. "', "; }
                if(isset($presentdate)) { $query_price .= "date= '" .$presentdate. "', "; } 
                if(isset($behaviorcd)) { $query_price .= "behaviorcd='" .$behaviorcd. "' "; }
             
$query_price.=$condition;              	
$query_price = mysqli_query($db_connection, $query_price); 
  }

  if($complications!='') {
   $query_price = $xcommand." ".$my_tables_use_check."_resources.record_complications SET ";
                 if(isset($user_id)) { $query_price .= "user_id= '" .$user_id. "', "; }
                if(isset($presentdate)) { $query_price .= "date= '" .$presentdate. "', "; } 
                if(isset($complications)) { $query_price .= "complications='" .$complications. "' "; }
             
$query_price.=$condition;              	
$query_price = mysqli_query($db_connection, $query_price); 
  }


if($surgery!='') {
      $query_price = $xcommand." ".$my_tables_use_check."_resources.record_surgical SET ";
                 if(isset($user_id)) { $query_price .= "user_id= '" .$user_id. "', "; }
                if(isset($presentdate)) { $query_price .= "date= '" .$presentdate. "', "; } 
                if(isset($surgery)) { $query_price .= "surgery='" .$surgery. "' "; }
             
$query_price.=$condition;              	
$query_price = mysqli_query($db_connection, $query_price); 
}

if($notes=='' AND $doctor_notes=='') {
     $query_price = $xcommand." ".$my_tables_use_check."_resources.record_notes SET ";
                 if(isset($user_id)) { $query_price .= "user_id= '" .$user_id. "', "; }
                if(isset($presentdate)) { $query_price .= "date= '" .$presentdate. "', "; } 
                if(isset($notes)) { $query_price .= "notes='" .$notes. "', "; }
              if(isset($doctor_notes)) { $query_price .= "doctor_notes='" .$doctor_notes. "' "; }
$query_price.=$condition;              	
$query_price = mysqli_query($db_connection, $query_price); 
}
 
if($management=='' AND $useofprolongedsteroids=='') {
     $query_price = $xcommand." ".$my_tables_use_check."_resources.record_management SET ";
                 if(isset($user_id)) { $query_price .= "user_id= '" .$user_id. "', "; }
                if(isset($presentdate)) { $query_price .= "date= '" .$presentdate. "', "; } 
                if(isset($management)) { $query_price .= "management='" .$management. "', "; }
              if(isset($useofprolongedsteroids)) { $query_price .= "useofprolongedsteroids='" .$useofprolongedsteroids. "' "; }
$query_price.=$condition;              	
$query_price = mysqli_query($db_connection, $query_price); 
}

if($biologics!='') {
    $query_price = $xcommand." ".$my_tables_use_check."_resources.record_biologics SET ";
                 if(isset($user_id)) { $query_price .= "user_id= '" .$user_id. "', "; }
                if(isset($presentdate)) { $query_price .= "date= '" .$presentdate. "', "; } 
                if(isset($biologics)) { $query_price .= "typeofbiologics='" .$biologics. "' "; }
 $query_price.=$condition;              	
$query_price = mysqli_query($db_connection, $query_price); 
}

  echo "<script>window.location = 'complete.php'</script>";           


?>