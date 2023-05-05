<?php
session_start();
include("../lib/permission1.php");
//include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$sql = "select * from site_info";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
				$sql_cat = "SELECT * FROM gallery_category WHERE category_id = '".$_GET[category_id]."' ";
				$query_cat = $db->query($sql_cat);
				$rs_cat = $db->db_fetch_array($query_cat);
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
<script language="javascript1.2">
	var chk_choose_cate = 0;
	function showpic(c){
		if(c != ""){
			document.all.imgp.src = c;
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
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction">เพิ่มรูปภาพ</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php if($_GET[category_id] != ''){ echo urlencode('เพิ่มรูปภาพ หมวดภาพ '.$rs_cat[category_name]);}else{ echo urlencode("เพิ่มรูปภาพ ");}?> &module=gallery&url=<?php echo urlencode("gallery_add_img.php?category_id=".$_GET["category_id"]);?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;
	<?php if($_GET["parent_cat_id_send"] != ''){ ?>
	<a href="gallery_view_category.php?category_id=<?php echo $_GET[category_id]?>&page_cat=<?php echo $page_cat?>">
	<?php }else{ ?>
	<a href="main_gallery.php">
	<?php } ?>
	<img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0"> หน้าหลัก</a>  
    <hr></td>
  </tr>
</table>

  <table width="94%" height="100%" border="0"  align="center" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF">
<form name="form1" method="post" enctype="multipart/form-data" action="gallery_process_img.php">  <tr > 
    <td bgcolor="#FFFFFF" valign="top"><table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#999999" class="ewttableuse">
          <tr class="ewttablehead"> 
            <td height="23" colspan="2">เพิ่มรูปภาพ</td>
          </tr>
          <tr> 
            <td width="18%" height="23" bgcolor="#FFFFFF"><strong>ชื่อรูปภาพ : 
              </strong><!--<strong style="color:#FF0000">*</strong>--></td>
            <td width="82%" height="23" bgcolor="#FFFFFF"> <input name="category_name" type="text" size="50" value="<?php echo $name?>">            </td>
          </tr>
          <tr> 
            <td height="23" bgcolor="#FFFFFF"><strong>รายละเอียด :</strong></td>
            <td height="23" bgcolor="#FFFFFF"> <textarea name="category_detail" cols="50" rows="3"><?php echo $detail?></textarea>            </td>
          </tr>
		   <tr>
          <td height="23" bgcolor="#FFFFFF"><strong>รูปภาพ : </strong><strong> </strong><strong style="color:#FF0000">*</strong></td>
          <td height="23" bgcolor="#FFFFFF">
            <input name="b_images" type="text" size="50" readonly="" >
            <img src="images/folder_img.gif" height="20" width="20" align="absmiddle" alt="เลือกภาพ" style="cursor:hand" onClick="window.open('../FileMgt/gallery_insert.php?stype=images&Flag=Link&o_value=window.opener.document.all.b_images.value','','width=800 , height=500');"><span class="style1"> (ในกรณีที่ต้องการนำเข้า file รูปภาพแบบ zip ให้เลือกตรงนี้)			</span></td>
        </tr>
		 <tr>
          <td height="23" bgcolor="#FFFFFF"></td>
          <td height="23" bgcolor="#FFFFFF">
		  <input type="checkbox" name="chkchange"  id="chkchange" value="yes"
		   onClick="if(this.checked==true){
		    document.getElementById('pics').style.display='';
			}else{
				document.getElementById('pics').style.display='none';
				document.form1.filep.value='';
				showpic('');
			} "> 
		  ต้องการใช้รูปภาพจากคอมพิวเตอร์ของคุณ</td>
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
          <tr> 
            <td height="23" bgcolor="#FFFFFF" valign="top"><strong>หมวดภาพ : </strong><strong style="color:#FF0000">*</strong></td>
            <td height="53" bgcolor="#FFFFFF"> 
              <?php if($_GET[category_id] == ""){?>
              <div style="overflow:-moz-scrollbars-vertical; overflow-x:auto;overflow-y:auto; width:100%; height:100; " > 
                <input name="add" type="hidden" value="add_all">
                <table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#006699">
                  <tr> 
                    <td bgcolor="#FFFFFF"  style="color:#FFFFFF"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
                        <tr> 
                          <th height="10" scope="col"><div align="left"><span><img src="images/b_dp.jpg" width="18" height="18" align="absmiddle" alt="เพิ่มรูปภาพ">&nbsp;<strong>เลือกหมวดหมู่ของภาพ</strong></span></div></th>
                        </tr>
                      </table></td>
                  </tr>
                  <tr> 
                    <td bgcolor="#FFFFFF" align="center" valign="top"> <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
                        <script language="JavaScript">
						function divshow(c,d){
							if(c.style.display == ""){
							c.style.display = 'none';
							d.src = "images/plus.gif";
							}else{
								c.style.display = '';
							d.src = "images/minus.gif";
							}
						}
						</script>
                        <?php
						$sql_group = $db->query("SELECT * FROM gallery_category ORDER BY category_parent_id ASC");
						$num = $db->db_num_rows($sql_group);
						if($num > 0){
					?>
                        <tr> 
                          <td >
                            <?php
  function GenLen($data,$op){
		$s = explode($op,$data);
		return count($s);
  }
  function GenPic($data){
	$s = explode("_",$data);
	for($i=1;$i<count($s);$i++){
		echo "<img src=\"images/o.gif\" width=\"20\" height=\"20\" border=\"0\" align=\"absmiddle\">";
	}
 }


    $i = 0;
    $LenChk =0;
	
  	while($R = $db->db_fetch_array($sql_group)){
	$sql_sub = $db->query("SELECT COUNT(category_id) FROM gallery_category WHERE category_parent_id LIKE '".$R["category_parent_id"]."_%'");
	$count_sub = $db->db_fetch_row($sql_sub);
	$len = GenLen($R["category_parent_id"],"_");
		//echo $LenChk."-".$len;		
	if($LenChk > $len ){
		for($y=$len;$y<$LenChk;$y++){
			echo "</div>";
		}
	}
	 $LenChk = $len;
  ?>
                            <div> 
                              <?php
		  	GenPic($R["category_parent_id"]);
		   if($count_sub[0] > 0){ ?>
                              <img src="images/plus.gif" border="0" align="absmiddle" onClick="divshow(document.all.dv<?php echo $i; ?>,this)"> 
                              <?php }else{ ?>
                              <img src="images/o.gif" width="20" height="20" border="0" align="absmiddle"> 
                              <?php } ?>
                              <img src="images/ico038.gif" width="11" height="11" border="0" align="absmiddle">&nbsp;&nbsp; 
                              <label> 
                              <input type="checkbox" name="category_id[]" value="<?php echo $R["category_id"]?>" <?php if($R["category_id"] == $_GET[category_id]){print "checked";}?> onClick="if(this.checked == true){chk_choose_cate++;}else{chk_choose_cate--;}">
                              <?php if($R["category_id"] == $_GET[category_id]){print "<script>chk_choose_cate++;</script>";}?>
                              </label>
                              &nbsp;<?php echo $R["category_name"]; ?></div>
                            <?php  if($count_sub[0] > 0){ echo "<div id=\"dv".$i."\"  style=\"display:none\">"; }  ?>
                            <?php 

   $i++; } ?>
                            <?php //</div>?>                          </td>
                        </tr>
                        <?php }else{?>
                        <tr>
                          <td style="color:#FF0000" align="center">ไม่มีข้อมูล</td>
                        </tr>
                        <?php }?>
                      </table></td>
                  </tr>
                </table>
              </div>
              <?php
		  	}else{ //end if category
				print "<script>chk_choose_cate++;</script>";
		  ?>
              <strong style="color:#0000CC">
              <?php echo $rs_cat[category_name]?>
              </strong> <input name="category_id[]" type="hidden" value="<?php echo $_GET[category_id]?>"> 
              <input name="ref" type="hidden" value="2"> 
              <?php }?>            </td>
          </tr>
        </table>
      <table width="90%" border="0" align="center">
        <tr>
          <th scope="col"><input type="submit" name="Submit" value="บันทึก" onClick="return chk_null(this.form);">
          &nbsp;
            <input type="button" name="Submit2" value="ยกเลิก" style="cursor:hand" onClick="location.href = 'gallery_view_category.php?category_id=<?php echo $_GET[category_id]?>&page=<?php echo $page?>'; ">
            <input type="hidden" name="flag" value="add"></th>
        </tr>
      </table></td>
  </tr>
</form></table>
<script>
function chk_null(me){
	/*if(me.category_name.value == ''){
		alert('กรุณากรอกชื่อรูปภาพ');
		me.category_name.focus();
		return false;
	}*/
	if(me.chkchange.checked == true){
		if(me.filep.value == ''){
			alert('กรุณาเลือกภาพ');
			me.b_images.value  = '';
			me.filep.focus();
			return false;
		}	
	}else{
		if(me.b_images.value == ''){
			alert('กรุณาเลือกภาพ');
			me.filep.value  = '';
			me.b_images.focus();
			return false;
		}	
	}
	if(chk_choose_cate == 0){
		alert('กรุณาเลือกหมวดหมู่ของภาพ');
		return false;
	}
	return true;
}
</script>
</body>
</html>
<?php
$db->db_close(); ?>
