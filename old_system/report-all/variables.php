<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>


<?php
	
	include '../../Connections/dbname.php';
	
	$my_username=$_SESSION['username'];
	
	$menu_transactions="";
	$menu_breakages="";
	$my_tables_use_check=$main_table_use;
	$my_tables_use=$main_table_use;
	
	$presentdate=date('Y-m-d');
	$asave_transaction='INVENTORY_LIST';
	$page_transaction=strtolower($asave_transaction);
	$page_location="../../";

$ryesultctr667aa12= mysqli_query($conn,"SELECT transactions, page_form, menu_name, limit_amount,
			 series_code, header1, header2, main_menu, lock_srp, print_form, lock_no_stocks, view_no_stocks 
			 FROM ".$my_tables_use."_settings.transaction_menu 
		WHERE transactions='$page_transaction' LIMIT 1");		
$ryow12aa12 = mysqli_fetch_assoc($ryesultctr667aa12);	

	$session_page_form=strtoupper($ryow12aa12['page_form']);
	$session_menu_name=ucwords(strtolower($ryow12aa12['menu_name']));
	$header1=strtoupper($ryow12aa12['header1']);
	$header2=ucwords(strtolower($ryow12aa12['header2']));
	$main_menu=ucwords(strtolower($ryow12aa12['main_menu']));
	
	$page_reference_code=strtoupper($ryow12aa12['series_code']);
	$session_lock_srp=strtoupper($ryow12aa12['lock_srp']);
	
	$session_print_form=strtoupper($ryow12aa12['print_form']);
	$session_lock_no_stocks=strtoupper($ryow12aa12['lock_no_stocks']);
	$session_view_no_stocks=strtoupper($ryow12aa12['view_no_stocks']);
	$session_limit_amount=strtoupper($ryow12aa12['limit_amount']);

	if($session_print_form=='') {
		$session_print_form='DEFAULT';
	}
	
	
	$ryesultctr667aa12= mysqli_query($conn,"SELECT barcode, item_code, batch_code 
		FROM ".$my_tables_use."_settings.column_define LIMIT 1");		
$ryow12aa12 = mysqli_fetch_assoc($ryesultctr667aa12);	

if($ryow12aa12['barcode']=='Y'){
		$column_barcode=true;		
}
else
{
		$column_barcode=false;	
}

if($ryow12aa12['item_code']=='Y'){
		$column_item_code=true;		
}
else
{
		$column_item_code=false;	
}



if($ryow12aa12['batch_code']=='Y'){
		$column_batch_code=true;		
}
else
{
		$column_batch_code=false;	
}


$my_module=$page_transaction;

	$main_amount_decimal ='2';
	$main_price_decimal='2';
	$main_qty_decimal='0';
	
$my_file_decimals=ltrim($my_tables_use_check).'_settings.decimals';
$result_trans90_check= mysqli_query($conn,"SELECT amount, price, quantity FROM ".$my_file_decimals."
		 WHERE module='$my_module' LIMIT 1");			
	$ryow12aa56 = mysqli_fetch_assoc($result_trans90_check);																						
		$my_total_records_check=mysqli_num_rows($result_trans90_check);						
 if ($my_total_records_check>0) {	
 	$main_amount_decimal =$ryow12aa56 ['amount'];
	$main_price_decimal=$ryow12aa56 ['price'];
	$main_qty_decimal=$ryow12aa56 ['quantity'];
 }

///FOR COST ACCESS
$access_cost='';

$my_file_cost=ltrim($my_tables_use_check).'_settings.user_access';
$result_trans90_check= mysqli_query($conn,"SELECT modules, a_readonly, a_write, a_allow FROM ".$my_file_cost." 
		 WHERE username='$my_username' and modules='COST' LIMIT 1");			
	$ryow12aa56 = mysqli_fetch_assoc($result_trans90_check);																						
		$my_total_records_check=mysqli_num_rows($result_trans90_check);						
 if ($my_total_records_check>0) {	
 	$access_cost =$ryow12aa56['a_allow'];
	
 }
	
	if($access_cost=='Y') {
		$access_cost=true;
	}
	else
	{
		$access_cost=false;
	}
								
	

?>