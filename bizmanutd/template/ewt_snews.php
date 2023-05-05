<?php
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");

$enc = base64_decode($_GET["s"]);
$ex = explode("@@@",$enc);
$pathall = "../".$ex[0]."/article/TEMP".$ex[1].".html";
//File url
$db->query("USE ".$EWT_DB_USER);
$sql_url = "select url,EWT_User from user_info where EWT_User = '".$ex[0]."'";
$RU = $db->db_fetch_array($db->query($sql_url));
$URL = $RU[EWT_User];
$db->query("USE ".$EWT_DB_NAME);
$temp = "SELECT * FROM design_list WHERE d_default = 'Y' ";
$sql_temp= $db->query($temp);
$RR = $db->db_fetch_array($sql_temp);

$global_theme = $RR["d_bottom_content"];
$mainwidth = "0";
			?>
<html>
<head>
<title>Preview</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<?php
include("ewt_script.php");	
?>
<script type="text/javascript" src="js/jquery/jquery.lightbox.js"></script>
		<style type="text/css">
		#lightbox{
	position: absolute;
	left: 0;
	width: 100%;
	z-index: 100;
	text-align: center;
	line-height: 0;
	}

#lightbox a img{ border: none; }

#outerImageContainer{
	position: relative;
	background-color: #fff;
	width: 250px;
	height: 250px;
	margin: 0 auto;
	}

#imageContainer{
	padding: 10px;
	}

#loading{
	position: absolute;
	top: 40%;
	left: 0%;
	height: 25%;
	width: 100%;
	text-align: center;
	line-height: 0;
	}
#hoverNav{
	position: absolute;
	top: 0;
	left: 0;
	height: 100%;
	width: 100%;
	z-index: 10;
	}
#imageContainer>#hoverNav{ left: 0;}
#hoverNav a{ outline: none;}

#prevLink, #nextLink{
	width: 49%;
	height: 100%;
	background: transparent url(mainpic/lightbox/blank.gif) no-repeat; /* Trick IE into showing hover */
	display: block;
	}
#prevLink { left: 0; float: left;}
#nextLink { right: 0; float: right;}
#prevLink:hover, #prevLink:visited:hover { background: url(mainpic/lightbox/prev.gif) left 50% no-repeat; }
#nextLink:hover, #nextLink:visited:hover { background: url(mainpic/lightbox/next.gif) right 50% no-repeat; }

/*** START : next / previous text links ***/
#nextLinkText, #prevLinkText{
color: #FF9834;
font-weight:bold;
text-decoration: none;
}
#nextLinkText{
padding-left: 0px;
}
#prevLinkText{
padding-right: 0px;
}
/*** END : next / previous text links ***/
/*** START : added padding when navbar is on top ***/

.ontop #imageData {
    padding-top: 5px;
}

/*** END : added padding when navbar is on top ***/

#imageDataContainer{
	font: 12px Verdana, Helvetica, sans-serif;
	background-color: #fff;
	margin: 0 auto;
	line-height: 1.4em;
	}

#imageData{
	padding:0 10px;
	}
#imageData #imageDetails{ width: 70%; float: left; text-align: left; }	
#imageData #caption{ font-weight: bold;	}
#imageData #numberDisplay{ display: block; clear: center; padding-bottom: 1.0em;	}
#imageData #bottomNavClose{ width: 10px; float: right;  padding-bottom: 0.7em;	}
#imageData #helpDisplay {clear: left; float: left; display: block; }

#overlay{
	position: absolute;
	top: 0;
	left: 0;
	z-index: 90;
	width: 100%;
	height: 500px;
	background-color: #000;
	filter:alpha(opacity=60);
	-moz-opacity: 0.6;
	opacity: 0.6;
	display: none;
	}
	

.clearfix:after {
	content: "."; 
	display: block; 
	height: 0; 
	clear: both; 
	visibility: hidden;
	}

* html>body .clearfix {
	display: inline-block; 
	width: 100%;
	}

* html .clearfix {
	/* Hides from IE-mac \*/
	height: 1%;
	/* End hide from IE-mac */
	}	
		</style>
