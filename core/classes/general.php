<?php
	include('class.phpmailer.php');
class general extends PHPMailer{
	public $errors = array();
	public function __construct() {
			parent::__construct();    //constructing database class
		}
	function logged_in_redirect(){
		if($this->logged_in() === true){
			header('Location: index.php');
			exit();
		}
	}

	function protect_page(){
		if($this->logged_in() === false){
			header('Location: protected.php');
			exit();
		}
	}
	function email_exists($email){

	$this->email = sanitize($email);
	$this->select('users','COUNT(user_id)',"`email` = '$email'");
	$res = $this->getResult();
	if(empty($res['COUNT(user_id)'])===true){
		return false;
	}else{
		return true;
	}

	}
	function admin_protect(){
		global $users;
		$this->protect_page();
		$id=$users->user_data['user_id'];
		if ($this->has_access($id, 1) === false) {
			header('Location: index.php');
			exit();
		}
	}
	function has_access($user_id,$type) {
		$user_id 	= (int)$user_id;
		$type		= (int)$type;
		return (mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `user_id` = $user_id AND `type` = $type"), 0) == 1) ? true : false;
	}
	function array_sanitize(&$item){
		$item = htmlentities(strip_tags(mysql_real_escape_String($item)));
	}
	function sanitize($data){
		return  htmlentities(strip_tags(mysql_real_escape_string($data)));
	}
	
	
	function output_errors($errors,$mode = 'default',$extra=''){
		
		if($mode == 'login_error'){
			$form ='<form action="login.php" method="POST">'.
					   '<table id="login" >'.

							'<tr><td class="black">Username</td><td><input type="text" name="username" id="username" class="TextInput" placeholder="Username"/></td></tr>'.
							'<tr><td class="black">Password</td><td><input type="password" name="password" id="password" class="TextInput" placeholder="Password"/></td></tr>'.
							'<tr><td colspan="2" align="right"><input type="submit" value="Log In" class="LoginButtonUi"/></td></tr>'.
							'<tr class="black"><td></td><td class="black">Forgot <a class="black" href="recover.php">password</a>?</td></tr>'.

						'</table>'.
				'</form>';
				$string='<div class="login_error_container gfont smaller-font">'.
					'<div class="padding10 border-bottom">'.
							'<span>'.
							  'Skilltrix Login'.
							'</span>'.
					'</div>'.
					'<div class="padding10 border-bottom error-container">'.
							'<span>'.
									'<ul><li>'.implode('</li><li>',$errors).'</li></ul>'.
							'</span>'.
					'</div>'.
				   '<div class="padding10">'.
							'<span>'.
									'Please try again'.
							'</span>'.
					'</div>'.
					'<div class="login-again">'.
							'<div>'.
								$form.
							'</div>'.
					'</div>'.
		'</div>';
		return $string;
		}else if($mode == 'resend'){
			$form = '<table><tr><td><input type="text" name="email" id="resendemail" class="TextInput" placeholder="Email" value="'.$extra.'" disabled></td></tr>'.
					'<tr><td colspan="2" align="right"><input onclick="resendactivation()" type="button" value="Resend" class="small-ui-button"/></td></tr></table>';
				$string='<div class="login_error_container gfont smaller-font">'.
					'<div class="padding10 border-bottom">'.
							'<span>'.
							  'Skilltrix Login'.
							'</span>'.
					'</div>'.
					'<div id="widget" class="padding10 border-bottom error-container">'.
							'<span>'.
									'<ul><li>'.implode('</li><li>',$errors).'</li></ul>'.
							'</span>'.
					'</div>'.
				   '<div class="padding10">'.
							'<span>'.
									'Please try again'.
							'</span>'.
					'</div>'.
					'<div class="login-again">'.
							'<div>'.
								$form.
							'</div>'.
					'</div>'.
		'</div>';
		return $string;
		}else{
		        return '<div class="padding20 marbot10 smaller-font error-container"><span class="block">'.implode('</span><span>',$errors).'</span></div>';
		}
	}
}
?>
