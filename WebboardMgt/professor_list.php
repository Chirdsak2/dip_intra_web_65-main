<?php
include("administrator.php");
include("lib/include.php");
include("inc.php");
$db->write_log("view","webboard","เข้าสู่ Module Webboard รายการผู้เชี่ยวชาญ ");
$Execsql = $db->query("SELECT * FROM w_cate   ORDER BY c_id ASC");
$row = mysql_num_rows($Execsql); ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">

</head>

<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">ผู้เชี่ยวชาญ</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("ผู้เชี่ยวชาญ");?>&module=webboard&url=<?php echo urlencode("professor_list.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="addprofessor.php?id=<?php echo $rec[prof_id];?>"><img src="../theme/main_theme/g_add.gif" alt="เพิ่ม" width="16" height="16" border="0" align="absmiddle"> 
     เพิ่มผู้เชี่ยวชาญ</a>&nbsp;
     <hr>
    </td>
  </tr>
</table>

  <table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#8A8B8F" class="ewttableuse">
    <tr class="ewttablehead" bgcolor="#E7E7E7">
      <td width="9%" height="25" align="center" bgcolor="#E7E7E7">&nbsp;</td>
      <td width="42%" bgcolor="#E7E7E7">ชื่อ-นามสกุลผู้เชี่ยวชาญ</td>
      <td bgcolor="#E7E7E7">การติดต่อ</td>
      <td bgcolor="#E7E7E7">เรื่องที่ดูแล</td>
    </tr>
    <?php
		$i=1;
		$sql = "select * from professor";
		$query = $db->query($sql);
		$num = $db->db_num_rows($query);
		while($rec = $db->db_fetch_array($query)){
			$db->query("USE ".$EWT_DB_USER);
			$sql_user = "select * from gen_user INNER JOIN emp_type ON emp_type.emp_type_id = gen_user.emp_type_id where gen_user_id = '".$rec[prof_name]."'";
			$query_user = $db->query($sql_user);
			$num_user = $db->db_num_rows($query_user);
			$rec_user = $db->db_fetch_array($query_user);
			$db->query("USE ".$EWT_DB_NAME);
			if($num > 0){
		?>
    <tr>
      <td height="30" align="left" valign="top" bgcolor="#FFFFFF"><nobody><a href="addprofessor.php?id=<?php echo $rec[prof_id];?>"><img src="../theme/main_theme/g_edit.gif" alt="แก้ไข" width="16" height="16" border="0"></a> <a href="professor_function.php?flag=del&id=<?php echo $rec[prof_id];?>&name=<?php echo $rec_user[name_thai].'  '.$rec_user[surname_thai];?>"><img src="../theme/main_theme/g_del.gif" alt="ลบ" width="16" height="16" border="0"></a></nobody></td>
      <td valign="top" bgcolor="#FFFFFF"><?php if($num_user > 0){echo $rec_user[name_thai].'  '.$rec_user[surname_thai];?><?php if($rec_user["emp_type_name"] != ''){ ?>
			(กลุ่ม : <?php echo $rec_user["emp_type_name"];?>)
			<?php }}else{ echo $rec[prof_name];} ?></td>
      <td valign="top" bgcolor="#FFFFFF">โทรศัพท์ :<?php echo $rec_user[tel_in];?><br>
        E-mail :<?php echo $rec_user[email_person];?></td>
      <td valign="top" bgcolor="#FFFFFF">
	  <?php 
	  $keyword = array();
	  $sql_keyword = "select * from professor_keyword where  prof_id = '".$rec[prof_id]."'";
	  $query_keyword = $db->query($sql_keyword);
	  while($rec_key = $db->db_fetch_array($query_keyword)){
	  array_push($keyword,trim($rec_key[key_word]));
	  }
	  echo implode(",", $keyword);
	  ?>	  </td>
    </tr>
    <?php } 
	}
		if($num == 0){
		?>
    <tr>
      <td height="30" colspan="4" align="center" bgcolor="#FFFFFF"><font color="#FF0000">--ไม่พบข้อมูล---</font></td>
    </tr>
    <?php
		}
		?>
  </table>
 
</body>
</html>
<script language="JavaScript">
function CHK(){
if(document.form1.name.value == ""){
alert("กรุณาใส่ชื่อผู้เชี่ยวชาญ");
document.form1.name.focus();
return false;
}
if(document.form1.tele.value == ""){
alert("กรุณาใส่เบอร์โทรศัพท์");
document.form1.tele.focus();
return false;
}
if(document.form1.mobie.value == ""){
alert("กรุณาใส่เบอร์โทรศัพท์มือถือ");
document.form1.mobie.focus();
return false;
}
if(document.form1.email.value == ""){
alert("กรุณาใส่ e-mail");
document.form1.email.focus();
return false;
}
if(document.form1.keyword.value == ""){
alert("กรุณาใส่ Keyword");
document.form1.keyword.focus();
return false;
}
}
</script>
<?php @$db->db_close(); ?>