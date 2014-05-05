<?php
global $users;
global $session_user_id;
$modules = new users();
$cid = $_GET['id'];
$text='';

$name = $modules->get_course_name_from_id($cid);
$image = $modules->get_course_image_from_id($cid);
?>
<div class="course-index-container">
	<div class="course-index clearfix">
	
		<div class="course-index-left lfloat">
			<div class="inners course-header padding20 clearfix bg-white">
				<div class="course-image lfloat" >
					<?php if(empty($image)===false){echo '<img src="'.$image.'" title="'.$name.'" >';}?>
				</div>
				<div class="course-header-info lfloat">
					<span class="name"><?php echo $name;?></span>
					<div class="course-by">
						<span class="lightgray small-font"><?php echo $course->get_author($id); ?></span>
					</div>
				</div>
				<div class="start-course rfloat">
					<a class="ui-button" href="course.php?c=<?php echo $id;?>">Resume</a>
				</div>

			</div>
			<div class="inners">
				<?php 
							$a=$modules->get_module($cid);
							foreach($a as $module){
				?>
				<div class="heading marginb20 bg-white">
					<div class="content ocontent">
						<?php
							$total_exercises =  $modules->count_total_exercise_in_module($cid,$module['module_id']);
						
							$percent = $modules->get_module_percent($cid,$module['module_id'],$total_exercises,$session_user_id);
							if($percent>0){
								$text = 'Resume';
							}else{
								$text = 'Start';
							}
							$abs_percent_temp 	= explode('.',$percent);
							
							if(isset($abs_percent_temp[1])){
								$abs_percent 		= $abs_percent_temp[0];
							
								$abs_percent_temp2	= explode('%',$abs_percent_temp[1]);
								$abs_percent_float	= $abs_percent_temp2[0];
								if($abs_percent_float > 0.5){
									$abs_percent++;
									$abs_percent .='%';
								}else{
									$abs_percent .='%';
								}
							}else{
								$abs_percent  = $abs_percent_temp[0];
							}
							$temp_prog = explode('%',$abs_percent);
							$progress = $temp_prog[0];
							$name = $modules->get_module_name_from_id($module['module_id']);
								echo '<div class="heading padding20 marginb20 clearfix ohead"><span class="font25 module_name_index lfloat">'.$name['module_name'].'</span>'.
									'<div class="head_text">'.
										'<span class="paddingleft5 bold smaller-font border- rfloat">'.$modules->count_total_exercise_in_module($cid,$module['module_id']).' Exercise'.'</span>'.
										'<span class="paddingright5 bold smaller-font border-right rfloat">'.$modules->count_submodules($cid,$module['module_id']).' Sub Modules'.'</span>'.
									'</div>'.
								'</div>';
					
								echo '<div class="content heading padding20 small-font clearfix odesc">'.
										'<div class="content marginb20">'.$modules->get_module_desc_from_id($module['module_id']).'</div>'.
									'</div>';
									
								echo '<div class="padding20 clearfix oprogress">'.
										'<div class="bar iblock lfloat"><div class="progressbar" value="'.$progress.'"><div id="progress-label">'.$abs_percent.'</div></div></div>'.
										'<div class="navigation-button rfloat">'.
											'<a class="ui-button" href="course.php?c='.$id.$modules->link_first_exercise($module['module_id']).'">'.$text.'</a>'.
										'</div>'.
									'</div>';
							?>
						
					</div>
				</div>
				<?php	}
						?>
			</div>
		</div>
		<div class="course-index-right lfloat">
			<div class="practice">
				<div class="block heading small-font marginb20 bg-white">
					<div class="content font25">
						<div class="heading padding20 marginb20 clearfix">
							Practice Area
						</div>
						<div class="content padding20 small-font clearfix">
							<a href="practice.php" class="ui-button">Practice</a>
						</div>
					</div>
				</div>
			</div>
			<div class="feedback">
				<div class="block heading small-font marginb20 bg-white">
					<div class="content font25">
						<div class="heading padding20 marginb20 clearfix">
							Send us a Feedback
						</div>
						<div class="content padding20 small-font clearfix">
							<a href="contact.php" class="ui-button">Feedback</a>
						</div>
					</div>
				</div>
			</div>
			<div class="subscribers">
				<div class="block heading small-font marginb20 bg-white">
					<div class="content font25">
						<div class="heading padding20 marginb20 clearfix">
							Recent Subscribers
						</div>
						<div class="content padding20 small-font clearfix">
							<?php
								print_r($modules->get_subscribers($cid));
							?>

						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
		
	</div>
</div>
   <script type="text/javascript">
 $(document).ready(function(){
	$("div.progressbar").each (function () {
		var element = this;
		$(element).progressbar({
			value: parseInt($(element).attr("value"))
		});
	});
});
 
  </script>
 
 