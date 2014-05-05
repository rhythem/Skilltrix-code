<?php
include 'core/init.php';
$users->logged_in_redirect();
include 'includes/overall/header.php';
$recoverObj = new users();
?>
<script type="text/javascript">
	$(document).ready(function(){
	var code;
	var email;
		$("#continue").click(function(){
			var data = $('#feild').val();
			
			if(data == ''){
				$('.warning').html("No data received.");
				$('.warning').css('display','block');
				$('.success').css('display','none')
			}else{
				//ajax
				if($('#feild').attr('type')=='text'){
					var m ="email";
					$.ajax({
						type: "POST",
						url: "ajax/recover.php",
						data: {email: data},
						 dataType: 'json',
						success: function(message){
							if(message != ''){
								
								if(message.mode == "success"){
									$('.success').html(message.message);
									code = message.code;
									email = message.email;
									$('.success').css('display','block');
									$('.warning').css('display','none');
									$('#feild').val('');
									$('.ask').html('Please enter the 8 digit code sent to your email');
									$('#feild').attr('type','password');
									$('#feild').attr('placeholder','Password');
	        					}else if(message.mode == "fail"){
	        							$('.warning').html(message.message);
	        							$('.warning').css('display','block');
	        							$('.success').css('display','none');
										code = 0;
	        					}
							}else{
								$('.warning').html(message);
								$('.warning').css('display','block');
								$('.success').css('display','none');
								code = 0;
							}
						}
					});
				}else if(($('#feild').attr('type')=='password')){
					if($('#feild').val()==code){
						$('#feild').hide();
						$('#passcontain').show();
						$(this).hide();
					}
						
					
				}
			}
		});
		$('#save').click(function(){
			var pass = $("#pass").val();
			var repass = $("#repass").val();
			if(pass == repass){
				if(pass.length > 6){
					$.ajax({
						type: "POST",
						url: "ajax/newpass.php",
						data: {pass: pass,email: email},
						 dataType: 'json',
						success: function(message){
							if(message != ''){
								
								if(message.mode == "success"){
									$('.success').html(message.message);
									$('#passcontain').hide();
									$('.success').css('display','block');
									$('.warning').css('display','none');

	        					}else if(message.mode == "fail"){
	        							$('.warning').html(message.message);
	        							$('.warning').css('display','block');
	        							$('.success').css('display','none');
										
	        					}
							}else{
								$('.warning').html(message.message);
								$('.warning').css('display','block');
								$('.success').css('display','none');
								
							}
						}
					});
				}else{
					$('.warning').html("Password too small.");
					$('.warning').css('display','block');
					$('.success').css('display','none');
				}
			}else{
					$('.warning').html("Passwords do not match.");
					$('.warning').css('display','block');
	        		$('.success').css('display','none');
				}
			
		});
	});
	
</script>
<div class="container-top-side-margin-normal">
        <div class="recover bg-white">
                <div class="bold">
                        <span class="smaller-font head">Reset your password</span>
                </div>
                <div class="recover-container">
                	<span class="smaller-font block ask">Please enter your email id.</span>
                	<span class="warning hidden"></span>
                	<span class="success hidden"></span>
                	<span class="block"><input id="feild" type="text" placeholder="Email" class="big-text-box"></span>
                	<div id="passcontain" class="hidden">
						<span class="block"><input id="pass" type="password" placeholder="New Password" class="big-text-box"></span>
						<span class="block"><input id="repass" type="password" placeholder="Confirm Password" class="big-text-box"></span>
						<div class="clearfix">
                		<span class="block lfloat"><input type="button" class="small-ui-button" id="save" value="Save"></span>
                	</div>
					</div>
                	<div class="clearfix">
                		<span class="block lfloat"><input type="button" class="small-ui-button" id="continue" value="Continue"></span>
                	</div>
                </div>
        </div>
</div>
<?php
if (isset($_GET['success']) === true && empty($_GET['success']) === true) {
?>
	<p class="success smaller font">Thanks, we've emailed you the details.</p>
<?php
}else{
}
include 'includes/overall/footer.php';  ?>
