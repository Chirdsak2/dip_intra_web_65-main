<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<script language="JavaScript">
function chk(){
	if(document.form1.design_name.value == ""){
		alert("Please insert template name!!");
		document.form1.design_name.focus();
		return false;
	}
}
</script>
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
      <?php
	$sql = $db->query("SELECT * FROM design_list  ");
	?><form name="form1" method="post" action="look_function.php" onSubmit="return chk();">
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<img src="../images/add.gif" width="16" height="16" border="0" align="absmiddle"> 
      <strong>Create new template </strong>
      
        <input type="text" name="design_name">
              <input type="submit" name="Submit" value="Create"><input name="Flag" type="hidden" id="Flag" value="Add">
      </form> 
      <table width="96%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#CCCCCC">
        <tr align="center" bgcolor="#F7F7F7"> 
          <td width="24%"><strong>Date Regis</strong></td>
          <td width="44%"><strong>Website name</strong></td>
          <td width="32%"><strong>Username</strong></td>
        </tr>
		<?php
		if($db->db_num_rows($sql) > 0){
		while($R = $db->db_fetch_array($sql)){
		?>
        <tr bgcolor="#FFFFFF"> 
          <td><?php $d = explode("-",$R["StartDate"]); echo $d[2]."/".$d[1]."/".$d[0]; ?></td>
          <td><?php echo $R["WebsiteName"]; ?></td>
          <td><?php echo $R["EWT_User"]; ?></td>
        </tr>
		<?php }}else{ ?>
        <tr align="center" bgcolor="#FFFFFF"> 
          <td height="35" colspan="3"><font color="#FF0000"><strong>No data found.</strong></font></td>
        </tr>
		<?php  } ?>
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
