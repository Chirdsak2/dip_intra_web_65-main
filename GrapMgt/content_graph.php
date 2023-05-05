<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$sql_graph = $db->query("SELECT * FROM graph_index WHERE graph_id = '".$_GET["graph_id"]."'");
$R = $db->db_fetch_array($sql_graph);
			//setting hide/show
			if($_GET["tb_show"] == ""){
			$tbshow = "01";
			}else{
			$tbshow = $_GET["tb_show"];
			}
include("../lib/config_path.php");
include("../header.php");
?>
<!--<html>
<head>
<title>Graph Management [<?php //echo $_GET["graph_id"]; ?>]</title>-->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<?php include('link.php'); ?>
<script >
		  	function selColor(c,d){
				Win2=window.open('../ewt_color.php?c_value='+ c +'&c_block=' + d + '','sel', 'height=175,width=245, status=0, menubar=0,resizable=no, location=0, scrollbars=no, left=400, top=300');
			}
			

</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('.noScrolling').jScrollPane();
    }
});
</script>
<style>

	iframe {
        overflow: -moz-scrollbars-vertical !important;
        overflow-y:scroll;
    }

</style>
</head>
<body leftmargin="0" topmargin="0" >
<table width="100%"  class="table table-bordered">
  <form action="graph_function.php"  method="post" enctype="multipart/form-data"   name="linkForm">
  <input type="hidden" name="tbshow" value="<?php echo $tbshow; ?>">
  <tr>
    <td valign="top">
	
	<table width="100%"  _class="table table-bordered">
        <tr>
          <td valign="top" bgcolor="F7F7F7">
              
			  
			 <table width="100%"  class="table table-bordered">
                <tr valign="top"> 
                  <td height="20"> <img src="../images/arrow_r.gif" width="7" height="7" border="0" align="absmiddle"> 
                    <strong>Page : <?php echo $_GET["filename"]; ?></strong> </td>
                </tr>
                <tr valign="top"> 
                  <td>
				  <table width="100%"  class="table table-bordered">
                      <tr   id="tr01" style="display:<?php if($tbshow == "01"){ echo '\'\''; }else{ echo "none"; } ?>">
                        <td valign="top" >
<ul class="nav nav-tabs">
  <li class="active"><a href="#">Graph Settings</a></li>
  <li><a href="#design" onClick="document.all.tr01.style.display='none';document.all.tr02.style.display='';document.all.tr03.style.display='none';document.linkForm.tbshow.value='02';">Graph Style </a></li>
  <li><a href="#popup" onClick="document.all.tr01.style.display='none';document.all.tr02.style.display='none';document.all.tr03.style.display='';document.linkForm.tbshow.value='03';">Graph Data</a></li>
  <li><a href="#popup" onClick="graph_data.document.dataForm.todo.value='OnSubmit';graph_data.document.dataForm.submit();">Graph Preview</a></li> 
</ul>
						<!--<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
						<tr style="font-size:11px;">
						<td width="100" align="center" background="../images/bg1_on.gif" style="background-repeat: no-repeat;" >Graph Settings</td>
						<td width="100" align="center" background="../images/bg3_off.gif" style="background-repeat: no-repeat;"><a href="#design" onClick="document.all.tr01.style.display='none';document.all.tr02.style.display='';document.all.tr03.style.display='none';document.linkForm.tbshow.value='02';">Graph Style </a></td>
						<td width="100" align="center" background="../images/bg3_off.gif" style="background-repeat: no-repeat;"><a href="#popup" onClick="document.all.tr01.style.display='none';document.all.tr02.style.display='none';document.all.tr03.style.display='';document.linkForm.tbshow.value='03';">Graph Data</a> </td>
						<td width="100" align="center" background="../images/bg3_off.gif" style="background-repeat: no-repeat;"><a href="#popup" onClick="graph_data.document.dataForm.todo.value='OnSubmit';graph_data.document.dataForm.submit();">Graph Preview</a> </td>
						<td background="../images/bg2_off.gif" style="background-repeat: no-repeat;">&nbsp;</td>
						</tr>
						</table>-->
