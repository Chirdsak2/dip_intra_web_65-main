<!-- Open Top -->
<?php include 'comtop.php'; ?>
<?php include 'header.php'; ?>
<?php 
$poll_view_cat = poll::getPoll($c_id);
$poll_view_ans = poll::getPollAswer($c_id);
?>
<!-- Close Top -->
<link rel="stylesheet" href="assets/css/poll.css">

<div class="container-fluid mar-t-90px bg--purple text-center">
	<div class="container py-5">
		<div class="top--topic--detial"> <?php echo $poll_view_cat[0]['c_name']; ?> </div>
	</div>
</div>

<div class="container-fluid">
	<!-- Open News -->
	<div class="container mt-3">

		<!-- start breadcrumb -->
		<p><a href="index.php" title="กลับหน้าหลัก">หน้าหลัก</a> / <a href="poll.php" title="ชื่อหมวด">แบบสำรวจ</a> </p>
		<!-- start breadcrumb -->
		<hr>

		<div class="row mb-5 mt-5">
			<div class="container">
				<div class="row">
					<div class="col-lg-12">
						<div>
							<!-- Show FAQs -->
							<div>
								<form class="font20px" action="#" id="poll_view_form">
									<fieldset>
										<div class="container mb-2">
											<?php foreach ($poll_view_ans as $key => $value) { ?>
												<div class="radio pb-3" style="color:<?php echo $value['a_color']; ?>">
													<label hidden> <?php echo $value['a_name']; ?> </label>
													<input type="radio" name="a_id" id="a_id" value="<?php echo $value['a_id']; ?>">
													<?php echo $value['a_name']; ?>
												</div>

												<div class="radio pb-3">
													<?php if (!empty($value['a_images'])) { ?>
														<img src="<?php echo 'download/poll/' . $value['a_images']; ?>" alt="<?php echo $value['a_images']; ?>" class="img-rounded img-responsive" style="width:120px;height:120px;">
													<?php } ?>
												</div>
											<?php } ?>
										</div>

										<?php if (!empty($poll_view_ans)) { ?>
											<div class="col-xl-12 text-center ">
												<button type="submit" class="btn btn-success mb-3" role="button">
													<em class="fa fa-check-circle"></em> โหวต
												</button>
												<a class="btn btn-primary mb-3" role="button" href="#" data-toggle="modal" data-target="#modal_poll" onclick="setEventId(<?php echo $poll_view_cat[0]['c_id']; ?>)">
													<i class="fa fa-signal"></i> ผลโหวต
												</a>
											</div>
										<?php } else { ?>
											<div class="col-xl-12 text-center font23px">
												<p style="color:red;">ไม่พบข้อมูลคำตอบ</p>
											</div>
										<?php } ?>

										<!-- Modal ปุ่มตอบแบบฟอร์ม -->
										<div class="margintop15 mb-2">

										</div>
										<div class="clearfix"></div>

									</fieldset>
								</form>
							</div>
							<!-- end Show Form -->
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- Close News -->
</div>

<!-- Modal Vote -->
<div class="modal fade" id="modal_vote" tabindex="-1" role="dialog" aria-labelledby="Vote" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header bg-blue-only" id="list_close">
				<h5 class="modal-title font23px txt-white1" id="Vote">โหวต</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span class="txt-white1" aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body font18px text-center">
				<div id="vote_status"></div>
			</div>
			<div class="modal-footer" id="list_btn_close">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Vote Result -->
<div class="modal fade" id="modal_poll" tabindex="-1" role="dialog" aria-labelledby="Result" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header bg-blue-only">
				<h5 class="modal-title font23px txt-white1" id="list_vote"></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span class="txt-white1" aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body font25px">
				<div class="mb-3" id="list_c_name"></div>
				<div class="row calendar-row" id="list_a_name"></div>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</div>
	</div>
</div>

<script>
	$(document).ready(function() {
		$("#poll_view_form").on("submit", function(event) {
			event.preventDefault();

			let formData = new FormData($(this)[0]);
			formData.append('c_id', <?php echo $c_id; ?>);

			$.ajax({
				url: "ajax/poll_view.ajax.php",
				data: formData,
				processData: false,
				contentType: false,
				type: "POST",
				success: function(data) {
					$("#modal_vote").modal();

					if (document.getElementsByName('a_id')[0].checked || document.getElementsByName('a_id')[1].checked || document.getElementsByName('a_id')[2].checked) {
						let object = JSON.parse(data, true);
						let list_close = '';
						list_close += '<h5 class="modal-title font23px txt-white1" id="Vote">โหวต</h5>';
						list_close += '<button type="button" class="close" data-dismiss="modal" aria-label="Close" onclick="closePopup();">';
						list_close += '<span class="txt-white1" aria-hidden="true">&times;</span>'
						list_close += '</button>';

						let list_btn_close = '';
						list_btn_close += '<button type="button" class="btn btn-danger" data-dismiss="modal" onclick="closePopup();">Close</button>';

						if (object.status == "success") {
							$('#list_close').html(list_close);
							$('#list_btn_close').html(list_btn_close);
							$('#vote_status').html('<div class="text-success font1-2em"><em class="fa fa-check-circle"></em> ขอบคุณสำหรับการโหวต</div>');
						} else {
							$('#list_close').html(list_close);
							$('#list_btn_close').html(list_btn_close);
							$('#vote_status').html('<div class="text-primary font1-2em">คุณได้ทำการโหวตไปเรียบร้อยแล้ว</div>');
						}
					} else {
						$('#vote_status').html('<div class="text-warning font1-2em">กรุณาเลือกข้อมูลที่ต้องการโหวต</div>');
					}
				},
				error: function(data) {
					console.log('Error');
				}
			});
		});
	});
</script>

<script>
	function setEventId(c_id) {
		$.ajax({
			type: 'POST',
			url: 'ajax/poll.modal.ajax.php',
			data: {
				c_id: c_id,
			},
			datatype: "text",
			success: function(data) {
				let object = JSON.parse(data, true);
				$('#list_vote').html(object.list_vote);
				$('#list_c_name').html(object.list_c_name);
				$('#list_a_name').html(object.list_a_name);
			},
			error: function() {
				console.log('Error');
			}
		});
	}
</script>

<script>
	function closePopup() {
		window.location.href = 'poll.php';
	}
</script>

<!-- Open Footer -->
<?php include 'footer.php'; ?>
<?php include 'combottom.php'; ?>
<!-- Close Footer -->