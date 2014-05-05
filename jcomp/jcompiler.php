<?php
if($_SERVER['REQUEST_METHOD']=='POST')
{

//Create a file out of the input made;
$uname="xyz";
$fname="$uname.java";
$flink=fopen($fname,'w');
fwrite($flink,$_POST['coding']);
fclose($flink);
Compiler code
shell_exec("javac xyz.java");
$output=shell_exec("java $uname");
exec("java xyz.class 2>&1",$err);
echo "$output";
//$dollar="pid";
//$output1=shell_exec("$dollar");
//$output2=shell_exec("$dollar");
//echo "$output1";
//echo "$output2";

$flink1=fopen($fname,'r');
$content=fread($flink1, filesize($fname));
}
else
{
?>
Give the class name as xyz<br/>
<b>Enter Your Coding Here</b><br/><br/>
<form action="jcompiler.php" method="post" enctype=multipart/form-data>
<textarea name="coding" cols=45 rows=20 ></textarea><br/>
<br/>
<input type="submit" value="Run" />
</form>
<?php }?>
