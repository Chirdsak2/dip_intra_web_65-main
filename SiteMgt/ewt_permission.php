<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function chge(){
iframe_data.location.href=document.form1.m_select.value;
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#333333">
  <tr> 
    <td height="28" bgcolor="#F3F3EE">
      
      <table width="100%" border="0" cellspacing="0" cellpadding="1">
        <tr>
          <td width="32"><img src="../theme/main_theme/ewt_logo.gif" width="28" height="28" align="absmiddle" onClick="top.ewt_main.location.href = '../ewt_main.php';"></td>
          <td><?php include("../ewt_menu.php"); ?></td>
		  <td width="15" align="right" valign="top"><div align="right"><img src="../images/bar_close.gif" width="15" height="13" border="1" style="border-Color:threedface"  title="Close" onClick="top.ewt_main.location.href = '../ewt_main.php';"></div></td>
        </tr>
      </table> </td>
  </tr>
  <tr> 
    <td height="1" bgcolor="#D8D2BD"></td>
  </tr>
  <tr> 
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
   <tr> 
    <td height="20" bgcolor="#FFFFFF"><table width="100%" border="0" cellpadding="1" cellspacing="0">
        <tr> 
          <td align="right">Website : <?php echo $_SESSION["EWT_SUSER"]; ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp; User : <?php echo $_SESSION["EWT_SMUSER"]; ?>&nbsp;&nbsp;&nbsp;</td>
        </tr>
      </table>
	  <table width="98%" border="0" align="center" cellpadding="2" cellspacing="0">
  <tr> 
    <td width="60" height="58"><img src="../theme/main_theme/g_permission_64.gif"> </td>
          <td><span class="ewthead">Permission</span>
                  <hr width="100%" size="1"  align="left"  color="#D8D2BD">
            <span class="ewtsubmenu"><a href="ewt_permission0.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle"> 
            กำหนดสิทธิ์ผู้ใช้งานระบบ</a></span> 
            <?php
			if($_SESSION["EWT_SMTYPE"] == "Y"){
			?>
			&nbsp;&nbsp;&nbsp;&nbsp;<span class="ewtsubmenu"><a href="ewt_permission_all.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle"> 
            ผู้ใช้ระบบทั้งหมด</a></span> 
			
            &nbsp;&nbsp;&nbsp;&nbsp;<span class="ewtsubmenu"><a href="ewt_permission_g.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle"> 
            กำหนดสิทธิ์กลุ่มผู้ใช้งาน</a></span> 
            <?php
			}
			?>
            <?php
			if($_SESSION["EWT_SMID"] != ""){
			?>
            &nbsp;&nbsp;&nbsp;&nbsp; <span class="ewtsubmenu"><a href="send_permission.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle"> 
            กำหนดสิทธิ์ให้ผู้อื่น</a></span>&nbsp;&nbsp;&nbsp;&nbsp; <span class="ewtsubmenu"><a href="wait_permission.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle"> 
            ติดตามผลการดำเนินงาน</a></span>&nbsp;&nbsp;&nbsp;&nbsp; <span class="ewtsubmenu"><a href="approve_permission.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle"> 
            ตรวจสอบคำขอ</a></span> 
            <?php
			}
			if($_SESSION["EWT_SMTYPE"] == "Y"){
			?>
			<span class="ewtsubmenu"><a href="ewt_permission_ldap.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle"> 
            กำหนดกลุ่ม LDAP</a></span> 
			<?php } ?>
          </td>
  </tr>
</table>
	  </td>
  </tr>
  <tr> 
    <td height="10" background="../theme/main_theme/bg.gif" bgcolor="#FF3300"></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#FFFFFF"><table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
                      <tr> 
                        <td bgcolor="#FFFFFF"><iframe name="iframe_data" src="ewt_permission0.php"  frameborder="0"  width="100%" height="100%" scrolling="yes"></iframe></td>
                      </tr>
                      
                    </table></td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close(); ?>