<?php

  $complains='';
                        if(isset($patient_details['chief_complain']) AND $patient_details['chief_complain']!='') {                           
                            $complains.=' '.$patient_details['chief_complain']; 
                        }
                        if(isset($patient_details['other_symptoms']) AND $patient_details['other_symptoms']!='') {                           
                            $complains.=' '.$patient_details['other_symptoms']; 
                        }
                        if(isset($patient_details['other_symptoms_others']) AND $patient_details['other_symptoms_others']!='') {                           
                            $complains.=' '.$patient_details['other_symptoms_others']; 
                        }
                        if(isset($patient_details['medical_history']) AND $patient_details['medical_history']!='') {                           
                            $complains.=' '.$patient_details['medical_history']; 
                        }
                        if(isset($patient_details['behavioral_health'])) {                           
                            $complains.=' '.$patient_details['behavioral_health']; 
                        }
                        if(isset($patient_record['chiefcomplaint']) AND $patient_record['chiefcomplaint']!='') { 
                            $my_nc = ltrim($main_table_use) . '_category.chief_complaint';
                            $result_trans90_check= mysqli_query($db_connection, "SELECT details  
                                 FROM ".$my_nc." 
                                WHERE code='".$patient_record['chiefcomplaint']."' LIMIT 1");            
                            $my_total_records_check=mysqli_num_rows($result_trans90_check);                                                        
                            if ($my_total_records_check>0) {
                                $ryow12aa56 = mysqli_fetch_assoc($result_trans90_check);    
                                $complains.=' '.$ryow12aa56['details']; 
                            }  
                        }
                        if(isset($patient_record['othersymptoms1']) AND $patient_record['othersymptoms1']!='') {                           
                            $complains.=', '.$patient_record['othersymptoms1']; 
                        }
                        if(isset($patient_record['othersymptoms2']) AND $patient_record['othersymptoms2']!='') {                           
                            $complains.=', '.$patient_record['othersymptoms2']; 
                        }
                        if(isset($patient_record['eims1']) AND $patient_record['eims1']!='') {                           
                            $complains.=', '.$patient_record['eims1']; 
                        }
                        if(isset($patient_record['complications']) AND $patient_record['complications']!='') {                           
                            $complains.=' '.$patient_record['complications']; 
                        }


                                foreach ($patient_complaint as $pcc): 
                                    $complains.=' ~ '.$pcc['othersymptoms1'];
                                endforeach; 

                                 foreach ($patient_complications as $pcomp): 
                                    $complains.=' ~ '.$pcomp['complications'];
                                endforeach; 

                                 foreach ($patient_biological as $pcbio): 
                                    $complains.=' ~ '.$pcbio['fistula'];
                                 endforeach; 

                        $complains = str_replace('~', ',', $complains);

                 
                        $complains = rtrim($complains, ' ,');

                         $words = array_map('trim', explode(',', $complains));
                        $uniqueWords = array_unique($words);

                        // Rebuild the string
                        $complains = implode(', ', $uniqueWords);
                                                
                       
                     
                     
                        $notes='';
                        if(isset($patient_details['other_notes'])) {
                            $notes.=$patient_details['other_notes'];
                        }
                        if(isset($patient_record['notes']) AND $patient_record['notes']!='') {
                            $notes.=' '.$patient_record['notes'];
                        }


                        
                        $medication_details='';
                        if(isset($patient_details['medications']) AND $patient_details['medications']!='') {                           
                            $medication_details.=$patient_details['medications']; 
                            $med_ctr=$med_ctr+1;
                        }
                        if(isset($patient_record['management']) AND $patient_record['management']!='') {                           
                            $medication_details.=' '.$patient_record['management']; 
                              $med_ctr=$med_ctr+1;
                        }

                         foreach ($patient_biological as $pcbiom): 
                                   
                                if($pcbiom['biological']!='') {
                                    $medication_details.=' ~ '.$pcbiom['biological'];
                                      $med_ctr=$med_ctr+1;
                                }

                                if($pcbiom['outcome']!='') {
                                    $medication_details.=' ~ '.$pcbiom['outcome'];
                                      $med_ctr=$med_ctr+1;
                                }

                         endforeach; 

                        $medication_details = str_replace('~', ', ', $medication_details);

                        $medication_details = rtrim($medication_details, ' ,');
                         
                      //  $med_ctr= count(explode(',', $medication_details))+count($patient_medication);

                                 $lab_ctr=0;
    
                                 foreach ($test_results as $test):  
                                     $lab_ctr= $lab_ctr+1;
                                 endforeach; 

                                foreach ($patient_documents as $docs): 
                                   $lab_ctr= $lab_ctr+1;
                                endforeach; 

                                if(isset($patient_record['proceduredone']) AND $patient_record['proceduredone']!=''):  
                                    $lab_ctr= $lab_ctr+1;
                                endif; 

                                if(isset($patient_record['hgblevels']) AND ltrim($patient_record['hgblevels'])!=''):  
                                        $lab_ctr= $lab_ctr+1;
                                endif;  