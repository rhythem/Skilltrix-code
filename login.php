<?php

include 'core/init.php';
$users->logged_in_redirect();
$loginObj = new users();
$email='';
if(!empty($_POST) ){


	$username=$_POST['username'];
	$password = $_POST['password'];
	
	$mode='login_error';
	
	$errormsg = 'We tried to log you in but, ';
	
	if(empty($username)==true || empty($password) == true){
	
		$errors[] = $errormsg.'<span class="error">You Need To enter a username/Password</span>';

		
	}else if($loginObj->user_exists($username)== false){
	
		$errors[] = $errormsg.'<span class="error">We can\'t find that Username Have you registerd?</span>';

		
	} else if($loginObj->user_active($username)==false){
	
		$errors[] = $errormsg.'<span class="error">You haven\'t activated your account.</span>';

	
	}else if(($loginObj->check_account_status($username,$password))===false){
		$errors[] = $errormsg.'<span class="error block">Your account is not active yet.</span><span class="error block">Plese activate your account.</span><span class="error block">If you have not yet received the activation email, try resending it.</span>';
		$mode = 'resend';
		$email = $loginObj->get_email_from_username($username);


	}if(strlen($password)<6){
		$errors[] = $errormsg.'<span class="error">Password Too small.</span>';
	} else {
	
		if(strlen($password) > 32){
			$errors[] = $errormsg.'<span class="error">Password Too Long.</span>';
		}
		$login = $loginObj->login($username,$password);
		if($login ===false){
			$errors[] = $errormsg.'<span class="error">Incorrect Username/Password.</span>';
		} else {
		 
			// set user session
			$_SESSION['user_id'] = $login;
			
			//redirect user to home
			header('Location: index.php');
			exit();
		}
	}
} else{
	$errors[] =$errormsg.'<span class="error">No Data Received. Please try again.</span>';
}
include 'includes/overall/header.php';
if(empty($errors) === false){
		echo $loginObj->output_errors($errors,$mode,$email);
	}

include 'includes/overall/footer.php';
?>
