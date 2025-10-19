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
	  
 	
$sql = mysqli_query($conn, "
    SELECT 
        pr.*, 
        pd.*,  
        DATE_FORMAT(pr.birthday, '%m/%d/%Y') AS formatted_bday,
        DATE_FORMAT(pr.date, '%m/%d/%Y') AS formatted_date,
        TIMESTAMPDIFF(YEAR, pr.birthday, CURDATE()) AS age,
        GROUP_CONCAT(pn.note SEPARATOR '\n') AS concatenated_notes
    FROM 
        ".$main_table_use."_resources.patient_info pr
    LEFT JOIN 
        ".$main_table_use."_resources.patient_details pd ON pr.user_id = pd.user_id
    LEFT JOIN 
        ".$main_table_use."_resources.patient_notes pn ON pr.user_id = pn.user_id
   
    ORDER BY 
        pr.id DESC
");

 //GROUP BY 
  //      pr.id, pd.column1, pd.column2  
  
$array = array();
	while ($row = mysqli_fetch_assoc($sql)) {
	
		$city[] = $row ;
	
	}
		$data1  = json_encode($city,JSON_NUMERIC_CHECK);
	
?>

<script type="text/javascript">


var rowData = <?php echo $data1 ?>;


var columnDefs = [

	 {
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
    },

{
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
},
 {
        headerName: "Full Name", 
        field: "fullname",  
        suppressSizeToFit: true,
        type: 'dimension',    
        cellRenderer: function(params) {
            // Create a clickable link without overriding grid features
            return '<a href="javascript:void(0)" onclick="handleFullNameClick(' + params.data.id + ')">' + params.value + '</a>';
        },     filter: 'agTextColumnFilter',
       
    },    
{headerName: "Age", filter: 'agNumberColumnFilter' ,field: "age",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Sex", field: "sex",   filter: 'agSetColumnFilter', // Use the set filter for dropdown options
    filterParams: {
        values: ['MALE', 'FEMALE'], // Define the dropdown options
    }, suppressSizeToFit: true,   type: 'dimension'},
	
{headerName: "Contact",  filter: 'agTextColumnFilter', field: "contactnumber",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Height (cm)", filter: 'agNumberColumnFilter' , field: "height_cm",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Weight (kg)", filter: 'agNumberColumnFilter' , field: "weight_kg",  suppressSizeToFit: true,   type: 'dimension'},

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

{
  headerName: "Attending",
  field: "attending",
  filter: 'agSetColumnFilter',  // Use set filter for categorical data
  suppressSizeToFit: true,
  type: 'dimension',
  
},



{
 headerName: "Hospital", field: "hospital", 
  filter: 'agSetColumnFilter',  // Use set filter for categorical data
  suppressSizeToFit: true,
  type: 'dimension',
  
},

 
{headerName: "Smoking",  filter: 'agSetColumnFilter', field: "smokinghx",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Pack/year",  filter: 'agSetColumnFilter', field: "smokingpackyears",  suppressSizeToFit: true,   type: 'dimension'},

{headerName: "Diagnosis Year", field: "diagnosisyear", filter: 'agSetColumnFilter', suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Diagnosis",  filter: 'agSetColumnFilter', field: "diagnosis1",  suppressSizeToFit: true,   type: 'dimension'},






{headerName: "Family History",  filter: 'agSetColumnFilter', field: "familyhxofibd",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Past Med HXV", filter: 'agSetColumnFilter',  field: "pastmedhxv",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Appendectomy",  filter: 'agSetColumnFilter', field: "appendectomy",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "OCP Use",  filter: 'agSetColumnFilter', field: "ocpuse",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Chief Complaint", filter: 'agSetColumnFilter',  field: "chiefcomplaint",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Other Symptoms",  filter: 'agSetColumnFilter', field: "othersymptoms1",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Other Symptoms", filter: 'agSetColumnFilter',  field: "othersymptoms2",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "EIMS", filter: 'agSetColumnFilter',  field: "eims1",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Hepa A Vac",  filter: 'agSetColumnFilter', field: "hepavaccination",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Hepa B Vac",  filter: 'agSetColumnFilter', field: "hepbvaccination",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Reactive",  filter: 'agSetColumnFilter', field: "reactive",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "HGB Levels",  filter: 'agSetColumnFilter', field: "hgblevels",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Type of Anemia", filter: 'agSetColumnFilter',  field: "typeofanemia",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Platelet Count",  filter: 'agSetColumnFilter',  field: "plateletcount",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Albumin", filter: 'agSetColumnFilter',  field: "albumin",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "CRP Level", filter: 'agSetColumnFilter', field: "crplevel",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "ESR",  filter: 'agSetColumnFilter', field: "esr",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Cdifficileinfxn", filter: 'agSetColumnFilter',  field: "cdifficileinfxn",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Procedure Done", filter: 'agSetColumnFilter', field: "proceduredone",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Date of Procedure", filter: 'agSetColumnFilter',  field: "dateofprocedure",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Endoscopic Findings", filter: 'agSetColumnFilter',  field: "endoscopicfindings",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Lesion", filter: 'agSetColumnFilter',  field: "lesion1",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Lesion",  filter: 'agSetColumnFilter', field: "lesion2",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Lesion",  filter: 'agSetColumnFilter', field: "lesion3",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Colonoscopic Findings",  filter: 'agSetColumnFilter', field: "colonoscopicfindings",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Distribution", filter: 'agSetColumnFilter',  field: "distribution",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Diagnosis",  filter: 'agSetColumnFilter', field: "diagnosis2",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Histopathfindings", filter: 'agSetColumnFilter',  field: "histopathfindings1",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Histopathfindings", filter: 'agSetColumnFilter',  field: "histopathfindings2",  suppressSizeToFit: true,   type: 'dimension'},
 {headerName: "Histopathfindings",  filter: 'agSetColumnFilter', field: "histopathfindings3",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Histopathfindings", filter: 'agSetColumnFilter',  field: "histopathfindings",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Initial Treatment",  filter: 'agSetColumnFilter', field: "initialtreatment",  suppressSizeToFit: true,   type: 'dimension'},

 {headerName: "Duration",  filter: 'agSetColumnFilter', field: "duration",  suppressSizeToFit: true,   type: 'dimension'},
 

 {headerName: "Follow up",  filter: 'agSetColumnFilter', field: "dateoffollowup",  suppressSizeToFit: true,   type: 'dimension'},
 {headerName: "Implorement", filter: 'agSetColumnFilter',  field: "improvement",  suppressSizeToFit: true,   type: 'dimension'},
 {headerName: "Additional Treatment", filter: 'agSetColumnFilter',  field: "additionaltreatment",  suppressSizeToFit: true,   type: 'dimension'},
 {headerName: "Repeat Colonoscopy", filter: 'agSetColumnFilter',  field: "repeatcolonoscopy",  suppressSizeToFit: true,   type: 'dimension'},

 {headerName: "Date of colonoscopy", filter: 'agSetColumnFilter',  field: "dateofcolonoscopy",  suppressSizeToFit: true,   type: 'dimension'},

 {headerName: "Mayo Score",  filter: 'agSetColumnFilter', field: "mayoscore",  suppressSizeToFit: true,   type: 'dimension'},
 {headerName: "Frequency of stools", filter: 'agSetColumnFilter',  field: "frequencyofstools",  suppressSizeToFit: true,   type: 'dimension'},
 {headerName: "Abdominal Pain", filter: 'agSetColumnFilter',  field: "abdominalpain",  suppressSizeToFit: true,   type: 'dimension'},

 {headerName: "General well being",  filter: 'agSetColumnFilter', field: "generalwellbeing",  suppressSizeToFit: true,   type: 'dimension'},
 {headerName: "Eims", field: "eims2",  filter: 'agSetColumnFilter',  suppressSizeToFit: true,   type: 'dimension'},
 {headerName: "Montreal xtentforuc",  filter: 'agSetColumnFilter', field: "montrealextentforuc",  suppressSizeToFit: true,   type: 'dimension'},
 {headerName: "Severity inuc",  filter: 'agSetColumnFilter', field: "severityinuc",  suppressSizeToFit: true,   type: 'dimension'},

 {headerName: "Locationcd",  filter: 'agSetColumnFilter', field: "severityinuc",  suppressSizeToFit: true,   type: 'dimension'},

 {headerName: "behavior cd",  filter: 'agSetColumnFilter', field: "behaviorcd",  suppressSizeToFit: true,   type: 'dimension'},
 {headerName: "Complications",  filter: 'agSetColumnFilter', field: "complications",  suppressSizeToFit: true,   type: 'dimension'},
 {headerName: "Complications",  filter: 'agSetColumnFilter', field: "surgery",  suppressSizeToFit: true,   type: 'dimension'},
 {headerName: "Notes",  filter: 'agSetColumnFilter', field: "notes",  suppressSizeToFit: true,   type: 'dimension'},
 {headerName: "Management",  filter: 'agSetColumnFilter', field: "management",  suppressSizeToFit: true,   type: 'dimension'},
 {headerName: "longedsteroids",  filter: 'agSetColumnFilter', field: "longedsteroids",  suppressSizeToFit: true,   type: 'dimension'},

 {headerName: "Use of proloned Steroids", filter: 'agSetColumnFilter', field: "useofprolongedsteroids",  suppressSizeToFit: true,   type: 'dimension'},
 {headerName: "Biologics",  filter: 'agSetColumnFilter', field: "biologics",  suppressSizeToFit: true,   type: 'dimension'},

 {headerName: "Type of biologics", filter: 'agSetColumnFilter',  field: "typeofbiologics",  suppressSizeToFit: true,   type: 'dimension'},
 
	
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
