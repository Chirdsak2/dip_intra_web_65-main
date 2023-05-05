<!-- Open Top -->
<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<?php 
$ecard_user_birthdate = ecard::getEcardHistory($_SESSION["EWT_MID"], $ech_date, $ech_date_year);
$birth_date = date("m-d", strtotime($birth_day)); //วันเกิด User
$birth_date_cy = date("Y") . '-' . $birth_date; //วันเกิด User ปีปัจจุบัน
$birth_date_bfy = date("Y", strtotime(" - 1 years")) . '-' . $birth_date; //วันเกิด User ปีก่อน
?>
<!-- Close Top -->

<style>
	.header--bg {
		padding: 50px 0px 0px 0px;
		background: #EEEEEE;
		text-align: center;
	}

	.max-width50px{
		width: 50px;
	}
</style>

<div class="container-fluid mar-t-90px header--bg">
	<div class="container py-5 text-center">
		<h3> การ์ดอวยพรวันเกิดที่ได้รับ </h3>
		<small><em class="fa fa-home"></em> / <a href="setting_profile.php" title="ข้อมูลส่วนตัว">ข้อมูลส่วนตัว
			</a></small>
	</div>
</div>


<div class="container-fluid mt-5">
	<div class="container">
		<form>
			<div class="row">
				<div class="col-lg-3 col-md-3 col-sm-12 col-12">
					<div>
						<div class="">
							<img src="<?php echo $webb_image; ?>" alt="<?php echo $webb_image; ?>"
								title="<?php echo $full_name; ?>" class="w-100">
						</div>
					</div>

					<div class="row g-3 mt-4">
						<div class="mb-3 col-lg-12 col-md-12 col-sm-12 col-12 text-center">
							<div class="font25px">
								คุณ<?php echo $full_name; ?>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-12 text-center">
							<div class="font20px bg-hbd-day">
								วันเกิด <?php echo convDateThai($birth_day)['DateThai']; ?>
							</div>
						</div>
					</div>
				</div>

				<div class="col-lg-9 col-md-9 col-sm-12 col-12 border-l-gray">
					<div class="row">
						<div class="col-12 mb-4">
							<h2>
								<span class="badge badge-info py-2 px-4 border-ra-30px">
									<?php echo convDateThai($birth_date_cy)['DateDay']; ?> </span>
							</h2>
						</div>

						<?php foreach ($ecard_user_birthdate['data'] as $value) { ?>
						<?php
							$ecard_list = ecard::getEcardList($value['ech_ecardid'])[0]; //ภาพการ์ดวันเกิด
							$ecard_greeting = ecard::getEcardGreeting($value['ech_cid'])[0]; //ข้อความการ์ดวันเกิด
							$user = user::chkUser(array("gen_user_id" => $value['ech_from_userid']))[0]; //ข้อมูลผู้ใช้ EWT
							$user_sso = $sso->getUser($user["gen_user"])["data"]; //ข้อมูลผู้ใช้ SSO
							$full_name = $user_sso["USR_FNAME"] . ' ' . $user_sso["USR_LNAME"]; //ชื่อ-นามสกุลผู้ส่งการ์ดวันเกิด
							$user_image = getImgbase64("profile/". $user_sso["USR_PICTURE"], "images/user_profile_empty.png"); //รูปผู้ส่งการ์ดวันเกิด
						?>

						<div class="col-lg-4 col-md-4 col-sm-12 col-12 text-center mb-3">
							<div class="card">
								<img src="<?php echo 'assets/images/ecard/' . (empty($ecard_list['ec_filename']) ? 'no_image.jpg' : $ecard_list['ec_filename']); ?>"
									class="card-img-top-fix"
									alt="<?php echo empty($ecard_list['ec_filename']) ? 'การ์ดอวยพรถูกนำออกจากระบบ' : $ecard_greeting['c_detail']; ?>"
									title="<?php echo empty($ecard_list['ec_filename']) ? 'การ์ดอวยพรถูกนำออกจากระบบ' : $ecard_greeting['c_detail']; ?>">
								<div class="card-body">
									<h6 class="card-title small2">
										<?php echo empty($ecard_greeting['c_detail']) ? null : $ecard_greeting['c_detail']; ?>
									</h6>
								</div>
								<ul class="list-group list-group-flush">
									<li class="list-group-item">
										<div class="dis-inline">
											<img src="<?php echo $user_image; ?>"
												class="rounded-circle max-width50px shadow-user"
												alt="<?php echo $full_name; ?>" title="<?php echo $full_name; ?>">
										</div>
										<div class="dis-inline">
											คุณ<?php echo $full_name; ?>
										</div>
									</li>
								</ul>
							</div>
						</div>
						<?php } ?>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>

<!-- ฟังก์ชันย่อบทความ -->
<script type="text/javascript" language="javascript">
	$(".small2").each(function () {
		text = $(this).text();
		if (text.length > 26) {
			$(this).html(text.substr(0, 26) + '<span class="elipsis">' + text.substr(26) +
				'</span><a class="elipsis" href="#"><i class="fa fa-caret-square-o-right" aria-hidden="true"></i> ดูเพิ่มเติม</a>'
			);
		}
	});
	$(".small2 > a.elipsis").click(function (e) {
		e.preventDefault(); //prevent '#' from being added to the url
		$(this).prev('span.elipsis').fadeToggle(500);
	});
</script>

<!-- Open Footer -->
<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>
<!-- Close Footer -->