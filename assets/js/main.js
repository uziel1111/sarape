
$(document).ready(function(){
	$('[data-toggle="tooltip"]').tooltip();  
	"use strict";

	var window_width 	 = $(window).width(),
	window_height 		 = window.innerHeight,
	header_height 		 = $(".default-header").height(),
	header_height_static = $(".site-header.static").outerHeight(),
	fitscreen 			 = window_height - header_height;


	// $(window).on('load', function() {
 //        // Animate loader off screen
 //        $(".preloader").fadeOut("slow");;
 //    });

	$(".fullscreen").css("height", window_height)
	$(".fitscreen").css("height", fitscreen);

    //-------- Active Sticky Js ----------//
     $(".sticky-header").sticky({topSpacing:0});

     // -------   Active Mobile Menu-----//

     $(".mobile-btn").on('click', function(e){
        e.preventDefault();
        $(".main-menu").slideToggle();
        $("span", this).toggleClass("lnr-menu lnr-cross");
        $(".main-menu").addClass('mobile-menu');
    });
    //  $(".main-menu li a").on('click', function(e){
    //     e.preventDefault();
    //     $(".mobile-menu").slideUp();
    //     $(".mobile-btn span").toggleClass("lnr-menu lnr-cross");
    // });



    // Add smooth scrolling to Menu links
         $(".main-menu li a, .smooth").on('click', function(event) {
                if (this.hash !== "") {
                  event.preventDefault();
                  var hash = this.hash;
                  $('html, body').animate({
                    scrollTop: $(hash).offset().top - (-10)
                }, 600, function(){

                    window.location.hash = hash;
                });
            }
        });

 });
(function ($){

    $.fn.bekeyProgressbar = function(options){

        options = $.extend({
          animate     : true,
          animateText : true
        }, options);

        var $this = $(this);

        var $progressBar = $this;
        var $progressCount = $progressBar.find('.progressBar-percentage-count');
        var $circle = $progressBar.find('.progressBar-circle');
        var percentageProgress = $progressBar.attr('data-progress');
        var percentageRemaining = (100 - percentageProgress);
        var percentageText = $progressCount.parent().attr('data-progress');

        //Calculate circonference od circle
        var radius = $circle.attr('r');
        var diameter = radius * 2;
        var circumference = Math.round(Math.PI * diameter);

        //Calculate % progress
        var percentage =  circumference * percentageRemaining / 100;

        $circle.css({
          'stroke-dasharray' : circumference,
          'stroke-dashoffset' : percentage
        })

        //Animation bar progression
        if(options.animate === true){
          $circle.css({
            'stroke-dashoffset' : circumference
          }).animate({
            'stroke-dashoffset' : percentage
          }, 3000 )
        }

        //Animation text (%)
        if(options.animateText == true){

          $({ Counter: 0 }).animate(
            { Counter: percentageText },
            { duration: 3000,
             step: function () {
               $progressCount.text( Math.ceil(this.Counter) + '%');
             }
            });

        }else{
          $progressCount.text( percentageText + '%');
        }

    };

})(jQuery);

$(document).ready(function(){

  $('.progressBar--animateNone').bekeyProgressbar({
    animate : false,
    animateText : false
  });

  $('.progressBar--animateCircle').bekeyProgressbar({
    animate : true,
    animateText : false
  });

  $('.progressBar--animateText').bekeyProgressbar({
    animate : false,
    animateText : true
  });

  $('.progressBar--animateAll').bekeyProgressbar();

})
