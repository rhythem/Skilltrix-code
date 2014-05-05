<?php
//dinclude 'core/init.php';

global $users;
global $session_user_id;
global $curr_dir;
$activity = new users();
?>

<?php 
$activity = new users();
$a = $activity->parse_activity($session_user_id);
foreach($a as $b){
	echo $b;

}
?>