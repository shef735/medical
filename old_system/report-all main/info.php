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
	
	
				  $document_readonly='';
			  	if(isset($_GET['info']) AND $_GET['info']==1) {
					$document_readonly='readonly';
				}
				
			  
			
	
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
  <link rel="stylesheet" type="text/css" href="../../css/dataTables.bootstrap.min.css">

  <link rel="stylesheet" href="../../bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../../bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../../bower_components/Ionicons/css/ionicons.min.css">
  <!-- daterange picker -->
  <link rel="stylesheet" href="../../bower_components/bootstrap-daterangepicker/daterangepicker.css">
  <!-- bootstrap datepicker -->
  <link rel="stylesheet" href="../../bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
  <!-- iCheck for checkboxes and radio inputs -->
  <link rel="stylesheet" href="../../plugins/iCheck/all.css">
  <!-- Bootstrap Color Picker -->
  <link rel="stylesheet" href="../../bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
  <!-- Bootstrap time Picker -->
  <link rel="stylesheet" href="../../plugins/timepicker/bootstrap-timepicker.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="../../bower_components/select2/dist/css/select2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../../dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../../dist/css/skins/_all-skins.min.css">
  <![endif]-->
  <!-- Google Font --> 

<script src="../../js/noback.js"></script>

<script src="../datatables_js/jquery-3.3.1.js"></script>  
<script src="../datatables_js/jquery.dataTables.min.js"></script>
 <script src="../datatables_js/dataTables.buttons.min.js"></script> 
 <script src="../datatables_js/buttons.flash.min.js"></script>
 <script src="../datatables_js/jszip.min.js"></script>
 <script src="../datatables_js/pdfmake.min.js"></script>
 <script src="../datatables_js/vfs_fonts.js"></script>
 <script src="../datatables_js/buttons.html5.min.js"></script>
 <script src="../datatables_js/buttons.print.min.js"></script> 
  
     
<link rel="stylesheet" type="text/css" href="../datatables_css/jquery.dataTables.min.css">
    
    

<!-- jQuery 3 -->
<!-- Bootstrap 3.3.7 -->
<!-- Select2 -->
<script src="../../bower_components/select2/dist/js/select2.full.min.js"></script>
<!-- InputMask -->
<script src="../../plugins/input-mask/jquery.inputmask.js"></script>
<script src="../../plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="../../plugins/input-mask/jquery.inputmask.extensions.js"></script>
<!-- date-range-picker -->
<script src="../../bower_components/moment/min/moment.min.js"></script>
<script src="../../bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="../../bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<!-- bootstrap time picker -->
<script src="../../plugins/timepicker/bootstrap-timepicker.min.js"></script>
<!-- SlimScroll -->
<!-- iCheck 1.0.1 -->
<!-- FastClick -->
<!-- AdminLTE App -->

<!-- AdminLTE for demo purposes -->




  <script>
 $(document).ready(function() {
    $('#example').DataTable( {
		dom: 'lfrtBip'
    
       
		
    } );
} );
 
 </script>
 
<script>
		jQuery.noconflict();
	</script>	

 
</head>

