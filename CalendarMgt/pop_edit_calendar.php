<?php
include("../EWT_ADMIN/comtop_pop.php");

// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

$event_id = (int)(!isset($_GET['event_id']) ? 0 : $_GET['event_id']);

// $_sql = $db->query("SELECT 
// 					cal_event.*,
// 					cal_show_event.event_date_start,
// 					cal_show_event.event_date_end,
// 					cal_category.cat_name,
// 					cal_category.cat_color 
// 					FROM cal_event 
// 					INNER JOIN cal_show_event ON (cal_event.event_id = cal_show_event.event_id) 
// 					INNER JOIN cal_category ON (cal_category.cat_id = cal_event.cat_id)
// 					WHERE cal_event.event_id = '{$event_id}' ");
$_sql = $db->query("SELECT * FROM cal_event WHERE event_id = '{$event_id}'");
$a_data = $db->db_fetch_array($_sql);

if (!empty($a_data['event_registor'])) {
	$event_registor = $a_data['event_registor'];
} else {
	$event_registor = "";
}

function getCateType($_type)
{
	if ($_type == '1') {
		$_text = 'ปฎิทินกิจกรรม';
	} else if ($_type == '2') {
		$_text = 'ปฎิทินผู้บริหาร';
	}
	return ' (' . $_text . ')';
}
?>

