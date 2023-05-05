<?php
include("../EWT_ADMIN/comtop.php");
$sso = new sso();
?>
<!-- START CONTAINER  -->
<div class="container-fluid">
	<?php
	include("menu-top.php");

	$wh1 = '';
	if (!empty($_GET['startdate']) && !empty($_GET['enddate'])) {
		$st = explode("/", $_GET['startdate']);
		$startdate = $st[2] . "-" . $st[1] . "-" . $st[0];
		$et = explode("/", $_GET['enddate']);
		$enddate = $et[2] . "-" . $et[1] . "-" . $et[0];
		$wh1 .= " (user_date BETWEEN '" . $startdate . "' AND '" . $enddate . "' )";
	}

	if (!empty($_GET['module_code'])) {
		$wh1 .= " AND (user_type = '" . $_GET['module_code'] . "' )";
	}

	if (!empty($_GET['user_id'])) {
		$wh1 .= " AND (user_id = '" . $_GET['user_id'] . "' ) ";
	}

	if (!empty($wh1)) {
		$wh = "WHERE " . $wh1;
	}

	$perpage = 10;
	$page = (int)(!isset($_GET['page']) ? 1 : $_GET['page']);
	if ($page <= 0) $page = 1;
	$start = ($page * $perpage) - $perpage;
	$_sql = $db->query("SELECT * FROM " . EWT_DB_USER . ".user_password_log {$wh} ORDER BY user_date DESC, user_time DESC LIMIT
	{$start},{$perpage}");
	$statement = "SELECT count(id) AS b FROM " . EWT_DB_USER . ".user_password_log {$wh} {$sql_search}";
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
							<div class="col-md-12 col-sm-12 col-xs-12 float-right text-right hidden-xs">
								<button type="button" class="btn btn-info  btn-sm" onClick="boxPopup('<?= linkboxPopup(); ?>pop_search_passwordlog.php');" title="<?= $txt_complain_add_cate; ?>" target="_self">
									<i class="fas fa-search"></i>&nbsp;<?= "ค้นหา Password Log"; ?>
								</button>
								<a target="_blank" onclick ="submitForm()" >
								<button type="button" class="btn btn-info  btn-ml ">
									<i class="fas fa-file-excel"></i>&nbsp;<?php echo "Excel"; ?>
								</button>
								</a>
								
								
							
							</div>
							

							<div class="col-md-6 col-sm-6 col-xs-12 float-right text-right visible-xs">
								<div class="btn-group ">
									<button type="button" data-toggle="dropdown" class="btn btn-info dropdown-toggle"><i class="far fa-play-circle"></i>&nbsp;action <span class="caret"></span></button>
									<ul class="dropdown-menu dropdown-menu-right"></ul>
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
							<div class="card">
								<div class="card-header ewt-bg-success m-b-sm">
									<div class="card-title text-left">
									</div>
								</div>
								<div class="card-body">
									<div class="panel-group" id="accordion">
										<?php if ($a_rows > 0) { ?>
											<?php $i = 0; ?>
											<?php while ($a_data = $db->db_fetch_array($_sql)) { ?>
												<?php
												$s_data = $sso->getUser($a_data['user_name'])["data"];
												$fullname = $s_data["USR_FNAME"] . ' ' . $s_data["USR_LNAME"];
												?>
												<div class="panel panel-default ">
													<div class="panel-heading ewt-bg-success">
														<h4 class="panel-title">
															<a class="accordion-toggle collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseOne<?= $i; ?>">
																<i class="fas fa-chalkboard-teacher color-ewt"></i>
																<?php
																if ($a_data["user_type"] == "forget") {
																	$detail = "ลืมรหัสผ่าน";
																	echo $fullname . " :: " .$detail;
																}

																if ($a_data["user_type"] == "re") {
												
																	$detail = $fullname . " :: เปลี่ยนรหัสผ่าน";
																	$detail = "เปลี่ยนรหัสผ่าน";
																	echo $fullname . " :: " .$detail;
																	
																}
																?>
															</a>
														</h4>
													</div>

													<div id="collapseOne<?= $i; ?>" class="panel-collapse collapse">
														<div class="panel-body">
															<div>
																<b><?= "วันที่"; ?> :</b> <?= date("d/m/Y",strtotime($a_data['user_date'])); ?>
																<?= date("H:i",strtotime($a_data['user_time'])); ?> น.
															</div><br>
															<div><b><?= "Username"; ?> :</b> <?= $a_data['user_name']; ?></div><br>
															<div><b><?= "IP"; ?> :</b> <?= $a_data['user_ip']; ?></div><br>
														</div>
														<div class="panel-footer ewt-bg-white text-right">
															<div class="ewt-icon-wrap ewt-icon-effect-1 ewt-icon-effect-1b">
															</div>
														</div>
													</div>
												</div>
												<Form action="passwordlog_report_excel_export.php?startdate=<?php echo $_GET["startdate"]; ?>&enddate=<?php echo $_GET["enddate"];?>&user_id=<?php echo $_GET["user_id"];?>&module_code=<?php echo $_GET['module_code'];?>" method="POST" name="form1">
												<?php
												echo '<input type="hidden" name="fullname[]" value="'. $fullname. '">';
												echo '<input type="hidden" name="username[]" value="'. $a_data['user_name']. '">';
												echo '<input type="hidden" name="IP[]" value="'. $a_data['user_ip']. '">';
												echo '<input type="hidden" name="datetime[]" value="'. date("H:i",strtotime($a_data['user_time'])). '">';
												echo '<input type="hidden" name="dateday[]" value="'. date("d/m/Y",strtotime($a_data['user_date'])). '">';
												echo '<input type="hidden" name="detail[]" value="'. $detail. '">';
												?>
												<?php $i++; ?>
											<?php } ?>
										<?php } else { ?>
											<div class="panel panel-default ">
												<div class="panel-heading text-center">
													<h4 class="panel-title">
														<p class="text-danger"><?= $txt_ewt_data_not_found; ?></p>
													</h4>
												</div>
											</div>
										<?php } ?>
									</div>
								</div>
							</div>
							<?= pagination_ewt($statement, $perpage, $page, $url = '?user_id=' . $_GET['user_id'] . '&module_code=' . $_GET['module_code'] . '&startdate=' . $_GET['startdate'] . '&enddate=' . $_GET['enddate'] . '&'); ?>
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


</Form>
<?php
print_r($a_name);
include("../EWT_ADMIN/combottom.php");
?>
<script>
function submitForm() {
	document.form1.submit();
}
function newsCount(a_name) {
        $.ajax({
            type: 'POST',
            url: 'test.php',
            data: {
                name : name,
            },
            datatype: "text",
            success: function(data) {
                //console.log(data);
                let object = JSON.parse(data, true);
            },
            error: function() {
                console.log('Error');
            }
        });
    }</script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui.min.js"></script>
<script src="https://mdbootstrap.com/wp-content/themes/mdbootstrap4/js/plugins/jquery-ui-touch-punch.min.js"></script>