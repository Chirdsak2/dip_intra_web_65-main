<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$recValue = $db->db_fetch_array ($db->query("select * from ebook_value where ebook_value_id = '1' ")); 
$maxSize = $recValue['ebook_value'];
$recValue = $db->db_fetch_array ($db->query("select * from ebook_value where ebook_value_id = '2' ")); 
$maxPDFSize = $recValue['ebook_value'];
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
</head>
<body leftmargin="0" topmargin="0" >
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/ebook_function_size.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">กำหนดความจุไฟล์ </span> </td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("กำหนดความจุไฟล์");?> &module=ebook&url=<?php echo urlencode("mgt_value.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp; <hr> </td>
</table>

<table width="90%" border="0" cellpadding="0" cellspacing="0"  align="center">
  <tr> 
    <td valign="top" bgcolor="#F4F4F4" class="MemberTitle">  

      <table width="100%" align="center" class="table table-bordered">
	  <tr class="ewttablehead">
          <td  colspan="2">กำหนดความจุไฟล์</td>
        </tr>
        <form name="form1" method="post" action="proc_ebook.php" onsubmit="return ck();">
          <?php  ?>
          <tr bgcolor="#FFFFFF">
            <td width="30%" height="13" valign="top">ขนาดที่จำกัดของไฟล์ประเภท Media<!--Media file maximumsize *--></td>
            <td width="70%"  align="left" valign="top"><label>
              <input class="form-control" style="width:30%;" name="ebook_value1" type="text" id="ebook_value1" size="7" maxlength="5" value="<?php echo $maxSize?>">
            KB </label></td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td width="22%" height="12" valign="top">ขนาดที่จำกัดของไฟล์ประเภท PDF<!--PDF file maximumsize  *--></td>
            <td  align="left" valign="top">
			<input class="form-control" style="width:30%;" name="ebook_value2" id="ebook_value2" type="text"  size="7" maxlength="5" value="<?php echo $maxPDFSize?>">
              MB </td>
          </tr>
          <tr bgcolor="#FFFFFF">
            <td height="25" align="right" valign="top">&nbsp;</td>
            <td  align="left" valign="top"><label>
              <input type="submit" name="saveButton" value="    บันทึก    " class="btn btn-success" />
              <input type="reset" name="saveButton2" value="  ยกเลิก   " class="btn btn-warning" />
              <input type="hidden" name="proc" value="saveValue">
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
<script type="text/javascript">
function ck(){
	var c1 = document.form1.ebook_value1;
	var c2 = document.form1.ebook_value2;
	if(c1.value!=""){ 
		if(isNaN(c1.value)){
			alert('กรุณากรอกตัวเลขเท่านั้น');
			c1.focus();
			return false;
		}
	}
	if(c2.value!=""){ 
		if(isNaN(c2.value)){
			alert('กรุณากรอกตัวเลขเท่านั้น');
			c2.focus();
			return false;
		}
	}
}
</script>
<?php $db->db_close(); ?>
