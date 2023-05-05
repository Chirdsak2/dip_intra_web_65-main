<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
 $status="savepreset";
 if ($_GET[id_preset] != '') {
   $rec_edit = $db->db_fetch_array($db->query ("select * from  ebook_preset  where ebook_preset_id='$_GET[id_preset]' "));
  $status="editpreset";
  
 }else{
  $status="savepreset";
 }
	?>
<html>
<head>
<title>E-Book</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.head_table {	border-bottom:"buttonshadow solid 1px";
	border-left:"buttonhighlight solid 1px";
	border-right:"buttonshadow solid 1px";
	border-top:"buttonhighlight solid 1px";
}
.style3 {color: #0000FF}
-->
</style>
<script>
    function chkForm (f) {
	    if (f.name_preset.value=='') {
		   alert ("Please field Preset Name");
		   f.name_preset.focus ();
		   return false;
		}
		if (f.w.value=='') {
		   alert ("Please field Width");
		   f.w.focus ();
		   return false;
	   }else{
		   if(isNaN(f.w.value)){
				alert('กรุณากรอกตัวเลขเท่านั้น');
				f.w.focus();
				return false;
		   }
	   }
	   
		if (f.h.value=='') {
			   alert ("Please field Height");
			   f.h.focus ();
			   return false;
		}else{
			if(isNaN(f.h.value)){
				alert('กรุณากรอกตัวเลขเท่านั้น');
				f.h.focus();
				return false;
			}
		}		
	}
	 function cfmDel (ref) {
      if (confirm ("ลบใช่หรือไม่ ?")) {
	      self.location.href='proc_ebook.php?proc=delpreset&preset_id='+ref;		   
	  }
   }
</script>
</head>
<body leftmargin="0" topmargin="0" >
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/ebook_function_preset.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">การจัดการขนาดไฟล์</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php  if ($_GET[id_preset] != '') { echo urlencode("แก้ไขกำหนดขนาด".$rec_edit['ebook_preset_name']);}else{ echo urlencode("กำหนดขนาดใหม่");}?>&module=ebook&url=<?php  if ($_GET[id_preset] != '') { echo urlencode("mgt_presetaddedit.php?id_preset=".$_GET[id_preset]);}else{ echo urlencode("mgt_presetaddedit.php");}?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp; 
	  <a href="mgt_presetaddedit.php" target="_self"><img src="../theme/main_theme/g_add.gif" width="16" height="16" border="0" align="absmiddle"> 
      เพิ่มขนาดใหม่  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
	  <a href="mgt_preset.php" target="_self"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" border="0" align="absmiddle"> 
      การจัดการขนาดไฟล์</a><hr>
    </td>
</table>

<table width="70%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF" align="center">
  <tr>
      
    <td valign="top" bgcolor="#F4F4F4" class="MemberTitle">  
      <table width="100%" height="100%" border="0" cellpadding="5" cellspacing="1" class="ewttableuse">
	  <tr class="ewttablehead">
          <td  colspan="2"><?php if($_GET[proc]=='edit'){?>แก้ไขการกำหนดขนาด<?php }else{?>กำหนดขนาดใหม่<?php }?></td>
        </tr>
        <form name="form1" method="post" action="proc_ebook.php" onSubmit="return chkForm(document.form1);">
          <?php  ?>
          <tr bgcolor="#FFFFFF">
            <td width="38%" height="25"  valign="top"> ชื่อ<!--Preset&nbsp; Name--></td>
            <td width="62%"  align="left" valign="top"><label>
              <input name="name_preset" type="text" size="15" value="<?php echo $rec_edit['ebook_preset_name'];?>">
            </label></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25"  valign="top"> ขนาด<!--Size--> </td>
            <td  align="left" valign="top"><label>ความกว้าง 
                <input name="w" type="text" size="5" value="<?php echo $rec_edit['ebook_preset_w'];?>"> X ความสูง
                    <input name="h" type="text" size="5"  value="<?php echo $rec_edit['ebook_preset_h'];?>">
pixel</label></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25" align="right" valign="top">&nbsp;</td>
            <td  align="left" valign="top"><label>
              <input type="submit" name="saveButton" value="    บันทึก    ">
              <input type="reset" name="saveButton2" value="  ยกเลิก   ">
              <input type="hidden" name="proc" value="<?php echo $status ;?>">
			   <input type="hidden" name="preset_id"  value="<?php echo $rec_edit['ebook_preset_id'];?>">
            </label></td>
          </tr>
          <?php ?>
        </form>
    </table>	
</td>
  </tr>
</table>
</body>
</html>
<?php $db->db_close(); ?>
