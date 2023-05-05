<?php
include("../EWT_ADMIN/comtop.php");
?>
<!-- START CONTAINER  -->
<div class="container-fluid">
	<?php
	include("menu-top.php");
	$faq_cid = (int)(!isset($_GET['faq_cid']) ? 0 : $_GET['faq_cid']);

	function faq_parent($faq_id)
	{
		global $db, $EWT_DB_NAME;
		$s_parent = $db->query("SELECT * FROM faq_category WHERE faq_cate_id = '{$faq_id}' ");
		if ($db->db_num_rows($s_parent)) {
			$a_parent = $db->db_fetch_array($s_parent);
			//$txt = "<li class=\"breadcrumb-item active\">".$a_parent['c_name']."</li>";					
			$txt = "<li class=\"active\" aria-current=\"page\"> <a href = \"faq_subgroup.php?faq_cid=" . $a_parent["faq_cate_id"] . "\">" . $a_parent['faq_cate_title'] . "</a></li>";
			if ($a_parent['faq_cate_parent'] != "0" and $a_parent['faq_cate_parent'] != "") {
				$txt = faq_parent($a_parent['faq_cate_parent']) . $txt;
			}
		}
		return $txt;
	}

	function faq_category($faq_id)
	{
		global $db, $EWT_DB_NAME;
		$s_category = $db->query("SELECT * FROM faq_category WHERE faq_cate_id = '{$faq_id}' ");
		if ($db->db_num_rows($s_category)) {
			$a_category = $db->db_fetch_array($s_category);
			$a_data = $a_category['faq_cate_title'];
		}
		return $a_data;
	}

	function faqsub_back($faq_id)
	{
		global $db, $EWT_DB_NAME;
		$s_category = $db->query("SELECT * FROM faq_category WHERE faq_cate_id = '{$faq_id}' ");
		$a_category = $db->db_fetch_array($s_category);
		if ($a_category['faq_cate_parent'] == "0") {
			$a_data = "faq_group.php";
		} else {
			$a_data = "faq_subgroup.php?faq_cid=" . $a_category['faq_cate_parent'];
		}
		return $a_data;
	}
	?>

	<div class="row m-b-sm">
		<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
			<!--start card -->
			<div class="card">
				<!--start card-header -->
				<div class="card-header">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
							<h4><?php echo $txt_poll_menu_main; ?></h4>
							<p></p>
						</div>

						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<ol class="breadcrumb">
									<li><a href="poll_list.php"><?php echo $txt_poll_menu_main; ?></a></li>

								</ol>
							</div>

							<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs">
								<button type="button" class="btn btn-info  btn-ml" onClick="boxPopup('<?php echo linkboxPopup(); ?>pop_add_poll.php?poll_id=<?php echo $poll_id; ?>');" title="<?php echo $txt_poll_add;; ?>" target="_self">
									<i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_poll_add; ?>
								</button>

								<button type="button" class="btn btn-info  btn-ml " onclick="boxPopup('<?php echo linkboxPopup(); ?>pop_search_poll.php');" title="<?php echo $txt_poll_search; ?>">
									<i class="fas fa-search"></i>&nbsp;<?php echo $txt_poll_search; ?>
								</button>
								<?php if (!empty($_GET['keyword'])) {	?>
									<a href="poll_list.php" target="_self">
										<button type="button" class="btn btn-info  btn-ml ">
											<i class="fas fa-undo-alt"></i>&nbsp;<?php echo $txt_ewt_back; ?>
										</button>
									</a>
								<?php }  ?>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs">
								<div class="btn-group ">
									<button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
									<ul class="dropdown-menu dropdown-menu-right">
										<li><a onClick="boxPopup('<?php echo linkboxPopup(); ?>pop_add_poll.php?poll_id=<?php echo $poll_id; ?>');"><i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_poll_add;; ?></a></li>
										<li><a onClick="boxPopup('<?php echo linkboxPopup(); ?>pop_search_poll.php');"><i class="fas fa-search"></i>&nbsp;<?php echo $txt_poll_search; ?></a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>

				</div>
				<!--END card-header -->
				<?php
				$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);

				$whall = '';
				if (!empty($_GET['keyword'])) {
					$whall .= "( c_name LIKE '%" . $_GET['keyword'] . "%' )  ";
				}
				if (!empty($_GET['date_start']) && !empty($_GET['date_end'])) {
					$whall .= "AND ( c_start  >= '{$_GET['date_start']}' AND c_stop <= '{$_GET['date_end']}' )";
				}
				if (!empty($whall)) {
					$wh = "WHERE " . $whall;
				}

				$perpage = 10;
				$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
				if ($page <= 0) $page = 1;
				$start = ($page * $perpage) - $perpage;

				$_sql = $db->query("SELECT * FROM poll_cat {$wh} ORDER BY c_id DESC LIMIT {$start} , {$perpage} ");
				$statement = "SELECT count(c_id) AS b FROM poll_cat {$wh} ";
				$a_rows = $db->db_num_rows($_sql);
				$s_count = $db->query($statement);
				$a_count = $db->db_fetch_array($s_count);
				$total_record = $a_count['b'];
				$total_page = (int)ceil($total_record / $perpage);
				?>
				<!--start card-body -->
				<div class="card-body">

					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
							<!--<div class="card ">
							<div class="card-header ewt-bg-success m-b-sm" >
							<div class="card-title text-left">

							</div>
							</div>
							<div class="card-body">-->

							<div class="panel-group" id="accordion">
								<?php
								$i = 0;
								if ($a_rows > 0) {
									while ($a_data = $db->db_fetch_array($_sql)) { ?>
										<div class="panel panel-default ">
											<div class="panel-heading ">
												<h4 class="panel-title">
													<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $i; ?>">
														<img src="<?php echo $IMG_PATH; ?>images/grabme.svg">
														<div class="blockico"><i class="fas fa-poll " style="color:#FFBE7D;"></i></div>
														<?php echo $a_data['c_name']; ?>
													</a>
												</h4>
											</div>

											<div id="collapseOne<?php echo $i; ?>" class="panel-collapse collapse">
												<div class="panel-body">
													<div class="m-b"><b><i class="fas fa-angle-right" style="color:#FFBE7D;"></i>
															<i class="far fa-list-alt"></i>
															&nbsp;</b><?php echo $a_data['c_detail']; ?>
													</div>

													<div class="m-b"><b><i class="fas fa-angle-right" style="color:#FFBE7D;"></i>
															<i class="far fa-calendar-alt"></i>
															&nbsp;</b><?php echo $a_data['c_start']; ?> to <?php echo $a_data['c_stop']; ?>
													</div>

													<? //=show_icon_lang($a_data['c_id'],'poll');
													?>
													<div class="m-b"><b><i class="fas fa-angle-right" style="color:#FFBE7D;"></i>
															<i class="fas fa-user-cog"></i>
															&nbsp;</b><?php echo $a_data['c_creater']; ?>
													</div>
												</div>
												<div class="panel-footer ewt-bg-white text-right">
													<!--<a onClick="boxPopup('<? //=linkboxPopup(); 
																				?>pop_edit_faq_group.php?fa_id=<?php echo $a_data['fa_id']; ?>');" data-toggle="tooltip" data-placement="right" title="<?php echo $text_genbanner_altedit; ?>">
													<i class="far fa-edit" aria-hidden="true"></i>
													</a>
													<a href="" onClick="" data-toggle="tooltip" data-placement="right" title="">
													<i class="far fa-trash-alt" aria-hidden="true"></i>
													</a>-->

													<div class="ewt-icon-wrap ewt-icon-effect-1 ewt-icon-effect-1b">
														<!--<a href="#set-1" class="ewt-icon ewt-icon-del text-dark"></a>
														<a onClick="boxPopup('<?php echo linkboxPopup(); ?>pop_edit_poll.php?c_id=<?php echo $a_data['c_id']; ?>');" class="ewt-icon ewt-icon-edit text-dark"></a>
														<a href="#set-1" class="ewt-icon ewt-icon-view text-dark"></a>
														<a href="#set-1" class=""><i class="fas fa-cogs"></i></a>
														
														<a onClick="JQSet_Lang_Poll('<?php echo $a_data['c_id']; ?>','')" data-toggle="tooltip" data-placement="right" title="<?php echo "สร้างภาษาอื่นๆ"; ?>">
														<button type="button" class="btn btn-info  btn-circle  btn-xs " id="lang<?php echo $a_data['c_id']; ?>" >
														<i class="fa fa-language" aria-hidden="true"></i>
														</button>
														</a>-->

														<a href="poll_ans_view.php?c_id=<?php echo $a_data['c_id']; ?>&no=<?php echo ($i + 1); ?>" data-toggle="tooltip" data-placement="top" title="ดูผลโหวต">
															<button type="button" class="btn btn-info btn-circle btn-sm ">
																<i class="fas fa-search" aria-hidden="true"></i>
															</button>
														</a>

														<a href="poll_builder.php?c_id=<?php echo $a_data['c_id']; ?>" data-toggle="tooltip" data-placement="top" title="แก้ไขคำตอบ">
															<button type="button" class="btn btn-success btn-circle btn-sm ">
																<i class="fa fa-th-list " aria-hidden="true"></i>
															</button>
														</a>

														<a onClick="boxPopup('<?php echo linkboxPopup(); ?>pop_edit_poll.php?c_id=<?php echo $a_data['c_id']; ?>');" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_poll_edit; ?>">
															<button type="button" class="btn btn-warning  btn-circle btn-sm ">
																<i class="far fa-edit" aria-hidden="true"></i>
															</button>
														</a>

														<a onClick="JQDel_Poll('<?php echo $a_data['c_id']; ?>');" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_poll_delete; ?>">
															<button type="button" class="btn btn-danger btn-circle  btn-sm ">
																<i class="far fa-trash-alt" aria-hidden="true"></i>
															</button>
														</a>
														<!--<a onClick="JQSet_Lang_Poll('<?php echo $a_data['c_id']; ?>','')" data-toggle="tooltip" data-placement="right" title="<?php echo $txt_ewt_create_multilang; ?>">
														<button type="button" class="btn btn-default btn-circle btn-sm " id="lang<?php echo $a_data['c_id']; ?>" >
														<i class="fa fa-language" aria-hidden="true"></i>
														</button>
														</a>-->
													</div>
												</div>
											</div>
										</div>
										<?php $i++; ?>
									<?php } ?>
								<?php } else { ?>
									<div class="panel panel-default ">
										<div class="panel-heading text-center">
											<h4 class="panel-title">
												<p class="text-danger"><?php echo $text_general_notfound; ?></p>
											</h4>
										</div>
									</div>
								<?php } ?>

							</div>
							<?php echo pagination_ewt($statement, $perpage, $page, $url = '?'); ?>
						</div>
					</div>

				</div>
				<!--END card-body -->
			</div>
			<!--END card -->
		</div>
	</div>
