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
    <!--Datatable-->
    <link href="../assets/css/vendor/datatable/jquery.dataTables.min.css" rel="stylesheet">
    <link href="../assets/css/vendor/datatable/buttons.dataTables.min.css" rel="stylesheet">
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
      <!-- breadcrumb start-->
        <div class="codex-breadcrumb">
          <div class="container-fluid">
            <div class="breadcrumb-contain">
              <div class="left-breadcrumb">
                <ul class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="index.php">
                      <h1>Dashboard</h1></a></li>
                  <li class="breadcrumb-item"><a href="javascript:void(0);">application</a></li>
                  <li class="breadcrumb-item active"><a href="javascript:void(0);">Datatable Advance</a></li>
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
      <div class="theme-body codex-chat">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">  
                <div class="card-body"><a class="btn btn-primary float-end mb-15" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#adddoctormodal"> <i class="ti-plus fw-700 mr-10"></i>Add Doctor</a>
                  <table class="doctorslist-tbl table" id="doctorslist-tbl" style="width:100%;">
                    <thead>
                      <tr>
                        <th>Name</th>
                        <th>Department</th>
                        <th>Specialization</th>
                        <th>Degree</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Joining Date</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>
                          <div class="d-flex align-items-center"><img class="img-fluid rounded-50 w-40" src="../assets/images/avtar/1.jpg" alt=""><span class="ml-10">Dr. Tiger Nixon</span></div>
                        </td>
                        <td>Otolaryngology</td>
                        <td>infertility</td>
                        <td>M.B.B.S,M.S</td>
                        <td>+1 50 456589</td>
                        <td>example@email.com</td>
                        <td>04/25/2023</td>
                        <td><a href="edit-doctor.php"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                      </tr>
                      <tr>
                        <td>
                          <div class="d-flex align-items-center"><img class="img-fluid rounded-50 w-40" src="../assets/images/avtar/2.jpg" alt=""><span class="ml-10">Dr. Anna Mull</span></div>
                        </td>
                        <td>Cardiologists</td>
                        <td>Prostate</td>
                        <td>M.B.B.S</td>
                        <td>+1 25 962689</td>
                        <td>example@email.com</td>
                        <td>05/21/2023</td>
                        <td><a href="edit-doctor.php"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2">                        </i></a></td>
                      </tr>
                      <tr>
                        <td>
                          <div class="d-flex align-items-center"><img class="img-fluid rounded-50 w-40" src="../assets/images/avtar/3.jpg" alt=""><span class="ml-10">Dr. Paul Molive</span></div>
                        </td>
                        <td>Heart Surgeons</td>
                        <td>infertility</td>
                        <td>M.B.B.S,M.S</td>
                        <td>+1 30 654589</td>
                        <td>example@email.com</td>
                        <td>10/12/2023</td>
                        <td><a href="edit-doctor.php"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                      </tr>
                      <tr>
                        <td>
                          <div class="d-flex align-items-center"><img class="img-fluid rounded-50 w-40" src="../assets/images/avtar/4.jpg" alt=""><span class="ml-10">Dr. Terry Aki</span></div>
                        </td>
                        <td>Medicine Specialists</td>
                        <td>Kidney</td>
                        <td>M.B.B.S</td>
                        <td>+1 55 894565</td>
                        <td>example@email.com</td>
                        <td>12/02/2023</td>
                        <td><a href="edit-doctor.php"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                      </tr>
                      <tr>
                        <td>
                          <div class="d-flex align-items-center"><img class="img-fluid rounded-50 w-40" src="../assets/images/avtar/5.jpg" alt=""><span class="ml-10">Dr. Poppa Cherry</span></div>
                        </td>
                        <td>Family Physicians</td>
                        <td>cancer</td>
                        <td>M.B.B.S,M.S</td>
                        <td>+1 45 506589</td>
                        <td>example@email.com</td>
                        <td>05/19/2023</td>
                        <td><a href="edit-doctor.php"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                      </tr>
                      <tr>
                        <td>
                          <div class="d-flex align-items-center"><img class="img-fluid rounded-50 w-40" src="../assets/images/avtar/6.jpg" alt=""><span class="ml-10">Dr. Saul T. Balls</span></div>
                        </td>
                        <td>Gynaecology</td>
                        <td>infertility</td>
                        <td>M.B.B.S,M.S</td>
                        <td>+1 50 456589</td>
                        <td>example@email.com</td>
                        <td>04/25/2023</td>
                        <td><a href="edit-doctor.php"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                      </tr>
                      <tr>
                        <td>
                          <div class="d-flex align-items-center"><img class="img-fluid rounded-50 w-40" src="../assets/images/avtar/7.jpg" alt=""><span class="ml-10">Dr. Hal Appeno</span></div>
                        </td>
                        <td>Eye Special</td>
                        <td>Dental </td>
                        <td>M.B.B.S,M.S</td>
                        <td>+1 66 282089</td>
                        <td>example@email.com</td>
                        <td>03/29/2023</td>
                        <td><a href="edit-doctor.php"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                      </tr>
                      <tr>
                        <td>
                          <div class="d-flex align-items-center"><img class="img-fluid rounded-50 w-40" src="../assets/images/avtar/8.jpg" alt=""><span class="ml-10">Dr. Polly Tech</span></div>
                        </td>
                        <td>Medicine Specialists</td>
                        <td>Radiology</td>
                        <td>M.B.B.S</td>
                        <td>+1 22 252889</td>
                        <td>example@email.com</td>
                        <td>08/17/2023</td>
                        <td><a href="edit-doctor.php"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                      </tr>
                      <tr>
                        <td>
                          <div class="d-flex align-items-center"><img class="img-fluid rounded-50 w-40" src="../assets/images/avtar/9.jpg" alt=""><span class="ml-10">Dr. Pat Agonia</span></div>
                        </td>
                        <td>Therapy Special</td>
                        <td>infertility</td>
                        <td>M.B.B.S,M.S</td>
                        <td>+1 50 456589</td>
                        <td>example@email.com</td>
                        <td>04/25/2023</td>
                        <td><a href="edit-doctor.php"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                      </tr>
                    </tbody>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center"><img class="img-fluid rounded-50 w-40" src="../assets/images/avtar/10.jpg" alt=""><span class="ml-10"> Dr.William Stephin</span></div>
                      </td>
                      <td>Gynocolgy</td>
                      <td>Prostate</td>
                      <td>M.B.B.S,M.S</td>
                      <td>+1 50 456589</td>
                      <td>example@email.com</td>
                      <td>04/25/2023</td>
                      <td><a href="edit-doctor.php"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center"><img class="img-fluid rounded-50 w-40" src="../assets/images/avtar/11.jpg" alt=""><span class="ml-10">Dr.Angelica Ramos</span></div>
                      </td>
                      <td>Urology</td>
                      <td>Ear, Nose</td>
                      <td>M.B.B.S</td>
                      <td>+1 50 456589</td>
                      <td>example@email.com</td>
                      <td>04/25/2023</td>
                      <td><a href="edit-doctor.php"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center"><img class="img-fluid rounded-50 w-40" src="../assets/images/avtar/12.jpg" alt=""><span class="ml-10">Dr.Sarah Smith</span></div>
                      </td>
                      <td>Dentist</td>
                      <td>Dental </td>
                      <td>M.B.B.S,M.S</td>
                      <td>+1 50 456589</td>
                      <td>example@email.com</td>
                      <td>04/25/2023</td>
                      <td><a href="edit-doctor.php"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                    </tr>
                    <tr>
                      <td>
                        <div class="d-flex align-items-center"><img class="img-fluid rounded-50 w-40" src="../assets/images/avtar/13.jpg" alt=""><span class="ml-10">Cristina Groves</span></div>
                      </td>
                      <td>Otolaryngology</td>
                      <td>Infertility </td>
                      <td>M.B.B.S,M.S</td>
                      <td>+1 50 456589</td>
                      <td>example@email.com</td>
                      <td>04/25/2023</td>
                      <td><a href="edit-doctor.php"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                    </tr>
                  </table>
                </div>
                <!-- Doctor Modal Start-->
                <div class="modal fade" id="adddoctormodal">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Add New Doctor               </h5>
                      </div>
                      <div class="modal-body">
                        <form>
                          <div class="row">
                            <div class="form-group col-md-6">
                              <label class="form-label">Name</label>
                              <input class="form-control" type="text" placeholder="Enter Doctor Name">
                            </div>
                            <div class="form-group col-md-6">
                              <label class="form-label">Department</label>
                              <input class="form-control" type="text" required="" placeholder="Department">
                            </div>
                            <div class="form-group col-md-6">
                              <label class="form-label">Specialization</label>
                              <input class="form-control" type="text" required="" placeholder="Specialization">
                            </div>
                            <div class="form-group col-md-6">
                              <label class="form-label">Degree</label>
                              <input class="form-control" type="text" required="" placeholder="Degree">
                            </div>
                            <div class="form-group col-md-6">
                              <label class="form-label">Mobile</label>
                              <input class="form-control" type="text" required="" placeholder="Mobile Number">
                            </div>
                            <div class="form-group col-md-6">
                              <label class="form-label">Email</label>
                              <input class="form-control" type="text" required="" placeholder="Email Id">
                            </div>
                            <div class="form-group col-md-6">
                              <div class="form-label">Joining Date                                     </div>
                              <input class="datepicker-here form-control" type="text" placeholder="DD/MM/YYYY" data-date-format="dd/mm/yyyy" data-language="en">
                            </div>
                          </div>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button class="btn btn-primary" type="button">Save</button>
                        <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
                </div>
                <!-- Doctor Modal Start-->
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- theme body end-->
    </div>
    <!-- footer start-->
      <footer class="codex-footer">
        <p>Copyright 2022-23 © medixo All rights reserved.</p>
      </footer>
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
      <!-- datepicker-->
      <script src="../assets/js/vendors/datepicker/datepicker.js"></script>
      <script src="../assets/js/vendors/datepicker/datepicker.en.js"></script>
      <script src="../assets/js/vendors/datepicker/custom-datepicker.js"></script>
      <!-- Datatable  -->
      <script src="../assets/js/vendors/datatable/jquery.dataTables.min.js"> </script>
      <script src="../assets/js/vendors/datatable/dataTables.buttons.min.js"></script>
      <script src="../assets/js/vendors/datatable/buttons.print.min.js"> </script>
      <script src="../assets/js/vendors/datatable/buttons.html5.min.js"> </script>
      <script src="../assets/js/vendors/datatable/pdfmake.min.js"></script>
      <script src="../assets/js/vendors/datatable/vfs_fonts.js"> </script>
      <script src="../assets/js/vendors/datatable/jszip.min.js"></script>
      <script src="../assets/js/vendors/datatable/custom-datatable.js"> </script>
      <!-- Custom script-->
      <script src="../assets/js/custom-script.js"></script>
  </body>
</html>