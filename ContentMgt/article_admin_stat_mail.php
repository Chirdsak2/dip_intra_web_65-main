<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
if($_POST[sent_now]=='sent'){
$thisyear = date("Y")+543;
	if($_POST[flag]=='1'){
	$body ='<html>
						<head>
						<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
						</head><body leftmargin="0" topmargin="0" ><table  width="85%"  border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#000000">
							<tr > 
							  <td height="18" colspan="3" align="center" bgcolor="#FFFFFF">
							  <table width="100%" border="0" >
							<tr > 
							  <td height="18" colspan="3" align="center" bgcolor="#FFFFFF" >รายงานการใช้งานข่าว/บทความ</td>
							</tr>
								<tr > 
							  <td height="18" colspan="3" align="center" bgcolor="#FFFFFF" >ระหว่างวันที่ '.$start_date.' ถึงวันที่ '.$end_date.'</td>
							</tr>
						  <tr > 
							<td bgcolor="#FFFFFF" colspan="3"  align="right"  >วันที่ออกรายงาน '.date('d/m/').$thisyear.'</td>
						  </tr>
						</table>
						</td>
							</tr>
							<tr bgcolor="#FFFFFF"> 
							  <td width="40%" height="18" align="center">หน่วยงาน</td>
							  <td width="30%" align="center">จำนวนบทความ</td>
							  <td width="30%" align="center">หน้าที่มีคนเข้าชม</td>
							</tr>';
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
    		$body .='<tr bgcolor="#FFFFFF"> <td height="25" >';
	  if($R[0] == ""){
	  		$body .='Web Admin';
				$link = "and n_owner ='0'";
	  }else{
			$body .=$R[0];
				$link = "and n_owner_org Like '".$R[0]."'";
	  }
		   $body .='</td>
		  <td align="center" >'.number_format($R[1],0).'</td>
		  <td align="center" >';
	  $sql_nid = $db->query("SELECT  news_view.news_id AS count_view 
FROM article_list INNER JOIN news_view ON (article_list.n_id = news_view.news_id) 
where n_approve = 'Y' 
$wh
$link
GROUP BY news_id ");
	   $body .= $db->db_num_rows($sql_nid);
 		$body .='</td></tr>';
	 } 
 		$body .='</table></body></html>';

		
		//set mail
		$to  =$_POST[email_user];
		$subject = "รายงานการใช้งานข่าว/บทความ";
		/* To send HTML mail, you can set the Content-type header. */
		$headers  = "MIME-Version: 1.0\r\n";
		 $headers .= "Content-Type: text/html; charset='UTF-8' \r\n"; 
		/* additional headers */
		$headers .= "From: ".$_POST[user_mail]."\r\n";
		
		/* and now mail it */
		@mail($to, $subject, $body, $headers);
	}//end if flag == 1
	if($_POST[flag]=='2'){
			$body ='<html>
						<head>
						<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
						</head><body leftmargin="0" topmargin="0" ><table  width="85%"  border="0" align="center" cellpadding="5" cellspacing="1" bgcolor="#000000">
							<tr > 
								  <td height="18" colspan="3" align="center" bgcolor="#FFFFFF">
								  <table width="100%" border="0" >
								<tr > 
								  <td height="18" colspan="3" align="center" bgcolor="#FFFFFF" >รายงานการใช้งานข่าว/บทความ['.$_POST[search_word].']</td>
								</tr>
									<tr > 
								  <td height="18" colspan="3" align="center" bgcolor="#FFFFFF" >ระหว่างวันที่ '.$start_date.' ถึงวันที่ '.$end_date.'</td>
								</tr>
							  <tr > 
								<td bgcolor="#FFFFFF" colspan="3"  align="right"  >วันที่ออกรายงาน '. date('d/m/').$thisyear.'</td>
							  </tr>
							</table>
							</td>
							  </tr>
								<tr bgcolor="FFFFFF"> 
								  <td width="40%" height="18" align="center">ชื่อ</td>
								  <td width="30%" align="center">จำนวนบทความ</td>
								  <td width="30%" align="center">หน้าที่มีคนเข้าชม</td>
								</tr>';
								
									if($_POST[start_date] != '' && $_POST[end_date] != '' ){
										$st = stripslashes(htmlspecialchars(trim($_POST[start_date]),ENT_QUOTES));
										$st = explode("/",$st );
										$st = ($st[2] )."-".$st[1]."-".$st[0];
										$et = stripslashes(htmlspecialchars(trim($_POST[end_date]),ENT_QUOTES));
										$et = explode("/",$et );
										$et = ($et[2] )."-".$et[1]."-".$et[0];
										$wh .= " AND  (n_date  between '".$st."' AND '".$et."'  ) and n_owner_org = '".$_POST[search_word]."'";
									}
							 $sql = $db->query("SELECT n_owner,count(n_id) as ct FROM article_list WHERE n_approve = 'Y' ".$wh." GROUP BY n_owner ORDER BY n_owner DESC  ");
										$graph_name = array();
										$graph_data = array();
								while($R = $db->db_fetch_row($sql)){
								$body .='<tr bgcolor="#FFFFFF"> <td height="25" >';
								    if($R[0] == "0"){
								  $body .='Web Admin';
											$link = "and n_owner ='0'";
								  }else{
								
								$db->query("USE ".$EWT_DB_USER);
								$sql_user = $db->db_fetch_array($db->query("select * from gen_user where gen_user_id = '".$R[0]."'"));
								$name = $sql_user[name_thai].'  '.$sql_user[surname_thai];
								$body .=$name;
								$db->query("use ".$EWT_DB_NAME);
											$link = "and n_owner Like '".$R[0]."'";
								  }
								  $total1 += $R[1];
								$body .='</td>
								  <td align="center" >'. number_format($R[1],0).'</td><td align="center" >';
								  $sql_nid = $db->query("SELECT  news_view.news_id AS count_view 
							FROM article_list INNER JOIN news_view ON (article_list.n_id = news_view.news_id) 
							where n_approve = 'Y' 
							$wh
							$link
							GROUP BY news_id ");
								  $G = $db->db_num_rows($sql_nid);
								$body .= number_format($G,0);
								  $total2 += $G;
								  $body .='</td></tr>'; 
							} 
								$body .='<tr bgcolor="#FFFFFF">
								  <td height="25" align="right" >รวม</td>
								  <td align="center" >'.number_format($total1,0).'</td>
								  <td align="center" >'.number_format($total2,0).'</td>
								</tr>
							</table></body></html>';
					//set mail
		$to  =$_POST[email_user];
		$subject = "รายงานการใช้งานข่าว/บทความ";
		/* To send HTML mail, you can set the Content-type header. */
		$headers  = "MIME-Version: 1.0\r\n";
		 $headers .= "Content-Type: text/html; charset='UTF-8' \r\n"; 
		/* additional headers */
		$headers .= "From: ".$_POST[user_mail]."\r\n";
		
		/* and now mail it */
		@mail($to, $subject, $body, $headers);
	}
	if($_POST[flag]=='3'){
	$db->query("USE ".$EWT_DB_USER);
	$sql_user = $db->db_fetch_array($db->query("select * from gen_user where gen_user_id = '".$_POST[n_owner]."'"));
	$name = $sql_user[name_thai].'  '.$sql_user[surname_thai];
	
	$db->query("use ".$EWT_DB_NAME);
				$body ='<html>
						<head>
						<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
						</head><body leftmargin="0" topmargin="0" ><table  width="94%"  border="1" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
							  <tr >
								<td height="18" colspan="4" align="center" bgcolor="#FFFFFF"><table width="100%" border="0" >
								  <tr >
									<td height="18" colspan="4" align="center" bgcolor="#FFFFFF" >รายงานการใช้งานข่าว/บทความ['.$_POST[search_word].']</td>
								  </tr>
								  <tr >
									<td height="18" colspan="4" align="center" bgcolor="#FFFFFF" >['.$name.']</td>
								  </tr>
								  <tr >
									<td height="18" colspan="4" align="center" bgcolor="#FFFFFF" >ระหว่างวันที่ '.$start_date.' ถึงวันที่ '.$end_date.'</td>
								  </tr>
								  <tr >
									<td bgcolor="#FFFFFF" colspan="4"  align="right"  >วันที่ออกรายงาน '.date('d/m/').$thisyear.'</td>
								  </tr>
								</table></td>
							  </tr>
							  <input type="hidden" name="Flag" value="DelGroup">
							  <tr bgcolor="E0DFE3" class="ewttablehead">
								<td height="18" align="center">ชื่อข่าว/บทความ</td>
								<td width="20%" align="center">หมวด</td>
								<td width="10%" align="center">จำนวนผู้อ่าน</td>
								<td width="10%" align="center">เข้าชมครั้งสุดท้ายวันที่</td>
							  </tr>';
							  if($_POST[start_date] != '' && $_POST[end_date]!=''){
							$st = stripslashes(htmlspecialchars(trim($_POST[start_date]),ENT_QUOTES));
							$st = explode("/",$st );
							$st = ($st[2] )."-".$st[1]."-".$st[0];
							$ed = stripslashes(htmlspecialchars(trim($_POST[end_date]),ENT_QUOTES));
							$ed = explode("/",$ed);
							$ed = ($ed[2] )."-".$ed[1]."-".$ed[0];
							$wh1 .= "  (article_list.n_date  between '".$st."' AND '".$ed."'  ) AND";
							}
							
							$wh = substr($wh1,0,-3);
							if($wh != ''){
							$wh = "WHERE " .$wh."  and  n_owner =".$_POST[n_owner];
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
							  $body .='<tr bgcolor="#FFFFFF">
								<td height="25">'.$G[n_topic].'</td>
								<td height="25">'.$groupName.'</td>
								<td align="center" >'.number_format($G[count_view],0).'</td>
								<td align="center" >'.$day.'</td>
							  </tr>';
							 $i++; }}
							 $body .=' <input name="alli" type="hidden" id="alli" value="'.$i.'">
							</table></body></html>';
					//set mail
		$to  =$_POST[email_user];
		$subject = "รายงานการใช้งานข่าว/บทความ";
		/* To send HTML mail, you can set the Content-type header. */
		$headers  = "MIME-Version: 1.0\r\n";
		 $headers .= "Content-Type: text/html; charset='UTF-8' \r\n"; 
		/* additional headers */
		$headers .= "From: ".$_POST[user_mail]."\r\n";
		
		/* and now mail it */
		@mail($to, $subject, $body, $headers);
	}
}else{
?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
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
<form name="form1" method="post" action="article_admin_stat_mail.php">
  <table width="300" border="0" class="ewtnormal">
    <tr>
      <td height="33" colspan="2"><p class="ewtsubmenu"><strong><img src="../images/arrow_r.gif" width="7" height="7"> ส่งรายงานการใช้งานข่าว/บทความทางอีเมล์</strong></p></td>
    </tr>
    <tr>
      <td width="29%" align="right" valign="top">e-mail ผู้รับ : <br></td>
      <td width="71%"><textarea name="email_user" cols="25" rows="5"><?php
	  if($_SESSION["EWT_SMID"] != ''){$db->query("USE ".$EWT_DB_USER);
	$sql_user = $db->db_fetch_array($db->query("select * from gen_user where gen_user_id = '".$_SESSION["EWT_SMID"]."'"));
	echo  $name = $sql_user[email_person];
	$db->query("use ".$EWT_DB_NAME);}
	  ?></textarea></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><span class="style1">[กรณีที่ต้องการ
        ส่งหลายคนให้คั่น
        ด้วยเครื่องหมาย ; ]</span></td>
    </tr>
    <tr>
      <td colspan="2" align="center"><input type="submit" name="Submit" value="    ส่ง    ">
          <input name="start_date" type="hidden" value="<?php echo $_GET[start_date];?>" size="5">
      <input name="end_date" type="hidden" value="<?php echo $_GET[end_date];?>" size="5">
      <input name="flag" type="hidden"  value="<?php echo $_GET[flag];?>" size="5">
      <input name="search_word" type="hidden" value="<?php echo $_GET[search_word];?>" size="5">
      <input name="n_owner" type="hidden" value="<?php echo $_GET[n_owner];?>" size="5">
	  <input name="sent_now" type="hidden" value="sent" size="5">
	  <input name="user_mail" type="hidden" value="<?php echo $name;?>" size="5"></td>
    </tr>
  </table>
</form>
</body>
</html>
<?php
}
$db->db_close(); ?>