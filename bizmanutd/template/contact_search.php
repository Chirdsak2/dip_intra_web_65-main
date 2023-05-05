<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
 
$db->query("USE ".$EWT_DB_USER);
$user_id =$_SESSION["EWT_MID"];

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
	window.open('contact_main.php','sel', 'height=375,width=445, status=0, menubar=0,resizable=no, location=0, scrollbars=no, left=400, top=300');
	}else if(t=='2'){
	document.getElementById('oth').style.display = '';
	}
}
</script>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>

<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="E0DFE3">
  <tr>
    <td><table width="100%" height="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="919B9C">
      <tr>
        <td bgcolor="F7F7F7"><table width="100%" height="100%" border="0" cellpadding="3" cellspacing="0">
          <tr>
            <td valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
              <tr height="25">
                <td align="center" ><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr height="25">
                    <td width="100" align="center" background="../images/bg1_on.gif">ค้นหาเจ้าหน้าที่ </td>
                    <td background="../images/bg2_off.gif">&nbsp;</td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td height="30"><table width="100%" border="0" cellspacing="0" cellpadding="0">
                  <form name="form1" method="post" action="contact_member_list.php" target="m_data">
                    <tr>
                      <td width="5" background="../images/content_bg_line.gif"></td>
                      <td >&nbsp;&nbsp;&nbsp; ค้นหา
                        <input name="fname" type="text" id="fname" size="50">
                                  <input type="submit" name="Submit2" value="ค้นหา..." >
                                  <input name="ug" type="hidden" id="ug" value="<?php echo $_GET["ug"]; ?>">
                      </td>
                    </tr>
                  </form>
                </table></td>
              </tr>
              <tr>
                <td><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="919B9C">
                  <tr>
                    <td bgcolor="#FFFFFF"><iframe name="m_data"  frameborder="0"  width="100%" height="100%" scrolling="yes" ></iframe></td>
                  </tr>
                </table></td>
              </tr>
              <tr align="right">
                <td height="2"></td>
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
<?php  $db->db_close(); ?>
