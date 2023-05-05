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
$block_link = $_POST["selected"];
	if($_POST["txt_showt"] == '' || $_POST["txt_showt"] =='0'){
		$_POST["txt_showt"] = '1';
	}
	$block_link .= "##".$_POST["txt_showt"];
	/*if($_POST["hi_b"] == '' || $_POST["hi_b"] =='0'){
		$_POST["hi_b"] = '50';
	}*/
	$block_link .= "##".$_POST["hi_b"];
	/*if($_POST["wi_b"] == '' || $_POST["wi_b"] =='0'){
		$_POST["wi_b"] = '50';
	}*/
	$block_link .= "##".$_POST["wi_b"];

	if($_POST["SH"] == '' || $_POST["SH"] =='0'){
		$_POST["SH"] = 'U';
	}
	$block_link .= "##".$_POST["SH"];
$db->query("UPDATE block SET block_link = '".$block_link."' WHERE BID = '".$BID."' ");
$db->write_log("update","main","แก้ไข E-Book");
?>
<script language="JavaScript">
//window.location.href = "content_graph.php?graph_id=<?php echo $_POST["selected"]; ?>&B=<?php echo $_POST["B"]; ?>";
window.location.href = "ebook_list.php?B=<?php echo $_POST["B"]; ?>";
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
$block_link = explode('##',$R["block_link"]);
$block_link_1 = $block_link[0];
$block_link_2 = $block_link[1];
$block_link_3 = $block_link[2];
$block_link_4 = $block_link[3];
$block_link_5 = $block_link[4];

$sql_menu = $db->query("SELECT * FROM ebook_group WHERE g_ebook_status='Y' ORDER BY g_ebook_name ASC ");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function selectG(c){
document.form1.selected.value = c;
//form1.submit(); 
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
<form name="form1" method="post" action="ebook_list.php">
 <input name="Flag" type="hidden" id="Flag" value="SET">
        <input name="B" type="hidden" id="B" value="<?php echo $_GET["B"]; ?>">
        <input type="hidden" name="selected" value="<?php echo $block_link_1;?>">

 <tr bgcolor="#E6E6E6"> 
    <td width="100%"><strong>ตั้งค่ารายการ E-Book เพิ่มเติม</strong></td>
  </tr>
    <tr bgcolor="#FFFFFF"> 
    <td colspan="2"><strong>กำหนดการแสดงข้อมูล</strong> : แสดง
      <input name="txt_showt" type="text"  size="5" maxlength="2" value="<?php echo $block_link_2;?>">
      รายการล่าสุด</td>
  </tr>
  
    <tr bgcolor="#FFFFFF">
      <td colspan="2"><STRONG>กำหนดขนาดภาพ</STRONG> : 
      Height:
        <INPUT id="hi_b" size="2" name="hi_b" value="<?php if($block_link_3 != ''){ echo $block_link_3;}?>">
Width:
<INPUT id="wi_b" size="2" name="wi_b" value="<?php if($block_link_4 != ''){ echo $block_link_4;}?>"></td>
    </tr>
    <tr bgcolor="#FFFFFF">
      <td colspan="2"><strong>กำหนดการแสดงผล</strong> : 
      <input name="SH" type="radio" value="U" <?php if($block_link_5=='U'){ echo 'checked';}else if($block_link_5 == ''){ echo 'checked';}?> >
      ข้อความอยู่ใต้ภาพ 
      <input name="SH" type="radio" value="R" <?php if($block_link_5=='R'){ echo 'checked';}?>>
      ข้อความอยู่ทางด้านขาวของภาพ</td>
    </tr>
  </form>
  <tr bgcolor="#E6E6E6"> 
    <td width="100%"><strong>รายการ E-Book</strong></td>
  </tr>
   <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='F7F7F7'" onMouseOut="this.style.backgroundColor='FFFFFF'"> 
    <td><input type="radio" name="chks"  value="" <?php if($block_link_1==''){?>checked<?php }?> onClick="if(this.checked){selectG('');}else{selectG('')}"> แสดงหน้าค้นหา E-Book</td>
  </tr>
  <?php
		if($db->db_num_rows($sql_menu) > 0){
			while($R2=$db->db_fetch_array($sql_menu)){
			    $g=$R2[g_ebook_id];
				$gid=$g.'@C';
				?>
			  <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='F7F7F7'" onMouseOut="this.style.backgroundColor='FFFFFF'"> 
				<td><input type="radio" name="chks" value="<?php echo $gid; ?>"  <?php if($block_link_1== $gid){?>checked<?php }?> onClick="if(this.checked==true){selectG('<?php echo $gid; ?>');}else{selectG('')}"> <?php echo $R2["g_ebook_name"]; ?> </td>
			  </tr>
  			<?php
			  $sql_menu2 = $db->query("SELECT * FROM ebook_info WHERE show_status='Y' and g_ebook_id='$R2[g_ebook_id]' ORDER BY ebook_name ASC ");
			  if($db->db_num_rows($sql_menu2) > 0){
					while($R3=$db->db_fetch_array($sql_menu2)){
						$g2=$R3[ebook_id];
						$gid2=$g2.'@B';
					?>
					  <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='F7F7F7'" onMouseOut="this.style.backgroundColor='FFFFFF'"> 
						<td>&nbsp; &nbsp; &nbsp; <input type="radio" name="chks" value="<?php echo $gid2; ?>"  <?php if($block_link_1== $gid2){?>checked<?php }?> onClick="if(this.checked==true){selectG('<?php echo $gid2; ?>');}else{selectG('')}"> <?php echo $R3["ebook_name"]; ?> </td>
					  </tr>
					<?php  }
			  }
		}
		}else{
		?>
  <tr align="center" bgcolor="#FFFFFF"> 
    <td colspan="2"><strong><font color="#FF0000">ไม่พบรายการ E-Book</font></strong></td>
  </tr>
  <?php } ?>
</table>
<?php if($db->db_num_rows($sql_menu) > 0){?><br><center><input type="button" value="บันทึก" onClick="form1.submit();"> </center><?php } ?>
</body>
</html>
<?php }} ?>
<?php
$db->db_close(); ?>
