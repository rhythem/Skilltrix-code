$(document).ready( function () {
$('.search_button').click(function(){
	$('.searchbox-container').fadeIn('fast');
});
left_menu_toggle('hide');
/********************************************/

$('.link-scroll').on('click',function (e) {
	    e.preventDefault();
	    var target = this.hash,
	    $target = $(target);
	    $('html, body').stop().animate({
	        'scrollTop': $target.offset().top
	    }, 900, 'swing', function () {
	        window.location.hash = target;
	    });
	});

/*******************************************
* Progress bar 
********************************************/
		var height =300;
		var percent=10; /* Fetch from database*/
		var green = (height*percent)/100;
		var white = height - green;
		$('.whitebar').css('height',white);
		$('.greenbar').css('height',green);

		h = $('#ui-center-module').css('height');
		$('#ui-center-right').css('min-height',h);
	
//very important. Do not remove ever
	var margin = $('#ui-left-menu-wrap').css('width');
	$('#MainContainer').css('margin-left',margin);
///////////////////////////////////////////////////////////
  var windowWidth = $(window).width();
    var windowHeight =$(window).height();
    $('#ui-center-module').css({'width':windowWidth*0.65 });


	$(function(){
		$('.inner-content-div').slimScroll({
		    height: '400px',
			railVisible: true,
			disableFadeOut: true
		});
	});
/***************************************************/

/*********************************************************/

	$('.MenuButton').click(function() {
		$('#menucontainer').toggle("fast");
		$('#MainContainer').click(function(){
			$('#menucontainer').hide();
			$('#menucontainer').hide();
		});

	});
	
	
	$('#ui-menu-image').click(function(){
		
		left_menu_toggle("show");
		left_menu_bio_toggle('show');
		$(this).hide();
		$('.module-number-js span.module-number-select').removeClass('bg-black selected');
		$('.module-number-js div.module-components').removeClass('module-component-stylize');
		$(".menu-text span").css("padding-left","5px");
		});
		
	$('#close-image').click(function(){
		close_left_menu();
		
	});
	$('.module-number-js').click(function(){
		var aclass = $('.module-number-js span.module-number-select').attr('class');
		var id=$(this).attr('id');
		$(".menu-text span").css("padding-left","10px");
		
		left_menu_toggle("show");
		module_component_toggle("show",id);
	
		id_select="#"+id+"  span.module-number-select";
		id_comp="#"+id+" div.module-components";
	
		module_class_toggle("remove",".module-number-js span.module-number-select",".module-number-js div.module-components");
		module_class_toggle("add",id_select,id_comp);
		$('#close').click(function(){
		left_menu_toggle("hide");
		module_component_toggle("hide",id);
		$('span.module-number-select').removeClass('bg-black selected');
	});
	});
	$('#center-container').click(function(){
		close_left_menu();
		
	});

});
function close_left_menu(){
	left_menu_toggle("hide");
	left_menu_bio_toggle('hide');
	$(" .module-components").hide();
	$(".menu-text span").css("padding-left","0px");
	$('.module-number-js span.module-number-select').removeClass('bg-black selected');
	$('.module-number-js div.module-components').removeClass('module-component-stylize');
}
function module_class_toggle(mode,id_select,id_comp){
	if(mode=="add"){
		$(id_select).addClass('bg-black selected');
		$(id_comp).addClass('module-component-stylize');
	} else if(mode=="remove"){
		$(id_select).removeClass('bg-black selected');
		$(id_comp).removeClass('module-component-stylize');
	}
}
function module_component_toggle(mode,id){
	if(mode=="show"){
		left_menu_bio_toggle("show");
		module_word_toggle("show");
		id_comp = "#"+id+" div.module-components";
		id_word = "#"+id+" span span.module-word";
		$(id_comp).show();
		$(id).show();
	}else if(mode=="hide"){
		module_word_toggle("hide");
		$(" .module-components").hide();
		
	}
}

function module_word_toggle(mode){
	
	if(mode=="show"){
		$('.module-word').css('display','inline-block');
		$('.module-word').css('overflow','hidden');
		$('.module-word').css('padding-top','3px');
		$('.module-word').css('height','34px');
		$('.module-word').css('padding-left','0px');
		
	}else if(mode=="hide"){
		$('.module-word').hide();
	}
}
function left_menu_bio_toggle(mode){
	if(mode=='hide'){
		$('#ui-user-profile-container').hide();
		module_word_toggle("hide")
		$('#ui-menu-image').show();
		$("#close").show();
		$('.disp_num').show();
	}else if(mode=='show'){
		$('#ui-user-profile-container').show();
		module_word_toggle("show");
		$("#close").hide();
		$('#ui-menu-image').hide();
		$('.disp_num').hide();
	}
}

function left_menu_toggle(mode){
	if(mode=="show"){
		module_component_toggle("hide");
		$('#module-name').show();
		$('#left-menu-continer').animate({
		width: "220px"
		},100);
		$('#ui-menu-container').animate({
		width: "220px"
		},100);
		$('.module-number-select').removeClass('center');
	} else if(mode=="hide"){
		
		$('#module-name').hide();
		$('#left-menu-continer').animate({
			width: "51px"
		},100);
		$('#ui-menu-container').animate({
			width: "51px"
		},100);
		$('.module-number-select').addClass('center');
	}
}
function resendactivation(){
	var data = $('#resendemail').val();
	if(data!= ''){
		$.ajax({
			type: "POST",
			url: "ajax/resend.php",
			data: {email: data},
			success: function(message){
				if(message == 'True'){
					$('.error-container span ul li').html('Email sent please activate your account.');
					$('#widget').css('background','#DFF2BF');
				}else{
					$('.error-container span ul li').html('<span class="error block">There was some error please try again.</span>');
					$('#widget').css('background','#FFBABA');
				}
			}
		});
	}else{
		$('.error-container span ul li').html('<span class="error block">Please enter an email id.</span>');
		$('#widget').css('background','#FFBABA');
	}
}