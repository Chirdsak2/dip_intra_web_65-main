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
<style type="text/css">
<!--
.style2 {color: #006699}
-->
</style>
</head>
<script language="javascript1.2">
function listname(t,u){
self.contact_name.location.href="contact_list.php?groupid=" + t.value + "&user_id=" + u;
self.contact_detail.location.href="contact_detail.php";
}
</script>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr> 
    <td  align="center" valign="top"><table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td class="myhead_02"><img src="mainpic/edit_user.gif" width="25" height="25" align="absmiddle">บริหารรายชื่อ  </td>
      </tr>
    </table>
      <table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
      <tr>
        <td align="right"><a href="contact_add_member.php"><img src="mainpic/add.gif" width="16" height="16" border="0" align="absmiddle">เพิ่มรายชื่อ</a>
           <hr>
        </td>
      </tr>
    </table>
	<br><br>
      <table width="90%" border="0" align="center" cellpadding="3" cellspacing="1">
        <tr>
          <td colspan="2">กลุ่ม :
            <?php
							$sql = "select * from contact_group where user_id = '$user_id'";
							$query = $db->query($sql);
							$num = mysql_num_rows($query);
							if($num > 0){
					?>
              <select name="group_name" onChange="listname(this,'<?php echo $user_id ;?>');">
                <option value="">---ไม่เข้ากลุ่ม---</option>
                <?php
							
							while($R = $db->db_fetch_array($query)){
							echo "<option value=\"".$R[contact_group_id]."\">".$R[contact_group_name]."</option>";
							}
							
						?>
              </select>
              <?php }else{ echo "-";}?>
            &nbsp;&nbsp;&nbsp;</td>
        </tr>
        <tr>
          <td width="31%"><table width="100%" height="100%" border="0" cellpadding="1" cellspacing="2" bgcolor="#CCCCCC">
              <tr>
                <td bgcolor="#FFFFFF"><table width="98%" border="0" cellspacing="0" cellpadding="1">
                    <tr>
                      <td><iframe name="contact_name" frameborder="0" src="contact_list.php"  width="200" height="350" scrolling="yes" ></iframe></td>
                    </tr>
                </table></td>
              </tr>
          </table></td>
          <td width="69%"><table width="100%" height="100%" border="0" cellpadding="1" cellspacing="2" bgcolor="#CCCCCC">
              <tr>
                <td bgcolor="#FFFFFF"><table width="98%" border="0" align="center" cellpadding="1" cellspacing="0">
                    <tr>
                      <td><iframe name="contact_detail"   frameborder="0"  width="100%" height="350" scrolling="no" ></iframe></td>
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
