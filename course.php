<?php
include 'core/init.php';
include 'includes/overall/header.php';
global $users;
global $session_user_id;
if(isset($_GET['c'])=== false and empty($_GET['c'])===true){
	header('Location: index.php');
}else{
	$cid=$_GET['c'];
}
if($users->check_subscription($session_user_id,$cid)===true){
	header('Location: index.php');
}

if ($users->logged_in() === true) {
	include 'includes/left-menu.php';
	include 'includes/center-container.php';

}
else {
header('Location: index.php');
}
?>
<?php
include 'includes/overall/footer.php';
?>
