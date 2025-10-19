<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>


<?php

ini_set('display_errors', 1);
error_reporting(E_ALL);

$_SESSION['system_name']="M-One Solutions";
	$presentdate=date('Y-m-d');


  function formatDate($dateString) {
    // Convert the date string to a timestamp
    $timestamp = strtotime($dateString);
    if ($timestamp === false) {
        return "Invalid date format";
    }

    // Format the timestamp into the desired output
    return date("M d, Y", $timestamp);
}



 

$presentdate=date('Y-m-d');
if(!isset($_SESSION['user_name'])) {

    echo "<script>window.location = 'login.php'</script>";


} 
 

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="utf-8">
    <meta http-equiv="refresh" name="viewport" content="width=device-width, initial-scale=1">
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
    <!-- Slick slider-->
    <link href="../assets/css/vendor/slider/slick-slider/slick.css" rel="stylesheet">
    <link href="../assets/css/vendor/slider/slick-slider/slick-theme.css" rel="stylesheet">
    <!-- Scrollbar-->
    <link href="../assets/css/vendor/simplebar.css" rel="stylesheet">
    <!-- Bootstrap css-->
    <link href="../assets/css/vendor/bootstrap.css" rel="stylesheet">
    <!-- Custom css-->
    <link href="../assets/css/style.css" rel="stylesheet">

     <link href="../assets/css/vendor/datepicker/datepicker.css" rel="stylesheet">
    <!-- select 2 css-->
    <link href="../assets/css/vendor/select2/select2.min.css" rel="stylesheet">
    <!--Datatable-->
    <link href="../assets/css/vendor/datatable/jquery.dataTables.min.css" rel="stylesheet">
    <link href="../assets/css/vendor/datatable/buttons.dataTables.min.css" rel="stylesheet">
 

