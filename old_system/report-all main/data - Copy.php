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
include ("../../Connections/dbname.php");


		$presentdate=date('Y-m-d');
							$my_branch=$_SESSION['branch_session'];	

	
	//echo json_encode($array); //Return the JSON Array

$qty_decimal=2;
	$my_tables_use=$_SESSION['my_tables'];
	$my_file_check=ltrim($my_tables_use).'_orderslip.orderslip_'.$my_branch;
	
$sql = mysql_query("select  item_code, batch_code, lot_number, category, item_desc,
	main_class, sub_class, prod_group_code, size, pcsperbox, supplier, unit_price, 
	srp, cost, uom, (sqm*quantity) AS sqm, date, department, custom1, custom2, custom3, custom4, custom5,
	ref_number, custname, del_date, po_number, quantity, warehouse, dr_number, dr_date, si_number, si_date,
	salescon, sc_date, amount, orig, item_color, item_design, custom6, custom7, custom8, custom9,
	custom10, agent
	 from $my_file_check  ");
	
	$array = array();
		
	while ($row = mysql_fetch_assoc($sql)) {
	
	//$array[] ='{var1: \''.$x.'\', var2: '.$x.'}';
	
		
	
		$item_code=ltrim(strtoupper($row["item_code"]));
		$batch_code=ltrim(strtoupper($row["batch_code"]));
		$lot_number=ltrim(strtoupper($row["lot_number"]));
		$category=ltrim(strtoupper($row["category"]));
		$item_desc=ltrim(strtoupper($row["item_desc"]));
		$main_class=ltrim(strtoupper($row["main_class"]));
		$sub_class=ltrim(strtoupper($row["sub_class"]));
		$prod_group_code=ltrim(strtoupper($row["prod_group_code"]));
		$size=ltrim(strtoupper($row["size"]));
		$pcsperbox=(float)$row["pcsperbox"];
		$supplier=ltrim(strtoupper($row["supplier"]));
		$unit_price=(float)$row["unit_price"];
		$srp=(float)$row["srp"];
		$cost=(float)$row["cost"];
		$uom=ltrim(strtoupper($row["uom"]));
		$sqm=(float)$row["sqm"];
		$date=$row["date"];
		$department=ltrim(strtoupper($row["department"]));
		$custom1=ltrim(strtoupper($row["custom1"]));
		$custom2=ltrim(strtoupper($row["custom2"]));
		$custom3=ltrim(strtoupper($row["custom3"]));
		$custom4=ltrim(strtoupper($row["custom4"]));
		$custom5=ltrim(strtoupper($row["custom5"]));
		$ref_number=ltrim(strtoupper($row["ref_number"]));
		$custname=ltrim(strtoupper($row["custname"]));
		$del_date=$row["del_date"];
		$po_number=ltrim(strtoupper($row["po_number"]));
		$quantity=(float)$row["quantity"];
		$warehouse=ltrim(strtoupper($row["warehouse"]));
		$dr_number=ltrim(strtoupper($row["dr_number"]));
		$dr_date=$row["dr_date"];
		$si_number=ltrim(strtoupper($row["si_number"]));
		$si_date=$row["si_date"];
		$salescon=ltrim(strtoupper($row["salescon"]));
		$sc_date=$row["sc_date"];
		$amount=(float)$row["amount"];
		$orig=(float)$row["orig"];
		$item_color=ltrim(strtoupper($row["item_color"]));
		$item_design=ltrim(strtoupper($row["item_design"]));
		$custom6=ltrim(strtoupper($row["custom6"]));
		$custom7=ltrim(strtoupper($row["custom7"]));
		$custom8=ltrim(strtoupper($row["custom8"]));
		$custom9=ltrim(strtoupper($row["custom9"]));
		$custom10=ltrim(strtoupper($row["custom10"]));
		$agent=ltrim(strtoupper($row["agent"]));
		
		
		
		
		if($item_desc=='' ) {
				continue;
		}
		
	
		
		$array[] ='{item_code: \'   '.$item_code.'   \', batch_code: \'    '.$batch_code.
					' \',lot_number: \' '.$lot_number.'  \', category: \'    '.$category.
					' \',item_desc: \' '.$item_desc.'  \', main_class: \'    '.$main_class.
				' \',sub_class: \' '.$sub_class.'  \', prod_group_code: \'    '.$prod_group_code.
				' \',size: \' '.$size.
					' \',pcsperbox: '.$pcsperbox.
			',supplier: \' '.$supplier.
				' \',unit_price: '.$unit_price.',srp: '.$srp.
					',cost: '.$cost.
					',uom: \' '.$uom.
					' \',sqm: '.$sqm.
					',date: \' '.$date.' \',department: \' '.$department.
					' \',custom1: \' '.$custom1.' \',custom2: \' '.$custom2.
					' \',custom3: \' '.$custom3.' \',custom4: \' '.$custom4.
						' \',custom5: \' '.$custom5.' \',ref_number: \' '.$ref_number.
							' \',custname: \' '.$custname.' \',del_date: \' '.$del_date.
						' \',po_number: \' '.$po_number.	
						' \',quantity: '.$quantity.
						',warehouse: \' '.$warehouse.' \',dr_number: \' '.$dr_number.
							' \',dr_date: \' '.$dr_date.' \',si_number: \' '.$si_number.
								' \',si_date: \' '.$si_date.' \',salescon: \' '.$salescon.
							' \',sc_date: \' '.$sc_date.
								' \',amount: '.$amount.
								',orig: '.$orig.
								',item_color: \' '.$item_color.' \',item_design: \' '.$item_design.
					' \',custom6: \' '.$custom6.
					' \',custom7: \' '.$custom7.
					' \',custom8: \' '.$custom8.' \',custom9: \' '.$custom9.
					' \',custom10: \' '.$custom10.
					' \',agent: \' '.$agent.' \''.
	
								
		
					'}';
		
	}
	
	$data1 = json_encode($array); //Return the JSON Array

	$data1=str_replace('","',',',$data1); 
	$data1=str_replace('}"]','}]',$data1); 
	$data1=str_replace('["','[',$data1); 
	$data1=str_replace('\r','',$data1); 
	$data1=str_replace('\n','',$data1); 
	$data1=str_replace('\t','',$data1); 
	$data1=str_replace('\/','',$data1); 
	
	

//echo $data1;

	
?>

<script type="text/javascript">


var rowData = <?php echo $data1 ?>;


var columnDefs = [


{headerName: "Date", field: "date", type: 'dimension', width: 145, filter:'agDateColumnFilter', filterParams:{
        comparator:function (filterLocalDateAtMidnight, cellValue){
            var dateAsString = cellValue;
            var dateParts  = dateAsString.split("-");
            var cellDate = new Date(Number(dateParts[0]),Number(dateParts[1]) - 1,Number(dateParts[2]));

            if (filterLocalDateAtMidnight.getTime() == cellDate.getTime()) {
                return 0
            }

            if (cellDate < filterLocalDateAtMidnight) {
                return -1;
            }

            if (cellDate > filterLocalDateAtMidnight) {
                return 1;
            }
        },
        clearButton:true
    }},

{headerName: "OS Number", field: "ref_number", type: 'dimension'},
{headerName: "Customer", field: "custname", type: 'dimension'},

{headerName: "Item Code", field: "item_code", type: 'dimension'},
{headerName: "Batch Code", field: "batch_code", type: 'dimension'},
{headerName: "Description", field: "item_desc", type: 'dimension'},
{headerName: "SRP", field: "srp", type: 'dimension', valueFormatter: currencyFormatter, cellClass: 'number-cell',
		filter: 'agSetColumnFilter', filterParams: {selectAllOnMiniFilter: true}, filter: 'agNumberColumnFilter', 
	cellClassRules: {'rag-red': 'x< 0'}},
	
	{headerName: "Quantity", field: "quantity", type: 'numberValue', valueFormatter: currencyFormatter, 
						cellClass: 'number-cell',
					filter: 'agSetColumnFilter', filterParams: {selectAllOnMiniFilter: true}, filter: 'agNumberColumnFilter', 
										cellClassRules: {'rag-red': 'x< 0'}},
										
				{headerName: "UOM", field: "uom", type: 'dimension'},	
				{headerName: "Amount", field: "amount", type: 'numberValue', valueFormatter: currencyFormatter, 
						cellClass: 'number-cell',
					filter: 'agSetColumnFilter', filterParams: {selectAllOnMiniFilter: true}, filter: 'agNumberColumnFilter', 
										cellClassRules: {'rag-red': 'x< 0'}},
						
{headerName: "SQM", field: "sqm", type: 'numberValue', valueFormatter: currencyFormatter, cellClass: 'number-cell',
					filter: 'agSetColumnFilter', filterParams: {selectAllOnMiniFilter: true}, filter: 'agNumberColumnFilter', 
										cellClassRules: {'rag-red': 'x< 0'}},
				
{headerName: "PO No.", field: "po_number", type: 'dimension'},
{headerName: "Sales Agent", field: "agent", type: 'dimension'},

{headerName: 'Delivery',
        children: [
					

				{headerName: "DR No.", field: "dr_number", type: 'dimension'},
						
						
						{headerName: "DR Date", type: 'dimension', field: "dr_date", width: 145, filter:'agDateColumnFilter',
						 columnGroupShow: 'open',  filterParams:{
        comparator:function (filterLocalDateAtMidnight, cellValue){
            var dateAsString = cellValue;
            var dateParts  = dateAsString.split("-");
            var cellDate = new Date(Number(dateParts[0]),Number(dateParts[1]) - 1,Number(dateParts[2]));

            if (filterLocalDateAtMidnight.getTime() == cellDate.getTime()) {
                return 0
            }

            if (cellDate < filterLocalDateAtMidnight) {
                return -1;
            }

            if (cellDate > filterLocalDateAtMidnight) {
                return 1;
            }
        },
        clearButton:true
    }},
						
					]
},

{headerName: 'Sales Ref',
        children: [
					
	{headerName: "SI No.", field: "si_number", type: 'dimension'},
	
	{headerName: "SI Date", type: 'dimension', field: "si_date", width: 145, filter:'agDateColumnFilter',  columnGroupShow: 'open', filterParams:{
        comparator:function (filterLocalDateAtMidnight, cellValue){
            var dateAsString = cellValue;
            var dateParts  = dateAsString.split("-");
            var cellDate = new Date(Number(dateParts[0]),Number(dateParts[1]) - 1,Number(dateParts[2]));

            if (filterLocalDateAtMidnight.getTime() == cellDate.getTime()) {
                return 0
            }

            if (cellDate < filterLocalDateAtMidnight) {
                return -1;
            }

            if (cellDate > filterLocalDateAtMidnight) {
                return 1;
            }
        },
        clearButton:true
    }},
	
	{headerName: "SC No.", field: "salescon", type: 'dimension', columnGroupShow: 'open'}
						
			]
},






{headerName: 'Category',
        children: [
					
					{headerName: "Warehouse", field: "warehouse", type: 'dimension'},
					
					
		
					
					{headerName: "Lot Number", field: "lot_number", type: 'dimension', columnGroupShow: 'open'},
					{headerName: "Category", field: "category", type: 'dimension', columnGroupShow: 'open'},
					{headerName: "Department", field: "department", type: 'dimension', columnGroupShow: 'open'},
					

					{headerName: "Class", field: "main_class", type: 'dimension', columnGroupShow: 'open'},
					{headerName: "Sub-Class", field: "sub_class", type: 'dimension', columnGroupShow: 'open'},
					{headerName: "Group Code", field: "prod_group_code", type: 'dimension', columnGroupShow: 'open'},
					{headerName: "Size", field: "size", type: 'dimension', columnGroupShow: 'open'},
					{headerName: "Color", field: "item_color", type: 'dimension', columnGroupShow: 'open'},
					{headerName: "Design", field: "item_design", type: 'dimension', columnGroupShow: 'open'},
					{headerName: "Volume", field: "pcsperbox", type: 'dimension', columnGroupShow: 'open'},
					{headerName: "Supplier", field: "supplier", type: 'dimension', columnGroupShow: 'open'},
					
				
						{headerName: "Custom 1", field: "custom1", type: 'dimension', columnGroupShow: 'open'},
						{headerName: "Custom 2", field: "custom2", type: 'dimension', columnGroupShow: 'open'},
						{headerName: "Custom 3", field: "custom3", type: 'dimension', columnGroupShow: 'open'},
						{headerName: "Custom 4", field: "custom4", type: 'dimension', columnGroupShow: 'open'},
						{headerName: "Custom 5", field: "custom5", type: 'dimension', columnGroupShow: 'open'},
						{headerName: "Custom 6", field: "custom6", type: 'dimension', columnGroupShow: 'open'},
						{headerName: "Custom 7", field: "custom7", type: 'dimension', columnGroupShow: 'open'},
						{headerName: "Custom 8", field: "custom8", type: 'dimension', columnGroupShow: 'open'},
						{headerName: "Custom 9", field: "custom9", type: 'dimension', columnGroupShow: 'open'},
						{headerName: "Custom 10", field: "custom10", type: 'dimension', columnGroupShow: 'open'}
		
				
					
					]
					
					
}




// {headerName: "Allocated", field: "allocated",  type: 'numberValue'},


//	 {field: "allocated", type: 'numberValue', cellStyle: {textAlign: "right"}},
	//   {field: "soh", type: 'numberValue', cellStyle: {textAlign: "right"}},
//	 {field: "balance", type: 'numberValue', cellStyle: {textAlign: "right"}}
	
    
	
];



function currencyFormatter(params) {
    return  formatNumber(params.value);
}

function formatNumber(number) {
    // this puts commas into the number eg 1000 goes to 1,000,
    // i pulled this from stack overflow, i have no idea how it works
    return parseFloat(number).toFixed(2).replace(/(\d)(?=(\d{3})+(?!\d))/g, "$1,");
}


</script>