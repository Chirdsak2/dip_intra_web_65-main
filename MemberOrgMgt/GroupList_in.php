<?php
header ("Content-Type:text/plain;charset=UTF-8"); 
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
	include("../lib/set_lang.php");
	if($cmd == "del"){
	$sql_chk = "select * from gen_user where emp_type_id ='$group_id' ";
	$query = $db->query($sql_chk);
	if($db->db_num_rows($query)==0){
			$sql = $db->query("delete from emp_type WHERE emp_type_id LIKE '".$group_id."'");
			echo "<script language=\"javascript\">";
			echo "alert('ลบข้อมูลเรียบร้อยแล้ว');";
			echo "document.location.href='GroupList_in.php'";
			echo "</script>";
		}else{
			echo "<script language=\"javascript\">";
			echo "alert('กลุ่มนี้ไม่สามารถลบได้เนื่องจากมีคนที่เป็นสมาชิกกลุ่มอยู่!!!!!!!!!!');";
			echo "document.location.href='GroupList_in.php'";
			echo "</script>";
		}
		$rec = $db->db_fetch_array($query);
		$db->query("USE ".$_SESSION["EWT_SDB"]);
		$db->write_log("delete","member","ลบกลุ่มบุคคลภายใน : ".$rec['emp_type_name']);
		$db->query("USE ".$EWT_DB_USER);
	}
	
include("../lib/config_path.php");
include("../header.php");	
?>
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<?php include('link.php'); ?>
<script src="../js/AjaxRequest.js"></script>
</head>
<body leftmargin="0" topmargin="0">
<?php
include('top.php');
?>
<?php include("../FavoritesMgt/favorites_include.php");?>
<div id="nav" style="position:absolute;width:400px;  z-index:1;display:none" ></div>
<!--<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">บริหารกลุ่มบุคคลภายใน</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("บริหารกลุ่มบุคคลภายใน");?>&module=org&url=<?php echo urlencode("GroupList_in.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="GroupAdd_in.php?cmd=add"><img border="0" src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle"> 
     เพิ่มกลุ่มบุคคลภายใน</a> 
      <hr>
    </td>
  </tr>
</table>-->

<div class="panel panel-default" style="border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">

<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;"><?="บริหารกลุ่มบุคคลภายใน" ;?></h4>
</div>	

<div class="panel-body">

<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12">
</div>
<div class="col-md-6 col-sm-6 col-xs-12" style="text-align:right;" >

<a href="GroupAdd_in.php?cmd=add" title="เพิ่มกลุ่มบุคคลภายใน">
<button type="button" class="btn btn-info" >
        <span class="glyphicon glyphicon-plus-sign "></span>&nbsp;&nbsp;<?="เพิ่มกลุ่มบุคคลภายใน";?>
</button>	  	  
</a>
<!--<a href="ewt_permission0.php" target="_self">
<button type="button" class="btn btn-info  btn-sm " >
       <span class="glyphicon glyphicon-backward"></span>&nbsp;&nbsp;<?="ย้อนกลับ";?>
</button>
</a>-->


</div>
</div>
<hr />
</div>	
<div class="clearfix">&nbsp;</div>

<div class="col-md-12 col-sm-12 col-xs-12" >
<table width="100%" class="table table-bordered">
                <tr class="ewttablehead">
				<th width="10%" style="text-align:center" >&nbsp;</th>
                <th width="80%" style="text-align:center">&nbsp;ชื่อกลุ่มบุคคลภายใน</th>
                <th width="10%" style="text-align:center">ภาษาอื่น</th>
                </tr>
				<?php
				$sql = "select * from emp_type where emp_type_status = '2' order by emp_type_name ASC";
				$query = $db->query($sql);
				while($rec = $db->db_fetch_array($query)){
				?>
                <tr >
				 <td align="center" bgcolor="#FFFFFF" valign="top">
				  <a href="GroupAdd_in.php?cmd=edit&group_id=<?php echo $rec[emp_type_id];?>"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" border="0" style="cursor:pointer"  title="แก้ไขข้อมูล"/></a>&nbsp;
				 <a href="GroupList_in.php?cmd=del&group_id=<?php echo $rec[emp_type_id];?>"><img src="../theme/main_theme/g_del.gif" width="16" height="16" border="0" style="cursor:pointer" title="ลบข้อมูล" onClick="return confirm('ต้องการลบข้อมูลหรือไม่');"/></a>&nbsp;
				 <a href="#G" onClick="txt_data('<?php echo $rec[emp_type_id]; ?>','')"> <img id="lang<?php echo $rec[emp_type_id]; ?>" src="../images/b_fonts.gif" alt="สร้างภาษาอื่น" width="16" height="16" align="absmiddle" border="0"></a></td>
                <td height="20" align="left" bgcolor="#FFFFFF"><?php echo $rec[emp_type_name];?>                
                <td height="20" align="left" bgcolor="#FFFFFF"><?php echo show_icon_lang_ewt($rec[emp_type_id],'emp_type');?>                                </tr>
             <?php } 
			 if(mysql_num_rows($query) == 0){
			 ?>
                <tr>
                  <td height="50" colspan="3" align="center" bgcolor="#FFFFFF">ไม่มีข้อมูล</td>
                </tr>
				<?php } ?>
</table>
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
<script >
function findPosX(obj)
{
 var curleft = 0;
 if (document.getElementById || document.all)
 {
  while (obj.offsetParent)
  {
   curleft += obj.offsetLeft
   obj = obj.offsetParent;
  }
 }
 else if (document.layers)
  curleft += obj.x;
 return curleft;
}
function findPosY(obj)
{
 var curtop = 0;
 if (document.getElementById || document.all)
 {
  while (obj.offsetParent)
  {
   curtop += obj.offsetTop
   obj = obj.offsetParent;
  }
 }
 else if (document.layers)
  curtop += obj.y;
 return curtop;
}
		function txt_data(w,g) {
	
	var mytop = findPosY(document.getElementById("lang"+w)) +document.getElementById("lang"+w).offsetHeight;
	var myleft = findPosX(document.getElementById("lang"+w));	
	var objDiv = document.getElementById("nav");
	objDiv.style.top = mytop;
	objDiv.style.left = myleft;
	objDiv.style.display = '';
	url='../language_set.php?gid='+g+'&id='+ w;
	AjaxRequest.get(
		{
			'url':url
			,'onLoading':function() { }
			,'onLoaded':function() { }
			,'onInteractive':function() { }
			,'onComplete':function() { }
			,'onSuccess':function(req) { 
					objDiv.innerHTML = req.responseText; 
					
			}
		}
	);
	
}
function txt_data1(w,g,lang) {

	 window.location.href='../multilangMgt/GroupList_in.php?langid='+g+'&lang='+lang+'&id='+ w;
}


</script>