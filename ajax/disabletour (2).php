<?php
	if(isset($_POST['code']) and empty($_POST['code'])===false){
	$id = $_POST['code'];
	$success = "success";
	$fail 	= "fail";
		include '/var/www/html/core/classes/users.php';
        $tour = new users();
		if($tour->disabletour($id)===true){
			echo $fail;
		}else{
			echo $fail;
		}
	}else{
		echo $fail;
	}
?>