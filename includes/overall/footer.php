</div>	<!-- Main container cclosing div-->
		
<?php
global $users;
global $curr_dir;
global $session_user_id;
if($users->logged_in()===false){
?>
<div id="FooterContainer" class="palegreen">
	<div class="connect">
		<div class="outerwrap fullpadding-25 clearfix">

		  <div class="row">
			<div class="twelve columns">
                                <div class="stayConnected">
	<div class="links">
	<p>Connect with us.</p>
		<a href="http://www.facebook.com/skilltrix" class="facebook" target="_blank"></a>
		<a href="http://www.linkedin.com/company/skilltrix" class="linkedIn" target="_blank"></a>
		<a href="http://www.twitter.com/Skilltrixdotcom" class="twitter" target="_blank"></a>
	</div>
</div>
				

			</div>
		  </div>

		</div>


	</div>
	
	
	
	<div class="outerwrap darkgrey clearfix">

  <footer class="row clearfix">
    <div class="twelve columns">
      <div class="row clearfix">

        <div class="ten columns">
			<ul id="menu-footer-menu" class="link-list">
				<li><a href="index.php">Skilltrix</a></li>
				<li><a href="our-story.php">Our Story</a></li>
				<li><a href="contact.php">Contact Us</a></li>
			</ul>     
		</div>

        <div class="two rfloat">
          &copy; Skilltrix 2013
        </div>

      </div>
    </div>
  </footer>
</div>
</div>
	<?php
	}else if($curr_dir != 'course.php'){
?>
<div class="outerwrap darkgrey clearfix">

  <footer class="row clearfix">
    <div class="twelve columns">
      <div class="row clearfix">

        <div class="ten columns">
			<ul id="menu-footer-menu" class="link-list">
				<li><a href="http://www.skilltrix.com">Skilltrix</a></li>
				<li id="ourstory-nav"><a href="our-story.php">Our Story</a></li>
				<li id="contact-nav"><a href="contact.php">Contact Us</a></li>
			</ul>     
		</div>

        <div class="two rfloat">
          &copy; Skilltrix 2013
        </div>

      </div>
    </div>
  </footer>
</div>
<?php

	}
	?>
	

</div>
</div>
</div>
<?php
if($users->logged_in()===true and $curr_dir == "index.php"){
?>
<?php
	if(isset($_GET['tour'])===true and empty($_GET['tour'])===false){
	if($_GET['tour']=='f0a4025b3b'){
?>
		<ol id="joyRideTipContent">
			<li data-id="MenuButton-nav" data-button="Next" data-options="tipLocation:bottom;tipAnimation:fade">
				<h2>Control Menu</h2>
				<p>Click on your name to open the profile menu options.</p>
				<p>Select among the options to navigate through the profile options.</p>
			</li>
			<li data-id="dp-nav" data-button="Next" data-options="tipLocation:top;tipAnimation:fade">
				<h2>Profile Picture</h2>
				<p>You can upload a new profile picture by clicking your profile picture and following the steps on the next page.</p>
			</li>
			<li data-id="cover-nav" data-button="Next" data-options="tipLocation:bottom;tipAnimation:fade">
				<h2>Cover Picture</h2>
				<p>Beuatify your profile with a cover picture.</p>
				<p>Hover on the cover image and change the cover picture</p>
			</li>
			<li data-id="about-you-content" data-button="Next" data-options="tipLocation:bottom;tipAnimation:fade">
				<h2>Start with shouting out something on your profile</h2>
				<p>Click on the text and shout something out new every time</p>
			</li>
			<li data-id="activity-nav" data-button="Next" data-options="tipLocation:bottom;tipAnimation:fade">
				<h2>Your Activities</h2>
				<p>Select activities on your homepage and view the past ten activities that you made on Skilltrix.</p>
				<p>Activities are your most recent activies on Skilltrix, they may b social activity or may be activities related to coursse.</p>
			</li>
			<li data-id="about-nav" data-button="Next" data-options="tipLocation:bottom;tipAnimation:fade">
				<h2>Your Personel Details</h2>
				<p>About tab describes personel, professional, Contact and other general details about you.</p>
				<p>Click to change your details.</p>
			</li>
			<li data-id="course-nav" data-button="Next" data-options="tipLocation:bottom;tipAnimation:fade">
				<h2>Courses</h2>
				<p>Land on the course selection page using this link at the op of the page.</p>
				<p>This page is the navigational door to all the course related content on Skilltrix</p>
			</li>
			<li data-id="ourstory-nav" data-button="Next" data-options="tipLocation:top;tipAnimation:fade">
				<h2>Our Story</h2>
				<p>Get to know about who we are, what is our vision and what we aim for.</p>
			</li>
			<li data-id="contact-nav" data-button="Next" data-options="tipLocation:top;tipAnimation:fade">
				<h2>Contact Us</h2>
				<p>Still got some queries? Feel free to contact is anytime.</p>
			</li>
		</ol>
		<!-- Run the plugin -->
		<script type="text/javascript" src="script/jquery.cookie.js"></script>
		<script type="text/javascript" src="script/modernizr.mq.js"></script>
		<script type="text/javascript" src="script/jquery.joyride-2.1.js"></script>
		<script>
			$(window).load(function() {
				$('#joyRideTipContent').joyride({
					preRideCallback: function(){
						$('.upload-cover').css('display','block');
						$('.container-top-side-margin-normal').css('margin-top','0px');
						
					},
					autoStart : <?php echo $tour;?>,
					postRideCallback: function(){
					window.location = 'http://www.skilltrix.com'
					},
					modal:true,
					'scrollSpeed': 600,  
				});
			});
		</script>
<?php
	}
}
?>
    
<?php
}
?>
</body>
</html>
