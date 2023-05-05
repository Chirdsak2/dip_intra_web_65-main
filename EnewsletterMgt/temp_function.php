<?php
//include("authority.php");
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("lang_newsletter.php");
?>
<?php 
$Path_true = "../ewt/".$_SESSION["EWT_SUSER"]."/file_attach";

if (!file_exists( $Path_true)) {
				mkdir ($Path_true, 0777);
}
			
			
if($Flag=="Add"){
		$fw1 = @fopen($Path_true."/".$t_name.".html", "w");
		if(!$fw1){ die("Cannot write ".$t_name.".html"); }
				$FlagW1 = fwrite($fw1,stripslashes($Text2));
				@fclose($fw1);
				$ins = $db->query("INSERT INTO `n_temp` ( `t_id` , `t_name` , `t_date` ) VALUES ('', '$t_name', NOW( ))");
				$db->write_log("create","enews","สร้างจดหมายข่าว E-news letter  : ".$t_name);
				?>
				<script language="javascript">
				window.opener.location.href="temp_mod.php?msg=Y";
				window.close();
				</script>
				<?php
		}else if($Flag=="Edit"){
					$fw1 = @fopen($Path_true."/".$t_name.".html", "w");
					if(!$fw1){ die("Cannot write ".$t_name.".html"); }
					$FlagW1 = fwrite($fw1,stripslashes($Text2));
					@fclose($fw1);
					$ins = $db->query("UPDATE `n_temp` SET `t_date` = NOW( ) WHERE `t_id` = '$tid'");
					$db->write_log("update","enews","แก้ไขจดหมายข่าว E-news letter  : ".$t_name);
					if($module=="1"){ ?>
					<script language="javascript">
					window.opener.prev.location.reload();
					window.close();
					</script>
		<?php }else{ ?>
				<script language="javascript">
				window.opener.location.href="temp_mod.php?msg=Y";
				window.close();
				</script>
		<?php
		  }
}elseif($Flag=="Delete"){
		for($i=0;$i<$all;$i++){
			$gid = 'gid'.$i;
			$gid = $$gid;
			$tname = 'tname'.$i;
			$tname = $$tname;
			
			if($gid <> ''){
				$del = "delete from n_temp where t_id = '$gid'";
				$r = $db->query($del);
				@unlink($Path_true."/".$tname.".html");
				$db->write_log("delete","enews","ลบจดหมายข่าว E-news letter  : ".$tname);
			}
}
?>
<script language="javascript">
window.location.href="temp_mod.php?msg=Y";
</script>
<?php } 
$db->db_close(); 
?>