<?php
	include('database.php');
	/********************************/
	//AMAZON S3 INCLUDES
	//INCLUDE ALL OTHER REQUIRED FILES HERE ONLY
	
	/********************************/

	class users extends database{

		
		public $user_data = array();
		public $parsed = array();

		public function __construct() {
			parent::__construct();    //constructing database class
		}


		////activity stuff
		function check_activity_type($type){
				$activity_type = array("joined","profile","cover","course_start","status","course_end","module_start","module_end","bio","saysomething");
			return in_array($type,$activity_type)?true:false;

		}
		function create_activity($user_id,$activity){
			$user_id =	$this->sanitize($user_id);
			$activity = $this->sanitize($activity);
			if($this->user_id_exists($user_id)){
					
				if($this->insert("activity",array($user_id,$activity),'user_id,activity')){
					return true;
				}else{
					return false;
				}
				
			} else{
					
				return false;
			}
		}
		function fetch_activity($user_id){
			$user_id = $this->sanitize($user_id);
			if($this->user_id_exists($user_id)){
				$this->select('activity','activity_id,user_id,activity',"user_id = $user_id",'timestamp DESC',10);
				return $this->getResult();
			} else{
				return false;
			}

		}
		function get_activity_ids($user_id){
			$user_id = $this->sanitize($user_id);
			
			$this->select('activity','activity_id',"user_id = {$user_id}","timestamp DESC");
			$res =	$this->getResult();
			return (empty($res))?'':$res;
			
		}
		function get_activity_date($activity_id){
			$activity_id = $this->sanitize($activity_id);
			if($this->verify_activity($activity_id)){
			$this->select('activity','timestamp',"activity_id = $activity_id");
			$res =	$this->getResult();
			return (empty($res['timestamp']))?'':$res['timestamp'];
			}else{
				return false;
			} 
		}
		function verify_activity($activity_id){
			$activity_id = $this->sanitize($activity_id);
			$this->select('activity','COUNT(activity_id)',"activity_id = $activity_id");
			$res =	$this->getResult();
			return (empty($res['COUNT(activity_id)']))?false:true; 

		}
		function parse_activity($user_id){
			$user_name = $this->get_fullname($user_id);
			$user_name = '<span class="user-name">'.$user_name.'</span>';
			$activities = $this->fetch_activity($user_id);
			if(empty($activities)===false){

			foreach($activities as $act){
				$header = '';
				$footer = '';
				$temp = explode(';',$act['activity']);
				$temp2 = explode(":",$temp[0]);
				$type = $temp2[1];
				$activity = $temp[1];

				//get date
				$datetime 	= $this->get_activity_date($act['activity_id']);
				$date 	= explode(' ',$datetime);
				$timevar = new DateTime( $datetime);
				if($timevar->format( 'H' )>12){
					$set = 'PM';
				}else{
					$set = 'AM';
				}
				$time   = $timevar->format( 'h:i' ).$set;
				$date 	= $date[0];
				$dateym = date('M,d', strtotime($date));
				$dated  = date('Y',strtotime($date));
				
				$header .=	'<div class="activity-container clearfix">'.
								'<div class="date-container lfloat">'.
									'<span class="date bold">'.$dateym.'</span>'.
									'<span class="day block">'.$dated.'</span>'.
								'</div>'.
							'<div class="activity-inner-container">'.
								'<div class="activity lfloat">'.
									'<div class="feed">';
				$footer .=  '<div class="date-container rfloat">'.
									'<span class="time">'.$time.'</span>'.
								'</div>';			

				if($this->check_activity_type($type)===false){
						continue;
				} else{
							
							if($type == "profile"){
								$t = explode(':',$activity);
								$t1 = $t[1].':'.$t[2];
								$length = strlen($t1);
								$t1 = substr($t1,1,$length-3);
								$return_string = $header.'<div class="">'.$user_name.'<span class="lightgray">'." updated his profile picture.</span></div>";
								$return_string .= '<span class="activity-profile-image"><img src="'.$t1.'" alt="'.substr(md5(strip_tags($user_name)),0,10).'.'.substr(md5($act['activity_id']),0,10).$act['activity_id'].'" class="display-pic"></span>';
								$return_string .= '</div></div></div>'.$footer.'</div>';
								array_push($this->parsed,$return_string);
							}else if($type == "cover"){	
								$t = explode(':',$activity);
								$t1 = $t[1].':'.$t[2];
								$length = strlen($t1);
								$t1 = substr($t1,1,$length-3);
								$return_string = $header.'<div class="">'.$user_name." updated his cover picture.</div>";
								$return_string .= '<span class="activity-cover-image"><img src="'.$t1.'" alt="'.substr(md5(strip_tags($user_name)),0,10).'.'.substr(md5($act['activity_id']),0,10).$act['activity_id'].'" class="display-cover"></span>';
								$return_string .= '</div></div></div>'.$footer.'</div>';
								array_push($this->parsed,$return_string);

							}else if($type == "course_start"){
								$t = explode('{',$activity);
								$length = strlen($t[1]);
								$course_id = substr($t[1],0,$length-2);
								$return_string = $header.$user_name.' joined the course <a href="course.php?c='.$course_id.'">'.$this->get_course_name_from_id($course_id).'</a>';
								$return_string .= '</div></div></div>'.$footer.'</div>';
								array_push($this->parsed,$return_string);

							}else if($type == "course_end"){
								$t = explode('{',$activity);
								$length = strlen($t[1]);
								$course_id = substr($t[1],0,$length-2);
								$return_string = $header.$user_name.' completed the course <a href="course.php?c='.$course_id.'">'.$this->get_course_name_from_id($course_id).'</a>';
								$return_string .= '</div></div></div>'.$footer.'</div>';
								array_push($this->parsed,$return_string);

							} else if($type == "module_start"){		
								$t = explode('{',$activity);
								$t2 = explode(':',$t[1]);          //To find the module id in activity
								$t3 = explode(',',$t2[1]);			// To find the course id in activity
								$course_id = $t3[0];

								$length = strlen($t2[2]);
								$module_id = substr($t2[2],0,$length-2);
								if($this->module_exists($module_id,$course_id)===true){
								
								
									$return_string = $header.$user_name.' started the module <a href="#">'.$this->get_module_name_from_id($module_id).'</a>';
									$return_string .= '</div></div></div>'.$footer.'</div>';
									array_push($this->parsed,$return_string);
								}
							}else if($type == "module_end"){

								$t = explode('{',$activity);
								$t2 = explode(':',$t[1]);          //To find the module id in activity
								$t3 = explode(',',$t2[1]);			// To find the course id in activity
								$course_id = $t3[0];

								$length = strlen($t2[2]);
								$module_id = substr($t2[2],0,$length-2);
								if($this->module_exists($module_id,$course_id)===true){
						
								
									$return_string = $header.$user_name.' completed the module <a href="#">'.$this->get_module_name_from_id($module_id).'</a>';
									$return_string .= '</div></div></div>'.$footer.'</div>';
									array_push($this->parsed,$return_string);
								}

							}else if($type == "bio"){
									$return_string = $header.$user_name.' updated his bio.';
									$return_string .= '</div></div></div>'.$footer.'</div>';
									array_push($this->parsed,$return_string);
							}else if($type == "status"){
								$t = explode('{',$activity);
								$length = strlen($t[1]);
								$t1 = substr($t[1],0,$length-2);
								$return_string = $header.$user_name." said about himself <b>".$t1.'</b>';
								$return_string .= '</div></div></div>'.$footer.'</div>';
								array_push($this->parsed,$return_string);
							}else if($type == "joined"){
								$return_string = $header.$user_name.' joined skilltrix.';
								$return_string .= '</div></div></div>'.$footer.'</div>';
								array_push($this->parsed,$return_string);
							}else if($type == "saysomething"){
								$t = explode(':',$activity);
								$t1 = $t[1];
								$length = strlen($t1);
								$t1 = substr($t1,1,$length-3);
								$return_string = $header.$user_name.' said , <span class="bold">'.$t1.'</span>.';
								$return_string .= '</div></div></div>'.$footer.'</div>';
								array_push($this->parsed,$return_string);
							}else{
								$this->parsed='';

							}
					}
			}
		}
		$temporary = $this->parsed;
		$this->parsed='';
		return $temporary;
	}

	


		function configure_s3($key='',$secret='',$bucket=''){
			if($key ==''){	
				$key = 'AKIAIIBXKICL64PBEZ5Q';
			}
			if($secret == ''){
				$secret = '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';
			}
			if($bucket == ''){
				$bucket = 'st_resource';
			}
				$config = array(
				'key' => $key,
				'secret' => $secret,
				'region' => Region::US_EAST_1
				);
			
				$s3 = S3Client::factory($config);
				$bucketname = $bucket;
				return $s3;


		}
		function get_user_image_link($image){
			$bucketname = 'st_resource';
			$image = 'profile/'.$image;
			$s3 = $this->configure_s3('AKIAIIBXKICL64PBEZ5Q','SQ3pX5JYBH9bQ2WMSm0664Tngitf9A07iSWilW2h',$bucketname);
			/*$result = $s3->getObject(array(
			    'Bucket' => $bucketname,
			    'Key'    => $image
			));
			print_r($result);*/
			//$s3 = $this->configure_s3('AKIAIIBXKICL64PBEZ5Q','SQ3pX5JYBH9bQ2WMSm0664Tngitf9A07iSWilW2h',$bucketname);
			$plainUrl = $s3->getObjectUrl($bucketname, $image);
			return $plainUrl;
		}
		function process_image($filename,$type,$file_extn) {  
          
	        $image_size 	= getimagesize($filename);
	        $image_width 	= $image_size[0];
	        $image_height 	= $image_size[1];
	        $new_size 		= ($image_width + $image_height)/($image_width*($image_height / 145));
	        
	        $new_width 		= $image_width * $new_size; 
	        $new_height		= $image_height * $new_size;	

	        $new_image 		= imagecreatetruecolor($new_width,$new_height);
	        if($file_extn == 'jpg'){
	       		$old_image = 	imagecreatefromjpeg($filename);
	         	imagecopyresized($new_image, $old_image, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height);
	         	imagejpeg($new_image,$filename);
	        }
	        if($file_extn == 'png'){
	       		$old_image = 	imagecreatefrompng($filename);
	         	imagecopyresized($new_image, $old_image, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height);
	         	imagepng($new_image,$filename);
	        }
	      
	      

  		}  
  		function disabletour($id){
			if(mysql_query("UPDATE `users` SET `tour` = '0' WHERE `user_id` = {$id}"))
				return true;
			else
				return false;
		}
		function change_image($user_id, $file_temp, $file_extn,$type,$x1,$y1,$width,$height){
			$filename = substr(md5(time()), 0, 10) . '.' .$file_extn;
			$file_path = 'photo/'.$type.'/'.substr(md5(time()), 0, 10) . '.' .$file_extn;

			if($type=='profile'){
				$this->process_image($file_temp,$type,$file_extn);
			}

			if(move_uploaded_file($file_temp, $file_path)){
				
				$bucketname = 'st_resource';
				$s3 = $this->configure_s3('AKIAIIBXKICL64PBEZ5Q','SQ3pX5JYBH9bQ2WMSm0664Tngitf9A07iSWilW2h',$bucketname);
				$filename = substr(md5(time()), 0, 10) ; 	//my image on my server
				$path = '/var/www/html/photo/'.$type.'/'; 					//the physical path where the image is located
				$fullfilename = $path.$filename.'.' .$file_extn;
				$s3->putObject(array(
				        'Bucket' => $bucketname,
				        'Key'    => $type.'/'.$filename.'.'.$file_extn, 
				        'Body'   => EntityBody::factory(fopen($fullfilename, 'r')),
				        'ACL'    => CannedAcl::PUBLIC_READ,
				        'ContentType' => 'image/'.$file_extn
				));
				$image_final_path = 'https://s3.amazonaws.com/'.$bucketname.'/'.$type.'/'.$filename.'.' .$file_extn;
				unlink($file_path);
				if($x1!='' and $y1!=''){
					$chords = "'".$x1.'-'.$y1."'";
				}else if($x1!='' and $y1==''){
					$chords = "'".$x1."-0'";
				}else if($x1=='' and $y1!=''){
					$chords = "'0".'-'.$y1."'";
				}else{
					$chords = "0-0";
				}
					if($type == "profile"){
						$temp = ', `chords` ='. $chords ;
					}else{
						$temp = '';
					}
				mysql_query("UPDATE `users` SET `$type` = '" . $image_final_path . "' ".$temp."  WHERE `user_id` = " . (int)$user_id) or die(mysql_error());
				$activity_string = "{type:".$type.";activity:{".$image_final_path."}}";
				return $this->create_activity($user_id,$activity_string);
			}			
		}
		function count_submodules($cid,$mid){
			$cid = $this->sanitize($cid);
			$temp = mysql_query("SELECT COUNT(sub_id) FROM `course` as c, `sub_modules` as s,`modules` as m WHERE c.course_id = $cid and m.module_id = s.module_id and s.module_id = $mid");
			$a = mysql_fetch_row($temp);
			return $a[0];
			
		}
		function link_first_exercise($mid){
			$this->select('sub_modules as s, modules as m, component as c, exercises as e','s.sub_id,c.component_id, e.exercise_id',"m.module_id = {$mid} and m.module_id = s.module_id and s.sub_id = c.sub_id and c.component_id = e.component_id ",'',1);
			$result = $this->getResult();
			$temp = '&module='.$mid.'&sub='.$result['sub_id'].'&comp='.$result['component_id'].'&exer='.$result['exercise_id']; 
			return $temp;
		}
		function count_modules($cid){
			$cid = $this->sanitize($cid);
			$temp = mysql_query("SELECT COUNT(module_id) FROM `modules` WHERE course_id = $cid ");
			$a = mysql_fetch_row($temp);
			return $a[0];
			
		}
		function get_module_name_from_id($id){
			//$id = $this->sanitize($id);
			$this->select('modules','module_name',"module_id= '$id'");
			$temp= $this->getResult();
			return $temp;
		}
		function get_module_desc_from_id($id){
			$id = $this->sanitize($id);
			$this->select('modules','module_desc',"module_id= '$id'");
			$temp= $this->getResult();
			return $temp['module_desc'];
		}
		function get_explanation_from_exercise_id($eid){
			$eid = $this->sanitize($eid);
			
			
			if($this->exercise_exists_by_id($eid)===true){
				$this->select('exercises','explanation',"exercise_id = '$eid'");
				$res = $this->getResult();
				return $res['explanation'];
			}else{
				return false;			
			}
		}
		function get_question_from_exercise_id($eid){
			$eid = $this->sanitize($eid);
			
			
			if($this->exercise_exists_by_id($eid)===true){
				$this->select('exercises','question',"exercise_id = '$eid'");
				$res = $this->getResult();
				return $res['question'];
			}else{
				return false;			
			}
		}
		function exercise_exists_by_id($eid){
			$this->select('exercises','COUNT(exercise_id)',"exercise_id = '$eid'");
			$res = $this->getResult();
			if(empty($res['COUNT(exercise_id)'])===true){
				return false;
			}else{
				return true;
			}
		}
		function match_userid_to_hash($hash,$user_id){
			$hash = $this->sanitize($hash);
			$length = strlen($hash);
			if(substr(md5($user_id),0,$length)==$hash){
				return true;
			} else {
				return false;
			}
		}
		function check_subscription($uid,$cid){
			$uid = $this->sanitize($uid);
			$cid = $this->sanitize($cid);
			$this->select('subscription','COUNT(*)',"`course_id` = '$cid' and `user_id`= '$uid'");
			$res = $this->getResult();
			if(empty($res['COUNT(*)'])===true){
				return  true;
			}else{
				return false;
			}
		}
		function  get_module($cid){
			$cid=$this->sanitize($cid);
			$this->select('modules','module_id',"course_id = '$cid'");
			$res = $this->getResult();
				return $res;
		}

		function get_submodules_id($mid){
		
			$mid=$this->sanitize($mid);
			
			$this->select('sub_modules','sub_id',"module_id = {$mid} ");
		
			$a = $this->getResult();

				//made a change of returning sub_id instead of a -Praveer
				return $a;
		}
		function get_submodules_name($sid){
		
			$sid=$this->sanitize($sid);
			
			$this->select('sub_modules','sub_name',"sub_id = {$sid} ");
			
			$a = $this->getResult();

				return $a['sub_name'];
		}
		function get_component_id($sid){
			$sid=$this->sanitize($sid);
			if($this->component_exists($sid)===false){
				return false;
			} else{
				
				$this->select('component','component_id',"sub_id = '$sid'");
				$res = $this->getResult();
				if(isset($res) and empty($res)===false){
					if(is_array($res)){
						return $res;
					}else{
						return $res['component_id'];
					}
				}else{
				}
			}
		}
		function get_component_id_old($sid){
			$sid=$this->sanitize($sid);
			if($this->component_exists($sid)===false){
				return false;
			} else{
				
				$this->select('component','component_id',"sub_id = '$sid'");
				$res = $this->getResult();
				if(isset($res) and empty($res)===false){
					return $res;
				}else{
				}
			}
		}
		function component_exists($sid){
			$this->select('component','COUNT(component_id)',"sub_id = '$sid'");
			$res = $this->getResult();
			if(empty($res['COUNT(component_id)'])===true){
					return false;
			}else{
				return true;
			}
		}
		function exercise_exists($compid){
			$this->select('exercises','COUNT(exercise_id)',"component_id = '$compid'");
			$res = $this->getResult();
			if(empty($res['COUNT(exercise_id)'])===true){
				return false;
			}else{
				return true;
			}
		}
		function course_exists($cid){
			$this->select('course','COUNT(course_id)',"course_id = '$cid'");
			$res = $this->getResult();
			if(empty($res['COUNT(course_id)'])===true){
				return false;
			}else{
				return true;
			}
		}
		function module_exists($mid,$cid){
			$this->select('modules','COUNT(module_id)',"module_id = '$mid' and course_id = '$cid'");
			$res = $this->getResult();
			if(empty($res['COUNT(module_id)'])===true){
				return false;
			}else{
				return true;
			}
		}
		function submodule_exists($sid,$mid){
			$this->select('sub_modules','COUNT(sub_id)',"sub_id = '$sid' and module_id = '$mid'");
			$res = $this->getResult();
			if(empty($res['COUNT(sub_id)'])===true){
				return false;
			}else{
				return true;
			}
		}
		function get_exercise_from_component($compid){
			$compid = $this->sanitize($compid);
			if($this->exercise_exists($compid)===false){
				return false;
			} else{
				$this->select('exercises','*',"component_id = '$compid'");
				$res = $this->getResult();
				return $res;
			}
			
		}		
		function get_exercise_id_from_compid($compid){
			$get = new users();
			$get->select('exercises','exercise_id',"component_id = $compid");
			$id = $get->getResult();
			if(empty($id['exercise_id'])===true){
				return false;
			} else{
				return $id['exercise_id'];
			}
		}
		
		//course.php?c=1&module=[MODULE_ID]&sub=[SUBMODULE_ID]&comp=[COMPONENT_ID]&exer=[EXERCISE_ID];
		function get_module_url($cid,$mid,$sid){
			$cid=$this->sanitize($cid);
			$mid=$this->sanitize($mid);
			$sid=$this->sanitize($sid);

			$url = "course.php?c=".$cid.'&module='.$mid.'&sub='.$sid.'&comp=';
                        //echo $sid;
			$compid = $this->get_component_id($sid);
			
			//print_r($compid);
			unset($compid['COUNT(component_id)']);
			//print_r($compid);
			if(is_array($compid)){
				foreach($compid as $comp){
					if(is_array($comp)){
					$comp_instance_value =  $comp['component_id'];
					}else{
						$comp_instance_value = $comp;
					}

					if($this->exercise_completed($comp_instance_value)===false){

						$url=$url.$comp_instance_value;
						$eid=$this->get_exercise_id_from_compid($comp_instance_value);

						if($eid === false){
							//$url = 'index.php';
							$eid='';
						}else{
							$url=$url.'&exer='.$eid;
						}

						return $url;
						break 1;
					}
				
				}
			}else{
			  
				$url='index.php';
				return $url;
			}
			
		}
		function count_total_exercise_in_module($cid,$mid){
			$this->select('exercises as e,modules as m, sub_modules as s, component as c,course as t ','count(exercise_id)',"t.course_id = {$cid} and m.module_id = {$mid} and m.module_id = s.module_id and s.sub_id = c.sub_id and c.component_id = e.component_id");
			$result = $this->getResult();
			return $result['count(exercise_id)'];
		}
		function count_total_exercise_in_course($cid){
			$this->select('exercises as e,modules as m, sub_modules as s, component as c,course as t ','count(exercise_id)',"t.course_id = {$cid} and m.module_id = s.module_id and s.sub_id = c.sub_id and c.component_id = e.component_id");
			$result = $this->getResult();
			return $result['count(exercise_id)'];
		}
		function count_total_module_in_course($id){
			$this->select('modules ','count(module_id)',"course_id = {$id} ");
			$result = $this->getResult();
			return $result['count(module_id)'];
		}
		function get_module_percent($cid,$mid,$count,$user_id){
			$cid=$this->sanitize($cid);
			$mid=$this->sanitize($mid);
			
			$this->select('done','COUNT(`module_id`)',"module_id = {$mid} and user_id = $user_id");
			
			$result = $this->getResult();
			$a = $result['COUNT(`module_id`)'];
			$percent = ($a/$count)*100;
			$percent = $percent.'% ';
			return $percent;
		}
		function get_exercise_name($eid){
			$eid=$this->sanitize($eid);
			$this->select('exercises','excer_name',"exercise_id = {$eid}");
			$result = $this->getResult();
			$a = $result['excer_name'];
			
			return $a;
		}
		function get_all_exercise_url($cid,$mid,$sid,$exid){
			$cid=$this->sanitize($cid);
			$mid=$this->sanitize($mid);
			$sid=$this->sanitize($sid);
			$result = array();
			$highlighted = '';
			$exercise_name = '';
			$url = "course.php?c=".$cid.'&module='.$mid.'&sub='.$sid.'&comp=';
                       
			$compid = $this->get_component_id($sid);

			if(empty($compid)===false){
				foreach($compid as $comp){
					if(is_array($comp)){
					$comp_instance_value =  $comp['component_id'];
					
					}else{
						$comp_instance_value = $comp;
					
					}	
					
						$eid=$this->get_exercise_id_from_compid($comp_instance_value);
						
						if($eid == $exid){
							$highlighted = 'highlighted';
						}else{
							$highlighted = '';
						}
						if($eid === false){
							//$url = 'index.php';
							$eid='';
							$comp_instance_value='';
							continue;
						}else{
							$url=$url.$comp_instance_value;
							$url=$url.'&exer='.$eid;
							$exercise_name = $this->get_exercise_name($eid);
						}
						$temp = '<a href="'.
								$url.
								'" class="hint--left" data-hint="'.$exercise_name.'">'.
								'<div  class="lesson-text bold700 "><span class="bold700" id="'.$highlighted.'">'.
								//'<span data-hint="'.$exercise_name.'">'.
								$exercise_name.
								//'</span>'.
								'</span></div></a>';
						array_push($result, $temp);
						$url = "course.php?c=".$cid.'&module='.$mid.'&sub='.$sid.'&comp=';
						$exercise_name = '';
						
				}
				
			}else{
			        
				$url='index.php';
				return $url;
			}
			return $result;
		}
		function get_next_exercise_url($cid,$mid,$sid,$comp){
			$sid=$this->sanitize($sid);
			$cid=$this->sanitize($cid);
			$mid=$this->sanitize($mid);
			$comp=$this->sanitize($comp);
			$this->select('component','component_id',"sub_id = {$sid} and component_id !=$comp  and component_id > $comp",'component_id',1);
			$result = $this->getResult();
			if(empty($result['component_id'])===false){
				$comp_instance_value =  $result['component_id'];
				$eid=$this->get_exercise_id_from_compid($comp_instance_value);
				$url = "course.php?c=".$cid.'&module='.$mid.'&sub='.$sid.'&comp='.$comp_instance_value.'&exer='.$eid;
				return $url;
			}else{
					if($this->jump_next_module($cid,$mid,$sid,$comp)===true){
						$url = "course.php?c=".$cid;
						$select = 'm.module_id,s.sub_id,c.component_id,e.exercise_id';
						$tables = 'modules as m, sub_modules as s, component as c, exercises as e';
						$where = "m.module_id != {$mid} and m.module_id > {$mid}  and s.module_id = m.module_id and s.sub_id = c.sub_id and c.component_id = e.component_id 
";
						$this->select($tables,$select,$where,'m.module_id',1);
						$jumpresult = $this->getResult();
						if(isset($jumpresult['module_id']) and empty($jumpresult['module_id'])===false){
							$url .='&module='.$jumpresult['module_id'].'&sub='.$jumpresult['sub_id'].'&comp='.$jumpresult['component_id'].'&exer='.$jumpresult['exercise_id'];
							return $url;
						}
					}else{
						$select = 's.sub_id,c.component_id,e.exercise_id ';
						$tables = 'modules as m, sub_modules as s,component as c, exercises as e'; 
						$where =  "m.module_id > {$mid} and s.sub_id != {$sid} and s.sub_id > {$sid} and m.module_id = s.module_id and s.sub_id = c.sub_id and c.component_id=e.component_id
";
						$this->select($tables,$select,$where,'s.sub_id',1);
						$interjump = $this->getResult();
						if(isset($interjump['sub_id']) and empty($jinterjump['sub_id'])===false){
							$url = "course.php?c=".$cid.'&module='.$mid.'&sub='.$interjump['sub_id'].'&comp='.$interjump['component_id'].'&exer='.$interjump['exercise_id'];
							return $url;
						}
						
					}

			}
		}
		function jump_next_module($cid,$mid,$sid,$comp){
			if($this->module_exists_at_submodule($cid,$mid,$sid,$comp)){
				return true;
			}else{
				return false;
			}

		}
		function get_subscribers($cid){
			$this->select('subscription','user_id',"course_id = {$cid}",'timestamp',30);
			$result = $this->getResult();
			foreach($result as $user_id){
				
					if(is_array($user_id)===false){
						$id = $user_id;
					}else{
						$id=$user_id['user_id'];
					}
					if($this->user_id_exists($id)===true){
						$src = $this->get_profile_image($id);
						$username = $this->get_fullname($id);
						$imgtag = "<img src='".$src."' alt='".$id."' />";
						$prepend = '<div class="lfloat profile_thumb hint--top" data-hint="'.$username.'">';
						$append = '</div>';
						$finalstring = $prepend.$imgtag.$append;
						echo $finalstring;
					}

			}


		}
		function get_profile_image($id){
			if($this->user_id_exists($id)===true){
				$this->select('users','profile',"user_id = {$id}");
				$result = $this->getResult();
				return $result['profile'];
			}
		}
		function module_exists_at_submodule($cid,$mid,$sid,$comp){
			$this->select('component','sub_id',"component_id > {$comp}",'component_id',1);
			$result = $this->getResult();
			$sub_id = $result['sub_id'];
			if(isset($sub_id) and empty($sub_id)===false){
				$this->select('sub_modules','count(module_id)',"sub_id = {$sub_id} and module_id = {$mid}");
				$temp = $this->getResult();

				if($temp['count(module_id)'] == 0){
					return true;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
		function set_saysomething($say,$id){
			$say=$this->sanitize($say);
			if(mysql_query("UPDATE `users` SET `something` = '$say' WHERE `user_id` = {$id}")){
				$activity_string = "{type:saysomething;activity:{".$say."}}";
				$this->create_activity($id,$activity_string);
				return true;
			}else{
				return false;
			}
		}
		function exercise_completed($compid){
			$check = new users();
			$check->select('exercises','*',"component_id = {$compid}");
			$res1 = $check->getResult();
			if(isset($res1['completed']) and empty($res1['completed'])===false){
			        if($res1['completed']=='0'){
				        return false;
			        } else{
				        return true;
			        }
			}else{
			        return false;
			}
			
		}
		function match_courseid_to_hash($hash,$id){
			$hash = $this->sanitize($hash);
			$length = strlen($hash);
			$temp = $length -2;
			if(substr(md5($id),5,$temp)===substr($hash,0,$temp)){
				return true;
			} else {
				return false;
			}
		
		}
		function subscribe($uid,$cid){
			$uid = $this->sanitize($uid);
			$cid = $this->sanitize($cid);
			if(mysql_query("INSERT INTO `subscription`(`course_id`, `user_id`) VALUES ($cid,$uid)")){
					$activity_string = "{type:course_start;activity:{".$cid."}}";
					$this->create_activity($uid,$activity_string);
				return true;
			}else{
				return false;
			}
			
			//return $this->insert('subscription',array($cid,$uid),'course_id,user_id');
			
		}
		
		function get_course_name_from_id($id){
			$id = $this->sanitize($id);
			$this->select('course','course_name',"course_id= '$id'");
			$temp= $this->getResult();
			return $temp['course_name'];
		}
		function get_course_image_from_id($id){
			$id = $this->sanitize($id);
			$this->select('course','image',"course_id= '$id'");
			$temp= $this->getResult();
			return $temp['image'];
		}
		function get_author($id){
			$id = $this->sanitize($id);
			$this->select('course','authors',"course_id = '$id'");
			$temp = $this->getResult();
			return $temp['authors'];
		}
		function get_description($id){
			$id = $this->sanitize($id);
			$this->select('course','description',"course_id = $id");
			$temp =$this->user_data=$this->getResult();
			return $temp['description'];
		}
		function user_data($user_id) {
			$this->select('users','*',"user_id = $user_id");
			$this->user_data=$this->getResult();

		}
		


		function user_exists($username){
			$username = $this->sanitize($username);
			$this->select('users','COUNT(user_id)',"username = '$username'");
			$result = $this->getResult();
			
			return (empty($result['COUNT(user_id)']) === true) ? false:true;
		}
		function user_id_exists($user_id){
			$user_id = $this->sanitize($user_id);
			$this->select('users','COUNT(user_id)',"user_id = '$user_id'");
			$result = $this->getResult();
			
			return (empty($result['COUNT(user_id)']) === true) ? false:true;
		}
		function user_exists_temp($username){
			$username = $this->sanitize($username);
			$this->select('users_temp','COUNT(username)',"username = '$username'");
			$result = $this->getResult();
			
			return (empty($result['COUNT(username)']) === true) ? false:true;
		}

		function user_active($username){
			$username = $this->sanitize($username);
			$this->select('users','COUNT(user_id)',"username = '$username'");
			$result = $this->getResult();
			
			return (empty($result['COUNT(user_id)']) === true) ? false:true;

		}
		function logged_in(){
			return(isset($_SESSION['user_id'])) ? true : false;
		 
		}
		function email_exists($email){
			$email = $this->sanitize($email);
			
			
			$this->select('users','COUNT(user_id)',"email = '$email'");
			$result = $this->getResult();
			
			return (empty($result['COUNT(user_id)']) === true) ? false:true;

		}
		function activate($email, $email_code) {
			$email 		= mysql_real_escape_string($email);
			$email_code = mysql_real_escape_string($email_code);
			
			if (mysql_result(mysql_query("SELECT COUNT(`user_id`) FROM `users` WHERE `email` = '$email' AND `email_code` = '$email_code' AND `active` = 0"),0) == 1) {
				// update user active status
				mysql_query("UPDATE `users` SET `active` = 1 WHERE `email` = '$email'");
				return true;	
			} else {
				return false;
			}
		}
		function user_id_from_email($email){
			$email = $this->sanitize($email);
			
			$this->select('users','user_id',"email = '$email'");
			$result = $this->getResult();
			
			return (empty($result['user_id']) === true) ? 0:$result['user_id'];
			
			
		}
		
		
		function update_user($user_id, $update_data){
	
			$update = array();
			array_walk($update_data, 'array_sanitize');
			foreach($update_data as $feild=>$data){
				$update[] = '`' . $feild . '` = \'' . $data . '\'';
			}
			mysql_query("UPDATE `users` SET " . implode(', ',$update) ." WHERE `user_id` = $user_id ");

			//creating activity
			$temp = array();
			$update_data['birthday'] = date('Y-m-d', strtotime($update_data['birthday']));
			foreach($update_data as $feild=>$data){
				$temp[] = $feild . ':'.$data;
			}
			$act_temp = implode(', ',$temp);
			$activity_string = "{type:bio;activity{".$act_temp."}}";
			return $this->create_activity($user_id,$activity_string);
		}
		function feedback($user_id, $update_data){
	
			$feedback = array();
			array_walk($feedback, 'array_sanitize');
			foreach($update_data as $feild=>$data){
				$feedback[] = $data;
			}
			$email = 'feedback@skilltrix.com';
			$body = 'Feedback from '.$feedback[0].' Email '.$feedback[1].'<br>'.$feedback[3];
			$subject = $feedback[2];
			if($this->our_mail($email,'',$subject,$body)===true){
				return true;

			}else{
				return false;

			}
		
			
			
		}
		function newpass($email,$pass){
			$pass = md5($pass);
			$query = "UPDATE `users` SET `password` ='$pass' WHERE `email` = '$email'";
			mysql_query($query);
		}
		function change_password_of_user($uid,$pass){
			$user_id = (int)$user_id;
			$password = '"'.$password.'"';
			//return $this->update('users',array('password'=>'$password'),array('user_id','$user_id'));
			$query = "UPDATE `users` SET password ='$pass'  WHERE user_id =".$user_id;
			if(mysql_query($query)){
				
				return true;
				
			}else{
			return false;
			}
		}
		function change_recover_password($user_id, $password) {
			$user_id = (int)$user_id;
			$password = '"'.$password.'"';
			//return $this->update('users',array('password'=>'$password'),array('user_id','$user_id'));
			$query = "UPDATE `users` SET recover =$password , password_recover=1 WHERE user_id =".$user_id;
			if(mysql_query($query)){
				
				return true;
				
			}else{
			return false;
			}
		}
		function recover($email) {
			$email 	= $this->sanitize($email);
			$user_id = $this->user_id_from_email($email);
			$name = $this->get_fullname($user_id);
			
			//recover password
			$generated_password = rand(10000000,99999999);
			if($this->change_recover_password($user_id,$generated_password)===true){
				
	$body = 'You recently requested a password reset for your Skilltrix account. To create a new password, user the code below:'.'<br><br><b>'.$generated_password.
			'</b><br><br>'."Regards,".'<br>'.
			"-Skilltrix Member Services".'<br>'.
			"Please do not reply to this message. Mail sent to this address cannot be answered.";
				$subject = 'Reset your password at Skilltrix.com';
				$this->our_mail($email,$name,$subject,$body);
				return $generated_password;
			}else{
				return false;
			}
			
		}
		

	
	function user_id_from_username($username){
		$username = $this->sanitize($username);
		return mysql_result(mysql_query("SELECT user_id FROM users WHERE username = '$username'"),0,'user_id');
	}
	
	function check_account_status($username,$password){
		$user_id = $this->user_id_from_username($username);
		$username = $this->sanitize($username);
		
		$query = mysql_query("select count(`user_id`) from `users` where `username` = '$username' AND `active` = 1" );
		return (mysql_result($query,0) == 1) ? true : false;
	}
	function login($username, $password){
		$user_id = $this->user_id_from_username($username);
		$username = $this->sanitize($username);
		$password = md5($password);

		$this->select('users','COUNT(user_id)',"username = '$username' and password = '$password'");
		$result=$this->getResult();
		if(empty($result['COUNT(user_id)'])){
			return false;
		} else {
			return $user_id;
		}
	}
	function auth_pass($pass,$id){
		$pass=md5($pass);
		$this->select('users','COUNT(user_id)',"`password` = '$pass' and `user_id` = $id");
		$result=$this->getResult();
		if(empty($result['COUNT(user_id)'])){
			return false;
		} else {
			return true;
		}
	}
	function register_user($register_data){
		array_walk($register_data, 'array_sanitize');
		$register_data['password'] = md5($register_data['password']);
		$feilds = '`'.implode('`, `', array_keys($register_data)).'`';
		$data= '\''.implode('\', \'',$register_data).'\'';

		$email = $register_data['email'];
		$name  = $register_data['first_name'].' '.$register_data['last_name'];
		$subject = 'Activate Your account at Skilltrix.com';
		
		$link = "http://skilltrix.com/activate.php?email=".$register_data['email']."&email_code=".$register_data['email_code'];
		$body = 'Thanks <b>'.$register_data['username'].'</b> for signing up with Skilltrix. You must follow this link to activate your account:'.'<br>'.
		'<a href="'.$link.'">'.$link.'</a><br>'.
		"If the link does not works try copying and pasting in your url bar.".
		'<br><br>'.
		"Have fun, and don't hesitate to contact us with your feedback (feedback@skilltrix.com).".'<br>'.
		"-The Skilltrix Team".'<br>'.
		"Skilltrix provides a new way to learn, a better environment to develop and a whole new set of opportunities.".'<br>'.
		"Please do not reply to this message. This is an automatically generated email.";
		if($this->our_mail($email,$name,$subject,$body)===true){
			mysql_query("INSERT INTO `users` ($feilds) VALUES ($data)");
			$user_id = $this->get_user_id($register_data['username']);
			$activity_string = "{type:joined;activity{".date('Y-m-d H:i:s', time())."}}";
			if($this->create_activity($user_id,$activity_string)){
				$activity_string = "{type:stray;activity{}}";
				$this->create_activity($user_id,$activity_string);
				return true;

			}else{
				return false;

			}
		}else{
			return false;
		}
		
	}

	function register_user_temp($register_data){

	array_walk($register_data, 'array_sanitize');
	$feilds = '`'.implode('`, `', array_keys($register_data)).'`';
	$data= '\''.implode('\', \'',$register_data).'\'';
	
	mysql_query("INSERT INTO `users_temp` ($feilds) VALUES ($data)");
	}
	 
	function update_details_from_temp($username,$password){
			$hashp=md5($password);
			mysql_query("UPDATE `users_temp` SET `password` = '$hashp' WHERE `username` = '$username' ");
			$this->select('users_temp','*',"username = '$username'");
			$a=$this->getResult();
			$a['password']=$password;
			
			
			$this->register_user($a);
		}
	 function email($to, $subject, $body){
		if(!mail($to,$subject,$body,'From: rhythemaggarwal@gmail.com')){
			echo 'There Was a problem sending email. Please contact us at rhythemaggarwal@gmail.com';
		}

	}
	function get_hash_value($val){
		$val = $this->sanitize($val);
		$this->select('hash_values','value,length', "text = '$val'");
		
		$result=$this->getResult();
		if(empty($result)===false){
			$l= $result['length'];
			$v= $result['value'];
			$r= substr($v,0,$l);
			return $r;
		}else{
			return false;
		}
	}
	// all the get functions
	function get_username($id){
		$id = $this->sanitize($id);
		if($this->user_id_exists($id)===true){
			$this->select('users','username',"user_id = '$id'");
			$result = $this->getResult();
			if(empty($result)===false){
				return $result['username'];
			}else{
				return false;
			}
		}else{
			return false;
		}
	}
	function get_email_from_username($username){
		$username = $this->sanitize($username);
		$this->select('users','email',"username = '$username'");
		$result = $this->getResult();
		if(empty($result)===false){
			return $result['email'];
		}else{
			return false;
		}
	}
	function get_emailcode_from_email($email){
		$email = $this->sanitize($email);
		$this->select('users','email_code',"email = '$email'");
		$result = $this->getResult();
		if(empty($result)===false){
			return $result['email_code'];
		}else{
			return false;
		}
	}
	function get_user_id($username){
		$username = $this->sanitize($username);
		$this->select('users','user_id',"username = '$username'");
		$result = $this->getResult();
		if(empty($result)===false){
			return $result['user_id'];
		}else{
			return false;
		}
	}
	function get_email($id){
		$id = $this->sanitize($id);
		$this->select('users','email',"user_id = '$id'");
		$result = $this->getResult();
		if(empty($result)===false){
			return $result['email'];
		}else{
			return false;
		}
	}
	
	function get_firstname($id){
		$id = $this->sanitize($id);
		$this->select('users','first_name',"user_id = '$id'");
		$result = $this->getResult();
		if(empty($result)===false){
			return $result['first_name'];
		}else{
			return false;
		}
	}
	
	function get_lastname($id){
		$id = $this->sanitize($id);
		$this->select('users','last_name',"user_id = '$id'");
		$result = $this->getResult();
		if(empty($result)===false){
			return $result['last_name'];
		}else{
			return false;
		}
	}
	function get_fullname($id){
		$id = $this->sanitize($id);
		if($this->user_id_exists($id)===true){
			$fname =$this->get_firstname($id);
			$lname =$this->get_lastname($id);
			return ucfirst($fname).' '.ucfirst($lname);
		}
	}

	function get_birthday($id){
		$id = $this->sanitize($id);
		$this->select('users','birthday',"user_id = '$id'");
		$result = $this->getResult();
		if(empty($result)===false){
			
			return $this->parse_birthday($result['birthday']);
		}else{
			return false;
		}
	}
		function  parse_birthday($birthday){
			$temp=explode('-',$birthday);
			
			$year=$temp[0];
			$month=$temp[1];
			$day=$temp[2];
			
			//parsing day
				$day = (int)$day;
				$day = $day.'<div class="idisplay" id="superscript">th</div>';
			
		
			//parsing month
			$listofmonths = array(
				1=>'January',
				2=>'February',
				3=>'March',
				4=>'April',
				5=>'May',
				6=>'June',
				7=>'July',
				8=>'August',
				9=>'September',
				10=>'October',
				11=>'November',
				12=>'December'
				);
			$month = $listofmonths[(int)$month];
			
			$dob = $day.' '.$month.','.$year;
			return $dob;
	}
	function get_gender($id){
		$id = $this->sanitize($id);
		$this->select('users','gender',"user_id='$id'");
		$result = $this->getResult();
		if(empty($result)===false){
			
			return $result['gender'];
		}else{
			return false;
		}
	}
	function get_course_id(){
			$this->select('course','course_id');
			$result = $this->getResult();
			return $result;
	}
}
/*
$try = new users();
echo '<pre>';
print_r($try->count_total_exercise(1,1));
*/
?>
