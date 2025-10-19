<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>
  

<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags-->
    <meta charset="utf-8">
    <meta http-equiv="refresh" name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">
    <meta name="keywords" content="admin template, html 5 admin template , medixo admin , dashboard template, bootstrap 5 admin template, responsive admin template">
    <title><?php echo $_SESSION['system_name'] ?></title>
    <!-- shortcut icon-->
    <link rel="shortcut icon" href="../../../uploads/images/logo/icon-logo.png" type="image/x-icon">
    <!-- Fonts css-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    <!-- Font awesome -->
    <link href="../assets/css/vendor/font-awesome.css" rel="stylesheet">
    <link href="../assets/css/vendor/themify-icons.css" rel="stylesheet">
    <link href="../assets/css/vendor/icoicon.css" rel="stylesheet">
    <!-- datepicker-->
    <link href="../assets/css/vendor/datepicker/datepicker.css" rel="stylesheet">
    <!-- select 2 css-->
    <link href="../assets/css/vendor/select2/select2.min.css" rel="stylesheet">
    <!--Datatable-->
    <link href="../assets/css/vendor/datatable/jquery.dataTables.min.css" rel="stylesheet">
    <link href="../assets/css/vendor/datatable/buttons.dataTables.min.css" rel="stylesheet">
    <!-- Scrollbar-->
    <link href="../assets/css/vendor/simplebar.css" rel="stylesheet">
    <!-- Bootstrap css-->
    <link href="../assets/css/vendor/bootstrap.css" rel="stylesheet">
    <!-- Custom css-->
    <link href="../assets/css/style.css" rel="stylesheet">

   
    <?php 

ini_set('display_errors', 1);
error_reporting(E_ALL);

unset($_SESSION['edit_click']);
unset($_SESSION['add_click']);
unset($_SESSION['patient_id']);

include "../../../Connections/dbname.php";
include "includes/header.php"; 

function calculateAge($birthdate) {
    // Convert the birthdate string to a DateTime object
    $birthDate = new DateTime($birthdate);
    $today = new DateTime('today');
    
    // Calculate the age
    $age = $birthDate->diff($today)->y;

    return $age;
}


?>


 <style>
        
        .action-buttons {
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        .btn {
            padding: 8px 15px;
            border-radius: 4px;
            text-decoration: none;
            color: white;
            font-size: 14px;
            display: inline-block;
        }
        .btn-add {
            background: #2ecc71;
        }
        .btn-add:hover {
            background: #27ae60;
        }
        
     
        .success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }
        .error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        
        .action-cell {
            white-space: nowrap;
        }
        .action-link {
            padding: 5px 10px;
            border-radius: 3px;
            text-decoration: none;
            margin-right: 5px;
            font-size: 13px;
            display: inline-block;
        }
        .view-link {
            background: #3498db;
            color: white;
        }
        .view-link:hover {
            background: #2980b9;
        }
        .edit-link {
            background: #f39c12;
            color: white;
        }
        .edit-link:hover {
            background: #e67e22;
        }
        .delete-link {
            background: #e74c3c;
            color: white;
         }
        .delete-link:hover {
            background: #c0392b;
        }

        .add-note-link {
            background: #9b59b6;
            color: white;
        }

        .add-note-link:hover {
            background: #8e44ad;
        }

        .add-visit-link {
            background:rgb(19, 161, 249);
            color: white;
        }

        .add-visit-link:hover {
            background: rgb(19, 161, 249);
        }
                
    </style>
  </head>
  <body>   
        <?php include "includes/sidebar.php"; ?>

      <!-- Header End-->
    <div class="themebody-wrap">
      <!-- breadcrumb start-->
        <div class="codex-breadcrumb">
          <div class="container-fluid">
            <div class="breadcrumb-contain">
              <div class="left-breadcrumb">
                <ul class="breadcrumb mb-0">
                  <li class="breadcrumb-item"><a href="index.html">
                      <h1>Dashboard</h1></a></li>
                  <li class="breadcrumb-item"><a href="javascript:void(0);">application</a></li>
                  <li class="breadcrumb-item active"><a href="javascript:void(0);">Datatable Advance</a></li>
                </ul>
              </div>
              <div class="right-breadcrumb">
                <ul>
                  <li>
                    <div class="bread-wrap"><i class="fa fa-clock-o"></i></div><span class="liveTime"></span>
                  </li>
                  <li>
                    <div class="bread-wrap"><i class="fa fa-calendar"></i></div><span class="getDate"></span>
                  </li>
                </ul>
              </div>
            </div>
          </div>
        </div>
      <!-- breadcrumb end-->
      <!-- theme body start-->
      <div class="theme-body codex-chat">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">  
                <div class="card-body"><!--<a class="btn btn-primary float-end mb-15" href="javascript:void(0);" data-bs-toggle="modal" data-bs-target="#patientmodalmodal">Add Patient</a> -->
                  <table class="patients-tbl table" style="width:100%;">
                    <thead>
                      <tr>
                       <th>Patient ID</th>   
                        <th>Name</th>                    
                        <th>Age</th>
                        <th>Gender</th>                      
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      

                <?php

                 $total_update_sql= "UPDATE  ".$my_tables_use_check."_resources.patient_info  
      SET  patient_id=id,
          patient_code=user_id,
          gender=sex,
          date_of_birth=birthday";
	$total_query = mysqli_query($db_connection,  $total_update_sql);

   $query = "SELECT * FROM ".$my_tables_use_check."_resources.patient_info"; 
	 
    $query = mysqli_query($db_connection, $query);
     
      while ($company = mysqli_fetch_array($query)){

          $photo=$company['photo'];

          if($photo=='') {
            $photo="default.png";
          }
          
            $gender=$company['sex'];

            

            $age='';
            if($company['birthday']!='0000-00-00') {
              $age=calculateAge($company['birthday']);
            }

          echo '<tr>';
            echo '<td>'.$company['user_id'].'</td>';
          echo '<td><div class="d-flex align-items-center">
                  <img class="img-fluid rounded-50 w-40" style="height:40px; width:100px" src="../../../uploads/patient-form/'.$photo.'" alt="">
                      <span class="ml-10">'.$company['last_name'].', '.$company['first_name'].'</span>
                </div>';
          echo '</td>';
            echo '<td>'.$age.'</td>';
            echo '<td>'.$gender.'</td>';
            
             //<td> <span class="badge badge-info">New Patient</span></td>

  /*echo '<td>
                <a href="edit-patient.php">
                  <i class="w-18" data-feather="edit"></i>
                </a> */

          echo '<td>';

          ?>
                   <a href="../../daily-chart/view_patient.php?id=<?php echo $company['id']; ?>" class="action-link view-link">View</a>
                        <a href="../../daily-chart/edit_patient.php?id=<?php echo $company['id']; ?>" class="action-link edit-link">Edit</a>
                        <a href="../../daily-chart/index.php?delete_id=<?php echo $company['id']; ?>" 
                           class="action-link delete-link" 
                           onclick="return confirm('Are you sure you want to delete this patient?')">Delete</a>

                   <a href="#" class="action-link add-note-link" 
                        data-bs-toggle="modal" 
                        data-bs-target="#addNoteModal"
                        data-patient-id="<?php echo $company['id']; ?>">Add Note</a>

                   <a href="../../daily-chart/patient_visits.php?patient_id=<?php echo $company['id']; ?>" 
                   class="action-link add-visit-link">Visits</a>      
              

              <?php  
          
             /*    echo  '<a class="text-primary ml-8" href="patient-load.php?id='.$company['user_id'].'">
                  <i class="w-18" data-feather="info"></i> View Details
                </a> */
                echo '</td>';
                   echo ' </tr>';

                    /*<a class="text-danger ml-8" href="javascript:void(0);">
                    <i class="w-18" data-feather="trash-2"></i>
                  </a> */
                    
      }                   
