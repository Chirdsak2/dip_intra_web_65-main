<?php
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
	if(t.start_date.value == '' && document.getElementById('show_all').checked==false){
	alert('กรุณาเลือกวันที่ ที่ต้องการ!!!!!!');
	return false;
	}
	if(t.end_date.value == '' && document.getElementById('show_all').checked==false){
	alert('กรุณาเลือกวันที่ ที่ต้องการ!!!!!!');
	return false;
	}
	return true;
}
</script>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<?php
$thisyear = date("Y")+543;
?>
<body leftmargin="0" topmargin="0" >
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">รายงานความนิยนในการดาวน์โหลด</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><hr>
    </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="3" cellspacing="0" class="ewtfunctionmenu">
  <tr> 
    <form name="form2" method="post" action="download_stat.php"  onSubmit="return CHK(this)" >
      <td> <table width="60%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
         <tr>
           <td colspan="2" bgcolor="#FFFFFF" class="ewttablehead">ระหว่างวันที่</td>
          </tr>
         <tr>
           <td width="27%" align="right" bgcolor="#FFFFFF">&nbsp;</td>
           <td width="73%" bgcolor="#FFFFFF"><input type="checkbox" name="show_all" id="show_all" value="all" <?php if($_POST['show_all']) echo 'checked'; ?>/>&nbsp;แสดงทั้งหมด</td>
         </tr>
         <tr>
           <td width="27%" align="right" bgcolor="#FFFFFF">วันที่ :<span class="style1">*</span> </td>
           <td width="73%" bgcolor="#FFFFFF"><input name="start_date" type="text" size="15" value="<?php echo $_POST[start_date];?>">
             <a href="#date" onClick="return showCalendar('start_date', 'dd-mm-y');" ><img src="../images/calendar.gif" width=20 height=20 border=0 align="absmiddle" ></a>
			 ถึงวันที่ <input name="end_date" type="text" size="15" value="<?php echo $_POST[end_date];?>">
             <a href="#date" onClick="return showCalendar('end_date', 'dd-mm-y');" ><img src="../images/calendar.gif" width=20 height=20 border=0 align="absmiddle" ></a></td>
         </tr>
         <tr>
           <td width="27%" align="right" bgcolor="#FFFFFF">หมวด :</td>
           <td width="73%" bgcolor="#FFFFFF"><select name="doc_group" id="doc_group">
           <option value="0">---ทั้งหมด---</option>
<?php
	$qGroup=$db->query('SELECT * FROM docload_group ORDER BY dlg_name ASC');
	while($rGroup=$db->db_fetch_array($qGroup)) {
		if($_POST['doc_group']==$rGroup['dlg_id']) {
			$selected='selected="selected"';
		} else {
			$selected='';
		}
		echo '<option value="'.$rGroup['dlg_id'].'" '.$selected.'>'.$rGroup['dlg_name'].'</option>';
	}
?></select></td>
         </tr>
         <tr>
           <td colspan="2" align="center" bgcolor="#FFFFFF"><input type="submit" name="Submit" value="ค้นหา">
            <input type="hidden" name="flag" value="search"></td>
          </tr>
       </table>
      <br>
</td>
    </form>
  </tr>
</table> 
<?php
echo (!$_POST['show_all'] ==  false);

if($_POST[flag]=='search'){ 
	if($_POST[start_date] != '' && $_POST[end_date]!='' && (!$_POST['show_all'])){
		$st = stripslashes(htmlspecialchars(trim($_POST[start_date]),ENT_QUOTES));
		$st = explode("/",$st );
		$st = ($st[2]-543 )."-".$st[1]."-".$st[0];
		$ed = stripslashes(htmlspecialchars(trim($_POST[end_date]),ENT_QUOTES));
		$ed = explode("/",$ed);
		$ed = ($ed[2]-543 )."-".$ed[1]."-".$ed[0];
		$wh .= "AND (dll.download_log_date BETWEEN '".$st."' AND '".$ed."'  ) ";
	}
	if($_POST['doc_group'] !='0' && $_POST['doc_group'] != '' && (!$_POST['show_all'])){
		$wh.='AND dl.dl_dlgid=\''.$_POST['doc_group'].'\' ';
	}
$sql_article = $db->query("SELECT dll.download_log_date,dl.dl_id, dl.dl_dlgid, count(dll.download_log_id) AS count_view, dl.dl_name, dl.dl_detail FROM docload_log dll, docload_list dl WHERE dl.dl_id = dll.download_log_did $wh GROUP BY dl.dl_id, dl.dl_name ORDER BY count_view DESC");
 
$disabled1='style="display:none"';
$disabled2='style="display:none"';
//if($db->check_permission('art','w','')){ $disabled1='';}
//if($db->check_permission('art','a','')){ $disabled2=''; }

?>
<table  width="85%"   border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="right"><A href="download_stat_excel.php?start_date=<?php echo $_POST[start_date];?>&end_date=<?php echo $_POST[end_date];?>&FlagE=excel&flag=<?php echo $_POST[flag];?>" target="_blank"><IMG height="16" src="../images/windows.gif" width="16" align="absMiddle" border="0"> Export to excel</A> | <a href="javascript:void(0);" onClick="window.print();"><img src="../images/bar_printer.gif" width="20" height="20" border="0" align="absmiddle">   พิมพ์หน้านี้ </a>
	</td>
  </tr>
</table>

<table  width="85%"  border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
    <input type="hidden" name="Flag" value="DelGroup">
    <tr bgcolor="E0DFE3" class="ewttablehead"> 
      <td height="18" align="center">รายชื่อ File / File</td>
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
      <td height="25" style="padding-left:10px;"> 
      <?php echo $G['dl_detail'].'<br/>'.$G['dl_name']?></td>
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