<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
$sql = $db->query("SELECT * FROM user_info WHERE UID = '".$_SESSION["EWT_SUID"]."' ");
$R = $db->db_fetch_array($sql);
function random_to($len){
			srand((double)microtime()*10000000);
			$chars = "ABCDEFGHJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz123456789";
			$ret_str = "";
			$num = strlen($chars);
			for($i=0;$i<$len;$i++){
				$ret_str .= $chars[rand()%$num];
			}
			return $ret_str;
	}
	$myFlag = random_to(20);
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript1.2">
<!--
top.window.moveTo(0,0);
if (document.all) {
top.window.resizeTo(screen.availWidth,screen.availHeight);
}
else if (document.layers||document.getElementById) {
if (top.window.outerHeight<screen.availHeight||top.window.outerWidth<screen.availWidth){
top.window.outerHeight = screen.availHeight;
top.window.outerWidth = screen.availWidth;
}
}
//-->
</script>
</head>
<body leftmargin="0" topmargin="0">
<?php
				$sql_user = $db->query("SELECT * FROM gen_user  WHERE gen_user_id = '".$_GET["gid"]."' ");
				$U = $db->db_fetch_array($sql_user);
				
				$sql_lead = $db->query("SELECT gen_user.name_thai,gen_user.surname_thai,leader_list.leader_id FROM gen_user INNER JOIN leader_list ON gen_user.gen_user_id = leader_list.leader_id WHERE leader_list.under_id = '".$U["gen_user_id"]."' ");
				$L = $db->db_fetch_row($sql_lead);
	   $Lname = $L[0]." ".$L[1];
				?>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#333333">
  <form name="formlink" method="post" action="ewt_permission2_function.php"><tr> 
    <td height="25" bgcolor="F3F3EE">
        <table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="70%">&nbsp;&nbsp;<img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"><img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
      <strong>Website : <?php echo $R["WebsiteName"]; ?> (<?php echo $R["EWT_User"]; ?>)</strong>
      
        <input type="hidden" name="mid" value=""><input type="hidden" name="mtype" value=""><input type="hidden" name="muse" value="">
        <input name="Flag" type="hidden" id="Flag"></td>
            <td align="right"><input name="t_set" type="hidden" id="t_set" value="<?php echo $_GET["gid"]; ?>">
			<input name="t_to" type="hidden" id="t_to" value="<?php echo $L[2]; ?>">
              <input name="myFlag" type="hidden" id="myFlag" value="<?php echo $myFlag; ?>">
              <input type="submit" name="Submit" value="  ยืนคำขอ  "></td>
          </tr>
        </table></td>
  </tr></form>
  <tr> 
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr> 
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
  <tr> 
    <td align="center" valign="top" bgcolor="F3F3EE"><table width="100%" height="100%" border="0" cellpadding="2" cellspacing="1">
        <tr> 
          <td width="30%" height="25" align="center" valign="top"><table width="100%" border="0" cellpadding="2" cellspacing="0">
              <tr>
                <td height="25"><img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
				กำหนดสิทธิ์ให้กับ  <?php echo $U["name_thai"]; ?> <?php echo $U["surname_thai"]; ?><br>
				
<img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> หัวหน้า : <?php echo $Lname; ?></td>
              </tr>
            </table></td>
          <td height="40%" rowspan="3" align="center" valign="top"><table width="100%" height="100%" border="0" cellpadding="2" cellspacing="0">
              <tr>
                <td height="25"><img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> Advance Properties</td>
              </tr>
			  <tr> 
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr> 
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
              <tr>
                <td align="center" valign="top" bgcolor="888888"><table width="100%" height="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#000000">
                      <tr> 
                        <td bgcolor="#FFFFFF"><iframe name="p_advance"  frameborder="0"  width="100%" height="100%" scrolling="yes"></iframe></td>
                      </tr>
                      
                    </table></td>
              </tr>
            </table></td>
        </tr>
     <!--<tr> 
          <td height="20" align="right"><input type="button" name="Submit2" value="   Add User   " onClick="win4=window.open('ewt_s_member.php?ug=<?php echo $_SESSION["EWT_SUID"]; ?>','usersq','width=650,height=400,scrollbars=1,resizable=1');win4.focus();">
            <input name="bt_remove" type="button" disabled id="bt_remove" value="Remove User"></td>
        </tr>-->
        <tr> 
          <td><table width="100%" height="100%" border="0" cellpadding="2" cellspacing="0">
		  <tr> 
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr> 
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
              <tr>
                <td height="25"><img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> Permission 
                  List</td>
              </tr>
			  <tr> 
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr> 
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
              <tr>
                <td align="center" valign="top" bgcolor="888888"><table width="100%" height="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#000000">
                      <tr> 
                        <td bgcolor="#FFFFFF"><iframe name="p_permission" src="ewt_p_list2.php?UID=<?php echo $_SESSION["EWT_SUID"]; ?>&mid=<?php echo $_GET["gid"]; ?>&mtype=U&myFlag=<?php echo $myFlag; ?>"  frameborder="0"  width="100%" height="100%" scrolling="yes"></iframe></td>
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
$db->db_close(); ?>