</div>
<!-- END CONTAINER  -->
<?php
include("../EWT_ADMIN/combottom.php");
?>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui-touch-punch.min.js"></script>

<style>
	.panel-default>.panel-heading {
		/*color: #FFFFFF;*/
		/*background-color: #FFC153 ;*/
		background-color: #FFFFFF;
		border-color: #ddd;
	}

	.faqHeader {
		font-size: 27px;
		margin: 20px;
	}

	.panel-heading [data-toggle="collapse"]:after {
		font-family: 'Font Awesome 5 Free';
		font-weight: 900;
		content: "\f105";
		/* "play" icon */
		float: right;
		color: #FFC153;
		font-size: 24px;
		line-height: 22px;
		/* rotate "play" icon from > (right arrow) to down arrow */
		-webkit-transform: rotate(-90deg);
		-moz-transform: rotate(-90deg);
		-ms-transform: rotate(-90deg);
		-o-transform: rotate(-90deg);
		transform: rotate(-90deg);

	}

	.panel-heading [data-toggle="collapse"].collapsed:after {
		/* rotate "play" icon from > (right arrow) to ^ (up arrow) */
		-webkit-transform: rotate(90deg);
		-moz-transform: rotate(90deg);
		-ms-transform: rotate(90deg);
		-o-transform: rotate(90deg);
		transform: rotate(90deg);
		color: #454444;
	}

	.ewt-icon-wrap {
		margin: 0 auto;
	}

	.ewt-icon {
		display: inline-block;
		font-size: 0px;
		cursor: pointer;
		_margin: 15px 15px;
		width: 30px;
		height: 30px;
		border-radius: 50%;
		text-align: center;
		position: relative;
		z-index: 1;
		color: #fff;
	}

	.ewt-icon:after {
		pointer-events: none;
		position: absolute;
		width: 100%;
		height: 100%;
		border-radius: 50%;
		content: '';
		-webkit-box-sizing: content-box;
		-moz-box-sizing: content-box;
		box-sizing: content-box;
	}

	.ewt-icon:before {
		font-family: 'Font Awesome 5 Free';
		font-weight: 900;
		speak: none;
		font-size: 18px;
		line-height: 30px;
		font-style: normal;
		_font-weight: normal;
		font-variant: normal;
		text-transform: none;
		display: block;
		-webkit-font-smoothing: antialiased;
	}

	.ewt-icon-edit:before {
		content: "\f044";
	}

	.ewt-icon-del:before {
		content: "\f2ed";
	}

	.ewt-icon-view:before {
		content: "\f06e";
	}

	.ewt-icon-print:before {
		content: "\f02f";
	}

	/* Effect 1 */
	.ewt-icon-effect-1 .ewt-icon {
		background: rgba(255, 255, 255, 0.1);
		-webkit-transition: background 0.2s, color 0.2s;
		-moz-transition: background 0.2s, color 0.2s;
		transition: background 0.2s, color 0.2s;
	}

	.ewt-icon-effect-1 .ewt-icon:after {
		top: -7px;
		left: -7px;
		padding: 7px;
		box-shadow: 0 0 0 4px #fff;
		-webkit-transition: -webkit-transform 0.2s, opacity 0.2s;
		-webkit-transform: scale(.8);
		-moz-transition: -moz-transform 0.2s, opacity 0.2s;
		-moz-transform: scale(.8);
		-ms-transform: scale(.8);
		transition: transform 0.2s, opacity 0.2s;
		transform: scale(.8);
		opacity: 0;
	}

	/* Effect 1a */
	.ewt-icon-effect-1a .ewt-icon:hover {
		background: rgba(255, 255, 255, 1);
		color: #41ab6b;
	}

	.ewt-icon-effect-1a .ewt-icon:hover:after {
		-webkit-transform: scale(1);
		-moz-transform: scale(1);
		-ms-transform: scale(1);
		transform: scale(1);
		opacity: 1;
	}

	/* Effect 1b */
	.ewt-icon-effect-1b .ewt-icon:hover {
		background: rgba(255, 255, 255, 1);
		color: #41ab6b;
	}

	.ewt-icon-effect-1b .ewt-icon:after {
		-webkit-transform: scale(1.2);
		-moz-transform: scale(1.2);
		-ms-transform: scale(1.2);
		transform: scale(1.2);
	}

	.ewt-icon-effect-1b .ewt-icon:hover:after {
		-webkit-transform: scale(1);
		-moz-transform: scale(1);
		-ms-transform: scale(1);
		transform: scale(1);
		opacity: 1;
	}

	.drop-placeholder {
		background-color: #f6f3f3 !important;
		height: 3.5em;
		padding-top: 12px;
		padding-bottom: 12px;
		line-height: 1.2em;
		border: 3px dotted #cccccc !important;
	}
