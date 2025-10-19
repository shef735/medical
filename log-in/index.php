<?php
if(!isset($_SESSION)){
session_start();
ob_start();
}
?>


<?php 

unset($_SESSION['user_name']);

 

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <!-- <link rel="stylesheet" href="assets/css/colorvariants/default.css" id="defaultscheme"> -->

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>M-ONE SOLUTIONS</title>

    <!-- font-awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

    <!-- Bootstrap-5 -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">

    <!-- custom-styles -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/responsive.css">
    <link rel="stylesheet" href="assets/css/animation.css">
</head>
<body>

    <!-- background -->
    <div class="ls-bg">
        <video playsinline autoplay muted loop class="ls-bg-inner">
            <source src="assets/images/bg.mp4">
        </video>
    </div>

    <main class="overflow-hidden">
        <div class="wrapper">
            <div class="main-inner">

                <!-- logo -->
                <div class="logo">
                    <div class="logo-icon">
                        <img src="assets/images/logo.png" alt="BeRifma">
                    </div>
                    <div class="logo-text">
                        GastroHep
                    </div>
                </div>
                <div class="row h-100 align-content-center">
                    <div class="col-md-6 tab-100 order_2">

                        <!-- side text -->
                        <div class="side-text">
                            <article>
                                <span>Gastroscopy - Colonoscopy - ERCP - EUS</span>
                                <h1 class="main-heading">GASTROHEP</h1>
                                <p>
                                   GASTROHEP ENDOSCOPY UNIT is a specialized unit for gastrointestinal and liver diseases.
                                </p>
                            </article>

                            <!-- login sign up button -->
                            <div class="logSign">
                                <button id="showlogin" type="button" class="active">Login</button>
                                <button id="showregister" type="button">register</button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 tab-100">

                        <!-- form -->
                        <div class="form">
                                <h2 class="login-form form-title">
                                    Account Login
                                </h2>
                                <h2 class="signup-form form-title">
                                    Create your Account!
                                </h2>

                                <!-- login form -->
                            <form id="step1" class="login-form" action="check-password.php" method="post">
                                <div class="input-field">
                                    <input type="text" id="username" name="username"  required>
                                    <label>
                                        Username or Email
                                    </label>
                                </div>
                                <div class="input-field delay-100ms">
                                    <input type="password" id="password" name="password" required>
                                    <label>
                                        Password
                                    </label>
                                </div>
                                <div class="d-flex justify-content-between flex-wrap">
                                    <div class="rememberme">
                                        <input type="checkbox">
                                        <label>Remember Me</label>
                                    </div>
                                    <a href="#" class="forget">forget password</a>
                                </div>
                                <div class="login-btn">
                                    <button type="submit" class="login">Login to your Account!</button>
                                </div>
                            </form>

                            <!-- sign up form -->
                            <form id="step2" class="signup-form" method="post">
                                <div class="input-field">
                                    <input type="text" id="mail-email" required>
                                    <label>
                                        Your Email
                                    </label>
                                </div>
                                <div class="input-field delay-100ms">
                                    <input type="text" id="user" required>
                                    <label>
                                        Username
                                    </label>
                                </div>
                                <div class="input-field delay-200ms">
                                    <input type="password" id="password" required>
                                    <label>
                                        Password
                                    </label>
                                </div>
                                <div class="input-field delay-300ms">
                                    <input type="password" id="confirm" required>
                                    <label>
                                        Repeat Password
                                    </label>
                                </div>
                                <div class="rememberme">
                                    <input type="checkbox">
                                    <label>Send me news and updates via email</label>
                                </div>
                                <div class="login-btn">
                                    <button type="button" class="signup">Register Now!</button>
                                </div>
                            </form>

                            <!-- social sign in -->
                         <!--   <div class="login-form signup_social">
                                <div class="divide-heading">
                                    <span>Login with your Social Account</span>
                                </div>
                                <div class="social-signup">
                                    <a class="facebook" href="#"><i class="fa-brands fa-square-facebook"></i></a>
                                    <a class="twitter" href="#"><i class="fa-brands fa-twitter"></i></a>
                                    <a class="twitch" href="#"><i class="fa-brands fa-twitch"></i></a>
                                    <a class="youtube" href="#"><i class="fa-brands fa-youtube"></i></a>
                                </div>
                            </div> -->

                            
                            <div class="signup-form register-text">
                                You'll receive a confirmation email in your inbox with a link to activate your account. If you have any problems, <a href="#">contact us!</a> 
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    

    <div id="error">

    </div>


    <!-- Bootstrap-5 -->
    <script src="assets/js/bootstrap.min.js"></script>

    <!-- Jquery -->
    <script src="assets/js/jquery-3.6.1.min.js"></script>

    <!-- My js -->
    <script src="assets/js/custom.js"></script>
</body>
</html>