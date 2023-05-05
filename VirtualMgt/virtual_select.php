<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");


  $sql = $db->query_db("SELECT * FROM virtual_group WHERE vg_parent = '0' ORDER BY vg_id ASC ",$_SESSION["EWT_SDB"]);

function GenPic($data){
	for($i=0;$i<$data;$i++){
		echo "<img src=\"../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
	}
}
function child($c,$x,$decho){
global $db,$i,$txt;
$y = $x+1;
$sql = $db->query_db("SELECT * FROM virtual_group WHERE vg_parent = '$c' ORDER BY vg_id ASC ",$_SESSION["EWT_SDB"]);
  while($U = $db->db_fetch_array($sql)){
  ?>
    <tr bgcolor="#FFFFFF" > 
      <td ><img src="../images/o.gif" width="20" height="20" border="0" align="absmiddle"><?php GenPic($y); ?><a href="#select" onClick="window.opener.document.form1.cid.value='<?php echo $U["vg_id"]; ?>';window.opener.document.all.txtshow.innerHTML='<?php echo eregi_replace("&#039;","`",$U["vg_name"]); ?>';window.close();">
	  
	  <?php if($y>=1 and $y<10){?>
			<img src="../images/folder_closed<?php echo $y;?>.gif" width="16" height="16" border="0" align="absmiddle">
	  <?php }else{?>
			<img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">
	  <?php }?>
	  
	  <?php echo $U["vg_name"]; ?></a></td>
    </tr>
    <?php
	$i++; 
	child($U["vg_id"],$y,$decho);
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
  <table width="95%" border="0" align="center" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC">
    <form name="form1" method="post" action="">
	<tr bgcolor="#FFFFFF" > 
      <td ><strong>Virtual Group</strong></td>
    </tr>
    <?php
	$i=1;
	$txt = "";
  while($U = $db->db_fetch_array($sql)){
  ?>
    <tr bgcolor="#FFFFFF" > 
      <td ><img src="../images/o.gif" width="20" height="20" border="0" align="absmiddle"><a href="#select" onClick="window.opener.document.form1.cid.value='<?php echo $U["vg_id"]; ?>';window.opener.document.all.txtshow.innerHTML='<?php echo eregi_replace("&#039;","`",$U["vg_name"]); ?>';window.close();"><img src="../images/folder_closed.gif" width="16" height="16" border="0" align="absmiddle">&nbsp; 
	  <?php echo $U["vg_name"]; ?></a></td>
    </tr>
    <?php 
	$i++;
	child($U["vg_id"],0,$decho);
  }
  ?><input type="hidden" name="numrow" value="<?php echo $i; ?>"></form>
  </table>
</body>
</html>
<?php $db->db_close(); ?>
