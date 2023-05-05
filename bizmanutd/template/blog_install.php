<?php
	session_start();
	include("blog/include/connect.php");
	
	$sql_profile="SELECT * FROM `blog_list`  WHERE `blog_list`.`blog_user`='$_SESSION[EWT_MID]' ";
	$exc_profile=mysql_query($sql_profile);
	$count_profile=mysql_num_rows($exc_profile);
	
	if($count_profile>0){
			echo "<script>window.location.href='blog_settheme.php';</script>";
			exit;
	}
	
	if($_POST[Submit]=="ยืนยัน"){
				$sql="INSERT INTO `blog_list` (`blog_list`.`blog_user`,
																	`blog_list`.`blog_title`,
																	`blog_list`.`blog_name`,
																	`blog_list`.`blog_position`,
																	`blog_list`.`blog_dept`,
																	`blog_list`.`blog_msg`,
																	`blog_list`.`blog_theme_id`,
																	`blog_list`.`blog_createdate`,`blog_list`.`blog_lastdate`,`blog_list`.`blog_size`,) VALUES (
																	'$_SESSION[EWT_MID]',
																	'$_POST[txt_title]',
																	'$_POST[txt_name]',
																	'$_POST[txt_position]',
																	'$_POST[txt_dept]',
																	'$_POST[txt_msg]',
																	'1',
																	NOW()	,NOW(),'50')";
			$exc=mysql_query($sql);
			
			$sql_profile="SELECT `blog_list`.`blog_id` FROM `blog_list`  WHERE `blog_list`.`blog_user`='$_SESSION[EWT_MID]' ";
			$exc_profile=mysql_query($sql_profile);
			$row_profile=mysql_fetch_array($exc_profile);
			
			// Upload Picture			
			$nfile = "n".date("Ymdhis")."_".$row_profile[blog_id];
	 		$Current_Dir = "blog/images_profile";
			
			if($_FILES['file']['size'] > 0 AND $_FILES['file']['size'] < 204800){
				 	$F = explode(".",$_FILES["file"]["name"]);
					$C = count($F);
					$CT = $C-1;
					$dir = strtolower($F[$CT]);
					
					if($dir == "jpeg"){
						$dir = "jpg";
					}
					
					$picname = $nfile.".".$dir;
					if($dir == "jpg" OR $dir == "png" OR $dir == "gif"){
						copy($_FILES["file"]["tmp_name"],$Current_Dir."/".$picname);
						@chmod ($Current_Dir."/".$picname, 0777);
						$exc=mysql_query("UPDATE blog_list SET blog_picture = '$picname' WHERE `blog_list`.`blog_user`='$_SESSION[EWT_MID]' ");
						include("../../ewt_thumbnail.php");
						if($dir == "jpg"){
							thumb_jpg($Current_Dir."/".$picname,$Current_Dir."/t".$picname, "100", "100");
						} // if jpg
						if($dir == "gif"){
							thumb_gif($Current_Dir."/".$picname,$Current_Dir."/t".$picname, "100", "100");
						} // if gif
						if($dir == "png"){
							thumb_png($Current_Dir."/".$picname,$Current_Dir."/t".$picname, "100", "100");
						} // if png
					} // if dir
			} // if file
																				
			echo "alert('ติดตั้งเรียบร้อยแล้ว'); <script>window.location.href='blog_settheme.php?blog_id=$row_profile[blog_id]';</script>";
			exit;
	}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>My Blog -- ติดตั้ง My Blog</title>
<style type="text/css">
<!--
.font_basic {
	font-size: 12px;
	font-family: sans-serif,Arial, Helvetica ;
}
-->
</style>
</head>

<body style="margin:0px" class="font_basic">
<form name="frm" action="?" method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="74" background="blog/images/header_bg.jpg">&nbsp;</td>
      </tr>
    </table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="300" align="center" valign="top" bgcolor="#E1D4C0"><table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50" rowspan="3" background="blog/images/line_left.jpg">&nbsp;</td>
            <td width="50"><img src="blog/images/conner_top_left.jpg" width="50" height="50"></td>
            <td background="blog/images/top_bg.jpg">&nbsp;</td>
            <td width="50"><img src="blog/images/conner_top_right.jpg" width="50" height="50"></td>
            <td width="50" rowspan="3" background="blog/images/line_right.jpg">&nbsp;</td>
          </tr>
          <tr>
            <td background="blog/images/left_bg.jpg">&nbsp;</td>
            <td height="450" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="5" cellpadding="0">
              <tr>
                <td align="left"><table width="100%" border="0" cellpadding="8" cellspacing="1" bgcolor="#CCCCCC">
                  <tr>
                    <td bgcolor="#FFEEBB"><strong>ยืนยันผู้ใช้ระบบที่ถูกต้อง</strong></td>
                  </tr>
                  <tr>
                    <td bgcolor="#F3F3F3">ชื่อผู้ใช้ระบบ:<br />
                      <input name="txt_user" type="text" id="txt_user" size="30" maxlength="30" />
                      <br />
