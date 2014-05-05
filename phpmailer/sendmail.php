<?php
require_once("class.phpmailer.php");
//include("class.smtp.php"); 
//optional, gets called from within class.phpmailer.php if not //already loaded
$mail=new PHPMailer();
$mail->IsSMTP(true); // telling the class to use SMTP
//$mail->Host="smtp.live.com"; // SMTP server
$mail->SMTPDebug=2;    
// enables SMTP debug information (for testing)
// 1 = errors and messages
// 2 = messages only
$mail->SMTPSecure="tls";
$mail->SMTPAuth=true;        // enable SMTP authentication
$mail->Host="smtp.live.com"; // sets the SMTP server
$mail->Port=587;    // set the SMTP port for the GMAIL server
$mail->Username="prateekkumar@skilltrix.com"; 
// SMTP account username
$mail->Password="Test@123";        
// SMTP account password
$mail->SetFrom("prateekkumar@skilltrix.com", "Prateek Kumar");
$mail->AddReplyTo("prateekkumar@skilltrix.com","Prateek Kumar");
$mail->Subject="Skilltrix is going good";
$mail->Body="Hi! \n\n This is to inform you that skilltrix is going good"; // optional, comment out and test
$mail->WordWrap=50;
//$mail->MsgHTML($body);
$address="prateekkumar70@outlook.com";
$mail->AddAddress($address, "Prateek Kumm");
if(!$mail->Send()) {
  echo "Mailer Error: ";
$mail->ErrorInfo;
} else {
  echo "Message sent!";
}
?>