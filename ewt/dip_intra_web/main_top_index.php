<?php
$banner = banner::getBanner($template_management["site_mainbanner"]);
?>

<style>
    .mar-l--40px {
        margin-left: 0px;
    }

    .alert-num-bell {
        right: 30px;
    }

    .icon-sound {
        filter: invert(27%) sepia(51%) saturate(2878%) hue-rotate(277deg) brightness(104%) contrast(97%);
        width: 26px;
        height: auto;
    }
</style>

<div class="container-fluid px-0 mar-t-90px">
    <div class="">
        <div class="row" style="margin-right: 0px;">
            <!-- Open Banner Slide -->
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12 order-2 order-sm-2 order-lg-2 order-xl-1 pad-x-0-sm pad-x-0-smtolg pr-0">
                <div id="carouselExampleCaptions" class="carousel slide h-100 pad-l--15-lg" data-ride="carousel">
                    <?php if ($banner['count'] > 1) { ?>
                        <ol class="carousel-indicators bullet-position">
                            <?php foreach ($banner["data"] as $key => $value) { ?>
                                <li data-target="#carouselExampleCaptions" data-slide-to="<?php echo $key ?>" class="<?php echo ($key == 0 ? "active" : ""); ?>"></li>
                            <?php } ?>
                        </ol>
                    <?php } ?>

                    <div class="carousel-inner h-100">
                        <?php foreach ($banner["data"] as $key => $value) { ?>

                            <?php $value["vdo_id"] = end(explode(".", trim($value['banner_pic']))); ?>

                            <div class="carousel-item h-100 <?php echo ($key == 0 ? "active" : ""); ?>">
                                <?php if ($value["vdo_id"] == "mp4" || $value["vdo_id"] == "wmv") { ?>
                                    <a href="<?php echo trim($value['banner_link']); ?>" target="<?php echo $value["banner_traget"]; ?>" title="<?php echo trim($value['banner_name']) ?>">
                                        <video autoplay="" muted="" loop="" id="bg-video" style="width: 100%;" controls>
                                            <source type="video/mp4" src="<?php echo trim($value['banner_pic']); ?>" class="d-block w-100 h-100">
                                        </video>
                                    </a>
                                <?php } else { ?>
                                    <a href="<?php echo trim($value['banner_link']); ?>" target="<?php echo $value["banner_traget"]; ?>" title="<?php echo trim($value['banner_name']) ?>">
                                        <img src="<?php echo trim($value['banner_pic']); ?>" class="d-block w-100 h-100 max-height-main-banner" title="<?php echo trim($value['banner_name']) ?>" alt="<?php echo trim($value['banner_name']) ?>">
                                    </a>
                                    <!-- <div class="carousel-caption label_caption">
                                        <a href="<?php //echo trim($value['banner_link']); ?>" title="<?php //echo trim($value['banner_name']) ?>" target="<?php //echo $value["banner_traget"]; ?>">
                                            <div class="title_caption">
                                                <?php //echo $value['banner_name']; ?>
                                            </div>
                                        </a>
                                    </div> -->
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>

                    <button class="carousel-control-prev" type="button" data-target="#carouselExampleCaptions" data-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="sr-only">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-target="#carouselExampleCaptions" data-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="sr-only">Next</span>
                    </button>
                </div>
            </div>
            <!-- Close Banner Slide -->

            <!-- Close Systems -->
        </div>
        <!-- Close Content aleart -->
    </div>
</div>
</div>

<script>
    // var audio = new Audio("assets/sound/sound_1.mp3");
    // audio.oncanplaythrough = function() {}
    // audio.onended = function() {}
    function audio(ID) {
        document.getElementById('player' + ID).play();
    }
</script>

<?php include('component/notification.php'); ?>
<?php include('component/vocab_popup.php'); ?>
