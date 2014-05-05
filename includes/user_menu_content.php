<?php
if(isset($_GET['c'])===true and empty($_GET['c'])===false){
	$cid=$_GET['c'];
}else{
	header('Location: index.php');
}
global $users;
$module = new users();
$submodule = new users();
$try = new users();
$try1 = new users();
$try2 = new users();
$try3 = new users();
$try4 = new users();
?>

<div id="ui-module-menu-wrap">
	<div id="module-name" class="ui-module-name menu-text lalign clearfix hidden bold700">
		<?php
			echo $users->get_course_name_from_id($cid);
		?>
	</div>
	<?php
		$a=$module->get_module($cid);
		$i=1;
				foreach ($a as $module_id){
				$name = $module->get_module_name_from_id($module_id['module_id']);
?>
	<div class="ui-module-number module-number menu-text module-number-js module-number-closed" id="module<?php echo $i;?>">
		<span class="module-number-select block center hint--right"  data-hint="<?php echo $name['module_name']; ?>">
			<span class="module-word gfont-comp bold700">
		
				<?php $name = $module->get_module_name_from_id($module_id['module_id']);

				echo $name['module_name']; ?>
		
			</span>
		        <span class="disp_num center bold700" id="nopadding"><?php echo $i;?></span>
		</span>
		<?php
				//Made a change in sid earlier it was sid=j i made it j['sub_id']
				//and u were sending $j to get submodule name changed it to sid
				//Praveer
				$mid = $module_id;
				$submodule = $try3->get_submodules_id($mid['module_id']);
			
				
				
					
					foreach($submodule as $j){
					
					if(is_array($j)){
					$sid = $j['sub_id'];
					}else{
						$sid = $j;
					}
						?>
						<a class="hint--right" data-hint="<?php echo $module->get_submodules_name($sid);?>" href="<?php echo $try1->get_module_url($cid,$mid['module_id'],$sid);?>">
							<div class="module-components">
								<span class="module-component-word bold700"><?php echo $module->get_submodules_name($sid);?> </span>
							</div>
						</a>	
			<?php
					}
			?>
	</div>
	<?php
		$i++;
		
			}
	?>
			
		
		
		
</div>

