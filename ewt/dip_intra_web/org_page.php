<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<?php include('org_menu.php'); ?>
<?php
$org_banner = banner::getBanner($org_page[0]["c_show_org_banner"]);
$org_title1 = org::getArticleOrg($org_page[0]["c_show_org1"]);
$org_title2 = org::getArticleOrg($org_page[0]["c_show_org2"]);
$org_title3 = org::getArticleOrg($org_page[0]["c_show_org3"]);
$org_article1 = org::getArticleOrgSub($org_page[0]["c_show_org1"]);
$org_article2 = org::getArticleOrgSub($org_page[0]["c_show_org2"]);
$org_article3 = org::getArticleOrg($org_page[0]["c_show_org3"]);
?>

<!-- Style CSS Template 3 -->
<link rel="stylesheet" href="assets/css/article.css">
<link rel="stylesheet" href="assets/css/org_page.css">

<style>
	.bg-org-page {
		background: url(<?php echo (empty($org_page[0]['c_show_org_image']) ? "images/bg_org_page.jpg" : trim($org_page[0]['c_show_org_image'])); ?>) center;
		background-size: cover;
	}
</style>

<div id="main" style="margin-left: 300px;">
	<div class="container-fluid">
		<div class="container mar-t-90px">

			<div id="org_banner" class="carousel slide h-100" data-ride="carousel">
				<?php if ($org_banner['count'] > 1) { ?>
					<ol class="carousel-indicators">
						<?php foreach ($org_banner["data"] as $key => $value) { ?>
							<li data-target="#org_banner" data-slide-to="<?php echo $key ?>" class="<?php echo ($key == 0 ? "active" : ""); ?>"></li>
						<?php } ?>
					</ol>
				<?php } ?>

				<div class="carousel-inner h-100">
					<?php foreach ($org_banner["data"] as $key => $value) { ?>

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
				<button class="carousel-control-prev" type="button" data-target="#org_banner" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</button>
				<button class="carousel-control-next" type="button" data-target="#org_banner" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</button>
			</div>


			<!-- <div id="org_banner" class="carousel slide" data-ride="carousel">
				<?php if ($org_banner["count"] > 1) { ?>
					<ol class="carousel-indicators">
						<?php foreach ($org_banner["data"] as $value) { ?>
							<li data-target="#org_banner" data-slide-to="<?php echo $key ?>" class="<?php echo ($key == 0 ? "active" : ""); ?>"></li>
						<?php } ?>
					</ol>
				<?php } ?>

				<div class="carousel-inner">
					<?php foreach ($org_banner["data"] as $value) { ?>
						<div class="carousel-item <?php echo ($key == 0 ? "active" : ""); ?>">
							<a href="<?php echo trim($value['banner_link']); ?>" target="<?php echo $value["banner_traget"]; ?>">
								<img src="<?php echo trim($value['banner_pic']); ?>" class="d-block w-100" alt="<?php echo $value["banner_name"]; ?>">
							</a>
						</div>
					<?php } ?>
				</div>
				<button class="carousel-control-prev" type="button" data-target="#org_banner" data-slide="prev">
					<span class="carousel-control-prev-icon" aria-hidden="true"></span>
					<span class="sr-only">Previous</span>
				</button>
				<button class="carousel-control-next" type="button" data-target="#org_banner" data-slide="next">
					<span class="carousel-control-next-icon" aria-hidden="true"></span>
					<span class="sr-only">Next</span>
				</button>
			</div> -->
		</div>
	</div>

	<div class="container-fluid bg-org-page padding--50">
		<div class="container">

			<button class="openbtn" onclick="openNav()">เมนู <i class="fas fa-bars"></i></button>

			<div class="text-center mb-5 text-white">
				<h3>ยินดีต้อนรับสู่ <?php echo $org_page[0]['c_name']; ?></h3>
			</div>
			<div class="row">
				<!-- ข่าว 1 -->
				<?php if (!empty($org_article1) && $org_page[0]['c_show_document'] == 'Y') { ?>
					<div class="col-lg-6 col-md-6">
						<div class="text-white mb-3">
							<h6><?php echo $org_title1[0]["c_name"] ?></h6>
						</div>

						<?php foreach ($org_article1 as $key => $value) { ?>
							<?php //$n_owner = $sso->getOrg($value['n_owner_org'])['name']; ?>
							<div class="aritcle--card">
								<div class="row">

									<?php if (!empty($value['picture']) && $org_page[0]["c_show_document"] == 'Y') { ?>
										<div class="col-lg-3">
											<a href="<?php echo ($value['news_use'] == 1 ? $value['link_html'] : "news_view.php?n_id=" . $value['n_id'] . " "); ?>" target="<?php echo $value['target']; ?>" title="<?php echo $value['n_topic']; ?>">
												<img src="images/article/news<?php echo $value['n_id'] . '/', $value['picture']; ?>" alt="<?php echo $value['picture']; ?>" class="article--pic">
											</a>
										</div>
									<?php } ?>

									<div class="<?php echo (!empty($value['picture']) && $org_page[0]["c_show_document"] == 'Y' ? "col-lg-9" : "col-lg-12"); ?>">
										<div class="article--title">
											<a onclick="newsCount(<?php echo $value['c_id']; ?>,<?php echo $value['n_id']; ?>,'news_tab_index');" href="<?php echo ($value['news_use'] == 1 ? $value['link_html'] : "news_view.php?n_id=" . $value['n_id'] . " "); ?>" target="<?php echo $value['target']; ?>" title="<?php echo $value['n_topic']; ?>">
												<?php echo (!empty($value['picture']) && $org_page[0]["c_show_document"] == 'Y' ? mb_strimwidth($value['n_topic'], 0, 50, '...') : mb_strimwidth($value['n_topic'], 0, 80, '...')); ?>
											</a>
										</div>
										<div class="article-date-time">
											<span class="mr-2"> <em class="far fa-calendar"></em> <?php echo ($value['show_date'] == 1 ? convDateThai($value['n_date'])['DateTH'] . ' ' . convDateThai($value['n_timestamp'])['TimeTH'] : null); ?> </span>
											<span class="mr-2" id="list_count<?php echo $value['n_id']; ?>"> <em class="far fa-eye"></em> <?php echo $value['view_count']; ?> </span>
											<span class="mr-2 "> <a href="<?php echo (file_exists($value['link_html']) ? $value['link_html'] : "#"); ?>">
													<em class="fa fa-user"></em> <?php echo $n_owner; ?> </a>
											</span>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>

						<div class="text-center">
							<a href="more_news.php?c_id=<?php echo $value['c_id']."&c_org=".$c_id; ?>" target="_black">
								<div class="more-news mx-auto my-3">อ่านทั้งหมด</div>
							</a>
						</div>

					</div>
				<?php } ?>

				<!-- ข่าว 2 -->
				<?php if (!empty($org_article2) && $org_page[0]['c_show_document'] == 'Y') { ?>
					<div class="col-lg-6 col-md-6">
						<div class="text-white mb-3">
							<h6><?php echo $org_title2[0]["c_name"] ?></h6>
						</div>

						<?php foreach ($org_article2 as $key => $value) { ?>
							<?php //$n_owner = $sso->getOrg($value['n_owner_org'])['name']; ?>
							<div class="aritcle--card">
								<div class="row">

									<?php if (!empty($value['picture']) && $org_page[0]["c_show_document"] == 'Y') { ?>
										<div class="col-lg-3">
											<a href="<?php echo ($value['news_use'] == 1 ? $value['link_html'] : "news_view.php?n_id=" . $value['n_id'] . " "); ?>" target="<?php echo $value['target']; ?>" title="<?php echo $value['n_topic']; ?>">
												<img src="images/article/news<?php echo $value['n_id'] . '/', $value['picture']; ?>" alt="<?php echo $value['picture']; ?>" class="article--pic">
											</a>
										</div>
									<?php } ?>

									<div class="<?php echo (!empty($value['picture']) && $org_page[0]["c_show_document"] == 'Y' ? "col-lg-9" : "col-lg-12"); ?>">
										<div class="article--title">
											<a onclick="newsCount(<?php echo $value['c_id']; ?>,<?php echo $value['n_id']; ?>,'news_tab_index');" href="<?php echo ($value['news_use'] == 1 ? $value['link_html'] : "news_view.php?n_id=" . $value['n_id'] . " "); ?>" target="<?php echo $value['target']; ?>" title="<?php echo $value['n_topic']; ?>">
												<?php echo (!empty($value['picture']) && $org_page[0]["c_show_document"] == 'Y' ? mb_strimwidth($value['n_topic'], 0, 50, '...') : mb_strimwidth($value['n_topic'], 0, 80, '...')); ?>
											</a>
										</div>
										<div class="article-date-time">
											<span class="mr-2"> <em class="far fa-calendar"></em> <?php echo ($value['show_date'] == 1 ? convDateThai($value['n_timestamp'])['DateTH'] : null); ?> </span>
											<span class="mr-2" id="list_count<?php echo $value['n_id']; ?>"> <em class="far fa-eye"></em> <?php echo $value['view_count']; ?> </span>
											<span class="mr-2 "> <a href="<?php echo (file_exists($value['link_html']) ? $value['link_html'] : "#"); ?>">
													<em class="fa fa-user"></em> <?php echo $n_owner; ?> </a>
											</span>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>

						<div class="text-center">
							<a href="more_news.php?c_id=<?php echo $value['c_id']."&c_org=".$c_id; ?>" target="_black">
								<div class="more-news mx-auto my-3">อ่านทั้งหมด</div>
							</a>
						</div>
					</div>
				<?php } ?>
			</div>
		</div>
	</div>

	<div class="container-fluid header--bg p-3">
		<!-- ข่าว 3 -->
		<?php if ($org_page[0]['c_show_document'] == 'Y') { ?>
			<div class="container">
				<div class="text-center mt-3 mb-3">
					<h4><?php echo $org_title3[0]["c_name"] ?></h4>
				</div>
				<!-- <div> -->
					<!-- <ul class="nav nav-tabs my-4 ul-li-center" id="myTab" role="tablist" style="border-bottom: 0px;">
						<?php foreach ($org_article3 as $key => $value) { ?>
							<li class="nav-item mx-2" role="presentation">
								<a class="nav-link <?php echo ($key == 0 ? "active" : null); ?>" id="org-article<?php echo $key; ?>" data-toggle="tab" href="#org_article<?php echo $key; ?>" role="tab" aria-controls="org_article<?php echo $key; ?>" aria-selected="true"> <span><?php echo $value["c_name"]; ?></span> </a>
							</li>
						<?php } ?>
					</ul> -->
					<div class="tab-content" id="myTabContent">
						<div class="tab-pane fade <?php echo ($key == 0 ? "show active" : null); ?>" id="org_article<?php echo $key; ?>" role="tabpanel" aria-labelledby="org-article<?php echo $key; ?>">
							<div class="row">
								<?php foreach (article::getSubArticleList($start, 6, $value["c_id"]) as $k => $val) { ?>
									<div class="col-lg-4 col-md-4 col-sm-6 col-12 px-2">
										<div class="card mb-3">
											<div class="row no-gutters">
												<div class="col-lg-3 col-md-3 col-sm-3 col-3 article-org-block-left">
													<div class="text-center article-org-date"><?php echo date('d', strtotime($val['n_date'])); ?></div>
													<div class="text-center article-org-montyear"><?php echo convDateThai($val['n_date'])['MTs']; ?><?php echo substr(date('Y', strtotime($val['n_date'])), 2); ?></div>
												</div>
												<div class="col-lg-9 col-md-9 col-sm-9 col-9">
													<div class="card-body p-2">
														<div class="card-title boldtext article-org-title-space-left">
															<a onclick="newsCount(<?php echo $val['c_id']; ?>,<?php echo $val['n_id']; ?>,'news_tab_index');" href="<?php echo ($val['news_use'] == 1 ? $val['link_html'] : "news_view.php?n_id=" . $val['n_id'] . " "); ?>" target="<?php echo $val['target']; ?>" title="<?php echo $val['n_topic']; ?>">
																<?php echo mb_strimwidth($val['n_topic'], 0, 80, '...'); ?>
															</a>
														</div>
														<p class="card-text font13px">
															<span class="mr-2" id="list_count<?php echo $val['n_id']; ?>">
																<em class="far fa-eye"></em> <?php echo $val['view_count']; ?>
															</span>
															<span class="mr-2">
																<a href="<?php echo (file_exists($val['link_html']) ? $val['link_html'] : "#"); ?>">
																	<em class="fa fa-user"></em>
																	<?php echo $sso->getOrg($val["n_owner_org"])["name"] ?>
																</a>
															</span>
														</p>
													</div>
												</div>
											</div>
										</div>
									</div>
								<?php } ?>
							</div>

							<div class="row">
								<div class="col-12 text-center">
									<a href="more_news.php?c_id=<?php echo $value['c_id']."&c_org=".$c_id; ?>" target="_black">
										<div class="more-index mx-auto my-3">
											อ่านทั้งหมด
										</div>
									</a>
								</div>
							</div>
						</div>
					</div>
				<!-- </div> -->
			</div>
		<?php } ?>
	</div>
</div>
<?php include('component/news_count.php'); ?>
<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>