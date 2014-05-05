<script src="includes/jquery.js"></script>
<script src="css/jquery.mCustomScrollbar.css"></script>
<style>
.hide
{
display:none;
}
#editor
{
height:100%;
width:50%;
}
.lfloat
{
float:left;
}
.rfloat
{float:right;}
.ace_scrollbar{
overflow-y:auto!important;
}

#editor{
background:#1D1F21;
}
</style>
<?php
//Coding area
echo "<div id='editor' class='lfloat'></div>";

//Output Area
echo "<div id='output-container' class='lfloat'>";
	echo "<div id='loading' class='hide'>
				<div id='load'><img src='includes/362.gif'/></div><span class='loading-text'>Tip: Taking too long. Try Reset button.<span>
		  </div>";
	echo "<div id='output'></div>";
echo "</div>";
?>
<script src="script/jquery.mCustomScrollbar.min.js"></script>
<script src="cms/src-min/ace.js"></script>
<textarea class='hide' id='transfer'></textarea>
<button id='run' onclick="get_output()">Run</button>
<button id='reset' onclick='location.reload();'>Reset</button>
<script>
var editor = ace.edit("editor");
    editor.setTheme("ace/theme/tomorrow_night");
    editor.setShowInvisibles(false);
    editor.setShowPrintMargin(false);
	editor.resize();
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
					$("#output").show();
							},
		success: function(data) {
					document.getElementById('output').innerHTML=data;
							}
			});
}
</script>
<script>
    (function($){
        $(window).load(function(){
            $(".ace_scrollbar").mCustomScrollbar();
$(".content").mCustomScrollbar({
    theme:"light"
});
        });
    })(jQuery);
</script>
