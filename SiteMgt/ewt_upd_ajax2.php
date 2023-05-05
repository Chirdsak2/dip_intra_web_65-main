<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
$sql_text = "";
			if($_GET["psid"] != "" AND $_GET["psid"] != "0"){
				$sql_text .= " AND s_id = '".$_GET["psid"]."' ";
			}
			if($_GET["psname"] != ""){
				$sql_text .= " AND s_name = '".$_GET["psname"]."' ";
			}
			if($_GET["accept"] == "Y"){
				$sql_p = $db->query("SELECT COUNT(p_id) FROM permission2 WHERE p_type = '".$_GET["mtype"]."' AND pu_id = '".$_GET["mid"]."' AND UID = '".$_GET["UID"]."' AND s_type = '".$_GET["ptype"]."' AND s_permission = '".$_GET["ppms"]."'  AND myFlag = '".$_GET["myFlag"]."' ".$sql_text);
				//echo "SELECT COUNT(p_id) FROM permission WHERE p_type = '".$_GET["mtype"]."' AND pu_id = '".$_GET["mid"]."' AND UID = '".$_GET["UID"]."' AND s_type = '".$_GET["ptype"]."' AND s_permission = '".$_GET["ppms"]."' ".$sql_text;
	 			$C = $db->db_fetch_row($sql_p);
	  			if($C[0] == 0){
					$db->query("INSERT INTO permission2 (p_type,pu_id,UID,s_type,s_id,s_name,s_permission,myFlag,timest) VALUES ('".$_GET["mtype"]."','".$_GET["mid"]."','".$_GET["UID"]."','".$_GET["ptype"]."','".$_GET["psid"]."','".$_GET["psname"]."','".$_GET["ppms"]."','".$_GET["myFlag"]."','".date("Y-m-d")."') ");
					}
			}else{
			$db->query("DELETE FROM permission2 WHERE p_type = '".$_GET["mtype"]."' AND pu_id = '".$_GET["mid"]."' AND UID = '".$_GET["UID"]."' AND s_type = '".$_GET["ptype"]."' AND s_permission = '".$_GET["ppms"]."'  AND myFlag = '".$_GET["myFlag"]."' ".$sql_text);
			//echo "DELETE FROM permission WHERE p_type = '".$_GET["mtype"]."' AND pu_id = '".$_GET["mid"]."' AND UID = '".$_GET["UID"]."' AND s_type = '".$_GET["ptype"]."' AND s_permission = '".$_GET["ppms"]."' ".$sql_text;
			}

		$db->db_close();
?>
