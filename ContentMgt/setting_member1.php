<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
$sql = $db->query("SELECT * FROM user_group WHERE ug_status = 'Y' ORDER BY ug_id");
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
	<SCRIPT language=JavaScript>
				function hlah(c,e){
				var d = document.form1.num.value;
					document.getElementById('tr'+d).removeAttribute("style");
					document.getElementById('arrow'+d).src = "../images/o.gif";
					document.getElementById('tr'+c).style.backgroundColor = "#D5D6DB";
					document.form1.num.value = c;
					document.getElementById('arrow'+c).src = "../images/arrow_r.gif";
					top.m_data12.location.href = 'setting_member2.php?ug=' + e + '&s_type=<?php echo $_GET["s_type"]; ?>&s_id=<?php echo $_GET["s_id"]; ?>&s_name=<?php echo $_GET["s_name"]; ?>';
			}
	</SCRIPT>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC">
  <tr align="center" bgcolor="E0DFE3"> 
    <td width="50%" class="head_table">Group name</td>
  </tr>
  <?php
  if($db->db_num_rows($sql)){
  $i=0;
  while($U = $db->db_fetch_array($sql)){
  ?>
  <tr id="tr<?php echo $i; ?>" bgcolor="#FFFFFF" onClick="hlah('<?php echo $i; ?>','<?php echo $U["ug_id"]; ?>')"> 
    <td  style="cursor:hand"><img src="../images/o.gif" name="arrow<?php echo $i; ?>" width="7" height="7" align="absmiddle" id="arrow<?php echo $i; ?>">&nbsp;<?php echo $U[1]; ?></td>
  </tr>
  <?php $i++; }}else{ ?>
  <tr align="center" bgcolor="#FFFFFF"> 
    <td height="40"><font color="#FF0000">ไม่มีรายชื่อสมาชิก</font></td>
  </tr>
  <?php } ?>
</table>
<form name="form1">
  <input name="num" type="hidden" id="num" value="0">
</form>
</body>
</html>
<?php $db->db_close(); ?>
