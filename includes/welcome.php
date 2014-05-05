<div class="welcome-image">
	<div class="welcome cwhite clearfix" id="WelcomeContainer">
			<div class="lfloat" id="WelcomeDisplay">
				<span class="cwhite big-font bold welcome-heading">Welcome to </span>
				<div class="clearfix">
					<div class="big-font bold lfloat welcome-heading">
						<span>Skilltrix</span>
					</div>
					<!--<div class="alpha _2alpha lfloat">
						<span class="innerAlpha idisplay">&alpha;</span>
					</div>
					-->
				</div>
				<div class="intro gfont">Skilltrix provides a new way to learn, a better environment to develop and a whole new set of opportunities.</div>
					<div id="ui-layout-modal" class="clearfix">
						<!-- panel with buttons -->
						<div class="main">
							<div class="panel">
								<!--<a href="#join_form" id="join_pop">Sign up now and start learning</a>-->
							</div>
						</div>
						<!-- popup form #1 -->
						<a href="#x" class="overlay" id="join_form"></a>
						<div class="popup clearfix">
							<div class="lfloat idisplay small-font popup-msg">
							<span class="white">We are still in beta phase.</span>
							</div>
							<div id="invite-form-holder" class="invite-form-holder lfloat">
								<span class="small-font">Sign up</span>
								<div id="invite-form">
										<?php
											include 'includes/register-form.php';
										?>
								</div>
								<!--<div class="ui-button"><a href="fb.php">Login Via Facebook</a></div>-->
							</div>
						</div>
					</div>
			</div>
	<div class="lfloat signup">
	<?php
											include 'includes/register-form.php';
										?>
	</div>
	</div>

</div>
<!--
<div class="beta-button">
<div class="beta-text">
            <a href="#blog" class='cwhite link-scroll'><span class="cwhite"><img src="http://www.skilltrix.com/images/resources/arrow.png" alt="We are still in beta phase" title="We are still in beta phase."></span></a>
        </div>
</div>
-->
<div class="wwd-container">

	<div class="wwd-inner">
		<div class="outerwrap width-margin">
			<div class="row martop10 clearfix">
			<?php
				$xml = simplexml_load_file("res/xml/welcome.xml")  or die("Error: Cannot create object");
				$i=0;
				foreach($xml->children() as $wwd){
					foreach($wwd->children() as $inner => $data){

					  echo '<div class="seven m20 columns gfont auto-width"><div class="wwd"><div class="row clearfix">';
					  echo '<span class="wwd-image"><center><img src="'.$data->image.'" alt="'.$data->image.'"></center></span>';
					  echo '<span class="wwd-heading"><center>'.$data->heading.'</center></span>';
					  echo '<span class="wwd-title"><center><h3>'.$data->service.'</h3></center></span>';
					  echo "</div></div></div>";
					  $i++;

					}
	
				}
				?>
			</div>
			
		</div>
	</div>
</div>
<div class="bg-white bg-grey">
	<div id="blog" class="width-margin">
		<div class="outerwrap width-margin">
				<div class="row">
					<span class="gont">
					<h3>
						Since we are still testing and upgrading our product, so its important for us to know what you think.
	Please tell us about any bug, error, content problems and we'll get down to rectifying it at once.
	Your feedback is of prime value. So, please take some time out to <a href ="contact.php">write to us</a>.
					</h3>
					</span>
				</div>
			
			</div>

	</div>
</div>
