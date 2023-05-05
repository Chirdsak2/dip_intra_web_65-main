<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../language/banner_language.php");

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
function CHK(t){
if(t.banner_name.value == ''){
alert("กรุณากรอกชื่อป้ายโฆษณา!!!!!!");
return false;
}
if(t.banner_pic.value == ''){
alert("เลือกภาพป้ายโฆษณา!!!!!!");
return false;
}
if(t.banner_link.value == ''){
alert("เลือกการเชื่อมโยง!!!!!!");
return false;
}
}
</script>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<?php
include('top.php');
?>

<?php
	if($_GET[banner_id]){
		$sql_banner = "SELECT * FROM banner WHERE banner_id = '".$_GET[banner_id]."' ";
		$query_banner = $db->query($sql_banner);
		$rs_banner = $db->db_fetch_array($query_banner);
		$name = $rs_banner[banner_name];
		$detail = $rs_banner[banner_detail];
		$pic = $rs_banner[banner_pic];
		$link = $rs_banner[banner_link];
		$target =  $rs_banner[banner_traget];
		$alt =  $rs_banner[banner_alt];
		if($rs_banner[banner_show_start] != ''){		
		$date_s=  explode('-',$rs_banner[banner_show_start]);
		$date_ss = $date_s[2].'/'.$date_s[1].'/'.$date_s[0];
		}
		if($rs_banner[banner_show_end] != ''){
		$date_e =   explode('-',$rs_banner[banner_show_end]);
		$date_ee = $date_e[2].'/'.$date_e[1].'/'.$date_e[0];
		}
		$banner_gid = $rs_banner[banner_gid];
	}
	if($_GET["banner_gid"] == ''){
	$_GET["banner_gid"] = $banner_gid;
	}
	$sql_banner = "SELECT * FROM banner_group where banner_gid ='".$_GET["banner_gid"]."' order by banner_gid";
$rec = $db->db_fetch_array($db->query($sql_banner));
$gname = $rec[banner_name];
?>

<!--<div class="panel panel-default" style="border: 2px solid #FFC153;
    padding: 10px;
    border-radius: 5px;">
<div class="panel-body">
<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="row">			
<div class="col-md-12 col-sm-12 col-xs-12" ><hr /> 
	<img src="../theme/main_theme/banner_function.gif" width="32" height="32" align="absmiddle"> 
	<span class="ewtfunction"><?php echo $text_genbanner_function1;?> >> <a href="main_banner.php?banner_gid=<?php echo $_GET[banner_gid];?>">หมวด&nbsp;&nbsp;<?php echo $gname;?></a></span> 
</div>    
</div>
</div>
</div>
</div>


<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("แก้ไข".$text_genbanner_function1.">>หมวด".$gname." :". $name);?>&module=banner&url=<?php echo urlencode("banner_edit.php?banner_id=".$_GET["banner_id"]);?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="banner_add.php?flag=add&banner_gid=<?php echo $banner_gid;?>" target="_self"><img src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle" border="0"> 
      <?php echo $text_genbanner_addnew;?></a>&nbsp;&nbsp;&nbsp;<a href="main_banner.php?banner_gid=<?php echo $banner_gid;?>" target="_self"><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0"> <?php echo $text_genbanner_back;?></a>    
      <hr>
    </td>
  </tr>
</table>-->

<div class="panel panel-default" style="border: 2px solid #FFC153;
    padding: 10px;
    border-radius: 5px;">
	
<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;"><?php echo $text_genbanner_formedit;?> <span class="glyphicon glyphicon-triangle-right"></span> <a href="main_banner.php?banner_gid=<?=$_GET['banner_gid'];?>">หมวด&nbsp;&nbsp;<?=$gname;?></a></h4>
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
        <input class="form-control" name="banner_name" type="text" id="banner_name"  value="<?php echo $name?>" >
      </div>
	
<div class="col-md-6 col-sm-6 col-xs-12">
        <label for="banner_detail"><?php echo $text_genbanner_formdetail;?> : </label>
       <textarea class="form-control" rows="5" id="banner_detail" name="banner_detail"  id="banner_detail"><?php echo $detail?></textarea>
      </div>
</div>	

