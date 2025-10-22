<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>



<?php

 
$presentdate=date('Y-m-d');
if(!isset($_SESSION['user_name'])) {

   echo "<script>window.location = '../log-in/'</script>";


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Form</title>

<!-- custom-styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link rel="stylesheet" href="assets/css/animation.css">
    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

   
       <link rel="shortcut icon" href="../../uploads/images/logo/icon-logo.png" type="image/x-icon">
    <!-- Fonts css-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <!-- Font awesome -->
    <link href=" ../admin/assets/css/vendor/font-awesome.css" rel="stylesheet">
    <link href="../admin/assets/css/vendor/themify-icons.css" rel="stylesheet">
    <link href="../admin/assets/css/vendor/icoicon.css" rel="stylesheet">
    <!-- datepicker-->
    <link href="../admin/assets/css/vendor/datepicker/datepicker.css" rel="stylesheet">
    <!-- select 2 css-->
    <link href="../admin/assets/css/vendor/select2/select2.min.css" rel="stylesheet">
    <!-- Scrollbar-->
    <link href="../admin/assets/css/vendor/simplebar.css" rel="stylesheet">
    <!-- Bootstrap css-->
    <link href="../admin/assets/css/vendor/bootstrap.css" rel="stylesheet">
    <!-- Custom css-->
    <link href="../admin/assets/css/style2.css" rel="stylesheet">

<style>
  /* Default styles */
  .patient-info-header {
    display: block; /* Ensure it's visible by default */
 margin-top: 20px;
  }
  .right-shape-img {
     height: 120px; 
     margin-right:50px;

  }

 

  /* Hide on mobile devices (e.g., screens less than 768px wide) */
  @media (max-width: 767.98px) {
    .patient-info-header {
      display: none;
 
    }

    .right-shape-img {    
        text-align: center;
    }

    .main-form {
        margin-top: 40px;
     }
   
  }
</style>
   
</head>
<body>
          <!--    <div class="logo"  >
            
           
              <div class="left-img">
                                <img src="assets/images/left-bg.gif" alt="BeRifma">
                </div>
                            <article class="side-text" style="text-align: center;margin-top: 40px;">
                                <h2>Specialized unit for gastrointestinal and liver diseases</h2>
                                <p>Email us : <span>malvargastrohep@gmail.com</span></p>
                            </article> 
           
        </div>-->


        
  
 <div class="themebody-wrap"  style="margin-left: 10px;margin-right: 10px; margin-top:25px;">  
   
      <div class="theme-body common-dash"  >
        <div class="container-fluid" >
             <div class="row"  >
             
                 <div class="col-md-12">


                     <div class="card" >
                
   <a style="  width:8%;z-index: 900; " href="../admin/source/" 
                           class="btn btn-success btn-lg btn-block text-white">
                   <i class="fa fa-home"></i>&nbsp;HOME</a>
                       <div class="card-header">
                        <h2  style="z-index: 900;"  class="patient-info-header">Patient Information</h2>
                        </div>

            
                         
           
                          <div class="card-body" > 
                            <!-- form -->

                              <div class="left-shape">
            <img style="z-index: 900;" src="../../uploads/images/top-left.png" alt="">
        </div>
                            <form class="main-form" id="steps" method="post" action="saving.php" enctype="multipart/form-data">
                                <!-- step 1 -->
                                <div id="step1" >
                                    <div class="row "  >
                                        <div class="col-md-6 ">
                                             <div class="form-group col-md-10"  >
                                                 <div class="form-label"  >Date :</div>
                                                <input class="form-control" type="date" readonly name="date" id="date" value="<?php echo $presentdate ?>">
                                               
                                            </div>

                                           <div class="form-group col-md-10">
                                                 <div class="form-label">Last Name :</div>
                                                <input class="form-control" required type="text" name="last_name" id="last_name" placeholder="Last Name">
                                                
                                            </div>

                                             <div class="form-group col-md-10">
                                                 <div class="form-label">First Name</div>
                                                <input class="form-control" required type="text" name="first_name" id="first_name" placeholder="First Name">
                                               
                                            </div>

                                             <div class="form-group col-md-10">
                                                 <div class="form-label">Middle Name</div>
                                                <input class="form-control" required type="text" name="middle_name" id="middle_name" placeholder="Middle Name">
                                                
                                            </div>

                                             <div class="form-group col-md-10" style="visibility: hidden;position:absolute">
                                                 <div class="form-label">Address </div>
                                                <input class="form-control" type="text" name="address" id="address" placeholder="Address">
                                               
                                            </div>

                                            

                                             <div class="form-group col-md-10">
                                                 <div class="form-label">Email Address </div>
                                                <input  class="form-control" required type="text" name="email" id="mail-email" placeholder="Email address">
                                               
                                            </div>

                                             <div class="form-group col-md-10">
                                                 <div class="form-label">Birthday </div>
                                                <input class="form-control" type="date" name="birthday" id="birthday" placeholder="Birth Date">
                                               
                                            </div>

                                            <div class="form-group col-md-10">
                                                 <div class="form-label">Civil Status</div>
                                                <select   class="form-select" name="civil_status" id="civil_status">
                                                    <option value="Single">Single</option>
                                                    <option value="Married">Married</option>
                                                </select>
                                                
                                            </div>

                                             <div class="form-group col-md-10">
                                                 <div class="form-label">Gender </div>
                                                <select   class="form-select"  name="sex" id="sex">
                                                    <option value="Male">Male</option>
                                                    <option value="Female">Female</option>
                                                </select>
                                            
                                            </div>

                                           
                                               <div class="form-group col-md-10">
                                                 <div class="form-label">Height (cm)</div>
                                                <input class="form-control" type="text" name="height_cm" id="height_cm" placeholder="Height (Cm)">
                                                <span></span>
                                            </div>

                                            <div class="form-group col-md-10">
                                                 <div class="form-label">Weight (kg)</div>
                                                <input class="form-control" type="text" name="weight_kg" id="weight_kg" placeholder="Weight (Kg)">
                                                <span></span>
                                            </div>
                                        </div>

                                        
                                        <div class="col-md-6">


                                             <div class="form-group col-md-10">
                                                 <div class="form-label">Phone </div>
                                                <input class="form-control" type="text" name="phone" id="phone" placeholder="Contact / Phone Number">
                                                <span></span>
                                            </div>


                                              <?php include "address.php" ?>           
                                             
                                             <div class="form-group col-md-10" style="visibility: hidden; position:absolute">
                                                 <div class="form-label">Number of previous consults with other MDs for this disease.</div>
                                                <input class="form-control" type="text" name="prev_consults" id="prev_consults" placeholder="">
                                                <span></span>
                                            </div>


                                            <div class="form-group col-md-10">
                                                 <div class="form-label">Blood Type </div>
                                                <select  class="form-select"  name="blood_group" id="blood_group">
                                                     <option value="N/A">N/A</option>
                                                    <option value="A+">A+</option>
                                                    <option value="A-">A-</option>
                                                    <option value="B+">B+</option>
                                                    <option value="B-">B-</option>
                                                    <option value="O+">O+</option>
                                                    <option value="O-">O-</option>
                                                    <option value="AB+">AB+</option>
                                                    <option value="AB-">AB-</option>
                                                </select>
                                            </div>

                                          
                                                  <!-- step Button -->
                        
                                        
                         


                                        </div>

                                            <div class="col-md-6">
                                                <?php include "../includes/camera.php" ?>
                                            </div>

                                            <div class="col-md-6">
 <div class="form-group col-md-12" style="text-align: center;">
                                    <button style="width: 80%; height:60px"  class="btn btn-sm btn-success" type="submit" id="sub" >
                                    <span style=" font-size:17px; font-weight:bold">
                                    CONTINUE &nbsp;&nbsp;&nbsp;   <i class="fa-solid fa-arrow-right"></i></span></button>

                  
                                </div>
                                            </div>

                                        
                                    </div>

                          
                                </div>
 
                                  
                            </form>
                        </div>
                    </div>

                    
                       
                           
                        
                            <ul class="links" >
                                <li><a href="#" style="font-size: 12px;">Terms of Service</a></li>
                                <li><a href="#" style="font-size: 12px;">Privacy Policy</a></li>
                                
                            </ul>
                        
                </div>
            </div>
        </div>
      
        <div class="right-shape">
            <img class="right-shape-img"  src="../../uploads/images/logo/logo-gh-fulltrans.png" alt="">
        </div>
   
 </div>
 </div>
    <div id="error"></div>

    <!-- Bootstrap-5 -->
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Jquery -->
    <script src="assets/js/jquery-3.6.1.min.js"></script>

    <!-- My js -->
    <!-- <script src="assets/js/custom.js"></script> -->


</body>



 <div class="scroll-top"><i class="fa fa-angle-double-up"></i></div>
    <!-- footer end-->
      <!-- main jquery-->
      <script src="../admin/assets/js/jquery-3.7.0.min.js"></script>
      <!-- Feather iocns js-->
      <script src="../admin/assets/js/icons/feather-icon/feather.js"></script>
      <!-- Bootstrap js-->
      <script src="../admin/assets/js/bootstrap.bundle.min.js"></script>
      <script src="../admin/assets/js/vendors/notify/bootstrap-notify.js"></script>
      <script src="../admin/assets/js/vendors/notify/bootstrap-customnotify.js"></script>
      <!-- customizer-->
      <script src="../admin/assets/js/customizer.js"></script>
      <!-- Scrollbar-->
      <script src="../admin/assets/js/vendors/simplebar.js"></script>
      <!-- select 2 js-->
      <script src="../admin/assets/js/vendors/select2/select2.min.js"></script>
      <script src="../admin/assets/js/vendors/select2/custom-select2.js"> </script>
      <!-- datepicker-->
      <script src="../admin/assets/js/vendors/datepicker/datepicker.js"></script>
      <script src="../admin/assets/js/vendors/datepicker/datepicker.en.js"></script>
      <script src="../admin/assets/js/vendors/datepicker/custom-datepicker.js"></script>
      <!-- Custom script-->
      <script src="../admin/assets/js/custom-script.js"></script>
</html>

