<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>
<style >
.number-cell {
        text-align: right;
    }
	</style>
	

<?php
ini_set('memory_limit', '-1');

include ("../../Connections/dbname.php");
 
 

		$presentdate=date('Y-m-d');
	 $sql ="
    SELECT 
        pr.*, pr.id AS id_pat,
        CONCAT(pr.last_name, ', ', pr.first_name) AS fullname, 
        eims.eims1,
        com.complications,
        sur.surgery,
        beh.behaviorcd,
        man.management,
        
        mayo.mayoscore,
        DATE_FORMAT(pr.birthday, '%m/%d/%Y') AS formatted_bday,
        DATE_FORMAT(pr.date, '%m/%d/%Y') AS formatted_date,
        TIMESTAMPDIFF(YEAR, pr.birthday, CURDATE()) AS age,
        
       
        GROUP_CONCAT(DISTINCT 
            CONCAT(
                DATE_FORMAT(pn.created_date, '%m/%d/%Y %h:%i %p'), 
                ' - ', 
                pn.note_content 
            ) 
            SEPARATOR '\n'
        ) AS formatted_notes,
         
       
        GROUP_CONCAT(DISTINCT 
            CONCAT(
                vd.notes, '\n', vd.document_type, '\n', vd.file_path
               
            )
            SEPARATOR '\n'
        ) AS visit_documents_data,

        
         

        GROUP_CONCAT(DISTINCT 
                CONCAT(
                     
                    CASE WHEN rcc.chiefcomplaint != '' THEN CONCAT(rcc.chiefcomplaint,'- ') ELSE '' END,
                    CASE WHEN rcc.othersymptoms1 != '' THEN CONCAT(rcc.othersymptoms1,'- ') ELSE '' END,
                    CASE WHEN rcc.othersymptoms2  != '' THEN CONCAT(rcc.othersymptoms2) ELSE '' END
                )
                SEPARATOR '\n'
            ) AS chief_complaints_data,
        
       
        GROUP_CONCAT(DISTINCT 
            CONCAT(
                rd.diagnosis1, ' ', rd.attending, ' ', rd.hospital 
            )
            SEPARATOR '\n'
        ) AS diagnoses_data,

        GROUP_CONCAT(DISTINCT 
                CONCAT(
                    pit.initialtreatment,
                    CASE WHEN pit.improvement != '' THEN CONCAT(' Improvement: ', pit.improvement) ELSE '' END,
                    CASE WHEN pit.additionaltreatment != '' THEN CONCAT(' Additional: ', pit.additionaltreatment) ELSE '' END
                )
                SEPARATOR '\n'
            ) AS treatment,
        
        
        GROUP_CONCAT(DISTINCT 
            CONCAT(
               cr.created_at, ' ', 'BP: ',cr.bp, ' ', 'WT:',cr.weight_kg, ' ', 'HT:',cr.height_cm 
            )
            SEPARATOR '\n'
        ) AS clinical_readings_data,
        
        
        GROUP_CONCAT(DISTINCT
            CONCAT(
                cv.review_of_systems, '\n',cv.objective, '\n',cv.assessment, '\n',cv.plans, '\n', cv.visit_date, '\n', cv.notes 
            )
            SEPARATOR '\n'
        ) AS clinic_visits_data,
        
      GROUP_CONCAT(DISTINCT
            CONCAT(
                lr.tests_requested, '\n', 
                lr.request_date, '\n', 
                lr.lab_notes, '\n', 
                lr.created_at
            )
            SEPARATOR '\n'
        ) AS lab_requests_data,
        
        
        GROUP_CONCAT(DISTINCT 
            CONCAT(
                m.medication_name, ' ', m.dosage, ' ', m.frequency 
            )
            SEPARATOR '\n'
        ) AS medications_data,
        
        
        GROUP_CONCAT(DISTINCT 
            CONCAT(
                df.document_name, '\n', df.document_type, '\n', df.file_path, '\n', df.notes, '\n', df.created_at 
            )
            SEPARATOR '\n'
        ) AS documents_forms_data
        
    FROM 
        ".$main_table_use."_resources.patient_info pr
    LEFT JOIN 
        ".$main_table_use."_resources.patient_record pd  ON COALESCE(pr.user_id, '') = COALESCE(pd.user_id, '')
    LEFT JOIN 
        ".$main_table_use."_resources.patient_notes pn ON pr.user_id = pn.user_id

  LEFT JOIN 
        ".$main_table_use."_resources.record_treatment pit ON pr.user_id = pit.user_id
  LEFT JOIN 
        ".$main_table_use."_resources.record_eims eims ON pr.user_id = eims.user_id
    
     LEFT JOIN 
        ".$main_table_use."_resources.record_behaviour beh ON pr.user_id = beh.user_id


 LEFT JOIN 
        ".$main_table_use."_resources.record_surgical sur ON pr.user_id = sur.user_id
    
    LEFT JOIN 
        ".$main_table_use."_resources.record_management man ON pr.user_id = man.user_id
    
     LEFT JOIN 
        ".$main_table_use."_resources.record_complications com ON pr.user_id = com.user_id
    LEFT JOIN
        ".$_SESSION['my_tables']."_laboratory.test_results tr ON pr.user_id = tr.patient_id
     
  LEFT JOIN
        ".$_SESSION['my_tables']."_resources.record_mayo mayo ON pr.user_id = mayo.user_id
   
    LEFT JOIN
        visit_documents vd ON pr.user_id = vd.user_id
    LEFT JOIN
        record_chief_complaint rcc ON pr.user_id = rcc.user_id
    LEFT JOIN
        record_diagnosis rd ON pr.user_id = rd.user_id
     
    LEFT JOIN
        clinical_readings cr ON pr.user_id = cr.user_id
    LEFT JOIN
        clinic_visits cv ON pr.user_id = cv.user_id
    LEFT JOIN
        lab_requests lr ON pr.user_id = lr.user_id
    LEFT JOIN
        medications m ON pr.user_id = m.user_id
    LEFT JOIN
        documents_forms df ON pr.user_id = df.user_id
  GROUP BY 
     pr.user_id 
    ORDER BY 
        pr.last_name  
