<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>



<?php 

if(!isset($_SESSION['username'])) {
		echo "<script>window.location = '../../logout.php'</script>";
}

	include ("variables.php");
	include ("session_value.php");
	


$session_username_id='1';

//include "generate.php";
 
 include "data.php";
 

?>
	


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title><?php echo $session_company_name ?></title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" type="text/css" href="../../css/googleapis.css">
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">

  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="../../index2.html" class="navbar-brand"><b>M-One</b>Solutions</a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="../../index.php">Home<span class="sr-only">(current)</span></a></li>
            <li><a href="#" onclick="sizeToFit()">Size to Fit</a></li>
               <li><a href="#" onclick="autoSizeAll()"  >Auto-Size All</a></li>
     <li><a href="#" onclick="expandAll()">Expand All</a></li>
       <li><a href="#" onclick="collapseAll()">Collapse All</a></li>
     
            
          </ul>
          
        </div>
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        
        <div style="padding-bottom: 4px;  visibility:hidden; position:absolute">
                    
                            <input type="checkbox" id="skipHeader"/>
                          
                            <input type="checkbox" id="columnGroups"/>
                          
                            <input type="checkbox" id="skipFooters"/>
                       
                            <input type="checkbox" id="onlySelected"/>
                          
                            <input type="checkbox" id="useCellCallback"/>
                          
                            <input type="checkbox" id="processHeaders"/>
                           
                            <input type="checkbox" id="skipPinnedTop"/>
                          
                            <input type="checkbox" id="skipPinnedBottom"/>
                         
                            <input type="checkbox" id="skipGroups"/>
                         
                            <input type="checkbox" id="useSpecificColumns"/>
                       
                            <input type="checkbox" id="allColumns"/>
                      
                            <input type="checkbox" id="skipGroupR"/>
                       
                            <input type="checkbox" id="appendHeader"/>
                           
                            <input type="checkbox" id="appendFooter"/>
                          
                   
                </div>
        
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>
  <!-- Full Width Column -->
  <div class="content-wrapper">
    <div >
      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1>
         Inventory List
          <small>Report Analysis</small>
        </h1>
        
      </section>

      <!-- Main content -->
      <section class="content">
      
      
      
      
      <div class="box box-danger">
           
            <div class="box-body">
              <div class="row">
                <div class="col-xs-6">
                        <div class="input-group">
                              <div class="input-group-btn">
                                  <button  type="button" class="btn btn-danger" onclick="onBtExport()">Export to Excel</button>
                              </div>
                                
                                <input type="text" id="fileName" class="form-control" placeholder="File Name">
                                 <input style="visibility:hidden; position:absolute" type="text" 
                                        id="sheetName" class="form-control" placeholder="Sheet Name">
                        </div>
                     
                
                </div>
                
                 <div class="col-xs-6"> 
                   <input type="text" id="filter-text-box"  class="form-control" 
              		placeholder="Quick Search..." oninput="onFilterTextBoxChanged()"/>
               	</div>
              </div>
            </div>
            <!-- /.box-body -->
          </div>
      
      
     
      
         
        
           <div id="myGrid" class="box-body ag-theme-balham" ></div>

    <script src="main2.js"></script>
         
     
          <!-- /.box-body -->
       
        <!-- /.box -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
   <?php
  
  	 include ("../../includes/footer.php");
  ?>
  
</div>
<!-- ./wrapper -->
	<script src="ag-grid-enterprise-master/dist/ag-grid-enterprise.min.js"></script>
    
<!-- jQuery 3 -->
<script src="../../bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../../bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../../bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../../bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../../dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../../dist/js/demo.js"></script>
</body>
</html>
