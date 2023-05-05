<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
 
$db->query("USE ".$EWT_DB_USER);
$user_id =$_SESSION["EWT_MID"];
$sql = "select * from contact_list where contact_list_id ='$id' ";
$query = $db->query($sql);
$R = $db->db_fetch_array($query);
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
</head>

<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td  align="center" valign="top"> <br><br> <form name="form1" method="post" action="contact_function.php"  onSubmit="return CHK(this);">
                          <table width="66%" border="0" cellpadding="0" cellspacing="0">
						    <tr>
                              <td height="30" colspan="2" valign="top"><strong>แก้ไขชื่อ contact </strong></td>
                            </tr>
                            <tr>
                              <td width="17%" height="22">ชื่อ : </td>
                              <td width="83%" height="22"><input type="text" name="user_name" value="<?php echo $R[contact_list_name];?>"></td>
                            </tr>
                            <tr>
                              <td height="22">สกุล : </td>
                              <td height="22"><input type="text" name="user_sername"  value="<?php echo $R[contact_list_name];?>"></td>
                            </tr>
                            <tr>
                              <td height="22">กลุ่ม : </td>
                              <td height="22"><?php
							$sql1 = "select * from contact_group where user_id = '$user_id'";
							$query1 = $db->query($sql1);
							$num = mysql_num_rows($query1);
							if($num > 0){
					?>
					  <select name="group_name" onChange="listname(this,'1');">
					  <option value="">---เลือกกลุ่ม---</option>
					    <?php
							
							while($R1 = $db->db_fetch_array($query1)){
							if($R1[contact_group_id] ==$R[contact_group_id] ){ $se = 'selected';}else{$se = '';}
							echo "<option value=\"".$R1[contact_group_id]."\" ".$se.">".$R1[contact_group_name]."</option>";
							}
							
						?>
					    </select>
						<?php }else{ echo "-";}?>                              </td>
                            </tr>
                            <tr>
                              <td height="22">email : </td>
                              <td height="22"><label>
                                <input type="text" name="email"  value="<?php echo $R[contact_list_email];?>">
                              </label></td>
                            </tr>
                            <tr>
                              <td colspan="2" align="center"><label>
                                <input type="submit" name="Submit" value="บันทึก">
                                <input type="hidden" name="flag" value="edit_member">
								 <input type="hidden" name="id" value="<?php echo $_GET["id"];?>">
                              </label></td>
                            </tr>
                          
                          </table>
                    </form></td>
  </tr>
</table>
</body>
</html>
<?php  $db->db_close(); ?>