<?php 




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
                <li class="breadcrumb-item active"><a href="javascript:void(0);">Default</a></li>
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

    <?php
    $result_trans90_check= mysqli_query($conn,"SELECT 
      SUM(CASE WHEN UPPER(SUBSTRING_INDEX(diagnosis1,' ',1)) = 'UC' THEN 1 ELSE 0 END) AS uc,
      SUM(CASE WHEN UPPER(SUBSTRING_INDEX(diagnosis1,' ',1)) = 'CD' THEN 1 ELSE 0 END) AS cd 
     
        FROM  ".$my_tables_use."_resources.record_diagnosis");
    $row_series = mysqli_fetch_assoc($result_trans90_check);			


     $result_trans90_checkbio = mysqli_query($conn,"SELECT 
      SUM(CASE WHEN UPPER(biological) = 'ENTYVIO' THEN 1 ELSE 0 END) AS entyvio,
         SUM(CASE WHEN UPPER(biological) = 'REMSIMA' THEN 1 ELSE 0 END) AS remsima,
          SUM(CASE WHEN UPPER(biological) = 'STELARA' THEN 1 ELSE 0 END) AS stelara    
        FROM  ".$my_tables_use."_resources.patient_biological");
    $row_seriesbio = mysqli_fetch_assoc($result_trans90_checkbio );			
          
    ?>


      <div class="theme-body common-dash" data-simplebar>
        <div class="container-fluid">
          
          <div class="col-lg-12">
              <div class="row">
                
                <div class="col-sm-4">
                  <div class="card hosinfo-count">
                   <a class="text-success ml-8" href="ibd-load.php?ibd=UC">
                    <div class="card-body">
                      <div class="media">
                        <div class="icon-wrap bg-success"><i class="icofont-medicine"></i></div>
                        <div class="count-detail">
                          <h3><span class="counter mr-5"><?php echo number_format((float)$row_series['uc'],2) ?></span> </h3>
                          <p>Ulcerative Colitis</p>
                        </div>
                      </div>
                    </div>
                   </a>
                  </div>
                </div>


                <div class="col-sm-4">
                   
                  
              
                  <div class="card hosinfo-count">
                   <a class="text-success ml-8" href="ibd-load.php?ibd=CD">
                    <div class="card-body">
                      <div class="media">
                        <div class="icon-wrap bg-secondary"><i class="icofont-medicine"></i></div>
                        <div class="count-detail">
                          <h3><span class="counter mr-5"><?php echo number_format((float)$row_series['cd'],2) ?></span> </h3>
                          <p>Crohn's Disease</p>
                        </div>
                      </div>
                    </div>
                   </a>
                  </div>
                     
                </div>

                <div class="col-sm-4">
                  <div class="card hosinfo-count">
                    <div class="card-body">
                      <div class="media">
                        <div class="icon-wrap bg-success"><i class="icofont-prescription"></i></div>
                        <div class="count-detail">
                          <h3><span class="counter mr-5"><?php echo number_format((float)$row_series['uc']+(float)$row_series['cd'],2) ?></span> </h3>
                          <p>Total IBD</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
           
              </div>
          </div>
 




            <?php  include "includes/sched-today.php"; ?>


           


 


       <!--     <div class="col-xxl-8 col-lg-7">
              <div class="card earning-chart">
                <div class="card-header">
                  <h4>Patient Count</h4>
                  <div class="setting-card action-menu"><a class="action-toggle" href="javascript:void(0)"><i class="codeCopy" data-feather="more-horizontal"></i></a>
                    <ul class="action-dropdown">
                      <li><a href="javascript:void(0);"><i class="fa fa-calendar-o"></i>weekly</a></li>
                      <li><a href="javascript:void(0);"><i class="fa fa-calendar-check-o"></i>monthly</a></li>
                      <li><a href="javascript:void(0);"><i class="fa fa-calendar"></i>yearly</a></li>
                    </ul>
                  </div>
                </div>
                <div class="card-body">
                  <div id="hospitalsurvay"></div>
                </div>
              </div>
            </div>

            <div class="col-xxl-4 col-lg-5">
              <div class="card">
                <div class="card-header">
                  <h4>Notifications</h4>
                </div>
                <div class="card-body">
                  <ul class="docnoti-list dashnoti-list" data-simplebar>
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
                        <div class="badge badge-primary">05:26 Am</div>
                      </div>
                    </li>
                  </ul>
                </div>
                <div class="card-footer"><a class="btn btn-primary d-block mx-auto btn-lg" href="javascript:void(0)">See All Notification</a></div>
              </div>
            </div>
            <div class="col-xxl-4 col-lg-5">
              <div class="card recentpatient-card">
                <div class="card-header">
                  <h4>Recent Patient</h4>
                  <div class="setting-card action-menu"><a class="action-toggle" href="javascript:void(0)"><i class="codeCopy" data-feather="more-horizontal"></i></a>
                    <ul class="action-dropdown">
                      <li><a href="javascript:void(0);"><i class="fa fa-calendar-o"></i>weekly</a></li>
                      <li><a href="javascript:void(0);"><i class="fa fa-calendar-check-o"></i>monthly</a></li>
                      <li><a href="javascript:void(0);"><i class="fa fa-calendar"></i>yearly</a></li>
                    </ul>
                  </div>
                </div>
                <div class="card-body">
                  <div class="table-responsive">
                    <table class="table">
                      <tbody>
                        <tr>
                          <td class="pt-0">
                            <div class="media">
                              <div class="badgeavtar bg-primary">J</div>
                              <div class="media-body ml-10">
                                <h6 class="text-default">Jordan Nt</h6>
                                <p class="text-light">41 Years Old</p>
                              </div>
                            </div>
                          </td>
                          <td class="pt-0"><span class="badge badge-success">Recovered</span></td>
                        </tr>
                        <tr>
                          <td>
                            <div class="media">
                              <div class="badgeavtar bg-secondary">A</div>
                              <div class="media-body ml-10">
                                <h6 class="text-default">Angela Nurhayati</h6>
                                <p class="text-light">41 Years Old</p>
                              </div>
                            </div>
                          </td>
                          <td> <span class="badge badge-success">New Patient</span></td>
                        </tr>
                        <tr>
                          <td>
                            <div class="media">
                              <div class="badgeavtar bg-success">T</div>
                              <div class="media-body ml-10">
                                <h6 class="text-default">Thomas Jaja</h6>
                                <p class="text-light">28 Years Old</p>
                              </div>
                            </div>
                          </td>
                          <td> <span class="badge badge-warning">On Recovery</span></td>
                        </tr>
                        <tr>
                          <td>
                            <div class="media">
                              <div class="badgeavtar bg-warning">J</div>
                              <div class="media-body ml-10">
                                <h6 class="text-default">Jordan Nt</h6>
                                <p class="text-light">20 Years Old</p>
                              </div>
                            </div>
                          </td>
                          <td> <span class="badge badge-info">Treatment</span></td>
                        </tr>
                        <tr>
                          <td>
                            <div class="media">
                              <div class="badgeavtar bg-info">J</div>
                              <div class="media-body ml-10">
                                <h6 class="text-default">Jordan Nt</h6>
                                <p class="text-light">30 Years Old</p>
                              </div>
                            </div>
                          </td>
                          <td> <span class="badge badge-warning">On Recovery</span></td>
                        </tr>
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xxl-8 col-lg-7">
              <div class="card toprated-doctor">
                <div class="card-header">
                  <h4>Top Rated Doctors</h4>
                </div>
                <div class="card-body">
                  <div class="ratedoctor-slide">
                    <div>
                      <div class="hosdoct-grid">
                        <div class="img-wrap"><img class="img-fluid" src="../assets/images/avtar/1.jpg" alt=""></div>
                        <div class="doct-detail">
                          <h4>Dr. Anna Mull</h4><span> Cardiologists</span>
                          <p>20 Bowman St, South Windsor, Mt 39508</p>
                          <ul class="codex-soclist">
                            <li><a href="javascript:void(0);"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="javascript:void(0);"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="javascript:void(0);"><i class="fa fa-instagram"></i></a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div>
                      <div class="hosdoct-grid">
                        <div class="img-wrap"><img class="img-fluid" src="../assets/images/avtar/2.jpg" alt=""></div>
                        <div class="doct-detail">
                          <h4>Dr. Anna Mull</h4><span> Cardiologists</span>
                          <p>50 Bowman St, South Windsor, Mt 39508</p>
                          <ul class="codex-soclist">
                            <li><a href="javascript:void(0);"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="javascript:void(0);"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="javascript:void(0);"><i class="fa fa-instagram"></i></a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div>
                      <div class="hosdoct-grid">
                        <div class="img-wrap"><img class="img-fluid" src="../assets/images/avtar/3.jpg" alt=""></div>
                        <div class="doct-detail">
                          <h4>Dr. Anna Mull</h4><span> Cardiologists</span>
                          <p>30 Bowman St, South Windsor, Mt 39508</p>
                          <ul class="codex-soclist">
                            <li><a href="javascript:void(0);"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="javascript:void(0);"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="javascript:void(0);"><i class="fa fa-instagram"></i></a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div>
                      <div class="hosdoct-grid">
                        <div class="img-wrap"><img class="img-fluid" src="../assets/images/avtar/4.jpg" alt=""></div>
                        <div class="doct-detail">
                          <h4>Dr. Anna Mull</h4><span> Cardiologists</span>
                          <p>30 Bowman St, South Windsor, Mt 39508</p>
                          <ul class="codex-soclist">
                            <li><a href="javascript:void(0);"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="javascript:void(0);"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="javascript:void(0);"><i class="fa fa-instagram"></i></a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div>
                      <div class="hosdoct-grid">
                        <div class="img-wrap"><img class="img-fluid" src="../assets/images/avtar/5.jpg" alt=""></div>
                        <div class="doct-detail">
                          <h4>Dr. Anna Mull</h4><span> Cardiologists</span>
                          <p>30 Bowman St, South Windsor, Mt 39508</p>
                          <ul class="codex-soclist">
                            <li><a href="javascript:void(0);"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="javascript:void(0);"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="javascript:void(0);"><i class="fa fa-instagram"></i></a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                    <div>
                      <div class="hosdoct-grid">
                        <div class="img-wrap"><img class="img-fluid" src="../assets/images/avtar/6.jpg" alt=""></div>
                        <div class="doct-detail">
                          <h4>Dr. Anna Mull</h4><span> Cardiologists</span>
                          <p>30 Bowman St, South Windsor, Mt 39508</p>
                          <ul class="codex-soclist">
                            <li><a href="javascript:void(0);"><i class="fa fa-facebook"></i></a></li>
                            <li><a href="javascript:void(0);"><i class="fa fa-twitter"></i></a></li>
                            <li><a href="javascript:void(0);"><i class="fa fa-instagram"></i></a></li>
                          </ul>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="card visitor-performance">
                <div class="card-header">
                  <h4>Operation Success Rate</h4>
                  <div class="setting-card action-menu"><a class="action-toggle" href="javascript:void(0)"><i class="codeCopy" data-feather="more-horizontal"></i></a>
                    <ul class="action-dropdown">
                      <li><a href="javascript:void(0);"><i class="fa fa-calendar-o"></i>weekly</a></li>
                      <li><a href="javascript:void(0);"><i class="fa fa-calendar-check-o"></i>monthly</a></li>
                      <li><a href="javascript:void(0);"><i class="fa fa-calendar"></i>yearly</a></li>
                    </ul>
                  </div>
                </div>
                <div class="card-body">
                  <div id="recoverystatistics"></div>
                </div>
              </div>
            </div>
            <div class="col-lg-6">
              <div class="card visitor-ratetbl">
                <div class="card-header">
                  <h4>Common Diseases Report</h4>
                  <div class="setting-card action-menu"><a class="action-toggle" href="javascript:void(0)"><i class="codeCopy" data-feather="more-horizontal"></i></a>
                    <ul class="action-dropdown">
                      <li><a href="javascript:void(0);"><i class="fa fa-calendar-o"></i>weekly</a></li>
                      <li><a href="javascript:void(0);"><i class="fa fa-calendar-check-o"></i>monthly</a></li>
                      <li><a href="javascript:void(0);"><i class="fa fa-calendar"></i>yearly</a></li>
                    </ul>
                  </div>
                </div>
                <div class="card-body p-0">
                  <div id="diseasesreport"></div>
                </div>
              </div>
            </div> -->

       
           
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
      <!--<script src="../assets/js/vendors/simplebar.js"></script>-->
      <!-- apex chart-->
     <!-- <script src="../assets/js/vendors/chart/apexcharts.js"></script> -->
      <!-- slick slider-->
      <script src="../assets/js/vendors/slider/slick-sldier/slick.min.js"></script>
      <!-- hospital dashboard js-->
    <!--  <script src="../assets/js/dashboard/hospital-dashboard.js"></script> -->
      <!-- Custom script-->
      <script src="../assets/js/custom-script.js"></script>

  </body>
</html>