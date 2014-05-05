<style>
.hide
{
display:none;
}
#editor
{
height:500px;
width:500px;
}
.lfloat
{
float:left;
}
.rfloat
{float:right;}
</style>
<?php
//Coding area
echo "<div id='editor' class='lfloat'></div>";

//Output Area
echo "<div id='output-container' class='rfloat'>";
	echo "<div id='loading' class='hide'>
				<div id='load'><img src='includes/362.gif'/></div><span class='loading-text'>Tip: Taking too long. Try Reset button.<span>
		  </div>";
	echo "<div id='output'></div>";
echo "</div>";
?>
<script src="includes/jquery.js"></script>
<script src="cms/src-min/ace.js"></script>
<textarea class='hide' id='transfer'></textarea>
<button id='run' onclick="get_output()">Run</button>
<button id='reset' onclick='location.reload();'>Reset</button>
<script>
var editor = ace.edit("editor");
    editor.setTheme("ace/theme/tomorrow_night");
    editor.setShowInvisibles(false);
    editor.setShowPrintMargin(false);
    editor.getSession().setMode("ace/mode/c_cpp");
function get_output()
{
	code=editor.getValue();
	$.ajax({
		type:"POST",
		url:"send_output.php",
		data :{coding:code},
		beforeSend:function(){
					$("#loading").show();
					$("#output").hide();
							 },
		complete: function(){
					$("#loading").hide();
					$("output").show();
							},
		success: function(data) {
					document.getElementById('output').innerHTML=data;
							}
			});
}
</script>
