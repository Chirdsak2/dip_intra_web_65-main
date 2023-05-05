<?php include("../EWT_ADMIN/comtop_pop.php"); ?>

<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_add_km_point') ?>" enctype="multipart/form-data">
	<input type="hidden" name="proc" id="proc" value="Add_Km_Point">

	<div class="container">
		<div class="modal-dialog modal-lg">

			<div class="modal-content">
				<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
					<button type="button" class="close" onclick="$('#box_popup').fadeOut();"><i class="far fa-times-circle fa-1x color-white"></i></button>
					<h4 class="modal-title color-white"><i class="fas fa-plus-circle"></i> <?php echo 'เพิ่ม KM'; ?></h4>
				</div>

				<div class="modal-body">
					<div class="card ">
						<div class="card-body">
							<div class="form-group row ">
								<label for="ec_name" class="col-sm-12 control-label"><b><?php echo ' ชื่อ KM'; ?> <span class="text-danger"><code>*</code></span> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<input type="text" class="form-control" placeholder="<?php echo 'ชื่อ KM'; ?>" id="km_name" name="km_name" required="required">
								</div>
							</div>
							<div class="form-group row">
								<div class="col-md-12 col-sm-12 col-xs-12">
									<label for="ec_detail" class="col-sm-12 control-label"><b><?php echo 'คะแนน KM'; ?> <span class="text-danger"><code>*</code></span> :</b></label>
									<input type="number" class="form-control" placeholder="<?php echo 'คะแนน KM'; ?>" id="km_point" name="km_point" required="required">
								</div>
							</div>

							<div class="form-group row">
								<label for="ec_images" class="col-sm-12 control-label"><b><?php echo ' รูปภาพ'; ?> <span class="text-danger"><code>*</code></span> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="file-upload-drag ">
										<div class="image-upload-wrap">
											<input type="file" class="file-upload-input" name="km_image" id="km_image" type="file" onchange="readURL(this);JSCheck_Img(this.id,this.value);" accept="image/*" required="required">
											<div class="drag-icon">
												<i class="fas fa-cloud-upload-alt fa-5x"></i>
											</div>
											<div class="drag-text">
												<h4>Drag and Drop your files or Browse</h4>
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

				<div class="modal-footer ">
					<div class="col-md-12 col-sm-12 col-xs-12 text-center">
						<button onclick="JQAdd_KM_POINT($('#form_main'));" type="button" class="btn btn-success  btn-ml">
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

	function JQAdd_KM_POINT(form) {
		var fail = CKSubmitData(form);
		if (fail == false) {
			var action = form.attr('action');
			var method = form.attr('method');
			var formData = false;
			if (window.FormData) {
				formData = new FormData(form[0]);
			}
			$.confirm({
				title: '<?php echo "เพิ่ม KM"; ?>',
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
						}
					}
				},
				animation: 'scale',
				type: 'blue'
			});
		}
	}
</script>