<div class="form-group row">
<div class="col-md-6 col-sm-6 col-xs-12 form-inline">
        <label for="banner_pic"><?php echo $text_genbanner_formpic;?><span class="text-danger">*</span> : </label>
        <input class="form-control" name="banner_pic" type="text" id="banner_pic"  value="<?php echo $pic?>" > <img src="images/folder_img.gif" height="20" width="20" align="absmiddle" alt="<?php echo $text_genbanner_formpic2;?>" style="cursor:hand" onClick="window.open('../FileMgt/gallery_insert.php?stype=images&Flag=Link&o_value=window.opener.document.all.banner_pic.value','','width=800 , height=500');"> 
      <img src="../FileMgt/phpThumb.php?src=../ewt/<?php echo $_SESSION["EWT_SUSER"];?>/<?php echo $pic?>&h=50&w=150" border="2">
	  </div>
	
<div class="col-md-6 col-sm-6 col-xs-12 form-inline">
        <label for="banner_link"><?php echo $text_genbanner_formlink;?><span class="text-danger">*</span> : </label>
	   <input class="form-control" name="banner_link" type="text" id="banner_link"  value="<?php echo $link?>" >   <img src="images/folder_closed.gif" height="16" width="16" align="absmiddle" alt="<?php echo $text_genbanner_formlink2;?>" style="cursor:hand" onClick="window.open('../FileMgt/website_main.php?stype=link&Flag=Link&o_value=window.opener.document.all.banner_link.value','','width=800 , height=500');">  
        <select name="target_link" class="form-control"  >
          <option value="_self" <?php if($target  == '_self'){ echo 'selected';}?>><?php echo $text_genbanner_optionlink1;?></option>
          <option value="_blank" <?php if($target  == '_blank'){ echo 'selected';}?>><?php echo $text_genbanner_optionlink2;?></option>
        </select>
      </div>
</div>

<div class="form-group row ">
<div class="col-md-4 col-sm-4 col-xs-12 form-inline">
        <label for="txt_alt"><?php echo $text_genbanner_formalt;?> : </label>
       <input class="form-control"  name="txt_alt" type="text" id="txt_alt" value="<?php echo $alt;?>">
</div>
	
<div class="col-md-4 col-sm-4 col-xs-12 form-inline" >
        <label for="start_date">วันแสดง   : </label>
        <input class="form-control"   name="start_date" type="text"  id="start_date" value="<?php echo $date_ss;?>"> 
		<a href="#date" onClick="return showCalendar('start_date', 'dd-mm-y');" >
		<img src="../images/bar_calendar.gif" width="20" height="20" border="0" align="middle"></a>
</div>		
<div class="col-md-4 col-sm-4 col-xs-12 form-inline" >		
		<label for="end_date">สิ้นสุด  : </label>
		<input class="form-control"    name="end_date" type="text"  id="end_date" value="<?php echo $date_ee;?>">
		<a href="#date" onClick="return showCalendar('end_date', 'dd-mm-y');" > <img src="../images/bar_calendar.gif" width="20" height="20" border="0" align="middle"></a>
</div>
</div>

<div class="form-group "  style="text-align:center;">
<input type="submit" name="Submit" value="<?=$text_genbanner_formupdate;?>" class="btn btn-success">
 <input type="hidden" name="flag" value="edit">
      <input type="hidden" name="banner_id" value="<?php echo $_GET[banner_id]?>">
	  <input type="hidden" name="banner_gid" value="<?php echo $_GET[banner_gid]?>">
</div>
<hr>
</form>
</div>
</div>





<!--<table width="90%" border="0" align="center" class="table table-bordered">
  <tr>
    <th height="23" colspan="2" class="ewttablehead" scope="col"><div align="left">&nbsp;&nbsp;&bull;&nbsp;<?php echo $text_genbanner_formedit;?> </div></th>
  </tr>
  <tr>
    <td width="25%" bgcolor="#FFFFFF"><?php echo $text_genbanner_formname;?> <strong style="color:#FF0000">*</strong></td>
    <td width="75%" bgcolor="#FFFFFF"><input class="form-control" style="width:30%;" name="banner_name" type="text" size="50" value="<?php echo $name?>">    </td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><?php echo $text_genbanner_formdetail;?></td>
    <td bgcolor="#FFFFFF"><textarea name="banner_detail" cols="50" rows="3" class="form-control" style="width:30%;"><?php echo $detail?>
