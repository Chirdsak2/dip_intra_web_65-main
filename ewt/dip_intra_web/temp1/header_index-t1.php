<!-- ======= Top Bar ======= -->
<section id="topbar" class="d-flex align-items-center">
	<div class="container dis-flex-lg_block-sm justify-content-center justify-content-md-between">
		<div class="contact-info d-flex align-items-center">
			<!--
			<a href="mailto:intraweb@prd.go.th"><i class="bi bi-envelope d-flex align-items-center"><span> intraweb@prd.go.th </span></i></a>
			<a href="tel:026182323"><i class="bi bi-phone d-flex align-items-center ms-4"><span>0-2618-2323 - 40</span></i></a>
			-->
			<div class="div-fontsize">
				<a class="color-font-size" href="#"> <span class="font-sm" id="decrease" value="Decrease"> ก </span></a>
			</div>
			<div class="div-fontsize">
				<a class="color-font-size" href="#"> <span class="font-md" id="normal" value="normal"> ก </span></a>
			</div>
			<div class="div-fontsize pr-3">
				<a class="color-font-size" href="#"> <span class="font-lg" id="increase" value="Increase"> ก </span></a>
			</div>
			<div class="text-center border-l-prd pl-3 font15px">
				<?php echo trim(convDateThai(date('Y-m-d'))['DateDayThaiShort']); ?>, <?php echo date('H:i'); ?> น.
			</div>
		</div>

		<div class="social-links align-items-center">

			<div class="ml-auto dis-alert-right1">
				<div class="aleart-color-r font12px px-1 text-center">
					<a data-toggle="collapse" href="#collapseuser" role="button" aria-expanded="false" aria-controls="collapseuser">
						<div class="text-center px-0">
							สวัสดีคุณ <?php echo $user_profile[0]['name_thai'] . ' ' . $user_profile[0]['surname_thai']; ?>
						</div>
						<?php echo $change_password; ?>
					</a>
				</div>
			</div>
			<div class="ml-auto dis-alert-right1">
				<div class="aleart-color-r font12px px-1 text-center h-50px">
					<a data-toggle="collapse" href="#collapsealert" role="button" aria-expanded="false" aria-controls="collapsealert">
						<div class="text-center">
							<img src="<?php echo HOST_NAME; ?>assets/img/bell.png" alt="alert" title="alert" class="max-w-20px">
						</div>
						<div class="alert-num-bell1"> 4 </div>
					</a>
				</div>
			</div>

			<!-------------- Alert BELL ------------------->
			<div class="alert-top-system-index1 border-alert collapse" id="collapsealert">
				<div class="card card-body min-width-250px border-ra-15px border-ra-15-footer-0 max-width-top-collapes">
					<h5 class="card-title txt-color-purple"> 3 รายการแจ้งเตือนสำหรับคุณ </h5>
					<ul class="mar-l--40px list-alert-system-top">
						<li><a href="#"> แจ้งลางานออนไลน์ </a></li>
						<li><a href="#"> เอกสารรอการอนุมัติ </a></li>
						<li><a href="#"> แจ้งประเมินพนักงานประจำปี 64 </a></li>
						<li><a href="#"> ได้เวลาอัพเดทข้อมูลส่วนตัวแล้วนะคะ </a></li>
					</ul>
				</div>
				<div class="card-footer footer-alert">
					<a href="#" class="txt-white-hover-gray">
						รายการแจ้งเตือนทั้งหมด.. <img src="assets/img/arrow-list-white.png" alt="arrow" title="arrow">
					</a>
				</div>
			</div>

			<!---------------- Alert config -------------------->
			<div class="collapse alert-top-index1 border-alert" id="collapseuser">
				<div class="card card-body min-width-250px border-ra-15px max-width-top-collapes">
					<h5 class="card-title txt-color-purple"> รายการข้อมูลส่วนตัว </h5>
					<ul class="mar-l--40px list-alert-top">
						<li><a href="setting_profile.php"> แก้ไขข้อมูลส่วนตัว </a></li>
						<li><a href="setting_system.php"> ตั้งค่าระบบงาน </a></li>
						<li><a href="setting_password.php"> เปลี่ยนรหัสผ่าน </a></li>
					</ul>
				</div>
			</div>

		</div>
	</div>
</section>

<!-- ======= Header Menu ======= -->
<nav class="navbar navbar-expand-lg navbar-light bg-white ">
	<div class="container">
		<a class="navbar-brand pb-2" href="index-t1.php"> <img src="<?php echo HOST_NAME; ?>assets/img/logo-t1.png" title="logo" alt="logo" class="max-width-logo"> </a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNavDropdown">
			<?php echo $menu_view1; ?>
		</div>
	</div>
</nav>
<!-- End Header -->

<script>
	let box = document.getElementById('box');
	let bell = document.querySelector(".bell");
	let down = false;
	//When Browser load notification function will execute
	window.onload = () => {
		notification();
	};
	//Onclick of bell
	bell.addEventListener('click', function() {
		bell.classList.remove("notify");
		toggle();
	});

	function toggle() {
		if (down) {
			box.style.height = '0px';
			box.style.opacity = '0';
			box.style.display = 'none';
			down = false;
		} else {
			box.style.height = '450px';
			box.style.opacity = '1';
			box.style.display = 'block';
			down = true;
		}
	}

	function notification() {
		setTimeout(function() {
			bell.classList.add("notify");
		}, 1000);
	}
</script>