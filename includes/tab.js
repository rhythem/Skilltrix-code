$(document).ready(function() {

$("#explanation").css({'display':'none'});
$("#loading").hide();
$("#re_frm").hide();

$("#excercise").css({'border-top':'5px solid #3079ed','background-color':'white','height':'45px'});
$("#hint").css({'border-top':'5px solid #ededf0','color':'grey','height':'45px'});
$("#result").css({'border-top':'5px solid #ededf0','color':'grey','height':'45px'});
$("#excer_cont").css({'display':'inline'});
$("#result").click(function()
{
$(this).css({'border-top':'5px solid #3079ed','background-color':'white','color':'black','height':'45px'});
$("#excercise").css({'border-top':'5px solid #ededf0','background-color':'#ededf0','color':'grey'});
$("#hint").css({'border-top':'5px solid #ededf0','background-color':'#ededf0','color':'grey'});
$("#excer_cont").css({'display':'none'});
$("#res_cont").css({'display':'block'});
$("#hint_cont").css({'display':'none'});
}
);

$("#excercise").click(function()
{
$(this).css({'border-top':'5px solid #3079ed','background-color':'white','color':'black','height':'45px'});
$("#result").css({'border-top':'5px solid #ededf0','background-color':'#ededf0','color':'grey'});
$("#hint").css({'border-top':'5px solid #ededf0','background-color':'#ededf0','color':'grey'});
$("#excer_cont").css({'display':'inline'});
$("#res_cont").css({'display':'none'});
$("#hint_cont").css({'display':'none'});}
);

$("#hint").click(function()
{
$(this).css({'border-top':'5px solid #3079ed','background-color':'white','color':'black'});
$("#result").css({'border-top':'5px solid #ededf0','background-color':'#ededf0','color':'grey'});
$("#excercise").css({'border-top':'5px solid #ededf0','background-color':'#ededf0','color':'grey'});
$("#hint_cont").css({'display':'block'});
$("#excer_cont").css({'display':'none'});
$("#res_cont").css({'display':'none'});
});
});