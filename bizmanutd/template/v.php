<?php
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>Gallery</title>
		<link rel="stylesheet" href="css/main.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="css/thickbox.css" type="text/css" media="screen" />
		<script type="text/javascript" src="js/jquery/jquery-1.1.1.pack.js"></script>
		<script type="text/javascript" src="js/jquery/slider.pack.js"></script>
		<script type="text/javascript" src="js/jquery/global.js"></script>
		<script type="text/javascript" src="js/jquery/thickbox.js"></script>
</head>
	<body>
		<div id="container">
			<div id="main" class="clearfix">
				<div id="slider">
					<div>
						<div class="floating">
							<a id="butleft" href="#"><img src="mainpic/folder_64.png" alt="" width="24" height="64" /></a>						</div>
						<div class="floating">
							<ul class="clearfix">
							<?php
							$i=0;
							$query_category = $db->query("SELECT * FROM gallery_category  ");
							while($rs_img = $db->db_fetch_array($query_category)){
		$sql_img = $db->query("select img_path_s from gallery_image,gallery_cat_img where gallery_cat_img.img_id=gallery_image.img_id and gallery_cat_img.category_id = '".$rs_img[category_id]."' order by gallery_image.img_id ASC limit 0,1");
							$rec_img = $db->db_fetch_array($sql_img);
							$img_p = $rec_img[img_path_s];
							if (!file_exists($rec_img[img_path_s]) ) {
									$img_p = "mainpic/no-download.gif";
							}
							?>
								<li id="image<?php echo $i; ?>">
									<a href="<?php echo $img_p;?>" class="thickbox imtitle" title="<?php echo $rs_img[category_name];?>"><?php echo $rs_img[category_name];?></a>
									<a href="<?php echo $img_p;?>" class="thickbox" title="<?php echo $rs_img[category_name];?>" ><img src="<?php echo $img_p;?>" alt=""/></a>
									<div id="text<?php echo $i; ?>" class="text"><?php echo $rs_img[category_name];?><br />
									</div>
							  </li>
			<?php $i++; } ?>
							</ul>
						</div>
						<div class="floating">
							<a id="butright" href="#"><img src="mainpic/folder_64.png" alt="" width="24" height="64" /></a>						</div>
					</div>
					<div id="controls" style="display:none">
						<a href="" id="playpause" title="Play/Pause automatic slideshow"><img src="images/playred.png" alt="Play/Pause" /></a> <a href="" id="directlink" title="Direct link to the current picture"><img src="images/directlink.png" alt="Direct Link" style="margin-bottom: 7px; margin-left: 10px;" /></a>
					</div>
				</div>
				<div id="texts"></div>
			</div>
		</div>
	</body>
</html>
<?php $db->db_close(); ?>