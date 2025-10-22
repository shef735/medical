<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

<?php


$fullname='';
$birthday='';
$gender='';
$age='';
$address='';
$email='';
$contact='';
$height_cm='';
$weight_kg='';
$bmi='';

 $photo='';


$last_name='';
$first_name='';
$middle_name='';
$user_id='';

if(isset($_SESSION['patient_id'])) {
        $user_id=$_SESSION['patient_id'];
}

$result_trans90_check= mysqli_query($conn,"SELECT *  
		FROM  ".$my_tables_use."_resources.patient_info 
		WHERE user_id='$user_id'  LIMIT 1");
	 
				$row_series = mysqli_fetch_assoc($result_trans90_check);			
				$my_total_records_check=mysqli_num_rows($result_trans90_check);
				
				  if ($my_total_records_check>0) {

            $fullname=$row_series['last_name'].', '.$row_series['first_name'];

        $last_name=$row_series['last_name'];
        $first_name=$row_series['first_name'];
        $middle_name=$row_series['middle_name'];

            $birthday=$row_series['birthday'];
            $gender=$row_series['sex'];
            $contact=$row_series['phone'];
              $height_cm=$row_series['height_cm'];

         
            if($row_series['birthday']!='0000-00-00') {
               $age=calculateAge($birthday);
            }

           
            $address=$row_series['address'];
            $email=$row_series['email'];
            $photo=$row_series['photo'];


          }


if($photo=='') {
 $photo='default.png';
}
 
$record_date='';
$dateofdiagnosis='';
$diagnosisyear='';
$diagnosis1='';
$attending='';
$hospital='';

$appendectomy1='';

$contactnumber='';
$smokinghx='';
$smokingpackyears='';
$familyhxofibd='';
$pastmedhxv='';


$ocpuse='';
$chiefcomplaint='';
$othersymptoms1='';
$othersymptoms2='';
$eims1='';
$hepavaccination='';
$hepbvaccination='';
$reactive='';
$hgblevels='';
$typeofanemia='';
$plateletcount='';
$albumin='';
$crplevel='';
$esr='';
$cdifficileinfxn='';
$proceduredone='';
$dateofprocedure='';
$endoscopicfindings='';
$lesion1='';
$lesion2='';
$lesion3='';
$colonoscopicfindings='';
$distribution='';
$diagnosis2='';
$histopathfindings1='';
$histopathfindings2='';
$histopathfindings3='';
$histopathfinding='';
$initialtreatment='';
$duration='';
$dateoffollowup='';
$improvement='';
$additionaltreatment='';
$repeatcolonoscopy='';
$dateofcolonoscopy='';
$mayoscore='';
$frequencyofstools='';
$abdominalpain='';
$generalwellbeing='';
$eims2='';
$montrealextentforuc='';
$severityinuc='';
$locationcd='';
$behaviorcd='';
$complications='';
$surgery='';
$notes='';
 $doctor_notes='';
$management='';
$useofprolongedsteroids='';
$biologics='';
$typeofbiologics ='';
$histopathdetails='';
$lesion='';
$bp='';
$bp_date='';
$bp_time='';

          
$result_trans90_check= mysqli_query($conn,"SELECT *  
		FROM  ".$my_tables_use."_resources.record_weight
		WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
	 
				$row_series = mysqli_fetch_assoc($result_trans90_check);			
				$my_total_records_check=mysqli_num_rows($result_trans90_check);
				
		 if ($my_total_records_check>0) {
              
            $bmi=$row_series['bmi'];
            $weight_kg=$row_series['weight_kg'];

            if((float)$weight_kg>0 and (float)$height_cm>0) {
              $bmi=calculateBMI($weight_kg, $height_cm);
            }
        
          }


$result_trans90_check= mysqli_query($conn,"SELECT *  
		FROM  ".$my_tables_use."_resources.record_bp
		WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
	 
				$row_series = mysqli_fetch_assoc($result_trans90_check);			
				$my_total_records_check=mysqli_num_rows($result_trans90_check);
				
		 if ($my_total_records_check>0) {
              
                        $bp=$row_series['bp'];
                        $bp_date=$row_series['date'];
                        $bp_time=$row_series['bp_time'];

                        $timeString = $bp_time;

                                // Convert to DateTime object
                                $dateTime = DateTime::createFromFormat('H:i', $timeString);

                                // Format to 12-hour format
                          //      $bp_time = $dateTime->format('g:i A'); 
                        
                 }

          $result_trans90_check= mysqli_query($conn,"SELECT *  
		FROM  ".$my_tables_use."_resources.record_diagnosis
		WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
	 
				$row_series = mysqli_fetch_assoc($result_trans90_check);			
				$my_total_records_check=mysqli_num_rows($result_trans90_check);
				
		 if ($my_total_records_check>0) {
         
            $dateofdiagnosis=$row_series['date'];
            $diagnosisyear=$row_series['diagnosisyear'];
            $diagnosis1=$row_series['diagnosis1'];
            $attending=$row_series['attending'];
            $hospital=$row_series['hospital'];

            if(strtoupper($diagnosis1)=='UC') {
                $diagnosis1='Ulcerative Colitis';
            }

               if(strtoupper($diagnosis1)=='CD') {
                $diagnosis1="Crohn's disease";
            }
     
        
          }

    $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
		FROM  ".$my_tables_use."_resources.record_appendect
		WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
	 
				$row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
				$my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
				
		 if ($my_total_records_checkaa>0) {
                      
            $appendectomy1=$row_seriesaa['appendectomy1'];
 
          }


    $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
		FROM  ".$my_tables_use."_resources.record_chief_complaint
		WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
	 
				$row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
				$my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
				
		 if ($my_total_records_checkaa>0) {
                      
            $chiefcomplaint=$row_seriesaa['chiefcomplaint'];
            $othersymptoms1=$row_seriesaa['othersymptoms1'].' '.$row_seriesaa['othersymptoms2'];

            if((float)$chiefcomplaint>0) {
                $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
                    FROM  ".$my_tables_use."_category.chief_complaint 
                    WHERE code='$chiefcomplaint' ORDER BY id DESC LIMIT 1");
                
                            $row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
                            $my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
                            
                    if ($my_total_records_checkaa>0) {
                        $chiefcomplaint=$row_seriesaa['details'];
                    }

            }
 
          }


            $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
		FROM  ".$my_tables_use."_resources.record_eims
		WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
	 
				$row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
				$my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
				
		 if ($my_total_records_checkaa>0) {
                      
            $eims1=$row_seriesaa['eims1'];
            $eims2=$row_seriesaa['eims2'];

           
                $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
                    FROM  ".$my_tables_use."_category.eims
                    WHERE code='$eims1' ORDER BY id DESC LIMIT 1");
                
                            $row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
                            $my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
                            
                    if ($my_total_records_checkaa>0) {
                       $eims1=$row_seriesaa['details'];
                    }

                     $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
                    FROM  ".$my_tables_use."_category.eims
                    WHERE code='$eims2' ORDER BY id DESC LIMIT 1");
                
                            $row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
                            $my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
                            
                    if ($my_total_records_checkaa>0) {
                       $eims2=$row_seriesaa['details'];
                    }

            
 
          }


            $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
		FROM  ".$my_tables_use."_resources.record_hepa
		WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
	 
				$row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
				$my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
				
		 if ($my_total_records_checkaa>0) {
                      
            $hepavaccination=$row_seriesaa['hepavaccination'];
             $hepbvaccination=$row_seriesaa['hepbvaccination'];
 
          }


  $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
		FROM  ".$my_tables_use."_resources.record_blood
		WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
	 
				$row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
				$my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
				
		 if ($my_total_records_checkaa>0) {
                      
          
            $reactive=$row_seriesaa['reactive'];
            $hgblevels=$row_seriesaa['hgblevels'];
            $typeofanemia=$row_seriesaa['typeofanemia'];
            $plateletcount=$row_seriesaa['plateletcount'];
            $albumin=$row_seriesaa['albumin'];
            $crplevel=$row_seriesaa['crplevel'];
            $esr=$row_seriesaa['esr'];
            $cdifficileinfxn=$row_seriesaa['cdifficileinfxn'];
 
            if((float)$typeofanemia>0) {
                $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
                    FROM  ".$my_tables_use."_category.anemia
                    WHERE code='$typeofanemia' ORDER BY id DESC LIMIT 1");
                
                            $row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
                            $my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
                            
                    if ($my_total_records_checkaa>0) {
                        $typeofanemia=$row_seriesaa['details'];
                    }

            }
 
          }



           $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
		FROM  ".$my_tables_use."_resources.record_procedure
		WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
	 
				$row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
				$my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
				
		 if ($my_total_records_checkaa>0) {
                      
           
           $proceduredone=$row_seriesaa['proceduredone'];
           $dateofprocedure=$row_seriesaa['date'];
           $endoscopicfindings=$row_seriesaa['endoscopicfindings'];
           $lesion1=$row_seriesaa['lesion1'];
           $lesion2=$row_seriesaa['lesion2'];
           $lesion3=$row_seriesaa['lesion3'];
           $colonoscopicfindings=$row_seriesaa['colonoscopicfindings'];
           $distribution=$row_seriesaa['distribution'];
            $histopathfindings1=$row_seriesaa['histopathfindings1'];
            $histopathfindings2=$row_seriesaa['histopathfindings2'];
            $histopathfindings3=$row_seriesaa['histopathfindings3'];
            $histopathfinding=$row_seriesaa['histopathfindings3'];

            $histopathdetails=$histopathfindings1;
            
            if($histopathfindings2!='') {
                $histopathdetails.='</br>'.$histopathfindings2;
            }

             if($histopathfindings3!='') {
                $histopathdetails.='</br>'.$histopathfindings3;
            }

             if($histopathfinding!='') {
                $histopathdetails.='</br>'.$histopathfinding;
            }


           $lesion='';
           
 
                $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
                    FROM  ".$my_tables_use."_category.anemia
                    WHERE code='$lesion1' ORDER BY id DESC LIMIT 1");
                
                            $row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
                            $my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
                            
                    if ($my_total_records_checkaa>0) {
                       $lesion.=$row_seriesaa['details'].' ';
                    }

                     $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
                    FROM  ".$my_tables_use."_category.anemia
                    WHERE code='$lesion2' ORDER BY id DESC LIMIT 1");
                
                            $row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
                            $my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
                            
                    if ($my_total_records_checkaa>0) {
                       $lesion.=$row_seriesaa['details'].' ';
                    }

                     $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
                    FROM  ".$my_tables_use."_category.anemia
                    WHERE code='$lesion3' ORDER BY id DESC LIMIT 1");
                
                            $row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
                            $my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
                            
                    if ($my_total_records_checkaa>0) {
                       $lesion.=$row_seriesaa['details'];
                    }

                     $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
                    FROM  ".$my_tables_use."_category.colonoscopic_findings
                    WHERE code='$colonoscopicfindings' ORDER BY id DESC LIMIT 1");
                
                            $row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
                            $my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
                            
                    if ($my_total_records_checkaa>0) {
                       $colonoscopicfindings=$row_seriesaa['details'];
                    }

                      $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
                    FROM  ".$my_tables_use."_category.distribution
                    WHERE code='$distribution' ORDER BY id DESC LIMIT 1");
                
                            $row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
                            $my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
                            
                    if ($my_total_records_checkaa>0) {
                       $distribution=$row_seriesaa['details'];
                    }
 
 
          }



  $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
		FROM  ".$my_tables_use."_resources.record_treatment
		WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
	 
				$row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
				$my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
				
		 if ($my_total_records_checkaa>0) {
                      
          
           
            $initialtreatment=$row_seriesaa['initialtreatment'];
             $duration=$row_seriesaa['duration'];
             $improvement=$row_seriesaa['improvement'];
             $additionaltreatment=$row_seriesaa['additionaltreatment'];

  
                $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
                    FROM  ".$my_tables_use."_category.treatment
                    WHERE code='$initialtreatment' ORDER BY id DESC LIMIT 1");
                
                            $row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
                            $my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
                            
                    if ($my_total_records_checkaa>0) {
                        $initialtreatment=$row_seriesaa['details'];
                    }

                       $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
                    FROM  ".$my_tables_use."_category.treatment
                    WHERE code='$additionaltreatment' ORDER BY id DESC LIMIT 1");
                
                            $row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
                            $my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
                            
                    if ($my_total_records_checkaa>0) {
                        $additionaltreatment=$row_seriesaa['details'];
                    }

            
 
          }

             $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
		FROM  ".$my_tables_use."_resources.record_mayo
		WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
	 
				$row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
				$my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
				
		 if ($my_total_records_checkaa>0) {
                      
        
             $mayoscore=$row_seriesaa['mayoscore'];
 
          }

            $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
		FROM  ".$my_tables_use."_resources.record_general_well
		WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
	 
				$row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
				$my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
				
		 if ($my_total_records_checkaa>0) {

                $frequencyofstools=$row_seriesaa['frequencyofstools'];
                $abdominalpain=$row_seriesaa['abdominalpain'];
                $generalwellbeing=$row_seriesaa['generalwellbeing'];

          }   



  $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
		FROM  ".$my_tables_use."_resources.record_montreal
		WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
	 
				$row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
				$my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
				
		 if ($my_total_records_checkaa>0) {
                                
            $montrealextentforuc=$row_seriesaa['montrealextentforuc'];
           
                $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
                    FROM  ".$my_tables_use."_category.montreal
                    WHERE code='$montrealextentforuc' ORDER BY id DESC LIMIT 1");
                
                            $row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
                            $my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
                            
                    if ($my_total_records_checkaa>0) {
                        $montrealextentforuc=$row_seriesaa['details'];
                    }

           
 
          }



  $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
		FROM  ".$my_tables_use."_resources.record_severity
		WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
	 
				$row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
				$my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
				
		 if ($my_total_records_checkaa>0) {
                                
            $severityinuc=$row_seriesaa['severityinuc'];
           
                $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
                    FROM  ".$my_tables_use."_category.severity
                    WHERE code='$severityinuc' ORDER BY id DESC LIMIT 1");
                
                            $row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
                            $my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
                            
                    if ($my_total_records_checkaa>0) {
                        $severityinuc=$row_seriesaa['details'];
                    }

           
 
          }




  $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
		FROM  ".$my_tables_use."_resources.record_location
		WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
	 
				$row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
				$my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
				
		 if ($my_total_records_checkaa>0) {
                                
            $locationcd=$row_seriesaa['locationcd'];
           
                $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
                    FROM  ".$my_tables_use."_category.location
                    WHERE code='$locationcd' ORDER BY id DESC LIMIT 1");
                
                            $row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
                            $my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
                            
                    if ($my_total_records_checkaa>0) {
                        $locationcd=$row_seriesaa['details'];
                    }

           
 
          }





  $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
		FROM  ".$my_tables_use."_resources.record_behaviour
		WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
	 
				$row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
				$my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
				
		 if ($my_total_records_checkaa>0) {
                                
           $behaviorcd=$row_seriesaa['behaviorcd'];
           
                $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
                    FROM  ".$my_tables_use."_category.behaviour
                    WHERE code='$behaviorcd' ORDER BY id DESC LIMIT 1");
                
                            $row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
                            $my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
                            
                    if ($my_total_records_checkaa>0) {
                        $behaviorcd=$row_seriesaa['details'];
                    }

           
 
          }




  $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
		FROM  ".$my_tables_use."_resources.record_complications
		WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
	 
				$row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
				$my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
				
		 if ($my_total_records_checkaa>0) {
                                
         $complications=$row_seriesaa['complications'];
           
                $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
                    FROM  ".$my_tables_use."_category.complications
                    WHERE code='$complications' ORDER BY id DESC LIMIT 1");
                
                            $row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
                            $my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
                            
                    if ($my_total_records_checkaa>0) {
                       $complications=$row_seriesaa['details'];
                    }

           
 
          }



    $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
		FROM  ".$my_tables_use."_resources.record_surgical
		WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
	 
				$row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
				$my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
				
		 if ($my_total_records_checkaa>0) {
                      
            $surgery=$row_seriesaa['surgery'];
 
          }


            $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
		FROM  ".$my_tables_use."_resources.record_notes
		WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
	 
				$row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
				$my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
				
		 if ($my_total_records_checkaa>0) {
                      
            $notes=$row_seriesaa['notes'];
             $doctor_notes=$row_seriesaa['doctor_notes'];
 
          }


                 $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
		FROM  ".$my_tables_use."_resources.record_management
		WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
	 
				$row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
				$my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
				
		 if ($my_total_records_checkaa>0) {
                      
           $management=$row_seriesaa['management'];
          $useofprolongedsteroids=$row_seriesaa['useofprolongedsteroids'];
 
          }

                $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
		FROM  ".$my_tables_use."_resources.record_biologics
		WHERE user_id='$user_id' ORDER BY id DESC LIMIT 1");
	 
				$row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
				$my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
				
		 if ($my_total_records_checkaa>0) {
                      
           $biologics=$row_seriesaa['typeofbiologics'];
       
 
          }
          
          



?>