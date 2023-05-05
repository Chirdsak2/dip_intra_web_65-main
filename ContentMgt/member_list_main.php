<?php
session_start();

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
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css"></head>
<script language="javascript1.1">

function used_user(){
var alli = m_data.form1.alli.value;
var uid = '';
var uname='';
var chkused;
window.opener.document.getElementById('hdd_uid').value = '';
window.opener.document.all.txtshow.innerHTML = '';

	for(var i=0;i<alli;i++){
		if(m_data.form1.document.getElementById('chk'+i).checked == true){
			if(uid == '') {
			uid = m_data.form1.document.getElementById('uid'+i).value;
			uname = m_data.form1.document.getElementById('uname'+i).value;
			}else{
			uid = uid+','+m_data.form1.document.getElementById('uid'+i).value;
			uname = uname+','+m_data.form1.document.getElementById('uname'+i).value;
		//	alert(uid);
			}
		}
		window.opener.document.getElementById('tr_user').style.display = '';
		window.opener.document.getElementById('hdd_uid').value = uid;
		window.opener.document.all.txtshow.innerHTML = uname;
	}
}
</script>
<body>
<table width="100%" height="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="E0DFE3">
  <tr>
    <td><table width="100%" height="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="919B9C">
        <tr>
          <td bgcolor="F7F7F7"><table width="100%" height="100%" border="0" cellpadding="3" cellspacing="0">
              <tr>
                <td height="20"> <img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"><strong> กำหนดสิทธิ์ </strong></td>
              </tr>
              <tr>
                  <td valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr height="25"> 
                      <td align="center" ><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr height="25"> 
                      <td width="100" align="center" background="../images/bg1_on.gif">รายบุคคล </td>
                      <td width="100" align="center" background="../images/bg3_off.gif"><a href="member_list_main2.php?ug=<?php echo $_GET[ug]; ?>">หน่วยงาน</a> </td>
                      <td width="100" align="center" background="../images/bg3_off.gif"><a href="member_list_main3.php?ug=<?php echo $_GET[ug]; ?>">กลุ่มสิทธิ์</a> </td>
                      <td width="100" align="center" background="../images/bg3_off.gif"><a href="member_list_main4.php?ug=<?php echo $_GET[ug]; ?>">กลุ่มบุคคล</a> </td>
                      <td background="../images/bg2_off.gif">&nbsp;</td>
                    </tr>
					</table>
                      </td>
                    </tr>
                    <tr> 
                      <td height="30"> <table width="100%" border="0" cellspacing="0" cellpadding="0">
                          <form name="form1" method="post" action="member_list1_user.php" target="m_data"><tr> 
                            <td width="5" background="../images/content_bg_line.gif"></td>
                            <td >&nbsp;&nbsp;&nbsp; ค้นหา 
                              <input name="fname" type="text" id="fname" size="50">
                              <input type="submit" name="Submit2" value="Find Now..." >
                              
                                <input name="ug" type="hidden" id="ug" value="<?php echo $_GET["ug"]; ?>">
								<input name="id" type="hidden" id="id" >
                               </td>
                          </tr></form>
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
                      <td height="22"><input name="btapply" type="button" disabled id="btapply" onClick="used_user()"  value="     OK     "> <input type="submit" name="Submit" value="  Cancel  " onClick="self.close();">
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
<script language="javascript1.2">
form1.document.getElementById('id').value = window.opener.document.getElementById('hdd_uid').value;

</script>
<?php
$db->db_close();
?>
