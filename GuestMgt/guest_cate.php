<?php
include("administrator.php");
include("lib/include.php");
include("inc.php");
include("../language/guest_language.php");

$chk_config = mysql_query("SELECT * FROM guest_config ");
$CO = mysql_fetch_array($chk_config);


//#########################    Chack Date < guest_config_date ########
$d = date(d) - $CO['guest_config_date'];
$m = date(m);
$y = date(Y);
$today = $y."-".$m."-".date(d);
$chk_date=  date("Y-m-d", mktime(0, 0, 0, $m, $d, $y));
//###############################################################

$s=explode('/',$_POST[datestart]);
$e=explode('/',$_POST[dateend]);
$sdate=($s[2]-543).'-'.$s[1].'-'.$s[0];
$edate=($e[2]-543).'-'.$e[1].'-'.$e[0];
if($_POST[datestart] or $_POST[dateend] or  $_POST[status_type]){
     if($_POST[datestart] and $_POST[dateend]){
	     $where=" and (date_guest  >= '$sdate' and date_guest <= '$edate')  ";
	 }else{
	     if($_POST[datestart]){  
			$where=" and (date_guest  >= '$sdate') "; 
		}else  if($_POST[dateend]){
			$where=" and (date_guest  <= '$edate') "; 
		}
	 }
	 if($_POST[status_type]!='All'){ 
	   $where.=" and (status_guest  = '".$_POST[status_type]."') "; 
	 }
}else{
	$where='';
}
$sel = "SELECT * FROM guestbook_list   where status_guest <> ' ' $where ORDER BY id_guest DESC";//WHERE date_guest BETWEEN '$chk_date' AND ' $today'


   if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