<body class="hold-transition skin-blue sidebar-collapse">
<div class="wrapper">

 <?php  

 	 	
 	
		
		
	
		$my_picture_jpg="../../images/".$session_username.".jpg";
		$my_picture_png="../../images/".$session_username.".png";
		$my_final_photo="../../images/no_photo.jpg";
		
		 if (file_exists($my_picture_jpg)) {
			 $my_final_photo=$my_picture_jpg;
		 }
		 	 
			 
		 if (file_exists($my_picture_png)) {
			 $my_final_photo=$my_picture_png;
		 }
		 	 	 
	
	
  ?>



  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $header1 ?>
        <small><?php echo '' ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="<?php echo '../../index.php' ?>"><i class="fa fa-dashboard"></i> Home</a></li>
        <li class="active"><a href="index.php"><i class="fa fa-sticky-note-o"></i> Create New</a></li></li>
         <li ><a href="../../logout.php"><i class="fa fa-sign-out"></i> Log-out</a></li></li>
      </ol>
    </section>

    <!-- Main content -->
   <section class="content">
    
      	<div class="row">
               		<div class="box box-primary">
                   </div>
     </div>             




   <form method="POST" action="" >
                
   			<?php
	
        			 if($_SERVER["REQUEST_METHOD"] == "POST") {
						  
						//  if(isset($_POST['generate'])) {
						  	$date1=$_POST['date1'];
							$date2=$_POST['date2'];
							$branch=$_POST['branch_save'];
							
							
							
						
							echo "<script>window.location = 'index.php?branch=".$branch."&date1=".$date1."&date2=".$date2."'</script>";
							
							
						  
					  }
					  
				
			 ?>                 
      		
            
          	  
        
        <div class="row">
        
      			  <div class="col-md-12">

                     <div class="box box-danger">
               
                            <div class="box-body">
                        
                                  <div class="input-group">
                                  
                                  <div class="col-md-6">
                                                                      <label>Branch</label>
                                                                       <div class="input-group">
                                                                                <span class="input-group-addon"><i class="fa fa-university"></i></span>        
                                               						 <select name="branch_save" id="branch_save" 
                                                style="width:100%"  class="select2" required      >
                                                                    
                                                                 
                                                                                       
                                                            <?php
																$date1_val='';
																$date2_val='';
																
																if(isset($_GET['date1'])) {
																	$date1_val=$_GET['date1'];
																}
																
																
																if(isset($_GET['date2'])) {
																	$date2_val=$_GET['date2'];
																}
																
																
																		if(isset($_GET['branch'])) {
																		$branch=$_GET['branch'];
																	}
																
																if(isset($branch) && $branch!='') {
																
																	 echo "<option value=\"".$branch."\">". $branch."</option>";
																}
															
																	  echo "<option  value=\"".'ALL'."\">". 'SELECT ALL'."</option>";
																
                                                                                        $cdquery="SELECT code, branch FROM 
                                                                                                ".$my_tables_use."_resources.branch ORDER BY branch";
                                                                                        $cdresult=mysqli_query($conn, $cdquery) ;
                                                                                        
                                                                                        while ($cdrow=mysqli_fetch_array($cdresult)) {
                                                                                                $cdTitle=$cdrow["code"].' - '.$cdrow["branch"];
                                                                                        
																								if(isset($branch) && $branch!='') {
																										if(ltrim($branch)==$cdTitle) {
																											continue;
																										}
																								}
																								
																						
                                                                                                $dept=ltrim($cdrow["code"]);
                                                                                                echo "<option value=\"".$cdTitle."\">". $cdTitle."</option>";
                                                                            
                                                                                    
                                                                                        }   
																
                                                         	?>
                                                                                        
                                                      </select>
                                                                        </div>
                                                                </div>
                                                                
                                                               
                                  
                                    <div class="col-md-3">
                                                                   <label>From </label>
                                                                      <div class="input-group">
                                                                            <span class="input-group-addon"><i class="fa fa-calendar"></i></span>

                                                                          <input required   class="form-control pull-right" id="date1" autocomplete="off"
                                                     		 data-inputmask="'alias': 'yyyy-mm-dd'" 
                                                                 data-mask
                                                                       name="date1"  value="<?php echo date("Y-m-d", strtotime($date1_val))?>">                                         
                                                                        </div>
                                                                    </div>
                                                                  
                                                                  <div class="col-md-3">
                                                                        <label>To</label>
                                                                       <div class="input-group">
                                                                         <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                                                                 <input required   class="form-control pull-right" id="date2" autocomplete="off"
                                                     		 data-inputmask="'alias': 'yyyy-mm-dd'" 
                                                                 data-mask
                                                                       name="date2"  value="<?php echo date("Y-m-d", strtotime($date2_val))?>">                                         
                                                                        </div>
                                                                </div>
                                  
                                  
                                                    
                                                   	
                                                    
                                                    
                                                    
                                                      
                                                                
                                                                
                                                                <div class="col-md-3" style="float:right">
                                                                        <label style="visibility:hidden">To</label>
                                                                       <div class="input-group">
                                                           
                                                                          <button class="btn btn-primary pull-right" 
                                                                          type="submit"  id="generate" name="generate" style="width:150px" >
                                                                          <i class="fa  fa-mail-forward"></i>
                                                                           Generate</button>    
                                                                           
                                                                           
                                                                           
                                                                           	
                                                                           

                                                    					</div>
                                                                  </div>      
                                                    
                                                         </div>
                            </div>
                
                        </div>
                
                </div>
         </div>
         
      
    
   
   </form>
    
    <div class="row">
        
    <div class="col-md-12">

         <div class="box box-danger">
   
            <div class="box-body">
                            
                 <section class="content">
            
                      <div class="row">
                                        <!-- START INSERT REPORTS HERE ---->
                                        
                       <div class="box-body">
                                                           

                                                         
                                   <table id="example" class="display" style="width:100%">
                                          <thead >
				<tr>
						<th  >Date</th>
           				 <th  >Branch</th>
						<th  >Reference No.</th>
						<th  >Barcode</th>
						<th  >Item</th>
						<th >Quantity</th>
						<th >Srp</th>
          
						<th  >Amount</th>
         
            </tr>
           
				                                                                                                                           
					</thead>
					<tbody>
										
                                                                                                                                    
												 
						<?php  
							$menu_sort='';
							$menu_validated='';
							$transaction_main='NON-CONFORMING / CREATE NEW';
							$transaction_validation='NON-CONFORMING / VALIDATION';
							
							$my_file_cost=ltrim($my_tables_use_check).'_settings.transaction_menu';
							$result_trans90_check= mysqli_query($conn,"SELECT menu_sort FROM ".$my_file_cost." 
									 WHERE UPPER(transactions)='".$transaction_main."' LIMIT 1");			
								$ryow12aa56 = mysqli_fetch_assoc($result_trans90_check);																						
									$my_total_records_check=mysqli_num_rows($result_trans90_check);						
							 if($my_total_records_check>0) {	
								$menu_sort =$ryow12aa56['menu_sort'];
							 }
							 
							 	$my_file_cost=ltrim($my_tables_use_check).'_settings.transaction_menu';
							$result_trans90_check= mysqli_query($conn,"SELECT menu_sort FROM ".$my_file_cost." 
									 WHERE UPPER(transactions)='".$transaction_validation."' LIMIT 1");			
								$ryow12aa56 = mysqli_fetch_assoc($result_trans90_check);																						
									$my_total_records_check=mysqli_num_rows($result_trans90_check);						
							 if($my_total_records_check>0) {	
								$menu_validated =$ryow12aa56['menu_sort'];
							 }
						
						
						
						
						
						$branch = strtok($_GET["branch"]," ");
					
						$my_nc=ltrim($main_table_use).'_transactions.transactions';
						
						
						 $where ='';
							if($branch == 'ALL'){
								$where = " date BETWEEN '".$date1_val."' AND '".$date2_val."'";
							}else{
								
            				    $where = " SUBSTRING_INDEX(branch,' ',1) = '".$branch."' AND 
								date BETWEEN '".$date1_val."' AND '".$date2_val."'";
           				   }

						$cdquery_main = "SELECT date,ref_number,barcode,item,quantity,srp,cost, 
									quantity_".$menu_sort." AS main_qty, quantity_".$menu_validated ." AS validated, 
									remarks,encoded,branch,status FROM ".$my_nc." 
									WHERE UPPER(transactions_".$menu_sort.")='".strtoupper($transaction_main)."'  AND ".$where." ";
									
								//	echo $cdquery_main;
									
						$sql=mysqli_query($conn, $cdquery_main);
						if($sql){
							if(mysqli_num_rows($sql) > 0){
								while ($cdrow_main=mysqli_fetch_array($sql)) { 
              
										  if ((float)$cdrow_main["validated"]<1) {
											$color='RED';
											$amount = 0;
											$cost_amount=0;
										  }else{
											$color='BLACK';
											$cost_amount = (float)$cdrow_main["main_qty"]*(float)$cdrow_main["cost"];
											$amount=(float)$cdrow_main["srp"]*(float)$cdrow_main["main_qty"];
										  }
              
						?> 				
                                        <tr>
                                            <td style="color: <?php echo $color; ?>"><?php echo $cdrow_main["date"]; ?></td>
                           					<td style="color: <?php echo $color; ?>"><?php echo $cdrow_main["branch"]; ?></td>
                                            <td style="color: <?php echo $color; ?>"><?php echo $cdrow_main["ref_number"]; ?></td>
                                            <td style="color: <?php echo $color; ?>"><?php echo $cdrow_main["barcode"]; ?></td>
                                            <td style="color: <?php echo $color; ?>"><?php echo $cdrow_main["item"]; ?></td>
                                            <td style="text-align:right; color: <?php echo $color; ?>"><?php echo $cdrow_main["main_qty"]; ?></td>
                                            <td style="text-align:right; color: <?php echo $color; ?>"><?php echo number_format(floatval($cdrow_main["srp"]),2); ?></td>
                                             <td style=" text-align:right; color: <?php echo $color; ?>"><?php echo number_format(floatval($amount),2); ?></td>
                            			 
                            		 
                                        </tr>				
                                                        
						<?php
						
								}
							}
						}
						?>
                                                                  
                                                                  
                                                       
                                                                 
                                                                  
                                                                                      

                                                        
                                          </tbody>
                                          
                                  </table> 
                                                               
                          
                           
                       </div>
                                    <!-- END  REPORTS HERE ---->
                                          
                      </div>          
          
                  </section>
  
          </div>
          </div>
       </div>
       </div>                     
                            
                             
  
   			
	</section>
          
          <!-- /.box -->
        </div>
        <!-- /.col -->
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php
  
  	 include ("../../includes/footer.php");
	//  include ("../../includes/rightmenu.php");
  ?>

  <!-- Control Sidebar -->
 
  <!-- /.control-sidebar -->
  <!-- Add the sidebar's background. This div must be placed
       immediately after the control sidebar -->
 
</div>
<!-- ./wrapper -->

<!-- jQuery 3 -->

    
        
		    
 
<!-- FastClick -->
<!-- AdminLTE App -->
<!-- AdminLTE for demo purposes -->
<!-- Page script -->
<script>
  $(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Datemask dd/mm/yyyy
    $('#datemask').inputmask('dd/mm/yyyy', { 'placeholder': 'dd/mm/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()

    //Date range picker
    $('#reservation').daterangepicker()
    //Date range picker with time picker
    $('#reservationtime').daterangepicker({ timePicker: true, timePickerIncrement: 30, format: 'MM/DD/YYYY h:mm A' })
    //Date range as a button
    $('#daterange-btn').daterangepicker(
      {
        ranges   : {
          'Today'       : [moment(), moment()],
          'Yesterday'   : [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
          'Last 7 Days' : [moment().subtract(6, 'days'), moment()],
          'Last 30 Days': [moment().subtract(29, 'days'), moment()],
          'This Month'  : [moment().startOf('month'), moment().endOf('month')],
          'Last Month'  : [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        },
        startDate: moment().subtract(29, 'days'),
        endDate  : moment()
      },
      function (start, end) {
        $('#daterange-btn span').html(start.format('MMMM D, YYYY') + ' - ' + end.format('MMMM D, YYYY'))
      }
    )

    //Date picker
    $('#date').datepicker({
		
      autoclose: true,        format: 'yyyy-mm-dd'
	 
 
    })
	
	   $('#date1').datepicker({
		
      autoclose: true,        format: 'yyyy-mm-dd'
	 
 
    })
	
	   $('#date2').datepicker({
		
      autoclose: true,        format: 'yyyy-mm-dd'
	 
 
    })

	
	  $('#datepicker2').datepicker({
      autoclose: true
    })

    //iCheck for checkbox and radio inputs
    $('input[type="checkbox"].minimal, input[type="radio"].minimal').iCheck({
      checkboxClass: 'icheckbox_minimal-blue',
      radioClass   : 'iradio_minimal-blue'
    })
    //Red color scheme for iCheck
    $('input[type="checkbox"].minimal-red, input[type="radio"].minimal-red').iCheck({
      checkboxClass: 'icheckbox_minimal-red',
      radioClass   : 'iradio_minimal-red'
    })
    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-green',
      radioClass   : 'iradio_flat-green'
    })

    //Colorpicker
    $('.my-colorpicker1').colorpicker()
    //color picker with addon
    $('.my-colorpicker2').colorpicker()

    //Timepicker
    $('.timepicker').timepicker({
      showInputs: false
    })
  })
</script>



</body>
</html>

		

<script type="text/javascript">
         $(document).ready(function () {
             $(".numberinput").forceNumeric();
         });


         // forceNumeric() plug-in implementation
         jQuery.fn.forceNumeric = function () {

             return this.each(function () {
                 $(this).keydown(function (e) {
                     var key = e.which || e.keyCode;

                     if (!e.shiftKey && !e.altKey && !e.ctrlKey &&
                     // numbers   
                         key >= 48 && key <= 57 ||
                     // Numeric keypad
                         key >= 96 && key <= 105 ||
                     // comma, period and minus, . on keypad
                        key == 190 || key == 109 || key == 110 ||
                     // Backspace and Tab and Enter
                        key == 8 || key == 9 || key == 13 ||
                     // Home and End
                        key == 35 || key == 36 ||
                     // left and right arrows
                        key == 37 || key == 39 ||
                     // Del and Ins
                        key == 46 || key == 45)
                         return true;

                     return false;
                 });
             });
         }
     </script>
     
     <script >
 $(document).ready(function() {
  $('form input').keydown(function(event){
    if(event.keyCode == 13) {
      event.preventDefault();
      return false;
    }
  });
});
 
 </script>
 
   
	<script src="../../js/jquery.validate.min.js"></script>
    

    
  
 
   <script>
	$('input').on('focus', function (e) {
    $(this)
        .one('mouseup', function () {
            $(this).select();
            return false;
        })
        .select();
});
</script>
  
  
  
<script>
$(document).ready(function()
{ 
       $(document).bind("contextmenu",function(e){
              return false;
       }); 
})
</script>


 