<div class="clearfix">&nbsp;</div>			
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12" >
<label for="vdo_creator"><?php echo "Subject"; ?> : </label>
<input class="form-control" name="g_subject" type="text" id="g_subject" value="<?php echo $R["graph_subject"]; ?>" size="50">
</div>
</div>
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12" >
<label for="vdo_creator"><?php echo "Description"; ?> : </label>
<input class="form-control" name="g_desc" type="text" id="g_desc" value="<?php echo $R["graph_description"]; ?>" size="50">
</div>
</div>
<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-6" >
<label for="vdo_creator"><?php echo "Graph title X"; ?> : </label>
<input class="form-control" name="g_x" type="text" id="g_x" value="<?php echo $R["graph_x"]; ?>" >
           
</div>
<div class="col-md-6 col-sm-6 col-xs-6" >
<label for="vdo_creator"><?php echo "Graph title Y"; ?> : </label>
<input class="form-control" name="g_y" type="text" id="g_y" value="<?php echo $R["graph_y"]; ?>" >

</div>
</div>
<!--<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-6" >
<label for="vdo_creator"><?php echo "Graph width"; ?> : </label>
<input class="form-control" name="g_width" type="text" id="g_width" value="<?php echo $R["graph_width"]; ?>" >
           
</div>
<div class="col-md-6 col-sm-6 col-xs-6" >
<label for="vdo_creator"><?php echo "Graph height"; ?> : </label>
<input class="form-control" name="g_height" type="text" id="g_height" value="<?php echo $R["graph_height"]; ?>" >

</div>
</div>-->
<div class="form-group row">
<!--<div class="col-md-6 col-sm-6 col-xs-6" >
<label for="vdo_creator"><?php echo "Graph align"; ?> : </label>
<select name="g_align" id="g_align" class="form-control">
                                  <option value="center" <?php if($R[graph_align] == "center"){ echo "selected"; } ?>>center</option>
                                  <option value="left" <?php if($R[graph_align] == "left"){ echo "selected"; } ?>>left</option>
                                  <option value="right" <?php if($R[graph_align] == "right"){ echo "selected"; } ?>>right</option>
                                </select>
</div>-->
<div class="col-md-6 col-sm-6 col-xs-6" >
<label for="vdo_creator"><?php echo "Background color"; ?> : </label>
<a id="CPreview1" style="background-color: <?php echo $R["graph_bgcolor"]; ?>; padding: 0; height: 21px; width: 21px;cursor:hand;border-width:0; border-style:solid;" onClick="selColor('window.opener.document.linkForm.g_bgcolor.value','window.opener.document.all.CPreview1.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23"></a>
&nbsp;
<input class="form-control" name="g_bgcolor" type="text" id="g_bgcolor" value="<?php echo $R["graph_bgcolor"]; ?>" size="7">
</div>
</div>
<div class="form-group row">
<div class="col-md-12 col-sm-12 col-xs-12" >
<label for="vdo_creator"><?php echo "Background picture"; ?> : </label>
    <?php
							  if($R["graph_bgpic"] != ""){ ?><img src="../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/graph/<?php echo $R["graph_bgpic"]; ?>" width="50" height="50" border="1" align="absmiddle"> <?php echo $R["graph_bgpic"]; ?><br>
                                <?php  } ?>
                                
								<input type="file" name="file" class="form-control">
                                <input name="oldpic" type="hidden" id="oldpic" value="<?php echo $R["graph_bgpic"]; ?>">
                                <br>
                                <input name="nopic" type="checkbox" id="nopic" value="Y">
                                remove background
