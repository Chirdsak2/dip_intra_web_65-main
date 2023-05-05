<?php
include("../EWT_ADMIN/comtop_pop.php");
$sso = new sso();

//$faq_cid = (int)(!isset($_GET['faq_cid']) ? 0 : $_GET['faq_cid']);
$db->query("USE " . $EWT_DB_USER);
?>

<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_add_org_list') ?>" enctype="multipart/form-data">
	<input type="hidden" name="proc" id="proc" value="Add_OrgUser">

	<div class="container">
		<div class="modal-dialog modal-lg">

			<div class="modal-content ">
				<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
					<button type="button" class="close" onclick="$('#box_popup').fadeOut();"><i class="far fa-times-circle fa-1x  color-white"></i></button>
					<h4 class="modal-title color-white"> <i class="fas fa-plus-circle"></i> <?php echo $txt_org_add; ?></h4>
				</div>

				<div class="modal-body">
					<div class="card">
						<div class="card-body">
							<div class="form-group row ">
								<label for="txt_org_list_title_thai" class="col-sm-12 control-label"><b><?php echo $txt_org_list_title_thai; ?> <span class="text-danger"><?php /*<code>*</code>*/ ?></span> :</label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<select name="txt_org_list_title_thai" id="txt_org_list_title_thai" class=" selectpicker form-control " required="required" data-live-search="true" title="<?php echo $txt_org_list_title_thai; ?>">
										<?php
										// $_sql_title = $db->query("SELECT `title_id`,`title_thai` 
										// 						 FROM `title` 
										// 						 WHERE `title`.`title_status` = 'Y' OR `title`.`title_status` = ''
										// 						 ORDER BY title_id ASC ");
										// while($a_data_title = $db->db_fetch_row($_sql_title)){
										// 	$sel = ($a_data_title[0] == trim($title_id)) ? "selected":"";
										$_sql_title = $sso->getTitle()["dataAll"];
										foreach ($_sql_title as $a_data_title) {
										?>
											<!-- <option value="<?php echo $a_data_title[0]; ?>" <?php echo $sel; ?> ><?php echo $a_data_title[1]; ?></option> -->
											<option value="<?php echo $a_data_title["PREFIX_TH"]; ?>"><?php echo $a_data_title["PREFIX_TH"]; ?></option>
										<?php
										}
										?>
									</select>
								</div>
							</div>

							<div class="form-group row">
								<label for="txt_org_list_name_thai" class="col-sm-12 control-label"><b><?php echo $txt_org_list_name_thai; ?> <span class="text-danger"><?php /*<code>*</code>*/ ?></span> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<input type="text" class="form-control" placeholder="<?php echo $txt_org_list_name_thai; ?>" id="txt_org_list_name_thai" name="txt_org_list_name_thai" required="required" />
								</div>
							</div>

							<div class="form-group row">
								<label for="txt_org_list_surname_thai" class="col-sm-12 control-label"><b><?php echo $txt_org_list_surname_thai; ?> <span class="text-danger"><?php /*<code>*</code>*/ ?></span> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<input type="text" class="form-control" placeholder="<?php echo $txt_org_list_surname_thai; ?>" id="txt_org_list_surname_thai" name="txt_org_list_surname_thai" required="required" />
								</div>
							</div>

							<div class="form-group row">
								<label for="txt_org_list_idcard" class="col-sm-12 control-label"><b><?php echo $txt_org_list_idcard; ?> <span class="text-danger"><code>*</code></span> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<input type="text" class="form-control checkidc idcard" placeholder="<?php echo $txt_org_list_idcard; ?>" id="txt_org_list_idcard" name="txt_org_list_idcard" oninput="ChkIdCard('txt_org_list_idcard');"/>
									<span class="text-danger">
										<code id="list_idcard">
											Ex. 9-9999-99999-99-9
										</code>
									</span>
								</div>
							</div>

							<div class="form-group row ">
								<label for="txt_org_list_org_name" class="col-sm-12 control-label"><b><?php echo $txt_org_list_org_name; ?> <span class="text-danger"><?php /*<code>*</code>*/ ?></span> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<select name="txt_org_list_org_name" id="txt_org_list_org_name" class=" selectpicker form-control" required="required" data-live-search="true" title="<?php echo $txt_org_list_org_name; ?>">
										<?php
										// $_sql_org = $db->query("SELECT `org_id`,`name_org` 
										// 						FROM `org_name` 
										// 						WHERE `org_name`.`parent_org_id` LIKE '0001_%' AND `org_name`.`org_status` = '' OR `org_name`.`org_status` = 'Y' 
										// 						ORDER BY name_org ASC ");
										// while($a_data_org = $db->db_fetch_row($_sql_org)){
										// 	$sel = ($a_data_org[0] == trim($org_id)) ? "selected":"";
										$_sql_org = $sso->getDepartments()["dataAll"];
										foreach ($_sql_org as $a_data_org) {
										?>
											<!-- <option value="<?php echo $a_data_org[0]; ?>" <?php echo $sel; ?> ><?php echo $a_data_org[1]; ?></option> -->
											<option value="<?php echo $a_data_org["DEP_NAME"]; ?>"><?php echo $a_data_org["DEP_NAME"]; ?></option>
										<?php
										}
										?>
									</select>
								</div>
							</div>

							<div class="form-group row ">
								<label for="txt_org_list_pos_name" class="col-sm-12 control-label"><b><?php echo $txt_org_list_pos_name; ?> <span class="text-danger"><?php /*<code>*</code>*/ ?></span> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<select name="txt_org_list_pos_name" id="txt_org_list_pos_name" class="selectpicker form-control" required="required" data-live-search="true" title="<?php echo $txt_org_list_pos_name; ?>">
										<?php
										// $_sql_pos = $db->query("SELECT `pos_id`,`pos_name` 
										// 						FROM `position_name` 
										// 						WHERE `position_name`.`pos_status` = 'Y' OR `position_name`.`pos_status` = ''
										// 						ORDER BY pos_name ASC ");
										// while($a_data_pos = $db->db_fetch_row($_sql_pos)){
										// 	$sel = ($a_data_pos[0] == trim($pos_id)) ? "selected":"";
										$_sql_pos = $sso->getPosition()["dataAll"];
										foreach ($_sql_pos as $a_data_pos) {
										?>
											<!-- <option value="<?php echo $a_data_pos[0]; ?>" <?php echo $sel; ?> ><?php echo $a_data_pos[1]; ?></option> -->
											<option value="<?php echo $a_data_pos["POS_NAME"]; ?>"><?php echo $a_data_pos["POS_NAME"]; ?></option>
										<?php
										}
										$db->query("USE " . $EWT_DB_NAME);
										?>
									</select>

								</div>
							</div>

							<div class="form-group row ">
								<label for="txt_org_list_pos_person" class="col-sm-12 control-label"><b><?php echo $txt_org_list_pos_person; ?> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<input type="text" class="form-control" placeholder="<?php echo $txt_org_list_pos_person; ?>" id="txt_org_list_pos_person" name="txt_org_list_pos_person" />
								</div>
							</div>

							<div class="form-group row ">
								<label for="txt_org_list_email" class="col-sm-12 control-label"><b><?php echo $txt_org_list_email; ?> <span class="text-danger"><?php /*<code>*</code>*/ ?></span> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<input type="text" class="form-control checkmail" placeholder="<?php echo $txt_org_list_email; ?>" id="txt_org_list_email" name="txt_org_list_email" required="required" />
									<span class="text-danger">
										<code>
											Ex. name@email.com
										</code>
									</span>
								</div>
							</div>

							<div class="form-group row ">
								<label for="txt_org_list_tel_in" class="col-sm-12 control-label"><b><?php echo $txt_org_list_tel_in; ?> <span class="text-danger"><?php /*<code>*</code>*/ ?></span> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<input type="text" class="form-control phone" placeholder="<?php echo $txt_org_list_tel_in; ?>" id="txt_org_list_tel_in" name="txt_org_list_tel_in" required="required" />
									<span class="text-danger">
										<code>
											Ex. 999-999-9999
										</code>
									</span>
								</div>
							</div>
							<div class="form-group row ">
								<label for="org_status" class="col-sm-12 control-label"><b><?php echo $txt_org_group_set_use; ?> <span class="text-danger"><?php /*<code>*</code>*/ ?></span> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="radio">
										<label><input type="radio" name="org_status" value="1" checked><?php echo $txt_org_status_y; ?>
											<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
										</label>
									</div>
									<div class="radio">
										<label><input type="radio" name="org_status" value="2"><?php echo $txt_org_status_n; ?>
											<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
										</label>
									</div>
								</div>
							</div>
							<div class="form-group row ">
								<label for="txt_org_list_image" class="col-sm-12 control-label"><b><?php echo $txt_org_list_image; ?> <span class="text-danger"><?php /*<code>*</code>*/ ?></span> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="file-upload-drag ">
										<div class="image-upload-wrap">
											<input class="file-upload-input" name="txt_org_list_image" id="txt_org_list_image" type="file" onchange="readURL(this);JSCheck_Img(this.id,this.value);" accept="image/*" />
											<div class="drag-icon">
												<i class="fas fa-cloud-upload-alt fa-5x"></i>
											</div>
											<div class="drag-text">
												<h4>Drag and Drop </h4>
											</div>
										</div>
										<div class="file-upload-content">
											<img class="file-upload-image" src="#" alt="your image" />
											<!--<div class="image-title-wrap">
											<button type="button" onclick="removeUpload();" class="remove-image"><i class="fas fa-trash-alt"></i> Remove </button>
											</div>-->
											<div style="padding-top:10px;text-align:left;">
												<button type="button" class="btn btn-danger  btn-circle  btn-sm " onclick="removeUpload();" data-toggle="tooltip" data-placement="top" title="Remove">
													<i class="far fa-trash-alt" aria-hidden="true"></i>
												</button>
											</div>
										</div>

									</div>

									<span class="text-danger">
										<code>
											ประเภทไฟล์ที่สามารถใช้ได้คือ <?php echo EwtTypefile('img'); ?>
										</code>
									</span>
									<br>
									<span class="text-danger"><code>
											ขนาดไฟล์ต้องไม่เกิน <?php echo EwtMaxfile('img'); ?> MB.
										</code>
									</span>
								</div>
							</div>

							<div class="form-group row">
								<hr>
								<div class="col-md-12 col-sm-12 col-xs-12">
									ดึงจาก Ldap:
									<br />
									<span class="text-danger">
										<code>
											หากดึงจาก Ldap จะไม่สามารถแก้ไข username และ password ได้
										</code>
									</span>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="radio">
										<label><input type="radio" name="ldap_use" value="0" checked> No
											<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
										</label>
									</div>
									<div class="radio">
										<label><input type="radio" name="ldap_use" value="1"> Yes
											<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
										</label>
									</div>
								</div>
							</div>

							<div class="form-group row userpass_section">
								<label for="txt_org_list_gen_user" class="col-sm-12 control-label"><b><?php echo $txt_org_list_gen_user; ?> <span class="text-danger"><?php /*<code>*</code>*/ ?></span> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<input type="text" autocomplete="off" class="form-control checklength checkusername" placeholder="<?php echo $txt_org_list_gen_user; ?>" id="txt_org_list_gen_user" name="txt_org_list_gen_user" required="required" pattern="^[a-zA-Z0-9]+$" title="ภาษาอังกฤษหรือตัวเลขเท่านั้น" minlength="8" maxlength="16" />
									<span class="text-danger">
										<code>
											กรอกข้อมูลเป็นภาษาอังกฤษหรือตัวเลข 8 - 16 ตัวอักษร
										</code>
									</span>
								</div>
							</div>

							<div class="form-group row userpass_section">
								<label for="txt_org_list_gen_pass" class="col-sm-12 control-label"><b><?php echo $txt_org_list_gen_pass; ?> <span class="text-danger"><?php /*<code>*</code>*/ ?></span> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<input type="password" autocomplete="new-password" class="form-control checklength checkpassword password" placeholder="<?php echo $txt_org_list_gen_pass; ?>" id="txt_org_list_gen_pass" name="txt_org_list_gen_pass" required="required" pattern="^[a-zA-Z0-9]+$" minlength="8" maxlength="16" />
									<span toggle="#txt_org_list_gen_pass" class="fas fa-fw fa-eye field-icon toggle-password text-dark"></span>
									<span class="text-danger">
										<code>
											กรอกข้อมูลเป็นภาษาอังกฤษหรือตัวเลข 8 - 16 ตัวอักษร
										</code>
									</span>
								</div>
							</div>

							<div class="form-group row userpass_section">
								<label for="txt_org_list_gen_pass_confirm" class="col-sm-12 control-label"><b><?php echo $txt_org_list_gen_pass_confirm; ?> <span class="text-danger"><?php /*<code>*</code>*/ ?></span> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<input type="password" autocomplete="new-password" class="form-control checklength checkpassword checkconfpass" placeholder="<?php echo $txt_org_list_gen_pass_confirm; ?>" id="txt_org_list_gen_pass_confirm" name="txt_org_list_gen_pass_confirm" required="required" pattern="^[a-zA-Z0-9]+$" minlength="8" maxlength="16" />
									<span toggle="#txt_org_list_gen_pass_confirm" class="fas fa-fw fa-eye field-icon toggle-password text-dark"></span>
									<span class="text-danger">
										<code>
											กรอกข้อมูลเป็นภาษาอังกฤษหรือตัวเลข 8 - 16 ตัวอักษร
										</code>
									</span>
								</div>
							</div>

							<div class="form-group row ">
								<hr>
								<div class="col-md-12 col-sm-12 col-xs-12">
									วันที่สิ้นสุดการเป็นสมาชิก:
									<br />
									<span class="text-danger">
										<code>
											หากสิ้นสุดจะไม่สามารถใช้งาน user ดังกล่าวได้
										</code>
									</span>
								</div>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="radio">
										<label><input type="radio" name="expire_use" value="0" checked> ไม่มีวันหมดอายุ
											<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
										</label>
									</div>
									<div class="radio">
										<label><input type="radio" name="expire_use" value="1"> มีวันหมดอายุ
											<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
										</label>
									</div>
								</div>
							</div>

							<div class="form-group row userexpire_section" hidden>
								<?php /*
								<label for="user_expire" class="col-sm-12 control-label"><b>เลือกวันที่สิ้นสุด <span class="text-danger">
								</span> :</b></label>
								*/ ?>
								<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 col-xs-12 input-group date datepicker" id="datetimepicker2">
									<input name="user_expire" id="user_expire" type="text" placeholder="__/__/____" class="form-control form-control-sm " value="">
									<span class="input-group-addon">
										<a href="#date" onclick="return show_calendar('form_main.user_expire');">
											<i class="far fa-calendar-alt"></i>
										</a>
									</span>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="modal-footer ">
					<div class="col-md-12 col-sm-12 col-xs-12 text-center">
						<button onclick="JQAdd_OrgUser($('#form_main'));" type="button" class="btn btn-success  btn-ml ">
							<i class="fas fa-save"></i>&nbsp;<?php echo $txt_ewt_save; ?>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<!-- Custom js -->