";

//echo  $sql;

 $sql=mysqli_query($conn, $sql);

$array = array();
while ($row = mysqli_fetch_assoc($sql)) {
    // Process test results data
  /* $row['test_results'] = array();
   if (!empty($row['test_results_data'])) {
        foreach (explode('|', $row['test_results_data']) as $testResult) {
            $parts = explode('|', $testResult);
            $row['test_results'][] = [
                'result_id' => $parts[0],
            
                'template_id' => $parts[1],
                'test_date' => $parts[2],             
                'created_at' => $parts[3],        
                'template_name' => $parts[4]
            ];
        }

          
    }  */
    
    // Process other data similarly...
  // $row['lab_requests'] = processConcatenatedData($row['lab_requests_data']);
   //  $row['visit_documents'] = processConcatenatedData($row['visit_documents_data']);
 
    // ... process other data types
    
  // unset($row['lab_requests_data'] );
    
   if (!empty($row['user_id'])) {
        $city[] = $row;
    }
}

function processConcatenatedData($data) {
    if (empty($data)) return [];
    
    $result = [];
    $seen = []; // Track seen items to avoid duplicates
    
    foreach (explode('\n', $data) as $item) {
        $key = md5($item); // Create a unique key for each item
        if (!isset($seen[$key])) {
            $result[] = explode('\n', $item);
            $seen[$key] = true;
        }
    }
    return $result;
}

$data1 = json_encode($city, JSON_NUMERIC_CHECK);
	
?>

<script type="text/javascript">


var rowData = <?php echo $data1 ?>;


