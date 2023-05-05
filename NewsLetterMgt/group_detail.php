<?php
include("authority.php");
?>
<?php 
$sel = "select * from n_member,n_group_member where n_member.m_id = n_group_member.m_id and n_group_member.g_id = '$gid'";
$r = $db->query($sel);
$rnum = mysql_num_rows($r);
?>
<html>
<head>
<title>Member for <?php echo $gname; ?> group</title>
<meta http-equiv="Content-Type" content="text/html; charset=">
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0">
<table width="100%" cellspacing="0" cellpadding="3" bordercolor="#003399" border="0" align="center">
  <tr>
    <td bgcolor="#CCCCCC"><font face="MS Sans Serif"><b><font color="#000000" size="1">Number 
      of <?php echo $gname; ?> Group <font color="#CC3300">( 
      <?php echo $rnum;?>
      )</font></font></b></font></td>
  </tr>
  <tr>
    <td height="38"> 
      <table width="100%" cellspacing="2" cellpadding="3">
        <?php
$i = 1;
while($R = mysql_fetch_array($r)){
?>
        <tr>
          <td bgcolor="#eeeeee" width="9%"> 
            <div align="center"><strong><font color="#000000" size="1" face="MS Sans Serif, Tahoma, sans-serif">
              <?php echo $i;?>
              </font> </strong></div>
          </td>
          <td bgcolor="#eeeeee" width="91%"><strong><font size="1" face="MS Sans Serif, Tahoma, sans-serif"> 
            <?php echo $R['m_email'];?>
          </font></strong></td>
        </tr>
        <?php 
$i++;
}?>
      </table>
    </td>
  </tr>
</table>
</body>
</html>
