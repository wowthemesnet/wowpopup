/*
WowPopup Plugin
Copyright 2016, Sal @wowthemesnet(https://www.wowthemes.net)
*/


/*! * Outer Height hidden plugin, licensed under the MIT
Copyright 2012, Ben Lin (http://dreamerslab.com/)
* Version: 1.0.18
* Requires: jQuery >= 1.2.3
*/
(function(a) {
	if (typeof define === "function" && define.amd) {
		define(["jquery"], a);
	} else {
		a(jQuery);
	}
}(function(a) {
	a.fn.addBack = a.fn.addBack || a.fn.andSelf;
	a.fn.extend({
		actual: function(b, l) {
			if (!this[b]) {
				throw '$.actual => The jQuery method "' + b + '" you called does not exist';
			}
			var f = {
				absolute: false,
				clone: false,
				includeMargin: false,
				display: "block"
			};
			var i = a.extend(f, l);
			var e = this.eq(0);
			var h, j;
			if (i.clone === true) {
				h = function() {
					var m = "position: absolute !important; top: -1000 !important; ";
					e = e.clone().attr("style", m).appendTo("body");
				};
				j = function() {
					e.remove();
				};
			} else {
				var g = [];
				var d = "";
				var c;
				h = function() {
					c = e.parents().addBack().filter(":hidden");
					d += "visibility: hidden !important; display: " + i.display + " !important; ";
					if (i.absolute === true) {
						d += "position: absolute !important; ";
					}
					c.each(function() {
						var m = a(this);
						var n = m.attr("style");
						g.push(n);
						m.attr("style", n ? n + ";" + d : d);
					});
				};
				j = function() {
					c.each(function(m) {
						var o = a(this);
						var n = g[m];
						if (n === undefined) {
							o.removeAttr("style");
						} else {
							o.attr("style", n);
						}
					});
				};
			}
			h();
			var k = /(outer)/.test(b) ? e[b](i.includeMargin) : e[b]();
			j();
			return k;
		}
	});
}));


/*!
 *  Based on the original by Frederick Giasson (2012) -- Dual licensed under the MIT or GPL Version 2 licenses
 */
