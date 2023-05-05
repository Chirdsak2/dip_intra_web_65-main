<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

if($_POST["Flag"] == "Set"){
$db->query("USE ".$EWT_DB_USER);

$db->query("UPDATE share_article SET c_id = '".$_POST["cg"]."' WHERE sg_id = '".$_POST["rec"]."' ");
?>
<script language="javascript">
window.opener.location.reload();
window.close();
</script>
<?php
exit;
}

function countparent($c){
global $db,$EWT_DB_USER,$ptype,$ppms1,$ppms2,$y;
$ptype = "Ag";
$ppms1 = "w";
$ppms2 = "a";

$sql = $db->query_db("SELECT c_parent FROM article_group WHERE c_id = '$c'   ",$_SESSION["EWT_SDB"]);
  while($U = $db->db_fetch_array($sql)){
	$c = countparent($U["c_parent"]);
	$y += $c;
	$sql2 = $db->query_db("SELECT s_id FROM permission WHERE p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' AND UID = '".$_SESSION["EWT_SUID"]."' 
	AND   (s_type = '".$ptype."' AND s_permission = '".$ppms1."'  AND s_id = '".$U["c_parent"]."' )   ",$EWT_DB_USER);
	if($db->db_num_rows($sql2) > 0){
	$y++;
	}
  }
  return $y;
}


if($db->check_permission('Ag','w',"0")){
  //$sql_article = $db->query_db("SELECT * FROM article_group WHERE c_parent = '0' ORDER BY c_id ASC",$_SESSION["EWT_SDB"]);
  $sql = $db->query_db("SELECT * FROM article_group WHERE c_parent = '0' ORDER BY c_id ASC ",$_SESSION["EWT_SDB"]);
}else{
		$sql_supadmin = $db->query_db("SELECT s_id FROM permission WHERE p_type = 'U' AND pu_id = '".$_SESSION["EWT_SMID"]."' AND UID = '".$_SESSION["EWT_SUID"]."'  AND (s_type = 'Ag' AND s_permission = 'w'  AND s_id != '0' )   ",$EWT_DB_USER);
		
			 $sql_text = "WHERE ( 0 ";
			while($G = $db->db_fetch_row($sql_supadmin)){
			$y = 0;
				if(countparent($G[0]) == 0){
				$sql_text .= " OR c_id = '".$G[0]."' ";
				}
			}
			$sql_text .= " ) ";
		//$sql_group = $db->query_db("SELECT * FROM gallery_category ".$sql_text." ORDER BY category_id ASC ",$_SESSION["EWT_SDB"]);
		$sql = $db->query_db("SELECT * FROM article_group  ".$sql_text." ORDER BY c_id ASC",$_SESSION["EWT_SDB"]);
}




function GenPic($data){
	for($i=0;$i<$data;$i++){
		echo "<img src=\"../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
	}
}
function child($c,$x,$decho){
global $db,$EWT_DB_USER,$i,$txt;
$y = $x+1;
$sql = $db->query_db("SELECT * FROM article_group WHERE c_parent = '$c' ORDER BY c_id ASC ",$_SESSION["EWT_SDB"]);
  while($U = $db->db_fetch_array($sql)){
  ?>
    <tr bgcolor="#FFFFFF" > 
      <td ><img src="../images/o.gif" width="20" height="20" border="0" align="absmiddle"><?php GenPic($y); ?><a href="#select" onClick="document.form1.cg.value='<?php echo $U["c_id"]; ?>';form1.submit();">
	  
	  <?php if($y>=1 and $y<10){?>
			<img src="../images/folder_closed<?php echo $y;?>.gif" width="16" height="16" border="0" align="absmiddle">
	  <?php }else{?>
			<img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">
	  <?php }?>
	  
	  <?php echo $U["c_name"]; ?></a></td>
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
    <form name="form1" method="post" action="article_select_share.php">
	<tr bgcolor="#FFFFFF" > 
      <td ><strong>Article group
        <input type="hidden" name="rec" value="<?php echo $_GET["cid"]; ?>"><input type="hidden" name="cg" value=""><input type="hidden" name="Flag" value="Set">
      </strong></td>
    </tr>
    <?php
	$i=1;
	$txt = "";
  while($U = $db->db_fetch_array($sql)){
  ?>
    <tr bgcolor="#FFFFFF" > 
      <td ><img src="../images/o.gif" width="20" height="20" border="0" align="absmiddle"><a href="#select" onClick="document.form1.cg.value='<?php echo $U["c_id"]; ?>';form1.submit();"><img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">&nbsp; 
	  <?php echo $U["c_name"]; ?></a></td>
    </tr>
    <?php 
	$i++;
	child($U["c_id"],0,$decho);
  }
  ?><input type="hidden" name="numrow" value="<?php echo $i; ?>"></form>
  </table>
</body>
</html>
<?php $db->db_close(); ?>
