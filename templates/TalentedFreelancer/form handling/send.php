<?php


require 'vendor/autoload.php';
if(isset($_POST))
{
    $name = $_POST['first-name'] . " " . $_POST['last-name'];
    $mailFrom = $_POST['mail'];
    $service = $_POST['service'];
    $phone = $_POST['contrycode'].$_POST['phone'];
    $ssn = $_POST['ssn'];

    if($ssn == "Yes")
    {
        $ssnnum = $_POST['ssn-num'];
    }
    else
    {
        $ssnnum = 'ssn is set to No!';
    }


    $countryselect = $_POST['country-select'];
    $state = $_POST['state'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $pincode = $_POST['pincode'];


    // get custom field data
    $numtextfield = $_POST['textboxID'];
    $numselectfield = $_POST['selectboxID'];

    for($i = 1; $i<=$numtextfield; $i++)
    {
        $textfield = $_POST['textfield'.$i];

        for($i = 1; $i<=$numtextfield; $i++)
        {
            $textfieldout = "" . "<br/>" . "<b>" . "TextField" . $i . ":" . "</b>"  .$textfield;
            
            // $textfieldCount = count($numtextfield);
            $Textfieldresult = []; // Empty array
            for ($i = 1; $i < $numtextfield; $i++) 
            {
                $Textfieldresult[$i] = $textfieldout;

                return $Textfieldresult;
            }
        };

    }




    $othercompany = $_POST['othercompany'];
    $subject = $_POST['subject'];
    $description = $_POST['description'];
    $corporation = $_POST['corporation'];
    $bussinesscmpny = $_POST['bussinesscmpny'];
    $shares = $_POST['shares'];
    $share_value = $_POST['share_value'];
    






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
