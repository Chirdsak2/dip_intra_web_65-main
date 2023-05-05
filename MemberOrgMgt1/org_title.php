<?php
include("../EWT_ADMIN/comtop.php");
$sso = new sso();
?>

<!-- START CONTAINER  -->
<div class="container-fluid">
	<?php
	include("menu-top.php");
	$perpage = 10;
	$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
	if ($page <= 0) $page = 1;
	$start = ($page * $perpage) - $perpage;

	$sql = "SELECT * FROM USR_PREFIX WHERE PREFIX_STATUS = 'Y' 
	ORDER BY CASE WHEN PREFIX_ORDER != 0 THEN PREFIX_ORDER END ASC,
	CASE WHEN PREFIX_ORDER = 0 THEN PREFIX_ID END ASC";
	$s_sql = $sql . " OFFSET {$start} ROWS FETCH NEXT {$perpage} ROWS ONLY";
	$query_all = $sso->getFetchAll($s_sql);

	$statement = "SELECT count(PREFIX_ID) AS b FROM USR_PREFIX";
	$a_rows  = $sso->getRowCount($s_sql);
	$a_count = $sso->getFetch($statement);
	$total_record = $a_count['b'];
	$total_page = (int)ceil($total_record / $perpage);
	?>
	<div class="row m-b-sm">
		<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
			<!--start card -->
			<div class="card">
				<!--start card-header -->
				<div class="card-header">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
							<h4><?php echo $txt_org_menu_nametitle; ?></h4>
							<p></p>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<ol class="breadcrumb">
									<li><a href="org_dashboard.php"><?php echo $txt_org_menu_main; ?></a></li>
									<li class=""><?php echo $txt_org_menu_nametitle; ?></li>
								</ol>
							</div>

							<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs">
								<a onClick="boxPopup('<?php echo linkboxPopup(); ?>pop_add_org_title.php');">
									<button type="button" class="btn btn-info  btn-ml" title="<?php echo $txt_org_title_add; ?>">
										<i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_org_title_add; ?>
									</button>
								</a>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs">
								<div class="btn-group ">
									<button type="button" data-toggle="dropdown" class="btn btn-info   btn-sm dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
									<ul class="dropdown-menu dropdown-menu-right">
										<li><a onClick="boxPopup('<?php echo linkboxPopup(); ?>pop_add_org_title.php);"><i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_org_title_add; ?></a></li>

									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--END card-header -->

				<div class="card-body">
					<div class="row ">
						<div class="col-md-12 col-sm-12 col-xs-12" id="table-view">
							<div class="panel-group" id="accordion">
								<?php
								if ($a_rows > 0) {
									$i = 0;
									foreach ($query_all as $a_data) { ?>
										<div class="panel panel-default " id="<?php echo $a_data['PREFIX_ID']; ?>">
											<div class="panel-heading ewt-bg-success">
												<h4 class="panel-title">
													<i class="fas fa-arrows-alt text-info move" aria-hidden="true" data-toggle="tooltip" data-placement="top" title="<?php echo 'Move'; ?>"></i>
													<input class="input-inline-sm text-center" name="title_order[]" id="title_order<?php echo $a_data['PREFIX_ORDER']; ?>" type="text" value="<?php echo $a_data['PREFIX_ORDER']; ?>" readonly />

													<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $i; ?>">
														<i class="fas fa-list-alt"></i>
														<?php echo $a_data['PREFIX_TH']; ?>
													</a>
													<span class="pull-right">
													<a onClick="boxPopup('<?php echo linkboxPopup(); ?>pop_edit_org_title.php?PREFIX_ID=<?php echo $a_data['PREFIX_ID']; ?>');">
															<button type="button" class="btn btn-warning btn-circle btn-xs" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_org_title_edit; ?>">
																<i class="fa fa-edit" aria-hidden="true"></i>
															</button>
														</a>
														<a onClick="JQDel_Org_Title('<?php echo $a_data['PREFIX_ID']; ?>');">
															<button type="button" class="btn btn-danger btn-circle btn-sm" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_org_title_delete; ?>">
																<i class="far fa-trash-alt" aria-hidden="true"></i>
															</button>
														</a>&nbsp;&nbsp;
									</span>
												</h4>
											</div>

											<div id="collapseOne<?php echo $i; ?>" class="panel-collapse collapse">
												<div class="panel-body">
													<div><b><?php echo $txt_org_title_name; ?> :</b> <?php echo $a_data['PREFIX_TH']; ?></div><br>
													<div><?php echo org::chkStatusOrg($a_data['PREFIX_STATUS']); ?></div><br>
												</div>
												<div class="panel-footer ewt-bg-white text-right">
													<div class="ewt-icon-wrap ewt-icon-effect-1 ewt-icon-effect-1b">
														
													</div>
												</div>
											</div>
										</div>
									<?php $i++; } ?>
									<?php } else { ?>
									<div class="panel panel-default ">
										<div class="panel-heading text-center">
											<h4 class="panel-title">
												<p class="text-danger"><?php echo $txt_ewt_data_not_found; ?></p>
											</h4>
										</div>
									</div>
								<?php } ?>
							</div>
						</div>
						<?php echo pagination_sso($statement, $perpage, $page, $url = '?'); ?>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<!-- END CONTAINER  -->
