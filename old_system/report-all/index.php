<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>



<?php 
  
  if(!isset($_SESSION['user_name'])) {

    echo "<script>window.location = '../index.php'</script>";


}  
 
  
 $selection_option='quantity';
  
$stock_option='available';
 
$date_as_of=$presentdate;
 
  
 
 include "data.php";

	
$presentdate_new=date('d/m/Y');

?>
	


<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>REPORT VIEW ALL</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
 
  <link rel="stylesheet" href="../assets/bower_components/bootstrap/dist/css/bootstrap.min.css">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="../assets/bower_components/font-awesome/css/font-awesome.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="../assets/bower_components/Ionicons/css/ionicons.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/dist/css/AdminLTE.min.css">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="../assets/dist/css/skins/_all-skins.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" type="text/css" href="../assets/css/googleapis.css">

  <style>
 
/* Popup Overlay */
#popupOverlay {
    display: none;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    z-index: 1000;
}

/* Popup Content */
#popupContent {
    position: fixed;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    background: white;
    padding: 20px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    width: 300px;
}

/* Form Inputs */
#editForm input {
    width: 100%;
    padding: 8px;
    margin-bottom: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
}

/* Buttons */
#editForm button {
    padding: 8px 16px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    color: white;
}

#editForm button[onclick="saveChanges()"] {
    background: #4CAF50;
}

#editForm button[onclick="closePopup()"] {
    background: #f44336;
    margin-left: 10px;
}

/* Modal Styles */
/* Modal Styles */
.modal {
    display: none; /* Hidden by default */
    position: fixed; /* Stay in place */
    z-index: 1000; /* Sit on top */
    left: 0;
    top: 0;
    width: 100%; /* Full width */
    height: 100%; /* Full height */
    overflow: auto; /* Enable scroll if needed */
    background-color: rgba(0, 0, 0, 0.5); /* Black with opacity */
}

.modal-content {
    background-color: #fff;
    margin: 5% auto; /* 5% from the top and centered */
    padding: 20px;
    border-radius: 10px;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
    width: 90%; /* Responsive width */
    max-width: 500px; /* Maximum width */
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.close:hover {
    color: #000;
}

/* Form Styles */
#addRecordForm {
    display: flex;
    flex-direction: column;
    gap: 15px; /* Space between form groups */
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 5px; /* Space between label and input */
}

.form-group label {
    font-weight: bold;
    color: #333;
}

.form-group input,
.form-group select {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
    outline: none;
    transition: border-color 0.3s ease;
}

.form-group input:focus,
.form-group select:focus {
    border-color: #007bff; /* Highlight focus */
}

/* Button Styles */
.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px; /* Space between buttons */
    margin-top: 20px;
}

.btn-submit,
.btn-cancel {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    font-size: 16px;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.btn-submit {
    background-color: #007bff;
    color: #fff;
}

.btn-submit:hover {
    background-color: #0056b3;
}

.btn-cancel {
    background-color: #6c757d;
    color: #fff;
}

.btn-cancel:hover {
    background-color: #5a6268;
}

#myGrid {
    width: 100%;
    height: 100%;
}
 
  </style>
