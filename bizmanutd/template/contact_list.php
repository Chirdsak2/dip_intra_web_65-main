<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
$user_id =$_SESSION["EWT_MID"];
$db->query("USE ".$EWT_DB_USER);
if(!empty($_GET["groupid"])){
$wh = "and contact_group_id = '".$_GET["groupid"]."'";
}else{
$wh = "and contact_group_id = '0'";
}
$sql = "select * from contact_list where user_id ='".$user_id."' $wh ";
$query = $db->query($sql);
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/mysite.css" rel="stylesheet" type="text/css"></head>
<title>Contact</title>
</head>
<script language="javascript1.2">
function linkpage(t){
self.parent.contact_detail.location.href="contact_detail.php?id=" + t;
}
</script>
<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" >
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
 <?php
while($R = $db->db_fetch_array($query)){
if(empty($R[member_id])){
?>
 <tr >
    <td><a href="contact_detail.php?id=<?php echo $R[contact_list_id];?>" target="contact_detail"><?php echo $R[contact_list_name].' '.$R[contact_list_sername];?></a></td>
  </tr>
   <?php
   }else{
   $sql_user = "select * from gen_user where gen_user_id = '".$R[member_id]."'";
   $query_user = $db->query($sql_user);
   $R_user = $db->db_fetch_array($query_user);
   ?>
    <tr >
    <td><a href="contact_detail.php?id=<?php echo $R[contact_list_id];?>" target="contact_detail"><?php echo $R_user[name_thai].' '.$R_user[surname_thai];?></a></td>
  </tr>

   <?php }
    } ?>
</table>
</td>
  </tr>

</table>
</body>
</html>
