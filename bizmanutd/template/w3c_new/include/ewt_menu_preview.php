<?php
function random_code($len){
			srand((double)microtime()*10000000);
			$chars = "ABCDEFGHJKMNPQRSTUVWXYZabcdefghijkmnpqrstuvwxyz123456789";
			$ret_str = "";
			$num = strlen($chars);
			for($i=0;$i<$len;$i++){
				$ret_str .= $chars[rand()%$num];
			}
			return $ret_str;
}
function GenLen($data,$op){
$s = explode($op,$data);
return count($s);
}
function child($level,$m_id){
global $db;
global $filename;
$lev = $level+1;
	$sql1 = $db->query("SELECT * FROM menu_properties WHERE mp_id LIKE '".$m_id."_%'  ORDER BY mp_id ASC");
	if($R[glo_showsub]=="Y" && $R[glo_highlight]=="Y"){ 
		$show_id=3; 
	}  else if($R[glo_showsub]=="Y" && $R[glo_highlight]==""){ 
		$show_id=1; 
	}  else {
		$show_id=0; 
	}
	$show_trans=100-$R[pop_trans];
	if($filename != ''){
	$filenmae_link = '&amp;filename='.$filename;
	}
	$memu_list_id = array();
	$memu_list_name = array();
	$memu_list_Glink = array();
		while($RR=$db->db_fetch_array($sql1)){
		$len = GenLen($RR[mp_id],"_");
			if($len == $lev ){
			array_push($memu_list_id,$RR[mp_id]);
			$MPNAME = urlencode($RR[mp_name]);
			$MPNAME = eregi_replace("%A0"," ",$MPNAME);
			$MPNAME1 = urldecode($MPNAME);
			array_push($memu_list_name,$MPNAME1);
			array_push($memu_list_Glink,$RR[Glink]);
			}
		}
		$num_row = count($memu_list_id);
		if($num_row > 0){
		echo '<ul>';
		for($i=0;$i<$num_row;$i++){
		?><li><?php if($memu_list_Glink[$i] != ''){ ?><a href="<?php echo $memu_list_Glink[$i];?>"><?php }?><?php echo $memu_list_name[$i];?><?php if($memu_list_Glink[$i] != ''){ ?></a><?php }?></li><?php echo child($lev,$memu_list_id[$i]);?>
			<?php
		}
		echo '</ul>';
		}
}
function GenMenu($m_id){
	global $db;
	global $filename;
	
	$sql = $db->query("SELECT * FROM menu_list WHERE m_id = '".$m_id."' ");
	$R = $db->db_fetch_array($sql);
	$sql1 = $db->query("SELECT * FROM menu_properties WHERE m_id = '".$m_id."' ORDER BY mp_id ASC");
	if($R[glo_showsub]=="Y" && $R[glo_highlight]=="Y"){ 
		$show_id=3; 
	}  else if($R[glo_showsub]=="Y" && $R[glo_highlight]==""){ 
		$show_id=1; 
	}  else {
		$show_id=0; 
	}
	$show_trans=100-$R[pop_trans];
	if($filename != ''){
	$filenmae_link = '&amp;filename='.$filename;
	}
	//cese นอน
	$memu_list_id = array();
	$memu_list_name = array();
	$memu_list_Glink = array();
		while($RR=$db->db_fetch_array($sql1)){
		$len = GenLen($RR[mp_id],"_");
			if($len == '2' ){
			array_push($memu_list_id,$RR[mp_id]);
			$MPNAME = urlencode($RR[mp_name]);
			$MPNAME = eregi_replace("%A0"," ",$MPNAME);
			$MPNAME1 = urldecode($MPNAME);
			array_push($memu_list_name,$MPNAME1);
			array_push($memu_list_Glink,$RR[Glink]);
			}
		}
		$num_row = count($memu_list_id);
		//echo $R[pop_display];
	if($R[pop_display]=='0'){
	
	?><table width="100%" border="0"><?php
		for($i=0;$i<$num_row;$i++){
			if($i%$num_row == 0 ) {?> <tr valign="top"><?php }?>
				<td ><?php if($memu_list_Glink[$i] != ''){ ?><a href="<?php echo $memu_list_Glink[$i];?>"><?php }?><?php echo trim($memu_list_name[$i]);?><?php if($memu_list_Glink[$i] != ''){ ?></a><?php }?><?php echo child('2',$memu_list_id[$i]);?></td>
			  <?php  if($i%$num_row == ($num_row-1)) {?> </tr> <?php }?>
			<?php
		}
		?></table><?php
	}else if($R[pop_display]=='1'){//ตั้ง
			?><table width="100%" border="0"><?php
			if($num_row > 0){
		for($i=0;$i<$num_row;$i++){
			?> <tr valign="top">
				<td ><?php if($memu_list_Glink[$i] != ''){ ?><a href="<?php echo $memu_list_Glink[$i];?>"><?php }?><?php echo trim($memu_list_name[$i]);?><?php if($memu_list_Glink[$i] != ''){ ?></a><?php }?><?php echo child('2',$memu_list_id[$i]);?></td>
			   </tr>
			<?php
		}
		}
		?></table><?php
	}
}
function GenBanner($banner_gid,$BID){
	global $db;
	global $mainwidth;
	global $global_theme;
	global $lang_sh;
	if($banner_gid!=''){
	$sql = $db->query("select block_themes from block where BID = '".$BID."' ");
	$rec = $db->db_fetch_array($sql);
	 //banner
	$query_set = $db->query("SELECT * FROM banner_setting where  BID = '$BID'");
    $rs_set = $db->db_fetch_array($query_set);
	if($db->db_num_rows($query_set )>0 && $rs_set[banner_show] != ''){
	$date_now = (date('Y')+ 543).'-'.date('m-d');
	$wh = "and ((banner_show_start = '' and banner_show_end = '')";
	$wh .= "or ('".$date_now."' between banner_show_start and banner_show_end))";
    if($rs_set[banner_type]=='R'){
   $sql_banner = "SELECT * FROM banner where banner_gid = '$banner_gid' $wh ORDER BY RAND() LIMIT ".$rs_set[banner_rand_row];
   }else{
    $sql_banner = "SELECT * FROM banner WHERE banner_id IN (".$rs_set[banner_show].") and banner_gid = '$banner_gid' $wh ORDER BY banner_position";
   }
   $query_banner = $db->query($sql_banner);
	$num_banner = $db->db_num_rows($query_banner);
	if($num_banner > 0){
             $k=1;
	 ?>
	 <table width="100%" border="0">
	 <?php
	while($rs_banner = $db->db_fetch_array($query_banner)){
				if(eregi("www", $rs_banner[banner_link]) AND !eregi("http://", $rs_banner[banner_link])){
					$link = "http://".$rs_banner[banner_link];
				}else{
					 $link = $rs_banner[banner_link];	
				}
				$wi='97%';
				$hi='38';
				if( $rs_set[banner_height]){   $sizes='height="'.trim($rs_set[banner_height]).'"'; }
				if( $rs_set[banner_width]){   $sizes.=' width="'.trim($rs_set[banner_width]).'"'; }
				 if($rs_banner[banner_traget] != ''){$target = $rs_banner[banner_traget];}else{ $target = '_blank';}
				  if($rs_set[banner_view]=='V'){ 
				  ?>
				   <tr>
			<td><a href="<?php echo $link?>"  target="<?php echo $target;?>" ><img src="../<?php echo $rs_banner[banner_pic]?>" border="0" <?php echo $sizes;?> alt="<?php echo $rs_banner[banner_alt]?>"></a></td>
		  </tr>
				  <?php
				  }else{
				  if($k%$rs_set[banner_rand_max]==1){ ?><tr><?php } 
				  ?><td align="center" ><a href="<?php echo $link?>"  target="<?php echo $target;?>" ><img src="../<?php echo $rs_banner[banner_pic]?>" border="0" <?php echo $sizes;?> alt="<?php if($rs_banner[banner_alt] != ''){echo $rs_banner[banner_alt];}else{ echo $rs_banner[banner_pic];}?>"></a></td><?php
				    if($k%$rs_set[banner_rand_max]==0){ ?></tr><?php }
				    $k++;
				  }//end if
	 }//end while
	 ?>
	</table>

	 <?php
	}//End $num_banner
	}//end if
	}//end if
}
function switch_mcalendar($m){
	switch($m) {
			case 1:  $html = "มกราคม"; break;
			case 2:  $html = "กุมภาพันธ์"; break;
			case 3:  $html = "มีนาคม"; break;
			case 4:  $html = "เมษายน"; break;
			case 5:  $html = "พฤษภาคม"; break;
			case 6:  $html = "มิถุนายน"; break;
			case 7:  $html = "กรกฏาคม"; break;
			case 8:  $html = "สิงหาคม"; break;
			case 9:  $html = "กันยายน"; break;
			case 10:  $html = "ตุลาคม"; break;
			case 11:  $html = "พฤศจิกายน"; break;
			case 12:  $html = "ธันวาคม"; break;
		}
	return $html;
}
function GenCalendar($BID){
	global $filename;
	global $db;
	global $mainwidth;
	global $global_theme;
		// Calendra Config Categories
	 $a=array();
	$query_calg = $db->query("SELECT * FROM cal_config WHERE BID='$BID' ");
	if($db->db_num_rows($query_calg)>0){
		   $data = $db->db_fetch_array($query_calg);
		   if($data[cal_group]!=""){
			  $a=explode(',',$data[cal_group]);
			  $wh_cat=" AND (cal_event.cat_id= '$a[0]' ";
			  for($k=1;$k<sizeof($a);$k++){ 
				  $wh_cat.=" OR cal_event.cat_id= '$a[$k]' ";
			  }
			   $wh_cat.=" )";
		   }
	}
	
	$path_cal = "";
	$cur_year = date('Y');
	$cur_month = date('m');
	?>
	<hr>
	<table width="100%" border="0">
	  <tr>
		<td>ปฏิทินกิจกรรมประจำเดือน  <?php echo switch_mcalendar($cur_month).'&nbsp;&nbsp;'.($cur_year+543);?></td>
	  </tr>
	  <?php
		if($_SESSION["EWT_MID"]) {
			$where1 = " AND (((cal_event.event_user_id = '".$_SESSION["EWT_MID"]."' OR cal_invite.person_id = '".$_SESSION["EWT_MID"]."' OR cal_invite.division_id = '".$_SESSION["EWT_ORG"]."')) OR (cal_event.event_private = '2'))";
			$where2 = " AND (cal_event.event_user_id = '".$_SESSION["EWT_MID"]."') ";
		} else {
			$where1 = " AND (cal_event.event_private = '2')";
		}
	$sql_group_event  ="
		select  *,cal_event.event_id as id
		from 
			cal_event inner join cal_show_event on cal_event.event_id = cal_show_event.event_id 
			inner join cal_category on cal_category.cat_id = cal_event.cat_id 
			left join cal_invite on cal_event.event_id = cal_invite.event_id 
		where ";
		$sql_group_event  .="(cal_event.event_date_start between'".date('Y-m-d', mktime(0, 0, 0, $cur_month, 1, $cur_year))."'  and '".date('Y-m-d', mktime(0, 0, 0, $cur_month+1, 0, $cur_year))."') and  (cal_event.event_date_end between'".date('Y-m-d', mktime(0, 0, 0, $cur_month, 1, $cur_year))."'  and   '".date('Y-m-d', mktime(0, 0, 0, $cur_month+1, 0, $cur_year))."' ) $where1
		group by cal_show_event.event_id,cal_show_event.event_date_start, cal_show_event.event_date_end  
		order by cal_event.event_date_start asc, cal_event.event_date_end asc";
	$result_group_event = $db->query($sql_group_event);
	$array_group_date = array();
	if($db->db_num_rows($result_group_event)>0){
	while($row_group_event = $db->db_fetch_array($result_group_event)) {
	//echo '1'.$row_group_event['id'];
	$start_ampm = 'น.';
						if($row_group_event['event_date_start'] == '0000-00-00' && $row_group_event['event_date_end'] == '0000-00-00') {
							$html_show = 'ไม่ระบุเวลา' ;
						} else {
							$html_show = '';
							$data_show1 = explode("-", $row_group_event['event_date_start']);
							$data_show2 = explode("-", $row_group_event['event_date_end']);
							if($row_group_event['event_date_start'] == '0000-00-00') {
							} else {
								$html_show .= date('j', mktime(0, 0, 0, $data_show1[1], $data_show1[2], $data_show1[0])).'&nbsp;';
								$html_show .= switch_mcalendar($data_show1[1]);
								$html_show .= (date('Y', mktime(0, 0, 0, $data_show1[1], $data_show1[2], $data_show1[0]))+543).'&nbsp;';
								if($row_group_event['event_time_start'] != '00:00:00') {
									$start_time = explode(':', $row_group_event['event_time_start']);
									$html_show .= sprintf('%02d', $start_time[0]).':'.sprintf('%02d', $start_time[1]).$start_ampm;
								}
								if($row_group_event['event_date_end'] == '0000-00-00') {
								} else {
									
									$html_show .= '&nbsp;-&nbsp;';
								}
							}
							if($row_group_event['event_date_end'] == '0000-00-00') {
							} else {
								$html_show .= date('j', mktime(0, 0, 0, $data_show2[1], $data_show2[2], $data_show2[0])).'&nbsp;';
								$html_show .= switch_mcalendar($data_show2[1]);
								$html_show .= (date('Y', mktime(0, 0, 0, $data_show2[1], $data_show2[2], $data_show2[0]))+543).'&nbsp;';
								if($row_group_event['event_time_end'] != '00:00:00') {
								$end_time = explode(':', $row_group_event['event_time_end']);
								$html_show .= sprintf('%02d', $end_time[0]).':'.sprintf('%02d', $end_time[1]).$start_ampm;
								}
							}
						}
	  ?>
	  <tr>
		<td><ul><li><a href="calendar_detail.php?event_id=<?php echo $row_group_event['id'];?>&amp;filename=<?php echo $filename;?>"><?php echo nl2br($row_group_event['event_title']);?>(<?php echo $html_show;?>)</a></li></ul></td>
	  </tr>
	  <?php }
	  ?>
	  <tr>
	    <td><a href="calendar_all.php?filename=<?php echo $filename;?>">ปฏิทินกิจกรรมทั้งหมด</a></td>
      </tr>
	  <?php
	  }else{?>
	  <tr>
		<td>ไม่พบข้อมูลกิจกรรม</td>
	  </tr>
	  <?php } ?>
	</table>

	<?php
}
function  GenSearch($BID){
	global $filename;
	global $db;
	global $mainwidth;
	global $global_theme;
	global $lang_sh;
	@include("language/language".$lang_sh.".php");
	$sql = $db->query("select block_themes from block where BID = '".$BID."' ");
	$rec = $db->db_fetch_array($sql);
	?>
	<hr>
		  <form name="search<?php echo $BID?>" method="post" action="search_result.php">
	  <table  cellpadding="0" cellspacing="0">
	  			<tr><td><span class="head">ค้นหา</span><td></tr>
			  	<tr>
					<td>
					<input name="keyword" type="text" id="keyword"  size="10" >
      				<input name="filename" type="hidden" id="filename" value="<?php echo $filename; ?>">
					<input name="oper" type="hidden" id="oper" value="OR">
					</td>
					<td>
					<input type="button" name="Submit"  
					onclick="
					if(document.search<?php echo $BID?>.searchby.value==2){
						//location.href='http://www.google.co.th/search?q='+document.search<?php echo $BID?>.keyword.value;
						window.open ('http://www.google.co.th/search?q='+document.search<?php echo $BID?>.keyword.value,'mygoogle'); 
					}else{
						document.search<?php echo $BID?>.submit();
					}" value="ค้นหา..." >
					</td>
				</tr>
			  	<tr>
					<td colspan="2"> 
					<input type="hidden" name="searchby" value="1" >
					<input  type="radio" name="chk" checked="checked" value="1"  onclick="if(this.checked==true){document.search<?php echo $BID?>.searchby.value=this.value;} "> ค้นหาจากในเว็บ<br >
	  				<input  type="radio" name="chk" value="2" onclick="if(this.checked==true){document.search<?php echo $BID?>.searchby.value=this.value;} " > ค้นหาจาก Google 
					</td>
				</tr>
		    </table>
</form>
			
	<?php
}
function GenOnline($id,$BID){
		 global $db;
		 global $mainwidth;
		 global $global_theme;
		 global $choose;
		 global $lang_sh;
		 $sqlB = $db->query("select block_themes from block where BID = '".$BID."' ");
		$recB = $db->db_fetch_array($sqlB);
	 @include("../language/language".$lang_sh.".php");
echo '<hr>';
if($id == ""){
//จำนวนผู้ online ขณะนี้
	$count = 0;
	$newTime = date ("YmdHis", mktime(date(H), date(i), date(s)-3600, date(m), date(d), date(Y)));

	$sql ="SELECT COUNT(*) FROM stat_visitor WHERE sv_url = 'page' AND sv_visitor = 'Y' AND sv_timestamp >= '".$newTime."' ";
	$query = $db->query($sql);
	$rec = $db->db_fetch_row($query);
	if(!session_is_registered("EWT_VISITOR_STAT")){
		$rec[0] ++;
	}
	if($rec[0]==0){
		$rec[0] = "1";
	}
	//if($choose == 'N'){
		$cs = sprintf("%06d",$rec[0]);
		for ( $i = 0; $i < strlen($cs); $i++ ) {
			//	$img .= "<img src=mainpic/counter/$cs[$i].gif>"; 
		}
	//}else{
		$img = "<img src=\"../ewt_c.php?n=".base64_encode($rec[0])."\" alt=\"".$cs."\">";
	//}
?>
   
<table >
  <tr>
    <td align="center" ><?php echo $text_genonline_numonline."<br>".$img; ?></td>
  </tr>
</table>
<?php
		 }elseif($id == "1"){
				$count = 0;
$sql ="SELECT COUNT(*) FROM stat_visitor WHERE sv_url = 'page' AND sv_visitor = 'Y'  ";
$query = $db->query($sql);
$rec = $db->db_fetch_row($query);
if(!session_is_registered("EWT_VISITOR_STAT")){
$rec[0] ++;
}
//chk counter hits
$sql_hits = "select set_countor from site_info";
$query_hits = $db->query($sql_hits);
$rec_hits = $db->db_fetch_array($query_hits);
$counter_hits = $rec_hits[set_countor];
if($rec[0]==0){
$rec[0] = "1";
}
$rec[0] += $counter_hits;
//if($choose == 'N'){
		$cs = sprintf("%06d",$rec[0]);
		for ( $i = 0; $i < strlen($cs); $i++ ) {
			//	$img .= "<img src=mainpic/counter/$cs[$i].gif>"; 
		}
	//}else{
		$img = "<img src=\"../ewt_c.php?n=".base64_encode($rec[0])."\" alt=\"".$cs."\">";
	//}
?>
<table >
  <tr>
    <td align="center" ><?php echo $text_genonline_numvisitor."<br>".$img; ?></td>
  </tr>
</table>
<?php
		}elseif($id == "2"){
				global $filename;
				$count = 0;
$sql ="select COUNT(*) from stat_visitor where sv_menu = '$filename'  ";
$query = $db->query($sql);
$rec = $db->db_fetch_row($query);
if(!session_is_registered("EWT_VISITOR_STAT")){
$rec[0] ++;
}
if($rec[0]==0){
$rec[0] = "0";
}
//if($choose == 'N'){
		$cs = sprintf("%06d",$rec[0]);
		for ( $i = 0; $i < strlen($cs); $i++ ) {
			//	$img .= "<img src=mainpic/counter/$cs[$i].gif>"; 
		}
	//}else{
		$img = "<img src=\"../ewt_c.php?n=".base64_encode($rec[0])."\" alt=\"".$cs."\">";
	//}
?>
<table >
  <tr>
    <td  align="center"><?php echo $text_genonline_numvisitorpage.$filename."<br>".$img; ?></td>
  </tr>
</table>
<?php
		}elseif($id == "3"){
				global $filename;
				$count = 0;

// All Total of file
$sql ="select COUNT(*) from stat_visitor where sv_menu = '$filename'  ";
$query = $db->query($sql);
$rec = $db->db_fetch_row($query);
$total=$rec[0];



// Total of Today
$sql ="select COUNT(*) from stat_visitor where sv_menu = '$filename' and sv_date like '".date('Y-m-d')."' ";
$query = $db->query($sql);
$rec = $db->db_fetch_row($query);
$today=$rec[0];

// Total of Yesterday
$yd=date("Y-m-d", mktime (0,0,0,date('m'),date('d')-1,date('Y')));
$sql ="select COUNT(*) from stat_visitor where sv_menu = '$filename' and sv_date = '$yd' ";
$query = $db->query($sql);
$rec = $db->db_fetch_row($query);
$yesterday=$rec[0];

// Total of Last month
$lm=date('m');
$sql ="select COUNT(*) from stat_visitor where sv_menu = '$filename' and sv_date like '%-".$lm."-%' ";
$query = $db->query($sql);
$rec = $db->db_fetch_row($query);
$lastmonth=$rec[0];

?>
<table >
  <tr>
    <td>
  <b><nobr>
  <?php echo $text_genonline_numtoday.' '.number_format($today)." $text_genonline_visitor";?><br>
  <?php echo $text_genonline_numyesterday.' '.number_format($yesterday)." $text_genonline_visitor";?><br>
  <?php echo $text_genonline_numlastmonth.' '.number_format($lastmonth)." $text_genonline_visitor";?><br>
 <?php echo $text_genonline_numall.' '.number_format($total)." $text_genonline_visitor";?>
  </nobr></b></td>
  </tr>
</table>
<?php
		}
	 }
