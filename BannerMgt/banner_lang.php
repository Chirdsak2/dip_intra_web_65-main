<?php
$namefolder = 'banner_'.$_GET[lang].'_'.$_GET[id];
$Current_Dir1 = "../ewt/".$_SESSION["EWT_SUSER"]."/language/".$namefolder.".php";
@include($Current_Dir1);
?>
<form name="form1" method="post" action="banner_process_lang.php" onSubmit="return CHK(this);">
  <table width="100%" border="0" cellpadding="5" cellspacing="1" bgcolor="#000000">
  <tr>
    <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="right"><a href="javascript:void(0);" onClick="document.getElementById('nav').style.display='none';"><img src="../images/b_delete.gif" width="14" height="14" border="0" align="top" /></a></td>
      </tr>
    </table>
      <table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" bgcolor="#999999" class="ewttableuse">
  <tr>
    <th height="23" colspan="2" bgcolor="#FFFFFF" class="ewttablehead" scope="col"><div align="left">&nbsp;&nbsp;&bull;&nbsp;เธเธฃเธธเธ“เธฒเนเธชเนเธ เธฒเธฉเธฒเธ•เธฒเธกเธ—เธตเนเธ—เนเธฒเธเน€เธฅเธทเธญเธ(<?php echo $_GET[lang];?>)</div></th>
  </tr>
  <tr>
    <td width="29%" height="23" bgcolor="#FFFFFF">เธเธทเนเธญเธเนเธฒเธขเนเธเธฉเธ“เธฒ :  <strong style="color:#FF0000">*</strong></td>
    <td width="71%" height="23" bgcolor="#FFFFFF"><input name="banner_name" type="text" size="50" value="<?php echo $banner_name?>">    </td>
  </tr>
  <tr>
    <td height="23" bgcolor="#FFFFFF">เธฃเธฒเธขเธฅเธฐเน€เธญเธตเธขเธ” : </td>
    <td height="23" bgcolor="#FFFFFF"><textarea name="banner_detail" cols="50" rows="3"><?php echo $banner_detail?>
</textarea>    </td>
  </tr>
  <tr>
    <td height="11" bgcolor="#FFFFFF">เธเธณเธญเธเธดเธเธฒเธข : </td>
    <td height="11" bgcolor="#FFFFFF"><input name="txt_alt" type="text" id="txt_alt" size="50" value="<?php echo $txt_alt;?>"></td>
  </tr>
   <tr>
    <td height="23" bgcolor="#FFFFFF">&nbsp;</td>
    <td height="23" bgcolor="#FFFFFF"><input type="submit" name="Submit" value="เธเธฑเธเธ—เธถเธ">
      
      <input type="hidden" name="flag" value="set_lang">
      <input type="hidden" name="banner_id" value="<?php echo $_GET[id]?>">
	  <input type="hidden" name="banner_gid" value="<?php echo $_GET[gid]?>">
	  <input type="hidden" name="lang" value="<?php echo $_GET[lang]?>">    </td>
  </tr>
</table></td>
  </tr>
</table>

</form>

