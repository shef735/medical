<?php


require 'vendor/autoload.php';
if(isset($_POST))
{
    $location = $_POST['location'];

$citizenship = $_POST['citizenship'];

$gender = $_POST['gender'];

$appliedJob = $_POST['applied'];

$name = $_POST['name'];
// $name = "saim";

$mailFrom = $_POST['mail'];
// $mailFrom = 'saimakbar15@gmai.com';

$experiencY = $_POST['experience-y'];
$experiencM = $_POST['experience-m'];

$sallaryM = $_POST['sallary-m'];
$sallaryY = $_POST['sallary-y'];

$designation = $_POST['designation'];
$keyskills = $_POST['keyskills'];
$lang = $_POST['lang'];
$message = $_POST['message'];
$terms = $_POST['terms'];
$newsletter = $_POST['newsletter'];
$file = $_POST['cv'];



// send mail

    // Create the Transport
    $transport = (new Swift_SmtpTransport('yourserverlocation', 465, 'ssl'))
        // optional ->setUsername('serveremail@site.com')
        // optional ->setPassword('email password')

    ;
    
    // if attachment is uploaded
    // $message->attach(
    // Swift_Attachment::fromPath($_FILES['file']['tmp_name'])->setFilename($_FILES['file']['name'])
    // );

    $mailer = new Swift_Mailer($transport);

    //Creating message
    $message = (new Swift_Message('Subject'))
        ->setFrom([$mailFrom => $name])
        ->setTo(["youremail@gmail.com" => "reciever Name"])
        ->setBody("Message Body"
)	
    ;

    $result = $mailer->send($message);
}
else
{
    echo "error";
}


ini_set("log_errors", 1);
ini_set("error_log", "/tmp/php-error.log");
error_log( "Hello, errors!" );
