<?php
$vdo = banner::getBanner($template_management["site_mainbanner"]);
// $sso_systems = $sso->getSystems($_SESSION["EWT_USERNAME"], $user_sso["USR_DIVISION"], $template_id);
// $all_main_top_index_t1 = main::getAllmaintopIndext1($sso);
?>

<style>
	.bg-top-index {
		background-image: url(<?php echo !empty($template_management["site_header"]) ? $template_management["site_header"] : 'images/Template1.jpg'; ?>);
	}

	.bg-today-t1 {
		background-color: #f9f9f9
	}

	.h-hbd-t1 {
		color: #cc4272;
	}

	.box-hbd-t1 {
		background-color: #ffe0eb;
		min-height: 115px;
	}

	.btn-hbd-gift-t1 {
		background-color: #d32a9f;
		padding: 2px 2px 2px 5px;
		border-radius: 0px 0px 10px 10px;
		font-size: 13px;
		transition: ease-in-out 0.3s;
	}

	.h-meeting-t1 {
		color: #51187d;
	}

	.box-meeting-t1 {
		background-color: #f4e5ff;
		min-height: 115px;
	}

	.h-en-t1 {
		color: #c4a819;
	}

	.box-en-t1 {
		background-color: #fffadb;
		min-height: 115px;
	}

	.btn-enchitchat-t1 {
		background-color: #D3B520;
		padding: 2px 2px 2px 5px;
		border-radius: 50px;
		font-size: 13px;
		transition: ease-in-out 0.3s;
	}

	.border-ra-15-top {
		border-radius: 15px 15px 0px 0px;
	}

	.border-ra-15-bottom {
		border-radius: 0px 0px 15px 15px;
	}
</style>

<div class="container-fluid bg-today-t1 p-2">
	<div class="container">
		<div class="h-hbd-t1 mt-2"> วันนี้มีอะไร </div>
		<div class="row mx-auto my-auto">
			<div id="myCarousel" class="carousel slide w-100" data-ride="carousel" data-interval="false">
				<ol class="carousel-indicators">
					<!-- <?php if ($all_main_top_index_t1["count"] > 1) {
						for ($i = 0; $i < $all_main_top_index_t1["count"]; $i++) { ?>
							<li data-target="#myCarousel" data-slide-to="<?php echo $i; ?>" class="<?php echo ($i == 0 ? "active" : null); ?> color-bullet1"></li>
					<?php }
					} ?> -->
				</ol>
				<div class="carousel-inner" role="listbox">
					<!-- <?php echo $all_main_top_index_t1["txt"]; ?> -->
				</div>
			</div>
		</div>

	</div>
</div>

<div class="featured bg-top-index main-data-position" id="featured">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-md-12 col-sm-12">
				
				<div class="row">
					<?php //echo $sso_systems["data_t"]; ?>

					<div class="col-lg-3 col-md-6 col-sm-12 col-12 mt-4">
					    <a href="setting_system.php">
					        <div class="icon-box">
					            <img src="" title="" alt="">
					            <br><br>
					                <h3 class="">ระบบทั้งหมด >></h3>
					        </div>
					    </a>
					</div>
				</div>

				<!-- <div class="pt-4 txt-right">
					<a href="setting_system.php" class="more-allsystem">
						<div class="dis-inline-block-more"> ระบบ </div>
						<div class="dis-inline-block-more"> ทั้งหมด </div>
						<div class="dis-inline-block-more"> >> </div>
					</a>
				</div> -->
			</div>
			<div class="col-lg-6 col-md-12 col-sm-12 col-12 py-2">
				<!-- Open Banner Slide -->
				<div id="carouselExampleCaptions" class="carousel slide h-100" data-ride="carousel">
					<?php if ($vdo['count'] > 1) { ?>
						<ol class="carousel-indicators">
							<?php foreach ($vdo["data"] as $key => $value) { ?>
								<li data-target="#carouselExampleCaptions" data-slide-to="<?php echo $key ?>" class="<?php echo ($key == 0 ? "active" : ""); ?>"></li>
							<?php } ?>
						</ol>
					<?php } ?>

					<div class="carousel-inner h-100">
						<?php foreach ($vdo["data"] as $key => $value) { ?>

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
									
									<div class="carousel-caption d-none d-md-block">
                                        <a href="<?php echo trim($value['banner_link']); ?>" title="<?php echo trim($value['banner_name']) ?>" target="<?php echo $value["banner_traget"]; ?>">
                                            <h5 style="padding:15px;background:rgb(0,0,0,0.5); border-radius:10px; color: #FFFFFF;">
                                                <?php echo $value['banner_name']; ?>
                                            </h5>
                                        </a>
                                    </div>
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
					<!-- Close Banner Slide -->
				</div>
			</div>

		</div>
	</div>
</div>

<script>
	// var audio = new Audio("assets/sound/sound_1.mp3");
	// audio.oncanplaythrough = function() {}
	// audio.onended = function() {}
	function audio (ID){
        document.getElementById('player' + ID).play();
    }
</script>

<?php include('component/ecard_modal.php'); ?>
<?php include('component/vocab_popup.php'); ?>


