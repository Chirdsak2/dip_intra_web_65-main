<?php include('comtop.php'); ?>
<?php include('header.php'); ?>
<?php 
$rss_main = rss::getRss();
$rss_more = rss::getMoreRss($rss_id);
?>

<!-- Style CSS Template 3 -->
<link rel="stylesheet" href="assets/css/article.css">

<div class="container-fluid mar-t-90px header--bg">
	<div class="container py-5 text-center">
		<h3>
			<a href="<?php echo $rss_more['rss_url']; ?>" target="_blank"><img src="assets/img/rssfeed.png" title="rssfeed" alt="rssfeed" class="max-w-30px dis-inline"></a>
			<?php echo $rss_more["data"]["rss_title"]; ?>
		</h3>
		<small><a href="index.php" title="RSS Service"><em class="fa fa-home"></em></a> / <a href="rss.php" title="RSS Service"> RSS </a></small>
	</div>
</div>

<div class="container-fluid bg--purple padding--50">
	<div class="container">
		<div class="row">
			<?php for ($i = 0; $i < $rss_more['rss_row']; $i++) { ?>
				<?php
				$title =  $rss_more['parsed_xml']->channel->item[$i]->title;
				$link =  $rss_more['parsed_xml']->channel->item[$i]->link;
				$description = $rss_more['parsed_xml']->channel->item[$i]->description;
				$pubDate = $rss_more['parsed_xml']->channel->item[$i]->pubDate;
				$img = $rss_more['parsed_xml']->channel->item[$i]->image;
				$image = $rss_more['parsed_xml']->channel->item[$i]->thumbnail;
				?>
				<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
					<div class="card mb-3">
						<div class="<?php echo ($rss_more['rss_images'] == 'Y' && !empty($image) ? "row no-gutters" : "dis-inline-flex-news"); ?>">

							<div class="<?php echo ($rss_more['rss_images'] == 'Y' && !empty($image) ? "col-lg-4 col-md-12 col-sm-12 col-12" : "dis-inline-flex max-width-left-pic"); ?>">
								<?php if ($rss_more['rss_images'] == 'Y' && !empty($image)) { ?>
									<img src="<?php echo $image; ?>" alt="<?php echo $image; ?>" class="w-100 p-2 border-ra-15px height-max-content" title="<?php echo $image; ?>">
								<?php } ?>
							</div>

							<div class="<?php echo ($rss_more['rss_images'] == 'Y' && !empty($image) ? "col-lg-8 col-md-12 col-sm-12 col-12" : "dis-inline-flex"); ?>">
								<div class="card-body p-2 min-h-box-index">
									<div class="card-title font17px <?php echo ($rss_more['rss_images'] == 'Y' && !empty($image) ? "text-short-more-news" : "text-short-more-rss"); ?>">
										<a href="<?php echo $link; ?>" class="font-weight-bold txt-gray-dark2 font17px" target="_black">
											<?php echo $title; ?>
										</a>
									</div>
									<p class="card-text font13px">
										<span class="mr-2"> <em class="far fa-calendar"></em> <?php echo $pubDate; ?> </span>
									</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php } ?>
		</div>
	</div>
</div>

<?php include('footer.php'); ?>
<?php include('combottom.php'); ?>