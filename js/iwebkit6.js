//iWebKit 6.0 javascript

var type;
var orientation=window.orientation;

function ios4fix() {
		if($.os.version < "5"){
		if($.os.ipad){$('body > #content').css('margin-top','44px').css('height','auto');};
		if($.os.iphone){if(orientation == '90' || orientation == '-90'){$('body > #content').css('margin-top','32px').css('height','auto')};
		if(orientation == '0' || orientation == '180'){$('body > #content').css('margin-top','44px').css('height','auto')}};	
		var contentheight = $('#content').height();
		var ipadmenuheight = $('#ipadmenu').height();
		if($.os.ipad && ipadmenuheight < contentheight){$('#ipadmenu').css('height', contentheight + 'px');$('body > footer').css('position','absolute').css('top',(contentheight + 44) + 'px');};
		if($.os.ipad && ipadmenuheight > contentheight){$('#content').css('height', ipadmenuheight + 'px');$('body > footer').css('position','absolute').css('top',(ipadmenuheight + 44) + 'px');};
		if($.os.iphone){$('body > footer').css('position','static');};
		}
		};
		
function ipadmenuslide(direction,direction2,nextmenu,currentmenu){$("[data-order='" + nextmenu + "']").css("-webkit-transform", "translate("+direction+"300px,0)").css('display','block');
setTimeout(function () {
$("[data-order='" + nextmenu + "']").css("-webkit-transition-duration", "0.4s").css("-webkit-transform", "translate(0,0)");
$("[data-order='" + currentmenu + "']").css("-webkit-transition-duration", "0.4s").css("-webkit-transform", "translate("+direction2+"300px,0)");
}, 1);setTimeout(function () {$('.current').css('display','none').removeClass('current');$("[data-order='" + nextmenu + "']").addClass('current');ipadmenu()}, 400);}

