<div class="container py-2">
	<div class="row">

		<div class="col-lg-4 col-md-6 col-sm-12 col-12 py-3 line-dashed-right">

			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center">
					<div class="h-news-col"> หนังสือเวียน </div>
				</div>
			</div>

			<div class="row">
				<?php foreach ($article_list_t1[0] as $val) { ?>
					<?php $n_owner = article::getOrg($val['n_owner'])['short_name']; ?>
					<div class="col-12 border-b-list line-dashed-bottom">
						<div class="h-news-list mt-2">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-8">
									<div class="<?php echo (empty($val['picture']) ? "dis-inline-flex-news" : "row no-gutters"); ?>">

										<div class="<?php echo (empty($val['picture']) ? "dis-inline-flex max-width-left-pic" : "col-lg-4 col-md-12 col-sm-12 col-12"); ?>">
											<?php if (!empty($val['picture'])) { ?>
												<img src="<?php echo HOST_NAME; ?>images/article/news<?php echo $val['n_id'] . '/', $val['picture']; ?>" alt="<?php echo $val['picture']; ?>" class="w-100 p-2 border-ra-15px" title="<?php echo $val['picture']; ?>">
											<?php } ?>
										</div>

										<div class="<?php echo (empty($val['picture']) ? "dis-inline-flex" : "col-lg-8 col-md-12 col-sm-12 col-12"); ?>">
											<div class="card-body p-2">
												<div class="detial-news-tab">
													<em class="far fa-calendar"></em> <?php echo ($val['show_date'] == 1 ? convDateThai($val['n_timestamp'])['DateTH'] : null); ?>
												</div>

												<a onclick="newsCount(<?php echo $val['c_id']; ?>,<?php echo $val['n_id']; ?>);" href="<?php echo ($val['news_use'] == 1 ? HOST_NAME . $val['link_html'] : "news_view.php?c_id=" . $val['c_id'] . "&n_id=" . $val['n_id'] . " "); ?>" target="<?php echo $val['target']; ?>" title="<?php echo $val['n_topic']; ?>">
													<div class="h-news-tab text-short">
														<?php echo $val['n_topic']; ?>
													</div>
												</a>

												<a href="<?php echo (file_exists($val['link_html']) ? $val['link_html'] : "#"); ?>" class="txt-department">
													<span class="mr-2" id="list_count<?php echo $val['n_id']; ?>">
														<em class="far fa-eye"></em>
														<?php echo $val['view_count']; ?>
													</span>
													<em class="far fa-folder"></em> <?php echo $n_owner; ?>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>

			<div class="p-2 txt-right">
				<a href="more_news.php?page=<?php echo $page . "&c_id=1"; ?>" class="more-api" target="_black">
					อ่านทั้งหมด
				</a>
			</div>
		</div>

		<div class="col-lg-4 col-md-6 col-sm-12 col-12 py-3 line-dashed-right">

			<div class="row">
				<div class="col-lg-12 col-md-12 col-sm-12 col-12 text-center">
					<div class="h-news-col"> ประชาสัมพันธ์</div>
				</div>
			</div>

			<div class="row">
				<?php foreach ($article_list_t1[1] as $val) { ?>
					<?php $n_owner = article::getOrg($val['n_owner'])['short_name']; ?>
					<div class="col-12 border-b-list line-dashed-bottom">
						<div class="h-news-list mt-2">
							<div class="row">
								<div class="col-lg-12 col-md-12 col-sm-12 col-8">
									<div class="<?php echo (empty($val['picture']) ? "dis-inline-flex-news" : "row no-gutters"); ?>">

										<div class="<?php echo (empty($val['picture']) ? "dis-inline-flex max-width-left-pic" : "col-lg-4 col-md-12 col-sm-12 col-12"); ?>">
											<?php if (!empty($val['picture'])) { ?>
												<img src="<?php echo HOST_NAME; ?>images/article/news<?php echo $val['n_id'] . '/', $val['picture']; ?>" alt="<?php echo $val['picture']; ?>" class="w-100 p-2 border-ra-15px" title="<?php echo $val['picture']; ?>">
											<?php } ?>
										</div>

										<div class="<?php echo (empty($val['picture']) ? "dis-inline-flex" : "col-lg-8 col-md-12 col-sm-12 col-12"); ?>">
											<div class="card-body p-2">
												<div class="detial-news-tab">
													<em class="far fa-calendar"></em> <?php echo ($val['show_date'] == 1 ? convDateThai($val['n_timestamp'])['DateTH'] : null); ?>
												</div>

												<a onclick="newsCount(<?php echo $val['c_id']; ?>,<?php echo $val['n_id']; ?>);" href="<?php echo ($val['news_use'] == 1 ? HOST_NAME . $val['link_html'] : "news_view.php?c_id=" . $val['c_id'] . "&n_id=" . $val['n_id'] . " "); ?>" target="<?php echo $val['target']; ?>" title="<?php echo $val['n_topic']; ?>">
													<div class="h-news-tab text-short">
														<?php echo $val['n_topic']; ?>
													</div>
												</a>

												<a href="<?php echo (file_exists($val['link_html']) ? $val['link_html'] : "#"); ?>" class="txt-department">
													<span class="mr-2" id="list_count<?php echo $val['n_id']; ?>">
														<em class="far fa-eye"></em>
														<?php echo $val['view_count']; ?>
													</span>
													<em class="far fa-folder"></em> <?php echo $n_owner; ?>
												</a>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>

			<div class="p-2 txt-right">
				<a href="more_news.php?page=<?php echo $page . "&c_id=2"; ?>" class="more-api" target="_black">
					อ่านทั้งหมด
				</a>
			</div>
		</div>

		<div class="col-lg-4 col-md-12 col-sm-12 col-12">
			<div class="col-lg-12 col-md-12 col-sm-12 col-12 mt-3 text-center">
				<div class="h-news-col"> ข้อมูลเผยแพร่ </div>
			</div>

			<ul class="nav nav-tabs" id="myTab" role="tablist">
				<?php foreach ($article_sub_group_t1 as $key => $value) { ?>
					<li class="nav-item" role="presentation">
						<a class="nav-link <?php echo ($key == 0 ? "active" : null); ?>" id="temp1-tab_<?php echo $key; ?>" data-toggle="tab" href="#temp1_<?php echo $key; ?>" role="tab" aria-controls="temp1_<?php echo $key; ?>" aria-selected="<?php echo ($key == 0 ? "true" : "false"); ?>">
							<?php echo $value["c_name"];  ?>
						</a>
					</li>
				<?php } ?>
			</ul>

			<div class="tab-content" id="myTabContent">
				<?php foreach ($article_sub_group_t1 as $key => $value) { ?>
					<div class="tab-pane fade <?php echo ($key == 0 ? "show active" : null); ?>" id="temp1_<?php echo $key; ?>" role="tabpanel" aria-labelledby="temp1-tab_<?php echo $key; ?>">
						<?php foreach (article::getArticleList($start, 6, $value["c_id"]) as $k => $val) { ?>
							<div class="col-12 line-dashed-bottom">
								<div class="h-news-list">
									<div class="row">
										<div class="col-lg-12 col-md-12 col-sm-12 col-8">
											<div class="<?php echo (empty($val['picture']) ? "dis-inline-flex-news" : "row no-gutters"); ?>">

												<div class="<?php echo (empty($val['picture']) ? "dis-inline-flex max-width-left-pic" : "col-lg-4 col-md-12 col-sm-12 col-12"); ?>">
													<?php if (!empty($val['picture'])) { ?>
														<img src="<?php echo HOST_NAME; ?>images/article/news<?php echo $val['n_id'] . '/', $val['picture']; ?>" alt="<?php echo $val['picture']; ?>" class="w-100 p-2 border-ra-15px" title="<?php echo $val['picture']; ?>">
													<?php } ?>
												</div>

												<div class="<?php echo (empty($val['picture']) ? "dis-inline-flex" : "col-lg-8 col-md-12 col-sm-12 col-12"); ?>">
													<div class="card-body p-2">
														<div class="detial-news-tab">
															<em class="far fa-calendar"></em> <?php echo ($val['show_date'] == 1 ? convDateThai($val['n_timestamp'])['DateTH'] : null); ?>
														</div>

														<a onclick="newsCount(<?php echo $val['c_id']; ?>,<?php echo $val['n_id']; ?>);" href="<?php echo ($val['news_use'] == 1 ? HOST_NAME . $val['link_html'] : "news_view.php?c_id=" . $val['c_id'] . "&n_id=" . $val['n_id'] . " "); ?>" target="<?php echo $val['target']; ?>" title="<?php echo $val['n_topic']; ?>">
															<div class="h-news-tab text-short">
																<?php echo $val['n_topic']; ?>
															</div>
														</a>

														<a href="<?php echo (file_exists($val['link_html']) ? $val['link_html'] : "#"); ?>" class="txt-department">
															<span class="mr-2" id="list_count<?php echo $val['n_id']; ?>">
																<em class="far fa-eye"></em>
																<?php echo $val['view_count']; ?>
															</span>
															<em class="far fa-folder"></em> <?php echo $n_owner; ?>
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>
						<?php } ?>

						<div class="p-2 txt-right">
							<a href="more_news.php?page=<?php echo $page . "&c_id=" . $val["c_id"]; ?>" class="more-api"> อ่านทั้งหมด </a>
						</div>
					</div>
				<?php } ?>
			</div>

		</div>

	</div>
</div>

<!-- นับจำนวนการเปิดดูข่าวหรือเปิดไฟล์เอกสาร -->
<script>
	function newsCount(c_id, n_id) {
		$.ajax({
			type: 'GET',
			url: 'ajax/news_tab_index.ajax.php',
			data: {
				c_id: c_id,
				n_id: n_id,
				page: 'news_tab_index'
			},
			datatype: "text",
			success: function(data) {
				let object = JSON.parse(data, true);
				$('#list_count' + object.n_id).html(object.view_count);
			},
			error: function() {
				console.log('Error');
			}
		});
	}
</script>