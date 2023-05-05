<?php
session_start();
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
include("../language.php");
include("../language/language_TH.php");
include("../lib/config_path.php");


$vdo_cid = (int)(!isset($_GET['vdo_cid']) ? 0 : $_GET['vdo_cid']);
$vdo_id = (int)(!isset($_GET['vdo_id']) ? 0 : $_GET['vdo_id']);


$_sql = $db->query("SELECT * FROM vdo_list  WHERE  vdo_id = '{$vdo_id}' ");
$a_data = $db->db_fetch_array($_sql);

$sql_Imsize = "SELECT * FROM site_info";
$query_Imsize = $db->query($sql_Imsize);
$rec_Imsize = $db->db_fetch_array($query_Imsize);
?>

<form id="form_main" name="form_main" method="POST" action="<?= getLocation('func_edit_vdo') ?>" enctype="multipart/form-data">
	<input type="hidden" name="proc" id="proc" value="Edit_Vdo">
	<input type="hidden" name="vdo_file_old" id="vdo_file_old" value="<?= $a_data['vdo_filename']; ?>">
	<input type="hidden" name="vdo_imagefile_old" id="vdo_imagefile_old" value="<?= $a_data['vdo_image']; ?>">

	<div class="container">
		<div class="modal-dialog modal-lg">

			<div class="modal-content">
				<div class="modal-header ">
					<button type="button" class="close" onclick="$('#box_popup').fadeOut();"><i class="far fa-times-circle fa-1x"></i></button>
					<h4 class="modal-title"><?= $txt_vdo_edit_vdo; ?></h4>
				</div>

				<div class="modal-body">

					<div class="card ">
						<div class="scrollbar scrollbar-near-moon thin">
							<div class="card-header ewt-bg-success m-b-sm">
								<div class="card-title text-left"><b></b></div>
							</div>

							<div class="card-body">

								<div class="form-group row ">
									<label for="vdo_name" class="col-sm-12 control-label"><b><?= $txt_vdo_name; ?> <span class="text-danger"><code>*</code></span> :</b></label>
									<div class="col-md-12 col-sm-12 col-xs-12">
										<input class="form-control" placeholder="<?= $txt_vdo_name; ?>" name="vdo_name" type="text" id="vdo_name" value="<?= $a_data['vdo_name']; ?>" required="required" />
									</div>
								</div>
								<div class="form-group row ">
									<label for="vdo_detail" class="col-sm-12 control-label"><b><?= $txt_vdo_detail; ?> <span class="text-danger"><code>*</code></span> :</b></label>
									<div class="col-md-12 col-sm-12 col-xs-12">
										<textarea class="form-control" placeholder="<?= $txt_vdo_detail; ?>" rows="6" id="vdo_detail" name="vdo_detail" required="required"><?= $a_data['vdo_detail']; ?></textarea>
									</div>
								</div>
								<div class="form-group row ">
									<label for="vdo_creator" class="col-sm-12 control-label"><b><?= $txt_vdo_creator; ?> :</b></label>
									<div class="col-md-12 col-sm-12 col-xs-12">
										<input class="form-control" placeholder="<?= $txt_vdo_creator; ?>" name="vdo_creator" type="text" id="vdo_creator" value="<?= $a_data['vdo_info']; ?>" />
									</div>
								</div>
								<div class="form-group row ">
									<label for="vdo_group" class="col-sm-12 control-label"><b><?= $txt_vdo_cate; ?> <span class="text-danger"><code>*</code></span> :</label>
									<div class="col-md-12 col-sm-12 col-xs-12">
										<select name="vdo_group" id="vdo_group" class="form-control" required="required">
											<option value="" selected="" disabled="disabled"><?= $txt_vdo_select_cate; ?></option>
											<?php
											$_sql_cate = $db->query("SELECT vdog_id,vdog_name 
FROM vdo_group 
ORDER BY vdog_id ASC ");
											while ($a_data_faq = $db->db_fetch_row($_sql_cate)) {
												$sel = ($a_data_faq[0] == trim($a_data['vdo_group'])) ? "selected" : "";
											?>
												<option value="<?= $a_data_faq[0]; ?>" <?= $sel; ?>><?= $a_data_faq[1]; ?></option>
											<?php
											}
											?>
										</select>
									</div>
								</div>

								<div class="form-group row ">
									<label for="vdo_format" class="col-sm-12 control-label"><b><?= $txt_vdo_format; ?> <span class="text-danger"><code>*</code></span> :</b></label>
									<div class="col-md-12 col-sm-12 col-xs-12">
										<div class="radio">
											<label><input type="radio" name="vdo_format" id="vdo_format1" value="1" onclick="JQCheck_Format($('#vdo_format1'));" <?php if ($a_data['vdo_show_vdo'] == '1') {
																																										echo 'checked="checked"';
																																									} ?> /><?= "ประเภทไฟล์วีดีโอ"; ?>
												<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
											</label>
										</div>
										<div class="radio">
											<label><input type="radio" name="vdo_format" id="vdo_format2" value="2" onclick="JQCheck_Format($('#vdo_format2'));" <?php if ($a_data['vdo_show_vdo'] == '2') {
																																										echo 'checked="checked"';
																																									} ?> /><?= "Url Youtube"; ?>
												<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
											</label>
										</div>
									</div>
								</div>

								<!--<div class="form-group row">
      <div class="col-md-12 col-sm-12 col-xs-12" id="filevideo1" >
        <label for="vdo_filesource"><?php //echo "เลือกไฟล์วิดีโอ";
									?><span class="text-danger">*</span> : </label>
       	  <select name="vdo_filesource" class="form-control" onChange="if(this.value=='com'){
		                              document.myForm.vdo_file1.style.display='';
									  document.myForm.vdo_file2.style.display='none';
									  document.all.sfile.style.display='none';
									}else{ 
		                              document.myForm.vdo_file1.style.display='none';
									  document.myForm.vdo_file2.style.display='';
									  document.all.sfile.style.display='';
									}
									
									">
	      <option value="com">ไฟล์จากเครื่อง</option> 
	      <option value="web">ไฟล์จากระบบ</option>  
