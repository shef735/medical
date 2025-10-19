<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">
    <meta name="keywords" content="admin template, html 5 admin template , medixo admin , dashboard template, bootstrap 5 admin template, responsive admin template">
    <title><?php echo $_SESSION['system_name'] ?></title>
    <!-- shortcut icon-->
    <link rel="shortcut icon" href="../assets/images/logo/icon-logo.png" type="image/x-icon">
    <!-- Fonts css-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <!-- Font awesome -->
    <link href="../assets/css/vendor/font-awesome.css" rel="stylesheet">
    <link href="../assets/css/vendor/themify-icons.css" rel="stylesheet">
    <link href="../assets/css/vendor/icoicon.css" rel="stylesheet">
    <!-- Scrollbar-->
    <link href="../assets/css/vendor/simplebar.css" rel="stylesheet">
    <!-- Bootstrap css-->
    <link href="../assets/css/vendor/bootstrap.css" rel="stylesheet">
    <!-- Custom css-->
    <link href="../assets/css/style.css" rel="stylesheet">

 
 <style>
        .gray-text {
            color: gray;
        }
    </style>
 
    <?php 

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include "../../../Connections/dbname.php";
include "includes/header.php"; 

function calculateAge($birthdate) {
    // Convert the birthdate string to a DateTime object
    $birthDate = new DateTime($birthdate);
    $today = new DateTime('today');
    
    // Calculate the age
    $age = $birthDate->diff($today)->y;

    return $age;
}

function calculateBMI($weight, $heightInCM) {
    // Convert height from cm to meters
    $heightInMeters = $heightInCM / 100;

    // Calculate BMI
    if ($heightInMeters > 0) {
        $bmi = $weight / ($heightInMeters * $heightInMeters);
        return round($bmi, 2); // Round to 2 decimal places
    } else {
        return "Height must be greater than 0.";
    }
}


