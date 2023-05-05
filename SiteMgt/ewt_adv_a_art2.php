<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
$ptype = "Ag";
$ppms = "a";

	  $sql_supadmin = $db->query_db("SELECT s_id FROM permission WHERE p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' AND UID = '".$_SESSION["EWT_SUID"]."' AND (s_type = '".$ptype."' AND s_permission = '".$ppms."'  AND s_id != '0' ) ",$EWT_DB_USER);
	 $sql_text = "WHERE ( 0 ";
	while($G = $db->db_fetch_row($sql_supadmin)){
	$y = 0;
		if(countparent($G[0]) == 0){
		$sql_text .= " OR c_id = '".$G[0]."' ";
		}
	}
	$sql_text .= " ) ";

$sql = $db->query_db("SELECT * FROM article_group ".$sql_text." ORDER BY c_id ASC ",$_SESSION["EWT_SDB"]);

$mid = $_GET["mid"];
$mtype  = $_GET["mtype"];
$UID = $_SESSION["EWT_SUID"];

$myFlag = $_GET["myFlag"];

function GenPic($data){
	for($i=0;$i<$data;$i++){
		echo "<img src=\"../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
	}
}
function child($c,$x,$decho){
global $db,$EWT_DB_USER,$mtype,$mid,$UID,$ptype,$ppms,$myFlag,$i,$txt;
$y = $x+1;
$sql = $db->query_db("SELECT * FROM article_group WHERE c_parent = '$c' ORDER BY c_id ASC ",$_SESSION["EWT_SDB"]);
  while($U = $db->db_fetch_array($sql)){
  $sql_sadmin = $db->query_db("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = '".$ppms."'  AND s_id = '".$U["c_id"]."' AND myFlag = '$myFlag' ",$EWT_DB_USER);
  	if($db->db_num_rows($sql_sadmin) > 0){
		$check = "checked";
	}else{
		$check = "";
	}
	$ct = countchild($U["c_id"]);
  ?>
    <tr bgcolor="#FFFFFF" > 
      <td ><img src="../images/o.gif" width="20" height="20" border="0" align="absmiddle"><?php GenPic($y); ?><img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">&nbsp; <input type="checkbox" name="chk<?php echo $i;  ?>" id="chk<?php echo $i;  ?>" onClick="chkdis(this,'<?php echo $U["c_id"]; ?>',<?php echo $i; ?>,<?php echo $ct; ?>);" value="<?php echo $U["c_id"]; ?>" <?php echo $decho;  ?> <?php echo $check;  ?>>
	  <?php echo $U["c_name"]; ?></td>
    </tr>
    <?php
	if($check == "checked"){
	$txt .= "chkdis(document.form1.chk".$i.",'".$U["c_id"]."',".$i.",".$ct."); ";
	}
	$i++; 
	child($U["c_id"],$y,$decho);
  }
}
function countchild($c){
global $db;

$sql = $db->query_db("SELECT c_id FROM article_group WHERE c_parent = '$c'   ",$_SESSION["EWT_SDB"]);
$x = 0;
  while($U = $db->db_fetch_array($sql)){
	$c = countchild($U["c_id"]);
	$x += $c;
	$x++;
  }
  return $x;
}
function countparent($c){
global $db,$EWT_DB_USER,$ptype,$ppms,$y;

$sql = $db->query_db("SELECT c_parent FROM article_group WHERE c_id = '$c'   ",$_SESSION["EWT_SDB"]);
  while($U = $db->db_fetch_array($sql)){
	$c = countparent($U["c_parent"]);
	$y += $c;
	$sql2 = $db->query_db("SELECT s_id FROM permission WHERE p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' AND UID = '".$_SESSION["EWT_SUID"]."' AND (s_type = '".$ptype."' AND s_permission = '".$ppms."'  AND s_id = '".$U["c_parent"]."' ) ",$EWT_DB_USER);
	if($db->db_num_rows($sql2) > 0){
	$y++;
	}
  }
  return $y;
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
/*function chkdis(c){
var num = document.form1.chk.length;
	for(i=1;i<num;i++){
		if(c.checked == true){
			document.form1.chk[i].disabled = true;
		}else{
			document.form1.chk[i].disabled = false;
		}
	}
	updates(c,'all');
}*/
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
      <td ><strong>Article group</strong></td>
    </tr>
    <?php
	$i=1;
	$txt = "";
  while($U = $db->db_fetch_array($sql)){
  $sql_sadmin = $db->query_db("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = '".$ppms."'  AND s_id = '".$U["c_id"]."' AND myFlag = '$myFlag' ",$EWT_DB_USER);
  	if($db->db_num_rows($sql_sadmin) > 0){
		$check = "checked";
	}else{
		$check = "";
	}
	$ct = countchild($U["c_id"]);
  ?>
    <tr bgcolor="#FFFFFF" > 
      <td ><img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">&nbsp; 
        <input type="checkbox" name="chk<?php echo $i; ?>" id="chk<?php echo $i; ?>" onClick="chkdis(this,'<?php echo $U["c_id"]; ?>',<?php echo $i; ?>,<?php echo $ct;  ?>);" value="<?php echo $U["c_id"]; ?>" <?php echo $decho;  ?> <?php echo $check;  ?>> 
	  <?php echo $U["c_name"]; ?></td>
    </tr>
    <?php 
	if($check == "checked"){
	$txt .= "chkdis(document.form1.chk".$i.",'".$U["c_id"]."',".$i.",".$ct."); ";
	}
	$i++;
	child($U["c_id"],0,$decho);
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