(function(factory){if(typeof define==='function'&&define.amd){define(['jquery'],factory)}else if(typeof exports==='object'){module.exports=factory(require('jquery'))}else{factory(jQuery)}}(function($){var pluses=/\+/g;function encode(s){return config.raw?s:encodeURIComponent(s)}
function decode(s){return config.raw?s:decodeURIComponent(s)}
function stringifyCookieValue(value){return encode(config.json?JSON.stringify(value):String(value))}
function parseCookieValue(s){if(s.indexOf('"')===0){s=s.slice(1,-1).replace(/\\"/g,'"').replace(/\\\\/g,'\\')}
try{s=decodeURIComponent(s.replace(pluses,' '));return config.json?JSON.parse(s):s}catch(e){}}
function read(s,converter){var value=config.raw?s:parseCookieValue(s);return $.isFunction(converter)?converter(value):value}
var config=$.cookie=function(key,value,options){if(arguments.length>1&&!$.isFunction(value)){options=$.extend({},config.defaults,options);if(typeof options.expires==='number'){var days=options.expires,t=options.expires=new Date();t.setMilliseconds(t.getMilliseconds()+days*864e+5)}
return(document.cookie=[encode(key),'=',stringifyCookieValue(value),options.expires?'; expires='+options.expires.toUTCString():'',options.path?'; path='+options.path:'',options.domain?'; domain='+options.domain:'',options.secure?'; secure':''].join(''))}
var result=key?undefined:{},cookies=document.cookie?document.cookie.split('; '):[],i=0,l=cookies.length;for(;i<l;i++){var parts=cookies[i].split('='),name=decode(parts.shift()),cookie=parts.join('=');if(key===name){result=read(cookie,value);break}
if(!key&&(cookie=read(cookie))!==undefined){result[name]=cookie}}
return result};config.defaults={};$.removeCookie=function(key,options){$.cookie(key,'',$.extend({},options,{expires:-1}));return!$.cookie(key)}}))

/*!
 * jQuery Enhanced Cookie Plugin v1.2.2 (2014) -- https://github.com/t0mtaylor/jquery-enhanced-cookie/ -- Based on the original by Frederick Giasson (2012) -- Dual licensed under the MIT or GPL Version 2 licenses
 * 		Should now return 'undefined' if cookie or local/sessionStorage key doesn't exist, same behaviour as $.cookie
 * 		-- Tom Taylor - 03/07/14 - http://tommytaylor.co.uk
 */
!function(a){"function"==typeof define&&define.amd?define(["jquery"],a):"object"==typeof exports?a(require("jquery")):a(jQuery)}(function(a){var b=window,c={},d={ls:0,ss:0,jse:b.JSON&&b.JSON.parse,n:null,u:void 0},e=function(a){return j.raw?a:encodeURIComponent(a)},f=function(a){return j.raw?a:decodeURIComponent(a)},g=function(a,c){return d.jse&&j.json?c?e(b.JSON.stringify(a)):f(b.JSON.parse(a)):String(a)},h={read:{storage:function(a){if(d.ls||d.ss){var b=a in d.ls?d.ls:a in d.ss?d.ss:0;if(b)return c.v=b.getItem(f(a)),c.v=c.v!==d.u&&c.v!==d.n?g(c.v,0):d.u,c.v}},cookie:function(b){if((!c.st||!c.o.uls||c.st&&c.o.ucc)&&a.cCookie){var e="",f=c.o.mnc;for(i=0;f>i;i++){if(e=a.cCookie(b+(0!==i?c.o.cpf+i:"")),e===d.u){0===i&&c.v!==d.u&&(c.v===d.n||0===c.v.length)&&(c.v=d.u);break}0===i&&(c.v=""),c.v+=e}return c.v}}},add:{storage:function(a,b){c.o.uls&&c.st&&(c.d=g(b,1),c.st.setItem(e(a),c.d))},cookie:function(b,e){if(a.cCookie){var f=e.match(new RegExp(".{1,"+c.o.mcs+"}","g"));if(f!==d.u){var g=f.length;for(i=0;g>i;i++)c.d=a.cCookie(b+(0!==i?c.o.cpf+i:""),f[i],c.o)}else c.d=a.cCookie(b,e,c.o)}}},remove:{storage:function(a){c.st&&a in c.st&&c.st.removeItem(f(a))},cookie:function(b){if((!c.st||!c.o.uls||c.st&&c.o.ucc)&&a.cCookie){var g,e=a.extend(1,c.o,{expires:-1}),f=c.o.mnc;for(i=0;f>i&&(g=b+(0!==i?e.cpf+i:""),a.cCookie(g)!==d.u);i++)a.cCookie(g,d.n,e)}}}},j=a.enhancedCookie=function(b,e,f){return!arguments.length>0||a.isFunction(e)?a.cCookie():(c={},f===d.u&&e!==d.u&&(f=e),c.o=a.extend({},j.defaults,a.extend(1,j.options,a.extend(1,j,f)))||{},c.st=c.o.expires!==d.u?d.ls:d.ss,"[object Object]"!==String(e)&&e!==d.u?(c.d=d.n,e===d.n||e===d.u?(h.remove.storage(b),h.remove.cookie(b)):c.o.uls&&c.st?(h.add.storage(b,e),c.o.ucc&&h.remove.cookie(b)):h.add.cookie(b,e),c.d):(c.v=d.u,h.read.storage(b),h.read.cookie(b),c.v))};j.defaults={mcs:3e3,mnc:20,cpf:"-cc"},j.options={uls:1,ucc:0},function(a,b){var d,e,f,g,c=[{n:"local",t:"ls"},{n:"session",t:"ss"}],h=c.length;for(d=0;h>d;d++)if(e=c[d],f=e.n+"Storage",!b[e.t]&&f in a&&typeof Storage!==b.u)try{g=a[f],g.setItem(f,1),g.removeItem(f),b[e.t]=g}catch(i){}}(b,d),a.cookie&&(a.cCookie=function(a){return a.cookie}(a),a.cookie=a.extend(1,a.cookie,a.enhancedCookie),a.cookie=a.enhancedCookie,a.removeCookie&&(a.removeCookie=function(b,c){return a.cookie(b,null,c||{expires:-1})}))});


// Our Init
var $ = jQuery.noConflict();
jQuery(window).bind("load", function() {
$(".wowgettheid").each( function() {
var $div = $(this);
var wowdata = $div.data('wowdata');
var cdata = window[wowdata];


if ($(cdata.popupostid).find("div").hasClass("StayInMiddle")) {
		$(cdata.popupostid).addClass("wowpopup-overlay");
		$(cdata.popupostid).find(".StayInMiddle").each(function() {
		$(this).css("position", "absolute");
		$(this).css("left", "50%");
		$(this).css("margin-left", -$(this).outerWidth() / 2);
		$(this).css("top", "50%");
		$(this).css("margin-top", -$(this).actual('outerHeight') / 2);
			return this;
		});
	}
if ($(cdata.popupostid).find("div").hasClass("FlyInLeft")) {
		$(cdata.popupostid).find(".FlyInLeft").each(function() {
			$(cdata.popupostid).css("position", "fixed");
			$(cdata.popupostid).css("width", "100%");
			$(cdata.popupostid).css("z-index", "99998");
			$(cdata.popupostid).css("bottom", "0");
			$(this).css("position", "absolute");
			$(this).css("left", "0px");
			$(this).css("margin-left", "0");
			$(this).css("top", "100%");
			$(this).css("margin-top", -$(this).actual('outerHeight'));
			$(this).css("bottom", "0px");
			$(this).find('.insidepopup').css("border-radius", "0");
			$(this).find('.topimg').css("border-radius", "0");
			return this;
		});
	}
if ($(cdata.popupostid).find("div").hasClass("FlyInRight")) {
			$(cdata.popupostid).find(".FlyInRight").each(function() {
			$(cdata.popupostid).css("position", "fixed");
			$(cdata.popupostid).css("width", "100%");
			$(cdata.popupostid).css("bottom", "0");
			$(cdata.popupostid).css("z-index", "99998");
			$(this).css("position", "absolute");
			$(this).css("right", "0");
			$(this).css("top", "100%");
			$(this).css("margin-top", -$(this).actual('outerHeight'));
			$(this).css("bottom", "0px");
			$(this).find('.insidepopup').css("border-radius", "0");
			$(this).find('.topimg').css("border-radius", "0");
			$(this).find('.wowpopup-closebutton').css("left", "-12px");
			return this;
		});
	}
if ($(cdata.popupostid).find("div").hasClass("SimpleTopBar")) {
		$(cdata.popupostid).find(".SimpleTopBar").each(function() {
			$(cdata.popupostid).css("position", "fixed");
			$(cdata.popupostid).css("width", "100%");
			$(cdata.popupostid).css("z-index", "99998");
			$(cdata.popupostid).css("top", "0");
			$(this).css("position", "absolute");
			$(this).css("right", "0px");
			$(this).css("margin-left", "0");
			$(this).css("top", "0");
			$(this).css("width", "100%");
			$('.admin-bar .SimpleTopBar').css("top", "32px");
			$(this).css("margin-top", '0');
			$(this).find('.insidepopup').css("border-radius", "0");
			$(this).find('.insidepopup').css("box-shadow", "0 1px 13px rgba(0,0,0,0.2)");
			$(this).find('.topimg').css("display", "none");
			$(this).find('.wowpopup-closebutton').css("top", "10px");
			$(this).find('.wowpopup-closebutton').css("right", "15px");
			$(this).find('.wowpopup-button').css("padding", "7px 15px");
		  $(this).find('.wowclearfix').css("clear", "none");
			$(this).find('.wowclearfix').css("float", "right");
			$(this).find('.wowpopup-text').css("padding", "16px 10%");
			return this;
		});
	}
if ($(cdata.popupostid).find("div").hasClass("SimpleBottomBar")) {
		$(cdata.popupostid).find(".SimpleBottomBar").each(function() {
			$(cdata.popupostid).css("position", "fixed");
			$(cdata.popupostid).css("width", "100%");
			$(cdata.popupostid).css("bottom", "0");
			$(cdata.popupostid).css("z-index", "99998");
			$(this).css("position", "absolute");
			$(this).css("right", "0px");
			$(this).css("margin-left", "0");
			$(this).css("bottom", "0");
			$(this).css("margin-top", '0');
			$(this).css("bottom", "0px");
			$(this).css("width", "100%");
			$(this).find('.insidepopup').css("border-radius", "0");
			$(this).find('.insidepopup').css("box-shadow", "0 1px 13px rgba(0,0,0,0.2)");
			$(this).find('.topimg').css("display", "none");
			$(this).find('.wowpopup-closebutton').css("top", "13px");
			$(this).find('.wowpopup-closebutton').css("right", "15px");
			$(this).find('.wowpopup-button').css("padding", "7px 15px");
	  	$(this).find('.wowclearfix').css("clear", "none");
			$(this).find('.wowclearfix').css("float", "right");
			$(this).find('.wowpopup-text').css("padding", "16px 10%");
			return this;
		});
	}

	// Prevent autoplay videos without popup shown
	var uniqueiframe = $(cdata.popupostid).find('iframe');
  var url = $(uniqueiframe).attr('src');
	$(uniqueiframe).attr('src', '');

	// Set cookies
	var cookie_expire = cdata.popupshowcookie;
	var popuphide = 'popup-hide'+cdata.uid;
	var popupnotshow = 'popup-notshow'+cdata.uid;

	// Show dialog on entry
	function ShowDialogOnentry() {
		if ((cdata.popupshowwhenagain == 'onesession' && sessionStorage[popupnotshow]  == null) || (cdata.popupshowwhenagain == 'oncookie' && $.cookie(popuphide) == null) || (cdata.popupshowwhenagain == 'alltime')) {
			$(cdata.popupostid).delay(cdata.popupshowaftersec).show(0);
			$(uniqueiframe).attr('src', url);
		}
	}

	// Show dialog on exit
	function ShowDialogOnexit() {
		if ((cdata.popupshowwhenagain == 'onesession' && sessionStorage[popupnotshow]  == null) || (cdata.popupshowwhenagain == 'oncookie' && $.cookie(popuphide) == null) || (cdata.popupshowwhenagain == 'alltime')) {
			$(cdata.popupostid).show(0);
			$(uniqueiframe).attr('src', url);
		}
	}

	// Hide dialog
	function HideDialog() {
		$(cdata.popupostid).fadeOut(400);
		$( cdata.popupostid ).addClass( "hascookie" );
	}

	//  On click close do this
	$(cdata.popupostid).find(".wowpopup-closebutton").click(function(e) {
			HideDialog();
			e.preventDefault();
			$(uniqueiframe).attr('src', '');

			if (cdata.popupshowwhenagain == 'onesession') {
				sessionStorage[popupnotshow] = 'yes';
			}

			if (cdata.popupshowwhenagain == 'oncookie') {
				$.cookie(popuphide, 'yes', {
					expires: cookie_expire,
					path: '/'
				});
			}
	});

	// IF entry intent
	if (cdata.popupshowentryorexit == 'onentry') {
		ShowDialogOnentry(true);
	}
	// IF Exit intent
	if (cdata.popupshowentryorexit == 'onexit') {
		function addEvent(obj, evt, fn) {
			if (obj.addEventListener) {
				obj.addEventListener(evt, fn, false);
			} else if (obj.attachEvent) {
				obj.attachEvent("on" + evt, fn);
			}
		}
		// Exit intent trigger
		addEvent(document, 'mouseout', function(evt) {
			if (evt.toElement == null && evt.relatedTarget == null) {
				ShowDialogOnexit(true);
			}
		});
	}




	}); 	// end for each modal

}); 	// end onload window
