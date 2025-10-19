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


$id='';
if(isset($_SESSION['selected_id']) AND $_SESSION['selected_id']!='') {
  $id=$_SESSION['selected_id'];
}

$load_fullname='';
$appointment_date='';
$appointment_time='';
$load_doctor='';
$findings='';
$bp='';
$status='';
$weight_kg='';


    $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
		FROM  ".$my_tables_use."_schedule.appointments
		WHERE id='$id' ORDER BY id DESC LIMIT 1");
	 
		
				$my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
				
		 if ($my_total_records_checkaa>0) {
      		$row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
           $load_fullname=substr($row_seriesaa['fullname'], (strpos($row_seriesaa['fullname'], ' - ') ?: -1) + 2);

        $appointment_date=$row_seriesaa['date_only'];
     
        $load_doctor_full=$row_seriesaa['doctor'];
        $load_doctor=substr($load_doctor_full, (strpos($load_doctor_full, ' - ') ?: -1) + 2);
         $appointment_time=$row_seriesaa['time_only'];
          $time_only=date("g:i A", strtotime($appointment_time));

          $findings=$row_seriesaa['findings'];
           $bp=$row_seriesaa['bp'];
           $weight_kg=$row_seriesaa['weight_kg'];
           $status=$row_seriesaa['status'];

           $_SESSION['load_username']=strtok($row_seriesaa['fullname']," ");

     }
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
            <div class="col-md-8">
              <div class="card">
                <div class="card-header">
                  <h4>Edit Appointment</h4>
                </div>
                <div class="card-body"> 
                <form id="appointmentForm" action="update-appointment.php" method="POST"> 
                    <div class="row">
                      <div class="form-group col-md-12">
                        <div class="form-label">Name: <?php echo $load_fullname ?>  </div> 

                    
                                         
                      </div>

                <?php $doctors = $conn->query("SELECT * FROM ".$my_tables_use."_resources.doctor_info ORDER BY last_name"); ?>

                       <div class="form-group col-md-12">
                            <div class="form-label">Doctor:</div>
                        <select name="doctor_id" id="doctor_id" class="form-control select2">
                     <option value="<?php echo $load_doctor_full; ?>">
                        <?php echo  $load_doctor; ?>
                        </option>
                    <?php while ($doctor = $doctors->fetch_assoc()) : ?>
                        <?php 
                        $name_data=$doctor['user_id'].' - '.$doctor['last_name'].', '.$doctor['first_name']; 
                         $name_show=$doctor['last_name'].', '.$doctor['first_name']; 
                        
                        ?>
                        <option value="<?php echo $name_data; ?>">
                        <?php echo  $name_show; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
                      </div>
 

                     
                      <div class="form-group col-md-6">
                        <div class="form-label">Appointment Date</div>
                        <input name="app_date" id="app_date" class=" form-control" type="text" readonly value="<?php echo  $appointment_date ?>" 
                        data-date-format="yyyy/mm/dd" data-language="en" placeholder="Select Appointment Date">
                      </div>
                      <div class="form-group col-md-6">
                        <div class="form-label">Appointment Time </div>
                        <input name="app_time"   id="app_time" class="form-control" type="time" readonly value="<?php echo  $appointment_time ?>">
                      </div>

                        <div class="form-group col-md-4">
                        <div class="form-label">Blood Pressure</div>
                        <input name="bp" id="bp" class="form-control" value="<?php echo $bp ?>"  >
                      </div>

                       <div class="form-group col-md-4">
                        <div class="form-label">Weight (KG)</div>
                        <input name="weight_kg" id="weight_kg" class="form-control" value="<?php echo $weight_kg ?>"  >
                      </div>

                      


                      <div class="form-group col-md-12">
                        <div class="form-label">Findings / Recommendations</div>
                        <textarea name="findings" id="findings" class="form-control" rows="6" value=""  ><?php echo $findings ?></textarea>
                      </div>


                   
   

                      <div class="form-group col-md-6">
                          <div class="form-group">
                        <label for="status" class="control-label">Status</label>
                        <select name="status" id="status"  class="form-select"  >
                            <option  value="0"<?php echo isset($status) && $status == "0" ? "selected": "" ?>>Rescheduled</option>
                            <option value="1"<?php echo isset($status) && $status == "1" ? "selected": "" ?>>Confirmed</option>
                            <option value="2"<?php echo isset($status) && $status == "2" ? "selected": "" ?>>Cancelled </option>
                           <option value="3"<?php echo isset($status) && $status == "3" ? "selected": "" ?>>Done </option>

                     
                        </select>
                    </div>
                      </div>


                      <div class="form-group col-md-6">
                         <div class="form-label"> <br></div>
                          <button type="submit" class="btn btn-primary"  onclick="submitForm()">Save Changes</button>
                      <a class="btn btn-sm btn-danger ml-8" 
   href="javascript:void(0);" 
   onclick="window.location.href='index.php';">Cancel</a></div>
                                        <!--  , '_blank' -->

                                        
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