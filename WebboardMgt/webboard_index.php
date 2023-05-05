<?php
include("administrator.php");
include("lib/include.php");
include("inc.php");
$db->write_log("view","webboard","เข้าสู่ Module Webboard ");
$session_id = isset( $HTTP_COOKIE_VARS['phpbb2mysql_sid'] ) ? $HTTP_COOKIE_VARS['phpbb2mysql_sid'] : '';
$Execsql = $db->query("SELECT * FROM w_cate   ORDER BY c_id ASC");
$row = mysql_num_rows($Execsql); 

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
    <td width="60" height="58"><img src="../theme/main_theme/g_webboard_64.gif"> </td>
          <td><span class="ewthead">Webboard Management</span>
                  <hr width="100%" size="1"  align="left"  color="#D8D2BD">
                  <!--<span class="ewtsubmenu"><img src="../theme/main_theme/bullet.gif" width="16" height="16" align="absmiddle"> <a href="../ewt/<?php//php echo $EWT_FOLDER_USER;?>/board/admin/index.php?sid=<?php//php echo $session_id;?>" target="_blank">เข้าสู่กระทู้ phpbb2 </a></span>&nbsp;&nbsp;&nbsp;&nbsp;
				  <span class="ewtsubmenu"><img src="../theme/main_theme/bullet.gif" width="16" height="16" align="absmiddle"><a href="report_webboard2.php" target="iframe_data">รายงานการใช้งาน phpbb2</a></span>&nbsp;&nbsp;&nbsp;&nbsp;
				  <span class="ewtsubmenu"><img src="../theme/main_theme/bullet.gif" width="16" height="16" align="absmiddle"><a href="report_webboard_stat2.php" target="iframe_data">สถิติการเข้าWebboard phpbb2</a></span>&nbsp;&nbsp;&nbsp;&nbsp;
				  <span class="ewtsubmenu"><img src="../theme/main_theme/bullet.gif" width="16" height="16" align="absmiddle"> <a href="professor_list.php" target="iframe_data">ผู้เชี่ยวชาญ</a></span>&nbsp;&nbsp;&nbsp;&nbsp;-->
		    <?php if($db->check_permission("webboard","g","") || $db->check_permission("webboard","a","")   ){ ?>
			<nobr><span class="ewtsubmenu"><img src="../theme/main_theme/bullet.gif" width="16" height="16" align="absmiddle"> <a href="index_cate.php" target="iframe_data">หมวดกระทู้ </a></span>
			<?php } if($db->check_permission("webboard","s","")){ ?> &nbsp;&nbsp;
		    <span class="ewtsubmenu"><img src="../theme/main_theme/bullet.gif" width="16" height="16" align="absmiddle"> <a href="professor_list.php" target="iframe_data">ผู้เชี่ยวชาญ</a></span>
			<?php } if($db->check_permission("webboard","m","")){ ?> &nbsp;&nbsp;
		    <span class="ewtsubmenu"><img src="../theme/main_theme/bullet.gif" width="16" height="16" align="absmiddle"> <a href="subadmin.php"  target="iframe_data">บริหารผู้ดูแลหมวดกระทู้</a></span>
			<?php } if($db->check_permission("webboard","c","")){ ?> &nbsp;&nbsp;
			<span class="ewtsubmenu"><img src="../theme/main_theme/bullet.gif" width="16" height="16" align="absmiddle"> <a href="admin.php" target="iframe_data">ตั้งค่าเว็บบอร์ด</a></span>
			<?php } if($db->check_permission("webboard","e","")){ ?> &nbsp;&nbsp;
		    <span class="ewtsubmenu"><img src="../theme/main_theme/bullet.gif" width="16" height="16" align="absmiddle"> <a href="emotion_list.php" target="iframe_data">รูปภาพแสดงอารมณ์ </a></span>
			<?php } ?>  &nbsp;&nbsp;
		    <span class="ewtsubmenu"><img src="../theme/main_theme/bullet.gif" width="16" height="16" align="absmiddle"> <a href="report_webboard.php" target="iframe_data">รายงานการใช้งาน</a></span><br/>
		    <span class="ewtsubmenu"><img src="../theme/main_theme/bullet.gif" width="16" height="16" align="absmiddle"> <a href="report_webboard_stat.php" target="iframe_data">สถิติการเข้าเว็บบอร์ดจำนวนผู้ตอบ</a></span>&nbsp;&nbsp;
			<span class="ewtsubmenu"><img src="../theme/main_theme/bullet.gif" width="16" height="16" align="absmiddle"> <a href="report_webboard_stat_counter.php" target="iframe_data">สถิติการเข้าเว็บบอร์ดจำนวนผู้อ่าน </a></span>
			<?php if($db->check_permission("webboard","p","")){ ?> &nbsp;&nbsp;
			<span class="ewtsubmenu"><img src="../theme/main_theme/bullet.gif" width="16" height="16" align="absmiddle"> <a href="user_noused.php" target="iframe_data">ชื่อห้ามใช้</a></span></nobr>
			<?php } ?>
            <span class="ewtsubmenu"><img src="../theme/main_theme/bullet.gif" width="16" height="16" align="absmiddle"> <a href="index_del_request.php" target="iframe_data">แจ้งลบกระทู้/ความคิดเห็น</a></span></td>
  </tr>
</table>
	  </td>
  </tr>
  <tr> 
    <td height="10" background="../theme/main_theme/bg.gif" bgcolor="#FF3300"></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="#FFFFFF">
	<?php
	if($db->check_permission("webboard","g","") || $db->check_permission("webboard","a","")){  $start_page="index_cate.php";
	}else if($db->check_permission("webboard","s","")){ $start_page="professor_list.php";
	}else if($db->check_permission("webboard","m","")){ $start_page="subadmin.php";
	}else if($db->check_permission("webboard","c","")){ $start_page="admin.php";
	}else if($db->check_permission("webboard","e","")){ $start_page="emotion_list.php";
	}else{ 	$start_page="report_webboard.php";   }
	if($_GET[url] != ''){
	$start_page = $_GET[url];
	}else{
	$start_page = $start_page;
	}
	?>
	<table width="100%" height="100%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#FFFFFF">
                      <tr > 
                        <td bgcolor="#FFFFFF"><iframe name="iframe_data" src="<?php echo $start_page?>"  frameborder="0"  width="100%" height="100%" scrolling="yes"></iframe></td>
                      </tr>
                      
                    </table></td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close(); ?>
