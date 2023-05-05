<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<?php
$webboard_config = webboard::getConfig();
$webboard_cate = webboard::getWCate($c_id);
$webboard_question = webboard::getWQuestion($t_id, $c_id);
$webboard_list = webboard::getWQuestionList($start_webboard, $per_page_webboard, $c_id, $t_id, $s_search);
$webboard_vulgar = webboard::getVulgar()["vulgar_text"];
//$total_page_webboard = ceil($webboard_list["countAll"] / $per_page_webboard);
?>

<!-- Style CSS Template 3 -->
<link rel="stylesheet" href="assets/css/article.css">
<link rel="stylesheet" href="assets/css/webboard.css">

<div class="container-fluid header--bg">
    <div class="container py-5 text-center">
		<h1 class="mt-3"> กระดานถามตอบ </h1>
	</div>
</div>

<section class="search-webboard mt-3">
	<div class="container">
		<form action="#" id="list_webboard" method="post" novalidate="novalidate">
			<div class="row">
				<div class="col-lg-12">
					<div class="row">
						<div class="col-lg-5 col-md-5 col-sm-12 p-0">
							<input type="text" name="s_search" id="s_search" class="form-control search-slt" placeholder="กรอกคำค้น" list="datalistOptions">
							<datalist id="datalistOptions">
								<?php foreach ($webboard_question["data_sh_lm"] as $key => $value) { ?>
									<option value="<?php echo $value["t_name"]; ?>">
										<?php echo $value["t_name"]; ?>
									</option>
								<?php } ?>
							</datalist>
						</div>
						<div class="col-lg-5 col-md-5 col-sm-12 p-0">
							<select class="form-control search-slt search-select" name="cate_c_id" id="cate_c_id">
								<option value=""> ทุกหมวด </option>
								<?php foreach ($webboard_cate["data"] as $key => $value) { ?>
									<option value="<?php echo $value["c_id"]; ?>" <?php echo ($c_id == $value["c_id"] ? "selected" : null) ?>>
										<?php echo $value["c_name"]; ?>
									</option>
								<?php } ?>
							</select>
						</div>

						<div class="col-lg-2 col-md-2 col-sm-12 p-0">
							<button type="button" id="btn_search" class="btn btn-danger  text_report posi-btn-search text-center">ค้นหา</button>
						</div>
					</div>
					<div class="text-center mt-5 text-red">
						<?php if (!empty($s_search)) { ?>
							ผลการค้นหา
							<?php echo (!empty($s_search) ? '"' . $s_search . '"' : null) . ' พบทั้งหมด ' . $webboard_list['countAll']; ?>
							รายการ
						<?php } ?>
					</div>
				</div>

			</div>
		</form>
	</div>
</section>

<section id="article-sec">

	<div class="container">
				<div>
					<h3 class="text-center">กระทู้ล่าสุด</h3>
				</div>
				<div class="table-responsive">
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
												$by_name .= !empty($by_user["web_name"]) ? $by_user["web_name"] : $by_user["name_thai"] . ' ' . $by_user["surname_thai"];
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
												$res_name .= !empty($res_user["web_name"]) ? $res_user["web_name"] : $res_user["name_thai"] . ' ' . $res_user["surname_thai"];
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
										<?php if ($value["t_top"] == 1) { ?>
											<img src="assets/img/pin-webboard.png" title="ปักหมุด" alt="ปักหมุด" class="max-w-20px dis-inline">
										<?php } ?>

										<a onclick="webboardCount(<?php echo $value['t_id']; ?>, 'weboard_count');" href="webboard_answer.php?t_id=<?php echo $value["t_id"]; ?>" class="txt-dark">
											<?php echo $a_text; ?>
										</a>
										<span class="txt-purple-webboard"> โดย<?php echo $by_name; ?> |
											(<?php echo convDateThai($value["t_date"])["Date"]; ?>
											<?php echo date("H:i:s", strtotime($value["t_time"])); ?>)
										</span>
									</th>
									<td class="font14px">
										<img src="assets/img/icon/file.svg" class="float-left max-w-20px">
										<?php echo $value["c_name"]; ?>
									</td>
									<td id="list_count<?php echo $value["t_id"]; ?>"> <em class="fa fa-eye"></em>
										<?php echo number_format($value["t_count"]); ?> </td>
									<td> <em class="fa fa-clipboard"></em>
										<?php echo number_format($webboard_answer["count"]); ?> </td>
									<td> <em class="fa fa-user-circle"></em> <?php echo $res_name; ?> </td>
								</tr>
							<?php } ?>
						</tbody>
					</table>
				</div>


		<!-- Start แสดงการตัดหน้าเพจ -->
		<!-- <? //php echo pagination('webboard.php', 'c_id=' . $c_id . '&s_search=' . $s_search . '', $page, $per_page_webboard, $webboard_list["countAll"]); 
				?> -->
		<?php echo pagination_ewt('webboard.php', 'c_id=' . $c_id . '&s_search=' . $s_search . '', $page, $per_page_webboard, $webboard_list["countAll"]); ?>
		<!-- End แสดงการตัดหน้าเพจ-->
	</div>

