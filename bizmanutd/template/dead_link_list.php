<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

$sql = $db->query("SELECT COUNT(lid),filename FROM check_link GROUP BY filename");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body leftmargin="0" topmargin="0">
<font size="2" face="Tahoma"><strong>Dead link report <br>
</strong></font> 
<?php
while($R=$db->db_fetch_row($sql)){
$sql1 = $db->query("SELECT COUNT(lid) FROM check_link WHERE filename = '".$R[1]."' AND link_detail = 'NO' ");
$N = $db->db_fetch_row($sql1);
?>
<font color="#FF3300" size="2" face="Tahoma"><strong># Page</strong></font><font size="2" face="Tahoma"><strong> 
: <?php echo $R[1]; ?> (<font color="#0000FF">use : <?php echo $R[0]; ?> link(s)</font> 
<font color="#FF0000">dead : <?php echo $N[0]; ?> link(s)</font>)<br>
</strong></font> 
<?php
if($N[0] > 0){
$sql2 = $db->query("SELECT link_name,link_url   FROM check_link WHERE filename = '".$R[1]."' AND link_detail = 'NO' ");
?>
<table width="90%" border="0" cellpadding="2" cellspacing="1" bgcolor="#000000">
  <tr align="center" bgcolor="#CCCCCC"> 
    <td width="68%"><strong><font size="2" face="Tahoma">Link name</font></strong></td>
    <td width="32%"><strong><font size="2" face="Tahoma">Url</font></strong></td>
  </tr>
  <?php while($L=$db->db_fetch_row($sql2)){ ?>
  <tr bgcolor="#FFFFFF"> 
    <td><?php echo $L[0]; ?></td>
    <td><?php echo $L[1]; ?></td>
  </tr>
  <?php } ?>
</table>
<?php
}
}
?>
</body>
</html>
<?php
$db->db_close();
?>
