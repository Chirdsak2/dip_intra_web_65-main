<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language.php");

$sql_v = $db->query("SELECT * FROM virtual_list WHERE v_id = '".$_GET["vid"]."' ");
$R = $db->db_fetch_array($sql_v);
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
		function selColor(c,d,e) {
			Win2 = window.open('../ewt_color.php?c_value='+ c +'&c_block=' + d + '&c_preview1=' + e + '','sel', 'height=175,width=245, status=0, menubar=0,resizable=no, location=0, scrollbars=no, left=400, top=300');
		}
		function chkstatus(c){
			if(c.checked == true){
				document.form1.maxwidth.disabled = true;
			}else{
				document.form1.maxwidth.disabled = false;
			}
		}
		function chkfrm(){
			if(document.form1.v_name.value == ""){
				alert("Please insert virtual name!");
				document.form1.v_name.focus();
				return false;
			}
			if(document.form1.cid.value == ""){
				alert("Please select group!");
				window.open('virtual_select.php','','height=400,width=300,resizable=1,scrollbars=1');
				return false;
			}
		}
</script>
</head>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td><img src="../theme/main_theme/fag_function.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction"> บริหาร Virtual</span></td>
  </tr>
</table>    
<table width="84%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("บริหาร Virtual >แก้ไขข้อมูล Virtual:". $R[v_name]);?>&module=virtual&url=<?php echo urlencode("virtual_edit_show.php?vid=".$_GET["vid"]);?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="virtual_add.php?gid=<?php echo $R["vg_id"]?>"><img border="0" src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle" alt=" <?php echo $text_general_add;?>"> <?php echo $text_general_add;?></a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="virtual_list.php?gid=<?php echo $R["vg_id"]?>"><img src="../theme/main_theme/g_back.gif" alt="กลับ" width="16" height="16" border="0" align="absmiddle"> <?php echo $text_general_back;?></a>
        <hr>
    </td>
  </tr>
</table>
<table width="84%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
  <form action="virtual_function.php" method="post" enctype="multipart/form-data" name="form1"  onSubmit="return chkfrm();">
    <tr class="ewttablehead">
      <td colspan="2" >ข้อมูล Virtual</td>
    </tr>
    <tr>
      <td width="34%" valign="top" bgcolor="#FFFFFF">ชื่อ virtual </td>
      <td width="66%" valign="top" bgcolor="#FFFFFF"><input name="v_name" type="text" id="v_name" value="<?php echo $R[v_name]; ?>" size="40">      </td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#FFFFFF">รายละเอียด</td>
      <td valign="top" bgcolor="#FFFFFF"><textarea name="v_detail" cols="40" rows="5" id="v_detail"><?php echo $R[v_detail]; ?></textarea></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#FFFFFF">รูปภาพ</td>
      <td valign="top" bgcolor="#FFFFFF"><input name="v_file" type="file" id="v_file">
          <input name="oldimg" type="hidden" id="oldimg" value="<?php echo $R["v_images"]; ?>" ></td>
    </tr>
