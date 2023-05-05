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
<form name="form1" method="post" action="">
<br>
<table width="95%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF" align="center">
  <tr> 
    <td valign="top" align="center"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
      <tr>
        <th width="89%" height="23" bgcolor="#CCFFEE" scope="col">ชื่อหมวด</th>
        <th width="11%" height="23" bgcolor="#CCFFEE" scope="col">ลบ</th>
      </tr>
	  <?php
	  	if($_GET[flag] == "add"){
			$sql = "select * from gallery_tmp_cat_img inner join gallery_category on gallery_tmp_cat_img.category_id = gallery_category.category_id where gallery_tmp_cat_img.tmp_id = '".$_GET[random_id]."' ";
			$query = $db->query($sql);
			$nums = $db->db_num_rows($query);
		}elseif($_GET[flag] == "edit"){
			
		}
		if($nums > 0){
		
	  ?>
	   <tr>
        <td height="23" bgcolor="#FFFFFF"><div align="center"></div></td>
        <td height="23" bgcolor="#FFFFFF"><div align="center"><img src="../images/b_delete.gif" height="14" width="14" align="absmiddle" alt="del.." style="cursor:hand" onClick="if(confirm('ยืนยันการลบ')){}else{return false}"></div></td>
      </tr>
	  <?php
	  }else{
	  ?>
	   <tr>
        <td height="23" colspan="2" bgcolor="#FFFFFF"><div align="center" style="color:#FF0000"><strong>ไม่พบข้อมูล</strong></div>          </td>
        </tr>
	  <?php
	  }
	  ?>
    </table></td>
  </tr>
</table>
</form>
</body>
</html>
<?php
$db->db_close(); ?>
