<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
  $mode = $_REQUEST["mode"];
 $ebookCode = $_REQUEST["ebookCode"];
 if ($mode=='edit') {
     $rec = $db->db_fetch_array($db->query ("select * from  ebook_group where g_ebook_id like '$ebookCode' "));
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
	    if (f.name.value=='') {
		   alert ("กรุณาใส่ชื่อ E-book");
		   f.name.focus ();
		   return false;
		}
	}
	
	function getPresetSize (obj) {
	     var arrSizeW=new Array();
		  var arrSizeH=new Array();
		  var id= obj.value;
	    <?php
		   $queryPre = $db->query ("select * from ebook_preset order by ebook_preset_name");
			       while ($recPre=$db->db_fetch_array ($queryPre)) {
				       print "arrSizeW[".$recPre['ebook_preset_id']."] = '".$recPre['ebook_preset_w']."'; \n";
					   print "arrSizeH[".$recPre['ebook_preset_id']."] = '".$recPre['ebook_preset_h']."'; \n";
				   }
		?>
		
		           obj.form.w.value = arrSizeW[id];
				   obj.form.h.value = arrSizeH[id];
	}
</script>
</head>
<body leftmargin="0" topmargin="0" >
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/ebook_function.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">การจัดการกลุ่ม E-Book</span> </td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
    <td align="right">
	  <a href="mgt_ebookg.php" target="_self"><img src="../theme/main_theme/g_add.gif" width="16" height="16" border="0" align="absmiddle"> 
      เพิ่มกลุ่ม E-Book  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a>
	  <a href="bookg_mgt.php" target="_self"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" border="0" align="absmiddle"> 
      การจัดการกลุ่ม</a><hr>
    </td>
</table>
  
      <table width="90%" border="0" align="center" class="table table-bordered">
	   <tr class="ewttablehead">
            <td  colspan="2"><?php    if ($mode=='edit') { print 'แก้ไขกลุ่ม E-Book'; }else {   print 'สร้างกลุ่ม E-Book ใหม่';  }   ?></td> 
          </tr>
        <form name="form1" method="post" action="proc_ebookg.php" onSubmit="return chkForm(document.form1);">
          <?php  ?>
          <tr bgcolor="#FFFFFF">
            <td width="30%" height="25"  valign="top">ชื่อกลุ่มE-Book<!--Name--> * </td>
            <td width="70%"  align="left" valign="top"><label>
              <input name="name" type="text" size="50" value="<?php echo $rec['g_ebook_name']?>" class="form-control" style="width:50%;">
            </label><input name="status" type="hidden" value="Y"></td>
          </tr>
         <!-- <tr bgcolor="#FFFFFF">
            <td height="25" valign="top">กำหนดสถานะ<!--Status Show* </td>--> 
            <!--<td  align="left" valign="top"><label>
              <input name="status" type="radio" value="Y" <?php if ($rec['g_ebook_status']=='Y') { print 'checked';}?>>
              แสดง 
              <input name="status" type="radio" value="N"  <?php if ($rec['g_ebook_status']=='N' || $rec['g_ebook_status']=='') { print 'checked';}?>>
            ไม่แสดง</label></td>
          </tr>-->
          <tr bgcolor="#FFFFFF">
            <td height="25" align="right" valign="top">&nbsp;</td>
            <td  align="left" valign="top"><label>
              <input type="submit" name="saveButton" value="    บันทึก    " class="btn btn-success" />
              <input type="Button" name="saveButton2" value="  ยกเลิก   " Onclick="window.location.href='bookg_mgt.php';" class="btn btn-warning" />
              <input type="hidden" name="proc" value="saveEbook">
              <input type="hidden" name="ebookCode" value="<?php echo $rec['g_ebook_id'];?>">
            </label></td>
          </tr>
          <?php ?>
        </form>
    </table></td>
  </tr>
</table>
</body>
</html>
<?php $db->db_close(); ?>
