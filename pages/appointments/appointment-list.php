<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

include "config.php";
?>


<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="">
    <meta name="keywords" content="admin template, html 5 admin template , medixo admin , dashboard template, bootstrap 5 admin template, responsive admin template">
    <title><?php echo $_SESSION['system_name'] ?></title>
    
    <link rel="shortcut icon" href="../assets/images/logo/icon-logo.png" type="image/x-icon">
    

    
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

    .breadcrumb-contain {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
    }

    .left-breadcrumb {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 1rem;
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

    /* --- Button Styling --- */
    .btn-action-group {
        display: flex;
        gap: 0.75rem;
        flex-wrap: wrap;
    }

    .btn-primary {
        background-color: var(--primary-color);
        border: none;
        border-radius: 8px;
        padding: 0.6rem 1.2rem;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(44, 128, 255, 0.2);
    }

    .btn-primary:hover {
        background-color: var(--primary-dark);
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(44, 128, 255, 0.3);
    }

    .btn-success {
        background-color: var(--success-color);
        border: none;
        border-radius: 8px;
        padding: 0.6rem 1.2rem;
        font-weight: 500;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(40, 167, 69, 0.2);
        color: white !important;
    }

    .btn-success:hover {
        background-color: #218838;
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(40, 167, 69, 0.3);
        color: white !important;
    }

    .float-end {
        margin-left: 0 !important;
    }

    /* --- Main Content Card --- */
    .card {
        border: none;
        border-radius: 12px;
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

    /* --- Right Breadcrumb --- */
    .right-breadcrumb ul {
        display: flex;
        gap: 1.5rem;
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .right-breadcrumb li {
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .bread-wrap {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 36px;
        height: 36px;
        background-color: var(--light-color);
        border-radius: 8px;
        color: var(--primary-color);
    }

    /* --- Responsive Adjustments --- */
    @media (max-width: 768px) {
        .breadcrumb-contain {
            flex-direction: column;
            align-items: flex-start;
        }
        
        .left-breadcrumb {
            flex-direction: column;
            align-items: flex-start;
            width: 100%;
        }
        
        .btn-action-group {
            width: 100%;
            justify-content: flex-start;
        }
        
        .card-body {
            padding: 1rem;
        }
        
        .patients-tbl thead th,
        .patients-tbl tbody td {
            padding: 0.7rem 0.5rem;
        }
    }

    @media (max-width: 576px) {
        .patients-tbl {
            font-size: 0.85rem;
        }
        
        .btn-action-group {
            flex-direction: column;
            width: 100%;
        }
        
        .btn-primary, .btn-success {
            width: 100%;
            text-align: center;
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
                     
                              <h1>Appointment List</h1></a> 
                  
                      <div class="btn-action-group">
                          <a class="btn btn-success" href="javascript:void(0);" onclick="window.location.href='../index.php'">
                              <i class="fa-solid fa-home me-2"></i>Home
                          </a> 
                          <a class="btn btn-primary" href="javascript:void(0);" onclick="window.location.href='index.php'">
                              <i class="fa-solid fa-plus me-2"></i>Add New Appointment
                          </a>
                      </div>
                  </div>
                  <div class="right-breadcrumb">
                      <ul>
                          <li>
                              <div class="bread-wrap"><i class="fa-solid fa-clock"></i></div><span class="liveTime"></span>
                          </li>
                          <li>
                              <div class="bread-wrap"><i class="fa-solid fa-calendar-days"></i></div><span class="getDate"></span>
                          </li>
                      </ul>
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
                        <th>Patient</th>
                        <th>Mobile</th>
                        <th>Email</th>
                        <th>Date</th>
                        <th>Time </th>
                        <th>Doctor</th>
                      </tr>
                    </thead>
                    <tbody>
                      
                   
                 
                <?php

                $query = "SELECT * FROM ".$my_tables_use_check."_resources.appointments"; 
              
                $query = mysqli_query($db_connection, $query);
                
                  while ($company = mysqli_fetch_array($query)){

                                
                       echo '<tr>';
                        echo '<td>'.substr($company['fullname'], (strpos($company['fullname'], '- ') ?: -1) + 1).'</td>';
                        echo '<td>'.$company['phone'].'</td>';
                        echo '<td>'.$company['email'].'</td>';
                        echo '<td>'.$company['date_only'].'</td>';
                        echo '<td>'.$company['time_only'].'</td>';
                        echo '<td> '.$company['doctor'].'</span></td>';
                     echo '</tr>';    
                            
                  
                  }

                ?>
   
                    </tbody>
                  </table>
                </div>
                <div class="modal fade" id="appoitmentmodal">
                  <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title">Add New Appointment               </h5>
                      </div>
                      <div class="modal-body">
                        <form>
                          <div class="row">
                            <div class="form-group col-md-6">
                              <label class="form-label">First Name</label>
                              <input class="form-control" type="text" placeholder="Patient First Name">
                            </div>
                            <div class="form-group col-md-6">
                              <label class="form-label">Last Name</label>
                              <input class="form-control" type="text" placeholder="Patient Last Name">
                            </div>
                            <div class="form-group col-md-6">
                              <div class="form-label">Phone                                  </div>
                              <input class="form-control" type="text" required="" placeholder="Phone Number">
                            </div>
                            <div class="form-group col-md-6">
                              <label class="form-label">Email</label>
                              <input class="form-control" type="text" required="" placeholder="Email Id">
                            </div>
                            <div class="form-group col-md-6">
                              <label class="form-label">Date</label>
                              <input class="datepicker-here form-control" type="text" placeholder="DD/MM/YYYY" data-date-format="dd/mm/yyyy" data-language="en">
                            </div>
                            <div class="form-group col-md-6">
                              <div class="form-label">Appointment Time</div>
                              <input class="form-control" type="time">
                            </div>
                          </div>
                        </form>
                      </div>
                      <div class="modal-footer">
                        <button class="btn btn-primary" type="button">Save</button>
                        <button class="btn btn-danger" type="button" data-bs-dismiss="modal">Close</button>
                      </div>
                    </div>
                  </div>
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
    $('.patients-tbl').DataTable({
        dom: 'Bfrtip', // Adds buttons
        buttons: [
            'copy', 'csv', 'excel', 'pdf', 'print'
        ],
        "language": {
            "search": "Search Appointments:"
        }
    });

    // 2. Initialize Feather Icons
    feather.replace();
    
    // 3. Initialize Select2
    if ($.fn.select2) {
        $('.form-select').select2(); // Initializes any <select> with this class
    }
    
    // 4. Initialize Datepicker
    if ($.fn.datepicker) {
        // This targets the class in your modal
        $('.datepicker-here').datepicker({
            autoclose: true,
            todayHighlight: true,
            format: 'dd/mm/yyyy',
            language: 'en'
        });
    }

    // 5. Live Time/Date (from your old theme)
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

  </body>
</html>