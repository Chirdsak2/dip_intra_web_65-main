<?php include 'main_menu_t2.php'; ?>
<?php
$ecard_user = $sso->getEcardUser(date('Y-m-d'));
$calendar_manager = calendar::getManagerCalendar();
$article_list_t2 = article::getSubArticleList('0', '4', '1');
$calendar_event = calendar::getEventCalendar();
$sso_systems = $sso->getSystems($_SESSION["EWT_USERNAME"], $user_sso["USR_DIVISION"], $template_id);
$vocab = $sso->getChitChat()["dataAll"];
?>

<style>
	.bg-main-top-index {
		background-image: url(<?php echo !empty($template_management["site_header"]) ? $template_management["site_header"] : '../img/bg_top_temp2.jpg'; ?>);
	}

	.bg-hbd {
		background-color: #d90832;
	}

	.bg-ceo-calendar {
		background-color: #165ca4;
	}

	.bg-en-chitchat {
		background-color: #bfa40c;
	}
</style>

<div class="bg-main-top-index">
	<div class="container-fluid pl-0 pr-0 fixed-top bg-top-menu-2">
		<nav class="navbar navbar-expand-lg navbar-light">
			<div class="container">
				<div class="row w-100">
					<div class="ml-auto col-lg-1 col-md-1 col-sm-2 col-2">
						<a href="#" class="text-white font25px" onclick="openNav()"> <i class="fas fa-bars mt-4"></i></a>
					</div>
					<div class="ml-auto col-lg-4 col-md-4 col-sm-0 col-0 dis-pc">
						<div class="row mt-4 w-100">
							<div class="col-lg-2 col-md-3 col-sm-6 col-12 pr-0 pl-0 txt-center-sm">
								<img src="<?php echo $webb_image; ?>" alt="<?php echo $full_name; ?>" title="<?php echo $full_name; ?>" class="rounded-circle max-width-user2 shadow-user">
							</div>
							<div class="col-lg-10 col-md-9 col-sm-6 col-12 txt-center-sm">
								<div class="day-user mt-1 txt-yellow">
									<?php echo checkPeriodTime('สวัสดีตอน'); ?>
								</div>
								<div class="name-user-login2">
									<?php echo $full_name; ?>
								</div>
								<div class="font10px text-white mt-1">
									<?php echo trim(convDateThai(date('Y-m-d'))['DateDayThaiShort']); ?>
								</div>
							</div>
						</div>
					</div>
					<div class="mx-auto text-left col-lg-3 col-md-3 col-sm-4 col-4">
						<a class="navbar-brand pb-2" href="index.php"> <img src="<?php echo $template_management['site_logo']; ?>" title="<?php echo $template_management['site_logo']; ?>" alt="<?php echo $template_management['site_logo']; ?>" class="max-width-logo2 mt-4"> </a>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 col-4">
						<div class="ml-auto dis-alert-right2">
							<div class="aleart-color-r mt-4 font12px px-1 py-3 text-center">
								<a data-toggle="collapse" href="#collapseuser" role="button" aria-expanded="false" aria-controls="collapseuser">
									<div class="text-center">
										<img src="assets/img/option_config.png" alt="alert" title="alert">
									</div>
								</a>
							</div>
						</div>
						<div class="ml-auto dis-alert-right2">
							<div class="aleart-color-r mt-4 font12px px-1 py-3 text-center">
								<a data-toggle="collapse" href="#collapsealert" role="button" aria-expanded="false" aria-controls="collapsealert">
									<div class="text-center">
										<img src="assets/img/icon_alert2.png" alt="alert" title="alert">
									</div>
									<?php if ($noti_count > 0) { ?>
										<div class="alert-num-bell2">
											<?php echo $noti_count; ?>
										</div>
									<?php } ?>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</nav>
	</div>

	<div class="container pad-t-top-index-t2">
		<form action="#" method="post" novalidate="novalidate">
			<div class="row">
				<div class="col-lg-12 px-4">
					<div class="row">
						<div class="offset-lg-2 offset-md-2 col-lg-7 col-md-7 col-sm-7 col-7 p-0">
							<input type="text" class="form-control search-slt search-box-index-t2" placeholder="ค้นหา, ค้นคำ, ชื่อเรื่อง, เนื้อเรื่อง" list="datalistOptions" id="s_search">
							<datalist id="datalistOptions">
								<option value="หนังสือเวียน"></option>
								<option value="ประชาสัมพันธ์"></option>
								<option value="สื่อประชาสมพันธ์"></option>
								<option value="วาระผู้บริหาร"></option>
							</datalist>
						</div>
						<div class="col-lg-1 col-md-1 col-sm-5 col-5 p-0 search-btn-index-t2">
							<button type="button" class="btn btn--search wrn-btn search-btn-index-t2" id="btn_search">
								<i class="fas fa-search color-blue"></i>
							</button>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>

	<div class="container min-height-alert mt-5">
		<div class="row">
			<?php if (!empty($ecard_user)) { ?>
				<div class="col-lg-3 col-md-3 col-sm-6 col-12 p-4" id="divBd">
					<div class="toast box-alert-top bg-hbd" role="alert" aria-live="assertive" aria-atomic="true">
						<div class="toast-header bg-alert-top">
							<img src="assets/images/ecard/ecard_ec_images_20220127105749.jpg" class="pic-alert mr-2" alt="ecard_ec_images_20220127105749.jpg" title="ecard_ec_images_20220127105749.jpg">
							<strong class="mr-auto text-white font17px">
								<?php echo convDateThai(date("Y-m-d"))['DateThai'] . '<br>ท่านที่เกิดวันนี้ ' . $ecard_user["count"] . ' ท่าน'; ?>
							</strong>
							<button type="button" class="close-index" data-dismiss="toast" aria-label="Close" onclick="hide('divBd')">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="toast-body font16px py-0">
							<a href="send_hbd.php" class="txt-yellow"> คลิกส่งการ์ดอวยพร </a>
						</div>
					</div>
				</div>
			<?php } ?>

			<?php foreach ($calendar_manager as $key => $value) { ?>
				<?php if (!empty($calendar_event[$value["cat_id"]])) { ?>
					<div class="col-lg-3 col-md-3 col-sm-6 col-12 p-4" id="div<?php echo $key; ?>">
						<div class="toast box-alert-top bg-ceo-calendar" role="alert" aria-live="assertive" aria-atomic="true">
							<div class="toast-header bg-alert-top">
								<img src="<?php echo (empty($value['m_images']) ? "images/user001.png" : 'assets/images/calendar/' . $value['m_images']); ?>" class="pic-alert mr-2" alt="<?php echo (empty($value['m_images']) ? "images/user001.png" : 'assets/images/calendar/' . $value['m_images']); ?>">
								<strong class="mr-auto text-white font17px">
									<?php echo $value['m_pos']; ?>
								</strong>
								<button type="button" class="close-index" data-dismiss="toast" aria-label="Close" onclick="hide('div<?php echo $key; ?>')">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>

							<?php foreach ($calendar_event[$value["cat_id"]] as $key => $val) { ?>
								<div class="toast-body font16px py-0 text-white mt-2">
									<div> <?php echo $val['event_time_start'] . '-' . $val['event_time_end']; ?> </div>
									<div> <?php echo mb_strimwidth($val['event_title'], 0, 50, '...'); ?> </div>
								</div>
							<?php } ?>
						</div>
					</div>
				<?php } ?>
			<?php } ?>

			<?php foreach ($vocab as $key => $value) { ?>
				<?php $sound = $sso->getSound($value["VOCAB_ID"], 'VOCAB_FILE1')["data"]["FILE_SAVE_NAME"]; ?>
				<div class="col-lg-3 col-md-3 col-sm-6 col-12 p-4" id="divE<?php echo $value['VOCAB_ID']; ?>">
					<div class="toast box-alert-top bg-en-chitchat" role="alert" aria-live="assertive" aria-atomic="true">
						<div class="toast-header bg-alert-top">
							<audio id="player<?php echo $value["VOCAB_ID"]; ?>" src="<?php echo HOST_SSO . 'attach/w17/' . $sound; ?>"></audio>
							<input type="image" src="assets/img/en_chitchat.jpg" onclick="audio(<?php echo $value['VOCAB_ID']; ?>);" class="pic-alert mr-2">
							<strong class="mr-auto text-white font17px">
								<?php echo $value["VOCAB_TITLE1"]; ?>
							</strong>
							<button type="button" class="close-index" data-dismiss="toast" aria-label="Close" onclick="hide('divE<?php echo $value['VOCAB_ID']; ?>')">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="toast-body font16px py-0 text-white">
							<div> <?php echo $value["VOCAB_READ1"]; ?> </div>
							<a class="text-white" href="#" data-toggle="modal" data-target="#vocabPop" data-target="#staticBackdrop" onclick="c_chat(<?php echo $value['VOCAB_ID']; ?>)" style="cursor: pointer;"> English chitchat </a>
						</div>
					</div>
				</div>
			<?php } ?>

			<?php foreach ($article_list_t2 as $key => $value) { ?>
				<div class="col-lg-3 col-md-3 col-sm-6 col-12 p-4" id="divb<?php echo $key; ?>">
					<div class="toast box-alert-top2" role="alert" aria-live="assertive" aria-atomic="true">
						<div class="toast-header bg-alert-top2">
							<img src="assets/img/system/system_07.png" class="pic-alert2 mr-2" alt="assets/img/system/system_07.png">
							<a onclick="newsCount(<?php echo $value['c_id']; ?>,<?php echo $value['n_id']; ?>,'news_tab_index');" href="<?php echo ($value['news_use'] == 1 ? $value['link_html'] : "news_view.php?c_id=" . $value['c_id'] . "&n_id=" . $value['n_id'] . " "); ?>" target="<?php echo $value['target']; ?>" title="<?php echo $value['n_topic']; ?>" class="txt-gray-dark2 font17px">
								<strong class="mr-auto txt-purple-alert font16px">
									<?php if ($value["pinned"] == 'Y') { ?>
										<img src="assets/img/pin-webboard.png" title="ปักหมุด" alt="ปักหมุด" class="max-w-20px dis-inline">
									<?php } ?>
									<?php echo (empty($value['picture']) ? mb_strimwidth($value['n_topic'], 0, 80, '...') : mb_strimwidth($value['n_topic'], 0, 50, '...')); ?>
								</strong>
							</a>

							<button type="button" class="close-index2" data-dismiss="toast" aria-label="Close" onclick="hide('divb<?php echo $key; ?>');">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<!-- <div class="toast-body py-0 txt-white font14px line-h-19px">
								<?php if ($value["pinned"] == 'Y') { ?>
									<img src="assets/img/pin-webboard.png" title="ปักหมุด" alt="ปักหมุด" class="max-w-20px dis-inline">
								<?php } ?>
								<?php echo (empty($value['picture']) ? mb_strimwidth($value['n_topic'], 0, 80, '...') : mb_strimwidth($value['n_topic'], 0, 50, '...')); ?>
							</div> -->
					</div>
				</div>
			<?php } ?>
		</div>
	</div>

	<div class="container">
		<div class="row mt-3">
			<?php echo $sso_systems["data_t"]; ?>
			<?php if ($sso_systems["count"] >= 5) { ?>
				<div class="col-lg-2 col-md-2 col-sm-6 col-12">
					<a href="#collapsesystem" data-toggle="collapse" role="button" aria-expanded="false" aria-controls="collapsesystem">
						<div class="bg-icon-index text-center"> <img src="assets/img/system/system_08_t2.png" title="อื่นๆ" alt="อื่นๆ" class="max-width-icon-system-t2"> </div>
						<div class="txt-white text-center pt-2"> อื่นๆ </div>
					</a>
				</div>
			<?php } ?>
		</div>
	</div>

	<!-------------- Alert BELL ------------------->
	<div class="alert-top-system-index2 border-alert collapse" id="collapsealert">
		<div class="card card-body min-width-250px border-ra-15px border-ra-15-footer-0 max-width-top-collapes">
			<h5 class="card-title txt-color-purple"> <?php echo $noti_count; ?> รายการแจ้งเตือนสำหรับคุณ </h5>
			<ul class="list-alert-system-top">
				<?php if ($noti_ecard["count"] > 0) { ?>
					<li>
						<a href="#" onclick="alertNotification($_SESSION['EWT_MID'],'ecard','receive_card_hbd.php');">
							คุณได้รับการ์ดวันเกิด <?php echo $noti_ecard["count"]; ?> รายการ
						</a>
					</li>
				<?php } ?>
				<?php if ($noti_change_profile["count"] > 0) { ?>
					<li>
						<a href="#" onclick="alertNotification($_SESSION['EWT_MID'],'profile','edit_profile.php');">
							แจ้งอัพเดทข้อมูลส่วนตัว
						</a>
					</li>
				<?php } ?>
				<?php if ($noti_register["count"] > 0) { ?>
					<li>ข้อมูลผู้ลงทะเบียนใหม่วันนี้ <?php echo $noti_register["count"]; ?> คน</li>
					<?php foreach ($noti_register["dataAll"] as $key => $value) { ?>
						<li><?php echo $value["REGIS_NAME_EN"] . ' ' . $value["REGIS_SURENAME_EN"]; ?> </li>
					<?php } ?>
				<?php } ?>
				<?php if ($noti_absent["count"] > 0) { ?>
					<?php if ($noti_absent["data"]["absent_amount"] > 0) { ?>
						<li>จำนวนใบลาที่ยังไม่อนุมัติ <?php echo $noti_absent["data"]["absent_amount"]; ?> ใบ</li>
					<?php } ?>
					<?php if ($noti_absent["data"]["cancel_amount"] > 0) { ?>
						<li>จำนวนใบยกเลิกลาที่ยังไม่อนุมัติ <?php echo $noti_absent["data"]["cancel_amount"]; ?> ใบ</li>
					<?php } ?>
				<?php } ?>
			</ul>
		</div>
		<div class="card-footer footer-alert">
			<a href="notify_warn.php" class="txt-white-hover-gray">
				รายการแจ้งเตือนทั้งหมด.. <img src="assets/img/arrow-list-white.png" alt="arrow" title="arrow">
			</a>
		</div>
	</div>

	<!---------------- Alert config -------------------->
	<div class="alert-top-system-index2 border-alert collapse" id="collapseuser">
		<div class="card card-body min-width-250px border-ra-15px border-ra-15-footer-0 max-width-top-collapes">
			<h5 class="card-title txt-color-purple"> รายการข้อมูลส่วนตัว </h5>
			<ul class="list-alert-top">
				<li class="p-2"><a href="setting_profile.php"> ข้อมูลส่วนตัว </a></li>
				<!-- <li class="p-2"><a href="chat_messages.php"> กล่องข้อความ </a></li> -->
				<li class="p-2"><a href="setting_system.php"> ตั้งค่าระบบงาน </a></li>
				<li class="p-2"><a href="setting_password.php"> เปลี่ยนรหัสผ่าน </a></li>
				<li class="p-2"><a href="logout.php"> ออกจากระบบ </a></li>
			</ul>
		</div>
	</div>
</div>

<!-- Card วันเกิด -->
<?php include 'component/ecard_modal.php'; ?>

<script>
	function hide(id) {
		document.getElementById(id).style.display = "none";
	}

	function show(id) {
		document.getElementById(id).style.display = "";
	}

	$("#btn_search").click(function() {
		window.location.href = 'search.php?s_search=' + $('#s_search').val()
	});
</script>

<script>
	// var audio = new Audio("assets/sound/sound_1.mp3");
	// audio.oncanplaythrough = function() {}
	// audio.onended = function() {}
	function audio(ID) {
		document.getElementById('player' + ID).play();
	}
</script>
<?php include('component/notification.php'); ?>
<?php include('component/vocab_popup.php'); ?>