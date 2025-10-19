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
                  <li class="breadcrumb-item"><a href="index.html">
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
                <div class="card-body">
                
                <!--<a class="btn btn-primary float-end mb-15" 
                href="javascript:void(0);" data-bs-toggle="modal" 
                data-bs-target="#appoitmentmodal">Add new Appoitment</a> -->

 


        <a class="btn btn-primary float-end mb-15" href="javascript:void(0);" 
     onclick="window.open('../../scheduler/admin/', '_blank');">Add new Appointment</a>
             
                  <table class="patients-tbl table" style="width:100%;">
                    <thead>
                      <tr>
                        <th>Patient</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Date</th>
                        <th>Time </th>
                        <th>Doctor</th>
                      <!--  <th>Action</th> -->
                      </tr>
                    </thead>
                    <tbody>
                      
                   
                 
                <?php

                $query = "SELECT * FROM ".$my_tables_use_check."_resources.appointments"; 
              
                $query = mysqli_query($db_connection, $query);
                
                  while ($company = mysqli_fetch_array($query)){

                                
                       echo '<tr>';
                        echo '<td>'.substr($company['fullname'], (strpos($company['fullname'], '- ') ?: -1) + 1).'</td>';
                        echo '<td>'.$company['phone'].'</td>';
                        echo '<td>'.$company['email'].'</td>';
                        echo '<td>'.$company['date_only'].'</td>';
                        echo '<td>'.$company['time_only'].'</td>';
                        echo '<td> '.$company['doctor'].'</span></td>';
         //     echo '<td><a href="edit-appointment.php"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>'; 

         
                     echo '</tr>';    
                            
                  
                  }

                ?>



                    
                 
                   
                   
                      
                    </tbody>
                  </table>
                </div>
                <!-- Patient Modal Start-->
                <div class="modal fade" id="appoitmentmodal">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Add New Appointment               </h5>
                      </div>
                      <div class="modal-body">
                        <form>
                          <div class="row">
                            <div class="form-group col-md-6">
                              <label class="form-label">First Name</label>
                              <input class="form-control" type="text" placeholder="Patient First Name">
                            </div>
                            <div class="form-group col-md-6">
                              <label class="form-label">Last Name</label>
                              <input class="form-control" type="text" placeholder="Patient Last Name">
                            </div>
                            <div class="form-group col-md-6">
                              <div class="form-label">Phone                                  </div>
                              <input class="form-control" type="text" required="" placeholder="Phone Number">
                            </div>
                            <div class="form-group col-md-6">
                              <label class="form-label">Email</label>
                              <input class="form-control" type="text" required="" placeholder="Email Id">
                            </div>
                            <div class="form-group col-md-6">
                              <label class="form-label">Date</label>
                              <input class="datepicker-here form-control" type="text" placeholder="DD/MM/YYYY" data-date-format="dd/mm/yyyy" data-language="en">
                            </div>
                            <div class="form-group col-md-6">
                              <div class="form-label">Appointment Time</div>
                              <input class="form-control" type="time">
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
                <!-- Patient Modal Start-->
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