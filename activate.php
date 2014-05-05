<?php

include 'core/init.php';
$activate = new users();
$activate->logged_in_redirect();
include 'includes/overall/header.php';
$errormsg = 'We tried to activate your account but, ';

if(isset($_GET['success']) === true && empty($_GET['success']) === true) {

	echo '<div class="success width-margin martop80 medium-font">Thanks, We\'ve activated your account.</div>';

} else if(isset($_GET['email'],$_GET['email_code']) === true) {
	$email = trim($_GET['email']);
	$email_code = trim($_GET['email_code']);
	
	if($activate->email_exists($email) === false){
		$activate->errors[] = $errormsg.'<span class="error">Something went wrong. We couldn\'t find that email address.</span>';
	} else if ($activate->activate($email,$email_code) === false) {
		$activate->errors[] = $errormsg.'<span class="error">We had problem activating your account.</span>';
	}
	
	if(empty($activate->errors) === false) {
		echo $activate->output_errors($activate->errors);
	} else {
		header('Location: activate.php?success');
		exit();
	}
} else {
	header('Location: index.php');
	exit();
}



include 'includes/overall/footer.php';  
?>