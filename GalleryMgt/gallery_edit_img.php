<?php
include("../lib/permission1.php");
//include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<body leftmargin="0" topmargin="0">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction">แก้ไขรูปภาพ</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="gallery_view_category.php?category_id=<?php echo $_GET[category_id]?>&page_cat=<?php echo $page_cat?>"><img src="../theme/main_theme/g_back.png" width="16" height="16" align="absmiddle" border="0"> กลับหน้าก่อนหน้า</a>
        <hr>
    </td>
  </tr>
</table>
<form name="form1" method="post" action="gallery_process_img.php" enctype="multipart/form-data">
<script>
	var chk_choose_cate = 0;
	function showpic(c){
		if(c != ""){
			document.all.imgp.src = c;
		}else{
			document.all.imgp.src = '../images/pic_preview.gif';
		}
	}
		function ch_height(c){
		if(c != ""){
			document.all.imgp.style.height = c;
		}
	}
		function ch_width(c){
		if(c != ""){
			document.all.imgp.style.width = c;
		}
	}
		function CHK(t){
	if(t.filesize_more.checked == true){
	return false;
	}
	return true;
	}
</script>
<?php
	$sql = "SELECT * FROM gallery_image INNER JOIN gallery_cat_img ON gallery_image.img_id = gallery_cat_img.img_id WHERE gallery_image.img_id = '".$_GET[img_id]."' ";
	$query = $db->query($sql);
	$i=1;
	$chk_cate_id = array();
	while($rs_img = $db->db_fetch_array($query)){
		$name = $rs_img[img_name];
		$detail = $rs_img[img_detail];
		$s_img = $rs_img[img_path_s];
		$b_img = $rs_img[img_path_b];
		$chk_cate_id[$i] = $rs_img[category_id];
		$i++;
	}
?>
<table width="101%" height="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
  <tr> 
    <td bgcolor="#FFFFFF" valign="top"><br>
      <table width="90%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#999999" class="ewttableuse">
        <tr class="ewttablehead">
          <td height="23" colspan="2" scope="col">แก้ไขรูปภาพ</td>
          </tr>
        <tr>
          <td width="18%" height="23" bgcolor="#FFFFFF"><strong>ชื่อรูปภาพ : </strong><!--<strong style="color:#FF0000">*</strong>--></td>
          <td width="82%" height="23" bgcolor="#FFFFFF">
            <input name="category_name" type="text" size="50" value="<?php echo $name?>">          </td>
        </tr>
        <tr>
          <td height="23" bgcolor="#FFFFFF"><strong>รายละเอียด :</strong></td>
          <td height="23" bgcolor="#FFFFFF">
            <textarea name="category_detail" cols="50" rows="3"><?php echo $detail?></textarea>          </td>
        </tr>
		
		<tr>
          <td height="23" bgcolor="#FFFFFF" valign="top"><strong>หมวดภาพ :  </strong><strong style="color:#FF0000">*</strong></td>
          <td height="23" bgcolor="#FFFFFF" style="color:#0000CC"><strong>
		  <?php
		  		$sql_cat = "SELECT * FROM gallery_category WHERE category_id = '".$_GET[category_id]."' ";
				$query_cat = $db->query($sql_cat);
				$rs_cat = $db->db_fetch_array($query_cat);
				print $rs_cat[category_name];
		  ?></strong>		  
		  </td>
        </tr>
		
		 <tr>
          <td height="23" bgcolor="#FFFFFF"><strong>รูปภาพ : </strong><strong> </strong><strong style="color:#FF0000">*</strong></td>
          <td height="23" bgcolor="#FFFFFF">
            <input name="b_images" type="text" size="50" readonly=""  value="<?php echo $b_img?>">
            <img src="images/folder_img.gif" height="20" width="20" align="absmiddle" alt="เลือกภาพ" style="cursor:hand" onClick="window.open('../FileMgt/gallery_insert.php?stype=images&Flag=Link&o_value=window.opener.document.all.b_images.value','','width=800 , height=500');"> 
			<img src="images/document_view.gif" height="24" width="24" align="absmiddle" alt="ดูภาพ" onClick="if(document.form1.b_images.value != ''){window.open('gallery_view_img.php?img_name='+document.form1.b_images.value+'','','width=500 , height=400,scrollbars=1,resizable = 1');}" style="cursor:hand"><span class="style1"><br> 
			(ในกรณีที่ต้องการนำเข้า file รูปภาพแบบ zip ให้เลือกรูปภาพจากตรงนี้) </span></td>
        </tr>
        <!--<tr>
          <td height="23" bgcolor="#FFFFFF"><strong>ภาพใหญ่ :  </strong><strong style="color:#FF0000">*</strong></td>
          <td height="23" bgcolor="#FFFFFF"><input name="b_images" type="text" size="50" readonly="" value="<?php//=$b_img?>">
            <img src="images/folder_img.gif" height="20" width="20" align="absmiddle" alt="เลือกภาพ" style="cursor:hand" onClick="window.open('../FileMgt/gallery_insert.php?stype=images&Flag=Link&o_value=window.opener.document.all.b_images.value','','width=800 , height=500');"> 
			<img src="images/document_view.gif" height="24" width="24" align="absmiddle" alt="ดูภาพ" onClick="if(document.form1.b_images.value != ''){window.open('gallery_view_img.php?img_name='+document.form1.b_images.value+'','','width=500 , height=400,scrollbars=1,resizable = 1');}" style="cursor:hand"></td>
        </tr>-->
		
		 <tr>
          <td height="23" bgcolor="#FFFFFF"></td>
          <td height="23" bgcolor="#FFFFFF">
		  <input type="checkbox" name="chkchange"  id="chkchange" value="yes"
		   onClick="if(this.checked==true){
		    document.getElementById('pics').style.display='';
			}else{
				document.getElementById('pics').style.display='none';
				document.form1.filep.value='';
				
			} "> 
		  ต้องการเปลี่ยนเป็นรูปภาพจากในเครื่อง</td>
		  </tr>
        
		
		<tr id="pics" style="display:none"> 
            <td height="23" valign="top" bgcolor="#FFFFFF"><strong>รูปภาพจากในเครื่อง : </strong><strong style="color:#FF0000">* </strong></td>
            <td height="23" bgcolor="#FFFFFF"> <input name="filep" type="file" id="filep" >
               <!-- <br>
