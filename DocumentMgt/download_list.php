<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

include("../lib/utilities_function.php");

$gid=$_REQUEST[gid];
if($gid<=0){
?><script language="jscript">location.href='main_download_group.php';</script><?php
}

function current_group_level($gid){
	global $db;
	$sql = "select * from docload_group where dlg_id = '$gid' ";
	$query = $db->query($sql); 
	$R = mysql_fetch_array($query);
	if($R[dlg_parent] > 0){  current_group_level($R[dlg_parent]); }
	if($gid<>0){
		 echo ' >> <a href="download_list.php?gid='.$R[dlg_id].'">'.$R[dlg_name].'</a>';
	}
}
include("lib_doc.php");
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<?php
$sel = "SELECT * FROM docload_group WHERE dlg_parent='$gid' ORDER BY dlg_id ASC";

$offset=$_GET[offset];
   if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
$limit = 5;

//    Set $totalrows = total number of rows that unlimited query would return 
//    (total number of records to display across all pages) 
$ExecSel = mysql_query($sel);
@$rows = mysql_num_rows($ExecSel);

	// Set $begin and $end to record range of the current page 
    $begin =($offset+1); 
    $end = ($begin+($limit-1)); 
    if ($end > $totalrows) { 
        $end = $totalrows; 
    } 
$Show = $sel." LIMIT $offset, $limit ";
$Execsql = mysql_query($Show); 


?>
<form name="myFrom" method="post" action="downloadg_process.php">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/download_function.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction"><a href="download_list.php?gid=0">กลุ่ม Download</a> <?php current_group_level($_GET["gid"]);?> </span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode ("หน้าหลัก->กลุ่ม Download : ").current_group_level2($_GET["gid"]); ?>&module=document&url=<?php echo urlencode  ( "download_list.php?gid=".$_GET["gid"]);?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="download_group_add.php?pid=<?php echo $_REQUEST[gid]?>" ><img src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle" border="0"> เพิ่มกลุ่มใหม่</a>  &nbsp; <a href="main_download_group.php" ><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0">กลับหน้าหลัก</a>
	<hr>
    </td>
  </tr>
</table>

<table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
    <td width="5%" height="30" align="center">&nbsp;</td>
    <td width="20%" align="center">รายชื่อกลุ่ม</td>
    <td width="60%" align="center">รายละเอียด</td>
    <td width="10%" align="center">สำหรับ</td>
    <td width="5%" align="center">Delete</td>
  </tr>
  <?php 
  
  $x = $offset;
  if($rows>0){
       $i = 0;
  		while($data=$db->db_fetch_array($Execsql)){ ?>
			  <tr bgcolor="#FFFFFF"> 
				<td align="center"><nobr>
				<a href="download_group_edit.php?gid=<?php echo $data[dlg_id];?>" ><img src="../theme/main_theme/g_edit.gif" width="16" height="16" alt="แก้ไข" border="0"></a> 
				</nobr></td>
				<td><a href="download_list.php?gid=<?php echo $data[dlg_id];?>"><?php echo $data[dlg_name];?></a></td>
				<td><?php echo $data[dlg_detail];?></td>
				<td  align="center"><?php if($data[dlg_private]=='Y'){ echo "สมาชิก"; }else{  echo "ทุกคน"; }?></td>
				<td align="center">
				<input name="del<?php echo $i; ?>" type="checkbox" id="del<?php echo $i; ?>" value="<?php echo $data[dlg_id]; ?>" ></td>
			  </tr>
  <?php
         $i++;
		 } ?>
			<tr align="right" bgcolor="#FFFFFF"> 
				<td colspan="4">&nbsp;</td>
				<td align="center"> 
					<input name="all" type="hidden" id="all2" value="<?php echo $i; ?>">
					<input type="hidden" name="flag" value="del">
					<input type="hidden" name="pid" value="<?php echo $_REQUEST[gid]?>">
		  			<input type="submit" name="Button" value="Delete" onClick="javascript: return confirm('คุณแน่ใจที่จะลบกลุ่ม หรือไม่?');"></td>
		  </tr>
  <?php }else{?>
			  <tr bgcolor="#FFFFFF"> 
				<td align="center" colspan="5" ><strong>ไม่มีข้อมูล</strong></td>
			  </tr>
  <?php
  
  }
  ?>
  

</table>
<table width="94%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td> หน้า : 
      <?php
				// Begin Prev/Next Links 
				// Don't display PREV link if on first page 
				if ($offset !=0) {   
				$prevoffset=$offset-$limit; 
				echo   "<a href='$PHP_SELF?offset=$prevoffset&x=$x'>
				<font  color=\"red\">&lt&ltPre</font></a>\n\n";
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
							echo  "<a href='$PHP_SELF?offset=$newoffset' ". 
							"onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">$i</font></a>\n\n"; 
					} 
				} 
				if ((!((($offset/$limit)+1)==$pages) && $pages!=1)  and   $rows>0){
						$newoffset=$offset+$limit; 
						echo   "<a href='$PHP_SELF?offset=$newoffset'>
						<font color=\"red\">Next>></font></a>"; 
				}
				?>
    </td>
  </tr>
