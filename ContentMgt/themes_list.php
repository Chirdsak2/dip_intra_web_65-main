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
$db->query("UPDATE block SET block_themes = '".$_POST["selected"]."', block_name='".$_POST['hdBlockName']."' WHERE BID = '".$BID."' ");
$db->write_log("update","main","แก้ไข block ");
?>
<script language="JavaScript">
//window.location.href = "banner_tool.php?banner_gid=<?php//php echo $_POST["selected"]; ?>&B=<?php//php echo $_POST["B"]; ?>";
top.self.close();
</script>
<?php
exit;
}else{
$bcode = base64_decode($_GET["B"]);
$bid_a = explode("z",$bcode);
$BID = $bid_a[1];
$sql_file = $db->query("SELECT block_name,block_link,block_themes FROM block WHERE BID = '".$BID."'");
if($db->db_num_rows($sql_file) == 1){
$R = $db->db_fetch_array($sql_file);
$block_name=$R['block_name'];
$BLink=$R[block_themes];
$sql_themes = $db->query("SELECT themes_id,themes_name FROM themes ORDER BY themes_name ASC ");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function selectG(c){
document.form1.selected.value = c;
document.form1.hdBlockName.value = document.getElementById('block_name').value;
form1.submit(); 
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
<form name="form1" method="post" action="themes_list.php">
 <input name="Flag" type="hidden" id="Flag" value="SET">
        <input name="B" type="hidden" id="B" value="<?php echo $_GET["B"]; ?>">
		<input name="hdBlockName" type="hidden" id="hdBlockName" value="">
        <input type="hidden" name="selected">
</form>
  <tr bgcolor="#E6E6E6"> 
    <td width="50%"><strong>Theme Design for block </strong></td>
    <td width="20%" align="center"><strong>View Theme Design </strong></td>
    <td width="30%" align="center"><strong>Apply to WebBlock</strong></td>
  </tr>
  <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='F7F7F7'" onMouseOut="this.style.backgroundColor='FFFFFF'"> 
   <td>
	<?php if($BLink==''){ ?>
	<img src="../theme/main_theme/g_select.gif" width="16" height="16" border="0" align="absmiddle">
	<?php }else{?>
	<img src="../theme/main_theme/blank.gif" width="16" height="16" border="0" align="absmiddle">
	<?php }?>No use theme </td>
    <td align="center">-</td>
    <td align="center"><a href="#select" onClick="selectG('');">Apply</a></td>
  </tr>
  <?php
		if($db->db_num_rows($sql_themes) > 0){
		while($R=$db->db_fetch_array($sql_themes)){
		 $Current_Dir1 = "../ewt/".$_SESSION["EWT_SUSER"]."/";
		?>
  <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='F7F7F7'" onMouseOut="this.style.backgroundColor='FFFFFF'"> 
    <td>
	<?php if($R["themes_id"]==$BLink){ ?>
	<img src="../theme/main_theme/g_select.gif" width="16" height="16" border="0" align="absmiddle">
	<?php }else{?>
	<img src="../theme/main_theme/blank.gif" width="16" height="16" border="0" align="absmiddle">
	<?php }?><?php echo $R["themes_name"]; ?> </td>
    <td align="center"><a href="#" onClick="window.open('<?php echo $Current_Dir1; ?>theme_view.php?themes_id=<?php echo $R[themes_id]; ?>', 'themes_view', 'status=yes, menubar=no, scrollbars=yes, resizable=yes, height=450, width=600, left=150,top=100');">View</a></td>
    <td align="center"><a href="#select" onClick="selectG('<?php echo $R["themes_id"]; ?>');">Apply</a></td>
  </tr>
  <?php
		}
		}else{
		?>
  <tr align="center" bgcolor="#FFFFFF"> 
    <td colspan="3"><strong><font color="#FF0000">Theme Design for block  not found.</font></strong></td>
  </tr>
  <?php } ?>
  <tr align="center" bgcolor="#FFFFFF"> 
    <td colspan="3" align="left"><img src="../theme/main_theme/blank.gif" width="16" height="16" border="0" align="absmiddle">Block name : <input type="text" name="block_name" id="block_name" value="<?php echo $block_name; ?>"></td>
  </tr>
</table>
</body>
</html>
<?php }} ?>
<?php
$db->db_close(); ?>
