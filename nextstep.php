<?php
$hash_uname =  $_GET['u'];
include 'core/init.php';
include 'includes/overall/header.php';
global $users;
$settings = new users();

if(empty($_POST)===false){
$required_feilds = array('fbusername','fbpassword','fbrepass');
	foreach($_POST as $key=>$value){
		if(empty($value) && in_array($key, $required_feilds) ===true){
			$settings->errors[] = 'Feilds marked with and astrisk are required.';
			break 1;
		}
	}
	
	if (empty($settings->errors) === true) {
		if(md5($_POST['fbusername']) != $hash_uname){
			$settings->errors[] = 'Username does not match.';
		}
		if($_POST['fbpassword']!=$_POST['fbrepass']){
			$settings->errors[] = 'Passwords do no match.';
		}
		if(strlen($_POST['fbpassword'])<6){
			$settings->errors[] = 'Password too short.';
		}
	}
	
	
}


?>

<?php

if(isset($_GET['success']) === true && empty($_GET['success']) === true){
	echo 'Your account have been created succesfully, please login to continue.';
} else{
		if(empty($_POST) === false && empty($settings->errors) === true){
			//update user temp details
				$username=$_POST['fbusername'];
				$password=$_POST['fbpassword'];
			$settings->update_details_from_temp($username,$password);
			header('Location: nextstep.php?success');
			exit();
		} else if(empty($settings->errors) === false){
			echo $settings->output_errors_standard($settings->errors);
			
		}
		?>

<form method="post" action="">
	<table class="black">
		<tr>
			<td class="black">Enter your facebook username:</td><td><input name="fbusername" type="text" class="TextInput" placeholder="Facebook Username"></td>
		</tr>
		<tr>
			<td class="black">Enter Password for Skilltrix:</td><td><input name="fbpassword" type="password" class="TextInput" placeholder="Password"></td>
		</tr>
		<tr>	
			<td class="black">Retype Password:</td><td><input name="fbrepass" type="password" class="TextInput" placeholder="Password"></td>
		</tr>
		<tr>	
			<td colspan="2"><input type="submit" class="ui-button" value="Save Password"></td>
		</tr>
	</table>
</form>
<?php
}
include 'includes/overall/footer.php';
?>
