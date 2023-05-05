<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$Globals_Dir = '../ewt/'.$EWT_FOLDER_USER;
$Globals_Dir1 = 'language';
if($_POST[flag] == 'upload'){
$sql = "select lang_config_suffix from lang_config where lang_config_id ='".$_POST["m_id"]."' ";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
if($_POST["m_id"] == '1'){
		@copy($file,'../ewt/'.$EWT_FOLDER_USER.'/language/language.php');
		if($rec[lang_config_status]=='T'){
		$path_lang = "lang_th";
		}else{
		$path_lang = "lang_en";
		}
		//@copy($file,'../language/'.$path_lang.'/language.php');
}else{
		@copy($file,'../ewt/'.$EWT_FOLDER_USER.'/language/language_'.$rec[lang_config_suffix].'.php');
}
		echo "<script language=\"javascript\">";
		echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว');";
		echo "document.location.href='language_setup_web.php';" ;
		echo "</script>";
}
if($_GET[flag] == 'del'){
$sql_lang = "select * from lang_config where lang_config_id = '".$_GET["id"]."'";
$query_lang = $db->query($sql_lang);
$rec = $db->db_fetch_array($query_lang);
//chk page used lang_config
$show_name = "___".$rec[lang_config_suffix];
$sql = "select filename from temp_index where filename REGEXP '%".$show_name."'";
$query = $db->query($sql);
if($db->db_num_rows($query)>0){
		echo "<script language=\"javascript\">";
		echo "alert('มีหน้าเว็บที่ใช้ภาษานี้อยู่ ท่านไม่สามารถลบข้อมูลนี้ได้ กรุณาลบหน้าเว็บที่เรียกใช้ภาษานี้ออกก่อน !!');";
		echo "document.location.href='language_setup_web.php';" ;
		echo "</script>";
exit;
}

@unlink ($Globals_Dir."/".$Globals_Dir1."/".$rec[lang_config_img]);
@unlink ('../ewt/'.$EWT_FOLDER_USER.'/language/language_'.$rec[lang_config_suffix].'.php');
$sql_del = "delete from lang_config where lang_config_id = '".$_GET["id"]."'";
$db->query($sql_del);
		echo "<script language=\"javascript\">";
		echo "alert('ลบข้อมูลเรียบร้อยแล้ว');";
		echo "document.location.href='language_setup_web.php';" ;
		echo "</script>";
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
</script>
<script src="../js/AjaxRequest.js"></script>
<script language="JavaScript">
		function CHK(t){
			if(t.file.value ==''){
			alert('กรุณาเลือกไฟล์ภาษา  !');
			return false;
			}
			return true;
		}
		function editmenu(c){
			self.location.href = "menu_main.php?m_id=" + c;
		}
		function applymenu(c){
			if(confirm('Are you sure you want to apply this menu to WebBlock?')){
				self.location.href = "menu_apply.php?m_id=" + c;
			}
		}
		function delmenu(c){
			if(confirm('Are you sure you want to delete this menu ?')){
				self.location.href = "menu_apply.php?flag=del&m_id=" + c;
			}
		}
		function findPosX(obj)
{
 var curleft = 0;
 if (document.getElementById || document.all)
 {
  while (obj.offsetParent)
  {
   curleft += obj.offsetLeft
   obj = obj.offsetParent;
  }
 }
 else if (document.layers)
  curleft += obj.x;
 return curleft;
}
function findPosY(obj)
{
 var curtop = 0;
 if (document.getElementById || document.all)
 {
  while (obj.offsetParent)
  {
   curtop += obj.offsetTop
   obj = obj.offsetParent;
  }
 }
 else if (document.layers)
  curtop += obj.y;
 return curtop;
}
		function txt_data(w) {
	
	var mytop = findPosY(document.getElementById("save"+w)) +document.getElementById("save"+w).offsetHeight;
	var myleft = findPosX(document.getElementById("save"+w));	
	var objDiv = document.getElementById("nav");
	objDiv.style.top = mytop;
	objDiv.style.left = myleft;
	objDiv.style.display = '';
	url='upload_file_lang.php?m_id='+ w;
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
					
			}
		}
	);
	
}

	</script>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<body leftmargin="0" topmargin="0">
<div id="nav" style="position:absolute;width:262px; height:280px; z-index:1;display:none" ></div>
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction">ตั้งค่าภาษา</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode ('ตั้งค่าภาษา ');?>&module=language&url=<?php echo urlencode  ( "language_setup_web.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="language_setup_add.php?flag=add" ><img src="../theme/main_theme/g_add.gif" width="16" height="16" border="0" align="absmiddle"> เพิ่ม</a> 
        <hr>
    </td>
  </tr>
