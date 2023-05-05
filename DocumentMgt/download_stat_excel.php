<?php
if($_GET["FlagE"] == "excel"){
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition:  filename=fag_excel.xls");
header( 'Content-Description: Download Data' );
header( 'Pragma: no-cache' );
header( 'Expires: 0' );



}
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<link href="../css/style_calendar.css" rel="stylesheet" type="text/css">
<script language="JavaScript"  type="text/javascript" src="../js/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/calendar-th.js"></script>
<script language="javascript1.2">
function CHK(t){
	if(t.start_date.value == ''){
	alert('กรุณาเลือกวันที่ ที่ต้องการ!!!!!!');
	return false;
	}
	if(t.end_date.value == ''){
	alert('กรุณาเลือกวันที่ ที่ต้องการ!!!!!!');
	return false;
	}
	return true;
}
</script>
</head>
<?php
$thisyear = date("Y")+543;
?>
<body leftmargin="0" topmargin="0" >
<?php if($_GET[flag]=='search'){ 
if($_GET[start_date] != '' && $_GET[end_date]!=''){
$st = stripslashes(htmlspecialchars(trim($_GET[start_date]),ENT_QUOTES));
$st = explode("/",$st );
$st = ($st[2]-543 )."-".$st[1]."-".$st[0];
$ed = stripslashes(htmlspecialchars(trim($_GET[end_date]),ENT_QUOTES));
$ed = explode("/",$ed);
$ed = ($ed[2]-543 )."-".$ed[1]."-".$ed[0];
$wh1 .= " (download_log_date  between '".$st."' AND '".$ed."'  ) AND";
$datename = "ระหว่างวันที่ ".$_GET[start_date].'  ถึงวันที่ '.$_GET[start_date];
}

$wh = substr($wh1,0,-3);
if($wh != ''){
$wh = "WHERE " .$wh;
}

$sql_article = $db->query("SELECT docload_list.dl_id,docload_list.dl_dlgid,  count(download_log_id) AS count_view, dl_name
													FROM docload_list  LEFT JOIN docload_log ON (docload_list.dl_id = docload_log.download_log_did) $wh
													GROUP BY docload_list.dl_id,  docload_list.dl_name
								          order by count_view desc  ");
 

 
$disabled1='style="display:none"';
$disabled2='style="display:none"';
//if($db->check_permission('art','w','')){ $disabled1='';}
//if($db->check_permission('art','a','')){ $disabled2=''; }

?>
<table  width="85%"   border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td align="center" colspan="4"> <strong>รายงานความนิยนในการดาวน์โหลด </strong></td>
  </tr>
  <tr>
    <td align="center" colspan="4"><?php echo $datename;?></td>
  </tr>
  <tr>
    <td colspan="4">&nbsp;</td>
  </tr>
</table>

<table  width="85%"  border="1" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
    <input type="hidden" name="Flag" value="DelGroup">
    <tr bgcolor="E0DFE3" class="ewttablehead"> 
      <td height="18" align="center">รายชื่อ File</td>
      <td width="20%" align="center">หมวด</td>
      
    <td width="10%" align="center">จำนวนผู้โหลด</td>
      <td width="10%" align="center">เข้าชมครั้งสุดท้ายวันที่</td>
    </tr>
    <?php
	$i = 0;
	 while($G = $db->db_fetch_array($sql_article)){ 
	 //group article
	 $sql_g = "select * from docload_group where dlg_id = '".$G[dl_dlgid]."'";
	 $query_g = $db->query($sql_g);
	 $rec_g = $db->db_fetch_array($query_g);
	 $groupName = $rec_g[dlg_name];
	 //date view leter
	 $sql_day = "select download_log_date from docload_log where download_log_did = '".$G[dl_id]."' order by download_log_date DESC ";
	 $query_day= $db->query($sql_day);
	 $rec_day= $db->db_fetch_array($query_day);
	 $day = $rec_day[download_log_date];
	  $day = explode('-',$day);
	 $day = $day[2].'/'.$day[1].'/'.($day[0]+543);
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"> 
      <?php echo $G[dl_name]?></td>
      <td height="25"><?php echo $groupName;?></td>
      <td align="center" ><?php echo number_format($G[count_view],0); ?></td>
      <td align="center" ><?php echo $day;?></td>
    </tr>
    <?php $i++; } ?>
    <input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>">
</table>
<?php

 } ?>
</body>
</html>
<?php
$db->db_close(); ?>