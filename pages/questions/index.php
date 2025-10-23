<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

<?php 

ini_set('display_errors', 1);
error_reporting(E_ALL);

include "../../Connections/dbname.php";

$presentdate=date('Y-m-d');
 
 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Form</title>

    <!-- font-awesome -->
    <link rel="stylesheet" href="assets/css/all.min.css">

    <!-- Bootstrap-5 -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- custom-styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link rel="stylesheet" href="assets/css/animation.css">

    <style>

    .responsive-img {
    max-width: 100%; /* Ensures the image does not exceed the container width */
    height: auto;    /* Maintains the aspect ratio */
        }


         .radio-group {
            display: flex;
            gap: 20px;
        }
        .radio-button {
            position: relative;
            cursor: pointer;
        }
        .radio-button input {
            display: none;
        }
      
        .radio-button input:checked + img {
            border: 4px solid blue; /* Change the border color for selected image */
        }

        .radio-button img {
    border: 2px solid gray;
    border-radius: 5px;
    width: 100%; /* Default to full width */
    height: auto; /* Maintain aspect ratio */
}

@media (max-width: 600px) {
    .radio-group {
        flex-direction: column; /* Stack images vertically on smaller screens */
        align-items: center;
    }
    
    .radio-button img {
        width: 80%; /* Adjust the width as needed for mobile view */
        height: auto; /* Maintain aspect ratio */
    }
}
</style>

