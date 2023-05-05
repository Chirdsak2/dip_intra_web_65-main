<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/config_path.php");
include("../header.php");
?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<?php include('link.php'); ?>
</head>
<script >
function ChkInput(c){
   if(c.vdog_name.value==""){
       alert('กรุณากรอกชื่อกลุ่ม');
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
		$sql = "SELECT * FROM vdo_group  WHERE vdog_id='$_GET[gid]'";
		$query=$db->query($sql);
		$data=$db->db_fetch_array($query);
?> 

<!--<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("แก้ไขกลุ่ม VDO : ".$data[vdog_name]);?>&module=video&url=<?php echo urlencode("vdo_group_edit.php?gid=".$_GET['gid']);?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="main_vdo_group.php" ><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0">กลับหน้าหลัก</a>
      <hr> </td>
  </tr>
</table>-->

<div class="panel panel-default" style="border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">

<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;">แก้ไขกลุ่ม VDO</h4>
</div>	

<div class="panel-body">

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
<a href="main_vdo_group.php" target="_self">
<!--<img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0"> 
<?php //echo $text_genbanner_back;?>-->
<button type="button" class="btn btn-info  btn-sm " >
        <span class="glyphicon glyphicon-backward"></span>&nbsp;&nbsp;<?="ย้อนกลับ";?>
</button>
</a>

</div>
</div>
<hr />
</div>

<div class="col-md-12 col-sm-12 col-xs-12" >
<form name="myForm" method="post" action="vdog_process.php">
<div class="form-group row">
      <div class="col-md-6 col-sm-6 col-xs-12">
        <label for="vdog_name"><?php echo "ชื่อกลุ่ม";?><span class="text-danger">*</span> : </label>
        <input class="form-control" name="vdog_name" type="text" id="vdog_name" size="60" value="<?=$data['vdog_name'];?>" />
      </div>

	  <div class="col-md-6 col-sm-6 col-xs-12">
        <label for="vdog_creator"><?php echo "ชื่อผู้สร้าง"; ?> : </label>
		  <input class="form-control" name="vdog_creator" type="text" id="vdog_creator" size="60" value="<?=$data['vdog_creator'];?>">
        
      </div>
</div>

<div class="form-group row">
      <div class="col-md-6 col-sm-6 col-xs-12">
      <label for="vdog_info">URLของแหล่งที่มา  :  </label>
        <input class="form-control" name="vdog_info" type="text" id="vdog_info" size="60" value="<?php echo $data['vdog_info'];?>">
      </div>
	  
	  <div class="col-md-6 col-sm-6 col-xs-12">
        <label for="vdog_downloadable">&nbsp;</label>
		<input name="vdog_downloadable" type="checkbox" value="1" <?php if($data['vdog_downloadable']=='1') { echo 'checked="checked"'; } ?>>&nbsp;สามารถ Download ได้</td>

        
      </div>
</div>
<div class="form-group row">	  
	  <div class="col-md-12 col-sm-12 col-xs-12" style="text-align:center">
<input type="submit" name="Submit2" value="&nbsp;&nbsp;บันทึก&nbsp;&nbsp;" onClick="return ChkInput(document.myForm)" class="btn btn-success btn-ml">
	  <input name="vdog_id" type="hidden" value="<?=$data['vdog_id'];?>">
	  <input name="flag" type="hidden"  value="edit"> 
      <input type="reset" name="Submit3" value="&nbsp;&nbsp;ยกเลิก&nbsp;&nbsp;" class="btn btn-warning">
      </div>
</div>
</form>
</div>

<!--<table width="100%" border="0" align="center" class="table table-bordered">
  <tr bgcolor="#E7E7E7" > 
    <td height="30" colspan="2" class="ewttablehead">แก้ไขกลุ่ม VDO</td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">ชื่อกลุ่ม <font color="#FF0000">*</font></td>
    <td width="62%"><input name="vdog_name" type="text" size="40" value="<?php //echo $data[vdog_name];?>"></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">ชื่อผู้สร้าง</td>
    <td width="62%"><input name="vdog_creator" type="text" size="40" value="<?php //echo $data[vdog_creator];?>"></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">URLของแหล่งที่มา </td>
    <td width="62%"><input name="vdog_info" type="text" size="40" value="<?php //echo $data[vdog_info];?>"></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">&nbsp;</td>
    <td width="62%"><input name="vdog_downloadable" type="checkbox" value="1" <?php //if($data['vdog_downloadable']=='1') { echo 'checked="checked"'; } ?>>&nbsp;สามารถ Download ได้</td>
  </tr>
  
  <tr bgcolor="#FFFFFF">
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit2" value="บันทึก" onClick="return ChkInput(document.myForm)">
	  <input name="vdog_id" type="hidden" value="<?php //echo $data[vdog_id];?>">
	  <input name="flag" type="hidden"  value="edit"> 
      <input type="reset" name="Submit3" value="ยกเลิก"></td>
  </tr>
</table>-->


</div>
<hr>
</div>
<?php
include('footer.php');
?>
</body>
</html>
<?php
$db->db_close(); ?>