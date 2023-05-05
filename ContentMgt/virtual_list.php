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
$db->write_log("update","main","แก้ไข block virtual ");

?>
<script language="JavaScript">
window.location.href = "virtual_list.php?B=<?php echo $_POST["B"]; ?>";
//top.self.close();
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
<script language="javascript1.2">
function show_datachid(gid,obj){
if(obj.src.search("minus.gif") != -1){ obj.src = "../images/plus.gif";}else { obj.src = "../images/minus.gif";}
							if(document.getElementById("G"+gid).style.display != "none") {
							document.getElementById("G"+gid).style.display = "none";
							}else{
							document.getElementById("G"+gid).style.display = "";
							}
}
function choose_id(id,name){
		window.opener.document.getElementById('virtual_id').value = id;
		window.opener.document.all.listid.innerHTML = name;
		//alert('เลือกเรียบร้อยแล้วค่ะ');
		window.close();
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#666666">
<form name="form1" method="post" action="virtual_list.php">
 <input name="Flag" type="hidden" id="Flag" value="SET">
        <input name="B" type="hidden" id="B" value="<?php echo $_GET["B"]; ?>">
        <input type="hidden" name="selected">
</form>
  <tr bgcolor="#E6E6E6"> 
    <td width="70%"><strong>virtual name</strong></td>
    <td width="30%" align="center"><strong>Apply to WebBlock</strong></td>
  </tr>
  <?php
	if($_GET[G_id] == '' || $_GET[G_id] == '0'){
	$_GET[G_id]  = '0';
	}
?>
<?php
function GenPic($data){
	for($i=0;$i<$data;$i++){
		echo "<img src=\"../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
	}
}
function data_child($id,$num){
global $db,$BLink;
$y = $num+1;
$sql = "select * from virtual_group where vg_parent = '".$id."' ";
$query = $db->query($sql);
while($R = $db->db_fetch_array($query)){
?>
 <tr bgcolor="#FFFFFF" > 
    <td><?php if($R["vg_id"]==$BLink){ ?>
	<img src="../theme/main_theme/g_select.gif" width="16" height="16" border="0" align="absmiddle">
	<?php }else{?>
	<img src="../theme/main_theme/blank.gif" width="16" height="16" border="0" align="absmiddle">
	<?php }?><?php GenPic($y); ?><img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle"><?php  echo $R[vg_name]; ?></td>
    <td align="center"><a href="#select" onClick="selectG('<?php echo $R["vg_id"]; ?>');">คลิกที่นี่เพื่อเลือก</a></td>
  </tr>
<?php
data_child($R["vg_id"],$y);
}
}
//show data
$sql = "select * from virtual_group where vg_parent = '".$_GET[G_id] ."' ";
$query = $db->query($sql);
while($R = $db->db_fetch_array($query)){
?>
  <tr bgcolor="#FFFFFF" > 
    <td><?php if($R["vg_id"]==$BLink){ ?>
	<img src="../theme/main_theme/g_select.gif" width="16" height="16" border="0" align="absmiddle">
	<?php }else{?>
	<img src="../theme/main_theme/blank.gif" width="16" height="16" border="0" align="absmiddle">
	<?php }?><img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle"><?php  echo $R[vg_name]; ?></td>
    <td align="center"><a href="#select" onClick="selectG('<?php echo $R["vg_id"]; ?>');">คลิกที่นี่เพื่อเลือก</a></td>
  </tr>
  <?php data_child($R[vg_id],0);?>
  <?php }
  if($db->db_num_rows($query)==0){
   ?>
  <tr align="center" bgcolor="#FFFFFF"> 
    <td colspan="2"><strong><font color="#FF0000">virtual not found.</font></strong></td>
  </tr>
  <?php } ?>

</table>
</body>
</html>
<?php }} ?>
<?php
$db->db_close(); ?>
