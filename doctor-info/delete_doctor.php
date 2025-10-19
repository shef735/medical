<?php
include 'config.php';

if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    
    // First get photo path to delete the file
    $sql = "SELECT photo FROM doctor_info WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    
    // Delete the record
    $stmt = $conn->prepare("DELETE FROM doctor_info WHERE user_id = ?");
    $stmt->bind_param("i", $user_id);
    
    if ($stmt->execute()) {
        // Delete the photo file if exists
        if ($row['photo'] && file_exists($row['photo'])) {
            unlink($row['photo']);
        }
        echo "Doctor record deleted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }
    
    $stmt->close();
    $conn->close();
    header("Location: index.php");
    exit();
} else {
    echo "No ID specified";
    $conn->close();
    header("Location: index.php");
    exit();
}
?>