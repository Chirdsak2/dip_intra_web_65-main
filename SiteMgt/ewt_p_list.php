<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../ewt_module_hidden.php");
$db->query("USE ".$EWT_DB_USER);
$mid = $_GET["mid"];
$mtype  = $_GET["mtype"];
$UID = $_SESSION["EWT_SUID"];
$myFlag = $_GET["myFlag"];

include("../lib/config_path.php");
include("../header.php");
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<?php include('link.php'); ?>
<script src="../js/AjaxRequest.js"></script>
<script src="../js/excute.js"></script>
<script  >
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
	var	url='ewt_upd_ajax.php?UID=<?php echo $UID; ?>&mid=<?php echo $mid; ?>&mtype=<?php echo $mtype; ?>&myFlag=<?php echo $myFlag; ?>&accept=Y&ptype=' + ptype + '&ppms=' + ppms ;
	}else{
	var	url='ewt_upd_ajax.php?UID=<?php echo $UID; ?>&mid=<?php echo $mid; ?>&mtype=<?php echo $mtype; ?>&myFlag=<?php echo $myFlag; ?>&accept=N&ptype=' + ptype + '&ppms=' + ppms ;
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
		self.parent.p_advance.location.href = g + "?mid=<?php echo $mid; ?>&mtype=<?php echo $mtype; ?>&myFlag=<?php echo $myFlag; ?>";
	}else{
		self.parent.p_advance.location.href ="blank.php";
	}
}
</script>
</head>
<?php
	$sql_myadmin = $db->query("SELECT * FROM permission WHERE p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' AND UID = '$UID' AND s_type = 'suser' ");
	if($db->db_num_rows($sql_myadmin) > 0 || $_SESSION["EWT_SMID"] == ''){
	$sadmin = "1";
		$sql = $db->query("SELECT * FROM web_permission WHERE p_status = 'Y'");
	}else{
	$sadmin = "0";
		$sql = $db->query("SELECT web_permission.* FROM permission INNER JOIN web_permission ON permission.s_type = web_permission.p_code WHERE permission.p_type = 'U' AND permission.pu_id = '".$_SESSION["EWT_SMID"]."' AND permission.UID = '".$_SESSION["EWT_SUID"]."'  AND web_permission.p_status = 'Y'  GROUP BY web_permission.p_name ORDER BY web_permission.p_id");
	}
?>
<body>
<span id="divhtml" style="display:none"></span>
  <table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC">
    <form name="form1" method="post" action="">
	<?php
	$sql_sadmin = $db->query("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = 'suser' AND myFlag = '$myFlag' ");
	if($db->db_num_rows($sql_sadmin) > 0 ){
		$decho = "disabled";
	}else{
		$decho = "";
	}
	//if($sadmin == "1"){
	?>
	<?php //if($_SESSION[EWT_SMTYPE]!='Y'){?>
	<?php if($_SESSION["EWT_SMID"] == ''){?>
	 <tr  bgcolor="#FFFFFF"   > 
      <td > 
	  <!--<input type="checkbox" name="checkbox" value="checkbox" <?php //if($decho == "disabled"){ echo "checked disabled "; }else{ ?>onClick="chkdis(this,'suser','');"<?php//} ?> >-->
	  <!--input type="checkbox" name="checkbox" value="checkbox" <?php if($decho == "disabled"){ echo "checked"; }else{ ?>onClick="chkdis(this,'suser','');"<?php } ?> -->
	  <input type="checkbox" name="checkbox" value="checkbox" 
	  <?php if($decho == "disabled"){ echo "checked"; }
	   if($_SESSION["EWT_SMID"] == '' ){ ?> onClick="chkdis(this,'suser','');"<?php } ?>>
        <strong>Super admin </strong></td>
    </tr>
	<?php } ?>
    <?php
	//}
 $i=0;
  while($U = $db->db_fetch_array($sql)){
  $db->query("USE ".$EWT_DB_USER);
  $sql_sadmin = $db->query("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$U["p_code"]."' AND s_permission = '".$U["p_type"]."'  AND myFlag = '$myFlag' ");
  	if($db->db_num_rows($sql_sadmin) > 0){
		$check = "checked";
	}else{
		$check = "";
	}
	if(module_hidden($U["p_code"],$_SESSION["EWT_SUID"])==false){$hidden = 0;}else{$hidden = 1;}
	if($hidden){

  ?>
    <tr bgcolor="#FFFFFF" > 
      
      <td >&nbsp;&nbsp; <input type="checkbox" name="chk<?php echo $i; ?>" id="chk<?php echo $i; ?>" onClick="updates(this,'<?php echo $U["p_code"]; ?>','<?php echo $U["p_type"]; ?>','<?php echo $U["p_advance"]; ?>');" value="Y" <?php echo $decho;  ?> <?php echo $check;  ?> >
	  <?php if($U["p_advance"] != ""){ 
	  //echo "<a href=\"#advance\" onClick=\"if(document.form1.chk".$i.".checked == true){ advto('".$U["p_advance"]."'); }else{ advto(''); }\" >"; 
	  } ?>
	  <?php echo $U["p_name"]; ?>
	  <?php 
	  if($U["p_advance"] != ""){ 
	  //echo "</a>";
	  } 
	  ?> 
	  </td>
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
