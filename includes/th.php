<?php
ob_start();
?>
<style>
.hide
{
display:none;
}
</style>
<?php 
$flag=0;
$user=$_POST['uname'];
$no=$_POST['up'];
$pth=$_POST['path'];
$link=mysql_connect('localhost','root','dZ8LyUqVBm4rfTD4');
mysql_select_db('lr');
$sql="SELECT user,eid FROM thmb_chk";
$row=mysql_query($sql);
while($result=mysql_fetch_array($row))
{
$u=$result['user'];
$p=$result['eid'];
if($user==$u&&$p==$pth)
{
$flag=1;
echo "f";
}
}
if(!$flag)
{
$sql="SELECT th_up,th_down FROM exercises WHERE exercise_id='$pth'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
if($no)
{
$tup=$row['th_up']+1;
$sqld1="UPDATE exercises SET th_up='$tup' WHERE exercise_id='$pth'";
mysql_query($sqld1);
}
else
{
$tdn=$row['th_down']+1;
$sqld="UPDATE exercises SET th_down='$tdn' WHERE exercise_id='$pth'";
mysql_query($sqld);
}
$sqlin="INSERT INTO thmb_chk(user,eid) VALUES('$user','$pth')";
mysql_query($sqlin);
}

?>
<form method="post">
<input type="text" name="up" class="hide"/>
<input type="text" name="path" class="hide"/>
<input type ="submit" class="hide"/>
</form>
