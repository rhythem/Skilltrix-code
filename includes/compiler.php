<script src="includes/tab.js"></script>
<script src="cms/src-min/ace.js"></script>
<link rel="stylesheet" type="text/css" href="includes/tab.css" />
<?php	
//error_reporting(0);
	include('includes/ques_class.php');
	//include('includes/compiler_class.php');
	//include('core/classes/users.php');
	
	$get_ques=new questions();
	
	$c=$_GET['c'];
	$m=$_GET['module'];
	$s=$_GET['sub'];
	$no=$_GET['comp'];
	$eid=$_GET['exer'];
	$link=mysql_connect('localhost','root','dZ8LyUqVBm4rfTD4');
	mysql_select_db('lr');
	$cr1="SELECT course_name FROM course WHERE course_id='$c'";
		$rcr=mysql_query($cr1);
		$rocr=mysql_fetch_array($rcr);
		$mn1="SELECT module_name,module_id FROM modules WHERE module_id='$m'";
		$rmn=mysql_query($mn1);
		$romn=mysql_fetch_array($rmn);
		$mn2=$romn['module_name'];
		$cr2=$rocr['course_name'];
/*		$k=1;
		while($k<=$m){		$romn=mysql_fetch_array($rmn);
		$mn2=$romn['module_name'];
		$mids=$romn['module_id'];		
		$k++;
		}*/
		$min2="SELECT sub_name FROM sub_modules WHERE sub_id='$s'";
		$rmn1=mysql_query($min2);
		$romn1=mysql_fetch_array($rmn1);
		$mn3=$romn1['sub_name'];
		/*		
$r=1;
		while($r<=$s){
		$romn1=mysql_fetch_array($rmn1);
		$mn3=$romn1['sub_name'];
		$r++;
		}*/
		
	$user_name=new users();
	$uid=$_SESSION['user_id'];
	$uname=$user_name->get_username($uid);
	
	/*$int=floor($id);
	$de=$id-$int;
	$dec=explode(".","$de");*/
	
	$get_ques->ques_id=$eid;
	
	$get_ques->get_ques();
	

?>
<div id="uid" class="hide"><?php echo $uid; ?></div>
<div id="qidse" class="hide"><?php echo $get_ques->ques_id; ?></div>
<div id="qidse1" class="hide"><?php echo $m; ?></div>
<div id="sub_id" class="hide"><?php echo $s ; ?></div>
<div id="exe_id" class="hide"><?php echo $eid ; ?></div>
<div id="qe" class="hide"><?php echo $get_ques->ques ;?></div>
<div id="ot" class="hide"><?php echo $get_ques->ot; ?></div>
<div id="chkr" class="hide"><?php echo $get_ques->chkr; ?></div>
<!--<div id="questi" class="small-font"><?php echo "Question. $get_ques->ques  ?"; ?></div>-->
<div id="btn-compiler-bar">
		<div id="excercise" class="lfloat bord small-font">Excercise</div>
		<div id="result" class="lfloat bord small-font">Result</div>
		<div id="hint" class="rfloat bord small-font">Hint</div>	
	</div>
<div id="uname"><?php echo $uname; ?></div>
<div id="q_check"><?php echo "$get_ques->output"; ?></div>
<div id="loading">
<div id="load"><img src="includes/362.gif"/></div><span class="loading-text">Tip: Taking too long. Try Reset button.<span>
</div>
<div id="hint_cont" class="disp"><?php echo "$get_ques->hint" ;?></div>
<div id="res_cont" class="disp">
	</div>
	
	<div id="excer_cont" class="disp">
	<div id="compil_wrap">
	<div id="editor" class="ace_editor"><?php $co=$get_ques->pre_code; 
	
							for($i=0;$i<strlen($co);$i++)
							{
			if($co[$i]=="\n")
			echo "\n";
			else if($co[$i]=="<")
			echo "&lt;";
			else if($co[$i]==">")
			echo "&gt;";
			else
			echo ($co[$i]);
		}
						?></div>
	
	</div>
	<!--Moved this code to module.php under div id=button-container 
	<button onclick="callit()" name="submit" class="rfloat ui-button">Run</button>
		<button onclick="location.reload()" class="rfloat ui-button">Reset</button>
<button id="th_up" onclick="thumb(this)"><img src="includes/thu_up.png"/></button>
		<button id="th_down" onclick="thumb(this)"><img src="includes/thu_dn.png"/></button>
		<button id="report" class="rfloat ui-button" onclick="disp_frm()">Report This Problem!</button>
	<div id="re_frm">Problem You Found in Question<textarea rows="10" cols="30" id="frm1"></textarea><button onclick="send_rep()">Submit</button>
