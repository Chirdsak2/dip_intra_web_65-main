<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
if(!$db->check_permission("art","","")){
				?>
				<script language="JavaScript">
				alert("You can not access this section!!");
				window.history.back();
				</script>
				<?php
}
	?>
<html>
<head>
<title>Article Management</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<link href="../css/style_calendar.css" rel="stylesheet" type="text/css">
<script language="JavaScript"  type="text/javascript" src="../js/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/calendar-th.js"></script>
<script language="JavaScript">
	function DelForm(){
		if(confirm("Are you sure you want to delete selected data?")){
			article_data.form1.submit();
		}
	}
	function CHK(t){
	if(t.search_txt.value == '' && t.date_s.value == '' && t.date_e.value == ''){
	alert("กรุณาระบุเงื่อนไขการค้นหา!!!!!!!!!!!");
	return false;
	}else{
	return true;
	}
	return false;
	}
</script>
</head>
<body leftmargin="0" topmargin="0" >
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
    <td width="60" height="58"><img src="../theme/main_theme/g_sitestats_64.gif" width="64" height="64"> </td>
                <td><span class="ewthead">Article stat </span>
                  <hr width="100%" size="1"  align="left"  color="#D8D2BD">
				  <span class="ewtsubmenu"><a href="article_admin_stat.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle">  รายงานการใช้งานข่าว/บทความ</a></span>&nbsp;&nbsp;&nbsp;&nbsp;
            <span class="ewtsubmenu"><a href="article_group_stat.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle">  จำนวนข่าว/บทความในหมวดต่างๆ</a></span>&nbsp;&nbsp;&nbsp;&nbsp; 
			<span class="ewtsubmenu"><a href="article_favor_stat.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle">   ข่าว/บทความยอดนิยม</a></span>&nbsp;&nbsp;&nbsp;&nbsp; 
		  <span class="ewtsubmenu"><a href="article_vote_stat.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle">   ข่าว/บทความที่มีคะแนน vote สูงสุด</a></span>&nbsp;&nbsp;&nbsp;&nbsp; 
       <span class="ewtsubmenu"><a href="article_admindownload_stat.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle">  รายงานการ Download ข่าว/บทความ</a></span><!--&nbsp;&nbsp;&nbsp;&nbsp;
            <br><span class="ewtsubmenu"><a href="article_download_stat.php" target="iframe_data"><img src="../theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle">   รายงานผู้  Download  ข่าว/บทความ </a></span--></td>
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
                        <td bgcolor="#FFFFFF"><iframe name="iframe_data" src="article_admin_stat.php"  frameborder="0"  width="100%" height="100%" scrolling="yes"></iframe></td>
                      </tr>
                      
                    </table></td>
  </tr>
</table>
</body>
</html>
<?php $db->db_close(); ?>
