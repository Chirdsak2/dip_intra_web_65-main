<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
if($_POST[Flag]=='config'){
//clear data for add data new
$delete = "DELETE FROM web_config_module WHERE UID = '".$_POST[UID]."'";
$db->query($delete);
	for($i=0;$i<$_POST[num_row];$i++){
		if($_POST["pcode".$i]!=''){
			$insert = "INSERT INTO web_config_module (UID,p_code) VALUES ( '".$_POST[UID]."' , '".$_POST["pcode".$i]."')";
			$db->query($insert);
		}
	}
			?>
				<script language="JavaScript">
				alert("บันทึกข้อมูลเรียบร้อยแล้ว!!");
				window.close();
				</script>
				<?php
				exit;
}

?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<form name="form1" method="post" action="ewt_permission1.php">
<table width="94%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><span class="ewtfunction">รายชื่อ Module </span></td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">
<hr>
    </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
    <td width="5%" height="30" align="center">&nbsp;</td>
    <td width="49%" >ชื่อmodule</td>
    <td width="46%" align="center" >เลือกmoduleที่ไม่ต้องการให้แสดง</td>
  </tr>
  <?php
  $query  = $db->query("select * from web_permission where p_status ='Y' and p_type = 'w'");
  $i = 1;
  $x=0;
  while($rec=$db->db_fetch_array($query)){
		$sql_web = $db->query("select * from web_config_module where UID = '".$_GET[UID]."' and p_code ='".$rec[p_code]."'");
		
		
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td align="center" valign="top"><?php echo $i++;?></td>
    <td valign="top"><?php echo $rec[p_name]; ?></td>
    <td align="center"><input type="checkbox" name="pcode<?php echo $x++;?>" value="<?php echo $rec[p_code]; ?>" <?php  if($db->db_num_rows($sql_web) > 0){ echo 'checked';}?>></td>
  </tr>
  
  <?php 
  }
  ?> 
  <tr bgcolor="#FFFFFF">
    <td colspan="3" align="center" valign="top"><input type="submit" name="Submit" value="บันทึก">
	<input name="num_row" type="hidden" value="<?php echo $x;?>">
	<input name="UID" type="hidden" value="<?php echo $_GET[UID];?>">
	<input name="Flag" type="hidden" value="config"></td>
    </tr>
  <?php
  if($db->db_num_rows($query)==0){
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td height="30" colspan="3" align="center"><font color="#FF0000">ไม่มีข้อมูลการกำหนดสิทธิ์</font></td>
  </tr>
  <?php } ?>
</table>

</form>
<br>
</body>
</html>
<?php
$db->db_close(); ?>