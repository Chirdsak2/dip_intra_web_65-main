<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
                 "'<[\/\!]*?[^<>]*?>'si",           // Strip out html tags
                 "'([\r\n])[\s]+'",                 // Strip out white space
                 "'&(quot|#34);'i",                 // Replace html entities
                 "'&(amp|#38);'i",
                 "'&(lt|#60);'i",
                 "'&(gt|#62);'i",
                 "'&(nbsp|#160);'i",
                 "'&(iexcl|#161);'i",
                 "'&(cent|#162);'i",
                 "'&(pound|#163);'i",
                 "'&(copy|#169);'i",
                 "'&#(\d+);'e");                    // evaluate as php

$replace = array ("",
                  "",
                  "\\1",
                  "\"",
                  "&",
                  "<",
                  ">",
                  " ",
                  chr(161),
                  chr(162),
                  chr(163),
                  chr(169),
                  "chr(\\1)");


if($_POST["Flag"] == "SET"){
$bcode = base64_decode($_POST["B"]);
$bid_a = explode("z",$bcode);
$BID = $bid_a[1];
$db->query("UPDATE block SET block_link = '".$_POST["selected"]."' WHERE BID = '".$BID."' ");
$db->write_log("update","main","แก้ไข block Survey ");
?>
<script language="JavaScript">
window.location.href = "survey_list.php?B=<?php echo $_POST["B"]; ?>";
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
$block_name=$R['block_name'];
$BLink=$R[block_link];
$sql_menu = $db->query("SELECT s_id,s_title FROM p_survey WHERE s_approve = 'Y' ORDER BY s_id ASC ");
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
<form name="form1" method="post" action="survey_list.php">
 <input name="Flag" type="hidden" id="Flag" value="SET">
        <input name="B" type="hidden" id="B" value="<?php echo $_GET["B"]; ?>">
        <input type="hidden" name="selected">
</form>
  <tr bgcolor="#E6E6E6"> 
    <td width="70%"><strong>Form Generator list</strong></td>
    <td width="30%" align="center"><strong>Apply to WebBlock</strong></td>
  </tr>
  <?php
		if($db->db_num_rows($sql_menu) > 0){
		while($R=$db->db_fetch_array($sql_menu)){
		?>
  <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='F7F7F7'" onMouseOut="this.style.backgroundColor='FFFFFF'"> 
    <td>
	<?php if($R["s_id"]==$BLink){ ?>
	<img src="../theme/main_theme/g_select.gif" width="16" height="16" border="0" align="absmiddle">
	<?php }else{?>
	<img src="../theme/main_theme/blank.gif" width="16" height="16" border="0" align="absmiddle">
	<?php }?><?php echo preg_replace ($search, $replace, $R["s_title"]); ?> </td>
    <td align="center"><a href="#select" onClick="selectG('<?php echo $R["s_id"]; ?>');">Apply</a></td>
  </tr>
  <?php
		}
		}else{
		?>
  <tr align="center" bgcolor="#FFFFFF"> 
    <td colspan="2"><strong><font color="#FF0000">Form Generator not found.</font></strong></td>
  </tr>
  <?php } ?>
</table>
</body>
</html>
<?php }} ?>
<?php
$db->db_close(); ?>
