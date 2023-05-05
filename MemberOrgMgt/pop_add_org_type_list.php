<?php
include("../EWT_ADMIN/comtop_pop.php");

//$faq_cid = (int)(!isset($_GET['faq_cid']) ? 0 : $_GET['faq_cid']);
$db->query("USE " . $EWT_DB_USER);
?>

<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_add_org_type_list') ?>" enctype="multipart/form-data">
	<input type="hidden" name="proc" id="proc" value="Add_OrgUser">

	<div class="container">
		<div class="modal-dialog modal-lg">

			<div class="modal-content ">
				<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
					<button type="button" class="close" onclick="$('#box_popup').fadeOut();"><i class="far fa-times-circle fa-1x  color-white"></i></button>
					<h4 class="modal-title color-white"> <i class="fas fa-plus-circle"></i> <?php echo "เพิ่มข้อมูลประเภทบุคลากร"; ?></h4>
				</div>

				<div class="modal-body">
					<div class="card ">
						<div class="card-body">
							<div class="form-group row">
								<label for="txt_org_list_type" class="col-sm-12 control-label"><b><?php echo "ประเภทบุคลากร"; ?> <span class="text-danger"><code>*</code></span> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<input type="text" class="form-control" placeholder="<?php echo "ประเภทบุคลากร"; ?>" id="txt_org_list_type" name="txt_org_list_type" required="required" />
								</div>
							</div>


							<div class="form-group row">
								<label for="txt_org_list_image" class="col-sm-12 control-label"><b><?php echo "Icon ประเภทบุคลากร"; ?> <span class="text-danger"><?php /*<code>*</code>*/ ?></span> :</b></label>
								<div class="col-md-12 col-sm-12 col-xs-12">
									<div class="file-upload-drag ">
										<div class="image-upload-wrap">
											<input class="file-upload-input" name="txt_org_list_image" id="txt_org_list_image" type="file" onchange="readURL(this);JSCheck_Img(this.id,this.value);" accept="image/*">
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

	function JQAdd_OrgUser(form) {
		CKupdate();

		//disable check temporary
		var fail = CKSubmitData(form);
		//var fail = false;

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
				boxWidth: '50%',
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
										boxWidth: '50%',
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