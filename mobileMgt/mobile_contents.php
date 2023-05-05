<?php
include("administrator.php");
include("lib/include.php");
include("inc.php");
include("../language/rude_language.php");


  $sql_cate = $db->query("SELECT * FROM mobile_contents left join article_group on article_group.c_id=mobile_contents.c_id order by mobile_contents.mcont_order");


?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" class="normal_font">
<div align="center">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/rude_function.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction">Mobile</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">
<a href="mobile_new.php"><img src="../theme/main_theme/g_add_document.gif" width="16" height="16" border="0" align="absmiddle"> 
      เพิ่มหมวด</a>     <hr>
    </td>
  </tr>
</table>
  <table width="94%" height="100%" border="0" cellpadding="0" cellspacing="0">
    <tr valign="top">
      <td colspan="2"><?php @include("com_top.php"); ?></td>
    </tr>
    <tr>
      <td valign="top"></td>
      <td width="100%" height="100%" valign="top">
	  <form name="form" method="post" action="mobile_function.php">
	  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" class="normal_font">
          <tr> 
            <td  valign="top"> 
                  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#B74900" class="ewttableuse">
                    <tr align="center" class="ewttablehead"> 
                      <td>หมวด</td>
                      <td width="100">ลำดับ</td>
                    </tr>
<?php
  while($cate = $db->db_fetch_array($sql_cate)) {
?>
                    <tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F5E0CD'" onMouseOut="this.style.backgroundColor='#FFFFFF'"> 
                      <td align="left"><?php echo $cate['c_name']; ?></td>
                      <td align="center"> <input type="text" name="c_name[<?php echo $cate['c_id']; ; ?>]" value="<?php echo $cate['mcont_order']; ?>" size="6" /> </td>
                    </tr>
<?php } ?>
                    <tr bgcolor="#FFFFFF">
                      <td></td>
                      <td align="center"><input type="hidden" name="flag" value="order"><button type="submit">บันทึก</button></td>
                    </tr>
                  </table>
			 </td>
          </tr>
        </table>
		
  </form>
		
      </td>
    </tr>
    <tr valign="top">
      <td colspan="2"><?php @include("com_bottom.php"); ?></td>
    </tr>
  </table>
</div>
</body>
</html>
<?php $db->db_close(); ?>
