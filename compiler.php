<script>
var editor1 = ace.edit("editor1");
editor1.setTheme("ace/theme/twilight");
    editor1.getSession().setMode("ace/mode/c_cpp");
</script>
<?php
	if($_SERVER['REQUEST_METHOD']=='POST'){
		//Create a file out of the input made;
		$uname="./compilers_files/xyz";
		$fname="$uname.c";
		$flink=fopen($fname,'w');
		fwrite($flink,$_POST['coding']);
		fclose($flink);

		//Compiler code
		shell_exec("gcc ./compiler_files/xyz.c -o ./compiler_files/abc.out ");
		exec("./compiler_files/abc.out",$output);
		exec("gcc ./compiler_files/xyz.c 2>&1",$err);
?>

<div id="editor1" class="ace-editor">
	<?php
		$i=strlen($content);
		for($b=0;$b<$i;$b++)
		{
			if($content[$b]==" "){
				echo "&nbsp;";
			}
			else if($content[$b]=="\n"){
				echo "<br/>";
			}
			else if($content[$b]=="<"){
				echo "&lt;";
			}
			else if($content[$b]==">"){
				echo "&gt;";
			}
			else{
				echo $content[$b];
			}
		}
		echo "\n-------------------------------------------------------\nOutput";
		if(!$err)
		{

			foreach($output as $ba)
			{
				echo "\n";
				for($g=0;$g<strlen($ba);$g++)
				{
					if($ba[$g]==" "){
						echo "&nbsp;";
					}
					else if($ba[$g]=="\t")
					{
						for($p=0;$p<8;$p++){
							echo "&nbsp;";
						}
					}
					else{
						echo "$ba[$g]";
					}
				}
			}


		}
		else
		{
			foreach($err as $a)
			{
				echo "\n";
				for($o=0;$o<strlen($a);$o++){
					if($a[$o]==" ")
					echo "&nbsp;";
					else
					echo $a[$o];
				}
			}
		}
?>
</div>
<div class="clearfix">
<button id="refresh-button" class="ui-button rfloat">Refresh</button>
</div>
<script>
	var editor1 = ace.edit("editor1");
	editor1.setTheme("ace/theme/twilight");
 	editor1.getSession().setMode("ace/mode/c_cpp");
	editor1.setReadOnly(true);
	
</script>
<?php
	}
	else {
	echo '<div class="small-font">Enter Your Coding Here</div>';
?>
	<div id="editor" class="ace-editor"></div>
	<form action="" method="post" enctype=multipart/form-data>
	<textarea  name="coding" id="copy" cols=1 rows=18></textarea>
	<div class="clearfix">
		<input type="submit" onclick="callit()"  value="Run" name="submit" class="ui-button rfloat"/>
		<input type="button" value="Reset" onclick="location.reload()" class="ui-button rfloat"/>
	</div>
	</form>

<script>
var editor = ace.edit("editor");
    editor.setTheme("ace/theme/twilight");
    editor.getSession().setMode("ace/mode/c_cpp");
function callit()
{
var x = editor.getValue();
document.getElementById("copy").innerHTML=x;
}

</script>

<?php 
	}
?>