function GenLogin($BID){
global $db;
global $mainwidth;
global $global_theme;
global $EWT_DB_NAME;
global $filename;
global $lang_sh;
global  $EWT_FOLDER_USER;
global  $EWT_DB_USER;
//echo $lang_sh;
@include("../language/language".$lang_sh.".php");

$sql = $db->query("select block_themes from block where BID = '".$BID."' ");
$rec = $db->db_fetch_array($sql);

 	if($_SESSION["EWT_MID"] == ""){
	?>
	<hr><form name="form_loginm<?php echo $BID;?>" method="post" action="ewt_login.php" onSubmit="return chk<?php echo $BID;?>();">
				<table width="98%" border="0" align="center" cellpadding="0" >
					
				<tr>
				  <td>&nbsp;<?php echo $text_GenLogin_name;?></td>
				</tr>
				<tr>
				  <td >
				  <table id="firstbox<?php echo $BID;?>" width="100%" border="0" cellspacing="0" cellpadding="0">
					  <tr>
						<td ><label><?php echo $text_GenLogin_title1;?><input name="ewt_user1" type="text" id="ewt_user1"  value=""   size="10"></label></td>
					  </tr>
					  <tr>
						<td ><label><?php echo $text_GenLogin_title2;?><input name="ewt_pass1" id="ewt_pass1" type="password"   value=""   size="10"></label></td>
					  </tr>
					  <tr>
						<td align="center" ><label>
						  <input type="submit" name="submit2"  value="<?php echo $text_GenLogin_name;?>" >
						</label></td>
					  </tr>
				  </table>
				  <table width="100%" border="0" cellspacing="0" cellpadding="0">
						  <tr>
							<td ><label>
							  <a href="frm_gen_user.php"><?php echo $text_GenLogin_addmember ;?>&nbsp;</a>
							</label> <label>
							  <a href="member_forgot.php" >|&nbsp;<?php echo $text_GenLogin_forget  ;?></a>
							<input name="fn" type="hidden" id="fn" value="main.php?filename=<?php echo $filename; ?>">
							 <input id="Flag" type="hidden" value="AcceptLogin" name="Flag">
							 <input id="BID" type="hidden" value="<?php echo $BID;?>" name="BID"></label></td>
						  </tr>
					</table></td>
				</tr>
				
			  </table></form>
				  <hr>
				   <script language="JavaScript"  type="text/javascript">
function chk<?php echo $BID;?>(){
	if(document.form_loginm<?php echo $BID;?>.ewt_user1.value == ""){
			alert("<?php echo $text_GenLogin_alertusername;?>");
			document.form_loginm<?php echo $BID;?>.ewt_user1.focus();
			return false;
	}else if(document.form_loginm<?php echo $BID;?>.ewt_pass1.value == ""){
			alert("<?php echo $text_GenLogin_alertpassword;?>");
			document.form_loginm<?php echo $BID;?>.ewt_pass1.focus();
			return false;
	}

}

</script>
	<?php
	}else{
	$db->query("USE ".$EWT_DB_USER);
$_SESSION["EWT_SMID"] = $_SESSION["EWT_MID"];
//echo "SELECT site_intra FROM user_info WHERE EWT_User = '".$EWT_FOLDER_USER."'  ";
$sql_site = $db->query("SELECT site_intra FROM user_info WHERE EWT_User = '".$EWT_FOLDER_USER."'  ");
$intra = $db->db_fetch_row($sql_site);
	?>
	<hr><table >
  <tr>
    <td >ยินดีต้อนรับ คุณ <?php echo $_SESSION["EWT_NAME"];?></td>
  </tr>
  <tr>
    <td>
	<table width="100%" >
  <tr>
    <td >
<DIV class=glossymenu  style="cursor:hand">
  <?php if($EWT_FOLDER_USER == "dmr_web" AND $_SESSION["EWT_ORG"] != "0"){ ?><a href="../dmr_intranet"><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>"  ><span style="font-size: <?php echo $body_font_size;?>">เข้าสู่เว็บไซต์อินทราเน็ต</span></font></span></a>
<br ><hr > <?php } ?>
<span class="submenuheader" style="height: 20px;"><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>"  ><span style="font-size: <?php echo $body_font_size;?>">Website</span></font></span></span>
<DIV class=submenu>
      <UL>
        <LI><a href="frm_gen_user_edit.php"><img src="../mainpic/m_profile.gif" width="24" height="24" border="0"  alt=" Edit Profile"> 
                       <span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>"> Edit Profile</span></font></span></a>
		</LI>
		  <LI><a href="#logout" onClick="if(confirm('ออกจากระบบ')){self.location.href='logout.php';}"><span class="text_normal"><font color="<?php echo $body_font_color2;?>"  face="<?php echo $body_font_face2;?>" ><span style="font-size: <?php echo $body_font_size2;?>"><img src="../mainpic/close.gif" width="24" height="24"  border="0" alt="ออกจากระบบ"> 
                        ออกจากระบบ</span></font></span></a> 
		</LI>
	</UL>
</DIV>	
	</DIV>	 
	</td>
  </tr>
</table>
	</td>
  </tr>
</table>
	<?php
	$db->query("USE ".$EWT_DB_NAME);
	}
}
function GenPic($data){
	for($i=0;$i<$data;$i++){
		echo "<img src=\"../../../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"\">";
	}
}
function GenSitemap($BID){
    global $db;
	global $mainwidth;
	global $global_theme;
	$sql = $db->query("select block_themes from block where BID = '$BID' ");
	$rec = $db->db_fetch_array($sql);
	
	
	$sql_menu = $db->query("SELECT m_id,m_name,m_realname,m_show  FROM  menu_list   where m_show='Y'  " );

				 ?>
				 <table width="100%" border="0">
				 <?php
				 	while($M = $db->db_fetch_array($sql_menu)){
				if($M["m_realname"]){
							   $nameMM=$M["m_realname"];
				}else{
							   $nameMM=$M["m_name"];
				 }
				 
				  ?>
				  <tr>
					<td><?php echo $nameMM;?></td>
				  </tr>
				  <?php
				   $sql_menu_sub = $db->query("SELECT * FROM menu_properties WHERE m_id = '".$M["m_id"]."' and  mp_show='Y'   ORDER BY mp_id ");
				while($R = $db->db_fetch_array($sql_menu_sub)){
					if($R["mp_realname"] ){
						 $nameMS=$R["mp_realname"];
					 }else{
						 $nameMS=$R["mp_name"];
					 }
					 $MPNAME = urlencode($nameMS);
					$MPNAME = eregi_replace("%A0"," ",$MPNAME);
					$MPNAME1 = urldecode($MPNAME);
					$nameMS = $MPNAME1;
					$level = GenLen($R["mp_id"],'_');
				  ?>
				  
				  <tr>
						<td><?php GenPic($level) ;?><img src="../mainpic/arrow_r.gif" alt="รายการย่อย" border="0">&nbsp;<a href="<?php echo $R["Glink"]?>" target="<?php $R["Gtarget"]?>"><?php echo $nameMS; ?></a></td>
				  </tr>
				  <?php }
				  } ?>
				</table>

				 <?php
}
function GenLink($BID){
 	global $db;
	global $mainwidth;
	global $global_theme;
 
 	$sql = $db->query("select * from block where BID = '".$BID."' ");
	$rec = $db->db_fetch_array($sql);
	$s_id=$rec[block_link];
	
	if($rec[block_themes] != '0'){
		$themeid = $rec[block_themes];
	}else{
		$themeid = $global_theme;
	}
	if($themeid != "0" AND $themeid != ""){
	$namefolder = "themes".($themeid);
			
			@include("../themesdesign/".$namefolder."/".$namefolder.".php");
	  //if($themes_type == 'F'){
		if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
                     $buffer = "";
                     $fd = @fopen ($Current_Dir1.$themes_file, "r");
					 while (!@feof ($fd)) {
						$buffer .= @fgets($fd, 4096);
					 }
					@fclose ($fd);
					$design = explode('<?#htmlshow#?>',$buffer);
			 }
			 //echo $design[0];
	}else{
		//$head_font_color='#666666';
		$bg_color='#333333';
		$head_color='#F8F8F8';
		$Current_Dir1='mainpic/';
		$bg_img='';
		//$head_img='toolbars.gif';
		$head_height=30;
		$body_color='#FFFFFF';
		//$body_font_color='#000099';
		$bottom_height=30;
		
	}
 
 global $filename;
 global $lang_sh;
 @include("language/language".$lang_sh.".php");
 $sql = $db->query("SELECT * FROM link_group ORDER BY glink_id ASC");
 $rows = $db->db_num_rows($sql);
 ?>
 <br>ลิงค์ที่หน้าสนใจ<hr><ul>
  <?php
						  $x = $offset;
						  if($rows > 0){
								   while($rec = $db->db_fetch_array($sql)){ 
$sql_count = $db->query("SELECT COUNT(link_id) FROM link_list WHERE glink_id = '$rec[glink_id]' ");
$C = $db->db_fetch_row($sql_count);
					?>
					<li><a href="ewt_link.php?glink_id=<?php echo $rec['glink_id'] ?>&amp;filename=<?php echo $filename; ?>&amp;BID=<?php echo $BID; ?>"> <?php echo $rec[glink_name]?>  (<?php echo $C[0]; ?>)</a> :<?php echo $rec[glink_des]?></li>
  
  <?php						
									}
							 }else{ 
					?><li><?php echo $text_GenLink_Nodetail;?></li>
  <?php } 
				 ?>
</ul>
<?php
}
function GenPoll($text_id,$BID){
global $db;
global $mainwidth;
global $global_theme;
global $filename;
global $lang_sh;
$lang_c = explode('_',$lang_sh);
@include("../language/language".$lang_sh.".php");
$date_poll_now = date("Y-m-d H:i:s");
$time_poll_now = date("H:i:s");
$q_date = "and ((('$date_poll_now' between c_start and c_stop) or (c_start = '' and c_stop = '')))";

$PollSel = $db->query("SELECT * FROM poll_cat WHERE  c_id = '".$text_id."' and c_approve = 'Y' $q_date");


if($rows = $db->db_num_rows($PollSel)>0){
	$pollR = $db->db_fetch_array($PollSel);
	$polls = random_code(4);
	if($lang_sh != ''){
	$pollR[c_name] = $pollR[lang_detail];
	}
    if($pollR[c_start]==''){ 
		  $sdate=date('YmdHi');
	}else{
		$sdate=$pollR[c_start].$pollR[c_timestart];
	}
	if($pollR[c_stop]==''){ 
		$edate=date('YmdHi');
	}else{
		$edate=$pollR[c_stop].$pollR[c_timestop];
	}
?>
<hr>
<form name="PollForm<?php echo $polls; ?><?php echo $BID; ?>" action="ewt_vote.php?filename=<?php echo $filename;?>" method=post >
<table width="100%" border="0">
  <tr>
    <td colspan="2"><span class="text_normal"><?php echo stripslashes($pollR[c_name]); ?></span></td>
  </tr>
  <?php
  $SelPoll = $db->query("SELECT * FROM poll_ans WHERE c_id = '$pollR[c_id]' ORDER BY a_id ASC"); 
  while($pollAns = $db->db_fetch_array($SelPoll)){
  ?>
  <tr><td colspan="2"><label>
              <INPUT type="radio" value="<?php echo $pollAns[a_id]; ?>" name="vote">
            <span class="text_normal"><?php echo stripslashes($pollAns[a_name]); ?></span></label></td></tr>
 
  <?php } ?>
   <tr>
    <td><label>
			 <input type="hidden" name="flag">
			  <input type="Submit" name="submit"  value="<?php echo $text_genpoll_votesubmit ;?>"   onClick="document.PollForm<?php echo $polls; ?><?php echo $BID; ?>.flag.value='0';   return chkPoll<?php echo $polls; ?>();">
            </label></td>
    <td><label>
              <input type="Submit" name="views"  value="<?php echo $text_genpoll_submitvote;?>"  onclick="document.PollForm<?php echo $polls; ?><?php echo $BID; ?>.flag.value='1'; ">
            </label><input name="cad_id" type="hidden" id="cad_id" value="<?php echo $pollR[c_id]; ?>"></td>
  </tr>
</table>
</form>
<?php
	}
}
function GenEBook($BID){
	 global $db;
	 global $mainwidth;
	 global $global_theme;
	 $sql = $db->query("select * from block where BID = '".$BID."' ");
	$rec = $db->db_fetch_array($sql);
	$ebook_id=$rec[block_link];
	 global $dataSearchEbook; 
	 @include("../language/language".$lang_sh.".php");
	  $dest = "../ebook/"; //Source ebook
	   if($ebook_id==''){
	   if (!empty($dataSearchEbook)) {
			$wh = " and (ebook_name like '%$dataSearchEbook%' or ebook_desc like '%$dataSearchEbook%') ";
			$sql = "select * from ebook_info where show_status='Y' $wh order by ebook_name";
			$query = $db->query ($sql);
			$numRows = $db->db_num_rows ($query);
	   }
}else{
	$tb=explode('@',$ebook_id);
	if($tb[1]=='C'){
		$sql = "select * from ebook_info inner join ebook_group on ebook_info.g_ebook_id=ebook_group.g_ebook_id  where ebook_info.g_ebook_id='$tb[0]' and show_status='Y' and g_ebook_status='Y' order by ebook_name";
	}else{
		//echo $ebook_id;
		$sql = "select * from ebook_info where ebook_id='$tb[0]' and show_status='Y' order by ebook_name";
	}
    $query = $db->query ($sql);
	$numRows = $db->db_num_rows ($query);
}
?>
<hr>
<?php if($ebook_id==''){ ?>
    <form name="form1" method="post" action="">
	<?php echo $text_GenEbook_head;?>
        <table width="100%" border="0" cellspacing="1" cellpadding="3">
    <tr>
      <td><?php echo $text_GenEbook_Search;?>:
              <input name="dataSearchEbook" type="text" value="<?php echo $dataSearchEbook;?>" size="15">
            <input type="submit" name="Submit" value="<?php echo $text_GenEbook_button_ok;?>"></span></font></td>
		 <td align="right" valign="bottom">
		 <?php    if (!empty($dataSearchEbook)){  echo $text_GenEbook_Search_text.' '.$numRows.' '.$text_GenEbook_list;  }  ?> 
		</td>
      </tr>
    </table></form>
<?php } else{ ?>
          <table width="100%" border="0" cellspacing="1" cellpadding="3">
<?php     if($numRows>0){ 
			  while($rec = $db->db_fetch_array($query)){

			  $querypage=$db->query("select ebook_code,ebook_page_file from ebook_page where ebook_code  like '$rec[ebook_code]' ORDER BY ebook_page");
			  $datapage = $db->db_fetch_array($querypage);
			  $sizeOfPage=$db->db_num_rows($querypage);
?>
            <tr > 
			   <td  width="25%" align="center" valign="top">
			   <table width="100"  border="0" cellpadding="5" cellspacing="1" bgcolor="#999999">
			  <tr>
				<td align="center" bgcolor="#FFFFFF"><a href="<?php print $dest.$rec['ebook_code'];?>/index.html" target="_blank" ><img src="../phpThumb.php?src=ebook/<?php echo $datapage[ebook_code].'/pages/'.$datapage[ebook_page_file];?>&amp;h=85&amp;w=85" hspace="0" vspace="0" align="middle" border=0 alt="<?php echo $rec['ebook_name'];?>"></a></td>
			  </tr>
			</table>
			   </td>
			   <td width="75%" valign="top"><a href="<?php print $dest.$rec['ebook_code'];?>/index.html" target="_blank"><?php echo $rec['ebook_name'];?></a>
			   <br><br> <?php echo $rec['ebook_desc'];?>
			   <br><br>(<?php echo $text_GenEbook_lblsize;?>) <?php echo $rec['ebook_w'];?> x <?php echo $rec['ebook_h'];?> <?php echo $text_GenEbook_lblpix;?> <?php echo $sizeOfPage ?>  <?php echo $text_GenEbook_lblpage;?>  <br>
                <?php echo $text_GenEbook_lblby;?> <?php echo $rec['ebook_by'];?>
              </td>
            </tr>
          
         <?php 
			  }
		 }else{?>
		 <tr > 
			   <td  colspan="2" align="center" valign="top"><?php echo $text_GenEbook_notfound;?></td>
            </tr>
<?php } ?>
      </table>
<?php
	}
}
function GenENews($BID){
	global $filename;
	global $db;
	global $mainwidth;
	global $global_theme;
	global $lang_sh;
	@include("../language/language".$lang_sh.".php");
$sql = $db->query("select block_themes from block where BID = '".$BID."' ");
$rec = $db->db_fetch_array($sql);

	if($rec[block_themes] != '0'){
		$themeid = $rec[block_themes];
	}else{
		$themeid = $global_theme;
	}
	if($themeid != "0" AND $themeid != ""){
	$namefolder = "themes".($themeid);

@include("../themesdesign/".$namefolder."/".$namefolder.".php");
 //if($themes_type == 'F'){
 	$buffer = "";
	if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
 	   $fd = @fopen ($Current_Dir1.$themes_file, "r");
		while (!@feof ($fd)) {
			$buffer .= @fgets($fd, 4096);
		}
 		@fclose ($fd);
		$design = explode('<?#htmlshow#?>',$buffer);
	}
}
?>
<hr>
<form name="NewsLetterForm<?php echo $BID;?>" method="post" action="newsletter_function.php?filename=<?php echo $filename; ?>" onSubmit="return ChkValueNewsLetter<?php echo $BID;?>();">
<table id="tball" width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr>
       <td >&nbsp;<?php echo $text_genenews_title;?></td>
    </tr>
     <tr>
       <td align="center" >
		<label>
              <input name="newsletteremail" type="text" id="newsletteremail" value="<?php echo $text_genenews_email;?>" onFocus="this.value='';">
       </label></td>
	</tr>
						<tr>
						  <td height="10" align="center" >
									<input name="applynewsletter" type="radio" value="Y" checked><?php echo $text_genenews_apply;?>
									<input type="radio" name="applynewsletter" value="N"><?php echo $text_genenews_cancle;?></td>
						</tr>
						<tr>
						  <td align="center" >
						 <input type="hidden" name="t" value="<?php echo $rec[block_themes];?>">
						 <input name="Button01" type="submit"  id="Button01" value="<?php echo $text_genenews_submit;?>">
						 <br><br>
						 </td>
						</tr>
