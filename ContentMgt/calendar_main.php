<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
		$bcode = base64_decode($_GET["B"]);
$bid_a = explode("z",$bcode);
$BID = $bid_a[1];
$sql_file = $db->query("SELECT block_name FROM block WHERE BID = '".$BID."'");
if($db->db_num_rows($sql_file) == 1){
$R = $db->db_fetch_row($sql_file);
	?>
<html>
<head>
<title>Calendar Management</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0" >
<table width="100%" height="100%" border="0" cellpadding="5" cellspacing="0" bgcolor="E0DFE3">
  <tr>
    <td><table width="100%" height="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="919B9C">
        <tr>
          <td bgcolor="F7F7F7"><table width="100%" height="100%" border="0" cellpadding="3" cellspacing="0">
              <tr>
                <td height="10"> <img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
                    <strong>Block : <?php echo $R[0]; ?></strong></td>
              </tr>
              <tr>
                <td height="10"><hr width="100%" size="1"  align="left"  color="#D8D2BD">
				  <span class="ewtsubmenu"><a href="calendar_list.php?B=<?php echo $_GET["B"]; ?>"  target="calendar_move"><img src="../theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle">Calendar Config</a>   <a href="themes_list.php?B=<?php echo $_GET["B"]; ?>"  target="calendar_move"><img src="../theme/main_theme/bullet.gif" width="16" height="16" border="0" align="absmiddle">Theme Design for block </a></span>				 </td>
              </tr>
              <tr>
                  <td valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr height="25"> 
                      <td >&nbsp;</td>
                    </tr>
                    <tr> 
                      <td><iframe name="calendar_move" src="calendar_list.php?B=<?php echo $_GET["B"]; ?>" frameborder="1" width="100%" height="100%" scrolling="yes"></iframe></td>
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
<?php } ?>
<?php $db->db_close(); ?>
