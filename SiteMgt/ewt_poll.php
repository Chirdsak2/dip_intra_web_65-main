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
$ptype = "poll";
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
	  $sql_sadmin = $db->query_db("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = 'a'  AND myFlag = '$myFlag' ",$EWT_DB_USER);
	if($db->db_num_rows($sql_sadmin) > 0){
		$decho = "disabled";
		$check = "checked";
	}else{
		$decho = "";
		$check = "";
	}
	?>
      <td >&nbsp; <input type="checkbox" name="chk1" id="chk1" value="0"  <?php echo $check;  ?> onClick="updates(this,'a');">
        อนุมัติ poll</td>
    </tr>
    <tr bgcolor="#FFFFFF" > 
      <?php
	  $sql_sadmin = $db->query_db("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = 's'  AND myFlag = '$myFlag' ",$EWT_DB_USER);
	if($db->db_num_rows($sql_sadmin) > 0){
		$decho = "disabled";
		$check = "checked";
	}else{
		$decho = "";
		$check = "";
	}
	?>
      <td >&nbsp; <input type="checkbox" name="chk0" id="chk0" value="0"  <?php echo $check;  ?> onClick="updates(this,'s');">
        ตั้งค่า poll</td>
    </tr>
  </form>
</table>
</body>
</html>
<?php
$db->db_close();
?>
