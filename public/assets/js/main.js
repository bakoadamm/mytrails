

// Preloader
$(window).on('load', function() { // makes sure the whole site is loaded
  $('#status').fadeOut(); // will first fade out the loading animation
  $('#preloader').delay(350).fadeOut('slow'); // will fade out the white DIV that covers the website.
  $('body').delay(350).css({'overflow':'visible'});
})

// OS detector
var phone, touch, ltie9, dh, ar, fonts, ieMobile;

var ua = navigator.userAgent;
var winLoc = window.location.toString();

var is_webkit       = ua.match(/webkit/i);
var is_firefox      = ua.match(/gecko/i);
var is_newer_ie     = ua.match(/msie (9|([1-9][0-9]))/i);
var is_older_ie     = ua.match(/msie/i) && !is_newer_ie;
var is_ancient_ie   = ua.match(/msie 6/i);
var is_ie           = is_ancient_ie || is_older_ie || is_newer_ie;
var is_mobile_ie    = navigator.userAgent.indexOf('IEMobile') !== -1;
var is_mobile       = ua.match(/mobile/i);
var is_OSX          = ua.match(/(iPad|iPhone|iPod|Macintosh)/g) ? true : false;
var iOS 			= getIOSVersion(ua);
var is_EDGE 		= /Edge\/12./i.test(navigator.userAgent);
function getIOSVersion(ua) {
	ua = ua || navigator.userAgent;
	return parseFloat(
			('' + (/CPU.*OS ([0-9_]{1,5})|(CPU like).*AppleWebKit.*Mobile/i.exec(ua) || [0,''])[1])
				.replace('undefined', '3_2').replace('_', '.').replace('_', '')
		) || false;
}


// Browser Ditector
$(document).ready(function(){
	var isOpera = (!!window.opr && !!opr.addons) || !!window.opera || navigator.userAgent.indexOf(' OPR/') >= 0;
	var isFirefox = typeof InstallTrigger !== 'undefined';
	var isSafari = /constructor/i.test(window.HTMLElement) || (function (p) { return p.toString() === "[object SafariRemoteNotification]"; })(!window['safari'] || safari.pushNotification);
	var isIE = /*@cc_on!@*/false || !!document.documentMode;
	var isEdge = !isIE && !!window.StyleMedia;
	var isChrome = !!window.chrome && !!window.chrome.webstore;
	var isBlink = (isChrome || isOpera) && !!window.CSS;

	if(isOpera) $('html').addClass("opera");
	if(isFirefox) $('html').addClass("firefox");
	if(isSafari) $('html').addClass("safari");
	if(isIE) $('html').addClass("ie");
	if(isEdge) $('html').addClass("edge");
	if(isChrome) $('html').addClass("chrome");
	if(isBlink) $('html').addClass("blink");

})


//  Header animation function
function animation() {

	var $gsap 			= $('.gsap'),
		$unite 			= $('.gsap-unite'),
		$slideDown 		= $('.gsap-slide-down'),
		$slideUp 		= $('.gsap-slide-up'),
		$fadeIn 		= $('.gsap-fade-in'),
		$header 		= $('.header'),
		$firstArrow 	= $('.down-arrow span:first-child'),
		$lastArrow		= $('.down-arrow span:last-child');
		timeline 		= new TimelineMax({ onComplete: animationDone }),
		headerTop       = $header.offset().top,
		headerHeight    = $header.outerHeight();

	$fadeIn.css({transform: 'matrix(1.1, 0, 0, 1.1, 0, 0)'});

	timeline.to($fadeIn, 0.75, {opacity: 1, filter: 'blur(0px)', scale: 1, ease: Power0.easeInOut})
	.fromTo($unite, 1.0, {'letter-spacing': '0.25em', opacity: 0}, {opacity: 1, 'letter-spacing': '0.05em', ease: Sine.easeInOut})
	.fromTo($slideUp, 0.7, {y: 20, opacity: 0}, {opacity: 1, y: 0, ease: Power2.easeOut}, '-=0.3')
	.fromTo($slideDown, 0.7, {y: -20, opacity: 0}, {opacity: 1, y: 0, ease: Power2.easeOut}, '-=0.2')
	.fromTo($firstArrow, 0.4, {y: 0, opacity: 0}, {y: 15, opacity: 1, ease: Back.easeOut}, "+=0.5")
	.fromTo($lastArrow, 0.4, {y: 0, opacity: 0}, {y: 11, opacity: 1, ease: Back.easeOut}, "-=0.25");

	$(function(){
		var $header 	  	= $(".header");
		var $parallaxItems	= $header.find('[class^="gsap-"]');

		$(window).on("scroll", function(event){

			var homeSHeight = $header.height(),
		        topScroll 	= $(window).scrollTop();

			$parallaxItems.each(function(){

				var item 	= $(this),
					opacity	= 1 - topScroll/$header.height() * 1.8;
				TweenMax.set(item, { opacity: opacity });
			});
		});
	});

	function animationDone(){
		var rellax = new Rellax('.parallax[class^="gsap-"]', {center: false});
		// arrowAnimation()
	}
}


// Arrow Down animation
/*
function arrowAnimation(){
	var timeline 	= new TimelineMax(),
		$firstArrow = $('.down-arrow span:first-child'),
		$lastArrow	= $('.down-arrow span:last-child');
	// $firstArrow.css({transform: 'matrix(1.1, 0, 0, 1.1, 0, 0)'});
	// $lastArrow.css({transform: 'matrix(1.1, 0, 0, 1.1, 0, 0)'});

	timeline.fromTo($firstArrow, 0.4, {y: 0, opacity: 0}, {y: 15, opacity: 1, ease: Back.easeOut}, "-=0.1")
	.fromTo($lastArrow, 0.4, {y: 0, opacity: 0}, {y: 11, opacity: 1, ease: Back.easeOut}, "-=0.25");
}

 */

// Image loader
$(window).on('load', function(){
	$('body').imagesLoaded()
	.always( function( instance ) {
		// console.log('all images loaded');
	})
	.done( function( instance ) {
		// console.log('all images successfully loaded');
		animation();
	})
	.fail( function() {
		// console.log('all images loaded, at least one is broken');
	})
	.progress( function( instance, image ) {
		// var result = image.isLoaded ? 'loaded' : 'broken';
		// console.log( 'image is ' + result + ' for ' + image.img.src );
	});
});

/*
$(document).ready(function(){
	if($('#nav-elements').length){
		var	$this	= $('#nav-elements');
			url		= window.location.href.split('/');
			link 	= url[url.length - 1];
			hrefs 	= $this.children('li').children('a');
		hrefs.each(function(){
			var $this	= $(this);
				href 	= $this.attr('href');
			while(href === link){
				$this.toggleClass('color-7 color-4 fw-800');
				break;
			}
		});
	}
})
 */
