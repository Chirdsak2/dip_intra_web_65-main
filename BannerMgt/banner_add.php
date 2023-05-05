<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language/banner_language.php");
$sql_banner = "SELECT * FROM banner_group where banner_gid ='{$_GET[banner_gid]}' order by banner_gid";
$rec = $db->db_fetch_array($db->query($sql_banner));
$gname = $rec['banner_name'];

include("../lib/config_path.php");
include("../header.php");
?>
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<link href="../css/style_calendar.css" rel="stylesheet" type="text/css">
<script type="text/javascript" src="../js/calendar.js"></script>
<script type="text/javascript" src="../js/loadcalendar.js"></script>
<script type="text/javascript" src="../js/calendar-th.js"></script>
<?php include('link.php'); ?>
</head>
<script>
function CHK(){
	
if(document.form1.banner_name.value == ''){
alert("กรุณากรอกชื่อป้ายโฆษณา!!!!!!");
document.form1.banner_name.focus();
return false;
}
if(document.form1.banner_pic.value == ''){
alert("เลือกภาพป้ายโฆษณา!!!!!!");
document.form1.banner_pic.focus();
return false;
}
if(document.form1.banner_link.value == ''){
alert("เลือกการเชื่อมโยง!!!!!!");
document.form1.banner_link.focus();
return false;
}
}
</script>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<?php
include('top.php');
?>

<!--<div class="panel panel-default" style="border: 2px solid #FFC153;
    padding: 10px;
    border-radius: 5px;">
<div class="panel-body">
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="row">			
<div class="col-md-12 col-sm-12 col-xs-12" ><hr /> 
	<img src="../theme/main_theme/banner_function.gif" width="32" height="32" align="middle"> 
	<span class="ewtfunction"><?php //echo $text_genbanner_function1;?> >> <a href="main_banner.php?banner_gid=<?php //echo $_GET[banner_gid];?>">หมวด&nbsp;&nbsp;<?php //echo $gname;?></a></span> 
</div>    
</div>
</div>
</div>
</div>-->

<!--<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php //echo urlencode("เพิ่ม".$text_genbanner_function1.">>หมวด".$gname);?>&module=banner&url=<?php //echo urlencode("banner_add.php?banner_gid=".$_GET["banner_gid"]);?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="banner_add.php?flag=add&banner_gid=<?php //echo $banner_gid;?>" target="_self"><img src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle" border="0"> 
      <?php //echo $text_genbanner_addnew;?></a> &nbsp;<a href="main_banner.php?banner_gid=<?php //echo $banner_gid;?>" target="_self"><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0"> 
      <?php //echo $text_genbanner_back;?></a>
      <hr>
    </td>
  </tr>
</table>-->



<div class="panel panel-default" style="border: 2px solid #FFC153;padding: 10px;border-radius: 5px;">
	
<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;"><?php echo $text_genbanner_formadd;?> <span class="glyphicon glyphicon-triangle-right"></span> <a href="main_banner.php?banner_gid=<?=$_GET['banner_gid'];?>">หมวด&nbsp;&nbsp;<?=$gname;?></a></h4>
</div>		
<div class="panel-body" >

<div class="col-md-12 col-sm-12 col-xs-12" style="text-align:right;" >
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12"></div>
<div class="col-md-6 col-sm-6 col-xs-12" style="text-align:right;" >
<!--<a href="banner_add.php?flag=add&banner_gid=<?php echo $banner_gid;?>" target="_self">
<img src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle" border="0"> 
      <?php //echo $text_genbanner_addnew;?>
<button type="button" class="btn btn-info  btn-sm " >
        <span class="glyphicon glyphicon-plus-sign "></span>&nbsp;&nbsp;<?=$text_genbanner_addnew;?>
</button>	  	  
</a> &nbsp;-->
<a href="main_banner.php?banner_gid=<?php echo $banner_gid;?>" target="_self">
<!--<img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0"> 
<?php //echo $text_genbanner_back;?>-->
<button type="button" class="btn btn-info  btn-sm " >
        <span class="glyphicon glyphicon-backward"></span>&nbsp;&nbsp;<?=$text_genbanner_back;?>
