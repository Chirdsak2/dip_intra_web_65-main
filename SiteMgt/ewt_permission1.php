<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
if($_POST["Flag"] == "SaveAndExit" AND $_POST["myFlag"] != ""){
$mid = $_POST["mid"];
$mtype  = $_POST["mtype"];
$UID = $_SESSION["EWT_SUID"];
$myFlag = $_POST["myFlag"];
//Optimize data

$sql_sadmin = $db->query("SELECT p_id FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = 'suser' AND myFlag = '$myFlag' ");

if($db->db_num_rows($sql_sadmin)>0){
$db->query("DELETE FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type != 'suser' AND myFlag = '$myFlag' ");
}
//Clear CMS -W
$sql_fo_w = $db->query("SELECT p_id FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = 'cms' AND s_permission = 'w'  AND myFlag = '$myFlag' ");
if($db->db_num_rows($sql_fo_w) == 0){
$db->query("DELETE FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = 'Fo' AND s_permission = 'w'  AND myFlag = '$myFlag' ");
}else{
$sql_fo_wc = $db->query("SELECT p_id FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = 'Fo' AND s_permission = 'w'  AND myFlag = '$myFlag' ");
	if($db->db_num_rows($sql_fo_wc) == 0){
		$db->query("DELETE FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = 'cms' AND s_permission = 'w'  AND myFlag = '$myFlag' ");
	}
}
//Clear CMS -A
$sql_fo_a = $db->query("SELECT p_id FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = 'cms' AND s_permission = 'a'  AND myFlag = '$myFlag' ");
if($db->db_num_rows($sql_fo_a) == 0){
$db->query("DELETE FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = 'Fo' AND s_permission = 'a'  AND myFlag = '$myFlag' ");
}else{
$sql_fo_ac = $db->query("SELECT p_id FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = 'Fo' AND s_permission = 'a'  AND myFlag = '$myFlag' ");
	if($db->db_num_rows($sql_fo_ac) == 0){
		$db->query("DELETE FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = 'cms' AND s_permission = 'a'  AND myFlag = '$myFlag' ");
	}
}
//Clear Article -W
$sql_ag_w = $db->query("SELECT p_id FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = 'art' AND s_permission = 'w'  AND myFlag = '$myFlag' ");
if($db->db_num_rows($sql_ag_w) == 0){
$db->query("DELETE FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = 'Ag' AND s_permission = 'w'  AND myFlag = '$myFlag' ");
}else{
$sql_ag_wc = $db->query("SELECT p_id FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = 'Ag' AND s_permission = 'w'  AND myFlag = '$myFlag' ");
	if($db->db_num_rows($sql_ag_wc) == 0){
		$db->query("DELETE FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = 'art' AND s_permission = 'w'  AND myFlag = '$myFlag' ");
	}
}
//Clear Article -A
$sql_ag_a = $db->query("SELECT p_id FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = 'art' AND s_permission = 'a'  AND myFlag = '$myFlag' ");
if($db->db_num_rows($sql_ag_a) == 0){
$db->query("DELETE FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = 'Ag' AND s_permission = 'a'  AND myFlag = '$myFlag' ");
}else{
$sql_ag_ac = $db->query("SELECT p_id FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = 'Ag' AND s_permission = 'a'  AND myFlag = '$myFlag' ");
	if($db->db_num_rows($sql_ag_ac) == 0){
		$db->query("DELETE FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = 'art' AND s_permission = 'a'  AND myFlag = '$myFlag' ");
	}
}
//Add Permission
	$sql_newp = $db->query("SELECT permission1.* FROM permission1 LEFT JOIN permission ON permission1.p_type = permission.p_type AND permission1.pu_id = permission.pu_id AND permission1.UID = permission.UID  AND  permission1.s_type = permission.s_type  AND  permission1.s_name = permission.s_name AND  permission1.s_id = permission.s_id  AND permission1.s_permission = permission.s_permission WHERE permission1.p_type = '$mtype' AND permission1.pu_id = '$mid' AND permission1.UID = '$UID' AND permission1.myFlag = '$myFlag' AND permission.p_id IS NULL ");
		while($N = $db->db_fetch_array($sql_newp)){
			if($mtype == "A"){
				$db->query("INSERT INTO permission0 (p_type,pu_id,UID,s_type,s_id,s_name,s_permission,myFlag,timest,p_status) VALUES ('".$N["p_type"]."','".$N["pu_id"]."','".$N["UID"]."','".$N["s_type"]."','".$N["s_id"]."','".$N["s_name"]."','".$N["s_permission"]."','".$N["myFlag"]."','".date("Y-m-d")."','A') ");
			}
		}
//DELETE Permission
$sql_delp = $db->query("SELECT permission.* FROM permission LEFT JOIN permission1 ON permission.p_type = permission1.p_type AND permission.pu_id = permission1.pu_id AND permission.UID = permission1.UID  AND  permission.s_type = permission1.s_type  AND  permission.s_name = permission1.s_name AND  permission.s_id = permission1.s_id  AND permission.s_permission = permission1.s_permission WHERE permission.p_type = '$mtype' AND permission.pu_id = '$mid' AND permission.UID = '$UID' AND permission1.p_id IS NULL ");
		while($D = $db->db_fetch_array($sql_delp)){
			if($mtype == "A"){
				$db->query("INSERT INTO permission0 (p_type,pu_id,UID,s_type,s_id,s_name,s_permission,myFlag,timest,p_status) VALUES ('".$D["p_type"]."','".$D["pu_id"]."','".$D["UID"]."','".$D["s_type"]."','".$D["s_id"]."','".$D["s_name"]."','".$D["s_permission"]."','".$myFlag."','".date("Y-m-d")."','D') ");
			}
		}
		
$db->query("DELETE FROM permission WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' ");
$sql = $db->query("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND myFlag = '$myFlag' ");
while($P=$db->db_fetch_array($sql)){
$db->query("INSERT INTO permission (p_type,pu_id,UID,s_type,s_id,s_name,s_permission) VALUES ('".$mtype."','".$mid."','".$UID."','".$P["s_type"]."','".$P["s_id"]."','".$P["s_name"]."','".$P["s_permission"]."') ");
}
$db->query("DELETE FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND myFlag = '$myFlag' ");
		if($mtype == "A"){
		?>
		<script >
		self.location.href = "ewt_permission_g_update.php?ug=<?php echo $mid; ?>&myFlag=<?php echo $myFlag; ?>";
		</script>
		<?php
		exit;
		}else{
		?>
		<script >
		self.location.href = "ewt_permission0.php";
		</script>
		<?php
		exit;
		}
}else{
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
	$myFlag = random_to(20);
	function level_name($L,$id){
	global $db;
		if($L == "A"){
			echo "<img src=\"../images/user_a.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\"> ";
			$sql = $db->query("SELECT ug_name FROM user_group WHERE ug_id = '".$id."' ");
			$R = $db->db_fetch_row($sql);
			echo $R[0];
		}
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
				$db->query("DELETE FROM permission1 WHERE p_type = '".$_GET["mtype"]."' AND pu_id = '".$_GET["mid"]."' AND UID = '".$_SESSION["EWT_SUID"]."'  ");
				$sql_p = $db->query("SELECT * FROM permission WHERE p_type = '".$_GET["mtype"]."' AND pu_id = '".$_GET["mid"]."' AND UID = '".$_SESSION["EWT_SUID"]."' ");
				while($P = $db->db_fetch_array($sql_p)){
				$db->query("INSERT INTO permission1 (p_type,pu_id,UID,s_type,s_id,s_name,s_permission,myFlag,timest,p_status) VALUES ('".$_GET["mtype"]."','".$_GET["mid"]."','".$_SESSION["EWT_SUID"]."','".$P["s_type"]."','".$P["s_id"]."','".$P["s_name"]."','".$P["s_permission"]."','".$myFlag."','".date("Y-m-d")."','O') ");
				}


include("../lib/config_path.php");
include("../header.php");					
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<?php include('link.php'); ?>
</head>
<body leftmargin="0" topmargin="0">
<?php
include('top.php');
?>
<div class="panel panel-default" style="border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">

<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;"><?="แก้ไขกำหนดสิทธิ์ผู้ใช้งานระบบ" ;?></h4>
</div>	

<div class="panel-body">

<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:right;" >
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12"></div>
<div class="col-md-6 col-sm-6 col-xs-12" style="text-align:right;" >

<!--<a href="banner_add.php?flag=add&banner_gid=<?php echo $banner_gid;?>" target="_self">
<img src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle" border="0"> 
      <?php //echo $text_genbanner_addnew;?>
<button type="button" class="btn btn-info  btn-sm " >
        <span class="glyphicon glyphicon-plus-sign "></span>&nbsp;&nbsp;<?=$text_genbanner_addnew;?>
</button>	  	  
</a> &nbsp;-->
<a href="ewt_permission0.php" target="_self">
<button type="button" class="btn btn-info  btn-sm " >
       <span class="glyphicon glyphicon-backward"></span>&nbsp;&nbsp;<?="ย้อนกลับ";?>
</button>
</a>


</div>
</div>
<hr />
</div>	

<div class="col-md-12 col-sm-12 col-xs-12"  >
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#333333">
<form name="formlink" method="post" action=""><tr> 
<td height="50" bgcolor="#FFFFFF">
<table width="100%"  >
<tr>
<td width="90%">
&nbsp;&nbsp;<img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
<span _class="ewtfunction">กำหนดสิทธิ์ผู้ใช้งานระบบ</span> 
<span _class="ewtfunction"><?php level_name($_GET["mtype"],$_GET["mid"]); ?></span>
      
        <input type="hidden" name="mid" value="<?php echo $_GET["mid"]; ?>">
		<input type="hidden" name="mtype" value="<?php echo $_GET["mtype"]; ?>">
        <input name="Flag" type="hidden" id="Flag" value="SaveAndExit">
		<input type="hidden" name="myFlag" value="<?php echo $myFlag; ?>">
</td>
<td align="right">
			<input type="submit" name="Submit" value="   บันทึก   " class="btn btn-success"> 
</td>
</tr>
</table>
</td>
  </tr>
</form>
<tr> 
<td align="center" valign="top" bgcolor="#FFFFFF">
<table width="100%" height="100%" class="table table-bordered">
        <tr> 
          <td width="30%" align="center" valign="top">
		  <table width="100%" height="100%" border="0" cellpadding="2" cellspacing="0">
              <tr> 
                <td height="25"><img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
                  รายการสิทธิ์</td>
              </tr>
              <tr> 
                <td height="1" bgcolor="D8D2BD"></td>
              </tr>
              <tr> 
                <td height="1" bgcolor="#FFFFFF"></td>
              </tr>
              <tr> 
                <td align="center" valign="top" bgcolor="888888">
				<table width="100%" height="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#000000">
                    <tr> 
                      <td bgcolor="#FFFFFF"><iframe name="p_permission"  frameborder="0"  width="100%" height="300" scrolling="yes" src="ewt_p_list.php?mid=<?php echo $_GET["mid"]; ?>&mtype=<?php echo $_GET["mtype"]; ?>&myFlag=<?php echo $myFlag; ?>"></iframe></td>
                    </tr>
                  </table>
</td>
              </tr>
            </table></td>
          <td height="250" rowspan="2" align="center" valign="top">
		  <table width="100%" height="100%" border="0" cellpadding="2" cellspacing="0">
              <tr> 
                <td height="25"><img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
                  ตั้งค่าเพิ่มเติม</td>
              </tr>
              <tr> 
                <td height="1" bgcolor="D8D2BD"></td>
              </tr>
              <tr> 
                <td height="1" bgcolor="#FFFFFF"></td>
              </tr>
              <tr> 
                <td align="center" valign="top" bgcolor="888888"><table width="100%" height="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="#000000">
                    <tr> 
                      <td bgcolor="#FFFFFF"><iframe name="p_advance"  frameborder="0"  width="100%" height="300" scrolling="yes"></iframe></td>
                    </tr>
                  </table></td>
              </tr>
            </table></td>
        </tr>
        <!--<tr> 
          <td height="20" align="right"><input type="button" name="Submit2" value="   Add User   " onClick="win4=window.open('ewt_s_member.php?ug=<?php echo $_SESSION["EWT_SUID"]; ?>','usersq','width=650,height=400,scrollbars=1,resizable=1');win4.focus();">
            <input name="bt_remove" type="button" disabled id="bt_remove" value="Remove User"></td>
        </tr>-->
      </table></td>
  </tr>
</table>
</div>	
</div>
</div>
<?php
include('footer.php');
?>
</body>
</html>
<?php
}
$db->db_close(); ?>
