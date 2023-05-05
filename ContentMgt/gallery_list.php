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
$delete =  "DELETE FROM gallery_tmp_cat_img WHERE tmp_id ='".$BID."' ";
$db->query($delete);
for($i=0;$i<count($_POST[selected]);$i++){
$sql_update="INSERT INTO gallery_tmp_cat_img (tmp_id,category_id) VALUES('".$BID."','".$_POST[selected][$i]."')";
$db->query($sql_update);
}
$db->write_log("update","main","แก้ไข block Gallery category ");
?>
<script language="JavaScript">
//window.location.href = "content_graph.php?graph_id=<?php//php echo $_POST["selected"]; ?>&B=<?php//php echo $_POST["B"]; ?>";
window.location.href = "gallery_list.php?B=<?php echo $_POST["B"]; ?>";
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
$sql_menu = $db->query("SELECT * FROM gallery_category ORDER BY category_parent_id ASC ");
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
<form name="form1" method="post" action="gallery_list.php">
 <input name="Flag" type="hidden" id="Flag" value="SET">
 <input name="B" type="hidden" id="B" value="<?php echo $_GET["B"]; ?>">
  <tr bgcolor="#E6E6E6"> 
    <td width="70%"><strong>Gallery category name</strong></td>
    <td width="30%" align="center"><strong>Apply to WebBlock</strong></td>
  </tr>
  <?php
  			function GenPic($data){
				for($i=0;$i<=$data;$i++){
					echo "<img src=\"../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
				}
			}
		if($db->db_num_rows($sql_menu) > 0){
		while($R=$db->db_fetch_array($sql_menu)){
		//chk to tb  gallery_tmp_cat_img
		$sql_chk = $db->query("select * from gallery_tmp_cat_img where tmp_id ='".$BID."' and category_id ='".$R["category_id"]."' ");
		if($db->db_num_rows($sql_chk) > 0){
		$checked = 'checked';
		}else{
		$checked = '';
		}
		$child = explode('_',$R[category_parent_id]);
		$b = (count($child)-1);
		?>
  <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='F7F7F7'" onMouseOut="this.style.backgroundColor='FFFFFF'"> 
    <td>
	<?php if($R["category_id"]==$BLink){ ?>
	<img src="../theme/main_theme/g_select.gif" width="16" height="16" border="0" align="absmiddle">
	<?php }else{?>
	<img src="../theme/main_theme/blank.gif" width="16" height="16" border="0" align="absmiddle">
	<?php }?><?php if($b > 0 ){ echo GenPic($b);}?><img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle"><?php echo $R["category_name"]; ?> </td>
    <td align="center"><input name="selected[]"  <?php echo $checked;?> type="checkbox" value="<?php echo $R["category_id"];?>"><!--<a href="#select" onClick="selectG('<?php//php echo $R["category_id"]; ?>');">Apply</a>--></td>
  </tr>

  <?php
		}
		?>   <tr align="center" bgcolor="#FFFFFF">
    <td colspan="2"><input type="submit" name="Submit" value="บันทึก"></td>
  </tr><?php
		}else{
		?>
  <tr align="center" bgcolor="#FFFFFF"> 
    <td colspan="2"><strong><font color="#FF0000">Gallery not found.</font></strong></td>
  </tr>

  <?php } ?>
  </form>
</table>
</body>
</html>
<?php }} ?>
<?php
$db->db_close(); ?>
