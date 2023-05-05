jQuery(document).ready(function($) { 
                                  
                                 // We only want these styles applied when javascript is enabled 
                                 $('div.navigation').css({'width' : '300px', 'float' : 'left'}); 
                                 $('div.content').css('display', 'block'); 
  
                                 // Initially set opacity on thumbs and add 
                                 // additional styling for hover effect on thumbs 
                                 var onMouseOutOpacity = 0.67; 
                                 $('#thumbs ul.thumbs li').css('opacity', onMouseOutOpacity) 
                                         .hover( 
                                                 function () { 
                                                         $(this).not('.selected').fadeTo('fast', 1.0); 
                                                 },  
                                                 function () { 
                                                         $(this).not('.selected').fadeTo('fast', onMouseOutOpacity); 
                                                 } 
                                         ); 
  
                                 // Enable toggling of the caption 
                                 var captionOpacity = 0.0; 
                                 $('#captionToggle a').click(function(e) { 
                                         var link = $(this); 
                                          
                                         var isOff = link.hasClass('off'); 
                                         var removeClass = isOff ? 'off' : 'on'; 
                                         var addClass = isOff ? 'on' : 'off'; 
                                         var linkText = isOff ? 'Hide Caption' : 'Show Caption'; 
                                         captionOpacity = isOff ? 0.7 : 0.0; 
  
                                         link.removeClass(removeClass).addClass(addClass).text(linkText).attr('title', linkText); 
                                         $('#caption span.image-caption').fadeTo(1000, captionOpacity); 
                                          
                                         e.preventDefault(); 
                                 }); 
                                  
                                 // Initialize Advanced Galleriffic Gallery 
                                 var gallery = $('#gallery').galleriffic('#thumbs', { 
                                         delay:                     2500, 
                                         numThumbs:                 15, 
                                         preloadAhead:              10, 
                                         enableTopPager:            true, 
                                         enableBottomPager:         true, 
                                         maxPagesToShow:            7, 
                                         imageContainerSel:         '#slideshow', 
                                         controlsContainerSel:      '#controls', 
                                         captionContainerSel:       '#caption', 
                                         loadingContainerSel:       '#loading', 
                                         renderSSControls:          true, 
                                         renderNavControls:         true, 
                                         playLinkText:              'Play Slideshow', 
                                         pauseLinkText:             'Pause Slideshow',
										 playLinkText1:              'Play Slideshow', 
                                         pauseLinkText1:             'Pause Slideshow',  
                                         prevLinkText:              '<img src="mainpic/lightbox/prevlabel_g.gif" width="53" height="22" border="0" align="middle">', 
										 prevLinkText1:				'Prev photo',
                                         nextLinkText:              '<img src="mainpic/lightbox/nextlabel_g.gif" width="53" height="22" border="0" align="middle">', 
										 nextLinkText1:				'Next photo',
                                         nextPageLinkText:          'Next &rsaquo;', 
                                         prevPageLinkText:          '&lsaquo; Prev', 
                                         enableHistory:             true, 
                                         autoStart:                 false, 
                                         syncTransitions:           true, 
                                         defaultTransitionDuration: 900, 
                                         onSlideChange:             function(prevIndex, nextIndex) { 
                                                 $('#thumbs ul.thumbs').children() 
                                                         .eq(prevIndex).fadeTo('fast', onMouseOutOpacity).end() 
                                                         .eq(nextIndex).fadeTo('fast', 1.0); 
                                         }, 
                                         onTransitionOut:           function(slide, caption, isSync, callback) { 
                                                 slide.fadeTo(this.getDefaultTransitionDuration(isSync), 0.0, callback); 
                                                 caption.fadeTo(this.getDefaultTransitionDuration(isSync), 0.0); 
                                         }, 
                                         onTransitionIn:            function(slide, caption, isSync) { 
                                                 var duration = this.getDefaultTransitionDuration(isSync); 
                                                 slide.fadeTo(duration, 1.0); 
                                                  
                                                 // Position the caption at the bottom of the image and set its opacity 
                                                 var slideImage = slide.find('img'); 
                                                 caption.width(slideImage.width()) 
                                                         .css({ 
                                                                 'bottom' : Math.floor((slide.height() - slideImage.outerHeight()) / 2), 
                                                                 'left' : Math.floor((slide.width() - slideImage.width()) / 2) + slideImage.outerWidth() - slideImage.width() 
                                                         }) 
                                                         .fadeTo(duration, captionOpacity); 
                                         }, 
                                         onPageTransitionOut:       function(callback) { 
                                                 $('#thumbs ul.thumbs').fadeTo('fast', 0.0, callback); 
                                         }, 
                                         onPageTransitionIn:        function() { 
                                                 $('#thumbs ul.thumbs').fadeTo('fast', 1.0); 
                                         } 
                                 }); 
  
                                 // PageLoad function 
                                 // This function is called when: 
                                 // 1. after calling $.historyInit(); 
                                 // 2. after calling $.historyLoad(); 
                                 // 3. after pushing "Go Back" button of a browser 
                                 function pageload(hash) { 
                                         // alert("pageload: " + hash); 
                                         // hash doesn't contain the first # character. 
                                         if(hash) { 
                                                 $.galleriffic.goto(hash); 
                                         } else { 
                                                 $.galleriffic.goto(0); 
                                         } 
                                 } 
  
                                 // Initialize history plugin. 
                                 // The callback is called at once by present location.hash.  
                                 $.historyInit(pageload, "wml.html"); 
  
                                 // set onlick event for buttons using the jQuery 1.3 live method 
                                 $("a[rel='history']").live('click', function() { 
                                         var hash = this.href; 
                                         hash = hash.replace(/^.*#/, ''); 
  
                                         // moves to a new page.  
                                         // pageload is called at once.  
                                         // hash don't contain "#", "?" 
                                         $.historyLoad(hash); 
  
                                         return false; 
                                 }); 
  
                         }); 