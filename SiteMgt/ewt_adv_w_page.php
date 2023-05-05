<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
$ptype = "Fo";
$ppms = "w";
if($_SESSION["EWT_SMID"] != ''){
	  $sql_supadmin = $db->query_db("SELECT p_id FROM permission WHERE p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' AND UID = '".$_SESSION["EWT_SUID"]."' AND ((s_type = '".$ptype."' AND s_permission = '".$ppms."'  AND s_id = '0' ) OR (s_type = 'suser'  )) ",$EWT_DB_USER);
	if($db->db_num_rows($sql_supadmin) == 0){
	?>
	<script language="JavaScript">
	window.location.href ="ewt_adv_w_page2.php?mid=<?php echo $_GET["mid"]; ?>&mtype=<?php echo $_GET["mtype"]; ?>&myFlag=<?php echo $_GET["myFlag"]; ?>";
	</script>
	<?php
	exit;
	}
}
$sql = $db->query_db("SELECT * FROM temp_main_group ORDER BY Main_Position ASC ",$_SESSION["EWT_SDB"]);

$mid = $_GET["mid"];
$mtype  = $_GET["mtype"];
$UID = $_SESSION["EWT_SUID"];

$myFlag = $_GET["myFlag"];

function GenPic($data){
	$s = explode("_",$data);
	for($i=2;$i<count($s);$i++){
		echo "<img src=\"../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
	}
}
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script src="../js/AjaxRequest.js"></script>
<script src="../js/excute.js"></script>
<script language="JavaScript" >
function updates(c,gid){
	if(c.checked == true){
	var	url='ewt_upd_ajax.php?UID=<?php echo $UID; ?>&mid=<?php echo $mid; ?>&mtype=<?php echo $mtype; ?>&myFlag=<?php echo $myFlag; ?>&accept=Y&ptype=<?php echo $ptype; ?>&ppms=<?php echo $ppms; ?>&psid=' + gid;
	}else{
	var	url='ewt_upd_ajax.php?UID=<?php echo $UID; ?>&mid=<?php echo $mid; ?>&mtype=<?php echo $mtype; ?>&myFlag=<?php echo $myFlag; ?>&accept=N&ptype=<?php echo $ptype; ?>&ppms=<?php echo $ppms; ?>&psid=' + gid ;
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
function chkdis(c,gid,start,len){
var num = start+len;
var st = start+1;
	for(i=st;i<=num;i++){
		if(c.checked == true){
			document.getElementById('chk'+i).disabled = true;
			if(document.getElementById('chk'+i).checked == true){
			document.getElementById('chk'+i).checked =  false;
			updates(document.getElementById('chk'+i),document.getElementById('chk'+i).value);
			}
		}else{
			document.getElementById('chk'+i).disabled = false;
		}
	}
	updates(c,gid);
}
</script>
</head>
<body>
<span id="divhtml" style="display:none"></span>
  <table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC">
    <form name="form1" method="post" action="">
	<tr bgcolor="#FFFFFF" > 
      <td ><strong>Webpage group</strong></td>
    </tr>
	<tr bgcolor="#FFFFFF" > <?php
	  $sql_sadmin = $db->query_db("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = '".$ppms."'  AND s_id = '0' AND myFlag = '$myFlag' ",$EWT_DB_USER);
	if($db->db_num_rows($sql_sadmin) > 0){
		$decho = "disabled";
		$check = "checked";
	}else{
		$decho = "";
		$check = "";
	}
	?>
      <td ><img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">&nbsp; <input type="checkbox" name="chk0" id="chk<?php echo $i; ?>" value="0"  <?php echo $check;  ?> onClick="chkdis(this,'0',0,<?php echo $db->db_num_rows($sql); ?>);">
        <strong>All folder</strong></td>
    </tr>
    <?php
 $i=1;
 $txt = "";
  while($U = $db->db_fetch_array($sql)){
  $sql_sadmin = $db->query_db("SELECT p_id FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = '".$ppms."'  AND s_id = '".$U["Main_Group_ID"]."' AND myFlag = '$myFlag' ",$EWT_DB_USER);
  	if($db->db_num_rows($sql_sadmin) > 0){
		$check = "checked";
	}else{
		$check = "";
	}
	$sql_sub = $db->query_db("SELECT COUNT(Main_Group_ID) FROM temp_main_group WHERE Main_Position LIKE '".$U["Main_Position"]."_%'",$_SESSION["EWT_SDB"]);
	$count_sub = $db->db_fetch_row($sql_sub);
  ?>
    <tr bgcolor="#FFFFFF" > 
      <td ><?php GenPic($U["Main_Position"]); ?><img src="../images/o.gif" width="20" height="20" border="0" align="absmiddle"><img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">&nbsp; <input type="checkbox" name="chk<?php echo $i; ?>" id="chk<?php echo $i; ?>" onClick="chkdis(this,'<?php echo $U["Main_Group_ID"]; ?>',<?php echo $i; ?>,<?php echo $count_sub[0]; ?>);" value="<?php echo $U["Main_Group_ID"]; ?>" <?php echo $decho;  ?> <?php echo $check;  ?>>
	  <?php echo $U["Main_Group_Name"]; ?></td>
    </tr>
    <?php 
	if($check == "checked"){
	$txt .= "chkdis(document.form1.chk".$i.",'".$U["Main_Group_ID"]."',".$i.",".$count_sub[0]."); ";
	}
	$i++;
  }
  ?><input type="hidden" name="numrow" value="<?php echo $i; ?>"></form>
  </table>
</body>
</html>
<script language="JavaScript">
<?php echo $txt; ?>
</script>
<?php
$db->db_close();
?>