<?php
$db->query("USE " . $EWT_DB_NAME);
include("../EWT_ADMIN/combottom.php");
?>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui-touch-punch.min.js"></script>
<style>
	.pull-right {float:right;}
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
</style>

<script>
	$(function() {
		$("#accordion").sortable({
			placeholder: 'drop-placeholder',
			update: function(event, ui) {
				var page_id_array = new Array();
				$('#accordion div.panel').each(function() {
					page_id_array.push($(this).attr("id"));
				});

				$.ajax({
					type: 'POST',
					url: 'func_sortable_org_title.php',
					data: {
						proc: 'Sortable_Edit',
						page_id_array: page_id_array,
						start: '<?php echo $start; ?>'
					},
					success: function(data) {
						var Newdata = JSON.stringify(eval("(" + data + ")"));
						var Obj = jQuery.parseJSON(Newdata);

						location.reload(true);
						//$("#frm_edit_s").load(location.href + " #frm_load");												
						//alert("Data Save: " + data);												
						//self.location.href="article_list.php?cid="+data;											
						//$('#box_popup').fadeOut();
						//document.location.reload();
					}
				});

			}
		});
	});

	function txt_data(w, g) {
		$.ajax({
			type: 'GET',
			url: 'pop_set_lang_org_title.php?gid=' + g + '&id=' + w,
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
			url: 'pop_org_title_multilang.php?langid=' + g + '&lang=' + lang + '&id=' + w,
			beforeSend: function() {
				$('#box_popup').html('');
			},
			success: function(data) {
				$('#box_popup').html(data);
			}
		});
		$('#box_popup').fadeIn();
	}

	function JQDel_Org_Title(id) {
		$.confirm({
			title: '<?php echo $txt_ewt_confirm_del_title; ?>',
			content: '<?php echo $txt_ewt_confirm_del_alert; ?>',
			//content: 'url:form.html',
			boxWidth: '30%',
			icon: 'fas fa-exclamation-circle',
			theme: 'modern',
			buttons: {
				confirm: {
					text: '<?php echo $txt_ewt_confirm_del; ?>',
					btnClass: 'btn-warning',
					action: function() {
						$.ajax({
							type: 'GET',
							url: 'func_delete_org_title.php',
							data: {
								'id': id,
								'proc': 'DelOrgTitle'
							},
							success: function(data) {
								$.alert({
									title: '<?php echo $txt_ewt_action_del_alert; ?>',
									theme: 'modern',
									content: '',
									boxWidth: '30%',
									buttons: {
										cancel: {
											text: '<?php echo $txt_ewt_submit; ?>',
											btnClass: 'btn-blue',
											action: function() {
												location.reload();
											}
										}
									}

								});

							}
						});
						//FuncDelete(id);											
						//$.alert('ทำการลบข้อมูลเรียบร้อยแล้ว');																
					}

				},
				cancel: {
					text: '<?php echo $txt_ewt_cancel; ?>'

				}
			},
			animation: 'scale',
			type: 'orange'

		});
		// });
	}
</script>