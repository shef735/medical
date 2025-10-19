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
    <!-- lightbox-->
    <link href="../assets/css/vendor/light-box/fancybox.css" rel="stylesheet">
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

      <!-- sidebar end-->
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
                  <li class="breadcrumb-item active"><a href="javascript:void(0);">profile</a></li>
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
        <div class="container-fluid cdxuser-profile">
          <div class="row">                    
            <div class="col-xxl-4 col-md-6">
              <div class="card doctor-probox">                  
                <div class="img-wrap"></div>
                <div class="card-body pt-0">
                  <div class="profile-head">
                    <div class="proimg-wrap"><img class="img-fluid" src="../assets/images/avtar/1.jpg" alt=""></div>
                    <h4>Elizabeth Blackwell</h4><span>Cardiologists</span>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, </p>
                    <div class="group-btn"><a class="btn btn-primary" href="javascript:void(0);">Send Email</a><a class="btn btn-secondary" href="javascript:void(0);">Send Message</a></div>
                  </div>
                </div>
                <ul class="docactivity-list">
                  <li>
                    <h4>2000</h4><span>Operations</span>
                  </li>
                  <li>
                    <h4>99</h4><span>Hospital</span>
                  </li>
                  <li>
                    <h4>9999</h4><span>Patients</span>
                  </li>
                </ul>
              </div>
            </div>
            <div class="col-xxl-4 col-md-6">
              <div class="card">
                <div class="card-header">
                  <h4>Notifications</h4>
                </div>
                <div class="card-body">
                  <ul class="docnoti-list">
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
                        <div class="badge badge-primary">05:26 Am                   </div>
                      </div>
                    </li>
                  </ul>
                </div>
                <div class="card-footer"><a class="btn btn-primary d-block mx-auto btn-lg" href="javascript:void(0)">See All Notification</a></div>
              </div>
            </div>
            <div class="col-xxl-4 col-md-6">
              <div class="card">
                <div class="card-header">
                  <h4>Skill</h4>
                </div>
                <div class="card-body">
                  <div id="doctskill"></div>
                </div>
              </div>
            </div>
            <div class="col-xxl-4 col-md-6">
              <div class="card">
                <div class="card-header">
                  <h4>Personal Information</h4>
                </div>
                <div class="card-body">
                  <ul class="contact-list">
                    <li> 
                      <div class="iocn-item"><i data-feather="user"></i></div>
                      <h6> Alex Spencer</h6>
                    </li>
                    <li> 
                      <div class="iocn-item"><i data-feather="bookmark"></i></div>
                      <h6> Senior doctor</h6>
                    </li>
                    <li>
                      <div class="iocn-item"><i data-feather="phone-call"></i></div>
                      <h6> <a href="tel:+9588489584">+9588489584</a></h6>
                    </li>
                    <li> 
                      <div class="iocn-item"><i data-feather="mail"></i></div>
                      <h6> <a href="mailto:test@example.com">test@example.com</a></h6>
                    </li>
                    <li> 
                      <div class="iocn-item"><i data-feather="map-pin"></i></div>
                      <h6> live in uk</h6>
                    </li>
                    <li> 
                      <div class="iocn-item"><i data-feather="globe"></i></div>
                      <h6> https://medixo.com</h6>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-xxl-4 col-md-6">
              <div class="card">
                <div class="card-header">
                  <h4>Speciality</h4>
                </div>
                <div class="card-body">
                  <ul class="speciality-list">
                    <li>
                      <div class="media">
                        <div class="icon-wrap bg-primary"><i class="fa fa-trophy"></i></div>
                        <div class="media-body">
                          <h6>Certified</h6><span class="text-light">Cold Laser Operation</span>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="media">
                        <div class="icon-wrap bg-primary"><i class="fa fa-trophy"></i></div>
                        <div class="media-body">
                          <h6>professional</h6><span class="text-light">Certified Skin Treatment</span>
                        </div>
                      </div>
                    </li>
                    <li>
                      <div class="media">
                        <div class="icon-wrap bg-primary"><i class="fa fa-trophy"></i></div>
                        <div class="media-body">
                          <h6>Medication Laser</h6><span class="text-light">Hair Lose Product           </span>
                        </div>
                      </div>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-xxl-4 col-md-6">
              <div class="card doct-skill">
                <div class="card-header">
                  <h4>Doctors Abilities</h4>
                </div>
                <div class="card-body">
                  <div class="progress-group progressCounter">
                    <h6>Operations <span><span class="count">50</span>%</span></h6>
                    <div class="progress">
                      <div class="progress-bar bg-primary" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="90" style="width: 90%;"></div>
                    </div>
                  </div>
                  <div class="progress-group progressCounter">
                    <h6>Theraphy <span><span class="count">80</span>%</span></h6>
                    <div class="progress">
                      <div class="progress-bar bg-success" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="90" style="width: 90%;"></div>
                    </div>
                  </div>
                  <div class="progress-group progressCounter">
                    <h6>Mediation<span><span class="count">40</span>%</span></h6>
                    <div class="progress">
                      <div class="progress-bar bg-secondary" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="90" style="width: 90%;"></div>
                    </div>
                  </div>
                  <div class="progress-group progressCounter">
                    <h6>Colestrol<span><span class="count">60</span>%</span></h6>
                    <div class="progress">
                      <div class="progress-bar bg-info" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="90" style="width: 90%;"></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xxl-4 col-xl-12">
              <div class="card">
                <div class="card-header">
                  <h4> <i class="fa fa-picture-o"></i>Gallery</h4>
                </div>
                <div class="card-body">                   
                  <ul class="gallerypost-list">
                    <li>                      <a data-fancybox="gallery" data-src="../assets/images/pages/gallery/1.jpg" data-caption=""><img class="img-fluid" src="../assets/images/pages/gallery/1.jpg" alt="gallery"></a></li>
                    <li>                      <a data-fancybox="gallery" data-src="../assets/images/pages/gallery/2.jpg" data-caption=""><img class="img-fluid" src="../assets/images/pages/gallery/2.jpg" alt="gallery"></a></li>
                    <li>                      <a data-fancybox="gallery" data-src="../assets/images/pages/gallery/3.jpg" data-caption=""><img class="img-fluid" src="../assets/images/pages/gallery/3.jpg" alt="gallery"></a></li>
                    <li>                      <a data-fancybox="gallery" data-src="../assets/images/pages/gallery/4.jpg" data-caption=""><img class="img-fluid" src="../assets/images/pages/gallery/4.jpg" alt="gallery"></a></li>
                    <li>                      <a data-fancybox="gallery" data-src="../assets/images/pages/gallery/5.jpg" data-caption=""><img class="img-fluid" src="../assets/images/pages/gallery/5.jpg" alt="gallery"></a></li>
                    <li>                      <a data-fancybox="gallery" data-src="../assets/images/pages/gallery/6.jpg" data-caption=""><img class="img-fluid" src="../assets/images/pages/gallery/6.jpg" alt="gallery"></a></li>
                    <li>                      <a data-fancybox="gallery" data-src="../assets/images/pages/gallery/7.jpg" data-caption=""><img class="img-fluid" src="../assets/images/pages/gallery/7.jpg" alt="gallery"></a></li>
                    <li>                      <a data-fancybox="gallery" data-src="../assets/images/pages/gallery/8.jpg" data-caption=""><img class="img-fluid" src="../assets/images/pages/gallery/8.jpg" alt="gallery"></a></li>
                    <li>                      <a data-fancybox="gallery" data-src="../assets/images/pages/gallery/9.jpg" data-caption=""><img class="img-fluid" src="../assets/images/pages/gallery/9.jpg" alt="gallery"></a></li>
                  </ul>
                </div>
              </div>
            </div>
            <div class="col-xxl-8 col-xl-12">
              <div class="card">
                <div class="card-header">
                  <h4>Appointment</h4>
                </div>
                <div class="card-body">             
                  <table class="patients-tbl table" style="width:100%;">
                    <thead>
                      <tr>
                        <th>Patient</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Date</th>
                        <th>Time </th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td>Tiger Nixon</td>
                        <td>+2 40 305060</td>
                        <td>example@email.com</td>
                        <td>05/06/2023</td>
                        <td>08:00 Am</td>
                        <td> <span class="badge badge-success">start</span></td>
                        <td><a href="edit-appointment.html"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                      </tr>
                      <tr>
                        <td>Brielle Williamson</td>
                        <td>+3 20 456589</td>
                        <td>example@email.com</td>
                        <td>08/09/2023</td>
                        <td>09:00 Am                       </td>
                        <td> <span class="badge badge-success">start</span></td>
                        <td><a href="edit-appointment.html"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                      </tr>
                      <tr>
                        <td>Cedric Kelly</td>
                        <td>+1 36 121390</td>
                        <td>example@email.com</td>
                        <td>10/11/2023</td>
                        <td>10:00 Am                       </td>
                        <td> <span class="badge badge-danger">Canclled</span></td>
                        <td><a href="edit-appointment.html"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                      </tr>
                      <tr>
                        <td>Charde Marshall</td>
                        <td>+6 30 208060</td>
                        <td>example@email.com</td>
                        <td>12/06/2023</td>
                        <td>11:00 Am                       </td>
                        <td> <span class="badge badge-danger">Canclled</span></td>
                        <td><a href="edit-appointment.html"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                      </tr>
                      <tr>
                        <td>Dai Rios</td>
                        <td>+1 50 456589</td>
                        <td>example@email.com</td>
                        <td>02/02/2023</td>
                        <td>12:00 Am                       </td>
                        <td> <span class="badge badge-info">pending</span></td>
                        <td><a href="edit-appointment.html"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                      </tr>
                      <tr>
                        <td>Garrett Winters</td>
                        <td>+2 20 558890</td>
                        <td>example@email.com</td>
                        <td>08/12/2023</td>
                        <td>02:00 Pm                       </td>
                        <td> <span class="badge badge-info">pending</span></td>
                        <td><a href="edit-appointment.html"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                      </tr>
                      <tr>
                        <td>Gloria Little</td>
                        <td>+5 20 608022</td>
                        <td>example@email.com</td>
                        <td>12/02/2023</td>
                        <td>03:00 Pm                       </td>
                        <td> <span class="badge badge-warning">re schedule</span></td>
                        <td><a href="edit-appointment.html"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2"></i></a></td>
                      </tr>
                      <tr>
                        <td>Jena Gaines</td>
                        <td>+3 22 588829</td>
                        <td>example@email.com</td>
                        <td>10/12/2023</td>
                        <td>04:00 Pm                       </td>
                        <td> <span class="badge badge-warning">re schedule</span></td>
                        <td><a href="edit-appointment.html"><i class="w-18" data-feather="edit"></i></a><a class="text-danger ml-8" href="javascript:void(0);"><i class="w-18" data-feather="trash-2">                   </i></a></td>
                      </tr>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- theme body end-->
    </div>
    <!-- footer start -->
         <?php include "includes/footer.php"; ?>
        <div class="scroll-top"><i class="fa fa-angle-double-up"></i></div>
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
      <!-- apex chart-->
      <script src="../assets/js/vendors/chart/apexcharts.js"></script>
      <!-- doctor dashboard-->
      <script src="../assets/js/dashboard/doctor-dashboard.js">    </script>
      <!-- select 2 js-->
      <script src="../assets/js/vendors/select2/select2.min.js"></script>
      <script src="../assets/js/vendors/select2/custom-select2.js"> </script>
      <!-- light box-->
      <script src="../assets/js/vendors/light-box/fancybox.umd.js"></script>
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
    <!-- footer end   -->
  </body>
</html>