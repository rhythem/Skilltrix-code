<?php
include 'core/init.php';
global $users;
global $session_user_id;

$a = explode('.',$_POST['id']);
$temp = substr($a[0],19,2);


if(($users->match_userid_to_hash($a[1],$session_user_id)===true)&&($users->match_courseid_to_hash($a[0],$temp)===true)){
	$user_id = $session_user_id;
	$course_id = $temp;
}else{
	echo json_encode(array("message" => "fail"));
}

if(isset($user_id)===true&&isset($course_id)===true){
	if($users->subscribe($user_id,$course_id)){
		echo json_encode(array("message" => "pass"));
	} else{
		echo json_encode(array("message" => "fail"));
	}
}
?>
