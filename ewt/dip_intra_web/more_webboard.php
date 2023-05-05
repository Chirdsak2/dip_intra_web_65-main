<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<?php include('component/captcha_webboard_answer.php'); ?>
<?php
$webboard_config = webboard::getConfig();
$webboard_cate = webboard::getWCate($c_id);
$webboard_question = webboard::getWQuestion($t_id, $c_id);
$webboard_c = $webboard_cate["data"][0];
$webboard_list = webboard::getWQuestionList($start_webboard, $per_page_webboard, $c_id, $t_id, $s_search);
$total_page_webboard = ceil($webboard_list["countAll"] / $per_page);
$webboard_emotion = webboard::getEmotion();
$webboard_vulgar = webboard::getVulgar()["vulgar_text"];
?>

<!-- Style CSS Template 3 -->
<link rel="stylesheet" href="assets/css/article.css">
<link rel="stylesheet" href="assets/css/webboard.css">
<!-- mar-t-90px -->
<div class="container-fluid header--bg text-center mt-3">
	<div class="container py-5">
		<!-- <div class="article--topic">  -->
			<h3>
				<?php echo $webboard_c["c_name"]; ?>
			</h3>
		<!-- </div> -->
		<small>
			<a href="index.php" title="กลับหน้าหลัก">หน้าหลัก</a> / <a href="webboard.php" title="กระดานถามตอบ">
				กระดานถามตอบ
			</a>
		</small>
	</div>
</div>

<section id="article-sec bg--white">
	<div class="container mt-5">
		<div class="container">
			<form action="#" method="post" novalidate="novalidate">
				<div class="row">
					<div class="col-lg-12">
						<div class="row">
							<div class="col-lg-5 col-md-5 col-sm-12 p-0">
								<input type="text" class="form-control search-slt" name="s_search" id="s_search" placeholder="กรอกคำค้น" list="datalistOptions">
								<datalist id="datalistOptions">
									<?php foreach ($webboard_question["data_sh_lm"] as $key => $value) { ?>
										<option value="<?php echo $value["t_name"]; ?>">
											<?php echo $value["t_name"]; ?>
										</option>
									<?php } ?>
								</datalist>
							</div>

							<div class="col-lg-5 col-md-5 col-sm-12 p-0">
								<select class="form-control search-slt search-select" name="webboard_q" id="webboard_q">
									<option> ทุกหมวด </option>
									<?php foreach ($webboard_cate["data"] as $key => $value) { ?>
										<option value="<?php echo $value["c_id"]; ?>" <?php echo ($c_id == $value["c_id"] ? "selected" : null) ?>>
											<?php echo $value["c_name"]; ?>
										</option>
									<?php } ?>
								</select>
							</div>

							<div class="col-lg-2 col-md-2 col-sm-12 p-0">
								<button type="button" id="btn_search" class="btn btn--search wrn-btn">ค้นหา</button>
							</div>
						</div>
						<div class="text-center mt-5 text-red">
							<?php echo (!empty($s_search) ? 'ผลการค้นหา "' . $s_search . '" พบทั้งหมด ' . (int)$webboard_list['countAll'] . ' รายการ' : null); ?>
						</div>
					</div>

				</div>
			</form>
		</div>
	</div>
</section>

