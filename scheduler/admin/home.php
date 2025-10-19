<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>
 
 
<?php
 $sched_arr=array();
?>
 
<div  >
  <div class="card">
    <div class="card-body">
        <div id="calendar"></div>
    </div>
  </div>
</div>
<style>
    .fc-event:hover, .fc-event-selected {
        color: black !important;
    }
    a.fc-list-day-text {
        color: black !important;
    }
    .fc-event:hover, .fc-event-selected {
        color: black !important;
        background: var(--light);
        cursor: pointer;
    }

    .fc-event-title {
    white-space: normal; /* Allow text to wrap */
    word-wrap: break-word; /* Break long words if necessary */
}

    

    
</style>


<style>
    /* Custom CSS for Select2 */
.select2-container--default .select2-results__option {
    background-color: #fff; /* Dropdown item background */
    color: #000; /* Dropdown item text color */
}

.select2-container--default .select2-results__option--highlighted {
    background-color: #f8f9fa; /* Highlighted item background */
    color: #000; /* Highlighted item text color */
}

.select2-container--default .select2-results__option--selected {
    background-color: #007bff; /* Selected item background (blue) */
    color: #fff; /* Selected item text color (white) */
}

.select2-container--default .select2-dropdown {
    background-color: #fff; /* Dropdown background */
    border: 1px solid #ccc; /* Dropdown border */
}
</style>
<!-- Simplified Modal Example -->
 <!-- Modal Structure -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="myModalLabel" style="color: white;">Add Appointment</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body" style="color:white">
                <form action="save.php" method="POST">

                <?php $patients = $conn->query("SELECT * FROM ".$my_tables_use."_resources.patient_info ORDER BY last_name"); ?>


 <div class="form-group">
                <label for="patient_id">Select Patient:</label>
                <select name="patient_id" id="patient_id" class="form-control select2" required>
                    <option value="">--Select Patient--</option>
                    <?php while ($patient = $patients->fetch_assoc()) : ?>
                        <?php 
                        $name_data=$patient['user_id'].' - '.$patient['last_name'].', '.$patient['first_name']; 
                         $name_show=$patient['last_name'].', '.$patient['first_name']; 
                        
                        ?>
                        <option value="<?php echo $name_data; ?>">
                        <?php echo  $name_show; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

     <?php $doctors = $conn->query("SELECT * FROM ".$my_tables_use."_resources.doctor_info ORDER BY last_name"); ?>


 <div class="form-group">
                <label for="doctor_id">Appointment with:</label>
                <select name="doctor_id" id="doctor_id" class="form-control select2">
                    <option  value="">--Select Doctor--</option>
                    <?php while ($doctor = $doctors->fetch_assoc()) : ?>
                        <?php 
                        $name_data=$doctor['user_id'].' - '.$doctor['last_name'].', '.$doctor['first_name']; 
                         $name_show=$doctor['last_name'].', '.$doctor['first_name']; 
                        
                        ?>
                        <option value="<?php echo $name_data; ?>">
                        <?php echo  $name_show; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>
 <div class="form-group">
                    <p>Selected Date: <span id="selectedDate"></span></p>
                    <input type="text" id="readOnlyDate" name="date" class="form-control" readonly>
 </div>
  <div class="form-group">
                    <label for="appointTime">Select Time:</label>
                    <input type="time" id="appointTime" name="time" class="form-control" required>
                    <!-- Hidden field for patient ID -->
  </div>

    <div class="form-group">
                    <label for="remarks">Remarks:</label>
                    <textarea  rows="4" id="remarks" name="remarks" class="form-control" required></textarea>
                    <!-- Hidden field for patient ID -->
  </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save changes</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
function addAppointmentModal(date) {
    // Set the content of the selectedDate span
    $('#selectedDate').text(date);

    // Create a Date object from the date string
    var dateObj = new Date(date);

    // Format the date for the read-only input (YYYY-MM-DD)
    var formattedDate = dateObj.toISOString().slice(0, 10); // Get only the date part

    // Set the value to the read-only date input
    $('#readOnlyDate').val(formattedDate);

    // Set the time input value based on the current time (or you can initialize with a specific time)
    var timeFormatted = dateObj.toTimeString().slice(0, 5); // Get HH:MM
    $('#appointTime').val(timeFormatted);

    // Show the modal
    $('#myModal').modal('show');
}
</script>

<?php



$sched_query = $conn->query("SELECT * FROM appointments");
$sched_arr = json_encode($sched_query->fetch_all(MYSQLI_ASSOC));
?>
<script>
 $(function(){
    $('.select2').select2()
    var Calendar = FullCalendar.Calendar;
    var date = new Date()
    var d    = date.getDate(),
        m    = date.getMonth(),
        y    = date.getFullYear()
    var scheds = $.parseJSON('<?php echo ($sched_arr) ?>');

    var calendarEl = document.getElementById('calendar');

    var calendar = new Calendar(calendarEl, {
                    initialView:"dayGridMonth",
                    headerToolbar: {
                        right : "dayGridWeek,dayGridMonth,listDay prev,next"
                    },
                    buttonText:{
                        dayGridWeek :"Week",
                        dayGridMonth :"Month",
                        listDay :"Day",
                        listWeek :"Week",
                    },
                    themeSystem: 'bootstrap',
                    events: function(event, successCallback) {
                        var events = []
                        Object.keys(scheds).map(k => {
                            var bg = 'var(--warning)';
                            if (scheds[k].status == 1) bg = 'var(--success)';
                              if (scheds[k].status == 2) bg = 'var(--danger)';
                               if (scheds[k].status == 3) bg = 'var(--info)';

                                    // Split the fullname by the '-' character and get the part after it
                                    let fullnameParts = scheds[k].fullname.split(' - ');
                                    let titleAfterDash = fullnameParts.length > 1 ? fullnameParts[1].trim() : scheds[k].fullname;

                                    // Add line breaks to the title (e.g., after a certain number of characters)
                                    const maxCharsPerLine = 10; // Adjust this value as needed
                                    let wrappedTitle = titleAfterDash
                                        .split(' ')
                                        .reduce((acc, word, index) => {
                                            if (index > 0 && acc.length > maxCharsPerLine * Math.floor(acc.length / maxCharsPerLine)) {
                                                return acc + '\n' + word; // Add a line break
                                            }
                                            return acc + ' ' + word;
                                        }, '')
                                        .trim();

                                    events.push({
                                        id: scheds[k].id,
                                        title: wrappedTitle , // Use the wrapped title
                                        start: moment(scheds[k].date_sched).format('YYYY-MM-DD[T]HH:mm'),
                                        backgroundColor: bg, 
                                        borderColor: bg, 
                                    });
                        })
                        successCallback(events)
                    },
                    eventClick: (info) => {
                        uni_modal("", "appointments/view_details.php?id=" + info.event.id)
                    },
                  dateClick: (info) => {
    console.log("Date clicked:", info.dateStr); // For debugging
    if ($('#myModal').is(':visible')) {
        return; // Avoid reopening an already open modal
    }
    // Show the modal
    addAppointmentModal(info.dateStr);
},
                    editable: false,
                    selectable: true,
                    selectAllow: function(select) {
                        return moment().subtract(1, 'day').diff(select.start) < 0 && 
                               (moment(select.start).format('dddd') != 'Saturday' && 
                                moment(select.start).format('dddd') != 'Sunday');
                    }
    });

    calendar.render();

    $('#location').change(function() {
        location.href = "./?lid=" + $(this).val();
    })
})


 
</script>
