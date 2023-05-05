<?php
include("../EWT_ADMIN/comtop_pop.php");

$id = (int)(!isset($_GET['id']) ? '' : $_GET['id']);
$cat_id = (int)(!isset($_GET['cat_id']) ? '' : $_GET['cat_id']);
if (empty($id)) {
	exit;
}
$_sql = $db->query("SELECT * FROM km_point WHERE id = '{$id}'");
$a_data = $db->db_fetch_array($_sql);
$dir_base = "../ewt/" . $_SESSION['EWT_SUSER'] . "/assets/img/icon/";
?>

<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_edit_km_point') ?>" enctype="multipart/form-data">
	<input type="hidden" name="proc" id="proc" value="Edit_Km_Point">
	<input type="hidden" name="id" id="id" value="<?php echo $id; ?>">
	<input type="hidden" name="km_image_old" id="km_image_old" value="<?php echo $a_data['km_image']; ?>">
	<div class="container">
		<div class="modal-dialog modal-lg">

			<div class="modal-content">
				<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
					<button type="button" class="close" onclick="$('#box_popup').fadeOut();"><i class="far fa-times-circle fa-1x color-white"></i></button>
					<h4 class="modal-title color-white"><i class="fas fa-plus-circle"></i> <?php echo 'แก้ไข KM'; ?></h4>
				</div>

				<div class="modal-body">
					<div class="card ">
						<div class="card-body">
							<div class="form-group row ">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label for="km_status"><b><?php echo "สถานะการเปิด/ปิดการใช้งาน"; ?> </b></label> :
									<div>
										<label class="switch">
											<input type="checkbox" name="km_status" id="km_status" <?php echo ($a_data['km_status'] == 'Y') ? 'checked="checked"' : null; ?> value="<?php echo $a_data['km_status']; ?>">
											<span class="slider round"></span>
											<span class="absolute-no">NO</span>
										</label>
									</div>
								</div>
							</div>
							<div class="form-group row ">
								<label for="ec_name" class="col-sm-12 control-label"><b><?php echo ' ชื่อ KM'; ?> <span class="text-danger"><code>*</code></span> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<input type="text" class="form-control" placeholder="<?php echo 'ชื่อ KM'; ?>" id="km_name" name="km_name" value="<?php echo $a_data['km_name']; ?>" required="required">
								</div>
							</div>
							
							<?php if($id == 6) { ?>
							<div class="form-group row ">
								<label for="ec_name" class="col-sm-12 control-label"><b><?php echo 'หมวด Article'; ?> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
								<select class=" selectpicker form-control " name="km_category" id="km_category" data-live-search="true" >
									<option disabled selected hidden>เลือกหมวด</option>
									<?php
									$_sql_article = $db->query(" SELECT c_id, c_name FROM article_group WHERE c_parent = '0' ");
									?>
									<?php
									while($a_data_article = $db->db_fetch_array($_sql_article)){
										$data = ($a_data_article["c_id"] == $cat_id) ? "selected":"";
									
									?>
									<option value="<?php echo $a_data_article["c_id"];?>" <?php echo $data;?> ><?php echo $a_data_article["c_name"];?></option>
									<?php
										}
									?>		  
								</select>
								</div>
							</div>
							<?php } ?>
							
							<div class="form-group row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label for="ec_detail" class="col-sm-12 control-label"><b><?php echo 'คะแนน KM'; ?> <span class="text-danger"><code>*</code></span> :</b></label>
									<input type="number" class="form-control" placeholder="<?php echo 'คะแนน KM'; ?>" id="km_point" name="km_point" value="<?php echo $a_data['km_point']; ?>" required="required">
								</div>
							</div>

							<div class="form-group row ">
								<label for="km_image" class="col-sm-12 control-label"><b><?php echo 'รูปภาพ'; ?> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="checkbox">
										<label><input type="checkbox" name="km_image" id="km_image" value="1" onclick="JSChange(this.id);">
											<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>เปลี่ยนรูปภาพ
										</label>
									</div>
									<div class="file-upload-drag " id="old-image">
										<?php
										if (file_exists($dir_base . $a_data['km_image']) && $a_data['km_image'] != '') {
										?>
											<img src="<?php echo $dir_base . $a_data['km_image']; ?>" alt="" class="img-rounded img-responsive file-upload-image-old">
										<?php } ?>
									</div>

									<div class="file-upload-drag " id="news-image" style="display:none;">
										<div class="image-upload-wrap">
											<input type="file" class="file-upload-input" name="km_image" id="km_image" onchange="readURL(this);JSCheck_Img(this.id,this.value);" accept="image/*" />
											<div class="drag-icon">
												<i class="fas fa-cloud-upload-alt fa-5x"></i>
											</div>
											<div class="drag-text">
												<h4>Drag and Drop your files or Browse</h4>
											</div>
										</div>
										<div class="file-upload-content">
											<img class="file-upload-image" src="#" alt="your image" />
											<div style="padding-top:10px;text-align:left;">
												<button type="button" class="btn btn-danger  btn-circle  btn-sm " onclick="removeUpload();" data-toggle="tooltip" data-placement="top" title="Remove">
													<i class="far fa-trash-alt" aria-hidden="true"></i>
												</button>
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
										<br>
										<span class="text-danger">
											<code>
												ขนาดของภาพที่เหมาะสมควรเป็น 500x500 px
											</code>
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="modal-footer ">
					<div class="col-md-12 col-sm-12 col-xs-12 text-center">
						<button onclick="JQEdit_KM_POINT($('#form_main'));" type="button" class="btn btn-success  btn-ml">
							<i class="fas fa-save"></i>&nbsp;<?php echo $txt_ewt_save; ?>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>
<script>
	$(document).ready(function() {
		var img = $('#ec_images_old').val();
		if (img == '' || img == 'undefined') {
			$('#news-image').show();
			$('#old-image').hide();
			$('.checkbox').hide();
		}
		

	$('.selectpicker').selectpicker();		
	});

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

	function JSChange(ID) {
		if ($('#' + ID).is(':checked') == true) {
			$('#old-image').hide();
			$('#news-image').show();
		} else if ($('#' + ID).is(':checked') == false) {
			$('#news-image').hide();
			$('#old-image').show();
		}
	}

	function JQEdit_KM_POINT(form) {
		var fail = CKSubmitData(form);
		if (fail == false) {
			var action = form.attr('action');
			var method = form.attr('method');
			var formData = false;
			if (window.FormData) {
				formData = new FormData(form[0]);
			}
			$.confirm({
				title: '<?php echo "แก้ไข KM"; ?>',
				content: 'คุณต้องการบันทึกข้อมูลนี้หรือไม่',
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
									$.alert({
										title: 'บันทึกข้อมูลเรียบร้อย',
										theme: 'modern',
										icon: 'far fa-check-circle',
										content: 'Success! ',
										type: 'green',
										typeAnimated: true,
										boxWidth: '30%',
										buttons: {
											ok: {
												btnClass: 'btn-green'
											}
										},
										onAction: function() {
											location.reload(true);
											$('#box_popup').fadeOut();
										}
									});
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