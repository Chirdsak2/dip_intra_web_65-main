<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
		$bcode = base64_decode($_GET["B"]);
$bid_a = explode("z",$bcode);
$BID = $bid_a[1];
$sql_file = $db->query("SELECT BID FROM block WHERE BID = '".$BID."'");
if($db->db_num_rows($sql_file) == 1){

$sql = $db->query("SELECT * FROM article_group WHERE c_parent = '0' ORDER BY c_id ASC ");

function GenPic($data){
	for($i=0;$i<$data;$i++){
		echo "<img src=\"../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
	}
}
function child($c,$x,$decho){
global $db,$i,$txt,$BID;
$y = $x+1;
$sql = $db->query("SELECT * FROM article_group WHERE c_parent = '$c' ORDER BY c_id ASC ");
  while($U = $db->db_fetch_array($sql)){
  $sql_check = $db->query("SELECT a_id FROM article_apply WHERE text_id = '".$BID."' AND article_apply.a_active = 'Y' AND c_id = '".$U["c_id"]."' ");
  ?>
    <tr bgcolor="#FFFFFF" > 
      <td ><img src="../images/o.gif" width="20" height="20" border="0" align="absmiddle"><?php GenPic($y); ?><input type="checkbox" name="chk[]" value="<?php echo $U["c_id"]; ?>"   <?php if($db->db_num_rows($sql_check)){ echo "checked"; } ?>>
		<?php if($y>=1 and $y<10){?>
			<img src="../images/folder_closed<?php echo $y;?>.gif" width="16" height="16" border="0" align="absmiddle">
	  <?php }else{?>
			<img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">
	  <?php }?>
	  &nbsp; 
	  <?php echo $U["c_name"]; ?></td>
    </tr>
    <?php
	$i++; 
	child($U["c_id"],$y,$decho);
  }
}
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">

</head>
<body>
<span id="divhtml" style="display:none"></span>
  <table width="95%" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC">
    <form name="form1" method="post" action="article_position_function.php">
	<tr bgcolor="#FFFFFF" > 
      <td ><strong>เลือกกลุ่มเพื่อแสดง</strong> 
        <input type="submit" name="Submit" value="  บันทึก  "><SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript" SRC="../js/find.js"></SCRIPT>
        <hr size="1" noshade>
        </td>
    </tr>
    <?php
	$i=1;
	$txt = "";
  while($U = $db->db_fetch_array($sql)){
  $sql_check = $db->query("SELECT a_id FROM article_apply WHERE text_id = '".$BID."' AND article_apply.a_active = 'Y' AND c_id = '".$U["c_id"]."' ");

  ?>
    <tr bgcolor="#FFFFFF" > 
      <td ><img src="../images/o.gif" width="20" height="20" border="0" align="absmiddle"><input type="checkbox" name="chk[]" value="<?php echo $U["c_id"]; ?>"    <?php if($db->db_num_rows($sql_check)){ echo "checked"; } ?>><img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">&nbsp; 
	  <?php echo $U["c_name"]; ?>
        </td>
    </tr>
    <?php 
	$i++;
	child($U["c_id"],0,$decho);
  }
  ?><input type="hidden" name="numrow" value="<?php echo $i; ?>">
  <tr bgcolor="#FFFFFF" > 
      <td ><hr size="1" noshade>
        <strong>เลือกกลุ่มเพื่อแสดง</strong> 
        <input type="submit" name="Submit" value="  บันทึก  "><SCRIPT TYPE="text/javascript" LANGUAGE="JavaScript" SRC="../js/find.js"></SCRIPT>
        <input name="B" type="hidden" id="B" value="<?php echo $_GET["B"]; ?>"><input type="hidden" name="Flag" value="Save">
</td>
    </tr>
  </form>
  </table>
</body>
</html>
<?php } ?>
<?php $db->db_close(); ?>