</div>
</div>

		
                         	 <!--<table width="100%"  class="table table-bordered" >
						  	<tr>
    							<td width="30%">&nbsp;</td>
    							<td width="70%">&nbsp;</td>
  							</tr>
                            <tr valign="top"> 
                              <td align="right"  >Subject : </td>
                              <td  ><input class="form-control" name="g_subject" type="text" id="g_subject" value="<?php echo $R["graph_subject"]; ?>" size="50"></td>
                            </tr>
                            <tr valign="top"> 
                              <td align="right">Description : </td>
                              <td><input class="form-control" name="g_desc" type="text" id="g_desc" value="<?php echo $R["graph_description"]; ?>" size="50"></td>
                            </tr>
                            <tr valign="top"> 
                              <td align="right">Graph width : </td>
                              <td><input class="form-control" name="g_width" type="text" id="g_width" value="<?php echo $R["graph_width"]; ?>" size="5">
                                Pixels </td>
                            </tr>
                            <tr valign="top">
                              <td align="right">Graph height : </td>
                              <td><input class="form-control" name="g_height" type="text" id="g_height" value="<?php echo $R["graph_height"]; ?>" size="5">
                                Pixels </td>
                            </tr>
                            <tr valign="top">
                              <td align="right">Graph align : </td>
                              <td><select name="g_align" id="g_align" class="form-control">
                                  <option value="center" <?php if($R[graph_align] == "center"){ echo "selected"; } ?>>center</option>
                                  <option value="left" <?php if($R[graph_align] == "left"){ echo "selected"; } ?>>left</option>
                                  <option value="right" <?php if($R[graph_align] == "right"){ echo "selected"; } ?>>right</option>
                                </select></td>
                            </tr>
                            <tr valign="top">
                              <td align="right">Background color: </td>
                              <td> 
                                <table width="100%" border="0" cellspacing="0" cellpadding="0">
                                  <tr>
                                    <td width="21"><a id="CPreview1" style="background-color: <?php echo $R["graph_bgcolor"]; ?>; padding: 0; height: 21px; width: 21px;cursor:hand;border-width:0; border-style:solid;" onClick="selColor('window.opener.document.linkForm.g_bgcolor.value','window.opener.document.all.CPreview1.style.backgroundColor');"><img src="../images/box_color.gif" width="21" height="23"></a></td>
                                    <td>&nbsp;<input class="form-control" name="g_bgcolor" type="text" id="g_bgcolor" value="<?php echo $R["graph_bgcolor"]; ?>" size="7"></td>
                                  </tr>
                                </table></td>
                            </tr>
							<tr valign="top">
                              <td align="right">Background picture: </td>
                              <td>
                                <?php
							  if($R["graph_bgpic"] != ""){ ?><img src="../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/graph/<?php echo $R["graph_bgpic"]; ?>" width="50" height="50" border="1" align="absmiddle"> <?php echo $R["graph_bgpic"]; ?><br>
                                <?php  } ?>
                                
								<input type="file" name="file" class="form-control">
                                <input name="oldpic" type="hidden" id="oldpic" value="<?php echo $R["graph_bgpic"]; ?>">
                                <br>
                                <input name="nopic" type="checkbox" id="nopic" value="Y">
                                remove background</td>
                            </tr>
                          </table>-->
						  
</td>
                      </tr>
                      <tr   id="tr02" style="display:<?php if($tbshow == "02"){ echo '\'\''; }else{ echo "none"; } ?>">
                        <td valign="top">
<ul class="nav nav-tabs">
  <li><a href="#menu" onClick="document.all.tr01.style.display='';document.all.tr02.style.display='none';document.all.tr03.style.display='none';document.linkForm.tbshow.value='01';">Graph Settings</a></li>
  <li class="active"><a href="#">Graph Style</a></li>
  <li><a href="#popup" onClick="document.all.tr01.style.display='none';document.all.tr02.style.display='none';document.all.tr03.style.display='';document.linkForm.tbshow.value='03';">Graph Data</a></li>
  <li><a href="#popup" onClick="graph_data.document.dataForm.todo.value='OnSubmit';graph_data.document.dataForm.submit();">Graph Preview</a></li> 
</ul>						
						<!--<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
						<tr> 
                              <td width="100" align="center" background="../images/bg1_off.gif"><a href="#menu" onClick="document.all.tr01.style.display='';document.all.tr02.style.display='none';document.all.tr03.style.display='none';document.linkForm.tbshow.value='01';">Graph 
                                Settings</a> </td>
                              <td width="100" align="center" background="../images/bg1_on.gif">Graph 
                                Style</td>
		
                              <td width="100" align="center" background="../images/bg3_off.gif"><a href="#popup" onClick="document.all.tr01.style.display='none';document.all.tr02.style.display='none';document.all.tr03.style.display='';document.linkForm.tbshow.value='03';">Graph 
                                Data</a> </td>
								<td width="100" align="center" background="../images/bg3_off.gif"><a href="#popup" onClick="graph_data.document.dataForm.todo.value='OnSubmit';graph_data.document.dataForm.submit();">Graph Preview</a> </td>
								<td background="../images/bg2_off.gif">&nbsp;</td>
                </tr>
              </table>-->
			  
<div class="clearfix">&nbsp;</div>			
<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-6" >
<label for="vdo_creator"><?php echo "Area Graph"; ?> : </label>
<input type="radio" name="g_type" value="Area" <?php if($R[graph_type] == "Area"){ echo "checked"; } ?>>
<img src="../images/graph_area.gif" width="32" height="32" border="0" align="middle"> 
</div>

