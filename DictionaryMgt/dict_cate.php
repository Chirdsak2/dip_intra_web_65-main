<?php
//include("administrator.php");
include("lib/include.php");
//include("inc.php");
include("../language/dict_language.php");
$db->query("USE ".$EWT_DB_USER);
 $data = $_REQUEST['data'];
 
 if (!empty($data)) {
			        $wh = " where DICT_WORD like '%$data%'  OR  DICT_SEARCH like '%$data%'  OR DICT_SYNONYM like '%$data%'  ";
}

$sel = "SELECT * FROM dictionary  $wh ORDER BY DICT_WORD  ASC";

$offset=$_GET[offset];
   if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
$limit = 15;

//    Set $totalrows = total number of rows that unlimited query would return 
//    (total number of records to display across all pages) 
$ExecSel = $db->query($sel);
$rows = mysql_num_rows($ExecSel);

	// Set $begin and $end to record range of the current page 
    $begin =($offset+1); 
    $end = ($begin+($limit-1)); 
    if ($end > $totalrows) { 
        $end = $totalrows; 
    } 
$Show = $sel." LIMIT $offset, $limit ";
$Execsql = $db->query($Show); 

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>

<body leftmargin="0" topmargin="0" class="normal_font">
<?php include("../FavoritesMgt/favorites_include.php");?>
<form name="form1" method="post" action="dict_cate.php">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/rude_function.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction"><?php echo $text_gendict_function;?></span> </td>
  </tr>
</table>


<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urldecode ( "การบริหารพจนานุกรม ");?>&module=dictionary&url=<?php echo urldecode ( "dict_cate.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="dict_addedit.php?flag=add" target="_self"><img src="../theme/main_theme/g_add.gif" width="16" height="16" align="absmiddle" border="0">
      <?php echo $text_gendict_addnew;?></a>
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
								<input type="hidden" name="curPage" value="1"> ค้นหาคำศัพท์
								<input type="text" name="data" value="<?php echo $data;?>">
								<input type="submit" name="Submit" value="ค้นหา">
								</td>
							</tr> 
						</table>
					  <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#B74900" class="ewttableuse">
							<tr align="center" class="ewttablehead"> 
							  <td width="10%"></td>
							  <td width="30%"><?php echo $text_gendict_formtype0;?></td>
							  <td width="30%"><?php echo $text_gendict_formtype1;?></td>
							  <td width="30%"><?php echo $text_gendict_formtype2;?></td>
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
									  <a href="dict_addedit.php?flag=edit&dict_id=<?php echo $rec['DICT_ID'] ?>" ><img src="../theme/main_theme/g_edit.gif" width="16" height="16"  border="0" alt="<?php echo $text_gendict_altedit?>"></a>
									  <a href="dict_function.php?flag=del&dict_id=<?php echo $rec['DICT_ID'] ?>"  onClick="return confirm('<?php echo $text_gendict_confirm_del?>');"> <img src="../theme/main_theme/g_garbage.png" width="16" height="16"  border="0" alt="<?php echo $text_gendict_altdel?>"></a>
									  <nobr>					  </td>
							  <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;   <?php echo $rec['DICT_WORD']?> </td> 
							  <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;   <?php echo $rec['DICT_SEARCH']?> </td> 
							  <td align="left">&nbsp;&nbsp;&nbsp;&nbsp;   <?php echo $rec['DICT_SYNONYM']?> </td> 
							</tr>
							<?php }  ?>
						   <?php if($rows > 0){ ?>
							<tr bgcolor="#FFFFFF"> 
							  <td height="25" colspan="15" valign="top"><?php echo $text_general_page;?> :
								<?php
														// Begin Prev/Next Links 
														// Don't display PREV link if on first page 
														$pages = intval($rows/$limit); 
														$last_offset=(($pages-1)*15)+1;
														$last_page=$pages;
														if ($rows%$limit) { 
																$pages++; 
														} 
													
														if ($offset !=0) {   
														echo   "<a href=\"$PHP_SELF?offset=0&data=$data\">
																<font color=\"red\">|< หน้าแรก</font></a>"; 
														$prevoffset=$offset-$limit; 
														echo   "<a href='$PHP_SELF?offset=$prevoffset&data=$data'>
														<font  color=\"red\">$text_general_previous</font></a>\n\n";
														}
													
														
														$start_set=floor($offset/($limit*100));
														if($start_set<=0){
														   $start_page=1;
														   if($pages>100){
														      $pages=100;
															}
														}else{
														   $start_page=($start_set*100)+1;
														   $pages=$start_page+100-1;
														} 
														
														for ($i=$start_page;$i<=$pages;$i++) { 
															if (($offset/$limit) == ($i-1)) { 
																	echo "<b>[ $i ] </b>"; 
															} else { 
																	$newoffset=$limit * ($i-1); 
																	echo  "<a href=\"$PHP_SELF?offset=$newoffset&data=$data\"". 
																	"onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">$i</font></a>\n\n"; 
															} 
														} 
														//if (!((($offset/$limit)+1)==$pages-1) && $pages!=1) { 
														if($last_page != 0 and $i<$last_page ){
																$newoffset=$offset+$limit; 
																//$newoffset=$last_offset;
																echo   "<a href=\"$PHP_SELF?offset=$newoffset&data=$data\">
																<font color=\"red\">$text_general_next</font></a>"; 
														}
														
														if($last_page != 0){
														        $newoffset=$last_page*15;
																echo   "<a href=\"$PHP_SELF?offset=$newoffset&data=$data\">
																<font color=\"red\">หน้าสุดท้าย >| </font></a>"; 
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
<?php 
$db->db_close(); 

?>
