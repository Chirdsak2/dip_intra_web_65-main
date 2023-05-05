<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);

if($_POST["Flag"] == "Upd" AND $_POST["myFlag"] != ""){
		function random_to($len){
				srand((double)microtime()*10000000);
				$chars = "ABCDEFGHJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz123456789";
				$ret_str = "";
				$num = strlen($chars);
				for($i=0;$i<$len;$i++){
					$ret_str .= $chars[rand()%$num];
				}
				return $ret_str;
		}
	
	function updatep($mid,$ptype,$psid,$psname,$ppms,$status){
	global $db;
				$sql_text = "";
				if($psid != "" AND $psid != "0"){
					$sql_text .= " AND s_id = '".$psid."' ";
				}
				if($psname != ""){
					$sql_text .= " AND s_name = '".$psname."' ";
				}
				if($status != "D"){
					$sql_p = $db->query("SELECT COUNT(p_id) FROM permission WHERE p_type = 'U' AND pu_id = '".$mid."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = '".$ptype."' AND s_permission = '".$ppms."'   ".$sql_text);
					$C = $db->db_fetch_row($sql_p);
					if($C[0] == 0){
						$db->query("INSERT INTO permission (p_type,pu_id,UID,s_type,s_id,s_name,s_permission ) VALUES ('U','".$mid."','".$_SESSION["EWT_SUID"]."','".$ptype."','".$psid."','".$psname."','".$ppms."' ) ");
						}
				}else{
				$db->query("DELETE FROM permission WHERE p_type = 'U' AND pu_id = '".$mid."' AND UID = '".$_SESSION["EWT_SUID"]."' AND s_type = '".$ptype."' AND s_permission = '".$ppms."'  ".$sql_text);
				}
	}

		$UID = $_SESSION["EWT_SUID"];
		$myFlag = $_POST["myFlag"];

 		for($i=0;$i<$_POST["alli"];$i++){
			if($_POST["chk".$i] == "Y"){
					$sql_lead = $db->query("SELECT gen_user.gen_user_id,gen_user.name_thai,gen_user.surname_thai FROM gen_user INNER JOIN leader_list ON gen_user.gen_user_id = leader_list.leader_id WHERE leader_list.under_id = '".$_POST["id".$i]."' ");
					if($db->db_num_rows($sql_lead)){
					$L = $db->db_fetch_row($sql_lead);
								$myFlag1 = random_to(20);
									if($_POST["setting"]=="only"){
										$sql_pp = "SELECT * FROM permission0 WHERE myFlag = '$myFlag' AND p_status = 'A' ";
									}else{
										$sql_pp = "SELECT * FROM permission WHERE p_type = 'A' AND pu_id = '".$_POST["ug"]."' AND UID = '".$_SESSION["EWT_SUID"]."'  ";
									}
									$sql_p1 = $db->query($sql_pp);
									if($db->db_num_rows($sql_p1)){
									$db->query("INSERT INTO permission_approve (UID,myFlag,f_from,f_date,f_time,t_set,t_to,t_date,t_time,t_status) VALUES ('$UID','$myFlag1','".$_SESSION["EWT_SMID"]."','".date("Y-m-d")."','".date("H:i:s")."','".$_POST["id".$i]."','$L[0]','','','W')");
										while($PP = $db->db_fetch_array($sql_p1)){
										$db->query("INSERT INTO permission2 (p_type,pu_id,UID,s_type,s_id,s_name,s_permission,myFlag,timest) VALUES ('U','".$_POST["id".$i]."','".$UID."','".$PP["s_type"]."','".$PP["s_id"]."','".$PP["s_name"]."','".$PP["s_permission"]."','".$myFlag1."','".date("Y-m-d")."') ");
										}
									}
					}else{
									if($_POST["setting"]=="only"){
										$sql_pp2 = "SELECT * FROM permission0 WHERE myFlag = '$myFlag'  ";
									}else{
										$sql_pp2 = "SELECT * FROM permission WHERE p_type = 'A' AND pu_id = '".$_POST["ug"]."' AND UID = '".$_SESSION["EWT_SUID"]."'  ";
									}
									$sql_p2 = $db->query($sql_pp2);
									while($PP2 = $db->db_fetch_array($sql_p2)){
										updatep($_POST["id".$i],$PP2["s_type"],$PP2["s_id"],$PP2["s_name"],$PP2["s_permission"],$PP2["p_status"]);
									}
					}
			}
		}
		$db->query("DELETE FROM permission0 WHERE myFlag = '$myFlag'");
		?>
		<script language="JavaScript">
		self.location.href = "ewt_permission_g.php";
		</script>
		<?php
		exit;
}
	function level_name($L,$id){
	global $db;
		if($L == "D"){
			echo "<img src=\"../images/user_group.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query("SELECT name_org FROM org_name WHERE org_id = '".$id."' ");
			$R = $db->db_fetch_row($sql);
			echo $R[0];
		}
		if($L == "L"){
			echo "<img src=\"../images/user_c.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query("SELECT ul_name FROM user_level WHERE ul_id = '".$id."' ");
			$R = $db->db_fetch_row($sql);
			echo $R[0];
		}
		if($L == "P"){
			echo "<img src=\"../images/user_pos.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query("SELECT position_name.pos_name FROM position_name INNER JOIN user_position ON position_name.pos_id = user_position.pos_id WHERE user_position.up_id = '".$id."' ORDER BY user_position.up_rank ASC ");
			$R = $db->db_fetch_row($sql);
			echo $R[0];
		}
		if($L == "U"){
			echo "<img src=\"../images/user_logo.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query("SELECT name_thai,surname_thai FROM gen_user WHERE gen_user_id = '".$id."' ");
			$R = $db->db_fetch_row($sql);
			echo $R[0]." ".$R[1];
		}
	}
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">กำหนดสิทธิ์กลุ่มให้กับสมาชิก</span></td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td>
<hr>
    </td>
  </tr>
