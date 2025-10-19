<?php
// --- DATABASE CONNECTION ---
// IMPORTANT: Replace with your actual database details

include "../../Connections/dbname.php";
echo "<h1>Password Hashing Utility</h1>";

// --- SELECT ALL USERS ---
$sql = "SELECT user_id as id, password_hash FROM  ".$_SESSION['my_tables']."_laboratory.users"; // Assuming your primary key is 'id'
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $updated_count = 0;
    
    // --- LOOP THROUGH EACH USER ---
    while ($row = mysqli_fetch_assoc($result)) {
        $user_id = $row['id'];
        $plain_password = $row['password_hash'];

        // Check if the password is NOT already hashed (hashes usually start with '$')
        if (substr($plain_password, 0, 1) !== '$') {
            
            // --- HASH THE PASSWORD ---
            // PASSWORD_BCRYPT is a strong and widely used algorithm
            $hashed_password = password_hash($plain_password, PASSWORD_BCRYPT);

            // --- UPDATE THE DATABASE ---
            // Use a prepared statement for security
            $update_sql = "UPDATE  ".$_SESSION['my_tables']."_laboratory.users SET password_hash = ? WHERE user_id = ?";
            $stmt = mysqli_prepare($conn, $update_sql);
            mysqli_stmt_bind_param($stmt, "si", $hashed_password, $user_id);
            
            if (mysqli_stmt_execute($stmt)) {
                echo "User ID #{$user_id} password has been hashed.<br>";
                $updated_count++;
            } else {
                echo "ERROR updating User ID #{$user_id}: " . mysqli_error($conn) . "<br>";
            }
        } else {
            echo "User ID #{$user_id} password appears to be already hashed. Skipped.<br>";
        }
    }
    echo "<h2>Done! {$updated_count} passwords were successfully updated.</h2>";
} else {
    echo "No users found.";
}

mysqli_close($conn);

echo "<p style='color:red; font-weight:bold;'>IMPORTANT: Please delete this file from your server immediately!</p>";
?>