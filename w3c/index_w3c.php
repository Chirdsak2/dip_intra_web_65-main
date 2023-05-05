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
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#333333">
  <tr> 
    <td height="28" bgcolor="#F3F3EE">
      
      <table width="100%" border="0" cellspacing="0" cellpadding="1">
        <tr>
          <td width="32"><img src="../theme/main_theme/ewt_logo.gif" width="28" height="28" align="absmiddle"></td>
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
    <td width="60" height="58"><img src="../theme/main_theme/module.gif" width="58" height="58"> </td>
          <td><span class="ewthead">W3C Management</span>
                  <hr width="100%" size="1"  align="left"  color="#D8D2BD">
            <span class="ewtsubmenu"><a href="../ewt/<?php echo $EWT_FOLDER_USER;?>/ewt_w3c/w3c_index.php" target="w3c_body"><img src="../theme/main_theme/bullet.gif" border="0" width="16" height="16" align="absmiddle"> หน้าหลัก</a></span>&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="ewtsubmenu"><a href="../ewt/<?php echo $EWT_FOLDER_USER;?>/ewt_w3c/w3c_index_template.php" target="w3c_body"><img src="../theme/main_theme/bullet.gif" border="0" width="16" height="16" align="absmiddle"> Template </a></span>&nbsp;&nbsp;&nbsp;&nbsp;
		    <span class="ewtsubmenu"><a href="main_w3c_tag_list.php" target="w3c_body"><img src="../theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle"> การจัดการ Tag</a></span>&nbsp;&nbsp;&nbsp;&nbsp;
		    <span class="ewtsubmenu"><a href="main_w3c_attribute_list.php" target="w3c_body"><img src="../theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle"> การจัดการ Attribute</a></span>&nbsp;&nbsp;&nbsp;&nbsp;
		    <span class="ewtsubmenu"><a href="main_w3c_correct_attribute_list.php" target="w3c_body"><img src="../theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle"> การจัดการข้อมูล Attribute แก้ไขหน้าเว็บอัตโนมัติ</a></span>&nbsp;&nbsp;&nbsp;&nbsp;</td>
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
                        <td bgcolor="#FFFFFF"><iframe name="w3c_body" src="../ewt/<?php echo $EWT_FOLDER_USER;?>/ewt_w3c/w3c_index.php"  frameborder="0"  width="100%" height="100%" scrolling="yes"></iframe></td>
                      </tr>
                      
                    </table></td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close(); ?>