<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>


<?php
 	include '../../Connections/dbname.php';

$my_tables_use=$main_table_use;
	$presentdate=date('Y-m-d');
	$start_date='2001-08-01';
	$inventory_date=$presentdate;
	
 $my_tables_use_check=$main_table_use;
			$my_warehouse_check=ltrim($my_tables_use_check).'_resources.warehouse';
			$my_masterfile_check=ltrim($my_tables_use_check).'_transactions.transactions';
			$my_branch_file=ltrim($my_tables_use_check).'_resources.warehouse';
			$filetoresult_branch=ltrim($my_tables_use_check).'_resources.branch';
$condition='';

$branch_field='';
$sum_total='';

if($branch=='') {
	$branch='HO';
}

$branch_condition=" AND SUBSTRING_INDEX(branch,' ',1)='".$branch."'";

		$query23_line = "SELECT code, inventory_date  FROM ".$filetoresult_branch." WHERE  UPPER(code)='".ltrim($branch)."'";		
		$query23_line = mysqli_query($conn, $query23_line);
		$my_total_records_check23_line=mysqli_num_rows($query23_line);		
		if((float)$my_total_records_check23_line>0) {
				$ryow12aa5623 = mysqli_fetch_assoc($query23_line);
			
			if($ryow12aa5623['inventory_date']==NULL  OR $ryow12aa5623['inventory_date']=='' ) {
				$inventory_date=$start_date;
			}
			else
			{
				$inventory_date=$ryow12aa5623['inventory_date'];
			}
		}

 $data_value=$stock_option;

if($data_value=='soh') {
	$data_value='(qty_in-qty_out)';
}
else
{
	$data_value='(qty_in-qty_allocated-qty_in_transit-qty_out)';
	
}

			if($selection_option=='cost') {
				$data_value=$data_value.'*cost_current';	
			}
			
			if($selection_option=='quantity') {
				$data_value=$data_value;	
			}


			if($selection_option=='srp') {
				$data_value=$data_value.'*srp_current';	
			}
			
		
			

	  $query_br = "SELECT id, code, warehouse, branch  FROM ".$my_branch_file." WHERE id>0 ".$branch_condition;  
		$query_br = mysqli_query($db_connection, $query_br);
	   while ($company_br = mysqli_fetch_array($query_br)){
			$warehouse_sel=strtoupper($company_br['code']);
			
			$warehouse_field=str_replace( array( '\'', '"', '#','-', '!','&' , ';', '<', '>' ), '', $warehouse_sel);
			$branch_search=strtok(strtoupper($company_br['branch'])," ");
			
			
		
		$field_available=$branch_search.'_'.$warehouse_sel.'_available';
		
		   $condition.="SUM(CASE WHEN  SUBSTRING_INDEX(warehouse,' ',1)='".$warehouse_sel."' 
		   							AND date>= '".$inventory_date."'  AND  date<='".$date_as_of."'   
									
						  THEN ".$data_value." ELSE 0 END) ".$warehouse_field.", ";
					//$condition.=$branch_sel.",";
		$sum_total.=	$warehouse_field.'+';			  
						  
	   }
			
		
			 
		//echo $condition;	 
		
	
$sum_total.='NOWH';

$condition.="SUM(CASE WHEN warehouse='' ".$branch_condition." AND date BETWEEN '".$inventory_date."'  AND '".$date_as_of."'   THEN ".$data_value." ELSE 0 END) ".'NOWH'." ";
						 


 
 $filetoresult_trans=ltrim($main_table_use).'_temp.masterf_inventory_listtemp';
 	$result_drop=mysqli_query($conn, "DROP TABLE IF EXISTS $filetoresult_trans");			
	$my_sql="CREATE TABLE ".$filetoresult_trans." AS 
						SELECT  * 
				 FROM ".$my_masterfile_check." WHERE  date>= '".$inventory_date."'  AND  date<='".$date_as_of."'    ";  
 				$sql=mysqli_query($conn, $my_sql);


$updateSQL8_series = "DELETE FROM ".$filetoresult_trans." 
							WHERE date='".$inventory_date."' AND transactions_1!='BEGINNING INVENTORY / CREATE NEW'  ";
				$Result8_series = mysqli_query($conn,$updateSQL8_series);
