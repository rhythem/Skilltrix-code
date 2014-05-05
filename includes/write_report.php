<style>
.hide{display:none;}
</style>
<?php 
$q=$_POST['ques'];
$o=$_POST['out'];
$re=$_POST['resp'];
$pth=$_POST['path'];
$link=mysql_connect('localhost','root','dZ8LyUqVBm4rfTD4');
mysql_select_db('lr');
$sql="INSERT INTO reports(report,output,exer_id) VALUES('$re','$o','$pth')";
mysql_query($sql);
?>
<form method="post">
<input type="text" name="ques" class="hide"/>
<input type="text" name="out" class="hide"/>
<input type="text" name="resp" class="hide"/>
<input type="text" name="path" class="hide"/>
<input type="submit" class="hide"/>
</form>
