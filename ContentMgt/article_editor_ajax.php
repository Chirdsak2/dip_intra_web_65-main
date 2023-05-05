<?php
header ("Content-Type:text/html;charset=UTF-8");
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
?>
	<span  id="previewe<?php echo $_GET["posdisp"]; ?>"><form action="article_editor.php" method="post"  name="forme<?php echo $_GET["posdisp"]; ?>" target="ftarget"><strong>รายละเอียด: 
						<input name="ad_id" type="hidden" id="ad_id" value="<?php echo $C1["ad_id"]; ?>">
						<input name="nid" type="hidden" id="nid" value="<?php echo $_GET["nid"]; ?>">
						<input name="hidp" type="hidden" id="hidp" value="<?php echo $_GET["hidp"]; ?>">
						<input name="widp" type="hidden" id="widp" value="<?php echo $_GET["widp"]; ?>">
						<input name="hide" type="hidden" id="hide" value="<?php echo $_GET["hide"]; ?>">
						<input name="wide" type="hidden" id="wide" value="<?php echo $_GET["wide"]; ?>">
						<input name="posdisp" type="hidden" id="posdisp" value="<?php echo $_GET["posdisp"]; ?>">
						  <input name="Flag" type="hidden" id="Flag" value="Editor">
						  <textarea style="display:none" name="d<?php echo $_GET["posdisp"]; ?>" cols="40" rows="5" wrap="VIRTUAL" id="d<?php echo $_GET["posdisp"]; ?>"><?php
								  if(trim($C1["ad_des"]) != "")
									{
									echo stripslashes($C1["ad_des"]); /*** remove (/) slashes ***/
									}
							  ?></textarea>
							<table width="<?php echo $_GET["widp"]; ?>" height="<?php echo $_GET["hidp"]; ?>" cellpadding="3" cellspacing="2" border="0" style="cursor:hand;border:#999999 dashed 1px;" onmouseover="this.style.borderColor='#FF0000'" onmouseout="this.style.borderColor='#999999'" title="Click To Edit"  onClick="this.style.display='none';generate_wysiwyg('d<?php echo $_GET["posdisp"]; ?>','<?php echo $_GET["wide"]; ?>','<?php echo $_GET["hide"]; ?>');document.all.hbOt<?php echo $_GET["posdisp"]; ?>.style.display='';">
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
							<div id="hbOt<?php echo $_GET["posdisp"]; ?>" style="display:none">
<input type="button" name="save" value=" บันทึก " style="width:60 px"  onClick="sendCode('d<?php echo $_GET["posdisp"]; ?>',document.forme<?php echo $_GET["posdisp"]; ?>,document.all.pe<?php echo $_GET["posdisp"]; ?>)"><input type="button" name="cancel" value=" ยกเลิก " style="width:60 px"    onClick="cancelCode('d<?php echo $_GET["posdisp"]; ?>',document.forme<?php echo $_GET["posdisp"]; ?>,document.all.pe<?php echo $_GET["posdisp"]; ?>)"></div>
							</form><img  style="display:none" name="pe<?php echo $_GET["posdisp"]; ?>" id="pe<?php echo $_GET["posdisp"]; ?>" src= "../images/o.gif" >
						  </span>
	</body>
	<script language="javascript">
	self.parent.document.all.previewe<?php echo $_GET["posdisp"]; ?>.innerHTML = document.all.Move01.innerHTML;
	</script>
	<?php
$db->db_close(); ?>
