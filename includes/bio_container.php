<?php
global $users;
global $session_user_id;
?>
<div id="ui-menu-container">
	<div id="ui-menu-image" class="menu-text">
		<img src="photo/resources/menu3.png" alt="Menu" title="View Your Profile"></img>
	</div>
	<div id="ui-user-profile-container" class="clearfix">
		<div class="menu-text rfloat">
			<div id="close-image">
				<img class="rfloat" id="close-menu" src="photo/resources/menu3.png" alt="Menu" title="Hide Profile Details"></img>
				<a href="logout.php"><div class="small-font logout">Logout</div></a>
			</div>
		</div>
		<div id="ui-user-profile-bio">
			<div class="clearfix">
				<div id="ui-user-profile-image" class="lfloat">
					<span class="tinyman">
						<a class="navLink" href="index.php">
							<img id="thumbnail" src="<?php echo $users->user_data['profile']; ?>" class="headerTinymanPhoto">
						</a>
					</span>
				</div>
				
			</div>
			<div id="ui-user-profile-info">
				<div id="ui-user-profile-name" class="small-font hint--right" data-hint="Return home">
				<?php 
					echo '<a href="index.php" class="cwhite">'.ucfirst($users->get_fullname($session_user_id)).'</a>';
				?>
				</div>
				<!-- hidden for now
				<div id="ui-user-profile-gender">
				<?php 
					echo ucfirst($users->get_gender($session_user_id));
				?>
				</div>
				<div id="ui-user-profile-dob">
				<?php
					echo $users->get_birthday($session_user_id);
				?>
				</div>
				<div id="ui-user-profile-livesin">Delhi, India</div>
				-->
			</div>
		</div>
	</div>
</div>
