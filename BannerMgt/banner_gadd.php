<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language/banner_language.php");
if($_GET["flag"] == 'add'){
$lable = 'เพิ่ม';
}else if($_GET["flag"] == 'edit'){
$lable = 'แก้ไข';
$sql_banner = "SELECT * FROM banner_group where banner_gid ='".$_GET["banner_id"]."' order by banner_gid";
$rec = $db->db_fetch_array($db->query($sql_banner));
$name = $rec[banner_name];
}

include("../lib/config_path.php");
include("../header.php");
?>

<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">

<?php include('link.php'); ?>
</head>
<script >
function CHK(t){
if(t.banner_gname.value == ''){
alert("กรุณากรอกชื่อกลุ่มป้ายโฆษณา!!!!!!");
return false;
}

}
</script>
<body leftmargin="0" topmargin="0">
<?php
include('top.php');
?>



<!--<div class="panel panel-default" style="border: 2px solid #FFC153;
    padding: 10px;
    border-radius: 4px;">
<div class="panel-body">
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="row">			
<div class="col-md-12 col-sm-12 col-xs-12" ><hr /> 
	<img src="../theme/main_theme/banner_function.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction">
	<?php echo $text_genbanner_function1;?></span> 
</div>    
</div>
</div>
</div>
</div>-->

<!--<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"> 
	<a href="main_group_banner.php" target="_self"><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0"> 
      <?php //echo $text_genbanner_manage;?>
	  </a>
      <hr>
    </td>
  </tr>
</table>-->
<div class="panel panel-default" style="border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
	
<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;"><?php echo $lable;?>หมวดป้ายโฆษณา</h4>
</div>		
	
<div class="panel-body">
<form name="form1" method="post" action="banner_gprocess.php" onSubmit="return CHK(this);">
<div class="form-group row">
<div class="col-md-4 col-sm-4 col-xs-12"></div>
<div class="col-md-4 col-sm-4 col-xs-12">
        <label for="banner_gname">ชื่อหมวดป้ายโฆษณา<span class="text-danger">*</span> : </label>
        <input class="form-control" name="banner_gname" type="text" id="banner_gname"  value="<?php echo $name?>" />
      </div>
<div class="col-md-4 col-sm-4 col-xs-12"></div>
</div>	  
<div class="form-group row">
<div class="col-md-4 col-sm-4 col-xs-12"></div>	  	  
<div class="col-md-4 col-sm-4 col-xs-12" style="text-align:center;">
      <input type="submit" name="Submit" value="<?php echo $text_genbanner_formupdate;?>" class="btn btn-success "  />
      <input type="hidden" name="flag" value="<?php echo $_GET['flag'];?>" />
	  <input type="hidden" name="banner_id" value="<?php echo $_GET['banner_id']?>" />
      </div>
<div class="col-md-4 col-sm-4 col-xs-12"></div>
</div>
</form>


<!--<form name="form1" method="post" action="banner_gprocess.php" onSubmit="return CHK(this);">
<div class="col-md-12 col-sm-12 col-xs-12" >
  <table width="90%" align="center" class="table table-bordered">
  <tr>
    <th height="23" colspan="2" class="ewttablehead"  scope="col"><div align="left"><?php //echo $lable;?>หมวดป้ายโฆษณา</div></th>
  </tr>
  <tr>
    <td width="30%" bgcolor="#FFFFFF">ชื่อหมวดป้ายโฆษณา<font style="color:#FF0000"> *</font></td>
    <td width="70%" bgcolor="#FFFFFF"><input name="banner_gname" type="text" size="50" value="<?php //echo $name?>" class="form-control" style="width:40%;">    </td>
  </tr>
  <tr>
    <td  bgcolor="#FFFFFF"></td>
    <td  bgcolor="#FFFFFF"><label>
      <input type="submit" name="Submit" value="<?php //echo $text_genbanner_formupdate;?>" class="btn btn-success">
&nbsp;&nbsp; </label>
      <input type="hidden" name="flag" value="<?php //echo $_GET["flag"];?>">
	  <input type="hidden" name="banner_id" value="<?php //echo $_GET[banner_id]?>">
      </label><!--img src="images/document_view.gif" height="24" width="24" align="absmiddle" alt="<?php //echo $text_genbanner_formlink3;?>" onClick="if(document.form1.banner_link.value != ''){window.open('banner_view.php?flag=link&img_name='+document.form1.banner_link.value+'','','width=500 , height=400,scrollbars=1,resizable = 1');}" style="cursor:hand"-></td>
  </tr>
</table>
<table width="90%" border="0" align="center">
  <tr>
    <th scope="col"><br>
      </th>
  </tr>
</table>
</form>-->


</div>
</div>
</div>
<?php
include('footer.php');
?>
</body>
</html>
<?php
$db->db_close(); ?>
