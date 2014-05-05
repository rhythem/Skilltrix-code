<!doctype html>
<html>
<head>
<?php header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0'); ?>

<META HTTP-EQUIV="Pragma" CONTENT="no-cache">
<?php
include 'includes/scripts.php';
include 'includes/meta.php';
global $users;
global $session_user_id;
global $curr_dir;
$var = substr(md5('tour'),0,10);
$tour=false;
if(isset($_GET['tour'])===true and empty($_GET['tour'])===false){
	if($_GET['tour'] == $var) $tour=true;
}
?>
<title>
<?php
if($users->logged_in()===false){
	echo "Skilltrix";
}else if($curr_dir=='settings.php'){
	echo 'Account Settings';
}else if($curr_dir=='edit.php'){
	echo 'Profile Settings';
}else if(($curr_dir=='courses.php')and(isset($_GET['id'])===false and empty($_GET['id']))){
	echo 'Courses';
}else if(($curr_dir=='courses.php')and(isset($_GET['id'])===true and empty($_GET['id'])===false)){
	echo ucfirst($users->get_course_name_from_id($_GET['id']));
}else if($curr_dir=='our-story.php'){
	echo 'Our Story';
}else if($curr_dir=='contact.php'){
	echo 'Contact Us';
}else{
	echo ucfirst($users->user_data['first_name']).' '.ucfirst($users->user_data['last_name']);
}
///$tour = substr(md5('tour'),0,10);//$_GET['code']==$tour

?>
</title>
</head>
<body>

	<div id="page-wrap">
		<div id="Container">
			<div id="InnerWrap" class="clearfix">
				<?php
					if(($curr_dir!='course.php')){
				?>
					<div id="HeadContainer">
						<div id="TopBarWrapper" <?php if($tour===false || $users->logged_in()===false){echo 'class="fixed"';} ?>>
							<div id="TopBarContainer">
								<div id="TopBar" class="clearfix <?php if($users->logged_in()===true){echo ' TopBar-loggedin';} ?>">
									<div class="lfloat">
										<a href="http://www.skilltrix.com" title="Start Learning">
											<div id="Logo" class="lfloat<?php if($users->logged_in()===false){echo ' Logo-margin';} ?>">
											Skilltrix
											</div>
										</a>
									</div>
									<div class="lfloat">
										<span id="alphaText" class="lfloat">
											<a href="www.skilltrix.com/blog" title="We are currently in alpha stage.">alpha</a>
										</span>
									</div>
									<?php
										if(($users->logged_in() === true)){
									?>
									<div id="course-nav" class="lfloat course-nav">
									<a href="courses.php" title="Courses">
										<div class="font25 lfloat courses">
											<span>Courses</span>
										</div>
									</a>
									</div>
									<?php
									}
									?>
									
									
										<?php
											 if(isset($_GET['faliure']) === false) {
										?>
										<div class="dropdown">
											<button id="MenuButton-nav" class="MenuButton">
												<span>
												<?php 
													if($users->logged_in()===false) {
														echo 'Sign In';
													 }else if($users->logged_in()===true){
													 	echo $users->get_fullname($session_user_id);
													 }
												 ?>
												 </span>
											</button>
															<div id="menucontainer">
								<?php if($users->logged_in()===false){ ?>
									<div id="whiteArrow"></div>
									<div id="DropDown" class="bg-white signin-drop">
										<div id="LoginMenu">
										<?php 
											}
										?>
										<?php
											if ($users->logged_in() === false and isset($_GET['faliure']) === false) {
												include('includes/login_form.php');
											} else if($users->logged_in()===true and isset($_GET['faliure'])===false){
												include 'includes/menu_username.php';
											}
										?>
										<?php if($users->logged_in()===false){ ?>
										</div>
									</div>
									<?php
										}
									?>
								
							</div>
											
										</div>
										<?php
										}
										?>
								</div>
							</div>
						</div>
					</div>
				<?php
				}
				?>
								
						
						
					

				<div id="MainContainer" 
				<?php 
				if(($users->logged_in() ===true)&&($users->has_access($users->user_data['user_id'],1)===true)){
				echo 'class="container-side-margin-admin"';
				}else if(($users->logged_in() ===true)&&($users->has_access($users->user_data['user_id'],1)===false)and($curr_dir=='course.php')){
				echo 'class="container-side-margin-normal"';
				}else if(($users->logged_in() ===false)||($users->logged_in() ===true and $curr_dir == 'contact.php' || $curr_dir == 'our-story.php')){
				echo 'class=container-top-margin';
				}else if($curr_dir!='course.php') {
				echo 'class="container-top-side-margin-normal"';
				}
				?>>
