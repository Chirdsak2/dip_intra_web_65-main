<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
?>
<html>
<head>
<title>Article Management</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">

</head>
<body leftmargin="0" topmargin="0" >
<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
<form name="form1" method="post" action="article_share_function_auto.php"><tr>
<?php
$sql_site = $db->query("SELECT UID,EWT_User FROM user_info WHERE EWT_User = '".$_SESSION["EWT_SUSER"]."' ");
$M = $db->db_fetch_row($sql_site);
?>		<input type="hidden" name="UID" value="<?php echo $M[0]; ?>">
			<input type="hidden" name="USER" value="<?php echo $M[1]; ?>">
			<input type="hidden" name="c_id" value="<?php echo $c_id; ?>">
	<td width="5%"><a href="article_sitting_auto.php"><img src="../images/article_back.gif" width="20" height="20" border="0" align="absmiddle"> 
                              Back <hr size="1"></td>
      <td width="95%" height="40">  |&nbsp;&nbsp;&nbsp;<strong>Select target to share article auto >></strong> <input type="submit" name="Submit" value="Save">
        <hr size="1"></td>
      
</tr>
  <tr>
          
    <td colspan="2"><img src="../images/workplace.gif" width="20" height="20" border="0" align="absmiddle"> 
      <strong>My Website</strong>      </td>
  </tr>
  <?php
  $sql_group = $db->query("SELECT UID,WebsiteName,EWT_User FROM user_info WHERE EWT_Status = 'Y' and UID <>'".$M[0]."'");
  $i = 1;
  	while($R = $db->db_fetch_array($sql_group)){
	$db->query("USE ".$_SESSION["EWT_SDB"]);
	$sql_article_auto =$db->query("select * from article_auto where UID = '".$R[0]."' and c_id='".$c_id."'");
	$A = mysql_num_rows($sql_article_auto);
	if($A>0){
	$check = "checked";
	}else{
	$check = "";
	}
  ?>
        <tr> 
          
    <td colspan="2"><img src="../images/o.gif" width="20" height="20" border="0" align="absmiddle"><input <?php echo $check;?>  type="checkbox" name="auto[]" value="<?php echo $R[UID]?>">&nbsp;<b><?php echo $R[2]; ?> 
      (<?php echo $R[1]; ?>)</b> <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="60"></td>
          <td   id="tdview<?php echo $i; ?>"></td>
        </tr>
      </table> </td>
  </tr>
  <?php $i++; $db->query("USE ".$EWT_DB_USER); } ?>
</form></table>
</body>
</html>
<?php $db->db_close(); ?>
