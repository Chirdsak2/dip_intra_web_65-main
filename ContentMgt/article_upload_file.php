<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");
if($_GET[flag]=='del'){
	$sql = "select fileattach_path from article_attach where fileattact_id = '".$_GET[at_id]."'";
	$query = $db->query($sql);
	$R = $db->db_fetch_array($query);
	$sql_c = $db->db_fetch_array($db->query("select count(fileattact_id) as num_c from article_attach where fileattach_path =  '".$R[fileattach_path]."' "));
	if($sql_c[num_c] == '1'){
				if (file_exists("../ewt/".$_SESSION["EWT_SUSER"]."/article_attach/".$R[fileattach_path])) {
				unlink("../ewt/".$_SESSION["EWT_SUSER"]."/article_attach/".$R[fileattach_path]);
				}
	}
	$db->query("DELETE FROM article_attach  where fileattact_id = '".$_GET[at_id]."'");
	?>
						<script language="javascript">
							alert("ลบเรียบร้อย");
							self.location.href = "article_upload_file.php?n_id=<?php echo $_GET["n_id"]; ?>&cid=<?php echo $_GET[cid];?>";
						</script>
		<?php
}
$n_id = $_GET[n_id];
$cid = $_GET[cid];
	?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">Article Attach  File</span></td>
  </tr>
</table>
<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right">
	<a href="article_edit.php?nid=<?php echo $n_id;?>&cid=<?php echo $cid;?>"><img src="../theme/main_theme/g_back.gif" width="16" height="16" border="0"> กลับหน้าหลัก</a>
	<a href="article_upload_file_add.php?flag=add&n_id=<?php echo $n_id;?>&cid=<?php echo $cid;?>"><img src="../theme/main_theme/g_add.gif" border="0"> เพิ่มเอกสารแนบ</a>
      <hr>
    </td>
  </tr>
</table>
<table width="90%" border="0" align="center" class="table table-bordered">
    <tr bgcolor="E0DFE3" class="ewttablehead"> 
	<td width="10%" align="center" >&nbsp;</td>
      <td width="90%"  height="18" align="center" >ชื่อเอกสารแนบ</td>
    </tr>
	<?php 
	$sel = "select * from article_attach where n_id = '".$n_id."' order by fileattact_id ASC";
	   if (empty($offset) || $offset < 0) { 
        $offset=0; 
		} 
	if(empty($limit)){
	$limit =10;
	}
	//    Set $totalrows = total number of rows that unlimited query would return 
	//    (total number of records to display across all pages) 
	$ExecSel = $db->query($sel);
	$rows = $db->db_num_rows($ExecSel);
	
		// Set $begin and $end to record range of the current page 
		$begin =($offset+1); 
		$end = ($begin+($limit-1)); 
		if ($end > $totalrows) { 
			$end = $totalrows; 
		} 
	$Show = $sel." LIMIT $offset, $limit ";
	$Execsql = $db->query($Show); 
	while($R = $db->db_fetch_array($Execsql)){
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="30">
	  <nobr>
	  <a  href="article_upload_file_add.php?flag=edit&n_id=<?php echo $n_id;?>&at_id=<?php echo $R[fileattact_id];?>&cid=<?php echo $cid;?>"><img src="../theme/main_theme/g_edit.gif" alt="แก้ไขเอกสารแนบ" width="16" height="16" border="0"></a>
	  <a href="article_upload_file.php?flag=del&n_id=<?php echo $n_id;?>&at_id=<?php echo $R[fileattact_id];?>&cid=<?php echo $cid;?>"><img src="../theme/main_theme/g_del.gif" alt="ลบเอกสารแนบ" width="16" height="16" border="0" onClick="return confirm('ต้องการลบข้อมูลหรือไม่');" onMouseOver="this.style.cursor='hand';">	</a>  </nobr>	  </td>
      <td height="30"><?php echo $R[fileattach_name];?></td>
    </tr>
	<?php }
	if($rows==0){
	?>
	   <tr bgcolor="#FFFFFF"> 
      <td height="30" colspan="4" align="center">ไม่พบรายการ</td>
    </tr>
	<?php
	}
	 ?>
    <tr bgcolor="#FFFFFF"> 
      <td height="30" colspan="4">หน้า : 
	  <?php
	  if($rows == 0){
	  	echo '[1]';
	  }else{
								// Begin Prev/Next Links 
								// Don't display PREV link if on first page 
								if ($offset !=0) {   
								$prevoffset=$offset-$limit; 
								echo   "<a href='$PHP_SELF?offset=$prevoffset'>
								<font  color=\"red\">$text_general_previous</font></a>\n\n";
								}
								$pages = intval($rows/$limit); 
								if ($rows%$limit) { 
										$pages++; 
								} 
								for ($i=1;$i<=$pages;$i++) { 
									if (($offset/$limit) == ($i-1)) { 
											echo "<b>[ $i ] </b>"; 
									} else { 
											$newoffset=$limit * ($i-1); 
											echo  "<a href=\"$PHP_SELF?offset=$newoffset\"". 
											"onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">$i</font></a>\n\n"; 
									} 
								} 
								if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
										$newoffset=$offset+$limit; 
										echo   "<a href=\"$PHP_SELF?offset=$newoffset\">
										<font color=\"red\">$text_general_next</font></a>"; 
								}
				}
								?> </td>
    </tr>
</table>
</body>
</html>
<?php $db->db_close(); ?>
