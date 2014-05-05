<style>
.hide
{
display:none;
}
</style>
~
<?php
include ('includes/db.php');

	//$uid=$_SESSION['user_id'];
	//$uname=$user_name->get_username($uid);


error_reporting(0);
$flag_cc=0;
$cc=new database();
$link=mysql_connect('localhost','root','mSLruyMbvTxLaAAK');
mysql_select_db("lr");
$qe=$_POST['ques'];
$sql="SELECT er_str,er_rep,code_check_y,code_check_n FROM exercises WHERE ques='$qe'";
$result=mysql_query($sql);
$row=mysql_fetch_array($result);
$uname=$_POST['uname'];
$id="ppar";

$fname="vijay/c/$id.c";
$fnaq="vijay/c/$id";
$flink=fopen("$fname",'w');
fwrite($flink,$_POST['coding']);
fclose($flink);
//Code Check Start
$sin_com="//";
$multi_com="/*";
$sy=$row['code_check_y'];
$sn=$row['code_check_n'];
$fna=file($fname);
$line_si=$cc->code_chk($fna,$sin_com);
$line_mu=$cc->code_chk($fna,$multi_com);
$cts=count($line_si);
$ctm=count($line_mu);
$no=0;

if($line_si)
array_splice($fna,$line_si,1);

if($line_mu)
array_splice($fna,$line_mu,1);

$fli=fopen($fname,'w');
$cs=count($fna);
for($i=0;$i<$cs;$i++)
fwrite($fli,$fna[$i]);

$sys=explode(',',$sy);
$sns=explode(',',$sn);
$cy=count($sys);
$cn=count($sns);
$flagy=0;
$flagn=0;
if($sy)
{
for($i=0;$i<$cy;$i++)
{
$l=$cc->code_chk($fna,$sys[$i]);
if($l)
$flagy++;
}
if($flagy==$cy)
{
//Code check true
}
else
{
//code check false
echo "1~";
$flag_cc=1;
}
}
if($sn)
{
for($i=0;$i<$cn;$i++)
{
$l1=$cc->code_chk($fna,$sns[$i]);
if($l1)
$flagn++;
}
if($flagn)
{
//code check false
echo "2~";
$flag_cc=1;
}
else
{
//code check true
}
}
// make and of both conditions if 1 then only code check is true otherwise false
if(!$flag_cc)
{

//Compiler code

shell_exec("gcc $fname -o $fnaq.out");
$output=shell_exec("./$fnaq.out");
$err=shell_exec("gcc $fname 2>&1 -o $fnaq.out");
if(!$err)
{
echo "o~";
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
echo "e~";
	$e=$row['er_str'];
	$e1=explode("!",$e);
$r=$row['er_rep'];
$r1=explode("^",$r);
$ces=count($e1);
$h=0;
	

for($i=0;$i<strlen($err);$i++)
if($err[$i]=="\n")
$h++;
$er=explode("test/c/$fnaq.c:",$err);


$flg_e=0;
for($j=0;$j<=$h;$j+=1)
{
	$flg_e=0;
	for($r2=0;$r2<$ces;$r2++)
	{
		if(strpos($er[$j],$e1[$r2]))
		{
		$flg_e=1;
		echo $r1[$r2];
		}
	}
	if(!$flg_e)
	{
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
}
}
}
unlink($fname);
?>
~
<form method="post" class="hide">
<input type="text" name="uname" class="hide" />
<input type="text" name="coding" class="hide"/>
<input type="text" name="ques" class="hide"/>
<input type="text" name="qid" class="hide" />
<input type="submit" value="Run" class="hide"/>
</form>

