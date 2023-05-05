<?php
include("administrator.php");
include("lib/include.php");
include("inc.php");
include("../language/rude_language.php");

 $data = $_REQUEST['data'];
 
 if (!empty($data)) {
			        $wh = " where vulgar_text like '%$data%' ";
}

$sel = "SELECT * FROM vulgar_table  $wh ORDER BY vulgar_text ASC";

$offset=$_GET[offset];
   if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
$limit = 15;

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
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" class="normal_font">
<?php include("../FavoritesMgt/favorites_include.php");?>
<form name="form1" method="post" action="vul_cate.php">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/rude_function.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction"><?php echo $text_genrude_function;?></span> </td>
  </tr>
</table>


<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode ('หน้าหลักการตั้งค่าคำไม่สุภาพ ');?>&module=vulgar&url=<?php echo urlencode ("vul_cate.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="vul_addedit.php?flag=add" target="_self"><img src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle" border="0">
      <?php echo $text_genrude_addnew;?></a>
      <hr>
    </td>
  </tr>
</table>

   <table width="94%" border="0" cellpadding="0" cellspacing="0" bgcolor="FFFFFF" align="center">
    <tr>
      <td valign="top"  class="MemberTitle">  
						<table width="100%" border="0" cellspacing="1" cellpadding="3" align="center" >
							<tr>
								<td >
								<input type="hidden" name="curPage" value="1"> ค้นหาคำไม่สุภาพ 
								<input type="text" name="data" value="<?php echo $data;?>">
								<input type="submit" name="Submit" value="ค้นหา">
								</td>
							</tr>
						</table>
					  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#B74900" class="ewttableuse">
							<tr align="center" class="ewttablehead"> 
							  <td width="6%"></td>
							  <td width="54%"><?php echo $text_genrude_title;?></td>
							  <td width="40%"><?php echo $text_genrude_type;?></td>
							</tr>
							<?php
								  //$x = $offset;
							while($rec = mysql_fetch_array($Execsql)){ 
													//$count = $db->query("SELECT * FROM vulgar_table WHERE vulgar_id = '$rec[vulgar_id]' ");
													//$countrow = mysql_num_rows($count);
													//$x +=$countrow 
							?>
							<tr bgcolor="#FFFFFF" onMouseOver="this.style.backgroundColor='#F5E0CD'" onMouseOut="this.style.backgroundColor='#FFFFFF'"> 
							  <td align="center"> 
									  <nobr>
									  <a href="vul_addedit.php?flag=edit&vulgar_id=<?php echo $rec['vulgar_id'] ?>" ><img src="../theme/main_theme/g_edit.gif" width="16" height="16"  border="0" alt="<?php echo $text_genrude_altedit?>"></a>
									  <a href="vul_function.php?flag=del&vulgar_id=<?php echo $rec['vulgar_id'] ?>"  onClick="return confirm('<?php echo $text_genrude_confirm_del?>');"> <img src="../theme/main_theme/g_garbage.png" width="16" height="16"  border="0" alt="<?php echo $text_genrude_altdel?>"></a>
									  <nobr>					  </td>
							  <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;   <?php echo $rec['vulgar_text']?> </td>
							  <td align="center"><?php if($rec['ip_add']==1){echo $text_genrude_formtype1;}else if($rec['ip_add']==2){echo $text_genrude_formtype2;}?> </td>
							</tr>
							<?php }  ?>
						   <?php if($rows > 0){ ?>
							<tr bgcolor="#FFFFFF"> 
							  <td height="25" colspan="15" valign="top"><?php echo $text_general_page;?> :
								<?php
														// Begin Prev/Next Links 
														// Don't display PREV link if on first page 
														if ($offset !=0) {   
														$prevoffset=$offset-$limit; 
														echo   "<a href='$PHP_SELF?offset=$prevoffset&data=$data'>
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
																	echo  "<a href=\"$PHP_SELF?offset=$newoffset&data=$data\"". 
																	"onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">$i</font></a>\n\n"; 
															} 
														} 
														if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
																$newoffset=$offset+$limit; 
																echo   "<a href=\"$PHP_SELF?offset=$newoffset&data=$data\">
																<font color=\"red\">$text_general_next</font></a>"; 
														}
														?>
							  </td>
							</tr>
							<?php }else{?>
							<tr bgcolor="#FFFFFF"> 
							  <td height="47" colspan="15"  align="center"><font color="#FF0000"><?php echo $text_general_notfound;?></font></td>
							</tr>
							<?php }?>
					</table>
		     </td>
        </tr>
  </table>
  </form>
  		

</body>
</html>
<script language="JavaScript">
function CHK(){
	if(document.form1.t_topic.value == ""){
		alert("กรุณาใส่คำไม่สุภาพ");
		document.form1.t_topic.focus();
		return false;
	}
	
	return true;
}
</script>
<?php $db->db_close(); ?>