<div class="container-fluid bg--purple padding--10">
	<div class="container">
		<div class="row">
			<div class="col-lg-8 col-md-8 col-sm-12 col-xs-12 col-12 txt-h-table-left">
				<div class="pt-3">
					<!-- <?php echo $webboard_c["c_name"]; ?> -->
				</div>
			</div>
			<div class="col-lg-4 col-md-4 col-sm-12 col-xs-12 col-12 text-right pb-3">
				<button type="button" class="btn btn-success btn-sm mt-3 font18px border-ra-30px px-3" data-toggle="modal" data-target="#newpost">
					<em class="fa fa-plus"></em> ตั้งกระทู้ใหม่
				</button>
			</div>
			<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
				<div class="table-responsive">
					<!-- จำนวนการแสดงผลของแต่ละหน้า สามารถกำหนดได้ที่ระบบบริหาร -->
					<table class="table table-hover table-striped table-light">
						<thead>
							<tr class="bg-dark text-white">
								<th scope="col" class="w-1-table"> หัวข้อ </th>
								<th scope="col" class="w-2-table"> หมวดหลัก </th>
								<th scope="col" class="w-3-table"> อ่าน </th>
								<th scope="col" class="w-4-table"> ตอบ </th>
								<th scope="col" class="w-5-table"> ผู้ตอบล่าสุด </th>
							</tr>
						</thead>
						<tbody>
							<?php foreach ($webboard_list["data"] as $key => $value) { ?>
								<?php
								$webboard_answer = webboard::getWAnswer(null, $value["t_id"]);
								$user1 = webboard::getUser($value["user_id"]);
								$user2 = webboard::getUser($webboard_answer["data"][0]["user_id"]);
								//$by_user = $sso->getUser($user1["gen_user"])["data"];
								//$res_user = $sso->getUser($user2["gen_user"])["data"];
								$by_user = user::chkUser(array("gen_user_id" => $user1["gen_user"]))[0]; //ข้อมูล EWT
								$res_user = user::chkUser(array("gen_user_id" =>$user2["gen_user"]))[0]; //ข้อมูล EWT
								$by_name = '';
								switch ($webboard_config["c_show_question"]) {
									case 'Y':
										if ($value["user_id"] == 0) {
											$by_name .= "แอดมิน";
										} else {
											if ($value["t_web_name"] == 1) {
												$by_name .= !empty($by_user["webb_name"]) ? $by_user["webb_name"] : $by_user["name_thai"] . ' ' . $by_user["surname_thai"];
											} else {
												$by_name .= $by_user["name_thai"] . ' ' . $by_user["surname_thai"];
											}
										}
										break;
								}

								$res_name = '';
								switch ($webboard_config["c_show_answer"]) {
									case 'Y':
										if ($value["user_id"] == 0) {
											$res_name .= "แอดมิน";
										} else {
											if ($value["t_web_name"] == 1) {
												$res_name .= !empty($res_user["webb_name"]) ? $res_user["webb_name"] : $res_user["name_thai"] . ' ' . $res_user["surname_thai"];
											} else {
												$res_name .= $res_user["name_thai"] . ' ' . $res_user["surname_thai"];
											}
										}
										break;
								}
								$a_text = cutWords($webboard_vulgar, trim($value["t_name"]));
								?>
								<tr class="<?php echo ($value["t_top"] == 1 ? "bg-pin" : null); ?>">
									<th scope="row">
										<a href="webboard_answer.php?t_id=<?php echo $value["t_id"]; ?>" class="txt-dark">
											<?php if ($value["t_top"] == 1) { ?>
												<img src="assets/img/pin-webboard.png" title="ปักหมุด" alt="ปักหมุด" class="max-w-20px dis-inline">
											<?php } ?>
											<?php echo $a_text; ?>
										</a>
										<span class="txt-purple-webboard"> โดย<?php echo $by_name; ?> |
											(<?php echo convDateThai($value["t_date"])["Date"]; ?>
											<?php echo date("H:i:s", strtotime($value["t_time"])); ?>) </span>
									</th>
									<td class="font14px"> <img src="assets/img/icon/file.svg" class="float-left max-w-20px">
										<?php echo $value["c_name"]; ?>
									</td>
									<td> <em class="fa fa-eye"></em> <?php echo number_format((int) $value["t_count"]); ?>
									</td>
									<td> <em class="fa fa-clipboard"></em>
										<?php echo number_format((int) $webboard_answer["count"]); ?> </td>
									<td> <em class="fa fa-user-circle"></em> <?php echo $res_name; ?> </td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>
			</div>

			<!-- Start แสดงการตัดหน้าเพจ -->
			<?php echo pagination_ewt('more_webboard.php', 'c_id=' . $c_id . '&s_search=' . $s_search . '', $page, $per_page_webboard, $webboard_list["countAll"]); ?>
			<!-- End แสดงการตัดหน้าเพจ-->
		</div>
	</div>
</div>

<!-- <section id="article-sec">
	<div class="container">
		<div class="webboard--subcat"> หมวดภายใน </div>
		<div class="row">
			<div class="table-responsive">
				<table class="table table-hover table-striped table-light">
					<thead>
						<tr class="bg-dark text-white">
							<th scope="col" class="w-1-1-table"> หมวด </th>
							<th scope="col" class="w-1-2-table"> จำนวนกระทู้ </th>
							<th scope="col" class="w-1-3-table"> จำนวนผู้ตอบ </th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th scope="row">
								<a href="more_webboard.php" class="txt-dark font20px">
									<img src="assets/img/icon/file.svg" class="float-left max-w-30px"> <span class=""> เรื่องทั่วไป </span>
								</a>
							</th>
							<td> <em class="fa fa-clipboard"></em> 35 </td>
							<td> <em class="fa fa-user-circle"></em> 44 </td>
						</tr>
						<tr>
							<th scope="row">
								<a href="more_webboard.php" class="txt-dark font20px">
									<img src="assets/img/icon/file.svg" class="float-left max-w-30px"> <span class=""> ข้อสงสัยเกี่ยวกับกองการเจ้าหน้าที่ </span>
								</a>
							</th>
							<td> <em class="fa fa-clipboard"></em> 3 </td>
							<td> <em class="fa fa-user-circle"></em> 3 </td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</section> -->

<!-- Modal -->
<div class="modal fade" id="newpost" tabindex="-1" aria-labelledby="newpost" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<div class="modal-title font20px" id="newpost"> ตั้งคำถามหรือเปิดประเด็นใหม่ตรงนี้ </div>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<form class="webboard" id="list_webboard_question">
				<div class="modal-body">
					<div class="alert alert-warning font18px" role="alert">
						กรุณาแสดงความคิดเห็นอย่างสร้างสรรค์ หน่วยงานจะไม่รับผิดชอบต่อความคิดเห็นใดๆ ทั้งสิ้น
						เพราะไม่สามารถระบุได้ว่าเป็นความจริง ผู้อ่านจึงควรใช้วิจารณญาณในการกลั่นกรอง
						หรือถ้าท่านพบเห็นข้อความใดที่ขัดต่อกฎหมายและศีลธรรม หรือเป็นการกลั่นแกล้งเพื่อให้เกิดความเสียหาย
						ต่อบุคคล หรือหน่วยงานใด กรุณาแจ้งมาที่ <a href="#"> ผู้ดูแลระบบ </a>
						เพื่อให้ระบบทราบและทำการลบข้อความนั้น ออกจากระบบต่อไป ขอขอบพระคุณล่วงหน้า มา ณ โอกาสนี้
					</div>

					<div class="form-group row font18px">
						<label for="inputuser" class="col-sm-2 col-form-label font18px font-w-600"><span class="red">*</span> ผู้ตั้ง </label>
						<div class="col-sm-10">
							<input type="text" name="q_name" id="q_name" class="form-control font18px" value="<?php echo !empty($webb_name) ? $webb_name : $full_name; ?>" readonly>
						</div>
					</div>

					<div class="form-group row font18px">
						<label for="t_name" class="col-sm-2 col-form-label font18px font-w-600"><span class="red">*</span> หัวข้อกระทู้ </label>
						<div class="col-sm-10">
							<input type="text" class="form-control font18px" name="t_name" id="t_name" placeholder="ตั้งหัวข้อกระทู้" required>
						</div>
					</div>

					<div class="form-group row font18px">
						<label for="t_detail" class="col-sm-2 col-form-label font18px font-w-600"><span class="red">*</span> รายละเอียด </label>
						<div class="col-sm-10">
							<textarea class="form-control ckeditor font18px" name="t_detail" id="t_detail" rows="3" placeholder="กรอกรายละเอียดกระทู้" required></textarea>
							<div class="dis-flex p-2">
								<?php foreach ($webboard_emotion["data"] as $key => $value) { ?>
									<img src="<?php echo $value["emotion_img"]; ?>" class="width-emotion" style="cursor:pointer;" onClick="setsmile('<?php echo $value["emotion_img"]; ?>')">
								<?php } ?>
							</div>
							<!-- <div class="dis-flex p-2 text-primary">
								*เพิ่มอิโมจิโดยคลิกเลือกลางวางที่กล่องข้อความ
							</div> -->
						</div>
					</div>
					<!-- <?php gen_pic2('more_webboard'); ?> -->
				</div>
				<div class="modal-footer">
					<input type="hidden" name="type_post" id="type_post" value="weboard_question">
					<input type="hidden" name="c_id" id="c_id" value="<?php echo $c_id; ?>">
					<input type="hidden" name="q_email" id="q_email" value="<?php echo $email_person; ?>">
					<button type="button" class="btn btn-danger font18px border-ra-30px px-3" data-dismiss="modal">ยกเลิก </button>
					<button type="submit" class="btn btn-success font18px border-ra-30px px-3"> ตั้งกระทู้ใหม่ </button>
				</div>
			</form>
		</div>
	</div>
</div>

<!-- ค้นหาด้วยการคลิกปุ่มแสดงรายการที่ค้นหา ที่กล่องข้อมูล -->
<script type="text/javascript">
	$("#btn_search").click(function() {
		let c_id = <?php echo $c_id; ?>;
		let s_search = $('#s_search').val();
		window.location.href = 'more_webboard.php?c_id=' + c_id + '&s_search=' + s_search;
	});
</script>

<script type="text/JavaScript">
	function setsmile(what) {
    CKEDITOR.instances["t_detail"].insertHtml('<img src =' +what+ ' width="30" >');
  }
</script>

<style type="text/css">
	p {
		display: flex;
	}
</style>

<?php include 'component/webboard_modal.php'; ?>
<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>