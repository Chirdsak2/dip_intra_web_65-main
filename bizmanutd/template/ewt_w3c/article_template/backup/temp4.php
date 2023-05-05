					<table width="90%" border="0" align="center" cellpadding="5" cellspacing="5">
					  <tr>
						<td align="center"><span class="ewtfunction"><?php echo $R["n_topic"]; ?></span></td>
					  </tr>
					</table>

<table width="99%" border="0" align="center" cellpadding="4" cellspacing="1" bgcolor="#CCCCCC">
<?php
$b = 0;
$sql = $db->query("SELECT MAX(at_type_row),count(at_type_row) FROM article_detail WHERE n_id = '$nid' AND at_type_col = '1' ");
$M = $db->db_fetch_row($sql);
for($x=1;$x<=$M[0];$x++){
$sql_l = $db->query("SELECT * FROM article_detail WHERE n_id = '$nid' AND at_type_row = '$x' AND at_type_col = '1' ");

	if($db->db_num_rows($sql_l) > 0){
	$C1 = $db->db_fetch_array($sql_l);
	$a = "1";
?>
  <tr bgcolor="#FFFFFF"> 
    <td width="35%" valign="top"><span  id="previewpx<?php echo $a; ?>y<?php echo $b; ?>"><form action="article_upload.php" method="post" enctype="multipart/form-data" name="formx<?php echo $a; ?>y<?php echo $b; ?>" target="ftargetx<?php echo $a; ?>y<?php echo $b; ?>"><strong>รูปภาพ: </strong><?php  if($C1["ad_pic_s"] != ""){ ?><div align = "right"><a href="#change" onClick="ShowEdit(document.all.whcx<?php echo $a; ?>y<?php echo $b; ?>);"><img src="../theme/main_theme/photo_scenery.jpg" width="16" height="16" border="0" align="absmiddle"> แก้ไขขนาดภาพ</a> <a href="#del" onClick="DelP(document.formx<?php echo $a; ?>y<?php echo $b; ?>,document.all.pvx<?php echo $a; ?>y<?php echo $b; ?>);"><img src="../theme/main_theme/g_del.gif" width="16" height="16" border="0" align="absmiddle"> ลบรูปภาพ</a></div>
						<div id="whcx<?php echo $a; ?>y<?php echo $b; ?>" style="display:none">แก้ไขขนาดภาพ สูง: 
							<input name="hbb" type="text" id="hbb" value="<?php echo $C1["ad_pic_h"]; ?>" size="2">
							กว้าง: 
							<input name="wbb" type="text" id="wbb" value="<?php echo $C1["ad_pic_w"]; ?>" size="2"> <input type="Button" name="Button" value=" Save " style="width:60 px" onClick="chkE(document.formx<?php echo $a; ?>y<?php echo $b; ?>,document.all.pvx<?php echo $a; ?>y<?php echo $b; ?>)">
						  </div>
						<?php } ?>
						<input name="ad_id" type="hidden" id="ad_id" value="<?php echo $C1["ad_id"]; ?>">
						<input name="ad_pic_b" type="hidden" id="ad_pic_b" value="<?php echo $C1["ad_pic_b"]; ?>">
						<input name="ad_pic_s" type="hidden" id="ad_pic_s" value="<?php echo $C1["ad_pic_s"]; ?>">
						<input name="nid" type="hidden" id="nid" value="<?php echo $nid; ?>">
						<input name="posdisp" type="hidden" id="posdisp" value="x<?php echo $a; ?>y<?php echo $b; ?>">
						  <input name="Flag" type="hidden" id="Flag" value="EUpload">
						  <table width="<?php echo $C1["ad_pic_w"]; ?>" height="<?php echo $C1["ad_pic_h"]; ?>" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000" >
							<tr> 
							  <td align="center" valign="middle" bgcolor="#FFFFFF"><img src="<?php if($C1["ad_pic_s"] != ""){ echo "../ewt/".$_SESSION["EWT_SUSER"]."/images/article/news".$nid."/".$C1["ad_pic_s"]; }else{ echo "../images/pic_preview.gif"; } ?>" ></td>
							</tr>
						  </table>
						  <input name="fileb" type="file" id="fileb"  size="10" onChange="activeC(this,document.all.whx<?php echo $a; ?>y<?php echo $b; ?>,document.all.Buttonx<?php echo $a; ?>y<?php echo $b; ?>);"><input type="Button" name="Buttonx<?php echo $a; ?>y<?php echo $b; ?>" value=" Upload " style="width:60 px" onClick="chkU(document.formx<?php echo $a; ?>y<?php echo $b; ?>,document.all.pvx<?php echo $a; ?>y<?php echo $b; ?>)" disabled>
						  <div id="whx<?php echo $a; ?>y<?php echo $b; ?>" style="display:none">สูง: 
							<input name="hb" type="text" id="hb" value="<?php echo $C1["ad_pic_h"]; ?>" size="2">
							กว้าง: 
							<input name="wb" type="text" id="wb" value="<?php echo $C1["ad_pic_w"]; ?>" size="2"> 
						  </div>
						  </form><img  style="display:none" name="pvx<?php echo $a; ?>y<?php echo $b; ?>" id="pvx<?php echo $a; ?>y<?php echo $b; ?>" src= "../images/o.gif">
						  </span>
						  <span  id="previewex<?php echo $a; ?>y<?php echo $b; ?>"><form action="article_editor.php" method="post"  name="formex<?php echo $a; ?>y<?php echo $b; ?>" target="ftargetx<?php echo $a; ?>y<?php echo $b; ?>"><strong>รายละเอียด: 
						<input name="ad_id" type="hidden" id="ad_id" value="<?php echo $C1["ad_id"]; ?>">
						<input name="nid" type="hidden" id="nid" value="<?php echo $nid; ?>">
						<input name="hidp" type="hidden" id="hidp" value="140">
						<input name="widp" type="hidden" id="widp" value="290">
						<input name="hide" type="hidden" id="hide" value="100">
						<input name="wide" type="hidden" id="wide" value="290">
						<input name="posdisp" type="hidden" id="posdisp" value="x<?php echo $a; ?>y<?php echo $b; ?>">
						  <input name="Flag" type="hidden" id="Flag" value="Editor">
						  <textarea style="display:none" name="dx<?php echo $a; ?>y<?php echo $b; ?>" cols="40" rows="5" wrap="VIRTUAL" id="dx<?php echo $a; ?>y<?php echo $b; ?>"><?php
								  if(trim($C1["ad_des"]) != "")
									{
									echo stripslashes($C1["ad_des"]); /*** remove (/) slashes ***/
									}
							  ?></textarea>
							<table width="290" height="140" cellpadding="3" cellspacing="2" border="0" style="cursor:hand;border:#999999 dashed 1px;" onmouseover="this.style.borderColor='#FF0000'" onmouseout="this.style.borderColor='#999999'" title="Click To Edit"  onClick="this.style.display='none';generate_wysiwyg('dx<?php echo $a; ?>y<?php echo $b; ?>','290','100');document.all.hbOtx<?php echo $a; ?>y<?php echo $b; ?>.style.display='';">
							  <tr>
								<td bgcolor="#FFFF99"  valign="top" onmouseover="this.style.backgroundColor='#FFCCCC';" onmouseout="this.style.backgroundColor='#FFFF99';"><?php
								  if(trim($C1["ad_des"]) != "")
									{
									echo stripslashes($C1["ad_des"]);
									}else{
									echo "คลิ๊กที่นี่เพื่อแก้ไขข้อความ";
									}
							  ?></td>
							  </tr>
							</table>
							<div id="hbOtx<?php echo $a; ?>y<?php echo $b; ?>" style="display:none">
<input type="button" name="save" value=" บันทึก " style="width:60 px"  onClick="sendCode('dx<?php echo $a; ?>y<?php echo $b; ?>',document.formex<?php echo $a; ?>y<?php echo $b; ?>,document.all.pex<?php echo $a; ?>y<?php echo $b; ?>)"><input type="button" name="cancel" value=" ยกเลิก " style="width:60 px"    onClick="cancelCode('dx<?php echo $a; ?>y<?php echo $b; ?>',document.formex<?php echo $a; ?>y<?php echo $b; ?>,document.all.pex<?php echo $a; ?>y<?php echo $b; ?>)"></div>
							</form><img  style="display:none" name="pex<?php echo $a; ?>y<?php echo $b; ?>" id="pex<?php echo $a; ?>y<?php echo $b; ?>" src= "../images/o.gif" >
						  </span><iframe name="ftargetx<?php echo $a; ?>y<?php echo $b; ?>" id="ftargetx<?php echo $a; ?>y<?php echo $b; ?>" width="0" height="0"></iframe></td>
	  <?php
	  if($b==0){
	  $sql_r = $db->query("SELECT * FROM article_detail WHERE n_id = '$nid' AND at_type_row = '$x' AND at_type_col = '2' ");
	  $C1 = $db->db_fetch_array($sql_r);
	  $a = "2";
	  ?>
    <td width="65%" valign="top" rowspan="<?php echo $M[1]; ?>"><span  id="previewex<?php echo $a; ?>y<?php echo $b; ?>"><form action="article_editor.php" method="post"  name="formex<?php echo $a; ?>y<?php echo $b; ?>" target="ftargetx<?php echo $a; ?>y<?php echo $b; ?>"><strong>รายละเอียด: 
						<input name="ad_id" type="hidden" id="ad_id" value="<?php echo $C1["ad_id"]; ?>">
						<input name="nid" type="hidden" id="nid" value="<?php echo $nid; ?>">
						<input name="hidp" type="hidden" id="hidp" value="500">
						<input name="widp" type="hidden" id="widp" value="400">
						<input name="hide" type="hidden" id="hide" value="450">
						<input name="wide" type="hidden" id="wide" value="400">
						<input name="posdisp" type="hidden" id="posdisp" value="x<?php echo $a; ?>y<?php echo $b; ?>">
						  <input name="Flag" type="hidden" id="Flag" value="Editor">
						  <textarea style="display:none" name="dx<?php echo $a; ?>y<?php echo $b; ?>" cols="40" rows="5" wrap="VIRTUAL" id="dx<?php echo $a; ?>y<?php echo $b; ?>"><?php
								  if(trim($C1["ad_des"]) != "")
									{
									echo stripslashes($C1["ad_des"]); /*** remove (/) slashes ***/
									}
							  ?></textarea>
							<table width="400" height="500" cellpadding="3" cellspacing="2" border="0" style="cursor:hand;border:#999999 dashed 1px;" onmouseover="this.style.borderColor='#FF0000'" onmouseout="this.style.borderColor='#999999'" title="Click To Edit"  onClick="this.style.display='none';generate_wysiwyg('dx<?php echo $a; ?>y<?php echo $b; ?>','400','450');document.all.hbOtx<?php echo $a; ?>y<?php echo $b; ?>.style.display='';">
							  <tr>
								<td bgcolor="#FFFF99"  valign="top" onmouseover="this.style.backgroundColor='#FFCCCC';" onmouseout="this.style.backgroundColor='#FFFF99';"><?php
								  if(trim($C1["ad_des"]) != "")
									{
									echo stripslashes($C1["ad_des"]);
									}else{
									echo "คลิ๊กที่นี่เพื่อแก้ไขข้อความ";
									}
							  ?></td>
							  </tr>
							</table>
							<div id="hbOtx<?php echo $a; ?>y<?php echo $b; ?>" style="display:none">
<input type="button" name="save" value=" บันทึก " style="width:60 px"  onClick="sendCode('dx<?php echo $a; ?>y<?php echo $b; ?>',document.formex<?php echo $a; ?>y<?php echo $b; ?>,document.all.pex<?php echo $a; ?>y<?php echo $b; ?>)"><input type="button" name="cancel" value=" ยกเลิก " style="width:60 px"    onClick="cancelCode('dx<?php echo $a; ?>y<?php echo $b; ?>',document.formex<?php echo $a; ?>y<?php echo $b; ?>,document.all.pex<?php echo $a; ?>y<?php echo $b; ?>)"></div>
							</form><img  style="display:none" name="pex<?php echo $a; ?>y<?php echo $b; ?>" id="pex<?php echo $a; ?>y<?php echo $b; ?>" src= "../images/o.gif" >
						  </span><iframe name="ftargetx<?php echo $a; ?>y<?php echo $b; ?>" id="ftargetx<?php echo $a; ?>y<?php echo $b; ?>" width="0" height="0"></iframe></td>
  </tr>
  <?php } $b++; }} ?>
</table>