?>
  </head>
  <body>
       <?php include "includes/sidebar.php"; 
 if(isset($_SESSION['patient_id'])) {       
  include "includes/get-data.php"; 
 }
         $readonly="readonly";
        $disabled="disabled";
 
          if(isset($_SESSION['edit_click']) AND $_SESSION['edit_click']=='Y') {
                $readonly="";
                $disabled="";
                
          }


           if(isset($_SESSION['add_click']) AND $_SESSION['add_click']=='Y') {

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


                $readonly="";
                $disabled="";
          }
            

        ?>
      <!-- Header End-->
  <form method="post" action="saving.php">
    <div class="themebody-wrap">
      <!-- breadcrumb start-->
        <div class="codex-breadcrumb">
          <div class="container-fluid">
            <div class="breadcrumb-contain">
              <div class="left-breadcrumb">
                <ul class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="index.html">
                      <h1>Dashboard</h1></a></li>
                  <li class="breadcrumb-item"><a href="javascript:void(0);">application</a></li>
                  <li class="breadcrumb-item active"><a href="javascript:void(0);">profile</a></li>
                </ul>
              </div>
              <div class="right-breadcrumb">
                <ul>
                  <li>
                    <div class="bread-wrap"><i class="fa fa-clock-o"></i></div><span class="liveTime"></span>
                  </li>
                  <li>
                    <div class="bread-wrap"><i class="fa fa-calendar"></i></div><span class="getDate"></span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      <!-- breadcrumb end-->
      <!-- theme body start-->
      <div class="theme-body">
        <div class="container-fluid cdxuser-profile">
          <div class="row">      
            <div class="col-xxl-12 col-xl-12">
              <div class="row">

               <!--    <div class="card doctor-probox"> 

                  
                                   
                   <div class="img-wrap"></div>
                    
                     <div class="card-body pt-0">

                    
                          <div class="profile-head">
                            <div class="proimg-wrap">
                              <img class="img-fluid"  src="../../patient-form/uploads/<?php echo $photo ?>" alt="">
                            </div>
                            <h4><?php echo $fullname ?></h4><span><?php echo $age ?> years old </br><?php echo $address ?></span>

                          </div>
                      
                    </div> 

                   </div> -->


            <div class="col-xxl-6 col-md-6">

              <div class="card">
                <div class="card-header">
                  <h4>Personal Information</h4>
                </div>

                <div class="card-body">
                      <ul class="contact-list">

                      
                            <li> <span>Last Name:</span>
                              <input  class="form-control"  style="width: 80%;" <?php echo $readonly ?> type="text" id="last_name" name="last_name" 
                              value="<?php echo $last_name ?>"> </li>        

                                  <li> <span>First Name:</span>
                              <input  class="form-control"  style="width: 80%;" <?php echo $readonly ?> type="text" id="first_name" name="first_name" 
                              value="<?php echo $first_name ?>"> </li>           

                                <li> <span>Middle Name:</span>
                              <input  class="form-control"  style="width: 80%;" <?php echo $readonly ?> type="text" id="middle_name" name="middle_name" 
                              value="<?php echo $middle_name ?>"> </li>   

                          <li> <span>Date of birth:</span>
                              <input  class="form-control"  style="width: 80%;" <?php echo $readonly ?> type="date" id="birthday" name="birthday" 
                              value="<?php echo $birthday ?>"> </li>
                      
                          <li> <span>Gender:</span>
                              
                                <select <?php echo $disabled ?> class="form-control" style="width: 80%;" name="gender" id="gender">
                                      <option value="<?php echo $gender ?>"><?php echo $gender ?></option>
                                      <option value="MALE">MALE</option>
                                      <option value="FEMALE">FEMALE</option>                  
                                    </select>
                        
                          </li>
                            <li> <span>Address:</span>
                                  <textarea class="form-control"  style="width: 80%;" <?php echo $readonly ?> 
                                      id="address" name="address" rows="3"><?php echo $address ?></textarea>
                            </li>
                        
                          

                                              
                                            
                                              
                      </ul>
                </div> 
              </div>   
            </div>

        
            <div class="col-xxl-6 col-md-6"  >
              <!--  <img class="img-fluid" style="border-radius: 50px; height:90%;" src="../../patient-form/uploads/<?php echo $photo ?>" alt="">  -->
                <div class="card">
                <div class="card-header">
                  
                </div>

                <div class="card-body">
                    <ul class="contact-list">
                    <li> <span>Age:</span>
                                
                                <input  class="form-control"  style="width: 80%;" <?php echo $readonly ?> 
                                type="text" id="age" name="age" 
                                value="<?php echo $age ?>"> 
                            
                            
                            </li>

                      <li> <span>Contact No.:</span>
                                
                                <input  class="form-control"  style="width: 80%;" <?php echo $readonly ?> 
                                type="text" id="contact" name="contact" 
                                value="<?php echo $contact ?>"> 
                            
                            
                            </li>
                            <li> <span>Email:</span>
                            
                              <input  class="form-control"  style="width: 80%;" <?php echo $readonly ?> 
                                type="text" id="email" name="email" 
                                value="<?php echo $email ?>"> 
                            
                            
                            </li>

                        
                          <li> <span>Weight (KG):</span>
                            
                            <input  class="form-control"  style="width: 80%;" <?php echo $readonly ?> 
                                type="text" id="weight_kg" name="weight_kg" 
                                value="<?php echo $weight_kg ?>"> 
                            
                            </li>
                                                  
                        <li> <span>Height: (CM)</span>
                          
                          <input  class="form-control"  style="width: 80%;" <?php echo $readonly ?> 
                                type="text" id="height_cm" name="height_cm" 
                                value="<?php echo $height_cm ?>"> 
                        
                        </li>
                                                
                          <li> <span>BMI:</span>
                              
                            <input  class="form-control"  style="width: 80%;" <?php echo $readonly ?> 
                                type="text" id="bmi" name="bmi" 
                                value="<?php echo $bmi ?>"> 
                          
                          </li>
                                              
                          <li> <span>Blood Pressure:</span>
                          <input  class="form-control"  style="width: 80%;" <?php echo $readonly ?> 
                                type="text" id="bp" name="bp" 
                                value="<?php echo $bp ?>"> 
                          
                          </li>
                                              
                        <li></li>
                    </ul>
                </div>

            </div>

            <div class="col-xxl-12 col-md-6">

                    
                    <div class="card doctor-probox"> 

                      
                                      
                    <!-- <div class="img-wrap"></div>
                        
                        <div class="card-body pt-0">

                        
                              <div class="profile-head">
                                <div class="proimg-wrap">
                                  <img class="img-fluid"  src="../../patient-form/uploads/<?php echo $photo ?>" alt="">
                                </div>
                                <h4><?php echo $fullname ?></h4><span><?php echo $age ?> years old <?php echo $address ?></span>

                              </div>
                          
                        </div> 

                        
                        <ul class="docactivity-list">
                          <li>
                            <h4><?php echo $weight_kg ?>kg</h4><span>Weight</span>
                          </li>
                          <li>
                            <h4><?php echo $height_cm ?>cm</h4><span>Height</span>
                          </li>
                          <li>
                            <h4><?php echo $bmi; ?></h4><span>BMI</span>
                          </li>

                            <li>
                            <h4>  <?php echo $bp ?></h4><span>Blood Pressure</span>
                          </li>
                        </ul>   -->
                      </div>
                    </div>

    

                  <!--   <div class="col-xxl-12 col-lg-8">
                      <div class="card patientreport-card">
                        <div class="card-header border-0">     
                          <div>
                            <h4>Blood pressure</h4><span><?php echo $bp_date.' / '.$bp_time ?></span>
                          </div>
                          <div class="report-count">
                            <h3 class="text-primary">
                                <?php echo $bp ?>
                              
                              </h3><span></span>
                          </div>
                        </div>
                            <div class="card-body p-0">
                          <div id="bloodpreport"></div>
                        </div>  
                      </div>
                    </div> -->

                  <!--   <div class="col-xxl-12 col-lg-8">
                      <div class="card patientreport-card">
                        <div class="card-header border-0">     
                          <div>
                            <h4>Heart Rate</h4><span>Above the normal</span>
                          </div>
                          <div class="report-count">
                            <h3 class="text-secondary">99</h3><span>Per min</span>
                          </div>
                        </div>
                        <div class="card-body p-0">
                          <div id="heartrate"></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-xxl-12 col-lg-8">
                      <div class="card patientreport-card">
                        <div class="card-header border-0">     
                          <div>
                            <h4>Glucose Rate</h4><span>In the normal</span>
                          </div>
                          <div class="report-count">
                            <h3 class="text-success">97</h3><span>mg/dl</span>
                          </div>
                        </div>
                        <div class="card-body p-0">
                          <div id="glucoserate"></div>
                        </div>
                      </div>
                    </div>
                    <div class="col-xxl-12 col-lg-8">
                      <div class="card patientreport-card">
                        <div class="card-header border-0">     
                          <div>
                            <h4>Clolesterol</h4><span>In the normal</span>
                          </div>
                          <div class="report-count">
                            <h3 class="text-warning">124</h3><span>mg/dl</span>
                          </div>
                        </div>
                        <div class="card-body p-0">
                          <div id="clolesterol"></div>
                        </div>
                      </div>
                    </div> -->



              

                    <!--<div class="col-xxl-12 col-lg-8">
                      <div class="card">
                        <div class="card-header">
                          <h4>Notifications</h4>
                        </div>
                        <div class="card-body">
                          <ul class="docnoti-list">
                            <li>
                              <div class="media"><img class="rounded-50 w-40" src="../assets/images/avtar/1.jpg" alt="">
                                <div class="media-body">
                                  <h6>Dr. Anna  Send you Photo</h6><span class="text-light">10, Feb ,2023</span>
                                </div>
                                <div class="badge badge-primary">10:15 Pm</div>
                              </div>
                            </li>
                            <li>
                              <div class="media"><img class="rounded-50 w-40" src="../assets/images/avtar/2.jpg" alt="">
                                <div class="media-body">
                                  <h6>Dr. Anna  Send you Photo</h6><span class="text-light">05, March ,2023</span>
                                </div>
                                <div class="badge badge-primary">09:20 Pm</div>
                              </div>
                            </li>
                            <li>
                              <div class="media"><img class="rounded-50 w-40" src="../assets/images/avtar/3.jpg" alt="">
                                <div class="media-body">
                                  <h6>Dr. Anna  Send you Photo</h6><span class="text-light">01, Jan ,2023</span>
                                </div>
                                <div class="badge badge-primary">03:40 Pm</div>
                              </div>
                            </li>
                            <li>
                              <div class="media"><img class="rounded-50 w-40" src="../assets/images/avtar/4.jpg" alt="">
                                <div class="media-body">
                                  <h6>Dr. Anna  Send you Photo</h6><span class="text-light">25, Feb ,2023</span>
                                </div>
                                <div class="badge badge-primary">05:26 Am                   </div>
                              </div>
                            </li>
                          </ul>
                        </div>
                        <div class="card-footer"><a class="btn btn-primary d-block mx-auto btn-lg" href="javascript:void(0)">See All Notification  </a></div>
                      </div>
                    </div> -->

                  </div>
            </div>



            <div class="col-xxl-12 col-xl-12">
              <div class="row">
                


                  <!--- insert here -->

                  <div class="col-xl-6">
                                    <div class="card">
                                      <div class="card-header">
                                        <h4>Medical Information</h4>
                                      </div>
                                      <div class="card-body">
                                        <div class="table-responsive">
                                          <ul class="contact-list">
                                          <li> <span>Diagnosis Date:</span>                     
                                            <input  class="form-control"  style="width: 80%;" <?php echo $readonly ?> 
                                              type="text" id="diagnosisyear" name="diagnosisyear" 
                                              value="<?php echo $diagnosisyear ?>"> 
                                          </li>

                                          
                                            <li> <span>Diagnosis:</span>
                                              <input required class="form-control"  style="width: 80%;" <?php echo $readonly ?> 
                                              type="text" id="diagnosis1" name="diagnosis1" 
                                              value="<?php echo ucfirst($diagnosis1) ?>"> 
                                          </li>
                                            <li> <span>Attending:</span> 
                                            
                                                <?php
                                              
                                                $cdquery="SELECT * FROM 
                                                      ".$my_tables_use."_resources.doctor_info";
                                                $cdresult=mysqli_query($conn, $cdquery) ;
                                      
                                                  echo '<select '.$disabled.' class="form-control" style="width: 80%;" name="attending" id="attending">';

                                                  echo '<option value="'.ucfirst($attending).'">'.ucfirst($attending).'</option>';

                                                  while ($cdrowssss=mysqli_fetch_array($cdresult)) {

                                                      $fullname=$cdrowssss["user_id"].' ~ '.$cdrowssss["suffix"].' '.$cdrowssss["first_name"].' '.$cdrowssss["last_name"];
                        
                                                        echo '<option value="'.$cdrowssss["user_id"].' ~ '.$fullname.'">'.$fullname.'</option>';
                                                    
                                                  }

                                                echo '</select>';
                                              ?>
                                            
                                            </li>

                                            <li> <span>Hospital:</span> 
                                              <?php
                                              
                                                $cdquery="SELECT * FROM 
                                                      ".$my_tables_use."_resources.hospital";
                                                $cdresult=mysqli_query($conn, $cdquery) ;
                                      
                                                  echo '<select '.$disabled.' class="form-control" style="width: 80%;" name="hospital" id="hospital">';

                                                  echo '<option value="'.ucfirst($hospital).'">'.ucfirst($hospital).'</option>';

                                                  while ($cdrowssss=mysqli_fetch_array($cdresult)) {

                                                      $details=$cdrowssss["code"].' ~ '.$cdrowssss["hospital"];
                        
                                                        echo '<option value="'.$details.'">'.$details.'</option>';
                                                    
                                                  }
                                                  
                                                echo '</select>';
                                              ?>
                                            
                                            </li>
                                            
                                            <li> <span>Appendectomy: &nbsp;</span> 
                                            <select <?php echo $disabled ?> class="form-control" style="width: 80%;" name="appendectomy1" id="appendectomy1">
                                              <option value="<?php echo $appendectomy1 ?>"><?php echo $appendectomy1 ?></option>
                                              <option value="YES">YES</option>
                                              <option value="NO">NO</option>                  
                                            </select>           
                                            </li>


                                          <li> <span>OCP Use:&nbsp; </span> 
                                          <select <?php echo $disabled ?> class="form-control" style="width: 80%;" name="ocpuse" id="ocpuse">
                                              <option value="<?php echo ucfirst($ocpuse) ?>"><?php echo ucfirst($ocpuse)  ?></option>
                                              <option value="YES">YES</option>
                                              <option value="NO">NO</option>                  
                                            </select>     
                                          </li>


                                          <li> <span>Chief Complaint: &nbsp;</span> 
                                          <?php
                                              
                                                $cdquery="SELECT * FROM 
                                                      ".$my_tables_use."_category.chief_complaint";
                                                $cdresult=mysqli_query($conn, $cdquery) ;
                                      
                                                  echo '<select '.$disabled.' class="form-control" style="width: 80%;" name="chiefcomplaint" id="chiefcomplaint">';

                                                  echo '<option value="'.strtoupper($chiefcomplaint).'">'.strtoupper($chiefcomplaint).'</option>';

                                                  while ($cdrowssss=mysqli_fetch_array($cdresult)) {

                                                      $details=strtoupper($cdrowssss["code"].' ~ '.$cdrowssss["details"]);
                        
                                                        echo '<option value="'.$details.'">'.$details.'</option>';
                                                    
                                                  }
                                                  
                                                echo '</select>';
                                              ?>
                                          
                                          </li>


                                          <li> <span>Other Symptoms:&nbsp; </span> 
                                            <input  class="form-control"  style="width: 80%;" <?php echo $readonly ?> 
                                              type="text" id="othersymptoms1" name="othersymptoms1" 
                                              value="<?php echo ucfirst($othersymptoms1) ?>"> 
                                          </li>


                                          <li><span>EIMs:&nbsp; </span> 
                                            <?php
                                              
                                                $cdquery="SELECT * FROM 
                                                      ".$my_tables_use."_category.eims";
                                                $cdresult=mysqli_query($conn, $cdquery) ;
                                      
                                                  echo '<select '.$disabled.' class="form-control" style="width: 80%;" name="eims1" id="eims1">';

                                                  echo '<option value="'.strtoupper($eims1).'">'.strtoupper($eims1).'</option>';

                                                  while ($cdrowssss=mysqli_fetch_array($cdresult)) {

                                                      $details=strtoupper($cdrowssss["code"].' ~ '.$cdrowssss["details"]);
                        
                                                        echo '<option value="'.$details.'">'.$details.'</option>';
                                                    
                                                  }
                                                  
                                                echo '</select>';
                                              ?>
                                          </li>
                                          
                                          <li><span>Hepa A Vaccination:&nbsp;</span> 
                                              <select <?php echo $disabled ?> class="form-control" style="width: 80%;" name="hepavaccination" id="hepavaccination">
                                              <option value="<?php echo strtoupper($hepavaccination) ?>"><?php echo strtoupper($hepavaccination)  ?></option>
                                              <option value="YES">YES</option>
                                              <option value="NO">NO</option>                  
                                            </select>     
                                          </li>


                                          <li><span>Hepa B Vaccination:&nbsp; </span>
                                          <select <?php echo $disabled ?> class="form-control" style="width: 80%;" name="hepbvaccination" id="hepbvaccination">
                                              <option value="<?php echo strtoupper($hepbvaccination) ?>"><?php echo strtoupper($hepbvaccination)  ?></option>
                                              <option value="YES">YES</option>
                                              <option value="NO">NO</option>                  
                                            </select>   
                                          </li>

                                          <li><span>Reactive / Non-Reactive:&nbsp; </span>
                                            <select <?php echo $disabled ?> class="form-control" style="width: 80%;" name="reactive" id="reactive">
                                              <option value="<?php echo strtoupper($reactive) ?>"><?php echo strtoupper($reactive)  ?></option>
                                              <option value="REACTIVE">REACTIVE</option>
                                              <option value="NON-REACTIVE">NON-REACTIVE</option>                  
                                            </select>   
                                          
                                          </li>

                                          <li><span>HGB Levels:&nbsp; </span> 
                                          <input  class="form-control"  style="width: 80%;" <?php echo $readonly ?> 
                                              type="text" id="hgblevels" name="hgblevels" 
                                              value="<?php echo ucfirst($hgblevels) ?>"> 
                                          </li>

                                          <li><span>Type of Anemia:&nbsp; </span>
                                            <?php
                                              
                                                $cdquery="SELECT * FROM 
                                                      ".$my_tables_use."_category.anemia";
                                                $cdresult=mysqli_query($conn, $cdquery) ;
                                      
                                                  echo '<select '.$disabled.' class="form-control" style="width: 80%;" name="typeofanemia" id="typeofanemia">';

                                                  echo '<option value="'.strtoupper($typeofanemia).'">'.strtoupper($typeofanemia).'</option>';

                                                  while ($cdrowssss=mysqli_fetch_array($cdresult)) {

                                                      $details=strtoupper($cdrowssss["code"].' ~ '.$cdrowssss["details"]);
                        
                                                        echo '<option value="'.$details.'">'.$details.'</option>';
                                                    
                                                  }
                                                  
                                                echo '</select>';
                                              ?>
                                          </li>



                                          <li><span>Platelet Count:&nbsp; </span> 
                                            <input  class="form-control"  style="width: 80%;" <?php echo $readonly ?> 
                                              type="text" id="plateletcount" name="plateletcount" 
                                              value="<?php echo $plateletcount ?>"> 
                                          </li>

                                            <li><span>Albumin:&nbsp; </span> 
                                            <input  class="form-control"  style="width: 80%;" <?php echo $readonly ?> 
                                              type="text" id="albumin" name="albumin" 
                                              value="<?php echo $albumin ?>"> 
                                            </li>
                                            
                                            <li><span>CRP Level:&nbsp; </span><?php echo $crplevel?>
                                            <input  class="form-control"  style="width: 80%;" <?php echo $readonly ?> 
                                              type="text" id="crplevel" name="crplevel" 
                                              value="<?php echo $crplevel ?>"> 
                                            </li>

                                            <li><span>ESR:&nbsp; </span> 
                                              <input  class="form-control"  style="width: 80%;" <?php echo $readonly ?> 
                                              type="text" id="esr" name="esr" 
                                              value="<?php echo $esr ?>"> 
                                            </li>

                                            <li><span>C. Difficile Infxn:&nbsp; </span>
                                              <select <?php echo $disabled ?> class="form-control" style="width: 80%;" name="cdifficileinfxn" id="cdifficileinfxn">
                                              <option value="<?php echo strtoupper($cdifficileinfxn) ?>"><?php echo strtoupper($cdifficileinfxn)  ?></option>
                                              <option value="POSITIVE">POSITIVE</option>
                                              <option value="NEGATIVE">NEGATIVE</option>                  
                                            </select>   
                                            </li>

                                                  <li><span>Procedure Done:&nbsp; </span> 
                                              <input  class="form-control"  style="width: 80%;" <?php echo $readonly ?> 
                                              type="text" id="proceduredone" name="proceduredone" 
                                              value="<?php echo strtoupper($proceduredone) ?>"> 
                                              </li>


                                          <li><span>Date of Procedure:&nbsp; </span> 
                                          <input  class="form-control"  style="width: 80%;" <?php echo $readonly ?> 
                                              type="date" id="dateofprocedure" name="dateofprocedure" 
                                              value="<?php echo  $dateofprocedure ?>"> 
                                          </li>


                                              <li><span>Endoscopic Findings:&nbsp; </span> 
                                                  <textarea class="form-control"  style="width: 80%;" <?php echo $readonly ?> 
                                        id="endoscopicfindings" name="endoscopicfindings" rows="8"><?php echo $endoscopicfindings ?></textarea>
                                              </li>

                                                <li><span>Lesion:&nbsp; </span>
                                                <?php
                                              
                                                $cdquery="SELECT * FROM 
                                                      ".$my_tables_use."_category.lesion";
                                                $cdresult=mysqli_query($conn, $cdquery) ;
                                      
                                                  echo '<select '.$disabled.' class="form-control" style="width: 80%;" name="lesion" id="lesion">';

                                                  echo '<option value="'.strtoupper($lesion).'">'.strtoupper($lesion).'</option>';

                                                  while ($cdrowssss=mysqli_fetch_array($cdresult)) {

                                                      $details=strtoupper($cdrowssss["code"].' ~ '.$cdrowssss["details"]);
                        
                                                        echo '<option value="'.$details.'">'.$details.'</option>';
                                                    
                                                  }
                                                  
                                                echo '</select>';
                                              ?>
                                                </li>


                                                    <li><span>Colonoscopic Findings:&nbsp;&nbsp; </span> 
                                                      <?php
                                              
                                                $cdquery="SELECT * FROM 
                                                      ".$my_tables_use."_category.colonoscopic_findings";
                                                $cdresult=mysqli_query($conn, $cdquery) ;
                                      
                                                  echo '<select '.$disabled.' class="form-control" style="width: 80%;" name="colonoscopicfindings" id="colonoscopicfindings">';

                                                  echo '<option value="'.strtoupper($colonoscopicfindings).'">'.strtoupper($colonoscopicfindings).'</option>';

                                                  while ($cdrowssss=mysqli_fetch_array($cdresult)) {

                                                      $details=strtoupper($cdrowssss["code"].' ~ '.$cdrowssss["details"]);
                        
                                                        echo '<option value="'.$details.'">'.$details.'</option>';
                                                    
                                                  }
                                                  
                                                echo '</select>';
                                              ?>
                                                    </li>

                                            

                                          </ul>
                                        </div>
                                      </div>
                                    </div>
                  </div>



                    <div class="col-xl-6">
                                    <div class="card">
                                    
                                      <div class="card-body">
                                        <div class="table-responsive">
                                          <ul class="contact-list">
                                          
                                        


                                                      <li><span>Distribution:&nbsp; </span> 
                                                          <?php
                                              
                                                          $cdquery="SELECT * FROM 
                                                                ".$my_tables_use."_category.distribution ";
                                                          $cdresult=mysqli_query($conn, $cdquery) ;
                                                
                                                            echo '<select '.$disabled.' class="form-control" style="width: 80%;" name="distribution" id="distribution">';

                                                            echo '<option value="'.strtoupper($distribution ).'">'.strtoupper($distribution).'</option>';

                                                            while ($cdrowssss=mysqli_fetch_array($cdresult)) {

                                                                $details=strtoupper($cdrowssss["code"].' ~ '.$cdrowssss["details"]);
                                  
                                                                  echo '<option value="'.$details.'">'.$details.'</option>';
                                                              
                                                            }
                                                            
                                                          echo '</select>';
                                                        ?>
                                                      </li>


                                                          <li><span>Histopath Findings:&nbsp; &nbsp;</span>
                                                        
                                                          <textarea class="form-control"  style="width: 80%;" <?php echo $readonly ?> 
                                        id="histopathdetails" name="histopathdetails" rows="4"><?php echo $histopathdetails ?></textarea>
                                                          
                                                          </li>

                                                      <li><span>Initial Treatment:&nbsp; </span> 
                                                      <?php
                                              
                                                          $cdquery="SELECT * FROM 
                                                                ".$my_tables_use."_category.treatment ";
                                                          $cdresult=mysqli_query($conn, $cdquery) ;
                                                
                                                            echo '<select '.$disabled.' class="form-control" style="width: 80%;" name="initialtreatment" id="initialtreatment">';

                                                            echo '<option value="'.strtoupper($initialtreatment).'">'.strtoupper($initialtreatment).'</option>';

                                                            while ($cdrowssss=mysqli_fetch_array($cdresult)) {

                                                                $details=strtoupper($cdrowssss["code"].' ~ '.$cdrowssss["details"]);
                                  
                                                                  echo '<option value="'.$details.'">'.$details.'</option>';
                                                              
                                                            }
                                                            
                                                          echo '</select>';
                                                        ?>
                                                      </li>

                                                      <li><span>Duration:&nbsp; </span> 
                                                        <input  class="form-control"  style="width: 80%;" <?php echo $readonly ?> 
                                                        type="text" id="duration" name="duration" 
                                                        value="<?php echo $duration ?>"> 
                                                      
                                                      </li>


                                                    <li><span>Improvement:&nbsp; </span> 
                                                      <select <?php echo $disabled ?> class="form-control" style="width: 80%;" name="improvement" id="improvement">
                                                        <option value="<?php echo strtoupper($improvement) ?>"><?php echo strtoupper($improvement)  ?></option>
                                                        <option value="YES">YES</option>
                                                        <option value="NO">NO</option>                  
                                                      </select>   
                                                    </li>


                                                  <li><span>Additional Treatment:&nbsp; </span> 
                                                  <?php
                                              
                                                          $cdquery="SELECT * FROM 
                                                                ".$my_tables_use."_category.treatment ";
                                                          $cdresult=mysqli_query($conn, $cdquery) ;
                                                
                                                            echo '<select '.$disabled.' class="form-control" style="width: 80%;" name="additionaltreatment" id="additionaltreatment">';

                                                            echo '<option value="'.strtoupper($additionaltreatment).'">'.strtoupper($additionaltreatment).'</option>';

                                                            while ($cdrowssss=mysqli_fetch_array($cdresult)) {

                                                                $details=strtoupper($cdrowssss["code"].' ~ '.$cdrowssss["details"]);
                                  
                                                                  echo '<option value="'.$details.'">'.$details.'</option>';
                                                              
                                                            }
                                                            
                                                          echo '</select>';
                                                        ?>
                                                  </li>


                                                    <li><span>Mayo Score/DAI for CD:&nbsp; </span> 
                                                    <input  class="form-control"  style="width: 80%;" <?php echo $readonly ?> 
                                                        type="text" id="mayoscore" name="mayoscore" 
                                                        value="<?php echo $mayoscore ?>"> 
                                                    </li>
                    
                                                    <li><span>Frequency of Stools:&nbsp; </span> 
                                                    <input  class="form-control"  style="width: 80%;" <?php echo $readonly ?> 
                                                        type="text" id="frequencyofstools" name="frequencyofstools" 
                                                        value="<?php echo $frequencyofstools ?>"> 
                                                    </li>

                                                      <li><span>Abdominal Pain:&nbsp; </span> 
                                                        <input  class="form-control"  style="width: 80%;" <?php echo $readonly ?> 
                                                        type="text" id="abdominalpain" name="abdominalpain" 
                                                        value="<?php echo $abdominalpain ?>"> 
                                                      
                                                      </li>



                                                        <li><span>General Well Being:&nbsp; </span> 
                                                        <input  class="form-control"  style="width: 80%;" <?php echo $readonly ?> 
                                                        type="text" id="generalwellbeing" name="generalwellbeing" 
                                                        value="<?php echo $generalwellbeing ?>"> 
                                                        
                                                        </li>


                                                          <li><span>Montreal-Extent:&nbsp; </span> 
                                                          <?php
                                              
                                                          $cdquery="SELECT * FROM 
                                                                ".$my_tables_use."_category.montreal";
                                                          $cdresult=mysqli_query($conn, $cdquery) ;
                                                
                                                            echo '<select '.$disabled.' class="form-control" style="width: 80%;" name="montrealextentforuc" id="montrealextentforuc">';

                                                            echo '<option value="'.strtoupper($montrealextentforuc).'">'.strtoupper($montrealextentforuc).'</option>';

                                                            while ($cdrowssss=mysqli_fetch_array($cdresult)) {

                                                                $details=strtoupper($cdrowssss["code"].' ~ '.$cdrowssss["details"]);
                                  
                                                                  echo '<option value="'.$details.'">'.$details.'</option>';
                                                              
                                                            }
                                                            
                                                          echo '</select>';
                                                        ?>
                                                          </li>         

                                                            <li><span>Severity:&nbsp; </span> 
                                                              <?php
                                              
                                                                $cdquery="SELECT * FROM 
                                                                      ".$my_tables_use."_category.severity";
                                                                $cdresult=mysqli_query($conn, $cdquery) ;
                                                      
                                                                  echo '<select '.$disabled.' class="form-control" style="width: 80%;" name="severityinuc" id="severityinuc">';

                                                                  echo '<option value="'.strtoupper($severityinuc).'">'.strtoupper($severityinuc).'</option>';

                                                                  while ($cdrowssss=mysqli_fetch_array($cdresult)) {

                                                                      $details=strtoupper($cdrowssss["code"].' ~ '.$cdrowssss["details"]);
                                        
                                                                        echo '<option value="'.$details.'">'.$details.'</option>';
                                                                    
                                                                  }
                                                                  
                                                                echo '</select>';
                                                              ?>
                                                            </li>  

                                                            <li><span>Location:&nbsp; </span> 
                                                            <?php
                                              
                                                                $cdquery="SELECT * FROM 
                                                                      ".$my_tables_use."_category.location";
                                                                $cdresult=mysqli_query($conn, $cdquery) ;
                                                      
                                                                  echo '<select '.$disabled.' class="form-control" style="width: 80%;" name="locationcd" id="locationcd">';

                                                                  echo '<option value="'.strtoupper($locationcd).'">'.strtoupper($locationcd).'</option>';

                                                                  while ($cdrowssss=mysqli_fetch_array($cdresult)) {

                                                                      $details=strtoupper($cdrowssss["code"].' ~ '.$cdrowssss["details"]);
                                        
                                                                        echo '<option value="'.$details.'">'.$details.'</option>';
                                                                    
                                                                  }
                                                                  
                                                                echo '</select>';
                                                              ?>
                                                            </li>  


                                                              <li><span>Behaviour:&nbsp; </span> 
                                                                  <?php
                                              
                                                                $cdquery="SELECT * FROM 
                                                                      ".$my_tables_use."_category.behaviour";
                                                                $cdresult=mysqli_query($conn, $cdquery) ;
                                                      
                                                                  echo '<select '.$disabled.' class="form-control" style="width: 80%;" name="behaviorcd" id="behaviorcd">';

                                                                  echo '<option value="'.strtoupper($behaviorcd).'">'.strtoupper($behaviorcd).'</option>';

                                                                  while ($cdrowssss=mysqli_fetch_array($cdresult)) {

                                                                      $details=strtoupper($cdrowssss["code"].' ~ '.$cdrowssss["details"]);
                                        
                                                                        echo '<option value="'.$details.'">'.$details.'</option>';
                                                                    
                                                                  }
                                                                  
                                                                echo '</select>';
                                                              ?>
                                                              </li>  

                                                                <li><span>Complications:&nbsp; </span> 
                                                                <?php
                                              
                                                                $cdquery="SELECT * FROM 
                                                                      ".$my_tables_use."_category.complications";
                                                                $cdresult=mysqli_query($conn, $cdquery) ;
                                                      
                                                                  echo '<select '.$disabled.' class="form-control" style="width: 80%;" name="complications" id="complications">';

                                                                  echo '<option value="'.strtoupper($complications).'">'.strtoupper($complications).'</option>';

                                                                  while ($cdrowssss=mysqli_fetch_array($cdresult)) {

                                                                      $details=strtoupper($cdrowssss["code"].' ~ '.$cdrowssss["details"]);
                                        
                                                                        echo '<option value="'.$details.'">'.$details.'</option>';
                                                                    
                                                                  }
                                                                  
                                                                echo '</select>';
                                                              ?>
                                                                
                                                                </li>


                                                            <li><span>Surgery (State surgical procedure done):&nbsp; </span> 
                                                            <select <?php echo $disabled ?> class="form-control" style="width: 80%;" name="surgery" id="surgery">
                                                              <option value="<?php echo strtoupper($surgery) ?>"><?php echo strtoupper($surgery)  ?></option>
                                                              <option value="YES">YES</option>
                                                              <option value="NO">NO</option>                  
                                                            </select>   
                                                            </li>


                                                          <li><span>Management:&nbsp; </span> 
                                                            <input  class="form-control"  style="width: 80%;" <?php echo $readonly ?> 
                                                                type="text" id="management" name="management" 
                                                                value="<?php echo $management ?>"> 
                                                          
                                                          </li>

                                                              <li><span>Use of prolonged steroids:&nbsp; </span> 
                                                              <select <?php echo $disabled ?> class="form-control" style="width: 80%;" name="useofprolongedsteroids" id="useofprolongedsteroids">
                                                              <option value="<?php echo strtoupper($useofprolongedsteroids) ?>"><?php echo strtoupper($useofprolongedsteroids)  ?></option>
                                                              <option value="YES">YES</option>
                                                              <option value="NO">NO</option>                  
                                                            </select>   
                                                              
                                                              </li>


                                                            <li><span>Type of Biologics:&nbsp; </span> 
                                                            <input  class="form-control"  style="width: 80%;" <?php echo $readonly ?> 
                                                                type="text" id="biologics" name="biologics" 
                                                                value="<?php echo $biologics ?>"> 
                                                            </li>
                  
                    
                                                              <li><span>Nurse's Note:&nbsp; </span> 
                                                              
                                                                  <textarea class="form-control"  style="width: 80%;" <?php echo $readonly ?> 
                                                                      id="notes" name="notes" rows="4"><?php echo $notes ?></textarea>
                                                </li>

                                                <li><span>Doctor's Note:&nbsp; </span> 
                                                              
                                                                  <textarea class="form-control"  style="width: 80%;" <?php echo $readonly ?> 
                                                                      id="doctor_notes" name="doctor_notes" rows="4"><?php echo $doctor_notes ?></textarea>
                                                </li>

                                            
                    


                                          </ul>
                                          
                                        </div>
                                      </div>
                                    </div>

                                      <div class="form-group">
                                          <div class="d-flex justify-content-between">
                                              <button id="save_btn" <?php echo $disabled ?> class="btn btn-primary" style="width: 32%;"  ><i class="fa fa-save"></i> Save / Update</button>
                                              <a href="javascript:void(0);" class="btn btn-success" style="width: 32%;" onclick="window.location='edit-click.php';"><i class="fa fa-pencil"></i> Edit Record</a>
                                            <a href="javascript:void(0);" class="btn btn-info" style="width: 32%;" onclick="window.location='add-click.php';"><i class="fa fa-plus"></i> Add New Patient</a>

                                          </div>
                                      </div>
                    </div>


                          
                          <!--  <div class="col-xl-12">
                              <div class="card">
                                <div class="card-header">
                                  <h4>Patient Activities</h4>
                                </div>
                                <div class="card-body">
                                  <div id="bloodlevel"></div>
                                </div>
                              </div>
                            </div> -->
                              <?php
                               if(isset($_SESSION['add_click']) AND $_SESSION['add_click']=='Y') {
                               }
                               else
                               { ?>
                                  <div class="col-xl-12">
                                      <div class="card">
                                        <div class="card-header">
                                          <h4>Patient Visits</h4>
                                        </div>
                                        <div class="card-body">
                                          <div class="table-responsive">
                                            <table class="table table-bordered" style="width:100%;">
                                              <thead>
                                                <tr>
                                              
                                                  <th>Date</th>
                                                  <th>Time </th>
                                                                  
                                                  <th>Status</th>
                                                </tr>
                                              </thead>
                                              <tbody>
                                              

                                                  <?php
                                                  
                                                  $user_id=$_SESSION['patient_id'];
                                                  $cdquery="SELECT * FROM 
                                                        ".$my_tables_use."_schedule.appointments 
                                                        WHERE user_id='".$user_id."'  ORDER BY id DESC";
                                                $cdresult=mysqli_query($conn, $cdquery) ;

                                                while ($cdrowssss=mysqli_fetch_array($cdresult)) {

                                                  $idrec=$cdrowssss['id'];

                                                
                                                    $dateTime = DateTime::createFromFormat('H:i', $cdrowssss['time_only']); // Create a DateTime object
                                                      $time_only = $dateTime->format('h:i A'); // Convert to 12-hour format with AM/PM

                                                  echo '<tr>';
                                              
                                              echo '<td>'.$cdrowssss['date_only'].'</td>';
                                                  echo '<td>'.$time_only.'</td>';
                                                
                                              
                                                  echo '<td>';
                                              
                                                  
                                                    switch($cdrowssss['status']){ 
                                                            case(0): 
                                                              echo '<span class="badge badge-warning">Rescheduled</span>';
                                                            break; 
                                                            case(1): 
                                                            echo '<span class="badge badge-success">Confirmed</span>';
                                                            break; 
                                                            case(2): 
                                                              echo '<span class="badge badge-danger">Cancelled</span>';
                                                            break; 
                                                            case(3): 
                                                              echo '<span class="badge badge-info">Done</span>';
                                                            break; 
                                                            default: 
                                                              echo '<span class="badge badge-secondary">NA</span>';
                                                                  } 
                              
                                                  echo '</td>';
                                                  
                                                  echo '</tr>';

                    
                                                }   


                                                ?>     
                                            
                                              
                                                
                                              </tbody>
                                            </table>
                                          </div>
                                        </div>
                                      </div>
                                  </div>
                               <?php } ?>


                            </div>
              </div>
            </div>
        </div>
      </div>
      <!-- theme body end-->
    </div>
  </form>

    <!-- footer start -->
       <?php //include "includes/footer.php"; ?>
        <div class="scroll-top"><i class="fa fa-angle-double-up"></i></div>
      <!-- main jquery-->
      <script src="../assets/js/jquery-3.7.0.min.js"></script>
      <!-- Feather iocns js-->
      <script src="../assets/js/icons/feather-icon/feather.js"></script>
      <!-- Bootstrap js-->
      <script src="../assets/js/bootstrap.bundle.min.js"></script>
      <script src="../assets/js/vendors/notify/bootstrap-notify.js"></script>
      <script src="../assets/js/vendors/notify/bootstrap-customnotify.js"></script>
      <!-- customizer-->
      <script src="../assets/js/customizer.js"></script>
      <!-- Scrollbar-->
      <script src="../assets/js/vendors/simplebar.js"></script>
      <!-- apex chart-->
      <script src="../assets/js/vendors/chart/apexcharts.js"></script>
      <!-- patient dashboard js-->
      <script src="../assets/js/dashboard/patient-dashboard.js"></script>
      <!-- Custom script-->
      <script src="../assets/js/custom-script.js"></script>
    <!-- footer end-->
  </body>
</html>