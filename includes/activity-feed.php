<?php
//dinclude 'core/init.php';

global $users;
global $session_user_id;
global $curr_dir;
$activity = new users();
?>


			<div class="activity-container clearfix">
				<div class="date-container lfloat">
						<span class="date bold">March 31</span>
						<span class="day block">Sunday</span>
				</div>
					
					<div class="activity-inner-container">
						<div class="activity lfloat">
							<div class="feed">
								<span class="user-name bold"><?php echo $users->get_firstname($session_user_id);?></span>
								<span class="lightgray"> started </span>
								<span class="bold"> c/c++ </span>
								<span class="lightgray">course.</span>
								<span class="lightgray rfloat">10.44 PM</span>
							</div>
							
						</div>
					</div>
				</div>
			</div>
