<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
if(!$db->check_permission("Ebook","w","")){
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
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#333333">
  <tr> 
    <td height="20" bgcolor="F3F3EE">
      <?php include("../ewt_menu.php"); ?>
    </td>
  </tr>
  <tr> 
    <td height="1" bgcolor="D8D2BD"></td>
  </tr>
  <tr> 
    <td height="1" bgcolor="#FFFFFF"></td>
  </tr>
  <tr> 
    <td height="1" bgcolor="AAAAAA"></td>
  </tr>
  <tr> 
    <td valign="top" bgcolor="808080"><table width="100%" height="100%" border="0" cellpadding="3" cellspacing="0">
        <tr>
          <td><table width="100%" height="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#000000">
                      <tr> 
                        <td bgcolor="#FFFFFF"><iframe name="book_body" src="book_mgt.php" frameborder="0"  width="100%" height="100%" scrolling="yes"></iframe></td>
                      </tr>
                      
                    </table></td>
        </tr>
      </table></td>
  </tr>
</table>
</body>
</html>
<?php $db->db_close(); ?>
