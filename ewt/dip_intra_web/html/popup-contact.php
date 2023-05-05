<!-- The social media icon bar -->
<div class="icon-bar">
	<!--
	<a href="#" class="contact--bg">
		<img src="../demo3/assets/img/icon/call.svg" class="filter-white">
		CALL
	</a>
	<a href="#" class="contact--bg"><img src="../demo3/assets/img/icon/chat.svg" class="filter-white">
		CHAT
	 </a>
	 -->
	<!-- <a href="contact.php" class="contact--bg">
		<img src="assets/img/icon/call.svg" class="filter-white">
		CALL
	</a>
	<a href="#" class="contact--bg"><img src="assets/img/icon/chat.svg" class="filter-white">
		CHAT
	</a> -->

	<?php foreach($contact as $value){ ?>
		<a href="<?php echo $value['banner_link']; ?>" class="contact--bg">
		<img src="<?php echo $value['banner_pic']; ?>" class="filter-white">
		<?php echo $value['banner_name']; ?>
	</a>
	<?php } ?>
</div>
