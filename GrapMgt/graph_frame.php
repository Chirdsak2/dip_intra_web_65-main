<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$sql_graph = $db->query("SELECT * FROM graph_index WHERE graph_id = '".$_GET["graph_id"]."'");
$R = $db->db_fetch_array($sql_graph);

	?>
<html>
<head>
<title>Graph Management [<?php echo $_GET["filename"]; ?>]</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" >
<table width="100%" height="90%" border="0" cellpadding="0" cellspacing="0" bgcolor="#000000">
                            <tr> 
                              <td  bgcolor="#FFFFFF"><div align="<?php echo $R["graph_align"]; ?>"><img src="graph_view.php?graph_id=<?php echo $_GET["graph_id"]; ?>" width="<?php echo $R["graph_width"]; ?>" height="<?php echo $R["graph_height"]; ?>"><br>
<?php
	 $fileGraph="../ewt/".$_SESSION["EWT_SUSER"]."/graph/graph_".$_GET["graph_id"].'.xml';		  
	 //FCF_Pie3D.swf  FCF_MSColumn3D.swf
?>
<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="<?php echo $R["graph_width"]; ?>" height="<?php echo $R["graph_height"]; ?>" id="Column3D" >
   <param name="movie" value="../chart/FCF_MSColumn3D.swf" />
   <param name="FlashVars" value="&dataURL=<?php echo $fileGraph; ?>&chartWidth=<?php echo $R["graph_width"]; ?>&chartHeight=<?php echo $R["graph_height"]; ?>">
   <param name="quality" value="high" />
   <embed src="../chart/FCF_MSColumn3D.swf" quality="high" name="Column3D"    flashVars="&dataURL=<?php echo $fileGraph; ?>&chartWidth=<?php echo $R["graph_width"]; ?>&chartHeight=<?php echo $R["graph_height"]; ?>" width="<?php echo $R["graph_width"]; ?>" height="<?php echo $R["graph_height"]; ?>"type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>
</div></td>
                            </tr>
                          </table>
</body>
</html>
<?php $db->db_close(); ?>