</table>

</form>

















<?php
$sel = "SELECT * FROM docload_list  WHERE dl_dlgid='$_GET[gid]' ORDER BY dl_id ASC";

$offset=$_GET[offset];
   if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
$limit = 5;

//    Set $totalrows = total number of rows that unlimited query would return 
//    (total number of records to display across all pages) 
$ExecSel = mysql_query($sel);
@$rows = mysql_num_rows($ExecSel);

	// Set $begin and $end to record range of the current page 
    $begin =($offset+1); 
    $end = ($begin+($limit-1)); 
    if ($end > $totalrows) { 
        $end = $totalrows; 
    } 
$Show = $sel." LIMIT $offset, $limit ";

$Execsql = mysql_query($Show); 

		$sql = "SELECT * FROM docload_group  WHERE dlg_id='$_GET[gid]'";
		$query=$db->query($sql);
		$data=$db->db_fetch_array($query);
?> 
<form name="myFrom" method="post" action="download_process.php">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/download_function.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">ข้อมูล File Download</span> (กลุ่ม <?php echo $data[dlg_name];?>)</td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="download_add.php?gid=<?php echo $_GET[gid]?>" ><img src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle" border="0"> เพิ่ม File ในกลุ่ม</a>
	<hr>
    </td>
  </tr>
</table>

<table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
    <td width="5%" height="30" align="center">&nbsp;</td>
    <td width="15%">รายชื่อ File</td>
    <td width="35%" align="center">รายละเอียด</td>
    <td width="10%" align="center">ขนาดไฟล์(Kb)</td>
    <td width="10%" align="center" >วันที่สร้าง</td>
    <td width="10%" align="center">วันที่<br>แก้ไขล่าสุด</td>
    <td width="10%" align="center">สถานะ<br>ดาวน์โหลด</td>
    <td width="5%" align="center">Delete</td>
  </tr>
  <?php 
  
  $x = $offset;
  if($rows>0){
       $i = 0;
  		while($data=$db->db_fetch_array($Execsql)){ ?>
			  <tr bgcolor="#FFFFFF"> 
				<td align="center"><nobr><a href="download_edit.php?fid=<?php echo $data[dl_id];?>&gid=<?php echo $_GET[gid]?>"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" alt="แก้ไข" border="0"></a> </nobr></td>
				<td><?php echo $data[dl_name];?></td>
				 <td ><?php echo $data[dl_detail];?></td>
				<td align="center"><?php echo number_format($data[dl_filesize]/1024,2);?></td>
				<td align="center"><?php echo date_display($data[dl_createdate],'YmdHis','DT1Th');?></td>
				<td align="center"><?php echo date_display($data[dl_update],'YmdHis','DT1Th');?></td>
				<td align="center"><?php if($data[dl_open]=='Y'){echo 'เปิด';}else{echo 'ปิด';}?></td>
				<td align="center">
				<input name="del<?php echo $i; ?>" type="checkbox" id="del<?php echo $i; ?>" value="<?php echo $data[dl_id]; ?>" >
    </td>
			  </tr>
  <?php 
         $i++;
  } ?>
			<tr align="right" bgcolor="#FFFFFF"> 
				<td colspan="7">&nbsp;</td>
				<td align="center">
          <input name="all" type="hidden" id="all2" value="<?php echo $i; ?>">
		  <input type="hidden" name="flag" value="del">
		  <input type="hidden" name="gid" value="<?php echo $_GET[gid]?>">
		  <input type="submit" name="Button" value="Delete" onClick="javascript: return confirm('คุณแน่ใจที่จะลบ File Download หรือไม่?');"></td>
		  </tr>
  <?php }else{?>
			  <tr bgcolor="#FFFFFF"> 
				<td align="center" colspan="8" ><strong>ไม่มีข้อมูล</strong></td>
			  </tr>
  <?php
  
  }
  ?>
  

</table>
<table width="94%" border="0" align="center" cellpadding="3" cellspacing="0">
  <tr>
    <td> หน้า : 
      <?php
				// Begin Prev/Next Links 
				// Don't display PREV link if on first page 
				if ($offset !=0) {   
				$prevoffset=$offset-$limit; 
				echo   "<a href='$PHP_SELF?offset=$prevoffset&x=$x&gid=$gid'>
				<font  color=\"red\">&lt&ltPre</font></a>\n\n";
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
							echo  "<a href='$PHP_SELF?offset=$newoffset&gid=$gid' ". 
							"onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">$i</font></a>\n\n"; 
					} 
				} 
				if ((!((($offset/$limit)+1)==$pages) && $pages!=1)  and   $rows>0){
						$newoffset=$offset+$limit; 
						echo   "<a href='$PHP_SELF?offset=$newoffset&gid=$gid'>
						<font color=\"red\">Next>></font></a>"; 
				}
				?>
    </td>
  </tr>
</table>
</form>
</body>
</html>
<?php
$db->db_close(); ?>