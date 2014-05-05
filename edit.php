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
	
	if (empty($settings->errors) === true) {
		if (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) === false) {
			$settings->errors[] = '<span class="error">A valid email address in required.</span>';
		} else if ($settings->email_exists($_POST['email']) === true && $users->user_data['email'] !== $_POST['email']) {
			$settings->errors[] = '<span class="error">Sorry, The email \''.htmlentities($_POST['email']). '\' is already in use.</span>';
		
		}
	}
	/*if(empty($_POST['curr_password'])===false and isset($_POST['curr_password'])===true){
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
	}*/
	if(isset($_POST['gender'])===false){
	       if(empty($_POST['gender'])){
	                $settings->errors[]='<span class="error">Gender feild can not be blank.</span>';
	                $highlight_gender=true;
	        }
	}
	if($_POST['year']== '-1' || $_POST['month']== '-1' || $_POST['day']== '-1'){
	         $settings->errors[]='<span class="error">You need to set you birthday.</span>';
	         $highlight_bday=true;
	}
}

?>

<?php

if(isset($_GET['success']) === true && empty($_GET['success']) === true){
	echo '<div class="success"><span>Your details have been updated.</span></div>';
} else{
		if(empty($_POST) === false && empty($settings->errors) === true){
			//update user details
			 if($_POST['gender'] == 'Male'){
                	$gender = 'Male';
	        }
	        else if($_POST['gender'] == 'Female'){
		        $gender = 'Female';
	        }
			$birthday = $_POST['year'].$_POST['month'].$_POST['day'];
			$worked_at = $_POST['worked_at'].'-'.$_POST['worked_as'];
			$working_at = $_POST['working_at'].'-'.$_POST['working_as'];
			$update_data = array(
				'first_name'	=> $_POST['first_name'],
				'last_name' 	=> $_POST['last_name'],
				'email'		=> $_POST['email'],
				'gender'	=> $gender,
				'birthday'	=> $birthday,
				'went_to'	=>$_POST['went_to'],
				'going_to'	=>$_POST['going_to'],
				'worked_at'	=>$worked_at,
				'working_at'	=>$working_at
				
				
			);
			/*if(isset($_POST['password']) && empty($_POST['password'])===false){
			        if(empty($_POST['password'])===true){
				        $settings->change_password_of_users($session_user_id,md5($newpass));
			        }
			}*/
			if($settings->update_user($session_user_id,$update_data)){
				header('Location: edit.php?success');
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
					<span>First Name:</span>
					<span><input type="text" class="textboxUI" placeholder="First Name" name="first_name" value ="<?php echo $users->user_data['first_name'];?>" /></span>
				</li>
				<li>
					<span>Last Name:</span>
					<span><input type="text" class="textboxUI" placeholder="Last Name" name="last_name" value ="<?php echo $users->user_data['last_name'];?>" /></span>
				</li>
				<li>
					<span>Email:</span>
					<span><input type="text" class="textboxUI" placeholder="Email" name="email" value ="<?php echo $users->user_data['email'];?>" /></span>
				</li>
				<li <?php if(isset($highlight_gender)){if($highlight_gender== true){echo 'class="error-container"';}}?>>
					<span>Gender</span>
					<span>
						<input type="radio" id="male" value="Male" name="gender">Male
						<input type="radio" id="Female" name="gender" value="Female">Female
					</span>
				</li>
				
				
				<li <?php if(isset($highlight_bday)){if($highlight_gender== true){echo 'class="error-container"';}}?>>
					<span>Date of birth</span>
					<span><?php include 'includes/date.php';?></span>
				</li>
				<li>
				<span>Went At?</span>
				<span>
				<input type="text" class="textboxUI" placeholder="Went to?" name="went_to" value="<?php echo $users->user_data['went_to'];?>"></span>
					</li>
					<li>
				<span>Going to?</span>
				<span>
				<input type="text" class="textboxUI" placeholder="Going to?" name="going_to" value="<?php echo $users->user_data['going_to'];?>"></span>
					
					</li>
				<li>
				<?php
				if((isset($users->user_data['worked_at'])===true && isset($users->user_data['working_at']))&&(empty($users->user_data['worked_at'])===false&&empty($users->user_data['working_at'])===false)){
					$worked_at = explode('-',$users->user_data['worked_at']);
					$working_at =  explode('-',$users->user_data['working_at']);
					$worked = $worked_at[0];
					$worked_as = $worked_at[1];
					$working = $working_at[0];
					$working_as = $working_at[1];
					}
				?>
				<span>Worked At?</span>
				<span>
				<input type="text" class="textboxUI" placeholder="Worked At?" name="worked_at" value="<?php if(isset($working)){echo $worked;}?>">as?<input type="text" class="textboxUI" placeholder="Worked as?" name="worked_as" value="<?php if(isset($worked_as)){echo $worked_as;}?>"></span>
					</li>
					<li>
				<span>Working at?</span>
				<span>
				<input type="text" class="textboxUI" placeholder="Working At?" name="working_at" value="<?php if(isset($working)){echo $working;}?>"> as?<input type="text" class="textboxUI" placeholder="Working as?" name="working_as" value="<?php if(isset($working_as)){echo $working_as;}?>"></span>
					
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
