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
                  <li class="breadcrumb-item"><a href="javascript:void(0);">pages</a></li>
                  <li class="breadcrumb-item active"><a href="javascript:void(0);">faq</a></li>
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
        <div class="container-fluid codex-faq">
          <div class="row">        
            <div class="col-md-12">
              <div class="card faq-searchwrap">
                <div class="card-body">
                  <div>
                    <h1>how can we help you?</h1>
                    <div class="input-group">            
                      <input class="form-control" type="text" placeholder="find your question">
                      <div class="input-group-text bg-primary border-0"><i class="fa fa-search"></i></div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">              
                <div class="card-body">
                  <div class="codex-accordion accordion accordion-flush" id="install-que">
                    <div class="accordion-item">                <a class="cdx-collapse" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#cdx-collapce1">Is SeekMed app available for all platforms?</a>
                      <div class="collapse show" id="cdx-collapce1" data-bs-parent="#install-que">
                        <div class="accordion-body">
                          <p class="text-light">‘Lorem ipsum dolor sit amet, consectetur adipisici elit…’ (complete text) is dummy text that is not meant to mean anything. It is used as a placeholder in magazine layouts, for example, in order to give an impression of the finished document. The text is intentionally unintelligible so that the viewer is not distracted by the content. The language is not real Latin and even the first word ‘Lorem’ does not exist. It is said that the lorem ipsum.</p>
                        </div>
                      </div>
                    </div>
                    <div class="accordion-item">                <a class="cdx-collapse collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#cdx-collapce2">What is the registration process for doctors?</a>
                      <div class="collapse" id="cdx-collapce2" data-bs-parent="#install-que">
                        <div class="accordion-body">
                          <p class="text-light">‘Lorem ipsum dolor sit amet, consectetur adipisici elit…’ (complete text) is dummy text that is not meant to mean anything. It is used as a placeholder in magazine layouts, for example, in order to give an impression of the finished document. The text is intentionally unintelligible so that the viewer is not distracted by the content. The language is not real Latin and even the first word ‘Lorem’ does not exist. It is said that the lorem ipsum.</p>
                        </div>
                      </div>
                    </div>
                    <div class="accordion-item">                <a class="cdx-collapse collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#cdx-collapce3">I’ve seen other apps that serve similar purpose. What makes yours any different?</a>
                      <div class="collapse" id="cdx-collapce3" data-bs-parent="#install-que">
                        <div class="accordion-body">
                          <p class="text-light">‘Lorem ipsum dolor sit amet, consectetur adipisici elit…’ (complete text) is dummy text that is not meant to mean anything. It is used as a placeholder in magazine layouts, for example, in order to give an impression of the finished document. The text is intentionally unintelligible so that the viewer is not distracted by the content. The language is not real Latin and even the first word ‘Lorem’ does not exist. It is said that the lorem ipsum.</p>
                        </div>
                      </div>
                    </div>
                    <div class="accordion-item">                <a class="cdx-collapse collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#cdx-collapce4">How do I get an appointment for video consultation?</a>
                      <div class="collapse" id="cdx-collapce4" data-bs-parent="#install-que">
                        <div class="accordion-body">
                          <p class="text-light">‘Lorem ipsum dolor sit amet, consectetur adipisici elit…’ (complete text) is dummy text that is not meant to mean anything. It is used as a placeholder in magazine layouts, for example, in order to give an impression of the finished document. The text is intentionally unintelligible so that the viewer is not distracted by the content. The language is not real Latin and even the first word ‘Lorem’ does not exist. It is said that the lorem ipsum.</p>
                        </div>
                      </div>
                    </div>
                    <div class="accordion-item">                <a class="cdx-collapse collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#cdx-collapce5">I'm looking for a surgical procedure done in India. How can SeekMed help?</a>
                      <div class="collapse" id="cdx-collapce5" data-bs-parent="#install-que">
                        <div class="accordion-body">
                          <p class="text-light">‘Lorem ipsum dolor sit amet, consectetur adipisici elit…’ (complete text) is dummy text that is not meant to mean anything. It is used as a placeholder in magazine layouts, for example, in order to give an impression of the finished document. The text is intentionally unintelligible so that the viewer is not distracted by the content. The language is not real Latin and even the first word ‘Lorem’ does not exist. It is said that the lorem ipsum.</p>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">               
                <div class="card-body">
                  <div class="codex-accordion accordion accordion-flush" id="product-que">
                    <div class="accordion-item">                <a class="cdx-collapse" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#cdx-collapce6">Who are the consulting doctors?</a>
                      <div class="collapse show" id="cdx-collapce6" data-bs-parent="#product-que">
                        <div class="accordion-body">
                          <p class="text-light">‘Lorem ipsum dolor sit amet, consectetur adipisici elit…’ (complete text) is dummy text that is not meant to mean anything. It is used as a placeholder in magazine layouts, for example, in order to give an impression of the finished document. The text is intentionally unintelligible so that the viewer is not distracted by the content. The language is not real Latin and even the first word ‘Lorem’ does not exist. It is said that the lorem ipsum.</p>
                        </div>
                      </div>
                    </div>
                    <div class="accordion-item">                <a class="cdx-collapse collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#cdx-collapce7">Will the doctor be able to resolve my issue?</a>
                      <div class="collapse" id="cdx-collapce7" data-bs-parent="#product-que">
                        <div class="accordion-body">
                          <p class="text-light">‘Lorem ipsum dolor sit amet, consectetur adipisici elit…’ (complete text) is dummy text that is not meant to mean anything. It is used as a placeholder in magazine layouts, for example, in order to give an impression of the finished document. The text is intentionally unintelligible so that the viewer is not distracted by the content. The language is not real Latin and even the first word ‘Lorem’ does not exist. It is said that the lorem ipsum.</p>
                        </div>
                      </div>
                    </div>
                    <div class="accordion-item">                <a class="cdx-collapse collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#cdx-collapce8">Is my consultation private with my doctor?</a>
                      <div class="collapse" id="cdx-collapce8" data-bs-parent="#product-que">
                        <div class="accordion-body">
                          <p class="text-light">‘Lorem ipsum dolor sit amet, consectetur adipisici elit…’ (complete text) is dummy text that is not meant to mean anything. It is used as a placeholder in magazine layouts, for example, in order to give an impression of the finished document. The text is intentionally unintelligible so that the viewer is not distracted by the content. The language is not real Latin and even the first word ‘Lorem’ does not exist. It is said that the lorem ipsum.</p>
                        </div>
                      </div>
                    </div>
                    <div class="accordion-item">                <a class="cdx-collapse collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#cdx-collapce9">For how long is the consultation valid?</a>
                      <div class="collapse" id="cdx-collapce9" data-bs-parent="#product-que">
                        <div class="accordion-body">
                          <p class="text-light">‘Lorem ipsum dolor sit amet, consectetur adipisici elit…’ (complete text) is dummy text that is not meant to mean anything. It is used as a placeholder in magazine layouts, for example, in order to give an impression of the finished document. The text is intentionally unintelligible so that the viewer is not distracted by the content. The language is not real Latin and even the first word ‘Lorem’ does not exist. It is said that the lorem ipsum.</p>
                        </div>
                      </div>
                    </div>
                    <div class="accordion-item">                <a class="cdx-collapse collapsed" href="javascript:void(0);" data-bs-toggle="collapse" data-bs-target="#cdx-collapce10">Do you have a refund policy?</a>
                      <div class="collapse" id="cdx-collapce10" data-bs-parent="#product-que">
                        <div class="accordion-body">
                          <p class="text-light">‘Lorem ipsum dolor sit amet, consectetur adipisici elit…’ (complete text) is dummy text that is not meant to mean anything. It is used as a placeholder in magazine layouts, for example, in order to give an impression of the finished document. The text is intentionally unintelligible so that the viewer is not distracted by the content. The language is not real Latin and even the first word ‘Lorem’ does not exist. It is said that the lorem ipsum.</p>
                        </div>
                      </div>
                    </div>
                  </div>
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
    <!-- footer end   -->
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
  </body>
</html>