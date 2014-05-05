<?php
global $users;
if(isset($_GET['c'])===true and empty($_GET['c'])===false) $cid=$_GET['c'];
?>

<div id="ui-left-menu-wrap" class="clearfix">
	<div id="left-menu-continer" class="<?php if($users->has_access($users->user_data['user_id'],1)==true){echo 'admin-left-menu-class';}else{echo'user-left-menu-class';} ?>">
		<div id="left-menu-inner-wrap">
			
			<?php
			include 'includes/bio_container.php';
			?>
<?php

	if($users->has_access($users->user_data['user_id'],1)==false){
		
		include 'includes/user_menu_content.php';
		
	}
?>
		</div>
	</div>	
</div>

