<?php
include("administrator.php");
include("inc.php");
include("lib/include.php");
include("../language.php");
$fa_id = $_GET["fa_id"];
$sel = "SELECT * FROM faq_answer WHERE  fa_id = '$fa_id' ORDER BY  faq_date DESC";
$Show = $sel;
$Execsql = $db->query($Show); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: none}
a:hover { color: #0099FF; text-decoration: none}
-->
</style>
</head>

<body leftmargin="0" topmargin="0" class="normal_font">
<div align="center">
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr >
    <td colspan="2" valign="top">
                <table width="100%" border="0" cellpadding="5" cellspacing="1" class="ewttableuse">
  <tr class="ewttablehead">
    <td>วันที่</td>
    <td>คำถาม</td>
    <td>รายละเอียด</td>
    <td>ผู้ถาม</td>
    <td>อีเมล์</td>
  </tr>
  <?php
  while($R = $db->db_fetch_array($Execsql)){
  ?>
  <tr bgcolor="#FFFFFF">
    <td ><?php echo $R[faq_date];?></td>
    <td ><?php echo $R[faq_user_ans];?></td>
    <td ><?php echo $R[faq_user_detail];?></td>
    <td ><?php echo $R[faq_user_name];?></td>
    <td ><?php echo $R[faq_user_email];?></td>
  </tr>
  <?php } ?>
</table>
</td>
  </tr>
  </table>
</div>
</body>
</html>
<?php @$db->db_close(); ?>