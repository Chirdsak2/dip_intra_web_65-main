<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
$sql = $db->query("SELECT * FROM n_temp_user WHERE tempcode = '$code' ORDER BY tempid ASC");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/style.css" rel="stylesheet" type="text/css">
<body>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#000000">
  <tr align="center" bgcolor="#CCCCCC"> 
    <td width="65%">รายชื่อ</td>
    <td width="10%">ลบ</td>
  </tr>
  <?php if($mto=$db->db_num_rows($sql)){ 
  while($R = $db->db_fetch_array($sql)){
		$recname=$db->db_fetch_array($db->query("SELECT title.title_thai AS title_name,name_thai,surname_thai FROM  gen_user INNER JOIN title ON gen_user.title_thai=title.title_id WHERE gen_user_id = '".$R['temp_gen_user_id']."'"));
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td>&nbsp;&nbsp;<?php echo $recname['title_name'].$recname['name_thai'].' '.$recname['surname_thai'];  ?></td>
    <td align="center"><a href="message_function_name.php?code=<?php echo $code; ?>&Flag=del&temp=<?php echo $R[tempid]; ?>" onClick="return confirm('คุณต้องการลบไฟล์นี้หรือไม่?');"><img src="mainpic/delete1.gif" width="16" height="16" border="0" alt="ลบไฟล์"></a></td>
  </tr>
  <?php }}else{ ?>
  <tr align="center" bgcolor="#FFFFFF"> 
    <td colspan="3"><font color="#FF0000">ไม่มีรายชื่อ</font></td>
  </tr>
  <?php } ?>
</table>
</body>
</html>
<script language="javascript">
		self.parent.document.getElementById('mto').value=<?php echo $mto?>;
</script>
<?php  $db->db_close(); ?>