</head>
<!-- ADD THE CLASS layout-top-nav TO REMOVE THE SIDEBAR. -->
<body class="hold-transition skin-blue layout-top-nav">
<div class="wrapper">




  <header class="main-header">
    <nav class="navbar navbar-static-top">
      <div class="container">
        <div class="navbar-header">
          <a href="../../index.php" class="navbar-brand"><b>Patient</b>List</a>
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar-collapse">
            <i class="fa fa-bars"></i>
          </button>
        </div>   

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse pull-left" id="navbar-collapse">
          <ul class="nav navbar-nav">
            <li class="active"><a href="../../index.php">Home<span class="sr-only">(current)</span></a></li>
            <li><a href="#" onclick="sizeToFit()">Size to Fit</a></li>
               <li><a href="#" onclick="autoSizeAll()"  >Auto-Size All</a></li>
     <li><a href="#" onclick="expandAll()">Expand All</a></li>
       <li><a href="#" onclick="collapseAll()">Collapse All</a></li>
     
     
     
            
          </ul>
          
           
          
        </div>
        <!-- /.navbar-collapse -->
        <!-- Navbar Right Menu -->
        
      
        
        <div style="padding-bottom: 4px;  visibility:hidden; position:absolute">
                    
                            <input type="checkbox" id="skipHeader"/>
                          
                            <input type="checkbox" id="columnGroups"/>
                          
                            <input type="checkbox" id="skipFooters"/>
                       
                            <input type="checkbox" id="onlySelected"/>
                          
                            <input type="checkbox" id="useCellCallback"/>
                          
                            <input type="checkbox" id="processHeaders"/>
                           
                            <input type="checkbox" id="skipPinnedTop"/>
                          
                            <input type="checkbox" id="skipPinnedBottom"/>
                         
                            <input type="checkbox" id="skipGroups"/>
                         
                            <input type="checkbox" id="useSpecificColumns"/>
                       
                            <input type="checkbox" id="allColumns"/>
                      
                            <input type="checkbox" id="skipGroupR"/>
                       
                            <input type="checkbox" id="appendHeader"/>
                           
                            <input type="checkbox" id="appendFooter"/>
                          
                   
                </div>
        
        <!-- /.navbar-custom-menu -->
      </div>
      <!-- /.container-fluid -->
    </nav>
  </header>
  <!-- Full Width Column -->
  <div class="content-wrapper">
    <div >
      <!-- Content Header (Page header) -->
      

      <!-- Main content -->
      <section class="content">
      
      
      
      
      <div class="box box-danger">
           
            <div class="box-body">
              <div class="row">
                <div class="col-xs-6">
                        <div class="input-group">
                              <div class="input-group-btn">
                                  <button  type="button" class="btn btn-danger" onclick="onBtExport()">Export to Excel</button>
                              </div>
                                
                                <input type="text" id="fileName" class="form-control" placeholder="File Name">
                                 <input style="visibility:hidden; position:absolute" type="text" 
                                        id="sheetName" class="form-control" placeholder="Sheet Name">
                        </div>
                     
                
                </div>
                
                 <div class="col-xs-6"> 
                   <input type="text" id="filter-text-box"  class="form-control" 
              		placeholder="Quick Search..." oninput="onFilterTextBoxChanged()"/>
               	</div>
              </div>
            </div>
            <!-- /.box-body -->
            
            
            
          </div>
      
   <!-- <button onclick="openAddRecordForm()">Add New Record</button>   -->
   
    <!-- Popup Overlay -->
<div id="popupOverlay" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0, 0, 0, 0.5); z-index: 1000;">
    <!-- Popup Content -->
    <div id="popupContent" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background: white; padding: 20px; border-radius: 8px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); width: 300px;">
        <h3 style="margin-top: 0;">Edit Record</h3>
        <form id="editForm">
            <label for="editDate">Date:</label>
            <input type="text" id="editDate" name="date" style="width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;"><br>
            <label for="editFullName">Full Name:</label>
            <input type="text" id="editFullName" name="fullname" style="width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;"><br>
            <label for="editAge">Age:</label>
            <input type="text" id="editAge" name="age" style="width: 100%; padding: 8px; margin-bottom: 10px; border: 1px solid #ccc; border-radius: 4px;"><br>
            <div style="text-align: right;">
                <button type="button" onclick="saveChanges()" style="padding: 8px 16px; background: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;">Save</button>
                <button type="button" onclick="closePopup()" style="padding: 8px 16px; background: #f44336; color: white; border: none; border-radius: 4px; cursor: pointer; margin-left: 10px;">Cancel</button>
            </div>
        </form>
    </div>
</div>
<!-- Popup Form -->
<div id="addRecordModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeAddRecordForm()">&times;</span>
        <h2>Add New Record</h2>
        <form id="addRecordForm">
            <div class="form-group">
                <label for="fullname">Full Name:</label>
                <input type="text" id="fullname" name="fullname" required>
            </div>

            <div class="form-group">
                <label for="age">Age:</label>
                <input type="number" id="age" name="age" required>
            </div>

            <div class="form-group">
                <label for="sex">Sex:</label>
                <select id="sex" name="sex" required>
                    <option value="MALE">Male</option>
                    <option value="FEMALE">Female</option>
                </select>
            </div>

            <div class="form-group">
                <label for="contactnumber">Contact Number:</label>
                <input type="text" id="contactnumber" name="contactnumber" required>
            </div>

            <!-- Add more fields as needed -->

            <div class="form-actions">
                <button type="button" class="btn-submit" onclick="submitAddRecordForm()">Submit</button>
                <button type="button" class="btn-cancel" onclick="closeAddRecordForm()">Cancel</button>
            </div>
        </form>
    </div>
</div>



      
          <div id="filteredCount"></div>
        <div id="myGrid" class="box-body ag-theme-balham"  style="width: 100%; height: 70%;"></div>
         
     <script src="main2.js"></script>
        
 
 
          <!-- /.box-body -->
       
        <!-- /.box -->
      </section>
      <!-- /.content -->
    </div>
    <!-- /.container -->
  </div>
  <!-- /.content-wrapper -->
   