<div class="col-md-6 col-sm-6 col-xs-6" >
<label for="vdo_creator"><?php echo "Line Graph"; ?> : </label>
<input type="radio" name="g_type" value="Line" <?php if($R[graph_type] == "Line"){ echo "checked"; } ?>>
<img src="../images/graph_area.gif" width="32" height="32" border="0" align="middle"> 
</div>
</div>
<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-6" >
<label for="vdo_creator"><?php echo "Column Graph"; ?> : </label>
<input type="radio" name="g_type" value="Column" <?php if($R[graph_type] == "Column"){ echo "checked"; } ?>>
<img src="../images/graph_column.gif" width="32" height="32" border="0" align="middle"> 
</div>

<div class="col-md-6 col-sm-6 col-xs-6" >
<label for="vdo_creator"><?php echo "Column Graph 3D"; ?> : </label>
<input type="radio" name="g_type" value="Column3d" <?php if($R[graph_type] == "Column3d"){ echo "checked"; } ?>>
<img src="../images/graph_column.gif" width="32" height="32" border="0" align="middle"> 
</div>
</div>
<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-6" >
<label for="vdo_creator"><?php echo "Bar Graph"; ?> : </label>
<input type="radio" name="g_type" value="Bar" <?php if($R[graph_type] == "Bar"){ echo "checked"; } ?>>
<img src="../images/graph_row.gif" width="32" height="32" border="0" align="absmiddle"> 
</div>

<div class="col-md-6 col-sm-6 col-xs-6" >
<label for="vdo_creator"><?php echo "Bar Graph 3D"; ?> : </label>
<input type="radio" name="g_type" value="Bar3d" <?php if($R[graph_type] == "Bar3d"){ echo "checked"; } ?>>
<img src="../images/graph_row.gif" width="32" height="32" border="0" align="middle"> 
</div>
</div>
<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-6" >
<label for="vdo_creator"><?php echo "Pie Graph (Only first column)"; ?> : </label>
<input type="radio" name="g_type" value="Pie" <?php if($R[graph_type] == "Pie"){ echo "checked"; } ?>>
<img src="../images/graph_pie.gif" width="32" height="32" border="0" align="absmiddle"> 
</div>

<div class="col-md-6 col-sm-6 col-xs-6" >
<label for="vdo_creator"><?php echo "Pie Graph 3D (Only first column)"; ?> : </label>
<input type="radio" name="g_type" value="Pie3d" <?php if($R[graph_type] == "Pie3d"){ echo "checked"; } ?>>
<img src="../images/graph_pie.gif" width="32" height="32" border="0" align="middle">
</div>
</div>

			  
<!--<table width="100%"  class="table table-bordered">
						  <tr align="center">
                              <td width="10%">&nbsp;</td>
                              <td width="40%">&nbsp;</td>
							  <td width="10%">&nbsp;</td>
							  <td width="40%">&nbsp;</td>
                            </tr>
                            <tr align="center"> 
							<td align="right" ><input type="radio" name="g_type" value="Area" <?php if($R[graph_type] == "Area"){ echo "checked"; } ?>></td>
                              <td align="left"><img src="../images/graph_area.gif" width="32" height="32" border="0" align="absmiddle"> 
                                Area Graph</td>
								<td align="right" ><input type="radio" name="g_type" value="Line" <?php if($R[graph_type] == "Line"){ echo "checked"; } ?>></td>
                              <td align="left"><img src="../images/graph_line.gif" width="32" height="32" border="0" align="absmiddle"> 
                                Line Graph</td>
                            </tr>
                            <tr align="center"> 
							<td align="right" ><input type="radio" name="g_type" value="Column" <?php if($R[graph_type] == "Column"){ echo "checked"; } ?>></td>
                              <td align="left"><img src="../images/graph_column.gif" width="32" height="32" border="0" align="absmiddle"> 
                                Column Graph</td>
								
                              <td align="right" ><input type="radio" name="g_type" value="Column3d" <?php if($R[graph_type] == "Column3d"){ echo "checked"; } ?>></td>
                              <td align="left"><img src="../images/graph_column.gif" width="32" height="32" border="0" align="absmiddle"> 
                                Column Graph 3D</td>
                            </tr>
                            <tr align="center"> 
							<td align="right" ><input type="radio" name="g_type" value="Bar" <?php if($R[graph_type] == "Bar"){ echo "checked"; } ?>></td>
                              <td align="left"><img src="../images/graph_row.gif" width="32" height="32" border="0" align="absmiddle"> 
                                Bar Graph</td>
								<td align="right" ><input type="radio" name="g_type" value="Bar3d" <?php if($R[graph_type] == "Bar3d"){ echo "checked"; } ?>></td>
                              <td align="left"><img src="../images/graph_row.gif" width="32" height="32" border="0" align="absmiddle"> 
                                Bar Graph 3D</td>
                            </tr>
                            <tr align="center">
							<td align="right" ><input type="radio" name="g_type" value="Pie" <?php if($R[graph_type] == "Pie"){ echo "checked"; } ?>></td>
                              <td align="left"><img src="../images/graph_pie.gif" width="32" height="32" border="0" align="absmiddle"> 
                                Pie Graph (Only first column)</td>
								<td align="right" ><input type="radio" name="g_type" value="Pie3d" <?php if($R[graph_type] == "Pie3d"){ echo "checked"; } ?>></td>
                              <td align="left"><img src="../images/graph_pie.gif" width="32" height="32" border="0" align="absmiddle"> 
                                Pie Graph 3D (Only first column)</td>
                            </tr>
