<?php
header ("Content-Type:text/plain;charset=UTF-8");
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
$db->query("USE ".$EWT_DB_NAME);

if($_POST[Flag]=='Favorites_add'){
//set path for back
	if($_POST[module]=='article'){
	$Bpath = "../ContentMgt/".$_POST[url];
	}
//chk data name
$sqlchk = "select * from favoristes where favoristes_url = '".$_POST[url]."' and favoristes_user = '".$_SESSION["EWT_SMID"]."' and favoristes_module ='".$_POST[module]."'";
$query = $db->query($sqlchk);
if($db->db_num_rows($query)>0){
?>
<script language="javascript">  
		alert("ท่านได้เพิ่มหน้านี้ใน Favorites แล้ว!!!");
//		location.href="<?php //echo $Bpath;?>"; 
			window.close();
	</script>

<?php
exit;
}
$sql = "insert into favoristes (favoristes_name,favoristes_module ,favoristes_user,favoristes_url,favoristes_create,favoristes_type) 
			values (
			'".$_POST[favorites_name]."','".$_POST[module]."','".$_SESSION["EWT_SMID"]."','".$_POST[url]."',NOW()
			,'".$_POST[type]."')";
$db->query($sql);
?>
<script language="javascript">  
	alert("เพิ่มข้อมูลใน Favorites เรียบร้อยแล้ว!!!");
	//	location.href="<?php // echo $Bpath;?>"; 
	window.close();
	</script>
<?php
}
if($_POST[Flag]=='Favorites_edit'){
$sql = "update favoristes set  favoristes_name='".$_POST[favorites_name]."' ,favoristes_module='".$_POST[module]."',favoristes_url='".$_POST[url]."' where favoristes_id='".$_POST[favoristes_id]."'";
$db->query($sql);
?>
<script language="javascript">  
	alert("แก้ไขเรียบร้อยแล้ว");
			window.opener.location.reload();
			window.close();
	</script>
<?php
}
if($_GET[flag]=='del'){
$db->query("Delete from favoristes where favoristes_id='".$_GET[Fid]."'");
?>
<script language="javascript">  
		location.href="../ewt_main.php"; 
	</script>
<?php
}
?>
<?php $db->db_close(); ?>