<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_edit_calendar') ?>" enctype="multipart/form-data">
	<input type="hidden" name="proc" id="proc" value="Edit_calendar">
	<input type="hidden" name="event_id" id="event_id" value="<?php echo $event_id; ?>">

	<div class="container">
		<div class="modal-dialog modal-lg">

			<div class="modal-content">
				<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
					<button type="button" class="close" onclick="$('#box_popup').fadeOut();"><i class="far fa-times-circle fa-1x color-white"></i></button>
					<h4 class="modal-title color-white"><i class="far fa-edit" aria-hidden="true"></i> <?php echo $txt_calendar_edit; ?></h4>
				</div>

				<div class="modal-body">

					<div class="card ">
						<div class="card-body">

							<div class="form-group row ">
								<label for="calendar_title" class="col-sm-12 control-label"><b><?php echo $txt_calendar_title; ?> <span class="text-danger"><code>*</code></span> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<textarea class="form-control" placeholder="<?php echo $txt_calendar_title; ?>" rows="6" id="calendar_title" name="calendar_title" required="required"><?php echo !empty($a_data['event_title']) ? $a_data['event_title'] : ""; ?></textarea>
								</div>
							</div>
							<div class="form-group row ">
								<label for="calendar_detail" class="col-sm-12 control-label"><b><?php echo $txt_calendar_detail; ?> <span class="text-danger"></span> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<textarea class="form-control" placeholder="<?php echo $txt_calendar_detail; ?>" rows="6" id="calendar_detail" name="calendar_detail"><?php echo !empty($a_data['event_detail']) ? $a_data['event_detail'] : ""; ?></textarea>
								</div>
							</div>

							<div class="form-group row">
								<label for="calendar_category" class="col-sm-12 control-label"><b><?php echo $txt_calendar_cate; ?> <span class="text-danger"><code>*</code></span> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<select name="calendar_category" id="calendar_category" class=" selectpicker form-control" required="required" data-live-search="true" title="<?php echo $txt_calendar_select_cate; ?>">
										<?php
										$_sql_cate = $db->query("SELECT cat_id,cat_name,cat_type,cat_manager FROM cal_category WHERE webname_site = '{$_SESSION['EWT_SUSER']}' ORDER BY cat_id ASC");
										while ($a_data_cat = $db->db_fetch_row($_sql_cate)) {
											$m_name = '';
											if ($a_data_cat[3]) {
												$_sql_user = $db->query("SELECT * FROM cal_manager WHERE m_id = '{$a_data_cat[3]}' ");
												$a_data_user = $db->db_fetch_array($_sql_user);
												$m_name = ' (' . $a_data_user['m_name'] . ' ' . $a_data_user['m_surname'] . ') ';
											}
											$sel = ($a_data_cat[0] == trim($a_data['cat_id'])) ? "selected" : "";
										?>
											<option value="<?php echo $a_data_cat[0]; ?>" <?php echo $sel; ?>><?php echo $a_data_cat[1]; ?> <?php echo getCateType($a_data_cat[2]) . ' ' . $m_name . ''; ?></option>
										<?php
										}
										?>
									</select>
								</div>
							</div>

							<div class="form-group row">
								<div class="col-md-4 col-sm-4 col-xs-12">
									<label for="event_date_start"><b><?php echo $txt_calendar_statdate; ?><span class="text-danger"><code>*</code></span> : </b></label>
									<div class='input-group date datepicker' id='datetimepicker1'>
										<input readonly type='text' class="form-control " placeholder="<?php echo $txt_calendar_statdate; ?>" name="event_date_start" id="event_date_start" value="<?php echo !empty($a_data['event_date_start']) ? datetimetool::format($a_data['event_date_start'], 'd/m/Y') : null; ?>" required="required">
										<span class="input-group-addon ewt-bg-color color-white border-ewt">
											<i class="far fa-calendar-alt"></i>
										</span>
									</div>
								</div>
								<div class="col-md-2 col-sm-2 col-xs-12">
									<label for="event_time_start"><b>&nbsp;<?php echo 'เวลาเริ่มต้น'; ?><span class="text-danger"><code>*</code></span> : </b></label>
									<div class="input-group">
										<input class="form-control datepickertime" placeholder="" name="event_time_start" type="text" id="event_time_start" value="<?php echo !empty($a_data['event_time_start']) ? datetimetool::format($a_data['event_time_start'], 'H:i') : ""; ?>" required="required" aria-describedby="basic-addon2">
										<span class="input-group-addon ewt-bg-color color-white border-ewt" id="basic-addon2">น.</span>
									</div>
								</div>


								<div class="col-md-4 col-sm-4 col-xs-12">
									<label for="event_date_end"><b><?php echo $txt_calendar_enddate; ?><span class="text-danger"><code>*</code></span> : </b></label>
									<div class='input-group date datepicker' id='datetimepicker2'>
										<input readonly type='text' class="form-control " placeholder="<?php echo $txt_calendar_enddate; ?>" name="event_date_end" id="event_date_end" value="<?php echo !empty($a_data['event_date_end']) ? datetimetool::format($a_data['event_date_end'], 'd/m/Y') : ""; ?>" required="required">
										<span class="input-group-addon ewt-bg-color color-white border-ewt">
											<i class="far fa-calendar-alt"></i>
										</span>
									</div>
								</div>
								<div class="col-md-2 col-sm-2 col-xs-12">
									<label for="event_time_end"><b>&nbsp;<?php echo 'เวลาสิ้นสุด'; ?><span class="text-danger"><code>*</code></span> : </b></label>
									<div class="input-group">
										<input class="form-control datepickertime" placeholder="" name="event_time_end" type="text" id="event_time_end" value="<?php echo !empty($a_data['event_time_end']) ? datetimetool::format($a_data['event_time_end'], 'H:i') : ""; ?>" required="required" aria-describedby="basic-addon2">
										<span class="input-group-addon ewt-bg-color color-white border-ewt" id="basic-addon2">น.</span>
									</div>
								</div>
							</div>

							<div class="form-group row">
								<label for="event_relatelink" class="col-sm-12 control-label"><b>เชื่อมโยงบทความหรือ url ที่เกี่ยวข้อง :</b></label>
								<div class="col-md-10 col-sm-10 col-xs-10">
									<input type="text" name="event_relatelink" id="event_relatelink" class="form-control" value="<?php echo !empty($a_data['event_relatelink']) ? $a_data['event_relatelink'] : ""; ?>">
								</div>
								<div class="col-md-2 col-sm-2 col-xs-2">
									<a href="#browse" onClick="win2 = window.open('../FileMgt/article_main.php?stype=link&Flag=Link&o_value=window.opener.document.form_main.event_relatelink.value','WebsiteLink','top=100,left=100,width=800,height=500,resizable=1,status=0');document.form1.browsefile[0].checked=true;win2.focus();">
										<button type="button" class="btn btn-info  btn-sm ">
											<i class="fas fa-folder-open"></i>&nbsp;เลือกไฟล์
										</button>
									</a>
								</div>
							</div>

							<div class="form-group row">
								<label for="event_link" class="col-sm-12 control-label"><b><?php echo $txt_calendar_attack; ?> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<input type="file" name="event_link" id="event_link" class="form-control" onchange="JSCheck_file(this.id,this.value);JSCheck_filenameTH(this.id,this.value);" />
									<?php
									if (!empty($a_data['event_link'])) {
									?>
										<span><?php echo $a_data['event_link']; ?></span><br>
									<?php } ?>
									<span class="text-danger">
										<code>
											ประเภทไฟล์ที่สามารถใช้ได้คือ <?php echo EwtTypefile('file'); ?>
										</code>
									</span>
									<br>
									<span class="text-danger"><code>
											ขนาดไฟล์ต้องไม่เกิน <?php echo EwtMaxfile('file'); ?> MB.
										</code>
									</span>
								</div>
							</div>

							<input name="event_link_old" type="hidden" id="event_link_old" value="<?php echo $a_data['event_link']; ?>">

							<?php
							$_sql_cal_invite = $db->query("SELECT * FROM cal_invite WHERE event_id = '{$event_id}' ");
							$a_data_invite = $db->db_fetch_array($_sql_cal_invite);
							?>

							<div class="form-group row">
								<label for="calendar_contact" class="col-sm-12 control-label"><b><?php echo "ผู้ประสานงาน"; ?> :</b></label>
								<div class="col-md-10 col-sm-10 col-xs-10">
									<a href="#browse" onClick="boxPopup2('<?php echo linkboxPopup(); ?>pop_calendar_genuser.php');">
										<input class="form-control" placeholder="<?php echo "ผู้ประสานงาน"; ?>" name="calendar_contact" type="text" id="calendar_contact" value="<?php echo !empty($a_data_invite['person_id']) ? cal_contact($a_data_invite['person_id']) : ""; ?>" />
									</a>
								</div>

								<div class="col-md-2 col-sm-2 col-xs-2">
									<span id="txtshow"></span>
									<a href="#browse" onClick="boxPopup2('<?php echo linkboxPopup(); ?>pop_calendar_genuser.php');">
										<button type="button" class="btn btn-info  btn-sm">
											<i class="fas fa-folder-open"></i>&nbsp;<?php echo "ผู้ประสานงาน"; ?>
										</button>
									</a>
									<input name="gen_user_id" type="hidden" id="gen_user_id" value="">
									<input name="gen_user_id_old" type="hidden" id="gen_user_id_old" value="<?php echo !empty($a_data_invite['person_id']) ? $a_data_invite['person_id'] : ""; ?>">
								</div>
							</div>

							<div class="form-group row" id="list_calendar_phone" style="<?php echo !empty($a_data_invite['person_id']) ? 'display:block' : 'display:none'; ?>">
								<label class="col-sm-12 control-label"><b>เบอร์โทรติดต่อ :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<input type="text" class="form-control" placeholder="เบอร์โทรติดต่อ" name="phone" id="phone" value="<?php echo $a_data_invite['phone']; ?>">
								</div>
							</div>

							<div class="form-group row" id="list_calendar_department" style="<?php echo !empty($a_data_invite['person_id']) ? 'display:block' : 'display:none'; ?>">
								<label class="col-sm-12 control-label"><b>หน่วยงาน :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<input type="text" class="form-control" placeholder="หน่วยงาน" name="department" id="department" value="<?php echo $a_data_invite['department']; ?>">
								</div>
							</div>

							<div id="box_popup2" class="layer-modal"></div>

							<div class="form-group row">
								<label for="calendar_location" class="col-sm-12 control-label"><b><?php echo $txt_calendar_location; ?> <span class="text-danger"><code>*</code></span> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<textarea class="form-control" placeholder="<?php echo $txt_calendar_location; ?>" rows="6" id="calendar_location" name="calendar_location" required="required"><?php echo !empty($a_data['event_location']) ? $a_data['event_location'] : ""; ?></textarea>
								</div>
							</div>

							<div class="form-group row">
								<label for="calendar_setregis" class="col-sm-12 control-label"><b><?php echo $txt_calendar_setregis; ?> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="radio b-sm">
										<label><input type="radio" name="calendar_setregis" id="calendar_setregis" value="" onclick="JQCheck_SetRegis($('#calendar_setregis'));" _onclick="JQCheck_SetRegis($('#calendar_setregis'));" <?php echo ($event_registor == '') ? 'checked' : ""; ?>><?php echo 'ไม่มีการลงทะเบียน'; ?>
											<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
										</label>

										<label><input type="radio" name="calendar_setregis" id="calendar_setregis" value="Y" onclick="JQCheck_SetRegis($('#calendar_setregis'));" _onclick="JQCheck_SetRegis($('#calendar_setregis'));" <?php echo ($event_registor == 'Y') ? 'checked' : ""; ?>><?php echo $txt_calendar_registor; ?>
											<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
										</label>

										<label><input type="radio" name="calendar_setregis" id="calendar_setregis1" value="M" onclick="JQCheck_SetRegis($('#calendar_setregis1'));" _onclick="JQCheck_SetRegis($('#calendar_setregis'));" <?php echo ($event_registor == 'M') ? 'checked' : ""; ?>><?php echo 'ลงทะเบียนจากเว็บอื่น'; ?>
											<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
										</label>
									</div>
									<!-- <div class="radio">
										<label>
											<input type="radio" name="calendar_setregis" id="calendar_setregis" value="Y" <?php echo ($event_registor == 'Y') ? 'checked' : ""; ?> _onclick="JQCheck_SetRegis($('#calendar_setregis'));" /><?php echo $txt_calendar_registor; ?>
											<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
										</label>
									</div> -->
									<!--<div class="radio" <?php echo ($event_registor != 'Y') ? "style=\"display:none;\"" : ""; ?>>
										<label><input type="radio" name="calendar_setregis" id="calendar_setregis" value="Y" <?php echo ($event_registor == '') ? 'checked' : ""; ?> _onclick="JQCheck_SetRegis($('#calendar_setregis'));" /><?php echo $txt_calendar_registor; ?>
											<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
										</label>
									</div>
									 <div class="radio" <?php if ($event_registor != 'M') {
															echo "style=\"display:none;\"";
														} ?>>
										<label><input type="radio" name="calendar_setregis" id="calendar_setregis1" value="M" <?php if ($event_registor == 'M') {
																																	echo 'checked';
																																} ?> _onclick="JQCheck_SetRegis($('#calendar_setregis1'));" /><?php echo 'ลงทะเบียนจากเว็บอื่น'; ?>
											<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
										</label>
									</div> -->
								</div>
							</div>

							<div class="form-group row " <?php if ($event_registor != 'M') {
																echo "style=\"display:none;\"";
															} ?> id="c_link">
								<label for="calendar_link_to" class="col-sm-12 control-label"><b><?php echo "ลิงค์ลงทะเบียนจากเว็บอื่น"; ?> <span class="text-danger"><code>*</code></span> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<input class="form-control " placeholder="<?php echo "ลิงค์ลงทะเบียนจากเว็บอื่น"; ?>" name="calendar_link_to" type="text" id="calendar_link_to" value="<?php echo $a_data['event_link_registor']; ?>" />
								</div>
							</div>

							<div class="form-group row " id="c_num" <?php echo ($event_registor != 'Y') ? "style=\"display:none;\"" : ""; ?>>
								<label for="calendar_num" class="col-sm-12 control-label"><b><?php echo $txt_calendar_num; ?> <span class="text-danger"><code>*</code></span> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<input class="form-control number" placeholder="<?php echo $txt_calendar_num; ?>" name="calendar_num" type="text" id="calendar_num" value="<?php echo $a_data['event_registor_num']; ?>" />
								</div>
							</div>

							<div class="form-group row " style="display:none;" id="c_form">
								<label for="calendar_form" class="col-sm-12 control-label"><b><?php echo $txt_calendar_form; ?> <span class="text-danger"><code>*</code></span> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
								</div>
							</div>

							<!-- <div class="form-group row" <?php if ($event_registor != 'Y') {
																	echo "style=\"display:none;\"";
																} ?> id="c_num">
								<label for="calendar_num" class="col-sm-12 control-label"><b><?php echo $txt_calendar_num; ?> <span class="text-danger"><code>*</code></span> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<input class="form-control number" placeholder="<?php echo $txt_calendar_num; ?>" name="calendar_num" type="text" id="calendar_num" value="<?php echo $a_data['event_registor_num']; ?>" />
								</div>
							</div>

							<div class="form-group row" <?php if ($event_registor != 'M') {
															echo "style=\"display:none;\"";
														} ?> id="c_link">
								<label for="calendar_link_to" class="col-sm-12 control-label"><b><?php echo "ลิงค์ลงทะเบียนจากเว็บอื่น"; ?> <span class="text-danger"><code>*</code></span> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<input class="form-control" placeholder="<?php echo "ลิงค์ลงทะเบียนจากเว็บอื่น"; ?>" name="calendar_link_to" type="text" id="calendar_link_to" value="<?php echo $a_data['event_link_registor']; ?>" />
								</div>
							</div>

							<div class="form-group row" style="display:none;" id="c_form">
								<label for="calendar_form" class="col-sm-12 control-label"><b><?php echo $txt_calendar_form; ?> <span class="text-danger"><code>*</code></span> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">

								</div>
							</div> -->

							<?php
							if (!empty($a_data['event_show_start']) == '0000-00-00') {
								$event_show_start = '';
							} else {
								$event_show_start = !empty($a_data['event_show_start']);
							}
							if (!empty($a_data['event_show_end']) == '0000-00-00') {
								$event_show_end = '';
							} else {
								$event_show_end = !empty($a_data['event_show_end']);
							}
							?>

							<!-- <div class="form-group row">
								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="start_date"><b><?php echo $txt_calendar_statdate_show; ?> : </b></label>
									<div class='input-group date datepicker' id='txt_calendar_statdate_show'>
										<input readonly type='text' class="form-control " placeholder="<?php echo $txt_calendar_statdate_show; ?>" name="start_date" id="start_date" value="<?php echo datetimetool::format($event_show_start, 'd/m/Y'); ?>">
										<span class="input-group-addon ewt-bg-color color-white border-ewt">
											<i class="far fa-calendar-alt"></i>
										</span>
									</div>
								</div>

								<div class="col-md-6 col-sm-6 col-xs-12">
									<label for="end_date"><b><?php echo $txt_calendar_enddate_show; ?> : </b></label>
									<div class='input-group date datepicker' id='txt_calendar_enddate_show'>
										<input readonly type='text' class="form-control " placeholder="<?php echo $txt_calendar_enddate_show; ?>" name="end_date" id="end_date" value="<?php echo datetimetool::format($event_show_end, 'd/m/Y'); ?>">
										<span class="input-group-addon ewt-bg-color color-white border-ewt">
											<i class="far fa-calendar-alt"></i>
										</span>
									</div>
								</div>
							</div> -->

						</div>
					</div>
				</div>

				<div class="modal-footer">
					<div class="col-md-12 col-sm-12 col-xs-12 text-center">
						<button onclick="JQEdit_Calendar($('#form_main'));" type="button" class="btn btn-success  btn-ml ">
							<i class="fas fa-save"></i>&nbsp;<?php echo $txt_ewt_save; ?>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<!-- Custom js -->
