<!-- Open Top -->
<?php include('comtop.php'); ?>
<?php !empty($t_header) ? include($t_header) : null; ?>
<?php include('popup-home.php'); ?>
<!-- Close Top -->

<?php echo ($template_id == 1) ? '<main id="main">' : null; ?>
<?php !empty($t_main_top_index) ? include($t_main_top_index) : null; ?>
<?php foreach($template_position as $value){ ?>

    <?php include($value["section_file"]); ?>
<?php } ?>
<?php echo ($template_id == 1) ? '</main>' : null; ?>

<!-- Open Footer -->
<?php !empty($t_footer) ? include($t_footer) : null; ?>
<?php include('combottom.php'); ?>
<!-- Close Footer -->

<!-- Start Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
	aria-labelledby="staticBackdropLabel" aria-hidden="true">
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