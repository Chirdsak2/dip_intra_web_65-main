<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition:  filename=form_excel.xls");
header( 'Content-Description: Download Data' );
header( 'Pragma: no-cache' );
header( 'Expires: 0' );
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<?php
$thisyear = date("Y")+543;
?>
<body leftmargin="0" topmargin="0" >
<?php if($_GET[flag]==1){ ?>
<table  width="85%"  border="1" align="center" cellpadding="5" cellspacing="1">
	<tr > 
      <td height="18" colspan="3" align="center" bgcolor="#FFFFFF">
	  <table width="100%" border="0" >
	<tr > 
      <td height="18" colspan="3" align="center" bgcolor="#FFFFFF" >รายงานการ Download ข่าว/บทความ</td>
    </tr>
		<tr > 
      <td height="18" colspan="3" align="center" bgcolor="#FFFFFF" >ระหว่างวันที่ <?php echo $start_date;?>   ถึงวันที่ <?php echo $end_date;?></td>
    </tr>
  <tr > 
    <td bgcolor="#FFFFFF" colspan="3"  align="right"  >วันที่ออกรายงาน <?php echo date('d/m/').$thisyear;?></td>
  </tr>
</table>
</td>
    </tr>
	<tr> 
      <td width="40%" height="18" align="center">หน่วยงาน</td>
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
			$wh .= " AND  (n_date  between '".$st."' AND '".$et."'  ) ";
		}
 $sql = $db->query("SELECT n_owner_org,COUNT(n_id) AS ct FROM article_list WHERE   news_use='4' and n_approve = 'Y' ".$wh." GROUP BY n_owner_org ORDER BY ct DESC ");
 			$graph_name = array();
			$graph_data = array();
	while($R = $db->db_fetch_row($sql)){
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" ><?php
	  if($R[0] == ""){
	  echo "Web Admin";
				$link = "and n_owner ='0'";
	  }else{
	echo $R[0];
				$link = "and n_owner_org Like '".$R[0]."'";
	  }
	  ?></td>
      <td align="center" ><?php echo number_format($R[1],0);?></td>
      <td align="center" ><?php
	  $sql_nid = $db->query("SELECT  news_view.news_id AS count_view 
FROM article_list INNER JOIN news_view ON (article_list.n_id = news_view.news_id) 
where  news_use='4'  and n_approve = 'Y' 
$wh
$link
GROUP BY news_id ");
	  echo $db->db_num_rows($sql_nid);
	  ?></td>
    </tr>
	<?php } ?>
</table>
<?php } ?>
<?php if($_GET[flag]==2){ ?>
<table  width="85%"  border="1" align="center" cellpadding="5" cellspacing="1" >
<tr > 
      <td height="18" colspan="3" align="center" bgcolor="#FFFFFF">
	  <table width="100%" border="0" >
	<tr > 
      <td height="18" colspan="3" align="center" bgcolor="#FFFFFF" >รายงานการ Download ข่าว/บทความ[<?php echo $_GET[search_word];?>]</td>
    </tr>
		<tr > 
      <td height="18" colspan="3" align="center" bgcolor="#FFFFFF" >ระหว่างวันที่ <?php echo $start_date;?>   ถึงวันที่ <?php echo $end_date;?></td>
    </tr>
  <tr > 
    <td bgcolor="#FFFFFF" colspan="3"  align="right"  >วันที่ออกรายงาน <?php echo date('d/m/').$thisyear;?></td>
  </tr>
</table>
</td>
  </tr>
	<tr bgcolor="E0DFE3"> 
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
 $sql = $db->query("SELECT n_owner,count(n_id) as ct FROM article_list WHERE  news_use='4'  and n_approve = 'Y' ".$wh." GROUP BY n_owner ORDER BY n_owner DESC  ");
 			$graph_name = array();
			$graph_data = array();
	while($R = $db->db_fetch_row($sql)){
	?>
    <tr bgcolor="#FFFFFF"> 
      <td height="25" ><?php
	  if($R[0] == "0"){
	  echo "Web Admin";
				$link = "and n_owner ='0'";
	  }else{
	
	$db->query("USE ".$EWT_DB_USER);
	$sql_user = $db->db_fetch_array($db->query("select * from gen_user where gen_user_id = '".$R[0]."'"));
	$name = $sql_user[name_thai].'  '.$sql_user[surname_thai];
	echo $name;
	$db->query("use ".$EWT_DB_NAME);
				$link = "and n_owner Like '".$R[0]."'";
	  }
	  $total1 += $R[1];
	  ?></td>
      <td align="center" ><?php echo number_format($R[1],0);?></td>
      <td align="center" ><?php
	  $sql_nid = $db->query("SELECT  news_view.news_id AS count_view 
FROM article_list INNER JOIN news_view ON (article_list.n_id = news_view.news_id) 
where   news_use='4'  and n_approve = 'Y' 
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
<?php } ?>
<?php if($_GET[flag]==3){ 

$db->query("USE ".$EWT_DB_USER);
	$sql_user = $db->db_fetch_array($db->query("select * from gen_user where gen_user_id = '".$_GET[n_owner]."'"));
	$name = $sql_user[name_thai].'  '.$sql_user[surname_thai];
	
	$db->query("use ".$EWT_DB_NAME);
?>
<table  width="94%"  border="1" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
  <tr >
    <td height="18" colspan="4" align="center" bgcolor="#FFFFFF"><table width="100%" border="0" >
      <tr >
        <td height="18" colspan="4" align="center" bgcolor="#FFFFFF" >รายงานการ Download ข่าว/บทความ[<?php echo $_GET[search_word];?>]</td>
      </tr>
	  <tr >
        <td height="18" colspan="4" align="center" bgcolor="#FFFFFF" >[<?php echo $name;?>]</td>
      </tr>
      <tr >
        <td height="18" colspan="4" align="center" bgcolor="#FFFFFF" >ระหว่างวันที่ <?php echo $start_date;?> ถึงวันที่ <?php echo $end_date;?></td>
      </tr>
      <tr >
        <td bgcolor="#FFFFFF" colspan="4"  align="right"  >วันที่ออกรายงาน <?php echo date('d/m/').$thisyear;?></td>
      </tr>
    </table></td>
  </tr>
  <input type="hidden" name="Flag" value="DelGroup">
  <tr bgcolor="E0DFE3" class="ewttablehead">
    <td height="18" align="center">ชื่อข่าว/บทความ</td>
    <td width="20%" align="center">หมวด</td>
    <td width="10%" align="center">จำนวนผู้อ่าน</td>
    <td width="10%" align="center">เข้าชมครั้งสุดท้ายวันที่</td>
  </tr>
  <?php
  if($_GET[start_date] != '' && $_GET[end_date]!=''){
$st = stripslashes(htmlspecialchars(trim($_GET[start_date]),ENT_QUOTES));
$st = explode("/",$st );
$st = ($st[2] )."-".$st[1]."-".$st[0];
$ed = stripslashes(htmlspecialchars(trim($_GET[end_date]),ENT_QUOTES));
$ed = explode("/",$ed);
$ed = ($ed[2] )."-".$ed[1]."-".$ed[0];
$wh1 .= "  (article_list.n_date  between '".$st."' AND '".$ed."'  ) AND";
}

$wh = substr($wh1,0,-3);
if($wh != ''){
$wh = "WHERE " .$wh."  and   news_use='4'  and n_owner =".$_GET[n_owner];
}
$sql_article = $db->query("SELECT news_view.news_id, count(news_view.id_view) AS count_view, article_list.n_topic,c_id
													FROM article_list  INNER JOIN news_view ON (article_list.n_id = news_view.news_id) $wh
													GROUP BY news_view.news_id,  article_list.n_topic
								          order by count_view desc  ");
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
    <td height="25"><?php echo $G[n_topic]?></td>
    <td height="25"><?php echo $groupName;?></td>
    <td align="center" ><?php echo number_format($G[count_view],0); ?></td>
    <td align="center" ><?php echo $day;?></td>
  </tr>
  <?php $i++; }} ?>
  <input name="alli" type="hidden" id="alli" value="<?php echo $i; ?>">
</table>
<?php } ?>
</body>
</html>
<?php
$db->db_close(); ?>