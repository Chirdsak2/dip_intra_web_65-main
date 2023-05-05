<?php
	session_start();
	include("../../blog/lib/user_config.php");

	$conn=mysql_connect($EWT_ROOT_HOST,$EWT_ROOT_USER,$EWT_ROOT_PASSWORD);
	$db=mysql_select_db($EWT_DB_NAME,$conn);
	
	$sql_profile="SELECT * FROM `blog_list`  WHERE `blog_list`.`blog_user`='$_SESSION[EWT_MID]' ";

	$exc_profile=mysql_query($sql_profile);
	$count_profile=mysql_num_rows($exc_profile);
	
	if($count_profile>0){
			echo "<script>window.location.href='blog_settheme.php';</script>";
			exit;
	}
	
	if($_POST[chkaccept]=="1"){
	//chk username and password 
	$sql = "select * from gen_user where gen_user_id = '".$_SESSION[EWT_MID]."' and  gen_user = '".$_POST[txt_user]."' and  gen_pass = '".$_POST[txt_pass]."'";
	$query = mysql_query($sql);
	if(mysql_num_rows($query) == 0){
	echo "<script>alert('ท่านใส่รหัสยืนยันไม่ถูกต้อง   กรุณายืนยันผู้ใช้ระบบที่ถูกต้องอีกครั้ง!!!!!'); window.location.href='blog_install.php';</script>";
	exit;
	}
			 $sql = "INSERT INTO `blog_list` (`blog_list`.`blog_user`,
															`blog_list`.`blog_title`,
															`blog_list`.`blog_theme_id`,
															`blog_list`.`blog_createdate`,`blog_list`.`blog_lastdate`,`blog_list`.`blog_size`)
															VALUES (
																	'$_SESSION[EWT_MID]',
																	'$_POST[txt_title]',
																	'1',
																	NOW()	,NOW(),'50')";
			$exc=mysql_query($sql);
			
			$sql_profile="SELECT `blog_list`.`blog_id` FROM `blog_list`  WHERE `blog_list`.`blog_user`='$_SESSION[EWT_MID]' ";
			$exc_profile=mysql_query($sql_profile);
			$row_profile=mysql_fetch_array($exc_profile);
					
			echo "<script>alert('ติดตั้งเรียบร้อยแล้ว'); window.location.href='blog_settheme.php?blog_id=$row_profile[blog_id]';</script>";
			exit;
	}
	
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
<title>My Blog -- ติดตั้ง My Blog</title>
<style type="text/css">
<!--
.font_basic {
	font-size: 12px;
	font-family: sans-serif,Arial, Helvetica ;
}
-->
</style>
<script language="javascript" type="text/javascript">
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


</head>

<body style="margin:0px" class="font_basic">
<form name="frm" action="?" method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="74"  style="background:url(../../blog/images/header_bg.jpg)">&nbsp;</td>
      </tr>
    </table>
	<table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="300" align="center" valign="top" bgcolor="#E1D4C0"><table width="600" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="50" rowspan="3" style="background:url(../../blog/images/line_left.jpg)">&nbsp;</td>
            <td width="50"><img src="../../blog/images/conner_top_left.jpg" width="50" height="50" alt="ซ้าย"></td>
            <td style="background:url(../../blog/images/top_bg.jpg)">&nbsp;</td>
            <td width="50"><img src="../../blog/images/conner_top_right.jpg" width="50" height="50" alt="ขวา"></td>
            <td width="50" rowspan="3" style="background:url(../../blog/images/line_right.jpg)">&nbsp;</td>
          </tr>
          <tr>
            <td  style="background:url(../../blog/images/left_bg.jpg)">&nbsp;</td>
            <td height="450" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="5" cellpadding="0">
              <tr>
                <td align="left"><table width="100%" border="0" cellpadding="8" cellspacing="1" bgcolor="#CCCCCC">
                  <tr>
                    <td bgcolor="#FFEEBB"><strong>ยืนยันผู้ใช้ระบบที่ถูกต้อง</strong></td>
                  </tr>
                  <tr>
                    <td bgcolor="#F3F3F3">ชื่อผู้ใช้ระบบ:<br >
                      <input name="txt_user" type="text" id="txt_user" size="30" maxlength="30" value="<?php echo $_SESSION["EWT_USERNAME"];?>" >
                      <br >
รหัสผ่าน:<br >
<input name="txt_pass" type="password" id="txt_pass" size="30" maxlength="30" ></td>
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
                    <td bgcolor="#F3F3F3">ชื่อ Blog :<br >
                      <input name="txt_title" type="text" id="txt_title" size="30" maxlength="30" ></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td align="left">&nbsp;</td>
              </tr>
              <tr>
                <td align="left"></td>
              </tr>
              
              <tr>
                <td align="center">&nbsp;</td>
              </tr>
              <tr>
                <td align="center">
				
				<input name="chkaccept" type="checkbox" id="chkaccept" value="1" onclick="if(this.checked){ frm.Submit.disabled=''; }else{ frm.Submit.disabled='false'; }" >
                  <input name="Submit" type="submit" class="font_basic"  style="width:80px"  onclick="return chkinput();" value="ยืนยัน" disabled="disabled" >
                  <input name="Submit2" type="button" class="font_basic" style="width:80px" value="ยกเลิก"></td>
              </tr>
            </table><a href="http://validator.w3.org/check?uri=referer"><img src="images/w3c_gold.bmp" alt="Valid HTML 4.01 Transitional" height="31" width="88" border="0"></a><?php  include("ewt_span.php");?></td>
            <td style="background:url(../../blog/images/right_bg.jpg)">&nbsp;</td>
            </tr>
          
          <tr>
            <td><img src="../../blog/images/conner_bottom_left.jpg" width="50" height="50"  alt="ซ้าย"></td>
            <td style="background:url(../../blog/images/bottom_bg.jpg)">&nbsp;</td>
            <td><img src="../../blog/images/conner_bottom_right.jpg" width="50" height="50" alt="ขวา"></td>
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
