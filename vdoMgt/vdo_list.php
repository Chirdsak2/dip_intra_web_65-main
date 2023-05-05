<?php
include("../EWT_ADMIN/comtop.php");

$vdo_cid = (int)(!isset($_GET['vdo_cid']) ? 0 : $_GET['vdo_cid']);
$data = (int)(!isset($_GET['data']) ? 0 : $_GET['data']);
?>
<!-- START CONTAINER  -->
<div class="container-fluid">
	<?php
	include("menu-top.php");


	if (!empty($data)) {
		$wh = " AND vdo_name LIKE '%$data%' ";
	}

	$perpage = 12;
	$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
	if ($page <= 0) $page = 1;
	$start = ($page * $perpage) - $perpage;

	$_sql = $db->query("SELECT * FROM vdo_list 
					INNER JOIN vdo_group ON vdo_group.vdog_id = vdo_list.vdo_group 
					WHERE vdo_group = '{$vdo_cid}' {$wh} ORDER BY vdo_id ASC LIMIT {$start} , {$perpage} ");

	$statement = "SELECT count(vdo_list.vdo_id) AS b FROM vdo_list INNER JOIN vdo_group ON vdo_group.vdog_id = vdo_list.vdo_group 
	WHERE vdo_group = '{$vdo_cid}' {$wh} ";

	$a_rows = $db->db_num_rows($_sql);
	$s_count = $db->query($statement);
	$a_count = $db->db_fetch_array($s_count);
	$total_record = $a_count['b'];
	$total_page = (int)ceil($total_record / $perpage);
	?>

	<!-- <style type="text/css">
		.border_dashed {
			margin-top: 10px;
			margin-right: 0px;
			margin-bottom: 5px;
			margin-left: 0px;
			padding: 0px 10px 10px 10px;
			_border-top: 2px dashed #cbcccc;
			border-top: 3px dashed #cbcccc;
			border-bottom: 3px dashed #cbcccc;
			border-right: 3px dashed #cbcccc;
			border-left: 3px dashed #cbcccc;
			text-align: center;
		}

		.border_dashed:hover {
			border-top: 3px dashed #cbcccc;
			border-bottom: 3px dashed #cbcccc;
			border-right: 3px dashed #cbcccc;
			border-left: 3px dashed #cbcccc;
			background-color: #f9f9f9;

		}

		.jFiler-input-icon {
			font-size: 48px;
			margin-top: -10px;
			-webkit-transition: all 0.3s ease;
			-moz-transition: all 0.3s ease;
			transition: all 0.3s ease;
		}

		.fileuploader {
			display: block;
			width: 100%;
			padding: 16px;
			margin: 16px 0;
			background: #fafbfd;
			border-radius: 6px;
			line-height: normal;
		}

		.fileuploader-theme-gallery .fileuploader-input-inner {
			display: flex;
			flex-direction: column;
			justify-content: center;
			height: 100%;
			min-height: 180px;
			border: 2px dashed #d5d9e0;
			padding: 0px 10px 10px 10px;
			font-weight: 700;
			cursor: pointer;
			border-radius: 6px;
			user-select: none;
			-webkit-transition: all 0.2s ease;
			transition: all 0.2s ease;
		}

		.fileuploader-theme-gallery .fileuploader-input-inner:hover {
			border: 2px dashed #b8beca;
			background: #FFFFFF;
		}
	</style> -->

	<?php
	function vdo_category($vdo_cid)
	{
		global $db, $EWT_DB_NAME;
		$s_category = $db->query("SELECT * FROM vdo_group WHERE vdog_id = '{$vdo_cid}' ");
		if ($db->db_num_rows($s_category)) {
			$a_category = $db->db_fetch_array($s_category);
			$a_data = $a_category['vdog_name'];
		}
		return $a_data;
	}
	function vdo_back($vdo_cid)
	{
		global $db, $EWT_DB_NAME;
		$s_category = $db->query("SELECT * FROM vdo_group WHERE vdog_id = '{$vdo_cid}' ");
		$a_category = $db->db_fetch_array($s_category);
		if ($a_category['vdog_parent'] == "0" or $a_category['vdog_parent'] == "") {
			$a_data = "vdo_group.php";
		} else {
			$a_data = "vdo_group.php?vdo_cid=" . $a_category['vdog_parent'];
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

							<h4><?= $txt_vdo_cate; ?> : <?= vdo_category($vdo_cid); ?></h4>
							<p></p>

						</div>

						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<ol class="breadcrumb">
									<li><a href="vdo_group.php"><?= $txt_vdo_cate; ?></a></li>
									<li class=""><?= vdo_category($vdo_cid); ?></li>
								</ol>
							</div>

							<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs">
								<!--<a onClick="boxPopup('<?= linkboxPopup(); ?>pop_add_vdo_group.php');" data-toggle="tooltip" data-placement="buttom" title="<?= $txt_vdo_add_cate; ?>"  target="_self">
								<button type="button" class="btn btn-info  btn-ml">
								<i class="fas fa-plus-circle"></i>&nbsp;<?= $txt_vdo_add_cate; ?>
								</button>
								</a>-->
								<a onClick="boxPopup('<?= linkboxPopup(); ?>pop_add_vdo.php?vdo_cid=<?= $vdo_cid; ?>');" target="_self">
									<button type="button" class="btn btn-info  btn-ml">
										<i class="fas fa-plus-circle"></i>&nbsp;<?= $txt_vdo_add_vdo; ?>
									</button>
								</a>
								<!--<a  target="_self" onclick="boxPopup('<?= linkboxPopup(); ?>pop_search_vdo.php');" >
								<button type="button" class="btn btn-info  btn-ml " >
								<i class="fas fa-search"></i>&nbsp;<?= $txt_vdo_search_vdo; ?>
								</button>
								</a>-->
								<a href="<?= vdo_back($vdo_cid); ?>" onClick="" target="_self">
									<button type="button" class="btn btn-info  btn-ml ">
										<i class="fas fa-undo-alt"></i>&nbsp;<?= $txt_ewt_back; ?>
									</button>
								</a>
							</div>

							<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs">
								<div class="btn-group ">
									<button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
									<ul class="dropdown-menu dropdown-menu-right">
										<!--<li><a onClick="boxPopup('<?= linkboxPopup(); ?>pop_add_vdo_group.php');" ><i class="fas fa-plus-circle"></i>&nbsp;<?= $txt_vdo_add_cate; ?></a></li>-->
										<li><a onClick="boxPopup('<?= linkboxPopup(); ?>pop_add_vdo.php?vdo_cid=<?= $vdo_cid; ?>');"><i class="fas fa-plus-circle"></i>&nbsp;<?= $txt_vdo_add_vdo; ?></a></li>
										<li><a href="<?= vdo_back($vdo_cid); ?>" onClick=""><i class="fas fa-plus-circle"></i>&nbsp;<?= $txt_ewt_back; ?></a></li>

									</ul>
								</div>
							</div>
						</div>
					</div>

				</div>
				<!--END card-header -->

				<!--start card-body -->
				<div class="card-body">

					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm fileuploader">

							<div id="frm_edit_s">
								<div id="frm_load">

									<?php

									$i = 1;
									if ($a_rows) {
										while ($a_video = $db->db_fetch_array($_sql)) {
									?>
											<div class="col-md-3 col-sm-12 col-xs-12 fileuploader-theme-gallery" style="padding:5px;">
												<div class="fileuploader-input-inner">
													<div style="margin-top: 5px;text-align:right;">
														<!--
															<a onClick="txt_data('<?= $a_video['vdo_id']; ?>','')">
															<button type="button" class="btn btn-info  btn-circle  btn-xs " id="lang<?= $a_video['vdo_id']; ?>" data-toggle="tooltip" data-placement="top" title="<?= $txt_ewt_create_multilang; ?>">
																<i class="fa fa-language" aria-hidden="true"></i>
															</button>
														</a>
														-->
														<a onclick="boxPopup('<?= linkboxPopup(); ?>pop_view_vdo.php?vdo_id=<?= $a_video['vdo_id']; ?>&vdo_cid=<?= $a_video['vdo_group']; ?>');" data-toggle="tooltip" data-placement="right" title="ดูวีดีโอ">
															<button type="button" class="btn btn-default btn-circle  btn-xs ">
																<i class="fas fa-search" aria-hidden="true"></i>
															</button>
														</a>
														<a onclick="JQDelete_Vdo(<?= $a_video['vdo_id']; ?>);" data-toggle="tooltip" data-placement="right" title="ลบข้อมูล">
															<button type="button" class="btn btn-default btn-circle  btn-xs">
																<i class="fas fa-trash-alt " aria-hidden="true"></i>
															</button>
														</a>
														<a onClick="boxPopup('<?= linkboxPopup(); ?>pop_edit_vdo.php?vdo_id=<?= $a_video['vdo_id']; ?>&vdo_cid=<?= $vdo_cid; ?>');" data-toggle="tooltip" data-placement="right" title="แก้ไขข้อมูล">
															<button type="button" class="btn btn-default btn-circle  btn-xs">
																<i class="fa fa-edit  " aria-hidden="true"></i>
															</button>
														</a>
													</div>
													<div class="panel-body" style="margin:5px;padding-top:20px; word-wrap: break-word;text-align:left;">
														<div style="border: 0.5px solid #cbcccc;;padding: 5px;border-radius: 5px;">
															<?php
															$vdo_fileyoutube = str_replace('https://www.youtube.com/watch?v=', '', $a_video['vdo_fileyoutube']);
															$vdo_image = "../images/pic_preview.gif";
															if ($a_video['vdo_filename'] != "") {
																if (!empty($a_video['vdo_image'])) {
																	echo "<img  src=\"../ewt/" . $_SESSION['EWT_SUSER'] . "/download/file_vdo/" . $a_video['vdo_image'] . "\"  alt=\"" . $a_video['vdo_filename'] . "\"  width=\"100%\" height=\"140\" title=\"" . $a_video['vdo_filename'] . "\" class=\"img-responsive\"/>";
																} else {
																	echo "<img src=\"" . $vdo_image . "\" alt=\"" . $a_video['vdo_filename'] . "\"  width=\"100%\" height=\"140\" title=\"" . $a_video['vdo_filename'] . "\" class=\"img-responsive\"/>";
																}
															} else {
																echo "<img src=\"https://i.ytimg.com/vi/" . $vdo_fileyoutube . "/sddefault.jpg\" alt=\"" . $a_video['vdo_fileyoutube'] . "\"  title=\"" . $a_video['vdo_fileyoutube'] . "\" class=\"img-responsive\" />";
															}
															?>
														</div>

													</div>
													<?= $a_video['vdo_name']; ?>

													<!-- <div class="text-left">
														<span class="label label-primary "><?= $txt_ewt_multilang; ?></span>
														<?php if (show_icon_lang($a_video['vdo_id'], 'vdo_list')) { ?>
															<button  type="button" class="btn btn-default   btn-sm " data-toggle="tooltip" data-placement="top" title="" >
															<?= show_icon_lang($a_video['vdo_id'], 'vdo_list'); ?>
															</button>
														<?php } ?>
													</div> -->
												</div>
											</div>
									<?php

											if ($i % 4 == '0') {
												echo "<div class=\"clearfix\"></div>" . PHP_EOL;
											}

											$i++;
										}
									} else {

										echo "<div class=\"col-md-12 col-sm-12 col-xs-12\" style=\"padding: 15px;text-align:center;\">ไม่มีข้อมููล</div>";
									}
									?>
								</div>
							</div>
						</div>
						<?php echo pagination_ewt($statement, $perpage, $page, '?vdo_cid=' . $_GET['vdo_cid'] . '&'); ?>
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
<script>
	function txt_data(w, g) {
		$.ajax({
			type: 'GET',
			url: 'pop_set_lang_vdo_list.php?gid=' + g + '&id=' + w,
			beforeSend: function() {
				$('#box_popup').html('');
			},
			success: function(data) {
				$('#box_popup').html(data);
			}

		});

		$('#box_popup').fadeIn();
	}

	function txt_data1(w, g, lang) {
		$.ajax({
			type: 'GET',
			url: 'pop_vdo_list_multilang.php?langid=' + g + '&lang=' + lang + '&id=' + w,
			beforeSend: function() {
				$('#box_popup').html('');
			},
			success: function(data) {
				$('#box_popup').html(data);
			}

		});
		$('#box_popup').fadeIn();
	}

	function JQDelete_Vdo(id) {
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
							url: 'func_delete_vdo.php',
							data: {
								'id': id,
								'proc': 'DelVdo'
							},
							success: function(data) {
								$.alert({
									title: '',
									theme: 'modern',
									content: 'ลบข้อมูลเรียบร้อย',
									boxWidth: '30%',
									onAction: function() {
										//self.location.href="vdo_group.php";	
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