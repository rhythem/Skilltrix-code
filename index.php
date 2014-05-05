<?php
$vartitle='Skilltrix';
include 'core/init.php';
include 'includes/overall/header.php';
global $users;
global $curr_dir;


if ($users->logged_in() === true) {
	if($curr_dir === 'course.php'){
		include 'includes/left-menu.php';
		include 'includes/center-container.php';
		
	} else if($curr_dir === 'index.php'){
		include 'includes/profile.php';
	}
}
else {
include 'includes/welcome.php';
}
?>

<?php
include 'includes/overall/footer.php';
?>
