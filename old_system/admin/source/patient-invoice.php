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
                  <li class="breadcrumb-item"><a href="javascript:void(0);">Ecommerce</a></li>
                  <li class="breadcrumb-item active"><a href="javascript:void(0);">Invoice</a></li>
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
                <div class="card-body cdx-invoice">
                  <div id="cdx-invoice">
                    <div class="head-invoice">
                      <div class="invoice-brand">
                        <div class="codex-brand"><a class="codexbrand-logo" href="Javascript:void(0);">
                        <img class="img-fluid" style="width: 40%;" src="../assets/images/logo/logo.png" alt="invoice-logo"></a></div>
                        <ul class="contact-list">
                          <li> 
                            <p>795 Folsom Ave, Opp. Town Hall,                            <br> CA 54656<br><b>P:</b> +12345647859</p>
                          </li>
                        </ul>
                      </div>
                      <div class="invoice-user">
                        <h5>Billed to:</h5>
                        <ul class="detail-list">
                          <li>
                             name :<span>Mark Wongar</span></li>
                          <li>
                             Phone :<span>+123585844859                    </span></li>
                          <li>Address : <span>368 mega get , medixo store</span></li>
                          <li>invoice date : <span> 21/3/2022</span></li>
                          <li>invoice no : <span>21/3/2022                         </span></li>
                        </ul>
                      </div>
                    </div>
                    <div class="body-invoice">
                      <div class="table-responsive">
                        <table class="table table-bordered">
                          <thead>
                            <tr>
                              <th>No</th>
                              <th>Particulars</th>
                              <th>Charges</th>
                              <th>Discount</th>
                              <th>Amout </th>
                            </tr>
                          </thead>
                          <tbody>
                            <tr>
                              <td>01</td>
                              <td>Room Charges</td>
                              <td>$90</td>
                              <td>$10</td>
                              <td>$80</td>
                            </tr>
                            <tr>
                              <td>02</td>
                              <td>Nursign</td>
                              <td>$150</td>
                              <td>$15</td>
                              <td>$135</td>
                            </tr>
                            <tr>
                              <td>03</td>
                              <td>ICU</td>
                              <td>$90</td>
                              <td>1</td>
                              <td>$180</td>
                            </tr>
                            <tr>
                              <td>04</td>
                              <td>OT</td>
                              <td>$200</td>
                              <td>$20</td>
                              <td>$180</td>
                            </tr>
                            <tr>
                              <td>05</td>
                              <td>Medicine & Consumables</td>
                              <td>$535</td>
                              <td>$35</td>
                              <td>$500</td>
                            </tr>
                            <tr>
                              <td>06</td>
                              <td>Investigation </td>
                              <td>$480</td>
                              <td>$50</td>
                              <td>$440</td>
                            </tr>
                            <tr>
                              <td>07</td>
                              <td>Ambulance </td>
                              <td>$700</td>
                              <td>$250</td>
                              <td>$450</td>
                            </tr>
                            <tr>
                              <td>08</td>
                              <td>Miscellaneous </td>
                              <td>$570</td>
                              <td>$170</td>
                              <td>$400</td>
                            </tr>
                          </tbody>
                        </table>
                      </div>
                    </div>
                    <div class="footer-invoice">                
                      <table class="table">
                        <tr>
                          <td>Sub Total</td>
                          <td>$1400</td>
                        </tr>
                        <tr>
                          <td>tax</td>
                          <td>$250</td>
                        </tr>
                        <tr>
                          <td>Discount</td>
                          <td>$250</td>
                        </tr>
                        <tr>
                          <td>total Bill amout</td>
                          <td>$1550                 </td>
                        </tr>
                      </table>
                    </div>
                  </div>
                  <div class="invoice-action"><a class="btn btn-primary" href="javascript:void(0);" onclick="myFunction()">print invoice</a><a class="btn btn-secondary ml-15" href="javascript:void(0);">download invoice</a></div>
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
      <!-- Custom script-->
      <script src="../assets/js/custom-script.js"></script>
    <script>
      "use strict";
       function myFunction() {
           window.print();
       }
    </script>
  </body>
</html>