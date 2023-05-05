<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
$sql1 = $db->query("SELECT * FROM user_info WHERE UID = '".$_GET["UID"]."' ");
$R = $db->db_fetch_array($sql1);

$sql = $db->query_db("SELECT * FROM temp_main_group ORDER BY Main_Position ASC ",$R["db_db"]);

$mid = $_GET["mid"];
$mtype  = $_GET["mtype"];
$UID = $_GET["UID"];
$ptype = "Fo";
$ppms = "a";

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
	var	url='ewt_upd_ajax2.php?UID=<?php echo $UID; ?>&mid=<?php echo $mid; ?>&mtype=<?php echo $mtype; ?>&myFlag=<?php echo $_GET["myFlag"]; ?>&accept=Y&ptype=<?php echo $ptype; ?>&ppms=<?php echo $ppms; ?>&psid=' + gid;
	}else{
	var	url='ewt_upd_ajax2.php?UID=<?php echo $UID; ?>&mid=<?php echo $mid; ?>&mtype=<?php echo $mtype; ?>&myFlag=<?php echo $_GET["myFlag"]; ?>&accept=N&ptype=<?php echo $ptype; ?>&ppms=<?php echo $ppms; ?>&psid=' + gid ;
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
  $sql_sadmin = $db->query_db("SELECT * FROM permission2 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = '".$ppms."'  AND s_id = '".$U["Main_Group_ID"]."'  AND myFlag = '".$_GET["myFlag"]."' ",$EWT_DB_USER);
  	if($db->db_num_rows($sql_sadmin) > 0){
		$check = "checked";
	}else{
		$check = "";
	}
  ?>
    <tr bgcolor="#FFFFFF" > 
      
      <td ><?php
		  		GenPic($U["Main_Position"]);
		   if($count_sub[0] > 0){ ?><img src="../images/minus.gif" border="0" align="absmiddle"><?php }else{ ?><img src="../images/o.gif" width="20" height="20" border="0" align="absmiddle"><?php } ?><img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">&nbsp; <input type="checkbox" name="chk<?php echo $i; ?>" id="chk<?php echo $i; ?>" onClick="updates(this,'<?php echo $U["Main_Group_ID"]; ?>');" value="Y" <?php echo $decho;  ?> <?php echo $check;  ?>>
	  <?php echo $U["Main_Group_Name"]; ?></td>
    </tr>
    <?php 
	$i++;
  }
  ?><input type="hidden" name="numrow" value="<?php echo $i; ?>"></form>
  </table>
</body>
</html>
<?php
$db->db_close();
?>
