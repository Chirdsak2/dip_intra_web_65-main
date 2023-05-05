<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
 
$db->query("USE ".$EWT_DB_USER);
$sql = "select * from contact_list where contact_list_id ='$id' ";
$query = $db->query($sql);
if(mysql_num_rows($query)>0){
$R = $db->db_fetch_array($query);
//group
$sqlgroup = "select * from contact_group where contact_group_id = '".$R[contact_group_id]."'";
$querygroup = $db->query($sqlgroup);
$Rgroup = $db->db_fetch_array($querygroup);
$group_name = $Rgroup[contact_group_name];
if(empty($R[member_id])){
$name = $R[contact_list_name].'   '.$R[contact_list_sername];
$email = $R[contact_list_email];
$pic ="../../images/a_no_pic.gif";

}else{
	$sql_user = "select * from gen_user where gen_user_id = '".$R[member_id]."'";
   $query_user = $db->query($sql_user);
   $R_user = $db->db_fetch_array($query_user);
   $name = $R_user[name_thai].' '.$R_user[surname_thai];
   $email = $R_user[email_kh];
   
   if(empty($email)){
   $email = $R_user[email_person];
   }
   		$pic = "../pic_upload/".$R_user[path_image];
	   if (file_exists($pic) && !empty($R_user[path_image])) {
	   	$pic = $pic;
	   }else{
	   	$pic ="../../images/a_no_pic.gif";
	   }
   
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/mysite.css" rel="stylesheet" type="text/css"></head>
<title>Contact</title>
</head>

<body leftmargin="0" topmargin="0">
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td valign="top" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
	 <tr>
    <td colspan="2" align="right" valign="bottom"><a href="contact_function.php?flag=del_member&id=<?php echo $R[contact_list_id];?>&groupid=<?php echo $R[contact_group_id];?>"><img src="mainpic/b_delete.gif" alt="ลบ" width="14" height="14" border="0" onClick="return confirm('ต้องการลบข้อมูลหรือไม่');">&nbsp;ลบ</a>&nbsp;&nbsp;&nbsp;
	<?php
	if(empty($R[member_id])){
	?>
	<a href="contact_edit_member.php?id=<?php echo $R[contact_list_id];?>"><img src="mainpic/cal_edit.gif" alt="แก้ไข" width="16" height="16" border="0" align="absmiddle">แก้ไข </a><?php } ?>
	<hr></td>
    </tr>
  <tr>
    <td height="22" colspan="2" class="myhead">คุณ <?php echo $name;?></td>
    </tr>
  <tr>
    <td width="71%" height="22">&nbsp;</td>
    <td width="29%" rowspan="4">
		<img src="img.php?p=<?php echo base64_encode($pic); ?>" width="100" height="100" >
		</td>
  </tr>
  <tr>
    <td height="22">กลุ่ม : <?php echo $group_name;?> </td>
    </tr>
  <tr>
    <td height="22">E-mail : <?php echo $email;?></td>
    </tr>
  <tr>
    <td height="22">&nbsp;</td>
    </tr>
 
</table>
</td>
  </tr>
</table>
</body>
</html>
<?php } ?>
