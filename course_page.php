<?php
include 'core/init.php';
include 'includes/overall/header.php';
global $users;
if ($users->logged_in() === true) {
	include 'includes/left-menu.php';
	include 'includes/center-container.php';
	if($users->has_access($users->user_data['user_id'],1)===false){
		//include 'includes/right-menu.php';
	}
}
else {
include 'includes/welcome.php';
}
?>


<?php
include 'includes/overall/footer.php';
?>
