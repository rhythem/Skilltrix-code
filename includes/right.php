<?php 
if(isset($_GET['module']) and isset($_GET['c']) and isset($_GET['sub']) and isset($_GET['comp']) and isset($_GET['exer'])){
	if(empty($_GET['module'])===false and empty($_GET['c'])===false and empty($_GET['sub'])===false and empty($_GET['comp'])===false and empty($_GET['exer'])===false){
	$link =  new users();
	$cid=$_GET['c'];
?>	
<div class="right-contain">
	<!--<div class="bar">
	
	</div>
	
	<div class="right-text">
		<span class="small-font"><span><strong>Progress</strong></span></span>
		<div class="clearfix">
			<div class="percent lfloat">
				<div class="clearfix">
					<div class="ui-stylish-circle lfloat">24</div>
					<div class="circle-text lfloat small-font">%</div>
				</div>
			</div>
			<div class="next-badge lfloat ">
				<div class="clearfix">
					<div class="circle-text line-zero lfloat">Next Badge</div>
					<div class="ui-stylish-circle lfloat"></div>					
				</div>
			</div>
		</div>
	</div>
	
	<div class="right-text">
		<span class="small-font"><span><strong>Badges</strong></span></span>
		<div class="clearfix">
			<div class="badges lfloat">
				<div class="clearfix">
					<div class="ui-stylish-circle lfloat"></div>
					<div class="ui-stylish-circle lfloat"></div>
					<div class="ui-stylish-circle lfloat"></div>
				</div>
			</div>
		</div>
	</div>
	-->

	<div class="right-text">
		<fieldset id="right-fieldset">
		<legend id="right-legend">Exercises</legend>
		<div class="clearfix">
			<div class="lesson-scroll">
				<div class="inner-content-div">
					<?php
						//$modules = $link->get_module($cid);
						//foreach($modules as $tempmod){
						//	$mid = $tempmod['module_id'];
						//	$submodule = $link->get_submodules($tempmod['module_id']);
							//foreach($submodule as $sub){
						//		$sid = $sub['sub_id'];
								/*echo '<div title="'.$sub['sub_disp_name'].'" class="lesson-text bold700"><span><strong>'.
								'<a href="'.
								$link->get_all_exercise_url($cid,$mid,$sid).
								'">'.
								$sub['sub_disp_name'].
								'</a>'.
								'</strong></span></div>';
								*/
								$temp = $link->get_all_exercise_url($cid,$_GET['module'],$_GET['sub'],$_GET['exer']);
								foreach($temp as $t){
									echo $t;
								}
 							//}				
						//}
					?>
					
					<?php

					?>
				</div>
			</div>
		</div></fieldset>
	</div>
		
</div>
<?php
}
}
?>
