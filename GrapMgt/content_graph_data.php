<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$graph_id=$_GET['graph_id']==''?$_POST['graph_id']:$_GET['graph_id'];

$column_text = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");

$sql_graph = $db->query("SELECT * FROM graph_index WHERE graph_id = '".$graph_id."'");
$R = $db->db_fetch_array($sql_graph);

		$sql_x = $db->query("SELECT * FROM graph_x WHERE graph_id = '".$graph_id."' ORDER BY x_id ASC");
		$row_x = $db->db_num_rows($sql_x);
		$width = 200 + (74 * $row_x);
		
		$sql_y = $db->query("SELECT * FROM graph_y WHERE graph_id = '".$graph_id."' ORDER BY y_id ASC");
		$row_y = $db->db_num_rows($sql_y);
		
include("../lib/config_path.php");
include("../header.php");
		?>
<!--<html>
<head>
<title>Graph Management [<?php //echo $_GET["filename"]; ?>]</title>-->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<?php include('link.php'); ?>
<script >
		  	function selColor(c,d){
				Win2=window.open('../ewt_color.php?c_value='+ c +'&c_block=' + d + '','sel', 'height=175,width=245, status=0, menubar=0,resizable=no, location=0, scrollbars=no, left=400, top=300');
			}
	function object_over(eButton){
		eButton.style.border = "#000000 solid 1px";
	}
		function object_out(eButton){
		eButton.removeAttribute("style");
	}
	function button_over(eButton){
		eButton.style.borderBottom = "buttonshadow solid 1px";
		eButton.style.borderLeft = "buttonhighlight solid 1px";
		eButton.style.borderRight = "buttonshadow solid 1px";
		eButton.style.borderTop = "buttonhighlight solid 1px";
	}
				
	function button_out(eButton){
	eButton.style.borderColor = "threedface";
	}
function todoGraph(c,d,e){
	if(c == "DelCol"){
		if(confirm("Are you sure you want to delete column '"+e+"' and all its data?")){
			document.dataForm.todo.value = c;
			document.dataForm.tododata.value = d;
			dataForm.submit();
		}
	}else if(c == "DelRow"){
		if(confirm("Are you sure you want to delete row '"+e+"' and all its data?")){
			document.dataForm.todo.value = c;
			document.dataForm.tododata.value = d;
			dataForm.submit();
		}
	}else{
		document.dataForm.todo.value = c;
		document.dataForm.tododata.value = d;
		dataForm.submit();
	}
}
function chkFileType() {
	var type_file		= document.getElementById('csvFile').value;
	var length_file		= document.getElementById('csvFile').value.length;
	if ( length_file == 0 )
	{
		alert( 'กรุณาระบุไฟล์ที่จะ Upload' ) ;
		document.getElementById('csvFile').value	="";			
		return false ;
	}else if (type_file.substring(type_file.lastIndexOf('.') + 1,length_file) !="csv")
	{
		alert( 'กรุณาระบุไฟล์นามสกุล csv เท่านั้น' ) ;
		document.getElementById('csvFile').value	="";					
		return false ;
	}
	if(confirm('The current data will be replaced. Continue?')) {
		return true;
	} else {
		return false;
	}
}
</script>
<style type="text/css">
<!--
.text_table {
	width:70px;
	height:17px;
	border-width:0px;
	text-align:right;
}
.head_table { 
	border-bottom:"buttonshadow solid 1px";
	border-left:"buttonhighlight solid 1px";
	border-right:"buttonshadow solid 1px";
	border-top:"buttonhighlight solid 1px";
	}
-->
</style>
</head>
<body bgcolor="#808080" leftmargin="0" topmargin="0" >

<div style="width:100%;  margin:10px 5px 0 0;">
<form method="post" action="content_graph_data_upload.php" enctype="multipart/form-data" onSubmit="javascript:return chkFileType();">
<div class="form-group row">
<div class="col-md-9 col-sm-9 col-xs-9" >
	<input type="hidden" name="graph_id" id="graph_id" value="<?php echo $graph_id?>" />
	<input type="file" name="csvFile" id="csvFile" class="form-control "  />
	<span style="color:red">Only .csv file is acceptable.&nbsp;&nbsp;</span>
</div>
<div class="col-md-3 col-sm-3 col-xs-3" >
	<input type="submit" value="Upload" class="btn btn-success btn-sm" />

	<a href="content_graph_data_export.php?graph_id=<?php echo $graph_id?>" target="_blank" >
	<button type="button" class="btn btn-info  btn-sm " >
        <span class="glyphicon glyphicon-file"></span>&nbsp;&nbsp;<?="Export";?>
	</button>
	</a>
</div>
</div>
</form>


</div> 
	
<div class="clearfix">&nbsp;</div>	
<!--<table width="<?php echo $width; ?>"  border="0" cellpadding="0" cellspacing="1" bordercolor="#FFFFFF" bgcolor="#808080">-->
<table width="100%"  class="table table-bordered">
  <form  method="post"   name="dataForm" action="graph_function.php">
    <tr bgcolor="#DFDFEA" > 
      <td colspan="2" class="head_table">&nbsp;</td>
      <td width="74"  class="head_table" style="width:74px">&nbsp;</td>
      								<?php  
	  									$value_x = array();
										$j = 0;
									 while($X = $db->db_fetch_array($sql_x)){ 
									 $value_x[$j] = $X["x_id"];
									 $value_title[$j] = $X["x_title"];
									  ?>
									  <input type="hidden" name="x_id<?php echo $j; ?>" value="<?php echo $X["x_id"]; ?>">
      <td width="74" align="right" class="head_table" style="width:74px"><strong><?php echo $column_text[$j]; ?></strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/graph_cdel.gif" width="9" height="9" align="texttop"  border="1" style="border-Color:threedface"  onMouseOver="button_over(this);" onMouseOut="button_out(this);" title="Delete Column"onClick="todoGraph('DelCol','<?php echo $X["x_id"]; ?>','<?php echo $column_text[$j]; ?>')"></td>
      <?php $j++; } ?>
      <td width="70" align="center" class="head_table" style="cursor:hand; width:70" onClick="todoGraph('InsCol','','')"><strong>...</strong></td>
    </tr>

    <tr bgcolor="#FFFFFF"> 
      <td height="26" colspan="2" bgcolor="#DFDFEA"  class="head_table">&nbsp;</td>
      <td bgcolor="#F7F7F7" ></td>
      	<?php
				for($i=0;$i<$row_x;$i++){
		?>
      <td align="center"  onMouseOver="object_over(this)" onMouseOut="object_out(this)"><input name="x_title<?php echo $i; ?>" type="text" class="text_table" value="<?php echo $value_title[$i]; ?>">
        </td>
      <?php  }  ?>
      <td bgcolor="#808080" ></td>
    </tr>
		<?php 
	$k=0;
	 while($Y = $db->db_fetch_array($sql_y)){ 
	 ?><input type="hidden" name="bgcolor<?php echo $k; ?>" value="<?php echo $Y["y_color"]; ?>">
	 <input type="hidden" name="y_id<?php echo $k; ?>" value="<?php echo $Y["y_id"]; ?>">
    <tr bgcolor="#FFFFFF"> 
      <td width="20" height="22" bgcolor="#DFDFEA"  class="head_table"><a id="CPreview<?php echo $k; ?>" style="background-color: <?php echo $Y["y_color"]; ?>; padding: 0; height: 21px; width: 21px;cursor:hand;border-width:0; border-style:solid;" onClick="selColor('window.opener.document.dataForm.bgcolor<?php echo $k; ?>.value','window.opener.document.all.CPreview<?php echo $k; ?>.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23" border="0" align="absmiddle"></a></td>
      <td width="30" align="right" nowrap bgcolor="#DFDFEA"  class="head_table"><strong><?php echo ($k+1); ?></strong>&nbsp;&nbsp;<img src="../images/graph_cdel.gif" width="9" height="9" align="texttop"  border="1" style="border-Color:threedface"  onMouseOver="button_over(this);" onMouseOut="button_out(this);" title="Delete Row" onClick="todoGraph('DelRow','<?php echo $Y["y_id"]; ?>','<?php echo ($k+1); ?>')"></td>
      <td align="center"   onMouseOver="object_over(this)" onMouseOut="object_out(this)"><input name="y_title<?php echo $k; ?>" type="text" class="text_table" value="<?php echo $Y["y_title"]; ?>"></td>
      <?php  
									  for($i=0;$i<$row_x;$i++){
									  $sql_value = $db->query("SELECT value_id,value_value FROM graph_value WHERE graph_id = '".$graph_id."' AND graph_x = '".$value_x[$i]."' AND graph_y = '".$Y["y_id"]."' ");
									  $V = $db->db_fetch_row($sql_value);
									  ?>
									  <input name="ix<?php echo $i; ?>y<?php echo $k; ?>" type="hidden" class="text_table" value="<?php echo $V[0]; ?>">
      <td align="center"  onMouseOver="object_over(this)" onMouseOut="object_out(this)"><input name="vx<?php echo $i; ?>y<?php echo $k; ?>" type="text" class="text_table" value="<?php echo $V[1]; ?>"></td>
      <?php } ?>
      <td bgcolor="#808080" ></td>
    </tr>
	<?php  $k++; } ?>
    <tr bgcolor="#FFFFFF"> 
      <td height="20" colspan="2" align="center" bgcolor="#DFDFEA"  class="head_table"  style="cursor:hand" onClick="todoGraph('InsRow','','')"><strong>...</strong></td>
      <td align="center" bgcolor="#808080" ></td>
	  <?php  
									  for($i=0;$i<$row_x;$i++){
									  ?>
      <td align="center" bgcolor="#808080">&nbsp;</td>
        <?php } ?>
      <td bgcolor="#808080" ></td>
    </tr>
<input type="hidden" name="allx" value="<?php echo $row_x; ?>">
<input type="hidden" name="ally" value="<?php echo $k; ?>">
<input type="hidden" name="todo" value="">
<input type="hidden" name="tododata" value="">
<input type="hidden" name="Flag" value="GraphData">
<input type="hidden" name="graph_id" value="<?php echo $graph_id; ?>">  </form>
</table>

</body>
</html>
<?php $db->db_close(); ?>
