<?php
// $email = "bk16cr@gmail.com";
// $name = "YOUR-NAME";
// $body = "Hey man, how are you? <br><br><a href='https://google.com'>Google</a>";
// $subject = "Test email";



$mail->isSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.sendgrid.net';  // Specify main and backup SMTP servers
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'apikey';                 // SMTP username
$mail->Password = 'SG.RcgxE6RDjTOqq8LCA_7RW1A.Pz6kkgT6D8l1E8sri75nKK0iQR7PdLGzkoiKUVElcyY';                           // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable TLS encryption, `ssl` also accepted
$mail->Port = 2525;                                    // TCP port to connect to
$mail->SMTPOptions = [
      'ssl' => [
            'verify_peer' => false,
            'verify_peer_name' => false,
      ],
];

//Import PHPMailer classes into the global namespace
	//These must be at the top of your script, not inside a function
	use PHPMailer\PHPMailer\PHPMailer;
	use PHPMailer\PHPMailer\SMTP;
	use PHPMailer\PHPMailer\Exception;

	//Load Composer's autoloader
	require 'vendor/autoload.php';

	//Create an instance; passing `true` enables exceptions
	$mail = new PHPMailer(true);
	try{
		$mail->isSMTP();// Set mailer to use SMTP
		$mail->CharSet = "utf-8";// set charset to utf8
		$mail->SMTPAuth = true;// Enable SMTP authentication
		$mail->SMTPSecure = 'tls';// Enable TLS encryption, `ssl` also accepted

		$mail->Host = 'smtp.gmail.com';// Specify main and backup SMTP servers
		$mail->Port = 587;// TCP port to connect to
		$mail->SMTPOptions = array(
		    'ssl' => array(
		        'verify_peer' => false,
		        'verify_peer_name' => false,
		        'allow_self_signed' => true
		    )
		);
		$mail->isHTML(true);// Set email format to HTML

		$mail->Username = 'milopleInc@gmail.com';// SMTP username
		$mail->Password = 'gmail password here';// SMTP password

		$mail->setFrom('milopleInc@gmail.com', 'John Smith');//Your application NAME and EMAIL
		$mail->Subject = 'Test Test';//Message subject
		$mail->MsgHTML('HTML code');// Message body
		$mail->addAddress('milopleInc@gmail.com', 'John Smith');// Target email

		$mail->send();
		echo 'Message has been sent';
	}
	catch (Exception $e) {
	    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
	}
    ?>