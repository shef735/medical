<div class="col-xxl-12 col-lg-12">
    <div class="card patientvisits-tbl">
        <div class="card-header">
            <h4>Today's Patient Appointments: <?php echo formatDate($presentdate); ?></h4>
            <input type="text" id="searchInput" placeholder="Search...">
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" style="width:100%;" id="appointmentsTable">
                    <thead>
                        <tr>
                            <th>Patient Name</th>
                            <th>Visit Time</th>
                            <th>Remarks</th>
                            <th>Doctor Name</th>
                            <th>Status</th>
                            
                        </tr>
                    </thead>
                    <tbody>
                        <?php

                        	$presentdate=date('Y-m-d');
                        // Pagination variables
                        $limit = 10; // Number of records per page
                        $page = isset($_GET['page']) ? $_GET['page'] : 1;
                        $start = ($page - 1) * $limit;

                        // Query to get total number of records
                        $total_query = "SELECT COUNT(*) as total FROM ".$my_tables_use."_resources.appointments WHERE date_only='".$presentdate."'";
                        $total_result = mysqli_query($conn, $total_query);
                        $total_row = mysqli_fetch_assoc($total_result);
                        $total_records = $total_row['total'];
                        $total_pages = ceil($total_records / $limit);

                        // Query to fetch records with pagination
                        $cdquery = "SELECT * FROM ".$my_tables_use."_resources.appointments WHERE date_only='".$presentdate."' ORDER BY date_sched LIMIT $start, $limit";
                        $cdresult = mysqli_query($conn, $cdquery);

                        while ($cdrowssss = mysqli_fetch_array($cdresult)) {
                            $idrec = $cdrowssss['id'];
                            
                            
                            $fullname = substr($cdrowssss['fullname'], (strpos($cdrowssss['fullname'], ' - ') ?: -1) + 2);


                            if($fullname=='') {
                                continue;
                            }
                            $doctor = substr($cdrowssss['doctor'], (strpos($cdrowssss['doctor'], ' - ') ?: -1) + 2);
                            $dateTime = DateTime::createFromFormat('H:i', $cdrowssss['time_only']);
                            $time_only = $dateTime->format('h:i A');

                            echo '<tr >';
                            echo '<td >'. ucwords($fullname) .'</td>';
                            echo '<td>'.$time_only.'</td>';
                            echo '<td>'.strtoupper($cdrowssss['remarks']).'</td>';
                            echo '<td>'.strtoupper($doctor).'</td>';
                            echo '<td>';
                            switch($cdrowssss['status']){ 
                                case(0): 
                                    echo '<span class="badge badge-warning">Rescheduled</span>';
                                    break; 
                                case(1): 
                                    echo '<span class="badge badge-success">Confirmed</span>';
                                    break; 
                                case(2): 
                                    echo '<span class="badge badge-danger">Cancelled</span>';
                                    break; 
                                case(3): 
                                    echo '<span class="badge badge-info">Done</span>';
                                    break; 
                                default: 
                                    echo '<span class="badge badge-secondary">NA</span>';
                            }
                            echo '</td>';
                           

                        /*echo '<td>
                                    <a class="text-info" href="load-id.php?id='. $idrec.'&transaction=edit-appointment">
                                        <i class="w-18" data-feather="edit"></i>
                                    </a>
                                    <a class="text-success ml-8" href="patient-load.php?id='.$cdrowssss['user_id'].'">
                                        <i class="w-18" data-feather="search"></i>
                                    </a>
                                  </td>'; */

                            echo '</tr>';
                        }
                        ?>
                    </tbody>
                </table>
            </div>
            <!-- Pagination -->
            <nav aria-label="Page navigation">
                <ul class="pagination">
                    <?php if ($page > 1): ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo ($page - 1); ?>">Previous</a></li>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $total_pages; $i++): ?>
                        <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                            <a class="page-link" href="?page=<?php echo $i; ?>"><?php echo $i; ?></a>
                        </li>
                    <?php endfor; ?>
                    <?php if ($page < $total_pages): ?>
                        <li class="page-item"><a class="page-link" href="?page=<?php echo ($page + 1); ?>">Next</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </div>
</div>

<script>
document.getElementById('searchInput').addEventListener('input', function() {
    var input, filter, table, tr, td, i, txtValue;
    input = document.getElementById("searchInput");
    filter = input.value.toUpperCase();
    table = document.getElementById("appointmentsTable");
    tr = table.getElementsByTagName("tr");

    // Loop through all table rows, and hide those that don't match the search query
    for (i = 1; i < tr.length; i++) { // Start from 1 to skip the header row
        td = tr[i].getElementsByTagName("td");
        var match = false;
        for (var j = 0; j < td.length; j++) {
            if (td[j]) {
                txtValue = td[j].textContent || td[j].innerText;
                if (txtValue.toUpperCase().indexOf(filter) > -1) {
                    match = true;
                    break;
                }
            }
        }
        if (match) {
            tr[i].style.display = "";
        } else {
            tr[i].style.display = "none";
        }
    }
});
</script>