</textarea>    </td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><?php echo $text_genbanner_formpic;?><strong style="color:#FF0000">*</strong></td>
    <td bgcolor="#FFFFFF"><input class="form-control" style="width:30%;" name="banner_pic" type="text" size="50" value="<?php echo $pic?>">
        <img src="images/folder_img.gif" height="20" width="20" align="absmiddle" alt="<?php echo $text_genbanner_formpic2;?>" style="cursor:hand" onClick="window.open('../FileMgt/gallery_insert.php?stype=images&Flag=Link&o_value=window.opener.document.all.banner_pic.value','','width=800 , height=500');"> <!--img src="images/document_view.gif" height="24" width="24" align="absmiddle" alt="<?php echo $text_genbanner_formpic3;?>" onClick=" if(document.form1.banner_pic.value != ''){window.open('banner_view.php?flag=img&img_name='+document.form1.banner_pic.value+'','','width=800 , height=550,scrollbars=1,resizable = 1');}" style="cursor:hand"-><br>
        <br>
		<img src="../FileMgt/phpThumb.php?src=../ewt/<?php echo $_SESSION["EWT_SUSER"];?>/<?php echo $pic?>&h=50&w=150" border="2">
		</td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><?php echo $text_genbanner_formlink;?><strong style="color:#FF0000">*</strong></td>
    <td bgcolor="#FFFFFF"><input class="form-control" style="width:30%;" name="banner_link" type="text" size="50" value="<?php echo $link?>">
        <img src="images/folder_closed.gif" height="16" width="16" align="absmiddle" alt="<?php echo $text_genbanner_formlink2;?>" style="cursor:hand" onClick="window.open('../FileMgt/website_main.php?stype=link&Flag=Link&o_value=window.opener.document.all.banner_link.value','','width=800 , height=500');"> <!--img src="images/document_view.gif" height="24" width="24" align="absmiddle" alt="<?php echo $text_genbanner_formlink3;?>" onClick="if(document.form1.banner_link.value != ''){window.open('banner_view.php?flag=link&img_name='+document.form1.banner_link.value+'','','width=500 , height=400,scrollbars=1,resizable = 1');}" style="cursor:hand"->
        <select name="target_link" class="form-control" style="width:20%;">
          <option value="_self" <?php if($target  == '_self'){ echo 'selected';}?>><?php echo $text_genbanner_optionlink1;?></option>
          <option value="_blank" <?php if($target  == '_blank'){ echo 'selected';}?>><?php echo $text_genbanner_optionlink2;?></option>
        </select></td>
  </tr>
  <tr>
    <td bgcolor="#FFFFFF"><?php echo $text_genbanner_formalt;?></td>
    <td bgcolor="#FFFFFF"><input class="form-control" style="width:30%;" name="txt_alt" type="text" id="txt_alt" size="50" value="<?php echo $alt;?>"></td>
  </tr>
    <tr>
    <td bgcolor="#FFFFFF">วันแสดง</td>
    <td bgcolor="#FFFFFF">เริ่มต้น
      <input class="form-control" style="width:10%;" name="start_date" type="text" size="10" value="<?php echo $date_ss;?>" id="start_date"> 
      
	  <a href="#date" onClick="return showCalendar('start_date', 'dd-mm-y');" ><img src="../images/bar_calendar.gif" width="20" height="20" border="0" align="absmiddle"></a>
      สิ้นสุด 
      <input class="form-control" style="width:10%;" name="end_date" type="text" size="10" value="<?php echo $date_ee;?>" id="end_date">
     
	  <a href="#date" onClick="return showCalendar('end_date', 'dd-mm-y');" > <img src="../images/bar_calendar.gif" width="20" height="20" border="0" align="absmiddle"></a></td>
  </tr>
   <tr>
    <td bgcolor="#FFFFFF">&nbsp;</td>
    <td bgcolor="#FFFFFF">
	<input type="submit" name="Submit" value="<?php echo $text_genbanner_formupdate;?>" class="btn btn-success">
      
      <input type="hidden" name="flag" value="edit">
      <input type="hidden" name="banner_id" value="<?php echo $_GET[banner_id]?>">
	  <input type="hidden" name="banner_gid" value="<?php echo $_GET[banner_gid]?>">    </td>
  </tr>
</table>
</form>-->


<?php
include('footer.php');
?>
</body>
</html>
<?php
$db->db_close(); ?>
