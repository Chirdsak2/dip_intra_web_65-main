<?php
session_start();
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
<script src="../js/AjaxRequest.js"></script>
<script src="../js/excute.js"></script>
<script language="javascript1.2">
function show_txt(t){
	if(t=='0'){
		document.getElementById('fname').style.display = '';
		document.getElementById('org_id').style.display = 'none';
		document.getElementById('org_id').value = '';
	}else{
	document.getElementById('fname').style.display = 'none';
	document.getElementById('fname').value = '';
	document.getElementById('org_id').style.display = '';
	}
}
function findPosX(obj)
{
 var curleft = 0;
 if (document.getElementById || document.all)
 {
  while (obj.offsetParent)
  {
   curleft += obj.offsetLeft
   obj = obj.offsetParent;
  }
 }
 else if (document.layers)
  curleft += obj.x;
 return curleft;
}
function findPosY(obj)
{
 var curtop = 0;
 if (document.getElementById || document.all)
 {
  while (obj.offsetParent)
  {
   curtop += obj.offsetTop
   obj = obj.offsetParent;
  }
 }
 else if (document.layers)
  curtop += obj.y;
 return curtop;
}
function txt_data(w) {
	var mytop = findPosY(document.form1.org_id) +document.form1.org_id.offsetHeight;
	var myleft = findPosX(document.form1.org_id);	
	var objDiv = document.getElementById("nav");
	objDiv.style.top = mytop;
	objDiv.style.left = myleft;
	objDiv.style.display = '';
	url='nav_pad.php?d='+ w;
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
			}
		}
	);
	
}
</script>
</head>

<body leftmargin="0" topmargin="0" >
<div id="nav" style="position:absolute;width:262px; height:280px; z-index:1;display:none" ></div>
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
                      <td width="146" align="center" background="../images/bg1_off90.gif"><a href="ul_s_member.php?G=<?php echo $_GET[G];?>">รายบุคคล</a></td>
                      
                      <td width="141" background="../images/bg3_off90.gif"><div align="center"><a href="ul_s_member_list.php?G=<?php echo $_GET[G];?>">บุคคลในสังกัด</a></div></td>
                      <td width="143" background="../images/bg1_on90.gif"><div align="center">บุคคลในหน่วยงาน</div></td>
                      <td width="524" background="../images/bg2_off.gif">&nbsp;</td>
                    </tr>
					</table>
                      </td>
                    </tr>
                    <tr> 
                      <td height="30">&nbsp; </td>
                    </tr>
                    <tr> 
                      <td><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="919B9C">
                          <tr> 
                            <td bgcolor="#FFFFFF"><iframe name="m_data"  src="site_s1_member_group.php?G=<?php echo $_GET[G];?>"  frameborder="0"  width="100%" height="100%" scrolling="yes" ></iframe></td>
                          </tr>
                        </table></td>
                    </tr>
                    <tr align="right"> 
                      <td height="22"><input name="btapply" type="button" disabled id="btapply" onClick="m_data.form1.submit();" value="     OK     "> <input type="submit" name="Submit" value="  Cancel  " onClick="self.close();">
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
