<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

if($_POST["Flag"] == "Add"){

for($i=0;$i<$_POST["allrow"];$i++){

		$chr = $_POST["chr".$i];
		$chw = $_POST["chw".$i];
		$p_type = $_POST["p_type".$i];
		$pu_id = $_POST["pu_id".$i];

		if($chr == "Y"){
				if($_POST["s_type"] == "Fo"){
					$sqlchk = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = '".$p_type."' AND pu_id = '".$pu_id."' AND s_type = 'Fo'  AND s_id = '".$_POST["s_id"]."'  AND s_permission = 'r' ");
				}
				if($_POST["s_type"] == "Fi"){
					$sqlchk = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = '".$p_type."' AND pu_id = '".$pu_id."' AND s_type = 'Fi'  AND s_name = '".$_POST["s_name"]."'  AND s_permission = 'r' ");
				}
 					$C = $db->db_fetch_row($sqlchk);
		 			if($C[0] == 0){
						$db->query("INSERT INTO permission (p_type,pu_id,s_type,s_id,s_name,s_permission) VALUES ('".$p_type."','".$pu_id."','".$_POST["s_type"]."','".$_POST["s_id"]."','".$_POST["s_name"]."','r') ");
					}
		
		}else{
			
				if($_POST["s_type"] == "Fo"){
					$sqlchk = $db->query("DELETE FROM permission WHERE p_type = '".$p_type."' AND pu_id = '".$pu_id."' AND s_type = 'Fo'  AND s_id = '".$_POST["s_id"]."'  AND s_permission = 'r' ");
				}
				if($_POST["s_type"] == "Fi"){
					$sqlchk = $db->query("DELETE FROM permission WHERE p_type = '".$p_type."' AND pu_id = '".$pu_id."' AND s_type = 'Fi'  AND s_name = '".$_POST["s_name"]."'  AND s_permission = 'r' ");
				}

		}
		
			if($chw == "Y"){
				if($_POST["s_type"] == "Fo"){
					$sqlchk = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = '".$p_type."' AND pu_id = '".$pu_id."' AND s_type = 'Fo'  AND s_id = '".$_POST["s_id"]."'  AND s_permission = 'w' ");
				}
				if($_POST["s_type"] == "Fi"){
					$sqlchk = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = '".$p_type."' AND pu_id = '".$pu_id."' AND s_type = 'Fi'  AND s_name = '".$_POST["s_name"]."'  AND s_permission = 'w' ");
				}
 					$C = $db->db_fetch_row($sqlchk);
		 			if($C[0] == 0){
						$db->query("INSERT INTO permission (p_type,pu_id,s_type,s_id,s_name,s_permission) VALUES ('".$p_type."','".$pu_id."','".$_POST["s_type"]."','".$_POST["s_id"]."','".$_POST["s_name"]."','w') ");
					}
		
		}else{
			
				if($_POST["s_type"] == "Fo"){
					$sqlchk = $db->query("DELETE FROM permission WHERE p_type = '".$p_type."' AND pu_id = '".$pu_id."' AND s_type = 'Fo'  AND s_id = '".$_POST["s_id"]."'  AND s_permission = 'w' ");
				}
				if($_POST["s_type"] == "Fi"){
					$sqlchk = $db->query("DELETE FROM permission WHERE p_type = '".$p_type."' AND pu_id = '".$pu_id."' AND s_type = 'Fi'  AND s_name = '".$_POST["s_name"]."'  AND s_permission = 'w' ");
				}

		}
		
}
	if($_POST["plan"] == "go"){
		?>
		<script language="JavaScript">
			window.location.href = "setting_member2.php?ug=<?php echo $_POST["ug"]; ?>&s_type=<?php echo $_POST["s_type"]; ?>&s_id=<?php echo $_POST["s_id"]; ?>&s_name=<?php echo $_POST["s_name"];?>";
		</script>
		<?php
	}else{
		?>
		<script language="JavaScript">
			top.close();
		</script>
	<?php
	}
}

$db->db_close(); ?>
