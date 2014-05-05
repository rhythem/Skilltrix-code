<?php
global $users;

?>
<?php
if((isset($_GET['c'])===true and empty($_GET['c'])===false and $users->course_exists($_GET['c'])===true)){
	if(isset($_GET['module'])===false and isset($_GET['c'])===false and isset($_GET['sub'])===false and isset($_GET['comp'])===false and isset($_GET['exer'])===false){


	}
?>
<div id="ui-center-module" class="lfloat">
	<?php 
	if(isset($_GET['module']) && isset($_GET['comp']) &&isset($_GET['sub']) && isset($_GET['c']) ) {
		if(empty($_GET['module'])===false and empty($_GET['c'])===false and empty($_GET['sub'])===false and empty($_GET['comp'])===false and empty($_GET['exer'])===false){
		/*if( $users->module_exists($_GET['module'],$_GET['c'])===false or $users->submodule_exists($_GET['sub'])===false or $users->exercise_exists($_GET['comp'])===false){
				header('Location: index.php');
		}*/
	?>

	<div id="module-name">

		<?php
			$name = $users->get_module_name_from_id($_GET['module']);
			echo '<div class="breadcrumb smaller-font">'.$users->get_course_name_from_id($_GET['c']).' > '.$name['module_name'].' > '.$users->get_submodules_name($_GET['sub']).'</div>';
			 echo '<div class="exercise-name small-font bold">'.$users->get_exercise_name($_GET['exer']).'</div>';
			 } 
			}else if($users->has_access($users->user_data['user_id'],1)===false){
				echo '<div class="small-font  bold700">Welcome. Please choose a module</div>'; 
		}?>

	</div>
	<?php 
	if(isset($_GET['module']) and isset($_GET['c']) and isset($_GET['sub']) and isset($_GET['comp']) and isset($_GET['exer'])){
		if(empty($_GET['module'])===false and empty($_GET['c'])===false and empty($_GET['sub'])===false and empty($_GET['comp'])===false and empty($_GET['exer'])===false){
	$module	= $_GET['module'];
	$comp	= $_GET['comp'];
	$c		= $_GET['c'];
	$exer	= $_GET['exer'];
	$sub	= $_GET['sub'];
	//$e = $users->get_exercise($module,$comp);
	?>				
	<div id="ui-center-module-container">
		<div id="module-question-container">
			<div id="module-question" class="small-font"><?php echo $users->get_question_from_exercise_id($exer);?></div>
			<div id="question" class="small-font" >
				<?php
					/*echo '<span id="consolas">This is where the code for the program goes</span>';*/
					
				?>
			</div>
		</div>
<div id="compiler-outer-container">
		<div id="compiler-container">
			<?php
			require_once("includes/compiler.php");
			$exp = $users->get_explanation_from_exercise_id($exer);
			$exp = $exp.'<a class="rfloat" href="'.$users->get_next_exercise_url($c,$module,$sub,$comp).'" title="Proceed to next excercise"><div class="small-ui-button">Next</div></a>';
			?>
		</div>
		<div id="button-container">
<button id="th_up" onclick="thumb(this)"><img src="includes/thu_up.png"/></button>
			<button id="th_down" onclick="thumb(this)"><img src="includes/thu_dn.png"/></button>
<button onclick="callit()" name="submit" class="new-rfloat-button">Run</button>
			<button onclick="location.reload()" class="new-rfloat-button">Reset</button>
			<!--<div class="lfloat small-font" id="votes">
			<?php
			
			?>
			</div>-->
			<button id="report" class="new-rfloat-button" onclick="disp_frm()">Report This Problem!</button>
			 <!-- <div id="ui-layout-modal" class="clearfix">
                                               panel with buttons 
                                                <div class="main">
                                                        <div class="panel">
                                                                <a href="#join_form" id="join_pop">Sign Up</a>
                                                        </div>
                                                </div>
                                                 popup form #1
                                                <a href="#x" class="overlay" id="join_form"></a>
                                                <div class="popup clearfix">
                                                        <div class="lfloat idisplay small-font bold popup-msg">
                                                        Send a Report For This Excercise
                                                        </div>
                                                        <div id="invite-form-holder" class="invite-form-holder lfloat">
                                                                
                                                                <div id="invite-form">
                                                                        <ul>
                                                                        
                                                                                <li><textarea rows="10" cols="30" id="frm1"></textarea></li>
                                                                                <li><button onclick="send_rep()" class="new-rfloat-button">Submit</button></li>
                                                                        
                                                                        </ul>
                                                                </div>
                                                        </div>
                                                </div>
                                        </div>-->
			<div id="re_frm">Problem You Found in Question<textarea rows="10" cols="30" id="frm1"></textarea><button onclick="send_rep()" class="new-rfloat-button">Submit</button></div>
		</div>	
		<div id="explanation" class="explanation"><div id="explanationContent" class="clearfix">
			<span class="expl-cls">Explanation Box</span>
			<?php
			echo $exp;
			
			
			?>
		</div></div>
</div>
	<?php }
	} ?>

</div></div>
<?php
}else{
	header('Location: index.php');
}
?>

