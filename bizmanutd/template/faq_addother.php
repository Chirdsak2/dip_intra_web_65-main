<?php
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
 ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: none}
a:hover { color: #0099FF; text-decoration: none}
-->
</style>
</head>

<body leftmargin="0" topmargin="0" class="normal_font">
<div align="center">
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
    <tr valign="top">
      <td colspan="2">&nbsp;</td>
    </tr>
    <tr>
      <td valign="top"></td>
      <td width="100%" height="100%" valign="top"><table width="100%" height="100%" border="0" cellpadding="2" cellspacing="0" class="normal_font">
  <tr>
    <td height="25" bgcolor="#CCCCCC">&nbsp;</td>
  </tr>
<?php
$Execsql1 = $db->query("SELECT * FROM f_cat  inner join f_subcat  on   f_cat.f_id =f_subcat.f_id WHERE f_sub_id = '$f_sub_id'");
$QQ= $db->db_fetch_array($Execsql1);
?>

  <tr>
    <td colspan="2" valign="top">
	<DIV align="center"  style="HEIGHT: 100%;OVERFLOW-Y: auto;WIDTH: 100%"><br>
                <strong><font size="2" face="Tahoma">ส่งคำถาม FAQ ในหมวด "<?php echo $QQ[f_cate]; ?>"</font></strong> 
                <font size="2"><br>
                <strong><font face="Tahoma">หมวดย่อย "<?php echo $QQ[f_subcate]; ?>" ไปยังผู้ดูแลระบบ</font></strong> 
                </font> <br>
                 <br>
                <table width="90%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#333333" class="normal_font">
                  <form name="faq_add" method="post" action="faq_function.php">
                    <tr bgcolor="#FFFFFF"> 
                      <td width="17%" bgcolor="#F8F8F8">หัวข้อ</td>
                      <td width="83%"><textarea name="fname" cols="50" rows="3" wrap="VIRTUAL" id="fname"></textarea></td>
                    </tr>
                    <tr bgcolor="#FFFFFF"> 
                      <td bgcolor="#F8F8F8">รายละเอียด</td>
                      <td><textarea name="fdetail" cols="50" rows="4" wrap="VIRTUAL" id="fdetail"></textarea></td>
                    </tr>
                    <tr bgcolor="#FFFFFF"> 
                      <td bgcolor="#F8F8F8">คำตอบ</td>
                      <td><textarea name="fans" cols="50" rows="5" wrap="VIRTUAL" id="fans"></textarea></td>
                    </tr>
                    <tr bgcolor="#FFFFFF"> 
                      <td bgcolor="#F8F8F8">&nbsp;</td>
                      <td> <input type="submit" name="Submit" value="Submit"> 
                        <input name="flag" type="hidden" id="flag" value="addfaq"> 
                        <input name="f_id" type="hidden" id="f_id" value="<?php echo $f_id; ?>"> <input name="f_sub_id" type="hidden" id="f_sub_id" value="<?php echo $f_sub_id; ?>"></td>
                    </tr>
                  </form>
                </table>
              </DIV></td>
  </tr>
</table>
      </td>
    </tr>
    <tr valign="top">
      <td colspan="2">&nbsp;</td>
    </tr>
  </table>
</div>
</body>
</html>
<script language="JavaScript">
function CHK(){
if(document.form1.a_detail.value == ""){
alert("กรุณาใส่รายละเอียด");
document.faq_add.a_detail.focus();
return false;
}
if(document.faq_add.t_name.value == ""){
alert("กรุณาใส่ชื่อ");
document.form1.t_name.focus();
return false;
}
}
</script>
