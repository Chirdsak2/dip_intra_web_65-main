<?php
include("administrator.php");
include("lib/include.php");
include("inc.php");
 $query =$db->query( "SELECT * FROM faq WHERE fa_id = '$fa_id' ");
$R=$db->db_fetch_array($query );
?>
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
    <tr valign="top">
      <td width="100%"><br>        
      <br>
      <table width="72%" border="0" align="center" cellpadding="0" cellspacing="0">
        <tr>
          <th scope="col"><table width="90%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#0000FF" class="normal_font">
            <tr bgcolor="#3399FF" class="head_font">
              <td width="19%">คำถาม</td>
              <td width="81%"> <?php echo ($R[fa_name]); ?> </td>
            </tr>
            <tr bgcolor="#F7F7F7">
              <td>รายละเอียด</td>
              <td width="81%" valign="top"> <?php echo ($R[fa_detail]); ?> </td>
            </tr>
            <tr bgcolor="#FFFFFF">
              <td>คำตอบ</td>
              <td> <?php echo ($R[fa_ans]); ?> </td>
            </tr>
          </table></th>
        </tr>
        <tr  id="tr_print">
          <td align="center"><form name="form1" method="post" action="faq_send.php">
            <input type="button" name="Submit3" value="พิมพ์"  onClick="tr_print.style.display='none';window.print();tr_print.style.display='';">
            <input type="button" name="Submit2" value="ปิดหน้านี้"  onClick="window.close();"> 
          </form></td>
        </tr>
      </table></td>
    </tr>
  </table>
</div>
</body>
</html>
<?php @$db->db_close(); ?>