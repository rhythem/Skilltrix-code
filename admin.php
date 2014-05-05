<?php
include 'core/init.php';
include 'includes/overall/header.php';
global $users;
$users->admin_protect();

if ($users->logged_in() === true) {
	include 'includes/left-menu.php';
}

?>


<?php 
include 'includes/overall/footer.php';
?>
