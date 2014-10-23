

var Arctic = {

	initialized: false,
	mobMenuFlag: false,
	breakpoint: 751,
	breakpointFlag: false,
	map: null,
	myLatlng: null,

	init: function() {
		"use strict";
		
		var $tis = this;
		
		if ($tis.initialized){
			return;
		}
		
		$tis.initialized = true;
		$tis.construct();
		$tis.events();
	},

	construct: function() {
		"use strict";
		
		var $tis = this;
		
		/**
		 * Main Menu
		 */
		$tis.mainMenu();
		
		/**
		 * Activate placeholder in older browsers
		 */
		$('input, textarea').placeholder();

		/**
		 * Dinamically create the menu for mobile devices
		 */
		$tis.createMobileMenu();
		
		/**
		 * Reposition the copyright element when hits the breakpoint
		 */
		$tis.reposCopyright();
		
		/**
		 * Check the visibility of the sections that can be closed
		 */
		$tis.sectionVisibility();
		
		/**
		 * Create flexSliders
		 */
		$tis.flexSlider();
		
		/**
		 * Get latest tweets
		 */
		$tis.getLatestTweets();
	},

	events: function() {
		"use strict";
		var $tis = this;
		
		/**
		 * Functions called on window resize
		 */
		$tis.windowResize();
		
		/**
		 * Center map on map canvas resize
		 */
		$tis.mapResize();
		
		/**
		 * Show Menu Search Input
		 */
		$tis.menuSearchInput();
		
		/**
		 * Close section buttons
		 */
		$tis.closeSection();
		
		/**
		 * Tabs
		 */
		$tis.tabs();
		
		/**
		 * Accordion
		 */
		$tis.accordion();
		
		/**
		 * Comments Toggle
		 */
		$tis.commentsToggle();
		
		/**
		 * Scroll to top
		 */
		$tis.scrollToTop();
		
		/**
		 * Contact form submit
		 */
		$tis.contactForm();
		
		/**
		 * Send newsletter data to mailchimp
		 */
		$tis.subscribeNewsletter();
		
		/**
		 * Projects slider, packages-slider and portfolio item hover effect
		 */
		$tis.itemHover();
	},
	
	mainMenu: function() {
		"use strict";
		
		$('ul.sf-menu').superfish({
			delay:       1000,                            // one second delay on mouseout
			animation:   {opacity:'show',height:'show'},  // fade-in and slide-down animation
			speed:       'fast'                          // faster animation speed	
		});
	},
	
	createMobileMenu: function(w) {
		"use strict";
		var $tis = this;
		
		if ( w !== null ){
			w = $(window).innerWidth();
		}
		
		if (w <= $tis.breakpoint && !$tis.mobMenuFlag) {
			var nav = $('.sf-menu').html();
			var navMobileHolder =  $('#nav-mobile-holder');
			
			navMobileHolder.append('<div id="nav-mobile-btn"><div id="menu-icon"></div>Menu<div id="menu-arrow"></div></div>');
			navMobileHolder.append('<ul id="menu-mobile"></ul>');
			/*navMobileHolder.append('<div id="search-mobile-btn"><div class="icon-search"></div>Search</div>');
			navMobileHolder.append('<ul id="search-input-holder"></ul>');*/
			
			var mobileMenu = $('#menu-mobile');
			var searchHolder = $('#search-input-holder');
			
			mobileMenu.html(nav);
			mobileMenu.append('<div class="menuSlideUp"></div>');
			
			$('#menu-mobile ul, #menu-mobile li, #menu-mobile a').each(function(){ $(this).removeAttr('style'); }); // Clear all inline styles
			searchHolder.html( $('#menu-mobile li#search div').html() );
			$('#menu-mobile li#search').remove(); // Remove the search element from the dropdown mobile menu
			
			$tis.setMobileMenuFunctionality();
			
			$tis.mobMenuFlag = true;
		}
	},
	
	setMobileMenuFunctionality: function() {
		"use strict";
		
		$("#nav-mobile-holder > div").hover(
			function () {
				$(this).addClass("txt-highlight-color");
			}, 
			function () {
				if ( !$(this).hasClass("nav-mobile-div-active") ){
					$(this).removeClass("txt-highlight-color");
				}
			}
		);
		
		$("#nav-mobile-btn").click(function(e){
			e.stopPropagation();
			$("#menu-mobile").slideToggle();
			$(this).toggleClass("nav-mobile-div-active");
			$("#search-mobile-btn").removeClass("nav-mobile-div-active txt-highlight-color");
			$("#search-input-holder").hide();
			if ( $(this).hasClass("nav-mobile-div-active") ){
				$(this).addClass("txt-highlight-color");
			}
		});
		
		$("#search-mobile-btn").click(function(e){
			e.stopPropagation();
			$("#search-input-holder").slideToggle();
			$(this).toggleClass("nav-mobile-div-active");
			$("#nav-mobile-btn").removeClass("nav-mobile-div-active txt-highlight-color");
			$("#menu-mobile").hide();
			if ( $(this).hasClass("nav-mobile-div-active") ){
				$(this).addClass("txt-highlight-color");
			}
		});
		
		$("#search-input-holder input").click(function(e){
			e.stopPropagation();
		});
		
		$(document).click(function() {
			$("#menu-mobile").slideUp();
			$("#search-input-holder").slideUp();
			$("#nav-mobile-btn").removeClass("nav-mobile-div-active txt-highlight-color");
			$("#search-mobile-btn").removeClass("nav-mobile-div-active txt-highlight-color");
		});
	},
	
	reposCopyright: function(w) {
		"use strict";
		
		var $tis = this;
		
		if ( w !== null ){
			w = $(window).innerWidth();
		}
		
		if (w < $tis.breakpoint && !$tis.breakpointFlag) {
			var fdiv = $('.footer-divider').clone();
			fdiv.attr("style", 'margin-top:10px');
			$('#footer').append(fdiv);

			var div = document.createElement("div");
			$(div).attr("class", "container").attr("id", "dinam-container").append($('#copyright')).appendTo("#footer");
			
			$tis.breakpointFlag = true;
		}
		else if(w >= $tis.breakpoint && $tis.breakpointFlag){
			$('#copyright').insertAfter($('#sn-icons'));
			$("#dinam-container").remove();
			
			$("#footer").children(".footer-divider").eq(1).remove();
			
			$tis.breakpointFlag = false;
		}
	},
	
	sectionVisibility: function(w){
		"use strict";
		
		var $tis = this;
		
		if ( w !== null ){
			w = $(window).innerWidth();
		}
		
		if(w <= $tis.breakpoint){
			$(".close-btn").each(function(){
				//$(this).closest("div").next().slideUp(); //uncomment this line if you want to automatically hide all sections if breakpoint reached(mobile device)
			});
		}
		else if(w > $tis.breakpoint){
			$(".close-btn").each(function(){
				$(this).closest("div").next().slideDown(); 
				$(this).removeClass("close-btn-clicked");
			});
		}
	},
	
	flexSlider: function() {
		"use strict";
		
		/**
		 * Projects slider
		 */
		if($("#projects-slider").get(0)) {
			$('#projects-slider').flexslider({
				animation: "slide",
				animationLoop: true,
				controlNav: false,
				prevText: "",
				nextText: "",
				move: 1,
				itemWidth: 233,
				itemMargin: 2
			});
			$("#projects-slider").resize(function(){}); //Slider resize fix
		}
		
		if($("#projects-slider-home2").get(0)) {
			$('#projects-slider-home2').flexslider({
				animation: "slide",
				animationLoop: true,
				controlNav: false,
				prevText: "",
				nextText: "",
				move: 1,
				itemWidth: 191,
				itemMargin: 2
			});
			$("#projects-slider-home2").resize(function(){}); //Slider resize fix
		}
		
		/**
		 * Clients slider
		 */
		if($("#clients-slider").get(0)) {
			$('#clients-slider').flexslider({
				animation: "slide",
				animationLoop: true,
				controlNav: false,
				prevText: "",
				nextText: "",
				move: 1,
				itemWidth: 190,
				itemMargin: 5
			});
		}
		
		/**
		 * Team slider
		 */
		if($("#team-slider").get(0)) {
			$('#team-slider').flexslider({
				animation: "slide",
				animationLoop: true,
				controlNav: false,
				prevText: "",
				nextText: "",
				move: 1,
				itemWidth: 220,
				itemMargin: 20
			});
			$("#team-slider").resize(function(){}); //Slider resize fix
		}
		
		/**
		 * Testemonials slider
		 */
		if($("#testemonials").get(0)) {
			$('#testemonials').flexslider({
				animation: "fade",
				controlNav: false,
				prevText: "",
				nextText: "",
				smoothHeight: true
			});
			$("#testemonials").resize(function(){}); //Slider resize fix
		}
		
		/**
		 * Featured slider
		 */
		if($("#featured-slider").get(0)) {
			$('#featured-slider').flexslider({
				animation: "slide",
				controlNav: false,
				prevText: "",
				nextText: "",
				smoothHeight: true
			});
			$("#featured-slider").resize(function(){}); //Slider resize fix
		}

		/**
		 * Packages slider
		 */
		if($("#packages-slider").get(0)) {
			$('#packages-slider').flexslider({
				animation: "slide",
				animationLoop: true,
				controlNav: false,
				prevText: "",
				nextText: "",
				move: 1,
				itemWidth: 233,
				itemMargin: 2
			});
			$("#packages-slider").resize(function(){}); //Slider resize fix
		}
	},
	
	getLatestTweets: function() {
		"use strict";
		
		$('#twitter-box').tweet({
			username: 'CreativeMarket', //replace with your own username
			modpath: 'twitter/',
			count: 3,
			loading_text: 'Loading tweets...',
			template: '<img src="imgs/icons/twitter_icon.png" alt="" /> <div><a href="http://twitter.com/{screen_name}" target="_blank">@{screen_name}:</a> {text} <br/><a href="http://twitter.com/{screen_name}/statuses/{tweet_id}/" target="_blank" class="time">{tweet_relative_time}</a></div>'
		});
	},
	
	windowResize:function() {
		"use strict";
		
		var $tis = this;
		
		$(window).resize(function() {
			var w = $(window).innerWidth();
			
			$tis.createMobileMenu(w);
			$tis.reposCopyright(w);
			$tis.sectionVisibility(w);
		});
	},
	
	mapResize: function() {
		"use strict";
		
		var $tis = this;
		
		$("#map-canvas").resize(function(){
			setTimeout(function() {
				$tis.centerMap();
			}, 1500);
		});
	},
	
	menuSearchInput: function() {
		"use strict";

		$('.sf-menu li#search').hover(
			function () {
				$("div", this).stop(true, true).delay(150).fadeIn();
			}, 
			function () {
				$("div", this).stop(true, true).delay(500).fadeOut(50);
			}
		);
	},
	
	closeSection: function() {
		"use strict";
		
		$(".close-btn").click(function(e){
			e.stopPropagation();
			e.preventDefault();
			$(this).closest("div").next().slideToggle();
			$(this).toggleClass("close-btn-clicked");
		});
	},
	
	tabs: function() {
		"use strict";
		
		/**
		 * Vertical tabs click event
		 */
		var $vtabs = $('.vertical-tabs>ul>li');
		$vtabs.click(function() {
			$vtabs.removeClass('selected');
			$(this).addClass('selected');
			
			var index = $vtabs.index($(this));
			$('.vertical-tabs>div').hide().eq(index).show();
		}).eq(0).click();
		
		/**
		 * Horizontal tabs click event
		 */
		var $htabs = $('.horizontal-tabs>ul>li');
		$htabs.click(function() {
			$htabs.removeClass('selected txt-highlight-color');
			$(this).addClass('selected txt-highlight-color');
		
			var index = $htabs.index($(this));
			$('.horizontal-tabs>div').hide().eq(index).show();
		}).eq(0).click();
	},
	
	accordion: function() {
		"use strict";
		
		/**
		 * Accordion click event
		 */
		$('.accordion > div, .faq > div').each(function() {
			var tis = $(this), state = false, ttl = $("h5", tis), plus = $(".plus-medium", tis), toggle = tis.children("div").not(".plus-medium").hide().css('height', 'auto').slideUp();
			tis.click(function() {
				state = !state;
				if (state) {
					plus.html("-").css({lineHeight : "24px"});
				}else{
					plus.html("+").css({lineHeight : "26px"});
				}
				toggle.slideToggle(state);
				ttl.toggleClass('txt-highlight-color', state);
				tis.toggleClass('active', state);
			});
		});
	},
	
	commentsToggle: function() {
		"use strict";
		
		/**
		 * Show/Hide all comments (2 comments is always visible)
		 */
		$(".show-all").click(function(){
			var $list = $(this).parent().next("ul");
			$(">li:nth-child(n+3)", $list).slideToggle(500);
			
			if (/show/i.test($(this).html())){
				$(this).html("Hide Comments");
			}else if (/hide/i.test($(this).html())){
				$(this).html("Show all Comments");
			}
		});
		
		/**
		 * Show/Hide all comment replys
		 */
		$(".show-all-reps").click(function(){
			var $list = $(this).parent().parent().next("ul");
			$list.slideToggle(500);
			
			if (/show/i.test($(this).html())){
				$(this).html("Hide all Replys");
			}else if (/hide/i.test($(this).html())){
				$(this).html("Show all Replys");
			}
		});
	},
	
	scrollToTop: function() {
		"use strict";
		
		$(window).scroll(function(){
			if ( $(this).scrollTop() > 200 ) {
				$('.scrollToTop').stop(false,false).animate({
					'right': '-48px'
				}, 250);
			} else {
				$('.scrollToTop').stop(false,false).animate({
					'right': '-110px'
				}, 250);
			}
		}); 
	 
		$('.scrollToTop').click(function(){
			$("html, body").animate({ scrollTop: 0 }, 500, 'easeInOutExpo');
			return false;
		});
	},
	
	contactForm: function() {
		"use strict";
		
		$("#submit-form-contact").click(function(e){
			e.preventDefault();

			var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			var name  = $('#contact_name').val();
			var	email  = $('#contact_email').val();
			var	subject  = $('#contact_subject').val();
			var	message  = $('#contact_message').val();
			var	html = "";
					
			if(name === ""){
				$('#contact_name').val('Your name is required.');
			}else{
				html = "name=" + name;
			}
					
			if(subject === ""){
				$('#contact_subject').val('Subject is required.');
			}else{
				html += "&subject="+ subject;
			}

			if(email === ""){
				$('#contact_email').val('Your email is required.');
			}else if(re.test(email) === false){
				$('#contact_email').val('Invalid Email Address.');
			}else{
				html += "&email="+ email;
			}
			
			if(message === ""){
				$('#contact_message').val('Message is required.');
			}else{
				html += "&message="+ message;
			}
			
			if(name !== "" && re.test(email) && message !== "" ) {
				$.ajax({
					type: 'POST',
					url: 'php/contact.php',
					data: html,
					success: function(msg){
						if (msg === 'ok'){
							$('#msg-status').html('Message successfully sent!')  ;
							$('#form-contact')[0].reset();
						}else{
							$('#msg-status').html('<span class="error">Error sending message! Please Try Again!</span>')  ; 
						}
					},
					error: function(){
						$('#msg-status').html('<span class="error">Error accessing server! Please try again.</span>');
					}
				});
			}
			return false;
		});
	},
	
	subscribeNewsletter: function() {
		"use strict";
		
		$('#subscribe').click(function(e) {
			e.preventDefault();
			
			var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
			var newsEmail = $('#newsletter-input').val();
			
			if (re.test(newsEmail)){
				$.ajax({
					url: 'php/mcapi_listSubscribe.php',
					type: 'POST',
					data: {
						email: newsEmail
					},
					success: function(data){
						if (data === 'ok'){
							$('#newsletter-status').html("Subscribed!").css('color', '#6eb840');
							$('#newsletter-input').val('');
						} else{
							$('#newsletter-status').html('An error has occurred! Please, try again.').css('color', '#d12323');
						}
					},
					error: function() {
						$('#newsletter-status').html('An error has occurred! Please, try again.').css('color', '#d12323');
					}
				});
			} else {
				$('#newsletter-status').html('Invalid Email Address.').css('color', '#d12323');
			}
			
			return false;
		});
	},
	
	itemHover: function() {
		"use strict";
		
		var $tis = this;
		var key;
		
		$("#projects-slider li, #projects-slider-home2 li, #packages-slider li, .portfolio-item").not(".portfolio4-item").hover(
			function(e) {
				key = $tis.getMousePosition(this, e);
				
				switch(key){
					case "left":
						$(".item-info", this).css({"top" : "0", "left" : "-100%"});
						$(".item-info", this).stop().animate({ left : "0%"},400);
						break;
					case "top":
						$(".item-info", this).css({"top" : "-100%", "left" : "0"});
						$(".item-info", this).stop().animate({ top : "0%"},400);
						break;
					case "right":
						$(".item-info", this).css({"top" : "0", "left" : "100%"});
						$(".item-info", this).stop().animate({ left : "0%"},400);
						break;
					case "bottom":
						$(".item-info", this).css({"top" : "100%", "left" : "0"});
						$(".item-info", this).stop().animate({ top : "0%"},400);
						break;
				}
			},
			function () {
				switch(key){
					case "left":
						$(".item-info", this).stop().animate({ left : "-100%"},200);
						break;
					case "top":
						$(".item-info", this).stop().animate({ top : "-100%"},200);
						break;
					case "right":
						$(".item-info", this).stop().animate({ left : "100%"},200);
						break;
					case "bottom":
						$(".item-info", this).stop().animate({ top : "100%"},200);
						break;
				}
			}
		);
	},

	getMousePosition: function(elem, e) {
		"use strict";
		
		var $tis = this;
		
		var posX = e.pageX - $(elem).offset().left;
		var posY = e.pageY - $(elem).offset().top;
		var dirX;
		var dirY;
		var w = $(elem).width();
		var h = $(elem).height();
		if (w - posX < posX ){
			dirX = "left";
			posX = w - posX;
		} else {
			dirX = "right";
		}
		
		if (h - posY < posY ){
			dirY = "top";
			posY = h - posY;
		} else {
			dirY = "bottom";
		}
		
		if (posX < posY){
			return dirX;
		}else{
			return dirY;
		}
	},
	
	centerMap: function() {
		"use strict";
		
		var $tis = this;
		
		$tis.map.setCenter($tis.myLatlng);
	},
	
	createSitemap: function() {
		"use strict";
		
		var nav = $('.sf-menu').html();
		var sitemap = document.createElement('ul');
		
		$(sitemap).attr('class', 'sitemap');
		$(sitemap).html(nav);
		
		$('ul, li, a', sitemap).each(function(){ $(this).removeAttr('style'); }); // Clear all inline styles
		$('li#search', sitemap).remove(); // Remove the search element from the sitemap
		
		$("#nav-sitemap").append(sitemap);
	},
	
	initialize: function(lat, lng, title, address, logo) {
		"use strict";
		
		var $tis = this;
		
		$tis.myLatlng = new google.maps.LatLng(lat, lng);
		var mapOptions = {
			center:  $tis.myLatlng,
			zoom: 14,
			mapTypeId: google.maps.MapTypeId.ROADMAP
		};
		
		$tis.map = new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
		
		var contentString = '<img src="' + logo + '" alt="" width="200px" /><div class="map-address">' + address + '</div>';

		var infowindow = new google.maps.InfoWindow({
			content: contentString
		});
		
		var marker = new google.maps.Marker({
			position: $tis.myLatlng,
			map: $tis.map,
			title: title,
			icon: "imgs/icons/marker_icon.png"
		});

		google.maps.event.addListener(marker, 'click', function() {
			infowindow.open($tis.map,marker);
		});
	}
};

Arctic.init();