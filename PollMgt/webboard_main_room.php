<?php
include("../EWT_ADMIN/comtop.php");

$chk_config = $db->query("SELECT * FROM w_config WHERE c_config = '1'");
$w_con = mysqli_fetch_array($chk_config);

//============
//  Removing
//============

if ($_POST["proc"] == "delete_question") {

	echo "<br><br><br><br><br><br>";
	//print_r($_POST);
	//exit();

	if ($_POST[t_id]) {
		$sql_del = "DELETE FROM w_question WHERE t_id='$_POST[t_id]'";
		$db->query($sql_del);

		$db->write_log("delete", "webboard question", "ลบกระทู้ ");
	}

	if ($_POST[c_id]) {
?>
		<script>
			location.href = "webboard_main_room.php?c_id=<?php echo $_POST[c_id]; ?>";
		</script>

	<?php
	} else {
	?>
		<script>
			location.href = "webboard_main_room.php";
		</script>

	<?php
	}
	exit();
} else if ($_POST["proc"] == "delete_room") {

	if ($_POST[c_parent]) {
		$sql_del = "DELETE FROM w_cate WHERE c_id='$_POST[c_id]'";
		$db->query($sql_del);
		$db->write_log("delete", "webboard room", "ลบห้องสนทนา");

	?>
		<script>
			location.href = "webboard_main_room.php?c_id=<?php echo $_POST[c_parent]; ?>";
		</script>

	<?php
	} else {
		$sql_del = "DELETE FROM w_cate WHERE c_id='$_POST[c_id]'";
		$db->query($sql_del);
		$db->write_log("delete", "webboard room", "ลบห้องสนทนา");
	?>
		<script>
			location.href = "webboard_room.php";
		</script>

	<?php
	}
	exit();
} else if ($_POST[proc] == "approve_question") {

	if ($_POST[c_id]) {

		if ($_POST[t_id]) {
			$sql_approve = "UPDATE w_question SET s_id='1' WHERE t_id='$_POST[t_id]'";
			$db->query($sql_approve);
			$db->write_log("approve", "webboard question", "อนุมัติกระทู้ ");
		}

	?>
		<script>
			location.href = "webboard_main_room.php?c_id=<?php echo $_POST[c_id]; ?>";
		</script>

	<?php
	}
	exit();
} else if ($_POST[proc] == "disapprove_question") {

	if ($_POST[c_id]) {

		if ($_POST[t_id]) {
			$sql_approve = "UPDATE w_question SET s_id='0' WHERE t_id='$_POST[t_id]'";
			$db->query($sql_approve);
			$db->write_log("disapprove", "webboard question", "ยกเลิกการอนุมัติกระทู้ ");
		}

	?>
		<script>
			location.href = "webboard_main_room.php?c_id=<?php echo $_POST[c_id]; ?>";
		</script>

	<?php
	}
	exit();
} else if ($_POST[proc] == "approve_room") {

	if ($_POST[c_parentid]) {

		if ($_POST[c_id]) {
			$sql_approve = "UPDATE w_cate SET c_use='Y' WHERE c_id='$_POST[c_id]'";
			$db->query($sql_approve);
			$db->write_log("approve", "webboard room", "อนุมัติห้องสนทนา");
		}

	?>
		<script>
			location.href = "webboard_main_room.php?c_id=<?php echo $_POST[c_parentid]; ?>";
		</script>

	<?php
	}
	exit();
} else if ($_POST[proc] == "disapprove_room") {

	if ($_POST[c_parentid]) {

		if ($_POST[c_id]) {
			$sql_approve = "UPDATE w_cate SET c_use='' WHERE c_id='$_POST[c_id]'";
			$db->query($sql_approve);
			$db->write_log("disapprove", "webboard room", "ยกเลิกการอนุมัติห้องสนทนา");
		}

	?>
		<script>
			location.href = "webboard_main_room.php?c_id=<?php echo $_POST[c_parentid]; ?>";
		</script>

<?php
	}
	exit();
}


?>

