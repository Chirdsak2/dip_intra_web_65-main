<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="javascript1.2">
function chk_db(f){
/*var i = 0;
var chk = 0;
for(i=0;i<f.num_db.value;i++){
alert(f.chk_select[i].value);
	if(f.chk_select[i].checked == true){
		chk +=1;
		if(f.txt_lang[i].value==''){
		 alert("กรุณาระบุภาษา!!!!!");
		 return false;
		}
	}else if(f.chk_select[i].checked == false){
		chk += 0;
	}
}

if(chk == 0){
alert("กรุณาเลือกฐานข้อมูลที่ท่านต้องการ");
return false;
}else if(chk > 0){
		var link_t = 'proc_language_setup_db.php';
		myForm.action = link_t;
		myForm.submit();
}
//f.num_db.value
return false;*/
var link_t = 'proc_language_setup_db.php';
		myForm.action = link_t;
		myForm.submit();
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">ตั้งค่าภาษา</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">&nbsp;
      <hr>
</td></tr></table>
  <table width="94%" height="92" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#000000" class="ewttableuse"><form name="myForm" method="post" enctype="multipart/form-data"  onSubmit="return chk_db(this);">
    <tr class="ewttablehead">
      <td bgcolor="#E7E7E7">&nbsp;</td>
      <td width="20" bgcolor="#E7E7E7">เลือก</td>
      <td width="40" bgcolor="#E7E7E7">ภาษา</td>
    </tr>
    <?php
			   $i=0;
		$db->query("USE ".$EWT_DB_USER);
		 $sql="select * from user_info";
		 $query = $db->query($sql);
		 while($rec = $db->db_fetch_array($query)){
		 $chk = '';
		 $lang= '';
		 $db->query("USE ".$_SESSION["EWT_SDB"]);
		 $sql_chk = "select * from lang_setting where lang_setting_id='".$rec[UID]."' and lang_setting_status = 'Y'";
		 if($db->db_num_rows($db->query($sql_chk))>0){
		 $rec1 = $db->db_fetch_array($db->query($sql_chk));
		 $chk ="checked";
		 $lang = $rec1[lang_setting_lang];
		 }

		 ?>
    <tr>
      <td bgcolor="#FFFFFF"><?php echo $rec[WebsiteName];?></td>
      <td bgcolor="#FFFFFF"><input type="checkbox"   name="chk_select[]" id="chk_select[<?php echo $i?>]" value="<?php echo $rec[UID];?>" <?php echo $chk?>></td>
      <td width="30" bgcolor="#FFFFFF"><input name="txt_lang<?php echo $rec[UID];?>" id="txt_lang<?php echo $rec[UID];?>" type="text" size="5" maxlength="5" value="<?php echo $lang?>">
      </td>
    </tr>
    <?php  
			  $i++;
		  }
		$db->query("USE ".$_SESSION["EWT_SDB"]);
		?>
    <br>
    <input name="num_db" id="num_db" type="hidden" value="<?php echo $i?>">
    <tr>
      <td colspan="3" align="center" bgcolor="#FFFFFF"><input type="submit" name="Submit" value="บันทึก"></td>
    </tr>
<tr class="ewttablehead"></tr>
</form></table>
</body>
</html>
<?php
$db->db_close(); ?>
