<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$group = "SELECT * FROM temp_main_group ORDER BY Main_Group_Name";
$sql_group= $db->query($group);
	?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" border="0" cellpadding="2" cellspacing="1" bgcolor="FB8233">
  <tr>
    <td height="28" background="../images/bg.gif" bgcolor="#FFFFFF">&nbsp;<strong>. 
      : : Change Group : : .</strong></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="FB8233"><form name="form1" method="post" action="">
  <tr> 
    <td height="23" bgcolor="#FFFFFF"><img src="../images/arrow_r.gif" width="7" height="7" align="absmiddle"> 
      <strong>Filename : <?php echo $_GET["filename"]; ?></strong></td>
  </tr>
  <tr>
    <td height="23" bgcolor="#FFFFFF"><img src="../images/arrow_r.gif" width="7" height="7" align="absmiddle"> 
      <strong>New Group : </strong>
      
        <select name="select">
		<?php
		while($G = $db->db_fetch_array($sql_group)){
		?>
          <option value="<?php echo $G['Main_Group_ID'];?>"><?php echo $G['Main_Group_Name'];?></option>
		  <?php } ?>
        </select>
      </td>
  </tr>
  <tr>
    <td height="23" align="center" bgcolor="#FFFFFF"><input type="submit" name="Submit" value="Save">   
        <input type="button" name="Submit2" value="Close" onClick="self.close();"></td>
  </tr></form>
</table>
</body>
</html>
<?php $db->db_close(); ?>
