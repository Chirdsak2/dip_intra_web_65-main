<?php
include("administrator.php");
include("lib/include.php");
include("inc.php");
include("../language.php");
$db->write_log("view","faq","ดูรายงาน สถิติ FAQ");
 ?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<link href="../css/style_calendar.css" rel="stylesheet" type="text/css">
<script language="JavaScript"  type="text/javascript" src="../js/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../js/calendar-th.js"></script>
</head>
<body leftmargin="0" topmargin="0" class="normal_font">
 <?php include("../FavoritesMgt/favorites_include.php");?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> <span class="ewtfunction"> รายงานจำนวนคำถามเพิ่มเติม </span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="5" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("รายงานจำนวนคำถามเพิ่มเติม");?>&module=faq&url=<?php echo urlencode("faq_stat3.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <hr> </td>
  </tr>
</table>
 <form name="form1" method="post" action="">
<table width="60%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
  <tr>
    <td colspan="2" bgcolor="#FFFFFF" class="ewttablehead">ค้นหา</td>
  </tr>
  <tr>
    <td width="27%" align="right" bgcolor="#FFFFFF">วันที่ทำการค้นหา : </td>
    <td width="73%" bgcolor="#FFFFFF"><input name="start_date" type="text" size="15" value="<?php echo $_POST[start_date];?>" id="start_date">
        <a href="#date" onClick="return showCalendar('start_date', 'dd-mm-y');" ><img src="../images/calendar.gif" width=20 height=20 border=0 align="absmiddle" ></a> ถึง
      <input name="end_date" type="text" size="15"  value="<?php echo $_POST[end_date];?>" id="end_date">
      <a href="#date" onClick="return showCalendar('end_date', 'dd-mm-y');" ><img src="../images/calendar.gif" width=20 height=20 border=0 align="absmiddle" ></a> </td>
  </tr>
  <tr>
    <td align="right" bgcolor="#FFFFFF">เลือกหมวดหมู่ : </td>
    <td bgcolor="#FFFFFF"><?php $sql_faq = $db->query("SELECT * FROM f_subcat  WHERE f_parent='0'"); 
					$fpid = $_POST["fid"];
					function child($id,$tag){
					      global  $db,$fpid;
					      $sql = $db->query("SELECT * FROM f_subcat  WHERE f_parent='$id' "); 
						  while($F=mysql_fetch_array($sql)){
					          ?><option value="<?php echo $F[f_sub_id]; ?>" <?php if($fpid == $F[f_sub_id]){ echo 'selected';}?>><?php echo $tag.$F[f_subcate]; ?></option><?php 
							    $sql_faq = $db->query("SELECT * FROM f_subcat  WHERE f_parent='$F[f_sub_id]' "); 
								if($db->db_num_rows($sql_faq)>0){
								   child($F[f_sub_id],$tag.$tag);
								}
						  } 
					}
					
					?><select name="fid" id="fid">
   <?php while($F=mysql_fetch_array($sql_faq)){ ?>
					<option value="<?php echo $F[f_sub_id]; ?>" <?php if($_POST["fid"]==$F[f_sub_id]){ echo 'selected';}?>><?php echo $F[f_subcate]; ?></option>
					<?php 
					
					    $sql_faq2 = $db->query("SELECT * FROM f_subcat  WHERE f_parent='$F[f_sub_id]' "); 
						if($db->db_num_rows($sql_faq2)>0){
						   child($F[f_sub_id],'&nbsp;&nbsp;&nbsp;&nbsp;');
						}
					
					} ?>
    </select></td>
  </tr>
  <tr>
    <td colspan="2" align="center" bgcolor="#FFFFFF"><input type="submit" name="Submit" value="ค้นหา">
    <input type="hidden" name="flag" value="search"></td>
  </tr>
</table>
</form>
<?php
if($_POST[flag]=='search'){
	$start_date = $_REQUEST["start_date"];
	$end_date = $_REQUEST["end_date"];
	if($start_date == "" AND $end_date == ""){
	$con = "";
	$date_name = "";
	}elseif($start_date != "" AND $end_date == ""){
	$st = explode("/",$start_date);
	$con = " AND (faq_answer.faq_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
	$date_name = "วันที่".$start_date;
	}elseif($start_date == "" AND $end_date != ""){
	$st = explode("/",$end_date);
	$con = " AND (faq_answer.faq_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
	$date_name = "วันที่".$end_date;
	}else{
	$st = explode("/",$start_date);
	$en = explode("/",$end_date);
	$con = " AND (faq_answer.faq_date BETWEEN '".($st[2] -543)."-".$st[1]."-".$st[0]."' AND '".($en[2] - 543)."-".$en[1]."-".$en[0]."') ";
	$date_name = "วันที่".$start_date."ถึง วันที่".$end_date;
	}
$sql_group = $db->query("select * from f_subcat where f_sub_id ='".$_REQUEST[fid]."'");
$RG = $db->db_fetch_array($sql_group);
?>
<table width="95%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#ffffff" >
  <tr>
    <td align="right"><a  href="faq_print3.php?start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>&orderby=<?php echo $orderby;?>&adesc=<?php echo $_REQUEST["adesc"];?>&fid=<?php echo $RG[f_sub_id ];?>" target="_blank" class="ewtfunctionmenu"><img src="../images/windows.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Export to pdf</a>	<a  href="faq_stat3_excel.php?start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>&orderby=<?php echo $orderby;?>&adesc=<?php echo $_REQUEST["adesc"];?>&fid=<?php echo $RG[f_sub_id ];?>&FlagE=excel&flag=<?php echo $_POST[flag];?>" target="_blank" class="ewtfunctionmenu"><img src="../images/windows.gif" width="16" height="16" border="0" align="absmiddle">&nbsp;Export to excel</a></td>
  </tr>
  <tr>
    <td align="center" class="ewtfunction">รายงานจำนวนคำถามเพิ่มเติม หมวด  : <?php echo $RG[f_subcate ];?></td>
  </tr>
  <tr>
    <td align="center" class="ewtfunction"><?php echo $date_name;?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>

<table width="95%" border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#000000" class="ewttableuse">
  <tr  class="ewttablehead">
    <td align="center">คำถาม</td>
    <td width="20%" align="center">จำนวนคำถามเพิ่มเติม</td>
  </tr>
  <?php
$sql="SELECT faq.fa_id,  faq.fa_name,count(faq_answer.faq_user_id) as max  FROM faq LEFT JOIN faq_answer ON faq.fa_id = faq_answer.fa_id   $con WHERE f_sub_id = '".$_REQUEST[fid]."'  GROUP BY faq.fa_id, faq.fa_name ORDER BY max DESC";
$Execsql = $db->query($sql);
 $row = mysql_num_rows($Execsql); 
 while($R = $db->db_fetch_array($Execsql)){

  ?>
    <tr bgcolor="#FFFFFF">
    <td><?php echo $R[fa_name];?></td>
    <td align="center"><?php echo $R["max"];?></td>
  </tr>
<?php } ?>
</table>
<?php
}
?>
</body>
</html>
<?php @$db->db_close(); ?>