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
      <span class="ewtfunction"><a href="article_admin_stat.php">รายงานการใช้งานข่าว/บทความ</a> >> <?php echo $_GET[search_word];?></span></td>
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
           <td width="100%" bgcolor="#FFFFFF" class="ewttablehead">ระหว่างวันที่ <?php echo $start_date;?>   ถึงวันที่ <?php echo $end_date;?></td>
          </tr>
       </table>
      <br>
</td>
    </form>
  </tr>
</table>
<table width="85%" border="0" align="center">
  <tr>
    <td align="right">[ <a href="##G" onClick="window.open('article_admin_stat_mail.php?flag=2&&search_word=<?=$_GET[search_word]; ?>&&start_date=<?php echo $start_date;?>&&end_date=<?php echo $end_date;?>', 'search_stat_viewdetail', 'status=no, menubar=no, scrollbars=no, resizable=no, height=150, width=300, left=150,top=100');">ส่งเมล์ </a>] [ <a href="article_admin_stat_excel.php?flag=2&&search_word=<?=$_GET[search_word]; ?>&&start_date=<?php echo $start_date;?>&&end_date=<?php echo $end_date;?>" target="_blank" >ส่งออกเป็น excel</a> ] </td>
  </tr>
</table>

<table  width="85%"  border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
	<tr bgcolor="E0DFE3" class="ewttablehead"> 
      <td width="40%" height="18" align="center">ชื่อ</td>
      <td width="30%" align="center">จำนวนบทความ</td>
      <td width="30%" align="center">หน้าที่มีคนเข้าชม</td>
	</tr>
	<?php
	
		if($_GET[start_date] != '' && $_GET[end_date] != '' ){
			$st = stripslashes(htmlspecialchars(trim($_GET[start_date]),ENT_QUOTES));
			$st = explode("/",$st );
			$st = ($st[2] )."-".$st[1]."-".$st[0];
			$et = stripslashes(htmlspecialchars(trim($_GET[end_date]),ENT_QUOTES));
			$et = explode("/",$et );
			$et = ($et[2] )."-".$et[1]."-".$et[0];
			$wh .= " AND  (n_date  between '".$st."' AND '".$et."'  ) and n_owner_org = '".$_GET[search_word]."'";
		}
 $sql = $db->query("SELECT n_owner,count(n_id) as ct FROM article_list WHERE n_approve = 'Y' ".$wh." GROUP BY n_owner ORDER BY n_owner DESC  ");
 			$graph_name = array();
			$graph_data = array();
	while($R = $db->db_fetch_row($sql)){
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" ><a href="article_admin_stat3.php?search_word=<?php echo $_GET[search_word]?>&&n_owner=<?=$R[0]; ?>&&start_date=<?php echo $start_date;?>&&end_date=<?php echo $end_date;?>" ><?php
	  if($R[0] == "0"){
	  echo "Web Admin";
	  			array_push($graph_name,"Web Admin");
				array_push($graph_data,$R[1]);
				$link = "and n_owner ='0'";
	  }else{
	
	$db->query("USE ".$EWT_DB_NAME);
	$sql_user = $db->db_fetch_array($db->query("select * from gen_user where gen_user_id = '".$R[0]."'"));
	$name = $sql_user[name_thai].'  '.$sql_user[surname_thai];
	echo $name;
	$db->query("use ".$EWT_DB_NAME);
				array_push($graph_name,$name);
				array_push($graph_data,$R[1]);
				$link = "and n_owner Like '".$R[0]."'";
	  }
	  $total1 += $R[1];
	  ?></a></td>
      <td align="center" ><?php echo number_format($R[1],0);?></td>
      <td align="center" ><?
	  $sql_nid = $db->query("SELECT  news_view.news_id AS count_view 
FROM article_list INNER JOIN news_view ON (article_list.n_id = news_view.news_id) 
where n_approve = 'Y' 
$wh
$link
GROUP BY news_id ");
	  $G = $db->db_num_rows($sql_nid);
	  echo number_format($G,0);
	  $total2 += $G;
	  ?></td>
    </tr>
    
	<?php } ?>
	<tr bgcolor="#FFFFFF">
      <td height="25" align="right" >รวม</td>
      <td align="center" ><?php echo number_format($total1,0);?></td>
      <td align="center" ><?php echo number_format($total2,0);?></td>
    </tr>
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
</body>
</html>
<?php
$db->db_close(); ?>