</style>

<script>
	/*$(function  () {
	$("#accordion").sortable({
	placeholder: 'drop-placeholder'
	});
	});*/
	function view_poll(c_id, no) {
		var url = "../ewt/otcc_web/popup/pop_poll_ans_result.php";
		var dataString = 'c_id=' + c_id + '&no=' + no;
		$.ajax({
			type: "GET",
			url: url,
			data: dataString, // serializes the form's elements.
			cache: false,
			success: function(html) {
				$('#shw_poll_result').html(html);
				$('#shw_head').html('สถิติการสำรวจความคิดเห็น');
				$('#hide_btn').hide();
			}
		});
	}

	function JQAdd_Lang_Poll(w, g, lang) {
		$.ajax({
			type: 'GET',
			url: 'pop_add_lang_poll.php?langid=' + g + '&lang=' + lang + '&id=' + w,
			beforeSend: function() {
				$('#box_popup').html('');
			},
			success: function(data) {
				$('#box_popup').html(data);
			}

		});

		$('#box_popup').fadeIn();
		//window.location.href='../multilangMgt/article_list.php?langid='+g+'&lang='+lang+'&id='+ w;
	}

	function JQSet_Lang_Poll(w, g) {
		$.ajax({
			type: 'GET',
			url: 'pop_set_lang_poll.php?gid=' + g + '&id=' + w,
			beforeSend: function() {
				$('#box_popup').html('');
			},
			success: function(data) {
				$('#box_popup').html(data);
			}

		});

		$('#box_popup').fadeIn();
	}

	function JQAdd_faq_group(form) {

		var fail = CKSubmitData(form);
		if (fail == false) {
			var action = form.attr('action');
			var method = form.attr('method');
			var formData = false;
			if (window.FormData) {
				formData = new FormData(form[0]);
			}
			$.confirm({
				title: '<?php echo "เพิ่มหมวด FAQ"; ?>',
				content: 'คุณต้องการบันทึกข้อมูลนี้หรือไม่',
				//content: 'url:form.html',
				boxWidth: '30%',
				icon: 'far fa-question-circle',
				theme: 'modern',
				buttons: {
					confirm: {
						text: 'ยืนยันการบันทึก',
						btnClass: 'btn-blue',
						action: function() {
							$.ajax({
								type: method,
								url: action,
								data: formData ? formData : form.serialize(),
								async: true,
								processData: false,
								contentType: false,
								success: function(data) {
									console.log(data);
									$.alert({
										title: '',
										theme: 'modern',
										content: 'บันทึกข้อมูลเรียบร้อย',
										boxWidth: '30%',
									});
									$("#frm_edit_s").load(location.href + " #frm_edit_s");
									//alert("Data Save: " + data);												
									//self.location.href="article_list.php?cid="+data;											
									$('#box_popup').fadeOut();

								}
							});
						}

					},
					cancel: {
						text: 'ยกเลิก',
						action: function() {
							$('#box_popup').fadeOut();
						}
					}
				},
				animation: 'scale',
				type: 'blue'

			});
		}

	}

	function JQDel_Poll(id) {

		$.confirm({
			title: 'ลบข้อมูล',
			content: 'คุณต้องการลบรายการนี้หรือไม่?',
			//content: 'url:form.html',
			boxWidth: '30%',
			icon: 'fas fa-exclamation-circle',
			theme: 'modern',
			buttons: {
				confirm: {
					text: 'ยืนยันลบข้อมูล',
					btnClass: 'btn-warning',
					action: function() {
						$.ajax({
							type: 'POST',
							url: 'func_delete_poll.php',
							data: {
								'id': id,
								'proc': 'DelPoll'
							},
							success: function(data) {
								$.alert({
									title: '',
									theme: 'modern',
									content: 'ลบข้อมูลเรียบร้อย',
									boxWidth: '30%',
									onAction: function() {

										location.reload(true);
										$('#box_popup').fadeOut();
									}
								});

							}
						});
						//FuncDelete(id);											
						//$.alert('ทำการลบข้อมูลเรียบร้อยแล้ว');																
					}

				},
				cancel: {
					text: 'ยกเลิก'

				}
			},
			animation: 'scale',
			type: 'orange'

		});
		// });
	}
</script>