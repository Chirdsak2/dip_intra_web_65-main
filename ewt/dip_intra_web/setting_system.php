<!-- Open Top -->
<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<?php
// $sso_system_h = $sso->getSystem(null, $sso_systems["sys_id"], "have")["dataAll"];
// $sso_system_n = $sso->getSystem(null, $sso_systems["sys_id"], "not")["dataAll"];
// $sso_system = array_merge($sso_system_h, $sso_system_n);

//$sso_systems = $sso->getSystems($_SESSION["EWT_USERNAME"], $user_sso["USR_DIVISION"], $template_id);
//$sso_system = $sso->getSystem()["dataAll"];
?>
<!-- Close Top -->
<link rel="stylesheet" href="assets/css/profile.css">
<style>
	.w-setting-num {
		width: 20%;
	}
</style>

<div class="container-fluid b__profile mar-t-90px">
	<div class="container py-5 text-center">
		<!-- <h3> ตั้งค่าระบบงาน </h3> -->
		<h3> <i class="fa fa-cogs"></i> ตั้งค่าระบบงาน </h3>
	</div>


	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-3 col-12">
				<?php include 'profile_menu.php'; ?>
			</div>

			<div class="col-lg-9 col-md-9 col-12">
				<div class="bg--white shadow">
					<form id="chkboxForm">
						<div class="table-responsive">
							<table class="table table-hover table-striped font16px" id="sortable">
								<thead>
									<tr class="h-setting-table text-center">
										<th scope="col" class="w-setting-1 font-weight-100 text-center"> # </th>
										<th scope="col" colspan="2" class="font-weight-100">ชื่อระบบ</th>
										<!-- <th scope="col" class="w-setting-num font-weight-100"> ตั้งค่าสถานะการใช้งาน </th> -->
										<th scope="col"></th>
									</tr>
								</thead>
								<tbody>
									<!-- <?php
									$i = 1;
									foreach ($sso_system as $key => $value) { ?>
										<?php
										if($value["SYSTEMS_ID"] != 31){
										//----------------------------------เรียกข้อมูลไฟล์รูป-----------------------------//
										$file = $sso->getFile($value["SYSTEMS_ID"]);
										//----------------------------------เช็คข้อมูลสิทธิ์จากใช้-----------------------------//
										$user = $sso->getUser($_SESSION["EWT_USERNAME"]);
										$personal = $sso->getPersonalMappingSys($user["data"]["USR_ID"]);
										if($personal){
											$check_box1 = $sso->getCheckBox($personal["data"]["WFR_ID"], 'SYSTEM_LIST', $value["SYSTEMS_ID"]);
										}
										//-------------------------------เช็คข้อมูลสิทธิ์จากหน่วยงาน---------------------------//
										$user_dep = $sso->getDepPermission(array("DEP_NAME" =>$user_sso["USR_DIVISION"]));
										if($user_dep){
											$check_box2 = $sso->getCheckBox($user_dep["data"]["DEP_PER_ID"], 'DEP_TO_SYSTEM', $value["SYSTEMS_ID"]);
										}
										//-------------------------------เช็คสถานะร้องขอสิทธ์---------------------------//
										$check_req = $sso->checkPermission($value["SYSTEMS_ID"], $user["data"]["USR_FNAME"] . ' ' . $user["data"]["USR_LNAME"]);

										if ($check_box1) {
											$checkbox_id = $check_box1["data"]["CHECKBOX_ID"];
										}
								
										if ($check_box2) {
											$checkbox_id = $check_box2["data"]["CHECKBOX_ID"];
										}
										?>

										<tr id="<?php echo $checkbox_id; ?>">
											<th scope="row" class="text-center num_sys"><?php echo $i; ?></th>
											<td class="text-center">
												<img src="<?php echo HOST_SSO . 'attach/w3/' . $file["data"]["FILE_SAVE_NAME"]; ?>" title="<?php echo $value["SYSTEMS_NAME"]; ?>" alt="<?php echo $value["SYSTEMS_NAME"]; ?>" class="mar-t--14px">
											</td>
											<td><?php echo $value["SYSTEMS_NAME"]; ?></td>
											<td class="text-center">
												<?php if (!empty($check_box1) || !empty($check_box2)) { ?>
													<a class="btn btn-success mb-3 border-ra-30px" role="button">
														<em class="fa fa-check-circle"></em> มีสิทธิ์ใช้งานระบบ
													</a>
												<?php } elseif ($check_req == true) { ?>
													<a class="btn btn-primary mb-3 border-ra-30px">
														รอพิจารณาจากแอดมิน
													</a>
												<?php } else { ?>
													<a onclick="setSys(<?php echo $value['SYSTEMS_ID'] ?>,'<?php echo $user_sso['DEP_ID']; ?>','getModal','list_sys');" class="btn btn-secondary mb-3 border-ra-30px" role="button" href="#" data-toggle="modal" data-target="#sys_request">
														ร้องขอใช้สิทธิ์
													</a>
												<?php } ?>
											</td>
										</tr>
									<?php $i++;
									} } ?> -->
								</tbody>
							</table>
						</div>

						<!-- <?php if ($sso_system) { ?>
							<div class="col-12 text-center mt-5">
								<div class="text-center mb-5">
									<button type="submit" class="btn btn-success btn-radius btn_save">
										บันทึกการเปลี่ยนแปลงข้อมูล
									</button>
								</div>
							</div>
						<?php } ?> -->
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- Modal ร้องขอใช้สิทธิ์ -->
<div class="modal fade" id="sys_request" tabindex="-1" role="dialog" aria-labelledby="sys_request" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<form id="sysForm">
				<div class="modal-header bg-blue-only">
					<h5 class="modal-title font23px txt-white1" id="sys_request">การร้องขอใช้สิทธิ์ระบบ</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span class="txt-white1" aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body font18px text-center">
					<div class="text-dark font1-2em" id="list_sys1"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-danger border-ra-30px" data-dismiss="modal"> <i class="fas fa-times"></i> ปิด </button>
					<button type="submit" class="btn btn-primary border-ra-30px">
						<em class="fa fa-check-circle"></em>
						ยืนยันการร้องขอสิทธิ์
					</button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- Modal ยืนยันการร้องขอใช้สิทธิ์ -->
