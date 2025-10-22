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
                        <div class="form-label">Profile Image             </div>
                        <input class="form-control" type="file">
                      </div>
                      <div class="form-group col-md-4">
                        <div class="form-label">First Name             </div>
                        <input class="form-control" type="text" value="Sarah">
                      </div>
                      <div class="form-group col-md-4">
                        <div class="form-label">last name             </div>
                        <input class="form-control" type="text" value="Smith">
                      </div>
                      <div class="form-group col-md-4">
                        <div class="form-label">Date of Birth                                     </div>
                        <input class="datepicker-here form-control" type="text" value="10/12/1999" data-date-format="dd/mm/yyyy" data-language="en">
                      </div>
                      <div class="form-group col-md-4">
                        <div class="form-label">Age            </div>
                        <input class="form-control" type="text" value="25">
                      </div>
                      <div class="form-group col-md-4">
                        <div class="form-label">Gender             </div>
                        <select class="form-select">
                          <option value="Gender">Select Gender</option>
                          <option value="Male">Male</option>
                          <option value="Female" selected>Female</option>
                        </select>
                      </div>
                      <div class="form-group col-md-4">
                        <div class="form-label">Blood Group</div>
                        <select class="form-select hidesearch" name="bloodgroup[]">
                          <option value="">Select Blood Group</option>
                          <option value="A+">A+</option>
                          <option value="A-">A-</option>
                          <option value="B+">B+</option>
                          <option value="B-">B-</option>
                          <option value="O+" selected>O+</option>
                          <option value="O-">O-</option>
                          <option value="AB+">AB+</option>
                          <option value="AB-">AB-</option>
                        </select>
                      </div>
                      <div class="form-group col-md-4">
                        <div class="form-label">Marital status</div>
                        <select class="form-select hidesearch" name="Maritalstatus[]">
                          <option value="Maritalstatus">Select Marital status</option>
                          <option value="Married">Married</option>
                          <option value="Unmarried" selected>Unmarried</option>
                        </select>
                      </div>
                      <div class="form-group col-md-4">
                        <div class="form-label">Patient Weight</div>
                        <input class="form-control" type="text" value="68 kg">
                      </div>
                      <div class="form-group col-md-4">
                        <div class="form-label">Patient Height</div>
                        <input class="form-control" type="text" value="5.2">
                      </div>
                      <div class="form-group col-md-4">
                        <div class="form-label">Email             </div>
                        <input class="form-control" type="text" value="example@email.com">
                      </div>
                      <div class="form-group col-md-4">
                        <div class="form-label">Phone             </div>
                        <input class="form-control" type="tel" value="+1 50 456XXX">
                      </div>
                      <div class="form-group col-md-4">
                        <div class="form-label">City</div>
                        <select class="form-select hidesearch" name="bloodgroup[]">
                          <option value="">Select City</option>
                          <option value="Tokyo">Tokyo</option>
                          <option value="Dubai">Dubai</option>
                          <option value="Barcelona" selected>Barcelona</option>
                          <option value="Rome">Rome</option>
                          <option value="Singapore">Singapore</option>
                          <option value="Amsterdam">Amsterdam</option>
                          <option value="NewYork">New York   </option>
                        </select>
                      </div>
                      <div class="form-group col-md-4">
                        <div class="form-label">State</div>
                        <select class="form-select hidesearch" name="State[]">
                          <option value="">Select State</option>
                          <option value="Washington">Washington</option>
                          <option value="Minnesota" selected>Minnesota</option>
                          <option value="Utah">Utah</option>
                          <option value="Idaho">Idaho</option>
                        </select>
                      </div>
                      <div class="form-group col-md-4">
                        <div class="form-label">Country</div>
                        <select class="form-select hidesearch" name="Country[]">
                          <option value="">Select Country</option>
                          <option value="japan" selected>japan</option>
                          <option value="india">india</option>
                          <option value="uk">uk</option>
                          <option value="itly">itly</option>
                          <option value="usa">usa</option>
                        </select>
                      </div>
                      <div class="form-group col-md-4">
                        <div class="form-label">Postal/zip Code</div>
                        <input class="form-control" type="text" value="395008">
                      </div>
                      <div class="form-group col-md-4">
                        <div class="form-label">Status</div>
                        <select class="form-select hidesearch" name="patientStatus[]">
                          <option value="">Select Status</option>
                          <option value="active" selected>Active</option>
                          <option value="Inctive">Inctive</option>
                        </select>
                      </div>
                      <div class="form-group col-md-6">
                        <div class="form-label">Address             </div>
                        <textarea class="form-control">463 Avenida Doutor José Singer,6- Conjunto Residencial Humaitá, São Vicente, SP, Brasil</textarea>
                      </div>
                      <div class="form-group col-md-6">
                        <div class="form-label">Patient History</div>
                        <textarea class="form-control">is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy</textarea>
                      </div>
                      <div class="form-group text-end mb-0">                    <a class="btn btn-sm btn-primary" href="javascript:void(0);">Submit</a><a class="btn btn-sm btn-danger ml-8" href="javascript:void(0);">Cancle    </a></div>
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
  </body>
</html>