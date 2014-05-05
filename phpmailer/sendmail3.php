<?php
require 'class.phpmailer.php';

$mail = new PHPMailer;

$mail->IsSMTP();                                      // Set mailer to use SMTP
$mail->Host = 'smtp.mandrillapp.com';                 // Specify main and backup server
$mail->Port = 587;                                    // Set the SMTP port
$mail->SMTPAuth = true;                               // Enable SMTP authentication
$mail->Username = 'prateekkumar70@outlook.com';                // SMTP username
$mail->Password = 'jkFFQgLYpCzamh7Y4TH8ZQ';                  // SMTP password
$mail->SMTPSecure = 'tls';                            // Enable encryption, 'ssl' also accepted

$mail->From = 'rhythemaggarwal@gmail.com';
$mail->FromName = 'Rhythem Aggarwal';
$mail->AddAddress('rhythemaggarwal@gmail.com', 'Rhythem Aggarwal');  // Add a recipient
//$mail->AddAddress('ellen@example.com');               // Name is optional

$mail->IsHTML(true);                                  // Set email format to HTML

$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <strong>in bold!</strong>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->Send()) {
   echo 'Message could not be sent.';
   echo 'Mailer Error: ' . $mail->ErrorInfo;
   exit;
}

echo 'Message has been sent';
