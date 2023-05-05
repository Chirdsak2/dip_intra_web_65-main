<?php
include("administrator.php");
include("inc.php");
include("lib/include.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<title>ส่งกระทู้ไปหน่วยงานอื่นๆ</title></head>
<body leftmargin="0" topmargin="0">
  <?php
$Execsql1 = $db->query("SELECT * FROM w_question WHERE t_id = '".$_GET["wtid"]."'");
$R= mysql_fetch_array($Execsql1);
?>
<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0">
  <form name="form1" method="post" action="sendto1.php"><tr>
    <td colspan="2"><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction">ส่งกระทู้ไปหน่วยงานอื่นๆ</span> <hr size="1"></td>
  </tr>
  <tr>
    <td width="20%">หัวข้อ : </td>
    <td width="80%"><?php echo $R["t_name"]; ?>&nbsp;</td>
  </tr>
  <tr>
    <td>ผู้รับ : </td>
    <td>
      <input name="typer" type="radio" value="P" checked>
    
    ผู้เชี่ยวชาญ 
    <select name="professor">
	<?php
		$sql = "select * from professor";
		$query = $db->query($sql);
		$num = $db->db_num_rows($query);
		while($rec = $db->db_fetch_array($query)){
		$db->query("USE ".$EWT_DB_USER);
			$sql_user = "select gen_user_id,name_thai,surname_thai from gen_user where gen_user_id = '".$rec[prof_name]."'";
			$query_user = $db->query($sql_user);
			$rec_user = $db->db_fetch_array($query_user);
			$db->query("USE ".$EWT_DB_NAME);
		?>
		<option value="<?php echo $rec[prof_name]; ?>"><?php echo $rec_user[name_thai].'  '.$rec_user[surname_thai];?></option>
		<?php
		}
	?>
    </select>    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input name="typer" type="radio" value="N" onClick="document.form1.name.focus();">
      บุคคล/หน่วยงาน 
      <input name="name" type="text" id="name" size="40">
      <a href="#" onClick="popo=window.open('site_s_professor.php','popug','width=800,height=600,scrollbars=1,resizable=1');popo.focus();"><img src="../images/user_pos.gif" alt="เพิ่มผุ้เชี่ยวชาญจากสมาชิกในระบบ" width="20" height="20" border="0"> 
        <input type="hidden" name="hdd_uid" id="hdd_uid" value="<?php echo $rec[prof_name];?>">
        </a></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;อีเมล์ 
      <input name="s_email" type="text" id="s_email" size="40"></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><input type="submit" name="Submit" value="ส่งข้อมูล">
      <input name="Flag" type="hidden" id="Flag" value="Send">
      <input name="wtid" type="hidden" id="wtid" value="<?php echo $_GET["wtid"]; ?>"></td>
  </tr>
  </form>
</table>
</body>
</html>
<?php @$db->db_close(); ?>