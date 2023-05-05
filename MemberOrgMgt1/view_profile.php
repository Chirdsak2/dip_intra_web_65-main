<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
$uploaddir = "../ewt/pic_upload/";

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
        <td align="center" background="../images/border_25.jpg" class="ewtfunction style1">ข้อมูลเจ้าหน้าที่</td>
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
			$selete_user="SELECT  * 
                          FROM
  `gen_user`
  LEFT OUTER JOIN `emp_type` ON (`gen_user`.`emp_type_id` = `emp_type`.`emp_type_id`)
  LEFT OUTER JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`) 
  LEFT OUTER JOIN `position_name` ON (`gen_user`.`posittion` = `position_name`.`pos_id`)  Where  gen_user.gen_user_id='$emp_id'  ";
			$exec_user=$db->query($selete_user);
			$rst_user = $db->db_fetch_array($exec_user);

			if($rst_user[path_image]){
			   $path_image=$uploaddir.$rst_user[path_image];
			   if(file_exists($path_image)){
				$path_image = $path_image;
				}else{
				$path_image = "../images/ImageFile.gif";
				}
			}else{
			   $path_image="../images/ImageFile.gif";
			}
			$sql_title = "SELECT title_thai FROM title where title_id = '$rst_user[title_thai]'";
			$query_title = $db->query($sql_title);
			$rec = $db->db_fetch_array($query_title);
			$sql_title_en = "SELECT title_eng FROM title where title_id = '$rst_user[title_eng]'";
			$query_title_en = $db->query($sql_title_en);
			$rec_en = $db->db_fetch_array($query_title_en);
		?>
            <td width="208" height="20" align="right" bgcolor="#FFFFFF">&nbsp;&nbsp;ชื่อ-นามสกุล :</td>
            <td width="251" bgcolor="#FFFFFF">&nbsp;<?php echo $rec[title_thai]." ".$rst_user[name_thai]."&nbsp;&nbsp;".$rst_user[surname_thai]; ?></td>
            <td width="176" rowspan="3" align="center" bgcolor="#FFFFFF"><img src="<?php echo $path_image; ?>" width="98" height="98" /></td>
          </tr>
          <tr style="display:none">
            <td height="20" align="right" bgcolor="#FFFFFF" class="Table-Text-Head">&nbsp; Name-Surname :</td>
            <td bgcolor="#FFFFFF">&nbsp;<?php if($rst_user[name_eng] != ''){ echo $rec_en[title_eng]." ".$rst_user[name_eng]."&nbsp;&nbsp;".$rst_user[surname_eng];} ?></td>
          </tr>
          <tr>
            <td height="20" align="right" bgcolor="#FFFFFF" class="Table-Text-Head">&nbsp;&nbsp;ตำแหน่งทางวิชาการ :</td>
            <td bgcolor="#FFFFFF">&nbsp;
                <?php echo $rst_user[position_person]; ?></td>
          </tr>
          <tr>
            <td height="9" align="right" bgcolor="#FFFFFF" class="Table-Text-Head">&nbsp;&nbsp;หน่วยงาน :</td>
            <td colspan="2" bgcolor="#FFFFFF">&nbsp;<?php echo $rst_user[name_org];?></td>
          </tr>
          <tr>
            <td height="10" align="right" bgcolor="#FFFFFF" class="Table-Text-Head">ตำแหน่งภายในหน่วยงาน : </td>
            <td colspan="2" bgcolor="#FFFFFF">&nbsp;<?php if($rst_user[pos_name] != ''){echo $rst_user[pos_name];}else{ echo '-';}?></td>
          </tr>
          <tr>
            <td height="20" align="right" bgcolor="#FFFFFF" class="Table-Text-Head">&nbsp;&nbsp;Email  : </td>
            <td colspan="2" bgcolor="#FFFFFF">&nbsp;<?php echo $rst_user[email_person];?></td>
          </tr>


          <tr>
            <td height="20" align="right" bgcolor="#FFFFFF" class="Table-Text-Head">&nbsp;&nbsp;เบอร์ต่อสะดวก :</td>
            <td colspan="2" bgcolor="#FFFFFF">&nbsp;<?php echo $rst_user[tel_in];?></td>
          </tr>

          <tr>
            <td height="20" align="right" bgcolor="#FFFFFF" class="Table-Text-Head">&nbsp;&nbsp;สถานที่ทำงาน :</td>
            <td colspan="2" bgcolor="#FFFFFF">&nbsp;<?php echo $rst_user[officeaddress];?></td>
          </tr>
          <tr>
            <td height="20" align="right" bgcolor="#FFFFFF" class="Table-Text-Head">ชื่อผู้ใช้ : </td>
            <td colspan="2" bgcolor="#FFFFFF">&nbsp;<?php echo $rst_user[gen_user];?></td>
          </tr>
          <tr>
            <td height="20" align="right" bgcolor="#FFFFFF" class="Table-Text-Head">รหัสผ่าน : </td>
            <td colspan="2" bgcolor="#FFFFFF">&nbsp;<?php echo $rst_user[gen_pass];?></td>
          </tr>
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
