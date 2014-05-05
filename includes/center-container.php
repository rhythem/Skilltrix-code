<?php
global $users;
if(isset($_GET['c'])===true and empty($_GET['c'])===false and isset($_GET['module']) and isset($_GET['c']) and isset($_GET['sub']) and isset($_GET['comp']) and isset($_GET['exer'])) 
	$cid=$_GET['c'];
?>


<div id="center-container">
	<div id="center-container-wrap" class="clearfix">
		<!--Ads removed
<div id="ads" class="small-font center rad">
			Text Ads
		</div>
-->
		
		<div id="contain" class="clearfix bgw rad">
		<div class="center-module-container clearfix">
			<?php 
				include 'includes/module.php';
			?>

			<div id="ui-center-right" class="rfloat">
					<?php
						include 'includes/right.php';
					?>
			</div>
		</div>
		</div>
		
	</div>
</div>

