<?php
include("administrator.php");
include("inc.php");
include("lib/include.php");

$sql = $db->query("SELECT * FROM faq WHERE fa_id = '$fa_id'");
$R = mysql_fetch_array($sql);
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
<div align="center">
  <table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
    <tr valign="top">
      <td colspan="2"><?php @include("com_top.php"); ?></td>
    </tr>
    <tr>
      <td valign="top"></td>
      <td width="100%" height="100%" valign="top"><table width="100%" height="100%" border="0" cellpadding="2" cellspacing="0" class="normal_font">
<?php
$Execsql1 = $db->query("SELECT * FROM f_subcat WHERE f_sub_id = '$f_sub_id'");
$QQ= mysql_fetch_array($Execsql1);
?>
  <tr>
    <td height="25" bgcolor="#CCCCCC"><strong><a href="faq_cate.php">หน้าหลัก FAQ</a> 
              | <a href="faq_stat.php">หน้าสถิติ FAQ</a> | <a href="faq_user.php">FAQ ที่เข้ามาในระบบ</a><img src="../wb_pic/arrow_r.gif" width="7" height="7" align="absmiddle"> 
              <a href="faq_question.php?f_id=<?php echo $f_id; ?>&f_sub_id=<?php echo $f_sub_id; ?>"><?php echo $QQ[f_subcate]; ?></a></strong></td>
  </tr>
  <tr>
    <td colspan="2" valign="top">
	<DIV align="center"  style="HEIGHT: 100%;OVERFLOW-Y: auto;WIDTH: 100%"><br>
                <strong><font size="4" face="Tahoma">แก้ไข FAQ</font></strong><br>
                 <br>
                 <table width="50%" border="0" cellpadding="2" cellspacing="1" bgcolor="#000000">
                   <tr>
                     <td bgcolor="#FFFFFF"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="normal_font">
                       <form name="form1" method="post" action="faqfunction.php">
					    <tr bgcolor="#FFFFFF">
                           <td>หมวดหมู่ : </td>
                           <td height="30" bgcolor="#FFFFFF">
						   <select name="faqsub_id">
						   <!--<option value="">--เลือกหมวดหมู่ Faq--</option>-->
						   <?php
						   $sql_group = "select * from f_subcat";
						   $query_group = $db->query($sql_group);
						   while($rec_gruop = $db->db_fetch_array($query_group)){
						   if($rec_gruop[f_sub_id]==$f_sub_id){ $c = "selected";}else{ $c = '';}
						   echo '<option value="'.$rec_gruop[f_sub_id].'"   '.$c.'>'.$rec_gruop[f_subcate].'</option>';
						   }
						   ?>
                           </select>
						   </td>
                         </tr>
                         <tr bgcolor="#FFFFFF">
                           <td width="20%">หัวข้อ : </td>
                           <td width="80%" bgcolor="#FFFFFF"><textarea name="fname" cols="50" rows="3" wrap="VIRTUAL" id="fname"><?php echo eregi_replace("<br>","", $R[fa_name]); ?></textarea></td>
                         </tr>
                         <tr bgcolor="#FFFFFF">
                           <td>รายละเอียด : </td>
                           <td bgcolor="#FFFFFF"><textarea name="fdetail" cols="50" rows="4" wrap="VIRTUAL" id="fdetail"><?php echo eregi_replace("<br>","", $R[fa_detail]); ?></textarea></td>
                         </tr>
                         <tr bgcolor="#FFFFFF">
                           <td>คำตอบ : </td>
                           <td bgcolor="#FFFFFF"><textarea name="fans" cols="50" rows="5" wrap="VIRTUAL" id="fans"><?php echo eregi_replace("<br>","", $R[fa_ans]); ?></textarea></td>
                         </tr>
                         <tr bgcolor="#FFFFFF">
                           <td>สถานะ : </td>
                           <td bgcolor="#FFFFFF"><input name="faq_use" type="radio" value="Y" checked>
                             แสดง
                             <input name="faq_use" type="radio" value="N" <?php if($R[faq_use]=='N'){ echo "checked";  } ?>>
                             ไม่แสดง </td>
                         </tr>
                         <tr bgcolor="#FFFFFF">
                           <td>แนะนำ : </td>
                           <td bgcolor="#FFFFFF"><input type="checkbox" name="faq_top" value="Y" <?php if($R[faq_top]=='Y'){ echo "checked";  } ?>></td>
                         </tr>
                         <tr bgcolor="#FFFFFF">
                           <td>&nbsp;</td>
                           <td height="30" valign="bottom" bgcolor="#FFFFFF"><input type="submit" name="Submit" value="Submit">
                               <input name="flag" type="hidden" id="flag2" value="editfaq">
                               <input name="f_id" type="hidden" id="f_id" value="<?php biz($R[f_id]); ?>">
                               <input name="f_sub_id" type="hidden" id="f_sub_id" value="<?php biz($R[f_sub_id]); ?>">
                               <input name="fa_id" type="hidden" id="fa_id" value="<?php echo $fa_id; ?>"></td>
                         </tr>
                        
                       </form>
                     </table></td>
                   </tr>
                 </table>
	</DIV></td>
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
if(document.form1.a_detail.value == ""){
alert("กรุณาใส่รายละเอียด");
document.form1.a_detail.focus();
return false;
}
if(document.form1.t_name.value == ""){
alert("กรุณาใส่ชื่อ");
document.form1.t_name.focus();
return false;
}
}
</script>
<?php @$db->db_close(); ?>