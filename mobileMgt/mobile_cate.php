<?php
include("administrator.php");
include("lib/include.php");
include("inc.php");
include("../language/rude_language.php");

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" class="normal_font">
<div align="center">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/rude_function.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction">Mobile Updater</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><hr></td>
  </tr>
</table>
  <table width="94%" height="100%" border="0" cellpadding="0" cellspacing="0">
    <tr valign="top">
      <td colspan="2"><?php @include("com_top.php"); ?></td>
    </tr>
    <tr>
      <td valign="top"></td>
      <td width="100%" height="100%" valign="top">
	  
	  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" class="normal_font">
          <tr> 
            <td  valign="top"> 
			<DIV align="center"  style="HEIGHT: 100%;OVERFLOW-Y: auto;WIDTH: 100%"> 
                  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#B74900" class="ewttableuse">
                    <tr align="center" class="ewttablehead"> 
                      <td width="5%"></td>
                      <td width="20%">ชือโปรแกรม</td>
                      <td width="10%">เวอร์ชั่น</td>
                      <td width="10%">วันที่ออก</td>
                      <td width="55%">รายละเอียด</td>
                    </tr>
                    <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F5E0CD'" onMouseOut="this.style.backgroundColor='#FFFFFF'"> 
					
                      <td align="center"><a href="tmp.php?NowD=programs&FID=BizMobileUpdater.CAB" target="_blank"><img src="../theme/main_theme/g_download_16.png" border="0" alt="Download"></a></td>
                      <td align="left">Biz Mobile Updater</td>
                      <td align="center">1.0</td>
                      <td align="center">2008/07/01</td>
                      <td align="left"> เป็นโปรแกรมสำหรับอัพเดทเว็บไซต์ผ่านมือถือ โดยเครื่องมือถือที่ใช้จะต้องเป็น Windows Mobile 6.0 ขึ้นไป </td>
                    </tr>
                    <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F5E0CD'" onMouseOut="this.style.backgroundColor='#FFFFFF'">
                      <td align="center"><a href="tmp.php?NowD=programs&FID=BizMobileUpdater_Demo.CAB" target="_blank"><img src="../theme/main_theme/g_download_16.png" border="0" alt="Download"></a></td>
                      <td align="left">Demo Biz Mobile Updater </td>
                      <td align="center">1.0</td>
                      <td align="center">2008/07/25</td>
                      <td align="left">เป็นโปรแกรมสำหรับอัพเดทเว็บไซต์ผ่านมือถือ โดยเครื่องมือถือที่ใช้จะต้องเป็น Windows Mobile 6.0 ขึ้นไป<br>
                        (เป็นตัวทดลองนะค่ะ)</td>
                    </tr>
                    <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F5E0CD'" onMouseOut="this.style.backgroundColor='#FFFFFF'">
                      <td align="center"><a href="tmp.php?NowD=programs&FID=ActiveSync4.5.msi" target="_blank"><img src="../theme/main_theme/g_download_16.png" border="0" alt="Download"></a></td>
                      <td align="left">ActiveSync</td>
                      <td align="center">4.5</td>
                      <td align="center">2008/07/25</td>
                      <td align="left">เป็นโปรแกรมสำหรับมือถือ HTC ใช้ในการติดต่อ HTCกับเครื่องคอมพิวเตอร์ ด้วยสาย link </td>
                    </tr>
                  </table>
             </DIV>
			 </td>
          </tr>
        </table>
		
		
      </td>
    </tr>
    <tr valign="top">
      <td colspan="2"><?php @include("com_bottom.php"); ?></td>
    </tr>
  </table>
  </form>
</div>
</body>
</html>
<script language="JavaScript">
function CHK(){
	if(document.form1.t_topic.value == ""){
		alert("กรุณาใส่คำไม่สุภาพ");
		document.form1.t_topic.focus();
		return false;
	}
	
	return true;
}
</script>
<?php $db->db_close(); ?>
