<div class="featured bg-top-index main-data-position" id="featured">
	<div class="container">
		<div class="row">
			<div class="col-lg-6 col-md-12 col-sm-12">
				<!-- <div class="txt-start-dashboard"> ข้อมูลระบบ </div> -->
				<!-- <div class="h-dashboard"> ระบบงานกรมฯ </div> -->
				<div class="row">
					<div class="col-lg-3 col-md-6 col-sm-12 col-12 mt-4">
						<a href="#">
							<div class="icon-box">
								<img src="assets/img/system/system_01.png" title="ระบบประเมินผล" alt="ระบบประเมินผล" class="img-hover">
								<h3 class=""> ระบบประเมินผล </h3>
							</div>
						</a>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-12 col-12 mt-4">
						<a href="#">
							<div class="icon-box">
								<img src="assets/img/system/system_02.png" title="วมสื่อประชาสัมพันธ์ 2565" alt="วมสื่อประชาสัมพันธ์ 2565" class="img-hover">
								<h3 class=""> รวมสื่อประชาสัมพันธ์ 2565 </h3>
							</div>
						</a>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-12 col-12 mt-4">
						<a href="#">
							<div class="icon-box">
								<img src="assets/img/system/system_03.png" title="สารบรรณอิเล็กทรอนิกส์" alt="สารบรรณอิเล็กทรอนิกส์" class="img-hover">
								<h3 class=""> สารบรรณอิเล็กทรอนิกส์ </h3>
							</div>
						</a>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-12 col-12 mt-4">
						<a href="#">
							<div class="icon-box">
								<img src="assets/img/system/system_04.png" title="อีเมล กปส." alt="อีเมล กปส." class="img-hover">
								<h3 class=""> อีเมล กปส. </h3>
							</div>
						</a>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-12 col-12 mt-4">
						<a href="#">
							<div class="icon-box">
								<img src="assets/img/system/system_05.png" title="BIG DATA" alt="BIG DATA " class="img-hover">
								<h3 class=""> BIG DATA </h3>
							</div>
						</a>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-12 col-12 mt-4">
						<a href="#">
							<div class="icon-box">
								<!-- <i class="bi bi-film"></i> -->
								<img src="assets/img/system/system_06.png" title="คลังภาพและเสียง" alt="คลังภาพและเสียง" class="img-hover">
								<h3 class=""> คลังภาพและเสียง </h3>
							</div>
						</a>
					</div>

					<div class="col-lg-3 col-md-6 col-sm-12 col-12 mt-4">
						<a href="#">
							<div class="icon-box">
								<img src="assets/img/system/system_07.png" title="E-DOCUMENT" alt="E-DOCUMENT" class="img-hover">
								<h3 class=""> E-DOCUMENT </h3>
							</div>
						</a>
					</div>
					<div class="col-lg-3 col-md-6 col-sm-12 col-12 mt-4">
						<a href="#">
							<div class="icon-box">
								<img src="assets/img/system/system_08.png" title="SMART CARD" alt="SMART CARD" class="img-hover">
								<h3 class=""> SMART CARD </h3>
							</div>
						</a>
					</div>
				</div>

				<div class="pt-4 txt-right">
					<a href="setting_system.php" class="more-allsystem">
						<div class="dis-inline-block-more"> ระบบ </div>
						<div class="dis-inline-block-more"> ทั้งหมด </div>
						<div class="dis-inline-block-more"> >> </div>
					</a>
				</div>

			</div>
			<div class="col-lg-6 col-md-12 col-sm-12 col-12 py-2">
				<!-- Open Banner Slide -->
				<div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
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