</table>
</form>
 <script language="JavaScript"  type="text/javascript">

function ChkValueNewsLetter<?php echo $BID;?>(){
	if(document.NewsLetterForm<?php echo $BID;?>.newsletteremail.value == ""){
		alert('<?php echo $text_genenews_alertemail;?>');
		document.NewsLetterForm<?php echo $BID;?>.newsletteremail.focus();
		return false;
	}else if(!validEMail(document.NewsLetterForm<?php echo $BID;?>.newsletteremail)){
		alert('<?php echo $text_genenews_alertemail_no;?>');
		document.NewsLetterForm<?php echo $BID;?>.newsletteremail.select();
		return false;
	}
	if(document.NewsLetterForm<?php echo $BID;?>.applynewsletter[1].checked){
		r = confirm("<?php echo $text_genenews_alertcancle;?>");
		if(r==true){
			return true;
		}else{
			return false;
		}
	}
}
</script>
<?php
}
function chg_date_th ($date_input)
{
	   $date = substr($date_input,8,2);
	   $mont= substr($date_input,5,2);
	   $year_en = substr($date_input,0,4);
	   $year=$year_en+543;

	   return $date."/".$mont."/".$year;
}
function GenGuestbook($BID){
	global $db;
	global $mainwidth;
	global $global_theme;
	global $filename;
	global $offset;
	global $lang_sh;
	@include("../language/language".$lang_sh.".php");
	$path_cal = "../";
	$sql = $db->query("select * from block where BID = '".$BID."' ");
	$rec = $db->db_fetch_array($sql);
	$s_id=$rec[block_link];
	
		//#####################replace *** to word  #########################
$sql_vul = " SELECT * FROM vulgar_table ";
$query_vul = mysql_query($sql_vul);
$num_vul  = mysql_num_rows($query_vul);
for($i=1;$i<=$num_vul;$i++){
		$rec = $db->db_fetch_array($query_vul);
		$vulels[$i] = $rec['vulgar_text'];		
}
//##############################################################
$chk_config = mysql_query("SELECT * FROM guest_config ");
$CO = $db->db_fetch_array($chk_config);
$message = explode(',',$CO["guest_config_message"]);

//#########################    Chack Date < guest_config_date ########
$d = date(d) - $CO['guest_config_date'];
$m = date(m);
$y = date(Y);
$today = $y."-".$m."-".date(d);
$chk_date=  date("Y-m-d", mktime(0, 0, 0, $m, $d, $y));
//###############################################################


$sel = "SELECT * FROM guestbook_list WHERE   status_guest = 'Y' ORDER BY id_guest DESC";//WHERE date_guest BETWEEN '$chk_date' AND ' $today' AND

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
?>
<br>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
				 <tr>
					<td bgcolor="#FFFFFF">
				<table border="0" width="100%" cellpadding="3" cellspacing="1"  >
								  <tr> 
										<td width="72%" height="33" ><?php echo $text_genguestbook_title;?><hr ></td>
								  </tr>
								  <tr > 
									<td align="center" height="30" >
									<?php
							
						  if($rows > 0){
								   while($rec = $db->db_fetch_array($Execsql)){ 
											$count = $db->query("SELECT * FROM guestbook_list WHERE id_guest = '$rec[id_guest]' ");
											$countrow = mysql_num_rows($count);
											$date_print = chg_date_th($rec['date_guest']);
				?><table width="100%" border="0" cellspacing="1" cellpadding="5">
                                      <tr>
                                        <td width="22%" align="right"><?php echo $text_genguestbook_name;?> :</td>
                                        <td width="78%" align="left"><?php echo str_replace($vulels, "***",$rec['name_guest']);?></td>
                                      </tr>
                                      <tr>
                                        <td align="right"><?php echo $text_genguestbook_message;?> : </td>
                                        <td align="left"><?php echo str_replace($vulels, "***",$rec['detail_guest']);?></td>
                                      </tr>
                                      <tr>
                                        <td align="right"><?php echo $text_genguestbook_unit;?> : </td>
                                        <td align="left"><?php echo str_replace($vulels, "***",$rec['unit_guest']);?></td>
                                      </tr>
                                      <tr>
                                        <td align="right"><?php echo $text_genguestbook_email;?> : </td>
                                        <td align="left"><?php echo str_replace($vulels, "***",$rec['country_province']);?></td>
                                      </tr>
                                      <tr>
                                        <td align="right"><?php echo $text_genguestbook_day;?> : </td>
                                        <td align="left"><?php print $date_print;?></td>
                                      </tr>
                                      <tr>
                                        <td colspan="2" align="right"><hr ></td>
                                      </tr>
                                    </table>
									<?php						
									}
							 }else{ 
					?><span class="text_normal"><?php echo $text_genguestbook_nodetail;?></span></td>
			      </tr> <?php }  ?>
              </table>
			  
	</td>
     </tr>
</table>
 <table width="95%"  border="0" align="center" cellpadding="1" cellspacing="0">
			  <?php if($rows > 0){ ?><tr>
								<td height="30" colspan="2"><?php echo $text_genguestbook_page;?> :<?php
								if ($offset !=0) {   
								$prevoffset=$offset-$limit; 
								echo   "<a href='$PHP_SELF?filename=".$filename."&amp;offset=$prevoffset'>
								<font  color=\"red\"><span class=\"text_normal\">$text_genguestbook_pre</span></font></a>\n\n";
								}
								$pages = intval($rows/$limit); 
								if ($rows%$limit) { 
										$pages++; 
								} 
								for ($i=1;$i<=$pages;$i++) { 
									if (($offset/$limit) == ($i-1)) { 
											echo "<font  color=\"blue\">[ $i ] </font>"; 
									} else { 
											$newoffset=$limit * ($i-1); 
											echo  "<a href='$PHP_SELF?filename=".$filename."&amp;offset=$newoffset'". 
											"onMouseOver=\"window.status='Page $i'; return true\";><font face=\"MS Sans Serif\" size=\"1\" color=\"black\"><span class=\"text_normal\">$i</span></font></a>\n\n"; 
									} 
								} 
								if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
										$newoffset=$offset+$limit; 
										echo   "<a href='$PHP_SELF?filename=".$filename."&amp;offset=$newoffset'>
										<font color=\"red\"><span class=\"text_normal\">$text_genguestbook_next</span></font></a>"; 
								}
								?></td>
						</tr>
					<?php } ?>
</table>
			<table width="100%" border="0">
			<tr  bgcolor="#FFFFFF">
					<td height="25" >Sign Guest Book ( ลงนามสมุดเยี่ยม )<hr></td>
			  </tr>
			</table>

			  <form name="frm1<?php echo $BID;?>" action="guestbook_function.php" method="post" onsubmit="return chk_input<?php echo $BID;?>();">
			  <table  width="80%" border="0" align="center" cellpadding="1" cellspacing="1" >
				 <tr  bgcolor="#FFFFFF">
					<td height="15" colspan="2" >แสดงความคิดเห็นโดยเลือกอย่างใดอย่างหนึ่ง</td>
			    </tr> 
				  <tr  bgcolor="#FFFFFF">
					<td align="right" bgcolor="#FFFFFF" ><?php echo $text_genguestbook_comment;?> :</td>
					<td width="65%" align="left" valign="top" ><select name="title_show" >
					  <option value=""><?php echo $text_genguestbook_option0;?></option>
					  <?php for($x=0;$x<count($message);$x++){ ?>
					  <option value="<?php echo $message[$x];?>"><?php echo $message[$x];?></option>
					  <?php }?>
					</select>
					</td>
				  </tr>
				  <tr  bgcolor="#FFFFFF">
					<td align="right" bgcolor="#FFFFFF" ><?php echo $text_genguestbook_select1;?> :</td>
					<td width="65%" align="left" valign="top" ><textarea name="comment_guest" cols="30" rows="5"  class="cadweb2007" id="t_detail"><?php echo $comment_guest?></textarea></td>
				  </tr>
				  <tr  bgcolor="#FFFFFF">
					<td height="25" colspan="2" >ข้อมูลผู้เข้าเยี่ยมชม</td>
				  </tr>
				  <tr  bgcolor="#FFFFFF">
					<td width="35%" align="right" bgcolor="#FFFFFF" ><?php echo $text_genguestbook_person;?> :</td>
					<td width="65%" align="left" valign="top" >
						<input name="name_guest" type="text" class="cadweb2007"  value="<?php echo $name_guest?>"></td>
				  </tr>
				  <tr  bgcolor="#FFFFFF">
					<td align="right" bgcolor="#FFFFFF" ><?php echo $text_genguestbook_unit;?> :</td>
					<td width="65%" align="left" valign="top" ><select name="unit">
					  <option value="">โปรดเลือก....</option>
					  <option value="นักเรียน/นักศึกษา">นักเรียน/นักศึกษา</option>
					  <option value="ข้าราชการ/รัฐวิสาหกิจ">ข้าราชการ/รัฐวิสาหกิจ</option>
					  <option value="เจ้าของกิจการ/ผู้ประกอบการ">เจ้าของกิจการ/ผู้ประกอบการ</option>
					  <option value="พนักงาน/ลูกจ้าง">พนักงาน/ลูกจ้าง</option>
					  <option value="ผู้สนใจทั่วไป">ผู้สนใจทั่วไป</option>
					</select></td>
				  </tr>
				  <tr  bgcolor="#FFFFFF">
					<td align="right" bgcolor="#FFFFFF" ><?php echo $text_genguestbook_email;?> :</td>
					<td width="65%" align="left" valign="top" ><input name="email" type="text" value="<?php echo $email?>">
						
					</td>
				  </tr>
				  <tr  bgcolor="#FFFFFF">
					<td align="right" bgcolor="#FFFFFF" >&nbsp;</td>
					<td width="65%" align="left" valign="top" >&nbsp;</td>
				  </tr>
				  <tr  bgcolor="#FFFFFF">
					<td align="center" valign="top" colspan="2"><input name="submit" type="submit" class="cadweb2007" value="<?php echo $text_genguestbook_valueok;?>"><input name="filename" type="hidden" value="<?php echo $filename;?>" ></td>
				  </tr>
				</table>
			  </form>
<script language="JavaScript"  type="text/javascript">
function chk_input<?php echo $BID;?>(){


		if(document.frm1<?php echo $BID;?>.comment_guest.value == '' && document.frm1<?php echo $BID;?>.title_show.value == ''){
				alert('กรุณาเขียนข้อความหรือเลือกข้อความคิดเห็น!!!!!!');
				return false;
		}
		if(document.frm1<?php echo $BID;?>.name_guest.value == ''){
				alert('กรุณาระบุชื่อผู้ลงนาม!!!!!');
				return false;
		}
		
		if(document.frm1<?php echo $BID;?>.email.value != '' && !validEMail(document.frm1<?php echo $BID;?>.email)){
				alert('กรุณาระบุ e-mail ให้ถูกต้อง!!!!!');
				return false;
		}
}

