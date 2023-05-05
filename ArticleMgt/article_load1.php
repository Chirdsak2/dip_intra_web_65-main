<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);

$dbq = $db->query("SELECT UID,db_db FROM user_info WHERE EWT_User = '".$_GET["usr"]."'");
$D = $db->db_fetch_array($dbq);
$sql_check = $db->query("SELECT c_id FROM share_article WHERE user_s = '".$_SESSION["EWT_SUSER"]."' AND user_t = '".$_GET["usr"]."' AND n_id = '".$_GET["nid"]."'  ");

	$gr = array();
	while($G = $db->db_fetch_array($sql_check)){
		array_push ($gr,$G["c_id"]);
	}
$db->query("USE ".$D[1]);
function GenPic($data){
	for($i=0;$i<$data;$i++){
		echo "<img src=\"../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
	}
}
function child($c,$x,$decho){
global $db,$i,$txt,$gr;
$y = $x+1;
$sql = $db->query("SELECT * FROM article_group WHERE c_parent = '$c' ORDER BY c_id ASC ");
  while($U = $db->db_fetch_array($sql)){
  ?>
    <tr bgcolor="#FFFFFF" > 
      <td > <img src="../images/o.gif" width="20" height="20" border="0" align="absmiddle"><?php GenPic($y); ?><input type="checkbox" name="use" value="<?php echo $decho."_".$U['c_id']; ?>" <?php if(in_array ($U['c_id'],$gr)){ echo "checked"; } ?>>
	  
	  <?php if($y>=1 and $y<10){?>
			<img src="../images/folder_closed<?php echo $y;?>.gif" width="16" height="16" border="0" align="absmiddle">
	  <?php }else{?>
			<img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">
	  <?php }?>
	  
	  <?php echo $U["c_name"]; ?></td>
    </tr>
    <?php
	$i++; 
	child($U["c_id"],$y,$decho);
  }
}
$sql = $db->query("SELECT * FROM article_group WHERE c_parent = '0' ORDER BY c_id ASC ");
	?>
<html>
<head>
<title>Article Management</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body leftmargin="0" topmargin="0" id="box">
<table width="95%" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC">
<?php
if($db->db_num_rows($sql) > 0){
while($R = $db->db_fetch_array($sql)){
?><tr bgcolor="#FFFFFF" > 
      <td ><input type="checkbox" name="use" value="<?php echo $D[0]."_".$R['c_id']; ?>" <?php if(in_array ($R['c_id'],$gr)){ echo "checked"; } ?>> <img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle"><?php echo $R[c_name]; ?>
	  	  </td>
    </tr>
<?php
child($R["c_id"],0,$D[0]);
}
}else{
echo "<div><font color=red>-- No data.</font></div>";
}
?>
</table>
</body>
</html>
<script language="JavaScript">
self.parent.document.all.tdview<?php echo $_GET["id"]; ?>.innerHTML = document.all.box.innerHTML;
</script>
<?php $db->db_close(); ?>
