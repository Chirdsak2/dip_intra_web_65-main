<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
		if(!(session_is_registered("EWT_OPEN_ARTICLE"))){
			session_register("EWT_OPEN_ARTICLE");
		}
		$_SESSION["EWT_OPEN_ARTICLE"] = "";
$db->write_log("view","article","เข้าสู่ Module Article");
$sql_article = $db->query("SELECT * FROM article_group ORDER BY c_id ASC");
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.head_table { 
	border-bottom:"buttonshadow solid 1px";
	border-left:"buttonhighlight solid 1px";
	border-right:"buttonshadow solid 1px";
	border-top:"buttonhighlight solid 1px";
	}
-->
</style>

</head>
<body leftmargin="0" topmargin="0">

<?php 
$disabled1='style="display:none"';
$disabled2='style="display:none"';
if($db->check_permission('art','w','')){ $disabled1='';}
if($db->check_permission('art','a','')){ $disabled2=''; }
$db->query("USE ".$_SESSION["EWT_SDB"]);
?>

<span id="formtext"></span>
<br><br>
<table align="center"  width="98%" border="0" cellpadding="10" class="table table-bordered">
  <form name="form1" method="post" action="article_function.php">
  <input type="hidden" name="Flag" value="DelGroup">
    <tr bgcolor="#E0DFE3"  class="ewttablehead">  
      <td width="70%" height="18"  >Group Name</td>
	  <td width="10%"  <?php echo $disabled2;?>>setting share auto</td>
    </tr>
	<?php
	$i = 0;
	 while($G = $db->db_fetch_array($sql_article)){ 
	 if($db->check_permission("Ag","",$G[c_id])){
	$S_count = $db->query("SELECT COUNT(n_id) FROM article_list WHERE c_id = '$G[c_id]' "); 
	$C = $db->db_fetch_row($S_count);
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" valign="top" bgcolor="F7F7F7"> <img src="../images/article_folder.gif" width="16" height="16" border="0" align="top"> 
        <?php echo $G["c_name"]; ?>    </td>
	  <td align="center" <?php echo $disabled2;?>><a href="article_unit_share_auto.php?c_id=<?php echo $G[c_id]?>">config ค่า</a></td>
    </tr>
	<?php $i++; }} ?>
    <tr bgcolor="#FFFFFF"> 
      <td valign="top" bgcolor="F7F7F7">&nbsp;<a id="#bottom"></a></td>
      <td <?php echo $disabled2;?>>&nbsp;</td>
    </tr>
	<input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>">
  </form>
</table>
</body>
</html>
<?php $db->db_close(); ?>
