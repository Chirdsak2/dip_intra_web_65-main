<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");


$sel = "SELECT * FROM download_group  ORDER BY dlg_id ASC";

$offset=$_GET[offset];
   if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
$limit = 5;

//    Set $totalrows = total number of rows that unlimited query would return 
//    (total number of records to display across all pages) 
$ExecSel = mysql_query($sel);
$rows = mysql_num_rows($ExecSel);

	// Set $begin and $end to record range of the current page 
    $begin =($offset+1); 
    $end = ($begin+($limit-1)); 
    if ($end > $totalrows) { 
        $end = $totalrows; 
    } 
$Show = $sel." LIMIT $offset, $limit ";
$Execsql = mysql_query($Show); 


?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">

<form name="myFrom" method="post" action="downloadg_process.php">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/download_function.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">กลุ่ม Download</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="download_group_add.php" ><img src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle" border="0"> เพิ่มกลุ่มใหม่</a> 
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
				<td align="center"><nobr><a href="download_group_edit.php?gid=<?php echo $data[dlg_id];?>" ><img src="../theme/main_theme/g_edit.gif" width="16" height="16" alt="แก้ไข" border="0"></a> </nobr></td>
				<td><a href="download_list.php?gid=<?php echo $data[dlg_id];?>"><?php echo $data[dlg_name];?></a></td>
				<td><?php echo $data[dlg_detail];?></td>
				<td  align="center"><?php if($data[dlg_type]=='M'){echo "สมาชิก";}else{echo "ทุกคน";}?></td>
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
</body>
</html>
<?php
$db->db_close(); ?>