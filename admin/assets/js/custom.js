/**	
	* Template Name: Rex
	* Version: 1.0	
	* Template Scripts
	* Author: MarkUps
	* Author URI: http://www.markups.io/

	Custom JS
	
	1. HEADER CONTENT SLIDE
	2. FIXED MENU
	3. COUNTER
	4. TESTIMONIAL SLIDE (SLICK SLIDER)
	5. CLIENT SLIDE (SLICK SLIDER)
	6. SCROLL TOP BUTTON
	7. MENU SMOOTH SCROLLING
	8. MIXIT FILTER ( FOR PORTFOLIO )  
	9. FANCYBOX ( FOR PORTFOLIO POPUP VIEW ) 
	10. MOBILE MENU CLOSE 
	11. PRELOADER 
	12. INSTAGRAM SLIDER (SLICK SLIDER)
	13. WOW ANIMATION 	
	
**/

jQuery(function($){


	/* ----------------------------------------------------------- */
	/*  1. HEADER CONTENT SLIDE (SLICK SLIDER)
	/* ----------------------------------------------------------- */

	/*jQuery('.header-slide').slick({
		dots: false,
		infinite: true,
		speed: 500,
		arrows:false, 
		autoplay: true,     
      	slidesToShow: 1,
		slide: 'span',
		fade: true,
		cssEase: 'linear'
	});*/

	/* ----------------------------------------------------------- */
	/*  2. FIXED MENU
	/* ----------------------------------------------------------- */


	jQuery(window).bind('scroll', function () {
    if ($(window).scrollTop() > 10) {
        $('.main-navbar').addClass('navbar-fixed-top');
        $('.logo').addClass('logo-compressed');
        $('.main-nav li a').addClass('less-padding');
		$('#navbar').addClass('navbar-collapse-top');
		$('.btn-header').addClass('btn-header-top');
		$('.sideNav').addClass('sideNav-top');

        //$('.search-area').css('height','44');
        //$('.search-area input[type="text"]').css('top','35%');
        
        
	    } else {
	        $('.main-navbar').removeClass('navbar-fixed-top');
	        $('.logo').removeClass('logo-compressed');
	        $('.main-nav li a').removeClass('less-padding');
		    $('#navbar').removeClass('navbar-collapse-top');
			$('.btn-header').removeClass('btn-header-top');
			$('.sideNav').removeClass('sideNav-top');
	        //$('.search-area').css('height','60');
	        //$('.search-area input[type="text"]').css('top','11%');
	    }
	});

	/* ----------------------------------------------------------- */
	/*  3. COUNTER
	/* ----------------------------------------------------------- */

	jQuery('.counter').counterUp({
        delay: 10,
        time: 1000
    });

	/* ----------------------------------------------------------- */
	/*  4. TESTIMONIAL SLIDE(SLICK SLIDER)
	/* ----------------------------------------------------------- */

	/*jQuery('.testimonial-slider').slick({
		dots: false,
		infinite: true,
		speed: 500,
		arrows:true, 
		autoplay: true,     
      	slidesToShow: 1,
		slide: 'div',		
		cssEase: 'linear'
	});*/

	/* ----------------------------------------------------------- */
	/*  5. CLIENT SLIDE (SLICK SLIDER)
	/* ----------------------------------------------------------- */

	/*$('.client-table').slick({
	  dots: false,
	  infinite: true,
	  arrows:false, 
	  speed: 200,
	  autoplay: true,
	  autoplaySpeed: 4000,
	  slidesToShow: 4,
	  slidesToScroll: 4,
	  responsive: [
	     
	{
      breakpoint: 1400,
      settings: {
        slidesToShow: 4,
        slidesToScroll: 4,
      }
    },
	{
      breakpoint: 1200,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 3,
      }
    },
    {
      breakpoint: 991,
      settings: {
        slidesToShow: 2,
        slidesToScroll: 2
      }
    },
    {
      breakpoint: 600,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 470,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 320,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }

	    // You can unslick at a given breakpoint now by adding:
	    // settings: "unslick"
	    // instead of a settings object
	  ]
	});*/

	/* ----------------------------------------------------------- */
	/*  6. SCROLL TOP BUTTON
	/* ----------------------------------------------------------- */

	//Check to see if the window is top if not then display button

	  /*jQuery(window).scroll(function(){
	    if ($(this).scrollTop() > 300) {
	      $('.scrollToTop').fadeIn();
	    } else {
	      $('.scrollToTop').fadeOut();
	    }
	  });
	   
	  //Click event to scroll to top

	  jQuery('.scrollToTop').click(function(){
	    $('html, body').animate({scrollTop : 0},800);
	    return false;
	  });*/

	/* ----------------------------------------------------------- */
	/*  7. MENU SMOOTH SCROLLING
	/* ----------------------------------------------------------- 
	
		//MENU SCROLLING WITH ACTIVE ITEM SELECTED

		// Cache selectors
		var lastId,
		topMenu = $(".main-nav"),
		topMenuHeight = topMenu.outerHeight()+13,
		// All list items
		menuItems = topMenu.find("a"),
		// Anchors corresponding to menu items
		scrollItems = menuItems.map(function(){
		  var item = $($(this).attr("href"));
		  if (item.length) { return item; }
		});

		// Bind click handler to menu items
		// so we can get a fancy scroll animation
		menuItems.click(function(e){
		  var href = $(this).attr("href"),
		      offsetTop = href === "#" ? 0 : $(href).offset().top-topMenuHeight+32;
		  jQuery('html, body').stop().animate({ 
		      scrollTop: offsetTop
		  }, 1500);
		  e.preventDefault();
		});

		// Bind to scroll
		jQuery(window).scroll(function(){
		   // Get container scroll position
		   var fromTop = $(this).scrollTop()+topMenuHeight;
		   
		   // Get id of current scroll item
		   var cur = scrollItems.map(function(){
		     if ($(this).offset().top < fromTop)
		       return this;
		   });
		   // Get the id of the current element
		   cur = cur[cur.length-1];
		   var id = cur && cur.length ? cur[0].id : "";
		   
		   if (lastId !== id) {
		       lastId = id;
		       // Set/remove active class
		       menuItems
		         .parent().removeClass("active")
		         .end().filter("[href=#"+id+"]").parent().addClass("active");
		   }           
		})

	/* ----------------------------------------------------------- */
	/*  8. MIXIT FILTER ( FOR PORTFOLIO ) 
	/* ----------------------------------------------------------- */ 

		/*jQuery(function(){
		    $('#mixit-container').mixItUp();
		});*/

	/* ----------------------------------------------------------- */
	/*  9. FANCYBOX ( FOR PORTFOLIO POPUP VIEW ) 
	/* ----------------------------------------------------------- */
	    
		/*jQuery(document).ready(function() {
			$(".fancybox").fancybox();
		});	*/ 

	/* ----------------------------------------------------------- */
	/*  10. MOBILE MENU CLOSE 
	/* ----------------------------------------------------------- */

	/*jQuery('.dropdown-toggle').on('click', 'li a', function() {
	  $('.in').collapse('hide');
	});*/

	/* ----------------------------------------------------------- */
	/*  11. PRELOADER 
	/* ----------------------------------------------------------- */ 

	/*jQuery(window).load(function() { // makes sure the whole site is loaded
      jQuery('.loader').fadeOut(); // will first fade out the loading animation
      jQuery('#preloader').delay(100).fadeOut('slow'); // will fade out the white DIV that covers the website.
      jQuery('body').delay(100).css({'overflow':'visible'});
    })*/

    /* ----------------------------------------------------------- */
	/*  12. INSTAGRAM SLIDER (SLICK SLIDER)
	/* ----------------------------------------------------------- */ 

	/*jQuery('.instagram-feed').slick({
		dots: true,
		infinite: true,
		speed: 500,
		arrows:true, 
		autoplay: true,     
      	slidesToShow: 1,
		slide: 'div',		
		cssEase: 'linear'
	});*/

	/* ----------------------------------------------------------- */
	/*  13. WOW ANIMATION
	/* ----------------------------------------------------------- */ 

	/*wow = new WOW(
      {
        animateClass: 'animated',
        offset:       100,
        callback:     function(box) {
          console.log("WOW: animating <" + box.tagName.toLowerCase() + ">")
        }
      }
    );
    wow.init();*/
	
	/* ----------------------------------------------------------- */
	/*  13. VOTE
	/* ----------------------------------------------------------- */ 
	
	/*$(document).ready(function () {
    $('#container div a').click(function () {
        $(this).parent().animate({ width: '+=3px' }, 500);
        $(this).prev().html(parseInt($(this).prev().html()) + 1);
        return false;
    });
	

	/* ----------------------------------------------------------- */
	/*  14. input file
	/* ----------------------------------------------------------- */ 

	/*$(":file").filestyle({buttonBefore: true});
		// get
		$(":file").filestyle('buttonText');
		// set
		$(":file").filestyle('buttonText', 'Browse...');

});*/
	$(':file').filestyle({
		iconName : 'fas fa-folder-open',
		buttonName : 'btn-info',
		buttonText : 'Browse...'
	});


	$(document).ready(function () {

	$('[data-toggle="tooltip"]').tooltip(); 
	$('.idcard').mask('0-0000-00000-00-0');
	$('.phone').mask('000-000-0000');
	
	});
	
	
	$(window).scroll(function(){
				if ($(this).scrollTop() > 100) {
					$('.scrollup').fadeIn();
					
				} else {
					$('.scrollup').fadeOut();
				}
					
			}); 
			
			$('.scrollup').click(function(){
				$("html, body").animate({ scrollTop: 0 }, 600);
				return false;
			});	
			
			setTimeout( function() { 			
						$('.scrollup').fadeOut();			
					} , 5000 );
					
			$(function() {
				$(".lined").linedtextarea();
			});

});

