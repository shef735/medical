<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>



<?php

 if(isset($_POST['get_option']) and $_POST['get_option']!='')
  {
	 
		  include ("../../Connections/dbname.php"); 
	 
		 
  
     $state = strtok($_POST['get_option']," ");
	 
	 $value = $state;
	$branch_id=ltrim(strtok($value, " ")); 

	   echo "<option value=\"". ""."\">"."Select..."."</option>";
	 
	     $cdquery="SELECT PSGC_REG_CODE, PSGC_PROV_CODE, PSGC_PROV_DESC FROM 
                          ".$main_table_use."_resources.ref_psgc_province 
						  	 WHERE UPPER(PSGC_REG_CODE)='".strtoupper($state)."' 
					 ORDER BY PSGC_PROV_DESC";
   	  $cdresult=mysqli_query($conn, $cdquery) ;
          
		  
	                                                                        
         while ($cdrow=mysqli_fetch_array($cdresult)) {
                              $cdTitle=strtoupper($cdrow["PSGC_PROV_DESC"]);
							  
							   $dept=strtoupper($cdrow["PSGC_PROV_CODE"]);
                               echo "<option value=\"".$dept.' ~ '.$cdTitle."\">". $cdTitle."</option>";
		 
		   
		 
		 }
		 
		
	 
     exit;
   }

?>