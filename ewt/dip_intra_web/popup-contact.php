<?php $contact_icon = banner::getBanner($template_management["site_icon"]); ?>
<!-- The social media icon bar -->
<div class="icon-bar">
	<?php foreach ($contact_icon["data"] as $value) {
		//if ($value["banner_name"] != "Chat") { ?>
			<a href="<?php echo $value['banner_link']; ?>" class="contact--bg">
				<img src="<?php echo $value['banner_pic']; ?>" class="filter-white">
				<?php echo $value['banner_name']; ?>
			</a>
	<?php //}
	} ?>
</div>