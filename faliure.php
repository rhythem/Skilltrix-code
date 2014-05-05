<?php
include 'core/init.php';
$users->logged_in_redirect();
include 'includes/overall/header.php';
?>
<?php
if(isset($_GET['faliure'])){
?>
<div id="Loginfaliure">
	<div id="FaliureHolder">Elearning Login</div>
	<div id="FaliureNotice">
		<div class="fwb fcb fsn">Please re-enter your password</div>
		<p>The password you entered is incorrect. Please try again (make sure your caps lock is off).</p>
		<p>Forgot your password? <a href ="forgot.php">Request a new one.</a></p>
	</div>
<?php
	include('includes/login_form.php');
?>
</div>
<?php
} else {
	header('Location: faliure.php?faliure');
}
include 'includes/overall/footer.php';
?>