<?php
include("../EWT_ADMIN/comtop.php");
?>  

<!-- START CONTAINER  -->
<div class="container-fluid" >
<?php
include("menu-top.php");

$db->query("USE ".$EWT_DB_USER);

	if($cmd == "del"){
		$sql = $db->query("delete from position_name WHERE pos_id LIKE '".$pos_id."%'");
		$sql_chk = $db->db_fetch_array($db->query("select * from position_name where pos_id LIKE '".$pos_id."'"));
		$db->query("USE ".$_SESSION["EWT_SDB"]);
		$db->write_log("delete","member","ลบตำแหน่ง : ".$sql_chk['pos_name']);
		$db->query("USE ".$EWT_DB_USER);
		echo "<script language=\"javascript\">";
		echo "alert('ลบข้อมูลเรียบร้อยแล้ว');";
		echo "document.location.href='PositionList.php'";
		echo "</script>";
	}
	if($cmd == "level"){
		for($i=0;$i<$_POST["num_p"];$i++){
			$pos_id = $_POST["pos_id".$i];
			$pos_num = $_POST["level_pos".$i];
			$sql_update = "update position_name set pos_level = '".$pos_num."' where pos_id = '".$pos_id."' ";
			$db->query($sql_update);
			$sql_chk = $db->db_fetch_array($db->query("select * from position_name where pos_id LIKE '".$pos_id."'"));
			$db->query("USE ".$_SESSION["EWT_SDB"]);
			$db->write_log("update","member","แก้ไขตำแหน่ง : ".$sql_chk['pos_name']."= ลำดับที่ : ".$pos_num);
			$db->query("USE ".$EWT_DB_USER);
		}
		echo "<script language=\"javascript\">";
		echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว');";
		echo "document.location.href='PositionList.php'";
		echo "</script>";
	}
	//unitname
	$sql = "select * from org_name where org_id = '".$_GET["org_id"]."'";
	$query = $db->query($sql);
	$rec_org = $db->db_fetch_array($query);
?>
<script src="../js/AjaxRequest.js"></script>

<div id="nav" style="position:absolute;width:400px;  z-index:1;display:none" ></div>

<div class="panel panel-default" style="border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">

<div class="panel-heading" style="background-color:#FFC153;border: 2px solid #FFC153;padding: 10px;border-radius: 4px;">
<h4 style="color:#FFFFFF;"><?="บริหารตำแหน่งภายในหน่วยงาน" ;?></h4>
</div>	

<div class="panel-body">

<div class="col-md-12 col-sm-12 col-xs-12" >
<div class="row">
<div class="col-md-6 col-sm-6 col-xs-12">
</div>
<div class="col-md-6 col-sm-6 col-xs-12" style="text-align:right;" >

<a href="PositionAdd.php?org_id=<?=$_GET['org_id'];?>&cmd=add" title="เพิ่มตำแหน่ง">
<button type="button" class="btn btn-info" >
        <span class="glyphicon glyphicon-plus-sign "></span>&nbsp;&nbsp;<?="เพิ่มตำแหน่ง";?>
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


