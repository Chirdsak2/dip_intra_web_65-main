<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
$sql1 = $db->query("SELECT * FROM user_info WHERE UID = '".$_GET["UID"]."' ");
$R = $db->db_fetch_array($sql1);

$sql = $db->query_db("SELECT * FROM article_group WHERE c_parent = '0'  ORDER BY c_id ASC ",$R["db_db"]);

$mid = $_GET["mid"];
$mtype  = $_GET["mtype"];
$UID = $_GET["UID"];
$ptype = "Ag";
$ppms = "a";

function GenPic($data){
	for($i=0;$i<$data;$i++){
		echo "<img src=\"../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
	}
}
function child($c,$x,$decho){
global $db,$mtype,$mid,$UID,$ptype,$ppms,$myFlag,$i,$txt,$EWT_DB_NAME;

$y = $x+1;
$sql = $db->query_db("SELECT * FROM article_group WHERE c_parent = '$c' ORDER BY c_id ASC ",$decho);
  while($U = $db->db_fetch_array($sql)){
    $sql_sadmin = $db->query_db("SELECT * FROM permission WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = '".$ppms."'  AND s_id = '".$U["c_id"]."' ",$EWT_DB_NAME);
  	if($db->db_num_rows($sql_sadmin) > 0){
		$check = "checked";
	}else{
		$check = "";
	}
  ?>
    <tr bgcolor="#FFFFFF" > 
      
      <td ><?php GenPic($y); ?><img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">&nbsp; <input type="checkbox" name="chk<?php echo $i; ?>" id="chk<?php echo $i; ?>" onClick="updates(this,'<?php echo $U["c_id"]; ?>');" value="Y" <?php echo $decho;  ?> <?php echo $check;  ?>>
	  <?php echo $U["c_name"]; ?></td>
    </tr>
    <?php 
	$i++;
	child($U["c_id"],$y,$decho);
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
	var	url='ewt_upd_ajax.php?UID=<?php echo $UID; ?>&mid=<?php echo $mid; ?>&mtype=<?php echo $mtype; ?>&accept=Y&ptype=<?php echo $ptype; ?>&ppms=<?php echo $ppms; ?>&psid=' + gid;
	}else{
	var	url='ewt_upd_ajax.php?UID=<?php echo $UID; ?>&mid=<?php echo $mid; ?>&mtype=<?php echo $mtype; ?>&accept=N&ptype=<?php echo $ptype; ?>&ppms=<?php echo $ppms; ?>&psid=' + gid ;
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
      
      <td ><strong>Webpage group</strong></td>
    </tr>
    <?php
 $i=0;
  while($U = $db->db_fetch_array($sql)){
  $sql_sadmin = $db->query_db("SELECT * FROM permission WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = '".$ppms."'  AND s_id = '".$U["c_id"]."' ",$EWT_DB_NAME);
  	if($db->db_num_rows($sql_sadmin) > 0){
		$check = "checked";
	}else{
		$check = "";
	}
  ?>
    <tr bgcolor="#FFFFFF" > 
      
      <td ><img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">&nbsp; <input type="checkbox" name="chk<?php echo $i; ?>" id="chk<?php echo $i; ?>" onClick="updates(this,'<?php echo $U["c_id"]; ?>');" value="Y" <?php echo $decho;  ?> <?php echo $check;  ?>>
	  <?php echo $U["c_name"]; ?></td>
    </tr>
    <?php 
	$i++;
	child($U["c_id"],0,$R["db_db"]);
  }
  ?><input type="hidden" name="numrow" value="<?php echo $i; ?>"></form>
  </table>
</body>
</html>
<?php
$db->db_close();
?>
