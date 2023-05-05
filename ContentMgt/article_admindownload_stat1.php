<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("update article_list set n_owner_org = '' where n_owner = '0'");

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
<?php
$thisyear = date("Y")+543;
?>
<body leftmargin="0" topmargin="0" >
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/article_logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">รายงานการ Download ข่าว/บทความ</span> </td>
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
    <form name="form2" method="post" action="article_admindownload_stat.php"  onSubmit="return CHK(this)" >
      <td> <table width="60%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
         <tr>
           <td colspan="2" bgcolor="#FFFFFF" class="ewttablehead">ระหว่างวันที่</td>
          </tr>
         <tr>
           <td width="27%" align="right" bgcolor="#FFFFFF">วันที่ :<span class="style1">*</span> </td>
           <td width="73%" bgcolor="#FFFFFF"><input name="start_date" type="text" size="15" value="<?php echo $_GET[start_date];?>">
             <a href="#date" onClick="return showCalendar('start_date', 'dd-mm-y');" ><img src="../images/calendar.gif" width=20 height=20 border=0 align="absmiddle" ></a>
			 ถึงวันที่ <input name="end_date" type="text" size="15" value="<?php echo $_GET[end_date];?>">
             <a href="#date" onClick="return showCalendar('end_date', 'dd-mm-y');" ><img src="../images/calendar.gif" width=20 height=20 border=0 align="absmiddle" ></a></td>
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
<!--table width="85%" border="0" align="center">
  <tr>
    <td align="right">[ <a href="##G" onClick="window.open('article_admindownload_stat_mail.php?flag=1&&start_date=<?php echo $start_date;?>&&end_date=<?php echo $end_date;?>', 'search_stat_viewdetail', 'status=no, menubar=no, scrollbars=no, resizable=no, height=150, width=300, left=150,top=100');">ส่งเมล์ </a>] [ <a href="article_admin_stat_excel.php?flag=1&&start_date=<?php echo $start_date;?>&&end_date=<?php echo $end_date;?>" target="_blank" >ส่งออกเป็น excel</a> ] </td>
  </tr>
</table-->

