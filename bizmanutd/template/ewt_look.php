<?php
include("../../lib/permission2.php");
include("../../lib/include.php");
include("../../lib/function.php");
include("../../lib/user_config.php");
include("../../lib/connect.php");
include("../../ewt_block_function.php");
include("../../ewt_menu_preview.php");
include("../../ewt_article_preview.php");
$temp = "SELECT * FROM design_list WHERE d_id = '".$_GET["d_id"]."'";
$sql_temp= $db->query($temp);
$F = $db->db_fetch_array($sql_temp);
$Website = "";
	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK href="../../css/dragdrop.css" type=text/css rel=stylesheet>
<script language="JavaScript" src="../../js/drag_drop.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="../../js/stm31.js"></script>
<script type="text/javascript" src="js/jquery/jquery-1.2.3.pack.js"></script>
<script language="JavaScript" src="../../js/function_look_preview.js"></script>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
 <tr> 
    <td height="20" bgcolor="F7F7F7"  class="TxtNormal"><img src="../../images/palette_text.gif" width="24" height="24" align="absmiddle"> 
      <strong>Template Preview : [<?php echo $F["d_name"]; ?>] <a href="template_preview.php?d_id=<?php echo $_GET["d_id"]; ?>" target="_blank"><img src="../../images/look_view.gif" width="16" height="16" border="0" align="absmiddle"></a>
      <input type="button" name="Button" value="Save Change" onClick="autosave();" class="TxtNormal">
      </strong></td>
  </tr>
  <tr>
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr>
    <td height="1" bgcolor="AAAAAA"></td>
  </tr>
  <tr> 
    <td  align="<?php echo $F["d_site_align"]; ?>" valign="top" bgcolor="<?php echo $F["d_site_bg_c"]; ?>"  id="Demo4" <?php   if($F["d_site_bg_p"] != ""){ echo "background=\"".$Website.$F["d_site_bg_p"]."\""; }  ?> > 
	<table width="100%" height="3" border="0" cellpadding="0" cellspacing="0">
        <tr>
          <td height="3"></td>
        </tr>
      </table>
      <table width="<?php echo $F["d_site_width"]; ?>" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC"  id="tbbody">
        <tr  valign="top" >
		<!--ewt_top_design-->
          <td height="<?php echo $F["d_top_height"]; ?>" bgcolor="<?php echo $F["d_top_bg_c"]; ?>" background="<?php echo $Website.$F["d_top_bg_p"]; ?>" colspan="3"     id="tbtop" class=DragContainer overClass="OverDragContainer"><span onClick="showtable('2')"><font color="#666666" size="1" face="Tahoma" style="background-color:#CCCCCC">Top 
            Design</font></span>
			<?php
		  $sql_top = $db->query("SELECT block.BID,block.block_name,block.block_type,block.block_edit FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '3' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
		  while($TB = $db->db_fetch_row($sql_top)){
		  ?>
<DIV class=DragBox id="EWTID_S<?php echo $TB[0]; ?>EWTID_E" overClass="OverDragBox" dragClass="DragDragBox" align="left"> :: <?php echo $TB[1]; ?> ::
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr style="cursor:hand">
            <td height="20" bgcolor="F3F3EE"><img src="<?php echo icon_block($TB[2]); ?>" width="20" height="20" align="absmiddle">&nbsp;&nbsp;&nbsp;&nbsp;<img id="EWTpospic" src="../../images/bar_down.gif" width="20" height="20" onClick="show_d(this,'tr<?php echo $TB[0]; ?>')">&nbsp;&nbsp;<img src="../../images/bar_edit.gif" width="20" height="20" onClick="edit_d('<?php echo base64_encode("z".$TB[0]."z00"); ?>')">&nbsp;&nbsp;<img src="../../images/bar_delete.gif" width="20" height="20" onClick="delete_d('<?php echo $TB[0]; ?>')"></td>
  </tr>
  <tr id="tr<?php echo $TB[0]; ?>" style="display:none">
    <td  style="cursor: no-drop;" onClick="return false;" id="td<?php echo $TB[0]; ?>"><?php echo show_block_edit($TB[0]); ?></td>
  </tr>
</table>

</DIV>
		<?php } ?>
			</td>
			<!--ewt_top_design-->
        </tr>
        <tr valign="top" > 
		<!--ewt_left_design-->
          <td width="<?php echo $F["d_site_left"]; ?>" bgcolor="<?php echo $F["d_left_bg_c"]; ?>"  background="<?php echo $Website.$F["d_left_bg_p"]; ?>" id="tbleft" class=DragContainer overClass="OverDragContainer"><span onClick="showtable('3')"><font color="#666666" size="1" face="Tahoma" style="background-color:#CCCCCC">Left 
            Design </font></span>
			<?php
		  $sql_left = $db->query("SELECT block.BID,block.block_name,block.block_type,block.block_edit FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '1' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV class=DragBox id="EWTID_S<?php echo $LB[0]; ?>EWTID_E" overClass="OverDragBox" dragClass="DragDragBox" align="left"> :: <?php echo $LB[1]; ?> :: 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr style="cursor:hand">
            <td height="20" bgcolor="F3F3EE"><img src="<?php echo icon_block($LB[2]); ?>" width="20" height="20" align="absmiddle">&nbsp;&nbsp;&nbsp;&nbsp;<img id="EWTpospic" src="../../images/bar_down.gif" width="20" height="20" onClick="show_d(this,'tr<?php echo $LB[0]; ?>')">&nbsp;&nbsp;<img src="../../images/bar_edit.gif" width="20" height="20" onClick="edit_d('<?php echo base64_encode("z".$LB[0]."z00"); ?>')">&nbsp;&nbsp;<img src="../../images/bar_delete.gif" width="20" height="20" onClick="delete_d('<?php echo $LB[0]; ?>')"></td>
  </tr>
  <tr id="tr<?php echo $LB[0]; ?>" style="display:none">
    <td  style="cursor: no-drop;" onClick="return false;" id="td<?php echo $LB[0]; ?>"><?php echo show_block_edit($LB[0]); ?></td>
  </tr>
</table></DIV>
		<?php } ?>
			</td>
			<!--ewt_left_design-->
			<!--ewt_content_design-->
          <td width="<?php echo $F["d_site_content"]; ?>" bgcolor="<?php echo $F["d_body_bg_c"]; ?>" background="<?php echo $Website.$F["d_body_bg_p"]; ?>" height="160"   id="tbcontent" class=DragContainer overClass="OverDragContainer"><span onClick="showtable('4')"><font color="#666666" size="1" face="Tahoma" style="background-color:#CCCCCC">Content 
            Design </font></span>
			<?php
		  $sql_content = $db->query("SELECT block.BID,block.block_name,block.block_type,block.block_edit FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '5' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
		  while($CB = $db->db_fetch_row($sql_content)){
		  ?>
<DIV class=DragBox id="EWTID_S<?php echo $CB[0]; ?>EWTID_E" overClass="OverDragBox" dragClass="DragDragBox" align="left"> :: <?php echo $CB[1]; ?> :: 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr style="cursor:hand">
            <td height="20" bgcolor="F3F3EE"><img src="<?php echo icon_block($CB[2]); ?>" width="20" height="20" align="absmiddle">&nbsp;&nbsp;&nbsp;&nbsp;<img id="EWTpospic" src="../../images/bar_down.gif" width="20" height="20" onClick="show_d(this,'tr<?php echo $CB[0]; ?>')">&nbsp;&nbsp;<img src="../../images/bar_edit.gif" width="20" height="20" onClick="edit_d('<?php echo base64_encode("z".$CB[0]."z00"); ?>')">&nbsp;&nbsp;<img src="../../images/bar_delete.gif" width="20" height="20" onClick="delete_d('<?php echo $CB[0]; ?>')"></td>
  </tr>
  <tr id="tr<?php echo $CB[0]; ?>" style="display:none">
    <td  style="cursor: no-drop;" onClick="return false;" id="td<?php echo $CB[0]; ?>"><?php echo show_block_edit($CB[0]); ?></td>
  </tr>
</table></DIV>
		<?php } ?>
			</td>
			<!--ewt_content_design-->
			<!--ewt_right_design-->
          <td width="<?php echo $F["d_site_right"]; ?>" bgcolor="<?php echo $F["d_right_bg_c"]; ?>" background="<?php echo $Website.$F["d_right_bg_p"]; ?>" id="tbright" class=DragContainer overClass="OverDragContainer"><span onClick="showtable('5')"><font color="#666666" size="1" face="Tahoma" style="background-color:#CCCCCC">Right 
            Design </font></span>
			<?php
		  $sql_right = $db->query("SELECT block.BID,block.block_name,block.block_type,block.block_edit FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '2' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
		  while($RB = $db->db_fetch_row($sql_right)){
		  ?>
<DIV class=DragBox id="EWTID_S<?php echo $RB[0]; ?>EWTID_E" overClass="OverDragBox" dragClass="DragDragBox" align="left"> :: <?php echo $RB[1]; ?> :: 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr style="cursor:hand">
            <td height="20" bgcolor="F3F3EE"><img src="<?php echo icon_block($RB[2]); ?>" width="20" height="20" align="absmiddle">&nbsp;&nbsp;&nbsp;&nbsp;<img id="EWTpospic" src="../../images/bar_down.gif" width="20" height="20" onClick="show_d(this,'tr<?php echo $RB[0]; ?>')">&nbsp;&nbsp;<img src="../../images/bar_edit.gif" width="20" height="20" onClick="edit_d('<?php echo base64_encode("z".$RB[0]."z00"); ?>')">&nbsp;&nbsp;<img src="../../images/bar_delete.gif" width="20" height="20" onClick="delete_d('<?php echo $RB[0]; ?>')"></td>
  </tr>
  <tr id="tr<?php echo $RB[0]; ?>" style="display:none">
    <td  style="cursor: no-drop;" onClick="return false;" id="td<?php echo $RB[0]; ?>"><?php echo show_block_edit($RB[0]); ?></td>
  </tr>
</table></DIV>
		<?php } ?>
			</td>
			<!--ewt_right_design-->
        </tr>
        <tr valign="top"  > 
		<!--ewt_bottom_design-->
          <td height="<?php echo $F["d_bottom_height"]; ?>" bgcolor="<?php echo $F["d_bottom_bg_c"]; ?>" background="<?php echo $Website.$F["d_bottom_bg_p"]; ?>" colspan="3"   id="tbbottom" class=DragContainer overClass="OverDragContainer"><span onClick="showtable('6')"><font color="#666666" size="1" face="Tahoma" style="background-color:#CCCCCC">Bottom 
            Design </font></span>
			<?php
		  $sql_bottom = $db->query("SELECT block.BID,block.block_name,block.block_type,block.block_edit FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '4' AND design_block.d_id = '".$_GET["d_id"]."' ORDER BY design_block.position ASC");
		  while($BB = $db->db_fetch_row($sql_bottom)){
		  ?>
<DIV class=DragBox id="EWTID_S<?php echo $BB[0]; ?>EWTID_E" overClass="OverDragBox" dragClass="DragDragBox" align="left"> :: <?php echo $BB[1]; ?> :: 
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr style="cursor:hand">
            <td height="20" bgcolor="F3F3EE"><img src="<?php echo icon_block($BB[2]); ?>" width="20" height="20" align="absmiddle">&nbsp;&nbsp;&nbsp;&nbsp;<img id="EWTpospic" src="../../images/bar_down.gif" width="20" height="20" onClick="show_d(this,'tr<?php echo $BB[0]; ?>')">&nbsp;&nbsp;<img src="../../images/bar_edit.gif" width="20" height="20" onClick="edit_d('<?php echo base64_encode("z".$BB[0]."z00"); ?>')">&nbsp;&nbsp;<img src="../../images/bar_delete.gif" width="20" height="20" onClick="delete_d('<?php echo $BB[0]; ?>')"></td>
  </tr>
  <tr id="tr<?php echo $BB[0]; ?>" style="display:none">
    <td  style="cursor: no-drop;" onClick="return false;" id="td<?php echo $BB[0]; ?>"><?php echo show_block_edit($BB[0]); ?></td>
  </tr>
</table></DIV>
		<?php } ?>
			</td>
			<!--ewt_bottom_design-->
        </tr>
      </table>
      
      <br>
    </td>
  </tr>
</table>
<iframe name="auto_save" src="../../ewt_auto_send1.php?d_id=<?php echo $_GET["d_id"]; ?>"  frameborder="0"  width="1" height="1" scrolling="no" ></iframe>
</body>
</html>
<?php $db->db_close(); ?>