</script>
<?php
	
	
	
}
?>
<?php
function GenComplain($BID){
global $db;
global $mainwidth;
global $global_theme;
global $filename;
global $lang_sh,$filename;
$sql = $db->query("select block_themes,block_link from block where BID = '$BID' ");
$count_rec = $db->db_num_rows($sql);
$rec = $db->db_fetch_array($sql);
@include("../language/language".$lang_sh.".php");
?>
 <form name="Complainform" method="post" action="m_complain_sendmail.php"  >
<table   width="100%"  cellpadding="3" cellspacing="1" >
              <tr> 
                <td  colspan="2" ><?php echo $text_GenComplain_head;?><hr></td>
              </tr>
              <tr> 
                <td width="35%" align="right" valign="top" ><?php echo $text_GenComplain_title;?>:</td>
                <td ><div align="left"> <font size="2" face="Tahoma"> <span class="text_normal">
                    <input name="topic" type="text" id="topic" ></span>
                    </font></div></td>
              </tr>
              <tr> 
                <td align="right" valign="top" ><?php echo $text_GenComplain_name;?> :</td>
                <td ><div align="left"> <font size="2" face="Tahoma"> 
                    <span class="text_normal"><input name="name" type="text" id="name" ></span>
                    </font></div></td>
              </tr>
              <tr> 
                <td align="right" valign="top" ><?php echo $text_GenComplain_email;?> :</td>
                <td ><div align="left"> <font size="2" face="Tahoma"> 
                    <span class="text_normal"><input name="email" type="text" id="email" ></span>
                    </font></div></td>
              </tr>
              <tr> 
                <td align="right" valign="top" ><?php echo $text_GenComplain_phone;?>:</td>
                <td ><div align="left"> <font size="2" face="Tahoma"> 
                    <span class="text_normal"><input name="tel" type="text" id="tel"  ></span>
                    </font></div></td>
              </tr>
              <tr> 
                <td align="right" valign="top" ><?php echo $text_GenComplain_detail;?> :</td>
                <td ><div align="left"> <font size="2" face="Tahoma"> 
                   <span class="text_normal"> <textarea name="detail" cols="30" rows="5"  id="detail"></textarea></span>
                    </font></div></td>
              </tr>
			  <tr> 
                <td align="right" valign="top" ><?php echo $text_GenComplain_unit;?>:</td>
                <td >
<div align="left">
<?php
$ss = mysql_query("Select * From m_complain_info ");
?>
                    <select name="select">
					<?php
					while($XX = mysql_fetch_row($ss)){
					?>
                      <option value="<?php echo $XX[0]; ?>"><?php echo $XX[1]; ?></option>
<?php } ?>
                    </select>
                  </div></td>
              </tr>
              <tr> 
                <td colspan="2" valign="top" ><div align="center"> 
                    <font size="2" face="Tahoma"> 
                    <input type="submit" name="Submit" value="<?php echo $text_GenComplain_add;?>" >
                    &nbsp; 
                    <input type="reset" name="Submit2" value="<?php echo $text_GenComplain_cancle;?>" >
                    <input type="hidden" name="flag" value="1" >
					<input type="hidden" name="filename" value="<?php echo $filename;?>" >
                    </font></div></td>
              </tr>
</table>
</form>
<?php

}
 function GenVdo($BLink,$BID){
global $db;
	global $global_theme;
	global $filename;
	$x=explode(',',$BLink);
	$vdo=$x[0];									//link ID  vdo group
	$vdo_WIDTH=$x[1];                //vdo width
	$vdo_HEIGHT=$x[2];              //vdo height
	$vdo_AUTOPLAY=$x[3];                   //vdo play type
	$vdo_LIST=$x[4];
	if($vdo_WIDTH==''){  $vdo_WIDTH=200; }
	if($vdo_HEIGHT==''){  $vdo_HEIGHT=200; }
	if($vdo_AUTOPLAY==''){  $vdo_AUTOPLAY='N'; }
	if($vdo_LIST=='' || $vdo_LIST=='0'){  $vdo_LIST=''; }else{ $vdo_LIST='LIMIT 0,'.$vdo_LIST;$MORE_SHOW='Y';}

 	$sql = $db->query("select block_themes from block where BID = '".$BID."' ");
	$rec = $db->db_fetch_array($sql);
	 if($vdo){
 	$sql = "SELECT vdog_name FROM vdo_group  WHERE vdog_id = '".$vdo."'";
	$query=$db->query($sql);
	$data1=$db->db_fetch_array($query);
	
	$Current_Dir="download/file_vdo/mediaplayer";
	$Current_Dir2="download/file_vdo/mediaplayer";
 ?>

<script language="javascript" type="text/javascript" src="../swfobject.js"></script>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" >
     <tr>
        <td align="center" bgcolor="#FFFFFF">
 <table width="100%" border="0" cellspacing="0" cellpadding="0" >
  <tr>
      <td align="left"><?php echo $data1[vdog_name];?><hr></td>
  </tr>
  <tr>
       <td align="left">
	   <?php
			   $sql = "SELECT * FROM vdo_list  WHERE vdo_group = '$vdo' order by vdo_id DESC $vdo_LIST";
				$query=$db->query($sql);
				$data1=$db->db_fetch_array($query);
	   ?>
	   <script language="javascript" type="text/javascript" >

var urlname = document.URL.split("/");
var urlen = (urlname.length - 2);
var myurl = "";
for(i=0;i<urlen;i++){
myurl = myurl + urlname[i] + "/";
}
//alert(myurl);
		    function play<?php echo $BID;?>(vdoFile,id) {
				var s<?php echo $BID;?> = new SWFObject("../media/mediaplayer.swf","single<?php echo $BID;?>","<?php echo $vdo_WIDTH;?>","<?php echo $vdo_HEIGHT;?>","1");
				s<?php echo $BID;?>.addParam("allowfullscreen","true");
				s<?php echo $BID;?>.addVariable("file",myurl + vdoFile);
				s<?php echo $BID;?>.addVariable("width","<?php echo $vdo_WIDTH;?>");
				s<?php echo $BID;?>.addVariable("height","<?php echo $vdo_HEIGHT;?>");
				s<?php echo $BID;?>.addVariable("autostart","true");
				s<?php echo $BID;?>.write("player<?php echo $BID;?>");	
				vdo_count<?php echo $BID;?>.location.href = "../vdo_count.php?v="+id;
			}
	   </script>
			 <p id="player<?php echo $BID;?>"><a href="http://www.macromedia.com/go/getflashplayer"><?php echo $data1[vdo_name];?></a></p>
	        <script language="javascript" type="text/javascript" >
				var s<?php echo $BID;?> = new SWFObject("../media/mediaplayer.swf","single<?php echo $BID;?>","<?php echo $vdo_WIDTH;?>","<?php echo $vdo_HEIGHT;?>","1");
				s<?php echo $BID;?>.addParam("allowfullscreen","true");
				s<?php echo $BID;?>.addVariable("file",myurl + "<?php echo $data1[vdo_filename];?>");
				s<?php echo $BID;?>.addVariable("image","<?php echo $data1[vdo_image];?>");
				s<?php echo $BID;?>.addVariable("width","<?php echo $vdo_WIDTH;?>");
				s<?php echo $BID;?>.addVariable("height","<?php echo $vdo_HEIGHT;?>");
               <?php if($vdo_AUTOPLAY=='Y'){?>  s<?php echo $BID;?>.addVariable("autostart","true");  <?php } ?>
				s<?php echo $BID;?>.write("player<?php echo $BID;?>");
			</script>
	   </td>
   </tr>
    <tr  > 
	    <td align="left"  >
	        <ul><li><a href="#view" onclick="play<?php echo $BID;?>('<?php echo $data1[vdo_filename];?>','<?php echo $data1[vdo_id];?>'); " title="<?php echo $data1[vdo_name];?>,จำนวนผู้เข้าชม <?php echo number_format($data1[vdo_count],0);?> คน"><?php echo $data1[vdo_name];?></a></li>
	        </ul>
		</td> 
	</tr>
   <?php 
	while($data1=$db->db_fetch_array($query)){ ?>
    <tr  > 
	    <td align="left"  >
	         <ul><li><a href="#view" onclick="play<?php echo $BID;?>('<?php echo $data1[vdo_filename];?>','<?php echo $data1[vdo_id];?>'); " title="<?php echo $data1[vdo_name];?>,จำนวนผู้เข้าชม <?php echo number_format($data1[vdo_count],0);?> คน"><?php echo $data1[vdo_name];?>
			 </a>
			 </li>
	         </ul>
			 
		</td> 
	</tr>
	<?php  } ?>
	<?php if($MORE_SHOW == 'Y'){ ?>
		<tr ><td><table width="100%" border="0">
		  <tr>
			<td align="left"><a href="more_video.php?gid=<?php echo $vdo;?>&amp;filename=<?php echo $filename;?>&amp;BID=<?php echo base64_encode ('ZY'.$BID);?>">ดูทั้งหมด</a></td>
		  </tr>
		</table></td> 
		</tr>
		<?php } ?>
</table>
<iframe name="vdo_count<?php echo $BID;?>" src=""  frameborder="0"  width="0" height="0" scrolling="no" ></iframe>

	</td>
     </tr>
</table>
 <?php
 	} 
}
function GenFaq($BID){
global $db;
global $mainwidth;
global $global_theme;
global $filename;
global $lang_sh;
@include("../language/language".$lang_sh.".php");

$sql = $db->query("select * from block where BID = '".$BID."' ");
$rec = $db->db_fetch_array($sql);
$g_id=$rec[block_link];

?>
<form name="formSearchFAQ" method="post" action="search_result.php">
<table width="100%" border="0" align="center" cellpadding="3" cellspacing="0" >
<tr>
    <td align="right">
	     <input name="filename" type="hidden" value="<?php echo $filename; ?>"> 
         <input type="text" name="keyword" class="styleMe">
		 <input type="hidden" name="search_mode" value="5">
         <input type="submit" name="search" value="<?php echo $text_genfaq_buttonsrarch;?>" class="styleMe">
     </td>
  </tr>
</table>
</form>
<?php

if($g_id=='' || !$g_id){
	$wh = "";
}else{
	if(count(explode(',',$g_id))>1){
	$wh = "and f_sub_id IN ($g_id)";
	}else{
	$wh = "and f_sub_id='$g_id'";
	}
}
if($g_id == ''){
$Execsql = $db->query("SELECT * FROM f_subcat where f_use='Y'  and f_parent=0 ORDER BY f_parent ASC,f_sub_no ASC");
$row = $db->db_num_rows($Execsql);
	if($row > 0){
		while($R = $db->db_fetch_array($Execsql)){ 
	?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
     <tr>
        <td  ><?php echo ($R[f_subcate]); ?><hr></td>
     </tr>
	 <tr>
        <td align="left">
		<?php   
		$sql_subcat="SELECT * FROM faq WHERE f_sub_id = '$R[f_sub_id]'   and faq_use='Y'  $seld ORDER BY  faq_top DESC ,faq_date DESC limit 0,10"  ;
		$query_subcat=$db->query($sql_subcat);
?>
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0"  id="tbbg" >

<tr>
    <td align="left" ><ul><?php 	while($R_SUB=$db->db_fetch_array($query_subcat)){ $f_subid = $R_SUB[f_sub_id]; ?><li><a href="##lo"  onclick="window.open('faq_open.php?fa_id=<?php echo $R_SUB[fa_id];?>','showass','scrollbars=yes,width=650,height=450')"><?php echo ($R_SUB[fa_name]); ?></a></li>
    <?php                       }//while($R_SUB=$db->db_fetch_array($query_subcat)){ ??
	 ?></ul></td>
</tr> 

	 <tr>
	<td align="left" >														  
	 	<a href="faq_list.php?f_id=<?php echo $R[f_id]; ?>&amp;f_sub_id=<?php echo $R[f_sub_id]; ?>&amp;filename=<?php echo $filename; ?>"  >ดูทั้งหมด>></a> </td>
</tr>  
 </table>

				     
	   </td>
     </tr>
</table>
	<?php
		}
	}
?>
<?php
}else{
$Execsql = $db->query("SELECT * FROM f_subcat where f_use='Y'  $wh ORDER BY f_parent ASC,f_sub_no ASC");
$row = $db->db_num_rows($Execsql);
	if($row > 0){
		while($R = $db->db_fetch_array($Execsql)){ 
	?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
     <tr>
        <td  ><?php echo ($R[f_subcate]); ?><hr></td>
     </tr>
	 <tr>
        <td align="left">
		<?php   
		$sql_subcat="SELECT * FROM faq WHERE f_sub_id = '$R[f_sub_id]'   and faq_use='Y'  $seld ORDER BY  faq_top DESC ,faq_date DESC limit 0,10"  ;
		$query_subcat=$db->query($sql_subcat);
?>
<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0"  id="tbbg" >

<tr>
    <td align="left" ><ul><?php 	while($R_SUB=$db->db_fetch_array($query_subcat)){ $f_subid = $R_SUB[f_sub_id]; ?><li><a href="##lo"  onclick="window.open('faq_open.php?fa_id=<?php echo $R_SUB[fa_id];?>','showass','scrollbars=yes,width=650,height=450')"><?php echo ($R_SUB[fa_name]); ?></a></li>
    <?php                       }//while($R_SUB=$db->db_fetch_array($query_subcat)){ ??
	 ?></ul></td>
</tr> 

	 <tr>
	<td align="left" >														  
	 	<a href="faq_list.php?f_id=<?php echo $R[f_id]; ?>&amp;f_sub_id=<?php echo $R[f_sub_id]; ?>&amp;filename=<?php echo $filename; ?>"  >ดูทั้งหมด>></a> </td>
</tr>  
 </table>

				     
	   </td>
     </tr>
</table>
	<?php
		}
	}
}
}
function GenSurvey($BID){
global $db;
global $mainwidth;
global $global_theme;
global $EWT_DB_NAME,$EWT_DB_USER;
$sql = $db->query("select block_themes,block_link from block where BID = '".$BID."' ");
$rec = $db->db_fetch_array($sql);
$s_id=$rec[block_link];

 $bg_width="84%";
if($s_id != ""){
	$db->query("USE ".$EWT_DB_USER);
    $sqlu = "SELECT * FROM gen_user WHERE gen_user_id = '".$_SESSION["EWT_MID"]."' AND status = '1' ";
	$queryu = $db->query($sqlu);
	$RU = $db->db_fetch_array($queryu);
	$mid = $RU["gen_user_id"];
	$morg = $RU["org_id"];
	$db->query("USE  ".$EWT_DB_NAME);
	if($_SESSION["EWT_MID"]){
		$SQL2 = $db->query("SELECT * FROM p_survey_group WHERE s_id = '$s_id' and (sg_mid = '$mid' or sg_oid = '$morg') ");
		$allowUser = mysql_num_rows($SQL2);
	}
	global $filename;
	global $EWT_FOLDER_USER;
	global $lang_sh;
	@include("../language/language".$lang_sh.".php");
	$Yn = date("Y")+543;
	$dn = date("m-d");
	$dn = $Yn."-".$dn;
	$SQL1 = $db->query("SELECT * FROM p_survey WHERE s_id = '$s_id' and s_approve = 'Y' and ( '$dn' between s_start and s_end )");
	if(!$rows = mysql_num_rows($SQL1) and $allowUser==0){
		$SQLX = $db->query("SELECT * FROM p_survey WHERE s_id = '$s_id' ");
		$PX = $db->db_fetch_array($SQLX);
		?>
		<script language="javascript">
			//window.location.href="<?php if($PX[start_page]!=""){ echo $PX[start_page]; }else{ echo "survey_error.php"; } ?>";
		</script>
		<?php
//exit;
	}else{
		if(getenv(HTTP_X_FORWARDED_FOR)){
			$IPn = getenv(HTTP_X_FORWARDED_FOR);
		}else{
			$IPn = getenv("REMOTE_ADDR");
		}
		$SQL11 = $db->query("SELECT * FROM p_ip WHERE p_id = '$s_id' and ip = '$IPn'");
		if($pasformgenerator == "Yes"){
				$SQLX = $db->query("SELECT * FROM p_survey WHERE s_id = '$s_id' ");
					$PX = $db->db_fetch_array($SQLX);
				?>
					<table width="80%" border="0" align="center" cellpadding="3" cellspacing="1" bgcolor="#660000">
					  <tr>
						<td align="center"  bgcolor="#FFBF80"><?php echo $text_genSurvey_warning;?></td>
					  </tr>
					</table>
		<?php
		//exit;
		}else{
			if($_SESSION["EWT_MID"]){
			  	$SQL1 = $db->query("SELECT * FROM p_survey WHERE s_id = '$s_id' and s_approve = 'Y' ");
			}
			$PR = $db->db_fetch_array($SQL1);
			@include("../survey_default.ewt");
			?>
			<table width="80%" border="0" align="center" cellpadding="3" cellspacing="1" style="display:none" bgcolor="#660000" id="tbsuccess<?php echo $BID; ?>">
			  <tr>
				<td align="center"  bgcolor="#FFBF80"><?php echo $text_genSurvey_waiting;?></td>
			  </tr>
			</table>
<?php
$SQL = $db->query("SELECT DISTINCT(p_cate.c_id),p_cate.c_d,p_cate.c_name,p_cate.c_title,p_cate.c_gp,p_cate.option1,p_cate.option2 FROM p_cate,p_question WHERE p_cate.s_id = '$s_id' AND p_cate.c_id = p_question.c_id ORDER BY p_cate.c_d ASC");
?>
<form name="Surveyform<?php echo $BID; ?>" method="post" onSubmit="return GoNext();" action="survey_preview.php" enctype="multipart/form-data" >
<div align="center">
  <font color="<?php echo $SubjectMainC; ?>" size="<?php echo $SubjectMainS; ?>" face="<?php echo $SubjectMainF; ?>"><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><?php if($SubjectMainB=="Y"){ echo "<b>"; } ?><?php if($SubjectMainI=="Y"){ echo "<em>"; } ?><?php echo $PR[s_title]; ?><?php if($SubjectMainI=="Y"){ echo "</em>"; } ?><?php if($SubjectMainB=="Y"){ echo "</b>"; } ?></font></font>
</div>
  <?php 
if($PR[file_page] != ""){
  ?>
<div align="left"><font  size="2" face="<?php echo $SubjectMainF; ?>"><a href="<?php echo $PR[file_page]; ?>" target="_blank"><?php echo $text_genSurvey_attachfile;?><font color="<?php echo $head_font_color;?>"  face="<?php echo $head_font_face;?>"><?php echo $PR[file_page]; ?></font></a></font></div>
  <?php
  }	  
    while($R=$db->db_fetch_array($SQL)){  
  ?>
   <br>
	<?php
	if($R[c_gp] =="Y" ){
	?>
		<table border="0" width="100%" align="center" cellpadding="3" cellspacing="1"  >
	  <tr>
	    <td colspan="<?php echo $R[option2]+2; ?>" ><?php if($SubjectPartB=="Y"){ echo "<b>"; } ?><?php if($SubjectPartI=="Y"){ echo "<em>"; } ?><?php echo $PartName1." ".$R[c_d]; if($R[c_name] !=""){ echo " : ".$R[c_name]; }  ?><?php if($SubjectPartI=="Y"){ echo "</em>"; } ?><?php if($SubjectPartB=="Y"){ echo "</b>"; } ?>
	    <?php if($DescPartB=="Y"){ echo "<b>"; } ?><?php if($DescPartI=="Y"){ echo "<em>"; } ?><?php  if($R[c_title] !=""){ echo "<br>".$DescName1." : ".$R[c_title]; }  ?><?php if($DescPartI=="Y"){ echo "</em>"; } ?><?php if($DescPartB=="Y"){ echo "</b>"; } ?></td>
      </tr>
		
	  <tr>
	    <td width="1%" rowspan="2" align="left" ><?php if($Head1B=="Y"){ echo "<b>"; } ?><?php if($Head1I=="Y"){ echo "<em>"; } ?><?php echo $HeadName1; ?><?php if($Head1I=="Y"){ echo "</em>"; } ?><?php if($Head1B=="Y"){ echo "</b>"; } ?></td>
	    <td width="50%" rowspan="2" align="center" ><?php if($Head1B=="Y"){ echo "<b>"; } ?><?php if($Head1I=="Y"){ echo "<em>"; } ?><?php echo $HeadName2; ?><?php if($Head1I=="Y"){ echo "</em>"; } ?><?php if($Head1B=="Y"){ echo "</b>"; } ?></td>
	    <td colspan="<?php echo $R[option2]; ?>" align="center" ><?php if($Head1B=="Y"){ echo "<b>"; } ?><?php if($Head1I=="Y"){ echo "<em>"; } ?><?php echo $HeadName3; ?><?php if($Head1I=="Y"){ echo "</em>"; } ?><?php if($Head1B=="Y"){ echo "</b>"; } ?></td>
	  </tr>
	<tr>
	    <?php
	$SQL2 = $db->query("SELECT DISTINCT(p_ans.a_name) FROM p_ans,p_question WHERE p_question.c_id = '$R[c_id]' AND p_question.q_id = p_ans.q_id ORDER BY p_ans.option3");	
		 while($Q = $db->db_fetch_array($SQL2)){  ?>		
	    <td align="left" ><?php if($Head2B=="Y"){ echo "<b>"; } ?><?php if($Head2I=="Y"){ echo "<em>"; } ?>
<?php echo $Q[a_name]; ?>
	    <?php if($Head2I=="Y"){ echo "</em>"; } ?><?php if($Head2B=="Y"){ echo "</b>"; } ?></td>
<?php } ?>	
	</tr>
	<?php $SSS = $db->query("SELECT * FROM p_question WHERE c_id = '$R[c_id]' ORDER BY q_pos ASC"); 
	while($X = $db->db_fetch_array($SSS)){
	?>
		  <tr>		  
	    <td align="left" ><?php if($Question2B=="Y"){ echo "<b>"; } ?><?php if($Question2I=="Y"){ echo "<em>"; } ?>     
	      <?php echo $X[q_name]; ?><?php if($Question2I=="Y"){ echo "</em>"; } ?><?php if($Question2B=="Y"){ echo "</b>"; } ?><?php if($X[q_req]=="Y"){ echo "<font color='#FF0000'>*</font>"; } ?></td>
	    <td ><?php if($Question2B=="Y"){ echo "<b>"; } ?><?php if($Question2I=="Y"){ echo "<em>"; } ?><?php echo $X[q_des]; ?><?php if($Question2I=="Y"){ echo "</em>"; } ?><?php if($Question2B=="Y"){ echo "</b>"; } ?></td>
	   <?php
	$SQL2 = $db->query("SELECT DISTINCT(p_ans.a_name) FROM p_ans,p_question WHERE p_question.c_id = '$R[c_id]' AND p_question.q_id = p_ans.q_id ORDER BY p_ans.option3");	
		$a=0;
		 while($Q = $db->db_fetch_array($SQL2)){ ?>		
	    <td align="center" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>">
		<?php if($R[option1]=="A"){ ?>
	      <input type="radio" name="ans<?php echo $X[q_id]; ?>" value="<?php echo $Q[a_name]; ?>" >
		  <?php }else{ ?>
	      <input type="checkbox" name="ans<?php echo $X[q_id]; ?>_<?php echo $a; ?>" value="<?php echo $Q[a_name]; ?>" >
		  <?php } ?>
	    </td>
<?php
$a++;
 } ?>
	  </tr>
<?php } ?>	  	
  </table>
  <?php 
	}else{//else  if line 1520
	?>
	<table border="0" width="100%" align="center" cellpadding="0" cellspacing="0"  >
	  <tr bgcolor="<?php echo $SubjectPartBGC; ?>">
	    <td colspan="2"  ><?php if($SubjectPartB=="Y"){ echo "<b>"; } ?><?php if($SubjectPartI=="Y"){ echo "<em>"; } ?><?php echo $PartName1." ".$R[c_d]; if($R[c_name] !=""){ echo " : ".$R[c_name]; }  ?><?php if($SubjectPartI=="Y"){ echo "</em>"; } ?><?php if($SubjectPartB=="Y"){ echo "</b>"; } ?><?php if($DescPartB=="Y"){ echo "<b>"; } ?><?php if($DescPartI=="Y"){ echo "<em>"; } ?><?php  if($R[c_title] !=""){ echo "<br>".$DescName1." : ".$R[c_title]; }  ?><?php if($DescPartI=="Y"){ echo "</em>"; } ?><?php if($DescPartB=="Y"){ echo "</b>"; } ?></td>
    </tr>
	<?php $SSS = $db->query("SELECT * FROM p_question WHERE c_id = '$R[c_id]' ORDER BY q_pos ASC"); 
	while($X = $db->db_fetch_array($SSS)){
	?>		
	  <tr >
	    <td ><?php if($Question1B=="Y"){ echo "<b>"; } ?><?php if($Question1I=="Y"){ echo "<em>"; } ?><?php echo $X[q_name]; ?>  <?php if($Question1I=="Y"){ echo "</em>"; } ?><?php if($Question1B=="Y"){ echo "</b>"; } ?><?php if($X[q_req]=="Y"){ echo "<font color='#FF0000'>*</font>"; } ?></td>
	    <td width="100%" >	      
	      <?php if($Question1B=="Y"){ echo "<b>"; } ?><?php if($Question1I=="Y"){ echo "<em>"; } ?><?php echo $X[q_des]; ?><?php if($Question1I=="Y"){ echo "</em>"; } ?><?php if($Question1B=="Y"){ echo "</b>"; } ?>
        </td>
    </tr>

		  <tr >		  
	    <td width="143" >&nbsp;</td>
	    <td  ><div align="left"><?php if($Answer1B=="Y"){ echo "<b>"; } ?><?php if($Answer1I=="Y"){ echo "<em>"; } ?>
			<?php	
			$SSS1 = $db->query("SELECT * FROM p_ans WHERE q_id = '$X[q_id]' ORDER BY option3 ASC"); 
			if($X[q_anstype]=="D"){ 
			if($RrRows = mysql_num_rows($SSS1)){
			$Z = $db->db_fetch_array($SSS1);
			if($Z[a_other]=="S"){  ?>
			<input name="ans<?php echo $X[q_id]; ?>" type="text" <?php if($Z[option4] != ""){ echo " size=\"$Z[option4]\" ";}  if($Z[option3] != ""){ echo " maxlength=\"$Z[option3]\" ";} ?> value="<?php echo $Z[a_name] ?>">
	<?php		}else{ ?>
	<textarea name="ans<?php echo $X[q_id]; ?>" <?php if($Z[option4] != ""){ echo " cols=\"$Z[option4]\" ";}  if($Z[option3] != ""){ echo " rows=\"$Z[option3]\" ";} ?> wrap="VIRTUAL" ><?php echo $Z[a_name] ?></textarea>
<?php	}			
			}else{ ?>
			<textarea name="ans<?php echo $X[q_id]; ?>" cols="50" rows="3" wrap="VIRTUAL" id="ans<?php echo $X[q_id]; ?>"></textarea>
	<?php		}
			}elseif($X[q_anstype]=="A"){
			$p=0;
	while($Z = $db->db_fetch_array($SSS1)){
		$answer_ex = explode("#@form#img@#",$Z[a_name]);
	?>
		<input name="ans<?php echo $X[q_id]; ?>" type="radio" value="<?php echo $Z[a_name]; ?>" <?php if($Z[option4] == "Y"){  echo "checked"; } ?>> 
		<?php 
			  if($answer_ex[1] != ""){
	  echo "<img src=\"".$answer_ex[1]."\"  align=\"absmiddle\">";
	  }
		echo $answer_ex[0]; ?>
		<?php if($Z[a_other]=="Y"){ ?> <input name="oth<?php echo $X[q_id]; ?>_<?php echo $p; ?>" type="text">  
		<?php } ?><br>
		
		<?php $p++; }
		}elseif($X[q_anstype]=="B"){
		$p = 0;
while($Z = $db->db_fetch_array($SSS1)){
	$answer_ex = explode("#@form#img@#",$Z[a_name]);
	?>
		<input name="ans<?php echo $X[q_id]; ?>_<?php echo $p; ?>" type="checkbox" value="<?php echo $Z[a_name]; ?>" <?php if($Z[option4] == "Y"){  echo "checked"; } ?>> 
		<?php 
			  if($answer_ex[1] != ""){
	  echo "<img src=\"".$answer_ex[1]."\"  align=\"absmiddle\">";
	  }
		echo $answer_ex[0]; ?>
		<?php if($Z[a_other]=="Y"){ ?>  <input name="oth<?php echo $X[q_id]; ?>_<?php echo $p; ?>" type="text">  
		<?php } ?><br>
		
		<?php $p++;  }		
		}elseif($X[q_anstype]=="C"){ ?>
		<select name="ans<?php echo $X[q_id]; ?>" >
<?php while($Z = $db->db_fetch_array($SSS1)){
			$answer_ex = explode("#@form#img@#",$Z[a_name]);
	?>
		 <option value="<?php echo $answer_ex[0]; ?>" <?php if($Z[option4] == "Y"){  echo "selected"; } ?>><?php echo $answer_ex[0]; ?></option>
		
		<?php } ?>
		</select>
		<?php		
		}else if($X[q_anstype]=="E"){
		if($RrRows = mysql_num_rows($SSS1)){
			$Z = $db->db_fetch_array($SSS1);?>
			กรุณาแนบเอกสารเรื่อง <?php echo $Z[a_name]; ?><br>
			<input type="file" name="file<?php echo $X[q_id]; ?>"><br>
ขนาดไฟล์ที่สามารถส่งได้ <?php echo number_format($Z[a_other],0); ?> KB.
	<?php		}
		}else if($X[q_anstype]=="F"){
		?>
		<input name="start_date<?php echo $X[q_id]; ?>"  readonly="" type="text" size="15" value="<?php echo date("d")."/".date("m")."/".(date("Y")+543); ?>">
             <a href="#date" onClick="return showCalendar('start_date<?php echo $X[q_id]; ?>', 'dd-mm-y');" ><img src="mainpic/b_calendar.gif" width=20 height=20 border=0  ></a>
		<?php
		}else if($X[q_anstype]=="G"){
		genjava_ddwlist1call2 ("SELECT p_code, a_code, a_name FROM   amphur","p_code","a_name","a_code",1,'Y',"- เลือกอำเภอ -                            ");
		
		?>
		
		<table width="500"  border="0" cellspacing="1" cellpadding="1">
                            <tr>
                              <td > จังหวัด</td>
                              <td ><select name="addr_prov<?php echo $X[q_id];?>"  id="addr_prov<?php echo $X[q_id];?>"  
															onChange="
																selectChange(this, document.getElementById('addr_amp<?php echo $X[q_id];?>'), arrItemsTxt1,arrItemsValue1,arrItemsGrp1,'');
																document.getElementById('addr_tamb<?php echo $X[q_id];?>').value='';
																">
                                <option value="" selected>- เลือกจังหวัด -
                                  <?php echo $tab.' '.$tab?>
                                </option>
                                <?php
								$db->query("USE ".$EWT_DB_USER);
								$sql_province = "select * from province ORDER BY p_name ASC";
								$query_province = $db->query($sql_province);
								while($rec_province = $db->db_fetch_array($query_province)){
								?>
								<option value="<?php echo $rec_province[p_code];?>"><?php echo $rec_province[p_name];?></option>
								<?php
								}
								$db->query("USE ".$EWT_DB_NAME);
								?>
                              </select>                                        </td>
                              <td >อำเภอ</td>
                              <td ><select name="addr_amp<?php echo $X[q_id];?>"  id="addr_amp<?php echo $X[q_id];?>"
															onFocus="
																if(document.getElementById('addr_prov<?php echo $X[q_id];?>').value==''){
																	alert('-เลือกจังหวัด-'); 
																	document.getElementById('addr_prov<?php echo $X[q_id];?>').focus();
																}"
																onChange="
																txt_area( document.getElementById('addr_prov<?php echo $X[q_id];?>').value,this.value,'<?php echo $X[q_id];?>');
																"
															>
                                <option value="">- เลือกอำเภอ -
                                  <?php echo $tab.$tab.$tab?>
                                </option>
                                 
                              </select>                                              </td>
                            </tr>
                            <tr>
                              <td > ตำบล</td>
                              <td ><div id="nav<?php echo $X[q_id];?>" >
								<select name="addr_tamb<?php echo $X[q_id];?>"  id="addr_tamb<?php echo $X[q_id];?>"
															onFocus="
																if(document.getElementById('addr_amp<?php echo $X[q_id];?>').value==''){
																	alert('เลือกอำเภอ'); 
																}"
															>
                                <option value="">- ตำบล -
                                  <?php echo $tab.$tab.$tab?>
                                  </option>
                              </select></div></td>
                              <td >&nbsp;</td>
                              <td >&nbsp;</td>
                            </tr>
          </table>
		<?php
		}
		?>
		<?php if($Answer1I=="Y"){ echo "</em>"; } ?><?php if($Answer1B=="Y"){ echo "</b>"; } ?></div></td>

	  </tr>
<?php } ?>	  	
  </table>
	<?php }//enf if line 1520?>
  <?php } //end while line 1516?>
  <table border="0" width="100%" align="center" cellpadding="3" cellspacing="1"  >
  <tr>
    <td >      <div align="right">
        <input name="s_id" type="hidden" id="s_id" value="<?php echo $s_id; ?>">
		<input name="mid" type="hidden" id="mid" value="<?php echo $mid; ?>">
		<input name="BID" type="hidden" id="BID" value="<?php echo $BID; ?>">
        <input name="filename" type="hidden"  value="<?php echo $filename; ?>">
		<input name="setflag" type="hidden" id="setflag" value="0">
		<input type="submit" name="Submit" value="<?php echo $text_genSurvey_submit_but?>">
        <input type="reset" name="Submit2" value="<?php echo $text_genSurvey_reset_but?>">
      </div></td></tr>
</table>
</form>
<script language="javascript" type="text/javascript" >
function GoNext(){
<?php
$SSSS = $db->query("SELECT * FROM p_question,p_cate WHERE p_cate.s_id='$s_id' AND p_cate.c_id = p_question.c_id AND (p_question.q_req = 'Y' OR p_question.q_req = 'E') AND p_question.q_anstype != 'B' AND p_cate.option1 != 'B' ");
if($gg = mysql_num_rows($SSSS)){
while($TT = $db->db_fetch_array($SSSS)){
if($TT[q_anstype]=="D"){
if($TT[q_req] == "Y"){
?>
if(document.Surveyform<?php echo $BID; ?>.elements["ans"+<?php echo $TT[q_id]; ?>].value =="" ){
		alert("<?php echo $text_genSurvey_alertA1;?> <?php echo $TT[q_name]; ?> <?php echo $text_genSurvey_alertA2;?> <?php echo $TT[c_d]; ?> <?php echo $text_genSurvey_alertA3;?>");
		document.Surveyform<?php echo $BID; ?>.elements["ans"+<?php echo $TT[q_id]; ?>].focus();
		return false;
}
<?php
}elseif($TT[q_req] == "E"){
?>
 	if(document.Surveyform<?php echo $BID; ?>.elements["ans"+<?php echo $TT[q_id]; ?>].value == ""){
		alert('<?php echo $text_genSurvey_alertmail1;?>');
		document.Surveyform<?php echo $BID; ?>.elements["ans"+<?php echo $TT[q_id]; ?>].focus();
		return false;
	}else if((document.Surveyform<?php echo $BID; ?>.elements["ans"+<?php echo $TT[q_id]; ?>].value.search("^.+@.+\\..+$") == -1)){
		alert('<?php echo $text_genSurvey_alertmail1;?>');
		document.Surveyform<?php echo $BID; ?>.elements["ans"+<?php echo $TT[q_id]; ?>].select();
		return false;
	}
<?php
}
}elseif(($TT[q_anstype]=="A")or($TT[q_anstype]=="")){
?>
var x = 0;
for (var i=0; i<document.Surveyform<?php echo $BID; ?>.ans<?php echo  $TT[q_id]; ?>.length; i++) {
         if (document.Surveyform<?php echo $BID; ?>.ans<?php echo  $TT[q_id]; ?>[i].checked) {
            var x = 1;
         }
      }
	if(x==0){
	alert("<?php echo $text_genSurvey_alertA1;?> <?php echo $TT[q_name]; ?> <?php echo $text_genSurvey_alertA2;?> <?php echo $TT[c_d]; ?> <?php echo $text_genSurvey_alertA3;?>");
	document.Surveyform<?php echo $BID; ?>.ans<?php echo  $TT[q_id]; ?>[0].focus();
	return false;
	}  
	<?php
}else if($TT[q_anstype]=="E"){
if($TT[q_req] == "Y"){
?>
if(document.Surveyform<?php echo $BID; ?>.elements["file"+<?php echo $TT[q_id]; ?>].value =="" ){
		alert("<?php echo $text_genSurvey_alertA1;?> <?php echo $TT[q_name]; ?> <?php echo $text_genSurvey_alertA2;?> <?php echo $TT[c_d]; ?> <?php echo $text_genSurvey_alertA3;?>");
		document.Surveyform<?php echo $BID; ?>.elements["file"+<?php echo $TT[q_id]; ?>].focus();
		return false;
}
<?php
}


}else if($TT[q_anstype]=="F"){
if($TT[q_req] == "Y"){
?>
if(document.Surveyform<?php echo $BID; ?>.elements["start_date"+<?php echo $TT[q_id]; ?>].value =="" ){
		alert("<?php echo $text_genSurvey_alertA1;?> <?php echo $TT[q_name]; ?> <?php echo $text_genSurvey_alertA2;?> <?php echo $TT[c_d]; ?> <?php echo $text_genSurvey_alertA3;?>");
		document.Surveyform<?php echo $BID; ?>.elements["start_date"+<?php echo $TT[q_id]; ?>].focus();
		return false;
}
<?php
}
}else if($TT[q_anstype]=="G"){
if($TT[q_req] == "Y"){
?>
if(document.Surveyform<?php echo $BID; ?>.elements["addr_prov"+<?php echo $TT[q_id]; ?>].value =="" ){
		alert("<?php echo $text_genSurvey_alertA1;?> <?php echo $TT[q_name]; ?> <?php echo $text_genSurvey_alertA2;?> <?php echo $TT[c_d]; ?> <?php echo $text_genSurvey_alertA3;?>");
		document.Surveyform<?php echo $BID; ?>.elements["addr_prov"+<?php echo $TT[q_id]; ?>].focus();
		return false;
}
if(document.Surveyform<?php echo $BID; ?>.elements["addr_amp"+<?php echo $TT[q_id]; ?>].value =="" ){
		alert("<?php echo $text_genSurvey_alertA1;?> <?php echo $TT[q_name]; ?> <?php echo $text_genSurvey_alertA2;?> <?php echo $TT[c_d]; ?> <?php echo $text_genSurvey_alertA3;?>");
		document.Surveyform<?php echo $BID; ?>.elements["addr_amp"+<?php echo $TT[q_id]; ?>].focus();
		return false;
}
if(document.Surveyform<?php echo $BID; ?>.elements["addr_tamb"+<?php echo $TT[q_id]; ?>].value =="" ){
		alert("<?php echo $text_genSurvey_alertA1;?> <?php echo $TT[q_name]; ?> <?php echo $text_genSurvey_alertA2;?> <?php echo $TT[c_d]; ?> <?php echo $text_genSurvey_alertA3;?>");
		document.Surveyform<?php echo $BID; ?>.elements["addr_tamb"+<?php echo $TT[q_id]; ?>].focus();
		return false;
}
<?php
}
}
}}
?>
if(document.Surveyform<?php echo $BID; ?>.setflag.value == "1"){
Surveyform<?php echo $BID; ?>.target = "_self";
Surveyform<?php echo $BID; ?>.enctype = "multipart/form-data";
Surveyform<?php echo $BID; ?>.action = "survey_function.php";
Surveyform<?php echo $BID; ?>.submit();
}else{ 
Surveyform<?php echo $BID; ?>.target = "ewt<?php echo $BID; ?>ewt";
Surveyform<?php echo $BID; ?>.enctype = "multipart/form-data";
window.open("","ewt<?php echo $BID; ?>ewt","scrollbars=1,resizable=1");
Surveyform<?php echo $BID; ?>.action = "survey_preview.php";
Surveyform<?php echo $BID; ?>.submit();
}
}

	</script>
<?php
		}
	}
}
 
}
function  genjava_ddwlist1call2 ($sql,$fieldGrp,$fieldTxt,$fieldValue,$ddwlistNum,$showFunc,$firstField) {
global $db,$EWT_DB_NAME,$EWT_DB_USER;
$db->query("USE ".$EWT_DB_USER);
								
								
		 //Use in page : onchange="selectChange(this, form1.sale_id, arrItemsTxt,arrItemsValue ,arrItemsGrp);"
		 $nl = "\n"; // New line
         echo '<SCRIPT LANGUAGE="JavaScript">'.$nl;
         echo '<!-- Begin '.$nl;
		 echo 'var arrItemsTxt'.$ddwlistNum.' = new Array();'.$nl;
		 echo 'var arrItemsValue'.$ddwlistNum.' = new Array();'.$nl;
		 echo 'var arrItemsGrp'.$ddwlistNum.' = new Array();'.$nl.$nl;
         //Create variable
		  $query         = $db->query ($sql);
		  $numRows  = $db->db_num_rows ($query);
          for ($i=0;$i < $numRows;$i++) {
          $result = $db->db_fetch_array ($query);
          echo 'arrItemsGrp'.$ddwlistNum.'['.$i.'] = "'.$result[$fieldGrp].'";'.$nl;
          echo 'arrItemsTxt'.$ddwlistNum.'['.$i.'] = "'.$result[$fieldTxt].'";'.$nl;
          echo 'arrItemsValue'.$ddwlistNum.'['.$i.'] = "'.$result[$fieldValue].'";'.$nl;
		  }//for
		 // Java function
		 if ($showFunc=='Y') {
         echo $nl.'function selectChange(control, controlToPopulate, ItemArrayTxt,ItemArrayValue, GroupArray,selectedValue)'.$nl;
         echo '{'.$nl;
         echo 'var myEle ;'.$nl;
         echo 'var x ;'.$nl;
         echo '// Empty the second drop down box of any choices'.$nl;
		 echo 'for (var q=controlToPopulate.options.length;q>=0;q--) controlToPopulate.options[q]=null;'.$nl;
         echo '// ADD Default Choice - in case there are no values'.$nl;
         echo 'myEle = document.createElement("option") ;'.$nl;
		
		 if (!empty($firstField)) {
			  echo 'myEle.value=0;'.$nl;
			  echo 'myEle.text="'.$firstField.'";'.$nl;
			  echo 'controlToPopulate.add(myEle) ;'.$nl;
		 }
		 echo 'for ( x = 0 ; x < ItemArrayTxt.length  ; x++ )'.$nl;
         echo   '{'.$nl;
         echo '    if ( GroupArray[x] == control.value)'.$nl;
         echo '   {'.$nl;
         echo 'myEle = document.createElement("option") ;'.$nl;
         echo ' myEle.text = ItemArrayTxt[x] ;'.$nl;
		 echo ' myEle.value= ItemArrayValue[x] ;'.$nl;

		 echo 'if (ItemArrayValue[x]==selectedValue)'.$nl;
		 echo '   myEle.selected=true;'.$nl;
         echo '   controlToPopulate.add(myEle) ;'.$nl;
         echo '   }'.$nl;
         echo ' }'.$nl;
         echo '}'.$nl;
		 }
		 echo '//  End -->'.$nl;
		 echo '</SCRIPT>';
		 $db->query("USE ".$EWT_DB_NAME);
	 }//end if line 1844
