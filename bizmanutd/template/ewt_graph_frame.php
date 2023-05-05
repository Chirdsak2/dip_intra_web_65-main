<?php
include("../../lib/permission2.php");
include("../../lib/include.php");
include("../../lib/function.php");
include("../../lib/user_config.php");
include("../../lib/connect.php");
?>
<html>
<head>
<title>Graph Management [<?php echo $_GET["filename"]; ?>]</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" >
<?php
$sql_graph = $db->query("SELECT * FROM graph_index WHERE graph_id = '".$_GET["graph_id"]."'");
$R = $db->db_fetch_array($sql_graph);
?>
<table width="100%" height="90%" border="0" cellpadding="0" cellspacing="0" bgcolor="#000000">
                            <tr> 
                              <td  bgcolor="#FFFFFF"><div align="<?php echo $R["graph_align"]; ?>">
<!--img src="graph_view.php?graph_id=<?php echo $_GET["graph_id"]; ?>" width="<?php echo $R["graph_width"]; ?>" height="<?php echo $R["graph_height"]; ?>"><br-->
<?php
      //$fileGraph="../ewt/".$_SESSION["EWT_SUSER"]."/graph/graph_".$_GET["graph_id"].'.xml';		  
	 
	 $fileGraph="graph/graph_".$_GET["graph_id"].'.xml';		  
	 
	 if($R['graph_type']=='Area'){
	     $Graph_swf="FCF_MSArea2D.swf";
	 }else  if($R['graph_type']=='Line'){
	     $Graph_swf="FCF_MSLine.swf";
	 }else if($R['graph_type']=='Column'){
	     $Graph_swf="FCF_MSColumn2D.swf";
	 }else if($R['graph_type']=='Column3d'){
	     $Graph_swf="FCF_MSColumn3D.swf";
	 }else if($R['graph_type']=='Bar' or $R['graph_type']=='Bar3d'){
	     $Graph_swf="FCF_MSBar2D.swf";
	 }else if($R['graph_type']=='Pie'){
	     $Graph_swf="FCF_Pie2D.swf";
		  $fileGraph="graph/gpie_".$_GET["graph_id"].'.xml';
	 }else if($R['graph_type']=='Pie3d'){
	     $Graph_swf="FCF_Pie3D.swf";
		  $fileGraph="graph/gpie_".$_GET["graph_id"].'.xml';
	 }
	 
?>
<OBJECT classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,0,0" width="<?php echo $R["graph_width"]; ?>" height="<?php echo $R["graph_height"]; ?>" id="Column3D" >
   <param name="movie" value="chart/<?php echo $Graph_swf; ?>" />
   <param name="FlashVars" value="&dataURL=<?php echo $fileGraph; ?>&chartWidth=<?php echo $R["graph_width"]; ?>&chartHeight=<?php echo $R["graph_height"]; ?>">
   <param name="quality" value="high" />
   <embed src="chart/<?php echo $Graph_swf; ?>" quality="high" name="Column3D"    flashVars="&dataURL=<?php echo $fileGraph; ?>&chartWidth=<?php echo $R["graph_width"]; ?>&chartHeight=<?php echo $R["graph_height"]; ?>" width="<?php echo $R["graph_width"]; ?>" height="<?php echo $R["graph_height"]; ?>"type="application/x-shockwave-flash" pluginspage="http://www.macromedia.com/go/getflashplayer" />
</object>
</div></td>
                            </tr>
                          </table>
</body>
</html>
<?php $db->db_close(); ?>
