<?php $all_main_top_index_t1 = main::getAllmaintopIndext1($sso); ?>
<style>
	.bg-today-t1 {
		background-color: #f9f9f9
	}

	.h-hbd-t1 {
		color: #cc4272;
	}

	.box-hbd-t1 {
		background-color: #ffe0eb;
	}

	.btn-hbd-gift-t1 {
		background-color: #d32a9f;
		padding: 2px 2px 2px 5px;
		border-radius: 0px 0px 10px 10px;
		font-size: 13px;
		transition: ease-in-out 0.3s;
	}

	.h-meeting-t1 {
		color: #51187d;
	}

	.box-meeting-t1 {
		background-color: #f4e5ff;
	}

	.h-en-t1 {
		color: #c4a819;
	}

	.box-en-t1 {
		background-color: #fffadb;
	}

	.btn-enchitchat-t1 {
		background-color: #D3B520;
		padding: 2px 2px 2px 5px;
		border-radius: 50px;
		font-size: 13px;
		transition: ease-in-out 0.3s;
	}

	.border-ra-15-top {
		border-radius: 15px 15px 0px 0px;
	}

	.border-ra-15-bottom {
		border-radius: 0px 0px 15px 15px;
	}
</style>

<div class="container-fluid bg-today-t1 p-2">
	<div class="container">
		<div class="row mx-auto my-auto">
			<div id="myCarousel" class="carousel slide w-100" data-ride="carousel" data-interval="false">
				<ol class="carousel-indicators">
					<?php if ($all_main_top_index_t1["count"] > 1) {
						for ($i = 0; $i < $all_main_top_index_t1["count"]; $i++) { ?>
							<li data-target="#myCarousel" data-slide-to="<?php echo $i; ?>" class="<?php echo ($i == 0 ? "active" : null); ?> color-bullet1"></li>
					<?php }
					} ?>
				</ol>
				<div class="carousel-inner pb-3" role="listbox">
					<?php echo $all_main_top_index_t1["txt"]; ?>
				</div>
			</div>
		</div>

	</div>
</div>


<!-- Card วันเกิด -->
<!-- Modal -->
<?php include('component/ecard_modal.php'); ?>

<script>
	var audio = new Audio("assets/sound/sound_1.mp3");
	audio.oncanplaythrough = function() {}
	audio.onended = function() {}
</script>