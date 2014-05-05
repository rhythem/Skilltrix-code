<?php
	echo "SUCCESS";
	if(isset($_POST['say']) and empty($_POST['say'])===false){
	$say = $_POST['say'];
	$id = $_POST['id'];
		include '/var/www/html/core/classes/users.php';
        $saysomething = new users();
		if($saysomething->set_saysomething($say,$id)){
			echo 'SUCCESS';
		}
	}
?>