var columnDefs = [

 /* 	 {
        headerName: " ", suppressSizeToFit: true,
		 width: 100, 
        cellRenderer: function(params) {
            return '<a href="#" style="width:100%" onclick="openEditPopup(' + params.data.id + ')"><i class="fa fa-pencil"></i> Edit</a>';
      
        },
    },  


   {
        headerName: " ",
        suppressSizeToFit: true,
        width: 150,
        cellRenderer: function(params) {
            return `
                 <a href="#" onclick="deleteRecord(${params.data.id})" style="color: red; margin-left: 10px;"><i class="fa fa-trash"></i> Delete</a>
            `;
        },
    }, */

     {headerName: "Patiend ID", filter: 'agSetColumnFilter',  field: "user_id",  suppressSizeToFit: true,   type: 'dimension'},


/*{
    headerName: "Encoded",
    field: "formatted_date",
    suppressSizeToFit: true,
    type: 'dimension',
    filter: 'agDateColumnFilter', // Use the date filter with a calendar UI
    filterParams: {
        // Custom comparator for date comparison
        
        // Additional filter options
        browserDatePicker: true, // Use the browser's native date picker
        minValidYear: 2000, // Minimum valid year
        maxValidYear: 2025, // Maximum valid year
        inRangeInclusive: true, // Include the selected range boundaries
        // Set the date format for the date picker
    // Specify the date format for picking
		 filterOptions: ['inRange', 'greaterThan', 'lessThan'], // Allow both 'inRange' and 'greaterThan' options
		 suppressAndOrCondition: true, // Nonexistent, but demonstrates intention
            comparator: function (filterLocalDateAtMidnight, cellValue) {
                const cellDate = new Date(cellValue);
				 if (cellDate.getTime() === filterLocalDateAtMidnight.getTime()) {
                    return 0; // Exclude kung pareho
                }
                return cellDate < filterLocalDateAtMidnight ? -1 : 1; // Simple comparison
            },
        defaultOption: 'inRange', // Default to 'inRange'
    }
},*/
 {
        headerName: "Full Name", 
        field: "fullname",  
        suppressSizeToFit: true,
        type: 'dimension',    
        cellRenderer: function(params) {
            // Create a clickable link without overriding grid features
            return '<a href="javascript:void(0)" onclick="handleFullNameClick(' + params.data.id_pat + ')">' + params.value + '</a>';
        },     filter: 'agTextColumnFilter',
       
    },    
{headerName: "Sex", field: "sex",   filter: 'agSetColumnFilter', // Use the set filter for dropdown options
    filterParams: {
        values: ['MALE', 'FEMALE'], // Define the dropdown options
    }, suppressSizeToFit: true,   type: 'dimension'},
	
 
{headerName: "Birthday", // Changed from "Date" to "Transaction Date"
    field: "formatted_bday", // Changed from "formatted_date" to "transaction_date"
    suppressSizeToFit: true,
    type: 'dimension',
    filter: 'agDateColumnFilter', // Use the date filter with a calendar UI
    filterParams: {
        browserDatePicker: true, // Use the browser's native date picker
        minValidYear: 2000, // Minimum valid year
        maxValidYear: 2025, // Maximum valid year
        inRangeInclusive: true, // Include the selected range boundaries
        filterOptions: ['inRange', 'greaterThan', 'lessThan'], // Allow inRange, greaterThan, and lessThan options
      	 suppressAndOrCondition: true,
	    comparator: function (localDateFilterAtMidnight, cellDateValue) {
            const cellDateConverted = new Date(cellDateValue); // Changed from "cellValue" to "cellDateValue"
            if (cellDateConverted.getTime() === localDateFilterAtMidnight.getTime()) {
                return 0; // Equals case
            }
            return cellDateConverted < localDateFilterAtMidnight ? -1 : 1; // Simple comparison
        },
        defaultOption: 'inRange', // Default to 'inRange'
    },
},
 

 
//{headerName: "Smoking",  filter: 'agSetColumnFilter', field: "smoker",  suppressSizeToFit: true,   type: 'dimension'},
//{headerName: "Pack/year",  filter: 'agSetColumnFilter', field: "pack_per_day",  suppressSizeToFit: true,   type: 'dimension'},
 
 {headerName: "Mayo Score",  filter: 'agSetColumnFilter', field: "mayoscore",  suppressSizeToFit: true,   type: 'dimension'},

 {headerName: "EIMS",  filter: 'agSetColumnFilter', field: "eims1",  suppressSizeToFit: true,   type: 'dimension'},
  {headerName: "Complications",  filter: 'agSetColumnFilter', field: "complications",  suppressSizeToFit: true,   type: 'dimension'},

 {headerName: "Surgery",  filter: 'agSetColumnFilter', field: "surgery",  suppressSizeToFit: true,   type: 'dimension'},
 {headerName: "Behaviour CD",  filter: 'agSetColumnFilter', field: "behaviorcd",  suppressSizeToFit: true,   type: 'dimension'},

{
    headerName: "Diagnosis",
    field: "diagnoses_data",
    filter: 'agSetColumnFilter',
    suppressSizeToFit: true,
    type: 'dimension',
    autoHeight: true, // Enable auto-height for rows
    cellStyle: { 'white-space': 'normal' }, // Allow text to wrap
    cellRenderer: function(params) {
        // Replace newlines with <br> tags for HTML display
        if (params.value) {
            return params.value.replace(/\n/g, '<br>');
        }
        return '';
    }
},
 

 

{
    headerName: "Chief Complaints",
    field: "chief_complaints_data",
    filter: 'agSetColumnFilter',
    suppressSizeToFit: true,
    type: 'dimension',
    autoHeight: true, // Enable auto-height for rows
    cellStyle: { 'white-space': 'normal' }, // Allow text to wrap
    cellRenderer: function(params) {
        // Replace newlines with <br> tags for HTML display
        if (params.value) {
            return params.value.replace(/\n/g, '<br>');
        }
        return '';
    }
} ,


{
    headerName: "Treatment",
    field: "treatment",
    filter: 'agSetColumnFilter',
    suppressSizeToFit: true,
    type: 'dimension',
    autoHeight: true, // Enable auto-height for rows
    cellStyle: { 'white-space': 'normal' }, // Allow text to wrap
    cellRenderer: function(params) {
        // Replace newlines with <br> tags for HTML display
        if (params.value) {
            return params.value.replace(/\n/g, '<br>');
        }
        return '';
    }
},

 
{
    headerName: "Medications",
    field: "medications_data",
    filter: 'agSetColumnFilter',
    suppressSizeToFit: true,
    type: 'dimension',
    autoHeight: true, // Enable auto-height for rows
    cellStyle: { 'white-space': 'normal' }, // Allow text to wrap
    cellRenderer: function(params) {
        // Replace newlines with <br> tags for HTML display
        if (params.value) {
            return params.value.replace(/\n/g, '<br>');
        }
        return '';
    }
},
 {headerName: "Management",  filter: 'agSetColumnFilter', field: "management",  suppressSizeToFit: true,   type: 'dimension'},



{
    headerName: "Notes",
    field: "formatted_notes",
    filter: 'agSetColumnFilter',
    suppressSizeToFit: true,
    type: 'dimension',
    autoHeight: true, // Enable auto-height for rows
    cellStyle: { 'white-space': 'normal' }, // Allow text to wrap
    cellRenderer: function(params) {
        // Replace newlines with <br> tags for HTML display
        if (params.value) {
            return params.value.replace(/\n/g, '<br>');
        }
        return '';
    }
},





{
    headerName: "Clinic Visits",
    field: "clinic_visits_data",
    filter: 'agSetColumnFilter',
    suppressSizeToFit: true,
    type: 'dimension',
    autoHeight: true, // Enable auto-height for rows
    cellStyle: { 'white-space': 'normal' }, // Allow text to wrap
    cellRenderer: function(params) {
        // Replace newlines with <br> tags for HTML display
        if (params.value) {
            return params.value.replace(/\n/g, '<br>');
        }
        return '';
    }
},



{
    headerName: "Clinical Readings",
    field: "clinical_readings_data",
    filter: 'agSetColumnFilter',
    suppressSizeToFit: true,
    type: 'dimension',
    autoHeight: true, // Enable auto-height for rows
    cellStyle: { 'white-space': 'normal' }, // Allow text to wrap
    cellRenderer: function(params) {
        // Replace newlines with <br> tags for HTML display
        if (params.value) {
            return params.value.replace(/\n/g, '<br>');
        }
        return '';
    }
}







	
];



function handleFullNameClick(id) {
    // Handle the click event, e.g., display the ID or navigate to another page
  //  alert('Clicked ID: ' + id);
    // You can also redirect to another page with the ID as a parameter
    window.open('load-record.php?id=' + id, '_blank');
}

function currencyFormatter(params) {
    return  formatNumber(params.value);
}

function formatNumber(number) {
 
    return parseFloat(number).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
}


function quantityFormatter(params) {
    return  quantityNumber(params.value);
}

function quantityNumber(number) {
 
    return parseFloat(number).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
}



</script>
