<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$ptype = "imgFo";
$ppms = "w";
$mid = $_GET["mid"];
$mtype  = $_GET["mtype"];
$UID = $_SESSION["EWT_SUID"];
$myFlag = $_GET["myFlag"];
$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/images";

$folder = base64_decode($_REQUEST["myfolder"]);

$Current_Dir = $Globals_Dir."/".$folder;
//echo $Current_Dir;
if (!(file_exists($Current_Dir))) {

$Current_Dir = $Globals_Dir;
}


//echo "SELECT p_id FROM permission WHERE p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' AND UID = '".$_SESSION["EWT_SUID"]."' AND ((s_type = '".$ptype."' AND s_permission = '".$ppms."'  AND s_id = '0' ) OR (s_type = 'suser'  )) ";
	  $sql_supadmin = $db->query_db("SELECT p_id FROM permission WHERE p_type = 'U'  AND UID = '".$_SESSION["EWT_SUID"]."' AND ((s_type = '".$ptype."' AND s_permission = '".$ppms."'  AND s_id = '0' ) OR (s_type = 'suser'  )) ",$EWT_DB_USER);
	/*if($db->db_num_rows($sql_supadmin) == 0){
	?>
	<script language="JavaScript">
	window.location.href ="blank.php";
	</script>
	<?php
	exit;
	}*/
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
	var	url='ewt_upd_ajax.php?UID=<?php echo $UID; ?>&mid=<?php echo $mid; ?>&mtype=<?php echo $mtype; ?>&myFlag=<?php echo $myFlag; ?>&accept=Y&ptype=<?php echo $ptype; ?>&ppms=<?php echo $ppms; ?>&psname=' + gid;
	}else{
	var	url='ewt_upd_ajax.php?UID=<?php echo $UID; ?>&mid=<?php echo $mid; ?>&mtype=<?php echo $mtype; ?>&myFlag=<?php echo $myFlag; ?>&accept=N&ptype=<?php echo $ptype; ?>&ppms=<?php echo $ppms; ?>&psname=' + gid ;
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
}function chkdis(c,gid,start,len){
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
<body leftmargin="0" topmargin="0">
<span id="divhtml" style="display:none"></span>
<table width="100%" border="0">
<tr>
    <td class="ewtsubmenu">หมายเหตุ: การกำหนดสิทธิ์ของ My Gallery ท่านสามารถกำหนดได้ใน folder ระดับที่ 1 เท่านั้น</td>
  </tr>
  <tr>
    <td class="ewtsubmenu">&nbsp;</td>
  </tr>
  <tr>
    <td class="ewtsubmenu"><strong>My Gallery </strong></td>
  </tr>
<?php

$array_folder = array();
$objFolder = opendir($Current_Dir);
rewinddir($objFolder);
$f = 0;
			  while($file = readdir($objFolder)){
			  if(!(($file == ".") or ($file == "..") or ($file == "Thumbs.db") )){
			  $FT= filetype($Current_Dir."/".$file);
			  if($FT == "dir"){
			  array_push ($array_folder,$file);
			  }else{
			  $array_file[$f][0] = $file;
			$f++;
			  }
			  }
			  }
			  closedir($objFolder);
 $numfolder = count($array_folder);
 
 
 
  $sql_sadmin = $db->query_db("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = '".$ppms."'  AND s_id = '0' AND s_name = '0' AND myFlag = '$myFlag' ",$EWT_DB_USER);
	if($db->db_num_rows($sql_sadmin) > 0){
		$decho = "disabled";
		$check = "checked";
	}else{
		$decho = "";
		$check = "";
	}
 
?>
<?php if($db->check_permission("imgFo","w","")){ 	?>
  <tr>
    <td><img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">&nbsp; <input type="checkbox" name="chk0" id="chk<?php echo $i; ?>" value="0"  <?php echo $check;  ?> onClick="chkdis(this,'0',0,<?php echo  $numfolder; ?>);">
        <strong>All folder</strong></td>
  </tr>
  <?php }?>
    <?php
$i=1;
	for($y=0;$y<$numfolder;$y++){
			if($folder != ""){
			$preview_path = $folder."/".$array_folder[$y];
			}else{
			$preview_path = $array_folder[$y];
			}
			$preview_path_en = base64_encode($preview_path);
			
			 $sql_sadmin = $db->query_db("SELECT * FROM permission1 WHERE p_type = '$mtype' AND pu_id = '$mid' AND UID = '$UID' AND s_type = '".$ptype."' AND s_permission = '".$ppms."'  AND s_id = '0'  AND s_name = '".$array_folder[$y]."' AND myFlag = '$myFlag' ",$EWT_DB_USER);
  	if($db->db_num_rows($sql_sadmin) > 0){
		$check = "checked";
	}else{
		$check = "";
	}
	?>
	<?php if($db->check_permission("imgFo","w","".$array_folder[$y]."")){ 	?>
  <tr>
    <td><img src="../images/o.gif" width="20" height="20" border="0" align="absmiddle"><img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">&nbsp; <input type="checkbox" name="chk<?php echo $i; ?>" id="chk<?php echo $i; ?>" onClick="chkdis(this,'<?php echo $array_folder[$y]; ?>',<?php echo $i; ?>,0);" value="<?php echo $array_folder[$y]; ?>" <?php echo $decho;  ?> <?php echo $check;  ?>>
	  <?php echo $array_folder[$y]; ?></td>
  </tr>
  <?php } ?>
  <?php
 $i++; }
  ?>
</table>
</body>

