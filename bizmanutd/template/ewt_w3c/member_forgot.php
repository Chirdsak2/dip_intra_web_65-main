<?php
$path = "../";
	session_start();
	$start_time_counter = date("YmdHis");
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");
	include("include/ewt_block_function.php");
	include("include/ewt_menu_preview.php");
	include("include/ewt_article_preview.php");
	include("ewt_template.php");
?>
<?php echo $template_design[0];?>
<?php
			$mainwidth = $F["d_site_content"];
			?>
			
			
			<form name="form1" method="post" action="ewt_login.php" onSubmit="return  chknull(this);">
  <br>
  <table width="90%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#999999">
    <tr bgcolor="#E7E7E7"> 
      <td colspan="2"><div align="center"><strong>ลืมรหัสผ่าน </strong></div></td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td width="15%"><strong>E-mail :<font color="#FF0000"></font></strong></td>
      <td width="85%"><input name="member_email" type="text" id="member_email" size="30"  onBlur="mail_format(this)"> 
      </td>
    </tr>
    <tr bgcolor="#FFFFFF"> 
      <td>&nbsp;</td>
      <td> <input name="บันทึก" type="submit"  value="ตกลง"> <input type="reset" name="Submit2" value="ยกเลิก"> 
        <input type="hidden" name="Flag" value="forgot">
      </td>
    </tr>
  </table>
  <div align="center"></div>
</form>
<?php include("include_logo_w3c_template.php");?>
<?php $db->db_close(); ?>