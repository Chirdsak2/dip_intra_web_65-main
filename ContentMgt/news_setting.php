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
//$db->write_log("update","main","แก้ไข block 	link");
?>
<script language="JavaScript">
window.location.href = "news_setting.php?B=<?php echo $_POST["B"]; ?>";
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
  <form name="form1" method="post" action="news_setting.php">
    <input name="Flag" type="hidden" id="Flag" value="SET">
    <input name="B" type="hidden" id="B" value="<?php echo $_GET["B"]; ?>">
    <tr bgcolor="#E6E6E6"> 
      <td width="70%"><strong>Setting</strong></td>
    </tr>
    <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='F7F7F7'" onMouseOut="this.style.backgroundColor='FFFFFF'"> 
      <td> <input type="radio" name="selected" value="" <?php if($R[block_link] == ""){ echo "checked"; } ?> >
        ข่าว/บทความล่าสุด 5 อันดับ</td>
    </tr>
    <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='F7F7F7'" onMouseOut="this.style.backgroundColor='FFFFFF'"> 
      <td><input type="radio" name="selected" value="1" <?php if($R[block_link] == "1"){ echo "checked"; } ?>>
        ข่าว/บทความยอดนิยม 5 อันดับ</td>
    </tr>
	<tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='F7F7F7'" onMouseOut="this.style.backgroundColor='FFFFFF'"> 
      <td><input type="radio" name="selected" value="2" <?php if($R[block_link] == "2"){ echo "checked"; } ?>>
       ข่าว/บทความ ที่มีคะแนนโหวตสูงสุด 5 อันดับ</td>
    </tr>
    <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='F7F7F7'" onMouseOut="this.style.backgroundColor='FFFFFF'">
      <td><input type="submit" name="Submit" value="Save"></td>
    </tr>
  </form>
</table>
</body>
</html>
<?php }} ?>
<?php
$db->db_close(); ?>
