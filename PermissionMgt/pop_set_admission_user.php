<?php
include("../EWT_ADMIN/comtop_pop.php");
$db->query("USE " . $EWT_DB_USER);

$pu_id  = (int)(!isset($_GET['pu_id']) ? '' : $_GET['pu_id']);
$p_id 	= (int)(!isset($_GET['p_id']) ? '' : $_GET['p_id']);
$s_type =  htmlentities(trim($_GET['s_type']), ENT_NOQUOTES);
$UID   	= $_SESSION['EWT_SUID'];
$p_type =  htmlentities(trim($_GET['p_type']), ENT_NOQUOTES);
$s_permission =  htmlentities(trim($_GET['s_permission']), ENT_NOQUOTES);

$_sql_item = $db->query("SELECT * FROM web_permission
LEFT JOIN web_module_ewt ON web_module_ewt.m_code = web_permission.p_code
WHERE web_module_ewt.m_status = 'Y' AND web_module_ewt.m_code = '{$s_type}'");
$x = 0;
$a_data_item = $db->db_fetch_array($_sql_item);
?>

<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_set_admission_user') ?>" enctype="multipart/form-data">
	<input name="UID" type="hidden" id="UID" value="<?php echo $UID; ?>">
	<input name="pu_id" type="hidden" id="pu_id" value="<?php echo $pu_id; ?>">

	<div class="container" id="frm_edit_s">
		<div class="modal-dialog modal-lg">

			<div class="modal-content">
				<div class="modal-header">
					<button type="button" class="close" onclick="$('#box_popup').fadeOut();"><i class="far fa-times-circle fa-1x"></i></button>
					<h4 class="modal-title">
						<img src="<?php echo $IMG_PATH . $a_data_item['m_image']; ?>" class="img-responsive" style="display:inline;margin: 0 1px;width:36px;height:36px;">
						<?php echo $a_data_item['m_name'] . " (" . $a_data_item['p_name'] . ")"; ?>
					</h4>
				</div>

				<div class="modal-body">

					<?php
					if (!empty($a_data_item['m_permission_link'])) {
						include($a_data_item['m_permission_link']);
					}
					?>

				</div>

				<div class="modal-footer">
					<div class="col-md-12 col-sm-12 col-xs-12 text-center">
						<button onclick="JQSet_Admission($('#form_main'));" type="button" class="btn btn-success  btn-ml ">
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
		$('#chk0').change(function() {
			var name = $(this).attr('name');
			$('input:checkbox[name=' + name + ']').prop('checked', $(this).prop('checked'));

			if ($(this).is(':checked') == true) {
				$('input:checkbox:checked').attr("disabled", true);
				$('#chk0').attr("disabled", false);
			} else if ($(this).is(':checked') == false) {
				$('input:checkbox').attr("disabled", false);
			}
			//console.log(v);
		});
	});

	function JQCheck_Cate(form) {
		var name = form.attr('name');
		var type_data = $('input:radio[name=' + name + ']:checked').val();

		if (type_data == '0') {
			$('#show_complain_category').hide();
			$('#complain_category').attr("disabled", true);
			$('#complain_category').attr("required", false);
		} else {
			$('#show_complain_category').show();
			$('#complain_category').attr("disabled", false);
			$('#complain_category').attr("required", true);
		}
		console.log(type_data);
	}

	function JQSet_Admission(form) {

		var fail = CKSubmitData(form);
		if (fail == false) {
			var action = form.attr('action');
			var method = form.attr('method');
			var formData = false;
			if (window.FormData) {
				formData = new FormData(form[0]);
			}
			//alert(form.serialize());  
			$.confirm({
				title: '<?php echo $a_data_item['m_name'] . " (" . $a_data_item['p_name'] . ")"; ?>',
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
									console.log(data);
									$.alert({
										title: '',
										theme: 'modern',
										content: 'บันทึกข้อมูลเรียบร้อย',
										boxWidth: '30%',
										onAction: function() {
											//self.location.href="complain_builder.php?com_fid="+data;			
											location.reload(true);
											//$("#frm_edit_s").load(location.href + " #frm_edit_s");
											$('#box_popup').fadeOut();
										}
									});
									//$("#frm_edit_s").load(location.href + " #frm_edit_s");
									//alert("Data Save: " + data);												
									//self.location.href="complain_builder.php?com_cid="+data;											
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