<?php
include("administrator.php");
include("lib/include.php");
include("inc.php");
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
          <tr> 
            <td height="25" bgcolor="#CCCCCC"><strong><a href="faq_cate.php">หน้าหลัก 
              FAQ</a></strong><strong>|<a href="faq_stat.php">หน้าสถิติ FAQ</a></strong> <strong>| <a href="faq_user.php">FAQ ที่เข้ามาในระบบ</a></strong> | <strong><a href="index_cate.php">หน้าหลักกระทู้</a></strong></td>
          </tr>
          <tr> 
            <td colspan="2" valign="top"> <DIV align="center"  style="HEIGHT: 100%;OVERFLOW-Y: auto;WIDTH: 100%"> 
                <table width="99%" border="0" align="center" cellpadding="3" cellspacing="1" class="normal_font">
                  <?php
		$Execsql = $db->query("SELECT * FROM f_cat WHERE  f_id = '$f_id' ");
		$row = mysql_num_rows($Execsql);  

		$R = mysql_fetch_array($Execsql);
		   $count = $db->query("SELECT * FROM faq WHERE f_id = '$R[f_id]'  ");
		   $countrow = mysql_num_rows($count);
		$f_cate_name=$R[f_cate];
		   ?>
                  <tr align="center" bgcolor="#3399FF"> 
                    <td height="30" colspan="2" bgcolor="#999999" class="head_font">หมวดย่อยของ <font color="000099">
                      <?php  biz($R[f_cate]); ?>
                    </font></td>
                    <td width="15%" bgcolor="#999999"><strong>แก้ไข ลบ </strong></td>
                  </tr>

                <?php   $sql_subcat="select * from f_subcat where f_id='$R[f_id]'  order by  f_sub_no "  ;
					$query_subcat=$db->query($sql_subcat);
					$row = mysql_num_rows($query_subcat); 
 if($row > 0){
					while($R_SUB=$db->db_fetch_array($query_subcat)){		
 ?>
				  <tr bgcolor="#FFFFFF"    onMouseOver="this.style.backgroundColor='#FFF3E8'" onMouseOut="this.style.backgroundColor='#FFFFFF'">
					<td width="5%" height="42" align="center"><img src="../wb_pic/book_blue.gif" width="24" height="24"></td>
					<td width="80%" height="42" >																	 
			<div align="left" class="head_font"> <li><font color="000099"><?php  biz($R_SUB[f_subcate]); ?></font></div>  &nbsp;  <?php  biz($R_SUB[f_subdetail]); ?></li></td>
		<td height="42" align="center">
				<a href="#" onClick="window.location.href='faq_addsub.php?f_sub_id=<?php echo $R_SUB[f_sub_id];?>&f_id=<?php echo $f_id?>'"><img src="../images/b_edit.gif" border="0" alt="แก้ไข"> </a>
				<a href="faqfunction.php?flag=deletesubcate&f_sub_id=<?php echo $R_SUB[f_sub_id];?>&f_id=<?php echo $f_id?>" onClick="return confirm('Are you sure to delete this subcategory?');"><img src="../images/b_delete.gif" border="0" alt="ลบ"> </a>
				  <?php if($R_SUB[f_use]=='Y') {?>
				  <a href="faqfunction.php?flag=dropsubcate&f_sub_id=<?php echo $R_SUB[f_sub_id];?>&f_id=<?php echo $f_id?>" onClick="return confirm('Are you sure to drop this subcategory?');"><img src="../images/bar_down.gif" alt="ซ่อน" border="0"></a>
				  <?php }else{  ?>
				  <a href="faqfunction.php?flag=showsubcate&f_sub_id=<?php echo $R_SUB[f_sub_id];?>&f_id=<?php echo $f_id?>" onClick="return confirm('Are you sure to show this subcategory?');"><img src="../images/bar_up.gif" alt="แสดง" border="0"></a>
				  <?php }?></td>
				  </tr>  

<?php } }else{ ?>
                  <tr bgcolor="#FFFFFF"> 
                    <td height="30" colspan="3"><div align="center"><font color="#FF0000"><strong>ไม่มี<span class="head_font">หมวดย่อยของ<font color="000099"> <?php echo $f_cate_name; ?></font></span></strong></font></div></td>
                  </tr>
                  <?php } ?>
                </table>
                <br>
                <table width="60%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#000000" class="normal_font">
                  <form name="form1" enctype="multipart/form-data" method="post" action="faqfunction.php" onSubmit="return CHK()">
						<?php
						if($f_sub_id){
						$query_edit=$db->query("select * from f_subcat where f_sub_id='$f_sub_id' ");
						$R_EDIT=$db->db_fetch_array($query_edit);
						$flag="editsubcate";
						$f_id=$R_EDIT[f_id];
						}else{
						$flag="subcate";
						}
						?>
                    <tr align="center" bgcolor="#3399FF"> 
                      <td height="30" colspan="2" bgcolor="#999999" class="head_font">เพิ่มหมวดย่อยของ<font color="000099">
                        <?php echo $f_cate_name; ?>
                      </font> </td>
                    </tr>
                    <tr bgcolor="#FFFFFF"> 
                      <td width="20%">ชื่อหมวดย่อย<font color="#FF0000">*</font></td>
                      <td width="80%"><input name="t_topic" type="text" class="normaltxt" id="t_topic" size="60" value="<?php echo $R_EDIT[f_subcate]?>"> 
                      </td>
                    </tr>
                    <tr bgcolor="#FFFFFF"> 
                      <td>รายละเอียด<font color="#FF0000">*</font></td>
                      <td><textarea name="t_detail" cols="60" rows="4" wrap="VIRTUAL" class="normaltxt" id="t_detail" ><?php echo $R_EDIT[f_subdetail]?></textarea> 
                      </td>
                    </tr>
                    <tr bgcolor="#FFFFFF">
                      <td>ลำดับที่การแสดง</td>
                      <td><input name="f_sub_no" type="text" id="f_sub_no" value="<?php echo $R_EDIT[f_sub_no]?>" size="3" maxlength="3"  onKeyPress="return(NumberFormat(this,event));"></td>
                    </tr>
                    <tr bgcolor="#FFFFFF"> 
                      <td>&nbsp;</td>
                      <td><input type="submit" name="Submit" value="Submit" class="normaltxt"> 
                        <input type="reset" name="Submit2" value="Reset" class="normaltxt"> 
                        <input name="flag" type="hidden" id="flag" value="<?php echo $flag?>"> 
                        <input name="f_id" type="hidden" id="f_id" value="<?php echo $f_id?>">
  						<input name="f_sub_id" type="hidden" id="f_id" value="<?php echo $f_sub_id?>">
                      </td>
                    </tr>
                  </form>
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
if(document.form1.t_topic.value == ""){
alert("กรุณาใส่หัวข้อ FAQ");
document.form1.t_topic.focus();
return false;
}
if(document.form1.t_detail.value == ""){
alert("กรุณาใส่หัวข้อรายละเอียด");
document.form1.t_detail.focus();
return false;
}
}
function NumberFormat(fld,e){
					var strCheck = '0123456789.';
					var len = 0;
					var whichCode = (window.Event) ? e.which : e.keyCode;
					key = String.fromCharCode(whichCode); 
					if (strCheck.indexOf(key) == -1) {
					alert('กรุณากรอกกรอกเป็นตัวเลข');
					return false;
					}
}

</script>
<?php @$db->db_close(); ?>