</select>
</div>
</div>

<div class="form-group row " id="filevideo">
<label for="vdo_filesource"><? //=$txt_vdo_file_vdo;
							?><span class="text-danger">*</span> : </label>
<div class="col-md-12 col-sm-12 col-xs-12">
			<input name="vdo_file1" type="file" class="form-control" >
			<input name="vdo_file2" type="text"  size="30"  style="display:none;" class="form-control">	    
			<a href="#browse" onClick="win2 = window.open('../FileMgt/website_main.php?stype=link&Flag=Link&o_value=window.opener.document.myForm.vdo_file2.value','WebsiteLink','top=100,left=100,width=800,height=600,resizable=1,status=0');">
			<img  id="sfile" src="../images/i_folder_on.jpg" width="16" height="16" border="0" align="absmiddle"  style="display:none;" ></a>	    
			
</div>	
</div>-->
								<div class="form-group row " id="filevideo" <?php if ($a_data['vdo_show_vdo'] == '2') {
																				echo 'style="display:none;"';
																			} ?>>
									<label for="vdo_file"><?= $txt_vdo_file_vdo; ?><span class="text-danger">*</span> : </label>
									<div class="col-md-12 col-sm-12 col-xs-12">
										<input name="vdo_file" id="vdo_file" type="file" class="form-control file_upload" onchange="JSCheck_Vdo(this.id,this.value);" />
										<input name="vdo_filesource" id="vdo_filesource" type="hidden" value="com">
										<?php
										if (!empty($a_data['vdo_filename'])) {
										?>
											<span><?= $a_data['vdo_filename']; ?></span><br>
										<?php } ?>
										<span class="text-danger">
											<code>
												ประเภทไฟล์ที่สามารถใช้ได้คือ <?= EwtTypefile('vdo'); ?>
											</code>
										</span>
										<br>
										<span class="text-danger"><code>
												ขนาดไฟล์ต้องไม่เกิน <?= EwtMaxfile('vdo'); ?> MB.
											</code></span>
										<!--<span class="text-danger">
