<?php
	include("../../lib/permission2.php");
	include("../../lib/include.php");
	include("../../lib/function.php");
	include("../../lib/user_config.php");
	include("../../lib/connect.php");
	include("../../ewt_block_function.php");
	include("../../ewt_menu_preview.php");
	include("../../ewt_article_preview.php");
	
	$sql_index = $db->query("SELECT * FROM temp_index WHERE filename = '".$_GET["filename"]."' ");
	$F = $db->db_fetch_array($sql_index);
	if(substr_count($_GET["filename"], "___") > 0 ) {
		$default_filename = substr($_GET["filename"], 0, strpos($_GET["filename"], '___'));
	} else {
		$default_filename = $_GET["filename"];
	}
	$array_language = array(array("Default", "", $default_filename));
	$sql_language = $db->query("select * from lang_config where lang_config_status ='O' order by lang_config_name asc");
	while($row_language = $db->db_fetch_array($sql_language)) {
		array_push($array_language, array($row_language['lang_config_name'], $row_language['lang_config_suffix'], $default_filename."___".$row_language['lang_config_suffix']));
	}
	//ar_dump($array_language);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<LINK href="../../css/dragdrop.css" type="text/css" rel="stylesheet">
<script language="JavaScript" src="../../js/drag_drop.js"></script>
<script type="text/javascript" language="JavaScript1.2" src="../../js/stm31.js"></script>
<script type="text/javascript" src="js/jquery/jquery-1.2.3.pack.js"></script>
<script language="JavaScript" src="../../js/function_preview.js"></script>
<script language="javascript">
function newLanguage(lang, defaultFilename) {
	//alert(lang);
	win2 = window.open('<?php echo $EWT_PATH; ?>ContentMgt/content_function.php?file_name='+defaultFilename+'&file_suffix='+lang+'&Flag=ChangeLanguage','ContentNew','top=100,left=80,width=640,height=370,resizable=1,status=0');
	win2.focus();
}
function editconfirm(c){
	if(confirm('This WebBlock is template !\nAre you sure to edit this WebBlock?')){
		edit_d(c);
	}
}
</script>
</head>
<body  id=Demo4 leftmargin="0" topmargin="0" <?php  if($F["d_site_bg_c"] != ""){ echo "bgcolor=\"".$F["d_site_bg_c"]."\""; }  if($F["d_site_bg_p"] != ""){ echo "background=\"".$F["d_site_bg_p"]."\""; }  ?>>
&nbsp;<span id="formtext"  class="TxtNormal"  style="background-color:#F8F8F8"> [Page : <?php echo $_GET["filename"]; ?>]&nbsp;&nbsp;&nbsp;[Language&nbsp;:&nbsp;
<input type="hidden" name="page" id="page" value="<?php echo $_GET["filename"]; ?>">
<?php
for($i = 0; $i<count($array_language); $i++) {
	if($array_language[$i][2] == $_GET["filename"]) {
		echo '<strong>'.$array_language[$i][0].'</strong>';
	} else {
		echo '<a href="#new" onClick="newLanguage(\''.$array_language[$i][1].'\', \''.$default_filename.'\')">'.$array_language[$i][0].'</a>';
	}
	if($i < count($array_language)-1) {
		echo "&nbsp;|&nbsp;";
	}
}
?>
]</span>
<p></p>
<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0">
	<tr>
		<td valign="top">
			<table width="<?php echo $F["d_site_width"]; ?>" border="1" cellpadding="0" cellspacing="0" bordercolor="#CCCCCC"  id="tbbody" align="<?php echo $F["d_site_align"]; ?>">
				<tr  valign="top" >
					<td height="<?php echo $F["d_top_height"]; ?>" bgcolor="<?php echo $F["d_top_bg_c"]; ?>" background="<?php echo $F["d_top_bg_p"]; ?>" colspan="3"     id="tbtop" class=DragContainer overClass="OverDragContainer"><div style="display:none" id="<!--ewt_top_design-->"></div><span ><font color="#666666" size="1" face="Tahoma" style="background-color:#CCCCCC">Top Design</font></span>
						<?php
							$sql_top = $db->query("SELECT block.BID,block.block_name,block.block_type,block.block_edit FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '3' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
							while($TB = $db->db_fetch_row($sql_top)) {
						?>
						<DIV class=DragBox id="EWTID_S<?php echo $TB[0]; ?>EWTID_E" overClass="OverDragBox" dragClass="DragDragBox" align="left"> :: <?php echo $TB[1]; ?> ::
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr style="cursor:hand">
									<td height="20" bgcolor="F3F3EE"><img src="<?php echo icon_block($TB[2]); ?>" width="20" height="20" align="absmiddle">&nbsp;&nbsp;&nbsp;&nbsp;<img id="EWTpospic" src="../../images/bar_down.gif" width="20" height="20" onClick="show_d(this,'tr<?php echo $TB[0]; ?>')">&nbsp;&nbsp;<img src="../../images/<?php if($TB[3] == "Y"){ echo "bar_edit.gif"; }else{ echo "bar_block.gif"; } ?>" width="20" height="20" <?php if($TB[3] == "Y"){ ?>onClick="edit_d('<?php echo base64_encode("z".$TB[0]."z00"); ?>')"<?php }else{ ?>onClick="editconfirm('<?php echo base64_encode("z".$TB[0]."z00"); ?>')"<?php } ?>>&nbsp;&nbsp;<img src="../../images/<?php if($TB[3] == "Y"){ echo "bar_delete.gif"; }else{ echo "bar_block.gif"; } ?>" width="20" height="20" <?php if($TB[3] == "Y"){ ?>onClick="delete_d('<?php echo $TB[0]; ?>')"<?php } ?>></td>
								</tr>
								<tr id="tr<?php echo $TB[0]; ?>" style="display:none">
									<td  style="cursor: no-drop;" onClick="return false;" id="td<?php echo $TB[0]; ?>"><?php echo show_block_edit($TB[0]); ?></td>
								</tr>
							</table>
						</DIV>
						<?php } ?>
					</td>
				</tr>
				<tr valign="top" > 
					<td width="<?php echo $F["d_site_left"]; ?>" bgcolor="<?php echo $F["d_left_bg_c"]; ?>"  background="<?php echo $F["d_left_bg_p"]; ?>" id="tbleft" class=DragContainer overClass="OverDragContainer"><div style="display:none" id="<!--ewt_top_design-->"></div><div style="display:none" id="<!--ewt_left_design-->"></div><span ><font color="#666666" size="1" face="Tahoma" style="background-color:#CCCCCC">Left Design </font></span>
						<?php
							$sql_left = $db->query("SELECT block.BID,block.block_name,block.block_type,block.block_edit FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '1' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
							while($LB = $db->db_fetch_row($sql_left)){
						?>
						<DIV class=DragBox id="EWTID_S<?php echo $LB[0]; ?>EWTID_E" overClass="OverDragBox" dragClass="DragDragBox" align="left"> :: <?php echo $LB[1]; ?> :: 
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr style="cursor:hand">
									<td height="20" bgcolor="F3F3EE"><img src="<?php echo icon_block($LB[2]); ?>" width="20" height="20" align="absmiddle">&nbsp;&nbsp;&nbsp;&nbsp;<img id="EWTpospic" src="../../images/bar_down.gif" width="20" height="20" onClick="show_d(this,'tr<?php echo $LB[0]; ?>')">&nbsp;&nbsp;<img src="../../images/<?php if($LB[3] == "Y"){ echo "bar_edit.gif"; }else{ echo "bar_block.gif"; } ?>" width="20" height="20" <?php if($LB[3] == "Y"){ ?>onClick="edit_d('<?php echo base64_encode("z".$LB[0]."z00"); ?>')"<?php }else{ ?>onClick="editconfirm('<?php echo base64_encode("z".$LB[0]."z00"); ?>')"<?php } ?>>&nbsp;&nbsp;<img src="../../images/<?php if($LB[3] == "Y"){ echo "bar_delete.gif"; }else{ echo "bar_block.gif"; } ?>" width="20" height="20" <?php if($LB[3] == "Y"){ ?>onClick="delete_d('<?php echo $LB[0]; ?>')"<?php } ?>></td>
								</tr>
								<tr id="tr<?php echo $LB[0]; ?>" style="display:none">
									<td  style="cursor: no-drop;" onClick="return false;" id="td<?php echo $LB[0]; ?>"><?php echo show_block_edit($LB[0]); ?></td>
								</tr>
							</table>
						</DIV>
						<?php } ?>
					</td>
					<td width="<?php echo $F["d_site_content"]; ?>" bgcolor="<?php echo $F["d_body_bg_c"]; ?>" background="<?php echo $F["d_body_bg_p"]; ?>" height="160"   id="tbcontent" class=DragContainer overClass="OverDragContainer"><div style="display:none" id="<!--ewt_left_design-->"></div><div style="display:none" id="<!--ewt_content_design-->"></div><span ><font color="#666666" size="1" face="Tahoma" style="background-color:#CCCCCC">Content Design </font></span>
						<?php
							$sql_content = $db->query("SELECT block.BID,block.block_name,block.block_type,block.block_edit FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '5' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
							while($CB = $db->db_fetch_row($sql_content)){
						?>
						<DIV class=DragBox id="EWTID_S<?php echo $CB[0]; ?>EWTID_E" overClass="OverDragBox" dragClass="DragDragBox" align="left"> :: <?php echo $CB[1]; ?> :: 
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr style="cursor:hand">
									<td height="20" bgcolor="F3F3EE"><img src="<?php echo icon_block($CB[2]); ?>" width="20" height="20" align="absmiddle">&nbsp;&nbsp;&nbsp;&nbsp;<img id="EWTpospic" src="../../images/bar_down.gif" width="20" height="20" onClick="show_d(this,'tr<?php echo $CB[0]; ?>')">&nbsp;&nbsp;<img src="../../images/<?php if($CB[3] == "Y"){ echo "bar_edit.gif"; }else{ echo "bar_block.gif"; } ?>" width="20" height="20" <?php if($CB[3] == "Y"){ ?>onClick="edit_d('<?php echo base64_encode("z".$CB[0]."z00"); ?>')"<?php }else{ ?>onClick="editconfirm('<?php echo base64_encode("z".$CB[0]."z00"); ?>')"<?php } ?>>&nbsp;&nbsp;<img src="../../images/<?php if($CB[3] == "Y"){ echo "bar_delete.gif"; }else{ echo "bar_block.gif"; } ?>" width="20" height="20" <?php if($CB[3] == "Y"){ ?>onClick="delete_d('<?php echo $CB[0]; ?>')"<?php } ?>></td>
								</tr>
								<tr id="tr<?php echo $CB[0]; ?>" style="display:none">
									<td  style="cursor: no-drop;" onClick="return false;" id="td<?php echo $CB[0]; ?>"><?php echo show_block_edit($CB[0]); ?></td>
								</tr>
							</table>
						</DIV>
						<?php } ?>
					</td>
					<td width="<?php echo $F["d_site_right"]; ?>" bgcolor="<?php echo $F["d_right_bg_c"]; ?>" background="<?php echo $F["d_right_bg_p"]; ?>" id="tbright" class=DragContainer overClass="OverDragContainer"><div style="display:none" id="<!--ewt_content_design-->"></div><div style="display:none" id="<!--ewt_right_design-->"></div><span ><font color="#666666" size="1" face="Tahoma" style="background-color:#CCCCCC">Right Design </font></span>
						<?php
							$sql_right = $db->query("SELECT block.BID,block.block_name,block.block_type,block.block_edit FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '2' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
							while($RB = $db->db_fetch_row($sql_right)){
						?>
						<DIV class=DragBox id="EWTID_S<?php echo $RB[0]; ?>EWTID_E" overClass="OverDragBox" dragClass="DragDragBox" align="left"> :: <?php echo $RB[1]; ?> :: 
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr style="cursor:hand">
									<td height="20" bgcolor="F3F3EE"><img src="<?php echo icon_block($RB[2]); ?>" width="20" height="20" align="absmiddle">&nbsp;&nbsp;&nbsp;&nbsp;<img id="EWTpospic" src="../../images/bar_down.gif" width="20" height="20" onClick="show_d(this,'tr<?php echo $RB[0]; ?>')">&nbsp;&nbsp;<img src="../../images/<?php if($RB[3] == "Y"){ echo "bar_edit.gif"; }else{ echo "bar_block.gif"; } ?>" width="20" height="20" <?php if($RB[3] == "Y"){ ?>onClick="edit_d('<?php echo base64_encode("z".$RB[0]."z00"); ?>')"<?php }else{ ?>onClick="editconfirm('<?php echo base64_encode("z".$RB[0]."z00"); ?>')"<?php } ?>>&nbsp;&nbsp;<img src="../../images/<?php if($RB[3] == "Y"){ echo "bar_delete.gif"; }else{ echo "bar_block.gif"; } ?>" width="20" height="20" <?php if($RB[3] == "Y"){ ?>onClick="delete_d('<?php echo $RB[0]; ?>')"<?php } ?>></td>
								</tr>
								<tr id="tr<?php echo $RB[0]; ?>" style="display:none">
									<td  style="cursor: no-drop;" onClick="return false;" id="td<?php echo $RB[0]; ?>"><?php echo show_block_edit($RB[0]); ?></td>
								</tr>
							</table>
						</DIV>
						<?php } ?>
					</td>
				</tr>
				<tr valign="top"> 
					<td height="<?php echo $F["d_bottom_height"]; ?>" bgcolor="<?php echo $F["d_bottom_bg_c"]; ?>" background="<?php echo $F["d_bottom_bg_p"]; ?>" colspan="3"   id="tbbottom" class=DragContainer overClass="OverDragContainer"><div style="display:none" id="<!--ewt_right_design-->"></div><div style="display:none" id="<!--ewt_bottom_design-->"></div><span ><font color="#666666" size="1" face="Tahoma" style="background-color:#CCCCCC">Bottom Design </font></span>
						<?php
							$sql_bottom = $db->query("SELECT block.BID,block.block_name,block.block_type,block.block_edit FROM block INNER JOIN block_function ON block_function.BID = block.BID WHERE block_function.side = '4' AND block_function.filename = '".$_GET["filename"]."' ORDER BY block_function.position ASC");
							while($BB = $db->db_fetch_row($sql_bottom)){
						?>
						<DIV class=DragBox id="EWTID_S<?php echo $BB[0]; ?>EWTID_E" overClass="OverDragBox" dragClass="DragDragBox" align="left"> :: <?php echo $BB[1]; ?> :: 
							<table width="100%" border="0" cellspacing="0" cellpadding="0">
								<tr style="cursor:hand">
									<td height="20" bgcolor="F3F3EE"><img src="<?php echo icon_block($BB[2]); ?>" width="20" height="20" align="absmiddle">&nbsp;&nbsp;&nbsp;&nbsp;<img id="EWTpospic" src="../../images/bar_down.gif" width="20" height="20" onClick="show_d(this,'tr<?php echo $BB[0]; ?>')">&nbsp;&nbsp;<img src="../../images/<?php if($BB[3] == "Y"){ echo "bar_edit.gif"; }else{ echo "bar_block.gif"; } ?>" width="20" height="20" <?php if($BB[3] == "Y"){ ?>onClick="edit_d('<?php echo base64_encode("z".$BB[0]."z00"); ?>')"<?php }else{ ?>onClick="editconfirm('<?php echo base64_encode("z".$BB[0]."z00"); ?>')"<?php } ?>>&nbsp;&nbsp;<img src="../../images/<?php if($BB[3] == "Y"){ echo "bar_delete.gif"; }else{ echo "bar_block.gif"; } ?>" width="20" height="20" <?php if($BB[3] == "Y"){ ?>onClick="delete_d('<?php echo $BB[0]; ?>')"<?php } ?>></td>
								</tr>
								<tr id="tr<?php echo $BB[0]; ?>" style="display:none">
									<td  style="cursor: no-drop;" onClick="return false;" id="td<?php echo $BB[0]; ?>"><?php echo show_block_edit($BB[0]); ?></td>
								</tr>
							</table>
						</DIV>
						<?php } ?>
					</td>
				</tr>
			</table><div style="display:none" id="<!--ewt_bottom_design-->"></div><br>
			<img id="EWTpospic" src="../../images/o.gif" width="1" height="1">
			<iframe name="auto_save" src="../../ewt_auto_send.php?filename=<?php echo $_GET["filename"]; ?>"  frameborder="0"  width="1" height="1" scrolling="no" ></iframe>
		</td>
	</tr>
</table>
</body>
</html>
<?php $db->db_close(); ?>