Height: -->
        <input name="hi" type="hidden" id="hi" value="300" size="2" onBlur="ch_height(this.value)">
   <!-- Width: -->
        <input name="wi" type="hidden" id="wi" value="300" size="2" onBlur="ch_width(this.value)">
		  <!--<input type="checkbox" name="filesize_more" value="checkbox"></font></a><font color="#FF0000">File 
        Size must  exceed <?php//php echo $rec[site_info_max_img];?> KB<br>
              <img src="../images/pic_preview.gif" name="imgp" width="300" height="300" id="imgp">--></td>
          </tr>
		
		
		
      </table>
      <table width="90%" border="0" align="center">
        <tr>
          <th scope="col"><input type="submit" name="Submit" value="บันทึก" onClick="return chk_null(this.form);">
          &nbsp;
            <input type="button" name="Submit2" value="ยกเลิก" onClick="location.href = 'gallery_view_category.php?category_id=<?php echo $_GET[category_id]?>&page=<?php echo $page_cat?>'; ">
            <input type="hidden" name="flag" value="edit">
			<input type="hidden" name="img_id" value="<?php echo $_GET[img_id]?>"><input type="hidden" name="category_id" value="<?php echo $_GET[category_id]?>">
			</th>
        </tr>
      </table></td>
  </tr>
</table></form>
<script>
function chk_null(me){
	/*if(me.category_name.value == ''){
		alert('กรุณากรอกชื่อรูปภาพ');
		me.category_name.focus();
		return false;
	}*/
	//if(me.s_images.value == ''){
		//alert('กรุณาเลือกภาพเล็ก');
		//me.s_images.focus();
		//return false;
	//}	
	if(me.b_images.value == ''){
		alert('กรุณาเลือกภาพใหญ่');
		me.b_images.focus();
		return false;
	}
	/*if(chk_choose_cate == 0){
		alert('กรุณาเลือกหมวดหมู่ของภาพ');
		return false;
	}*/
	return true;
}
</script>
</body>
</html>
<?php
$db->db_close(); ?>
