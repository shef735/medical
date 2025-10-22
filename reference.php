<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

<?php


include '../../Connections/dbname.php';

$presentdate=date('Y-m-d');
$current_time = date('H:i:s');

$presentdate = date('m/d/Y'); // Get current date in mm/dd/yyyy format
$convertedDate = date('Y-m-d', strtotime($presentdate)); // Convert to YYYY-MM-DD
echo $convertedDate;

$my_nc = ltrim($main_table_use) . '_transactions.transactions';
$cdquery_main = "SELECT ref_number, barcode, item, quantity FROM " . $my_nc . " 
WHERE ref_number='" . $ref_number . "' ORDER BY id";
$sql = mysqli_query($conn, $cdquery_main);
		$row_series = mysqli_fetch_assoc($sql);		
// Check if any results were returned
if (mysqli_num_rows($sql) > 0) {


     $total_update_sql= "UPDATE  ".$my_tables_use_check."_transactions.transactions 
SET   gross_sales=gross_srp*quantity_".$menu_sort_value.",
    sales=srp*quantity_".$menu_sort_value.",
    cost_amount=quantity_".$menu_sort_value."*cost,
    total_qty=quantity_".$menu_sort_value.",
    
    withholding_amount = IF(withholding = 'BOTH', (sales/".(float)$session_tax.")*.01+(sales/".(float)$session_tax.")*.05, withholding_amount),
    withholding_amount = IF(withholding = '1', (sales/".(float)$session_tax.")*.01, withholding_amount),
    withholding_amount = IF(withholding = '5', (sales/".(float)$session_tax.")*.05, withholding_amount),
   
    total_overall = total_overall-overall_peso-amount1-amount2, 
    total_overall_".$menu_sort_value."=total_overall,
    discount=gross_sales-total_overall ".$total_overall_condition."";

	$total_query = mysqli_query($db_connection,  $total_update_sql);


$result_trans90_check= mysqli_query($db_connection, "SELECT branch, warehouse 
								 FROM ".$my_masterfile_full." 
								WHERE barcode='".$barcode."' AND batch_code='".$batch_code."' AND 
										SUBSTRING_INDEX(branch,' ',1)='".$branch."' AND  
											SUBSTRING_INDEX(warehouse,' ',1)='".$warehouse."' LIMIT 1");			
										$my_total_records_check=mysqli_num_rows($result_trans90_check);
										$ryow12aa56 = mysqli_fetch_assoc($result_trans90_check);																						
							if ($my_total_records_check>0) {
								  continue;

       $cdresult=mysqli_query($conn, $cdquery) ;
          
		  $my_flag=0;                                                                              
         while ($cdrow=mysqli_fetch_array($cdresult)) {
 
	 /// INSERT 
	$query = "INSERT INTO ".$my_tables_use."_sessions.session_transactions  SET ";	
		if(isset($ref_number)) { $query .= "ref_number = '" .  mysqli_real_escape_string($conn, $ref_number). "', "; }	
		if(isset($my_username)) { $query .= "username = '" .  mysqli_real_escape_string($conn, $my_username). "', "; }	
		if (isset($var_branch)) { $query .= "branch_trans = '" . mysqli_real_escape_string($conn, $var_branch) . "', "; }	
		if (isset($var_approved_by)) 
					{ $query .= "approved_by = '" . mysqli_real_escape_string($conn, $var_approved_by) . "', "; }
		if (isset($page_transaction)) { $query .= "transactions = '" . mysqli_real_escape_string($conn, $page_transaction) . "', "; }	
		if (isset($var_document)) { $query .= "document = '" . mysqli_real_escape_string($conn, $var_document) . "', "; }				
				if (isset($var_note)) { $query .= "remarks = '" . mysqli_real_escape_string($conn, $var_note) . "', "; }
		if (isset($var_date)){ $query .= "date_trans = '" . $var_date . "' "; }
	$query = mysqli_query($conn, $query);

}

                                             $message =  $message;
													echo "<script type='text/javascript'>alert('$message');</script>";		
																		
									 
													
						echo "<script>window.location = 'index.php'</script>";

echo "<script>window.location = 'purchase_list.php?".$randomString."&item=".$item."&barcode=".$barcode."'</script>";

/// GET THE NEXT STRING AFTER THE CHARACTER
$text = substr($needle, (strpos($needle, '_') ?: -1) + 1);


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

	//replace string 
	 $amount = str_replace(',', '', $amount);


      $date_encode = new DateTime("now");
$datetostring=date_format($date_encode, "d F Y h:i:s");
$encoded=$_SESSION['main_user_name'].' ~ '.$_SESSION['fullname'].' ~ '.$datetostring;


/// if variable exisits
$_SESSION['branch_from'] = isset($_POST['branch_from']) ? $_POST['branch_from'] : '';


 <a  href="javascript:void(0)" 
                                                    onclick="location.href='<?php echo $my_location.$sub_menu_file.$intial_char."from_transaction_scan=".$from_transaction_scan."&menu_id=".$menu_id."&trans_value=".$trans_value.$link_variable ?>'">
                                                <i class="fa fa-circle-o"></i><?php echo $sub_menu_details ?></a>



$cdquery="SELECT main_db  FROM ".$my_nc." GROUP BY main_db";
	 $cdresult=mysqli_query($conn, $cdquery) ;
                                                                                        
    while ($cdrow=mysqli_fetch_array($cdresult)) {

    }
 

   $new_table=$main_table_use."_".$maindb.".".$table_name;
    $sql = "INSERT INTO ".$new_table." (date, ref_number, doc_number, 
             barcode, batch_code, 
            item, quantity, srp, discount, amount, 
            uom, inv, encoded_by, note_remarks, cost)
        SELECT 	date_".$menu_sort.", ref_number, ref_number_".$menu_sort.",
         barcode, batch_code, 
            item, quantity_".$menu_sort.", srp, discount1, total_overall_".$menu_sort.",
            uom, inv, encoded, note, cost 
        FROM ".$v1_transactions." 
        WHERE UPPER(transactions_".$menu_sort.")='".strtoupper($transactions)."'"; 



UPDATE medical_resources.clinic_visits os
JOIN medical_resources.patient_info mf ON os.user_id = mf.user_id
SET os.last_name = mf.last_name, os.first_name = mf.first_name,
     os.patient_code = mf.patient_code  
WHERE os.user_id = mf.user_id