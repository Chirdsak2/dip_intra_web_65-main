<?php
	session_start();
	include("../../blog/lib/user_config.php");

	$conn=mysql_connect($EWT_ROOT_HOST,$EWT_ROOT_USER,$EWT_ROOT_PASSWORD);
	$db=mysql_select_db($EWT_DB_NAME,$conn);
	
if($_POST[Submit]=="เข้าสู่ระบบ"){
		$sql="UPDATE `blog_list` SET `blog_list`.`blog_theme_id`='$_POST[chktheme]' WHERE `blog_list`.`blog_id`='$_POST[blog_id]' ";
		$exc=mysql_query($sql);
		echo "<script>alert('ทำการติดตั้งเรียบร้อย ขณะนี้ท่านกำลังเข้าสู่ระบบ My Blog'); window.location.href='blog.php?blog_id=$_POST[blog_id]';</script>";
		exit;
	}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" >
<title>My Blog -- เลือก Theme</title>
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
<form name="frm" action="?" method="post">
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
            <td width="50"><img src="../../blog/images/conner_top_left.jpg" width="50" height="50" alt=""></td>
            <td style="background:url(../../blog/images/top_bg.jpg)">&nbsp;</td>
            <td width="50"><img src="../../blog/images/conner_top_right.jpg" width="50" height="50" alt=""></td>
            <td width="50" rowspan="3" style="background:url(../../blog/images/line_right.jpg)">&nbsp;</td>
          </tr>
          <tr>
            <td  style="background:url(../../blog/images/left_bg.jpg)">&nbsp;</td>
            <td height="450" valign="top" bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="5" cellpadding="0">
              <tr>
                <td colspan="3" align="left" valign="top">&nbsp;</td>
              </tr>
              	<?php
						$sql_theme="SELECT * FROM `blog_theme` ORDER BY `blog_theme`.`theme_name` ";
						$exc_theme=mysql_query($sql_theme);
						$chk="checked";
						while($row_theme=$db->db_fetch_array($exc_theme)){
				?>
              <tr>
                <td width="20" align="left" valign="top"><input name="chktheme" type="radio" value="<?php echo $row_theme[theme_id]; ?>" <?php echo $chk;  ?> ></td>
                <td width="150" align="left"><img src="../../blog/theme/<?php echo $row_theme[theme_name]; ?>/ex_theme.jpg" width="150" height="150" alt="<?php echo $row_theme[theme_name]; ?>"></td>
                <td align="left" valign="top"><strong>ชื่อ Theme:</strong> <?php echo $row_theme[theme_name]; ?></td>
              </tr>
			  <?php
			  			$chk="";
			  		}
			  ?>
              <tr>
                <td colspan="3" align="left">&nbsp;</td>
              </tr>

              <tr>
                <td colspan="3" align="center"><input name="Submit" type="submit" class="font_basic" value="เข้าสู่ระบบ" style="width:80px" >
                  <input name="blog_id" type="hidden" id="blog_id" value="<?php echo $_GET[blog_id]; ?>" ></td>
              </tr>
            </table></td>
            <td style="background:url(../../blog/images/right_bg.jpg)">&nbsp;</td>
            </tr>
          
          <tr>
            <td><img src="../../blog/images/conner_bottom_left.jpg" width="50" height="50" alt=""></td>
            <td style="background:url(../../blog/images/bottom_bg.jpg)">&nbsp;<a href="http://validator.w3.org/check?uri=referer"><img src="../w3c/checked/images/w3c_gold.bmp" alt="Valid HTML 4.01 Transitional" height="31" width="88" border="0"></a><?php  include("ewt_span.php");?></td>
            <td><img src="../../blog/images/conner_bottom_right.jpg" width="50" height="50" alt=""></td>
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

