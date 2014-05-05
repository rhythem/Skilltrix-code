<?php
include 'core/init.php';
/*s3 includes*/
require 'vendor/autoload.php';

/*************************/
include 'includes/overall/header.php';
echo '<link rel="stylesheet" type="text/css" href="css/imgareaselect-default.css" />'.
 '<script type="text/javascript" src="script/jquery.imgareaselect.pack.js"></script>';

global $users;
if(isset($_GET['t']) and empty($_GET['t'])===false){
	$type=$_GET['t'];
	if($type=='profile' || $type=='cover'){
		if($type=='profile'){
?>

			<script type="text/javascript">
			$(document).ready(function(){

			$("#image").change(function(){
				readURL(this);
			});
			function preview(img,selection){
				$('#changed-image').attr('src',$('#preview').attr('src'));
				var scaleX = 160 / (selection.width || 1);
				var scaleY = 160 / (selection.height || 1);
				$('#header-change-image-text').hide();
				$('#changed-image').css({
					width: Math.round(scaleX * 400) + 'px',
					height: Math.round(scaleY * 300) + 'px',
					marginLeft: -Math.round(scaleX * selection.x1) + 'px',	
					marginTop: -Math.round(scaleY * selection.y1) + 'px'	
				});
				$('input[name="x1"]').val(selection.x1);
				$('input[name="y1"]').val(selection.y1);
				$('input[name="width"]').val(selection.width);
				$('input[name="height"]').val(selection.height);
			}
			function readURL(input) {

				if (input.files && input.files[0]) {
					var reader = new FileReader();

					reader.onload = function (e) {
					   $('#preview').attr('src', e.target.result);
					   $('#preview').css('width','400px');
					   $('#preview').css('height','300px');
					   var a = '<div id="changed-image-preview"><img id="changed-image" src="'+e.target.result+'"></div>';
					   $('#header-change-image-text').show();
					   $('#change-image').html(a);
					   $('#changed-image').css({
						width: Math.round(0.8 * 400) + 'px',
						height: Math.round(1.06 * 300) + 'px'
						});

					   $('img#preview').imgAreaSelect({
						aspectRatio: '1:1',
						x1:0,
						y1:0,
						x2:200,
						y2:150,
						persistent:true,
						resizable:false,
						onSelectEnd: preview,
						});
						
					}

					reader.readAsDataURL(input.files[0]);

				
				}
			}
			});
			</script>
<?php
}else{
?>
<script type="text/javascript">
	$(document).ready(function(){
		$("#image").change(function(){
			readURL(this);
		});
		function readURL(input) {

				if (input.files && input.files[0]) {
					var reader = new FileReader();

					reader.onload = function (e) {
					   $('#preview').attr('src', e.target.result);
					   $('#preview').css('height',height+'%');
					}

					reader.readAsDataURL(input.files[0]);

				
				}
			}
	});
</script>
<?php
}
?>

<div class="image-upload-container martop10">
	<div class="inner">
		<div class="head"><span class="gfont smaller-font">Update your <?php echo $type;?> photo.</span></div>
		<div><span>Please upload a new <?php echo $type;?> image</span></div>
		<ul class="clearfix">
		
			<li class="lfloat change-image">
					<img id="preview" src="<?php echo $users->user_data[$type];?>" alt="<?php echo $users->user_data['first_name'].' '.$users->user_data['last_name'];?>">
			</li>
			<li class="lfloat">
					<?php
						if (isset($_FILES['profile']) === true) {
							if (empty($_FILES['profile']['name']) === true) {
								echo '<div class="error-container smaller-font"><span class="block error">Please Choose a file.</span></div>';
							} else {

								$allowed = array ('jpg','jpeg','png');
								
								$file_name = $_FILES['profile']['name'];
								if(isset($file_name)){
									$temp = explode('.',$file_name);
									$length = count($temp);
									
									$temp = strtolower($temp[$length-1]);
									$file_extn = $temp;
								}
								$file_temp = $_FILES['profile']['tmp_name'];
								$x1 	= $_POST['x1'];
								$y1 	= $_POST['y1'];
								if (in_array($file_extn,$allowed) === true) {
										//upload file
										list($width, $height, $type_of_file, $attr) = getimagesize($file_temp);
										if($users->change_image($session_user_id, $file_temp, $file_extn,$type,$x1,$y1,$width,$height)){
											header('Location: index.php');
											exit();
										}else{
											echo '<div class="error-container smaller-font"><span class="error">There was some error please try again.</span></div>';
										}
								} else if(($_FILES['profile']['size']>=524288)||($_FILES['profile']['size']==0)){
									echo '<div class="error-container smaller-font"><span class="error">Maximum image size allowed is 256 Kilo bytes.Please choose a smaller image.</span></div>';

								}else {
									echo '<div class="error-container smaller-font"><span class="block error">Incorrect file type.</span>'.'<span class="error block">Allowed:';
									echo '<b>'.strtoupper(implode(' , ',$allowed)).'</b> ';
									echo '</span></div>';
								}
							}
						}
					?>	
		<form action="" method="post" enctype="multipart/form-data">
				<div id="PicUploadButton">
					<input type="file" id="image" name="profile">
					<input type="submit">
				</div>
				<input type="hidden" name="x1" value="" />
				<input type="hidden" name="y1" value="" />
				<input type="hidden" name="width" value="" />
				<input type="hidden" name="height" value="" />
				<div id="header-change-image-text" class="error-container hidden">Please crop your image</div>
				<div id="change-image"></div>
			
				</form>
			</li>
		</ul>

	</div>
</div>
<?php
}else{
	$image->errors[] = '<span class="error">Some error occored. Please try again.</span>';
}
}else{
	header("Location: index.php");
}
include 'includes/overall/footer.php';
?>
