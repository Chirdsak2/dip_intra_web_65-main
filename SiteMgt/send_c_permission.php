<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
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
	 <tr bgcolor="#FFFFFF" > 
		
      <td ><strong>กำหนดสิทธิ์</strong> 
        <hr size="1"></td>
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
  ?>
    <tr bgcolor="#FFFFFF" > 
      
      <td >&nbsp;&nbsp; <input type="checkbox" name="chk<?php echo $i; ?>" id="chk<?php echo $i; ?>"  value="Y" >
        <?php echo $U["p_name"]; ?> 
        <?php if($U["p_advance"] != ""){ ?>
        <?php } ?>
        <input name="p" type="hidden" id="p"> </td>
    </tr>
    <?php 
	$i++;
  }
  ?>
  <tr bgcolor="#FFFFFF" > 
		<td align="center" ><hr size="1">
        <input type="submit" name="Submit" value="Submit"> </td>
    </tr>
  <input type="hidden" name="numrow" value="<?php echo $i; ?>"></form>
  </table>
</body>
</html>
<?php
$db->db_close();
?>
