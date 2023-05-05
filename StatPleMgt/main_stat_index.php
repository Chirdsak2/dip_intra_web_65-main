<?php
session_start();
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";


function convert_datedb($date){ 
	//$mont =  array("ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
	$mont =  array("1"=>"มกราคม","2"=>"กุมภาพันธ์","3"=>"มีนาคม","4"=>"เมษายน","5"=>"พฤษภาคม","6"=>"มิถุนายน", "7"=>"กรกฎาคม","8"=>"สิงหาคม","9"=>"กันยายน","10"=>"ตุลาคม",
							"11"=>"พฤศจิกายน","12"=>"ธันวาคม");
	$date = substr($date,0,10);
	
	if($date){
		$arr = explode("-",$date);
		$month=$mont[(($arr[1]*1))];
		$date = ($arr[2].' '.$month.' '.($arr[0]+543));
		return $date;
	}//if
}//fuction

$nmoth = $_REQUEST['nmoth'];
$nyear = $_REQUEST['nyear'];
$wh = " where 1=1 ";
if (!empty($nmoth)) {
			  $wh .= " and substring(p_date,6,2) = '".sprintf("%02d",$nmoth)."' ";
}
if (!empty($nyear)) {
			  $wh .= " and substring(p_date,1,4) = '$nyear' ";
}

$sel = "SELECT * FROM stat_population $wh order by p_date desc";

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
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<?php include("../FavoritesMgt/favorites_include.php");?>
<form name="frm1" action="main_stat_index.php" method="post">
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/banner_function.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction">ข้อมูลสถิตินักท่องเที่ยว</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("สถิตินักท่องเที่ยว");?>&module=banner&url=<?php echo urlencode("main_group_banner.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="stat_add.php?flag=add" target="_self"><img src="../theme/main_theme/g_add.gif"  width="16" height="16"  align="absmiddle" border="0"> 
      เพิ่มสถิตินักท่องเที่ยว</a>
      <hr>
    </td>
  </tr>
</table>

<table width="94%" height="100%" border="0" cellpadding="0" cellspacing="0" class="normal_font" align="center">
  <tr> 
	<td  valign="top" align="center"> 
	
				<table width="60%" border="0" cellspacing="1" cellpadding="3">
					<tr height="40">
					  <td ><input type="hidden" name="curPage" value="1">
						ค้นหา สถิตินักท่องเที่ยว 				
						<select name="nyear">
							<option value="">-เลือกปี-</option>
							<?php 
								$sel2 = "SELECT DISTINCT substring(p_date,1,4) as date1 FROM stat_population order by p_date desc";
								$qul = mysql_query($sel2);
								while($rs2 = $db->db_fetch_array($qul)){
									if($rs2['date1']==$nyear){
										echo '<option value="'.$rs2['date1'].'" selected>'.($rs2['date1']+543).'</option>';
									}else{
										echo '<option value="'.$rs2['date1'].'">'.($rs2['date1']+543).'</option>';
									}
								}
								
							?>
						</select>
					  <input type="submit" name="Submit" value="ค้นหา"></td>
					</tr>
				  </table>
	
				<table width="60%" cellpadding="5"  cellspacing="1" bgcolor="#B74900" class="ewttableuse" >
				<tr class="ewttablehead" >
				  <td width="4%" ></td>  
				  <td width="10%" align="center">เดือน/ปี</td>
				  <td width="10%" align="center">จำนวนคนไทย</td>
				  <td width="10%" align="center">จำนวนคนต่างชาติ</td>
				  </tr>
					<?php 
						$num = $db->db_num_rows($Execsql);
						if($num> 0){
								while($rs = $db->db_fetch_array($Execsql)){
									$sum = $rs[p_nthai]+$rs[p_nother];
								?>
								<tr bgcolor="#FFFFFF" align="center">
									<td><img src="../theme/main_theme/g_edit.gif" height="16" width="16" align="absmiddle" alt="<?php echo $text_genbanner_altedit;?>" style="cursor:hand" onClick="location.href='stat_add.php?flag=edit&p_id=<?php echo $rs[p_id]?>';">&nbsp;<img src="../theme/main_theme/g_garbage.png" height="16" width="16" align="absmiddle" alt="<?php echo $text_genbanner_altdel;?>" style="cursor:hand" onClick="if(confirm('ยืนยันการลบสถิติ'))location.href = 'stat_process.php?flag=del&p_id=<?php echo $rs[p_id]?>'; "></td>
									<td><?php echo convert_datedb($rs[p_date]);?></td>
									<td><?php if($rs[p_nthai]!="-"){echo  number_format($rs[p_nthai]);}else{echo$rs[p_nthai];}?></td>
									<td><?php if($rs[p_nother]!="-"){echo  number_format($rs[p_nother]);}else{echo $rs[p_nother];}?></td>
								</tr>
								<?php  }
						} ?>
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
                      <td height="30" colspan="15"  align="center"><font color="#FF0000"><?php echo $text_general_notfound;?></font></td>
                    </tr>
			<?php }?>
				   </table>
   </td>
  </tr>
</table>
</form>
</body>
</html>
<?php
$db->db_close(); ?>