<!--<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
<tr> 
<td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"><span class="ewtfunction">บริหารตำแหน่งภายในหน่วยงาน </span></td>
</tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
<tr>
<td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("บริหารตำแหน่งภายในหน่วยงาน");?>&module=org&url=<?php echo urlencode("PositionList.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="PositionAdd.php?org_id=<?php echo $_GET["org_id"];?>&cmd=add"><img src="../theme/main_theme/g_add.gif" width="16" height="16" border="0" align="absmiddle"> เพิ่มตำแหน่ง</a> &nbsp;&nbsp;&nbsp;
<hr>
</td>
</tr>
</table>-->


<div class="col-md-12 col-sm-12 col-xs-12" >
<form name="form1" method="post" action="" onSubmit="return CHK(this);">
<table width="100%" class="table table-bordered">
<tr class="ewttablehead">
<th width="10%" style="text-align:center">&nbsp;</th>
<th width="60%" style="text-align:center">ชื่อตำแหน่งหน่วยงาน</th>
<th width="15%" style="text-align:center">ภาษาอื่น</th>
<th width="15%" style="text-align:center">ลำดับความสำคัญของตำแหน่ง<br>
[แก้ไขลำดับ<a href="#" onClick="show_edit_level();"><img src="../theme/main_theme/g_edit.gif" alt="คลิกที่นี่เมื่อต้องการแก้ไขลำดับความสำคุญของตำแหน่ง" width="16" height="16" border="0"></a>]
</th>
</tr>
<?php 
$sql_pos = "SELECT * FROM position_name ORDER BY pos_level,pos_name ASC";
$query_pos = $db->query($sql_pos);
$num_pos = $db->db_num_rows($query_pos);
if($num_pos >0){
for($i_pos = 0 ;$i_pos <$num_pos ;$i_pos++){
$result_pos = $db->db_fetch_array($query_pos);

?>
<tr bgcolor="#FFFFFF">
<td align="center" bgcolor="#FFFFFF"><nobr><a href="PositionAdd.php?cmd=edit&pos_id=<?php echo $result_pos[pos_id];?>"><img src="../theme/main_theme/g_edit.gif" alt="แก้ไขข้อมูล" width="16" height="16" border="0"> </a> <a href="PositionList.php?cmd=del&pos_id=<?php echo $result_pos[pos_id];?>"><img src="../theme/main_theme/g_del.gif" alt="ลบข้อมูล" width="16" height="16" border="0" onClick="return confirm('ต้องการลบข้อมูลหรือไม่');"></a> &nbsp;<a href="#G" onClick="txt_data('<?php echo $result_pos[pos_id]; ?>','')"><img id="lang<?php echo $result_pos[pos_id]; ?>" src="../images/b_fonts.gif" alt="สร้างภาษาอื่น" width="16" height="16" align="absmiddle" border="0"></a></nobr></td>
<td><?php echo $result_pos[pos_name];?></td>
<td><?php echo show_icon_lang_ewt($result_pos[pos_id],'position_name');?></td>
<td align="center" bgcolor="#FFFFFF"><input name="level_pos<?php echo $i_pos;?>" type="text" id="level_pos<?php echo $i_pos;?>" value="<?php echo $result_pos[pos_level];?>" size="5" maxlength="3" onKeyUp="chkformatnum(this)" disabled="disabled"><input name="pos_id<?php echo $i_pos;?>" type="hidden" value="<?php echo $result_pos[pos_id];?>"></td>
</tr>

<?php 			}// end for
}//end if
?>
<tr bgcolor="#FFFFFF">
<td colspan="3" align="center" bgcolor="#FFFFFF">&nbsp;</td>
<td align="center" bgcolor="#FFFFFF">
<input type="submit" name="Submit" value="บันทึก" disabled="disabled" class="btn btn-success btn-ml" >
<input type="hidden" name="cmd" value="level">
<input type="hidden" name="num_p" value="<?php echo $num_pos;?>">
</td>
</tr>
<?php 
if($num_pos ==0){
?>
<tr align="right" bgcolor="#FFFFFF">
<td colspan="4" align="center"><font color="#FF0000">---ไม่พบข้อมูล---</font></td>
</tr>
<?php } ?>
</table>
</form>
</div>

</div>				
</div>				
</div>				
<!-- END CONTAINER  -->
<?php
include("../EWT_ADMIN/combottom.php");
?>
<script language="javascript">
function CHK(t){
var num = document.form1.num_p.value;
var value_chk = '';
var i = 0;
for(i=0;i<num;i++){
if(self.document.getElementById("level_pos"+i).value == ''){
value_chk +=1;
}else{
value_chk +=0;
}
}
if(value_chk > 0){
alert("กรุณาใส่ลำดับความสำคัญให้ครบทุกตำแหน่ง!!!!!");
return false;
}
return true;
}
function show_edit_level(){
var num = document.form1.num_p.value;
var i = 0;
for(i=0;i<num;i++){
self.document.getElementById("level_pos"+i).disabled=false;

}
self.document.form1.Submit.disabled=false;
}
function isNum (charCode) 
{
if (charCode >= 48 && charCode <= 57 )
return true;
else
return false;
}
function chkFormatNam (str) {//0-9
strlen = str.length;
for (i=0;i<strlen;i++)
{
var charCode = str.charCodeAt(i);
if (!isNum(charCode) && (charCode!=46) && (charCode!=44)) {
return false;
}
}
return true;
}
function chkformatnum(t){ 
_MyObj = t;
_MyObj_Name = t.name;
_MyObj_Value = t.value;
_MyObj_Strlen =_MyObj_Value.length; 
if( _MyObj_Strlen >1 && _MyObj_Value.substr(0,1)==0){
t.value = _MyObj_Value.substr(1);
}
if(!chkFormatNam (t.value)){
alert('กรุณากรอกตัวเลขเท่านั้น');
t.value = 0;
t.focus();
} 
}
</script>
<?php
$db->db_close(); ?>
<script language="javascript1.2">
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

	 window.location.href='../multilangMgt/PositionList.php?langid='+g+'&lang='+lang+'&id='+ w;
}


</script>
