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
    <title><?php echo $_SESSION['system_name'] ?><</title>
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
                  <li class="breadcrumb-item active"><a href="javascript:void(0);">Datatable</a></li>
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
        <div class="container-fluid">      
          <div class="row">
            <div class="col-12">
              <div class="card">  
                <div class="card-body"> <a class="btn btn-primary float-end mb-15" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#paymentmodal">Add New Payment               </a>
                  <table class="payment-tbl table">
                    <thead>
                      <tr>
                        <th>Bill No</th>
                        <th>Patient Name</th>
                        <th>Doctor Name</th>
                        <th>Bill Date</th>
                        <th>Payment Method</th>
                        <th>Status</th>
                        <th>Amout</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>01</td>
                        <td>Ashton Cox</td>
                        <td>Dr. Anna Mull</td>
                        <td>28/12/2022</td>
                        <td>Cash</td>
                        <td> <span class="badge badge-success">Paid</span></td>
                        <td>$150</td>
                        <td>                              <a href="edit-patient.php"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                      </tr>
                      <tr>
                        <td>02</td>
                        <td>Brielle Williamson</td>
                        <td>Dr. Hal Appeno</td>
                        <td>25/10/2022</td>
                        <td>Cheque</td>
                        <td> <span class="badge badge-warning">Panding</span></td>
                        <td>$200</td>
                        <td>                              <a href="edit-patient.php"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                      </tr>
                      <tr>
                        <td>03</td>
                        <td>Cedric Kelly</td>
                        <td>Dr. Pat Agonia</td>
                        <td>11/05/2022</td>
                        <td>Credit Card</td>
                        <td> <span class="badge badge-success">Paid</span></td>
                        <td>$350</td>
                        <td>                              <a href="edit-patient.php"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                      </tr>
                      <tr>
                        <td>04</td>
                        <td>Charde Marshall</td>
                        <td>Dr. Paul Molive</td>
                        <td>03/01/2023</td>
                        <td>Debit Card</td>
                        <td> <span class="badge badge-danger">Unpaid</span></td>
                        <td>$280</td>
                        <td>                              <a href="edit-patient.php"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                      </tr>
                      <tr>
                        <td>05</td>
                        <td>Dai Rios</td>
                        <td>Dr. Polly Tech</td>
                        <td>28/12/2022</td>
                        <td>Net Bancking</td>
                        <td> <span class="badge badge-danger">Unpaid</span></td>
                        <td>$150</td>
                        <td>                              <a href="edit-patient.php"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                      </tr>
                      <tr>
                        <td>06</td>
                        <td>Garrett Winters</td>
                        <td>Dr. Poppa Cherry</td>
                        <td>30/07/2022</td>
                        <td>Insurence</td>
                        <td> <span class="badge badge-warning">Panding</span></td>
                        <td>$260</td>
                        <td>                              <a href="edit-patient.php"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                      </tr>
                      <tr>
                        <td>07</td>
                        <td>Gloria Little</td>
                        <td>Dr. Saul T. Balls</td>
                        <td>20/09/2022</td>
                        <td>Cash</td>
                        <td> <span class="badge badge-warning">Panding</span></td>
                        <td>$80</td>
                        <td>                              <a href="edit-patient.php"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                      </tr>
                      <tr>
                        <td>08</td>
                        <td>Jena Gaines</td>
                        <td>Dr. Terry Aki</td>
                        <td>28/09/2022</td>
                        <td>Chaque</td>
                        <td> <span class="badge badge-danger">Unpaid</span></td>
                        <td>$500</td>
                        <td>                              <a href="edit-patient.php"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                      </tr>
                      <tr>
                        <td>09</td>
                        <td>Paul Byrd</td>
                        <td>Dr. Tiger Nixon</td>
                        <td>20/06/2022</td>
                        <td>Credit Card</td>
                        <td> <span class="badge badge-success">Paid</span></td>
                        <td>$620</td>
                        <td>                              <a href="edit-patient.php"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                      </tr>
                      <tr>
                        <td>10</td>
                        <td>Rhona Davidson</td>
                        <td>Dr.William Stephin</td>
                        <td>16/03/2022</td>
                        <td>Debit Card</td>
                        <td> <span class="badge badge-success">Paid</span></td>
                        <td>$802</td>
                        <td>                              <a href="edit-patient.php"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                      </tr>
                      <tr>
                        <td>11</td>
                        <td>Tiger Nixon</td>
                        <td>Dr.Angelica Ramos</td>
                        <td>18/08/2022</td>
                        <td>Net Banking</td>
                        <td> <span class="badge badge-success">Paid</span></td>
                        <td>$480</td>
                        <td>                              <a href="edit-patient.php"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                      </tr>
                      <tr>
                        <td>12</td>
                        <td>Ashton Cox</td>
                        <td>Dr. Anna Mull</td>
                        <td>28/12/2022</td>
                        <td>Cash</td>
                        <td> <span class="badge badge-success">Paid</span></td>
                        <td>$150</td>
                        <td>                              <a href="edit-patient.php"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                      </tr>
                      <tr>
                        <td>13</td>
                        <td>Brielle Williamson</td>
                        <td>Dr. Hal Appeno</td>
                        <td>25/10/2022</td>
                        <td>Cheque</td>
                        <td> <span class="badge badge-warning">Panding</span></td>
                        <td>$200</td>
                        <td>                              <a href="edit-patient.php"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                      </tr>
                      <tr>
                        <td>14</td>
                        <td>Cedric Kelly</td>
                        <td>Dr. Pat Agonia</td>
                        <td>11/05/2022</td>
                        <td>Credit Card</td>
                        <td> <span class="badge badge-success">Paid</span></td>
                        <td>$350</td>
                        <td>                              <a href="edit-patient.php"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
                <!-- Doctor Modal Start-->
                <div class="modal fade" id="paymentmodal">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Add New Payment               </h5>
                      </div>
                      <div class="modal-body">
                        <form>
                          <div class="row">
                            <div class="form-group col-md-6">
                              <div class="form-label">First name             </div>
                              <input class="form-control" type="text" placeholder="First Name">
                            </div>
                            <div class="form-group col-md-6">
                              <div class="form-label">last name             </div>
                              <input class="form-control" type="text" placeholder="Last Name">
                            </div>
                            <div class="form-group col-md-6">
                              <div class="form-label">Bill No</div>
                              <input class="form-control" type="text" placeholder="Enter Bill Number">
                            </div>
                            <div class="form-group col-md-6">
                              <div class="form-label">Bill Date                            </div>
                              <input class="datepicker-here form-control" type="text" value="" data-date-format="dd/mm/yyyy" data-language="en" placeholder="Bill Date">
                            </div>
                            <div class="form-group col-md-6">
                              <div class="form-label">Doctor Name</div>
                              <input class="form-control" type="text" placeholder="Enter Doctor Name">
                            </div>
                            <div class="form-group col-md-6">
                              <div class="form-label">Admit Date             </div>
                              <input class="datepicker-here form-control" type="text" value="" data-date-format="dd/mm/yyyy" data-language="en" placeholder="Enter Admit Date">
                            </div>
                            <div class="form-group col-md-6">
                              <div class="form-label">Discharge Date             </div>
                              <input class="datepicker-here form-control" type="text" value="" data-date-format="dd/mm/yyyy" data-language="en" placeholder="Enter Discharge Date">
                            </div>
                            <div class="form-group col-md-6">
                              <div class="form-label">Payment Method</div>
                              <select class="form-select hidesearch" name="Payment[]">
                                <option value="">Select Payment Method</option>
                                <option value="Cash">Cash</option>
                                <option value="Cheque">Cheque</option>
                                <option value="CreditCard">Credit Card</option>
                                <option value="DebitCard">Debit Card</option>
                                <option value="NetBancking">Net Bancking</option>
                                <option value="Insurence">Insurence                         </option>
                              </select>
                            </div>
                            <div class="form-group col-md-6">
                              <div class="form-label">Payment Status</div>
                              <select class="form-select hidesearch" name="PaymentStatus[]">
                                <option value="">Select Payment Status</option>
                                <option value="Paid">Paid</option>
                                <option value="Unpaid">Unpaid                         </option>
                                <option value="Partial">Partial</option>
                              </select>
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