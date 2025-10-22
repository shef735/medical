<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

<?php
//require_once('../../config.php');

 
$fullname='';
ini_set('display_errors', 1);
error_reporting(E_ALL);

include "../../../../Connections/dbname.php";

if(isset($_GET['id']) && $_GET['id'] > 0){
    $user_id=$_GET['id'];
    $_SESSION['edit_id']=$user_id;
    
                $result_trans90_checkaa= mysqli_query($conn,"SELECT *  
		FROM  ".$my_tables_use."_schedule.appointments
		WHERE id='$user_id' ORDER BY id DESC LIMIT 1");
	 
				$row_seriesaa = mysqli_fetch_assoc($result_trans90_checkaa);			
				$my_total_records_checkaa=mysqli_num_rows($result_trans90_checkaa);
				
		 if ($my_total_records_checkaa>0) {
             $fullname=substr($row_seriesaa['fullname'], (strpos($row_seriesaa['fullname'], ' - ') ?: -1) + 2);
         
           $date_sched=$row_seriesaa['date_sched'];
           $status=$row_seriesaa['status'];
           $time_only=date("g:i A", strtotime($row_seriesaa['time_only']));
           
            $doctor=substr($row_seriesaa['doctor'], (strpos($row_seriesaa['doctor'], ' - ') ?: -1) + 2);
         
         $remarks=$row_seriesaa['remarks'];
 
          }
          
  }
?>
<style>
#uni_modal .modal-content>.modal-footer{
    display:none;
    

}
#uni_modal .modal-body{
    padding-bottom:0 !important;
     
}


</style>


<form id="appointmentForm" action="update.php" method="POST"> 
        <div class="container-fluid" style="color: white;">

        
            <p ><b>Schedule:</b> <?php echo date("F d, Y",strtotime($date_sched)).' '.$time_only  ?></p>
            <p><b>Patient Name:</b> <?php echo $fullname ?></p>
            <p><b>Appointment with:</b> <?php echo ucwords(substr($doctor, (strpos($doctor, '-') ?: -1) + 1) ) ?></p>
        
            <p><b>Remarks:</b> <?php echo $remarks ?></p>
        

                <div class="form-group">
                        <label for="status" class="control-label">Status</label>
                        <select name="status" id="status" class="custom custom-select">
                            <option  value="0"<?php echo isset($status) && $status == "0" ? "selected": "" ?>>Rescheduled</option>
                            <option value="1"<?php echo isset($status) && $status == "1" ? "selected": "" ?>>Confirmed</option>
                            <option value="2"<?php echo isset($status) && $status == "2" ? "selected": "" ?>>Cancelled </option>
                           <option value="3"<?php echo isset($status) && $status == "3" ? "selected": "" ?>>Done </option>

                     
                        </select>
                    </div>

        </form>
        </div>
       <div class="modal-footer border-0">
    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
    <button type="submit" class="btn btn-primary"  onclick="submitForm()">Save Changes</button>
</div>
</form>


<script>
    function submitForm() {
        // Submit the form
        document.getElementById('appointmentForm').submit();

        // Close the modal (assuming you're using Bootstrap)
        $('#myModal').modal('hide'); // Replace `#myModal` with the ID of your modal
    }
</script>