<?php
include('users.php');
	class activity{

		public $parsed = array();

	

		function check_activity_type($type){
				$activity_type = array("profile","cover","course_start","status","course_end","module_start","module_end","bio");
			return in_array($type,$activity_type)?true:false;

		}
		function create_activity($user_id,$activity){
			$user_id =	$this->sanitize($user_id);
			$activity = $this->sanitize($activity);
			if($this->user_id_exists($user_id)){
				$this->insert("activity",array($user_id,$activity),'user_id,activity');
				return true;
			} else{
				return false;
			}
		}
		function fetch_activity($user_id){
			$user_id = $this->sanitize($user_id);
			if($this->user_id_exists($user_id)){
				$this->select('activity','*',"user_id = $user_id",'timestamp');
				return $this->getResult();
			} else{
				return false;
			}

		}
		function parse_activity($user_id){
			$user_name = $this->get_fullname($user_id);
			$activities = $this->fetch_activity($user_id);
				//print_r($activities);
			foreach($activities as $act){

				$temp = explode(';',$act['activity']);
				$temp2 = explode(":",$temp[0]);
				$type = $temp2[1];
				$activity = $temp[1];
				

				if($this->check_activity_type($type)===false){
						continue;
				} else{
							
							if($type == "profile"){
								$t = explode(':',$activity);
								$t1 = $t[2];
								$length = strlen($t1);
								$t1 = substr($t1,0,$length-2);
								$return_string = $this->get_fullname($user_id)." updated his profile picture.";
								$return_string .= '<img src="'.$t1.'" alt="'.$this->get_fullname($user_id).'.'.substr(md5($act['activity_id']),0,30).$act['activity_id'].'">';
								array_push($this->parsed,$return_string);
							}else if($type == "cover"){	
								$t = explode(':',$activity);
								$t1 = $t[2];
								$length = strlen($t1);
								$t1 = substr($t1,0,$length-2);
								$return_string = $user_name." updated his cover picture.";
								$return_string .= '<img src="'.$t1.'" alt="'.$user_name.'.'.substr(md5($act['activity_id']),0,30).$act['activity_id'].'">';
								array_push($this->parsed,$return_string);

							}else if($type == "course_start"){
								$t = explode('{',$activity);
								$length = strlen($t[1]);
								$course_id = substr($t[1],0,$length-2);
								$return_string = $user_name.' joined the course <a href="#">'.$this->get_course_name_from_id($course_id).'</a>';
								array_push($this->parsed,$return_string);

							}else if($type == "course_end"){
								$t = explode('{',$activity);
								$length = strlen($t[1]);
								$course_id = substr($t[1],0,$length-2);
								$return_string = $user_name.' completed the course <a href="#">'.$this->get_course_name_from_id($course_id).'</a>';
								array_push($this->parsed,$return_string);

							} else if($type == "module_start"){		
								$t = explode('{',$activity);
								$t2 = explode(':',$t[1]);          //To find the module id in activity
								$t3 = explode(',',$t2[1]);			// To find the course id in activity
								$course_id = $t3[0];

								$length = strlen($t2[2]);
								$module_id = substr($t2[2],0,$length-3);
								if($this->module_exists($module_id,$course_id)===true){
								
								
									$return_string = $user_name.' started the module <a href="#">'.$this->get_module_name_from_id($module_id).'</a>';
									array_push($this->parsed,$return_string);
								}
							}else if($type == "module_end"){
								$t = explode('{',$activity);
								$t2 = explode(':',$t[1]);          //To find the module id in activity
								$t3 = explode(',',$t2[1]);			// To find the course id in activity
								$course_id = $t3[0];

								$length = strlen($t2[2]);
								$module_id = substr($t2[2],0,$length-3);
								if($this->module_exists($module_id,$course_id)===true){
								
								
									$return_string = $user_name.' completed the module <a href="#">'.$this->get_module_name_from_id($module_id).'</a>';
									array_push($this->parsed,$return_string);
								}

							}else if($type == "bio"){
									$return_string = $user_name.' updated his bio.';
									array_push($this->parsed,$return_string);
							}else if($type == "status"){
								$t = explode('{',$activity);
								$length = strlen($t[1]);
								$t1 = substr($t[1],0,$length-2);
								$return_string = $user_name." said about himself <b>".$t1.'</b>';
								array_push($this->parsed,$return_string);
							}else{
								$this->parsed='';

							}
					}
		}
		$temporary = $this->parsed;
		$this->parsed='';
		return $temporary;
	}
}
	//$try = new activity();
	//echo '<pre>';
	//print_r($try->parse_activity(1));


	/*
	$try->create_activity("1","{type:profile;activity:{cover:/photo/cover/asdadasd.jpg}}");
	$try->create_activity("1","{type:image;activity:{profile:/photo/image/asdadasd.jpg}}");
	$try->create_activity("1","{type:status;activity:{cool programmer who loves to play games}}");
	$try->create_activity("1","{type:bio;activity:{name:Rhythem aggarwal,dob:1435asda}}");
	$try->create_activity("1","{type:course_start;activity:{3}}");
	$try->create_activity("1","{type:course_end;activity:{3}}");
	$try->create_activity("1","{type:module_start;activity:{cid:3,mid:4}}}");
	$try->create_activity("1","{type:module_end;activity:{cid:4,mid:5}}");
	if($try->create_activity("1","{type:profile,activity:cover->/photo/cover/asdadasd.jpg}")){
	 	echo "yoyoyoy";
	}else{
		echo "nonono";
	}*/
?>
