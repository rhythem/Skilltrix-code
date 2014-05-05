<?php
$id = $_GET['id'];
$name = $course->get_course_name_from_id($id);
if(isset($_GET['subs'])===true){
	$subs = $_GET['subs'];
	}else{
		$subs=1;
	
	}
global $session_user_id;
$subs = new users();
$image = $subs->get_course_image_from_id($id);
?>
<script type="text/javascript">
	function subscribe(){
		var id = $('#subscribe_button').attr('data');
		if(id!=''){
			$.ajax({
			type: "POST",
			data:{id:id},
			dataType : 'json',
			url:"subscribe.php",
			success:function(result){
				if(result.message=="pass"){
				
					location.reload()
				}else if(result.message=="fail"){
					$("#subs-error").show();
				}
			}
			});
		}else{
			$("#subs-error").show();
		}
	}
</script>
<div class="course-index-container">
	<div class="course-index clearfix">
		
		<div class="course-index-left lfloat">
			<div class="inners course-header padding20 bg-white clearfix">
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
				<?php
					if($subs->check_subscription($session_user_id,$id)===true){
				?>
					<?php 
					$a = substr(md5($id),5,19).$id.'.'.substr(md5($session_user_id),0,20);
					echo '<div id="subs-error" class="hidden error-container">There was some error. Please try again later.</div><button id="subscribe_button" data="'.$a.'" class="ui-button" onClick="subscribe()">Subscribe</button>'; ?>
				<?php
				}else{
					echo '<a class="ui-button" href="course.php?c='.substr(md5($id),5,19).'">Resume course</a>';
				}
				?>
				</div>
				
			</div>
			<div class="inners course-description bg-white">
				<div id="desc" class="gfont font30 block heading padding20">Description</div>
				<div class="inners smaller-font content padding20"><?php echo $course->get_description($id);?></div>
			</div>
			<?php
			
			?>
			<div class="inners module-info bg-white">
				<div id="desc" class="heading padding20 gfont font30 osynopsis">Course Synopsis</div>
				<div class="gfont osyncontainer">
					<?php
					$a=$course->get_module($id);
					$name='';
					
					foreach ($a as $module_id){
					$name = $course->get_module_name_from_id($module_id['module_id']);
									
						$output =  '<div class="heading padding20 border-bottom module-holder"><span class="module-name gfont bold small-font">'.$name['module_name'].'</span>';
						$output .= '<div class="module-description"><span class="smaller-font">'.$course->get_module_desc_from_id($module_id['module_id']).'</span></div>';
						$mid = $module_id;
						
						/*
						$submodule = $course->get_submodules_id($mid['module_id']);
							foreach($submodule as $j){
								$sid = $j;
								$output .= '<div class="submodule-holder"><span class="submodule-name">'.$course->get_submodules_name($j['sub_id']).'</span></div>';
							}
						*/
							$output .= '</div>';
					echo $output;
					}
					
					?>
				</div>
			</div>
			<?php
			
			?>
		</div>

	<div class="course-index-right rfloat">
		<div class="at-a-glance bg-white marginb20">
			<div class="block heading small-font bg-white">
				<div class="content font25">
					<div class="heading padding20 marginb20 clearfix  ohead">
						At a glance
					</div>
					<div class="content small-font clearfix">
						<div class="at-a-glance-list">
							<span><?php echo $course->count_total_module_in_course($id);?></span>
							<span> Modules</span>
						</div>
						<div class="at-a-glance-list">
							<span><?php echo $course->count_total_exercise_in_course($id);?></span>
							<span> Exercises</span>
						</div>
						
					</div>
				</div>
			</div>
		</div>
		<div class="subscribers bg-white marginb20">
			<div class="block heading small-font bg-white">
				<div class="content font25">
					<div class="heading padding20 marginb20 clearfix">
						Recent Subscribers
					</div>
					<div class="content padding20 small-font clearfix">
						<?php
							print_r($course->get_subscribers($id));
						?>

					</div>
				</div>
			</div>
		</div>
		<div class="feedback bg-white marginb20">
			<div class="block heading small-font bg-white">
				<div class="content font25">
					<div class="heading padding20 clearfix">
						Send us a Feedback
					</div>
					<div class="content padding20 small-font clearfix ofeed-cont">
						<a href="contact.php" class="ui-button">Feedback</a>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	
</div>