?>             
                      
                    </tbody>
                  </table>
                </div>
                <!-- Patient Modal Start-->
            
                <!-- Patient Modal Start-->
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- theme body end-->
    </div>

    <!-- footer start-->
      <?php include "includes/footer.php"; ?>




        <div class="scroll-top"><i class="fa fa-angle-double-up"></i></div>
    <!-- footer end-->
      <!-- main jquery-->
      <script src="../assets/js/jquery-3.7.0.min.js"></script>
      <!-- Feather iocns js-->
      <script src="../assets/js/icons/feather-icon/feather.js"></script>
      <!-- Bootstrap js-->
      <script src="../assets/js/bootstrap.bundle.min.js"></script>
      <script src="../assets/js/vendors/notify/bootstrap-notify.js"></script>
      <script src="../assets/js/vendors/notify/bootstrap-customnotify.js"></script>
      <!-- customizer-->
      <script src="../assets/js/customizer.js"></script>
      <!-- Scrollbar-->
      <script src="../assets/js/vendors/simplebar.js"></script>
      <!-- select 2 js-->
      <script src="../assets/js/vendors/select2/select2.min.js"></script>
      <script src="../assets/js/vendors/select2/custom-select2.js"> </script>
      <!-- datepicker-->
      <script src="../assets/js/vendors/datepicker/datepicker.js"></script>
      <script src="../assets/js/vendors/datepicker/datepicker.en.js"></script>
      <script src="../assets/js/vendors/datepicker/custom-datepicker.js"></script>
      <!-- Datatable  -->
      <script src="../assets/js/vendors/datatable/jquery.dataTables.min.js"> </script>
      <script src="../assets/js/vendors/datatable/dataTables.buttons.min.js"></script>
      <script src="../assets/js/vendors/datatable/buttons.print.min.js"> </script>
      <script src="../assets/js/vendors/datatable/buttons.html5.min.js"> </script>
      <script src="../assets/js/vendors/datatable/pdfmake.min.js"></script>
      <script src="../assets/js/vendors/datatable/vfs_fonts.js"> </script>
      <script src="../assets/js/vendors/datatable/jszip.min.js"></script>
      <script src="../assets/js/vendors/datatable/custom-datatable.js"> </script>
      <!-- Custom script-->
      <script src="../assets/js/custom-script.js"></script>





<!-- Add Note Modal -->
<div class="modal fade" id="addNoteModal" tabindex="-1" aria-labelledby="addNoteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addNoteModalLabel">Add Patient Note</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="noteForm"  >
                                <input type="hidden" name="patient_id" id="modalPatientId"  >

                <div class="modal-body">
                    <div class="mb-3">
                        <label for="noteContent" class="form-label">Note</label>
                        <textarea class="form-control" id="noteContent" name="note_content" rows="20" required></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save Note</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
 $(document).ready(function() {
    // Set patient_id when clicking "Add Note"
    $(document).on('click', '.add-note-link', function(e) {
        e.preventDefault();
        var patientId = $(this).data('patient-id');
        $('#modalPatientId').val(patientId);

        
    
    });

    // Submit form via AJAX
    $('#noteForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: 'save_note.php',
            type: 'POST',
            data: $(this).serialize(),
            success: function(response) {

                $('#noteForm')[0].reset();

               alert('Note saved successfully!');
                 
                $('#addNoteModal').modal('hide');
            },
            error: function() {
                alert('Error saving note.');
            }
        });
    });
});
</script>

  </body>
</html>