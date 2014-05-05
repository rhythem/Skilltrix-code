<style>
.hide
{
display:none;
}
</style>
<?php
$uname=$_POST['uname'];
$fname="$uname/c/xyz";
$flink=fopen("$fname.c",'w');
fwrite($flink,$_POST['coding']);
fclose($flink);
//Compiler code
shell_exec("gcc $fname.c -o $fname.out");
$output=shell_exec("./$fname.out");
$err=shell_exec("gcc $fname.c 2>&1");
if(!$err)
{
for($i=0;$i<strlen($output);$i++)
{
if($output[$i]=="\n")
echo "<br/>";
else if($output[$i]==" ")
echo "&nbsp;";
else if($output[$i]=="<")
echo "&lt;";
else if($output[$i]==">")
echo "&gt;";
else if($output[$i]=="\t")
for($r=1;$r<=8;$r++)
echo "&nbsp;";
else
echo $output[$i];
}
}
else
{
$h=0;
for($i=0;$i<strlen($err);$i++)
if($err[$i]=="\n")
$h++;
$er=explode("xyz.c:",$err);



for($j=1;$j<=$h;$j+=1)
for($i=0;$i<strlen($er[$j]);$i++)
{
if($er[$j][$i]=="\n")
echo "<br/>";
else if($er[$j][$i]==" ")
echo "&nbsp;";
else if($er[$j][$i]=="\t")
for($r=1;$r<=8;$r++)
echo "&nbsp;";
else
echo $er[$j][$i];
}
}
?>
<form method="post">
<input type="text" name="uname" class="hide" />
<input type="text" name="coding" class="hide"/>
<input type="submit" value="Run" class="hide"/>
</form>

