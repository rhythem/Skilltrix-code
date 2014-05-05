<?php
include 'core/init.php';
include 'includes/overall/header.php';
$settings = new users();
global $users;
$users->protect_page();
global $session_user_id;
?>
<div class="settings-container">
<?php
if (empty($_POST) === false) {
	$required_feilds = array('first_name','last_name','email','going_to','went_to','worked_at','working_at','worked_as','working_as');
	foreach($_POST as $key=>$value){
		if(empty($value) && in_array($key, $required_feilds) ===true){
			$settings->errors[] = '<span class="error">All feilds are required.</span>';
			break 1;
		}
	}
	
	
	if(empty($_POST['curr_password'])===false and isset($_POST['curr_password'])===true){
		$curr_pass=$_POST['curr_password'];

		
		if($settings->auth_pass($curr_pass,$session_user_id) === true){
			if(empty($_POST['password'])===false and empty($_POST['re_password'])===false){
						$pass           = $_POST['password'];
						$repass         = $_POST['re_password'];
						if(strcmp($pass,$repass)!=0){
							$settings->errors[]='<span class="error">Both passwords do not match</span>';
						}else if(strlen($pass)<6){
							$settings->errors[]='<span class="error">Password to small.</span>';
						}else{
							$newpass=$pass;
							echo $newpass;
						}
			}else{
					$settings->errors[]='<span class="error">Password feilds are empty.</span>';
				}
		}else{
			$settings->errors[]='<span class="error">Current Password to incorrect.</span>';
		}
	}
	
	
}

?>

<?php

if(isset($_GET['success']) === true && empty($_GET['success']) === true){
	echo '<div class="success"><span>Your details have been updated.</span></div>';
} else{
		if(empty($_POST) === false && empty($settings->errors) === true){
			//update user details
	
			$update_data = array(
				'password'	=> md5($_POST['password'])
			);
			
			if($settings->update_user($session_user_id,$update_data)){
				header('Location: settings.php?success');
				exit();
			}else{
				$settings->errors[] = '<span class="error">Some error occored please try again.</span>';

			}
		} else if(empty($settings->errors) === false){
			echo $settings->output_errors($settings->errors);
		}
		?>
<div class="small-container">
		<form action="" method="post">
			<ul class="settings">
				
				<li>
					<span>Current Password:</span>
					<span><input type="password" class="textboxUI" placeholder="Current Password" name="curr_password"  /></span>
				</li>
				<li>
					<span>Password:</span>
					<span><input type="password" class="textboxUI" placeholder="Password" name="password"  /></span>
				</li>
				<li>
					<span>Retype Password:</span>
					<span><input type="password" class="textboxUI" placeholder="Retype Password" name="re_password"/></span>
				</li>
				<li>
					<span><input class="ui-button" type="submit" value="Update" /></span>
				</li>
			</ul>
		</form>
</div>
</div>
<?php
}
include 'includes/overall/footer.php';
?>
