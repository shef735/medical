<?php
if(!isset($_SESSION)){
    session_start();
    ob_start();
}

// Get the current values passed from the main file
$address_values = isset($address_values) ? $address_values : [];
$psgc_region = isset($address_values['psgc_region']) ? $address_values['psgc_region'] : '';
$psgc_province = isset($address_values['psgc_province']) ? $address_values['psgc_province'] : '';
$psgc_municipality = isset($address_values['psgc_municipality']) ? $address_values['psgc_municipality'] : '';
$psgc_barangay = isset($address_values['psgc_barangay']) ? $address_values['psgc_barangay'] : '';
$ZipCode = isset($address_values['ZipCode']) ? $address_values['ZipCode'] : '';
$NoBldgName = isset($address_values['NoBldgName']) ? $address_values['NoBldgName'] : '';
$StreetName = isset($address_values['StreetName']) ? $address_values['StreetName'] : '';
$address = isset($address_values['address']) ? $address_values['address'] : '';

// If address field exists, use it for NoBldgName
if (!empty($address) && empty($NoBldgName)) {
    $NoBldgName = $address;
}
?>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<div class="form-group col-md-10">
    <div class="form-label">Address: </div>
    <textarea class="form-control" type="text" name="NoBldgName" id="NoBldgName" placeholder="House/ Building No. / Building Name"><?php echo htmlspecialchars($NoBldgName); ?></textarea>
</div>

<div class="form-group col-md-10" style="display: none;">
    <div class="form-label">Unit No / Street / Subdivision</div>
    <input type="text" class="form-control" name="StreetName"  id="StreetName" placeholder="Unit No / Street / Subdivision" value="<?php echo htmlspecialchars($StreetName); ?>">
</div>

<div class="form-group col-md-10">
    <div class="form-label">Region: </div>
    <select class="form-select" name="psgc_region" id="psgc_region" required>
        <?php
        echo '<option value="">Select...</option>';
        
        $cdquery = "SELECT PSGC_REG_CODE, PSGC_REG_DESC FROM ".$my_tables_use."_resources.ref_psgc_region ORDER BY PSGC_REG_CODE";
        $cdresult = mysqli_query($conn, $cdquery);
        
        while ($cdrow = mysqli_fetch_array($cdresult)) {
            $cdTitle = strtoupper($cdrow["PSGC_REG_DESC"]);
            $dept = strtoupper($cdrow["PSGC_REG_CODE"]);
            $optionValue = $dept . ' ~ ' . $cdTitle;
            $selected = ($psgc_region == $optionValue) ? 'selected' : '';
            echo "<option value=\"$optionValue\" $selected>$cdTitle</option>";
        }
        ?>
    </select>
</div>

