<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$Globals_Dir = '../ewt/'.$EWT_FOLDER_USER;
$Globals_Dir1 = 'language';
if($_POST[f]=='add'){
	
	if($_FILES['file']['size']>0){
	$img_name = 'img_name_';
	$type_img = explode('.',strtolower($_FILES["file"]["name"]));
	$img_name .=$_POST[lang_name_short].'.'.$type_img[1];
	@copy($_FILES["file"]["tmp_name"],$Globals_Dir."/".$Globals_Dir1."/".$img_name);
	}
$db->query("INSERT INTO lang_config (lang_config_name,lang_config_suffix,lang_config_img,lang_config_status) VALUES ('".$_POST[lang_name]."','".$_POST[lang_name_short]."','".$img_name."','O')");
@copy('../language/lang_th/language.php','../ewt/'.$EWT_FOLDER_USER.'/language/language_'.$_POST[lang_name_short].'.php');
		echo "<script language=\"javascript\">";
		echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว');";
		echo "document.location.href='language_setup_web.php';" ;
		echo "</script>";
}
if($_POST[f]=='edit'){
   if($_FILES['file']['size']>0){
   	$img_name = 'img_name_';
	$type_img = explode('.',strtolower($_FILES["file"]["name"]));
	$img_name .=$_POST[lang_name_short].'.'.$type_img[1];
	@copy($_FILES["file"]["tmp_name"],$Globals_Dir."/".$Globals_Dir1."/".$img_name);
		if($_POST[lang_name_short] != $_POST[hdd_name_short]){
			@unlink ( $Globals_Dir."/".$Globals_Dir1."/".$_POST[hddfile]);
		}
	}else{
		if($_POST[lang_name_short] != $_POST[hdd_name_short]){
			$img_name =ereg_replace ($_POST[hdd_name_short], $_POST[lang_name_short], $_POST[hddfile]);
			@copy($Globals_Dir."/".$Globals_Dir1."/".$_POST[hddfile],$Globals_Dir."/".$Globals_Dir1."/".$img_name);
			@unlink ($Globals_Dir."/".$Globals_Dir1."/".$_POST[hddfile]);
		}else{
			$img_name  = $_POST[hddfile];
		}
	}
$db->query("UPDATE lang_config SET lang_config_name='".$_POST[lang_name]."',lang_config_suffix='".$_POST[lang_name_short]."',lang_config_img = '".$img_name."' where lang_config_id ='".$_POST[id]."' ");
if($_POST[lang_name_short] != $_POST[hdd_name_short]){
	@unlink ('../ewt/'.$EWT_FOLDER_USER.'/language/language_'.$_POST[lang_name_short].'.php');
}
@copy('../language/lang_th/language.php','../ewt/'.$EWT_FOLDER_USER.'/language/language_'.$_POST[hdd_name_short].'.php');

		echo "<script language=\"javascript\">";
		echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว');";
		echo "document.location.href='language_setup_web.php';" ;
		echo "</script>";
}
if($_GET[flag]=='add'){
$lable = 'เพิ่ม';
}else{
$lable = 'แก้ไข';
$sql = "select * from lang_config where lang_config_id = '".$_GET[id]."'";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
$name = $rec[lang_config_name];
$name_short = $rec[lang_config_suffix];
$img_file = $rec[lang_config_img];
}

?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="javascript1.2">
function open_w(p,s,w,w_n){
var link = "page_mapping.php?filename="+p+"&&select="+s+"&&web="+w+"&&web1="+w_n;
win = window.open(link,'LanguageOpen','top=100,left=80,width=240,height=480,resizable=1,status=0,scrollbars=1');
win.window.focus();
}
function submit_form(f){
		var link_t = 'proc_language_setup_page.php';
		form1.action = link_t;
		form1.submit();
}
function CHK(t){
	if(t.lang_name.value == ''){
		alert('กรุณาใส่ชื่อภาษา !');
		return false;
	}
	if(t.lang_name_short.value == ''){
		alert('กรุณาใส่ชื่อย่อภาษา !');
		return false;
	}
	return true;
}
</script>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction">ตั้งค่าภาษา</span> </td>
  </tr>
</table>

<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode ('ตั้งค่าภาษา -'.$lable.'ภาษา');?>&module=language&url=<?php if($_GET[flag]=='edit'){ echo urlencode("language_setup_add.php?id=".$_GET[id]);}else{ echo urlencode  ('language_setup_add.php?flag=add');}?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="language_setup_web.php"><img src="../theme/main_theme/g_back.gif" width="16" height="16" align="absmiddle" border="0">&nbsp;กลับ&nbsp;</a>
      <hr>
    </td>
  </tr>
</table>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF">
  <tr> 
    <td align="center" valign="top">
	<form action="" method="post" enctype="multipart/form-data" name="form1" onSubmit="return CHK(this);">
	<table width="70%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE"  class="ewttableuse">
      <tr bgcolor="#E7E7E7" >
        <td height="30" colspan="2" class="ewttablehead"> <?php echo $lable;?></td>
      </tr>
      <tr valign="top" bgcolor="#FFFFFF">
        <td width="38%">ชื่อ :<span class="style1"> * </span></td>
        <td width="62%"><input name="lang_name" type="text" size="40" value="<?php echo $name;?>"></td>
      </tr>
      <tr valign="top" bgcolor="#FFFFFF">
        <td>ชื่อย่อ:<span class="style1">*</span></td>
        <td width="62%"><input name="lang_name_short" type="text" value="<?php echo $name_short;?>" size="6" maxlength="2">
          <input type="hidden" name="hdd_name_short" value="<?php echo $name_short;?>"></td>
      </tr>
      <tr valign="top" bgcolor="#FFFFFF">
        <td>รูปสัญลักษณ์ :</td>
        <td width="62%"><input type="file" name="file">
          <input type="hidden" name="hddfile" value="<?php echo $img_file;?>"></td>
      </tr>

      <tr bgcolor="#FFFFFF">
        <td>&nbsp;</td>
        <td><input type="submit" name="Submit2" value="Submit">
            <input type="reset" name="Submit3" value="Reset">
            <input type="hidden" name="f" value="<?php echo $flag;?>">
            <input type="hidden" name="id" value="<?php echo $id;?>"></td>
      </tr>
    </table>
      
      </form>
    </td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close(); ?>
