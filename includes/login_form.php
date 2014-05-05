<form action="login.php" method="post">
<?php
if (isset($_GET['faliure']) === false) {
?>
	<ul id="login">
		
			<li><input type="text" name="username" id="username" class="TextInput" placeholder="Username"/></li>
			<li><input type="password" name="password" id="password" class="TextInput" placeholder="Password"/></li>
			<li><input type="submit" value="Log In" class="LoginButtonUi"/></li>
			<li class="black"><a class="black" href="recover.php">Forgot password?</a></li>

	</ul>
<?php
} else {
?>
	<div id="FaliureLoginFormContainer" class="clearfix">
		<div class="FaliureLoginForm">
			<label for="username" class="fwb">Username:</label>
			<input type="text" name="username" id="username" class="TextInput faliure" placeholder="Username"/>
		</div>
		<div class="FaliureLoginForm">
			<label for="password" class="fwb">Password:</label>
			<input type="password" name="password" id="password" class="TextInput faliure" placeholder="Password"/>
		</div>
		<div class="FaliureLoginForm FaliureSubmit clearfix">
			<div id="FaliureSubmitButon"><input type="submit" value="Log In" class="LoginButtonUi FaliureButton"/></div>
			<div id="Register_link"> Or <strong><a href="signup.php">Sign Up</a> With Elearning</strong></div>
		</div>
		<div id="ForgotPassword"><a href="forgot.php">Forgot Your Password?</a></div>
	</div>
<?php
}
?>
</form>
