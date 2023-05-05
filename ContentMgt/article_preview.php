<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$Website = "../ewt/".$_SESSION["EWT_SUSER"];

$sql_design = $db->query("SELECT * FROM article_apply WHERE a_id = '".$_GET["aid"]."' ");
$R = $db->db_fetch_array($sql_design);
	?>
<html>
<head>
<title>Article Management [<?php echo $_GET["filename"]; ?>]</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
		function showtable(c){
	for(i=1;i<5;i++){
		if(i != c){
		self.parent.article_config.document.getElementById("tr0" +i).style.display='none';
		}else{
		self.parent.article_config.document.getElementById("tr0" +i).style.display='';
		}
	}
}
</script>
</head>
<body leftmargin="0" topmargin="0" ><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td height="25" bgcolor="F7F7F7"><table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td width="5" background="../images/content_bg_line.gif"></td>
          <td > <strong>Article Design</strong></td>
          <td width="300" align="right"><strong>Sample Preview</strong>&nbsp;&nbsp;</td>
        </tr>
      </table></td>
  </tr>
   <tr>
    <td height="1" bgcolor="AAAAAA"></td>
  </tr>
      <tr>
    <td height="1" bgcolor="716F64"></td>
  </tr>
  <tr> 
    <td align="center" valign="top">&nbsp;<table width="<?php echo $R["AMWidth"]; ?>" border="1" align="center" cellpadding="0" cellspacing="0"  bordercolor="#CCCCCC"  id="tbbody" style="cursor:hand;border:dashed 1px;">
  <tr>
          <td height="<?php echo $R["AMHeadH"]; ?>" bgcolor="<?php echo $R["AMHeadBG"]; ?>" id="bg01" style="cursor:hand;border:dashed 1px;"  onClick="showtable('2')" <?php if($R["AMHeadP"] != ""){ echo "background=\"".$Website."/".$R["AMHeadP"]."\""; } ?>><?php if($R["AMBulletSP"] == ""){ echo "<img name=\"img02\" src=\"../images/o.gif\"   align=\"absmiddle\">"; }elseif($R["AMBulletSP"] == "@first_news#"){ echo "<img name=\"img02\" src=\"../images/a_news_pic1.gif\"   align=\"absmiddle\">"; }else{ echo "<img name=\"img02\" src=\"".$Website."/".$R["AMBulletSP"]."\"   align=\"absmiddle\">"; } ?> <font face="<?php echo $R["AMHeadF"]; ?>" color="<?php echo $R["AMHeadC"]; ?>" size="<?php echo $R["AMHeadS"]; ?>"><span id="name01" style="<?php if($R["AMUseHead"] != "Y"){ echo "display:none;"; } ?><?php if($R["AMHeadB"]=="Y"){ echo "font-Weight:bold;"; } ?><?php if($R["AMHeadI"]=="Y"){ echo "font-Style:italic;"; } ?>">News Group Name &gt;&gt;</span></font></td>
  </tr>
  <tr>
    <td style="cursor:hand;border:dashed 1px;"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
                <td  align="center" valign="top" onClick="showtable('1')"><?php if($R["AMBulletBP"] == ""){ echo "<img name=\"img01\" src=\"../images/o.gif\"   align=\"absmiddle\">"; }elseif($R["AMBulletBP"] == "@first_news#"){ echo "<img name=\"img01\" src=\"../images/a_news_pic.gif\"   align=\"absmiddle\">"; }else{ echo "<img name=\"img01\" src=\"".$Website."/".$R["AMBulletBP"]."\"   align=\"absmiddle\">"; } ?></td>
          <td width="100%" valign="top" id="bg02" bgcolor="<?php echo $R["AMBodyBG"]; ?>"><table width="100%" border="0" cellspacing="0" cellpadding="1" onClick="showtable('3')">
                    <tr> 
                      <td  valign="top"><?php if($R["AMBodyBP"] == ""){ echo "<img name=\"img03_1\" src=\"../images/o.gif\"   align=\"absmiddle\">"; }elseif($R["AMBodyBP"] == "@detail_news#"){ echo "<img name=\"img03_1\" src=\"../images/a_news_pic1.gif\"   align=\"absmiddle\">"; }else{ echo "<img name=\"img03_1\" src=\"".$Website."/".$R["AMBodyBP"]."\"   align=\"absmiddle\">"; } ?></td>
                      <td width="100%" valign="top"><font face="<?php echo $R["AMBodyF"]; ?>" color="<?php echo $R["AMBodyC"]; ?>" size="<?php echo $R["AMBodyS"]; ?>"><span id="name02_1" style="<?php if($R["AMBodyB"]=="Y"){ echo "font-Weight:bold;"; } ?><?php if($R["AMBodyI"]=="Y"){ echo "font-Style:italic;"; } ?>"> #1 หัวข้อข่าว 
                        - News topic <span id="namedate1" <?php if($R["AMDate"] != "Y"){ echo "style=\"display:none\""; } ?>>(<?php echo date("d/m/Y"); ?>)</span></span></font> <br><font face="<?php echo $R["AMDetailF"]; ?>" color="<?php echo $R["AMDetailC"]; ?>" size="<?php echo $R["AMDetailS"]; ?>"><span id="name05_1" style="<?php if($R["AMUseDetail"] != "Y"){ echo "display:none;"; } ?><?php if($R["AMDetailB"]=="Y"){ echo "font-Weight:bold;"; } ?><?php if($R["AMDetailI"]=="Y"){ echo "font-Style:italic;"; } ?>">News 
                        Detail ......................<br>
                        .....................................</span></font> </td>
                    </tr>
					<tr> 
                      <td valign="top"><?php if($R["AMBodyBP"] == ""){ echo "<img name=\"img03_2\" src=\"../images/o.gif\"   align=\"absmiddle\">"; }elseif($R["AMBodyBP"] == "@detail_news#"){ echo "<img name=\"img03_2\" src=\"../images/a_news_pic1.gif\"   align=\"absmiddle\">"; }else{ echo "<img name=\"img03_2\" src=\"".$Website."/".$R["AMBodyBP"]."\"   align=\"absmiddle\">"; } ?></td>
                      <td  valign="top"><font face="<?php echo $R["AMBodyF"]; ?>" color="<?php echo $R["AMBodyC"]; ?>" size="<?php echo $R["AMBodyS"]; ?>"><span id="name02_2" style="<?php if($R["AMBodyB"]=="Y"){ echo "font-Weight:bold;"; } ?><?php if($R["AMBodyI"]=="Y"){ echo "font-Style:italic;"; } ?>">#2 หัวข้อข่าว 
                        - News topic  <span id="namedate2" <?php if($R["AMDate"] != "Y"){ echo "style=\"display:none\""; } ?>>(<?php echo date("d/m/Y"); ?>)</span></span></font> <br><font face="<?php echo $R["AMDetailF"]; ?>" color="<?php echo $R["AMDetailC"]; ?>" size="<?php echo $R["AMDetailS"]; ?>"><span id="name05_2" style="<?php if($R["AMUseDetail"] != "Y"){ echo "display:none;"; } ?><?php if($R["AMDetailB"]=="Y"){ echo "font-Weight:bold;"; } ?><?php if($R["AMDetailI"]=="Y"){ echo "font-Style:italic;"; } ?>">News 
                        Detail ......................<br>
                        .....................................</span></font> </td>
                    </tr>
                  </table></td>
        </tr>
      </table></td>
  </tr>
  <tr>
          <td height="<?php echo $R["AMBOTTOMH"]; ?>" align="right" bgcolor="<?php echo $R["AMBOTTOMBG"]; ?>"  id="bg04" style="cursor:hand;border:dashed 1px;" onClick="showtable('4')" <?php if($R["AMBOTTOMP"] != ""){ echo "background=\"".$Website."/".$R["AMBOTTOMP"]."\""; } ?>><?php if($R["AMMorePic"] != ""){ echo "<img name=\"img04\" src=\"".$Website."/".$R["AMMorePic"]."\"   align=\"absmiddle\">"; }else{ echo "<img name=\"img04\" src=\"../images/o.gif\"   align=\"absmiddle\">"; } ?>
                    <font face="<?php echo $R["AMBottomF"]; ?>" color="<?php echo $R["AMBottomC"]; ?>" size="<?php echo $R["AMBottomS"]; ?>"><span id="name03" style="<?php if($R["AMBottomB"]=="Y"){ echo ";font-Weight:bold;"; } ?><?php if($R["AMBottomI"]=="Y"){ echo "font-Style:italic;"; } ?>"><?php echo $R["AMMORE"]; ?></span></font></div></td>
  </tr>
</table></td>
  </tr>
</table>


</body>
</html>
<?php $db->db_close(); ?>
