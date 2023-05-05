<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

if($_POST["Flag"] == "SET"){
$bcode = base64_decode($_POST["B"]);
$bid_a = explode("z",$bcode);
$BID = $bid_a[1];
$db->query("UPDATE block SET block_link = '".$_POST["selected"]."' WHERE BID = '".$BID."' ");
$db->write_log("update","main","แก้ไข block Vdo ");
?>
<script language="JavaScript">
window.location.href = "vdo_list.php?B=<?php echo $_POST["B"]; ?>";
//self.close();
</script>
<?php
}else{
$bcode = base64_decode($_GET["B"]);
$bid_a = explode("z",$bcode);
$BID = $bid_a[1];
$sql_file = $db->query("SELECT block_name,block_link FROM block WHERE BID = '".$BID."'");
if($db->db_num_rows($sql_file) == 1){
$R = $db->db_fetch_array($sql_file);
$BLink=$R[block_link];
$sql_vdo = $db->query("SELECT * FROM vdo_group ORDER BY vdog_id ASC ");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function selectG(c){
document.form1.selected.value = c;
form1.submit(); 
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
<form name="form1" method="post" action="vdo_list.php">
 <input name="Flag" type="hidden" id="Flag" value="SET">
        <input name="B" type="hidden" id="B" value="<?php echo $_GET["B"]; ?>">
        <input type="hidden" name="selected">
</form>
  <tr bgcolor="#E6E6E6"> 
    <td width="70%"><strong>Vdo name</strong></td>
    <td width="30%" align="center"><strong>Apply to WebBlock</strong></td>
  </tr>
  <?php
		if($db->db_num_rows($sql_vdo) > 0){
		while($R=$db->db_fetch_array($sql_vdo)){
		
			$x=explode(',',$BLink);
			$BLink=$x[0];
			//$BVDO_WIDTH=$x[1]; $BVDO_HEIGHT=$x[2]; $BVDO_PLAY=$x[3];
		?>
  <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='F7F7F7'" onMouseOut="this.style.backgroundColor='FFFFFF'"> 
    <td>
	<?php if($R["vdog_id"]==$BLink){ ?>
	<img src="../theme/main_theme/g_select.gif" width="16" height="16" border="0" align="absmiddle">
	<?php }else{?>
	<img src="../theme/main_theme/blank.gif" width="16" height="16" border="0" align="absmiddle">
	<?php }?> <?php echo $R["vdog_name"]; ?></td>
    <td align="center"><a href="#select" onClick="selectG('<?php echo $R["vdog_id"]; ?>');">Apply</a></td>
  </tr>
  <?php
		}
		}else{
		?>
  <tr align="center" bgcolor="#FFFFFF"> 
    <td colspan="2"><strong><font color="#FF0000">Vdo not found.</font></strong></td>
  </tr>
  <?php } ?>
</table>
</body>
</html>
<?php }} ?>
<?php
$db->db_close(); ?>
