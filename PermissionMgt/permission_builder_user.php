<?php
include("../EWT_ADMIN/comtop.php");
$db->query("USE " . $EWT_DB_USER);
?>

<!-- START CONTAINER  -->
<div class="container-fluid">
	<?php
	include("menu-top.php");

	//$com_fid = (int)(!isset($_GET['com_fid']) ? '' : $_GET['com_fid']);

	$mid = get('mid', '');
	$mtype = get('mtype', '');
	$UID = $_SESSION['EWT_SUID'];

	function random_to($len)
	{
		srand((float)microtime() * 10000000);
		$chars = "ABCDEFGHJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz123456789";
		$ret_str = "";
		$num = strlen($chars);
		for ($i = 0; $i < $len; $i++) {
			$ret_str .= $chars[rand() % $num];
		}
		return $ret_str;
	}

	$myFlag = random_to(20);

	function level_name($L, $id)
	{
		global $db;
		if ($L == "A") {
			//echo "<img src=\"../images/user_a.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query("SELECT emp_type_name FROM emp_type WHERE emp_type_id = '" . $id . "' ");
			$R = $db->db_fetch_row($sql);
			echo $R[0];
		}
		if ($L == "D") {
			//echo "<img src=\"../images/user_group.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query("SELECT name_org FROM org_name WHERE org_id = '" . $id . "' ");
			$R = $db->db_fetch_row($sql);
			echo $R[0];
		}
		if ($L == "L") {
			//echo "<img src=\"../images/user_c.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query("SELECT ul_name FROM user_level WHERE ul_id = '" . $id . "' ");
			$R = $db->db_fetch_row($sql);
			echo $R[0];
		}
		if ($L == "P") {
			//echo "<img src=\"../images/user_pos.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query("SELECT position_name.pos_name FROM position_name INNER JOIN user_position ON position_name.pos_id = user_position.pos_id WHERE user_position.up_id = '" . $id . "' ORDER BY user_position.up_rank ASC ");
			$R = $db->db_fetch_row($sql);
			echo $R[0];
		}
		if ($L == "U") {
			//echo "<img src=\"../images/user_logo.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query("SELECT name_thai,surname_thai,gen_user FROM gen_user WHERE gen_user_id = '" . $id . "' ");
			$R = $db->db_fetch_row($sql);
			echo $R[0] . " " . $R[1] . " (" . $R[2] . ")";
		}
	}

	$perpage = 10;
	$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
	if ($page <= 0) $page = 1;
	$start = ($page * $perpage) - $perpage;

	/*$_sql = $db->query("SELECT *
					FROM m_complain_form_element 
					INNER JOIN m_complain_form_item ON (m_complain_form_item.com_item_id = m_complain_form_element.com_ele_id)
					WHERE com_ele_fid = '{$com_fid}' {$wh} 
					ORDER BY com_ele_order ASC LIMIT {$start} , {$perpage} ");

	$statement = "SELECT count(com_ele_id) AS b
				FROM m_complain_form_element 
				WHERE com_ele_fid = '{$com_fid}' {$wh}  ";
				
		
	$s_count = $db->query($statement);
	$a_count = $db->db_fetch_array($s_count);
	$total_record = $a_count['b'];
	$total_page = (int)ceil($total_record / $perpage);
	$db->query("USE ".$EWT_DB_USER);*/

	$_sql = $db->query("SELECT * FROM permission WHERE pu_id = '{$mid}' AND p_type = '{$mtype}' AND UID = '{$UID}' AND s_id = '0' ORDER BY p_id ASC ");
	$a_rows = $db->db_num_rows($_sql);
	?>

	<div class="row m-b-sm">
		<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
			<!--start card -->
			<div class="card">
				<!--start card-header -->
				<div class="card-header">
					<div class="row">
						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
							<h4><?php echo $txt_permission_set; ?></h4>
							<p></p>
						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<ol class="breadcrumb">
									<li><a href="permission_user.php"><?php echo $txt_permission_menu_user; ?></a></li>
									<li class=""><?php echo $txt_permission_set; ?></li>
								</ol>
							</div>

							<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs">
								<a href="permission_user.php" target="_self">
									<button type="button" class="btn btn-info  btn-ml ">
										<i class="fas fa-undo-alt"></i>&nbsp;<?php echo $txt_ewt_back; ?>
									</button>
								</a>
							</div>

							<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs">
								<div class="btn-group ">
									<button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
									<ul class="dropdown-menu dropdown-menu-right">
										<li><a href="permission_user.php" target="_self"><i class="fas fa-undo-alt"></i>&nbsp;<?php echo $txt_ewt_back; ?></a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--END card-header -->

				<!--start card-body -->
				<div class="card-body">
					<div class="row ">
						<div class="col-md-12 col-sm-12 col-xs-12" id="table-view">
							<div class="row">
								<div class="col-md-7 col-sm-7 col-xs-7 m-b-sm">
									<div class="card ">
										<div class="card-header  ewt-bg-color b-t-l-3 b-t-r-3">
											<div class="card-title text-left color-white">
												<i class="fas fa-user-cog color-white fa-1x" aria-hidden="true"></i>
												<?php echo level_name($mtype, $mid); ?>
											</div>
										</div>

										<div class="card-body m-b-sm">
											<input type="hidden" name="mid" id="mid" value="<?php echo $mid; ?>">
											<input type="hidden" name="UID" id="UID" value="<?php echo $UID; ?>">
											<input type="hidden" name="mtype" id="mtype" value="<?php echo $mtype; ?>">
											<input name="Flag" type="hidden" id="Flag" value="SaveAndExit">
											<input type="hidden" name="myFlag" value="<?php echo $myFlag; ?>">

											<ul id="sortableLv1-form" class="sortableLv1 connectedSortable " style="width: 100%;">
												<li class="productCategoryLevel1 ui-state-disabled text-center " id="0">
													<b>เลือก Module ด้านขวา</b>
												</li>
												<?php
												//$db->query("USE ".$EWT_DB_NAME);
												if ($a_rows > 0) {
													$i = 0;
													$s_data = array();
													while ($a_data = $db->db_fetch_array($_sql)) {
														if ($a_data['s_type'] == 'suser') {
															array_push($s_data, $a_data['s_type']);
														} else {
															array_push($s_data, $a_data['s_type'] . "#" . $a_data['s_permission']);
														}

														$_sql_item = $db->query("SELECT * FROM web_permission
														LEFT JOIN web_module_ewt ON web_module_ewt.m_code = web_permission.p_code
														WHERE web_permission.p_status = 'Y' 
														AND web_module_ewt.m_status = 'Y' 
														AND web_permission.p_code = '{$a_data['s_type']}' 
														AND p_type = '{$a_data['s_permission']}'");
														$a_data_item = $db->db_fetch_array($_sql_item);

														if ($a_data['s_type'] == 'suser') { ?>
															<li class="productCategoryLevel1 move">
																&nbsp;
																<input type="hidden" name="hiddencategory_id[]" id="hiddencategory_id<?php echo $a_data['p_id']; ?>" value="<?php echo $a_data['p_id']; ?>">
																<i class="fas fa-user-cog text-medium text-dark "></i>
																&nbsp;<b>Super Admin</b>
																<!--<div class="iconAction1">
																&nbsp;
																<button type="button" class="btn btn-default btn-circle btn-sm " onClick="boxPopup('<?php echo linkboxPopup(); ?>pop_setting_item.php?com_eid=<?php echo $a_data['com_ele_id']; ?>&com_fid=<?php echo $com_fid; ?>');" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_complain_setting; ?>">
																<i class="fas fa-cogs" aria-hidden="true"></i>
																</button>
																&nbsp;
																</div>-->
															</li>

															<?php } else {
															if ($a_data['s_type'] != 'Ag') {
															?>

																<li class="productCategoryLevel1 ui-state-disabled">
																	&nbsp;
																	<input type="hidden" name="hiddencategory_id[]" id="hiddencategory_id<?php echo $a_data['p_id']; ?>" value="<?php echo $a_data['p_id']; ?>">
																	<div class="blockico"><i class="far fa-check-circle text-success" style=""></i></div>
																	<img src="<?php echo $IMG_PATH; ?><?php echo $a_data_item['m_image']; ?>" class="img-responsive " style="display:inline;margin: 0 1px;width:24px;height:24px;" />
																	&nbsp;<?php echo $a_data_item['m_name']; ?> (<?php echo $a_data_item['p_name']; ?>)

																	<div class="iconAction1">
																		&nbsp;
																		<!--<button type="button" class="btn btn-default btn-circle btn-sm " onClick="boxPopup('<?php echo linkboxPopup(); ?>pop_setting_item.php?com_eid=<?php echo $a_data['com_ele_id']; ?>&com_fid=<?php echo $com_fid; ?>');" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_complain_setting; ?>">
																		<i class="fas fa-cogs" aria-hidden="true"></i>
																		</button>
																		<a onClick="JQDel_Permission('<?php echo $a_data['p_id']; ?>');" data-toggle="tooltip" data-placement="top" title="<?php echo "ลบ"; ?> <?php echo $a_data_item['p_name']; ?>"  >
																		<i class="fas fa-minus-circle text-danger"  aria-hidden="true"></i>
																		</a>-->
																		<?php if (!empty($a_data_item['m_permission_link'])) { ?>
																			<button type="button" class="btn btn-info btn-circle btn-sm " onClick="boxPopup('<?php echo linkboxPopup(); ?>pop_set_admission_user.php?p_id=<?php echo $a_data['p_id']; ?>&s_type=<?php echo $a_data['s_type']; ?>&pu_id=<?php echo $a_data['pu_id']; ?>&p_type=<?php echo $mtype; ?>&s_permission=<?php echo $a_data['s_permission']; ?>');" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_complain_setting; ?>">
																				<i class="fas fa-cogs " aria-hidden="true"></i>
																			</button>
																		<?php } ?>
																		<button type="button" class="btn btn-danger  btn-circle  btn-sm" onClick="JQDel_Permission('<?php echo $a_data['p_id']; ?>','<?php echo $a_data['pu_id']; ?>','<?php echo $a_data['s_type']; ?>');" data-toggle="tooltip" data-placement="top" title="<?php echo $txt_permission_del_admission; ?> (<?php echo $a_data_item['p_name']; ?>) ">
																			<i class="fas fa-trash-alt " aria-hidden="true"></i>
																		</button>
																		&nbsp;
																	</div>
																</li>
															<?php } ?>
														<?php } ?>
														<?php $i++; ?>
													<?php } ?>
												<?php } else { ?>
													<li class="productCategoryLevel1 ui-state-disabled text-center ">
														<p class="text-danger"><?php echo $txt_ewt_data_not_found; ?></p>
													</li>
												<?php } ?>

											</ul>
										</div>

										<div class="card-body m-t-xxl text-center">
											<!--<button onclick="boxPopup('<?php echo linkboxPopup(); ?>pop_view_form.php?com_fid=<?php echo $com_fid; ?>');" type="button" class="btn btn-info  btn-ml " >
											<i class="fas fa-search"></i>&nbsp;<?php echo $txt_ewt_viewform; ?>
											</button>-->
											<button onclick="JQAdd_Permission_User($('#form_main'));" type="button" class="btn btn-success  btn-ml ">
												<i class="fas fa-save"></i>&nbsp;<?php echo $txt_ewt_save; ?>
											</button>
										</div>
									</div>
								</div>
								<div class="col-md-5 col-sm-5 col-xs-5 m-b-sm">
									<div class="card ">
										<div class="card-header ewt-bg-color b-t-l-3 b-t-r-3">
											<div class="card-title text-left  color-white">
												<i class="fas fa-cogs color-white fa-1x"></i>
												Module
											</div>
										</div>
										<div class="card-body">

											<ul id="sortableLv1" class="sortableLv1 connectedSortable " style="width: 100%;">
												<li class="productCategoryLevel1  ui-state-disabled text-center " id="00">
													<b>Module</b>
												</li>
												<?php
												//print_r($s_data);
												$data = implode("','", $s_data);
												if ($data != 'suser') {
												?>
													<li class="productCategoryLevel1 bg-success text-left move" id="suser">
														&nbsp;
														<input type="hidden" name="hiddencategory_id[]" id="hiddencategory_id<?php echo $a_data_item['p_id']; ?>" value="<?php echo $a_data_item['p_id']; ?>">
														<img src="<?php echo $IMG_PATH; ?>images/grabme.svg">
														&nbsp;<b>Super Admin</b>
													</li>
												<?php
												}

												$_sql_item = $db->query("SELECT * FROM web_permission
												LEFT JOIN web_module_ewt ON web_module_ewt.m_code = web_permission.p_code
												WHERE web_permission.p_status = 'Y' AND web_module_ewt.m_status = 'Y'
												ORDER BY web_permission.p_id ASC ");
												$x = 0;
												while ($a_data_item = $db->db_fetch_array($_sql_item)) {
													$_sql = $db->query("SELECT *
													FROM permission 
													WHERE 
													pu_id = '{$mid}' 
													AND p_type = '{$mtype}'  
													AND UID = '{$UID}'
													AND s_type = '{$a_data_item['p_code']}'
													AND s_permission = '{$a_data_item['p_type']}'
													");
													$a_rows = $db->db_num_rows($_sql);
													$a_data_permission = $db->db_fetch_array($_sql);
													if (empty($a_rows)) {
													?>
														<li class="productCategoryLevel1 move" id="<?php echo $a_data_item['p_code'] . '#' . $a_data_item['p_type']; ?>">
															&nbsp;
															<input type="hidden" name="hiddencategory_id[]" id="hiddencategory_id<?php echo $a_data_item['p_id']; ?>" value="<?php echo $a_data_item['p_id']; ?>">
															<img src="<?php echo $IMG_PATH; ?>images/grabme.svg">
															<img src="<?php echo $IMG_PATH; ?><?php echo $a_data_item['m_image']; ?>" class="img-responsive " style="display:inline;margin: 0 1px;width:24px;height:24px;" />
															&nbsp;<?php echo $a_data_item['m_name']; ?> (<?php echo $a_data_item['p_name']; ?>)
														</li>
													<?php } ?>
													<?php $x++; ?>
												<?php } ?>
											</ul>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!--END card-body-->
			</div>
			<!--END card-->
		</div>
	</div>

</div>
<!-- END CONTAINER  -->
<?php
$db->query("USE " . $EWT_DB_NAME);
include("../EWT_ADMIN/combottom.php");
?>
<script src="../js/mask-input-jquery/docs/jquery.samask-masker.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui-touch-punch.min.js"></script>
<!-- <style>
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

	.drop-placeholder11 {
		background-color: #f6f3f3 !important;
		height: 3.5em;
		padding-top: 12px;
		padding-bottom: 12px;
		line-height: 1.2em;
		border: 3px dotted #cccccc !important;
	}

	.drop-placeholder {
		background-color: rgba(240, 243, 244, 1.0);
		height: 4.0em;
		border: 4px dotted #cccccc !important;
		border-radius: 3px;
		margin-top: 5px !important;
		box-shadow: 0px 4px 30px rgba(22, 33, 74, 0.07);
		-webkit-box-shadow: 0px 4px 30px rgba(22, 33, 74, 0.07);
		-moz-box-shadow: 0px 4px 30px rgba(22, 33, 74, 0.07);
	}
</style> -->

<script>
	$(function() {
		$(".sortableLv1").sortable({
			placeholder: 'drop-placeholder',
			connectWith: ".sortableLv1",
			items: "li:not(.ui-state-disabled)",
			update: function(event, ui) {

				var changedList = this.id;
				var order = $(this).sortable('toArray');
				var positions = order.join(',');

				var mid = $('#mid').val();
				var UID = $('#UID').val();
				var mtype = $('#mtype').val();

				//console.log(changedList);	

				if (changedList == 'sortableLv1-form') {
					console.log({
						id: changedList,
						positions: positions
					});

					$.ajax({
						type: 'POST',
						url: 'func_sortable_user_builder.php',
						data: {
							proc: 'Sortable_Edit',
							page_id_array_form: order,
							mid: mid,
							UID: UID,
							mtype: mtype
						},
						success: function(data) {
							console.log(data);
							location.reload(true);
							//$("#frm_edit_s").load(location.href + " #frm_load");												
							//alert("Data Save: " + data);												
							//self.location.href="article_list.php?cid="+data;											
							//$('#box_popup').fadeOut();
							//document.location.reload();
						}
					});

				}
			}
		});

		$.samaskHtml();
		$('.phone').samask("(000)000-0000");
		$('.hour').samask("00:00:00");
		$('.date').samask("00/00/0000");
		$('.date_hour').samask("00/00/0000 00:00:00");
		$('.ip_address').samask("000.000.000.000");
		$('.percent').samask("%00");
		$('.mixed').samask("SSS-000");
		$('.number').samask("000");

	});

	function JQAdd_Permission_User(form) {
		var fail = CKSubmitData(form);
		if (fail == false) {
			var action = form.attr('action');
			var method = form.attr('method');
			var formData = false;
			if (window.FormData) {
				formData = new FormData(form[0]);
			}
			$.confirm({
				title: '<?php echo "กำหนดสิทธิ์การใช้งานระบบ"; ?>',
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
									//console.log(data);
									$.alert({
										title: '',
										theme: 'modern',
										content: 'บันทึกข้อมูลเรียบร้อย',
										boxWidth: '30%',
										onAction: function() {
											self.location.href = "permission_user.php";
											//location.reload(true);			
											$('#box_popup').fadeOut();
										}
									});
									//$("#frm_edit_s").load(location.href + " #frm_edit_s");
									//alert("Data Save: " + data);												
									//self.location.href="complain_builder.php?com_cid="+data;											
									//$('#box_popup').fadeOut();

								}
							});
						}

					},
					cancel: {
						text: 'ยกเลิก',
						action: function() {
							//$('#box_popup').fadeOut(); 	
						}
					}
				},
				animation: 'scale',
				type: 'blue'

			});
		}
	}

	function JQDel_Permission(id, pu_id, s_type) {
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
							type: 'GET',
							url: 'func_delete_permission.php',
							data: {
								'id': id,
								'pu_id': pu_id,
								's_type': s_type,
								'proc': 'DelPer'
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