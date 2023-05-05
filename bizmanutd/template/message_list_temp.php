<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
function ShowSize($data){
	if($data > 1024000){ echo number_format($data/1024000,2)." MB."; }
	elseif($data > 1024){ echo number_format($data/1024,2)." KB."; }
	elseif($data > 1){ echo number_format($data)." bytes."; }
	elseif($data >= 0){ echo number_format($data)." byte."; }
}
$sql = $db->query("SELECT * FROM n_temp WHERE temp_code = '$code' ORDER BY id");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/style.css" rel="stylesheet" type="text/css">
<body>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#000000">
  <tr align="center" bgcolor="#CCCCCC"> 
    <td width="65%">ชื่อไฟล์</td>
    <td width="25%">ขนาด</td>
    <td width="10%">ลบ</td>
  </tr>
  <?php if($db->db_num_rows($sql)){ 
  while($R = $db->db_fetch_array($sql)){
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td>
	<a href="temp/<?php echo $R[filenametemp]; ?>" target="_blank"><img src="mainpic/b_paperclip.gif" width="16" height="16" border="0" align="absmiddle" alt="ไฟล์"> 
      <?php echo $R[filenamegiven]; ?></a>
	  </td>
    <td align="right">
      <?php ShowSize($R[file_size]); ?>
    </td>
    <td align="center"><a href="message_function_temp.php?code=<?php echo $code; ?>&Flag=del&temp=<?php echo $R[id]; ?>" onClick="return confirm('คุณต้องการลบไฟล์นี้หรือไม่?');"><img src="mainpic/delete1.gif" width="24" height="24" border="0" alt="ลบไฟล์"></a></td>
  </tr>
  <?php }}else{ ?>
  <tr align="center" bgcolor="#FFFFFF"> 
    <td colspan="3"><font color="#FF0000">ไม่มีเอกสารแนบ</font></td>
  </tr>
  <?php } ?>
</table>
</body>
</html>
<?php  $db->db_close(); ?>
