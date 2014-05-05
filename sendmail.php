<?php
require 'phpmailer/class.phpmailer.php';
$mail = new PHPMailer;
$mail->IsSMTP();                                      
$mail->Host = 'smtp.mandrillapp.com';                 
$mail->Port = 587;                                    
$mail->SMTPAuth = true;                               
$mail->Username = 'prateekkumar70@outlook.com';
$mail->Password = 'jkFFQgLYpCzamh7Y4TH8ZQ';
$mail->SMTPSecure = 'tls';                            
$mail->From = 'prateekkumar70@yahoo.com';
$mail->FromName = 'yo';
$mail->AddAddress('feedback@skilltrix.com', 'Prateek Kumar');  

$mail->IsHTML(true);                                  
$mail->Subject = 'Here is the subject';
$mail->Body    = 'This is the HTML message body <strong>in bold!</strong>';
$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

if(!$mail->Send()) {
   echo 'Message could not be sent.';
   echo 'Mailer Error: ' . $mail->ErrorInfo;
   exit;
}

echo 'Message has been sent';
?>
