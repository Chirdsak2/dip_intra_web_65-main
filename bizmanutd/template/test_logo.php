<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");
$filename_temp = "research_flame";

$sql_index = $db->query("SELECT * FROM temp_index WHERE filename = '".$filename_temp."'  ");
$F = $db->db_fetch_array($sql_index);
	?>
<html>
<head>
  <title></title>
   <meta content="MSHTML 6.00.5730.11" name="GENERATOR" />
   <script type='text/javascript' src='js/jquery/jquery-1.2.3.min.js'></script>
<script type='text/javascript' src='js/jquery/jquery.jqDock.js'></script>
<style type="text/css">
<!--
#icon_botton{
	PADDING-LEFT: 0px; POSITION: relative; TOP: 0px
}

DIV.jqDockLabel {
	BORDER-RIGHT: 0px; PADDING-RIGHT: 14px; BORDER-TOP: 0px; PADDING-LEFT: 4px; FONT-WEIGHT: bold; FONT-SIZE: 14px; PADDING-BOTTOM: 0px; BORDER-LEFT: 0px; COLOR: #000000; PADDING-TOP: 0px; BORDER-BOTTOM: 8px; FONT-STYLE: italic; WHITE-SPACE: nowrap; BACKGROUND-COLOR: transparent
}
DIV.jqDockLabelLink {
	CURSOR: pointer
}
DIV.jqDockLabelImage {
	CURSOR: default
}
#icon_botton DIV.jqDockLabel {
	FONT-WEIGHT: normal; FONT-SIZE: 12px; PADDING-BOTTOM: 0px; COLOR: #000000; PADDING-TOP: 1px; 
}
.demo {
	DISPLAY: none
}
.demo IMG {
	BORDER-RIGHT: 0px; PADDING-RIGHT: 0px; BORDER-TOP: 0px; PADDING-LEFT: 0px; PADDING-BOTTOM: 0px; VERTICAL-ALIGN: top; BORDER-LEFT: 0px; WIDTH: 48px; PADDING-TOP: 0px; BORDER-BOTTOM: 0px; HEIGHT: 48px
}
-->
</style>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"></head>
<body>
<div id="icon_botton" class="demo">
   				<a href="main.php?filename=geology_world"><img id="Image1" height="100" src="images/bottom_menu/01_off.jpg" width="74" border="0" name="Image1"  title="ท่องโลกธรณี"/></a>
                 <a href="main.php?filename=global_warming"> <img id="Image2" height="100" src="images/bottom_menu/02_off.jpg" width="66" border="0" name="Image2"  title="ภาวะโลกร้อน" /></a>
                 <a  href="main.php?filename=landslide"><img id="Image3" height="100" src="images/bottom_menu/03_off.jpg" width="70" border="0" name="Image3"  title="ดินถล่ม"/></a>
                 <a  href="main.php?filename=pms"><img id="Image4" height="100" src="images/bottom_menu/04_off.jpg" width="68" border="0" name="Image4"  title="จริยธรรมการให้บริการ"/></a>
                 <a href="main.php?filename=workser1"><img id="Image5" height="100" src="images/bottom_menu/05_off.jpg" width="68" border="0" name="Image5"  title="การปฏิบัติราชการ ทร."/></a>
                 <a href="http://www.dmr.go.th/warn/" target="_blank"><img id="Image6" height="100" src="images/bottom_menu/06_off.jpg" width="68" border="0" name="Image6"   title="รับแจ้งเหตุธรณีพิบัติ"/></a>
                 <a href="main.php?filename=doc"> <img id="Image7" height="100" src="images/bottom_menu/07_off.jpg" width="70" border="0" name="Image7"   title="ศูนย์ปฏิบัติการ"/></a>
                 <a href="main.php?filename=ancorr"><img id="Image8" height="100" src="images/bottom_menu/08_off.jpg" width="67" border="0" name="Image8"   title="ศูนย์ปฏิบัติราชการใสสะอาด"/></a>
                 <a href="main.php?filename=data4people"> <img id="Image9" height="100" src="images/bottom_menu/09_off.jpg" width="69" border="0" name="Image9"  title="ข้อมูลข่าวสารตามพรบข้อมูล"/></a>
                 <a href="http://www.dmr.go.th/e-mail/" target="_blank"><img id="Image10" height="100" src="images/bottom_menu/10_off.jpg" width="67" border="0" name="Image10"   title="webmail"/></a>
                 <a href="#"><img id="Image11" height="100" src="images/bottom_menu/11_off.jpg" width="75" border="0" name="Image11"  title="Login สำหรับสมาชิก" /></a>
</div>
</body>
</html>
<script>
	jQuery(document).ready(function(){
		var opts =
		{ align: 'right'
		, size: 70
		, labels: 'tc'
		, source: function(i){ return (this.alt) ? false : this.src.replace(/(png|gif)$/,'jpg'); }
		};
		jQuery('#icon_botton').jqDock(opts);
	});
</script>
<?php $db->db_close(); ?>
