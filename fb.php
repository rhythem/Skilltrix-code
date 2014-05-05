<?php 
	include 'core/init.php';
	include 'includes/overall/header.php';

   $app_id = "140058679495862";
   $app_secret = "0fb930822b16b24d41d2e0f06e53e272";
   
   $my_url = "http://skilltrix.in/fb.php";
	
   session_start();


      $code = $_REQUEST["code"];
   if(empty($code)) {
     $_SESSION['state'] = md5(uniqid(rand(), TRUE)); // CSRF protection
     $dialog_url = "https://www.facebook.com/dialog/oauth?client_id=" 
       . $app_id . "&redirect_uri=" . urlencode($my_url) . "&state="
       . $_SESSION['state'] . "&scope=email,user_birthday,read_stream,user_about_me";

     echo("<script> top.location.href='" . $dialog_url . "'</script>");	
   }
  
   if($_SESSION['state'] && ($_SESSION['state'] === $_REQUEST['state'])) {
     $token_url = "https://graph.facebook.com/oauth/access_token?"
       . "client_id=" . $app_id . "&redirect_uri=" . urlencode($my_url)
       . "&client_secret=" . $app_secret . "&code=" . $code;

     $response = file_get_contents($token_url);
     $params = null;
     parse_str($response, $params);

     $_SESSION['access_token'] = $params['access_token'];

     $graph_url = "https://graph.facebook.com/me?access_token=" 
       . $params['access_token'];

     $user = json_decode(file_get_contents($graph_url));
		$username = $user->username;
		$password = substr(md5(microtime()),0,10);
		$bday=$user->birthday;
		
		$temp=explode('/',$bday);
		
		$birthday=$temp[2].'-'.$temp[1].'-'.$temp[0];
		
		$data_set = array(
			"username"		=> $user->username,
			"first_name"	=> $user->first_name,
			"last_name"		=> $user->last_name,
			"gender" 		=> ucfirst($user->gender),
			"birthday"		=> $birthday,
			"email"			=> $user->email
		);

		if($users->user_exists_temp($user->username)===true){
			echo '<b><h1>You are already registered via Facebook, please login to continue.</h1></b>';
		}else if(is_array($data_set)===false){
			echo '<b><h1>Some error occured. Please go back and try again.</h1></b>';
		}else{
				$keys = array_keys($data_set);
				$users->register_user_temp($data_set);
				echo "Registration successfull";
				$hash=md5($username);
				echo '<br>Please click the following URL, for the next step. This will be unique for you in case you get lost on the next step.<brt>';
				echo '<a href="'."nextstep.php?u=".$hash.'">Next Step</a>';
				
				
			}
?>

<?php
   }else {
     echo("The state does not match. You may be a victim of CSRF.");
   }
 ?>
 
 
 
 
