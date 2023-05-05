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
</head>

<body>
<table width="100%" height="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="E0DFE3">
  <tr>
    <td><table width="100%" height="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="919B9C">
        <tr>
          <td bgcolor="F7F7F7"><table width="100%" height="100%" border="0" cellpadding="3" cellspacing="0">
              <tr>
                <td height="20"> <img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
                    <strong>Add User</strong></td>
              </tr>
              <tr>
                  <td valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr height="25"> 
                      <td align="center" ><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr height="25"> 
                      <td width="100" align="center" background="../images/bg1_off.gif"><a href="site_s_member.php?ug=<?php echo $_GET["ug"]; ?>">รายบุคคล</a> </td>
                      <td width="100" align="center" background="../images/bg1_on.gif">แผนก/หน่วยงาน </td>
                     <td width="100" align="center" background="../images/bg3_off.gif"><a href="site_s_member3.php?ug=<?php echo $_GET["ug"]; ?>">ระดับ</a> </td>
					 <td width="100" align="center" background="../images/bg3_off.gif"><a href="site_s_member4.php?ug=<?php echo $_GET["ug"]; ?>">กลุ่มผู้ใช้งาน</a></td>
                      <td background="../images/bg2_off.gif">&nbsp;</td>
                    </tr>
					</table>
                      </td>
                    </tr>
                    <tr> 
                      <td height="30"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <tr> 
                            <td width="5" background="../images/content_bg_line.gif"></td>
                            <td >&nbsp;&nbsp;&nbsp;หน่วยงานภายใต้การเคหะแห่งชาติ กระทรวงการพัฒนาสังคมและความมั่นคงของมนุษย์ </td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr> 
                      <td><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="919B9C">
                          <tr> 
                            <td bgcolor="#FFFFFF"><iframe name="m_data1" src="site_s2_member.php?ug=<?php echo $_GET["ug"]; ?>"  frameborder="0"  width="100%" height="100%" scrolling="yes" ></iframe></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="right"> 
                      <td height="22"><input name="btapply" type="button"  id="btapply" onClick="m_data1.form1.submit();" value="     OK     "> <input type="submit" name="Submit" value="  Cancel  " onClick="self.close();">
                        </td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close();
?>