function ipadmenuintercept(link){var currentmenu = $('.current').data('order');
var nextmenu = parseInt(/#(\d+)/.exec(link)[1]);
if (nextmenu > currentmenu){var direction = "";direction2 = "-";ipadmenuslide(direction,direction2,nextmenu,currentmenu)}
else{var direction = "-";direction2 = "";ipadmenuslide(direction,direction2,nextmenu,currentmenu)}};

function ipadmenu(){
 
var ipadtopbar = $('nav').first().attr('data-ipadnav');
if(ipadtopbar = 'left'){
var previousmenu = $("#ipadmenu section.current").data('order') - 1;
var nextmenu = Number($("#ipadmenu section.current").data('order')) + 1;
var title = '<h1>'+$('#ipadmenu > .current').attr('data-title')+'</h1>';
var leftnavname = $('#ipadmenu > .current').attr('data-leftnav');
var leftnav = '<a class="leftnav generated" href="#'+previousmenu+'"  data-nav-type="arrow">'+ leftnavname +'</a>';
var rightnavname = $('#ipadmenu > .current').attr('data-rightnav');
var rightnav = '<a class="rightnav generated" href="#'+nextmenu+'"  data-nav-type="arrow">'+ rightnavname +'</a>';
if(leftnavname == undefined && rightnavname != undefined){$('nav').first().html(rightnav)}
if(leftnavname != undefined && rightnavname == undefined){$('nav').first().html(leftnav)}
if(leftnavname != undefined && rightnavname != undefined){$('nav').first().html(leftnav+rightnav)}
if($('#ipadmenu > .current').attr('data-title') != undefined){$('nav').first().append(title)}};

};


function transition(type){
	function newlayout(){

		$('head > title').text($('body > title').text());		
		$('.oldcontent').remove();
		ipadmenu();
		$('body > meta').remove();
		$('body > script').remove();
		$('body > link').remove();
		$('body > title').remove();
		updateOrientation();
		ios4fix();
		
		
	};	
	function slide(dir,dir2){
		var hdistance = $('#content').width();
		var currentipadmenu = $('#ipadmenu.oldcontent')[0];
		var nextipadmenu = $('#ipadmenu.newcontent')[0];
		var currentfooter = $('footer.oldcontent')[0];
		var nextfooter = $('footer.newcontent')[0];
		if(currentipadmenu != undefined && nextipadmenu != undefined){$('#ipadmenu.newcontent').css('opacity','0')};
		$('body > header.newcontent').css("opacity", "0");if(nextipadmenu == undefined){var hdistance = $('body').width()};
		$('body > header.newcontent').find('h1').css("-webkit-transform", "translate("+ dir + hdistance +"px,0)");
		$('body > header.newcontent').find('nav').css("-webkit-transform", "translate("+ dir + hdistance/2+"px,0)");
		if((nextipadmenu == undefined) || (nextipadmenu != undefined && currentipadmenu == undefined)){$('body > #content.newcontent').css("-webkit-transform", "translate("+ dir + $('body').width() +"px,0)");}
		else{$('body > #content.newcontent').children().css("-webkit-transform", "translate("+ dir + hdistance +"px,0)");};
		if(nextipadmenu != undefined && currentipadmenu == undefined && $.os.ipad){$('body > #ipadmenu.newcontent').css("-webkit-transform", "translate("+ dir + hdistance +"px,0)");};
		if(currentfooter == undefined && nextfooter != undefined){$('body > footer.newcontent').css("opacity", "0").css("-webkit-transform", "translate(0,0)")};
		if(currentfooter != undefined && nextfooter != undefined){$('body > footer.newcontent').find('a').css('opacity','0');};	
		if($.os.version < "5"){$('body > #content').css('height','auto');$('body > footer').css('position','static');};
		setTimeout(function () {
		if(currentipadmenu != undefined && nextipadmenu != undefined){;$("#ipadmenu.oldcontent").css("-webkit-transition", "opacity 0.4s linear").css('opacity','0');$("#ipadmenu.newcontent").css("-webkit-transition", "opacity 0.4s linear").css('opacity','1')}
		$('body > header.newcontent').css("-webkit-transition", "opacity 0.4s linear").css("opacity", "1");
		if((nextipadmenu == undefined) || (nextipadmenu != undefined && currentipadmenu == undefined)){$('#ipadmenu.oldcontent').css("-webkit-transition-duration", "0.4s").css("-webkit-transform", "translate("+ dir2 + hdistance +"px,0)");
		$('body > #content.oldcontent').css("-webkit-transition-duration", "0.4s").css("-webkit-transform", "translate("+ dir2 + hdistance +"px,0)");
		$('body > #content.newcontent').css("-webkit-transition-duration", "0.4s").css("-webkit-transform", "translate(0,0)");}
		else{
		$('body > #content.oldcontent').children().css("-webkit-transition-duration", "0.4s").css("-webkit-transform", "translate("+ dir2 + hdistance +"px,0)");
		$('body > #content.newcontent').children().css("-webkit-transition-duration", "0.4s").css("-webkit-transform", "translate(0,0)");
		}
		if(nextipadmenu != undefined && currentipadmenu == undefined){$('#ipadmenu.newcontent').css("-webkit-transition-duration", "0.4s").css("-webkit-transform", "translate(0,0)");}
		$('body > header.oldcontent').find('nav').css("-webkit-transition-duration", "0.4s").css("-webkit-transform", "translate("+ dir2 + hdistance/2 +"px,0)");
		$('body > header.oldcontent').find('h1').css("-webkit-transition-duration", "0.4s").css("-webkit-transform", "translate("+ dir2 + hdistance +"px,0)");
		$('body > header.newcontent').find('h1').css("-webkit-transition-duration", "0.4s").css("-webkit-transform", "translate(0,0)");
		$('body > header.newcontent').find('nav').css("-webkit-transition-duration", "0.4s").css("-webkit-transform", "translate(0,0)");
		$('body > footer.newcontent').css("-webkit-transition", "opacity 0.4s linear").css("opacity", "1");
		if(nextfooter == undefined){$('body > footer.oldcontent').css("-webkit-transition", "opacity 0.4s linear").css("opacity", "0")};
		if(currentfooter != undefined && nextfooter != undefined){$('body > footer.oldcontent').find('a').css("-webkit-transition", "opacity 0.4s linear").css("opacity", "0");
		$('body > footer.newcontent').find('a').css("-webkit-transition", "opacity 0.4s linear").css("opacity", "1");}
		
		setTimeout(function () {newlayout();}, 400);
		}, 1);
			
		}
	if (type == 'Lslide'){var dir = "-";var dir2 = "";slide(dir, dir2)};
	if (type == 'Rslide'){var dir = "";var dir2 = "-";slide(dir, dir2)};
	if (type == 'none'){newlayout()};
	}

function touchresponse() {
	$('header a').live('touchstart', function(e){
		  $(this).addClass('click');
           		
		});
		$('#content a, input').live('touchstart', function(e){
		$(this).addClass('temp');
		setTimeout(function () {
                $('.temp').addClass('click');
            }, 100);		
		});
	
	 $('a, input').live("touchmove", function (e) {
		 	$('.temp').removeClass('temp');
            setTimeout(function () {$('.click').removeClass('click')}, 60);
        });	
		$('header>nav>a').live("touchend", function (e) {
		   $('.temp').removeClass('temp');
           $('.click').removeClass('click');
        });	
		
	};

function ajax(){
	$('a').live('click', function(e){
		if(($(this).parent().data('ipadnav') == 'left') && $(this).hasClass('generated')){var link = $(this).attr('href');e.preventDefault();ipadmenuintercept(link)}else{
		if($(this).hasClass('leftnav') | $(this).attr('data-transition') == 'Lslide'){type = 'Lslide'}
		else if(($(this).hasClass('rightnav')) || ($(this).attr('data-transition') == 'Rslide') || ($(this).parents('nav').attr('data-image-type'))){type = 'Rslide'}
		else{type = 'none'};
		e.preventDefault();
		var href = e.target.href;
		window.history.pushState(null, "", href );
		$.get(href, function (data) {
		var tempdiv = '<div class="tempdiv"></div>';
		$('body').append(tempdiv);
		$('.tempdiv').append(data);
		$('body>header,body>#ipadmenu,body>#content,body>footer').removeClass('newcontent').addClass('oldcontent');
		$('.tempdiv>header,.tempdiv>#ipadmenu,.tempdiv>#content,.tempdiv>footer').addClass('newcontent');
		$('body').append($('.tempdiv').html());
		$('.tempdiv').remove();
		transition(type);
		});
		
		}});	
}
function backbutton(){
	$(window).bind("popstate", function() {
		var current = location.href;		
		$.get(current, function (data) {
		var tempdiv = '<div class="tempdiv"></div>';
		$('body').append(tempdiv);
		$('.tempdiv').append(data);
		$('body>header,body>#ipadmenu,body>#content,body>footer').removeClass('newcontent').addClass('oldcontent');
		$('.tempdiv>header,.tempdiv>#ipadmenu,.tempdiv>#content,.tempdiv>footer').addClass('newcontent');
		$('body').append($('.tempdiv').html());
		$('.tempdiv').remove();
		if (type == undefined){type = 'none'}
		else if(type == 'Lslide'){type = 'Rslide'}
		else if (type == 'Rslide'){type = 'Lslide'}
		else {type = 'none'};
		transition(type);
		});
	})};
function updateOrientation(){  
if($.os.version > "4"){
var footer = document.getElementsByTagName('footer')[0];
if(orientation == '0' || orientation == '180'){
if (navigator.standalone && footer != null && $.os.iphone) {$('#content, #ipadmenu').css('height','372px')}
if (!navigator.standalone && footer == null && $.os.iphone) {$('#content, #ipadmenu').css('height','372px')}
if (!navigator.standalone && footer != null && $.os.iphone) {$('#content, #ipadmenu').css('height','328px')}
if (!navigator.standalone && footer != null && $.os.ipad) {$('#content, #ipadmenu').css('height','840px')}
if (navigator.standalone && footer != null && $.os.ipad) {$('#content, #ipadmenu').css('height','916px')}
if (!navigator.standalone && footer == null && $.os.ipad) {$('#content, #ipadmenu').css('height','884px')}
if (navigator.standalone && footer == null && $.os.ipad) {$('#content, #ipadmenu').css('height','960px')}
if (footer != null){$('#content, #ipadmenu').css('margin-bottom','44px')}
}
if(orientation == '90' || orientation == '-90'){
if (navigator.standalone && footer != null && $.os.iphone) {$('#content, #ipadmenu').css('height','236px')}
if (!navigator.standalone && footer == null && $.os.iphone) {$('#content, #ipadmenu').css('height','236px')}
if (!navigator.standalone && footer != null && $.os.iphone) {$('#content, #ipadmenu').css('height','204px')}
if (!navigator.standalone && footer != null && $.os.ipad) {$('#content, #ipadmenu').css('height','584px')}
if (navigator.standalone && footer != null && $.os.ipad) {$('#content, #ipadmenu').css('height','660px')}
if (!navigator.standalone && footer == null && $.os.ipad) {$('#content, #ipadmenu').css('height','646px')}
if (navigator.standalone && footer == null && $.os.ipad) {$('#content, #ipadmenu').css('height','704px')}
if ($.os.iphone && footer != null){$('#content, #ipadmenu').css('margin-bottom','32px')}
if ($.os.ipad && footer != null){$('#content, #ipadmenu').css('margin-bottom','44px')}
}}
};

$(document).ready(function(){
	window.scrollTo(0,0.9);
	ajax();	
	backbutton();
	touchresponse();
	ios4fix();
})
window.onorientationchange=updateOrientation;
 
    