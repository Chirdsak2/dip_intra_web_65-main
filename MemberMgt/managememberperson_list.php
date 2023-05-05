<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
include("../lib/set_lang.php");
if($_POST[flag]=='tools'){
	for($i=0;$i<count($_POST[gen_user_id]);$i++){
		$sql_edit = "UPDATE gen_user SET level_id='".$_POST[level_pos][$i]."'  WHERE gen_user_id = '".$_POST[gen_user_id][$i]."' ";
		$db->query($sql_edit);
			$rec=$db->db_fetch_array($db->query("select * from gen_user WHERE gen_user_id = '".$_POST[gen_user_id][$i]."' "));
			$db->query("USE ".$EWT_DB_NAME);
			$db->write_log("update","member","เรียงลำดับพนักงาน ".$rec[name_thai].'   '.$rec[surname_thai]);
			$db->query("USE ".$EWT_DB_USER);
	}
			echo "<script language=\"javascript\">";
			echo "alert('บันทึกข้อมูลเรียบร้อยแล้ว');";
			echo "document.location.href='managememberperson_list.php?org_id=".$_POST[org_id]."';" ;
			echo "</script>";	
}
	?>
<html>
<head>
<title>Member Management</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script src="../js/AjaxRequest.js"></script>
<script src="../js/excute.js"></script>
<script src="../BannerMgt/js/jquery/jquery.core.js"></script>
<script src="../BannerMgt/js/jquery/jquery.tablednd.js"></script>
<script language="javascript">
function isNum (charCode) {
	if (charCode >= 48 && charCode <= 57 ) return true;
	else return false;
}
function chkFormatNam (str) {//0-9
	strlen = str.length;
	for (i=0;i<strlen;i++) {
		var charCode = str.charCodeAt(i);
		if (!isNum(charCode) && (charCode!=46) && (charCode!=44)) {
			return false;
		}
	}
	return true;
}
function chkformatnum(t) { 
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
function txt_data(w) {
	var mytop = findPosY(document.form1.org_id) +document.form1.org_id.offsetHeight;
	var myleft = findPosX(document.form1.org_id);	
	var objDiv = document.getElementById("nav");
	objDiv.style.top = mytop;
	objDiv.style.left = myleft;
	objDiv.style.display = '';
	url='nav_pad.php?d='+ w;
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
</script>
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
		function txt_data2(w,g) {
	
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

	 window.location.href='../multilangMgt/MemberList.php?langid='+g+'&lang='+lang+'&id='+ w;
}


</script>

</head>
<body leftmargin="0" topmargin="0" >
<?php include("../FavoritesMgt/favorites_include.php");?>
<div id="nav" style="position:absolute;width:400px;  z-index:1;display:none" ></div>
	<form name="frm1" action="managememberperson_list.php" method="post">
  <table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
    <tr>
      <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction">บุคลากร</span> </td>
    </tr>
  </table>
  <?php
  $sql_o = "select * from org_name where  org_id ='".$_GET["org_id"]."' ";
  $queryo = $db->query($sql_o);
  $RO = $db->db_fetch_array($queryo);
  ?>
  <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
    <tr>
      <td align="right"> <a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("จัดเรียงบุคคลากร   ".$RO[name_org]);?>&module=org&url=<?php echo urlencode("managememberperson_list.php?org_id=".$_GET["org_id"]);?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;<?php if($_SESSION["EWT_SMID"] == "" || $_SESSION["EWT_SMTYPE"] == 'Y'){  ?><a href="managememberperson.php"><img src="../theme/main_theme/g_back.png" width="16" height="16" border="0" align="absmiddle"> 
     กลับ</a><?php }?>
        <hr>
      </td>
    </tr>
	</table>
  <table width="94%" border="0" align="center" cellpadding="1" cellspacing="1" class="ewttableuse" id="table-1">
                    <tr class="nodrop  nodrag ewttablehead">
                      <td width="5%" height="25" align="center" >&nbsp;</td>
                      <td >ชื่อ - สกุล </td>
                      <td width="37%" >ตำแหน่งภายในหน่วยงาน</td>
                      <td width="29%" >ตำแหน่งทางวิชาการ</td>
                      <td align="center" >ลำดับการเรียง</td>
                    </tr>
					<?php
				
					$uploaddir = "../ewt/pic_upload/";
					
		$sql="SELECT *
FROM
  `gen_user`
  LEFT OUTER JOIN `emp_type` ON (`gen_user`.`emp_type_id` = `emp_type`.`emp_type_id`)
  LEFT OUTER JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`)  
  LEFT OUTER JOIN `position_name` ON (`gen_user`.`posittion` = `position_name`.`pos_id`)  
  where  gen_user.org_id = '$org_id' and emp_type.emp_type_status = '2'  order by gen_user.level_id ASC";
					$sql_member = $sql;//." LIMIT $offset,$limit ";
					$query = $db->query($sql_member);
					$num_rows = $db->db_num_rows($query);
					$rows = mysql_num_rows($db->query($sql));
					$i = 1;
					if(!empty($num_rows)){
					while($rec = $db->db_fetch_array($query)){
					//print_r($rec);
						if($bg == "#FFFFFF"){
							$bg = "#FFF8EC";
						}else{
							$bg = "#FFFFFF";
						}
							$gen_user_id=$rec[gen_user_id];
							$title_thai=$rec[title_thai];
							$name_thai=$rec[name_thai];
							$surname_thai=$rec[surname_thai];
							$emp_type_name=$rec[emp_type_name];
							$name_org=$rec[name_org];
							$level_name=$rec[level_name];
							$level_id=$rec[level_id];
							$path_image1 = $rec[path_image];
							if($path_image1 != ''){
							   $path_image=$uploaddir.$path_image1;
							   if(file_exists($path_image)){
								$path_image = $path_image;
								}else{
								$path_image = "../images/ImageFile.gif";
								}
							}else{
							   $path_image="../images/ImageFile.gif";
							}
						?>
						<tr bgcolor="<?php echo $bg?>"  id="<?php echo $i;?>" onMouseOver="this.style.backgroundColor='#FEFEEB';this.style.color='#FF6600'" onMouseOut="this.style.backgroundColor='<?php echo $bg?>';this.style.color='#000000'">
						  <td height="20" align="center" bgcolor="#FFFFFF">
						  <img src="../FileMgt/phpThumb.php?src=<?php echo $path_image; ?>&h=80&w=80" border=0></td>
						  <td bgcolor="#FFFFFF">&nbsp;<?php echo $name_thai;?> <?php echo $surname_thai;?></td>
						  <td bgcolor="#FFFFFF">&nbsp;<?php if($rec[pos_name] != ''){echo $rec[pos_name];}else{ echo '-';}?></td>
						  <td bgcolor="#FFFFFF">&nbsp;<?php echo $rec[position_person];?></td>
						  <td align="center" bgcolor="#FFFFFF">
						  <input type="text" name="level_pos[]" id="level_pos"  size="5" value="<?php if($level_id != ''){echo $level_id;}else{echo $i;}?>" onKeyUp="chkformatnum(this)" >
								<input type="hidden" name="gen_user_id[]" id="gen_user_id"   value="<?php echo $gen_user_id;?>"></td>
				        </tr>
						<?php
								$i++;
								
						}//end while
						?>    
					<tr bgcolor="#FFFFFF" class="nodrop  nodrag ">
					  <td colspan="4" align="center">&nbsp;</td>
                      <td align="center"><input type="hidden" name="flag" value="tools"> <input type="hidden" name="org_id" value="<?php echo $_GET[org_id]?>"><input type="Button" name="Submit" value="บันทึกข้อมูล" onClick="document.frm1.submit();"></td>
	</tr><?php
					}else{
					?>
					<tr bgcolor="#FFFFFF" class="nodrop  nodrag ">
						  <td colspan="5" align="center">ไม่พบข้อมูล</td>

					
					<?php
					}
					?>
</table>

<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="30">&nbsp;</td>
  </tr>
</table>
</form>
</body>
</html>
<script type="text/javascript">
$(document).ready(function() {
	$('#table-1').tableDnD( {
		onDrop: function(table, row) {
			var level_pos = $('* > #level_pos');
			for(var i=0; i<level_pos.length; i++) {
				jQuery(level_pos[i]).val(i+1);
			}
        }
	});
});
</script>
<?php $db->db_close(); ?>
