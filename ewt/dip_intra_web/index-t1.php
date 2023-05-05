<?php include('comtop.php'); ?>
<?php include('header_index-t1.php'); ?>
<link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
<link rel="stylesheet" href="assets/css/style-t1.css">
<style>
	.pe-2 {
		padding-right: 0.5rem !important;
	}
</style>
<!-- Start #main -->
<main id="main">
	<?php include('today-t1.php'); ?>
	<?php include('main_top_index-t1.php'); ?>
	<?php foreach ($template_position as $value) { ?>
		<?php include($value["section_file"]); ?>
	<?php } ?>
</main>
<!-- End #main -->

<!-- Start Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="staticBackdropLabel"> Popup Intro </h5>
				<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
			</div>
			<div class="modal-body">
				<?php include('popup_intro.php'); ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-bs-dismiss="modal"> ปิด </button>
			</div>
		</div>
	</div>
</div>
<!-- End Modal -->

<?php include('footer-t1.php'); ?>
<?php include('combottom.php'); ?>