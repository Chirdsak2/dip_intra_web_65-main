<?php
include("administrator.php");
include("lib/include.php");
include("inc.php");
include("../language/rude_language.php");


  $sql_config = $db->query("SELECT * FROM mobile_config");

  while($config = $db->db_fetch_array($sql_config)) {
    $a_data[$config['mconf_code']] = $config['mconf_value'];
  }

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
    <td><img src="../theme/main_theme/rude_function.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction">Mobile setting</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"> <hr>
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
                <tr bgcolor="#FFFFFF"> 
                  <td align="left" style="width: 180px">รูป Logo </td>
                  <td> <input type="text" name="logo" value="<?php echo $a_data['logo']; ?>" size="40" /> 
        <img src="../images/folder_img.gif" height="20" width="20" align="absmiddle" alt="<?php echo $text_genbanner_formpic2;?>" style="cursor:hand" onClick="window.open('../FileMgt/gallery_insert.php?stype=images&Flag=Link&o_value=window.opener.document.all.logo.value','','width=800 , height=500');">                   </td>
                </tr>
                <tr bgcolor="#FFFFFF">
                  <td></td>
                  <td><input type="hidden" name="flag" value="setting"><button type="submit">บันทึก</button></td>
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
