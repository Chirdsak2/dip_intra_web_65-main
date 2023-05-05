<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");


$all = count($_POST["auto"]);
if($all > 0){
	$sql = $db->query("select * from article_auto where c_id = '".$_POST["c_id"]."'");
			echo $num = mysql_num_rows($sql);
			if($num > 0){
				$sql_delete = "DELETE FROM article_auto where c_id = '".$_POST["c_id"]."' ";
				$db->query($sql_delete);
			}
	for($y=0;$y<$all;$y++){
		echo $chk = $_POST["auto"][$y];
		if($chk != ""){
			$sql_insert = "insert into article_auto (c_id,UID) values('".$_POST["c_id"]."','".$chk."')";
			$db->query($sql_insert);
		}
	}
	?>
<script language="javascript">
alert("Share article auto complete");
//self.location.href = '<?php//php echo $_POST["backto"]; ?>';
</script>
<?php
}else{
$sql_delete = "DELETE FROM article_auto where c_id = '".$_POST["c_id"]."' ";
$db->query($sql_delete);
?>
<script language="javascript">
//alert("กรุณาเลือกหน่วยงาน!!!!!!");
self.location.href = 'article_unit_share_auto.php?c_id=<?php echo $c_id?>';
</script>
<?php
}
$db->db_close(); 
?>