</section>

<section id="article-sec">
	<div class="container">
		<div class="webboard--subcat"><h3>หมวดหลักกระทู้</h3> </div>
			<div class="table-responsive">
				<table class="table table-hover table-striped table-light">
					<thead>
						<tr class="bg-dark text-white">
							<th scope="col" class="w-1-1-table"> หมวดหลัก </th>
							<th scope="col" class="w-1-2-table"> จำนวนกระทู้ </th>
							<th scope="col" class="w-1-3-table"> จำนวนผู้ตอบ </th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($webboard_cate["data"] as $key => $value) { ?>
							<?php
							$webboard_question = webboard::getWQuestion(null, $value["c_id"])["count"];
							$webboard_answer = webboard::getQuestionAnswer($value["c_id"])["total"];
							$a_text = cutWords($webboard_vulgar, trim($value["c_name"]));
							?>
							<tr>
								<th scope="row">
									<a href="more_webboard.php?c_id=<?php echo $value["c_id"]; ?>" class="txt-dark font20px">
										<img src="assets/img/icon/file.svg" class="float-left max-w-30px">
										<span> <?php echo $a_text; ?> </span>
									</a>
								</th>
								<td> <em class="fa fa-clipboard"></em> <?php echo $webboard_question; ?> </td>
								<td> <em class="fa fa-user-circle"></em> <?php echo $webboard_answer; ?> </td>
							</tr>
						<?php } ?>
					</tbody>
				</table>
			</div>


	</div>
</section>

<!-- <div class="container mt-4">
	<div class="row">
		<div class="col-12 text-center alert alert-warning" role="alert">
			<h4> ประกาศ </h4>
			<div class=" text-left font18px">
				เนื่องจาก Intranet Portal กรมประชาสัมพันธ์ เป็น Website ที่ให้บริการเข้าถึงระบบต่างๆ
				ได้ให้ผู้เข้าเยี่ยมชมได้ร่วมกันแสดงความคิดเห็น ไม่ว่าจะเป็นการตั้งกระทู้
				หรือการร่วมแสดงความเห็นในกระทู้ต่างๆ จึงจำเป็นต้องกระทำด้วยความระมัดระวัง
				เพื่อไม่ให้เกิดความเสียหายต่อสังคมส่วนรวม โปรดใช้ข้อความที่สุภาพ ตั้งกระทู้ให้ตรงกับเนื้อหาหรือระบบใน
				Website ห้ามเสนอข้อความหรือเนื้อหาที่ส่อไปในทางหยาบคาย ก้าวร้าว ลามก อนาจาร
				หรือก่อให้เกิดความเสียหายต่อบุคคลอื่น และเนื้อหาอันเป็นสิ่งที่เกี่ยวข้องกับสิ่งผิดกฎหมาย
				หรือศีลธรรมอันดีของสังคม
			</div>
		</div>
	</div>
</div> -->

<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>
<!-- เคลียร์ค่าช่องค้นหา -->
<script>
	$("#s_search").click(function() {
		document.getElementById("s_search").value = "";
	});
</script>

<!-- ค้นหาด้วยการคลิกปุ่มแสดงรายการที่ค้นหา ที่กล่องข้อมูล -->
<script type="text/javascript">
	$("#btn_search").click(function() {
		window.location.href = 'webboard.php?c_id=' + $('#cate_c_id').val() + '&s_search=' + $('#s_search').val();
	});
</script>

<!-- นับจำนวนคนอ่านกระทู้ -->
<script>
	function webboardCount(t_id, type_post) {
		$.ajax({
			type: 'POST',
			url: 'ajax/webboard.ajax.php',
			data: {
				t_id: t_id,
				type_post: type_post,
			},
			datatype: "text",
			success: function(data) {
				//console.log(data);
				let object = JSON.parse(data, true);
				$('#list_count' + object.t_id).html(object.output);
			},
			error: function() {
				console.log('Error');
			}
		});
	}
</script>