</head>
<body class="popreveal">
    <main class="overflow-hidden">
        <div class="wrapper">
            <form id="steps" class="show-section" method="post" novalidate enctype="multipart/form-data">


            <?php 
             include "step1.php"; 
               include "step2.php";  
               include "step3.php";  
               include "step4.php"; 
               include "step5.php";   
                 include "step6.php"; 
                   include "step7.php";  
                include "step8.php";  
                  include "step9.php";  
                 include "step10.php";
                 
                 ?>         
          
                
  <!-- FINAL -->
                <section class="steps">

                 <?php  include "step-final.php"; ?>


                       <footer>
                        <div class="container ps-3 pe-3">
                            <div class="next_prev">
                                <button class="prev" type="button"><span>Previous Question</span></button>
                                <div class="bar-inner">
                                    <span class="bar-text">95% complete. keep it up!</span>
                                    <div class="w-75 bar-move"></div>
                                </div>
                                  <button class="apply" type="submit" id="sub_save" name="sub_save"><span>Submit</span></button>
                            </div>
                        </div>
                    </footer>  
                </section>

              </form>


                <?php
                        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

                            
                            
                            // Something posted

                            if (isset($_POST['sub_save'])) {


                                   

                                    //STEP 1
                                    $_SESSION['first_attack']=$_POST['first_attack'];
                                    $_SESSION['stool_per_day']=$_POST['stool_per_day'];
                                    $_SESSION['frequency_pain']=$_POST['frequency_pain'];
                                    $_SESSION['chief_complain']='';
       
                                     if (isset($_POST['chief_complain'])) {
                                        $chief_complain = $_POST['chief_complain']; // Store selected values in session
                                        
                                         foreach ($chief_complain as $complaint) {
                                            $_SESSION['chief_complain'].=htmlspecialchars($complaint).' ~ ' ;
                                            }
                                     }

                                     //STEP 2                                   
                                     $_SESSION['other_symptoms']='';
       
                                     if (isset($_POST['other_symptoms'])) {
                                        $var_value = $_POST['other_symptoms']; // Store selected values in session
                                        
                                         foreach ($var_value as $var_result) {
                                            $_SESSION['other_symptoms'].=htmlspecialchars($var_result).' ~ ' ;
                                         }
                                     }

                                      $_SESSION['other_symptoms_others']=$_POST['other_symptoms_others'];

                                      //STEP 3
                                         $_SESSION['medical_history']='';
       
                                     if (isset($_POST['medical_history'])) {
                                        $var_value = $_POST['medical_history']; // Store selected values in session
                                        
                                         foreach ($var_value as $var_result) {
                                            $_SESSION['medical_history'].=htmlspecialchars($var_result).' ~ ' ;
                                         }
                                     }

                                      $_SESSION['others_medical_history']=$_POST['others_medical_history'];
                                      $_SESSION['any_operation']=$_POST['any_operation'];
                                        
                                    //STEP 4
                                     $_SESSION['family_history']="";
                                    if (isset($_POST['family_history'])) {
                                        $_SESSION['family_history'] = $_POST['family_history'];
                                    }

                                    //STEP 5
                                    
                                    $_SESSION['smoker']="";
                                    if (isset($_POST['smoker'])) {
                                        $_SESSION['smoker'] = $_POST['smoker'];
                                    }
                                    $_SESSION['pack_per_day']=$_POST['pack_per_day'];
                                    $_SESSION['years_smoking']=$_POST['years_smoking'];

                                    //STEP 6
                                    $_SESSION['pain_rate']="";
                                    if (isset($_POST['pain_rate'])) {
                                        $_SESSION['pain_rate'] = $_POST['pain_rate'];
                                    }

                                    $_SESSION['general_well']="";
                                    if (isset($_POST['general_well'])) {
                                        $_SESSION['general_well'] = $_POST['general_well'];
                                    }

                                    //STEP 7
                                      $_SESSION['behavioral_health']='';
       
                                     if (isset($_POST['behavioral_health'])) {
                                        $var_value = $_POST['behavioral_health']; // Store selected values in session
                                        
                                         foreach ($var_value as $var_result) {
                                            $_SESSION['behavioral_health'].=htmlspecialchars($var_result).' ~ ' ;
                                         }
                                     }
                                                                        
                                     $_SESSION['behavioral_health_others']=$_POST['behavioral_health_others'];

                                     ///STEP 8
                                     
                                      $_SESSION['laboratories']='';
       
                                     if (isset($_POST['laboratories'])) {
                                        $var_value = $_POST['laboratories']; // Store selected values in session
                                        
                                         foreach ($var_value as $var_result) {
                                            $_SESSION['laboratories'].=htmlspecialchars($var_result).' ~ ' ;
                                         }
                                     }

                                    //UPLOADING FILE STEP 8
                                     $_SESSION['files_lab_status']='';
                                     $_SESSION['files_lab']='';
                                    if (isset($_FILES['files_lab']) && !empty($_FILES['files_lab']['name'][0])) {
                                        
                                        $uploadDir = '../../uploads/'.$_SESSION['user_id'].'/'; // Directory where files will be uploaded

                                        // Ensure the uploads directory exists
                                        if (!is_dir($uploadDir)) {
                                            mkdir($uploadDir, 0755, true);
                                        }

                                        foreach ($_FILES['files_lab']['tmp_name'] as $key => $tmp_name) {
                                            // Check for upload errors
                                            if ($_FILES['files_lab']['error'][$key] === UPLOAD_ERR_OK) {
                                                $file_name = basename($_FILES['files_lab']['name'][$key]);
                                                $file_tmp = $_FILES['files_lab']['tmp_name'][$key];

                                                // Move the uploaded file to the uploads directory
                                                if (move_uploaded_file($file_tmp, $uploadDir . $file_name)) {
                                                    $_SESSION['files_lab'].=" ~ ".$file_name;
                                                }
                                            }
                                        }
                                    }
                                    ///////////////////////
                                    //////////////////////
                                    

                                     //STEP 9
                                     
                                       $_SESSION['vaccines']='';
       
                                     if (isset($_POST['vaccines'])) {
                                        $var_value = $_POST['vaccines']; // Store selected values in session
                                        
                                         foreach ($var_value as $var_result) {
                                            $_SESSION['vaccines'].=htmlspecialchars($var_result).' ~ ' ;
                                         }
                                     }

                                         //UPLOADING FILE STEP 9
                                     $_SESSION['files_vac_status']='';
                                     $_SESSION['files_vac']='';
                                    if (isset($_FILES['files_vac']) && !empty($_FILES['files_vac']['name'][0])) {
                                        
                                        $uploadDir = '../../uploads/'.$_SESSION['user_id'].'/'; // Directory where files will be uploaded

                                        // Ensure the uploads directory exists
                                        if (!is_dir($uploadDir)) {
                                            mkdir($uploadDir, 0755, true);
                                        }

                                        foreach ($_FILES['files_vac']['tmp_name'] as $key => $tmp_name) {
                                            // Check for upload errors
                                            if ($_FILES['files_vac']['error'][$key] === UPLOAD_ERR_OK) {
                                                $file_name = basename($_FILES['files_vac']['name'][$key]);
                                                $file_tmp = $_FILES['files_vac']['tmp_name'][$key];

                                                // Move the uploaded file to the uploads directory
                                                if (move_uploaded_file($file_tmp, $uploadDir . $file_name)) {
                                                    $_SESSION['files_vac'].=" ~ ".$file_name;
                                                }
                                            }
                                        }
                                    }
                                    ///////////////////////
                                    //////////////////////

                                     
                                     //STEP 10
                                     
                                       $_SESSION['medications']='';
       
                                     if (isset($_POST['medications'])) {
                                        $var_value = $_POST['medications']; // Store selected values in session
                                        
                                         foreach ($var_value as $var_result) {
                                            $_SESSION['medications'].=htmlspecialchars($var_result).' ~ ' ;
                                         }
                                     }

                                     //UPLOADING FILE STEP 10
                                     $_SESSION['files_med_status']='';
                                     $_SESSION['files_med']='';
                                    if (isset($_FILES['files_med']) && !empty($_FILES['files_med']['name'][0])) {
                                        
                                        $uploadDir = '../../uploads/'.$_SESSION['user_id'].'/'; // Directory where files will be uploaded

                                        // Ensure the uploads directory exists
                                        if (!is_dir($uploadDir)) {
                                            mkdir($uploadDir, 0755, true);
                                        }

                                        foreach ($_FILES['files_med']['tmp_name'] as $key => $tmp_name) {
                                            // Check for upload errors
                                            if ($_FILES['files_med']['error'][$key] === UPLOAD_ERR_OK) {
                                                $file_name = basename($_FILES['files_med']['name'][$key]);
                                                $file_tmp = $_FILES['files_med']['tmp_name'][$key];

                                                // Move the uploaded file to the uploads directory
                                                if (move_uploaded_file($file_tmp, $uploadDir . $file_name)) {
                                                    $_SESSION['files_med'].=" ~ ".$file_name;
                                                }
                                            }
                                        }
                                    }
                                    ///////////////////////
                                    //////////////////////


                                     //STEP FINAL                                     
                                      $_SESSION['imaging']='';
       
                                     if (isset($_POST['imaging'])) {
                                        $var_value = $_POST['imaging']; // Store selected values in session
                                        
                                         foreach ($var_value as $var_result) {
                                            $_SESSION['imaging'].=htmlspecialchars($var_result).' ~ ' ;
                                         }
                                     }
                                     
                                       $_SESSION['imaging_others']=$_POST['imaging_others'];

                                         //UPLOADING FILE STEP FINAL
                                     $_SESSION['files_ima_status']='';
                                     $_SESSION['files_ima']='';
                                    if (isset($_FILES['files_ima']) && !empty($_FILES['files_ima']['name'][0])) {
                                        
                                        $uploadDir = '../../uploads/'.$_SESSION['user_id'].'/'; // Directory where files will be uploaded

                                        // Ensure the uploads directory exists
                                        if (!is_dir($uploadDir)) {
                                            mkdir($uploadDir, 0755, true);
                                        }

                                        foreach ($_FILES['files_ima']['tmp_name'] as $key => $tmp_name) {
                                            // Check for upload errors
                                            if ($_FILES['files_ima']['error'][$key] === UPLOAD_ERR_OK) {
                                                $file_name = basename($_FILES['files_ima']['name'][$key]);
                                                $file_tmp = $_FILES['files_ima']['tmp_name'][$key];

                                                // Move the uploaded file to the uploads directory
                                                if (move_uploaded_file($file_tmp, $uploadDir . $file_name)) {
                                                    $_SESSION['files_ima'].=" ~ ".$file_name;
                                                }
                                            }
                                        }
                                    }
                                    ///////////////////////
                                    //////////////////////


                                  
                                    echo "<script>window.location = 'saving.php'</script>";


                            }
                        
                          
                        }
   
                ?>

          


        </div>
        <div class="image-f d-none">
            <img src="assets/images/image-f.png" alt="image">
        </div>
    </main>




    
    <div id="error">

    </div>


    <!-- Bootstrap-5 -->
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Jquery -->
    <script src="assets/js/jquery-3.6.1.min.js"></script>

    <!-- My js -->
     <script src="assets/js/custom.js"></script> 
</body>
</html>