<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
 $status="savepreset";
 if ($_GET['proc']=='edit') {
   $rec_edit = $db->db_fetch_array($db->query ("select * from  ebook_preset  where ebook_preset_id='$id_preset' "));
  $status="editpreset";
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
		   }		
	if (f.h.value=='') {
		   alert ("Please field Height");
		   f.h.focus ();
		   return false;
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
    <td align="right"> <a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=การจัดการขนาดไฟล์ &module=ebook&url=mgt_preset.php', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="mgt_presetaddedit.php" target="_self"><img src="../theme/main_theme/g_add.gif" width="16" height="16" border="0" align="absmiddle"> 
      เพิ่มขนาดใหม่ &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a> <a href="mgt_preset.php" target="_self"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" border="0" align="absmiddle"> 
      การจัดการขนาดไฟล์</a><hr></td>
</table>

<table width="94%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF" align="center">
  <tr>
      
    <td valign="top" bgcolor="#F4F4F4" class="MemberTitle">  
	 <table width="100%" align="center" class="table table-bordered">
	  <tr class="ewttablehead">
          <td  width="16%" align="center">&nbsp;</td>
    <td  width="21%" align="center"> &nbsp;&nbsp;ชื่อ</td>
    <td  width="26%" align="center">ขนาด</td>
  </tr>
  <?php 
  $query = $db->query ("select * from ebook_preset");
  $i=1;
   while ($rec = $db->db_fetch_array ($query)){
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td align="center"><a href="mgt_presetaddedit.php?proc=edit&id_preset=<?php echo $rec[ebook_preset_id];?>"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" alt="แก้ไข" border="0"></a>
	<a href="javascript:cfmDel ('<?php echo $rec[ebook_preset_id];?>');"><img src="../theme/main_theme/g_del.gif" width="16" height="16" alt="ลบ"  border="0"></a>
	</td>
    <td>&nbsp;&nbsp;<?php echo $rec[ebook_preset_name] ?></td>
    <td align="center">&nbsp;&nbsp;<?php echo $rec[ebook_preset_w] ?> X <?php echo $rec[ebook_preset_h] ?></td>
  </tr>
  <?php $i++;}?>
</table>
</td>
  </tr>
</table>
</body>
</html>
<?php $db->db_close(); ?>
