<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> PATIENT FORM</title>

    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- Bootstrap-5 -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- custom-styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link rel="stylesheet" href="assets/css/animation.css">
</head>
<body class="popreveal thankyou-page">

    <header>
        <h2>
     
            </br> 

            <a style="color: wheat;" href='../patient-form/'><i class="fa-solid fa-home"></i> HOME </a>  
</br></br>
              PATIENT FORM   
              
              <?php
             
           //   echo  $_SESSION['files_lab'];
                 
              
               ?>
        </h2>
    </header>
    <main class="thankyou-page-inner">
        <img src="assets/images/thankyou-check.png" alt="">
        <span>Your submission has been saved</span>
        <h1>Thankyou For Your Response!</h1>
      <!--  <div class="subscribe">
            <input type="text"   placeholder="Your Email">
            <button type="button">subscribe now</button>
        </div> -->
    </main>


    <!-- Bootstrap-5 -->
    <script src="assets/js/bootstrap.min.js"></script>
</body>
</html>