</div>

  <script src="../assets/vendor/jquery/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="../assets/vendor/select2/select2.min.js"></script>
    <script src="../assets/vendor/datepicker/moment.min.js"></script>
    <script src="../assets/vendor/datepicker/daterangepicker.js"></script>
    
    <script src="../assets/plugins/input-mask/jquery.inputmask.js"></script>
<script src="../assets/plugins/input-mask/jquery.inputmask.date.extensions.js"></script>
<script src="../assets/plugins/input-mask/jquery.inputmask.extensions.js"></script>

    <!-- Main JS-->
    <script src="../assets/js/global.js"></script>


<script>
  $(function () {
    //Initialize Select2 Elements
   

    //Datemask dd/mm/yyyy
     $('#datemask').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Datemask2 mm/dd/yyyy
    $('#datemask2').inputmask('mm/dd/yyyy', { 'placeholder': 'mm/dd/yyyy' })
    //Money Euro
    $('[data-mask]').inputmask()
	
 })
</script>	

<!-- ./wrapper -->
	<script src="ag-grid-enterprise-master/dist/ag-grid-enterprise.min.js"></script>
    
<!-- jQuery 3 -->
<script src="../assets/bower_components/jquery/dist/jquery.min.js"></script>
<!-- Bootstrap 3.3.7 -->
<script src="../assets/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- SlimScroll -->
<script src="../assets/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="../assets/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="../assets/dist/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="../assets/dist/js/demo.js"></script>


<script>
var currentRecordId = null;

// Function to open the popup
function openEditPopup(id) {
    // Find the record in rowData
    var record = rowData.find(function(row) {
        return row.id === id;
    });

    if (record) {
        // Populate the form with record data
        document.getElementById('editDate').value = record.date;
        document.getElementById('editFullName').value = record.fullname;
        document.getElementById('editAge').value = record.age;

        // Store the current record ID
        currentRecordId = id;

        // Show the popup
        document.getElementById('popupOverlay').style.display = 'block';
    }
}

// Function to close the popup
function closePopup() {
    // Hide the popup
    document.getElementById('popupOverlay').style.display = 'none';
}
</script>


<script>

function saveChanges() {
    // Get updated data from the form
    var updatedData = {
        id: currentRecordId,
        date: document.getElementById('editDate').value,
        fullname: document.getElementById('editFullName').value,
        age: document.getElementById('editAge').value,
    };

    // Send AJAX request to update the record
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'update_record.php', true);
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            var response = JSON.parse(xhr.responseText);
            if (response.success) {
            //    alert('Record updated successfully!');
				
             //   closePopup();

			  // Save the edited record ID in localStorage
                localStorage.setItem('lastEditedRecordId', currentRecordId);

                // Refresh the page
                window.location.reload();

				// window.location.href = 'index.php';

                // Update the grid data
                var recordIndex = rowData.findIndex(function(row) {
                    return row.id === currentRecordId;
                });
                if (recordIndex !== -1) {
                    rowData[recordIndex] = updatedData;
                    gridOptions.api.refreshCells(); // Refresh the grid
                }
            } else {
                alert('Error updating record: ' + response.message);
            }
        }
    };
    xhr.send(JSON.stringify(updatedData));
}

</script>


<script>
// Open the popup form
function openAddRecordForm() {
    document.getElementById('addRecordModal').style.display = 'block';
}

// Close the popup form
function closeAddRecordForm() {
    document.getElementById('addRecordModal').style.display = 'none';
}

// Submit the form data
function submitAddRecordForm() {
    const formData = new FormData(document.getElementById('addRecordForm'));
    const data = {};
    formData.forEach((value, key) => {
        data[key] = value;
    });

    fetch('add_record.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data),
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('Record added successfully!');
            closeAddRecordForm();
            // Optionally, refresh the grid or add the new record to the existing data
            refreshGrid();

            
        } else {
            alert('Error adding record: ' + data.message);
        }
    })
    .catch((error) => {
        console.error('Error:', error);
    });
}



function deleteRecord(recordId) {
    // Confirm deletion
    if (confirm("Are you sure you want to delete this record?")) {
        // Send a request to delete the record
        fetch('delete_record.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ id: recordId }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
               // alert('Record deleted successfully!');
                // Refresh the grid
                refreshGrid();
            } else {
                alert('Error deleting record: ' + data.message);
            }
        })
        .catch((error) => {
            console.error('Error:', error);
        });
    }
}


// Refresh the grid after adding a record
function refreshGrid() {
    // Implement logic to refresh the grid, e.g., reload the page or fetch new data
    location.reload();
}


</script>

 
</body>
</html>