<table  width="85%"  border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
	<tr bgcolor="E0DFE3" class="ewttablehead"> 
      <td width="40%" height="18" align="center">หน่วยงาน</td>
      <td width="30%" align="center">จำนวนบทความ</td>
      
    <td width="30%" align="center">หน้าที่มีคนโหลด</td>
	</tr>
	<?php
	
		if($_GET[start_date] != '' && $_GET[end_date] != '' ){
			$st = stripslashes(htmlspecialchars(trim($_GET[start_date]),ENT_QUOTES));
			$st = explode("/",$st );
			$st = ($st[2] )."-".$st[1]."-".$st[0];
			$et = stripslashes(htmlspecialchars(trim($_GET[end_date]),ENT_QUOTES));
			$et = explode("/",$et );
			$et = ($et[2] )."-".$et[1]."-".$et[0];
			$wh .= " AND  (n_date  between '".$st."' AND '".$et."'  )  AND n_owner_org like '$_GET[search_word]' ";
		}
 $sql = $db->query("SELECT n_owner_org,COUNT(n_id) AS ct FROM article_list WHERE news_use='4' and n_approve = 'Y' ".$wh." GROUP BY n_owner_org ORDER BY ct DESC ");
 			$graph_name = array();
			$graph_data = array();
	while($R = $db->db_fetch_row($sql)){
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" ><a href="article_admindownload_stat2.php?search_word=<?php echo $R[0]; ?>&&start_date=<?php echo $start_date;?>&&end_date=<?php echo $end_date;?>" ><?php
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
      <td align="center" ><?php
	  $sql_nid = $db->query("SELECT  news_view.news_id AS count_view 
FROM article_list INNER JOIN news_view ON (article_list.n_id = news_view.news_id) 
where news_use='4' and  n_approve = 'Y' 
$wh
$link
GROUP BY news_id ");
	  echo $db->db_num_rows($sql_nid);
	  ?></td>
    </tr>
	<?php } ?>
</table>
<br>








<?php 


if($_GET[start_date] != '' && $_GET[end_date]!=''){
$st = stripslashes(htmlspecialchars(trim($_GET[start_date]),ENT_QUOTES));
$st = explode("/",$st );
$st = ($st[2] )."-".$st[1]."-".$st[0];
$ed = stripslashes(htmlspecialchars(trim($_GET[end_date]),ENT_QUOTES));
$ed = explode("/",$ed);
$ed = ($ed[2] )."-".$ed[1]."-".$ed[0];
$wh1 .= " (article_list.n_date  between '".$st."' AND '".$ed."'  ) AND";
}

$wh = substr($wh1,0,-3);
if($wh != ''){
$wh = "WHERE " .$wh."  and  news_use='4'  AND n_owner_org like '$_GET[search_word]'  ";
}
$sql_article = $db->query("SELECT news_view.news_id, count(news_view.id_view) AS count_view, article_list.n_topic,c_id
													FROM article_list  LEFT JOIN news_view ON (article_list.n_id = news_view.news_id) $wh
													GROUP BY news_view.news_id,  article_list.n_topic
								          order by count_view desc  ");
 

 
$disabled1='style="display:none"';
$disabled2='style="display:none"';
if($db->check_permission('art','w','')){ $disabled1='';}
if($db->check_permission('art','a','')){ $disabled2=''; }
$db->query("USE ".$_SESSION["EWT_SDB"]);
$db->query("USE ".$EWT_DB_USER);
	$sql_user = $db->db_fetch_array($db->query("select * from gen_user "));
	$name = $sql_user[name_thai].'  '.$sql_user[surname_thai];
	
	$db->query("use ".$EWT_DB_NAME);
?>
<!--table width="85%" border="0" align="center">
  <tr>
    <td align="right">[ <a href="##G" onClick="window.open('article_admindownload_stat_mail.php?flag=3&n_owner=<?php echo $_GET[n_owner]; ?>&start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>', 'search_stat_viewdetail', 'status=no, menubar=no, scrollbars=no, resizable=no, height=150, width=300, left=150,top=100');">ส่งเมล์ </a>][ <a href="article_admin_stat_excel.php?flag=3&&search_word=<?php echo $_GET[search_word]; ?>&&n_owner=<?php echo $_GET[n_owner]; ?>&&start_date=<?php echo $start_date;?>&&end_date=<?php echo $end_date;?>" target="_blank" >ส่งออกเป็น excel</a> ] </td>
  </tr>
</table-->
<table  width="85%"  border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
    <input type="hidden" name="Flag" value="DelGroup">
    <tr bgcolor="E0DFE3" class="ewttablehead"> 
      <td height="18" align="center">ชื่อข่าว/บทความ</td>
      <td width="20%" align="center">หมวด</td>
      
    <td width="10%" align="center">จำนวนผู้โหลด</td>
      <td width="10%" align="center">เข้าชมครั้งสุดท้ายวันที่</td>
    </tr>
    <?php
	$i = 0;
	 while($G = $db->db_fetch_array($sql_article)){ 
	 if($db->check_permission("Ag","",$G[c_id])){
	 //group article
	 $sql_g = "select * from article_group where c_id = '".$G[c_id]."'";
	 $query_g = $db->query($sql_g);
	 $rec_g = $db->db_fetch_array($query_g);
	 $groupName = $rec_g[c_name];
	 //date view leter
	 $sql_day = "select date_view from news_view where news_id = '".$G[news_id]."' order by date_view DESC ";
	 $query_day= $db->query($sql_day);
	 $rec_day= $db->db_fetch_array($query_day);
	 $day = $rec_day[date_view];
	  $day = explode('-',$day);
	 $day = $day[2].'/'.$day[1].'/'.($day[0]+543);
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25"> 
      <?php echo $G[n_topic]?></td>
      <td height="25"><?php echo $groupName;?></td>
      <td align="center" ><?php echo number_format($G[count_view],0); ?></td>
      <td align="center" ><?php echo $day;?></td>
    </tr>
    <?php $i++; }} ?>
    <input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>">
</table>

</body>
</html>
<?php
$db->db_close(); ?>