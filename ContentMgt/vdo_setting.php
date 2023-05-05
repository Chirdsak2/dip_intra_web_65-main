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
		
		$links = $_POST["selected"].','.$_POST["vdo_width"].','.$_POST["vdo_height"].','.$_POST["vdo_play"].','.$_POST["txt_vdolist"];
		$db->query("UPDATE block SET block_link = '$links' WHERE BID = '$BID' ");
		$db->write_log("update","main","แก้ไข block Vdo ");
		?>
		<script language="JavaScript">
		window.location.href = "vdo_list.php?B=<?php echo $_POST["B"]; ?>";
		//self.close();
		</script>
<?php }else{
		$bcode = base64_decode($_GET["B"]);
		$bid_a = explode("z",$bcode);
		$BID = $bid_a[1];
		$sql_file = $db->query("SELECT block_name,block_link FROM block WHERE BID = '".$BID."'");
		if($db->db_num_rows($sql_file) == 1){
			$R = $db->db_fetch_array($sql_file);
			
			$x=explode(',',$R[block_link]);
			$BLink=$x[0];
			$BVDO_WIDTH=$x[1];
			$BVDO_HEIGHT=$x[2];
			$BVDO_PLAY=$x[3];
			$BVDO_VDOLIST=$x[4];
			$sql_vdo = $db->query("SELECT * FROM vdo_group WHERE vdog_id= '$BLink' ");
			$R=$db->db_fetch_array($sql_vdo)
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
<table width="70%" border="0" cellpadding="3" cellspacing="1" bgcolor="#666666">
<form name="form1" method="post" action="vdo_setting.php">
 		<input name="Flag" type="hidden" id="Flag" value="SET">
        <input name="B" type="hidden" id="B" value="<?php echo $_GET["B"]; ?>">
        <input type="hidden" name="selected" value="<?php echo $R["vdog_id"]; ?>">
  <tr bgcolor="#E6E6E6"> 
    <td width="25%" colspan="2"><strong>ตั้งค่าการแสดงผล</strong></td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td width="25%"><strong>ขนาด</strong></td>
    <td width="30%" >
	<input type="text" size="5" name="vdo_width" value="<?php echo $BVDO_WIDTH; ?>"> x
	<input type="text" size="5" name="vdo_height" value="<?php echo $BVDO_HEIGHT; ?>"> (กว้าง x สูง)</td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td width="25%"><strong>รูปแบบการแสดง</strong></td>
    <td width="30%" >
	<input type="radio" name="vdo_play" value="Y" <?php if($BVDO_PLAY=='Y' or $BVDO_PLAY==''){?>checked<?php }?>> เล่นอัตโนมัติ<br>
	<input type="radio" name="vdo_play" value="N" <?php if($BVDO_PLAY=='N'){?>checked<?php }?>> ปกติ<br></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td><strong>จำนวนวีดีโอที่แสดง</strong></td>
    <td width="30%" ><input name="txt_vdolist" type="text" id="txt_vdolist" size="4" value="<?php echo $BVDO_VDOLIST; ?>"> 
      รายการ </td>
  </tr>
    <tr bgcolor="#E6E6E6"> 
    <td width="25%" colspan="2" align="center"><input type="submit" value="บันทึก"></td>
  </tr>
</form>
</table>
</body>
</html>
<?php }}?>
<?php $db->db_close(); ?>
