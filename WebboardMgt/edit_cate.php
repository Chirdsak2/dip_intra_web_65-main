<?php
include("administrator.php");
include("lib/include.php");
include("inc.php");


if($_GET[flag]=='category'){
$flag = 'category';
$lable = 'เพิ่ม';
}else if($_GET[flag]=='editcategory'){
$flag = 'change';
$lable = 'แก้ไข';
}
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: none}
a:hover { color: #0099FF; text-decoration: none}
-->
</style>
</head>

<body leftmargin="0" topmargin="0" class="normal_font">
<?php include("../FavoritesMgt/favorites_include.php");?>
<div align="center">
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
    <tr valign="top">
      <td colspan="2"><?php @include("com_top.php"); ?></td>
    </tr>
    <tr>
      <td valign="top"></td>
      <td width="100%" height="100%" valign="top"><table width="100%" height="100%" border="0" cellpadding="2" cellspacing="0" class="normal_font">
  <tr>
    <td height="25" bgcolor="#FFFFFF"><table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
      <tr>
        <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction"><?php echo $lable;?>หมวดของกระทู้</span> </td>
      </tr>
    </table>
	<?php
$sql = $db->query("SELECT * FROM w_cate WHERE c_id = '$wcad'");
$R = mysql_fetch_array($sql);
?>
      <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
        <tr>
          <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode($lable."หมวดของกระทู้".$R[c_name]);?>&module=webboard&url=<?php if($_GET["flag"]=='editcategory'){ echo urlencode("edit_cate.php?wcad=".$_GET["wcad"]."&flag=editcategory"); }else{echo urlencode("edit_cate.php?flag=category");}?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="index_cate.php"><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" border="0" align="absmiddle"> หน้าหลัก</a>
              <hr>
          </td>
        </tr>
      </table></td>
    </tr>
  <tr>
    <td colspan="2" valign="top">


<table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
                  <form name="form1" enctype="multipart/form-data" method="post" action="question_function.php" onSubmit="return CHK()">
                    <tr align="center" bgcolor="#FFCC99" class="ewttablehead"> 
                      <td height="30" colspan="5" class="head_font"><?php echo $lable;?>หมวดของกระทู้</td>
                    </tr>
                    <tr bgcolor="#FFFFFF"> 
                      <td width="20%">ชื่อหมวด<font color="#FF0000">*</font></td>
                      <td width="80%" colspan="4"><input name="t_topic" type="text" class="normaltxt" id="t_topic" size="60" value="<?php echo $R[c_name]; ?>">                      </td>
                    </tr>
                    <tr bgcolor="#FFFFFF"> 
                      <td>รายละเอียด<font color="#FF0000">*</font></td>
                      <td colspan="4"><textarea name="t_detail" cols="60" rows="4" wrap="VIRTUAL" class="normaltxt" id="t_detail"><?php echo $R[c_detail]; ?></textarea>                      </td>
                    </tr>
					<tr bgcolor="#FFFFFF">
                      <td rowspan="5">เงื่อนไข </td>
					  <td>&nbsp;</td>
                          <td>ไม่ต้อง login </td>
                          <td align="center">ต้อง login<br>
                          (สำหรับทุกคน)</td>
                          <td align="center">ต้อง login<br>
                          (เฉพาะบุคคลภายใน)</td>
                    </tr>
                        <tr bgcolor="#FFFFFF"> 
                          <td>สิทธิ์ในการเข้าดูกระทู้ในหมวดนี้</td>
                          <td align="center"><input name="c_view" type="radio" id="c_view" value="1" checked <?php if($R[c_view]=='1' || $R[c_view]==''){ echo 'checked';}?>></td>
                          <td align="center"><input name="c_view" type="radio" id="c_view" value="2" <?php if($R[c_view]=='2'){ echo 'checked';}?>></td>
                          <td align="center"><input name="c_view" type="radio" id="c_view" value="3" <?php if($R[c_view]=='3'){ echo 'checked';}?>></td>
                        </tr>
                        <tr bgcolor="#FFFFFF"> 
                          <td>สิทธิ์ในการตั้งกระทู้ในหมวดนี้</td>
                          <td align="center"><input name="c_question" type="radio"  id="c_question"  value="1" checked <?php if($R[c_question]=='1' || $R[c_question]==''){ echo 'checked';}?>></td>
                          <td align="center"><input name="c_question" type="radio" id="c_question" value="2" <?php if($R[c_question]=='2'){ echo 'checked';}?>></td>
                          <td align="center"><input name="c_question" type="radio" id="c_question" value="3" <?php if($R[c_question]=='3'){ echo 'checked';}?>></td>
                        </tr>
                        <tr bgcolor="#FFFFFF"> 
                          <td>สิทธิ์ในการตอบกระทู้ในหมวดนี้</td>
                          <td align="center"><input name="c_answer" type="radio" value="1" checked <?php if($R[c_answer]=='1' || $R[c_answer]==''){ echo 'checked';}?>></td>
                          <td align="center"><input name="c_answer" type="radio" id="c_answer" value="2" <?php if($R[c_answer]=='2'){ echo 'checked';}?>></td>
                          <td align="center"><input name="c_answer" type="radio" id="a_prof_answer" value="3" <?php if($R[c_answer]=='3'){ echo 'checked';}?>></td>
				    </tr>
                        <tr bgcolor="#FFFFFF">
                          <td>สิทธิ์ในการดาวน์โหลดไฟล์ในหมวดนี้</td>
                          <td align="center"><input name="c_download" type="radio" value="1" checked <?php if($R[c_view_porf]=='1' || $R[c_view_porf]==''){ echo 'checked';}?>></td>
                          <td align="center"><input name="c_download" type="radio" value="2" <?php if($R[c_view_porf]=='2'){ echo 'checked';}?>></td>
                          <td align="center"><input name="c_download" type="radio" value="3" <?php if($R[c_view_porf]=='3'){ echo 'checked';}?>></td>
                        </tr>
					
                    <tr bgcolor="#FFFFFF"> 
                      <td>&nbsp;</td>
                      <td colspan="4"><input type="submit" name="Submit" value="Submit" class="normaltxt"> 
                        <input type="reset" name="Submit2" value="Reset" class="normaltxt"> 
                        <input name="flag" type="hidden" id="flag" value="<?php echo $flag;?>">
                        <input type="hidden" name="wcad" value="<?php echo $wcad; ?>"> </td>
                    </tr>
                  </form>
              </table>
</td>
  </tr>
</table>
      </td>
    </tr>
    <tr valign="top">
      <td colspan="2"><?php @include("com_bottom.php"); ?></td>
    </tr>
  </table>
</div>
</body>
</html>
<script language="JavaScript">
function CHK(){
if(document.form1.t_topic.value == ""){
alert("กรุณาใส่หัวข้อกระทู้");
document.form1.t_topic.focus();
return false;
}
if(document.form1.t_detail.value == ""){
alert("กรุณาใส่หัวข้อรายละเอียด");
document.form1.t_detail.focus();
return false;
}
}
</script>
<?php @$db->db_close(); ?>