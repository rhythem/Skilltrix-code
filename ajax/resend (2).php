<?php 
	$email = $_POST['email'];
	    if($email !=''){
        include '/var/www/html/core/classes/users.php';
        $resend = new users();
		$code = $resend->get_emailcode_from_email($email);
        $to=$email;
		$name = '';
		$subject = 'Activate Your account at Skilltrix.com';
		$body = 'Thank you for signing up with Skilltrix! You must follow this link to activate your account:'.'<br>'.
		"http://skilltrix.com/activate.php?email=".$email."&email_code=".$code.'<br>'.
		"If the link does not works try copying and pasting in your url bar.".
		'<br><br>'.
		"Skilltrix provides a new way to learn, a better environment to develop and a whole new set of opportunities.".
		'<br><br>'.
		'-Skilltrix Team'.'<br>'.
		'http://www.skilltrix.com';
		if($resend->our_mail($email,$name,$subject,$body)){
			echo 'True';
		}
    } 
?>