<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<form name="frm1" action="" method="post">
<?php
	$sql_category = "SELECT * FROM gallery_category WHERE category_id = '".$_GET[category_id]."' ";
	$query_category = $db->query($sql_category);
	$rs_category = $db->db_fetch_array($query_category);
	$limit = $rs_category[col]*$rs_category[row];
	
	if($_POST[page]) $page = $_POST[page];
	else $page = $_GET[page];
	if(!$limit) $limit = 5;
	if($page == '' || $page < 1)$page =1;
	$page1=$page-1;
	if($page1 == '' || $page1 < 0)$page1 =0;
	
	$sql_img = "SELECT * FROM gallery_cat_img INNER JOIN gallery_image ON gallery_cat_img.img_id = gallery_image.img_id WHERE gallery_cat_img.category_id = '".$_GET[category_id]."' ORDER BY cat_img_id";
	$query_img = $db->query($sql_img);
	$num_img = $num_all = $db->db_num_rows($query_img);
	
	if($num_all%$limit==0){
		@$page_all = $num_all/$limit;
	}else{
		@$page_all = (int)($num_all/$limit)+1;
	}
	if($page_all==0) $page_all = 1;
	if($page>=$page_all){$page1 = $page_all-1;$page=$page_all;}
	$sql_2 = $sql_img."  limit ".$page1*$limit.",$limit";
	$query = $db->query($sql_2);
	$num_rows_2 = $db->db_num_rows($query);
	$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";
?>
<table width="300"  border="0" align="center" cellpadding="0" cellspacing="1">
  <tr>
    <td valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td height="6" width="7"><img src="<?php echo $path;?>images/head_left.gif" width="7" height="6"></td>
        <td bgcolor="#5599CC"></td>
        <td height="6" width="7"><img src="<?php echo $path;?>images/head_right.gif" width="7" height="6"></td>
      </tr>
      <tr>
        <td height="30" width="7" bgcolor="#5599CC"></td>
        <td valign="middle" bgcolor="#5599CC" height="30"><div align="center"><strong style="color:#FFFFFF">หมวด <?php echo $rs_category[category_name]?></strong></div></td>
        <td height="30" width="7" bgcolor="#5599CC"></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#006699">
      <tr>
        <td bgcolor="#FFFFFF" align="center"><br>
          <table border="0" cellpadding="5" cellspacing="1">
          <tr>
            <td><div align="center">
              <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1">
			  	<?php 
					if($num_rows_2 > 0){
						for($i=1;$i<=$num_rows_2;$i++){
							$rs_img = $db->db_fetch_array($query);
							if($i%$rs_category[col] == 0 && $i==1) {
							?>
							<tr align=\"center\">
							<?php }?>
							<td width=\"250\" align=\"center\">
								
							  <table border="0" cellpadding="1" cellspacing="1" bgcolor="#FFFFFF" align="center" style="cursor:hand" onMouseOver="document.getElementById('name_<?php echo $rs_img[img_id]?>').style.color = '#FF0000'; " onMouseOut="document.getElementById('name_<?php echo $rs_img[img_id]?>').style.color = '#000000'; " onClick="location.href='gallery_view_img_comment.php?category_id=<?php echo $_GET[category_id]?>&img_id=<?php echo $rs_img[img_id]?>&page_cat=<?php echo $page?>';">
								  <tr>
									<td bgcolor="#FFFFFF"  align="center"><table border="0" cellpadding="1" cellspacing="1" bgcolor="#999999" align="center">
								  <tr>
									<td bgcolor="#FFFFFF"  align="center"><img src="<?php echo $Globals_Dir.$rs_img[img_path_s]?>" height="100" width="100"></td>
								  </tr>
							  </table></td>
					        </tr>
								  <tr>
									<td bgcolor="#FFFFFF"  align="center"><span id="name_<?php echo $rs_img[img_id]?>"><?php echo $rs_img[img_name]?></span></td>
								  </tr>
							  </table>							</td>
							<?php
							if($i%$rs_category[col] == 0 ) {
							?>
							</tr>
							<?php }?>
               <!-- <tr>
                  <td>&nbsp;</td>
                </tr>-->
				<?php 
						}// end for
					}else{//end if num_rows_2
				?>
					<tr><td align="center" style="color:#FF0000"><strong>ไม่มีรูปภาพ</strong></td></tr>
				<?php }?>
              </table>
            </div></td>
          </tr>
        </table>
          <br></td>
      </tr>
    </table>
      <table width="100%" border="0" align="left">
        <tr>
          <th scope="col"><div align="right">หน้าที่
              <select name="page" onChange="document.frm1.submit();">
                <?php
							for($i=1;$i<=$page_all;$i++){
								if($i == $page) $selected = "selected";
								else $selected = "";
								print "<option value=\"$i\" $selected>$i</option>";
							}
						?>
              </select>
/
<?php echo $page_all?>
หน้า</div></th>
        </tr>
      </table></td>
  </tr>
</table>
</form>
</body>
</html>
<?php
$db->db_close(); ?>
