<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
 
$db->query("USE ".$EWT_DB_USER);
$user_id =$_SESSION["EWT_MID"];

?>
<html>
<head>
<title>My Website</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/mysite.css" rel="stylesheet" type="text/css">
<script language="javascript1.2">
function chang_detail(t){
	if(t=='1'){
	document.getElementById('oth').style.display = 'none';
	window.open('contact_search.php','sel', 'height=375,width=445, status=0, menubar=0,resizable=no, location=0, scrollbars=no, left=400, top=300');
	}else if(t=='2'){
	document.getElementById('oth').style.display = '';
	}
}
function mail_format(){
		var goodEmail1 = form1.email.value.match(/\b(^(\S+@).+((\.com)|(\.net)|(\.edu)|(\.mil)|(\.gov)|(\.org)|(\.co.th)|(\.go.th)|(\.localnet)|(\..{2,2}))$)\b/gi);
		 if(form1.email.value==''){
			alert('กรุณากรอก E-mail  ของท่าน');
			form1.email.focus();
			return false;
		 }else if (!goodEmail1){
			alert('รูปแบบ E-mail  ไม่ถูกต้อง')
			form1.email.focus();
			form1.email.select();
			return false;
		}
}
function CHK(t){
if(t.user_name.value == ''){
alert("กรุณากรอกชื่อ");
return false;
}
if(t.user_sername.value == ''){
alert("กรุณากรอกนามสกุล");
return false;
}
return mail_format();

}
</script>
<style type="text/css">
<!--
.style2 {color: #006699}
-->
</style>
</head>

<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td  align="center" valign="top"><table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td class="myhead_02"><img src="mainpic/edit_user.gif" width="25" height="25" align="absmiddle">บริหารรายชื่อ  </td>
      </tr>
    </table>
      <table width="90%" border="0" align="center" cellpadding="3" cellspacing="1">
      <tr>
        <td height="19" align="right" valign="top"><strong><a href="contact_main.php"><img src="mainpic/m_home.gif" width="16" height="16" border="0" align="absmiddle">กลับ</a></strong><hr></td>
      </tr>
      <tr>
        <td height="20" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;<strong>&nbsp;&nbsp;เลือกรูปแบบการเพิ่มรายชื่อ : </strong></td>
      </tr>
      <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input name="u_type" type="radio" value="1" onClick="chang_detail(this.value);">
          สมาชิกภายใน</td></tr>
      <tr>
        <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
		<input name="u_type" type="radio" value="2" onClick="chang_detail(this.value);">
          อื่นๆ</td></tr>
      <tr style="display:none" id="oth">
        <td align="center"><form name="form1" method="post" action="contact_function.php" onSubmit="return CHK(this);">
            <table width="66%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="17%" height="22">ชื่อ : </td>
                <td width="83%" height="22"><input type="text" name="user_name"></td>
              </tr>
              <tr>
                <td height="22">สกุล : </td>
                <td height="22"><input type="text" name="user_sername"></td>
              </tr>
              <tr>
                <td height="22">กลุ่ม : </td>
                <td height="22"><?php
							$sql = "select * from contact_group where user_id = '$user_id'";
							$query = $db->query($sql);
							$num = mysql_num_rows($query);
							if($num > 0){
					?>
                    <select name="group_name" >
                      <option value="" selected>---ไม่เข้ากลุ่ม---</option>
                      <?php
							
							while($R = $db->db_fetch_array($query)){
							echo "<option value=\"".$R[contact_group_id]."\">".$R[contact_group_name]."</option>";
							}
							
						?>
                                        </select>
                    <?php }else{ echo "-";}?>                </td>
              </tr>
              <tr>
                <td height="22">email : </td>
                <td height="22"><label>
                  <input type="text" name="email">
                </label></td>
              </tr>
              <tr>
                <td colspan="2" align="center"><label>
                  <input type="submit" name="Submit" value="บันทึก">
                  <input type="hidden" name="flag" value="add_member">
                </label></td>
              </tr>
            </table>
        </form></td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php  $db->db_close(); ?>