</div>
-->
	</div>
	
	<div id="ccex" class="hide"><?php echo $get_ques->ccex; ?></div>
	<div id="ofex" class="hide"><?php echo $get_ques->ofe; ?></div>


<script>
var editor = ace.edit("editor");
    editor.setTheme("ace/theme/clouds");
    editor.setShowInvisibles(false);
    editor.setShowPrintMargin(false);
    editor.getSession().setMode("ace/mode/c_cpp");
function callit()
{
var x =editor.getValue();
var u = document.getElementById("uname").innerHTML;
var q = document.getElementById("qe").innerHTML;
var k = document.getElementById("qidse").innerHTML;
var k1 = document.getElementById("qidse1").innerHTML;
var subid = document.getElementById("sub_id").innerHTML;
var eid = document.getElementById("exe_id").innerHTML;
var chkr = document.getElementById("chkr").innerHTML;
var ul =document.getElementById("uid").innerHTML;
$.ajax({
   type:"POST",	
   url : "includes/comp.php",
   data:{coding:x,uname:u,ques:q,qid:k},
   beforeSend: function(){
        $("#loading").show();
	$("#compil_wrap").hide();
$("#hint").click(function()
{
$(this).css({'border-top':'5px solid #3079ed','background-color':'white','color':'black'});
$("#result").css({'border-top':'5px solid #ededf0','background-color':'#ededf0','color':'grey'});
$("#excercise").css({'border-top':'5px solid #ededf0','background-color':'#ededf0','color':'grey'});
$("#hint_cont").css({'display':'none'});
$("#excer_cont").css({'display':'none'});
$("#res_cont").css({'display':'none'});
});
   },
   complete: function(){
	  $("#loading").hide();
	$("#compil_wrap").show();
   },
   success: function(data,status) {
   	var dataar=data.split('~');
	$("#hint").click(function()
{
$(this).css({'border-top':'5px solid #3079ed','background-color':'white','color':'black'});
$("#result").css({'border-top':'5px solid #ededf0','background-color':'#ededf0','color':'grey'});
$("#excercise").css({'border-top':'5px solid #ededf0','background-color':'#ededf0','color':'grey'});
$("#hint_cont").css({'display':'block'});
$("#excer_cont").css({'display':'none'});
$("#res_cont").css({'display':'none'});
});
	var ot= document.getElementById("ot").innerHTML;
	var o = document.getElementById("q_check").innerHTML;
	var o1="";
	for(jk=0;jk<o.length;jk++)
	{
	
	if(o[jk]==" ")
	{
	var stg=new String("&nbsp;");
	o1=o1.concat(stg);
	}
	else if(o[jk]=="\n")
	{
	var stg1=new String("<br/>");
	o1=o1.concat(stg1);
	}
	else
	o1=o1.concat(o[jk]);
	}	
	
	if(dataar[1]==1)
	document.getElementById("res_cont").innerHTML="<span class='comp-out'>"+dataar[3]+"</span>"+"<br>"+"<br>";     
	else
document.getElementById("res_cont").innerHTML="<span class='comp-out'>"+dataar[2]+"</span>"+"<br>"+"<br>";
	$("#result").css({'border-top':'5px solid #3079ed','background-color':'white','height':'45px'});
	$("#excercise").css({'border-top':'5px solid #ededf0','background-color':'#ededf0','color':'grey'});
	$("#hint").css({'border-top':'5px solid #ededf0','background-color':'#ededf0','color':'grey'});
	$("#excer_cont").css({'display':'none'});
	$("#res_cont").css({'display':'block'});
	$("#hint_cont").css({'display':'none'});

	if(isNaN(dataar[1]))
		{
			if(dataar[1].match("e"))
			{
				if(chkr=="err")
				{
				if(ot=="exact")
				{
					if(o1==dataar[2])
						{document.getElementById("res_cont").innerHTML+="<span class='correct-output'><h3>Correct Output</h3><br>See the Explanation Box Below.<br>Don't Forget to rate this exercise.</span>";
						$("#explanation").css({'display':'block'});
						$.ajax({
						type:"POST",
						url:"includes/done.php",
						data:{qid:k1,uname:ul,sid:subid,exid:eid}
						});
						}
					else
					{var str5 = $("#ofex").html();
			var n9 = new String("<span class='outfail'>");
			n9=n9.concat(str5);
			var nw = new String("</span>");
			n9=n9.concat(nw);
			document.getElementById("res_cont").innerHTML+=n9;
					}
				
				
				}
				else if(ot=="substr")
				{
					
					
					if(dataar[2].indexOf(o1)!=-1)
						{
						document.getElementById("res_cont").innerHTML+="<span class='correct-output'><h3>Correct Output</h3><br>See the Explanation Box Below.<br>Don't Forget to rate this exercise.</span>";
						$("#explanation").css({'display':'block'});
						$.ajax({
						type:"POST",
						url:"includes/done.php",
						data:{qid:k1,uname:ul,sid:subid,exid:eid}
						});
						}
					else
				{var str8 = $("#ofex").html();
			var na = new String("<span class='outfail'>");
			na=na.concat(str8);
			var nv = new String("</span>");
			na=na.concat(nv);
			document.getElementById("res_cont").innerHTML+=na;
					}
				}		
				else
				{var str4 = $("#ofex").html();
			var n6 = new String("<span class='outfail'>");
			n6=n6.concat(str4);
			var n5 = new String("</span>");
			n6=n6.concat(n5);
			document.getElementById("res_cont").innerHTML+=n6;
					}
				
				}
				else
				{
				document.getElementById("res_cont").innerHTML+="<span class='incorrect-output'><h3>Incorrect Output</h3><br>Try Again!</span>";
				}
			}
			else
			{
				if(chkr=="out")
				{
				if(ot=="exact")
				{
					
					if(o1==dataar[2])
					{
					document.getElementById("res_cont").innerHTML+="<span class='correct-output'><h3>Correct Output</h3><br>See the Explanation Box Below.<br>Don't Forget to rate this exercise.</span>";
					$("#explanation").css({'display':'block'});
					$.ajax({
						type:"POST",
						url:"includes/done.php",
						data:{qid:k1,uname:ul,sid:subid,exid:eid}
						});
					}
					else
					{var str3 = $("#ofex").html();
			var n3 = new String("<span class='outfail'>");
			n3=n3.concat(str3);
			var n4 = new String("</span>");
			n3=n3.concat(n4);
			document.getElementById("res_cont").innerHTML+=n3;
					}
				
				}
				else if(ot=="substr")
				{
					
					if(dataar[2].indexOf(o1)!=-1)
						{
						document.getElementById("res_cont").innerHTML+="<span class='correct-output'><h3>Correct Output</h3><br>See the Explanation Box Below.<br>Don't Forget to rate this exercise.</span>";
						$("#explanation").css({'display':'block'});
						$.ajax({
						type:"POST",
						url:"includes/done.php",
						data:{qid:k1,uname:ul,sid:subid,exid:eid}
						});
						}
					else
				{var str9 = $("#ofex").html();
			var nr = new String("<span class='outfail'>");
			nr=nr.concat(str9);
			var nt = new String("</span>");
			nr=nr.concat(nt);
			document.getElementById("res_cont").innerHTML+=nr;
					}				
				}
				else
				{var str2 = $("#ofex").html();
			var n2 = new String("<span class='outfail'>");
			n2=n2.concat(str2);
			var n7 = new String("</span>");
			n2=n2.concat(n7);
			document.getElementById("res_cont").innerHTML+=n2;
					}
				
				}
				
				else
				{var str1 = $("#ofex").html();
			var np = new String("<span class='outfail'>");
			np=np.concat(str1);
			var n8 = new String("</span>");
			np=np.concat(n8);
			document.getElementById("res_cont").innerHTML+=np;
					}
				
			}
		}
	else
	{
		//now check here for code check and display that explanation
		if(dataar[1]==1)
		{
			var str = $("#ccex").html();
			var n = new String("<span class='codefail'>");
			n=n.concat(str);
			var n1 = new String("</span>");
			n=n.concat(n1)
			document.getElementById("res_cont").innerHTML+=n;

					
				
			$("#explanation").css({'display':'none'});
		}
		//elseif(dataar[0]==2)
		//{$("#ofex").css({'display':'block'});}
		//document.getElementById("res_cont").innerHTML+="<span class='incorrect-output'><h3>Incorrect Output</h3><br>Try Again!</span>";
	}

	
	//get ot from div ot and if it is substr match then make it else otherwise
	
	var le=dataar.length;
	
   }
 });
}
function send_rep()
{
var q=document.getElementById("qidse").innerHTML;
var o=document.getElementById("q_check").innerHTML;
var rep=$("#frm1").val();

var d1 = document.getElementById("qidse").innerHTML;
$.post("includes/write_report.php",
{ques:q,out:o,resp:rep,path:d1},
function(data,status){
$("#re_frm").hide();
$("#report").hide();
});

}
function disp_frm()
{
$("#re_frm").show();
}
function thumb(obj)
{
var u = document.getElementById("uname").innerHTML;
var d = document.getElementById("qidse").innerHTML;
if(obj.id=="th_up")
{
$.post("includes/th.php",
{up:1,path:d,uname:u},function(data,status){$("#th_up").hide();$("#th_down").hide();});
}
else
{$.post("includes/th.php",
{up:0,path:d,uname:u},
function(data,status){$("#th_up").hide();$("#th_down").hide();}
);}
}
</script>
