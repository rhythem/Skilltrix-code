
	<div class="widget">
		
		<div class="inner">
			<div class="profile">
				<?php
				if (isset($_FILES['profile']) === true) {
					if (empty($_FILES['profile']['name']) === true) {
						echo 'Please Choose a file!';
					} else {
						
						$allowed = array ('jpg','jpeg','gif', 'png');
						
						$file_name = $_FILES['profile']['name'];
						$file_extn = strtolower(end(explode('.', $file_name)));
						$file_temp = $_FILES['profile']['tmp_name'];
						
						if (in_array($file_extn,$allowed) === true) {
								//upload file
								change_profile_image($session_user_id, $file_temp, $file_extn);
								header('Location: index.php');
								exit();
						} else {
							echo 'Incorrect file type. Allowed:';
							echo implode(', ',$allowed);
						}
					}
				}
					if (empty($user_data['profile']) === false) {
						echo '<a href="'.$user_data['first_name'].'">'.'<img src="'. $user_data['profile'].'" alt="'. $user_data['first_name'] . '">'.'</a>';
					} 
				?>
				<form action="" method="post" enctype="multipart/form-data">
				<div id="PicUploadButton"><input type="file" name="profile"><input type="submit"></div>
				</form>
				
				<nav id="UiButtons">
				<ul>
					<li><a href="index.php"><img src="images/resources/home.png" alt="Home" /></a></li>
					<li><a href="settings.php"><img src="images/resources/Settings.png" alt="Settings" /></a></li>
					<li><a id="changepicButton"><img src="images/resources/changepic.png" alt="Change Pic" /></a></li>
					<li><a href="changepassword.php"><img src="images/resources/password.png" alt="Change Password" /></a></li>
					<li><a href="notification.php"><i class="notification"><?php echo count_friend_request($session_user_id); ?></i></a></li>
					<li><a href="logout.php"><img src="images/resources/logout.png" alt="Logout" /></a></li>
				</ul>
				
				</nav>
				<div class="clear"></div>
			</div>
				<ul>
					<li>
						<a href="<?php echo $user_data['username'];?>">Profile</a>
					</li>
					<?php
						if(has_access($user_data['user_id'], 1) === true)
						{
					?>
					<li>
						<a href="mail.php">Send Mass Mail</a>
					</li>
					<li>
						<a href="courseadd.php">Add Course</a>
					</li>
					<?php
						}
					?>
					<li><hr /></li>
					<?php 
						if ( has_access($user_data['user_id'], 1) === false) {
					?>
					<li>
						<fieldset>
							<legend>Courses Enrolled:</legend>
							<ul id="CourseEnrolled">
							<?php
								$courseenrolledBufferCreated	= fetch_course_code_from_userid();
								foreach($courseenrolledBufferCreated as $courseenrolled) {
							?>
								<a href="courses.php?course=<?php echo $courseenrolled; ?>" class="CourseList"><li><div class="CompleteStatus"></div><?php echo ucfirst($courseenrolled);?></li></a>
							<?php
							}
							?>
								
								<a href="courses.php?course=all"   class="CourseList"><li><div id="AllCourses"></div>AllCources</li></a>
							</ul>
							<div class="clear"></div>
						</fieldset>
					</li>
					<?php
						} else {
					?>
					<li>
						<fieldset>
							<legend>Courses Available:</legend>
							<ul id="CourseAvailable">
					<?php
						$courseBufferCreated	= fetch_course_name();
						foreach($courseBufferCreated as $course) {
					?>
						<a href="coursedetails.php?details=<?php echo $course; ?>" class="CourseList"><li><?php echo ucfirst($course);?></li></a>
					<?php
					}
					?>
							</ul>
							<div class="clear"></div>
						</fieldset>
					</li>
					<?php
						}
					?>
					<li><hr /></li>
					
				</ul>
		</div>
	</div>

