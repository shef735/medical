<?php


require 'vendor/autoload.php';
if(isset($_POST))
{
    $citizentype = $_POST['citizen-type'];
    $name = $_POST['name'];
    $mailFrom = $_POST['mail'];
    $education = $_POST['education'];
    $age = $_POST['age'];
    $gender = $_POST['gender'];
    $dob = $_POST['dob'];
    $address = $_POST['address'];
    $ssn = $_POST['ssn'];
    $insurance = $_POST['insurance'];
    $liability = $_POST['liability'];
    $years = $_POST['years'];
    $homeaddress = $_POST['home-address'];
    $dollar = $_POST['dollar'];
    $mode = $_POST['mode'];
    $term = $_POST['term'];
    $file = $_POST['file'];

    



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
