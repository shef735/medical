<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

unset($_SESSION['edit_click']);
unset($_SESSION['add_click']);
unset($_SESSION['patient_id']);

include "config.php";
 
function calculateAge($birthdate) {
    $birthDate = new DateTime($birthdate);
    $today = new DateTime('today');
    $age = $birthDate->diff($today)->y;
    return $age;
}
?>
  

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="refresh" name="viewport" content="width=device-width, initial-scale=1">
    <title>Patient List</title>
     
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.dataTables.min.css" rel="stylesheet">

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" rel="stylesheet">
    
    <link href="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    
   <style>
    :root {
        --primary-color: #2c80ff;
        --primary-dark: #1a6fe0;
        --secondary-color: #6c757d;
        --success-color: #28a745;
        --warning-color: #ffc107;
        --danger-color: #dc3545;
        --light-color: #f8f9fa;
        --dark-color: #343a40;
        --border-color: #e9ecef;
        --card-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
        --hover-shadow: 0 6px 20px rgba(0, 0, 0, 0.12);
    }

    body {
        background-color: #f5f7fb;
        font-family: 'Poppins', sans-serif;
        color: #444;
        line-height: 1.6;
    }

    /* --- Breadcrumb Bar --- */
    .codex-breadcrumb {
        background-color: #ffffff;
        border-bottom: 1px solid var(--border-color);
        padding: 1.2rem 0;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.03);
    }

    .breadcrumb-contain .left-breadcrumb h1 {
        font-size: 1.6rem;
        color: var(--dark-color);
        font-weight: 600;
        margin: 0;
    }

    .breadcrumb {
        margin-bottom: 0;
    }

    /* --- Main Content Card --- */
    .card {
        border: none;
        border-radius: 10px;
        box-shadow: var(--card-shadow);
        margin-top: 1.5rem;
        overflow: hidden;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .card:hover {
        box-shadow: var(--hover-shadow);
        transform: translateY(-2px);
    }

    .card-body {
        padding: 1.5rem;
    }

    /* --- Table Styling --- */
    .patients-tbl {
        width: 100% !important;
        border-collapse: separate;
        border-spacing: 0;
    }

    .patients-tbl thead th {
        background-color: var(--primary-color);
        color: white;
        font-weight: 600;
        border: none;
        text-transform: uppercase;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        padding: 1rem 0.8rem;
        text-align: left;
        position: sticky;
        top: 0;
        z-index: 10;
    }

    .patients-tbl tbody td {
        vertical-align: middle;
        padding: 0.9rem 0.8rem;
        border-bottom: 1px solid var(--border-color);
        transition: background-color 0.15s ease;
    }

    .patients-tbl tbody tr {
        transition: all 0.15s ease;
    }

    .patients-tbl tbody tr:hover {
        background-color: rgba(44, 128, 255, 0.04);
        transform: scale(1.002);
    }
    
    /* --- Patient Photo --- */
    .patient-photo {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid #eaeaea;
        margin-right: 12px;
        transition: all 0.2s ease;
    }

    .patient-photo:hover {
        border-color: var(--primary-color);
        transform: scale(1.05);
    }
    
    /* --- Action Buttons --- */
    .action-cell {
        display: flex;
        flex-wrap: wrap;
        gap: 6px;
    }
    
    .action-link {
        padding: 0.4rem 0.8rem;
        border-radius: 6px;
        text-decoration: none;
        color: white !important;
        font-size: 0.75rem;
        font-weight: 500;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        transition: all 0.2s ease;
        white-space: nowrap;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        min-width: 65px;
    }

    .action-link i {
        margin-right: 4px;
        font-size: 0.7rem;
    }

    .action-link:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
        text-decoration: none;
        color: white !important;
    }

    .view-link { 
        background-color: var(--primary-color); 
    }
    .view-link:hover { 
        background-color: var(--primary-dark); 
    }

    .edit-link { 
        background-color: var(--warning-color); 
        color: #212529 !important; 
    }
    .edit-link:hover { 
        background-color: #e0a800; 
        color: #212529 !important;
    }

    .delete-link { 
        background-color: var(--danger-color); 
    }
    .delete-link:hover { 
        background-color: #c82333; 
    }
    
    .add-note-link { 
        background-color: var(--secondary-color); 
    }
    .add-note-link:hover { 
        background-color: #5a6268; 
    }

    .add-visit-link { 
        background-color: var(--success-color); 
    }
    .add-visit-link:hover { 
        background-color: #218838; 
    }

    /* --- Modal Styling --- */
    .modal-header {
        background-color: var(--light-color);
        border-bottom: 1px solid var(--border-color);
        padding: 1.2rem 1.5rem;
    }
    
    .modal-header .modal-title {
        font-weight: 600;
        color: var(--dark-color);
    }
    
    .modal-footer {
        border-top: 1px solid var(--border-color);
        padding: 1rem 1.5rem;
    }
    
    /* --- Responsive Adjustments --- */
    @media (max-width: 768px) {
        .card-body {
            padding: 1rem;
        }
        
        .patients-tbl thead th,
        .patients-tbl tbody td {
            padding: 0.7rem 0.5rem;
        }
        
        .action-cell {
            gap: 4px;
        }
        
        .action-link {
            padding: 0.3rem 0.6rem;
            font-size: 0.7rem;
            min-width: 55px;
        }
        
        .patient-photo {
            width: 36px;
            height: 36px;
        }
    }
    
    @media (max-width: 576px) {
        .patients-tbl {
            font-size: 0.85rem;
        }
        
        .action-cell {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .action-link {
            width: 100%;
            justify-content: flex-start;
        }
    }
    
    /* --- DataTables Customization --- */
    .dataTables_wrapper .dataTables_filter input {
        border: 1px solid var(--border-color);
        border-radius: 6px;
        padding: 0.4rem 0.8rem;
    }
    
    .dataTables_wrapper .dataTables_length select {
        border: 1px solid var(--border-color);
        border-radius: 6px;
        padding: 0.4rem;
    }
    
    .dt-buttons .btn {
        background-color: var(--primary-color);
        border: none;
        border-radius: 6px;
        color: white;
        padding: 0.5rem 1rem;
        margin-right: 5px;
        transition: all 0.2s ease;
    }
    
    .dt-buttons .btn:hover {
        background-color: var(--primary-dark);
        transform: translateY(-1px);
    }
    
    /* --- Scroll to Top Button --- */
    .scroll-top {
        background-color: var(--primary-color);
        border-radius: 50%;
        width: 45px;
        height: 45px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: fixed;
        bottom: 20px;
        right: 20px;
        cursor: pointer;
        opacity: 0.8;
        transition: all 0.3s ease;
        z-index: 1000;
        box-shadow: 0 2px 10px rgba(0,0,0,0.2);
    }
    
    .scroll-top:hover {
        opacity: 1;
        transform: translateY(-3px);
    }
    
    .scroll-top i {
        color: white;
        font-size: 1.2rem;
    }
    
    /* --- Status Indicators --- */
    .status-badge {
        padding: 0.3rem 0.6rem;
        border-radius: 20px;
        font-size: 0.75rem;
        font-weight: 500;
    }
    
    .status-active {
        background-color: rgba(40, 167, 69, 0.1);
        color: var(--success-color);
    }
    
    .status-inactive {
        background-color: rgba(108, 117, 125, 0.1);
        color: var(--secondary-color);
    }
    
    /* --- Loading Animation --- */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    
    .card, .codex-breadcrumb {
        animation: fadeIn 0.5s ease-out;
    }
                
</style>
  </head>
  <body>   
     

      <div class="themebody-wrap">
       

            <div class="codex-breadcrumb">
                <div class="container-fluid">
                    <div class="breadcrumb-contain">
                        <div class="left-breadcrumb">
                            
                                 
                        
                            <div class="btn-action-group" >
                                <a class="btn btn-success" href="javascript:void(0);" onclick="window.location.href='index.php'">
                                    <i class="fa-solid fa-home me-2"></i>Home
                                </a> 
                                <a class="btn btn-primary" href="javascript:void(0);" onclick="window.location.href='patient-form/index.php'">
                                    <i class="fa-solid fa-plus me-2"></i>Add New Patient
                                </a>
                            </div>

                               <h1 style="text-align: center;">Patient List</h1> 
                        </div>
                    
                    </div>
                </div>
            </div>



      <div class="theme-body codex-chat">
        <div class="container-fluid">
          <div class="row">
            <div class="col-12">
              <div class="card">  
                <div class="card-body">
                  <table class="patients-tbl table" style="width:100%;">
                    <thead>
                      <tr>
                       <th>Patient ID</th>   
                        <th>Name</th>                    
                        <th>Age</th>
                        <th>Gender</th>                      
                        <th style="width: 400px;">Action</th>
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

                   $query = "SELECT * FROM ".$my_tables_use_check."_resources.patient_info ORDER BY id DESC"; 
   
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
                          echo '<td><div class="d-flex align-items-center">';
                            echo '<img class="patient-photo" src="../uploads/patient-form/'.$photo.'" alt="">';
                            echo '<span class="ml-10">'.$company['last_name'].', '.$company['first_name'].'</span>';
                          echo '</div>';
                          echo '</td>';
                            echo '<td>'.$age.'</td>';
                            echo '<td>'.$gender.'</td>';
            
                          echo '<td class="action-cell">';

                          ?>
                               <a href="../../daily-chart/view_patient.php?id=<?php echo $company['id']; ?>" class="action-link view-link">View</a>
                                <a href="patient-form/edit_patient_form.php?id=<?php echo $company['id']; ?>" class="action-link edit-link">Edit</a>
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
                          
                        echo '</td>';
                   echo ' </tr>';
      }                   
