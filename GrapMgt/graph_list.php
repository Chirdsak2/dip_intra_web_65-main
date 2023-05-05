<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

if($_POST["Flag"] == "NewG"){
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
<script>
  //window.location.href = "content_graph.php?graph_id=<?php echo $maxgid[0]; ?>&B=<?php echo $_POST["B"]; ?>";
//window.location.href = "graph_list.php?graph_id=<?php echo $maxgid[0]; ?>";
window.open('content_graph.php?graph_id=<?php echo $maxgid[0]; ?>','mywindow','status=1,toolbar=0,width=800,height=600,resizable=1');	
</script>
<?php
}elseif($_POST["Flag"] == "DelG"){
	$db->query("DELETE FROM graph_x WHERE graph_id = '".$_POST["selected"]."' ");
	$db->query("DELETE FROM graph_y WHERE graph_id = '".$_POST["selected"]."' ");
	$db->query("DELETE FROM graph_value WHERE graph_id = '".$_POST["selected"]."' ");
	$db->query("DELETE FROM graph_index WHERE graph_id = '".$_POST["selected"]."' ");
?>
<script >
 window.location.href = "graph_list.php";
</script>
<?php
}elseif($_POST["Flag"] == "SET"){
?>
<script>
//window.location.href = "graph_list.php?graph_id=<?php echo $_POST["selected"]; ?>";
window.open('content_graph.php?graph_id=<?php echo $_POST["selected"]; ?>','mywindow','status=1,toolbar=0,width=800,height=600,resizable=1');	
</script>
<?php
}
include("../lib/config_path.php");
include("../header.php");
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<?php include('link.php'); ?>
<script >
function selectG(c){
	document.form1.selected.value = c;
	form1.submit(); 
}
</script>
</head>
<body leftmargin="0" topmargin="0">
<?php
include('top.php');
?>

<form name="form1" method="post" action="graph_list.php">
        <input name="Flag" type="hidden" id="Flag" value="SET">
        <input name="B" type="hidden" id="B" value="<?php echo $_GET["B"]; ?>">
        <input type="hidden" name="selected">
</form>
 
<div class="panel panel-default" style="border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">

<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;">ข้อมูลกราฟ</h4>
</div>	

<div class="panel-body">

<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12" >
</div>
<div class="col-md-6 col-sm-6 col-xs-12 float-right" style="text-align:right;" > 
<a href="#new" onClick="document.form1.Flag.value='NewG';form1.submit();" target="_self">
<button type="button" class="btn btn-info  btn-sm " >
        <span class="glyphicon glyphicon-plus-sign"></span>&nbsp;&nbsp;<?="สร้างกราฟ";?>
		
</button>
</a>

<!--<a href="vdo_list.php?gid=<?//=$_GET['gid'];?>" target="_self">

<button type="button" class="btn btn-info  btn-sm " >
        <span class="glyphicon glyphicon-backward"></span>&nbsp;&nbsp;<?="ย้อนกลับ";?>
</button>
</a>-->
</div>	
</div>
</div>
<br>
<hr>

<div class="col-md-12 col-sm-12 col-xs-12" >
<table width="100%"  class="table table-bordered">
<tr class="ewttablehead"> 
<th style="text-align:center;">เลือกกราฟ</th>
</tr>
<?php
$sql_graph = $db->query("SELECT * FROM graph_index");
while($a_graph = $db->db_fetch_array($sql_graph)){
?>
<tr> 
<td>
	<?php if($_GET['graph_id'] == $a_graph['graph_id']){ ?>
	<img src="../images/right1.gif" width="20" height="20" align="absmiddle"><?php }else{  ?>
	<img src="../images/o.gif" width="20" height="20" align="absmiddle"><?php } ?>&nbsp;&nbsp;
	<a href="#select" onClick="selectG('<?php echo $a_graph['graph_id']; ?>');">
	<img src="../images/c_chart.gif" width="24" height="24" border="0" align="absmiddle"> 
    <?php echo $a_graph['graph_subject']; ?>
	</a> 
	<a href="#del" onClick="if(confirm('Are you sure to delete Graph?')){ document.form1.selected.value='<?=$a_graph['graph_id']?>';document.form1.Flag.value='DelG';form1.submit(); }">
	<img src="../theme/main_theme/g_del.gif" alt="ลบ" width="16" height="16" border="0" align="absmiddle">
	</a>
</td>
</tr>
  <?php } ?>
</table>
<!--<table width="90%" border="0" align="center" class="table table-bordered">
  <tr bgcolor="F3F3EE"> 
    <td height="20" align="left" colspan="2"> Select Graph or Create New Graph 
      <a href="#new" onClick="document.form1.Flag.value='NewG';form1.submit();"><font color="#0000FF">สร้างกราฟ</font></a> </td>
  </tr>
  <?php
  /*$sql_graph = $db->query("SELECT * FROM graph_index");
  while($G = $db->db_fetch_array($sql_graph)){*/
  ?>
  <tr> 
    <td>
	<?php /*if($_GET["graph_id"] == $G["graph_id"]){ */?><img src="../images/right1.gif" width="20" height="20" align="absmiddle"><?php //}else{  ?><img src="../images/o.gif" width="20" height="20" align="absmiddle"><?php //} ?>&nbsp;&nbsp;<a href="#select" onClick="selectG('<?php //echo $G["graph_id"]; ?>');"><img src="../images/c_chart.gif" width="24" height="24" border="0" align="absmiddle"> 
    <?php //echo $G["graph_subject"]; ?></a> <a href="#del" onClick="if(confirm('Are you sure to delete Graph?')){ document.form1.selected.value='<?//=$G["graph_id"]?>';document.form1.Flag.value='DelG';form1.submit(); }"><img src="../theme/main_theme/g_del.gif" alt="ลบ" width="16" height="16" border="0" align="absmiddle"></a></td>
  </tr>
  <?php //} ?>
</table>-->

</div>
</div> 
</div> 
<?php
include('footer.php');
?>
</body>
</html>
<?php //} ?>
<?php $db->db_close(); ?>