$limit = $CO[guest_config_page];
$ExecSel = mysql_query($sel);
$rows = mysql_num_rows($ExecSel);
$begin =($offset+1); 
$end = ($begin+($limit-1)); 
if ($end > $totalrows) { 
	$end = $totalrows; 
} 
$Show = $sel." LIMIT $offset, $limit ";
//echo  $Show;
$Execsql = mysql_query($Show); 
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<link href="../css/style_calendar.css" rel="stylesheet" type="text/css">
<script language="JavaScript"  type="text/javascript" src="../js/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/calendar-th.js"></script>
<style type="text/css">
<!--
a:link { color: #005CA2; text-decoration: none}
a:visited { color: #005CA2; text-decoration: none}
a:active { color: #0099FF; text-decoration: none}
a:hover { color: #0099FF; text-decoration: none}
-->
</style>
</head>

<body leftmargin="0" topmargin="0" class="normal_font">
<?php include("../FavoritesMgt/favorites_include.php");?>
<div align="center">
<form name="form1" method="post" action="" >
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/guest_function.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction"><?php echo $text_genguest_function1;?></span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode($text_genguest_function1);?>&module=guestbook&url=<?php echo urlencode("guest_cate.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href="guest_cate.php" target="_self"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" align="absmiddle" border="0"> 
      <?php echo $text_genguest_manage;?></a><a href="#print" onClick="
	  var s=document.form1.datestart.value; 
	  var e=document.form1.dateend.value; 
	  var t=document.form1.status_type.value;
	    window.open('guest_print.php?datestart='+s+'&dateend='+e+'&status_type='+t);"><img src="../theme/main_theme/g_edit.gif" width="16" height="16" align="absmiddle" border="0"> 
     <?php echo $text_genguest_print;?></a>
	  
	  <hr>
    </td>
  </tr>
</table>
  <table width="94%" height="100%" border="0" cellpadding="0" cellspacing="0">
    <tr valign="top">
      <td colspan="2"><?php @include("com_top.php"); ?> ค้นหา วันที่ <input type="text" name="datestart" title="ตัวอย่าง : 01/01/2008" value="<?php echo $_POST[datestart]?>">  <a href="#date" onClick="return showCalendar('datestart', 'dd-mm-y');" ><img src="../images/calendar.gif" width=20 height=20 border=0 align="absmiddle" ></a> 
	  ถึง <input type="text" name="dateend" title="ตัวอย่าง : 31/01/2008" value="<?php echo $_POST[dateend]?>"> <a href="#date" onClick="return showCalendar('dateend', 'dd-mm-y');" ><img src="../images/calendar.gif" width=20 height=20 border=0 align="absmiddle" ></a>
	  <select name="status_type">
	  <option value="All">ทุกสถานะ</option>
	  <option value="Y" <?php if($_POST[status_type]=='Y')echo 'selected'; ?>>อนุมัติแล้ว</option>
	  <option value="N" <?php if($_POST[status_type]=='N')echo 'selected'; ?>>ยังไม่อนุมัติ</option>
	  </select>
	  <input type="submit" value="ค้นหา"></td>
    </tr>
    <tr>
      <td width="94%" height="100%" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" class="normal_font">
          <tr> 
            <td colspan="2" valign="top"> <DIV align="center"  style="HEIGHT: 100%;OVERFLOW-Y: auto;WIDTH: 100%"> 
                <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#B74900"  class="ewttableuse">
								  <tr align="center" class="ewttablehead"> 
										<td width="10%" ></td>
										<td width="10%" ><?php echo $text_genguest_column1;?></td>
										<td width="30%" ><?php echo $text_genguest_column2;?></td>
										<td width="10%" ><?php echo $text_genguest_column3;?></td>
										<td width="10%" ><?php echo $text_genguest_column4;?></td>
                                        <td width="10%" ><?php echo $text_genguest_column5;?></td>
										<td width="10%" ><?php echo $text_genguest_column6;?></td>
										<td width="10%" ><?php echo $text_genguest_column7;?></td>
								  </tr>
					<?php
							 function chg_date_th ($date_input)
							{
								   $date = substr($date_input,8,2);
								   $mont= substr($date_input,5,2);
								   $year_en = substr($date_input,0,4);
								   $year=$year_en+543;
						
								   return $date."/".$mont."/".$year;
							}
							
						  if($rows > 0){
								   while($rec = mysql_fetch_array($Execsql)){ 
											/*$count = $db->query("SELECT * FROM guestbook_list WHERE id_guest = '$rec[id_guest]' ");
											$countrow = mysql_num_rows($count);*/
											$date_print = chg_date_th($rec['date_guest']);
				?>
								  <tr bgcolor="#FFFFFF" > 
										<td align="center"  >
										<a onClick="return confirm('<?php if($rec[status_guest] == Y){ echo $text_genguest_confirm_cancel;}else{echo $text_genguest_confirm_app;}?>')"
																href = 'guest_function.php?proc=<?php if($rec[status_guest] == Y){echo "cancel";}else{echo "confirm";}?>&id_guest=<?php echo $rec[id_guest]?>'>																
																<?php if($rec[status_guest] == 'Y'){?>
																    <img src="../theme/main_theme/g_applycancle.gif" border="0" alt="<?php echo $text_genguest_altcancel?>" >
																<?php }else{ //echo "อนุมัติ"; ?> 
																   <img src="../theme/main_theme/g_apply.gif" border="0" alt="<?php echo $text_genguest_altapp?>">
																<?php }?>
									    </a>
										<a href="guest_edit.php?id_guest=<?php echo $rec['id_guest']?>"><img src="../theme/main_theme/g_edit.gif" border="0" alt="<?php echo $text_genguest_altedit?>"></a>
										<img src="../theme/main_theme/g_del.gif" onClick=" if(confirm('<?php echo $text_genguest_confirm_del?>')){form1.action='guest_function.php?type_page=cate&id_guest=<?php echo $rec['id_guest']?>';form1.submit();}" style="cursor:hand" alt="<?php echo $text_genguest_altdel?>">
										</td>
										<td align="center"  ><?php if($rec[status_guest] == 'Y'){ echo $text_genguest_status1;}else{ echo $text_genguest_status2;}?></td>
                      					<td align="left"  >&nbsp;  <?php echo $rec['detail_guest'];?></td>
                      					<td align="left"  ><?php print $rec['name_guest'];?></td>
										<td align="left"  ><?php print $rec['country_province'];?></td>
										<td align="center"  ><?php print $rec['unit_guest'];?></td>
										<td align="center"  ><?php echo $date_print.' '.$rec['time_guest'];?></td>
										<td align="center"  > <?php echo $rec['ip_guest'];?></td>
				    </tr>
	
					<?php						
									}
							 }else{ 
					?>
								  <tr bgcolor="#FFFFFF"> 
										<td  align="center" colspan="8"><font color="#FF0000"><strong><?php echo $text_genguest_notfound;?></strong></font></td>
								  </tr>
					  <?php } 
				    if($rows > 0){ ?>
						<tr bgcolor="#FFFFFF">
								<td height="25" colspan="8" valign="top"><?php echo $text_genguest_page;?> :     <?php
								// Begin Prev/Next Links 
								// Don't display PREV link if on first page 
								if ($offset !=0) {   
								$prevoffset=$offset-$limit; 
								echo   "<a href='$PHP_SELF?offset=$prevoffset'>
								<font  color=\"red\">$text_genguest_pre</font></a>\n\n";
								}
								$pages = intval($rows/$limit); 
								if ($rows%$limit) { 
										$pages++; 
								} 
								for ($i=1;$i<=$pages;$i++) { 
									if (($offset/$limit) == ($i-1)) { 
											echo "<font  color=\"blue\">[ $i ] </font>"; 
									} else { 
											$newoffset=$limit * ($i-1); 
											echo  "<a href='$PHP_SELF?offset=$newoffset' ". 
											"onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">$i</font></a>\n\n"; 
									} 
								} 
								if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
										$newoffset=$offset+$limit; 
										echo   "<a href='$PHP_SELF?offset=$newoffset'>
										<font color=\"red\">$text_genguest_next</font></a>"; 
								}
								?></td>
						</tr>
					<?php } ?>
                </table>
                <br>
            </DIV></td>
          </tr>
        </table>
      </td>
    </tr>
    <tr valign="top">
      <td colspan="2"><?php @include("com_bottom.php"); ?></td>
    </tr>
  </table>
  </form>
</div>
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
