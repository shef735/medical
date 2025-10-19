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
                  <h4>Personal Information</h4>
                </div>
                <div class="card-body"> 
                  <form>
                    <div class="row">
                      <div class="form-group col-md-4">
                        <div class="form-label">First Name</div>
                        <input class="form-control" type="text" placeholder="First Name">
                      </div>
                      <div class="form-group col-md-4">
                        <div class="form-label">last name</div>
                        <input class="form-control" type="text" placeholder="Last Name">
                      </div>
                      <div class="form-group col-md-4">
                        <div class="form-label">Date of Birth</div>
                        <input class="datepicker-here form-control" type="text" value="" data-date-format="dd/mm/yyyy" data-language="en" placeholder="DD/MM/YYYY">
                      </div>
                      <div class="form-group col-md-4">
                        <div class="form-label">Gender</div>
                        <select class="form-select">
                          <option value="Gender">Select Gender</option>
                          <option value="Male">Male</option>
                          <option value="Female">Female</option>
                        </select>
                      </div>
                      <div class="form-group col-md-4">
                        <div class="form-label">Profile Image</div>
                        <input class="form-control" type="file">
                      </div>
                      <div class="form-group col-md-4">
                        <div class="form-label">Education</div>
                        <input class="form-control" type="text" placeholder="Enter Education">
                      </div>
                      <div class="form-group col-md-4">
                        <div class="form-label">Designation</div>
                        <input class="form-control" type="text" placeholder="Enter Designation">
                      </div>
                      <div class="form-group col-md-4">
                        <div class="form-label">Department</div>
                        <select class="form-select hidesearch" name="Department[]">
                          <option value="Audiologists">Audiologists</option>
                          <option value="Cardiologists">Cardiologists</option>
                          <option value="Endocrinologist">Endocrinologist</option>
                          <option value="Oncologists">Oncologists</option>
                          <option value="Neurology">Neurology</option>
                          <option value="Orthopedics">Orthopedics</option>
                          <option value="Gynaecology">Gynaecology</option>
                          <option value="Microbiology">Microbiology</option>
                        </select>
                      </div>
                      <div class="form-group col-md-4">
                        <div class="form-label">Website URL</div>
                        <input class="form-control" type="text" placeholder="Speciality">
                      </div>
                      <div class="form-group mb-0"><a class="btn btn-sm btn-primary" href="javascript:void(0);">Save</a><a class="btn btn-sm btn-danger ml-8" href="javascript:void(0);">Cancel</a></div>
                    </div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <h4>Doctor Account Info</h4>
                </div>
                <div class="card-body"> 
                  <form>
                    <div class="form-group">
                      <div class="form-label">Email</div>
                      <input class="form-control" type="text" placeholder="">
                    </div>
                    <div class="form-group">
                      <div class="form-label">Phone</div>
                      <input class="form-control" type="text" placeholder="">
                    </div>
                    <div class="form-group">
                      <div class="form-label">Password</div>
                      <input class="form-control" type="password" placeholder="">
                    </div>
                    <div class="form-group">
                      <div class="form-label">Confirm Password</div>
                      <input class="form-control" type="password" placeholder="">
                    </div>
                    <div class="form-group mb-0"><a class="btn btn-sm btn-primary" href="javascript:void(0);">Save</a><a class="btn btn-sm btn-danger ml-8" href="javascript:void(0);">Cancel</a></div>
                  </form>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-header">
                  <h4>Doctor Social Media Info</h4>
                </div>
                <div class="card-body"> 
                  <form>
                    <div class="form-group">
                      <div class="form-label">Facebook URL</div>
                      <input class="form-control" type="url" value="http://www.facebook.com/">
                    </div>
                    <div class="form-group">
                      <div class="form-label">Twitter URL</div>
                      <input class="form-control" type="url" value="http://www.twitter.com/">
                    </div>
                    <div class="form-group">
                      <div class="form-label">Instagram URL</div>
                      <input class="form-control" type="url" value="http://www.instagram.com/">
                    </div>
                    <div class="form-group">
                      <div class="form-label">Google Plus URL</div>
                      <input class="form-control" type="url" value="http://www.plus.google.com">
                    </div>
                    <div class="form-group mb-0"><a class="btn btn-sm btn-primary" href="javascript:void(0);">Save</a><a class="btn btn-sm btn-danger ml-8" href="javascript:void(0);">Cancel</a></div>
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
  </body>
</html>