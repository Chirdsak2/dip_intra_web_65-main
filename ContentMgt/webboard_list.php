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
$txt = "";
	for($i=0;$i<$_POST["alli"];$i++){
		$chk = $_POST["chk".$i];
		if($chk != ""){
			$txt .= $chk."_";
		}
	}

$db->query("UPDATE block SET block_link = '".$txt."' WHERE BID = '".$BID."' ");
$db->write_log("update","main","แก้ไข block webboard ");
?>
<script language="JavaScript">
window.location.href = "webboard_list.php?B=<?php echo $_POST["B"]; ?>";
//self.close();
</script>
<?php
}else{
$bcode = base64_decode($_GET["B"]);
$bid_a = explode("z",$bcode);
$BID = $bid_a[1];
$sql_file = $db->query("SELECT block_name,block_link FROM block WHERE BID = '".$BID."'");
if($db->db_num_rows($sql_file) == 1){
$RR= $db->db_fetch_array($sql_file);
$bo_id = explode('_',$RR[block_link]);
$sql_menu = $db->query("SELECT c_id,c_name FROM w_cate WHERE c_use = 'Y' ORDER BY c_name ASC ");
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
<form name="form1" method="post" action="webboard_list.php">
 <input name="Flag" type="hidden" id="Flag" value="SET">
        <input name="B" type="hidden" id="B" value="<?php echo $_GET["B"]; ?>">
  <tr bgcolor="#E6E6E6"> 
    <td width="70%"><strong>Webboard category</strong></td>
    <td width="30%" align="center"><strong>Apply to WebBlock</strong></td>
  </tr>
  <?php
		if($db->db_num_rows($sql_menu) > 0){
		$i=0;
		while($R=$db->db_fetch_array($sql_menu)){
		$chk ='';
		for($g=0;$g<count($bo_id);$g++){
			if ($bo_id[$g] == $R["c_id"]){ $chk = 'checked';}
		}
		
		?>
  <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='F7F7F7'" onMouseOut="this.style.backgroundColor='FFFFFF'"> 
    <td><img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
      <?php echo $R["c_name"]; ?> </td>
    <td align="center">
        <input type="checkbox" name="chk<?php echo $i; ?>" value="<?php echo $R["c_id"]; ?>" <?php echo $chk;?> >
	</td>
  </tr>
  <?php
	$i++;	}
		?>
		
    <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='F7F7F7'" onMouseOut="this.style.backgroundColor='FFFFFF'"> 
      <td>&nbsp;</td>
      <td align="center"><strong><font color="#FF0000"> 
        <input type="submit" name="Submit" value="Submit">
        <input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>">
        </font></strong></td>
  </tr>
	<?php	}else{ ?>
		<tr align="center" bgcolor="#FFFFFF"> 
    <td colspan="2"><strong><font color="#FF0000">Webboard category not found.</font></strong></td>
  </tr>
  <?php } ?>
  </form>
</table>
</body>
</html>
<?php }} ?>
<?php
$db->db_close(); ?>
