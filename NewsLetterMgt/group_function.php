<?php
include("authority.php");
?>
<?php 
$g_name = addslashes($_POST["g_name"]);
$g_des = addslashes($_POST["g_des"]);
if($_POST["flag"] == 'Add'){
	//$ins = "insert into n_group (g_name,g1,g2) values ('$g_name','$g_des','$gtype')";

	//$r = $db->query($ins);
	for($i=0;$i<$_POST["num"];$i++){
	$article_id = "article_".$i;
	$article_id = $_POST[$article_id];
		if(!empty($article_id)){
			$ins = "insert into n_group (g_name,g2) values ('$article_id','2')";
			$r = $db->query($ins);
		}
	}
     $abc = mysql_query("  select  * from admin_section_detail");
while($row = mysql_fetch_array($abc)){

$lastrow = $row["sdID"];

	}

$last = explode("sd",$lastrow);
$lastnum =  $last[1];
$lastnum +=1;
echo $lastnum;
mysql_query( " insert into admin_section_detail (sdID,sdName,smID,sdName_en) values ('$lastnum','$g_name','sm19','$g_name')" );
$db->write_log("create","enews","สร้างกลุ่มข่าว E-news letter  : ".$g_name);
		?>
<script language="javascript">
window.opener.location.href="group_mod.php?msg=Y";
	window.close();
</script>
		<?php
}
if($_POST["flag"] == 'Edit'){

	$upd = "update n_group set g1 = '".$_POST["g_des"]."',g2 = '".$_POST["gtype"]."' where g_id = '".$_POST["gid"]."'";
	$r = $db->query($upd);
	mysql_query(" update admin_section_detail set sdName = '".$_POST["g_name"]."', sdName_en = '".$_POST["g_name"]."' where sdName ='".$_POST["gn"]."' ");
	$db->write_log("update","enews","แก้ไขกลุ่มข่าว E-news letter  : ".$_POST["g_name"]);
	?>
<script language="javascript">
window.opener.location.href="group_mod.php?msg=Y";
window.close();
</script>
		<?php
}
if($_POST["flag"] == 'Delete'){
for($i=0;$i<$_POST["all"];$i++){
	$gid = 'gid'.$i;
	$gid = $_POST[$gid];
if($gid <> ''){
	$del = "delete from n_group where g_id = '$gid'";
$adel = mysql_query( " select * from n_group where g_id = '$gid' ");
while($row2 = mysql_fetch_array($adel )){
$delrow= $row2["g_name"];
	}
$gn = $delrow;


mysql_query( " delete from admin_section_detail where sdName = '$gn' ");
	$r = $db->query($del);
	$del1= "delete from n_group_member where g_id = '$gid'";
	$r1= $db->query($del1);
$db->write_log("delete","enews","ลบกลุ่มข่าว E-news letter  : ".$delrow);
}
}
	?>
<script language="javascript">
window.location.href="group_mod.php?msg=Y";
</script>
		<?php
}
?>
