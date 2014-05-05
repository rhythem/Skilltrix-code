<?php
//include('../core/init.php');
//$user_name=new users();
//global $session_user_id;
$module_id=$_POST['qid'];
$eid=$_POST['exid'];
$subid=$_POST['sid'];
$flag=0;
$link=mysql_connect('localhost','root','dZ8LyUqVBm4rfTD4');
	mysql_select_db('lr');
			$uid=$_POST['uname'];
			//$uname=$user_name->get_username($uid);
			$sqlchk="SELECT user_id,exercise_id FROM done";
			$result=mysql_query($sqlchk);
			while($row=mysql_fetch_array($result))
			{
			$uid1=$row['user_id'];
			$mid=$row['exercise_id'];
			if($uid1==$uid&&$eid==$mid)
			{
				$flag=1;
			}
			}
			if(!$flag)
			{
			$sqlins="INSERT INTO done(user_id,module_id,exercise_id,sub_id) VALUES('$uid','$module_id','$eid','$subid')";
			mysql_query($sqlins);
			}
?>