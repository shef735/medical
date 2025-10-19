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
	  
	$filetoresult=ltrim($main_table_use).'_resources.patient_record';
	

$sql = mysqli_query($conn,"select  * from ".$filetoresult." ");
	 

$array = array();
	while ($row = mysqli_fetch_assoc($sql)) {
	
		$city[] = $row ;
	
	}
		$data1  = json_encode($city,JSON_NUMERIC_CHECK);
	
?>

<script type="text/javascript">


var rowData = <?php echo $data1 ?>;


var columnDefs = [





{headerName: "Date", field: "date",  suppressSizeToFit: true,   type: 'dimension'},
{
        headerName: "Full Name",
        field: "fullname",
        suppressSizeToFit: true,
        type: 'dimension',
        cellRenderer: function(params) {
            // Create a clickable link without overriding grid features
            return '<a href="javascript:void(0)" onclick="handleFullNameClick(' + params.data.id + ')">' + params.value + '</a>';
        },
        filter: true, // Ensure filtering is enabled
        sortable: true, // Ensure sorting is enabled
    },    
{headerName: "Age", field: "age",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Sex", field: "sex",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Contact", field: "contactnumber",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Height (cm)", field: "height_cm",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Weight (kg)", field: "weight_kg",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Birthday", field: "birthday",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Attending", field: "attending",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Hospital", field: "hospital",  suppressSizeToFit: true,   type: 'dimension'},

{headerName: "Smoking", field: "smokinghx",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Pack/year", field: "smokingpackyears",  suppressSizeToFit: true,   type: 'dimension'},

{headerName: "Diagnosis Date", field: "diagnosisyear",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Diagnosis", field: "diagnosis1",  suppressSizeToFit: true,   type: 'dimension'},






{headerName: "Family History", field: "familyhxofibd",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Past Med", field: "pastmedhxv",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Appendectomy", field: "appendectomy",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Ocpuse", field: "ocpuse",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Chief Complaint", field: "chiefcomplaint",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Other Symptoms", field: "othersymptoms1",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Other Symptoms", field: "othersymptoms2",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "EIMS", field: "eims1",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Hepa A Vac", field: "hepavaccination",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Hepa B Vac", field: "hepbvaccination",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Reactive", field: "reactive",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "HGB Levels", field: "hgblevels",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Type of Anemia", field: "typeofanemia",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Platelet Count", field: "plateletcount",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Albumin", field: "albumin",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "CRP Level", field: "crplevel",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "ESR", field: "esr",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Cdifficileinfxn", field: "cdifficileinfxn",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Procedure Done", field: "proceduredone",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Date of Procedure", field: "dateofprocedure",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Endoscopic Findings", field: "endoscopicfindings",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Lesion", field: "lesion1",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Lesion", field: "lesion2",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Lesion", field: "lesion3",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Colonoscopic Findings", field: "colonoscopicfindings",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Distribution", field: "distribution",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Diagnosis", field: "diagnosis2",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Histopathfindings", field: "histopathfindings1",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Histopathfindings", field: "histopathfindings2",  suppressSizeToFit: true,   type: 'dimension'},
 {headerName: "Histopathfindings", field: "histopathfindings3",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Histopathfindings", field: "histopathfindings",  suppressSizeToFit: true,   type: 'dimension'},
{headerName: "Initial Treatment", field: "initialtreatment",  suppressSizeToFit: true,   type: 'dimension'},

 {headerName: "Duration", field: "duration",  suppressSizeToFit: true,   type: 'dimension'},
 

 {headerName: "Follow up", field: "dateoffollowup",  suppressSizeToFit: true,   type: 'dimension'},
 {headerName: "Implorement", field: "improvement",  suppressSizeToFit: true,   type: 'dimension'},
 {headerName: "Additional Treatment", field: "additionaltreatment",  suppressSizeToFit: true,   type: 'dimension'},
 {headerName: "Repeat Colonoscopy", field: "repeatcolonoscopy",  suppressSizeToFit: true,   type: 'dimension'},

 {headerName: "Date of colonoscopy", field: "dateofcolonoscopy",  suppressSizeToFit: true,   type: 'dimension'},

 {headerName: "Nayo Score", field: "mayoscore",  suppressSizeToFit: true,   type: 'dimension'},
 {headerName: "Frequency of stools", field: "frequencyofstools",  suppressSizeToFit: true,   type: 'dimension'},
 {headerName: "Abdominal Pain", field: "abdominalpain",  suppressSizeToFit: true,   type: 'dimension'},

 {headerName: "General well being", field: "generalwellbeing",  suppressSizeToFit: true,   type: 'dimension'},
 {headerName: "Eims", field: "eims2",  suppressSizeToFit: true,   type: 'dimension'},
 {headerName: "Montreal xtentforuc", field: "montrealextentforuc",  suppressSizeToFit: true,   type: 'dimension'},
 {headerName: "Severity inuc", field: "severityinuc",  suppressSizeToFit: true,   type: 'dimension'},

 {headerName: "Locationcd", field: "severityinuc",  suppressSizeToFit: true,   type: 'dimension'},

 {headerName: "behavior cd", field: "behaviorcd",  suppressSizeToFit: true,   type: 'dimension'},
 {headerName: "Complications", field: "complications",  suppressSizeToFit: true,   type: 'dimension'},
 {headerName: "Complications", field: "surgery",  suppressSizeToFit: true,   type: 'dimension'},
 {headerName: "Notes", field: "notes",  suppressSizeToFit: true,   type: 'dimension'},
 {headerName: "Management", field: "management",  suppressSizeToFit: true,   type: 'dimension'},
 {headerName: "longedsteroids", field: "longedsteroids",  suppressSizeToFit: true,   type: 'dimension'},
 
 
 
/*
user_id
 


bmi


diagnosisyear



smokinghx
smokingpackyears
contactnumber
familyhxofibd
pastmedhxv
appendectomy
ocpuse
chiefcomplaint
othersymptoms1
othersymptoms2
eims1
hepavaccination
hepbvaccination
reactive
hgblevels
typeofanemia
plateletcount
albumin
crplevel
esr
cdifficileinfxn
proceduredone
dateofprocedure
endoscopicfindings
lesion1
lesion2
lesion3
colonoscopicfindings
distribution
diagnosis2
histopathfindings1
histopathfindings2
histopathfindings3
histopathfinding
initialtreatment
duration
dateoffollowup
improvement
additionaltreatment
repeatcolonoscopy
dateofcolonoscopy
mayoscore
frequencyofstools
abdominalpain
generalwellbeing
eims2
montrealextentforuc
severityinuc
locationcd
behaviorcd
complications
surgery
notes
management
useofprolongedsteroids
biologics
typeofbiologics Ascending 1
*/

/* {headerName: 'SRP', field: 'srp_current', type: 'numberValue', valueFormatter: currencyFormatter, cellClass: 'number-cell', width: 100, suppressSizeToFit: true, 
							filter: 'agSetColumnFilter', filterParams: {selectAllOnMiniFilter: true}, filter: 'agNumberColumnFilter', 
						cellClassRules: {'rag-red': 'x<0'},
						cellStyle: function (params) {
									if (params.value >0) {
											return { color: 'black', 'font-size': '14px' };
									} else {
										if (params.value ==0) {
											return { color: 'white', 'font-size': '14px' };
										}
										else
										{
											return { color: 'red', 'font-size': '14px' };
										}
									}
              			  }},
 {headerName: 'Cost', field: 'cost_current', type: 'numberValue', valueFormatter: currencyFormatter, cellClass: 'number-cell', width: 100, suppressSizeToFit: true, 
							filter: 'agSetColumnFilter', filterParams: {selectAllOnMiniFilter: true}, filter: 'agNumberColumnFilter', 
						cellClassRules: {'rag-red': 'x<0'},
						cellStyle: function (params) {
									if (params.value >0) {
											return { color: 'black', 'font-size': '14px' };
									} else {
										if (params.value ==0) {
											return { color: 'white', 'font-size': '14px' };
										}
										else
										{
											return { color: 'red', 'font-size': '14px' };
										}
									}
              			  }},
*/


	

	


// {headerName: "Allocated", field: "allocated",  type: 'numberValue'},


//	 {field: "allocated", type: 'numberValue', cellStyle: {textAlign: "right"}},
	//   {field: "soh", type: 'numberValue', cellStyle: {textAlign: "right"}},
//	 {field: "balance", type: 'numberValue', cellStyle: {textAlign: "right"}}
	
    
	
];


function handleFullNameClick(id) {
    // Handle the click event, e.g., display the ID or navigate to another page
    alert('Clicked ID: ' + id);
    // You can also redirect to another page with the ID as a parameter
    // window.location.href = 'details.php?id=' + id;
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