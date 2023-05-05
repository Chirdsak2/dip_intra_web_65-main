<?php
include("authority.php");
?>
<?php 

?>
<html><title>Admin ย่อย</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<head>
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr> 
    <td><?php
include('menu.php');
?><br></td>
  </tr>
  <tr>
    <td align="center" valign="top"><font size="4" face="Tahoma"><strong>บริหาร 
      Admin ย่อย</strong></font>
	<?php   if($flag=="Fadd" AND $t_user != ""){ 
	$db->query("INSERT INTO n_admin (t_name,t_user,t_pass,t_type,t_login) VALUES ('$t_name','$t_user','$t_pass','N',NOW( ))");
	$id = mysql_insert_id();
		for($i=0;$i<$alli;$i++){
			$cid = "cid".$i;
			$cid = $$cid;
			$chk = "chk".$i;
			$chk = $$chk;
			if($chk == "Y"){
				$db->query("INSERT INTO n_permission (t_id,c_id) VALUES ('$id','$cid')");
			}
		}
		?>
		<script language="JavaScript">
		self.location.href = "subadmin.php";
		</script>
		<?php
	}elseif($flag=="Fedit" AND $t_id != ""){ 
	$db->query("UPDATE n_admin SET t_name = '$t_name',t_user ='$t_user' ,t_pass ='$t_pass'  WHERE t_id = '$t_id'");
	$db->query("DELETE FROM n_permission WHERE t_id = '$t_id'");
		for($i=0;$i<$alli;$i++){
			$cid = "cid".$i;
			$cid = $$cid;
			$chk = "chk".$i;
			$chk = $$chk;
			if($chk == "Y"){
				$db->query("INSERT INTO n_permission (t_id,c_id) VALUES ('$t_id','$cid')");
			}
		}
		?>
		<script language="JavaScript">
		self.location.href = "subadmin.php";
		</script>
		<?php
	}elseif($flag=="del" AND $t_id != ""){ 
	$db->query("DELETE FROM n_admin WHERE t_id = '$t_id'");
	$db->query("DELETE FROM n_permission WHERE t_id = '$t_id'");
	
		?>
		<script language="JavaScript">
		self.location.href = "subadmin.php";
		</script>
		<?php
	}elseif($flag=="add" or $flag=="edit"){ 
		if($flag == "edit"){
			$admin = $db->query("SELECT * FROM n_admin WHERE t_id = '$t_id'");
			$T = mysql_fetch_array($admin);
		}
?><br>
<br>
<table width="600" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#000000">
        <form name="form1" method="post" action="subadmin.php">
          <tr> 
            <td bgcolor="#F7F7F7"><font size="2" face="Tahoma">ชื่อ</font></td>
            <td bgcolor="#FFFFFF"> <input name="t_name" type="text" id="t_name" value="<?php echo $T[t_name]; ?>"> </td>
          </tr>
          <tr> 
            <td bgcolor="#F7F7F7"><font size="2" face="Tahoma">Username</font></td>
            <td bgcolor="#FFFFFF"><input name="t_user" type="text" id="t_user" value="<?php echo $T[t_user]; ?>"></td>
          </tr>
          <tr> 
            <td bgcolor="#F7F7F7"><font size="2" face="Tahoma">Password</font></td>
            <td bgcolor="#FFFFFF"><input name="t_pass" type="password" id="t_pass" value="<?php echo $T[t_pass]; ?>"></td>
          </tr>
          <tr> 
            <td bgcolor="#F7F7F7"><font size="2" face="Tahoma">Confirm password</font></td>
            <td bgcolor="#FFFFFF"><input name="t_cpass" type="password" id="t_cpass" value="<?php echo $T[t_pass]; ?>"></td>
          </tr>
		  <tr> 
            <td valign="top" bgcolor="#F7F7F7"><font size="2" face="Tahoma">กลุ่มข่าวที่มีสิทธิ์</font></td>
            <td valign="top" bgcolor="#FFFFFF"><?php
			$c = $db->query("SELECT * FROM n_group");
			$i=0;
			while($C = mysql_fetch_array($c)){
			?>
			<div><input name="chk<?php echo $i; ?>" type="checkbox" id="chk<?php echo $i; ?>" value="Y" <?php 
			if($flag == "edit"){
			$sql = $db->query("SELECT p_id FROM n_permission WHERE t_id = '$t_id' AND c_id = '$C[g_id]' ");
			if(mysql_num_rows($sql)){
			echo "checked";
			}
			}
			 ?>>
                <input name="cid<?php echo $i; ?>" type="hidden" id="cid<?php echo $i; ?>" value="<?php echo $C[g_id] ?>">
                <font size="2" face="Tahoma"><?php echo $C[g_name] ?></font></div>
			<?php
			$i++; }
			?>
              </td>
          </tr>
          <tr> 
            <td bgcolor="#F7F7F7">&nbsp;</td>
            <td bgcolor="#FFFFFF"><input type="submit" name="Submit" value="Submit">
              <input name="flag" type="hidden" id="flag" value="<?php if($flag == "add"){ echo "Fadd"; }else{ echo "Fedit"; } ?>">
			  <input name="t_id" type="hidden" id="t_id" value="<?php echo $t_id; ?>">
              <input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>"></td>
          </tr>
        </form>
      </table>


<?php }else{ 
$sql_admin = $db->query("SELECT * FROM n_admin WHERE t_type = 'N'");
$i = 1;
?>
	  <div align="right"><font size="2" face="Tahoma"><a href="subadmin.php?flag=add">เพิ่มข้อมูล</a></font>&nbsp;&nbsp;</div>
      <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#000000">
        <tr align="center" bgcolor="#CCCCCC"> 
          <td width="7%"><font size="2" face="Tahoma"><strong>ลำดับ</strong></font></td>
          <td width="62%"><font size="2" face="Tahoma"><strong>ชื่อ</strong></font></td>
          <td width="16%"><font size="2" face="Tahoma"><strong>แก้ไข</strong></font></td>
          <td width="15%"><font size="2" face="Tahoma"><strong>ลบ</strong></font></td>
        </tr>
        <?php while($R = mysql_fetch_array($sql_admin)){ ?>
        <tr bgcolor="#FFFFFF"> 
          <td align="center"><font size="2" face="Tahoma"><?php echo $i; ?></font></td>
          <td><font size="2" face="Tahoma"><?php echo $R[t_name]; ?></font></td>
          <td align="center"><font size="2" face="Tahoma"><a href="subadmin.php?flag=edit&t_id=<?php echo $R[t_id]; ?>">แก้ไข</a></font></td>
          <td align="center"><font size="2" face="Tahoma"><a href="#del" onClick="if(confirm('Are you sure to delete this user?')){ self.location.href='subadmin.php?flag=del&t_id=<?php echo $R[t_id]; ?>'; }">ลบ</a></font></td>
        </tr>
        <?php $i++; } ?>
      </table><?php } ?></td>
  </tr>
</table>

</body>
</html>
