<?php
//get username
/*include('core/classes/users.php');
$user_name=new users();
$uid=$_SESSION['user_id'];
$uname=$user_name->get_username($uid);
*/
//File-write
$coding=$_POST['coding'];
$uname="test";
$file_name="practice/".$uname."_practice.c";
$out_fname="practice/".$uname."_practice.out";
$flink=fopen($file_name,'w');
fwrite($flink,$coding);

//Compiler Code
shell_exec("gcc $file_name -o $out_fname");
$output=shell_exec("./$out_fname");
$error=shell_exec("gcc $file_name 2>&1 -o $out_fname");
if(!$error)
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
	$count_lines=0;
	for($i=0;$i<strlen($error);$i++)
		if($error[$i]=="\n")
			$count_lines++;
	$er=explode("practice/".$file_name.":",$error);
	for($j=0;$j<=$h;$j+=1)
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
unlink($file_name);
unlink($out_fname);
?>