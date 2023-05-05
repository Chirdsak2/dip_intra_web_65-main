<?php
header ("Content-Type:text/plain;charset=UTF-8");
?>
<form action="language_setup_web.php" method="post" enctype="multipart/form-data" name="form" onSubmit="return CHK(this);">
<table width="300" border="0" cellpadding="3" cellspacing="1" bgcolor="#000000">
  <tr>
    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td height="40" colspan="2" valign="top"><strong>กรุณาเลือกไฟล์ภาษาที่ต้องการ....</strong></td>
          <td width="2%" align="right" valign="top"><a href="javascript:void(0);" onClick="document.getElementById('nav').style.display='none';"><img src="../theme/main_theme/g_del.gif" width="16" height="16" border="0"></a></td>
        </tr>
        <tr>
          <td width="28%" align="right"> เลือกไฟล์ <span class="style1">*</span> &nbsp;:&nbsp;</td>
          <td width="70%"><input type="file" name="file" /></td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td height="40">&nbsp;</td>
          <td height="50" valign="bottom">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="submit" name="Submit" value="upload file">
          <input type="hidden" name="m_id" value="<?php echo $_GET[m_id];?>">
		  <input type="hidden" name="flag" value="upload"></td>
          <td>&nbsp;</td>
        </tr>
      </table></td>
  </tr>
  
</table></form>
