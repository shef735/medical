<?php
// Include your database connection
include '../db_connection.php'; // Make sure this file contains your DB connection logic

// Fetch patients from the database
$patients = $conn->query("SELECT * FROM patient_list ORDER BY name");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle form submission
    $patient_id = $_POST['patient_id'];
    $date_time = $_POST['date_time'];

    // Insert appointment into the database
    $stmt = $conn->prepare("INSERT INTO appointments (patient_id, date_sched) VALUES (?, ?)");
    $stmt->bind_param("is", $patient_id, $date_time);
    
    if ($stmt->execute()) {
        echo "Appointment added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Appointment</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css" />
</head>
<body>
    <div class="container">
        <h2>Add Appointment</h2>
        <form id="addAppointmentForm">
            <div class="form-group">
                <label for="patient_id">Select Patient:</label>
                <select name="patient_id" id="patient_id" class="form-control select2" required>
                    <option value="">--Select Patient--</option>
                    <?php 
                    while ($patient = $patients->fetch_assoc()) : ?>
                        <option value="<?php echo $patient['id']; ?>"><?php echo htmlspecialchars($patient['name']); ?></option>
                    <?php endwhile; ?>
                </select>
            </div>
            <div class="form-group">
                <label for="date_time">Select Date and Time:</label>
                <input type="datetime-local" name="date_time" id="date_time" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Add Appointment</button>
            <button type="button" class="btn btn-secondary" onclick="window.history.back();">Cancel</button>
        </form>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2').select2();

            $('#addAppointmentForm').on('submit', function(e) {
                e.preventDefault();

                // Post the form data using AJAX
                $.post("add.php", $(this).serialize(), function(response) {
                    alert(response); // Alert the response (success or error)
                    // Optionally reload the calendar here or redirect
                });
            });
        });
    </script>
</body>
</html>