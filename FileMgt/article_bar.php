<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
	?>
<html>
<head>
<title>My Website</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="https://fonts.googleapis.com/css?family=Itim|Kanit|Lobster|Mitr|Pridi|Prompt|Roboto|Roboto+Condensed|Slabo+27px|Sriracha" rel="stylesheet"> 

<link rel="shortcut icon" type="image/icon" href="../EWT_ADMIN/images/logo_biz.png"/>

<!-- bootstrap 3.3.7 -->
<link href="../EWT_ADMIN/css/bootstrap.css" rel="stylesheet"/>
<!-- END -->

<!-- Main Style -->
<link href="../EWT_ADMIN/style.css" rel="stylesheet"/>
<link rel="stylesheet" href="../EWT_ADMIN/css/backend_style.css"/>
<link rel="stylesheet" href="../EWT_ADMIN/css/icons.css"/>
<!-- END -->

</head>
<body leftmargin="0" topmargin="0"  bgcolor="#F7F7F7">
<table width="100%" height="3" border="0" cellspacing="0" cellpadding="0">
  <tr height="3">
    <td height="3"></td>
  </tr>
</table>
<table width="100%" height="25" border="0" cellpadding="0" cellspacing="0">
<form name="form1" method="post" action="">
<tr>
<td width="100" style="font-size:12px;" align="center" background="../images/bg1_on.gif" >
My Article</td>
<!--<td width="100"  align="center" background="../images/bg1_off.gif" style="display:none"><a href="#design" onClick="self.parent.location.href='website_main.php?stype=<?php echo $_REQUEST["stype"]; ?>&Flag=<?php echo $_REQUEST["Flag"]; ?>&filename=<?php echo $_REQUEST["filename"]; ?>&o_value=<?php echo $_REQUEST["o_value"]; ?>&o_preview=<?php echo $_REQUEST["o_preview"]; ?>';">
My Website</a></td>
<td width="100" style="font-size:12px;" align="center" background="../images/bg1_off.gif"><a href="#design" onClick="self.parent.location.href='gallery_main.php?stype=<?php echo $_REQUEST["stype"]; ?>&Flag=<?php echo $_REQUEST["Flag"]; ?>&filename=<?php echo $_REQUEST["filename"]; ?>&o_value=<?php echo $_REQUEST["o_value"]; ?>&o_preview=<?php echo $_REQUEST["o_preview"]; ?>';">
My Gallery </a></td>
<td width="100" style="font-size:12px;" align="center" background="../images/bg1_off.gif"><a href="#design" onClick="self.parent.location.href='download_main.php?stype=<?php echo $_REQUEST["stype"]; ?>&Flag=<?php echo $_REQUEST["Flag"]; ?>&filename=<?php echo $_REQUEST["filename"]; ?>&o_value=<?php echo $_REQUEST["o_value"]; ?>&o_preview=<?php echo $_REQUEST["o_preview"]; ?>';">
My Download </a></td>

<td width="100" align="center" background="../images/bg3_off.gif" style="display:none"><a href="#design" onClick="self.parent.location.href='share_main.php?stype=<?php echo $_REQUEST["stype"]; ?>&Flag=<?php echo $_REQUEST["Flag"]; ?>&filename=<?php echo $_REQUEST["filename"]; ?>&o_value=<?php echo $_REQUEST["o_value"]; ?>&o_preview=<?php echo $_REQUEST["o_preview"]; ?>';">File Manager </a> </td>
--><td background="../images/bg2_off.gif">&nbsp;</td>
          </tr><input type="hidden" name="num" value="0"></form>
        </table>




</body>
</html>
<?php $db->db_close(); ?>