* ประเภทไฟล์ที่สามารถใช้ได้คือ mp4 เท่านั้น <br>
* ขนาดไฟล์ต้องไม่เกิน <?= '10'; //$sql_chk["site_info_max_file"];
						?> MB.</span>-->
									</div>
								</div>
								<div class="form-group row " id="fileyoutube" <?php if ($a_data['vdo_show_vdo'] == '1') {
																					echo 'style="display:none;"';
																				} ?>>
									<label for="vdo_youtube"><?= $txt_vdo_youtube; ?><span class="text-danger">*</span> : </label>
									<div class="col-md-12 col-sm-12 col-xs-12">
										<input name="vdo_youtube" id="vdo_youtube" type="text" class="form-control" value="<?= $a_data['vdo_fileyoutube']; ?>" />
										<span class="text-danger">
											<code>
												* Ex. https://www.youtube.com/watch?v=Yx5ew-ck4B8
											</code>
										</span>
									</div>
								</div>

								<div class="form-group row" id="fileimage">
									<div class="col-md-12 col-sm-12 col-xs-12">
										<label for="vdo_imagefile"><?= $txt_vdo_img; ?> : </label>
										<input name="vdo_imagefile" id="vdo_imagefile" type="file" class="form-control file_upload" onchange="JSCheck_Img(this.id,this.value);" />
										<?php
										if (!empty($a_data['vdo_image'])) {
										?>
											<span><?= $a_data['vdo_image']; ?></span><br><?php } ?>
										<span class="text-danger">
											<code>
												ประเภทไฟล์ที่สามารถใช้ได้คือ <?= EwtTypefile('img'); ?>
											</code>
										</span>
										<br>
										<span class="text-danger"><code>
												ขนาดไฟล์ต้องไม่เกิน <?= EwtMaxfile('img'); ?> MB.
											</code></span>
											<br>
											<span class="text-danger"><code>ขนาดที่เหมาะสม 16 : 9 หรือ ประมาณ 1,366 x 768 px</code></span>
										<!--<span class="text-danger">
* ประเภทไฟล์ที่สามารถใช้ได้คือ jpg,gif,png เท่านั้น <br>
* ขนาดไฟล์ต้องไม่เกิน <?= '10'; //$sql_chk["site_info_max_file"];
						?> MB.</span>
</div>
</div>-->

									</div>
								</div>
							</div>
							<input type="hidden" name="vdo_creator" id="vdo_creator" value="<?= $_SESSION['EWT_SMUSER']; ?>">
							<input type="hidden" name="vdo_id" id="vdo_id" value="<?= $a_data['vdo_id']; ?>">
							<div class="modal-footer ">
								<div class="col-md-12 col-sm-12 col-xs-12 text-center">
									<button onclick="JQEdit_vdo($('#form_main'));" type="button" class="btn btn-success  btn-ml ">
										<i class="fas fa-save"></i>&nbsp;<?= $txt_ewt_save; ?>
									</button>
								</div>
							</div>
						</div>

					</div>

				</div>
			</div>
</form>

<!-- Custom js -->
<script type="text/javascript" src="<?= $IMG_PATH; ?>assets/js/custom.js"></script>
<script>
	function JQCheck_Cate(form) {
		var name = form.attr('name');
		var check = $('input:checkbox[name=' + name + ']:checked').val();
		if (check == 'Y') {
			$('#category_parent').attr("disabled", false);
			$('#category_parent').attr("required", false);
		} else {
			$('#category_parent').attr("disabled", true);
			$('#category_parent').attr("required", true);
		}
		console.log(check);
	}

	function JQCheck_Format(form) {
		var name = form.attr('name');
		var check = $('input:radio[name=' + name + ']:checked').val();
		console.log(check);
		if (check == '1') {
			$('#filevideo').show();
			$('#vdo_file').show();
			$('#fileyoutube').hide();
			$('#vdo_youtube').hide();
			$('#vdo_youtube').attr("required", false);
			$('#vdo_file').attr("required", true);
			$('#fileimage').show();
		} else if (check == '2') {
			$('#fileyoutube').show();
			$('#vdo_youtube').show();
			$('#filevideo').hide();
			$('#vdo_file').hide();
			$('#fileimage').hide(); 
			$('#vdo_file').attr("required", false);
			$('#vdo_youtube').attr("required", true);
		}
	}

	function JQEdit_vdo(form) {

		var fail = CKSubmitData(form);
		if (fail == false) {
			var action = form.attr('action');
			var method = form.attr('method');
			var formData = false;
			if (window.FormData) {
				formData = new FormData(form[0]);
			}
			$.confirm({
				title: '<?= $txt_vdo_edit_vdo; ?>',
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
								data: formData,
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