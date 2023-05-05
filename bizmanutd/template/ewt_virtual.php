<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

$sql_v = $db->query("SELECT * FROM virtual_list WHERE v_id = '".$_GET["vid"]."' ");
$R = $db->db_fetch_array($sql_v);

?><html>
<head>
<title><?php echo $R["v_name"]; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link rel="stylesheet" type="text/css" href="css/thickbox_p.css" media="screen" />
<link rel="stylesheet" type="text/css" href="css/jquery.panorama.css" media="screen" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/jquery.panorama.js"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$("img.advancedpanorama").panorama({
	         auto_start: <?php echo $R["v_auto"]; ?>,
				 <?php if($R["v_fit"] != "Y" AND $R["v_maxwidth"] != "0"){ ?>
			viewport_width: <?php echo $R["v_maxwidth"]; ?>,
				 <?php } ?>
			start_position: <?php echo $R["v_start"]; ?>,
			speed: <?php echo $R["v_speed"]; ?>,
			mode_360: <?php echo $R["v_360"]; ?>
	         });
	});
</script>
<script type="text/javascript" src="js/cvi_text_lib.js"></script>
<script type="text/javascript" src="js/jquery.advanced-panorama.js"></script>
<script type="text/javascript" src="js/jquery.flipv.js"></script>
<script type="text/javascript" src="js/thickbox.js"></script>
<script type="text/javascript">
	tb_pathToImage = "css/loadingAnimation.gif";
</script>

<style  type="text/css">
	body {
		background: <?php echo $R[v_bgcolor]; ?>;
		text-align: center;
	}
	#page {
		text-align: center;
		color: white;
	}
	#page a {
		color: white;
	}
	#page .panorama-viewport {
		border: 20px solid #414141;
		margin-left: auto;
		margin-right: auto;
	}
	#page p {
		margin-bottom: 1em;
	}
	.TB_overlayBG {
		background-color: <?php echo $R[v_bgcolor]; ?>;
	}
</style>
</head>
<body  leftmargin="0" topmargin="0" >
<div style="font-family:Tahoma; font-size:17px;color: <?php echo $R[v_fontcolor]; ?>"><br /><?php echo $R["v_name"]; ?></div><br /><div style="font-family:Tahoma; font-size:13px;color: <?php echo $R[v_fontcolor]; ?>"><?php echo $R["v_detail"]; ?>
</div>
<div id="page"><img src="virtual/<?php echo $R["v_images"]; ?>"  width="<?php echo $R["v_width"]; ?>" class="advancedpanorama" height="<?php echo $R["v_height"]; ?>" usemap="testmap" alt="<?php echo $R["v_name"]; ?>" />
  <map id="testmap" name="testmap">
  <?php
  $sql_spot = $db->query("SELECT * FROM virtual_spot WHERE v_id = '".$_GET["vid"]."'");
  while($S = $db->db_fetch_array($sql_spot)){
  if($S[s_type] =='VIRTUAL'){
  $S[s_link] = 'ewt_virtual.php?vid='.$S[s_link];
  }
  ?>
    <area shape="rect" coords="<?php echo $S[s_x1]; ?>,<?php echo $S[s_y1]; ?>,<?php echo $S[s_x2]; ?>,<?php echo $S[s_y2]; ?>" href="<?php echo $S[s_link]; ?>" alt="<?php echo $S[s_name]; ?>"  <?php echo $S[s_type]; ?> target="<?php echo $S[s_target];?>" />
	<?php } ?>
  </map>
  <div><br />
</body>
</html>
<?php $db->db_close(); ?>
