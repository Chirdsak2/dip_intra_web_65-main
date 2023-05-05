<!-- Open Top -->
<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<?php 
$rss_main = rss::getRss();
$rss_more = rss::getMoreRss($rss_id);
?>
<!-- Close Top -->
<link rel="stylesheet" href="assets/css/poll.css">

<div class="container-fluid mar-t-90px header--bg">
	<div class="container py-5 text-center">
		<h3> RSS FEED </h3>
	</div>
</div>


<div class="container-fluid bg--purple padding--50">
	<!-- Open News -->
	<div class="container">
		<div class="row mb-5 mt-5">

			<!-- Open รูปแบบ List รายการ -->
			<?php foreach($rss_main as $key => $value){ ?>
				<div class="col-12">
				<div class="mb-2 poll--card py-2">
					<a href="more_rss.php?rss_id=<?php echo $value['rss_id'] ?>" class="title-news font25px" target="_blank">
						<img src="assets/img/rssfeed.png" title="rssfeed" alt="rssfeed" class="img-rss"> <?php echo $value['rss_title']; ?>
					</a>
				</div>
			</div>
			<?php } ?>
			<!-- Close รูปแบบ List รายการ -->
		</div>
	</div>
	<!-- Close News -->
</div>

<script>
	$(function() {
		$('#btnValidate').click(function() {
			var txt = $('#txturl').val();
			var re = '/(http(s)?:\\)?([\w-]+\.)+[\w-]+[.com|.in|.org]+(\[\?%&=]*)?/';
			if (re.test(txt)) {
				alert('Valid URL')
			} else {
				alert('Please Enter Valid URL');
				return false;
			}
		});
	});
</script>


<!-- Open Footer -->
<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>
<!-- Close Footer -->