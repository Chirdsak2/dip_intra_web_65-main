<div class="container-fluid my-5">
    <div class="container">
        <!--Carousel Wrapper-->
        <div id="multi-item-footer" class="carousel slide carousel-multi-item" data-ride="carousel">

            <!--Controls-->
            <!--
			<div class="controls-top text-center mt-5">
				<a class="btn-floating" href="#multi-item-footer" data-slide="prev"><i class="fa fa-chevron-left"></i></a>
				<a class="btn-floating" href="#multi-item-footer" data-slide="next"><i class="fa fa-chevron-right"></i></a>
			</div>
			-->
            <!--/.Controls-->

            <!--Indicators-->
            <ol class="carousel-indicators carousel-indicators-slide">
				<?php for ($i = 1; $i <= ceil(count($count_footer) / 6); $i++) {?>
					<li data-target="#multi-item-footer" data-slide-to="<?php echo $i-1 ?>" class="<?php echo ($i-1 == 0 ? "active" : ""); ?>"></li>
				<?php }?>
            </ol>

            <!--/.Indicators-->

			<!--Slides-->
			<div class="carousel-inner" role="listbox">
			  <?php echo $slide_footer; ?>
			</div>
			<!--/.Slides-->

        </div>
        <!--/.Carousel Wrapper-->
    </div>
</div>