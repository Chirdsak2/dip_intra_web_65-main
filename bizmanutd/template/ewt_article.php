<?php
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
if($_SESSION["EWT_MID"] != ""){
if($_POST["Flag"] == "Edit" AND $_POST["N"] != ""){
$topic = stripslashes(htmlspecialchars($_POST["topic"],ENT_QUOTES));
$description = stripslashes(htmlspecialchars($_POST["description"],ENT_QUOTES));
$date = explode("/",$_POST["date_n"]);
$date_n = $date[2]."-".$date[1]."-".$date[0];
$aid = base64_decode($_POST["N"]);
$update = "UPDATE article_list SET n_date = '$date_n', n_timestamp = '".date("Y-m-d H:i:s")."',n_topic = '$topic',n_des = '$description' WHERE n_id = '".$aid."' AND n_owner = '".$_SESSION["EWT_MID"]."' ";
$db->query($update);
?>
<script language="JavaScript">
window.opener.location.reload();
window.close();
</script>
<?php
exit;
}
if($_GET["N"] != ""){
$aid = base64_decode($_GET["N"]);
$sql = $db->query("SELECT * FROM article_list WHERE n_id = '".$aid."' AND n_owner = '".$_SESSION["EWT_MID"]."' ");
if($db->db_num_rows($sql) > 0){
$R = $db->db_fetch_array($sql);
$date = explode("-",$R["n_date"]);
 ?>
<html>
<head>
<title>แก้ไขข่าว/บทความ</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link  href="css/interface.css" rel="stylesheet" type="text/css">
<link id="stext" href="css/normal.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0"><br>

<table width="90%" border="0" align="center" cellpadding="10" cellspacing="1" bgcolor="#999999">
  <tr>
    <td bgcolor="#E7E7E7" class="text_head">แก้ไขข่าว/บทความ</td>
  </tr>
</table>
<br>
<table width="90%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#999999">
  <form name="form1" method="post" action=""><tr bgcolor="#FFFFFF">
    <td width="22%">หัวข้อ</td>
    <td width="78%"><input name="topic" type="text" id="topic" value="<?php echo $R["n_topic"]; ?>" size="40"></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>รายละเอียด</td>
    <td><textarea name="description" cols="40" rows="5" wrap="VIRTUAL" id="description"><?php echo $R["n_des"]; ?></textarea></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>วันที่</td>
    <td>
        <input name="date_n" type="text" id="date_n" value="<?php echo $date[2]."/".$date[1]."/".$date[0]; ?>" size="10" >
      </td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="  แก้ไข  ">
        <input type="button" name="Submit2" value="ปิดหน้านี้" onClick="window.close();">
        <input name="N" type="hidden" id="N" value="<?php echo base64_encode($R[n_id]); ?>">
        <input name="Flag" type="hidden" id="Flag" value="Edit"></td>
  </tr></form>
</table>
</body>
</html>
<?php
}
}
}
$db->db_close();
?>