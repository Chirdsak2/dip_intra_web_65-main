<?php
session_start();

include("administrator.php");
include("lib/include.php");
include("inc.php");

if($_POST["Flag"] == "Add"){

}else{
	$run = "select * from professor"; 
		$sql = $db->query($run);
		$rows = $db->db_num_rows($sql);
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
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
<script language="javascript1.2">
function sand_to_parent(n,s,g){
top.window.opener.document.form1.hdd_uid.value=g;
top.window.opener.document.form1.t_name.value=n +' '+s;
top.close();
}
</script>
</head>

<body>
<table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC"><form name="form1" method="post" target="_top" action="site_s1_member.php">
  <tr align="center" bgcolor="E0DFE3"> 
    <td width="50%" class="head_table">ชื่อ - สกุล 
      <input name="ug" type="hidden" id="ug" value="<?php echo $_POST["ug"]; ?>">
      <input name="Flag" type="hidden" id="Flag" value="Add"></td>
    <td class="head_table">keyword</td>
  </tr>
  <?php
  if($rows > 0){
  $i = 0;
  while($U = $db->db_fetch_array($sql)){
			$db->query("USE ".$EWT_DB_USER);
			$sql_user = "select * from gen_user where gen_user_id = '".$U[prof_name]."'";
			$query_user = $db->query($sql_user);
			$num_user = $db->db_num_rows($query_user);
			$rec_user = $db->db_fetch_array($query_user);
			$db->query("USE ".$EWT_DB_NAME);
				if($num_user > 0){
				$keyword = array();
				  $sql_keyword = "select * from professor_keyword where  prof_id = '".$U[prof_id]."'";
				  $query_keyword = $db->query($sql_keyword);
				  while($rec_key = $db->db_fetch_array($query_keyword)){
				  array_push($keyword,trim($rec_key[key_word]));
				  }
  ?>
  <tr bgcolor="#FFFFFF"> 
    <td><a href="##" onClick="sand_to_parent('<?php echo $rec_user["name_thai"]; ?>','<?php echo $rec_user["surname_thai"]; ?>','<?php echo $rec_user["gen_user_id"]; ?>');">เลือก</a><img src="../images/user_logo.gif" width="20" height="20" border="0" align="absmiddle"> 
       <?php echo $rec_user[name_thai].'  '.$rec_user[surname_thai];?> <input name="uid<?php echo $i; ?>" type="hidden" value="<?php echo $rec_user["gen_user_id"]; ?>"> 
      </td><td><?php echo implode(",", $keyword); ?></td>
  </tr>
  <?php $i++; }}}else{ ?>
  <tr align="center" bgcolor="#FFFFFF"> 
    <td height="40" colspan="2"><font color="#FF0000">ไม่มีรายชื่อสมาชิก</font></td>
  </tr>
  <?php } ?><input name="alli" type="hidden" value="<?php echo $i; ?>"></form>
</table>
</body>
</html>

<?php
}
$db->db_close();
?>