รหัสผ่าน:<br />
<input name="txt_pass" type="password" id="txt_pass" size="30" maxlength="30" /></td>
                  </tr>
                </table></td>
              </tr>
              
              <tr>
                <td align="left">&nbsp;</td>
              </tr>
              <tr>
                <td align="left"><table width="100%" border="0" cellpadding="8" cellspacing="1" bgcolor="#CCCCCC">
                  <tr>
                    <td bgcolor="#FFEEBB"><strong>ชื่อ Blog ของท่านที่ต้องการ </strong></td>
                  </tr>
                  <tr>
                    <td bgcolor="#F3F3F3">ชื่อ Blog :<br />
                      <input name="txt_title" type="text" id="txt_title" size="30" maxlength="30" /></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left">&nbsp;</td>
              </tr>
              <tr>
                <td align="left"><table width="100%" border="0" cellpadding="8" cellspacing="1" bgcolor="#CCCCCC">
                  <tr>
                    <td bgcolor="#FFEEBB"><strong>ข้อมูลส่วนตัว</strong></td>
                  </tr>
                  <tr>
                    <td bgcolor="#F3F3F3">ชื่อ-สกุล:<br />
                      <input name="txt_name" type="text" id="txt_name" size="30" />
                      <br />
ตำแหน่ง:<br />
<input name="txt_position" type="text" id="txt_position" size="50" />
<br />
สังกัด:<br />
<input name="txt_dept" type="text" id="txt_dept" size="50" />
<br />
รายละเอียดเพิ่มเติม
:<br />
<textarea name="txt_msg" cols="50" rows="5" id="txt_msg"></textarea>
<br />
<br />
รูปภาพ:<br />
<input name="file" type="file" class="font_basic" id="file" size="30" onchange="preview(this)" /></td>
                  </tr>
                </table></td>
              </tr>
              
              <tr>
                <td align="center">&nbsp;</td>
              </tr>
              <tr>
                <td align="center"><input name="chkaccept" type="checkbox" id="chkaccept" value="1" onclick="if(this.checked){ frm.Submit.disabled=''; }else{ frm.Submit.disabled='false'; }" />
                  <input name="Submit" type="submit" class="font_basic"  style="width:80px"  onclick="return chkinput();" value="ยืนยัน" disabled="disabled" />
                  <input name="Submit2" type="button" class="font_basic" style="width:80px" value="ยกเลิก"></td>
              </tr>
            </table></td>
            <td background="blog/images/right_bg.jpg">&nbsp;</td>
            </tr>
          
          <tr>
            <td><img src="blog/images/conner_bottom_left.jpg" width="50" height="50"></td>
            <td background="blog/images/bottom_bg.jpg">&nbsp;</td>
            <td><img src="blog/images/conner_bottom_right.jpg" width="50" height="50"></td>
            </tr>
        </table>
          </td>
      </tr>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
<script>
function chkinput(){
	
	if(frm.txt_user.value==''){
			alert('กรุณากรอกชื่อผู้ใช้ระบบด้วย เพื่อยืนยันในการติดตั้งระบบ');
			frm.txt_user.focus();
			return false;
	}
		if(frm.txt_pass.value==''){
			alert('กรุณากรอกรหัสผ่านด้วย เพื่อยืนยันในการติดตั้งระบบ');
			frm.txt_pass.focus();
			return false;
	}
	if(frm.txt_title.value==''){
			alert('กรุณากรอกชื่อ Blog ด้วย ');
			frm.txt_title.focus();
			return false;
	}
	if(frm.txt_name.value==''){
			alert('กรุณากรอกชื่อ-นามสกุลด้วย');
			frm.txt_name.focus();
			return false;
	}
	if(frm.txt_position.value==''){
			alert('กรุณากรอกตำแหน่งด้วย');
			frm.txt_position.focus();
			return false;
	}
	if(frm.txt_dept.value==''){
			alert('กรุณากรอกสังกัด');
			frm.txt_name.focus();
			return false;
	}
	
	if(frm.file.value){
		if(preview(frm.file)){
				frm.file.focus();
				return false;
		}
	}
}

	<!-- Begin

/***** CUSTOMIZE THESE VARIABLES *****/

  // width to resize large images to
var maxWidth=400;
  // height to resize large images to
var maxHeight=400;
  // valid file types
var fileTypes=["gif","png","jpg","jpeg"];
  // the id of the preview image tag
var outImage="previewField";
  // what to display when the image is not valid
var defaultPic="../images/preview_photo.gif";

/***** DO NOT EDIT BELOW *****/

function preview(what){
  var source=what.value;
  var ext=source.substring(source.lastIndexOf(".")+1,source.length).toLowerCase();
  for (var i=0; i<fileTypes.length; i++) if (fileTypes[i]==ext) break;
  globalPic=new Image();
  if (i<fileTypes.length) globalPic.src=source;
  else {
    globalPic.src=defaultPic;
    alert("THAT IS NOT A VALID IMAGE\nPlease load an image with an extention of one of the following:\n\n"+fileTypes.join(", "));
	return true;
  }
  //setTimeout("applyChanges()",200);
}
var globalPic;
function applyChanges(){
  var field=document.getElementById(outImage);
  var x=parseInt(globalPic.width);
  var y=parseInt(globalPic.height);
  if (x>maxWidth) {
    y*=maxWidth/x;
    x=maxWidth;
  }
  if (y>maxHeight) {
    x*=maxHeight/y;
    y=maxHeight;
  }
  field.style.display=(x<1 || y<1)?"none":"";
  field.src=globalPic.src;
  field.width=x;
  field.height=y;
}
// End -->
</script>