</button>
</a>
</div>
</div>
<hr />
</div>


<form name="form1" method="post" action="banner_process.php" onSubmit="return CHK();">
<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12">
        <label for="banner_gname"><?php echo $text_genbanner_formname;?><span class="text-danger">*</span> : </label>
        <input class="form-control" name="banner_name" type="text" id="banner_name"  value="" >
      </div>
	
<div class="col-md-6 col-sm-6 col-xs-12">
        <label for="banner_detail"><?php echo $text_genbanner_formdetail;?> : </label>
       <textarea class="form-control" rows="5" id="banner_detail" name="banner_detail"  id="banner_detail"></textarea>
      </div>
</div>	

<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12 form-inline">
        <label for="banner_pic"><?php echo $text_genbanner_formpic;?><span class="text-danger">*</span> : </label>
        <input class="form-control" name="banner_pic" type="text" id="banner_pic"  value="" > <img src="images/folder_img.gif" height="20" width="20" align="absmiddle" alt="<?php echo $text_genbanner_formpic2;?>" style="cursor:hand" onClick="window.open('../FileMgt/gallery_insert.php?stype=images&Flag=Link&o_value=window.opener.document.all.banner_pic.value','','width=800 , height=500');"> 
      </div>
	
<div class="col-md-6 col-sm-6 col-xs-12 form-inline">
        <label for="banner_link"><?php echo $text_genbanner_formlink;?><span class="text-danger">*</span> : </label>
	   <input class="form-control" name="banner_link" type="text" id="banner_link"  value="" >   <img src="images/folder_closed.gif" height="16" width="16" align="absmiddle" alt="<?php echo $text_genbanner_formlink2;?>" style="cursor:hand" onClick="window.open('../FileMgt/website_main.php?stype=link&Flag=Link&o_value=window.opener.document.all.banner_link.value','','width=800 , height=500');">  
        <select name="target_link" class="form-control"  >
          <option value="_self"><?php echo $text_genbanner_optionlink1;?></option>
          <option value="_blank"><?php echo $text_genbanner_optionlink2;?></option>
        </select>
      </div>
</div>

<div class="form-group row ">
<div class="col-md-4 col-sm-4 col-xs-12 form-inline">
        <label for="txt_alt"><?php echo $text_genbanner_formalt;?> : </label>
       <input class="form-control"  name="txt_alt" type="text" id="txt_alt" >
</div>
	
<div class="col-md-4 col-sm-4 col-xs-12 form-inline" >
        <label for="start_date">วันแสดง   : </label>
        <input class="form-control"   name="start_date" type="text"  id="start_date"> 
		<a href="#date" onClick="return showCalendar('start_date', 'dd-mm-y');" >
		<img src="../images/bar_calendar.gif" width="20" height="20" border="0" align="middle"></a>
</div>		
<div class="col-md-4 col-sm-4 col-xs-12 form-inline" >		
		<label for="end_date">สิ้นสุด  : </label>
		<input class="form-control"    name="end_date" type="text"  id="end_date">
		<a href="#date" onClick="return showCalendar('end_date', 'dd-mm-y');" > <img src="../images/bar_calendar.gif" width="20" height="20" border="0" align="middle"></a>
</div>
</div>

<div class="form-group "  style="text-align:center;">
<input type="submit" name="Submit" value="<?=$text_genbanner_formupdate;?>" class="btn btn-success">
<input type="hidden" name="flag" value="add">
<input type="hidden" name="banner_gid" value="<?=$_GET['banner_gid']?>">
</div>
 <hr>
</form>
</div>
</div>
  
  
  
  <!--<table width="90%" border="0" align="center" class="table table-bordered">
  <tr>
    <th height="23" colspan="2" class="ewttablehead"  scope="col"><div align="left"><?php echo $text_genbanner_formadd;?> </div></th>
  </tr>
  <tr>
    <td width="25%"  bgcolor="#FFFFFF"><?php echo $text_genbanner_formname;?> :<font style="color:#FF0000"> *</font></td>
    <td width="75%"  bgcolor="#FFFFFF"><input class="form-control" style="width:40%;"  name="banner_name" type="text" size="50" value="<?php echo $name?>">    </td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><?php echo $text_genbanner_formdetail;?> :</td>
    <td bgcolor="#FFFFFF"><textarea class="form-control" style="width:40%;"  name="banner_detail" cols="100" rows="6"><?php echo $detail?>
