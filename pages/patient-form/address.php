<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


<?php
 ini_set('display_startup_errors', 1);
ini_set('display_errors', 1);
error_reporting(-1);

include "db.php";

  	$psgc_region='';
		$psgc_province='';
		$psgc_municipality='';
		$psgc_barangay='';
 
		$ZipCode='';
        $NoBldgName='';
		$StreetName='';


?>
    <div class="form-group col-md-10">
           <div class="form-label">House/ Building No. / Building Name </div>
                 		<input class="form-control" type="text" name="NoBldgName" 
                    id="NoBldgName" value="<?php echo $NoBldgName ?>" placeholder="House/ Building No. / Building Name"   >
   </div>
                
 <div class="form-group col-md-10">
    <div class="form-label">Unit No / Street / Subdivision</div>
  
       
    	    <input type="text" class="form-control" name="StreetName" required id="StreetName" placeholder="Unit No / Street / Subdivision" value="<?php echo $StreetName ?>"  >
       
        </div>


 
       <div class="form-group col-md-10">
        <div class="form-label">Region: </div>
             <select  class="form-select"  name="psgc_region" id="psgc_region"  required>
                                                                  
                                        <?php
                                  
                                    $details='';
                                  
                                  
                                    echo '<option value="">Select...</option>';
                                    
                                          $cdquery="SELECT PSGC_REG_CODE, PSGC_REG_DESC FROM 
                                          ".$my_tables_use."_resources.ref_psgc_region  ORDER BY PSGC_REG_CODE";
                                      $cdresult=mysqli_query($conn, $cdquery) ;
                                      
                                      while ($cdrow=mysqli_fetch_array($cdresult)) {
                                            $cdTitle=strtoupper($cdrow["PSGC_REG_DESC"]);
                                          $dept=strtoupper($cdrow["PSGC_REG_CODE"]);
                                        
                                          echo "<option value=\"".$dept.' ~ '.$cdTitle."\">". $cdTitle."</option>";
                                
                                      }   
                                      
                                        ?>

                                        </select>
                     </div>
 <div class="form-group col-md-10">
        <div class="form-label">Province:</div>
                              <select  class="form-select" name="psgc_province" id="psgc_province"  required  >
                                              
                                              <?php
                                
                                  $details='';
                                  $pcode=$psgc_province;
                                  $psg_desc='PSGC_PROV_DESC';
                                  $psg_code='PSGC_PROV_CODE';
                                  if($pcode!='') {
                                      $ryesultctr667aa12= mysqli_query($conn,"SELECT  ".$psg_desc." as details 
                                          FROM ".$my_tables_use."_resources.ref_psgc_province 
                                          WHERE ".$psg_code."='".strtok($pcode," ")."' LIMIT 1");		
                                        if(mysqli_num_rows($ryesultctr667aa12)>0) {	
                                          $ryow12aa12 = mysqli_fetch_assoc($ryesultctr667aa12);	
                                          $details=$ryow12aa12['details'];
                                        }
                                  }
                                
                                  echo '<option value="'.$pcode.'">'.$details.'</option>';
                                  
                                  
                                  if($psgc_region!='') {
                                      $cdquery="SELECT PSGC_REG_CODE, PSGC_PROV_CODE, PSGC_PROV_DESC FROM 
                                                ".$main_table_use."_resources.ref_psgc_province 
                                                WHERE UPPER(PSGC_REG_CODE)='".strtoupper(strtok($psgc_region," "))."' 
                                            ORDER BY PSGC_PROV_DESC";
                                      $cdresult=mysqli_query($conn, $cdquery) ;
                                                                        
                                      while ($cdrow=mysqli_fetch_array($cdresult)) {
                                                  $cdTitle=strtoupper($cdrow["PSGC_PROV_DESC"]);
                                                  $dept=strtoupper($cdrow["PSGC_PROV_CODE"]);
                                                  echo "<option value=\"".$dept.' ~ '.$cdTitle."\">". $cdTitle."</option>";
                                      }
                                    
                                  }
                                
                                ?>
                                              
                            </select>
                  </div>

             <div class="form-group col-md-10">
        <div class="form-label">Municipality:</div>
                         <select  class="form-select"  name="psgc_municipality" id="psgc_municipality"  required >
                                   
                                        
                            <?php
							
								$details='';
								$pcode=$psgc_municipality;
								$psg_desc='PSGC_MUNC_DESC';
								$psg_code='PSGC_MUNC_CODE';
								$psg_file= $my_tables_use."_resources.ref_psgc_municipality";
								
								if($pcode!='') {
										$ryesultctr667aa12= mysqli_query($conn,"SELECT  ".$psg_desc." as details 
												FROM ".$psg_file."  
												WHERE ".$psg_code."='".strtok($pcode," ")."' LIMIT 1");		
											if(mysqli_num_rows($ryesultctr667aa12)>0) {	
												$ryow12aa12 = mysqli_fetch_assoc($ryesultctr667aa12);	
												$details=$ryow12aa12['details'];
											}
								}
							
							  echo '<option value="'.$pcode.'">'.$details.'</option>';
							  
							  
							  	  if($psgc_province!='') {
								     $cdquery="SELECT PSGC_REG_CODE, PSGC_PROV_CODE,  PSGC_MUNC_CODE, PSGC_MUNC_DESC FROM 
														  ".$main_table_use."_resources.ref_psgc_municipality 
															 WHERE UPPER(PSGC_PROV_CODE)='".strtoupper(strtok($psgc_province," "))."' 
													 ORDER BY PSGC_MUNC_DESC";
									  $cdresult=mysqli_query($conn, $cdquery) ;
										  
										 while ($cdrow=mysqli_fetch_array($cdresult)) {
															  $cdTitle=strtoupper($cdrow["PSGC_MUNC_DESC"]);
															  
															   $dept=strtoupper($cdrow["PSGC_MUNC_CODE"]);
															   echo "<option value=\"".$dept.' ~ '.$cdTitle."\">". $cdTitle."</option>";
										 }
							  }
							
							?>
                            
                                   
                                </select>


                      </div>


             <div class="form-group col-md-10">
        <div class="form-label">Barangay: </div>
                         <select class="form-select"  name="psgc_barangay" id="psgc_barangay" required   >
                                
                                     <?php
							
								$details='';
								$pcode=$psgc_barangay;
								$psg_desc='PSGC_BRGY_DESC';
								$psg_code='PSGC_BRGY_CODE';
								$psg_file= $my_tables_use."_resources.ref_psgc_barangay";
								
								if($pcode!='') {
										$ryesultctr667aa12= mysqli_query($conn,"SELECT  ".$psg_desc." as details 
												FROM ".$psg_file."  
												WHERE ".$psg_code."='".strtok($pcode," ")."' LIMIT 1");		
											if(mysqli_num_rows($ryesultctr667aa12)>0) {	
												$ryow12aa12 = mysqli_fetch_assoc($ryesultctr667aa12);	
												$details=$ryow12aa12['details'];
											}
								}
							
							  echo '<option value="'.$pcode.'">'.$details.'</option>';
							  
							  
							    if($psgc_municipality!='') {
								     $cdquery="SELECT PSGC_REG_CODE, PSGC_PROV_CODE,  PSGC_MUNC_CODE, PSGC_BRGY_DESC,  PSGC_BRGY_CODE FROM 
												  ".$main_table_use."_resources.ref_psgc_barangay 
													 WHERE UPPER(PSGC_MUNC_CODE)='".strtoupper(strtok($psgc_municipality," "))."' 
													 
											 ORDER BY PSGC_BRGY_DESC";
							  $cdresult=mysqli_query($conn, $cdquery) ;
								  
								 while ($cdrow=mysqli_fetch_array($cdresult)) {
													  $cdTitle=strtoupper($cdrow["PSGC_BRGY_DESC"]);
													  
													   $dept=strtoupper($cdrow["PSGC_BRGY_CODE"]);
													   echo "<option value=\"".$dept.' ~ '.$cdTitle."\">". $cdTitle."</option>";
								 }
							  }
							
							?>
                                
                       </select>

                    </div>    

             <div class="form-group col-md-10">
        <div class="form-label">Zip Code: </div>
                        <input class="form-control" placeholder="Zip Code"  class="form-control" name="ZipCode" id="ZipCode" type="text" >
                      </div>



              

<script>

$('#psgc_region').change(function() {
  //  window.location = "info.php?bvar=" + $(this).val();
   $.ajax({
     type: 'post',
     url: 'fetch_province.php',
     data: {
       get_option:$(this).val()
     },
     success: function (response) {
       document.getElementById("psgc_province").innerHTML=response;
  	
     }
   });
  
});

</script>


<script>

$('#psgc_province').change(function() {
  //  window.location = "info.php?bvar=" + $(this).val();
   $.ajax({
     type: 'post',
     url: 'fetch_municipality.php',
     data: {
       get_option:$(this).val()
     },
     success: function (response) {
       document.getElementById("psgc_municipality").innerHTML=response;
	
     }
   });
  
});

</script>

<script>

$('#psgc_municipality').change(function() {
  //  window.location = "info.php?bvar=" + $(this).val();
   $.ajax({
     type: 'post',
     url: 'fetch_barangay.php',
     data: {
       get_option:$(this).val()
     },
     success: function (response) {
       document.getElementById("psgc_barangay").innerHTML=response;
	
     }
   });
  
});

</script>


<script>

$('#psgc_barangay').change(function() {
  //  window.location = "info.php?bvar=" + $(this).val();
   $.ajax({
     type: 'post',
     url: 'fetch_zipcode.php',
     data: {
       get_option:$(this).val()
     },
     success: function (response) {
       document.getElementById("ZipCode").value=response;
	
     }
   });
  
});

</script>
