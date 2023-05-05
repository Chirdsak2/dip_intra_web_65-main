<?php
include("../EWT_ADMIN/comtop.php");
?>  
<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");

$db->query("USE ".$EWT_DB_USER);

	if($cmd == "del"){
	$sql_chk = "SELECT * FROM gen_user where title_thai = '{$title_id}' ";
	$query = $db->query($sql_chk);
	if($db->db_num_rows($query)==0){
			$sql = $db->query("DELETE FROM title WHERE title_id LIKE '{$title_id}' ");
			$sql_chk = $db->db_fetch_array($db->query("SELECT * FROM title where title_id LIKE '{$title_id}' "));
			$db->query("USE ".$_SESSION["EWT_SDB"]);
			$db->write_log("delete","member","ลบคำนำหน้า : ".$sql_chk['title_thai']."(".$sql_chk['title_eng'].")");
			$db->query("USE ".$EWT_DB_USER);
			echo "<script>";
			echo "alert('ลบข้อมูลเรียบร้อยแล้ว');";
			echo "document.location.href='TitleList.php'";
			echo "</script>";
		}else{
			echo "<script>";
			echo "alert('คำนำหน้านี้ ไม่สามารถลบได้เนื่องจากมีคนที่เป็นสมาชิกใช้อยู่!!!!!!!!!!');";
			echo "document.location.href='TitleList.php'";
			echo "</script>";
		}
	}
?>

<script src="../js/AjaxRequest.js"></script>
<script>
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

	 window.location.href='../multilangMgt/TitleList.php?langid='+g+'&lang='+lang+'&id='+ w;
}


</script>


<div id="nav" style="position:absolute;width:400px;  z-index:1;display:none" ></div>

<!--<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">บริหารคำนำหน้าชื่อ</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("บริหารคำนำหน้าชื่อ");?>&module=org&url=<?php echo urlencode("TitleList.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="TitleAdd.php?cmd=add"><img border="0" src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle"> 
     เพิ่มคำนำหน้าชื่อ</a> 
      <hr>
    </td>
  </tr>
</table>-->
<div class="panel panel-default" style="border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">

<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;"><?="บริหารคำนำหน้าชื่อ" ;?></h4>
</div>	

<div class="panel-body">

<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12">
</div>
<div class="col-md-6 col-sm-6 col-xs-12" style="text-align:right;" >

<a href="TitleAdd.php?cmd=add" title="เพิ่มคำนำหน้าชื่อ">
<button type="button" class="btn btn-info" >
        <span class="glyphicon glyphicon-plus-sign "></span>&nbsp;&nbsp;<?="เพิ่มคำนำหน้าชื่อ";?>
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
                <th width="80%" style="text-align:center" >&nbsp;คำนำหน้าชื่อภาษาไทย</th>
                <th width="10%" style="text-align:center" >ภาษาอื่น</th>
</tr>
<?php
				$sql = "SELECT * FROM title ORDER BY title_thai ASC";
				$query = $db->query($sql);
				while($rec = $db->db_fetch_array($query)){
				?>
                <tr >
				<td align="center" bgcolor="#FFFFFF" valign="top">
					<a href="TitleAdd.php?cmd=edit&title_id=<?php echo $rec[title_id];?>"><img src="../theme/main_theme/g_edit.gif" alt="แก้ไขข้อมูล" width="16" height="16" border="0" style="cursor:pointer"  title="แก้ไขข้อมูล"/></a>&nbsp;
					<a href="TitleList.php?cmd=del&title_id=<?php echo $rec[title_id];?>"><img src="../theme/main_theme/g_del.gif" alt="ลบข้อมูล" width="16" height="16" border="0" style="cursor:pointer" title="ลบข้อมูล" onClick="return confirm('ต้องการลบข้อมูลหรือไม่');"/></a>&nbsp;
					<a href="#G" onClick="txt_data('<?php echo $rec[title_id]; ?>','')"><img id="lang<?php echo $rec[title_id]; ?>" src="../images/b_fonts.gif" alt="สร้างภาษาอื่น" width="16" height="16" align="absmiddle" border="0"></a></td>
                <td height="20" align="left" bgcolor="#FFFFFF"><?php echo $rec[title_thai];?> </td>           
                <td height="20" align="left" bgcolor="#FFFFFF"><?php echo show_icon_lang_ewt($rec[title_id],'title');?></td> 
                </tr>
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
</div>				
				
			
<!-- END CONTAINER  -->
<?php
include("../EWT_ADMIN/combottom.php");
?>