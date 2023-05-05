<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
if(!$db->check_permission("cms","w","")){
				?>
				<script language="JavaScript">
				alert("You can not access this section!!");
				window.close();
				</script>
				<?php
}
if($_POST[flag] == 'add_page'){

$insert = "insert into tips_list (tips_group_id,tips_list_title,tips_list_detail) values ('".$_POST[group_id]."','".$_POST[title]."','".$_POST[detail]."')";
$db->query($insert);

$sql = "select tips_list_id as max_id from tips_list  where tips_list_title = '".$_POST[title]."' and tips_group_id = '".$_POST[group_id]."'order by tips_list_id DESC";
$query = $db->query($sql);
$R = $db->db_fetch_array($query);
$max_id = $R[max_id];

$insert = "insert into tips_main (tips_list_id,tips_main_type,tips_main_type_id) values ('".$max_id."','".$_POST[type]."','".$_POST[filename]."')";
$db->query($insert);
?>
<script language="javascript1.2">
alert("บันทึกเรียบร้อยแล้ว");
 window.location.href='content_tooltips_list.php?type=<?php echo $_POST[type];?>&filename=<?php echo $_POST[filename];?>';
</script>
<?php
}
if($_GET[flag] == 'add_page2'){

$insert = "insert into tips_main (tips_list_id,tips_main_type,tips_main_type_id) values ('".$_GET[tips_id]."','".$_GET[type]."','".$_GET[filename]."')";
$db->query($insert);
?>
<script language="javascript1.2">
alert("บันทึกเรียบร้อยแล้ว");
 window.location.href='content_tooltips_list.php?type=<?php echo $_GET[type];?>&filename=<?php echo $_GET[filename];?>';
</script>
<?php
}
if($_POST[flag] == 'add_group'){

$insert = "insert into tips_group (tips_group_name) values ('".$_POST[title]."')";
$db->query($insert);

?>
<script language="javascript1.2">
alert("บันทึกเรียบร้อยแล้ว");
<?php if($_POST[type_name] == 'add_group'){ ?>
 window.location.href='content_tooltips_grouplist.php';
<?php }else{ ?>
 window.location.href='content_tooltips_add.php?type=<?php echo $_POST[type];?>&filename=<?php echo $_POST[filename];?>&tips_id=<?php echo $_POST[tips_id];?>&flag=<?php echo $_POST[type_name];?>';
<?php } ?>
</script>
<?php
}
if($_POST[flag] == 'edit_group'){
$update = "update tips_group set tips_group_name = '".$_POST[title]."' where tips_group_id ='".$_POST[tips_id]."'";
$db->query($update);
?>
<script language="javascript1.2">
 alert("บันทึกเรียบร้อยแล้ว");
 window.location.href='content_tooltips_grouplist.php';

</script>
<?php
}
if($_GET[flag] == 'del'){
$sql = "select count(tips_main_id) as num from tips_main where tips_list_id = '".$_GET[tips_id]."'";
$query = $db->query($sql);
$R = $db->db_fetch_array($query);
if($R[num]<=1){
$delete = "delete from tips_list  where tips_list_id = '".$_GET[tips_id]."'";
$db->query($delete);
}
$delete = "delete from tips_main  where tips_list_id = '".$_GET[tips_id]."' and tips_main_type_id = '".$_GET[filename]."'";
$db->query($delete);
?>
<script language="javascript1.2">
alert("ลบเรียบร้อยแล้ว");
 window.location.href='content_tooltips_list.php?type=<?php echo $_GET[type];?>&filename=<?php echo $_GET[filename];?>';
</script>
<?php
}
if($_GET[flag] == 'del_group'){

$delete = "delete from tips_group  where tips_group_id = '".$_GET[tips_id]."' ";
$db->query($delete);
?>
<script language="javascript1.2">
alert("ลบเรียบร้อยแล้ว");
window.location.href='content_tooltips_grouplist.php';
</script>
<?php
}
if($_POST[flag] == 'edit_page'){

$update = "update tips_list set tips_group_id = '".$_POST[group_id]."',tips_list_title='".$_POST[title]."',tips_list_detail='".$_POST[detail]."' where tips_list_id ='".$_POST[tips_id]."'";
$db->query($update);
?>
<script language="javascript1.2">
alert("แก้ไขเรียบร้อยแล้ว");
 window.location.href='content_tooltips_list.php?type=<?php echo $_POST[type];?>&filename=<?php echo $_POST[filename];?>';
</script>
<?php
}
?>
<?php $db->db_close(); ?>
