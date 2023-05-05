<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=windows-874">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">Function Name</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><img src="../theme/main_theme/a.gif" width="16" height="16" align="absmiddle"> 
      Add new function &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../theme/main_theme/b.gif" width="16" height="16" align="absmiddle"> 
      Manage function<hr>
    </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td align="left">&nbsp;<img src="../theme/main_theme/c.gif" width="16" height="16" align="absmiddle"> 
      Search 
      <input type="text" name="textfield">
      <input type="submit" name="Submit" value="Search"></td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
    <td width="5%" height="30" align="center">&nbsp;</td>
    <td >Function Name</td>
    <td width="5%" align="center">Delete</td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td align="center"><nobr><img src="../theme/main_theme/g_edit.gif" width="16" height="16"> 
      <img src="../theme/main_theme/g_edit.gif" width="16" height="16"> <img src="../theme/main_theme/g_edit.gif" width="16" height="16"> 
      <img src="../theme/main_theme/g_edit.gif" width="16" height="16"> <img src="../theme/main_theme/g_edit.gif" width="16" height="16"></nobr></td>
    <td>detail ................................................</td>
    <td align="center"><input type="checkbox" name="checkbox10" value="checkbox"></td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td align="center"><img src="../theme/main_theme/g_edit.gif" width="16" height="16"> 
      <img src="../theme/main_theme/g_edit.gif" width="16" height="16"> <img src="../theme/main_theme/g_edit.gif" width="16" height="16"> 
      <img src="../theme/main_theme/g_edit.gif" width="16" height="16"> <img src="../theme/main_theme/g_edit.gif" width="16" height="16"></td>
    <td>detail ................................................</td>
    <td align="center"><input type="checkbox" name="checkbox9" value="checkbox"></td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td align="center"><img src="../theme/main_theme/g_edit.gif" width="16" height="16"> 
      <img src="../theme/main_theme/g_edit.gif" width="16" height="16"> <img src="../theme/main_theme/g_edit.gif" width="16" height="16"> 
      <img src="../theme/main_theme/g_edit.gif" width="16" height="16"> <img src="../theme/main_theme/g_edit.gif" width="16" height="16"></td>
    <td>detail ................................................</td>
    <td align="center"><input type="checkbox" name="checkbox8" value="checkbox"></td>
  </tr>
  <tr bgcolor="#FFFFFF"> 
    <td align="center"><img src="../theme/main_theme/g_edit.gif" width="16" height="16"> 
      <img src="../theme/main_theme/g_edit.gif" width="16" height="16"> <img src="../theme/main_theme/g_edit.gif" width="16" height="16"> 
      <img src="../theme/main_theme/g_edit.gif" width="16" height="16"> <img src="../theme/main_theme/g_edit.gif" width="16" height="16"></td>
    <td>detail ................................................</td>
    <td align="center"><input type="checkbox" name="checkbox7" value="checkbox"></td>
  </tr>
  <tr align="right" bgcolor="#FFFFFF"> 
    <td colspan="2">&nbsp;</td>
    <td align="center"><input type="button" name="Button" value="Delete"></td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td>Page : &lt;&lt; Pre&nbsp;&nbsp;1&nbsp;&nbsp;<strong>[2]</strong>&nbsp;&nbsp;3&nbsp;&nbsp;4&nbsp;&nbsp;5&nbsp;&nbsp;6&nbsp;&nbsp;Next &gt;&gt;</td>
  </tr>
</table>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">Function Name</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><img src="../theme/main_theme/a.gif" width="16" height="16" align="absmiddle"> 
      Add new function &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../theme/main_theme/b.gif" width="16" height="16" align="absmiddle"> 
      Manage function
      <hr> </td>
  </tr>
</table>
<table width="70%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE"  class="ewttableuse">
  <tr bgcolor="#E7E7E7" > 
    <td height="30" colspan="2" class="ewttablehead"> Add Function</td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td width="38%">Detail1</td>
    <td width="62%"><input name="textfield2" type="text" size="40"></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td>Detail2</td>
    <td><select name="select">
        <option>Choose 1</option>
        <option>Choose 2</option>
        <option>Choose 3</option>
        <option>Choose 4</option>
      </select></td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td>Detail3</td>
    <td><input name="radiobutton" type="radio" value="radiobutton" checked>
      A 
      <input type="radio" name="radiobutton" value="radiobutton">
      B 
      <input type="radio" name="radiobutton" value="radiobutton">
      C </td>
  </tr>
  <tr valign="top" bgcolor="#FFFFFF"> 
    <td>Detail4</td>
    <td><textarea name="textfield24" cols="40" rows="5"></textarea></td>
  </tr>
  <tr bgcolor="#FFFFFF">
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit2" value="Submit">
      <input type="reset" name="Submit3" value="Reset"></td>
  </tr>
</table>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
<br>
</body>
</html>
<?php
$db->db_close(); ?>