//echo $condition;	 
		
$filetoresult=ltrim($main_table_use).'_temp.inventory_listtemp';

	$result_drop=mysqli_query($conn, "DROP TABLE IF EXISTS $filetoresult");			
	$my_sql="CREATE TABLE ".$filetoresult." AS 
						SELECT   id, item_code,  barcode, batch_code, item, srp_current, 
								cost_current,  ".$condition.", encoded as total , supplier, supplier_code 
				 FROM ". $filetoresult_trans."  WHERE  date>= '".$inventory_date."'  AND  date<='".$date_as_of."'   
 										GROUP BY barcode, batch_code";  
 				$sql=mysqli_query($conn, $my_sql);		
				
				
			$filetoresult22=ltrim($main_table_use).'_temp.inventory_listtemp';	
		$filetoresult=ltrim($main_table_use).'_temp.inventory_list'.$session_username_id;		
		
					$result_drop=mysqli_query($conn, "DROP TABLE IF EXISTS $filetoresult");			
	$my_sql="CREATE TABLE ".$filetoresult." AS 
						SELECT masta.category, transa.*, masta.prod_group_code, masta.department, masta.size, masta.sqm, masta.item AS item_desc 
								FROM ".$filetoresult22."  transa LEFT JOIN ".$my_tables_use_check."_resources.masterfile_stocks  masta
								ON  transa.barcode=masta.barcode
								
 										GROUP BY transa.barcode, transa.batch_code";  
 				$sql=mysqli_query($conn, $my_sql);							
						 
						$updateSQL8_series = "UPDATE ".$filetoresult."  
																		SET total=".$sum_total." " ;
																	
						$Result8_series = mysqli_query($db_connection,$updateSQL8_series) ;
						
				/*		$updateSQL8_series = "UPDATE ".$filetoresult."  
																		SET HO=''  
																		WHERE  HO IS NULL " ;						
						$Result8_series = mysqli_query($conn,$updateSQL8_series);  */
		
		$updateSQL8_series = "UPDATE ".$filetoresult."  
																		SET cost_current='0'  
																		WHERE  cost_current IS NULL  OR cost_current=''" ;						
						$Result8_series = mysqli_query($conn,$updateSQL8_series);
 
 
 $updateSQL8_series = "UPDATE ".$filetoresult."  
																		SET srp_current='0'  
																		WHERE  srp_current IS NULL  OR srp_current=''" ;						
						$Result8_series = mysqli_query($conn,$updateSQL8_series);
						
	$sql1 =mysqli_query($conn, "ALTER TABLE ".$filetoresult." DROP id ");
			$sql2 = mysqli_query($conn, "ALTER TABLE  ".$filetoresult." ADD id INT(11) NOT NULL PRIMARY KEY AUTO_INCREMENT");

		
		
	  $query_br = "SELECT id, code, warehouse  FROM ".$my_branch_file." WHERE id>0 ".$branch_condition;  
		$query_br = mysqli_query($db_connection, $query_br);
	   while ($company_br = mysqli_fetch_array($query_br)){
			$warehouse_sel=strtoupper($company_br['code']);

			$warehouse_sel=str_replace( array( '\'', '"', '#','-', '!','&' , ';', '<', '>' ), '', $warehouse_sel);
			
			$sql1 =  "ALTER TABLE ".$filetoresult." MODIFY ".$warehouse_sel." VARCHAR(15) NOT NULL ";
			
			
	//		 $query = "DELETE FROM ".$filetoresult." WHERE total = '0' OR total='' ";
    //  $query = mysqli_query($db_connection, $query);

			//$sql1 =mysqli_query($conn, $sql1) ;
			
			
		/*	$updateSQL8_series = "UPDATE ".$filetoresult."  
																		SET ".$warehouse_sel."=0  
																		WHERE  ".$warehouse_sel."='0' OR ".$warehouse_sel."=0 OR ".$warehouse_sel." IS NULL " ;						
						$Result8_series = mysqli_query($conn,$updateSQL8_series);  */
			 	  
						  
	   }
	

?>