<?php
global $users;
?>
<div class="about-container">
	<div class="about-container-feed">
		<div class="about-feed-inset basic clearfix">
			<div>Basic Info</div>
			<div><span><?php echo ucfirst($users->user_data['first_name']).' '.ucfirst($users->user_data['last_name']);?></span></div>
			<div><span><?php echo ucfirst($users->user_data['gender']);?></span></div>
			<div><span><?php echo 'Born on '.$users->user_data['birthday'];?></span></div>
			<div class="edit rfloat"><a href="settings.php">Edit</a></div>
		</div>
		<div class="about-feed-inset education clearfix">
			<div>Education</div>
			<?php 
			if(empty($users->user_data['went_to'])===false and empty($users->user_data['going_to'])===false){
				echo '<div><span>Went to '.ucfirst($users->user_data['went_to']).'</span></div><div><span>'.'Going to '.ucfirst($users->user_data['going_to']).'</span></div>';
				}else{
				echo '<div><span>Please add education details.</span></div>';
				}?>
			
			<div class="edit rfloat"><a href="settings.php">Edit</a></div>
		</div>
	</div>
	<div class="about-container-feed ">
		<div class="about-feed-inset work clearfix">
			<div>Work</div>
			<?php	
				$worked='';
				$working='';
				
				if((isset($users->user_data['worked_at'])===true && isset($users->user_data['working_at']))&&(empty($users->user_data['worked_at'])===false&&empty($users->user_data['working_at'])===false)){
					$worked_at = explode('-',$users->user_data['worked_at']);
					$working_at =  explode('-',$users->user_data['working_at']);
					$worked = $worked_at[0];
					$worked_as = $worked_at[1];
					$working = $working_at[0];
					$working_as = $working_at[1];
					
					
			?>
			<div><span><?php	echo 'Worked at '.ucfirst($worked).' as '.ucfirst($worked_as);?></span></div>
			<div><span><?php echo 'Working at '.ucfirst($working).' as '.ucfirst($working_as);?></span></div>
			
			<?php
			}else{
			?>
			<div><span>Please Add Work Details</span></div>
			
			<?php
			}
			?>
			<div class="edit rfloat"><a href="settings.php">Edit</a></div>
		</div>
		<div class="about-feed-inset contact clearfix">
			<div>Contact</div>
			<div><span><?php echo 'Email '.ucfirst($users->user_data['email']);?></span></div>
			<div class="edit rfloat"><a href="settings.php">Edit</a></div>
		</div>
	</div>
</div>

	


















