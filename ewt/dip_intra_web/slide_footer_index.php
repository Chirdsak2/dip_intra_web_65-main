<?php
$template_section = sitelayout::getSiteLayout("site_management_section", "banner"); 
$slide_footer = banner::getSlideFooter($template_section["section_data"]); 
?>
<div class="container-fluid my-5">
    <div class="container">
        <!--Carousel Wrapper-->
        <div id="multi-item-footer" class="carousel slide carousel-multi-item" data-ride="carousel">
            
            <!--Indicators-->
            <?php if ($slide_footer["count"] > 6) { ?>
                <ol class="carousel-indicators carousel-indicators-slide">
                    <?php for ($i = 0; $i < $slide_footer["count"]; $i++) { ?>
                        <li data-target="#multi-item-footer" data-slide-to="<?php echo $i ?>" class="<?php echo ($i == 0 ? "active" : ""); ?>"></li>
                    <?php } ?>
                </ol>
            <?php } ?>
            <!--/.Indicators-->

            <!--Slides-->
            <div class="carousel-inner" role="listbox">
                <!-- <?php echo $slide_footer["data"]; ?> -->
                <?php for ($i = 0; $i < $slide_footer["count"]; $i++) { ?>
                    <div class="carousel-item <?php echo ($i == 0 ? 'active' : null); ?>">
                        <div class="row">
                            <?php foreach ($slide_footer["data"][$i] as $key => $value) { ?>
                                <div class="col-lg-2 col-md-2 col-sm-6 col-6 mb-3">
                                    <div class="mb-2">
                                        <a href="<?php echo trim($value['banner_link']); ?>" target="<?php echo $value['banner_traget']; ?>" title="<?php echo $value['banner_alt']; ?>">
                                            <img class="card-img-top" src="<?php echo trim($value['banner_pic']); ?>" title="<?php echo $value['banner_alt']; ?>" alt="<?php echo $value['banner_alt']; ?>">
                                        </a>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                <?php } ?>
            </div>
            <!--/.Slides-->
            <style>
                .arrow-banner-footer-only{
                    background-color: #a3a3a3; width: 4% !important;top: 20% !important;
                }
            </style>
            <a class="carousel-control-prev arrow-banner-footer-only" href="#multi-item-footer" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next arrow-banner-footer-only" href="#multi-item-footer" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>

        </div>
        <!--/.Carousel Wrapper-->
    </div>
</div>