function GenPic2($data){
	$s = explode("_",$data);
	for($i=1;$i<count($s);$i++){
		echo "<img src=\"../../../images/o.gif\" width=\"20\" height=\"20\" border=\"0\" alt=\"show\">";
	}
}

	function genOrgChart2($gen_id) {
						global $db;
						global $filename;
						global $staff_flag,$lang_sh;
						global $mainwidth;
						$lang_shw = substr($lang_sh , 1);
						if($staff_flag == 1) {
							$sql_org = $db->query("SELECT * FROM org_name where parent_org_id = '".$gen_id."'");
							$R = $db->db_fetch_array($sql_org);
							
							$sql_user = $db->query("SELECT * FROM gen_user where org_id = '".$R["org_id"]."' order by level_id ASC");
							$return = '
							
							<tr>
								<td align="center" valign="top">
									<table width="95%" border="0" cellspacing="0" cellpadding="0" style="padding:5px 5px 5px 5px; border:1px solid #000000;" class="childOrg">
										<tr>
											<td>
												<div id="body_wrap">
													<div id="content">
														<table width="100%" border="0" cellspacing="0" cellpadding="0"  style="padding:5px 5px 5px 5px;">
															<tr>
																<td valign="middle" align="center">
														<ul class="gallery">';
													while($R_user = $db->db_fetch_array($sql_user)){
							$sql_title = "select * from title where title_id = '".$R_user['title_thai']."'";
							$query_title = $db->query($sql_title);
							$result_title = $db->db_fetch_array($query_title);
							if($lang_sh != ''){
							$R_user["name_thai"] = select_lang_detail_ewt($R_user[gen_user_id],$lang_shw,'name_thai','gen_user');
							$R_user["surname_thai"] = select_lang_detail_ewt($R_user[gen_user_id],$lang_shw,'surname_thai','gen_user');
							$R_user["position_person"] = select_lang_detail_ewt($R_user[gen_user_id],$lang_shw,'position_person','gen_user');
								if($R_user["name_thai"] != ''){
								$result_title["title_thai"] = select_lang_detail_ewt($result_title[title_id],$lang_shw,'title_thai','title');
								}else{
								$result_title["title_thai"] =  '';
								}
							}

							if($R_user[path_image] != ""){
								$path_image= "../../pic_upload/".$R_user[path_image];
								if (file_exists($path_image)) {
									$path_image=$path_image;
								}else{
									$path_image="../images/ImageFile.gif";
								}
							}else{
							$path_image="../images/ImageFile.gif";
							}
														$return .= '
															<li>
																<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="padding:5px 5px 5px 5px; border:1px solid #000000;" class="childOrg">
																	<tr onClick="window.open(\'staff_info.php?filename='.$filename.'&amp;gen_user_id='.$R_user["gen_user_id"].'\',\'staff_info\',\'width=600 , height=550, scrollbars=1,resizable = 0\');" style="cursor:hand">
																		<td>
																			<table width="100%" border="0" cellspacing="0" cellpadding="0" bgcolor="#FFFFFF" style="padding:5px 5px 5px 5px;">
																				<tr>
																					<td valign="middle" align="center"><img src="img.php?p='.base64_encode($path_image).'" name="previewField" width="50" height="50"style="border:1px solid #555;"  alt="'.$R_user["name_thai"].'&nbsp;'.$R_user["surname_thai"].'"></td>
																				</tr>
																				<tr>
																					<td align="center" valign="middle" height="25">'.$R_user["name_thai"].'&nbsp;'.$R_user["surname_thai"].'</td>
																				</tr>
																			</table>
																		</td>
																	</tr>
																</table>
															</li>';
															}
														$return .= '
														</ul></td>
										</tr>
									</table>
													</div>
												</div>';
							$return .= '	</td>
										</tr>
									</table>
								</td>
							</tr>';
						} else {
							$sql_group = $db->query("SELECT * FROM org_name where parent_org_id LIKE '".$gen_id."\_____' ORDER BY parent_org_id ASC");
							$return = '
							<tr>
								<td align="center" valign="top">
									<table width="100%" border="0" cellspacing="0" cellpadding="0">
										<tr>';
							$i = 1;
							$max = $db->db_num_rows($sql_group);
							if($max > 1) { $tb_width = $mainwidth/(floor($max/2)); } else { $tb_width = $mainwidth; }
							while($R = $db->db_fetch_array($sql_group)){
								if($i == 1) { $bgcolor1 = ''; } else { $bgcolor1 = '#000000'; }
								if($i == $max) { $bgcolor2 = ''; } else { $bgcolor2 = '#000000'; }
								//if(trim($R["short_name"]) == '') { $text_name = $R["name_org"]; } else { $text_name = $R["short_name"]; }
								$text_name = $R["name_org"];
								if( $lang_sh!= ''){
								$text_name = select_lang_detail_ewt($R[org_id],$lang_shw,'name_org','org_name');
								}
								$logo = "img.php?p=".base64_encode("../../../MemberMgt/pic_org/".$R[org_pics]);
								$map = "../../../MemberMgt/pic_org/".$R[org_map];
								$area = "../../../MemberMgt/pic_org/".$R[org_area];
								if($R["org_color"] == '') { $R["org_color"] = '#FFFFFF'; }
								if($R[org_pics] != ''){ $logo = $logo; } else { $logo = "img.php?p=".base64_encode("../mainpic/no_pic_2.gif"); }
								if($R[org_map] != ''){ $map = "<a href=\"img.php?p=".base64_encode($map)." target=\"_blank\"> ??????".$R[name_org]."</a>"; } else { $map = ""; }
								if($R[org_area] != ''){ $area =  "<a href=\"img.php?p=".base64_encode($area)." target=\"_blank\"> ?????????".$R[name_org]."</a>"; } else { $area = ""; }
								$sql_child = $db->query("SELECT * FROM org_name where parent_org_id LIKE '".$R["parent_org_id"]."\_____' ORDER BY parent_org_id ASC");
								$child = $db->db_num_rows($sql_child);	
								$return .= '
											<td align="center" valign="top">
												<table width="100%" border="0" cellspacing="0" cellpadding="0">';
								$return .= '		
													<tr>
														<td width="'.((100%$max)*2).'%">
															<table width="100%" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td align="center" style="background:url(img.php?p='.base64_encode("../mainpic/hline2.gif").');background-repeat:repeat-y; background-position:center;height:15px" valign="top" >
																		<table width="100%" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td width="50%" height="1" bgcolor="'.$bgcolor1.'"> </td>
																				<td width="50%" height="1" bgcolor="'.$bgcolor2.'"> </td>
																			</tr>
																		</table>
																	</td>';
								if($i+1 == 1) { $bgcolor1 = ''; } else { $bgcolor1 = '#000000'; }
								if($i+1 == $max) { $bgcolor2 = ''; } else { $bgcolor2 = '#000000'; }
								if($i+1 <= $max) {
										$return .= '
																	<td width="30px"  style="background:url(img.php?p='.base64_encode("../mainpic/hline2.gif").');background-repeat:repeat-y; background-position:center;height:15px" valign="top" >
																		<table width="30" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td width="15" height="1" bgcolor="'.$bgcolor1.'"> </td>
																				<td width="15" height="1" bgcolor="'.$bgcolor2.'"> </td>
																			</tr>
																		</table>
																	</td>';
								} else {
										$return .= '
																	<td width="30px"valign="top" height="15"> </td>';
								}
								$return .= '
																</tr>
																<tr>
																	<td align="center" valign="middle">
																		<table width="100%" border="0" cellspacing="0" cellpadding="0">
																			<tr>
																				<td>
																		<table width="100%" border="0" cellspacing="0" cellpadding="1" style="padding:0px 0px 0px 0px; border:1px solid #000000;height:80px"  bgcolor="'.$R["org_color"].'" class="childOrg">
																			<tr>
																				<td align="center" valign="middle"><div style="width=100%; height=100%" class="gradient"><table width="100%" border="0" cellspacing="0" cellpadding="1" style="height:100%">
																			<tr>
																				<td align="center" valign="middle"><span class="text_normal">';
																				if($child > 0) {
																				$return .= '<a href="?org_id='.$R[org_id].'&amp;filename='.$filename.'">'.$text_name.'</a>';
																				} else {
																				$return .= '<a href="?org_id='.$R[org_id].'&amp;filename='.$filename.'&amp;staff_flag=1">'.$text_name.'</a>';
																				}
																				$return .= '</span></td>
																			</tr>
																		</table></div></td>
																			</tr>
																		</table><br></td>
																			</tr>
																		</table>
																	</td>';
								
								if($i+1 <= $max) {
								$return .= '
																	<td width="30px" style="background:url(img.php?p='.base64_encode("../mainpic/hline2.gif").');background-repeat:repeat-y; background-position:center"><img src="img.php?p='.base64_encode("../mainpic/blank.gif").'" width="30" height="10" border="0" alt="blank"></td>';
								} else {
								$return .= '<td width="30px" style="background-repeat:repeat-y; background-position:center"><img src="img.php?p='.base64_encode("../mainpic/blank.gif").'" width="30" height="10" border="0" alt ="blank"></td>';
								}
								$return .= '
																</tr>
															</table>
														</td>
													</tr>';
								$i++;
								$R = $db->db_fetch_array($sql_group);
								$sql_child = $db->query("SELECT * FROM org_name where parent_org_id LIKE '".$R["parent_org_id"]."\_____' ORDER BY parent_org_id ASC");
								$child = $db->db_num_rows($sql_child);	
								//if(trim($R["short_name"]) == '') { $text_name = $R["name_org"]; } else { $text_name = $R["short_name"]; }
								$text_name = $R["name_org"];
								if($lang_sh != ''){
								$text_name  = select_lang_detail_ewt($R[org_id],$lang_shw,'name_org','org_name');
								}
								$logo = "img.php?p=".base64_encode("../../../MemberMgt/pic_org/".$R[org_pics]);
								$map = "../../../MemberMgt/pic_org/".$R[org_map];
								$area = "../../../MemberMgt/pic_org/".$R[org_area];
								if($R["org_color"] == '') { $R["org_color"] = '#FFFFFF'; }
								if($R[org_pics] != ''){ $logo = $logo; } else { $logo = "img.php?p=".base64_encode("../mainpic/no_pic_2.gif"); }
								if($R[org_map] != ''){ $map = "<a href=\"img.php?p=".base64_encode($map)." target=\"_blank\"> $text_genchat_map".$R[name_org]."</a>"; } else { $map = ""; }
								if($R[org_area] != ''){ $area =  "<a href=\"img.php?p=".base64_encode($area)." target=\"_blank\"> $text_genchat_place".$R[name_org]."</a>"; } else { $area = ""; }
								$return .= '		<tr>
														<td>';
								if($i <= $max) {
								
								$return .= '
															<table width="100%" border="0" cellspacing="0" cellpadding="0">
																<tr>
																	<td width="10px"><img src="img.php?p='.base64_encode("../mainpic/blank.gif").'" width="10" height="10" border="0" alt="blank"></td>
																	<td align="center" valign="middle">
																		<table width="100%" border="0" cellspacing="0" cellpadding="1" style="padding:0px 0px 0px 0px; border:1px solid #000000;height:80px" bgcolor="'.$R["org_color"].'" class="childOrg">
																			<tr>
																				<td align="center" valign="middle"><div style="width=100%; height=100%" class="gradient"><table width="100%" border="0" cellspacing="0" cellpadding="1" style="height:100%">
																			<tr>
																				<td align="center" valign="middle"><span class="text_normal">';
																				if($child > 0) {
																				$return .= '<a href="?org_id='.$R[org_id].'&amp;filename='.$filename.'">'.$text_name.'</a>';
																				} else {
																				$return .= '<a href="?org_id='.$R[org_id].'&amp;filename='.$filename.'&amp;staff_flag=1">'.$text_name.'</a>';
																				}
																				$return .= '</span></td>
																			</tr>
																		</table></div></td>
																			</tr>
																		</table>
																	</td>
																</tr>
															</table>';
								} else {
								$return .= '&nbsp;';
								}
								$return .= '
														</td>
													</tr>';
								$return .= '	</table>
											</td>';
								$i++;
							}
							$return .= '
										</tr>
									</table>
								</td>
							</tr>';
						}
						return $return;
					}
						function genOrgChart($up_id) {
						global $db,$lang_sh;
						global $mainwidth;
						$lang_shw = substr($lang_sh , 1);
						$sql_order = "select * from gen_user_order where up_user_id = '".$up_id."' order by order_no asc";
						$query_order = $db->query($sql_order);
						$return = '
						<tr>
							<td align="center" valign="top">
								<table width="100%" border="0" cellspacing="0" cellpadding="0">
									<tr>';
						$i = 1;
						$max = $db->db_num_rows($query_order);
						while($result_order = $db->db_fetch_array($query_order)) {
							if($i == 1) { $bgcolor1 = 'border-top:0px solid #FFFFFF;'; } else { $bgcolor1 = 'border-top:1px solid #000000;'; }
							if($i == $max) { $bgcolor2 = 'border-top:0px solid #FFFFFF;'; } else { $bgcolor2 = 'border-top:1px solid #000000;'; }
							$sql_staff = "select * from gen_user  LEFT OUTER JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`) where gen_user_id = '".$result_order['gen_user_id']."'";
							$query_staff = $db->query($sql_staff);
							$result_staff = $db->db_fetch_array($query_staff);
							$sql_title = "select * from title where title_id = '".$result_staff['title_thai']."' ";
							$query_title = $db->query($sql_title);
							$result_title = $db->db_fetch_array($query_title);
							$sql_position_staff = "select * from position_name where pos_id = '".$result_staff['posittion']."'";
							$query_position_staff = $db->query($sql_position_staff);
							$result_position_staff = $db->db_fetch_array($query_position_staff);
							if($result_staff[path_image] != ""){
								$path_image= "../pic_upload/".$result_staff[path_image];
								if (file_exists($path_image)) {
									$path_image=$path_image;
								}else{
									$path_image="../images/ImageFile.gif";
								}
							}
							
							$return .= '
										<td align="center" valign="top">
											<table width="100%" border="0" cellspacing="0" cellpadding="0">';
							if($max == 1) {
								$return .= '
												<tr>
													<td align="center"><img src="img.php?p='.base64_encode("mainpic/horizonline.gif").'" width="1" height="13" border="0" align="absmiddle"></td>
												</tr>';
							} else {
								$return .= '
												<tr>
													<td align="center" width="100%">
														<table width="100%" border="0" cellspacing="0" cellpadding="0">
															<tr>
																<td width="50%">
																	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="'.$bgcolor1.'">
																		<tr><td> </td></tr>
																	</table>
																</td>
																<td align="center" valign="bottom" bgcolor="#000000" height="14px"><img src="img.php?p='.base64_encode("mainpic/hline2.gif").'" width="1" height="13" border="0" align="absmiddle"></td>
																<td width="50%">
																	<table width="100%" height="100%" border="0" cellspacing="0" cellpadding="0" style="'.$bgcolor2.'">
																		<tr><td> </td></tr>
																	</table>
																</td>
															</tr>
														</table>
													</td>
												</tr>';
							}
							if($lang_sh != ''){
							$result_position_staff['pos_name'] = select_lang_detail_ewt($result_position_staff['pos_id'],$lang_shw,'pos_name','position_name');
							$result_title['title_thai'] = select_lang_detail_ewt($result_title['title_id'],$lang_shw,'title_thai','title');
							$result_staff['name_thai'] = select_lang_detail_ewt($result_staff['gen_user_id'],$lang_shw,'name_thai','gen_user');
							$result_staff['surname_thai'] = select_lang_detail_ewt($result_staff['gen_user_id'],$lang_shw,'surname_thai','gen_user');
								if($result_staff['name_thai'] == ''){
								$result_title['title_thai']  ='';
								}
							}
							$return .= '
												<tr>
													<td align="center" valign="middle" style="padding:1px 1px 1px 1px;">
														<table width="90px" cellspacing="0" cellpadding="0">
															<tr>
																<td align="center" valign="middle">
																	<table width="90px" height="120px" border="0" cellspacing="0" cellpadding="0" class="orgchartperson" style="border:1px solid #FAC663; background-color:#FFF3D9;">
																		<tr>
																			<td align="center" valign="middle">
																				<div style="margin:10px 3px 5px 3px">
																				<img src="img.php?p='.base64_encode($path_image).'" name="previewField" width="75" height="75" id="previewField" style="border:1px solid #555;" />
																				</div>
																			</td>
																		</tr>
																		<tr>
																			<td align="center" valign="middle" height="25" style="FONT-WEIGHT: normal; FONT-SIZE: 10px; COLOR: #000000; FONT-FAMILY: \'Tahoma\'"><nobr>'.$result_title["title_thai"].$result_staff["name_thai"].'&nbsp;'.$result_staff["surname_thai"].'</nobr></td>
																		</tr>
																		<tr>
																			<td align="center" valign="middle" height="25" style="FONT-WEIGHT: normal; FONT-SIZE: 10px; COLOR: #000000; FONT-FAMILY: \'Tahoma\'"><strong>'.$result_position_staff["pos_name"].'</strong></td>
																		</tr>
																	</table>
																</td>
															</tr>';
							$sql_child = $db->query("select * from gen_user_order where up_user_id = '".$result_staff["gen_user_id"]."' order by order_no asc");
							$child = $db->db_num_rows($sql_child);	
							if($child > 0) {
								$return .= '
															<tr>
																<td align="center"><img src="img.php?p='.base64_encode("mainpic/horizonline.gif").'" width="1" height="13" border="0" align="absmiddle"></td>
															</tr>';
							}
							$return .= genOrgChart($result_staff["gen_user_id"]);
							$return .= '				</table>
													</td>
												</tr>
											</table>
										</td>';
							$i++;
						}
						$return .= '
									</tr>
								</table>
							</td>
						</tr>';
						return $return;
					}
