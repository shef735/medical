<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

<?php
date_default_timezone_set("Asia/Manila"); 



$my_username=$_SESSION['username'];
include '../../Connections/dbname.php';
$my_tables_use=$main_table_use;

						$session_branch_main_code='';
						$session_branch_main_name='';
						$session_branch_main_address='';
						$session_branch_main_telno='';
						$session_branch_main_faxno='';
						$session_branch_main_email='';

///COMPANY
$ryesultctr667aa12= mysqli_query($conn,"SELECT  username, branch_main, company , multiple 
		FROM ".$my_tables_use."_sessions.session_main
		WHERE username='$my_username' LIMIT 1");		
$ryow12aa12 = mysqli_fetch_assoc($ryesultctr667aa12);	
			
			$session_company_code=$ryow12aa12['company'];			
			$session_branch_main=$ryow12aa12['branch_main'];	
			$session_multiple=$ryow12aa12['multiple'];	
			
			
$ryesultctr667aa12= mysqli_query($conn,"SELECT company, address, code, telno, faxno, 
		email, website, form_code FROM ".$my_tables_use."_resources.company 
		WHERE code='$session_company_code' LIMIT 1");		
$ryow12aa12 = mysqli_fetch_assoc($ryesultctr667aa12);	
			
			$session_company_code=$ryow12aa12['code'];
			$session_company_name=$ryow12aa12['company'];			
			$session_company_adress=$ryow12aa12['address'];	
			$session_company_telno=$ryow12aa12['telno'];
			$session_company_faxno=$ryow12aa12['faxno'];
			$session_company_email=$ryow12aa12['email'];
			$session_company_form=$ryow12aa12['form_code'];
			
	
		////TRANSACTION MENU
				
				$session_approval_level='';
				$session_per_area_approval='';
			
				
$result_trans90_check= mysqli_query($conn,"SELECT approval_level, per_area_approval 
		FROM  ".$my_tables_use."_settings.transaction_menu  
		WHERE transactions='REQUISITION_APPROVAL' LIMIT 1");
	 
				 		$row_series = mysqli_fetch_assoc($result_trans90_check);			
				$my_total_records_check=mysqli_num_rows($result_trans90_check);
				
				  if ($my_total_records_check>0) {
	   					$session_approval_level=$row_series['approval_level'];
						$session_per_area_approval=$row_series['per_area_approval'];
				  }
				  
				  
				  	$session_access_condition='';	  
				  $result_trans90_check= mysqli_query($conn,"SELECT access_condition  
		FROM  ".$my_tables_use."_settings.transaction_menu  
		WHERE transactions='CONSIGNOR_REORDER' LIMIT 1");
	 
				 		$row_series = mysqli_fetch_assoc($result_trans90_check);			
				$my_total_records_check=mysqli_num_rows($result_trans90_check);
				
				  if ($my_total_records_check>0) {
	   			
						$session_access_condition=$row_series['access_condition'];
						
				  }
				

	//// BRANCH SOURCE

						$ryesultctr667aa12= mysqli_query($conn,"SELECT code, branch, address, telno, faxno, email 
									 FROM ".$my_tables_use."_resources.branch 
								WHERE code='$session_branch_main' LIMIT 1");		
						$ryow12aa12 = mysqli_fetch_assoc($ryesultctr667aa12);	
			
			
						$session_branch_source_code=$ryow12aa12['code'];
						$session_branch_source_name=$ryow12aa12['branch'];
						$session_branch_source_address=$ryow12aa12['address'];
						$session_branch_source_telno=$ryow12aa12['telno'];
						$session_branch_source_faxno=$ryow12aa12['faxno'];
						$session_branch_source_email=$ryow12aa12['email'];

		
//// SIGNATORY

$ryesultctr667aa12= mysqli_query($conn,"SELECT approved, verified, noted, checked, accepted    
			 FROM ".$my_tables_use."_settings.signatory LIMIT 1");		
$ryow12aa12 = mysqli_fetch_assoc($ryesultctr667aa12);	
			
			
			$session_approved=$ryow12aa12['approved'];		
			$session_verified=$ryow12aa12['verified'];			
			$session_noted=$ryow12aa12['noted'];	
			$session_checked=$ryow12aa12['checked'];
			$session_accepted=$ryow12aa12['accepted'];		
		
			
//// USERNAME

$ryesultctr667aa12= mysqli_query($conn,"SELECT id, username, lastname, middlename, firstname, department  , branch_access 
			 FROM ".$my_tables_use."_resources.user_data 
		WHERE username='$my_username' LIMIT 1");		
$ryow12aa12 = mysqli_fetch_assoc($ryesultctr667aa12);	
		
			$session_username_department=$ryow12aa12['department'];		
			
			$session_username_id=$ryow12aa12['id'];		
			$session_username=$ryow12aa12['username'];			
			$session_fullname=$ryow12aa12['lastname'].', '.$ryow12aa12['firstname'].' '.$ryow12aa12['middlename'];	
			
			 $session_username_branch_access='';
			  $session_username_branch_access=$ryow12aa12['branch_access'];
			
			
///// TRANSACTION VARIABLES

						$session_branch_trans_code='';
						$session_date_trans='';
						$session_warehouse_trans='';
						$session_remarks_trans='';
						$page_reference_number='';
						$session_warehouse_full='';
						$session_branch_full='';
						$session_document='';
						$session_customer='';
						$session_customer_address='';
						$session_quotation='';
						$session_lookfor='';
						$session_delivery_date='';
						$session_via='';
						$session_po_number='';
						$session_officer='';
						 $session_trip='';
						  $session_del_address='';


						$session_approval_full='';

$result_trans90_check= mysqli_query($conn,"SELECT ref_number, username, branch_trans, 
		date_trans, warehouse, remarks, document, approved_by,
		customer , customer_address, quotation, lookfor, delivery_date, via, po_number, officer, trip, del_address 
		FROM  ".$my_tables_use."_sessions.session_transactions 
		WHERE transactions='$page_transaction' AND  username='$my_username'  LIMIT 1");
	 
				 		$row_series = mysqli_fetch_assoc($result_trans90_check);			
				$my_total_records_check=mysqli_num_rows($result_trans90_check);
				
				  if ($my_total_records_check>0) {
	   		
						$value = $row_series['branch_trans'];
						$session_branch_trans_code=strtok($value, " "); 
			
						$session_date_trans=$row_series['date_trans'];
						$session_document=$row_series['document'];
						
						
						$session_branch_full= $row_series['branch_trans'];
							$session_warehouse_full= $row_series['warehouse'];
							
							if($session_warehouse_full==''){
								$session_warehouse_full='DEFAULT';	
							}
						
						$value = $row_series['warehouse'];
						$session_warehouse_trans=strtok($value, " "); 
						
						$session_remarks_trans=$row_series['remarks'];
						$page_reference_number =$row_series['ref_number'];
						
						$session_customer=$row_series['customer'];
						$session_customer_address=$row_series['customer_address'];
						$session_quotation=$row_series['quotation'];
							$session_lookfor=$row_series['lookfor'];
							$session_delivery_date=$row_series['delivery_date'];
							$session_via=$row_series['via'];
							$session_po_number=$row_series['po_number'];
							$session_officer=$row_series['officer'];
							 $session_trip=$row_series['trip'];
							  $session_del_address=$row_series['del_address'];
							  $session_approved_by=$row_series['approved_by'];
							  
							  	$ryesultctr667aa12= mysqli_query($conn,"SELECT username, 
									CONCAT(lastname,', ',firstname,' ',middlename) AS fullname 
									 FROM ".$my_tables_use."_resources.user_data  
								WHERE username='$session_approved_by' LIMIT 1");		
						$ryow12aa12 = mysqli_fetch_assoc($ryesultctr667aa12);	
			
			
						$session_approval_full=$ryow12aa12['fullname'];
						
							  }
							  
							  
						//// BRANCH
			if($session_branch_trans_code=='')  {
						$session_branch_trans_code=$session_branch_main;
			}
			
			
			
						//// BRANCH

						$ryesultctr667aa12= mysqli_query($conn,"SELECT code, branch, address, telno, faxno, email 
									 FROM ".$my_tables_use."_resources.branch 
								WHERE code='$session_branch_trans_code' LIMIT 1");		
						$ryow12aa12 = mysqli_fetch_assoc($ryesultctr667aa12);	
			
			
						$session_branch_main_code=$ryow12aa12['code'];
						$session_branch_main_name=$ryow12aa12['branch'];
						$session_branch_main_address=$ryow12aa12['address'];
						$session_branch_main_telno=$ryow12aa12['telno'];
						$session_branch_main_faxno=$ryow12aa12['faxno'];
						$session_branch_main_email=$ryow12aa12['email'];
						
						
											
											
			



?>