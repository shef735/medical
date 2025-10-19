<?php


require 'vendor/autoload.php';
if(isset($_POST))
{
    $name = $_POST['name'];
    $mailFrom = $_POST['mail'];
    $residence = $_POST['residence'];
    $location = $_POST['location'];
    $minprice = $_POST['min-price'];
    $maxprice = $_POST['max-price'];
    $category = $_POST['category'];
    $BedRooms = $_POST['BedRooms'];
    $propertylocation = $_POST['property-location'];
    $property = $_POST['property'];
    $zip = $_POST['zip'];
    $product = $_POST['product'];
    $father = $_POST['father'];
    $mother = $_POST['mother'];
    $residencep = $_POST['residence-p'];
    $phone = $_POST['phone'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];

    



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
