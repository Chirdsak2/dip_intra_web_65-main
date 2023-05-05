<?php
include("administrator.php");
include("inc.php");
include("lib/include.php");


  /*
$db->query("CREATE TABLE `w_question_sts_request` (                                     
                          `request_id` int(4) NOT NULL auto_increment,                              
                          `t_id` int(4) default NULL,                                               
                          `approve_sts` int(4) default '0' COMMENT '0=show,1=hide,2=del,3=cancel',  
                          `request_createdate` datetime default NULL,                               
                          `request_lastdate` datetime default NULL,                                 
                          `requestor_ip` varchar(50) default NULL,                                  
                          PRIMARY KEY  (`request_id`)                                               
                        ) ENGINE=MyISAM AUTO_INCREMENT=3 DEFAULT CHARSET=latin1");
		
$db->query("alter table `w_answer` add column `a_sts` tinyint(1) default '1' NULL  after `a_fign`");
	*/		

$chk_config = $db->query("SELECT * FROM w_config WHERE c_config = '1'");
$CO = mysql_fetch_array($chk_config);

$data = $_REQUEST['data'];
$wcad = $_REQUEST['wcad'];
$flag = $_REQUEST['flag'];
$wrid = $_REQUEST['wrid'];
$waid = $_REQUEST['waid'];
$page = $_REQUEST['page'];

switch($flag) {
	case 'hideTopic':
		$db->query("UPDATE w_question_sts_request SET approve_sts=1,request_lastdate = NOW()  WHERE request_id='$wrid' and request_type='T' ");
		$db->query('UPDATE w_question SET t_sts=2  WHERE t_id=\''.$wtid.'\'');
		break;
	case 'showTopic':
		$db->query("UPDATE w_question_sts_request SET approve_sts=0,request_lastdate = NOW()  WHERE request_id='$wrid' and request_type='T' ");
		$db->query('UPDATE w_question SET t_sts=1 WHERE t_id=\''.$wtid.'\'');
		break;
	case 'delTopic':
		$db->query("UPDATE w_question_sts_request SET approve_sts=2,request_lastdate = NOW()  WHERE request_id='$wrid' and request_type='T' ");
		$db->query('DELETE FROM w_question WHERE t_id=\''.$wtid.'\'');
		$db->query('DELETE FROM w_answer WHERE t_id=\''.$wtid.'\'');
		break;
	case 'cancelTopic':
		$db->query("UPDATE w_question_sts_request SET approve_sts=3,request_lastdate = NOW()  WHERE request_id='$wrid'  ");
		break;
		
		
		
		
		
	case 'hideComment':
		$db->query("UPDATE w_question_sts_request SET approve_sts=1,request_lastdate = NOW()  WHERE request_id='$wrid' and request_type='A' ");
		$db->query('UPDATE w_answer SET a_sts=2 WHERE a_id=\''.$waid.'\'');
		break;
	case 'showComment':
		$db->query("UPDATE w_question_sts_request SET approve_sts=0,request_lastdate = NOW()  WHERE request_id='$wrid' and request_type='A' ");
		$db->query('UPDATE w_answer SET a_sts=1 WHERE a_id=\''.$waid.'\'');
		break;
	case 'delComment':
		$db->query("UPDATE w_question_sts_request SET approve_sts=2,request_lastdate = NOW()   WHERE request_id='$wrid' and request_type='A' ");
		$db->query('DELETE FROM w_answer WHERE a_id=\''.$waid.'\'');
		break;
	case 'cancelComment':
		$db->query("UPDATE w_question_sts_request SET approve_sts=3,request_lastdate = NOW()  WHERE request_id='$wrid'  ");
		break; 
}

	if($page=='topic') {
		$wh.="AND wr.request_type='T' ";
	} else if($page=='comment') {
		$wh.="AND wr.request_type='A' ";
	}
	if (!empty($data)) {
		$wh = "AND (wq.t_name LIKE '%$data%' OR wq.t_detail LIKE '%$data%')";
	}
	$sel = 'SELECT * FROM w_question_sts_request wr LEFT JOIN  w_question wq ON wr.t_id=wq.t_id WHERE (approve_sts=0 OR approve_sts=1) '.$wh.' ORDER BY request_createdate DESC';
	if (empty($offset) || $offset < 0) { 
		$offset=0; 
	}
	//echo $sel;

