<?php
$menu_view1 = menu::genMenuView3($template_management["site_mainmenu"], 1);
?>
<!-- ======= Top Bar ======= -->
<section id="topbar" class="d-flex align-items-center">
	<div class="container dis-flex-lg_block-sm justify-content-center justify-content-md-between">

		<div class="contact-info d-flex align-items-center">
			<div class="div-fontsize">
				<a href="#" class="font-sm"> ก </a>
			</div>
			<div class="div-fontsize">
				<a href="#" class="font-md"> ก </a>
			</div>
			<div class="div-fontsize">
				<a href="#" class="font-lg"> ก </a>
			</div>
		</div>

		<div class="social-links align-items-center" id="navbar-top-t1">
			<ul class="navbar ml-auto mb-0">
				<li style="list-style: none;">
					<div class="bell pad-r-10px">
						<div class="text-center">
							<img src="assets/img/icon_alert.png" alt="alert" title="alert" class="bell-size">
						</div>
						<?php if ($noti_count > 0) { ?>
							<div class="alert-num-bell">
								<?php echo $noti_count; ?>
							</div>
						<?php } ?>
					</div>
					<div class="notification-box" style="height:auto !important;" id="box">
						<h2>การแจ้งเตือนใหม่ <span><?php echo $noti_count; ?></span> รายการ </h2>
						<?php if ($noti_ecard["count"] > 0) { ?>
							<div class="notification-item" onclick="alertNotification($_SESSION['EWT_MID'],'ecard','receive_card_hbd.php');">
								<img src="assets/images/ecard/ecard_ec_images_20220127105749.jpg">
								<div class="text">
									<h4>คุณได้รับการ์ดวันเกิด <?php echo $noti_ecard["count"]; ?> รายการ</h4>
								</div>
							</div>
						<?php } ?>

						<?php if ($noti_change_profile["count"] > 0) { ?>
							<div class="notification-item" onclick="alertNotification($_SESSION['EWT_MID'],'profile','edit_profile.php');">
								<img src="assets/img/system/system_03.png">
								<div class="text">
									<h4> แจ้งอัพเดทข้อมูลส่วนตัว </h4>
								</div>
							</div>
						<?php } ?>

						<?php if ($noti_register["count"] > 0) { ?>
							<div class="notification-item">
								<img src="assets/img/system/system_03.png">
								<div class="text">
									<h4> <?php echo $noti_register["count"]; ?> คน </h4>
								</div>
							</div>
							<?php foreach ($noti_register["dataAll"] as $key => $value) { ?>
								<div class="notification-item">
									<div class="text">
										<h4> <?php echo $value["REGIS_NAME_EN"] . ' ' . $value["REGIS_SURENAME_EN"]; ?></h4>
									</div>
								</div>
							<?php } ?>
						<?php } ?>

						<?php if ($noti_absent["count"] > 0) { ?>
							<?php if ($noti_absent["data"]["absent_amount"] > 0) { ?>
								<div class="notification-item">
									<img src="assets/img/system/system_03.png">
									<div class="text">
										<h4>จำนวนใบลาที่ยังไม่อนุมัติ <?php echo $noti_absent["data"]["absent_amount"]; ?> ใบ</h4>
									</div>
								</div>
							<?php } ?>

							<?php if ($noti_absent["data"]["cancel_amount"] > 0) { ?>
								<div class="notification-item">
									<img src="assets/img/system/system_03.png">
									<div class="text">
										<h4>จำนวนใบยกเลิกลาที่ยังไม่อนุมัติ <?php echo $noti_absent["data"]["cancel_amount"]; ?> ใบ</h4>
									</div>
								</div>
							<?php } ?>
						<?php } ?>

						<div><a href="notify_warn.php" class="more-alert"> ดูการแจ้งเตือนทั้งหมด </a></div>
					</div>
				</li>

				<li class="dropdown" style="list-style: none;">
					<a href="#" class="border-l-prd"><span> <i class="fas fa-user"></i> <?php echo $full_name; ?> </span> <i class="bi bi-chevron-down"></i> </a>
					<ul class="user-list">
						<li class="p-2">
							<a href="setting_profile.php">
								<i class="fas fa-cog"></i> <span class="ps-2"> ข้อมูลส่วนตัว</span>
							</a>
						</li>
						<!-- <li class="p-2">
							<a href="chat_messages.php">
								<i class="fas fa-comment"></i> <span class="ps-2"> กล่องข้อความ</span>
							</a>
						</li> -->
						<li class="p-2">
							<a href="setting_system.php">
								<i class="fas fa-list-ol"></i> <span class="ps-2"> ตั้งค่าระบบงาน</span>
							</a>
						</li>
						<li class="p-2">
							<a href="setting_password.php">
								<i class="far fa-question-circle"></i> <span class="ps-2"> เปลี่ยนรหัสผ่าน</span>
							</a>
						</li>
					</ul>
				</li>
				<li style="list-style: none;">
					<a href="logout.php" class="border-l-prd border-r-prd pe-2"> <i class="fas fa-sign-out-alt"></i> <span class="ps-2"></span></a>
				</li>
			</ul>
		</div>
	</div>
</section>

<!-- ======= Header Menu ======= -->
<nav class="navbar navbar-expand-lg navbar-light bg-white ">
	<div class="container">
		<a class="navbar-brand pb-2" href="index.php"> <img src="<?php echo $template_management['site_logo']; ?>" title="<?php echo $template_management['site_logo']; ?>" alt="<?php echo $template_management['site_logo']; ?>" class="max-width-logo"> </a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarNavDropdown">
			<?php echo $menu_view1; ?>

			<li style="list-style: none;">
				<a class="nav-link" href="search.php" title="ค้นหา" target="_blank" style="text-align: left;">
					<em class="fa fa-search fa-w-16"></em>
				</a>
			</li>
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
<?php include('component/notification.php'); ?>