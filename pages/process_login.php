<?php
// Start the session
if(!isset($_SESSION)){
    session_start();
}

// Include database connection
require_once "config.php";

// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = trim($_POST["username"]);
    $password = $_POST["password"];

    // Prepare a select statement
    $sql = "SELECT id, username, password, firstname, lastname  
    FROM ".$my_tables."_resources.user_data WHERE username = ? OR email = ?";
    
    if ($stmt = mysqli_prepare($conn, $sql)) {
        // Bind variables to the prepared statement as parameters
        mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_username);
        
        // Set parameters
        $param_username = $username;
        
        // Attempt to execute the prepared statement
        if (mysqli_stmt_execute($stmt)) {
            // Store result
            mysqli_stmt_store_result($stmt);
            
            // Check if username exists, if yes then verify password
            if (mysqli_stmt_num_rows($stmt) == 1) {
                // Bind result variables
                mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password, $firstname, $lastname);
                if (mysqli_stmt_fetch($stmt)) {
                    if (password_verify($password, $hashed_password)) {
                        // Password is correct, so start a new session
                        session_regenerate_id(true); // Prevent session fixation
                        
                        // Store data in session variables
                        $_SESSION["loggedin"] = true;
                        $_SESSION["user_id"] = $id;
                        $_SESSION["username"] = $username;
                        $_SESSION['user_name'] = $username;
                        $_SESSION["fullname"] = $firstname . " " . $lastname;
                        $_SESSION['last_name']= $lastname;
                        $_SESSION['first_name']=$firstname;
                        $_SESSION['middle_name']='';

                        // --- FETCH USER PERMISSIONS ---
                        $access_list = [];
                        $sql_access = "SELECT m.menu_identifier 
                                       FROM ".$my_tables."_resources.menus m
                                       JOIN ".$my_tables."_resources.user_menu_access uma ON m.id = uma.menu_id
                                       WHERE uma.user_id = ?";
                        
                        if ($stmt_access = mysqli_prepare($conn, $sql_access)) {
                            mysqli_stmt_bind_param($stmt_access, "i", $id);
                            mysqli_stmt_execute($stmt_access);
                            $result_access = mysqli_stmt_get_result($stmt_access);
                            while ($row = mysqli_fetch_assoc($result_access)) {
                                $access_list[] = $row['menu_identifier'];
                            }
                            mysqli_stmt_close($stmt_access);
                        }
                        $_SESSION['user_access'] = $access_list;
                        
                        // Redirect user to menu page
                        header("location: index.php");
                        exit();
                    } else {
                        // Password is not valid
                        $_SESSION['login_error'] = "Invalid username or password.";
                        header("location: login.php");
                        exit();
                    }
                }
            } else {
                // Username doesn't exist
                $_SESSION['login_error'] = "Invalid username or password.";
                header("location: login.php");
                exit();
            }
        } else {
            echo "Oops! Something went wrong. Please try again later.";
        }

        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($conn);
}
?>