<div class="modal fade" id="requestpermission" tabindex="-1" role="dialog" aria-labelledby="requestpermission" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-blue-only">
				<h5 class="modal-title font23px text-success" id="requestpermission"> <em class="fa fa-check-circle"></em> ยืนยันการร้องขอใช้สิทธิ์ระบบ</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span class="txt-white1" aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body font18px text-center">
				<div class="text-success font1-2em" id="list_sys2"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger border-ra-30px" data-dismiss="modal"><i class="fas fa-times"></i> Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Open Footer -->
<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>
<!-- Close Footer -->
<script>
	$(document).ready(function() {
		$("#sysForm").on("submit", function(event) {
			event.preventDefault();

			let formData = new FormData($(this)[0]);
			formData.append('type', "sysForm");

			$.ajax({
				url: "ajax/setting_system.ajax.php",
				data: formData,
				processData: false,
				contentType: false,
				type: "POST",
				success: function(data) {
					let object = JSON.parse(data, true);
					if (object.status == "success") {
						$.alert({
							title: object.type_text,
							content: 'Success!',
							icon: 'fa fa-check-circle',
							theme: 'modern',
							type: 'green',
							buttons: {
								ok: {
									btnClass: 'btn-green'
								}
							},
							onAction: function() {
								location.reload(true);
							}
						});
					} else {
						$.alert({
							title: object.type_text,
							content: 'Error!',
							icon: 'fa fa-times-circle',
							theme: 'modern',
							type: 'red',
							typeAnimated: true,
							boxWidth: '30%',
							buttons: {
								ok: {
									btnClass: 'btn-red'
								}
							},
							onAction: function() {
								location.reload(true);
							}
						});
					}
				},
				error: function(data) {
					// console.log('Error');
					$.alert({
						title: 'กรุณาติดต่อผู้ดูแลระบบ',
						content: 'Error!',
						icon: 'fa fa-times-circle',
						theme: 'modern',
						type: 'red',
						typeAnimated: true,
						boxWidth: '30%',
						buttons: {
							ok: {
								btnClass: 'btn-red'
							}
						},
						onAction: function() {
							location.reload(true);
						}
					});
				}
			});
		});

		// $("#chkboxForm").on("submit", function(event) {
		// 	event.preventDefault();

		// 	var w_status_unchecked = new Array();
		// 	$("input:checkbox[name='W_STATUS[]']:not(:checked)").each(function() {
		// 		w_status_unchecked.push($(this).val());
		// 	});

		// 	let formData = new FormData($(this)[0]);
		// 	formData.append('type', "chkboxForm");
		// 	formData.append('w_status_unchecked', w_status_unchecked);

		// 	$.ajax({
		// 		url: "ajax/setting_system.ajax.php",
		// 		data: formData,
		// 		processData: false,
		// 		contentType: false,
		// 		type: "POST",
		// 		success: function(data) {
		// 			let object = JSON.parse(data, true);
		// 			if (object.status == "success") {
		// 				alert(object.type_text);
		// 			} else {
		// 				alert('เกิดข้อผิดพลาดที่ระบบกรุณาลองใหม่อีกครั้ง!');

		// 			}
		// 			window.location.reload();
		// 		},
		// 		error: function(data) {
		// 			console.log('Error');
		// 		}
		// 	});
		// });

		$("#sortable tbody").sortable({
			placeholder: 'sortable-placeholder',
			update: function(event, tbody) {
				var page_id_array = new Array();
				$('#sortable tbody tr').each(function() {
					page_id_array.push($(this).attr("id"));
				});

				//console.log(page_id_array);			
				$.ajax({
					type: 'POST',
					url: 'ajax/setting_system.ajax.php',
					data: {
						type: 'orderBySys',
						page_id_array: page_id_array
					},
					success: function(data) {
						location.reload(true);
					}
				});

			}
		});
	});

	function setSys(systems_id, org, type, list) {
		$.ajax({
			type: 'POST',
			url: 'ajax/setting_system.ajax.php',
			data: {
				systems_id: systems_id,
				org: org,
				type: type,
				list: list
			},
			datatype: "text",
			success: function(data) {
				let object = JSON.parse(data, true);
				if (object.status == "success") {
					if (object.type == "getModal") {
						$('#' + object.list + '1').html(object.output1);
						$('#' + object.list + '2').html(object.output2);
					}
				} else {
					alert('เกิดข้อผิดพลาดที่ระบบกรุณาลองใหม่อีกครั้ง!');
					window.location.reload();
				}
				//console.log(data);
			},
			error: function() {
				console.log('Error');
			}
		});
	}
</script>