<?php

$category_id =  $_GET[category_id];
			if(($_GET[category_id]!= '') && ($_GET[category_id] != '0')){
				$sql =$db->query("select category_name,parent_id,col,row,height_s,width_s,category_vote,category_comment,category_send from gallery_category where category_id ='".$_GET[category_id]."'");
				$num_row = $db->db_num_rows($sql);
				$sql_gname =  $db->db_fetch_array($sql);
				//$name = ' >> '.findparent($sql_gname[parent_id]).$sql_gname[category_name];
				$col = $sql_gname[col];
				$row = $sql_gname[row];
				$hi = $sql_gname[height_s];
				$wi = $sql_gname[width_s];
			}
					$hiw = 70;
			$wiw = 70;
$sql = "SELECT * FROM gallery_cat_img INNER JOIN gallery_image ON gallery_cat_img.img_id = gallery_image.img_id WHERE gallery_cat_img.category_id = '".$category_id."' ORDER BY cat_img_id,gallery_image.img_id";
		$rows  = $db->db_num_rows($db->query($sql));
		if($rows > 0){
?>

              
                  
                 <link rel="stylesheet" href="css/galleriffic.css" type="text/css" /> 
                 <script type="text/javascript" src="js/jquery.min.js"></script> 
                 <script type="text/javascript" src="js/jquery.history.js"></script> 
                 <script type="text/javascript" src="js/jquery.galleriffic.js"></script> 

<table width="99%" border="0" cellspacing="0" cellpadding="3">
  <tr valign="top">
    <td > <div id="page"> 
                         <div id="container"> 
                                 <!-- Start Advanced Gallery Html Containers --> 
                                 <div id="gallery" class="content"> 
                                         
                                         <div class="slideshow-container"> 
                                                 <div id="loading" class="loader"></div> 
                                                 <div id="slideshow" class="slideshow"></div> 
                                                 <div id="caption" class="caption-container"></div> 
                                         </div> 
                                         
                                 </div> 
								 <div id="thumbs" class="navigation"> <div id="controls" class="controls"></div> 
                                         <ul class="thumbs noscript">
										 <?php

		$cal = $col;
		$w = number_format((100/$cal),0,'','');
		$sql_category =  $sql; //." LIMIT $offset,$limit ";
		$query_category = $db->query($sql_category);
		while($rs_img = $db->db_fetch_array($query_category)){

							$img_p = $rs_img[img_path_s];
							if (!file_exists($rs_img[img_path_s]) ) {
									$img_p = "mainpic/no-download.gif";
							}
							if(!$default_img)  $default_img = $img_p;
							$img_id = $rs_img[img_id];
							if(!$img_name) $img_name = $rs_img[img_name];
							
	?>
										 <li> 
                                                         <a class="thumb" href="<?php echo $img_p?>" title="<?php echo $rs_img[img_name]?>" > 
                                                               <img src="<?php echo $img_p?>" width="<?php echo $wiw;?>"  height="<?php echo $hiw;?>" hspace="0" vspace="0" border="0" align="top"  style="border:2px #FFFFFF double ; padding:5px;" alt="<?php echo $rs_img[img_name]?>">
                                                         </a> 
                                                         <div class="caption"> 
                                                                 <div class="download"> 
                                                                        <a href="gallery_view_img_comment.php?category_id=<?php echo $category_id;?>&filename=<?php echo $_GET["filename"];?>&img_id=<?php echo $img_id;?>&BID=<?php echo $BID;?>">
																		<?php if($sql_gname[category_vote] == '1'){?><img src="mainpic/lightbox/check.jpg" border="0" alt="เธเธฅเธดเธเน€เธกเธทเนเธญเธ•เนเธญเธเธเธฒเธฃ Vote"><?php }?>
																		<?php if($sql_gname[category_comment] == '1'){?><img src="mainpic/lightbox/message.jpg" border="0" alt="เธเธฅเธดเธเน€เธกเธทเนเธญเธ•เนเธญเธเธเธฒเธฃ Comment"><?php }?>
																		<?php if($sql_gname[category_send] == '1'){?><img src="mainpic/lightbox/mail.jpg" border="0" alt="เธเธฅเธดเธเน€เธกเธทเนเธญเธ•เนเธญเธเธเธฒเธฃ เธชเนเธเธ•เนเธญเนเธซเนเน€เธเธทเนเธญเธ"><?php }?></a>
                                                                 </div> 
                                                                 <div class="image-title"><?php echo $rs_img[img_name]?></div> 
                                                                 <div class="image-desc"><?php echo $rs_img[img_detail]?></div> 
                                                         </div> 
                                           </li> 
											<?php
						$i++;
		}//end while
		?> </ul>
							
							</div> <!-- End Advanced Gallery Html Containers --> 
                                 <div style="clear: both;"></div> 
                         </div> 
                 </div> 
                 <div id="footer">&nbsp;</div> </td>
  </tr>
</table>    <script type="text/javascript"> 
                         jQuery(document).ready(function($) { 
                                  
                                 // We only want these styles applied when javascript is enabled 
                                 $('div.navigation').css({'width' : '290px', 'float' : 'left'}); 
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
                                         numThumbs:                 12, 
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
                                         playLinkText:              '<img src="mainpic/lightbox/gal_b_play.jpg"  border="0" align="middle">', 
                                         pauseLinkText:             '<img src="mainpic/lightbox/gal_b_paus.jpg"  border="0" align="middle">',
										 playLinkText1:             'Play', 
                                         pauseLinkText1:            'Pause',  
                                         prevLinkText:              '<img src="mainpic/lightbox/gal_b_prev.jpg" border="0" align="middle">', 
										 prevLinkText1:				'Prev photo',
                                         nextLinkText:              '<img src="mainpic/lightbox/gal_b_next.jpg" border="0" align="middle">', 
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
                 </script> 
<?php } ?>
                