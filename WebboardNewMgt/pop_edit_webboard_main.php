<?php
include("../EWT_ADMIN/comtop_pop.php");
$c_id = (int)(!isset($_GET['c_id']) ? '' : $_GET['c_id']);
if (empty($c_id)) {
	exit;
}
$_sql = $db->query("SELECT c_id,c_use,c_name,c_detail FROM w_cate WHERE c_id = '{$c_id}'");
$a_data = $db->db_fetch_array($_sql);
?>

<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_edit_webboard_main') ?>" enctype="multipart/form-data">
	<input type="hidden" name="proc" id="proc" value="Edit_Webboard_Main">
	<input type="hidden" name="c_id" id="c_id" value="<?php echo $c_id; ?>">
	<div class="container">
		<div class="modal-dialog modal-lg">

			<div class="modal-content">
				<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
					<button type="button" class="close" onclick="$('#box_popup').fadeOut();"><i class="far fa-times-circle fa-1x color-white"></i></button>
					<h4 class="modal-title color-white"><i class="fas fa-plus-circle"></i> <?php echo 'แก้ไขหมวดกระทู้'; ?></h4>
				</div>

				<div class="modal-body">
					<div class="card ">
						<div class="card-body">
							<div class="form-group row ">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label for="km_status"><b><?php echo "สถานะการเปิด/ปิดการใช้งาน"; ?> </b></label> :
									<div>
										<label class="switch">
											<input type="checkbox" name="c_use" id="c_use" <?php echo ($a_data['c_use'] == 'Y') ? 'checked="checked"' : null; ?> value="<?php echo $a_data['c_use']; ?>">
											<span class="slider round"></span>
											<span class="absolute-no">NO</span>
										</label>
									</div>
								</div>
							</div>
							<div class="form-group row ">
								<label for="c_name" class="col-sm-12 control-label"><b><?php echo 'ชื่อหมวด'; ?> <span class="text-danger"><code>*</code></span> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<input type="text" class="form-control" placeholder="<?php echo 'ชื่อหมวด'; ?>" name="c_name" id="c_name" value="<?php echo $a_data['c_name']; ?>" required="required">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label for="c_detail" class="col-sm-12 control-label"><b><?php echo 'รายละเอียดหมวด'; ?> <span class="text-danger"><code>*</code></span> :</b></label>
									<textarea rows="4" cols="50" class="form-control" placeholder="<?php echo 'รายละเอียดหมวด'; ?>" name="c_detail" id="c_detail" required="required"><?php echo $a_data['c_detail']; ?></textarea>
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
				title: '<?php echo "แก้ไขหมวดกระทู้"; ?>',
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