<?php
include("../EWT_ADMIN/comtop_pop.php");

$db->query("USE " . $EWT_DB_USER);
$_GET['ug'] = $_SESSION["EWT_SUID"];

$sql_gen_user = "SELECT * FROM org_name WHERE org_status = 'Y' ";

if ($_POST["name_org"] != "") {
	$sql_gen_user .= " AND (name_org LIKE '%" . $_POST["name_org"] . "%')  ";
}

if ($_SESSION["EWT_SUID"] != '') {
	$sql_gen_user .= "  AND org_id <> " . $_SESSION["EWT_SUID"] . "";
}

$sql_gen_user .= " ORDER BY org_id DESC LIMIT 10";

$s_sql  = $db->query($sql_gen_user);
$a_rows = $db->db_num_rows($s_sql);
?>

<form id="form_main" name="form_main" method="POST" action="<?php echo getLocation('func_set_permission_addorg') ?>" enctype="multipart/form-data">
	<input type="hidden" name="proc" id="proc" value="Add">
	<input name="ug" type="hidden" id="ug" value="<?php echo $_GET['ug']; ?>">

	<div class="container" id="frm_edit_s">
		<div class="modal-dialog modal-lg">

			<div class="modal-content">
				<div class="modal-header ewt-bg-color b-t-l-6 b-t-r-6">
					<button type="button" class="close" onclick="$('#box_popup').fadeOut();"><i class="far fa-times-circle fa-1x color-white"></i></button>
					<h4 class="modal-title color-white">
						<?php echo "ให้สิทธิ์หน่วยงาน"; ?></h4>
				</div>

				<div class="modal-body">
					<div class="card ">
						<div class="card-body">
							<div class="col-lg-12 row" style="margin-bottom:20px;">
								<div style="margin-bottom:8px;">
									<div><label for="name_org"><b>ชื่อหน่วยงาน:</b></label></div>
									<div><input class="form-control" type="text" id="name_org" name="name_org" value=""></div>
								</div>

								<div align="center" style="margin-top:20px;padding:15px;">
									<button type="button" onclick="search_org();" class="btn btn-primary search_module_button">
										<i class="fas fa-search"></i>&nbsp;ค้นหา
									</button>
								</div>
							</div>

							<table class="table table-bordered">
								<thead>
									<tr class="text-center ">
										<th class="text-center">หน่วยงาน</th>
									</tr>
								</thead>

								<tbody id="search_org_area">
									<?php
									if ($a_rows > 0) {
										$i = 0;
										while ($a_data = $db->db_fetch_array($s_sql)) {
											$sql_chk = $db->query("SELECT COUNT(ugm_id) FROM web_group_member WHERE ug_id = '{$_SESSION['EWT_SUID']}' AND ugm_type = 'D' AND ugm_tid = '{$a_data['org_id']}' ");
											$C = $db->db_fetch_row($sql_chk);
											if ($C[0] == 0) { ?>
												<tr>
													<td>
														<div class="checkbox">&nbsp;&nbsp;
															<label>
																<input type="checkbox" class="chk" name="chk<?php echo $i; ?>" id="chk<?php echo $i; ?>" value="Y" <?php echo ($C[0] > 0) ? "checked" : null; ?>>
																<span class="cr1"><i class="cr-icon fas fa-check color-ewt"></i></span>&nbsp;
																<input name="uid<?php echo $i; ?>" type="hidden" value="<?php echo $a_data['org_id']; ?>">
																<img src="<?php echo $IMG_PATH; ?>images/grabme.svg">
																<img src="../images/user_logo.gif" width="20" height="20" border="0" align="absmiddle">
																<?php echo $a_data["name_org"]; ?>
															</label>
														</div>
													</td>
												</tr>
											<?php } ?>
											<?php $i++; ?>
										<?php } ?>
									<?php } else { ?>
										<tr align="center" bgcolor="#FFFFFF">
											<td height="40" colspan="2">
												<font color="#FF0000">ไม่พบรายชื่อหน่วยงาน</font>
											</td>
										</tr>
									<?php } ?>
									<input name="alli" type="hidden" value="<?php echo $i; ?>">
								</tbody>
							</table>
						</div>
					</div>
				</div>
				<div class="modal-footer ">
					<div class="col-md-12 col-sm-12 col-xs-12 text-center">
						<button onclick="JQAdd_Permission_org($('#form_main'));" type="button" class="btn btn-success  btn-ml ">
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
		$('.chk').change(function() {
			var name = $(this).attr('name');
			$('input:checkbox[name=' + name + ']').prop('checked', $(this).prop('checked'));
			if ($(this).is(':checked') == true) {
				//$('input:checkbox').is(':checked').attr("disabled",true);
				$('input:checkbox').attr("disabled", true);
				$(this).attr("disabled", false);
			} else if ($(this).is(':checked') == false) {
				$('input:checkbox').attr("disabled", false);
			}
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

	function JQAdd_Permission_org(form) {
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
				title: '<?php echo "ให้สิทธิ์ผู้ใช้งานระบบ"; ?>',
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
										boxWidth: '30%',
										onAction: function() {
											self.location.href = "permission_builder_user.php?mid=" + data + "&mtype=<?php echo url_encode('U'); ?>";
											//location.reload(true);	
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

	function search_org() {
		$("#search_org_area").html("");
		var name_org = $("#name_org").val();

		$("#search_org_area").html('<tr align="center" bgcolor="#FFFFFF">' +
			'<td height="40" colspan="2"><font color="#0ed145">..กำลังดำเนินการ..</font></td>' +
			'</tr>');

		$.ajax({
			url: "search_org_process.php",
			method: "post",
			data: {
				name_org: name_org
			},
			success: function(data) {
				setTimeout(function() {
					$("#search_org_area").html(data);
				}, 1000);
			}
		})
	}
</script>