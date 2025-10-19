<?php


require 'vendor/autoload.php';
if(isset($_POST))
{
    
    $name = 'Meeting';
    $mailFrom = $_POST['mail'];


    $meeting_type = $_POST['meeting_type'];

    $date  = 'from: '.$_POST['start_date']. " to: " . $_POST['end_date'];
    $schedule = $_POST['schedule'];

    $time  = 'from: '.$_POST['start_time']. " to: " . $_POST['end_time'];

    $customvalue = $_POST['customvalue'];
    $location = $_POST['location'];


    $calender = $_POST['calender'];
    $room = $_POST['room'];
    $description = $_POST['description'];
    $event_color = $_POST['event_color'];

    






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
