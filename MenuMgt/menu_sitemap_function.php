<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
if($_GET[Flag] == ''){
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<body leftmargin="0" topmargin="0">
      <form name="form1" method="post" action="menu_sitemap_function.php">
		<input type="hidden" name="Flag" value="Savelist">
        <input type="hidden" name="mid">
		<input type="hidden" name="active">
        <input type="hidden" name="sid" value="<?php echo $_REQUEST["sid"]; ?>">
      </form> 
</body>
</html>
<?php
}
if($_POST[Flag]=="Savelist"){
$sid = $_POST["sid"];
$mid = $_POST["mid"];
	if($_POST["active"]=='Y'){
		$db->query("UPDATE menu_sitemap_list SET sm_active = 'Y'  WHERE s_id = '".$sid."' and m_id ='".$mid."' ");
		$db->query("UPDATE menu_sitemap_list SET sm_active = 'Y'  WHERE s_id = '".$sid."' and mp_id LIKE '".$mid."_%'");
	}else if($_POST["active"]=='N'){
		$db->query("UPDATE menu_sitemap_list SET sm_active = 'N'  WHERE s_id = '".$sid."' and m_id ='".$mid."' ");
		$db->query("UPDATE menu_sitemap_list SET sm_active = 'N'  WHERE s_id = '".$sid."' and mp_id LIKE '".$mid."_%'");
	}
}
if($_POST[Flag]=="Save"){
$sid = $_POST["sid"];
$all = count($_POST["chk"]);//id menu
$db->query("UPDATE menu_sitemap_list SET sm_active = 'N' WHERE s_id = '".$sid."'  ");
	for($i=0;$i<$all;$i++){
		$m_id = $_POST["chk"][$i];

		//chk data
		$sql_chk = "select sm_id from menu_sitemap_list where m_id ='".$m_id."' and  s_id = '".$sid."' ";
		$query_chk = $db->query($sql_chk);
		if($db->db_num_rows($query_chk) == '0'){
		$db->query("insert  into menu_sitemap_list(s_id,menu_type,m_id,sm_active) values ('".$sid."','0','".$m_id."','Y')");
		}else{
		$db->query("UPDATE menu_sitemap_list SET sm_active = 'Y' WHERE s_id = '".$sid."' and  m_id ='".$m_id."' ");
		$db->query("UPDATE menu_sitemap_list SET sm_active = 'Y' WHERE s_id = '".$sid."' and  mp_id Like '".$m_id."_%' ");
		}
	}
	?>
	<script language="javascript">
	self.location.href = "menu_sitemap_all.php?sid=<?php echo $sid;?>";	
	</script>
	<?php
}
if($_POST["Flag"] == "UpdateSitemap"){
	for($i=0;$i<$_POST["alli"];$i++){
		$chk = $_POST["menuMain".$i];
		$nid = $_POST["menu2Main".$i];
		if($chk != ""){
			$db->query("Update menu_sitemap_list SET 
			            m_realname='".$_POST["inputMM".$i]."' ,
						m_show='Y'
						WHERE m_id = '$chk' and s_id='".$_POST["sid"]."'");
		}else{
			$db->query("Update menu_sitemap_list SET 
			            m_realname='".$_POST["inputMM".$i]."' ,
						m_show=NULL
						WHERE m_id = '$nid' and s_id='".$_POST["sid"]."'");
		}
	}
	
	for($i=0;$i<$_POST["allj"];$i++){
		$chk = $_POST["menuSub".$i];
		$nid = $_POST["menu2Sub".$i];

		if($chk != ""){
		//chk data
		$sql_data = "select sm_id from menu_sitemap_list where s_id='".$_POST["sid"]."' and  mp_id='$chk'";
		$query_data = $db->query($sql_data);
			if($db->db_num_rows($query_data)=='0'){
				$db->query("Insert into menu_sitemap_list (s_id,menu_type,mp_id,m_realname,m_show,sm_active) Values ('".$_POST["sid"]."','1','$chk','".$_POST["inputMS".$i]."' ,'Y','Y')");
			}else{
				$db->query("Update menu_sitemap_list SET 
							m_realname='".$_POST["inputMS".$i]."' ,
							m_show='Y',
							sm_active = 'Y'
							WHERE mp_id = '$chk'  and s_id='".$_POST["sid"]."' ");
			}
		}else{
		$sql_data = "select sm_id from menu_sitemap_list where s_id='".$_POST["sid"]."' and  mp_id='$nid'";
		$query_data = $db->query($sql_data);
			if($db->db_num_rows($query_data)=='0'){
				$db->query("Insert into menu_sitemap_list (s_id,menu_type,mp_id,m_realname,m_show,sm_active) Values ('".$_POST["sid"]."','1','$nid','".$_POST["inputMS".$i]."' ,NULL,'Y')");
			}else{
			$db->query("Update menu_sitemap_list SET 
			            m_realname='".$_POST["inputMS".$i]."' ,
						m_show=NULL,
							sm_active = 'Y'
						WHERE mp_id = '$nid' and s_id='".$_POST["sid"]."'");
				}
		}
	}
	$db->write_log("update","sitemap","ตั้งค่า sitemap");
	?>
			<script language="javascript">
		        alert('<?php echo $text_gensmap_complete2;?>');
				window.close();
			</script>
	<?php
}
if($_POST[Flag]=="SetDisp"){
				$db->query("UPDATE menu_setting SET s_type = '".$_POST["show_type"]."',s_column = '".$_POST["map_col"]."'  WHERE s_id = '".$_POST["sid"]."'");
				?>
		<script language="JavaScript">
				self.location.href = "menu_sitemap_config.php?sid=<?php echo $_POST["sid"]; ?>";
		</script>
	<?php
}
if($_POST[Flag]=="adddata"){
	$db->query("insert into menu_setting (s_name,s_type,s_column,s_map_type) values ('".$_POST[txt_name]."','0','1','".$_POST['map_type']."')");
	?>
		<script language="JavaScript">
				alert("บันทึกเรียบร้อย");
				self.location.href = "menu_sitemap_main.php";
		</script>
	<?php
}
if($_POST[Flag]=="editdata"){
	$db->query("update menu_setting set s_name ='".$_POST[txt_name]."', s_map_type='".$_POST['map_type']."' where s_id = '".$_POST["sid"]."'");
	?>
		<script language="JavaScript">
				alert("บันทึกเรียบร้อย");
				self.location.href = "menu_sitemap_main.php";
		</script>
	<?php
}
if($_GET[Flag]=="delete"){
	$db->query("delete from menu_setting where s_id ='".$_GET["sid"]."'");
	$db->query("delete from menu_sitemap_list where s_id ='".$_GET["sid"]."'");
	?>
		<script language="JavaScript">
				alert("ลบเรียบร้อย");
				self.location.href = "menu_sitemap_main.php";
		</script>
	<?php
}
if($_POST['Flag']=="UpdateSitemapBlock"){
	$chk=$_POST['chk'];
	$filename=$_POST['filename'];
	$sid=$_POST['sid'];
	$db->query('DELETE FROM block_sitemap WHERE filename=\''.$filename.'\'');
	foreach($chk as $key => $val) {
		$db->query('INSERT INTO block_sitemap(filename, BID, sid) VALUES(\''.$filename.'\',\''.$val.'\',\''.$sid.'\')');
	}
	?>
		<script language="JavaScript">
				alert("บันทึกเรียบร้อย");
				self.location.href = "menu_sitemap_page.php?sid=<?php echo $_POST['sid']; ?>";
		</script>
	<?php
}
$db->db_close(); ?>
