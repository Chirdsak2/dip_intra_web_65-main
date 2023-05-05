<?php
$vdo = banner::getBanner($template_management["site_mainbanner"]);
$menu_view2 = menu::genMenuView2($template_management["site_submenu"], 2);
$article_group_first = article::getArticleFirstGroup(1);
$article_listAll_t2 = article::getSubArticleList(0, 3, 1); /* 0,6,1 */
?>

<div class="container-fluid bg-purple-menu2 txt-white mb-3">
	<div class="container">
		<nav class="nav py-3">
			<?php echo $menu_view2["level1"]; ?>

			<li class="nav-link ml-auto">
				<a class="color-font-size pl-2" href="#"> <span class="font-s txt-white-nav" id="decrease" value="Decrease"> ก </span></a>
				<a class="color-font-size pl-2" href="#"> <span class="font-m txt-white-nav" id="normal" value="normal"> ก </span></a>
				<a class="color-font-size pl-2" href="#"> <span class="font-l txt-white-nav" id="increase" value="Increase"> ก </span></a>
			</li>
		</nav>
	</div>
</div>

<div class="container mb-3">
	<div class="">
		<div class="row">
			<!-- Open Banner Slide -->
			<!-- Open add class="col-xl-6" 18/05/2565 -->
			<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 order-2 order-sm-2 order-lg-1">
				<!-- Close add class="col-xl-6" 18/05/2565 -->
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
				</div>
			</div>
			<!-- Close Banner Slide -->

			<!-- Open Content aleart -->
			<!-- Open add class="col-xl-6" 18/05/2565 -->
			<div class="col-xl-6 col-lg-12 col-md-12 col-sm-12 col-12 pl-0 order-1 order-sm-1 order-lg-2 mt-2">
				<!-- Close add class="col-xl-6" 18/05/2565 -->
				<div class="row">
					<?php
					foreach ($article_listAll_t2 as $key => $value) { ?>
						<?php
						$n_owner = $sso->getOrg($value['n_owner_org'])['name'];
						$c_group = article::getArticleFirstGroup(null, $value["n_id"]);
						?>
						<div class="col-lg-12 col-md-12 col-sm-12 col-12 px-2">
							<!-- Open add class="ml-3" 18/05/2565 -->
							<div class="card mb-3 ml-3">
								<!-- Close add class="ml-3" 18/05/2565 -->
								<div class="dis-inline-flex-news">
									<!-- Open มีภาพประกอบให้แสดงโค้ดนี้ -->
									<?php if (!empty($value["picture"]) && $c_group['c_show_pic'] == "Y") { ?>
										<div class="dis-inline-flex max-width-left-pic">
											<img src="<?php echo 'images/article/news' . $value['n_id'] . '/', $value['picture']; ?>" alt="<?php echo 'images/article/news' . $value['n_id'] . '/', $value['picture']; ?>" class="w-100 p-2 border-ra-15px height-max-content">
										</div>
									<?php } elseif ($c_group['c_show_pic'] != "Y" && $c_group['c_show_pic'] != "N") { ?>
										<div class="dis-inline-flex max-width-left-pic w-100 icon__block">
											<div class="border-r-graylight txt-color-purple w-100">
												<div class="text-center font60px-lg font-weight-bold px-3 pt-2 line-height-70px">
													<a href="<?php echo ($value['news_use'] == 1 ? $value['link_html'] : "news_view.php?n_id=" . $value['n_id'] . " "); ?>" target="<?php echo $value['target']; ?>" title="<?php echo $c_group['c_name']; ?>">
														<img src="<?php echo $c_group['c_show_pic']; ?>" style="padding:3px 10px; width:50px;">
													</a>
												</div>
											</div>
										</div>
									<?php } else { ?>
										<div class="dis-inline-flex max-width-left-pic w-100">
											<div class="border-r-graylight txt-color-purple w-100">
												<div class="text-center font60px-lg font-weight-bold px-3 pt-2 line-height-70px">
													<?php echo date('d', strtotime($value['n_date'])); ?>
												</div>
												<div class="text-center font15px font-weight-bold">
													<?php echo convDateThai($value['n_date'])['DateH']; ?>
												</div>
											</div>
										</div>
									<?php } ?>
									<!-- Close มีภาพประกอบให้แสดงโค้ดนี้ -->
									<div class="dis-inline-flex">
										<div class="card-body p-2">
											<div class="card-title font14px">
												<div class="font12px mb-2">
													<a href="more_news.php?page=<?php echo $page . "&c_id=" . $value['c_id']; ?>" class="txt-color-purple-2-news font-weight-bold"> <?php echo $value['c_name']; ?> </a>
												</div>
												<?php if ($value["pinned"] == 'Y') { ?>
													<img src="assets/img/pin-webboard.png" title="ปักหมุด" alt="ปักหมุด" class="max-w-20px dis-inline">
												<?php } ?>
												<a onclick="newsCount(<?php echo $value['c_id']; ?>,<?php echo $value['n_id']; ?>,'news_tab_index');" href="<?php echo ($value['news_use'] == 1 ? $value['link_html'] : "news_view.php?c_id=" . $value['c_id'] . "&n_id=" . $value['n_id'] . " "); ?>" target="<?php echo $value['target']; ?>" title="<?php echo $value['n_topic']; ?>" class="font-weight-bold txt-gray-dark2">
													<?php echo mb_strimwidth($value['n_topic'], 0, 26, '...'); ?>
												</a>
											</div>
											<p class="card-text font12px txt-color-purple-2">
												<span class="mr-2" id="list_count<?php echo $value['n_id']; ?>"> <em class="far fa-eye"></em> <?php echo $value['view_count']; ?> </span>
												<span class="mr-2"> <em class="far fa-calendar"></em> <?php echo ($value['show_date'] == 1 ? convDateThai($value['n_date'])['DateTH'] . ' ' . convDateThai($value['n_timestamp'])['TimeTH'] : null); ?> </span><br>
												<?php if ($n_owner) { ?>
													<span class="mr-2">
														<a href="<?php echo (file_exists($value['link_html']) ? $value['link_html'] : "#"); ?>">
															<em class="far fa-user"></em>
															<?php echo $n_owner; ?>
														</a>
													</span>
												<?php } ?>
												<?php if ($c_group) { ?>
													<span class="mr-2">
														<a href="more_news.php?c_id=<?php echo $c_group["c_id"]; ?>">
															<em class="fas fa-book"></em>
															<?php echo $c_group["c_name"]; ?>
														</a>
													</span>
												<?php } ?>
											</p>
										</div>
									</div>
								</div>
							</div>
						</div>
					<?php } ?>
				</div>
			</div>
			<!-- Close Content aleart -->
		</div>
	</div>
</div>

<?php include('component/news_count.php'); ?>