</table>
<?php
	$sql = $db->query("SELECT * FROM user_group_member WHERE ug_id = '".$_GET["ug"]."' AND ugm_type = 'U' ORDER BY ugm_type ASC");
	?>
<table width="94%" border="0" align="center" cellpadding="3" cellspacing="1" class="ewttableuse">
  <form name="form1" method="post" action="ewt_permission_g_update.php">
    <tr class="ewttablehead"> 
      <td width="10%" align="center" >เลือก</td>
      <td align="center" >ชื่อ - สกุล</td>
      <td align="center" >หมายเหตุ</td>
    </tr>
    <?php
 if($db->db_num_rows($sql) > 0){
 $i=0;
  while($U = $db->db_fetch_array($sql)){
  ?>
    <tr> 
      <td align="center" bgcolor="#FFFFFF"> <input name="chk<?php echo $i; ?>" type="checkbox" id="chk<?php echo $i; ?>" value="Y" checked>
        <input name="id<?php echo $i; ?>" type="hidden" id="id<?php echo $i; ?>" value="<?php echo $U["ugm_tid"]; ?>"></td>
      <td bgcolor="#FFFFFF"> 
        <?php level_name($U["ugm_type"],$U["ugm_tid"]); ?>
      </td>
      <td bgcolor="#FFFFFF"> 
        <?php
	  
	  if($U["ugm_type"] == "U"){
	  	$sql_lead = $db->query("SELECT gen_user.name_thai,gen_user.surname_thai,leader_list.leader_id FROM gen_user INNER JOIN leader_list ON gen_user.gen_user_id = leader_list.leader_id WHERE leader_list.under_id = '".$U["ugm_tid"]."' ");
  		if($db->db_num_rows($sql_lead)){
		$L = $db->db_fetch_row($sql_lead);
	   	$Lname = $L[0]." ".$L[1];
		echo "ต้องขออนุมัติจาก ".$Lname;
		}
	  }
	  ?>
      </td>
    </tr>
    <?php 
	$i++;
  }
  ?>
    <tr> 
      <td colspan="3" bgcolor="#FFFFFF"><input name="setting" type="radio" value="only" checked> ตั้งค่าสิทธิ์เฉพาะที่เพิ่ม
        
        <br><input type="radio" name="setting" value="all">
ตั้งค่าสิทธิ์ที่มีอยู่ทั้งหมด<br>
        <input type="submit" name="Submit" value="      ตั้งค่า      ">
        <input type="button" name="Submit3" value="กลับหน้าหลัก" onClick="window.location.href='ewt_permission_g.php';">
        <input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>">
        <input name="ug" type="hidden" id="ug" value="<?php echo $_GET["ug"]; ?>">
		<input name="myFlag" type="hidden" id="myFlag" value="<?php echo $_GET["myFlag"]; ?>">
        <input name="Flag" type="hidden" id="Flag" value="Upd">
		</td>
    </tr>
    <?php
  }else{ ?>
    <tr> 
      <td height="40" colspan="3" align="center" bgcolor="#FFFFFF"><font color="#FF0000">ไม่มีสมาชิกในกลุ่มนี้</font></td>
    </tr>
    <?php } ?>
  </form>
</table>
</body>
</html>
<?php

$db->db_close(); ?>