<?php


	session_start();
	ob_start();
	error_reporting(0);
	include('core/classes/users.php');
	include('core/classes/profile.php');
	$users = new users();
	if($users->logged_in() === true){
		$session_user_id = $_SESSION['user_id'];
		$users->user_data($session_user_id);
	}
	$curr_dir = basename($_SERVER['PHP_SELF']);
?>
