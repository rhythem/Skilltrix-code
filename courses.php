<?php
include 'core/init.php';
include 'includes/overall/header.php';
global $users;
$course = new users();
global $curr_dir;
global $session_user_id;
?>

<?php
if(empty($_GET)){
?>
<div class="coursepage-container">
	<div class="coursepage-inner">
		<center>
		<div class="course clearfix">
		<?php
		
			$res = $course->get_course_id();
			//echo'<pre>';
			//print_r($res);
			foreach($res as $r){
			//print_r($r);
			$image = $course->get_course_image_from_id($r['course_id']);
		?>
			<a href="courses.php?id=<?php echo $r['course_id'];?>">
				<div class="course-tile lfloat" id="<?php echo $r['course_id'];?>" <?php if(empty($image)===false){echo "style=background-image:url(".$image.")";}?>> 
					<div class="course-name-label">
						<span><?php echo $course->get_course_name_from_id($r['course_id']);?></span>
					</div>
				</div>
			</a>
		<?php
		}
		?>
		</div>
		</center>
	</div>
</div>
<?php
}else{
$id	= $_GET['id'];
$subs=$users->check_subscription($session_user_id,$id);

?>
<?php
	if($subs==true){
		include 'includes/course-intro.php';
	}else if($subs==false){
		include 'includes/course-index.php';
	}else{
		header('Location: index.php');
	}
?>

<?php
}
include 'includes/overall/footer.php';
?>













