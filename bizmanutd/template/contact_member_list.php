<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
 
$db->query("USE ".$EWT_DB_USER);
$user_id =$_SESSION["EWT_MID"];
$run = "SELECT * FROM gen_user INNER JOIN org_name ON org_name.org_id = gen_user.org_id "; 
		if($_POST["fname"] != ""){
			$wh  =  "AND gen_user.name_thai LIKE '".$_POST["fname"]."%' OR gen_user.surname_thai LIKE '".$_POST["fname"]."%' ";
		}
	$run .= " WHERE gen_user.emp_type_id = '1' $wh ORDER BY gen_user.gen_user_id";
		$sql = $db->query($run);
		$rows = $db->db_num_rows($sql);
?>
<html>
<head>
<title>My Website</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/mysite.css" rel="stylesheet" type="text/css">
<script language="javascript1.2">
function chang_detail(t){
	if(t=='1'){
	document.getElementById('oth').style.display = 'none';
	window.open('contact_main.php','sel', 'height=375,width=445, status=0, menubar=0,resizable=no, location=0, scrollbars=no, left=400, top=300');
	}else if(t=='2'){
	document.getElementById('oth').style.display = '';
	}
}
function link_sele(t){
//self.parent.location.href="contact_function.php?flag=add_member_unit&groupid="+self.parent.document.getElementById('group_name').value+"&gid="+t;
self.parent.location.href="contact_member_view_profile.php?&gid="+t;
}
</script>
<style type="text/css">
<!--
.style1 {color: #FF0000}
.head_table {	border-bottom:"buttonshadow solid 1px";
	border-left:"buttonhighlight solid 1px";
	border-right:"buttonshadow solid 1px";
	border-top:"buttonhighlight solid 1px";
}
-->
</style>
</head>

<body leftmargin="0" topmargin="0">
<table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="#CCCCCC">
  <form name="form1" method="post" target="_top" action="ewt_s1_member.php">
    <tr align="center" bgcolor="E0DFE3">
      <td width="50%" class="head_table">ชื่อ - สกุล
        <input name="ug" type="hidden" id="ug" value="<?php echo $_POST["ug"]; ?>">
          <input name="Flag" type="hidden" id="Flag" value="Add"></td>
      <td class="head_table">หน่วยงาน</td>
    </tr>
    <?php
  if($rows > 0){
  $i = 0;
  while($U = $db->db_fetch_array($sql)){
  $sqlchk = $db->query("SELECT COUNT(ugm_id) FROM web_group_member WHERE  ugm_type = 'U' AND ugm_tid = '".$U["gen_user_id"]."' ");
  $C = $db->db_fetch_row($sqlchk);
  ?>
    <tr bgcolor="#FFFFFF">
      <td><input type="button" name="Button" value="เลือก" onClick="link_sele(<?php echo $U["gen_user_id"]; ?>);">
          &nbsp;&nbsp; <?php echo $U["name_thai"]; ?> <?php echo $U["surname_thai"]; ?> </td>
      <td><?php echo $U["name_org"]; ?></td>
    </tr>
    <?php $i++; }}else{ ?>
    <tr align="center" bgcolor="#FFFFFF">
      <td height="40" colspan="2"><font color="#FF0000">ไม่มีรายชื่อสมาชิก</font></td>
    </tr>
    <?php } ?>
    <input name="alli" type="hidden" value="<?php echo $i; ?>">
  </form>
</table>
</body>
</html>
<?php  $db->db_close(); ?>