</table>-->



</td>
</tr>
<tr id="tr03" style="display:<?php if($tbshow == "03"){ echo '\'\''; }else{ echo "none"; } ?>">
                        <td>
<ul class="nav nav-tabs">
  <li><a href="#menu" onClick="document.all.tr01.style.display='';document.all.tr02.style.display='none';document.all.tr03.style.display='none';document.linkForm.tbshow.value='01';">Graph Settings</a></li>
  <li><a href="#design" onClick="document.all.tr01.style.display='none';document.all.tr02.style.display='';document.all.tr03.style.display='none';document.linkForm.tbshow.value='02';">Graph Style</a></li>
  <li class="active"><a href="#popup">Graph Data</a></li>
  <li><a href="#popup" onClick="graph_data.document.dataForm.todo.value='OnSubmit';graph_data.document.dataForm.submit();">Graph Preview</a></li> 
</ul>
						
						<!--<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
						<tr>
                              <td width="100" align="center" background="../images/bg1_off.gif"><a href="#menu" onClick="document.all.tr01.style.display='';document.all.tr02.style.display='none';document.all.tr03.style.display='none';document.linkForm.tbshow.value='01';">Graph 
                                Setting</a>s </td>
                              <td width="100" align="center" background="../images/bg1_off.gif"><a href="#design" onClick="document.all.tr01.style.display='none';document.all.tr02.style.display='';document.all.tr03.style.display='none';document.linkForm.tbshow.value='02';">Graph 
                                Style</a></td>
                              <td width="100" align="center" background="../images/bg1_on.gif">Graph 
                                Data</td>
								<td width="100" align="center" background="../images/bg3_off.gif"><a href="#popup" onClick="graph_data.document.dataForm.todo.value='OnSubmit';graph_data.document.dataForm.submit();">Graph Preview</a> </td><td background="../images/bg2_off.gif">
								&nbsp;
								</td>
								</tr>
						</table>-->
						
						
						<table width="100%" height="90%" border="0" cellpadding="0" cellspacing="1" bgcolor="#000000">
						<tr> 
                        <td bgcolor="#FFFFFF"><iframe name="graph_data" src="content_graph_data.php?graph_id=<?php echo $_GET["graph_id"]; ?>" frameborder="0" marginheight="0" marginwidth="0" width="100%" height="300" scrolling="yes"></iframe></td>
						</tr>
						</table></td>
						</tr>
						</table> </td>
						</tr>
						<tr valign="top"> 
						<td height="20" align="right">
						<input name="graph_id" type="hidden" id="graph_id" value="<?php echo $_GET["graph_id"]; ?>">
                    <input name="Flag" type="hidden" id="Flag" value="SaveGraph">
                    <input type="button" name="Button" value=" Save " class="btn btn-success btn-ml" onClick="graph_data.document.dataForm.todo.value='OnSubmit';graph_data.document.dataForm.submit();"> 
                    <input type="button" name="Submit2" value="Close" onClick="self.close();" class="btn btn-warning"></td>
                </tr>
              </table> </td>
        </tr>
      </table></td>
  </tr></form>
</table>
</body>
</html>
<?php $db->db_close(); ?>
