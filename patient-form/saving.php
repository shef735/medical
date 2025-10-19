<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

<?php


function clean($string) {
   // Replace single quotes with backticks
    $string = str_replace('\'', '`', $string);
    
    // Replace double quotes with double backticks
    $string = str_replace('"', '``', $string);
    
    return $string;
} 


function cleanfile($string) {
   // Replace single quotes with backticks
    $string = str_replace('\'', '`', $string);
    
    // Replace double quotes with double backticks
    $string = str_replace('"', '``', $string);
    
    return $string;
} 



include "../../Connections/dbname.php";

$presentdate=date('Y-m-d');
$full_name='';
 
if(isset($_POST['last_name'])) {

    $full_name=strtoupper($_POST['last_name'].', '.$_POST['first_name'].' '.$_POST['middle_name']);

    $_SESSION['date']=$presentdate;
    $_SESSION['last_name']=$_POST['last_name'];
    $_SESSION['first_name']=$_POST['first_name'];
    $_SESSION['middle_name']=$_POST['middle_name'];
 
    $_SESSION['password']='';
    $_SESSION['phone']=cleanfile($_POST['phone']);
    $_SESSION['sex']=$_POST['sex'];
    $_SESSION['email']=$_POST['email'];
    $_SESSION['birthday']=$_POST['birthday'];
    $_SESSION['height_cm']=cleanfile($_POST['height_cm']);
    $_SESSION['weight_kg']=cleanfile($_POST['weight_kg']);
    $_SESSION['prev_consults']=cleanfile($_POST['prev_consults']);

    $_SESSION['NoBldgName']=cleanfile($_POST['NoBldgName']);
    $_SESSION['StreetName']=cleanfile($_POST['StreetName']);

 

    $_SESSION['psgc_region']=substr($_POST['psgc_region'], (strpos($_POST['psgc_region'], '~') ?: -1) + 1);
    $_SESSION['psgc_province']=substr($_POST['psgc_province'], (strpos($_POST['psgc_province'], '~') ?: -1) + 1);
    $_SESSION['psgc_municipality']=substr($_POST['psgc_municipality'], (strpos($_POST['psgc_municipality'], '~') ?: -1) + 1);
    $_SESSION['psgc_barangay']=substr($_POST['psgc_barangay'], (strpos($_POST['psgc_barangay'], '~') ?: -1) + 1);
    $_SESSION['ZipCode']=$_POST['ZipCode'];

       $_SESSION['address']= substr($_SESSION['NoBldgName'], (strpos($_SESSION['NoBldgName'], '~') ?: -1) + 1).' '.
       substr($_SESSION['StreetName'], (strpos($_SESSION['StreetName'], '~') ?: -1) + 1).' '.
         substr($_SESSION['psgc_region'], (strpos($_SESSION['psgc_region'], '~') ?: -1) + 1).''.
         substr($_SESSION['psgc_province'], (strpos($_SESSION['psgc_province'], '~') ?: -1) + 1).''.
           substr($_SESSION['psgc_municipality'], (strpos($_SESSION['psgc_municipality'], '~') ?: -1) + 1).''.
            substr($_SESSION['psgc_barangay'], (strpos($_SESSION['psgc_barangay'], '~') ?: -1) + 1).' '.
   substr($_SESSION['ZipCode'], (strpos($_SESSION['ZipCode'], '~') ?: -1) + 1);

    $_SESSION['civil_status']=$_POST['civil_status'];

    $_SESSION['blood_group']=cleanfile($_POST['blood_group']);


    $fileExtension = pathinfo($_FILES["photofile"]["name"], PATHINFO_EXTENSION); 
    //  $photofile = basename($_FILES['photofile']['name']);

    $photofile=cleanfile($_POST['last_name'].$_POST['first_name'].$_POST['birthday']).'.'.$fileExtension;

   //CHECK REFERENCE NUMBER
                                    $my_series_search='20001';
                                                
                                            
                                    do {
                                        $page_reference_code='1';
                                        $branch_save='P0';
                                            
                                        $my_reference=$branch_save.'-'.$page_reference_code.(string)$my_series_search;
                                            
                                        $result_trans90= mysqli_query($db_connection,"SELECT user_id 
                                        FROM ".$main_table_use."_resources.patient_info
                                            WHERE user_id='$my_reference' LIMIT 1");					
                                            $my_total_records_series=mysqli_num_rows($result_trans90);
                                            
                                            if ($my_total_records_series>0) {
                                                    
                                                        $my_series_search=(float)$my_series_search+1;		
                                                                
                                            }
                                            else
                                            {
                                                    break;
                                            }

                                    } while (true);

                                    $_SESSION['user_id']= $my_reference;

    //// CHECK HERE IF DUPLICATE RECORD
   
    $result_trans90_check= mysqli_query($conn,"DELETE FROM  ".$my_tables_use_check."_resources.patient_info
		WHERE date='".$_SESSION['date']."' AND  user_id='".$_SESSION['user_id']."'");
 			                      




        if (isset($_FILES["photofile"]) && $_FILES["photofile"]["error"] == 0) {
            $uploadDir = "../../uploads/"; // Directory where you want to save uploaded files
            $newFilename = "file1234"; // New filename without extension
            $fileExtension = pathinfo($_FILES["photofile"]["name"], PATHINFO_EXTENSION); // Get the original file extension
            $filePath = $uploadDir . $photofile; // New file path with extension

            // Check if the directory exists, if not, create it
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            // Move the uploaded file to the designated directory
            if (move_uploaded_file($_FILES["photofile"]["tmp_name"], $filePath)) {
                // echo "File uploaded successfully: " . htmlspecialchars($newFilename . '.' . $fileExtension);
            } else {
                $photofile='';
                // echo "Error uploading the file.";
            }
        }
        else
        {
             $photofile='';
        }

        $query_price = "INSERT INTO ".$my_tables_use_check."_resources.patient_info  SET ";
    if(isset($_SESSION['date'])) { $query_price .= "date = '" .$_SESSION['date']. "', "; }
    if(isset($_SESSION['user_id'])) { $query_price .= "user_id = '" .$_SESSION['user_id']. "', "; }
    if(isset($_SESSION['last_name'])) { $query_price .= "last_name = '" .$_SESSION['last_name']. "', "; }
    if(isset($_SESSION['first_name'])) { $query_price .= "first_name = '" .$_SESSION['first_name']. "', "; }
    if(isset($_SESSION['middle_name'])) { $query_price .= "middle_name = '" .$_SESSION['middle_name']. "', "; }
    if(isset($_SESSION['address'])) { $query_price .= "address = '" .$_SESSION['address']. "', "; }
    if(isset($_SESSION['password'])) { $query_price .= "password = '" .$_SESSION['password']. "', "; }
    if(isset($_SESSION['phone'])) { $query_price .= "phone = '" .$_SESSION['phone']. "', "; }
    if(isset($_SESSION['sex'])) { $query_price .= "sex = '" .$_SESSION['sex']. "', "; }
    if(isset($_SESSION['email'])) { $query_price .= "email = '" .$_SESSION['email']. "', "; }
    if(isset($_SESSION['birthday'])) { $query_price .= "birthday = '" .$_SESSION['birthday']. "', "; }
    if(isset($_SESSION['height_cm'])) { $query_price .= "height_cm = '" .$_SESSION['height_cm']. "', "; }
    if(isset($_SESSION['weight_kg'])) { $query_price .= "weight_kg = '" .$_SESSION['weight_kg']. "', "; }
   
    if(isset($_SESSION['civil_status'])) { $query_price .= "civil_status = '" .$_SESSION['civil_status']. "', "; }

        if(isset($_SESSION['blood_group'])) { $query_price .= " blood_group = '" .$_SESSION['blood_group']. "', "; }

    if(isset( $_SESSION['prev_consults'])) { $query_price .= "prev_consults = '" .$_SESSION['prev_consults']. "', "; }
    if(isset( $_SESSION['NoBldgName'])) { $query_price .= "NoBldgName = '" .$_SESSION['NoBldgName']. "', "; }
     if(isset( $_SESSION['StreetName'])) { $query_price .= "StreetName = '" .$_SESSION['StreetName']. "', "; }
     if(isset( $_SESSION['psgc_region'])) { $query_price .= "psgc_region = '" .$_SESSION['psgc_region']. "', "; }
     if(isset( $_SESSION['psgc_province'])) { $query_price .= "psgc_province = '" .$_SESSION['psgc_province']. "', "; }
     if(isset( $_SESSION['psgc_municipality'])) { $query_price .= "psgc_municipality = '" .$_SESSION['psgc_municipality']. "', "; }
     if(isset( $_SESSION['psgc_barangay'])) { $query_price .= "psgc_barangay = '" .$_SESSION['psgc_barangay']. "', "; }
      if(isset( $_SESSION['ZipCode'])) { $query_price .= "ZipCode = '" .$_SESSION['ZipCode']. "', "; }
        if(isset($photofile)) { $query_price .= "photo = '" .$photofile. "' "; }
       
        $query_price = mysqli_query($db_connection, $query_price);	

  echo "<script>window.location = '../questions/'</script>";

}
else
{
  echo "<script>window.location = 'index.php'</script>";

}

?>