<?php
if($_SERVER['REQUEST_METHOD']=='POST')
	{
		$fname="jkl.c";
		$flink=fopen($fname,'w');
		$fwrite($flink,$_POST['coding']);
		fclose($flink);
		shell_exec("gcc jkl.c -o qwe.out");
		exec("./qwe.out/",$output);
		exec("gcc jkl.c 2>&1",$err);
		$flink1=fopen($fname,'r');
		$content=fread($flink1, filesize($fname));
		$i=strlen($content);
		for($b=0;$b<$i;$b++)
			{
				if($content[$b]==" ")
				echo "&nbsp;";

				else if($content[$b]=="\n")
				echo "<br/>";

				else if($content[$b]=="<")
				echo "&lt;";

				else if($content[$b]==">")
				echo "&gt;";
				
				else
				echo $content[$b];
			}
		echo "<br/>";
		if(!$err)
			{
				foreach($output as $ba)
					{
						echo "\n";
					for($g=0;$g<strlen($ba);$g++)
						{
							if($ba[$g]==" ")
							echo "&nbsp;";

							else if($ba[$g]=="\t")
								{
									for($p=0;$p<8;$p++)
									echo "&nbsp;";
								}

							else
							echo "$ba[$g]";
						}
					}	


			}
		else
			{
				foreach($err as $a)
					{
						echo "\n";
					for($o=0;$o<strlen($a);$o++)
						{
							if($a[$o]==" ")
							echo "&nbsp;";
							
							else
							echo $a[$o];
						}
					}
			}
	}
else
	{
?>
	<form method="post" enctype=multipart/form-data>
		<textarea name="coding" rows=10 cols=10></textarea>
	</form>
<?php 	} ?>
