<!-- Open Top -->
<?php include('comtop.php'); ?>
<?php include('header_index-t2.php'); ?>
<?php include('popup-home.php'); ?>
<!-- Close Top -->
<link rel="stylesheet" href="assets/css/style-t2.css">
<style>
	.pe-2 {
		padding-right: 0.5rem !important;
        margin-left: 0px;
	}
</style>

<?php foreach($template_position as $value){ ?>
    <?php include($value["section_file"]); ?>
<?php } ?>

<!-- Open Footer --> 
<?php include('footer-t2.php'); ?> 
<?php include('combottom.php'); ?>
<!-- Close Footer -->