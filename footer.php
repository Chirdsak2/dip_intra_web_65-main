
</div>
</div>
<div  style="padding-bottom:100px;"></div>
<footer class="footer panel-footer fix navbar-fixed-footer">
<div class="container">
<p>© Copyright © 2017, BizPotential.com - All Rights Reserved.</p>
</div>
</footer>
<a href="#" class="scrollup" style="display: none;"><span class="glyphicon glyphicon-circle-arrow-up scrollup-icon"></span></a>	

<script src="<?=$IMG_PATH;?>js/jquery-3.1.0.js"></script> 
<script src="<?=$IMG_PATH;?>js/bootstrap.js"></script>
<script type="text/javascript">
$(document).ready(function(){ 
			
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
});
</script>
<!-- Slick Slider -->
<script type="text/javascript" src="<?=$IMG_PATH;?>assets/js/slick.js"></script> 
<!-- Custom js -->
<script type="text/javascript" src="<?=$IMG_PATH;?>assets/js/custom.js"></script>