function JSCheck_filenameTH(id,fileValue){
	    if(id != ''){
	    var file_name = $("#"+id)[0].files[0].name;
		var pattern_en = '/^([a-z0-9\_])+$/i';
		var pattern_th = '/^[ก-๏\s]+$/';
		var n = file_name.split('.').pop().toLowerCase();
		var nameArr = file_name.split('.');
		var fail = 0;		

	    for(var x = 0; x < nameArr.length; x++) {			
			 var fn = nameArr[x];	
		//if(!file_name.match(/^([a-z0-9\s])+$/i)){	
				if(fn.match(/[ก-ฮ]/g)){
					var fail = 1;
					//alert(nameArr[x]);	
				}
			}
			
		if(fail == 1){
			$('#'+id).val("");
			$('#'+id).focus();
		$.alert({
						title: 'กรุณาเลือกรูปแบบใหม่ ',
						content: 'Browse File ไม่รองรับชื่อไฟล์ที่มีอักษรภาษาไทย  \n\nชื่อไฟล์ต้องเป็น ภาษาอังกฤษ หรือ ตัวเลขอารบิก',
						icon: 'fa fa-exclamation-circle',
                        theme: 'modern',                          
                        type: 'orange',
						closeIcon: false,						
						buttons: {
							close: {
								 text: 'ปิด',
									btnClass: 'btn-orange',
								}
							},						
						});	
			return false;						
		}else{
		return true;
		}
			
		
		}
	}
	