function GenChart($org){
global $db,$EWT_DB_USER;
	@include("../language/language".$lang_sh.".php");
	$uploaddir = "../../pic_upload/";
	$o = explode(",",$org);
	$org_id = $o[0];
	$type = $o[1];
	$sname = $o[2];
	$spic = $o[3];
	$sdetail = $o[4];
	$db->query("USE ".$EWT_DB_USER);
	if($type == "1"){
	$sql_group1 = $db->query("SELECT * FROM org_name WHERE org_id = '".$org_id."' ");
		$R = $db->db_fetch_array($sql_group1);
		$logo = "../../../MemberMgt/pic_org/".$R[org_pics];
		$map = "../../../MemberMgt/pic_org/".$R[org_map];
		$area = "../../../MemberMgt/pic_org/".$R[org_area];
		if(file_exists($logo) && $R[org_pics] != ''){ $logo = $logo; } else { $logo = "../../../images/a_no_pic.gif"; }
		if(file_exists($map) && $R[org_map] != ''){ $map = "<a href=\"../img.php?p=".base64_encode($map)." target=\"_blank\" alt=\"แผนที่\"> แผนที่".$R[name_org]."</a>"; } else { $map = ""; }
		if(file_exists($area) && $R[org_area] != ''){ $area =  "<a href=\"../img.php?p=".base64_encode($area)." alt=\"ภาพสถานที่\" target=\"_blank\"> ภาพสถานที่".$R[name_org]."</a>"; } else { $area = ""; }
		?>
		<table width="96%" border="0" align="center" cellpadding="3" cellspacing="0">
		<tr>
			<td align="center" bgcolor="<?php if($R[org_color] != ''){ echo $R[org_color]; } else { echo "#EEEEEE"; } ?>"><font size="4"><strong><span class="text_head"><?php echo $R[name_org]; ?></span></strong></font>
				<?php if($sdetail == "Y"){ ?>
				<hr size="1">
				<table width="95%" border="0" align="center" cellpadding="3" cellspacing="0" style="FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #000000; FONT-FAMILY: Tahoma">
					<tr> 
						<td width="31%" class="bg_color_row"><span class="text_normal"><?php echo $text_genchat_location;?> :</span></td>
						<td width="69%"><span class="text_normal"><?php echo $R[org_place] ?></span></td>
						<td width="69%" align="center"><span class="text_normal"><?php echo $text_genchat_logo;?></span></td>
					</tr>
					<tr> 
						<td class="bg_color_row"><span class="text_normal"><?php echo $text_genchat_addess;?> :</span></td>
						<td><span class="text_normal"><?php echo $R[org_address] ?></span></td>
						<td rowspan="9" align="center"><img src="img.php?p=<?php echo base64_encode($logo); ?>" width="98" height="98" alt="logo"></td>
					</tr>
					<tr> 
						<td class="bg_color_row"><span class="text_normal"><?php echo $text_genchat_phonin;?> :</span></td>
						<td><span class="text_normal"><?php echo $R[tel] ?></span></td>
					</tr>
					<tr> 
						<td class="bg_color_row"><span class="text_normal"><?php echo $text_genchat_fax;?> :</span></td>
						<td><span class="text_normal"><?php echo $R[fax] ?></span></td>
					</tr>
					<tr> 
						<td class="bg_color_row"><span class="text_normal"><?php echo $text_genchat_email;?> : </span></td>
						<td><span class="text_normal"><?php echo $R[email] ?></span></td>
					</tr>
					<tr> 
						<td class="bg_color_row"><span class="text_normal"><?php echo $text_genchat_url;?> :</span></td>
						<td><span class="text_normal"><?php echo $R[org_url] ?></span></td>
					</tr>
					<tr>
						<td class="bg_color_row"><span class="text_normal"><?php echo $text_genchat_objective;?> :</span></td>
						<td><span class="text_normal"><?php echo $R[org_object]; ?></span></td>
					</tr>
					<tr>
						<td class="bg_color_row"><span class="text_normal"><?php echo $text_genchat_map;?> :</span></td>
						<td><span class="text_normal"><?php echo $map;?></span></td>
					</tr>
					<tr>
						<td class="bg_color_row"><span class="text_normal"><?php echo $text_genchat_place;?> :</span></td>
						<td><span class="text_normal"><?php echo $area;?></span></td>
					</tr>
					<tr>
						<td class="bg_color_row">&nbsp;</td>
						<td>&nbsp;</td>
					</tr>
				</table>
				<?php } ?>
			</td>
		</tr>
	</table>
	<br>
	<?php
		$sql_position = $db->query("SELECT distinct(pos_name) AS pos_name ,pos_id FROM position_name INNER JOIN gen_user ON position_name.pos_id = gen_user.posittion WHERE gen_user.org_id = '".$R["org_id"]."' ORDER BY position_name.pos_level ASC ");
		while($P = $db->db_fetch_array($sql_position)){
	?>
	<table width="96%" border="0" align="center" cellpadding="3" cellspacing="2">
		<tr><td align="center" bgcolor="<?php if($R[org_color] != ''){ echo $R[org_color];}else{ echo "#F7F7F7";} ?>"><font size="1"  face="MS Sans Serif"><b><span class="text_head"><?php echo $P["pos_name"]; ?></span></b></font></td></tr>
		<tr><td align="center" >&nbsp;</td></tr>
		<tr>
			<td>
			<?php
				$sql_user = $db->query("SELECT * FROM gen_user WHERE posittion = '".$P["pos_id"]."' AND org_id = '".$R["org_id"]."'  order by org_type_id DESC,name_thai  ASC ");
				$x=0;
				while($U = $db->db_fetch_array($sql_user)){
					$path_image=$U[path_image];
					if($path_image != ''){
						$path_image22 = $uploaddir.$path_image;
						if(file_exists($path_image22)){
							$path_image2 = $path_image22;
						}else{
							$path_image2 = "../../../images/ImageFile.gif";
						}
					}else{
						$path_image2 = "../../../images/ImageFile.gif";
					}
					if($x%3 == 0){
						echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\"><tr>";
					}
			?>
			<td align="center" valign="top" width="33%"><?php if($spic == "Y"){ ?><img src="img.php?p=<?php echo base64_encode($path_image2); ?>" width="98" height="98" alt="<?php echo $U["name_thai"]; ?> <?php echo $U["surname_thai"]; ?>"><?php } ?><?php if($sname == "Y"){ ?><div><font size="2"><span class="text_normal"><?php echo $U["name_thai"]; ?> <?php echo $U["surname_thai"]; ?><br><?php echo $U["position_person"]; ?></span></font><?php } ?></div></td>
			<?php 
					$x++;
					if($x%3 == 0){
						echo "</tr></table><br>";
					}
				} 
				if($x%3==1 OR $x%3==2){
					echo "</tr></table><br>";
				}
			?>
			</td>
		</tr>
	</table>
	<?php 
			$sql_position2 = $db->query("SELECT * FROM gen_user  WHERE gen_user.org_id = '".$R["org_id"]."' and posittion = '' order by org_type_id DESC,name_thai  ASC ");
		if($db->db_num_rows($sql_position2) >0){
	?>
	<table width="96%" border="0" align="center" cellpadding="3" cellspacing="2">
		<tr><td align="center" bgcolor="<?php if($R[org_color] != ''){ echo $R[org_color];}else{ echo "#F7F7F7";} ?>"><font size="1"  face="MS Sans Serif"><b><span class="text_normal">เจ้าหน้าที่</span></b></font></td></tr>
		<tr><td align="center" >&nbsp;</td></tr>
		<tr>
			<td>
			<?php
				$sql_user2 = $db->query("SELECT * FROM gen_user WHERE  gen_user.org_id = '".$R["org_id"]."' and posittion = '' order by org_type_id DESC,name_thai  ASC ");
				$x=0;
				while($U2 = $db->db_fetch_array($sql_user2)){
					$path_image=$U2[path_image];
					if($path_image != ''){
						$path_image22 = $uploaddir.$path_image;
						if(file_exists($path_image22)){
							$path_image2 = $path_image22;
						}else{
							$path_image2 = "../../../images/ImageFile.gif";
						}
					}else{
						$path_image2 = "../../../images/ImageFile.gif";
					}
					if($x%3 == 0){
						echo "<table width=\"100%\" border=\"0\" cellspacing=\"0\" cellpadding=\"3\"><tr>";
					}
			?>
			<td align="center" valign="top" width="33%"><?php if($spic == "Y"){ ?><img src="img.php?p=<?php echo base64_encode($path_image2); ?>" width="98" height="98" alt="<?php echo $U2["name_thai"]; ?> <?php echo $U2["surname_thai"]; ?>"><?php } ?><?php if($sname == "Y"){ ?><div><font size="2"><span class="text_normal"><?php echo $U2["name_thai"]; ?> <?php echo $U2["surname_thai"]; ?><br><?php echo $U2["position_person"]; ?></span></font><?php } ?></div></td>
			<?php 
					$x++;
					if($x%3 == 0){
						echo "</tr></table><br>";
					}
				} 
				if($x%3==1 OR $x%3==2){
					echo "</tr></table><br>";
				}
			?>
			</td>
		</tr>
	</table>
	<?php 
			}
			}
		}else if($type == "0"){//else if line 1911
			?>
	<script language="JavaScript" type="text/javascript">
		function divshow(c,d){
			if(c.style.display == ""){
				c.style.display = 'none';
				d.src = "../mainpic/plus.gif";
			}else{
				c.style.display = '';
				d.src = "../mainpic/minus.gif";
			}
		}
		function divshow1(c){
			win5 = window.open('ewt_org.php?oid='+c+'&amp;org=<?php echo $org; ?>','org','height=500,width=600,resizable=1,scrollbars=1');
			win5.focus();
		}
	</script>
	<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr><td>&nbsp;</td></tr>
	</table>
	<table width="98%" border="0" align="center" cellpadding="0" cellspacing="0" style="FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #000000; FONT-FAMILY: Tahoma">
		<tr> 
			<td>
				<?php
					$sql_group1 = $db->query("SELECT parent_org_id FROM org_name WHERE org_id = '".$org_id."' ");
					$R1 = $db->db_fetch_array($sql_group1);
					$sql_group = $db->query("SELECT * FROM org_name WHERE parent_org_id LIKE '".$R1["parent_org_id"]."%' ORDER BY parent_org_id ASC");
					$i = 0;
					$k = 0;
					$LenChk =0;
					while($R = $db->db_fetch_array($sql_group)){
						$sql_sub = $db->query("SELECT COUNT(org_id) FROM org_name WHERE parent_org_id LIKE '".$R["parent_org_id"]."_%'");
						$count_sub = $db->db_fetch_row($sql_sub);
						$len = GenLen($R["parent_org_id"],"_");
						if($LenChk > $len ){
							for($y=$len;$y<$LenChk;$y++){
								echo "</div>";
							}
						}
						$LenChk = $len;
				?>
				<div>
				<?php
						GenPic2($R["parent_org_id"]);
						if($count_sub[0] > 0){ 
				?>
				<img src="../../../images/minus.gif" border="0" alt="show" onClick="divshow(document.all.dv<?php echo $i; ?>,this)">
				<?php 
						}else{ 
				?>
				<img src="../../../images/o.gif" width="20" height="20" border="0" alt="hidden">
				<?php 
						} 
				?>
				<a href="#show" onClick="divshow1('<?php echo $R["org_id"]; ?>')"><img src="../../../images/user_group.gif" width="20" height="20" border="0" alt="หน่วยงาน">&nbsp;<span class="text_normal"><?php echo $R["name_org"]; ?></span></a> 
				<?php
						$k++;
						if($count_sub[0] > 0){ echo "<div id=\"dv".$i."\"  >"; }  
						$i++; 
					} 
				?>
				</div>
			</td>
		</tr>
	</table>
	<?php
		} else if($type == "2") {
		if(isset($_GET['org_id'])) {
			$org_id = $_GET['org_id'];
		}
		global $filename;
		global $staff_flag;
	?>
	<script type="text/javascript"  language="javascript" src="../js/jquery/jquery.corner.js"></script>
	<script type="text/javascript" language="javascript" src="../js/jquery/jquery.dimensions.js"></script>
	<script type="text/javascript"  language="javascript" src="../js/jquery/jquery.gradient.js"></script>
	<script language="javascript" type="text/javascript">
	$(document).ready( function() {
		$('.gradient').gradient({
			from:      'FFFFFF',
			to:        'FFFFFF',
			direction: 'horizontal'
		});
		$(".childOrg").corner("10px");
	});
	</script>
	<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td>&nbsp;</td>
		</tr>
	</table>
	<table width="98%" border="0" align="center"   cellpadding="0" cellspacing="0" style="FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #000000; FONT-FAMILY: Tahoma">
		<tr> 
			<td><br>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<?php
					
					$sql_group2 = $db->query("SELECT * FROM org_name where org_id = '".$org_id."' ORDER BY parent_org_id ASC");
					$R2 = $db->db_fetch_array($sql_group2);
					$logo = "img.php?p=".base64_encode("../../../MemberMgt/pic_org/".$R2[org_pics]);
					$map = "../../../MemberMgt/pic_org/".$R2[org_map];
					$area = "../../../MemberMgt/pic_org/".$R2[org_area];
					if($R2["org_color"] == '') { $R2["org_color"] = '#FFFFFF'; }
					if($R2[org_pics] != ''){ $logo = $logo; } else { $logo = "img.php?p=".base64_encode("../mainpic/no_pic_2.gif"); }
					if($R2[org_map] != ''){ $map = "<a href=\"img.php?p=".base64_encode($map)." target=\"_blank\"> $text_genchat_map".$R2[name_org]."</a>"; } else { $map = ""; }
					if($R2[org_area] != ''){ $area =  "<a href=\"img.php?p=".base64_encode($area)." target=\"_blank\"> $text_genchat_place".$R2[name_org]."</a>"; } else { $area = ""; }
					$sql_child = $db->query("SELECT * FROM org_name where parent_org_id LIKE '".$R2["parent_org_id"]."\_____' ORDER BY parent_org_id ASC");
					$child = $db->db_num_rows($sql_child);
					if($child == 0) {
					$staff_flag=1;
					}	
					$org_code = explode("_", $R2["parent_org_id"]);
					if(count($org_code) == 1) {
						$parent = 0;
					} else {
						$parent = 1;
						$code = array_pop($org_code);
						$parent_code = implode("_", $org_code);
						$sql_parent = $db->query("SELECT * FROM org_name where parent_org_id = '".$parent_code."'");
						$row_parent = $db->db_fetch_array($sql_parent);	
					}
								if($lang_sh != ''){
								$R2["name_org"] = select_lang_detail_ewt($R2[org_id],$lang_shw,'name_org','org_name');
								}
				?>
				<?php
				if($parent) {
					echo '
					<tr>
						<td align="center" valign="top">
							<table width="300" border="0" cellspacing="0" cellpadding="0">
								<tr><td align="center" valign="middle"><a href="?org_id='.$row_parent['org_id'].'&amp;filename='.$filename.'"><img src="img.php?p='.base64_encode("../mainpic/navigate_open.gif").'" border="0" alt="navigate_open.gif"></a></td></tr>
							</table>
						</td>
					</tr>';
				}
				?>
					<tr>
						<td align="center" valign="top">
							<table width="300" border="0" cellspacing="0" cellpadding="0" style="padding:0px 0px 0px 0px; border:1px solid #000000; height:80px"  bgcolor="<?php echo $R2["org_color"];?>" class="childOrg">
								<tr><td align="center" valign="middle"><table width="100%"  style="height:100%" border="0" cellspacing="0" cellpadding="0" >
																			<tr>
																				<td align="center" valign="middle"><div style="width=100%; height=100%" class="gradient"><table width="100%" border="0" cellspacing="0" cellpadding="1" style="height:100%">
																			<tr>
																				<td align="center" valign="middle">
													<strong><?php echo $R2["name_org"]; ?></strong>
												</td></tr></table></div></td></tr>
							</table></td></tr>
							</table>
						</td>
					</tr>
					<tr>
						<td align="center" valign="top">
							<table width="300" border="0" cellspacing="0" cellpadding="0">
								<tr><td align="center" valign="middle"><img src="img.php?p=<?php echo base64_encode("../mainpic/horizonline.gif"); ?>" width="11" height="20" border="0"  alt="horizonline.gif"></td></tr>
							</table>
						</td>
					</tr>
					<?php
						echo genOrgChart2($R2["parent_org_id"]);
					?>
				</table><br>
			</td>
		</tr>
	</table>
	<br>
<?php
	}else if($type == "3") {
		global $mainwidth;
	?>
	<script type="text/javascript" language="javascript" src="../js/jquery/jquery.corner.js"></script>
	<script language="javascript" ttype="text/javascript" >
		$(document).ready(function(){
			$(".orgchartperson").corner("10px");
		});
	</script>
	<table width="90%" border="0" align="center" cellpadding="0" cellspacing="0">
		<tr>
			<td>&nbsp;</td>
		</tr>
	</table>
	<table width="98%" border="0" bgcolor="#FFFFFF" align="center" cellpadding="0" cellspacing="0" style="FONT-WEIGHT: normal; FONT-SIZE: 13px; COLOR: #000000; FONT-FAMILY: Tahoma">
		<tr> 
			<td>
				<table width="100%" border="0" cellspacing="0" cellpadding="0">
				<?php
					
					$sql_position_id = "select min(pos_level), pos_id from position_name group by pos_id";
					$query_position_id = $db->query($sql_position_id);
					$result_position_id = $db->db_fetch_array($query_position_id);
					$position_level = $result_position_id[0];
					$position_id= $result_position_id[1];
					$sql_current_pos = "select * from position_name where pos_id = '".$position_id."'";
					$query_current_pos = $db->query($sql_current_pos);
					$result_current_pos = $db->db_fetch_array($query_current_pos);
					$position_level = $result_current_pos['pos_level'];
					$sql_staff = "select * from gen_user LEFT OUTER JOIN `org_name` ON (`gen_user`.`org_id` = `org_name`.`org_id`) where gen_user.posittion = '".$position_id."' ";
					$query_staff = $db->query($sql_staff);
				?>
					<tr>
				<?php
					while($result_staff = $db->db_fetch_array($query_staff)) {
						$sql_order = "select * from gen_user_order where gen_user_id = '".$result_staff['gen_user_id']."'";
						$query_order = $db->query($sql_order);
						$sql_title = "select * from title where title_id = '".$result_staff['title_thai']."'";
						$query_title = $db->query($sql_title);
						$result_title = $db->db_fetch_array($query_title);
						$sql_position_staff = "select * from position_name where pos_id = '".$result_staff['posittion']."'";
						$query_position_staff = $db->query($sql_position_staff);
						$result_position_staff = $db->db_fetch_array($query_position_staff);
						if($result_staff[path_image] != ""){
							$path_image= "../../pic_upload/".$result_staff[path_image];
							if (file_exists($path_image)) {
								$path_image=$path_image;
							}else{
								$path_image="../images/ImageFile.gif";
							}
						}
					if($lang_sh != ''){
					$result_position_staff['pos_name'] = select_lang_detail_ewt($result_position_staff['pos_id'],$lang_shw,'pos_name','position_name');
					$result_title['title_thai'] = select_lang_detail_ewt($result_title['title_id'],$lang_shw,'title_thai','title');
					$result_staff['name_thai'] = select_lang_detail_ewt($result_staff['gen_user_id'],$lang_shw,'name_thai','gen_user');
					$result_staff['surname_thai'] = select_lang_detail_ewt($result_staff['gen_user_id'],$lang_shw,'surname_thai','gen_user');
						if($result_staff['name_thai'] ==''){
						$result_title['title_thai']  =='';
						}
					}
				?>
						<td align="center" valign="top">
							<table width="100%" cellspacing="0" cellpadding="0">
								<tr>
									<td align="center" valign="middle">
										<table width="<?php echo ($mainwidth-300)/2;?>px" height="120px" border="0" cellspacing="0" cellpadding="0" class="orgchartperson" style="border:1px solid #FAC663; background-color:#FFF3D9;">
											<tr>
												<td align="center" valign="middle">
													<div style="margin:5px 5px 5px 5px">
													<img src="img.php?p=<?php echo base64_encode($path_image); ?>" name="previewField" width="80" height="80" id="previewField" style="border:1px solid #555;" />
													</div>
												</td>
											</tr>
											<tr>
												<td align="center" valign="middle" height="25"><strong><?php echo $result_position_staff['pos_name']?></strong></td>
											</tr>
											<tr>
												<td align="center" valign="middle" height="25"><nobr>&nbsp;(<?php echo $result_title['title_thai']; ?><?php echo $result_staff['name_thai']; ?>&nbsp;<?php echo $result_staff['surname_thai']; ?>)&nbsp;</nobr></td>
											</tr>
										</table>
									</td>
								</tr>
								<?php
									$sql_child = $db->query("select * from gen_user_order where up_user_id = '".$result_staff["gen_user_id"]."' order by order_no asc");
									$child = $db->db_num_rows($sql_child);	
									if($child > 0) {
										echo '
								<tr>
									<td align="center"><img src="img.php?p='.base64_encode("../mainpic/horizonline.gif").'" width="11" height="13" border="0" align="absmiddle"></td>
								</tr>';
									}
									echo genOrgChart($result_staff['gen_user_id']);
								?>
							</table>
						</td>
				<?php
					}
				?>
					</tr>
				</table>
				<div id="lightbox" style="display:none"></div>
			</td>
		</tr>
	</table>
	<br >
<?php
	}//end if line 1911
	if($_SESSION["EWT_SDB"] != ""){
		$db->query("USE ".$_SESSION["EWT_SDB"]);
	}else{
		global $EWT_DB_NAME;
		$db->query("USE ".$EWT_DB_NAME);
	}
}//end if line 1900
function GenWebboard($text_id,$BID){
global $db;
global $filename;
global $mainwidth;
global $global_theme;
global $lang_sh;
$target = '_self';
@include("../language/language".$lang_sh.".php");
$e = explode("_",$text_id);
$c = count($e);
$txt = " AND ( 0 ";
	for($i=0;$i<$c;$i++){
		if($e[$i] != ""){
			$txt .= " OR w_cate.c_id = '".$e[$i]."' ";
		}
	}
	$txt .= " ) ";
	if($lang_sh != ''){
	$sql = "SELECT * FROM w_cate 
		INNER JOIN lang_w_cate ON lang_w_cate.c_id =w_cate.c_id
		INNER JOIN lang_config ON lang_config.lang_config_id = lang_w_cate.lang_name 
		WHERE  c_use = 'Y' and lang_field = 'c_name'".$txt;
	}else{
	$sql = "SELECT * FROM w_cate WHERE c_use = 'Y' ".$txt;
	}
	$Execsql = $db->query($sql);
	if($db->db_num_rows($Execsql) > 0){
	$sql = $db->query("select block_themes from block where BID = '".$BID."' ");
	$rec = $db->db_fetch_array($sql);
	?>
<form name="formSearchWEBB" method="post" action="search_result.php?filename=<?php echo $filename; ?>&amp;search_mode=4" target="_blank">
		<table width="90%" border="0" align="center" cellpadding="3" cellspacing="0" class="styleMe">
		  <tr>
			<td align="right" >
								<input type="text" name="keyword">
								<input type="submit" name="search" value="<?php echo $text_genwebboard_buttom_search;?>" >      </td>
		  </tr>
		</table>
</form>	
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC" >
     <tr>
        <td align="center" bgcolor="#FFFFFF">
	<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0" >
   <tbody>   
   <tr>
       <td ><table width="100%" border="0" cellspacing="0" cellpadding="0">
         <tr>
           <td  align="center"><?php echo $text_genwebboard_cat;?></td>
           <td width="20%" align="center"><?php echo $text_genwebboard_numqu;?></td>
           <td width="20%" align="center"><?php echo $text_genwebboard_numanw;?></td>
         </tr>
       </table><hr ></td>
     </tr>
     <tr>
       <td ><table width="100%" border="0" align="center" cellpadding="1" cellspacing="1"  >
<?php
   while($R = $db->db_fetch_array($Execsql)){
   if($lang_sh != ''){
   $R[c_name] = $R[lang_detail];
   $R[c_detail] = select_lang_detail($R[c_id],$lang_shw,"c_detail",w_cate);
   }
   if($R["c_rss"]=='Y'){
			 $filename1="rss/webboard".$R["c_id"].".xml";
			 if(file_exists($filename1)){
			     $link='<a href="rss/webboard'.$R["c_id"].'.xml" target="_blank"><img src="mainpic/ico_rss.gif" border="0" alt="RSS"> </a>';
			 }else{
			     $link='';
			 }
		}else{ $link='';
		}
   $count = $db->query("SELECT * FROM w_question WHERE c_id = '$R[c_id]' AND s_id = '1' AND t_date >= '$dateshowl'");
   $countrow = mysql_num_rows($count);
  $count1 = $db->query("SELECT DISTINCT(w_answer.a_id) FROM w_answer,w_question WHERE w_question.t_id = w_answer.t_id AND w_question.c_id = '$R[c_id]' AND w_answer.s_id = '1' ");
   $countrow1 = mysql_num_rows($count1);
   ?>
    <tr onMouseOver="this.style.backgroundColor='#E7E7E7'" onMouseOut="this.style.backgroundColor='<?php echo $body_color;?>'"  > 
      <td width="4%" align="center" valign="top"><br >
        <?php if($R[c_view] == "Y"){ ?><img src="../mainpic/lock.gif" width="24" height="24"  alt="permission"><?php }else{ ?><img src="../mainpic/book_blue.gif" width="24" height="24" alt="personal"><?php } ?></td>
      
    <td align="left"  valign="top" >
	  <a href="index_question.php?wcad=<?php echo $R[c_id]; ?>&amp;filename=<?php echo $filename; ?>&amp;t=<?php echo $rec[block_themes]; ?>"><?php  echo stripslashes($R[c_name]); ?></a><?php echo $link;?>
     	<br >
     	<span class="text_normal"><?php  echo stripslashes(nl2br ($R[c_detail])); ?></span></td>
      <td width="20%" align="center"><span class="text_normal"><?php echo $countrow; ?></span></td>
      <td width="20%"  align="center"><span class="text_normal"><?php echo $countrow1; ?></span></td>
    </tr>
    <?php }?>
</table></td>
     </tr>
  </tbody>
</table>

	</td>
     </tr>
</table>
	<?php
	}//enf if line 2602
}//end if line 2577
 function GenGallery($BID){
 	global $db;
	global $mainwidth;
	global $global_theme;
	 global $filename;
	 global $lang_sh;
 @include("../language/language".$lang_sh.".php");
  	$sql = $db->query("select * from block where BID = '".$BID."' ");
	$rec = $db->db_fetch_array($sql);
	$block_link=explode("@",$rec[block_link]);
	$type_choi = $block_link[0];
	$row = $block_link[1]*$block_link[2];
	$cal = $block_link[2];
	 ?>

 <form name="gallery<?php echo $category_id; ?>" action="" method="post">
<?php
$w = 100;
if($type_choi == '2'){
$cat_id = array();
$sql_g = "select * from gallery_tmp_cat_img where tmp_id = '".$BID."'";
$query = $db->query($sql_g);
	if($db->db_num_rows($query) > 0){
		while($R = $db->db_fetch_array($query)){
			array_push($cat_id,$R[category_id]);
		}
		$wh = "WHERE category_id IN (".implode(",", $cat_id).")";
		$wh1 = "and category_id IN (".implode(",", $cat_id).")";
		$cal = 3;
		$row = count($cat_id);
		
	}
}
    $w= $w/$cal;

	$sql_category = "SELECT * FROM gallery_category  $wh  order by cat_timestamp DESC,category_id DESC";


	$query_category = $db->query($sql_category);
	$num_rows_2  = $db->db_num_rows($query_category);
	if($num_rows_2<$row){
	$row = $num_rows_2;
	}
?>
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="1" >
     <tr>
        <td align="center"  >

                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0"  >
					  <tr>
						<td colspan="<?php echo $row;?>"  valign="middle" ><?php echo $text_GenGallery_cat;?></td>
					  </tr>
                  <?php 
					if($num_rows_2 > 0){
						for($i=1;$i<=$row;$i++){
							$rs_img = $db->db_fetch_array($query_category);
							if($lang_sh != ''){
								$rs_img[category_name] = $rs_img[lang_detail];
							}
							$sql_img = $db->query("select * from gallery_image,gallery_cat_img where gallery_cat_img.img_id=gallery_image.img_id and gallery_cat_img.category_id = '".$rs_img[category_id]."' order by gallery_image.img_id ASC");
							$rec_img = $db->db_fetch_array($sql_img);
							$img_p = $rec_img[img_path_s];
							if (!file_exists('../'.$rec_img[img_path_s]) ) {
									$img_p = "../mainpic/no-download.gif";
							}
							if($i%$cal == 0 || $i==1) {
							?>
                  <tr > 
					<?php }?>
                   <td >
					
                      <table width="100%" border="0" cellpadding="3" cellspacing="1" >
						<tr >
                          <td    align="center" valign="bottom"  ><table width="50"  border="0" cellpadding="6" cellspacing="1" bgcolor="C3C3C3"><tr><td align="center" bgcolor="#FFFFFF" ><a href="gallery_view_catelogy.php?category_id=<?php echo $rs_img[category_id];?>&amp;filename=<?php echo $filename;?>"><img src="../<?php echo $img_p;?>"  width="150" height="150"  alt="<?php echo nl2br($rs_img[category_name]);?>" style="border:1px #C3C3C3 double ; padding:5px;"></a></td></tr></table></td></tr>
						  <tr valign="top" ><td  height="50" align="center" ><?php echo nl2br($rs_img[category_name]);?></td>
						  
				        </tr>
                        </table>
						</td>
						  <?php
							if($i%$cal == 0 ) {
							?>
                    </tr>
                  <?php }?>
                  <?php 
						}// end for
						?>
						<tr><td align="right" colspan="<?php echo $cal;?>" ><a href="gallery_view_catelogy_all.php?flag=all&amp;filename=<?php echo $filename;?>&amp;BID=<?php echo $BID;?>"><?php echo $text_GenGallery_viewall;?></a></td></tr>
						<?php
					}else{//end if num_rows_2
				?>
                  <tr><td align="center" style="color:#FF0000"><?php echo $text_GenGallery_notfound;?></td></tr>
                  <?php }?>
                  </table>	
				  
				  	</td>
     </tr>
</table>
				
</form>
 <?php
}//end if line 2672 GenGallery
function GenFontSize($BID){
global $db;
global $mainwidth;
global $global_theme;

$sql = $db->query("select block_themes from block where BID = '$BID' ");
$count_rec = $db->db_num_rows($sql);
$rec = $db->db_fetch_array($sql);
?>
<TABLE cellSpacing=1 cellPadding=6 width=120  border=0>
<TBODY>
<TR>
<TD style="FONT-WEIGHT: bold; FONT-SIZE: 11px; COLOR: #555555; FONT-FAMILY: Tahoma; TEXT-DECORATION: none"  bgColor="#FFFFFF">FONTSIZE <A onClick="changeStyle('small');" href="#size"><IMG height=10 src="../mainpic/s.gif" width=10 border=0 alt="small"></A> <A onClick="changeStyle('normal');" href="#size"><IMG height=10 src="../mainpic/n.gif" width=10 border=0 alt="normal"></A> <A onClick="changeStyle('big');" href="#size"><IMG height=10 src="../mainpic/b.gif" width=10 border=0 alt="big"></A> </TD></TR></TBODY></TABLE>
<?php
}//end if line 2770 GenFontSize
function GenBlog($BID){
	@include("../../blog/lib/blog_config.php");
	global $lang_sh; 
	@include("../language/language".$lang_sh.".php");
	 global $db;
	 global $mainwidth;
	 global $global_theme;
	 global $EWT_DB_USER;
	 $sql = $db->query("select * from block where BID = '".$BID."' ");
	$rec = $db->db_fetch_array($sql);
	$s_id=$rec[block_link];
	$db->query("USE ".$EWT_DB_USER);
	?>
	<hr >
	<table width="100%" border="0">
  <tr>
    <td><?php echo $text_GenBlog_update_blog;?></td>
  </tr>
    <?php if($_SESSION["EWT_MID"]){?>
  <tr>
    <td><table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#CC99CC" >
                <tr>
                  <td height="30" align="center" bgcolor="#DEDEEF" ><?php 
		$sql_profile="SELECT * FROM `blog_list` WHERE `blog_list`.`blog_user`='$_SESSION[EWT_MID]' ";
		$exc_profile=mysql_query($sql_profile);
		$count_profile=mysql_num_rows($exc_profile);
		$row_profile=$db->db_fetch_array($exc_profile);
		
		if($count_profile>0){
		?>
                      <a href="../<?php echo $blog_url; ?>?blog_id=<?php echo $row_profile[blog_id]; ?>" target="_blank"><b><?php echo $text_GenBlog_manageblog;?></b></a>
                      <?php
		}else{
		?>
                      <a href="../../blog/blog_install.php" target="_blank"><b><?php echo $text_GenBlog_configblog;?></b></a>
                      <?php
		}
		?></td>
                </tr>
            </table></td>
  </tr>
  <?php } ?>
  <tr>
    <td>
	<?php 
	
		$sql_profile="SELECT * FROM `blog_list` ORDER BY  `blog_list`.`blog_lastdate` DESC LIMIT 0,10";
		$exc_profile=mysql_query($sql_profile);
		$count_profile=mysql_num_rows($exc_profile);
		if($count_profile > 0){
	?>
	
	<table width="100%" border="0" cellpadding="0" cellspacing="5" >
                <?php
		
		while($row_profile=$db->db_fetch_array($exc_profile)){
				$photo_name="nophoto.jpg";
				if($row_profile[blog_picture]){
					$photo_name=$row_profile[blog_picture];
				}
				
				$sp_datetime=split(" ",$row_profile[blog_lastdate]);
				$sp_date=split("-",$sp_datetime[0]);
				$sp_time=split(":",$sp_datetime[1]);
				
	?>
                <tr >
                  <td width="50" height="50" align="center" valign="middle" bgcolor="#CCCCCC"><img src="../phpThumb.php?src=../blog/images_profile/<?php echo $photo_name; ?>&amp;h=48&amp;w=48" border="0" alt="<?php echo $row_profile[blog_title]; ?>"></td>
                  <td valign="top"><div><a href="../<?php echo $blog_url; ?>?blog_id=<?php echo $row_profile[blog_id]; ?>" target="_blank"><b><?php echo $row_profile[blog_title]; ?></b></a></div>
                    <div><b><?php echo $text_GenBlog_Update;?>:</b> <?php echo $sp_date[2]."/".$sp_date[1]."/".($sp_date[0]+543); ?> <?php echo ($sp_time[0]*1).":".$sp_time[1] ?></div></td>
                </tr>
                <?php
	  		}
	  ?>
            </table> <?php } ?></td>
  </tr>
  <tr>
    <td>&raquo; <a href="blog.php" target="_blank"><?php echo $text_GenBlog_showtotal;?></a></td>
  </tr>
</table>
<?php
		  if($_SESSION["EWT_SDB"] != ""){
$db->query("USE ".$_SESSION["EWT_SDB"]);
}else{
global $EWT_DB_NAME;
$db->query("USE ".$EWT_DB_NAME);
}
}
function show_icon_lang1($langid,$type,$body_font_color,$body_font_face,$body_font_size,$body_font_italic,$body_font_bold){//list language
global $db;
global $EWT_FOLDER_USER;
global $filename;  
$Globals_Dir = '';//'../ewt/'.$EWT_FOLDER_USER;
$Globals_Dir1 = 'language';
$lang_exp = explode(',',$langid);
$lang_num = count($lang_exp);
if($lang_num >'1'){
$wh = "WHERE lang_config_id IN (".substr($langid, 0, -1).") ";
}else if($lang_num =='1'){
$wh = "WHERE lang_config_id = '".$langid."' ";
}

		$sql_lang = "select * from lang_config $wh";
		$query = $db->query($sql_lang);
	while($rec_db = $db->db_fetch_array($query)){

		$spacial_text= "";
		 if($body_font_italic=='Y'){$spacial_text= ";font-style:italic"; } 
		 if($body_font_bold=='Y'){ $spacial_text.= ";font-weight:bold";}

		if($rec_db[lang_config_status]=='T'){ $rec_db[lang_config_name] ='thai';}else if($rec_db[lang_config_status]=='E'){ $rec_db[lang_config_name] ='english';}

		if($rec_db[lang_config_img]!='' && $type == 'Y'){ 
		$text .= "<a onclick=\"ChangeLanguage('".$rec_db[lang_config_suffix]."')\" href=\"#language\"><span class=\"text_head\"><img src=\"".$Globals_Dir.$Globals_Dir1."/".$rec_db[lang_config_img]."\" border=\"0\" align=\"absmiddle\"  alt=".$rec_db[lang_config_name]."></span></a>&nbsp; &nbsp;";
		}else{
		
		$text .= "<a onclick=\"ChangeLanguage('".$rec_db[lang_config_suffix]."')\" href=\"#language\"><span class=\"text_head\">".$rec_db[lang_config_name]."</span></a>&nbsp;|&nbsp;";
		}
	}
	return substr($text,0,(strlen($text)-7));
}
function Genlanguage($langid,$BID){
global $db;
global $mainwidth;
global $global_theme;
global $lang_sh;
?>
<table width="100%" border="0" align="center" cellspacing="0" cellpadding="0" >
  <tr  >
    <td align="center"  ><?php echo show_icon_lang1($langid,'Y',$body_font_color,$body_font_face,$body_font_size,$body_font_italic,$body_font_bold);?></td>
  </tr>
</table>
<?php
}
?>