</table>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF">
  <tr> 
    <td align="center" valign="top"><table width="94%" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000" class="ewttableuse">
      <tr class="ewttablehead">
        <td width="16%" align="center" bgcolor="#E7E7E7">&nbsp;</td>
        <td width="41%" bgcolor="#E7E7E7"><strong>ชื่อ</strong></td>
        <td width="21%" bgcolor="#E7E7E7"><strong>ชื่อย่อ</strong></td>
        <td width="22%" align="center" bgcolor="#E7E7E7">รูปสัญลักษณ์</td>
      </tr>
	  <?php
	  	$NDir = "../ewt/".$EWT_FOLDER_USER."/language";
		 		 $sql_db = "select * from lang_config where lang_config_id = '1' ";
				$query = $db->query($sql_db);
				$rec_db=$db->db_fetch_array($query);
		  ?>
	   <tr>
        <td bgcolor="#FFFFFF">
		<a href="language_setup_add1.php?flag=edit&id=1"><img src="../theme/main_theme/g_edit.gif" alt="แก้ไข" border="0"></a>
		<a href="tmp.php?NowD=../ewt/<?php echo $EWT_FOLDER_USER;?>/language&FID=language.php" target="_blank"><img src="../theme/main_theme/g_download_16.png" alt="download file" width="16" height="16" border="0"></a>
		<a href="#" onClick="txt_data('<?php echo $rec_db["lang_config_id"]; ?>')"><img src="../theme/main_theme/g_saveas.gif" alt="upload file" name="save<?php echo $rec_db["lang_config_id"]; ?>" width="16" height="16" border="0" id="save<?php echo $rec_db["lang_config_id"]; ?>"></a> <a href="multiset.php?id=1"><img src="../theme/main_theme/g_document.gif" alt="แก้ไขภาษาด้วยตัวเอง" width="16" height="16" border="0"></a></td>
        <td bgcolor="#FFFFFF">Default [<?php if($rec_db[lang_config_status]=='T'){ echo 'Thai';}else{ echo 'English';}?>]</td>
        <td bgcolor="#FFFFFF">&nbsp;</td>
        <td align="center" bgcolor="#FFFFFF"><?php if($rec_db[lang_config_img]!=''){ ?><img src="<?php echo $Globals_Dir."/".$Globals_Dir1."/".$rec_db[lang_config_img];?>" ><?php } ?></td>
      </tr>
	  <?php
	  $NDir = "../ewt/".$EWT_FOLDER_USER."/language";
		 		 $sql_db = "select * from lang_config where lang_config_status = 'O' ";
				$query = $db->query($sql_db);
				while($rec_db=$db->db_fetch_array($query)){
				$file = "language_".$rec_db[lang_config_suffix].".php";
		  ?>
      <tr>
        <td bgcolor="#FFFFFF"><a href="language_setup_add.php?flag=edit&id=<?php echo $rec_db[lang_config_id];?>"><img src="../theme/main_theme/g_edit.gif" alt="แก้ไข" border="0"></a>
		<a href="tmp.php?NowD=<?php echo $NDir; ?>&FID=<?php echo $file; ?>" target="_blank"><img src="../theme/main_theme/g_download_16.png" alt="download file" width="16" height="16" border="0"></a>
		<a href="#" onClick="txt_data('<?php echo $rec_db["lang_config_id"]; ?>')"><img src="../theme/main_theme/g_saveas.gif" id="save<?php echo $rec_db["lang_config_id"]; ?>" alt="upload file" width="16" height="16" border="0"></a>
		<a href="language_setup_web.php?flag=del&id=<?php echo $rec_db[lang_config_id];?>"><img src="../theme/main_theme/g_del.gif" alt="ลบ" border="0"></a>
		<a href="multiset.php?id=<?php echo $rec_db[lang_config_id];?>"><img src="../theme/main_theme/g_document.gif" alt="แก้ไขภาษาด้วยตัวเอง" width="16" height="16" border="0"></a></td>
        <td bgcolor="#FFFFFF"><?php echo $rec_db[lang_config_name];?></td>
        <td bgcolor="#FFFFFF"><?php echo $rec_db[lang_config_suffix];?></td>
        <td align="center" bgcolor="#FFFFFF"><?php if($rec_db[lang_config_img]!=''){ ?><img src="<?php echo $Globals_Dir."/".$Globals_Dir1."/".$rec_db[lang_config_img];?>" ><?php } ?></td>
      </tr>
      <?php } ?>

    </table></td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close(); ?>
