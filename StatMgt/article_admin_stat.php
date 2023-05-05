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
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<?
$thisyear = date("Y")+543;
?>
<body leftmargin="0" topmargin="0" >
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">รายงานการใช้งานข่าว/บทความ</span> </td>
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
    <form name="form2" method="post" action="article_admin_stat.php"  onSubmit="return CHK(this)" >
      <td> <table width="60%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
         <tr>
           <td colspan="2" bgcolor="#FFFFFF" class="ewttablehead">ระหว่างวันที่</td>
          </tr>
         <tr>
           <td width="27%" align="right" bgcolor="#FFFFFF">วันที่ :<span class="style1">*</span> </td>
           <td width="73%" bgcolor="#FFFFFF"><input name="start_date" type="text" size="15" value="<?php echo $_POST[start_date];?>">
             <a href="#date" onClick="return showCalendar('start_date', 'dd-mm-y');" ><img src="../images/calendar.gif" width=20 height=20 border=0 align="absmiddle" ></a>
			 ถึงวันที่ <input name="end_date" type="text" size="15" value="<?php echo $_POST[end_date];?>">
             <a href="#date" onClick="return showCalendar('end_date', 'dd-mm-y');" ><img src="../images/calendar.gif" width=20 height=20 border=0 align="absmiddle" ></a></td>
         </tr>
         <tr>
           <td colspan="2" align="center" bgcolor="#FFFFFF"><input type="submit" name="Submit" value="ค้นหา">
            <input type="hidden" name="flag" value="search"><input type="hidden" name="db" value="<?php echo $_REQUEST["db"]; ?>"></td>
          </tr>
       </table>
      <br>
</td>
    </form>
  </tr>
</table> 
<? if($_POST[flag]=='search'){ ?>
<table width="85%" border="0" align="center">
  <tr>
    <td align="right">[ <a href="##G" onClick="window.open('article_admin_stat_mail.php?flag=1&&start_date=<?php echo $start_date;?>&&end_date=<?php echo $end_date;?>', 'search_stat_viewdetail', 'status=no, menubar=no, scrollbars=no, resizable=no, height=150, width=300, left=150,top=100');">ส่งเมล์ </a>] [ <a href="article_admin_stat_excel.php?flag=1&&start_date=<?php echo $start_date;?>&&end_date=<?php echo $end_date;?>" target="_blank" >ส่งออกเป็น excel</a> ] </td>
  </tr>
</table>

<table  width="85%"  border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
	<tr bgcolor="E0DFE3" class="ewttablehead"> 
      <td width="40%" height="18" align="center">หน่วยงาน</td>
      <td width="30%" align="center">จำนวนบทความ</td>
      <td width="30%" align="center">หน้าที่มีคนเข้าชม</td>
	</tr>
	<?php
	
		if($_POST[start_date] != '' && $_POST[end_date] != '' ){
			$st = stripslashes(htmlspecialchars(trim($_POST[start_date]),ENT_QUOTES));
			$st = explode("/",$st );
			$st = ($st[2] )."-".$st[1]."-".$st[0];
			$et = stripslashes(htmlspecialchars(trim($_POST[end_date]),ENT_QUOTES));
			$et = explode("/",$et );
			$et = ($et[2] )."-".$et[1]."-".$et[0];
			$wh .= " AND  (n_date  between '".$st."' AND '".$et."'  ) ";
		}
 $sql = $db->query("SELECT n_owner_org,COUNT(n_id) AS ct FROM article_list WHERE n_approve = 'Y' ".$wh." GROUP BY n_owner_org ORDER BY ct DESC ");
 			$graph_name = array();
			$graph_data = array();
	while($R = $db->db_fetch_row($sql)){
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" ><a href="article_admin_stat2.php?search_word=<?=$R[0]; ?>&&start_date=<?php echo $start_date;?>&&end_date=<?php echo $end_date;?>" ><?php
	  if($R[0] == ""){
	  echo "Web Admin";
	  			array_push($graph_name,"Web Admin");
				array_push($graph_data,$R[1]);
				$link = "and n_owner ='0'";
	  }else{
	echo $R[0];
				array_push($graph_name,$R[0]);
				array_push($graph_data,$R[1]);
				$link = "and n_owner_org Like '".$R[0]."'";
	  }
	  ?></a></td>
      <td align="center" ><?php echo number_format($R[1],0);?></td>
      <td align="center" ><?
	  //set for old
 $db->query("USE db_00_stat_visitor");
 $table = base64_decode ( $_REQUEST["db"]);
  $db_table = explode("EX",$table);
   $sql_list= "select * from list_name where list_id ='".$db_table[0]."' order by list_id ASC";
   $query_list = $db->query($sql_list);
   $R_list = $db->db_fetch_array($query_list);
   $name_list = $R_list["list_name"];
	$sql_nid = $db->query("SELECT  news_view.news_id AS count_view 
FROM article_list INNER JOIN news_view ON (article_list.n_id = news_view.news_id) 
where n_approve = 'Y' 
$wh
$link
GROUP BY news_id ");
	  echo $db->db_num_rows($sql_nid);
	  ?></td>
    </tr>
	<?php } ?>
</table>
<br>
<table  width="80%"  border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
	<tr bgcolor="E0DFE3" class="ewttablehead"> 
      <td  align="center" bgcolor="#FFFFFF"><?php
	  				$graph_height  = "500";
  				$graph_width  = "850";
				$graph_group = "Y";
				$graph_rotate = "";
				include("../ewt_graph_include.php");
	  ?></td>
    </tr>
</table>
<?php

 } ?>
</body>
</html>
<?php
$db->db_close(); ?>