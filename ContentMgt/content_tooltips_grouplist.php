<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
if(!$db->check_permission("cms","w","")){
				?>
				<script language="JavaScript">
				alert("You can not access this section!!");
				window.close();
				</script>
				<?php
}
function chk_list($gtips_id){
global $db;
$sql = "select tips_list_id from tips_list where tips_group_id='".$gtips_id."'";
$query = $db->query($sql);
if($db->db_num_rows($query)>0){
return FALSE;
}else{
return TRUE;
}
}
	?>
<html>
<head>
<title>Page Properties [<?php echo $R[filename];?>]</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script src="../js/AjaxRequest.js"></script>
<script language="javascript1.2">
function txt_data(obj,obj_id) {
	var type = window.top.document.getElementById('type').value;
	var filename = window.top.document.getElementById('filename').value;
	var mytop = '80';//findPosY(document.getElementById("lang")) +document.getElementById("lang").offsetHeight;
	var myleft = '80';//findPosX(document.getElementById("lang"));	
	var objDiv = document.getElementById("nav");
	objDiv.style.top = mytop;
	objDiv.style.left = myleft;
	objDiv.style.display = '';
	url='content_tooltips_group.php?type='+type+'&filename'+filename+'&flag='+obj+'&tips_id='+obj_id;
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
function adddata(F,tips_id){
var type = window.top.document.getElementById('type').value;
var filename = window.top.document.getElementById('filename').value;
	if(F == 'E'){
	txt_data('edit_group',tips_id);
	}else if(F == 'D'){
		if(confirm('คุณต้องการลบ กลุ่ม Tool Tips นี้?')){
		self.location.href= "content_tooltips_function.php?flag=del_group&tips_id="+tips_id;
		}
	}
}
</script>
</head>
<body leftmargin="0" topmargin="0" >
<div id="nav" style="position:absolute;width:600px; z-index:1;display:none" ></div>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"><span class="ewtfunction">กลุ่ม Tool Tips</span> </td>
      </tr>
</table>
      <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
        <tr>
          <td align="right">
                <img src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle"> <a href="#" onClick="txt_data('add_group','')">Add กลุ่ม </a>&nbsp;&nbsp;&nbsp;&nbsp;
                  <hr>
          </td>
        </tr>
      </table>
<table width="94%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF" align="center">
         <tr>
             <td valign="top"  class="MemberTitle">  
					<table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse" >
					  <tr  bgcolor="#FFCC99" class="ewttablehead">
						<td width="58" height="25" align="center" class="head_font"></td>
						<td class="head_font">กลุ่ม</td>
					  </tr>
						<?php
						$sql = "select * from tips_group ";
						$query = $db->query($sql);
						while($R = $db->db_fetch_array($query)){
						?>
					  <tr bgcolor="#FFFFFF" >
						<td width="58" align="left">
						<a href="#E" onClick="adddata('E',<?php echo $R[tips_group_id];?>);"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" border="0"></a>&nbsp;
						<?php if(chk_list($R[tips_group_id]) == TRUE){?><a href="#D"  onClick="adddata('D',<?php echo $R[tips_group_id];?>);"><img src="../theme/main_theme/g_del.gif" width="16" height="16" border="0"></a><?php } ?></td>
						<td width="427" valign="top" bgcolor="#FFFFFF" ><?php echo $R[tips_group_name];?></td>
					  </tr>
						<?php } ?>
					</table>
		   </td>
  </tr>
</table>
<table width="94%" border="0" align="center">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
</body>
</html>
<?php $db->db_close(); ?>