?>             
                      
                    </tbody>
                  </table>
                </div>
                </div>
            </div>
          </div>
        </div>
      </div>
      </div>

   
    <div class="scroll-top"><i class="fa fa-angle-double-up"></i></div>

      
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/simplebar@latest/dist/simplebar.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-notify/0.2.0/js/bootstrap-notify.min.js"></script>

    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>

    <script>
$(document).ready(function() {
    
    // 1. Initialize DataTables
    // This replaces your 'custom-datatable.js'
    $('.patients-tbl').DataTable({
        dom: 'Bfrtip', // Adds buttons
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "language": {
            "search": "Search Patients:"
        },
        "ordering": false
    });

    // 2. Initialize Feather Icons
    // This replaces the call in 'custom-script.js'
    feather.replace();
    
    // 3. Initialize Select2
    // This replaces 'custom-select2.js'
    if ($.fn.select2) {
        $('.form-select').select2();
    }
    
    // 4. Initialize Datepicker
    // This replaces 'custom-datepicker.js'
    if ($.fn.datepicker) {
        $('.datepicker-here').datepicker({
            autoclose: true,
            todayHighlight: true
        });
    }

    // 5. Live Time/Date (from your old theme)
    // This replaces parts of 'custom-script.js'
    function updateTime() {
        var now = new Date();
        var hours = now.getHours().toString().padStart(2, '0');
        var minutes = now.getMinutes().toString().padStart(2, '0');
        var seconds = now.getSeconds().toString().padStart(2, '0');
        $('.liveTime').text(hours + ":" + minutes + ":" + seconds);
    }
    function updateDate() {
        var now = new Date();
        var options = { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' };
        $('.getDate').text(now.toLocaleDateString('en-US', options));
    }
    setInterval(updateTime, 1000);
    updateTime();
    updateDate();
});
</script>


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