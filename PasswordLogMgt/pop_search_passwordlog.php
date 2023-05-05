<?php
include("../EWT_ADMIN/comtop_pop.php");
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

?>
<div class="container">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" onclick="$('#box_popup').fadeOut();"><i class="far fa-times-circle fa-1x"></i></button>
				<h4 class="modal-title"><?= $txt_systemlog_search; ?></h4>
			</div>
			<form name="form_main" id="form_main" method="GET" action="<?= getLocation('passwordlog_main') ?>">
				<div class="modal-body">
					<div class="scrollbar scrollbar-near-moon thin">
						<div class="form-group row ">
							<label for="banner_gid" class="col-sm-12 control-label"><b><?= $txt_systemlog_search_user; ?> :</b></label>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<select name="user_id" id="user_id" class="form-control">
									<option value="" selected="" disabled="disabled"><?= $txt_systemlog_select_user; ?></option>
									<?php
									$db->query("USE " . $EWT_DB_USER);
									$_sql = $db->query("SELECT * FROM web_group_member WHERE web_group_member.ug_id = '{$_SESSION['EWT_SUID']}' ORDER BY web_group_member.ugm_type ASC");
									while ($a_data = $db->db_fetch_array($_sql)) {
									?>
										<option value="<?= $a_data['ugm_tid']; ?>" <?= $sel; ?>><?= level_name($a_data['ugm_type'], $a_data['ugm_tid']);; ?> </option>
									<?php } ?>
								</select>
							</div>
						</div>
						<div class="form-group row ">
							<label for="module_code" class="col-sm-12 control-label"><b><?= "Type"; ?> :</b></label>
							<div class="col-md-12 col-sm-12 col-xs-12">
								<select name="module_code" id="module_code" class="form-control">
									<option value="" selected="" disabled="disabled"><?= "เลือกข้อมูล"; ?></option>
									<option value="forget">ลืมรหัสผ่าน</option>
									<option value="re">เปลี่ยนรหัสผ่าน</option>
								</select>
							</div>
						</div>
						<?php $db->query("USE " . $EWT_DB_NAME); ?>
						<div class="form-group row">
							<div class="col-md-6 col-sm-6 col-xs-12">
								<label for="startdate"><b><?= $txt_ewt_start_date; ?> : </b></label>
								<input type="text" class="form-control " name="startdate" id="datepickerStart2" value="" />
								<div id="datepickerStart" class="m-t-xs"></div>
							</div>
							<div class="col-md-6 col-sm-6 col-xs-12">
								<label for="enddate"><b><?= $txt_ewt_end_date; ?> : </b></label>
								<input type="text" class="form-control " name="enddate" id="datepickerEnd2" value="" />
								<div id="datepickerEnd" class="m-t-xs"></div>
							</div>
						</div>
						<input name="proc" type="hidden" id="proc" value="custom">
					</div>
				</div>
			</form>

			<div class="modal-footer">
				<div class="form-group row">
					<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center">
						<button onclick="JQSearch_Systemlog($('#form_main'));" class="btn btn-success btn-lm" data-toggle="tooltip" data-placement="top" title="<?= $txt_ewt_submit; ?>">
							<i class="fas fa-check-circle fa-1x"></i>&nbsp;<?= $txt_ewt_submit; ?>
						</button>
						<button onClick="$('#box_popup').fadeOut();" class="btn btn-warning btn-lm" data-toggle="tooltip" data-placement="top" title="<?= $txt_ewt_cancel; ?>">
							<i class="fas fa-times-circle fa-1x"></i>&nbsp;<?= $txt_ewt_cancel; ?>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
	$(function() {
		$('#datepickerStart')
			.datepicker({
				format: 'dd/mm/yyyy',
				language: 'en-en',
				leftArrow: '<i class="fas fa-angle-double-left"></i>',
				rightArrow: '<i class="fas fa-angle-double-right"></i>',
			}).datepicker("setDate", "0");
			$('#datepickerStart2').val($('#datepickerStart').datepicker('getFormattedDate'));
			$('#datepickerStart').on('changeDate', function() {
			$('#datepickerStart2').val($('#datepickerStart').datepicker('getFormattedDate'));
			var datestart = $('#datepickerStart2').val();
			var dateend = $('#datepickerEnd2').val();

			if (dateend < datestart) {
				$.alert({
					title: 'วันที่เริ่มต้นไม่ถูกต้อง',
					content: 'กรุณาเลือกวันที่เริ่มต้นใหม่อีกครั้ง',
					icon: 'fa fa-exclamation-circle',
					theme: 'modern',
					type: 'orange',
					animation: 'scale',
					closeIcon: false,
					buttons: {
						close: {
							text: 'ปิด',
							btnClass: 'btn-orange',
						}
					},
				});

				$('#datepickerStart')
					.datepicker({
						format: 'dd/mm/yyyy',
						language: 'en-en',
						leftArrow: '<i class="fas fa-angle-double-left"></i>',
						rightArrow: '<i class="fas fa-angle-double-right"></i>',
					}).datepicker("setDate", "0");
				$('#datepickerStart2').val($('#datepickerStart').datepicker('getFormattedDate'));
			}
		});

		$('#datepickerEnd')
			.datepicker({
				format: 'dd/mm/yyyy',
				language: 'en-en',
				leftArrow: '<i class="fas fa-angle-double-left"></i>',
				rightArrow: '<i class="fas fa-angle-double-right"></i>',
			}).datepicker("setDate", "0");
			$('#datepickerEnd2').val($('#datepickerEnd').datepicker('getFormattedDate'));
			$('#datepickerEnd').on('changeDate', function() {
			$('#datepickerEnd2').val($('#datepickerEnd').datepicker('getFormattedDate'));
			var datestart = $('#datepickerStart2').val();
			var dateend = $('#datepickerEnd2').val();
			if (dateend < datestart) {
				$.alert({
					title: 'วันที่สิ้นสุดไม่ถูกต้อง',
					content: 'กรุณาเลือกวันที่สิ้นสุดใหม่อีกครั้ง',
					icon: 'fa fa-exclamation-circle',
					theme: 'modern',
					type: 'orange',
					animation: 'scale',
					closeIcon: false,
					buttons: {
						close: {
							text: 'ปิด',
							btnClass: 'btn-orange',
						}
					},
				});

				$('#datepickerEnd')
					.datepicker({
						format: 'dd/mm/yyyy',
						language: 'en-en',
						leftArrow: '<i class="fas fa-angle-double-left"></i>',
						rightArrow: '<i class="fas fa-angle-double-right"></i>',
					}).datepicker("setDate", "0");
				$('#datepickerEnd2').val($('#datepickerEnd').datepicker('getFormattedDate'));
			}
		});
	});

	function JQSearch_Systemlog(form, id) {
		var fail = false;
		if (fail == false) {
			var action = form.attr('action');
			$('#proc').val(id);
			form.submit();
		}
	}
</script>