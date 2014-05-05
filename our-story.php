<?php
$vartitle="Our Story";
include 'core/init.php';
include 'includes/overall/header.php';
global $users;

?>

<div class="story-container">
	<div class="about-inner">
		<div class="our-story">
			<div class="row nopad about-heading">
				Our Story
			</div>
		</div>
	<div class="story-block-1">
		<div class="story-title">Problem
		</div>
		<div class="story-content">Even though many efforts have been made to simplify education, but the need to do so never ends and students are always looking for newer avenues. Though there are the ever available books to help us out, but in this century we need something more compatible with our techno-culture.
			<div class="story-highlight">
			Every sector of life screams technology lets implement it to the thing that created it(education).
			</div>
		</div>
	</div>
	<div class="story-block-2">
		<div class="story-title">Our Solution
		</div>
			<div class="story-content">Easy to learn,simple to understand and using technology in a way that it revolutionizes the notion of education is the vision of SKILLTRIX.<p>
Skilltrix is all about learning and skill development. Skilltrix brings you courses which help you fine-tune yourself and upgrade your skills. We not only offer you courses but a whole system where you can track your progress, interact with peers and compare your progress with your friends and other users.</p>
			<div class="story-highlight">
			We understand how valuable one's time is, that is why we try to take very less of it.
			</div>
		</div>
	</div>
	<div class="story-block-3">
		<div class="story-title">The Team
		</div>
		<div class="story-content">We are a bunch of experimentalists and visionaries. We work hard to bring to you skilltrix in the hope of changing and betterment of the way you learn.
<div class="story-highlight">We feel that given the right tools and resources, a person can create whatever he wants to, but it is his skills that set him a class apart.</div>
		</div>
	</div>
	<div class="start-learning">
		<div class="title"><div class="text">So what are you waiting for?</div>
		
		<?php
		if($users->logged_in()===false){
			$href="http://www.skilltrix.com";
		}else{
			$href="http://www.skilltrix.com/courses.php";
		}
		echo '<a href="'.$href.'">Start Learning</a>';
		?>
			
</div>
		</div>
	</div>
</div>
<?php
	include 'includes/overall/footer.php';
?>