<!-- START CONTAINER  -->
<div class="container-fluid">
	<?php
	include("menu-top.php");

	$ban_cid = (int)(!isset($_GET['ban_cid']) ? 0 : $_GET['ban_cid']);

	include("lib/webboard_function.php");

	if ($_GET['c_id']) {
		if (check_type_number($_GET['c_id']) == true) {
			$room_cid = $_GET['c_id'];
		}
	} else {
		$room_cid = '';
	}

	if ($w_con["c_number"]) {
		$perpage = $w_con["c_number"];
	} else {
		$perpage = 10;
	}

	$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);

	if ($page <= 0) $page = 1;

	$start = ($page * $perpage) - $perpage;

	$room_sql = $db->query("SELECT *
					    FROM w_cate
					    WHERE c_id='$room_cid'");

	$room_info = $db->db_fetch_array($room_sql);


	$_sql = $db->query("SELECT *
					FROM w_question
					{$wh} 
					WHERE c_id='$room_cid'
					ORDER BY w_question.t_id DESC LIMIT {$start} , {$perpage} ");

	$statement = "SELECT count(t_id) AS b
			  FROM w_question
			  {$wh}  
			  WHERE c_id='$room_cid'";

	$a_rows = $db->db_num_rows($_sql);
	$s_count = $db->query($statement);
	$a_count = $db->db_fetch_array($s_count);
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

							<h4><?php echo $room_info["c_name"]; ?></h4>
							<p></p>

						</div>
						<div class="col-md-12 col-sm-12 col-xs-12 m-b-sm">
							<div class="col-md-12 col-sm-12 col-xs-12">
								<ol class="breadcrumb">
									<li><a href="webboard_main.php"><?php echo 'หมวดกระทู้'; ?></a></li>
									<?php
									if ($room_cid != "") {
										$room_array = group_bread($room_cid);
										for ($r = 0; $r < sizeof($room_array); $r++) {
									?>
											<li><a href="webboard_room.php?c_id=<?php echo $room_array[$r]; ?>"><?php echo room_name($room_array[$r]); ?></a></li>
										<?php
										}
										?>
									<?php } ?>
									<li class=""><?php echo $room_info["c_name"]; ?></li>
								</ol>
							</div>

							<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs">
								<button type="button" class="btn btn-info  btn-ml" onClick="boxPopup('<?php echo linkboxPopup(); ?>pop_add_webboard_question.php?c_id=<?php echo $c_id; ?>');">
									<i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_webboard_new_question; ?>
								</button>

								<!--<a href="webboard_add_question.php?c_id=<?php //echo $c_id;
																			?>" title="<?php //echo $txt_webboard_new_question ;
																											?>"  target="_self">
<button type="button" class="btn btn-info btn-ml" >
<i class="far fa-arrow-alt-circle-right"></i>&nbsp;<?php //echo $txt_webboard_new_question;
													?>
</button>
</a>-->

								<a href="webboard_main.php?c_id=<?php echo $c_id; ?>" title="<?php echo $txt_webboard_new_question; ?>" target="_self">
									<button type="button" class="btn btn-info btn-ml">
										<i class="fas fa-undo-alt"></i>&nbsp;<?php echo $txt_ewt_back; ?>
									</button>
								</a>
							</div>

							<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs">
								<div class="btn-group ">
									<button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle">
										<i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span>
									</button>
									<ul class="dropdown-menu dropdown-menu-right">
										<li>
											<a onClick="boxPopup('<?php echo linkboxPopup(); ?>pop_add_calendar_group.php?cal_cid=<?php echo $cal_cid; ?>');">
												<i class="fas fa-plus-circle"></i>&nbsp;<?php echo $txt_calendar_add_cate; ?>
											</a>
										</li>
										<li>
											<a href="banner_group.php" target="_self">
												<i class="fas fa-undo-alt"></i>&nbsp;<?php echo $txt_ewt_back; ?>
											</a>
										</li>
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
							<div class="panel-group" id="accordion">
								<?php
								if ($a_rows > 0) {
									$i = (($page - 1) * $perpage) + 1;
									while ($a_data = $db->db_fetch_array($_sql)) {
								?>
										<div class="panel panel-default ">
											<div class="panel-heading ewt-bg-success">
												<h4 class="panel-title">
													<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?php echo $i; ?>">
														<img src="<?php echo $IMG_PATH; ?>images/grabme.svg">
														<div class="blockico color_ewt"><i class="far fa-question-circle" style="color:#FFBE7D;"></i></div>
														<?php echo $i; ?>.) <?php echo $a_data['t_name']; ?>
													</a>
												</h4>
											</div>
											<div id="collapseOne<?php echo $i; ?>" class="panel-collapse collapse">
												<div class="panel-body">
													<div class="m-b"><b><i class="fas fa-angle-right" style="color:#FFBE7D;"></i>
															วันที่สร้าง&nbsp;:</b> <?php echo datetimetool::format($a_data['t_date'] . $a_data['t_time'], 'd/m/Y H:i'); ?>
													</div>
													<?php
													$total_comment = total_comment($a_data['t_id']);
													if ($total_comment > 0) {
													?>
														<div class="m-b"><b><i class="fas fa-angle-right" style="color:#FFBE7D;"></i><span style="color:green;"> มีผู้มาตอบคำถามแล้ว </span></b></div>
													<?php
													} else {
													?>
														<div class="m-b"><b><i class="fas fa-angle-right" style="color:#FFBE7D;"></i><span style="color:red;"> ยังไม่มีผู้มาตอบคำถาม </span></b></div>
													<?php
													}
													if ($a_data['q_name']) {
													?>
														<div class="m-b"><b><i class="fas fa-angle-right" style="color:#FFBE7D;"></i> ชื่อผู้ตั้งกระทู้ : </b> <?php echo $a_data['q_name']; ?> </div>
													<?php
													} else {
													?>
														<div class="m-b"><b><i class="fas fa-angle-right" style="color:#FFBE7D;"></i> ชื่อผู้ตั้งกระทู้ : </b> - </div>
													<?php
													}
													?>
													<div class="m-b"><b><i class="fas fa-angle-right" style="color:#FFBE7D;"></i> ความคิดเห็น : </b>
														<?php
														echo $total_comment;
														?>
													</div>
													<div class="m-b"><b><i class="fas fa-angle-right" style="color:#FFBE7D;"></i> สถานะการแสดงผล :
															<?php if ($a_data['s_id'] == 0) { ?>
																<span style="color:red;">ไม่อนุมัติ</span>
															<?php } else { ?>
																<span style="color:green;">อนุมัติ</span>
															<?php } ?></b>
													</div>
												</div>
												
											</div>
										</div>
									<?php
										$i++;
									}
								} else {
									?>
									<div class="panel panel-default ">
										<div class="panel-heading text-center">
											<h4 class="panel-title">
												<p class="text-danger"><?php echo $txt_ewt_data_not_found; ?></p>
											</h4>
										</div>
									</div>
								<?php } ?>
							</div>

							<?php echo pagination_ewt($statement, $perpage, $page, $url = 'webboard_room.php?c_id=' . $room_cid . '&'); ?>
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
include("../EWT_ADMIN/combottom.php");
?>
<script>
	function FuncCheckMarker(Id) {
		if ($('#top' + Id).val() == '0') {
			$.alert({
				title: 'ปักหมุด',
				content: 'คุณต้องการบันทึกข้อมูลนี้หรือไม่',
				icon: 'fas fa-map-marker-alt',
				boxWidth: '50%',
				animation: 'scale',
				type: 'blue',
				theme: 'modern',
				buttons: {
					confirm: {
						text: 'ตกลง',
						icon: 'far fa-check-circle',
						btnClass: 'btn-success',
						action: function() {
							$.ajax({
								type: 'POST',
								url: 'func_update_top.php',
								data: {
									't_id': Id,
									't_top': '1',
									'proc': 'Edit_Top'
								},
								success: function(data) {
									$.alert({
										title: '',
										content: 'ยืนยันปักหมุด',
										icon: 'far fa-check-circle',
										boxWidth: '50%',
										animation: 'scale',
										type: 'green',
										theme: 'modern',
										buttons: {
											cancel: {
												text: 'ตกลง',
												btnClass: 'btn-success',
												action: function() {
													location.reload();
												}
											}
										}

									});

								}
							});
						}
					},
					cancel: {
						text: 'ยกเลิก',
						btnClass: 'btn-warning',
						action: function() {
							location.reload();
						}
					}
				}
			});
		} else if ($('#top' + Id).val() == '1') {
			$.alert({
				title: 'ยกเลิกปักหมุด',
				content: '',
				icon: 'far fa-times-circle',
				boxWidth: '50%',
				animation: 'scale',
				type: 'orange',
				theme: 'modern',
				buttons: {
					confirm: {
						text: 'ตกลง',
						btnClass: 'btn-success',
						action: function() {
							$.ajax({
								type: 'POST',
								url: 'func_update_top.php',
								data: {
									't_id': Id,
									't_top': '0',
									'proc': 'Edit_Top'
								},
								success: function(data) {
									$.alert({
										title: '',
										content: 'ยืนยันยกเลิกปักหมุด',
										icon: 'far fa-check-circle',
										boxWidth: '50%',
										animation: 'scale',
										type: 'green',
										theme: 'modern',
										buttons: {
											cancel: {
												text: 'ตกลง',
												btnClass: 'btn-success',
												action: function() {
													location.reload();
												}
											}
										}

									});

								}
							});
						}
					},
					cancel: {
						text: 'ยกเลิก',
						btnClass: 'btn-warning',
						action: function() {
							location.reload();
						}
					}
				}
			});
		}
	}

	function FuncCheckWebName(Id) {
		if ($('#web_name' + Id).val() == '0') {
			$.alert({
				title: 'แสดงชื่อนามสมมุติ',
				content: 'คุณต้องการบันทึกข้อมูลนี้หรือไม่',
				icon: 'fas fa-user',
				boxWidth: '50%',
				animation: 'scale',
				type: 'blue',
				theme: 'modern',
				buttons: {
					confirm: {
						text: 'ตกลง',
						icon: 'far fa-check-circle',
						btnClass: 'btn-success',
						action: function() {
							$.ajax({
								type: 'POST',
								url: 'func_update_web_name.php',
								data: {
									't_id': Id,
									't_web_name': '1',
									'proc': 'Edit_Web_Name'
								},
								success: function(data) {
									$.alert({
										title: '',
										content: 'ยืนยันแสดงชื่อนามสมมุติ',
										icon: 'far fa-check-circle',
										boxWidth: '50%',
										animation: 'scale',
										type: 'green',
										theme: 'modern',
										buttons: {
											cancel: {
												text: 'ตกลง',
												btnClass: 'btn-success',
												action: function() {
													location.reload();
												}
											}
										}

									});

								}
							});
						}
					},
					cancel: {
						text: 'ยกเลิก',
						btnClass: 'btn-warning',
						action: function() {
							location.reload();
						}
					}
				}
			});
		} else if ($('#web_name' + Id).val() == '1') {
			$.alert({
				title: 'ยกเลิกแสดงชื่อนามสมมุติ',
				content: '',
				icon: 'far fa-times-circle',
				boxWidth: '50%',
				animation: 'scale',
				type: 'orange',
				theme: 'modern',
				buttons: {
					confirm: {
						text: 'ตกลง',
						btnClass: 'btn-success',
						action: function() {
							$.ajax({
								type: 'POST',
								url: 'func_update_web_name.php',
								data: {
									't_id': Id,
									't_web_name': '0',
									'proc': 'Edit_Web_Name'
								},
								success: function(data) {
									$.alert({
										title: '',
										content: 'ยืนยันไม่แสดงชื่อนามสมมุติ',
										icon: 'far fa-check-circle',
										boxWidth: '50%',
										animation: 'scale',
										type: 'green',
										theme: 'modern',
										buttons: {
											cancel: {
												text: 'ตกลง',
												btnClass: 'btn-success',
												action: function() {
													location.reload();
												}
											}
										}

									});

								}
							});
						}
					},
					cancel: {
						text: 'ยกเลิก',
						btnClass: 'btn-warning',
						action: function() {
							location.reload();
						}
					}
				}
			});
		}
	}
</script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui-touch-punch.min.js"></script>
<style>
	<!--
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
	-->
</style>

<span id="manage_info"></span>

<script>
	$(".delete_room").click(function() {
		var c_id = this.value;
		$.alert({
			title: 'Delete!!',
			content: '<?php echo $txt_webboard_delete_room; ?>',
			icon: 'fas fa-exclamation-circle',
			theme: 'modern',
			type: 'red',
			closeIcon: false,
			buttons: {
				confirm: {
					text: 'ตกลง',
					btnClass: 'btn-red',
					action: function() {
						$("#manage_info").html('<form method="post" id="manage_form"><input type="hidden" name="c_parent" value="<?php echo $room_cid; ?>"><input type="hidden" name="c_id" value="' + c_id + '"><input type="hidden" name="proc" value="delete_room"></form>');
						$("#manage_form").submit();
					}
				},
				close: {
					text: 'ยกเลิก',
					btnClass: 'btn-default',
				}
			},
			onAction: function() {
				//$('#loader').fadeOut();	 									
			},
			boxWidth: '80%'

		});
		//if(confirm("<?php echo $txt_webboard_delete_room; ?>")){
		//$("#manage_info").html('<form method="post" id="manage_form"><input type="hidden" name="c_parent" value="<?php echo $room_cid; ?>"><input type="hidden" name="c_id" value="'+c_id+'"><input type="hidden" name="proc" value="delete_room"></form>');
		//$("#manage_form").submit();
		//}
	});

	$(".delete_question").click(function() {
		var t_id = this.value;
		var c_id = '<?php echo $room_cid; ?>';

		$.alert({
			title: 'Delete!!',
			content: '<?php echo $txt_webboard_delete_question_ask; ?>',
			icon: 'fas fa-exclamation-circle',
			theme: 'modern',
			type: 'red',
			closeIcon: false,
			buttons: {
				confirm: {
					text: 'ตกลง',
					btnClass: 'btn-red',
					action: function() {
						$("#manage_info").html('<form method="post" id="manage_form"><input type="hidden" name="c_id" value="' + c_id + '"><input type="hidden" name="t_id" value="' + t_id + '"><input type="hidden" name="proc" value="delete_question"></form>');
						$("#manage_form").submit();
					}
				},
				close: {
					text: 'ยกเลิก',
					btnClass: 'btn-default',
				}
			},
			onAction: function() {
				//$('#loader').fadeOut();	 									
			},
			boxWidth: '80%'
		});
		//if(confirm("<?php echo $txt_webboard_delete_question_ask; ?>")){
		//$("#manage_info").html('<form method="post" id="manage_form"><input type="hidden" name="c_id" value="'+c_id+'"><input type="hidden" name="t_id" value="'+t_id+'"><input type="hidden" name="proc" value="delete_question"></form>');			
		//$("#manage_form").submit(); 
		//}
	});

	$(".approve_question").click(function() {
		//var comment = $("#comment_desc").val();
		var t_id = this.value;
		var c_id = '<?php echo $room_cid; ?>';
		/*if(confirm("<?php echo $txt_webboard_approve_question_ask; ?>")){
			$("#manage_info").html('<form method="post" id="manage_question"><input type="hidden" name="t_id" value="'+t_id+'"><input type="hidden" name="c_id" value="'+c_id+'"><input type="hidden" name="proc" value="approve_question"></form>');
			$("#manage_question").submit();
		}*/
		$.confirm({
			title: 'Approve!!',
			content: '<?php echo $txt_webboard_approve_question_ask; ?>?',
			boxWidth: '80%',
			icon: 'fas fa-exclamation-circle',
			theme: 'modern',
			buttons: {
				confirm: {
					text: 'ยืนยัน Approve',
					btnClass: 'btn-green',
					action: function() {
						$("#manage_info").html('<form method="post" id="manage_question"><input type="hidden" name="t_id" value="' + t_id + '"><input type="hidden" name="c_id" value="' + c_id + '"><input type="hidden" name="proc" value="approve_question"></form>');
						$("#manage_question").submit();
						/*$.ajax({
							type: 'POST',
							url: "func_approve_question.php",   					
							data: {id:Id,proc:"DelRss"},
							success: function (data) { 

								$.alert({
									title: '',
									theme: 'modern',
									content: 'บันทึกข้อมูลเรียบร้อย',
									boxWidth: '30%',
									onAction: function () {
										location.reload(true);			
										$('#box_popup').fadeOut();
									}
								});																						 
							}
							
						});	*/
					}
				},
				cancel: {
					text: 'ยกเลิก'
				}
			},
			animation: 'scale',
			type: 'green'
		});

	});

	$(".disapprove_question").click(function() {
		//var comment = $("#comment_desc").val();
		var t_id = this.value;
		var c_id = '<?php echo $room_cid; ?>';
		/*if(confirm("<?php echo $txt_webboard_disapprove_question_ask; ?>")){
			$("#manage_info").html('<form method="post" id="manage_question"><input type="hidden" name="t_id" value="'+t_id+'"><input type="hidden" name="c_id" value="'+c_id+'"><input type="hidden" name="proc" value="disapprove_question"></form>');
			$("#manage_question").submit();
		}*/

		$.confirm({
			title: 'Disapprove!!',
			content: '<?php echo $txt_webboard_disapprove_question_ask; ?>?',
			boxWidth: '80%',
			icon: 'fas fa-exclamation-circle',
			theme: 'modern',
			buttons: {
				confirm: {
					text: 'ยืนยัน Disapprove',
					btnClass: 'btn-warning',
					action: function() {

						$("#manage_info").html('<form method="post" id="manage_question"><input type="hidden" name="t_id" value="' + t_id + '"><input type="hidden" name="c_id" value="' + c_id + '"><input type="hidden" name="proc" value="disapprove_question"></form>');
						$("#manage_question").submit();
						/*$.ajax({
							type: 'POST',
							url: "func_disapprove_question.php",   					
							data: {id:Id,proc:"DelRss"},
							success: function (data) { 

								$.alert({
									title: '',
									theme: 'modern',
									content: 'บันทึกข้อมูลเรียบร้อย',
									boxWidth: '30%',
									onAction: function () {
										location.reload(true);			
										$('#box_popup').fadeOut();
									}
								});																						 
							}
							
						});	*/
					}
				},
				cancel: {
					text: 'ยกเลิก'
				}
			},
			animation: 'scale',
			type: 'orange'
		});
	});



	$(".approve_room").click(function() {

		var c_id = this.value;
		var c_parentid = '<?php echo $room_cid; ?>';

		$.confirm({
			title: '<?php echo $txt_webboard_approve_room; ?>',
			content: '<?php echo $txt_webboard_approve_room_ask; ?>',
			boxWidth: '30%',
			icon: 'glyphicon glyphicon-exclamation-sign',
			theme: 'modern',
			buttons: {
				confirm: {
					text: '<?php echo $txt_webboard_approve_confirm; ?>',
					btnClass: 'btn-warning',
					action: function() {
						$("#manage_info").html('<form method="post" id="manage_room"><input type="hidden" name="c_parentid" value="' + c_parentid + '"><input type="hidden" name="c_id" value="' + c_id + '"><input type="hidden" name="proc" value="approve_room"></form>');
						$("#manage_room").submit();
					}

				},
				cancel: {
					text: '<?php echo $txt_webboard_no_confirm; ?>'

				}
			},
			animation: 'scale',
			type: 'green'

		});

	});

	$(".disapprove_room").click(function() {
		//var comment = $("#comment_desc").val();
		var c_id = this.value;
		var c_parentid = '<?php echo $room_cid; ?>';

		$.confirm({
			title: '<?php echo $txt_webboard_disapprove_room; ?>',
			content: '<?php echo $txt_webboard_disapprove_room_ask; ?>',
			boxWidth: '30%',
			icon: 'glyphicon glyphicon-exclamation-sign',
			theme: 'modern',
			buttons: {
				confirm: {
					text: '<?php echo $txt_webboard_disapprove_confirm; ?>',
					btnClass: 'btn-warning',
					action: function() {
						$("#manage_info").html('<form method="post" id="manage_room"><input type="hidden" name="c_parentid" value="' + c_parentid + '"><input type="hidden" name="c_id" value="' + c_id + '"><input type="hidden" name="proc" value="disapprove_room"></form>');
						$("#manage_room").submit();
					}

				},
				cancel: {
					text: '<?php echo $txt_webboard_no_confirm; ?>'

				}
			},
			animation: 'scale',
			type: 'orange'

		});

	});
</script>