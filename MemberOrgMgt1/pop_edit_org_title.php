<?php
include("../EWT_ADMIN/comtop_pop.php");
$sso = new sso();
$PREFIX_ID = (int)(!isset($_GET['PREFIX_ID']) ? 0 : $_GET['PREFIX_ID']);

$s_sql	= "SELECT * FROM USR_PREFIX WHERE PREFIX_ID = '{$PREFIX_ID}'";
$a_data	= $sso->getFetch($s_sql);
?>

<form id="form_main" name="form_main" method="POST" action="<?= getLocation('func_edit_org_title') ?>" enctype="multipart/form-data">
	<input type="hidden" name="proc" id="proc" value="Edit_Org_Title">
	<input type="hidden" name="PREFIX_ID" id="PREFIX_ID" value="<?= $a_data['PREFIX_ID']; ?>">
	<div class="container">
		<div class="modal-dialog modal-lg">

			<div class="modal-content ">
				<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
					<button type="button" class="close" onclick="$('#box_popup').fadeOut();"><i class="far fa-times-circle fa-1x  color-white"></i></button>
					<h4 class="modal-title color-white"> <i class="fas fa-plus-circle"></i> <?= $txt_org_title_edit; ?></h4>
				</div>

				<div class="modal-body">

					<div class="card ">
						<div class="scrollbar scrollbar-near-moon thin">
							<div class="card-body">

								<div class="form-group row ">
									<label for="org_title_name" class="col-sm-12 control-label"><b><?= $txt_org_title_name; ?> <span class="text-danger"><code>*</code></span> :</b></label>
									<div class="col-md-12 col-sm-12 col-xs-12">
										<textarea class="form-control" placeholder="<?= $txt_org_title_name; ?>" rows="6" id="org_title_name" name="org_title_name" required="required"><?= $a_data['PREFIX_TH']; ?></textarea>
									</div>
								</div>

								<div class="form-group row ">
									<label for="org_title_use" class="col-sm-12 control-label"><b><?= $txt_org_title_set_use; ?> <span class="text-danger"><code>*</code></span> :</b></label>
									<div class="col-md-12 col-sm-12 col-xs-12">
										<div class="radio">
											<label><input type="radio" name="org_title_use" value="Y" checked><?= $txt_org_status_y; ?>
												<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
											</label>
										</div>
										<div class="radio">
											<label><input type="radio" name="org_title_use" value="N"><?= $txt_org_status_n; ?>
												<span class="cr"><i class="cr-icon fas fa-check color-ewt"></i></span>
											</label>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="modal-footer ">
						<div class="col-md-12 col-sm-12 col-xs-12 text-center">
							<button onclick="JQEdit_Org_Group($('#form_main'));" type="button" class="btn btn-success  btn-ml ">
								<i class="fas fa-save"></i>&nbsp;<?= $txt_ewt_save; ?>
							</button>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<script>
	function JQEdit_Org_Group(form) {

		var fail = CKSubmitData(form);
		if (fail == false) {
			var action = form.attr('action');
			var method = form.attr('method');
			var formData = false;
			if (window.FormData) {
				formData = new FormData(form[0]);
			}
			$.confirm({
				title: '<?= $txt_org_title_edit; ?>',
				content: '<?= $txt_ewt_confirm_alert; ?>',
				//content: 'url:form.html',
				boxWidth: '30%',
				icon: 'far fa-question-circle',
				theme: 'modern',
				buttons: {
					confirm: {
						text: '<?= $txt_ewt_confirm_submit; ?>',
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
									console.log(data);
									$.alert({
										title: '',
										theme: 'modern',
										content: '<?= $txt_ewt_action_alert; ?>',
										boxWidth: '30%',
										onAction: function() {
											document.location.reload();
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
						text: '<?= $txt_ewt_cancel; ?>',
						action: function() {
							$('#box_popup').fadeOut();
						}
					}
				},
				animation: 'scale',
				type: 'blue'

			});
		}

	}
</script>