<script type="text/javascript" src="<?php echo $IMG_PATH; ?>assets/js/custom.js"></script>
<script>
	$(document).ready(function() {
		$('.selectpicker').selectpicker();
	});

	$(function() {
		// $.samaskHtml();
		//$('.number').samask("00000");
		$('.datepickertime').mask("00:00", {
			placeholder: "--:--"
		});
		var today = new Date();
		$('.datepicker')
			.datepicker({
				format: 'dd/mm/yyyy',
				todayHighlight: true,
				autoclose: true,
				language: 'th-th',
				//thaiyear: true,
				leftArrow: '<i class="fas fa-angle-double-left"></i>',
				rightArrow: '<i class="fas fa-angle-double-right"></i>',
			})
		//.datepicker("setDate", "0"); 
		//.datepicker("setDate", today.toLocaleDateString());  	

		$('#datetimepicker1').on('changeDate', function() {
			var event_date_start = $('#event_date_start').val();
			var event_date_end = $('#event_date_end').val();

			if (event_date_end != '') {
				if (event_date_end < event_date_start) {
					$.alert({
						title: 'วันที่เริ่มต้นกิจกรรมไม่ถูกต้อง',
						content: 'กรุณาเลือกวันที่เริ่มต้นกิจกรรมใหม่อีกครั้ง',
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

					$('#event_date_start').val('');
				}
			}
		});

		$('#datetimepicker2').on('changeDate', function() {
			var event_date_start = $('#event_date_start').val();
			var event_date_end = $('#event_date_end').val();

			if (event_date_end < event_date_start) {
				$.alert({
					title: 'วันที่สิ้นสุดกิจกรรมไม่ถูกต้อง',
					content: 'กรุณาเลือกวันที่สิ้นสุดกิจกรรมใหม่อีกครั้ง',
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
				$('#event_date_end').val('');
			}
		});

		$('#txt_calendar_statdate_show').on('changeDate', function() {
			var start_date = $('#start_date').val();
			var end_date = $('#end_date').val();
			if (end_date != '') {
				if (end_date < start_date) {
					$.alert({
						title: 'วันที่เริ่มต้นการแสดงผลที่ปฏิทินกิจกรรมไม่ถูกต้อง',
						content: 'กรุณาเลือกวันที่เริ่มต้นการแสดงผลที่ปฏิทินกิจกรรมใหม่อีกครั้ง',
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

					$('#start_date').val('');
				}
			}
		});

		$('#txt_calendar_enddate_show').on('changeDate', function() {
			var start_date = $('#start_date').val();
			var end_date = $('#end_date').val();

			if (end_date < start_date) {
				$.alert({
					title: 'วันที่สิ้นสุดการแสดงผลที่ปฏิทินกิจกรรมไม่ถูกต้อง',
					content: 'กรุณาเลือกวันที่สิ้นสุดการแสดงผลที่ปฏิทินกิจกรรมใหม่อีกครั้ง',
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
				$('#end_date').val('');
			}
		});
	});

	function JCheck_SetRegis(display) {
		if (display == "show") {
			$("#JQCheck_SetRegis").val("Y");
		} else if (display == "hide") {
			$("#JQCheck_SetRegis").val("");
		}
	}

	function JQCheck_SetRegis(form) {
		// var name = form.attr('name');
		// var check = $('input:checkbox[name=' + name + ']:checked').val();
		// if (check == 'Y') {
		// 	$('#c_num').show();
		// 	$('#calendar_num').attr("required", true);

		// } else {
		// 	$('#c_num').hide();
		// 	$('#calendar_num').attr("required", false);

		// }
		// console.log(check);
		var name = form.attr('name');
		var check = $('input:radio[name=' + name + ']:checked').val();
		if (check == 'Y') {
			$('#c_num').show();
			$('#c_link').hide();
			$('#calendar_num').attr("required", true);
			$('#calendar_link_to').attr("required", false);
		} else if (check == 'M') {
			$('#c_num').hide();
			$('#c_link').show();
			$('#calendar_link_to').attr("required", true);
			$('#calendar_num').attr("required", false);
		} else {
			$('#c_num').hide();
			$('#c_link').hide();
			$('#calendar_link_to').attr("required", false);
			$('#calendar_num').attr("required", false);

		}
	}

	function JQEdit_Calendar(form) {
		var fail = CKSubmitData(form);
		if (fail == false) {
			var action = form.attr('action');
			var method = form.attr('method');
			var formData = false;
			if (window.FormData) {
				formData = new FormData(form[0]);
			}
			$.confirm({
				title: '<?php echo $txt_calendar_edit; ?>',
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
										boxWidth: '50%',
										animation: 'scale',
										type: 'blue',
										onAction: function() {
											//self.location.href="poll_builder.php?c_id="+jsonObject;	
											location.reload(true);
											$('#box_popup').fadeOut();
										}
									});

									//$("#frm_edit_s").load(location.href + " #frm_edit_s");
									//alert("Data Save: " + data);												
									//self.location.href="article_list.php?cid="+data;											
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
</script>