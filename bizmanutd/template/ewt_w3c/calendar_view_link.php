<?php
$path = "../";
	session_start();
	$start_time_counter = date("YmdHis");
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<title><?php echo $ewt_mytitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body >
<?
	$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";
	if($_GET[flag] == "img"){
?>
<table  border="0" cellpadding="1" cellspacing="1" bgcolor="#999999" align="center">
  <tr>
    <td bgcolor="#FFFFFF"><img src="<?=$Globals_Dir.$_GET[img_name]?>"></td>
  </tr>
</table>
<? }else{
	
	if(eregi("www.", $_GET[img_name]) || eregi("http://", $_GET[img_name])){
	$link = str_replace("http://","",$_GET[img_name]);
	print "<script>
			location.href = 'http://".$link."';
			</script>";
	}else{
	 if(ereg('calendar/',$_GET[img_name])){
	 $path = "../";
	 }
	print "<script>
			location.href = '". $path.$_GET[img_name]."';
			</script>";
	}
	
 }?>
</body>
</html>
<?php
$db->db_close(); ?>
