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
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="E0DFE3">
<tr> 
    <td height="20" bgcolor="F3F3EE">
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
       <tr> 
            <td> 
              <?php include("../ewt_menu.php"); ?>
               </td>
          <td width="19" align="center" ><img src="../images/bar_close.gif" width="15" height="13" border="1" style="border-Color:threedface"  title="Close" onClick="top.ewt_main.location.href = '../ewt_main.php';"></td>
        </tr>
      </table>
    </td>
  </tr>
  <tr> 
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr> 
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
  <tr>
    <td><table width="100%" height="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="919B9C">
        <tr>
          <td bgcolor="F7F7F7"><table width="100%" height="100%" border="0" cellpadding="3" cellspacing="0">
              <tr>
                  <td valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr height="25"> 
                      <td align="center" ><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr height="25"> 
                      <td width="100" align="center" background="../images/bg1_on.gif">Article 
                        Group </td>
                     <td width="100" align="center" background="../images/bg3_off.gif"><a href="article_useshare.php">Use Share Article</a> </td>
                      <td width="100" align="center" background="../images/bg3_off.gif"><a href="article_share_auto.php">Setting Share Auto</a></td>
                      <td background="../images/bg2_off.gif">&nbsp;</td>
                    </tr>
					</table>
                      </td>
                    </tr>
                    <tr> 
                      <td height="30"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr> 
                            <td width="5" background="../images/content_bg_line.gif"></td>
                            <td width="325" height="25" > &nbsp;&nbsp;<a name="backoff"><img src="../images/article_back_off.gif" width="20" height="20" border="0" align="absmiddle"> 
                              <font color="#999999">Back</font></a><a name="backon" style="display:none" href="#" onClick="article_data.location.href=article_data.document.form1.backto.value;"><img src="../images/article_back.gif" width="20" height="20" border="0" align="absmiddle"> 
                              Back</a>&nbsp;&nbsp;&nbsp;<a name="folderoff" style="display:none"><img src="../images/article_newfolder_off.gif" width="20" height="20" border="0" align="absmiddle"> 
                              <font color="#999999">New Group</font></a><a name="folderon" href="#" onClick="article_data.document.all.new_fo.style.display = '';article_data.document.form1.new_folder.focus();"><img src="../images/article_newfolder.gif" width="20" height="20" border="0" align="absmiddle"> 
                              New Group</a>&nbsp;&nbsp;&nbsp;<a href="#" onClick="article_data.location.href='article_new.php';"><img src="../images/article_newfile.gif" width="20" height="20" border="0" align="absmiddle"> 
                              New Article</a></td>
                            <td width="601" ><form name="form1" method="post" action="?"  onSubmit="return CHK(this)">
                              ค้นหา Article :
                              <input type="text" name="search_txt" value="<?php echo $_POST["search_txt"];?>">
วันที่ :
<input name="date_s" type="text" size="11" value="<?php echo $_POST["date_s"];?>">
<img src="../images/calendar.gif" alt="..เปิดปฎิทิน." width="20" height="20" border="0" align="absmiddle" onClick="return showCalendar('date_s', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';"> ถึง
<input name="date_e" type="text" size="11" value="<?php echo $_POST["date_e"];?>">
<img src="../images/calendar.gif" alt="..เปิดปฎิทิน." width="20" height="20" border="0" align="absmiddle" onClick="return showCalendar('date_e', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';">
<input type="submit" name="Submit" value="ค้นหา"><input name="serach_flag" type="hidden" value="<?php echo $_POST["serach_flag"];?>">
                                                        </form>                            </td>
                          </tr>
                          
                        </table></td>
                    </tr>
                    <tr> 
                      <td>

					  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="919B9C">
                          <tr> 
                            <td bgcolor="#FFFFFF"><iframe name="article_data" src="article_list2.php?serach_flag=<?php echo $_POST["serach_flag"];?>&&search_txt=<?php echo $_POST["search_txt"];?>&&date_s=<?php echo $_POST["date_s"];?>&&date_e=<?php echo $_POST["date_e"];?> " frameborder="0"  width="100%" height="100%" scrolling="yes" ></iframe></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="right"> 
                      <td height="22"><a name="deloff" style="display:none"><img src="../images/article_del_off.gif" width="20" height="20" border="0" align="absmiddle"> 
                        <font color="#999999">Delete Selected</font></a><a name="delon" href="#del" onClick="DelForm()"><img src="../images/article_del.gif" width="20" height="20" border="0" align="absmiddle"> 
                        Delete Selected</a></td>
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
<?php $db->db_close(); ?>
