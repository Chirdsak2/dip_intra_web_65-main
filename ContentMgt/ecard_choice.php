<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
if($_POST[flag] == 'set'){
$bcode = base64_decode($_POST["B"]);
$bid_a = explode("z",$bcode);
$BID = $bid_a[1];
if($_POST[choice] == '1'){
	$_POST["selected"] = $_POST[choice].'@'.$_POST[txtrow].'@'.$_POST[txtcol];
}
$db->query("UPDATE block SET block_link = '".$_POST["selected"]."' WHERE BID = '".$BID."' ");
$db->write_log("update","main","แก้ไข block E Card ");
?>
<script language="JavaScript">
<?php if($_POST[choice] == '1'){?>
window.location.href = "ecard_choice.php?B=<?php echo $_POST["B"]; ?>";
<?php }  ?>
</script>
<?php
exit;
}
//chc
$bcode = base64_decode($_GET["B"]);
$bid_a = explode("z",$bcode);
$BID = $bid_a[1];
//echo "SELECT * FROM block WHERE BID = '".$BID."'";
$sql_file = $db->query("SELECT * FROM block WHERE BID = '".$BID."'");
$R = $db->db_fetch_array($sql_file);
$choice = explode('@',$R[block_link]); 
//print_r($choice);
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<form action="" method="post" enctype="multipart/form-data" name="form">
<input name="flag" type="hidden" value="set">
<input name="B" type="hidden" id="B" value="<?php echo $_GET["B"]; ?>">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1">
    <tr>
      <td class="ewtfunction">เลือกรูปแบบที่ต้องการ....</td>
    </tr>
    
    <tr>
      <td>&nbsp;</td>
    </tr>  
  <tr> 
    <td><input name="choice" type="hidden" value="1" >
      การแสดงผลแบบ[Row * Columns] 
        <input name="txtrow" type="text" value="<?php if($choice[1] != '' && $choice[0]== '1'  ){ echo $choice[1];}else{ echo '4';} ?>" size="5" maxlength="3">
      * 
      <input name="txtcol" type="text" value="<?php if($choice[2] != ''  && $choice[0]== '1' ){ echo $choice[2];}else{ echo '4';} ?>" size="5" maxlength="3"> 
      แถว </td>
  </tr>
  
    <tr>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td align="center"><input type="submit" name="Submit" value="บันทึก"></td>
    </tr>
</table></form>
</body>
</html>
<?php
$db->db_close(); ?>
