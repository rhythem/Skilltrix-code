<?php
$vartitle="Contact Us";
        include 'core/init.php';
        include 'includes/overall/header.php';
        global $users;
?>
	<style>
	/*reset browser styles */
html, body, div, span, object, iframe, h1, h2, h3, h4, h5, h6, p, blockquote, pre, a, abbr, acronym, address, big, cite, code, del, dfn, em, img, ins, kbd, q, s, samp,small, strike, strong, sub, sup, tt, var, b, u, i, center, dl, dt, dd, ol, ul, li, fieldset, form, label, legend,
table, caption, tbody, tfoot, thead, tr, th, td, article, aside, canvas, details, embed, 
figure, figcaption, footer, header, hgroup, menu, nav, output, ruby, section, summary,
time, mark, audio, video {
	margin: 0;
	padding: 0;
	border: 0;
	font-size: 100%;
	vertical-align: baseline;
}
article, aside, details, figcaption, figure, footer, header, hgroup, menu, nav, section {
	display: block;
}
body {
	line-height: 1.2;
}
ol { 
	padding-left: 1.4em;
	list-style: decimal;
}
ul {
	padding-left: 0;
	list-style: none;
}
table {
	border-collapse: collapse;
	border-spacing: 0;
} 
/* end reset browser styles */
.outer-container{
min-height:760px;
}
	.topText{
		max-width: 100%;
		background-color: #ededf0;
		min-height: 125px;
		padding-top: 72px;
	}
	.topText h1{
		margin: 0 auto 0 auto;
		text-align: left;
		max-width: 981px;
		font-size: 46px;
		font-family: Lato, sans-serif;
		font-weight: 900;
	}
	.outer-container{
	        background-color: #ffffff;
	}
	.contactUsArea{
		
		width: 981px;
		margin:0 auto;
		padding:30px;
	}
	.contactUsContent{
		margin: 0 auto 36px auto;
		text-align: left;
		max-width: 981px;
		font-family: "Source Sans Pro", sans-serif;
		font-weight: 400;
		font-size: 20px;
		padding-top: 36px;
	}
	.contactUsContent h2{
		font-family: Lato, sans-serif;
		font-size: 24px;
		font-weight: 700;
	}
	fieldset{
		border-left: 3px solid #ededf0;

	}
	.emailid{
	text-decoration:none;
	display:inline-block;
	border-bottom:1px solid black;
		
	}
	.emailid:hover{
		background-color: grey;
	}
	.contactUsContent p{
		margin-top: 18px;
		font-size:	22px;
	}
	form.contact-form{
		max-width: 981px;
		margin: 50px auto 50px auto;
	}
	legend{
		font-family: "Lato", sans-serif;
		font-weight: 700;
		font-size: 24px;
	}
	fieldset{
		padding: 20px;
		max-width: 580;
		margin-left: 0;
	}
	.label{
	font-family: "Lato", sans-serif;
	display: inline-block;
	width: 70px;
	font-size:18px;
	vertical-align: top;
	text-align: right;
	margin-right: 10px;
	margin-top: 15px;
	font-weight: 700;
	}
	form.contact-form input[type="text"], form.contact-form textarea{
	font-family: "Source Sans Pro", sans-serif;
	font-size: 400;
	border-radius: 5px;
	border: 1px solid #ccc;
	background-color: #f7f7f7;
	color: black;
	font-size: 22px;
	width: 420px;
	padding: 10px;
	margin-bottom: 5px;
	margin-top: 5px;
	}
	form.contact-form input[type="text"]:focus, form.contact-form textarea:focus{
		background-color: white;
	}
	form.contact-form input[type="radio"]{
		color: black;
		margin-top: 18px;
		margin-bottom: 18px;

	}
	.submitButton{
		font-family: "Lato",sans-serif;
		font-weight: 700;
		margin-top: 10px;
		margin-left: 370px;
		padding: 10px 25px;
		border-radius: 3px;
		color: white;
		background-color: #4d90fe;
		border: 1px solid #3079ed;
	}
	.submitButton:hover{
		background-color: #4787ed;
	}
	label{
		font-family: "Lato", sans-serif;
		font-size: 18px;
		font-weight: 700;
	}
	.footer{
		background-color: #ededf0;
	}
	.stayConnected{
		margin-right: auto;
		margin-left: auto;
		max-width: 981px;
		min-height: 100px;
		font-family: "Lato",sans-serif;
		font-weight: 700;
	}
	.links{
		padding-top: 26px;
	}
	.links p{
		padding-top: 14px; 
		float: left;
		font-size: 22px;
		margin-right: 20px;
	}
	.links .facebook{
		background-image: url(/images/facebook-hover.png);
		height: 48px;
		width: 48px;
		display: block;
		float: left;
		margin: 0 10px 0 10px;
	}
	.links .facebook:hover{
		background-image: url(/images/facebook-hover.png);
		background-position: 0 -48px;
		height: 48px;
		width: 48px;

	}
	.links .linkedIn{
		background-image: url(/images/linkedin-hover.png);
		height: 48px;
		width: 48px;
		display: block;
		float: left;
		margin: 0 10px 0 10px;
	}
	.links .linkedIn:hover{
		background-image: url(/images/linkedin-hover.png);
		background-position: 0 -48px;
		height: 48px;
		width: 48px;

	}
	.links .twitter{
		background-image: url(/images/twitter-hover.png);
		height: 48px;
		width: 48px;
		display: block;
		float: left;
		margin: 0 10px 0 10px;
		
	}
	.links .twitter:hover{
		background-image: url(/images/twitter-hover.png);
		background-position: 0 -48px;
		height: 48px;
		width: 48px;

	}
	</style>
	<div class="topText">
		<h1>Contact Us</h1>
	</div>
	<div class="outer-container">
	<div class="contactUsArea">
	<div class="contactUsContent">
			<p>Feel free to contact us at anytime. Mail us at <span class="emailid">support@skilltrix.com</span>. <p>
		        <h2>We love feedback</h2> 
		        <p>Use the form given below for feedback.</p>
		</div>
	<?php
	        $contact = new users();
	        if (empty($_POST) === false) {
	         $required_feilds = array('email','name','message');
                        foreach($_POST as $key=>$value){
                                if(empty($value) && in_array($key, $required_feilds) ===true){
	                                $contact->errors[] = '<span class="error">All feilds are required.</span>';
	                                break 1;
                                }
                        }
                        if(isset($_POST['subject'])===false && empty($_POST['subject'])){
                               if(empty($_POST['subject'])){
                                        $contact->errors[]='<span class="error">Subject feild can not be blank.</span>';
                                }
                        }
	
	        }
	        
                if(isset($_GET['success']) === true && empty($_GET['success']) === true){
	                echo '<div class="success"><span>Your feedback has been recorded.</span></div>';
                } else{
                if(empty($_POST) === false && empty($contact->errors) === true){
			//update user details
			 if($_POST['subject'] == 'feedback'){
                	        $subject = 'Feedback';
                        }
                        else if($_POST['gender'] == 'support'){
	                        $subject = 'Support';
                        } else if($_POST['gender'] == 'support'){
                                 $subject = 'Other';
                        }
			
			$feedback_data = array(
				'name'	=> $_POST['name'],
				'email'		=> $_POST['email'],
				'subject'	=> $subject,
				'message'	=>$_POST['message']
				
				
			);
			if($contact->feedback($session_user_id,$feedback_data)){
				header('Location: contact.php?success');
				exit();
			}else{
				$contact->errors[] = '<span class="error">Some error occored please try again.</span>';

			}
		} else if(empty($contact->errors) === false){
			echo $contact->output_errors($contact->errors);
		}
	?>
		
		
<form class="contact-form" action="" method="POST">
 <fieldset>
  <legend>Contact Us</legend>
  <p>
		<label for="name" class="label">Name</label>
		<input type="text" name="name" id="name">
	</p>
	<p>
		<label for="email" class="label">Email ID</label>
		<input type="text" name="email" id="email">
	</p>
	<p><span class="label">Subject</span>
		<label>
			<input name="subject" type="radio" value="feedback" checked="checked">
			Feedback</label>
		<label>
			<input name="subject" type="radio" value="support">
			Support</label>
		<label>
			<input name="subject" type="radio" value="other">
			Other</label>
	</p>
	<p>
		<label for="message" class="label">Message </label>
		<textarea name="message" cols="35" rows="4" id="message"></textarea>
	</p>
	<p>
		<input type="submit" class="submitButton" value="SEND MESSAGE"/>
	</p>
 </fieldset>
</form>

<?php
        }
?>
</div>
</div>
<?php
        include 'includes/overall/footer.php';
?>