</head>
<body  leftmargin="0" topmargin="0" <?php if($RR["d_site_bg_c"] != ""){ echo "bgcolor=\"".$RR["d_site_bg_c"]."\""; } ?> <?php if($RR["d_site_bg_p"] != ""){ echo "background=\"".$RR["d_site_bg_p"]."\""; } ?> >
<table id="ewt_main_structure" width="<?php echo $RR["d_site_width"]; ?>" border="0" cellpadding="0" cellspacing="0" align="<?php echo $RR["d_site_align"]; ?>">
        <tr  valign="top" > 
          <td id="ewt_main_structure_top" height="<?php echo $RR["d_top_height"]; ?>" bgcolor="<?php echo $RR["d_top_bg_c"]; ?>" background="<?php echo $RR["d_top_bg_p"]; ?>" colspan="3" >
		  <?php
			$mainwidth = $RR["d_site_width"];
			?><?php
		  $sql_top = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '3' AND design_block.d_id = '".$RR["d_id"]."' ORDER BY design_block.position ASC");
		  while($TB = $db->db_fetch_row($sql_top)){
		  ?>
<DIV ><?php echo show_block($TB[0]); ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td id="ewt_main_structure_left" width="<?php echo $RR["d_site_left"]; ?>" bgcolor="<?php echo $RR["d_left_bg_c"]; ?>" background="<?php echo $RR["d_left_bg_p"]; ?>">
		  <?php
			$mainwidth = $RR["d_site_left"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '1' AND design_block.d_id = '".$RR["d_id"]."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
		  </td>
          
    <td id="ewt_main_structure_body" width="<?php echo $RR["d_site_content"]; ?>" bgcolor="<?php echo $RR["d_body_bg_c"]; ?>" height="160" background="<?php echo $RR["d_body_bg_p"]; ?>">
	<?php
			$mainwidth = $RR["d_site_content"];
			?><?php
		  $sql_content = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '5' AND design_block.d_id = '".$RR["d_id"]."' ORDER BY design_block.position ASC");
		  while($CB = $db->db_fetch_row($sql_content)){
		  ?>
<DIV ><?php echo show_block($CB[0]); ?></DIV>
		<?php } ?>
		<?php 
		$fw = @fopen($pathall, "r");
				 if($fw){ 
					while($html = @fgets($fw, 1024)){
					$line .= $html;
					}
				}
				echo $line;
				// echo ereg_replace ("href=\"phpThumb.php?src=../".$URL."/", " href=\"ewt_dl_file.php?url=", $line);//$line;
		  @fclose($fw);
		  ?>
	</td>
          <td id="ewt_main_structure_right" width="<?php echo $RR["d_site_right"]; ?>" bgcolor="<?php echo $RR["d_right_bg_c"]; ?>" background="<?php echo $RR["d_right_bg_p"]; ?>">
		  <?php
			$mainwidth = $RR["d_site_right"];
			?><?php
		  $sql_right = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '2' AND design_block.d_id = '".$RR["d_id"]."' ORDER BY design_block.position ASC");
		  while($RRB = $db->db_fetch_row($sql_right)){
		  ?>
<DIV ><?php echo show_block($RRB[0]); ?></DIV>
		<?php } ?>
		  </td>
        </tr>
        <tr valign="top" > 
          <td id="ewt_main_structure_bottom" height="<?php echo $RR["d_bottom_height"]; ?>" bgcolor="<?php echo $RR["d_bottom_bg_c"]; ?>" colspan="3" background="<?php echo $RR["d_bottom_bg_p"]; ?>">
		  <?php
			$mainwidth = $RR["d_site_width"];
			?><?php
		  $sql_bottom = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '4' AND design_block.d_id = '".$RR["d_id"]."' ORDER BY design_block.position ASC");
		  while($BB = $db->db_fetch_row($sql_bottom)){
		  ?>
<DIV><?php echo show_block($BB[0]); ?></DIV>
		<?php } ?></td>
        </tr>
      </table>
</body>
</html>
<script>
	$(document).ready(function(){
		$(".lightbox").lightbox({
			category_id : '',
			filename : '<?php echo $filename; ?>',
			page : '',
			BID : '',
			vote : '0',
			comment : '0',
			send : '0',
			showimg : 1
		});
	});
</script>
<?php $db->db_close(); ?>
