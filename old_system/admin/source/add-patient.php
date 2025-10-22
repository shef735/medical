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
    <!-- datepicker-->
    <link href="../assets/css/vendor/datepicker/datepicker.css" rel="stylesheet">
    <!-- select 2 css-->
    <link href="../assets/css/vendor/select2/select2.min.css" rel="stylesheet">
    <!-- Scrollbar-->
    <link href="../assets/css/vendor/simplebar.css" rel="stylesheet">
    <!-- Bootstrap css-->
    <link href="../assets/css/vendor/bootstrap.css" rel="stylesheet">
    <!-- Custom css-->
    <link href="../assets/css/style.css" rel="stylesheet">

      <?php 

ini_set('display_errors', 1);
error_reporting(E_ALL);


include "../../../Connections/dbname.php";
include "includes/header.php"; 

?>
  </head>
  <body>

     <?php include "includes/sidebar.php"; ?>
      <!-- Header End-->
    <div class="themebody-wrap">
      <!-- theme body start-->
      <div class="theme-body common-dash" data-simplebar>
        <div class="container-fluid">
          <div class="row">
            <div class="col-md-12">
              <div class="card">
                <div class="card-header">
                  <h4>Patient Information</h4>
                </div>
                <div class="card-body"> 
                  <form>
                    <div class="row">
                      <div class="form-group col-md-4">
                        <div class="form-label">Profile Image</div>
                        <input class="form-control" name="patient_photo" id="patient_photo" type="file">
                      </div>

                         <div class="form-group col-md-4">
                         </div>

                           <div class="form-group col-md-4">
                         </div>


                      <div class="form-group col-md-4">
                        <div class="form-label">First Name</div>
                        <input class="form-control" name="first_name" id="first_name" type="text" placeholder="First Name">
                      </div>

                      <div class="form-group col-md-4">
                        <div class="form-label">Last Name</div>
                        <input class="form-control" name="last_name" id="last_name" type="text" placeholder="Last Name">
                      </div>

                       <div class="form-group col-md-4">
                        <div class="form-label">Middle Name</div>
                        <input class="form-control" name="middle_name" id="middle_name" type="text" placeholder="Middle Name">
                      </div>

                      <div class="form-group col-md-4">
                        <div class="form-label">Date of Birth</div>
                        <input class="datepicker-here form-control" id="birthday" name="birthday" placeholder="YYYY-MM-DD"
                        type="text" value="" data-date-format="yyyy-mm-dd" data-language="en">
                      </div>
                      
                    
                      <div class="form-group col-md-4">
                        <div class="form-label">Gender</div>
                        <select class="form-select" name="gender" id="gender">
                          <option value="Gender">Select Gender</option>
                          <option value="Male">Male</option>
                          <option value="Female">Female</option>
                        </select>
                      </div>
                      <div class="form-group col-md-4">
                        <div class="form-label">Blood Group</div>
                        <select name="blood_group" id="blood_group"  class="form-select">
                          <option value="">Select Blood Group</option>
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
                      <div class="form-group col-md-4">
                        <div class="form-label">Civil Status</div>
                        <select class="form-select hidesearch" name="civil_status" id="civil_status" >
                          <option value="">Select...</option>
                          <option value="Married">Married</option>
                          <option value="Single">Single</option>
                        </select>
                      </div>
                      <div class="form-group col-md-4">
                        <div class="form-label">Weight (Kg)</div>
                        <input class="form-control" name="weight_kg" id="weight_kg" type="text" value="">
                      </div>
                      <div class="form-group col-md-4">
                        <div class="form-label">Height (Cm)</div>
                        <input class="form-control" name="height_cm" id="height_cm"  type="text" value="">
                      </div>
                      <div class="form-group col-md-4">
                        <div class="form-label">Email</div>
                        <input class="form-control" type="email" name="email" id="email"  placeholder="">
                      </div>
                      <div class="form-group col-md-4">
                        <div class="form-label">Phone</div>
                        <input name="photo" id="photo" class="form-control" type="text" placeholder="">
                      </div>

            <?php include "address.php" ?>


                      
                      
                      
                      
                      <div class="form-group col-md-4">
                        <div class="form-label">Status</div>
                        <select class="form-select hidesearch" name="patientStatus[]">
                          <option value="">Select Status</option>
                          <option value="active">Active</option>
                          <option value="Inctive">Inctive</option>
                        </select>
                      </div>
                      
                      <div class="form-group col-md-12">
                        <div class="form-label">Patient History</div>
                        <textarea class="form-control" placeholder="Patient History"></textarea>
                      </div>
                      <div class="form-group text-end mb-0"><a class="btn btn-sm btn-primary" href="javascript:void(0);">Submit</a><a class="btn btn-sm btn-danger ml-8" href="javascript:void(0);">Cancel</a></div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- theme body end-->
    </div>
    
    <!-- footer start-->
     <?php include "includes/footer.php"; ?>
        <div class="scroll-top"><i class="fa fa-angle-double-up"></i></div>
    <!-- footer end-->
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
      <!-- select 2 js-->
      <script src="../assets/js/vendors/select2/select2.min.js"></script>
      <script src="../assets/js/vendors/select2/custom-select2.js"> </script>
      <!-- datepicker-->
      <script src="../assets/js/vendors/datepicker/datepicker.js"></script>
      <script src="../assets/js/vendors/datepicker/datepicker.en.js"></script>
      <script src="../assets/js/vendors/datepicker/custom-datepicker.js"></script>
      <!-- Custom script-->
      <script src="../assets/js/custom-script.js"></script>

<script>
    document.getElementById('birthday').addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, ''); // Remove non-digits
        if (value.length > 4) {
            value = value.slice(0, 4) + '-' + value.slice(4);
        }
        if (value.length > 7) {
            value = value.slice(0, 7) + '-' + value.slice(7);
        }
        e.target.value = value.slice(0, 10); // Limit to 10 characters (yyyy-mm-dd)
    });
</script>

  </body>
</html>