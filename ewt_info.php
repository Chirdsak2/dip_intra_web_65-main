<?php
include("lib/permission.php");
include("lib/include.php");
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

 				$f1 = fopen("font_list.txt","r");
			  while($line1 = fgets($f1,1024)){
			  $fontL .= $line1; 
			  }
			  fclose($f1);
			 $FontA = explode("###",$fontL);  

$sql = "select * from site_info";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
$db->query("USE ".$EWT_DB_USER);
$sql_user = "select url from user_info where UID = '".$_SESSION["EWT_SUID"]."'";
$query_user = $db->query($sql_user);
$rec_user = $db->db_fetch_array($query_user);
$db->query("USE ".$EWT_DB_NAME);
	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="javascript" src="js/functions.js"></script>
<script language="javascript1.2">
function selColor(c,d){
				Win2=window.open('ewt_color.php?c_value='+ c +'&c_block=' + d + '','sel', 'height=175,width=245, status=0, menubar=0,resizable=no, location=0, scrollbars=no, left=400, top=300');
			}
			  	function CreColor(va,bg,pre,flag){
				  	bg.style.backgroundColor= va;
					if(flag == 'color'){
  						pre.style.color = va;
					}else{
						pre.style.backgroundColor = va;
					}
				}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#333333">
  <tr> 
    <td height="28" bgcolor="#F3F3EE">
      
      <table width="100%" border="0" cellspacing="0" cellpadding="1">
        <tr>
          <td width="32"><img src="theme/main_theme/ewt_logo.gif" width="28" height="28" align="absmiddle"></td>
          <td><?php include("ewt_menu.php"); ?></td>
		  <td width="15" align="right" valign="top"><div align="right"><img src="images/bar_close.gif" width="15" height="13" border="1" style="border-Color:threedface"  title="Close" onClick="top.ewt_main.location.href = 'ewt_main.php';"></div></td>
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
    <td width="60" height="58"><img src="theme/main_theme/g_properties_64.gif"> </td>
          <td><span class="ewthead">Site Properties</span>
          <hr width="100%" size="1"  align="left"  color="#D8D2BD">
          <span class="ewtsubmenu"><a href="ewt_info_site.php" target="iframe_data"><img src="theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle"> ตั้งค่าคุณสมบัติเว็บไซต์</a></span>&nbsp;&nbsp;&nbsp;&nbsp;
		  <span class="ewtsubmenu"><a href="ewt_info_interf.php" target="iframe_data"><img src="theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle"> ตั้งค่าตัวอักษรที่ใช้ในเว็บไซต์</a></span>&nbsp;&nbsp;&nbsp;&nbsp;
		  <span class="ewtsubmenu"><a href="ewt_info_module_config.php" target="iframe_data"><img src="theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle"> ตั้งค่า Module ต่างๆ</a></span>&nbsp;&nbsp;&nbsp;&nbsp;
		  <span class="ewtsubmenu"><a href="ewt_info_email_config.php" target="iframe_data"><img src="theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle"> ตั้งค่า E-mail สำหรับ Module ต่างๆ</a></span>&nbsp;&nbsp;&nbsp;&nbsp;
		  <span class="ewtsubmenu"><a href="ewt_info_contact.php" target="iframe_data"><img src="theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle">ตั้งค่าข้อมูลการติดต่อ </a></span>&nbsp;&nbsp;&nbsp;&nbsp;
				<!--  <span class="ewtsubmenu"><img src="theme/main_theme/bullet.gif" width="16" height="16" align="absmiddle"> Ftp Setting</span>-->				  </td>
  </tr>
</table>
	  </td>
  </tr>
  <tr> 
    <td height="10" background="theme/main_theme/bg.gif" bgcolor="#FF3300"></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#FFFFFF"><table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
                      <tr> 
                        <td bgcolor="#FFFFFF"><iframe name="iframe_data" src="ewt_info_site.php"  frameborder="0"  width="100%" height="100%" scrolling="yes"></iframe>;</td>
                      </tr>
                      
                    </table></td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close(); ?>
