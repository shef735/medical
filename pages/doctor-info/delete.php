<?php
include 'db.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']); // This is the `id`

    // --- Delete the photo file ---
    // 1. Get the photo filename using the `id`
    $sql_select = "SELECT photo FROM doctor_info WHERE id = '$id'";
    $result = mysqli_query($conn, $sql_select);
    
    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        $photo_to_delete = $row['photo'];

        // 2. Check if filename exists and delete the file
        if (!empty($photo_to_delete) && file_exists("uploads/" . $photo_to_delete)) {
            unlink("../../uploads/" . $photo_to_delete);
        }
    }

    // 3. Delete the record from the database using the `id`
    $sql_delete = "DELETE FROM doctor_info WHERE id = '$id'";
    
    if (mysqli_query($conn, $sql_delete)) {
        header("Location: index.php?msg=" . urlencode("Doctor profile deleted successfully."));
    } else {
        header("Location: index.php?msg=" . urlencode("Error deleting record: " . mysqli_error($conn)));
    }
    
    exit();
    
} else {
    // Redirect if no ID is provided
    header("Location: index.php");
    exit();
}
?>