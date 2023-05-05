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

	?>
<html>
<head>
<title>Page Properties [<?php echo $R[filename];?>]</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="javascript1.2">
function adddata(F,tips_id){
var type = window.top.document.getElementById('type').value;
var filename = window.top.document.getElementById('filename').value;
	if(F == 'S'){
	self.location.href= "content_tooltips_add.php?type="+type+"&filename="+filename+"&flag=add_page";
	}else if(F == 'A'){
	self.location.href= "content_tooltips_list_all.php?type="+type+"&filename="+filename+"&flag=add_page";
	}else if(F == 'E'){
	self.location.href= "content_tooltips_add.php?type="+type+"&filename="+filename+"&flag=edit_page&tips_id="+tips_id;
	}else if(F == 'D'){
		if(confirm('คุณต้องการลบ Tool Tips นี้?')){
		self.location.href= "content_tooltips_function.php?type="+type+"&filename="+filename+"&flag=del&tips_id="+tips_id;
		}
	}
}
</script>
</head>
<body leftmargin="0" topmargin="0" >
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction">Tool Tips</span> </td>
      </tr>
</table>
      <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
        <tr>
          <td align="right">
                <img src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle"> <a href="#A" onClick="adddata('S','');" >Add New Tool Tips </a>&nbsp;&nbsp;&nbsp;&nbsp;
				  <img src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle"> <a href="#ALL"  onClick="adddata('A','');" >Add Tool Tips ที่มีอยู่แล้ว </a>&nbsp;&nbsp;&nbsp;&nbsp;
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
						<td height="25" class="head_font">หัวข้อ Tool Tips </td>
						<td class="head_font">กลุ่ม</td>
					  </tr>
						<?php
						$sql = "select * from tips_list inner join tips_main on tips_main.tips_list_id = tips_list.tips_list_id inner join tips_group on tips_group.tips_group_id = tips_list.tips_group_id where tips_main_type = '".$_GET[type]."' and tips_main_type_id ='".$_GET[filename]."' ";
						$query = $db->query($sql);
						while($R = $db->db_fetch_array($query)){
						?>
					  <tr bgcolor="#FFFFFF" >
						<td width="58" align="left">
						<a href="#E" onClick="adddata('E',<?php echo $R[tips_list_id];?>);"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" border="0"></a>&nbsp;
						<a href="#D"  onClick="adddata('D',<?php echo $R[tips_list_id];?>);"><img src="../theme/main_theme/g_del.gif" width="16" height="16" border="0"></a>						</td>
						<td width="426" valign="top" bgcolor="#FFFFFF" ><img src="../images/content_bg_line.gif" width="5" height="4" align="absmiddle">&nbsp;<?php echo $R[tips_list_title];?></td>
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
