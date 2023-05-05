<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include("webboard_log.php");
$sql = $db->query("select * from w_question where t_id='".$_GET["wtid"]."'");
$rec = $db->db_fetch_array($sql);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php if($MyTitle==""){?>===== Welcome =====<?php }else{ echo $MyTitle; }?></title>
<link href="css/menu.css" rel="stylesheet" type="text/css">
<link href="../../css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
<form name="form1" method="post" action="question_function.php">
  <table width="100%" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td height="40" colspan="2" class="MemberHead">=&gt;การกำหนด keyword </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="right">ระบุ keyword : </td>
      <td><textarea name="txt_key" cols="50" rows="5"><?php echo $rec[keyword];?></textarea>      </td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="Submit" value="บันทึก">
      <input type="hidden" name="flag" value="keyword">
      <input type="hidden" name="wtid" value="<?php echo  $_GET["wtid"];?>"></td>
      <td>&nbsp;</td>
    </tr>
  </table>
</form>
</body>
</html>
