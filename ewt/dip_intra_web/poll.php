<!-- Open Top -->
<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<?php 
$poll_cat = poll::getPollListLimit($start_poll, $per_page_poll);
// $total_page_poll = ceil($poll_cat["countAll"] / $per_page_poll);
?>
<!-- Close Top -->
<link rel="stylesheet" href="assets/css/poll.css">

<div class="container-fluid mar-t-90px header--bg">
	<div class="container py-5 text-center">
		<h3> แบบสำรวจ </h3>
	</div>
</div>

<div class="container-fluid">
	<!-- Open News -->
	<div class="container">
		<div class="row mb-5 mt-5">

			<!-- Open รูปแบบ List รายการ -->
			<?php foreach ($poll_cat["data"] as $key => $value) { ?>
				<div class="col-12">
					<div class="mb-2 poll--card py-2">
						<div class="float-left">
							<a href="poll_view.php?c_id=<?php echo $value['c_id']; ?>" class="title-news font25px">
								<em class="fas fa-poll-h pr-1 pl-2 pt-2 font35px"></em>
								<?php echo $value['c_name']; ?>
								<span class="font15px"> (เริ่ม<?php echo convDateThai($value['c_start'])['DateDayThaiShort']; ?>, สิ้นสุด<?php echo convDateThai($value['c_stop'])['DateDayThaiShort']; ?>) </span>
							</a>
						</div>
						<div class="float-right">
							<a class="btn btn-primary" role="button" href="#" data-toggle="modal" data-target="#modal_poll" onclick="setEventId(<?php echo $value['c_id']; ?>)">
								<i class="fa fa-signal"></i> ผลโหวต
							</a>
						</div>
					</div>
				</div>
			<?php } ?>
			<!-- Close รูปแบบ List รายการ -->
		</div>
	</div>
	<!-- Close News -->

	<!-- Start แสดงการตัดหน้าเพจ -->
	<!-- <?//php echo pagination('poll.php', 's_search=' . $s_search . '', $page, $per_page_poll, $poll_cat["countAll"]); ?> -->
	<?php echo pagination_ewt('poll.php', 's_search=' . $s_search . '', $page, $per_page_poll, $poll_cat["countAll"]); ?>
	<!-- End แสดงการตัดหน้าเพจ-->
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

<!-- Open Footer -->
<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>
<!-- Close Footer -->