<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title><?php echo $proj_title;?></title>
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #FFFFFF}
-->
</style></head>

<body>
<form  name="frm" method="post" action="">
<table width="96%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center"><table width="50%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="12" height="22"><img src="../images/border_24.jpg" width="12" height="32" /></td>
        <td align="center" background="../images/border_25.jpg" class="ewtfunction style1">ข้อมูล TAG </td>
        <td width="12"><img src="../images/border_28.jpg" width="12" height="32" /></td>
      </tr>
    </table></td>
  </tr>
</table>

  <table width="77%" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
      <td align="left"><table width="100%" border="0" cellpadding="3" cellspacing="1">
          <tr>
            <?php
		//webpage_info check data for w3c
  $db->query("USE ".$EWT_DB_W3C);
   $sql_tag = "SELECT tag_info.*,  section_name FROM  tag_info LEFT JOIN tag_section ON  tag_info.section_id = tag_section.section_id  where tag_id = '".$_GET[tag_id]."' ORDER BY tag_name ";
   $query= $db->query($sql_tag);
   $R = $db->db_fetch_array($query);
		?>
            <td width="208" height="20" align="right" bgcolor="#FFFFFF">Tag Name :</td>
            <td bgcolor="#FFFFFF">&nbsp;<?php echo $R[tag_name];?></td>
          </tr>
          <tr >
            <td height="20" align="right" bgcolor="#FFFFFF" class="Table-Text-Head">Tag Section :</td>
            <td bgcolor="#FFFFFF">&nbsp;<?php echo $R[section_name];?></td>
          </tr>
          <tr>
            <td height="20" align="right" bgcolor="#FFFFFF" class="Table-Text-Head">ต้องมี Tag นี้  :</td>
            <td bgcolor="#FFFFFF">&nbsp;
                <?php echo ($R[need_status]=='1')? "ใช่":"&nbsp;";?></td>
          </tr>
          <tr>
            <td height="9" align="right" bgcolor="#FFFFFF" class="Table-Text-Head">ต้องมี Tag ปิด :</td>
            <td bgcolor="#FFFFFF">&nbsp;<?php echo ($R[need_close]=='1')? "ใช่":"&nbsp;";?></td>
          </tr>
          <tr>
            <td height="10" align="right" bgcolor="#FFFFFF" class="Table-Text-Head">Tag แม่ : </td>
            <td bgcolor="#FFFFFF">&nbsp;<?php echo $R[tag_grand];?></td>
          </tr>
          <tr>
            <td height="20" align="right" bgcolor="#FFFFFF" class="Table-Text-Head">Tag นำหน้า 1  : </td>
            <td bgcolor="#FFFFFF">&nbsp;<?php echo $R[tag_parent];?></td>
          </tr>


          <tr>
            <td height="20" align="right" bgcolor="#FFFFFF" class="Table-Text-Head">Tag นำหน้า 2 :</td>
            <td bgcolor="#FFFFFF">&nbsp;<?php echo $R[tag_parent2];?></td>
          </tr>

          <tr>
            <td height="20" align="right" bgcolor="#FFFFFF" class="Table-Text-Head">Tag นำหน้า 3 :</td>
            <td bgcolor="#FFFFFF">&nbsp;<?php echo $R[tag_parent3];?></td>
          </tr>
          <tr>
            <td height="20" align="right" bgcolor="#FFFFFF" class="Table-Text-Head">W3C ไม่อนุญาติ : </td>
            <td bgcolor="#FFFFFF">&nbsp;<?php echo ($R[w3c_notallow]=='N')? "Not Allow":"&nbsp;";?></td>
          </tr>
		  <?php $db->query("USE ".$EWT_DB_NAME);?>
      </table></td>
    </tr>
  </table>
  <div align="center"><br />
    <br />
    <input name="Submit" type="submit" class="submit"  style="width:100" onclick="window.close();" value="ปิดหน้าต่าง" />
  </div>
</form>
</body>
</html>
