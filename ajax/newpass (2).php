<?php
	$email = $_POST['email'];
	$pass = $_POST['pass'];
	if(empty($email)===false and empty($pass)===false){
		include '/var/www/html/core/classes/users.php';
        $newsend = new users();

		$newsend->newpass($email,$pass);
		$temp = 'Password changed';
		echo json_encode(array("message" => $temp,"mode"=>"success","email"=>$email));
	}else{
		echo json_encode(array("message" => "Failed to change your password, please try again.","mode"=>"success","fail"=>$email));
	}
	
?>