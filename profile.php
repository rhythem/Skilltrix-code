<?php
include 'core/init.php';
include 'includes/overall/header.php';

if(isset($_GET) and empty($_GET)===false){
	if(isset($_GET['username']) and empty ($_GET['username'])===false){
	$username = $_GET['username'];
	global $users;
	if($users->user_exists($username)===true){
		$session_user_id = $users->get_user_id($username);
		$profile = new profile();
		$profile->profile_user_data($session_user_id);
		if((isset($_GET['activity'])===true)||((empty($_GET)===true)&&($curr_dir=='index.php'))){
			$label ='Recent Activity';
		}else if(isset($_GET['about'])===true){
			$label='About';
		}else if(isset($_GET['courses'])===true){
			$label='Courses';
		}else if(isset($_GET['badges'])===true){
			$label='All Badges';
		}
?>
<script type="text/javascript">
$(document).ready(function(){var e=$("#profile-image").attr("alt").split(".");if(e[1]!=""){e=e[1].split("-");var t=e[0];var n=e[1];if(t!=0||n!=0){var r=.8;var i=1.06;$("#profile-image").css({width:Math.round(r*400)+"px",height:Math.round(i*300)+"px",marginLeft:-Math.round(r*t)+"px",marginTop:-Math.round(i*n)+"px"})}else if(t==0&&n==0){$("#profile-image").css({width:160+"px",height:160+"px",marginLeft:0+"px",marginTop:0+"px"})}}else{$("#profile-image").css({width:100+"%",height:100+"%"})}$("#display-pic").hover(function(){$(".change").toggle()})})
</script>


<div class="profile-container">
	<div class="profile-inner">
		<div id="Profile">
			<div class="cover-container" id="margint85";>
				<div class="cover-inner">
					<div id="cover">
						<?php if(isset($profile->profile_data['cover']) and empty($profile->profile_data['cover'])===false){ echo '<img src="'.$profile->profile_data['cover'].'">'; }?>
						<span class="name-gradient"></span>
						<span class="underline">
							<h2 class="display-name">
								<a href="index.php" ><?php echo $users->get_fullname($session_user_id);?></a>
							</h2>
						</span>
						<span id="cover-nav" class="upload-cover <?php echo $tour?'block':'hidden'; ?>">
						        <h2 class="change-image smaller-font">
						                <a href="image.php?t=cover">Change Cover</a>
						        </h2>
						</span>
					</div>
				</div>
			</div>
			<div id="about-container">
				<div id="about">
					<div id="about-you">
						<?php
						if(empty($profile->profile_data['something'])===true){
							$temp = '<span id="about-you-content" data-hint="Say something" class="hint--always hint--right">Say something about yourself</span>';
						}else{
							$temp = '<span id="about-you-content" data-hint="Click to say something" class="hint--right">'.$profile->profile_data['something'].'</span>';
						}
						echo $temp.'<span id="'.$session_user_id.'" class="user_id hidden"></span>';
						
						?>
					</div>
					<div id="work-container">
						<div id="worked-at">
							<span id="work-label">Working at: <span id="work-place"><?php echo $profile->profile_data['working_at'];?></span></span><br>
							
						</div>
					</div>
				</div>
			</div>
			<div id="menu-container">
				<div id="menu-inner">
					<ul id="menu">
						<li>
							<a id="activity-nav" class="menu-link <?php if((isset($_GET['activity'])===true)||((empty($_GET)===true)&&($curr_dir=='index.php'))){ echo 'menu-selected';}?>" href="index.php?activity">Activity</a>
						</li>
					
						<li>
							<a id="about-nav" class="menu-link <?php if(isset($_GET['about'])===true){ echo 'menu-selected';}?>" href="index.php?about">About</a>
						</li>
					
						<?php /*if(isset($_GET['courses'])===true){
						?>
						<li>
							<a class="menu-link <?php echo 'menu-selected';}?>" href="index.php?courses">Courses</a>
						</li>
						
						<li>
							<a class="menu-link <?php if(isset($_GET['badges'])===true){ echo 'menu-selected';}?>" href="index.php?badges">Badges</a>
						</li>
						<?php
						
						*/
						?>
					</ul>
				</div>
			</div>
			<div id="dp-nav" class="dp-container">
			
					<div id="display-pic">
						<img id="profile-image" src="<?php echo $profile->profile_data['profile'];?>" alt="<?php echo substr(md5($profile->profile_data['username']),0,10).'.'.$profile->profile_data['chords'];?>"/>
					</div>

			</div>

		</div>
	</div>
	<div class="profile-lower clearfix">
		<div class="profile-activity-container lfloat">
		
			<div class="profile-activity">
				<span class="activity-label"><?php if(isset($label)){ echo $label;}else{ echo 'Welcome';} ?></span>
				<?php 
				if((isset($_GET['activity'])===true)||((empty($_GET)===true)&&($curr_dir=='index.php'))){
					include 'includes/feeds/activity-feed.php';
				}else if(isset($_GET['about'])===true){
					include 'includes/feeds/about-feed.php';
				}else if(isset($_GET['courses'])===true){
					include 'includes/feeds/course-feed.php';
				}else if(isset($_GET['badges'])===true){
					include 'includes/feeds/badge-feed.php';
				}
				?>
			</div>
				
		</div>
		
	</div>
</div>
<?php
	}//user_exist
}
}else{
	echo 'Sorry but the page you requested does not exists';
}
?>