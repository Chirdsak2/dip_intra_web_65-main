<?php include 'comtop.php'; ?>
<?php include 'header.php'; ?>
<?php
$calendar_view = calendar::getCalendarView($event_id);
$calendar_user = calendar::getUser($calendar_view["event_id"]);
$calendar_registor = calendar::getRegisterEvent($calendar_view["event_id"]);
$num_register = $calendar_view['event_registor_num'] - $calendar_registor["count"];
?>
<!-- Style CSS Template 3 -->
<link rel="stylesheet" href="assets/css/article.css">
<link rel="stylesheet" href="assets/css/calendar.css">

<div class="container-fluid mar-t-90px bg--purple text-center">
	<div class="container py-5">
		<div class="article--topic"> <?php echo $calendar_view["event_title"]; ?> </div>
	</div>
</div>

<section id="article-sec bg--white">
	<div class="container mt-3">
		<!-- start breadcrumb -->
		<!-- <p><a href="index.php" title="กลับหน้าหลัก">หน้าหลัก</a> / <a href="calendar.php" title="ปฏิทินกิจกรรม"> ปฏิทินกิจกรรม </a></p> -->
		<p><a href="index.php" title="กลับหน้าหลัก">หน้าหลัก</a> / <a href="more_calendar.php" title="ปฏิทินกิจกรรม"> ปฏิทินกิจกรรม </a></p>
		<!-- start breadcrumb -->
		<hr>

		<div class="form-group row">
			<!-- Open rightside -->
			<div class="col-lg-8 col-md-8 col-sm-12 col-12">
				<div class="form-check col-lg-12 col-md-12 col-sm-12 mb-3">
					<div class="h-ac"> รายละเอียดกิจกรรม </div>
					<p class="mt-3">
						<?php echo $calendar_view["event_detail"]; ?>
					</p>
					<?php if ($calendar_view['event_registor_num'] > 0) { ?>
						<!-- <p>*หมายเหตุ ควรลงทะเบียนที่หน้างานก่อนเข้างานก่อนเวลา <?php echo date('H:i', strtotime($calendar_view['event_time_start'])); ?> น. เพื่อให้เตรียมพร้อมก่อนประชุม ดูรายละเอียดเพิ่มเติมได้ที่</p> -->
					<?php } ?>
					<p></p>
				</div>

				<div class="table-responsive">
					<table class="table">
						<tbody>
							<tr>
								<th scope="row" class="w-detial-modal-1"> วันที่จัดกิจกรรม : </th>
								<td class="w-detial-modal-2"> <?php echo convDateThai($calendar_view['event_date_start'])['DateTH']; ?> - <?php echo convDateThai($calendar_view['event_date_end'])['DateTH']; ?> </td>
							</tr>
							<tr>
								<th scope="row"> เวลาจัดกิจกรรม : </th>
								<td> <?php echo date('H:i', strtotime($calendar_view['event_time_start'])); ?> - <?php echo date('H:i', strtotime($calendar_view['event_time_end'])); ?> น.</td>
							</tr>
							<tr>
								<th scope="row"> สถานที่จัดกิจกรรม : </th>
								<td> <?php echo $calendar_view['event_location']; ?> </td>
							</tr>
							<?php if (!empty($calendar_user["fullname"])) { ?>
								<tr>
									<th scope="row"> ผู้ประสานงาน : </th>
									<td>
										<?php echo $calendar_user["fullname"]; ?>
									</td>
								</tr>
							<?php } ?>

							<?php if(!empty($calendar_user["phone"])){ ?>
								<tr>
									<th scope="row"> เบอร์โทรติดต่อ : </th>
									<td>
										<?php echo $calendar_user["phone"]; ?>
									</td>
								</tr>
							<?php } ?>

							<?php if(!empty($calendar_user["department"])){ ?>
								<tr>
									<th scope="row"> หน่วยงาน : </th>
									<td>
										<?php echo $calendar_user["department"]; ?>
									</td>
								</tr>
							<?php } ?>

							<?php if (!empty($calendar_view["event_relatelink"])) { ?>
								<tr>
									<th scope="row"> ลิงก์เชื่อมโยง : </th>
									<td>
										<a href="<?php echo $calendar_view["event_relatelink"]; ?>">
											ลิงก์ข้อมูล
										</a>
									</td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>

				<!-- แสดงไฟล์แนบประกอบข่าวตรงนี้ -->
				<?php if (!empty($calendar_view["event_link"])) { ?>
					<div class="container mb-5">
						<h6 class="article-header mb-3"> เอกสารประกอบกิจกรรม</h6>
						<div class="article-attach-file-block">
							<div class="row">
								<div class="col-lg-9">
									<div class="article-attach-list">
										<a href="<?php echo $calendar_view["event_link"]; ?>" target="_blank" title="<?php echo $calendar_view["event_link"]; ?>">
											<?php echo $calendar_view["event_link"]; ?>
										</a>
									</div>
								</div>
								<div class="col-lg-3 text-center">
									<div class="article-attach-view"><a href="<?php echo $calendar_view["event_link"]; ?>" target="_blank" title="<?php echo $calendar_view["event_link"]; ?>"><i class="fa fa-download"></i></a></div>
								</div>
							</div>
						</div>
					</div>
				<?php } ?>
			</div>
			<!-- Close leftside -->

			<!-- Open rightside -->

			<div class="col-lg-4 col-md-4 col-sm-12 col-12" style="<?php echo ($calendar_view['event_registor_num'] > 0 ? "display:block" : "display:none") ?>">
				<div class="row">
					<form id="register_form">
						<div class="col-12 mb-3">
							<div class="h-ac text-center">
								ลงทะเบียนกิจกรรม
							</div>
						</div>
						<div class="col-12 mb-3">
							<div class="row">
								<div class="col-lg-6 col-md-6 col-sm-12 col-12 text-center bg-regis-calendar">
									<!-- <div class="h-ac"> จำนวนที่รับสมัคร </div>-->
									<input type="text" class="form-control-plaintext text-center font25px font-weight-bold" value="จำนวนที่รับสมัคร">
									<div class="font30px font-weight-bold"> <?php echo $calendar_view['event_registor_num']; ?> </div>
								</div>
								<div class="col-lg-6 col-md-6 col-sm-12 col-12 text-center bg-regis-calendar2">
									<!-- <div class="h-ac"> จำนวนที่เหลือ </div> -->
									<input type="text" class="form-control-plaintext text-center font25px font-weight-bold" value="จำนวนที่เหลือ">
									<div class="font30px font-weight-bold" style="color:red;"> <?php echo $num_register; ?> </div>
								</div>
							</div>
						</div>

						<?php if ($num_register != 0) { ?>
							<div class="col-12">
								<div class="row">
									<div class="col-lg-12 col-md-12 col-sm-12 p-3">
										<input type="text" class="form-control border-ra-15px" name="cal_registor_name" id="cal_registor_name" placeholder="ชื่อ - สกุล" list="datalistOptions" required>
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 p-3">
										<input type="text" class="form-control border-ra-15px" name="cal_registor_tel" id="cal_registor_tel" placeholder="เบอร์โทร" required>
									</div>
									<div class="col-lg-12 col-md-12 col-sm-12 p-3">
										<input type="email" class="form-control border-ra-15px" name="cal_registor_email" id="cal_registor_email" placeholder="อีเมล" required>
									</div>

									<div class="col-12 text-center">
										<input type="hidden" name="cal_event_id" id="cal_event_id" value="<?php echo $event_id; ?>">
										<button type="submit" class="more-index mx-auto my-3 w-100">
											ลงทะเบียน
										</button>
									</div>
								</div>
							</div>
						<?php } ?>

						<?php if ($num_register == 0) { ?>
							<div class="col-12 text-center" style="color:red;">ปิดรับการลงทะเบียน</div>
						<?php } ?>

					</form>
				</div>
			</div>

			<!-- Close rightside -->
		</div>
	</div>
</section>

<script>
	$(document).ready(function() {
		$("#register_form").on("submit", function(event) {
			event.preventDefault();
			let formData = new FormData($(this)[0]);
			$.ajax({
				url: "ajax/calendar_view.ajax.php",
				data: formData,
				processData: false,
				contentType: false,
				type: "POST",
				success: function(data) {
					let object = JSON.parse(data, true);
					if (object.email == "emailFailed") {
						$.alert({
							title: 'รูปแบบอีเมล์ไม่ถูกต้อง กรุณากรอกข้อมูลใหม่',
							content: 'Warning!',
							icon: 'fa fa-times-circle',
							theme: 'modern',
							type: 'orange',
							typeAnimated: true,
							boxWidth: '30%',
							buttons: {
								ok: {
									btnClass: 'btn-orange'
								}
							},
							onAction: function() {
								location.reload(true);
							}
						});
					}

					// if(object.phone == "phoneFailed"){
					// 	$.alert({
					// 		title: 'รูปแบบเบอร์โทรศัพท์ไม่ถูกต้อง กรุณากรอกข้อมูลใหม่',
					// 		content: 'Warning!',
					// 		icon: 'fa fa-times-circle',
					// 		theme: 'modern',
					// 		type: 'orange',
					// 		typeAnimated: true,
					// 		boxWidth: '30%',
					// 		buttons: {
					// 			ok: {
					// 				btnClass: 'btn-orange'
					// 			}
					// 		},
					// 		onAction: function() {
					// 			location.reload(true);
					// 		}
					// 	});
					// }

					if (object.status == "success") {
						$.alert({
							title: 'ลงทะเบียนสำเร็จ',
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
					}

					if (object.status == "error") {
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
				},
				error: function(data) {
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

<?php include 'footer.php'; ?>
<?php include 'combottom.php'; ?>
