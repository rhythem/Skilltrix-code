<?php
include 'core/init.php';

global $users;
$users->logged_in_redirect();


if (empty($_POST) === false){
	$required_feilds = array('username','password','password_again','first_name','email');
	foreach($_POST as $key=>$value){
		if(empty($value) && in_array($key, $required_feilds) ===true){
			$users->errors[] = 'Feilds marked with and astrisk are required.';
			$e=1;
			break 1;
		}
	}
	if(empty($users->errors) === true){
		if ($users->user_exists($_POST['username']) === true) {
			$users->errors[]='Sorry, The username \''.htmlentities($_POST['username']). '\' is already taken.';
			$e=2;
		}
		if(preg_match("/\\s/", $_POST['username']) == true ){
			$users->errors[] = 'Username Cant contain spaces.';
			$e=3;
		}
		if(strlen($_POST['password'])<6){
			$users->errors[] = 'Password is too small.';
			$e=4;
		}
		if($_POST['password'] != $_POST['password_again']){
			$users->errors[] = 'Your passwords do not match';
			$e=5;
		}
		if($users->email_exists($_POST['email']) === true){
			$users->errors[] = 'Sorry, The email \''.htmlentities($_POST['email']). '\' is already in use.';
			$e=6;
		}
		if(filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false){
			$users->errors[] = 'A valid email address in required.';
			$e=7;
		}
		
	}
	
}

?>
<?php
if(isset($_GET['success']) && empty($_GET['success'])){
	include 'includes/overall/header.php';
		echo '<div class="success width-margin martop80 medium-font"><span class="block">You\'ve been registered succesfully!</span><span class="block"> Please check your email to activate your account.</span></div>';
	include 'includes/overall/footer.php';
}else {
if(empty($_POST) === false && empty($users->errors) === true){
	//register user
	 $register_data = array(
	 'username' 	=> $_POST['username'],
	 'password'		=> $_POST['password'],
	 'first_name' 	=> ucfirst($_POST['first_name']),
	 'last_name' 	=> ucfirst($_POST['last_name']),
	 'email' 		=> $_POST['email'],
	 'email_code'	=> md5($_POST['username'] + microtime() )
	 );
	if($users->register_user($register_data)===true){
	//redirect
	header('Location: register.php?success');
	//exit
	exit();
	}
} else if(empty($users->errors) === false) {
	$e=md5($e);
	
	//in case a modal popup is to be presented, just append #join_form at the end of the link
	echo header("Location: index.php?e=$e");
}

}
?>
