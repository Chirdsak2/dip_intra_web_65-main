<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
include("../ewt_module_hidden.php");
$db->query("USE ".$EWT_DB_NAME);
$sql = $db->query("SELECT * FROM web_permission ");

$mid = $_GET["mid"];
$mtype  = $_GET["mtype"];
$UID = $_GET["UID"];


?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script src="../js/AjaxRequest.js"></script>
<script src="../js/excute.js"></script>
<script language="JavaScript" >
function chkdis(c,ptype,ppms){
var num = document.form1.numrow.value;
	for(i=0;i<num;i++){
		if(c.checked == true){
			document.getElementById('chk'+i).disabled = true;
		}else{
			document.getElementById('chk'+i).disabled = false;
		}
	}
	updates(c,ptype,ppms,"");
}
function updates(c,ptype,ppms,g){
	if(c.checked == true){
	var	url='ewt_upd_ajax.php?UID=<?php echo $UID; ?>&mid=<?php echo $mid; ?>&mtype=<?php echo $mtype; ?>&accept=Y&ptype=' + ptype + '&ppms=' + ppms ;
	}else{
	var	url='ewt_upd_ajax.php?UID=<?php echo $UID; ?>&mid=<?php echo $mid; ?>&mtype=<?php echo $mtype; ?>&accept=N&ptype=' + ptype + '&ppms=' + ppms ;
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
	if(c.checked == true){
	advto(g);
	}else{
	advto('');
	}
}
function advto(g){
	if(g != ""){
		self.parent.p_advance.location.href = g + "?UID=<?php echo $UID; ?>&mid=<?php echo $mid; ?>&mtype=<?php echo $mtype; ?>";
	}else{
		self.parent.p_advance.location.href ="blank.php";
	}
}
</script>
</head>

<body>
<span id="divhtml" style="display:none"></span>
  <table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC">
    <form name="form1" method="post" action="">
	<?php
	$sql_sadmin = $db->query("SELECT * FROM permission WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = 'suser' ");
	if($db->db_num_rows($sql_sadmin) > 0){
		$decho = "disabled";
	}else{
		$decho = "";
	}
	?>
	 <tr  bgcolor="#FFFFFF"   > 
      <td > <input type="checkbox" name="checkbox" value="checkbox" onClick="chkdis(this,'suser','');" <?php if($decho == "disabled"){ echo "checked"; } ?>>
        <strong>Super admin </strong></td>
    </tr>
    <?php
 $i=0;
  while($U = $db->db_fetch_array($sql)){
  $sql_sadmin = $db->query("SELECT * FROM permission WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$U["p_code"]."' AND s_permission = '".$U["p_type"]."'  ");
  	if($db->db_num_rows($sql_sadmin) > 0){
		$check = "checked";
	}else{
		$check = "";
	}
	if(module_hidden($U["p_code"],$UID)==false){$hidden = 0;}else{$hidden = 1;}
	if($hidden){
  ?>
    <tr bgcolor="#FFFFFF" > 
      
      <td >&nbsp;&nbsp; <input type="checkbox" name="chk<?php echo $i; ?>" id="chk<?php echo $i; ?>" onClick="updates(this,'<?php echo $U["p_code"]; ?>','<?php echo $U["p_type"]; ?>','<?php echo $U["p_advance"]; ?>');" value="Y" <?php echo $decho;  ?> <?php echo $check;  ?>>
	  <?php if($U["p_advance"] != ""){ echo "<a href=\"#advance\" onClick=\"if(document.form1.chk".$i.".checked == true){ advto('".$U["p_advance"]."'); }else{ advto(''); }\" >"; } ?><?php echo $U["p_name"]; ?><?php if($U["p_advance"] != ""){ echo "</a>"; } ?> </td>
    </tr>
    <?php 
	$i++;
	}
  }
  ?><input type="hidden" name="numrow" value="<?php echo $i; ?>"></form>
  </table>
</body>
</html>
<?php
$db->db_close();
?>