<div class="form-group col-md-10">
    <div class="form-label">Province:</div>
    <select class="form-select" name="psgc_province" id="psgc_province" required>
        <?php
        if (!empty($psgc_province)) {
            $pcode = $psgc_province;
            $psg_desc = 'PSGC_PROV_DESC';
            $psg_code = 'PSGC_PROV_CODE';
            
            $ryesultctr667aa12 = mysqli_query($conn, "SELECT $psg_desc as details 
                FROM ".$my_tables_use."_resources.ref_psgc_province 
                WHERE $psg_code='".strtok($pcode, " ")."' LIMIT 1");
            
            if (mysqli_num_rows($ryesultctr667aa12) > 0) {
                $ryow12aa12 = mysqli_fetch_assoc($ryesultctr667aa12);
                $details = $ryow12aa12['details'];
                echo '<option value="'.$pcode.'" selected>'.$details.'</option>';
            }
        }
        
        if (!empty($psgc_region)) {
            $cdquery = "SELECT PSGC_REG_CODE, PSGC_PROV_CODE, PSGC_PROV_DESC FROM 
                ".$main_table_use."_resources.ref_psgc_province 
                WHERE UPPER(PSGC_REG_CODE)='".strtoupper(strtok($psgc_region, " "))."' 
                ORDER BY PSGC_PROV_DESC";
            $cdresult = mysqli_query($conn, $cdquery);
            
            while ($cdrow = mysqli_fetch_array($cdresult)) {
                $cdTitle = strtoupper($cdrow["PSGC_PROV_DESC"]);
                $dept = strtoupper($cdrow["PSGC_PROV_CODE"]);
                $optionValue = $dept . ' ~ ' . $cdTitle;
                $selected = ($psgc_province == $optionValue) ? 'selected' : '';
                echo "<option value=\"$optionValue\" $selected>$cdTitle</option>";
            }
        }
        ?>
    </select>
</div>

<div class="form-group col-md-10">
    <div class="form-label">Municipality:</div>
    <select class="form-select" name="psgc_municipality" id="psgc_municipality" required>
        <?php
        if (!empty($psgc_municipality)) {
            $pcode = $psgc_municipality;
            $psg_desc = 'PSGC_MUNC_DESC';
            $psg_code = 'PSGC_MUNC_CODE';
            $psg_file = $my_tables_use."_resources.ref_psgc_municipality";
            
            $ryesultctr667aa12 = mysqli_query($conn, "SELECT $psg_desc as details 
                FROM $psg_file  
                WHERE $psg_code='".strtok($pcode, " ")."' LIMIT 1");
            
            if (mysqli_num_rows($ryesultctr667aa12) > 0) {
                $ryow12aa12 = mysqli_fetch_assoc($ryesultctr667aa12);
                $details = $ryow12aa12['details'];
                echo '<option value="'.$pcode.'" selected>'.$details.'</option>';
            }
        }
        
        if (!empty($psgc_province)) {
            $cdquery = "SELECT PSGC_REG_CODE, PSGC_PROV_CODE, PSGC_MUNC_CODE, PSGC_MUNC_DESC FROM 
                ".$main_table_use."_resources.ref_psgc_municipality 
                WHERE UPPER(PSGC_PROV_CODE)='".strtoupper(strtok($psgc_province, " "))."' 
                ORDER BY PSGC_MUNC_DESC";
            $cdresult = mysqli_query($conn, $cdquery);
            
            while ($cdrow = mysqli_fetch_array($cdresult)) {
                $cdTitle = strtoupper($cdrow["PSGC_MUNC_DESC"]);
                $dept = strtoupper($cdrow["PSGC_MUNC_CODE"]);
                $optionValue = $dept . ' ~ ' . $cdTitle;
                $selected = ($psgc_municipality == $optionValue) ? 'selected' : '';
                echo "<option value=\"$optionValue\" $selected>$cdTitle</option>";
            }
        }
        ?>
    </select>
</div>

<div class="form-group col-md-10">
    <div class="form-label">Barangay: </div>
    <select class="form-select" name="psgc_barangay" id="psgc_barangay" required>
        <?php
        if (!empty($psgc_barangay)) {
            $pcode = $psgc_barangay;
            $psg_desc = 'PSGC_BRGY_DESC';
            $psg_code = 'PSGC_BRGY_CODE';
            $psg_file = $my_tables_use."_resources.ref_psgc_barangay";
            
            $ryesultctr667aa12 = mysqli_query($conn, "SELECT $psg_desc as details 
                FROM $psg_file  
                WHERE $psg_code='".strtok($pcode, " ")."' LIMIT 1");
            
            if (mysqli_num_rows($ryesultctr667aa12) > 0) {
                $ryow12aa12 = mysqli_fetch_assoc($ryesultctr667aa12);
                $details = $ryow12aa12['details'];
                echo '<option value="'.$pcode.'" selected>'.$details.'</option>';
            }
        }
        
        if (!empty($psgc_municipality)) {
            $cdquery = "SELECT PSGC_REG_CODE, PSGC_PROV_CODE, PSGC_MUNC_CODE, PSGC_BRGY_DESC, PSGC_BRGY_CODE FROM 
                ".$main_table_use."_resources.ref_psgc_barangay 
                WHERE UPPER(PSGC_MUNC_CODE)='".strtoupper(strtok($psgc_municipality, " "))."' 
                ORDER BY PSGC_BRGY_DESC";
            $cdresult = mysqli_query($conn, $cdquery);
            
            while ($cdrow = mysqli_fetch_array($cdresult)) {
                $cdTitle = strtoupper($cdrow["PSGC_BRGY_DESC"]);
                $dept = strtoupper($cdrow["PSGC_BRGY_CODE"]);
                $optionValue = $dept . ' ~ ' . $cdTitle;
                $selected = ($psgc_barangay == $optionValue) ? 'selected' : '';
                echo "<option value=\"$optionValue\" $selected>$cdTitle</option>";
            }
        }
        ?>
    </select>
</div>

<div class="form-group col-md-10">
    <div class="form-label">Zip Code: </div>
    <input class="form-control" placeholder="Zip Code" name="ZipCode" id="ZipCode" type="text" value="<?php echo htmlspecialchars($ZipCode); ?>">
</div>

<script>
$('#psgc_region').change(function() {
    $.ajax({
        type: 'post',
        url: 'fetch_province.php',
        data: {
            get_option: $(this).val()
        },
        success: function(response) {
            document.getElementById("psgc_province").innerHTML = response;
        }
    });
});

$('#psgc_province').change(function() {
    $.ajax({
        type: 'post',
        url: 'fetch_municipality.php',
        data: {
            get_option: $(this).val()
        },
        success: function(response) {
            document.getElementById("psgc_municipality").innerHTML = response;
        }
    });
});

$('#psgc_municipality').change(function() {
    $.ajax({
        type: 'post',
        url: 'fetch_barangay.php',
        data: {
            get_option: $(this).val()
        },
        success: function(response) {
            document.getElementById("psgc_barangay").innerHTML = response;
        }
    });
});

$('#psgc_barangay').change(function() {
    $.ajax({
        type: 'post',
        url: 'fetch_zipcode.php',
        data: {
            get_option: $(this).val()
        },
        success: function(response) {
            document.getElementById("ZipCode").value = response;
        }
    });
});
</script>