<?php $banner = banner::getBanner("39"); ?>
<?php if (!empty($banner)) { ?>
    <script type="text/javascript">
        $(window).on('load', function() {
            var delayMs = 1000; // delay in milliseconds

            setTimeout(function() {
                $('#popupHome').modal('show');
            }, delayMs);
        });
    </script>
<?php } ?>

<div class="modal hide fade" id="popupHome">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="popup--header">
                <button type="button" class="close popup-close" data-dismiss="modal"><i class="fas fa-window-close"></i></button>
            </div>
            <div class="modal-body">
                <!-- <img src="assets/img/Banner.png" class="img-fluid"> -->
                <div class="container">
                    <div id="popup-home" class="carousel slide carousel-multi-item" data-ride="carousel">
                        <?php if ($vdo['count'] > 1) { ?>
                            <ol class="carousel-indicators">
                                <?php foreach ($vdo["data"] as $key => $value) { ?>
                                    <li data-target="#carouselExampleCaptions" data-slide-to="<?php echo $key ?>" class="<?php echo ($key == 0 ? "active" : ""); ?>"></li>
                                <?php } ?>
                            </ol>
                        <?php } ?>

                        <!-- <div class="carousel-inner" role="listbox">
                            <?php foreach ($banner["data"] as $key => $value) { ?>
                                <div class="carousel-item <?php echo ($key == 0 ? "active" : ""); ?>">
                                    <div class="row">
                                        <div class="col-lg-12 col-md-12">
                                            <div class="mb-2">
                                                <a href="<?php echo trim($value['banner_link']); ?>" target="<?php echo $value["banner_traget"]; ?>">
                                                    <img class="img-fluid" src="<?php echo trim($value['banner_pic']); ?>" 
                                                    alt="<?php echo trim($value['banner_name']) ?>">
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php } ?>
                        </div> -->

                        <div class="carousel-inner h-100">
                            <?php foreach ($banner["data"] as $key => $value) { ?>

                                <?php $video = end(explode(".", trim($value['banner_pic']))); ?>

                                <div class="carousel-item h-100 <?php echo ($key == 0 ? "active" : ""); ?>">
                                    <?php if ($video == "mp4" || $video == "wmv") { ?>
                                        <a href="<?php echo trim($value['banner_link']); ?>" target="<?php echo $value["banner_traget"]; ?>">
                                            <video autoplay="" muted="" loop="" id="bg-video" style="width: 100%;" controls>
                                                <source type="video/mp4" src="<?php echo trim($value['banner_pic']); ?>" class="d-block w-100 h-100">
                                            </video>
                                        </a>
                                    <?php } else { ?>
                                        <a href="<?php echo trim($value['banner_link']); ?>" target="<?php echo $value["banner_traget"]; ?>">
                                            <img src="<?php echo trim($value['banner_pic']); ?>" class="d-block w-100 h-100" alt="<?php echo trim($value['banner_name']) ?>">
                                        </a>
                                    <?php } ?>
                                </div>
                            <?php } ?>
                        </div>

                        <button class="carousel-control-prev" type="button" data-target="#popup-home" data-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="sr-only">Previous</span>
                        </button>

                        <button class="carousel-control-next" type="button" data-target="#popup-home" data-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="sr-only">Next</span>
                        </button>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    .popup-close {
        font-size: 25px;
        padding: 10px;
        color: #260273;
        background: #FFFFFF;
        border: 0px solid #FFFFFF;
        float: right;
        display: block;
        padding: 10px;
    }

    .popup-content {
        border: 5px solid #260273;
        background: #FFFFFF;
        border-radius: 10px;
    }

    .popup--header {
        padding: 16px;
        border-bottom: 0px solid #FFFFFF;
    }
</style>