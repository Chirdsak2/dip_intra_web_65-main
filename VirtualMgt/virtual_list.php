<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$sel = "SELECT * FROM virtual_list  WHERE vg_id='$_GET[gid]' ORDER BY v_id ASC";

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
<?php include("../FavoritesMgt/favorites_include.php");?>
<?php
$parent=$_GET[gid];
$group_text="";
if($parent!=0){
	do{
		$sql_insert = "SELECT vg_id,vg_name,vg_parent  FROM virtual_group WHERE vg_id='$parent' ";
		$query=$db->query($sql_insert);
		$dat=$db->db_fetch_array($query);
		$group_text=' ><a href="virtual_list.php?gid='.$dat[vg_id].'"> '.$dat[vg_name].'</a>'.$group_text;
		$group_text2 = '>'.$dat[vg_name].$group_text2;
		$parent=$dat[vg_parent];
	}while($parent!=0);
}

?>

<form name="myFrom" method="post" action="virtualg_process.php">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/virtual_function.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction"><a href="virtual_list.php" >ข้อมูล Virtual  Tour </a><?php echo $group_text;?></span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
    <tr> 
      <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("ข้อมูล Virtual Tour ".$group_text2);?>&module=virtual&url=<?php echo urlencode("virtual_list.php?gid=".$_GET["gid"]);?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="virtual_group_add.php?gid=<?php echo $_GET[gid]?>" ><img src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle" border="0"> 
        เพิ่มกลุ่มใหม่</a>  &nbsp;  <a href="virtual_add.php?gid=<?php echo $_GET[gid]?>" ><img src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle" border="0"> 
        เพิ่ม virtual tour ในกลุ่ม</a> &nbsp; <a href="virtual_list.php" ><img src="../theme/main_theme/g_mainpage.gif" width="16" height="16" align="absmiddle" border="0">กลับหน้าหลัก</a> 
        <hr>
    </td>
  </tr>
</table>


<?php
$sel2 = "SELECT * FROM virtual_group  WHERE  vg_parent='$_GET[gid]'  ORDER BY vg_id ASC";
$ExecSel2 = mysql_query($sel2);
$rows2 = mysql_num_rows($ExecSel2);
?>

<table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
    <td width="5%" height="30" align="center">&nbsp;</td>
      <td >รายชื่อกลุ่ม</td>
    <td width="5%" align="center">Delete</td>
  </tr>
  <?php 
  
  $x = $offset;
  if($rows2>0){
       $i = 0;
  		while($data2=$db->db_fetch_array($ExecSel2)){ ?>
			  <tr bgcolor="#FFFFFF"> 
				<td align="center"><nobr><a href="virtual_group_edit.php?gid=<?php echo $data2[vg_id];?>" ><img src="../theme/main_theme/g_edit.gif" width="16" height="16" alt="แก้ไข" border="0"></a> </nobr></td>
				<td><a href="virtual_list.php?gid=<?php echo $data2[vg_id];?>"><?php echo $data2[vg_name];?></a></td>
				<td align="center">
				<input name="del<?php echo $i; ?>" type="checkbox" id="del<?php echo $i; ?>" value="<?php echo $data2[vg_id]; ?>" ></td>
			  </tr>
  <?php
         $i++;
		 } ?>
			<tr align="right" bgcolor="#FFFFFF"> 
				<td colspan="2">&nbsp;</td>
				<td align="center"> 
					<input name="all" type="hidden" id="all2" value="<?php echo $i; ?>">
					<input type="hidden" name="flag" value="del">
		  			<input type="submit" name="Button" value="Delete" onClick="javascript: return confirm('คุณแน่ใจที่จะลบกลุ่ม หรือไม่?');"></td>
		  </tr>
  <?php }else{?>
			  <tr bgcolor="#FFFFFF"> 
				<td align="center" colspan="3" ><strong>ไม่มีข้อมูล</strong></td>
			  </tr>
  <?php
  
  }
  ?>
</table>
</form><br><br>


  <?php 
  if($_GET[gid]!=0){
		$sql = "SELECT * FROM virtual_group  WHERE vg_id='$_GET[gid]'";
		$query=$db->query($sql);
		$data=$db->db_fetch_array($query);
?>
<form name="myFrom" method="post" action="virtual_process.php">
  <table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#CECECE" class="ewttableuse">
  <tr bgcolor="#E7E7E7"  class="ewttablehead"> 
    <td width="5%" height="30" align="center">&nbsp;</td>
    <td >รายชื่อ Virtual  tour ในกลุ่ม  <?php echo $data[vg_name];?></td>
    <td width="5%" align="center">Delete</td>
  </tr>
  <?php 
  
  $x = $offset;
  if($rows>0){
       $i = 0;
  		while($data=$db->db_fetch_array($Execsql)){ ?>
			  <tr bgcolor="#FFFFFF"> 
				<td align="center" nowrap><a href="virtual_edit_show.php?vid=<?php echo $data[v_id];?>"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" alt="แก้ไข" border="0"></a>
				<a href="virtual_preview.php?vid=<?php echo $data[v_id];?>&&vg_id=<?php echo $_GET[gid];?>"><img src="../theme/main_theme/g_add_document.gif" width="16" height="16" alt="hot-sport" border="0"></a>
				<a href="#view"  onClick="window.open('../ewt/<?php echo $_SESSION["EWT_SUSER"]; ?>/ewt_virtual.php?vid=<?php echo $data[v_id];?>','','width=800,height=600,scrollbars=1,resizable=1');"><img border="0" src="../theme/main_theme/g_view.gif" width="16" height="16" align="absmiddle" alt="Preview"></a></td>
				<td><?php echo $data[v_name];?> </td>
				<td align="center">
				<input name="del<?php echo $i; ?>" type="checkbox" id="del<?php echo $i; ?>" value="<?php echo $data[v_id]; ?>" >
    </td>
			  </tr>
  <?php 
         $i++;
  } ?>
			<tr align="right" bgcolor="#FFFFFF"> 
				<td colspan="2">&nbsp;</td>
				<td align="center">
          <input name="all" type="hidden" id="all2" value="<?php echo $i; ?>">
		  <input type="hidden" name="flag" value="del">
		  <input type="hidden" name="gid" value="<?php echo $_GET[gid]?>">
		  <input type="submit" name="Button" value="Delete" onClick="javascript: return confirm('คุณแน่ใจที่จะลบ virtual หรือไม่?');"></td>
		  </tr>
  <?php }else{?>
			  <tr bgcolor="#FFFFFF"> 
				<td align="center" colspan="3" ><strong>ไม่มีข้อมูล</strong></td>
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
<?php } ?>
</body>
</html>
<?php
$db->db_close(); ?>