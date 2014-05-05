<?php
//dinclude 'core/init.php';
/*s3 includes*/
/*************************/
global $users;
global $session_user_id;
global $curr_dir;
$cover_class =false;
$var = substr(md5('tour'),0,10);
$tour=false;
if(isset($_GET['tour'])===true and empty($_GET['tour'])===false){
	if($_GET['tour'] == $var) $tour=true;
}
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

	$(document).ready(function(){
				
				var chords = $('#profile-image').attr('alt').split(".");
				if(chords[1]!=''){
					chords = chords[1].split("-");
					var x1=chords[0];
					var y1=chords[1];
					if(x1!=0 || y1!=0){
						var scaleX = 0.8;
						var scaleY = 1.06;
						$('#profile-image').css({
							width: Math.round(scaleX * 400) + 'px',
							height: Math.round(scaleY * 300) + 'px',
							marginLeft: -Math.round(scaleX * x1) + 'px',	
							marginTop: -Math.round(scaleY * y1) + 'px'	
						});
					}else if(x1==0 && y1==0){
						$('#profile-image').css({
							width: 160 + 'px',
							height: 160 + 'px',
							marginLeft: 0 + 'px',	
							marginTop: 0 + 'px'	
						});
					}
					
			}else{
				$('#profile-image').css({
						width: 100+'%',
						height: 100+'%'	
					});

			}
<?php
if($tour===false){
?>
	$('#cover').hover(function(){
        $('.upload-cover').toggle();
	});
<?php
}
?>
	$('#display-pic').hover(function(){
		$('.change').toggle();

	});

		$('#about-you-content').css('display','inline');
		$('#about-you-content').click(function(){
			$(this).addClass('ajax');  
			$(this).html('<input id="editbox" type="text" value="' + $(this).text()+'">');                                         
			$('#editbox').focus();  
			$('#about-you-content #editbox').blur(function(){

				var a = $(this).val();
				var id = $('.user_id').attr('id');
				if(a!=''){
				$.ajax({
						type: "POST",
						url: "ajax/changeabout.php",
						data: {say: a,id: id},
						success: function(message){
							if(message != ''){
								 var time = 100;
								 $('#about-you-content').css('color','green');
									setTimeout(function(){
									$('#about-you-content').animate({color: '#000000'}, 'slow');}, 1000);
									$('#about-you-content').html(a);
									if($('#about-you-content').attr('data-hint')=='Say something'){
										$('#about-you-content').attr('data-hint','Click to say something');
										$('#about-you-content').attr('class','hint--right');
									}
							}else{
								$('#about-you-content').html(a);
							}
						}
					});
					}
				
			});  
		}); 
		
		$('#tour_start').click(function(){
			var code = <?php echo $session_user_id;?>;
			var resp = $.ajax({
					type: "POST",
					url: "ajax/disabletour.php",
					data: {code: code},
					dataType: 'text',
					success: function(message){
						if(message != ""){
							window.location = "index.php?tour=f0a4025b3b"
						}
					}
			});
		});
	});
</script>

<div>
<?php
if($users->user_data['tour']==1 and $tour==false){
?>
	<div class="tour_message_container">
		<div class="tour_inner clearfix">
			<div class="tour_wrap">
				<span class="bold">
					<h3>Welcome to Skilltrix. We recommend you take a tour of Skilltrix now.</h3>
				</span>
					<div class="clearfix">
						<button id="tour_start" class="ui-button rfloat">
							Start Tour
						</button>
					</div>
			</div>
		</div>
	</div>
<?php
}else{
	$cover_class=true;
}
?>
</div>

<div class="profile-container">
	<div class="profile-inner">
		<div id="Profile">
			<div class="cover-container" <?php if($cover_class and $tour===false ) echo 'id="margint85"';?>>
				<div class="cover-inner">
					<div id="cover">
						<?php if(isset($users->user_data['cover']) and empty($users->user_data['cover'])===false){ echo '<img src="'.$users->user_data['cover'].'">'; }?>
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
						if(empty($users->user_data['something'])===true){
							$temp = '<span id="about-you-content" data-hint="Say something" class="hint--always hint--right">Say something about yourself</span>';
						}else{
							$temp = '<span id="about-you-content" data-hint="Click to say something" class="hint--right">'.$users->user_data['something'].'</span>';
						}
						echo $temp.'<span id="'.$session_user_id.'" class="user_id hidden"></span>';
						
						?>
					</div>
					<div id="work-container">
						<div id="worked-at">
							<span id="work-label">Working at: <span id="work-place"><?php echo $users->user_data['working_at'];?></span></span><br>
							
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
			
				<a href="image.php?t=profile">
					<div id="display-pic">
						<div class="change"><span>Change</span></div>
						<img id="profile-image" src="<?php echo $users->user_data['profile'];?>" alt="<?php echo substr(md5($users->user_data['username']),0,10).'.'.$users->user_data['chords'];?>"/>
					</div>
				</a>
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
