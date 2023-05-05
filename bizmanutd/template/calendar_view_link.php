<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<?php
	$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";
	if($_GET[flag] == "img"){
?>
<table  border="0" cellpadding="1" cellspacing="1" bgcolor="#999999" align="center">
  <tr>
    <td bgcolor="#FFFFFF"><img src="<?php echo $Globals_Dir.$_GET[img_name]?>"></td>
  </tr>
</table>
<?php }else{
	
	if(eregi("www.", $_GET[img_name]) || eregi("http://", $_GET[img_name])){
	$link = str_replace("http://","",$_GET[img_name]);
	print "<script>
			location.href = 'http://".$link."';
			</script>";
	}else{
	print "<script>
			location.href = '".$_GET[img_name]."';
			</script>";
	}
	
 }?>
</body>
</html>
<?php
$db->db_close(); ?>
