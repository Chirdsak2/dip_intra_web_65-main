<!-- Open Top -->
<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<!-- Close Top -->
<link rel="stylesheet" href="assets/css/profile.css">

<div class="container-fluid b__profile mar-t-90px">
	<div class="container py-5 text-center">
		<h3> <i class="fa fa-key"></i> เปลี่ยนรหัสผ่าน </h3>
	</div>

	<div class="container">
		<div class="row">
			<div class="col-lg-3 col-md-3 col-12">
				<?php include 'profile_menu.php'; ?>
			</div>

			<div class="col-lg-9 col-md-9 col-12">
				<div class="bg--white shadow">
					<form id="setting_password_form">
						<div class="col-lg-12 col-md-12 col-sm-12 col-12 border-l-graylight">
							<div class="row g-3">
								<div class="form-floating mb-3 offset-lg-12 col-lg-12 offset-md-12 col-md-12 col-sm-12 col-12">
									<label for="firstnameuser" class="label-form"> รหัสผ่านเดิม : </label>
									<input type="password" class="form-control" placeholder="กรอกรหัสผ่านเดิม" name="password_old" id="password_old"></input>
								</div>

								<div class="form-floating mb-3 offset-lg-12 col-lg-12 offset-md-12 col-md-12 col-sm-12 col-12">
									<label for="firstnameuser" class="label-form"> รหัสผ่านใหม่ : </label>
									<input type="password" class="form-control" placeholder="กรอกรหัสผ่านใหม่" name="password_new" id="password_new"></input>
								</div>

								<div class="form-floating mb-3 offset-lg-12 col-lg-12 offset-md-12 col-md-12 col-sm-12 col-12">
									<label for="firstnameuser" class="label-form"> ยืนยันรหัสผ่านใหม่ : </label>
									<input type="password" class="form-control" placeholder="กรอกรหัสผ่านใหม่อีกครั้ง" name="password_confirm" id="password_confirm"></input>
								</div>

								<div class="font15px text-danger offset-lg-12 col-lg-12 col-md-12 col-sm-12 col-12">
									* รหัสผ่านต้องประกอบด้วย ภาษาอังกฤษมีพิมพ์ใหญ่ พิมพ์เล็ก ตัวเลข และจำนวนรวมกันไม่น้อยกว่า 8 ตัว
								</div>
							</div>
						</div>

						<!-- <?php
						gen_pic('set_password');
						function gen_pic($subject)
						{
						?> -->
							<div class="col-12 text-center">
								<!-- <div class="captcha-center mt-5">
									<div class="form-group m-b--15px">
										<div class="w-100 max-w-450px text-center mx-auto">
											<div class="bg-captcha fix-captcha" id="logpic_<?php echo $subject; ?>">
												<img src="<?php echo HOST_CAPTCHA; ?>?subject=<?php echo $subject; ?>" id="list_image" title="captcha" alt="captcha" class="mx-auto">
											</div>
											<a herf="#" id="btn_captcha" onclick="Getmessage_<?php echo $subject; ?>('');return false;" style="cursor: pointer;">
												<div class="re-captcha mb-2"> คลิกเพื่อเปลี่ยนรูป <i class="fas fa-sync-alt"></i>
												</div>
											</a>
										</div>
										<input type="text" name="chkpic1_<?php echo $subject; ?>" id="chkpic1_<?php echo $subject; ?>" class="form-control mt-1 mx-auto max-w-450px" placeholder="กรอกรหัสตามภาพ" class="form-control" autocomplete="off" style="width:100%; text-align: center; ">
										<label for="captcha" class="sr-only"> captcha </label>
									</div>
								</div> -->

								<div class="text-center mb-5">
									<button type="submit" class="btn btn-success btn-radius"> ตกลง </button>
									<button type="button" class="btn btn-danger btn-radius"> ยกเลิก </button>
								</div>
							</div>

							<!-- <input type="hidden" name="captcha_id" value="<?php echo $subject; ?>">

							<script>
								function Getmessage_<?php echo $subject; ?>() {
									current_local_time = new Date();
									document.getElementById('logpic_<?php echo $subject; ?>').innerHTML =
										'<img src="<?php echo HOST_CAPTCHA; ?>?subject=<?php echo $subject; ?>" align="absmiddle">';
								}
							</script> -->
						<!-- <?php } ?> -->
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$("#setting_password_form").on("submit", function(event) {
			event.preventDefault();
			let formData = new FormData($(this)[0]);

			$.ajax({
				url: "ajax/setting_password.ajax.php",
				data: formData,
				processData: false,
				contentType: false,
				type: "POST",
				success: function(data) {
					// console.log(object);
					let object = JSON.parse(data, true);
					if (object.status == "success") {
						$.alert({
							title: object.message,
							content: 'Success!',
							icon: 'fa fa-check-circle',
							theme: 'modern',
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
							}
						});
					} else {
						$.alert({
							title: object.message,
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

					if (object.status == "captchaFailed") {
						$('#chkpic1_set_password').focus();
					} else if (object.status == "passOldFailed") {
						$('#password_old').focus();
					} else if (object.status == "passconfirmFailed") {
						$('#password_new').focus();
					} else if (object.status == "passFailed") {
						$('#password_new').focus();
					} else if (object.status == "success") {
						//window.location.reload();
					}
				},
				error: function(data) {
					//console.log("error");
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
	});
</script>

<!-- Open Footer -->
<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>
<!-- Close Footer -->