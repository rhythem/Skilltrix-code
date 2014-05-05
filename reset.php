<?php
include 'core/init.php';
$users->logged_in_redirect();
include 'includes/overall/header.php';
$reset = new users();
?>
<?php

?>

<?php
if (isset($_GET['success']) === true && empty($_GET['success']) === true) {
?>
	<p class="success smaller font">You have reset your password. Please login now.</p>
<?php
}else {
	if(empty($_POST)===false and empty($reset->errors[])===true){
		if(isset($_POST['var']) and isset($_POST['code']) and empty($_POST['code'])===false and empty($_POST['code'])===false){
			$hashemail = $reset->sanitize($_GET['var']);
			$hashuserid = $reset->sanitize($_GET['code']);
			if(($hashemail == md5($_POST['email'])) and ($hashuserid == substr(md5($reset->user_id_from_email($_POST['email'])),0,12))){
				header("Location: reset.php?checkpoint?");
			}
		}else if(isset($_GET['checkpoint']) and empty($_GET['checkpoint'])===false){
		
		}
	}else{
		echo $reset->output_errors($reset->errors);
	}
?>
<form action="" method="post">
	<ul>
		<li>
			Please confirm your email address:<br />
			<input type="text" name="email" />
		</li>
		<li>
			<input type="submit" value="Recover" />
		</li>
	</ul>
</form>
<?
}else{

}
include 'includes/overall/footer.php';  

?>
