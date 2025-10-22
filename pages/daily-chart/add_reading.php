<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>

<?php

function calculateBMI($weight, $heightInCM) {
    // Convert height from cm to meters
    $heightInMeters = $heightInCM / 100;

    // Calculate BMI
    if ($heightInMeters > 0) {
        $bmi = $weight / ($heightInMeters * $heightInMeters);
        return round($bmi, 2); // Round to 2 decimal places
    } else {
        return "Height must be greater than 0.";
    }
}

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $patient_id = $_POST['patient_id'];
     $user_id = $_SESSION['patient_user_id']; // Assuming you have user authentication

    
    $bp=$_POST['bp'];
    $heart_rate=$_POST['heart_rate'];
    $weight_kg=$_POST['weight_kg'];
    $height_cm=$_POST['height_cm'];
      $notes=$_POST['notes'];

    if((float)$weight_kg>0 AND (float)$height_cm>0 ) {
        $bmi=calculateBMI($weight_kg, $height_cm );
    }
       

    $sql = "INSERT INTO clinical_readings (user_id, bp, heart_rate, weight_kg, height_cm, bmi, notes, created_at) 
            VALUES ('$user_id', '$bp', '$heart_rate', '$weight_kg', '$height_cm', '$bmi', '$notes', NOW())";
    
    if (mysqli_query($conn, $sql)) {
        header("Location: view_patient.php?id=$patient_id&success=note_added");
    } else {
        header("Location: view_patient.php?id=$patient_id&error=note_failed");
    }
} else {
    header("Location: index.php");
}
exit;
?>