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
<title>Article Management</title>
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
                <td height="20"> <img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
                    <strong>Block : <?php echo $R[0]; ?></strong></td>
              </tr>
              <tr>
                  <td valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr height="25"> 
                      <td ><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                    <tr height="25"> 
					<!--
                      <td width="100" align="center" background="../images/bg1_off.gif"><a href="content_article.php?B=<?php echo $_GET["B"]; ?>">Article 
                        Group</a> </td>
						-->
                      <td width="100" align="center" background="../images/bg1_on.gif">Manage 
                        Position </td>
                      <td width="100" align="center" background="../images/bg3_off.gif"><a href="article_design.php?B=<?php echo $_GET["B"]; ?>">Design</a> </td>
                      <td background="../images/bg2_off.gif">&nbsp;</td>
                    </tr>
					</table>
					</td>
                    </tr>
                    <tr> 
                      <td><iframe name="article_move" src="article_position_all.php?B=<?php echo $_GET["B"]; ?>" frameborder="1" width="100%" height="100%" scrolling="yes"></iframe></td>
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
