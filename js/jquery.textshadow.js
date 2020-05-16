/*
 * jQuery textShadow plugin
 * Version 1.0 (27/10/2008)
 * @requires jQuery v1.2+
 *
 * Copyright (c) 2008 Kilian Valkhof (kilianvalkhof.com)
 * Dual licensed under the MIT and GPL licenses:
 * http://www.opensource.org/licenses/mit-license.php
 * http://www.gnu.org/licenses/gpl.html
 *
 */
(function($){
	$.fn.textShadow = function(useroptions) {			
		return this.each(function() {  	
			var obj = $(this);
			obj.removeTextShadow();
			var shadowarray = obj.css("text-shadow").split(" ");
			var sradi = parseInt(shadowarray[3]);
			var text = "<span class='jQshad'>" + obj.html() + "</span>";
			
			var padding = {
				left:parseInt(obj.css("padding-left")),
				top:parseInt(obj.css("padding-top"))
			};
			
			var defaults = {
				color: shadowarray[0],
				radius: sradi,
				xoffset: parseInt(shadowarray[1])-1+(padding.left-sradi) + "px",
				yoffset: parseInt(shadowarray[2])-1+(padding.top-sradi) + "px",
				opacity: 50
			};
			var options = $.extend(defaults, useroptions); 
			options.color = (options.color.length == 4) ? options.color.replace(/#([0-9A-f])([0-9A-f])([0-9A-f])/i, '#$1$1$2$2$3$3') : options.color;
			
			if($.browser.msie && options != "") {
				obj.css({"position":"relative","zoom":"1"}).append(text);	
				obj.children("span.jQshad").css({
					"position":"absolute",
					"z-index":"-1",
					"zoom":"1",
					"left":options.xoffset,
					"top":options.yoffset,
					"color":options.color,
					"filter":"progid:DXImageTransform.Microsoft.Glow(Color="+options.color+",Strength="+(options.radius/6)+") progid:DXImageTransform.Microsoft.Blur(pixelradius="+options.radius+", enabled='true') progid:DXImageTransform.Microsoft.Alpha(opacity="+options.opacity+")",
					"-ms-filter":"\"progid:DXImageTransform.Microsoft.Glow(Color="+options.color+",Strength="+(options.radius/6)+") progid:DXImageTransform.Microsoft.Blur(pixelradius="+options.radius+", enabled='true') progid:DXImageTransform.Microsoft.Alpha(opacity="+options.opacity+")\""
				});
			}
		});  
	};
	
	$.fn.removeTextShadow = function() {
		return this.each(function() {
			$(this).children("span.jQshad").remove();
		});
	};
})(jQuery);