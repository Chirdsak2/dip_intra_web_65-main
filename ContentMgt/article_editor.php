<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

if($_POST["Flag"] == "Editor" AND $_POST["nid"] != "" AND $_POST["ad_id"] != ""){
	$ad_des1 = "d".$_POST["posdisp"];
	$ad_des = addslashes($_POST[$ad_des1]);
	$ad_id = $_POST["ad_id"];
				$update = "UPDATE article_detail SET ad_des = '$ad_des'  WHERE ad_id ='$ad_id' ";
				$db->query($update);
	}
	if($_POST["posdisp"] != ""){
							$sql_l = $db->query("SELECT * FROM article_detail WHERE ad_id = '".$_POST["ad_id"]."' ");
							$C1 = $db->db_fetch_array($sql_l);
	?>
	<body id="Move01"><form action="article_editor.php" method="post"  name="forme<?php echo $_POST["posdisp"]; ?>" target="ftarget"><strong>รายละเอียด: 
						<input name="ad_id" type="hidden" id="ad_id" value="<?php echo $C1["ad_id"]; ?>">
						<input name="nid" type="hidden" id="nid" value="<?php echo $_POST["nid"]; ?>">
						<input name="hidp" type="hidden" id="hidp" value="<?php echo $_POST["hidp"]; ?>">
						<input name="widp" type="hidden" id="widp" value="<?php echo $_POST["widp"]; ?>">
						<input name="hide" type="hidden" id="hide" value="<?php echo $_POST["hide"]; ?>">
						<input name="wide" type="hidden" id="wide" value="<?php echo $_POST["wide"]; ?>">
						<input name="posdisp" type="hidden" id="posdisp" value="<?php echo $_POST["posdisp"]; ?>">
						  <input name="Flag" type="hidden" id="Flag" value="Editor">
						  <textarea style="display:none" name="d<?php echo $_POST["posdisp"]; ?>" cols="40" rows="5" wrap="VIRTUAL" id="d<?php echo $_POST["posdisp"]; ?>"><?php
								  if(trim($C1["ad_des"]) != "")
									{
									echo stripslashes($C1["ad_des"]); /*** remove (/) slashes ***/
									}
							  ?></textarea>
							<table width="<?php echo $_POST["widp"]; ?>" height="<?php echo $_POST["hidp"]; ?>" cellpadding="3" cellspacing="2" border="0" style="cursor:hand;border:#999999 dashed 1px;" onmouseover="this.style.borderColor='#FF0000'" onmouseout="this.style.borderColor='#999999'" title="Click To Edit"  onClick="this.style.display='none';generate_wysiwyg('d<?php echo $_POST["posdisp"]; ?>','<?php echo $_POST["wide"]; ?>','<?php echo $_POST["hide"]; ?>');document.all.hbOt<?php echo $_POST["posdisp"]; ?>.style.display='';">
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
							<div id="hbOt<?php echo $_POST["posdisp"]; ?>" style="display:none">
<input type="button" name="save" value=" บันทึก " style="width:60 px"  onClick="sendCode('d<?php echo $_POST["posdisp"]; ?>',document.forme<?php echo $_POST["posdisp"]; ?>,document.all.pe<?php echo $_POST["posdisp"]; ?>)"><input type="button" name="cancel" value=" ยกเลิก " style="width:60 px"    onClick="cancelCode('d<?php echo $_POST["posdisp"]; ?>',document.forme<?php echo $_POST["posdisp"]; ?>,document.all.pe<?php echo $_POST["posdisp"]; ?>)"></div>
							</form><img  style="display:none" name="pe<?php echo $_POST["posdisp"]; ?>" id="pe<?php echo $_POST["posdisp"]; ?>" src= "../images/o.gif" >
	</body>
	<script language="javascript">
	self.parent.document.all.previewe<?php echo $_POST["posdisp"]; ?>.innerHTML = document.all.Move01.innerHTML;
	</script>
	<?php
	}
$db->db_close(); ?>
