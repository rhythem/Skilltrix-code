<aside>
	<?php
		global $users;
	if($users->logged_in() ===true){
		include 'includes/widgets/loggedin.php';
	}
	?>
</aside>