$limit = $CO[c_number];
if(empty($limit)){
$limit =10;
}
//    Set $totalrows = total number of rows that unlimited query would return 
//    (total number of records to display across all pages) 
$ExecSel = $db->query($sel);
$rows = mysql_num_rows($ExecSel);


	// Set $begin and $end to record range of the current page 
    $begin =($offset+1); 
    $end = ($begin+($limit-1)); 
    if ($end > $totalrows) { 
        $end = $totalrows; 
    } 
$Show = $sel." LIMIT $offset, $limit ";
//echo  $Show;
$Execsql = $db->query($Show); 

?>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0"> 
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td><span class="ewtfunction"><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle">&nbsp;<a href="?page=topic">แจ้งลบกระทู้</a></span>&nbsp;&nbsp;-&nbsp;&nbsp;<span class="ewtfunction"><a href="?page=comment">แจ้งลบความคิดเห็น</a></span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"> 
      <hr>
    </td>
  </tr>
</table>

     <table width="94%" border="0" cellspacing="1" cellpadding="3" align="center">
					 <form method="post" action="?">
									<tr>
									  <td ><input type="hidden" name="curPage" value="1">
										ค้นหาหัวข้อกระทู้
										<input type="text" name="data" value="<?php echo $data;?>">
									  <input type="submit" name="Submit" value="ค้นหา"></td>
									</tr>
					</form>	
	</table>

  <table width="94%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
    <tr align="center" bgcolor="#FFCC99" class="ewttablehead">
      <td width="5%" class="head_font">&nbsp;</td>
      <td class="head_font">หัวข้อกระทู้/ความคิดเห็น</td>
      <td width="10%" class="head_font">ชนิด</td>
      <td width="10%"><?php echo $text_genwebboard_datepost;?></td>
      <td width="10%">IP ผู้ร้องขอ</td>
    </tr>
    <?php
  if($rows > 0){ 
   while($R = mysql_fetch_array($Execsql)){
   $rq_type=$R[request_type]; 
if($rq_type=='T'){
	$hide_flag='hideTopic' ;
	$show_flag='showTopic' ;
	$del_flag='delTopic';
	$cancel_flag='cancelTopic';
	
	$hide_alt='ซ่อนกระทู้' ;
	$show_alt='แสดงกระทู้' ;
	$del_alt='ลบกระทู้' ;
	
	$status_of_request='กระทู้';
}else{
	$hide_flag='hideComment' ;
	$show_flag='showComment' ;
	$del_flag='delComment';
	$cancel_flag='cancelComment';
	
	$hide_alt='ซ่อนความคิดเห็น' ;
	$show_alt='แสดงความคิดเห็น' ;
	$del_alt='ลบความคิดเห็น' ;
	
	$status_of_request='คำตอบ';
}
$cancel_alt='ยกเลิกการพิจารณา';
   ?>
    <tr bgcolor="<?php if($R[s_id] == "1"){ echo "FFFFFF"; }else{ echo "E7E7E7"; } ?>"  onMouseOver="this.style.backgroundColor='<?php if($R[s_id] == "1"){ echo "#FFF3E8"; }else{ echo "CCCCCC"; } ?>'" onMouseOut="this.style.backgroundColor='<?php if($R[s_id] == "1"){ echo "FFFFFF"; }else{ echo "E7E7E7"; } ?>'">
      <td width="6%" align="center" bgcolor="#FFFFFF"><nobody>
<?php
		if($R['approve_sts']=='0') {
?>
			  <a href="?flag=<?php echo $hide_flag ?>&wtid=<?php echo $R[t_id]; ?>&waid=<?php echo $R[a_id]; ?>&wrid=<?php echo $R['request_id']; ?>" onClick="return confirm('คุณแน่ใจที่จะซ่อนรายการนี้');"><img src="../theme/main_theme/g_not_allow.png" width="16" height="16" border="0" title="<?php echo $hide_alt ?>"></a>
			  
	<?php	} else {?>  

      <a href="?flag=<?php echo $show_flag ?>&wtid=<?php echo $R[t_id]; ?>&waid=<?php echo $R[a_id]; ?>&wrid=<?php echo $R['request_id']; ?>" onClick="return confirm('คุณแน่ใจที่จะแสดงรายการนี้');"><img src="../theme/main_theme/g_add_bk.gif" width="16" height="16"  border="0" title="<?php echo $show_alt ?>"></a>
<?php
		}
?>
	  <a href="?flag=<?php echo $del_flag ?>&wtid=<?php echo $R[t_id]; ?>&waid=<?php echo $R[a_id]; ?>&wrid=<?php echo $R['request_id']; ?>" onClick="return confirm('คุณแน่ใจที่จะลบรายการนี้');"><img src="../theme/main_theme/g_del.gif" width="16" height="16"  border="0" title="<?php echo $del_alt ?>"></a>
      <a href="?flag=<?php echo $cancel_flag ?>&wtid=<?php echo $R[t_id]; ?>&waid=<?php echo $R[a_id]; ?>&wrid=<?php echo $R['request_id']; ?>" onClick="return confirm('คุณแน่ใจที่จะยกเลิกรายการนี้');"><img src="../images/bar_enews.gif" title="<?php echo $cancel_alt ?>" width="16" height="16" border="0"></a>

      </nobody> </td>
      <td width="54%" valign="middle" bgcolor="#FFFFFF">
        <?php  //if($page=='' || $page=='topic') { 
		if($rq_type=='T'){
		  echo stripslashes($R[t_name]); 
		} else { 
		   $sql_detail= "SELECT * FROM  w_answer  WHERE a_id='$R[t_id]' ";
		   $query_detail=$db->query($sql_detail);
		   $res_detail=$db->db_fetch_array($query_detail);
		   
		  echo stripslashes($R[t_name].' <br> [ความเห็น] '.$res_detail['a_detail']);
	     }?><br>
       <font color="#FF0000">เหตุผล :  <?php echo $R['request_reason'];?> </font></td>
      <?php $timer = explode("-",date('Y-m-d', strtotime($R['request_createdate']))); $YearT = $timer[0]+543; ?>
      <td align="center" bgcolor="#FFFFFF"><?php echo $status_of_request;?></td>
      <td align="center" bgcolor="#FFFFFF"><?php echo $timer[2]."/".$timer[1]."/".$YearT."<br>".$R[t_time]; ?></td>
      <td align="center" bgcolor="#FFFFFF"><?php echo $R['requestor_ip'];?></td>
    </tr>
    <?php }   
	}?>
	
    <?php if($rows > 0){ ?>
                    <tr bgcolor="#FFFFFF"> 
                      <td height="25" colspan="15" valign="top"><?php echo $text_general_page;?> :
                        <?php
								// Begin Prev/Next Links 
								// Don't display PREV link if on first page 
								if ($offset !=0) {   
								$prevoffset=$offset-$limit; 
								echo   "<a href='$PHP_SELF?offset=$prevoffset&data=$data&wcad=$wcad&flag=$flag&wrad=$wrad&waid=$waid&page=$page'>
								<font  color=\"red\">$text_general_previous</font></a>\n\n";
								}
								$pages = intval($rows/$limit); 
								if ($rows%$limit) { 
										$pages++; 
								} 
								for ($i=1;$i<=$pages;$i++) { 
									if (($offset/$limit) == ($i-1)) { 
											echo "<b>[ $i ] </b>"; 
									} else { 
											$newoffset=$limit * ($i-1); 
											echo  "<a href=\"$PHP_SELF?offset=$newoffset&data=$data&flag=$flag&wrad=$wrad&waid=$waid&page=$page\"". 
											"onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\">$i</font></a>\n\n"; 
									} 
								} 
								if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
										$newoffset=$offset+$limit; 
										echo   "<a href=\"$PHP_SELF?offset=$newoffset&data=$data&flag=$flag&wrad=$wrad&waid=$waid&page=$page\">
										<font color=\"red\">$text_general_next</font></a>"; 
								}
								?>
                      </td>
                    </tr>
                    <?php }else{?>
					<tr bgcolor="#FFFFFF"> 
                      <td height="30" colspan="15"  align="center"><font color="#FF0000"><?php echo $text_general_notfound;?></font></td>
                    </tr>
			<?php }?>
  </table>
</body>
</html>
<?php @$db->db_close(); ?>