<?php
	  if($R["vg_id"] != ""){
	  $sql_g = $db->query("SELECT vg_name FROM virtual_group WHERE vg_id = '".$R["vg_id"]."' ");
	  $G = $db->db_fetch_row($sql_g);
	  }
	  ?>
    <tr>
      <td valign="top" bgcolor="#FFFFFF">กลุ่ม</td>
      <td valign="top" bgcolor="#FFFFFF"><span id="txtshow"><?php echo $G[0]; ?></span> <img src="../images/i_folder_on.jpg" width="16" height="16" align="absmiddle" style="cursor:pointer" onClick="window.open('virtual_select.php','','height=400,width=300,resizable=1,scrollbars=1');">
          <input name="cid" type="hidden" id="cid" value="<?php echo $R["vg_id"]; ?>" >      </td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#FFFFFF">สีตัวอักษร</td>
      <td valign="top" bgcolor="#FFFFFF"><a id="CPreview1" style="background-color: <?php echo $R[v_fontcolor]; ?>;" onClick="selColor('window.opener.document.form1.fontcolor.value','window.opener.document.all.CPreview1.style.backgroundColor','');"><img src="../images/box_color.gif" width="21" height="23" align="absmiddle"></a>
          <input name="fontcolor" type="text" id="fontcolor" value="<?php echo $R[v_fontcolor]; ?>" size="6"></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#FFFFFF">สีพื้นหลัง</td>
      <td valign="top" bgcolor="#FFFFFF"><a id="CPreview2" style="background-color: <?php echo $R[v_bgcolor]; ?>;" onClick="selColor('window.opener.document.form1.bgcolor.value','window.opener.document.all.CPreview2.style.backgroundColor','');"><img src="../images/box_color.gif" width="21" height="23" align="absmiddle"></a>
          <input name="bgcolor" type="text" id="bgcolor" value="<?php echo $R[v_bgcolor]; ?>" size="6"></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#FFFFFF">ความกว้างของหน้าจอ</td>
      <td valign="top" bgcolor="#FFFFFF"><input name="maxwidth" type="text" id="maxwidth" value="<?php echo $R[v_maxwidth]; ?>" size="4">
        pixels <br>
        <label>
          <input name="fit" type="checkbox" id="fit" value="Y" onClick="chkstatus(this)" <?php  if($R[v_fit] == "Y"){ echo "checked"; } ?>>
          พอดีกับรูป</label></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#FFFFFF">ความเร็วในการเลื่อนภาพ</td>
      <td valign="top" bgcolor="#FFFFFF"><select name="speed">
        <option value="4000" <?php  if($R[v_speed] == "4000"){ echo "selected"; } ?>>เร็ว</option>
        <option value="8000" <?php  if($R[v_speed] == "8000"){ echo "selected"; } ?>>ปานกลาง</option>
        <option value="16000" <?php  if($R[v_speed] == "16000"){ echo "selected"; } ?>>ช้า</option>
      </select></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#FFFFFF">เลื่อนรูปภาพอัตโมัติ</td>
      <td valign="top" bgcolor="#FFFFFF"><label>
        <input name="autostart" type="radio" value="1" <?php  if($R[v_auto] == "1"){ echo "checked"; } ?>>
        ใช่ </label>
          <label>
          <input name="autostart" type="radio" value="0" <?php  if($R[v_auto] == "0"){ echo "checked"; } ?>>
            ไม่ใช่ </label></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#FFFFFF">ภาพ 360 ต่อเนื่องกัน</td>
      <td valign="top" bgcolor="#FFFFFF"><label>
        <input name="mode_360" type="radio" value="true" <?php  if($R[v_360] == "true"){ echo "checked"; } ?>>
        ใช่ </label>
          <label>
          <input name="mode_360" type="radio" value="false" <?php  if($R[v_360] == "false"){ echo "checked"; } ?>>
            ไม่ใช่ </label></td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#FFFFFF">การแสดงผล</td>
      <td valign="top" bgcolor="#FFFFFF"><input name="mode_status" type="radio" value="1"  <?php  if($R[v_status] == "1"){ echo "checked"; } ?>>
อนุมัติ
  <input name="mode_status" type="radio" value="1" <?php  if($R[v_status] == "0"){ echo "checked"; } ?>>
ไม่อนุมัติ</td>
    </tr>
    <tr>
      <td valign="top" bgcolor="#FFFFFF">&nbsp;</td>
      <td valign="top" bgcolor="#FFFFFF"><label>
        <input type="submit" name="Submit" value="Submit">
        <input type="reset" name="Submit2" value="Reset">
        <input name="Flag" type="hidden" id="Flag" value="Edit" >
        <input name="vid" type="hidden" id="vid" value="<?php echo $_GET["vid"]; ?>" >
      </label></td>
    </tr>
  </form>
</table>
</body>
</html>
<?php $db->db_close(); ?>