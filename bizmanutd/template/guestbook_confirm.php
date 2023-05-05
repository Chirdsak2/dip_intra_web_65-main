<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
$path_cal = "";

 function chg_date_th ($date_input)
{
	   $date = substr($date_input,8,2);
	   $mont= substr($date_input,5,2);
	   $year_en = substr($date_input,0,4);
	   $year=$year_en+543;

	   return $date."/".$mont."/".$year;
}

//#####################replace *** to word  #########################
$sql_vul = " SELECT * FROM vulgar_table ";
$query_vul = mysql_query($sql_vul);
$num_vul  = mysql_num_rows($query_vul);
for($i=1;$i<=$num_vul;$i++){
		$rec = mysql_fetch_array($query_vul);
		$vulels[$i] = $rec['vulgar_text'];		
}
//##############################################################
$chk_config = mysql_query("SELECT * FROM guest_config ");
$CO = mysql_fetch_array($chk_config);


//#########################    Chack Date < guest_config_date ########
$d = date(d) - $CO['guest_config_date'];
$m = date(m);
$y = date(Y);
$today = $y."-".$m."-".date(d);
$chk_date=  date("Y-m-d", mktime(0, 0, 0, $m, $d, $y));
//###############################################################


$sel = "SELECT * FROM guestbook_list  WHERE date_guest BETWEEN '$chk_date' AND ' $today' AND status_guest = 'Y' ORDER BY id_guest DESC";

   if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 
$limit = $CO[guest_config_page];

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

if($check_data != 'yes'){ 
			$yes_chk = 'guestbook.php?check_data=yes'; 
			$indata = 'text';
			$no_chk = "self.location.href='$PHP_SELF';document.frm1.name_guest.value='';document.frm1.comment_guest.value=''; ";
			if(!empty($name_guest))$name_guest = stripslashes(htmlspecialchars($name_guest ,ENT_QUOTES));
			if(!empty($comment_guest))$comment_guest = stripslashes(htmlspecialchars($comment_guest ,ENT_QUOTES));
}else if($check_data == 'yes'){ 
			$yes_chk="guestbook_function.php?name_guest=$name_guest"; 
			$indata = 'hidden';
			$name_guest = stripslashes(htmlspecialchars($name_guest ,ENT_QUOTES));
			$comment_guest = stripslashes(htmlspecialchars($comment_guest ,ENT_QUOTES));
			$name_guest_print   = str_replace($vulels, "***",$name_guest);
			$comment_guest_print  = str_replace($vulels, "***",$comment_guest);
			//##############################################################
			$no_chk = "document.frm1.action='$PHP_SELF' ";
} 
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.styleMe {
font:Verdana, Arial, Helvetica, sans-serif;
color:#000011;
font-size:12px;
}
-->
</style>
</head>
<body leftmargin="0" topmargin="0">

<table width="60%"  border="0" align="center" cellpadding="1" cellspacing="0"><form name="frm1" action="" method="post">  <tr> 
    <td  align='middle' vAlign='top'   bgcolor="#FFFFFF" width="100%" > 
			<table  width="80%" border="0" align="center" cellpadding="1" cellspacing="1"  bgcolor="#666666">
					<tr  bgcolor="#FFFFFF">
							<td bgcolor="#FFCC66" colspan="2" class="styleMe">
									::  สมุดเยี่ยมชม ::							</td>
					</tr>
					<tr  bgcolor="#FFFFFF">
							<td align="right" valign="top" width="35%" class="styleMe">
									ชื่อ&nbsp; :&nbsp;&nbsp;							</td>
							<td align="left" valign="top" width="65%" class="styleMe">
									<?php if($check_data == 'yes')  print $name_guest_print; ?>
									<input name="name_guest" type="<?php echo $indata?>"  value="<?php echo $name_guest?>">&nbsp;							</td>
					</tr>
					<tr  bgcolor="#FFFFFF">
							<td align="right" valign="top" class="styleMe">
								ความคิดเห็น&nbsp; :&nbsp;&nbsp;							</td>
							<td align="left" valign="top" width="65%" class="styleMe">
								<?php if($check_data != 'yes') {?>
											<textarea name="comment_guest" cols="30" rows="5" 
													style="scrollbar-base-color:#FFCC66;" wrap="VIRTUAL" class="normaltxt" id="t_detail"><?php echo $comment_guest?></textarea> 
								<?php }else{ ?>
											<?php echo $comment_guest_print?>
											<input name="comment_guest" type="hidden"  value="<?php echo $comment_guest?>">	&nbsp;
								<?php } ?>							</td>
					</tr>
					<tr  bgcolor="#FFFFFF">
							<td align="center" valign="top" colspan="2">
									<input name="submit" type="submit" value="&nbsp;&nbsp;ยืนยัน&nbsp;&nbsp;" onClick="document.frm1.action='<?php echo $yes_chk?>';">&nbsp;&nbsp;
									<input name="cancle" type="submit" value="&nbsp;&nbsp;ยกเลิก&nbsp;&nbsp;" onClick="<?php echo $no_chk?>">							</td>
				</tr>
	  </table>    </td>
  </tr></form>
</table>

</body>
</html>
<?php
$db->db_close(); ?>
