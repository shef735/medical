<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>



<?php

session_destroy();
$presentdate=date('Y-m-d');
if(!isset($_SESSION['user_name'])) {

    //echo "<script>window.location = '../log-in/'</script>";


}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Patient Form</title>

    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- Bootstrap-5 -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- custom-styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link rel="stylesheet" href="assets/css/animation.css">


<style>
    /* Basic styling for the select element */
    select {
        
        
        cursor: pointer; /* Pointer cursor */
      
    color: var(--field-text-color);
    font-weight: bold;
    display: block;
    margin-bottom: 20px;

     font-size: 17px;
    color: var(--field-place-color);
    background-color: transparent;
    border: 0;
    border-bottom: solid 3px var(--field-color);
    width: 100%;
    position: relative;
    transition: .4s ease;

    }

    /* Style for the options in modern browsers */
    option {
        padding: 10px; /* Space inside the option */
        background-color: #fff; /* Background color for options */
        color: #333; /* Font color for options */
    }

    /* Add hover effect */
    select:hover {
        border-color: #666; /* Change border on hover */
    }
</style>

</head>
<body>
    <main>
        <div class="logo">
            <div class="logo-icon">
                <img src="assets/images/logo.png" alt="BeRifma">
            </div>
            <div class="logo-text">
                GastroHep - Patient Form
            </div>
        </div>
        <div class="container">
            <div class="wrapper">
                <div class="row">
                    <div class="c-order tab-sm-100 col-md-6">

                        <!-- side -->
                        <div class="left">
                            <article class="side-text">
                                <h2>Specialized unit for gastrointestinal and liver diseases</h2>
                                <p>Email us : <span>malvargastrohep@gmail.com</span></p>
                            </article>
                            <div class="left-img">
                                <img src="assets/images/left-bg.gif" alt="BeRifma">
                            </div>
                            <ul class="links">
                                <li><a href="#">Trems of Service</a></li>
                                <li><a href="#">Privacy Policy</a></li>
                                <li><a href="#">Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="tab-sm-100 offset-md-1 col-md-5">
                        <div class="right">


                            <!-- form -->
                            <form id="steps" method="post" action="../questions/"  enctype="multipart/form-data">

                                <!-- step 1 -->
                                <div id="step1" class="form-inner lightSpeedIn">
 
                                 <div class="input-field">
                                        <label for="message"><i class="fa-solid fa-calendar"></i>Date <span>*</span></label>
                                        <input type="date" name="date" id="date" value=<?php echo $presentdate ?>>
                                        <span></span>
                                    </div>

                                    <div class="input-field">
                                        <label><i class="fa-regular fa-user"></i>Last Name <span>*</span></label>
                                        <input required type="text" name="last_name" id="last_name" placeholder="Type Last Name">
                                        <span></span>
                                        
                                    </div>

                                    <div class="input-field">
                                        <label><i class="fa-regular fa-user"></i>First Name <span>*</span></label>
                                        <input required type="text" name="first_name" id="first_name" placeholder="Type First Name">
                                        <span></span>
                                    </div>

                                    <div class="input-field">
                                        <label><i class="fa-regular fa-user"></i>Middle Name <span>*</span></label>
                                        <input required type="text" name="middle_name" id="middle_name" placeholder="Type Middle Name">
                                        <span></span>
                                    </div>


                                    <div class="input-field" style="visibility: hidden; position:absolute">
                                        <label for="company"><i class="fa-regular fa-paper-plane"></i>Address <span>*</span></label>
                                        <input type="text" name="address" id="address" placeholder="Type Address">
                                        <span></span>
                                    </div>

 <?php include "address.php" ?>

                                    <div class="input-field">
                                        <label for="phone"><i class="fa-solid fa-phone"></i>Phone <span>*</span></label>
                                        <input type="text" name="phone" id="phone" placeholder="Type Phone Number">
                                        <span></span>
                                    </div>
                                    <div class="input-field">
                                        <label><i class="fa-regular fa-envelope"></i>Email Address <span>*</span></label>
                                        <input required type="text" name="email" id="mail-email" placeholder="Type email address">
                                        <span></span>
                                    </div>
                                    <div class="input-field">
                                        <label for="message"><i class="fa-solid fa-calendar"></i>Birthday <span>*</span></label>
                                        <input type="date" name="birthday" id="birthday" placeholder="">
                                        <span></span>
                                    </div>

                                    <div class="input-field">
                                        <label for="sex"><i class="fa-solid fa-user"></i>Civil Status <span>*</span></label>
                                      <select name="civil_status" id="civil_status">
                                        <option value="Single">Single</option>
                                        <option value="Married">Married</option>
                                       
                                        </select>
                                     <span></span>
                                    </div>

                                     <div class="input-field">
                                        <label for="sex"><i class="fa-solid fa-user"></i>Sex <span>*</span></label>
                                      <select name="sex" id="sex">
                                        <option value="Male">Male</option>
                                        <option value="Female">Female</option>
                                       
                                        </select>
                                     <span></span>
                                    </div>

  <div class="input-field">
          <label for="sex"><i class="fa-solid fa-plus-square"></i>Blood Type </label>
                        <select name="blood_group" id="blood_group">
                        
                          <option value="A+">A+</option>
                          <option value="A-">A-</option>
                          <option value="B+">B+</option>
                          <option value="B-">B-</option>
                          <option value="O+">O+</option>
                          <option value="O-">O-</option>
                          <option value="AB+">AB+</option>
                          <option value="AB-">AB-</option>
                        </select>
  </div>
                                     <div class="input-field">
                                        <label for="message"><i class="fa-solid fa-message"></i>Height (cm)<span>*</span></label>
                                        <input type="text" name="height_cm" id="height_cm" placeholder="">
                                        <span></span>
                                    </div>

                                     <div class="input-field">
                                        <label for="message"><i class="fa-solid fa-message"></i>Weight (kg)<span>*</span></label>
                                        <input type="text" name="weight_kg" id="weight_kg" placeholder="">
                                        <span></span>
                                    </div>

                                    <div class="input-field">
                                        <label for="message"><i class="fa-solid fa-message"></i>Number of previous consults with other MDs for this disease.</label>
                                        <input type="text" name="prev_consults" id="prev_consults" placeholder="">
                                        <span></span>
                                    </div>

                                    

                                 <!--   <div class="check-field">
                                        <label><i class="fa-regular fa-user"></i>Services <span>*</span></label>
                                        <div class="row">
                                            <div class="tab-100 col-md-6">
                                                <div class="check-single">
                                                    <input type="checkbox" name="service" value="paid media" checked>
                                                    <label>Paid Media</label>
                                                </div>
                                                <div class="check-single">
                                                    <input type="checkbox" name="service" value="Digital experience">
                                                    <label>Digital experience</label>
                                                </div>
                                                <div class="check-single">
                                                    <input type="checkbox" name="service" value="Email">
                                                    <label>Email</label>
                                                </div>
                                            </div>
                                            <div class="tab-100 col-md-6">
                                                <div class="check-single">
                                                    <input type="checkbox" name="service" value="Content Creation">
                                                    <label>Content Creation</label>
                                                </div>
                                                <div class="check-single">
                                                    <input type="checkbox" name="service" value="Strategy & Consulting">
                                                    <label>Strategy & Consulting</label>
                                                </div>
                                                <div class="check-single">
                                                    <input type="checkbox" name="service" value="Other">
                                                    <label>Other</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>

                                <!-- step Button -->
                                <div class="submit">
                                    <button type="submit" id="sub">CONTINUE<span><i class="fa-solid fa-thumbs-up"></i></span></button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="left-shape">
            <img src="assets/images/top-left.png" alt="">
        </div>
        <div class="right-shape">
            <img src="assets/images/top-right.png" alt="">
        </div>

    </main>







    
    <div id="error">

    </div>


    <!-- Bootstrap-5 -->
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Jquery -->
    <script src="assets/js/jquery-3.6.1.min.js"></script>

    <!-- My js -->
    <!-- <script src="assets/js/custom.js"></script> -->
</body>
</html>