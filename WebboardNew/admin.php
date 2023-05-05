<?php
include("administrator.php");
include("lib/include.php");
include("inc.php");

if($_POST["flag"] == "change"){

$Execsql = $db->query("UPDATE w_admin SET t_user = '$user',t_pass = '$pass'");
?>
<script language="JavaScript">
	alert("แก้ไขข้อมูลเรียบร้อยแล้ว");
window.location.href = "index_cate.php";
</script>
<?php
exit;
}
if($_POST["flag"] == "config"){

$Execsql=$db->query("SELECT * FROM w_config");
if($db->db_num_rows($Execsql)>0){
			$Execsql = $db->query("UPDATE w_config SET c_approve = '".$_POST["wtype"]."',c_number = '".$_POST[nump]."',c_mail = '".$_POST[wemail]."',c_img='".$_POST[Img]."',c_link='".$_POST[txt_time]."',c_sizeupload='".$_POST[txt_size]."',c_vote='".$_POST[wvote]."',c_voteshow ='".$_POST[txtshowdate]."',c_showip='".$_POST[wip]."' WHERE c_config = '1'");
}else{
			$Execsql = $db->query("INSERT INTO 
			w_config(c_approve,c_number,c_mail,c_img,c_link,c_sizeupload,c_vote,c_voteshow,c_showip) 
			VALUES('".$_POST[wtype]."','".$_POST[nump]."','".$_POST[wemail]."','".$_POST[Img]."','".$_POST[txt_time]."','".$_POST[txt_size]."','".$_POST[wvote]."','".$_POST[txtshowdate]."','".$_POST[wip]."' )");
}
$db->write_log("update","webboard","ตั้งค่ากระทู้");
?>
<script language="JavaScript">
	alert("แก้ไขข้อมูลเรียบร้อยแล้ว");
window.location.href = "admin.php";
</script>
<?php
exit;
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: none}
a:hover { color: #0099FF; text-decoration: none}
.style1 {color: #FF0000}
-->
</style>
</head>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
      <td valign="top"></td>
      <td width="100%" height="100%" valign="top"><table width="100%" height="100%" border="0" cellpadding="2" cellspacing="0" bgcolor="F3F3EE" class="normal_font">
  <tr>
    <td height="25" bgcolor="#FFFFFF"><table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction">ตั้งค่าเว็บบอร์ด</span></td>
      </tr>
    </table>
      <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
        <tr>
          <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("ตั้งค่าเว็บบอร์ด");?>&module=webboard&url=<?php echo urlencode("admin.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<hr>
          </td>
        </tr>
      </table></td>
    </tr>
  <tr>
    <td colspan="2" valign="top" bgcolor="#FFFFFF">
	  <?php
$sql = $db->query("SELECT * FROM w_config WHERE c_config = '1'");
$R = mysql_fetch_array($sql);
?>
      <table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
 <form name="form2"  method="post" action="admin.php" onSubmit="return CHK1()">
  <tr align="center" bgcolor="#FFCC99" class="ewttablehead">
    <td height="25" colspan="2" class="head_font">ตั้งค่าของกระทู้</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td width="34%">มีการอนุมัติก่อนขึ้นแสดง<font color="#FF0000">&nbsp;</font></td>
    <td width="66%"><select name="wtype" id="wtype">
    <option value="0" <?php if($R[c_approve] == "0"){ echo "selected"; } ?>>Yes</option>
    <option value="1" <?php if($R[c_approve] == "1"){ echo "selected"; } ?>>No</option>
    </select></td>
  </tr>
                    <tr bgcolor="#FFFFFF"> 
                      <td>มีการแจ้งเตือนทางอีเมล์เมื่อมีข้อความใหม่</td>
                      <td><input name="wemail" type="text" id="wemail" value="<?php echo $R[c_mail]; ?>">
                      <br>
                      <span class="style1">(ในกรณีที่ต้องการใส่หลายคน ให้คั้นด้วยเครื่องหมาย ; )</span></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>จำนวนกระทู้ในหมวดต่อหนึ่งหน้า<font color="#FF0000">&nbsp;</font></td>
    <td><input name="nump" type="text" id="nump" value="<?php echo $R[c_number]; ?>" size="2" onKeyUp="chkformatnum(this)"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>กำหนดประเภทนามสกุลรูปภาพ</td>
    <td><input type="text" name="Img" id="Img" value="<?php echo $R[c_img]; ?>">
      Ex: jpg,gif </td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>กำหนดเวลาการตอบกระทู้อัตโนมัติ</td>
    <td><input name="txt_time" type="text" id="txt_time" size="5" value="<?php echo $R[c_link]; ?>" onKeyUp="chkformatnum(this)">
      นาที</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>กำหนดขนาดไฟล์ที่สามารถนำขึ้นได้</td>
    <td><input name="txt_size" type="text" size="5" value="<?php echo $R[c_sizeupload]; ?>" onKeyUp="chkformatnum(this)">
      KB.</td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>กำหนดให้สามารถโหวตคำถามได้</td>
    <td><select name="wvote" id="wvote" onChange="fixdate(this);">
    <option value="0" <?php if($R[c_vote] == "0"){ echo "selected"; } ?>>Yes</option>
    <option value="1" <?php if($R[c_vote] == "1"){ echo "selected"; } ?>>No</option>
    </select>
<span id='showdate'  <?php if($R[c_vote] == "1"){ ?>style="display:none"<?php }?>> จากวันตั้งกระทู้      
<input name="txtshowdate" value="<?php echo $R[c_voteshow]; ?>" type="text" size="3" maxlength="3" onKeyUp="chkformatnum(this)"> 
วัน<br>
<span class="style1">(ในกรณีที่ใส่เป็น 0 หรือ ช่องว่าง จะเป็นการไม่กำหนดเวลา)</span></span></td>
  </tr>
  
  <tr bgcolor="#FFFFFF">
    <td>กำหนดการแสดงหมายเลขเครื่อง (IP)</td>
    <td><select name="wip" id="wip" >
    <option value="Y" <?php if($R[c_showip] == "Y"){ echo "selected"; } ?>>แสดง</option>
    <option value="N" <?php if($R[c_showip] == "N"){ echo "selected"; } ?>>ไม่แสดง</option>
    </select></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="Submit" class="normaltxt">
      <input type="reset" name="Submit2" value="Reset" class="normaltxt">
      <input name="flag" type="hidden" id="flag" value="config">	  </td>
  </tr>
</form>
</table></td>
  </tr>
</table>
      </td>
    </tr>
  </table>
</body>
</html>
<script language="JavaScript">
function fixdate(t){
if(t.value == '0'){
document.getElementById('showdate').style.display ='' ; 
}else{
document.getElementById('showdate').style.display ='none' ; 
}
}
function CHK(){
if(document.form1.user.value == ""){
alert("กรุณาใส่ username");
document.form1.user.focus();
return false;
}
if(document.form1.pass.value == ""){
alert("กรุณาใส่ password");
document.form1.pass.focus();
return false;
}

if(document.form1.cpass.value != document.form1.pass.value){
alert("กรุณายืนยัน password ตรงกัน");
document.form1.cpass.select();
return false;
}
}
function CHK1(){
if(document.form2.nump.value == ""){
alert("กรุณาใส่จำนวนกระทู้ในหมวดต่อหนึ่งหน้า");
document.form2.nump.focus();
return false;
}
}
 function isNum (charCode) 
   {
       if (charCode >= 48 && charCode <= 57 )
	       return true;
      else
	     return false;
   }
 function chkFormatNam (str) {//0-9
  strlen = str.length;
  for (i=0;i<strlen;i++)
  {
      var charCode = str.charCodeAt(i);
	  if (!isNum(charCode) && (charCode!=46) && (charCode!=44)) {
		  return false;
	  }
   }
   return true;
}
function chkformatnum(t){ 
		_MyObj = t;
		_MyObj_Name = t.name;
		_MyObj_Value = t.value;
		_MyObj_Strlen =_MyObj_Value.length; 
		if( _MyObj_Strlen >1 && _MyObj_Value.substr(0,1)==0){
			t.value = _MyObj_Value.substr(1);
		}
		if(!chkFormatNam (t.value)){
				alert('กรุณากรอกตัวเลขเท่านั้น');
				t.value = 0;
				t.focus();
	} 
}
</script>
<?php @$db->db_close(); ?>