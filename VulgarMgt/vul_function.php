<?php
include("administrator.php");
include("inc.php");
include("lib/include.php");
include("../language/rude_language.php");

$ip_data = getenv("REMOTE_ADDR");
$date_data = date('Y-m-d');

$t_topic=$_POST[t_topic];
$r=$_POST[r];
$vulgar_id=$_POST[vulgar_id];
$flag=$_POST[flag];

if($flag==''){
  $vulgar_id=$_GET[vulgar_id];
  $flag=$_GET[flag];
}

if($flag == 'add'){
$sql = "select * from vulgar_table where vulgar_text = '$t_topic'";
$query = $db->query($sql);
if(mysql_num_rows($query)>0){
?>
		<script>
		 				alert('<?php echo $text_genrude_noadd;?>'); 
		 				self.location.href='vul_cate.php';
		 </script>
<?php
}else{
		 $add_sql = "INSERT INTO vulgar_table(vulgar_id,vulgar_text,ip_add) VALUES ('','$t_topic','$r')";
		 mysql_query($add_sql);
		 $db->write_log("create","vulgar","เพิ่มข้อมูลคำไม่สุภาพหรือโฆษณา  ".$t_topic);
}
}
if($flag == 'edit'){
$sql = "select * from vulgar_table where vulgar_text = '$t_topic' and (vulgar_id <> '$vulgar_id')";
$query = $db->query($sql);
if(mysql_num_rows($query)>0){
?>
		<script>
		 				alert('<?php echo $text_genrude_noadd;?>'); 
		 				self.location.href='vul_cate.php';
		 </script>
<?php
}else{
		$update_sql = " update vulgar_table set vulgar_text='$t_topic',ip_add='$r' where (vulgar_id='$vulgar_id') ";
		mysql_query($update_sql);
		 $db->write_log("update","vulgar","แก้ไขข้อมูลคำไม่สุภาพหรือโฆษณา  ".$t_topic);
}
}
if($flag == 'del'){
		$rec = $db->db_fetch_array($db->query("select * from vulgar_table where (vulgar_id='$vulgar_id')"));
		$db->write_log("delete","vulgar","ลบข้อมูลคำไม่สุภาพหรือโฆษณา ".$rec[vulgar_text]);
		$del_sql = " delete from vulgar_table where (vulgar_id='$vulgar_id') ";
		mysql_query($del_sql);
}
		?>
		<script>
		 				alert('<?php echo $text_genrude_complete;?>'); 
		 				self.location.href='vul_cate.php';
		 </script>
<?php
$db->db_close(); 

?>
