<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#333333">
  <tr> 
    <td  ><table width="52%" border="0" align="center" cellpadding="4" cellspacing="0">
      <form name="search" method="post" action="search_result.php">
        <tr align="center">
          <td height="15" colspan="2">&nbsp;</td>
        </tr>
        <tr>
          <td width="211" align="right">ค้นหา</td>
          <td width="339"><input name="keyword" type="text" id="keyword"  size="30">
              <input type="submit" name="Submit" value="ค้นหา...">          </td>
        </tr>
        <tr>
          <td>&nbsp;</td>
          <td><input name="oper" type="radio" value="AND" checked >
            ค้นหาทุกคำ
            <input name="oper" type= "radio"value="OR">
            ค้นหาบางคำ</td>
        </tr>
      </form>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close(); ?>
