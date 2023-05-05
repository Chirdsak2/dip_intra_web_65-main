<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
if($_POST["Flag"] == "NewG"){
	$bcode = base64_decode($_POST["B"]);
	$bid_a = explode("z",$bcode);
	$BID = $bid_a[1];
			$db->query("INSERT INTO graph_index (graph_subject,graph_description,graph_type,graph_bgcolor,graph_width,graph_height,graph_align) VALUES ('Data Sheet','Description','Column3d','#FFFFFF',400,300,'center')");
				$sql_gid = $db->query("SELECT MAX(graph_id) AS gid FROM graph_index ");
				$maxgid = $db->db_fetch_row($sql_gid);

				$db->query("UPDATE block SET block_link = '".$maxgid[0]."' WHERE BID = '".$BID."' ");

					$db->query("INSERT INTO graph_x (graph_id,x_title) VALUES ('$maxgid[0]','Data1')");
					$db->query("INSERT INTO graph_x (graph_id,x_title) VALUES ('$maxgid[0]','Data2')");
					$db->query("INSERT INTO graph_x (graph_id,x_title) VALUES ('$maxgid[0]','Data3')");
					$db->query("INSERT INTO graph_x (graph_id,x_title) VALUES ('$maxgid[0]','Data4')");

					$db->query("INSERT INTO graph_y (graph_id,y_title,y_color) VALUES ('$maxgid[0]','Sample1','#F6BD0F')");
					$db->query("INSERT INTO graph_y (graph_id,y_title,y_color) VALUES ('$maxgid[0]','Sample2','#AFD8F8')");
					$db->query("INSERT INTO graph_y (graph_id,y_title,y_color) VALUES ('$maxgid[0]','Sample3','#1941A5')");
$i = date("i") + 23;
					$sqlX = $db->query("SELECT x_id FROM graph_x WHERE graph_id = '$maxgid[0]' ORDER BY x_id ASC");
					while($X = $db->db_fetch_row($sqlX)){
							$sqlY = $db->query("SELECT y_id FROM graph_y WHERE graph_id = '$maxgid[0]' ORDER BY y_id ASC");
							while($Y = $db->db_fetch_row($sqlY)){
								$v = $i % (date("s") + 11);
								$v += date("j");
								$i += date("H");
								$db->query("INSERT INTO graph_value (graph_id,graph_x,graph_y,value_value) VALUES ('$maxgid[0]','$X[0]','$Y[0]','$v')");
							}
					}

?>
<script language="JavaScript">
  //window.location.href = "content_graph.php?graph_id=<?php echo $maxgid[0]; ?>&B=<?php echo $_POST["B"]; ?>";
 window.location.href = "graph_list.php?graph_id=<?php echo $maxgid[0]; ?>&B=<?php echo $_POST["B"]; ?>";
  window.open('content_graph.php?graph_id=<?php echo $maxgid[0]; ?>&B=<?php echo $_POST["B"]; ?>','mywindow','status=1,toolbar=0');	
</script>
<?php
}elseif($_POST["Flag"] == "SET"){
$bcode = base64_decode($_POST["B"]);
$bid_a = explode("z",$bcode);
$BID = $bid_a[1];
$db->query("UPDATE block SET block_link = '".$_POST["selected"]."' WHERE BID = '".$BID."' ");
?>
<script language="JavaScript">
window.location.href = "graph_list.php?graph_id=<?php echo $_POST["selected"]; ?>&B=<?php echo $_POST["B"]; ?>";
window.open('content_graph.php?graph_id=<?php echo $_POST["selected"]; ?>&B=<?php echo $_POST["B"]; ?>','mywindow','status=1,toolbar=0,width=500,height=400,resizable=1');	
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
<table width="100%" border="0" cellpadding="3" cellspacing="0">
  <form name="form1" method="post" action="graph_list.php"><tr bgcolor="F3F3EE"> 
    <td height="20" align="left" colspan="2"> <img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
      Block name : <?php echo $R["block_name"]; ?> 
        <input name="Flag" type="hidden" id="Flag" value="SET">
        <input name="B" type="hidden" id="B" value="<?php echo $_GET["B"]; ?>">
        <input type="hidden" name="selected"> </td>
  </tr></form>
  <tr> 
    <td height="1" bgcolor="AAAAAA" colspan="2"></td>
  </tr>
  <tr> 
    <td height="1" bgcolor="716F64" colspan="2"></td>
  </tr>
  <tr bgcolor="F3F3EE"> 
    <td height="20" align="left" colspan="2"> Select Graph or Create New Graph 
      <a href="#new" onClick="document.form1.Flag.value='NewG';form1.submit();"><font color="#0000FF">Here</font></a> </td>
  </tr>
  <tr> 
    <td height="1" bgcolor="AAAAAA" colspan="2"></td>
  </tr>
  <tr> 
    <td height="1" bgcolor="716F64" colspan="2"></td>
  </tr>
  <?php
  $sql_graph = $db->query("SELECT * FROM graph_index");
  while($G = $db->db_fetch_array($sql_graph)){
  ?>
  <tr> 
    <td><?php if($R["block_link"] == $G["graph_id"]){ ?><img src="../images/right1.gif" width="20" height="20" align="absmiddle"><?php }else{  ?><img src="../images/o.gif" width="20" height="20" align="absmiddle"><?php } ?>&nbsp;&nbsp;<a href="#select" onClick="selectG('<?php echo $G["graph_id"]; ?>');"><img src="../images/c_chart.gif" width="24" height="24" border="0" align="absmiddle"> 
      <?php echo $G["graph_subject"]; ?></a> </td>
  </tr>
  <?php } ?>
</table>
</body>
</html>
<?php }} ?>
<?php $db->db_close(); ?>
