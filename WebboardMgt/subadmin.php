<?php
include("administrator.php");
include("lib/include.php");
include("inc.php");
if($_GET[flag] == 'edit'){
$lable = "แก้ไขผู้ดูแลหมวดกระทู้";
}else if($_GET[flag] == 'add'){
$lable = "เพิ่มผู้ดูแลหมวดกระทู้";
}else{
$lable = "บริหารผู้ดูแลหมวดกระทู้";
}
		if($flag == "edit"){
			$admin = $db->query("SELECT * FROM w_admin WHERE t_id = '$t_id'");
			$T = mysql_fetch_array($admin);
		}
?>
<html><title>Admin ย่อย</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<head>
</head>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction"><?php echo $lable;?> </span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode($lable.$T[t_name]);?>&module=webboard&url=<?php echo urlencode("subadmin.php?flag=".$_GET["flag"]."&t_id=".$_GET["t_id"]);?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php if($_GET[flag] != 'edit' && $_GET[flag] != 'add'){ ?><a href="subadmin.php?flag=add"><img src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle" border="0"> เพิ่มผู้ดูแลระบบ</a><?php } ?><?php if($_GET[flag] == 'edit' || $_GET[flag] == 'add'){ ?>  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="subadmin.php"><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0"> หน้าหลัก</a><?php }?>
      <hr>
    </td>
  </tr>
</table>
<?php   if($flag=="Fadd" AND $hdd_uid != ""){ 
	$sql_ch = $db->query("select * from w_admin where t_id = '$hdd_uid'");
	if($db->db_num_rows($sql_ch)>0){
	?>
	<script language="JavaScript">
	alert('ผู้ดูแลระบบท่านนี้มีแล้วในระบบ กรุณาตรวจสอบ!');
	window.location.href = "subadmin.php";
	</script>
	<?php
	exit;
	}
	$db->query("INSERT INTO w_admin (t_id,t_name,t_user,t_pass,t_type,t_login) VALUES ('$hdd_uid','$t_name','$t_user','$t_pass','N',NOW( ))");
	$id = $hdd_uid;
		for($i=0;$i<$alli;$i++){
			$cid = "cid".$i;
			$cid = $$cid;
			$chk = "chk".$i;
			$chk = $$chk;
			if($chk == "Y"){
				$db->query("INSERT INTO w_permission (t_id,c_id) VALUES ('$id','$cid')");
				$db->write_log("Access","webboard","กำหนด  ".$_POST["t_name"]."  เป็นผู้ดูแลหมวดหมู่กระทู้ ".$_POST["cname".$i]);
			}
		}
		?>
		<script language="JavaScript">
		self.location.href = "subadmin.php";
		</script>
		<?php
	}elseif($flag=="Fedit" AND $t_id != ""){ 
	$sql_ch = $db->query("select * from w_admin where t_id ='".$hdd_uid."' and t_id <> '$t_id'");
	if($db->db_num_rows($sql_ch)>0){
	?>
	<script language="JavaScript">
	alert('ผู้ดูแลระบบท่านนี้มีแล้วในระบบ กรุณาตรวจสอบ!');
	window.location.href = "subadmin.php";
	</script>
	<?php
	exit;
	}
	$db->query("UPDATE w_admin SET t_id = '$hdd_uid',t_name = '$t_name',t_user ='$t_user' ,t_pass ='$t_pass'  WHERE t_id = '$t_id'");
	$db->query("DELETE FROM w_permission WHERE t_id = '$t_id'");
		for($i=0;$i<$alli;$i++){
			$cid = "cid".$i;
			$cid = $$cid;
			$chk = "chk".$i;
			$chk = $$chk;
			if($chk == "Y"){
				$db->query("INSERT INTO w_permission (t_id,c_id) VALUES ('$hdd_uid','$cid')");
				$db->write_log("Access","webboard","แก้ไข  ".$_POST["t_name"]."  เป็นผู้ดูแลหมวดหมู่กระทู้ ".$_POST["cname".$i]);
			}
		}
		?>
		<script language="JavaScript">
		self.location.href = "subadmin.php";
		</script>
		<?php
	}elseif($flag=="del" AND $t_id != ""){ 
	$db->query("DELETE FROM w_admin WHERE t_id = '$t_id'");
	$db->query("DELETE FROM w_permission WHERE t_id = '$t_id'");
	$db->write_log("Access","webboard","ยกเลิกผู้ดูแลหมวดหมู่กระทู้   ".$_GET["t_name"] );
		?>
		<script language="JavaScript">
		self.location.href = "subadmin.php";
		</script>
		<?php
	}elseif($flag=="add" or $flag=="edit"){ 
		
?>
<table width="94%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#000000" class="ewttableuse">
        <form name="form1" method="post" action="subadmin.php">
		 <tr> 
            <td colspan="2" bgcolor="#F7F7F7" class="ewttablehead">เพิ่มผู้ดูแลระบบ </td>
          </tr>
          <tr> 
            <td bgcolor="#FFFFFF"><font size="2" face="Tahoma">ชื่อ</font></td>
            <td bgcolor="#FFFFFF"> <input name="t_name" type="text" id="t_name" value="<?php echo $T[t_name]; ?>">
            <a href="#" onClick="popo=window.open('site_s_member.php','popug','width=800,height=600,scrollbars=1,resizable=1');popo.focus();"><img src="../images/user_pos.gif" alt="เลือกจากบุคคลภายในองค์กร" width="20" height="20" border="0" align="absmiddle"></a>&nbsp;
			<a href="#" onClick="popo=window.open('site_s_professor_c.php','popug','width=800,height=600,scrollbars=1,resizable=1');popo.focus();">
			<img src="../images/bar_user.gif" alt="เลือกจากรายการผู้เชี่ยวชาญของระบบกระทู้" width="20" height="20" border="0" align="absmiddle">			</a>
			<input type="hidden" name="hdd_uid" id="hdd_uid" value="<?php echo $t_id; ?>"></td>
          </tr>
		  <tr> 
            <td valign="top" bgcolor="#FFFFFF"><font size="2" face="Tahoma">หมวดที่ดูแล</font></td>
            <td valign="top" bgcolor="#FFFFFF"><?php
			$c = $db->query("SELECT * FROM w_cate");
			$i=0;
			 
			 if( $db->check_permission("webboard","m",'0') ){  $pass='Y';  }
			while($C = mysql_fetch_array($c)){
					  if($db->check_permission("webboard","m",$C[c_id]) ||  $pass=='Y'  ){
								?>
								<div><input name="chk<?php echo $i; ?>" type="checkbox" id="chk<?php echo $i; ?>" value="Y" <?php 
								if($flag == "edit"){
									$sql = $db->query("SELECT p_id FROM w_permission WHERE t_id = '$t_id' AND c_id = '$C[c_id]' ");
									if(mysql_num_rows($sql)){
										echo "checked";
									}
								}
								 ?>>
									<input name="cid<?php echo $i; ?>" type="hidden" id="cid<?php echo $i; ?>" value="<?php echo $C[c_id] ?>">
									 <input name="cname<?php echo $i; ?>" type="hidden" id="cname<?php echo $i; ?>" value="<?php echo $C[c_name] ?>">
									<font size="2" face="Tahoma"><?php echo $C[c_name] ?></font></div>
								<?php
								$i++; 
					}//end if 
			}//end while
			?>              </td>
          </tr>
          <tr> 
            <td bgcolor="#FFFFFF">&nbsp;</td>
            <td bgcolor="#FFFFFF"><input type="submit" name="Submit" value="Submit">
              <input name="flag" type="hidden" id="flag" value="<?php if($flag == "add"){ echo "Fadd"; }else{ echo "Fedit"; } ?>">
			  <input name="t_id" type="hidden" id="t_id" value="<?php echo $t_id; ?>">
              <input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>"></td>
          </tr>
        </form>
</table>


<?php }else{ 
$sql_admin = $db->query("SELECT * FROM w_admin WHERE t_type = 'N'");
$i = 1;
?>
<table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
        <tr  class="ewttablehead"> 
          <td width="7%" align="center">&nbsp;</td>
          <td>ชื่อ</td>
        </tr>
        <?php while($R = mysql_fetch_array($sql_admin)){ 
		
		 $db->query("USE ".$EWT_DB_USER);
		 $sql_img = "select * from gen_user LEFT OUTER JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`) INNER JOIN emp_type ON emp_type.emp_type_id = gen_user.emp_type_id   where gen_user_id = '$R[t_id]'";
		 $query = $db->query($sql_img);
		 $rec_img = $db->db_fetch_array($query);
		 $db->query("USE ".$EWT_DB_NAME);
		 if($db->db_num_rows($query) >0){
		?>
        <tr bgcolor="#FFFFFF"> 
          <td align="left"><font size="2" face="Tahoma"><a href="subadmin.php?flag=edit&t_id=<?php echo $R[t_id]; ?>"><img src="../theme/main_theme/g_edit.gif" border="0" alt="แก้ไข"></a> <a href="#del" onClick="if(confirm('คุณแน่ใจที่จะลบผู้ดูแลคนนี้?')){ self.location.href='subadmin.php?flag=del&t_id=<?php echo $R[t_id]; ?>&t_name=<?php echo $rec_img[name_thai].'  '.$rec_img[surname_thai]; ?>'; }"><img src="../theme/main_theme/g_del.gif" border="0" alt="ลบ"></a></font></td>
          <td><font size="2" face="Tahoma"><?php echo $rec_img[name_thai].'  '.$rec_img[surname_thai]; ?>
		   <?php if($rec_img[name_org] != ''){ ?>
		    (<?php echo $rec_img[name_org];?>)
			<?php } ?>
			<?php if($rec_img["emp_type_name"] != ''){ ?>
			(กลุ่ม : <?php echo $rec_img["emp_type_name"];?>)
			<?php } ?>
			</font></td>
        </tr>
       
        <?php 
		}
		$i++; }
		if(mysql_num_rows($sql_admin) == 0){ ?>
		 <tr bgcolor="#FFFFFF">
          <td colspan="2" align="center" bgcolor="#FFFFFF"><font size="2" color="#FF0000">----ไม่พบรายการ----</font></td>
        </tr>
		<?php } ?>
</table>
    <?php } ?>


</body>
</html>
<?php $db->db_close(); ?>