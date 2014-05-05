<form action="register.php" method="post">
<div class="register-container">
	<table class="register-table">
			<tr>
			<td colspan="2">
				<span id="signup_head" class="cwhite">Sign up now and start learning</span>
			</td>
		</tr>
	<?php
	
	if(empty($_GET['e'])===false){
		if($_GET['e'] == md5(1)){
			$errors='All feilds required.';
		}else if($_GET['e'] == md5(2)){
			$errors='Sorry, The username is already registered.';
		} else if($_GET['e'] == md5(3)){
			$errors='Username Cant contain spaces.';
		} else if($_GET['e'] == md5(4)){
			$errors='Password too small.';
		} else if($_GET['e'] == md5(5)){
			$errors='Your passwords do not match';
		} else if($_GET['e'] == md5(6)){
			$errors='Sorry, The email is already in use.';
		} else if($_GET['e'] == md5(7)){
			$errors='A valid email address in required.';
		} else {
				$errors = 'Some error occored please try again.';

		}

		echo '<tr><td colspan="2" id="error">'.$errors.'</td></tr>';
	}
	?>

		<tr >
			<td ><input class="TextInput width100" placeholder="First Name" type="text" name="first_name" /></td>
			<td ><input class="TextInput width100" placeholder="Last Name" type="text" name="last_name" /></td>
		</tr>
		<tr >
			<td colspan="2" ><input class="TextInput width100" placeholder="Email" type="text" name="email" /></td>
		</tr>
		<tr >
			<td colspan="2" ><input class="TextInput width100" placeholder="Username" type="text" name="username" /></td>
		</tr>
		<tr>
<td ><input class="TextInput width100" placeholder="Password" type="password" name="password" /></td><td ><input class="TextInput width100" placeholder="Password Again" type="password" name="password_again" /></td>
		</tr>
		<tr >
			<td colspan="2"><input class="ui-button width100" type="submit" value="Register" ></td>
		</tr>
		<!--<tr>
			<td colspan="2" align="center"><i><b class="cwhite">connect with via facebook.</b></i></td>
		</tr>
		<tr>
			<td colspan="2" ><a href="fb.php" class="ui-button facebook width100" style="width:93%"><span class="cwhite">Facebook</span></a></td>
		</tr>-->
	</table>

	
</div>

</form>