<script type="text/javascript">
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function(e) {
				$('.image-upload-wrap').hide();
				$('.file-upload-image').attr('src', e.target.result);
				$('.file-upload-content').show();
				$('.image-title').html(input.files[0].name);
			};
			reader.readAsDataURL(input.files[0]);
		} else {
			removeUpload();
		}
	}

	function removeUpload() {
		$('.file-upload-input').replaceWith($('.file-upload-input').clone());
		$('.file-upload-content').hide();
		$('.image-upload-wrap').show();
	}
	$('.image-upload-wrap').bind('dragover', function() {
		$('.image-upload-wrap').addClass('image-dropping');
	});
	$('.image-upload-wrap').bind('dragleave', function() {
		$('.image-upload-wrap').removeClass('image-dropping');
	});

	$(document).ready(function() {
		$('.selectpicker').selectpicker();

		$('input[name="ldap_use"]').change(function() {
			var ldap_use = $(this).val();

			if (ldap_use == "1") {
				$(".userpass_section").prop("hidden", true);
			} else {
				$(".userpass_section").prop("hidden", false);
			}
		})

		$('input[name="expire_use"]').change(function() {
			var expire_use = $(this).val();

			if (expire_use == "1") {
				$(".userexpire_section").prop("hidden", false);
			} else {
				$(".userexpire_section").prop("hidden", true);
			}
		})

		$('.datepicker').datepicker({
			format: 'dd/mm/yyyy',
			language: 'th-th',
			//thaiyear: true,
			leftArrow: '<i class="fas fa-angle-double-left"></i>',
			rightArrow: '<i class="fas fa-angle-double-right"></i>',
		})

	});

	$(".toggle-password").click(function() {
		$(this).toggleClass("fa-eye fa-eye-slash");
		var input = $($(this).attr("toggle"));
		if (input.attr("type") == "password") {
			input.attr("type", "text");
		} else {
			input.attr("type", "password");
		}
	});

	function CKupdate() {
		for (instance in CKEDITOR.instances)
			CKEDITOR.instances[instance].updateElement();
	}

	function JQCheck_Cate(form) {
		var name = form.attr('name');
		var check = $('input:checkbox[name=' + name + ']:checked').val();
		if (check == 'Y') {
			$('#category_sub').attr("disabled", false);
		} else {
			$('#category_sub').attr("disabled", true);
		}
		console.log(check);
	}

	function ChkIdCard(text){
		var id_card = $("#"+text).val().length;
		if(id_card != 13){
			$("#"+text).focus();
			$("#list_idcard").text('กรุณากรอกข้อมูลให้ครบ 13 ตัว');
		}
		console.log(id_card);
	}

	function JQAdd_OrgUser(form) {
		CKupdate();

		//disable check temporary
		//var fail = CKSubmitData(form);
		var fail = false;

		if (fail == false) {
			var action = form.attr('action');
			var method = form.attr('method');
			var formData = false;
			if (window.FormData) {
				formData = new FormData(form[0]);
			}

			$.confirm({
				title: '<?php echo $txt_org_add; ?>',
				content: '<?php echo $txt_ewt_confirm_alert; ?>',
				//content: 'url:form.html',
				boxWidth: '30%',
				icon: 'far fa-question-circle',
				theme: 'modern',
				buttons: {
					confirm: {
						text: '<?php echo $txt_ewt_confirm_submit; ?>',
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

									$.alert({
										title: '',
										theme: 'modern',
										content: '<?php echo $txt_ewt_action_alert; ?>',
										boxWidth: '30%',
										onAction: function() {
											//console.log(data);	
											//location.reload(true);	
											var Newdata = JSON.stringify(eval("(" + data + ")"));
											var Obj = jQuery.parseJSON(Newdata);
											//console.log(data);											
											//console.log(Obj);	
											//alert("URL:"+Obj.url);				

											if (Obj.err) {
												$.alert({
													title: 'Error',
													content: Obj.message,
													icon: 'fa fa-exclamation-circle',
													theme: 'modern',
													type: 'orange',
													closeIcon: false,
													buttons: {
														close: {
															text: 'ปิด',
															btnClass: 'btn-orange',
														}
													}

												});
												return false;
											}

											if (Obj.warn) {
												$.alert({
													title: 'Warning',
													content: Obj.message,
													icon: 'fa fa-exclamation-circle',
													theme: 'modern',
													type: 'orange',
													closeIcon: false,
													buttons: {
														close: {
															text: 'ปิด',
															btnClass: 'btn-orange',
														}
													}

												});
												return false;
											}

											if (Obj.url) {
												window.location.href = Obj.url;
											}
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
						text: '<?php echo $txt_ewt_cancel; ?>',
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