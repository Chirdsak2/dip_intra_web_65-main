<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);
$txt = "";
if($_POST["Flag"]=="SQL" AND $_POST["textarea"] != ""){
$textarea = stripslashes($textarea);
$sql = $db->query("SELECT EWT_User,db_db FROM user_info WHERE EWT_Status = 'Y'");
$s = explode(";",$_POST["textarea"]);
$num = count($s);
while($R=$db->db_fetch_row($sql)){
	for($i=0;$i<$num;$i++){
		if($s[$i] != ""){
	if(@mysql_db_query($R[1],stripslashes($s[$i]))){
		$txt .= "query: $R[0] on $R[1] : Success.<br>";
	}else{
		$txt .= "<font color=red>cannot query $R[0] on $R[1] because : ".mysql_error()."</font><br>";
	}
	}
	}
}

}

?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>

<body>
<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
  <tr valign="top"> 
    <td height="1" colspan="3"> 
      <?php include("com_top.php"); ?>
    </td>
  </tr>
  <tr valign="top"> 
    <td width="1"><?php include("com_left.php"); ?></td>
    <td>
	<table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
	<tr>
    <td height="10" >
	<table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#FFFFFF">
  <form action="sql.php" method="post"  name="form1">
          <tr> 
            <td colspan="2">&nbsp;</td>
          </tr>

          <tr > 
            <td width="19%"><div align="right"><font  size="1" face="MS Sans Serif, Tahoma, sans-serif"><strong>Update 
                SQL </strong></font></div></td>
            <td width="81%"><textarea name="textarea" cols="100" rows="10"><?php echo $_POST["textarea"]; ?></textarea> </td>
          </tr>

          <tr align="center"> 
            <td height="10" colspan="2"><input type="submit" name="Submit" value="Submit">
              <input name="Flag" type="hidden" id="Flag" value="SQL">
              <input type="reset" name="Submit2" value="Reset"></td>
          </tr>
		  </form>
</table>
	</td>
  </tr>
  <tr>
    <td valign="top" ><font size="2" face="Tahoma"><strong><?php echo $txt; ?></strong></font></td>
  </tr>
</table></td>
    <td width="1"><?php include("com_right.php"); ?></td>
  </tr>
  <tr valign="top"> 
    <td height="1" colspan="3"> 
      <?php include("com_bottom.php"); ?>
    </td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close();
?>