</textarea>    </td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><?php echo $text_genbanner_formpic;?> :<font style="color:#FF0000"> *</font></td>
    <td bgcolor="#FFFFFF"><input class="form-control"  name="banner_pic" type="text" size="50" >
        <img src="images/folder_img.gif" height="20" width="20" align="absmiddle" alt="<?php echo $text_genbanner_formpic2;?>" style="cursor:hand" onClick="window.open('../FileMgt/gallery_insert.php?stype=images&Flag=Link&o_value=window.opener.document.all.banner_pic.value','','width=800 , height=500');"> 
        <!--img src="images/document_view.gif" height="24" width="24" align="absmiddle" alt="<?php echo $text_genbanner_formpic3;?>" onClick=" if(document.form1.banner_pic.value != ''){window.open('banner_view.php?flag=img&img_name='+document.form1.banner_pic.value+'','','width=800 , height=550,scrollbars=1,resizable = 1');}" style="cursor:hand"-></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><?php echo $text_genbanner_formlink;?> :<font style="color:#FF0000"> *</font></td>
    <td bgcolor="#FFFFFF"><input class="form-control"   name="banner_link" type="text" size="50">
        <img src="images/folder_closed.gif" height="16" width="16" align="absmiddle" alt="<?php echo $text_genbanner_formlink2;?>" style="cursor:hand" onClick="window.open('../FileMgt/website_main.php?stype=link&Flag=Link&o_value=window.opener.document.all.banner_link.value','','width=800 , height=500');">  
        <!--img src="images/document_view.gif" height="24" width="24" align="absmiddle" alt="<?php echo $text_genbanner_formlink3;?>" onClick="if(document.form1.banner_link.value != ''){window.open('banner_view.php?flag=link&img_name='+document.form1.banner_link.value+'','','width=500 , height=400,scrollbars=1,resizable = 1');}" style="cursor:hand"->  
        <select name="target_link" class="form-control" style="width:20%;" >
          <option value="_self"><?php echo $text_genbanner_optionlink1;?></option>
          <option value="_blank"><?php echo $text_genbanner_optionlink2;?></option>
        </select>        </td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><?php echo $text_genbanner_formalt;?> : </td>
    <td bgcolor="#FFFFFF"><input class="form-control" style="width:30%;"  name="txt_alt" type="text" id="txt_alt" size="50"></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF">วันแสดง :</td>
    <td bgcolor="#FFFFFF">เริ่มต้น :
      <input class="form-control" style="width:10%;"  name="start_date" type="text" size="10" id="start_date"> 
      
	  <a href="#date" onClick="return showCalendar('start_date', 'dd-mm-y');" ><img src="../images/bar_calendar.gif" width="20" height="20" border="0" align="absmiddle"></a>
      สิ้นสุด : 
      <input class="form-control" style="width:10%;"  name="end_date" type="text" size="10" id="end_date">
     
	  <a href="#date" onClick="return showCalendar('end_date', 'dd-mm-y');" > <img src="../images/bar_calendar.gif" width="20" height="20" border="0" align="absmiddle"></a></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"></td>
    <td bgcolor="#FFFFFF"><label>
      <input type="submit" name="Submit" value="<?php echo $text_genbanner_formupdate;?>" class="btn btn-success">
&nbsp;&nbsp; </label>
      <label>
      <input type="hidden" name="flag" value="add">
	  <input type="hidden" name="banner_gid" value="<?php echo $_GET[banner_gid]?>">
      </label><!--img src="images/document_view.gif" height="24" width="24" align="absmiddle" alt="<?php echo $text_genbanner_formlink3;?>" onClick="if(document.form1.banner_link.value != ''){window.open('banner_view.php?flag=link&img_name='+document.form1.banner_link.value+'','','width=500 , height=400,scrollbars=1,resizable = 1');}" style="cursor:hand"-></td>
  </tr>
</table>-->



<?php
include('footer.php');
?>
</body>
</html>
<?php
$db->db_close(); ?>
