<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
 
$db->query("USE ".$EWT_DB_USER);
$user_id =$_SESSION["EWT_MID"];
if($_POST["flag"]=='add'){
$insert = "insert into contact_group (contact_group_name,user_id) values ('".$_POST["group_name"]."','".$user_id."')";
$db->query($insert);
?>
<script language="javascript1.2">
alert("บันทึกเรียบร้อย");
//self.location.href = "contact_add_group.php";
history.go(-1);
</script>
<?php
}
if($_POST["flag"]=='add_member'){
$insert = "insert into contact_list (user_id,contact_group_id,contact_list_name,contact_list_sername,contact_list_email) values ('".$user_id."','".$_POST["group_name"]."','".$_POST["user_name"]."','".$_POST["user_sername"]."','".$_POST["email"]."')";
$db->query($insert);
?>
<script language="javascript1.2">
alert("บันทึกเรียบร้อย");
//self.location.href = "contact_main.php";
history.go(-2);
</script>
<?php
}
if($_GET["flag"]=='add_member_unit'){
$insert = "insert into contact_list (user_id,contact_group_id,member_id) values ('".$user_id."','".$_GET["groupid"]."','".$_GET["gid"]."')";
$db->query($insert);
?>
<script language="javascript1.2">
alert("บันทึกเรียบร้อย");
window.opener.location.href = "contact_main.php";
window.close();
</script>
<?php
}
if($_GET["flag"]=='del'){
$delete = "delete from contact_group where contact_group_id='".$_GET["groupid"]."'";
$db->query($delete);
$update = "update contact_list set contact_group_id='' where contact_group_id='".$_GET["groupid"]."'";
$db->query($update);
?>
<script language="javascript1.2">
alert("ลบเรียบร้อย");
//self.location.href = "contact_add_group.php";
history.go(-1);
</script>
<?php
}
if($_GET["flag"]=='del_member'){
$delete = "delete from contact_list where contact_list_id='".$_GET["id"]."'";
$db->query($delete);

?>
<script language="javascript1.2">
alert("ลบเรียบร้อย");
self.parent.contact_name.location.href="contact_list.php?groupid=<?php echo $_GET["groupid"];?>";
</script>
<?php
}
if($_POST["flag"]=='edit_member'){
$update = "update contact_list set user_id='".$user_id."',
														contact_group_id ='".$_POST["group_name"]."',
														contact_list_name = '".$_POST["user_name"]."',
														contact_list_sername ='".$_POST["user_sername"]."',
														contact_list_email ='".$_POST["email"]."'
														 where contact_list_id='".$_POST["id"]."'";
$db->query($update);

?>
<script language="javascript1.2">
alert("แก้ไขเรียบร้อย");
self.parent.contact_name.location.href="contact_list.php?groupid=<?php echo $_POST["group_name"];?>";

</script>
<?php
}
if($_POST["flag"]=='edit'){
$update = "update contact_group set contact_group_name='".$_POST["group_name"]."'
														 where contact_group_id='".$_POST["groupid"]."'";
$db->query($update);

?>
<script language="javascript1.2">
alert("แก้ไขเรียบร้อย");
//self.location.href = "contact_add_group.php";
history.go(-2);
</script>
<?php
}
?>
