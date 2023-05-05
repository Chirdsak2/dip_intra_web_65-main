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

$s=explode('/',$_GET[datestart]);
$e=explode('/',$_GET[dateend]);
$sdate=($s[2]-543).'-'.$s[1].'-'.$s[0];
$edate=($e[2]-543).'-'.$e[1].'-'.$e[0];
if($_GET[datestart] or $_GET[dateend] or  $_GET[status_type]){
     if($_GET[datestart] and $_GET[dateend]){
	     $where=" and (date_guest  >= '$sdate' and date_guest <= '$edate')  ";
	 }else{
	    if($_GET[datestart]){  
			$where=" and (date_guest  >= '$sdate') "; 
		}else  if($_GET[dateend]){
			$where=" and (date_guest  <= '$edate') "; 
		}
	 }
	 if($_GET[status_type]!='All'){ 
	   $where.=" and (status_guest  = '".$_GET[status_type]."') "; 
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
$Show = $sel;
//echo  $Show;
$Execsql = mysql_query($Show); 
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
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
<div align="center">
<form name="form1" method="post" action="" >
  <table width="94%" height="100%" border="0" cellpadding="0" cellspacing="0">
    <tr valign="top">
      <td colspan="2"><?php @include("com_top.php"); ?>  </td>
    </tr>
    <tr>
      <td width="94%" height="100%" valign="top"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0" class="normal_font">
          <tr> 
            <td colspan="2" valign="top"> <DIV align="center"  style="HEIGHT: 100%;OVERFLOW-Y: auto;WIDTH: 100%"> 
                <table width="100%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#B74900"  class="ewttableuse">
								  <tr align="left" class="ewttablehead"> 
										<td width="10%" >รายงานสมุดเยี่ยมชม 
										<?php if($_GET[datestart]){?> ตั้งแต่วันที่ <?php echo $_GET[datestart]; }?> 
										<?php if($_GET[dateend]){?> ถึงวันที่ <?php echo $_GET[dateend]; }?></td>
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
										
										<table cellpadding="0" cellspacing="1" width="100%">
										   <tr>
											   <td align="left" width="20%">&nbsp;  <?php echo $text_genguest_column1;?></td>
											   <td align="left" width="70%">&nbsp;  <?php if($rec[status_guest] == 'Y'){ echo $text_genguest_status1;}else{ echo $text_genguest_status2;}?></td>
										   </tr>
										   <tr>
											   <td align="left"  >&nbsp;  <?php echo $text_genguest_column2;?></td>
											   <td align="left"  >&nbsp;  <?php echo $rec['detail_guest'];?></td>
										   </tr>
										   <tr>
											   <td align="left"  >&nbsp;  <?php echo $text_genguest_column3;?></td>
											   <td align="left"  >&nbsp;  <?php echo $rec['name_guest'];?></td>
										   </tr>
										   <tr>
											   <td align="left"  >&nbsp;  <?php echo $text_genguest_column4;?></td>
											   <td align="left"  >&nbsp;  <?php echo $rec['country_province'];?></td>
										   </tr>
										   <tr>
											   <td align="left"  >&nbsp;  <?php echo $text_genguest_column5;?></td>
											   <td align="left"  >&nbsp;  <?php echo $rec['unit_guest'];?></td>
										   </tr>
										   <tr>
											   <td align="left"  >&nbsp;  <?php echo $text_genguest_column6;?></td>
											   <td align="left"  >&nbsp;  <?php echo $rec['time_guest'];?></td>
										   </tr>
										   <tr>
											   <td align="left"  >&nbsp;  <?php echo $text_genguest_column7;?></td>
											   <td align="left"  >&nbsp;  <?php echo $rec['ip_guest'];?></td>
										   </tr>
										</table>
										
										</td>
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
								<td height="25" colspan="8" valign="top" align="center">
								<input type="button" value="พิมพ์รายงาน" onclick="window.print();">
								<input type="button" value="ปิดหน้านี้" onclick="window.close();">
								</td>
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