function JSCheck_InPutTH(id,Value){
	    if(id != ''){
	    var name = $("#"+id).val();
		var pattern_en = '/^([a-z0-9\_])+$/i';
		var pattern_th = '/^[ก-๏\s]+$/';
		var fail = 0;		
		var validNameTH = name.match(/[ก-ฮ]/g);
        if (validNameTH) {	
					var fail = 1;
			}	
		
		if(fail == 1){
			$('#'+id).val("");
			$('#'+id).focus();
		$.alert({
						title: 'กรุณากรอกข้อมูล ',
						content: 'E-mail ไม่ถูกต้อง  E-mail มีอักษรภาษาไทย',
						icon: 'fa fa-exclamation-circle',
                        theme: 'modern',                          
                        type: 'orange',
						closeIcon: false,						
						buttons: {
							close: {
								 text: 'ปิด',
									btnClass: 'btn-orange',
								}
							},						
						});	
			return false;						
		}else{
		return true;
		}
			
		
		}
	}

	
function JSCheck_Text(id,Value){
	    if(id != ''){
	    var name = $("#"+id).val();
		var pattern_en = '/^([a-z0-9\_])+$/i';
		var pattern_th = '/^[ก-๏\s]+$/';
		var fail = 0;		
		var validNameTH = name.match(/[ก-ฮ]/g);
        if (validNameTH) {	
					var fail = 1;
			}	
		
		if(fail == 1){
			$('#'+id).val("");
			$('#'+id).focus();
		$.alert({
						title: 'กรุณากรอกข้อมูล ',
						content: 'E-mail ต้องไม่มีตัวอักษรภาษาไทย',
						icon: 'fa fa-exclamation-circle',
                        theme: 'modern',                          
                        type: 'orange',
						closeIcon: false,						
						buttons: {
							close: {
								 text: 'ปิด',
									btnClass: 'btn-orange',
								}
							},						
						});	
			return false;						
		}else{
		return true;
		}
			
		
		}
}

function JSCheck_TextOnly(id,Value){
	    if(id != ''){
	    var valname = $("#"+id).val();
		var name = $("#"+id).attr( 'name' );	
		var text = $("[for="+name+"]").text();
		
		var pattern_en = '/^([a-z0-9\_])+$/i';
		var pattern_th = '/^[ก-๏\s]+$/';
		var fail = 0;		
		var validNameTH = valname.match(/[ก-ฮa-zA-Z]/g);
        if (!validNameTH) {	
					var fail = 1;
			}	
		
		if(fail == 1){
			$('#'+id).val("");
			$('#'+id).focus();
		$.alert({
						title: 'กรุณากรอกข้อมูล ',
						content: text+'ไม่ถูกต้อง กรอกได้เฉพาะตัวอักษรภาษาไทยและตัวอักษรภาษาอังกฤษเท่านั้น',
						icon: 'fa fa-exclamation-circle',
                        theme: 'modern',                          
                        type: 'orange',
						closeIcon: false,						
						buttons: {
							close: {
								 text: 'ปิด',
									btnClass: 'btn-orange',
								}
							},						
						});	
			return false;						
		}else{
		return true;
		}
			
		
		}
}		
$(document).ready(function () {
	
  var mont_th=["","มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"];	
  var d = new Date();
  var toDay = 'วันที่ ' +d.getDate() + ' ' + mont_th[(d.getMonth() + 1)] + ' ' + (d.getFullYear() + 543);
  
  $('.date-today-th').html(toDay);
  
  
  
});