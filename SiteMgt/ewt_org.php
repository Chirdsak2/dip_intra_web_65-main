<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
$mid = $_GET["mid"];
$mtype  = $_GET["mtype"];
$UID = $_SESSION["EWT_SUID"];
$ptype = "org";
$myFlag = $_GET["myFlag"];

?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script src="../js/AjaxRequest.js"></script>
<script src="../js/excute.js"></script>
<script language="JavaScript" >
function updates(c,ppms){
	if(c.checked == true){
	var	url='ewt_upd_ajax.php?UID=<?php echo $UID; ?>&mid=<?php echo $mid; ?>&mtype=<?php echo $mtype; ?>&myFlag=<?php echo $myFlag; ?>&accept=Y&ptype=<?php echo $ptype; ?>&ppms=' + ppms;
	}else{
	var	url='ewt_upd_ajax.php?UID=<?php echo $UID; ?>&mid=<?php echo $mid; ?>&mtype=<?php echo $mtype; ?>&myFlag=<?php echo $myFlag; ?>&accept=N&ptype=<?php echo $ptype; ?>&ppms=' + ppms ;
	}
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					document.all.divhtml.innerHTML = req.responseText; 
			}
		}
	);
	//advto(g);
}
</script>
</head>
<body>
<span id="divhtml" style="display:none"></span>
  
<table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC">
  <form name="form1" method="post" action="">
    <tr bgcolor="#FFFFFF" > 
      <td ><strong>ตั้งค่า</strong></td>
    </tr>
	
	
    <tr bgcolor="#FFFFFF" > 
      <?php
	  $sql_sadmin = $db->query_db("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = 'u'  AND myFlag = '$myFlag' ",$EWT_DB_USER);
	if($db->db_num_rows($sql_sadmin) > 0){
		$decho = "disabled";
		$check = "checked";
	}else{
		$decho = "";
		$check = "";
	}
	?>
      <td >&nbsp; <input type="checkbox" name="chk1" id="chk1" value="0"  <?php echo $check;  ?> onClick="updates(this,'u');"> บริหารข้อมูลบุคลากร</td>
    </tr>
	
	
    <tr bgcolor="#FFFFFF" > 
      <?php
	  $sql_sadmin = $db->query_db("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = 'o'  AND myFlag = '$myFlag' ",$EWT_DB_USER);
	if($db->db_num_rows($sql_sadmin) > 0){
		$decho = "disabled";
		$check = "checked";
	}else{
		$decho = "";
		$check = "";
	}
	?>
      <td >&nbsp; <input type="checkbox" name="chk2" id="chk2" value="0"  <?php echo $check;  ?> onClick="updates(this,'o');">  บริหารหน่วยงาน </td>
    </tr>
		
	
    <tr bgcolor="#FFFFFF" > 
      <?php
	  $sql_sadmin = $db->query_db("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = 'p'  AND myFlag = '$myFlag' ",$EWT_DB_USER);
	if($db->db_num_rows($sql_sadmin) > 0){
		$decho = "disabled";
		$check = "checked";
	}else{
		$decho = "";
		$check = "";
	}
	?>
      <td >&nbsp; <input type="checkbox" name="chk3" id="chk3" value="0"  <?php echo $check;  ?> onClick="updates(this,'p');">  บริหารตำแหน่ง  </td>
    </tr>
		
	
    <tr bgcolor="#FFFFFF" > 
      <?php
	  $sql_sadmin = $db->query_db("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = 'g'  AND myFlag = '$myFlag' ",$EWT_DB_USER);
	if($db->db_num_rows($sql_sadmin) > 0){
		$decho = "disabled";
		$check = "checked";
	}else{
		$decho = "";
		$check = "";
	}
	?>
      <td >&nbsp; <input type="checkbox" name="chk4" id="chk4" value="0"  <?php echo $check;  ?> onClick="updates(this,'g');">  บริหารกลุ่มบุคลากร  </td>
    </tr>
		
	
    <tr bgcolor="#FFFFFF" > 
      <?php
	  $sql_sadmin = $db->query_db("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = 'm'  AND myFlag = '$myFlag' ",$EWT_DB_USER);
	if($db->db_num_rows($sql_sadmin) > 0){
		$decho = "disabled";
		$check = "checked";
	}else{
		$decho = "";
		$check = "";
	}
	?>
      <td >&nbsp; <input type="checkbox" name="chk5" id="chk5" value="0"  <?php echo $check;  ?> onClick="updates(this,'m');">  บริหารคำนำหน้าชื่อ   </td>
    </tr>
		
	<?php if($_SESSION[EWT_SMTYPE]!='Y'){?>
    <tr bgcolor="#FFFFFF" > 
      <?php
	  $sql_sadmin = $db->query_db("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = 'l'  AND myFlag = '$myFlag' ",$EWT_DB_USER);
	if($db->db_num_rows($sql_sadmin) > 0){
		$decho = "disabled";
		$check = "checked";
	}else{
		$decho = "";
		$check = "";
	}
	?>
      <td >&nbsp; <input type="checkbox" name="chk6" id="chk6" value="0"  <?php echo $check;  ?> onClick="updates(this,'l');">  ตั้งค่าหัวหน้า/ลูกน้อง </td>
    </tr>
	<?php }?>
	
    <tr bgcolor="#FFFFFF" > 
      <?php
	  $sql_sadmin = $db->query_db("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = 'c'  AND myFlag = '$myFlag' ",$EWT_DB_USER);
	if($db->db_num_rows($sql_sadmin) > 0){
		$decho = "disabled";
		$check = "checked";
	}else{
		$decho = "";
		$check = "";
	}
	?>
      <td >&nbsp; <input type="checkbox" name="chk7" id="chk7" value="0"  <?php echo $check;  ?> onClick="updates(this,'c');"> บริหารแผนผังบุคลากร </td>
    </tr>
		
	<?php if($_SESSION[EWT_SMTYPE]!='Y'){?>
    <tr bgcolor="#FFFFFF" > 
      <?php
	  $sql_sadmin = $db->query_db("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = 't'  AND myFlag = '$myFlag' ",$EWT_DB_USER);
	if($db->db_num_rows($sql_sadmin) > 0){
		$decho = "disabled";
		$check = "checked";
	}else{
		$decho = "";
		$check = "";
	}
	?>
      <td >&nbsp; <input type="checkbox" name="chk8" id="chk8" value="0"  <?php echo $check;  ?> onClick="updates(this,'t');"> บริหารกลุ่มสิทธิ์   </td>
    </tr>

	<?php }?>
	    <tr bgcolor="#FFFFFF" >
	  <?php
	  $sql_sadmin = $db->query_db("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = 'x'  AND myFlag = '$myFlag' ",$EWT_DB_USER);
	if($db->db_num_rows($sql_sadmin) > 0){
		$decho = "disabled";
		$check = "checked";
	}else{
		$decho = "";
		$check = "";
	}
	?>
      <td >&nbsp; <input type="checkbox" name="chk9" id="chk9" value="0"  <?php echo $check;  ?> onClick="updates(this,'x');"> จัดเรียงบุคคลากร   </td>
    </tr>
  </form>
</table>
</body>
</html>
<?php
$db->db_close();
?>
