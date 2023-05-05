<?php
	session_start();
	header ("Content-Type:text/plain;charset=UTF-8");
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	//include("ewt_script.php");
	if($themeid != "0" AND $themeid != ""){
	$namefolder = "themes".($themeid);

	
	@include("themesdesign/".$namefolder."/".$namefolder.".php");
	// if($themes_type == 'F'){
 		$buffer = "";
	if(file_exists($Current_Dir1.$themes_file) && $themes_file!=''){ //block_themes
 		$fd = @fopen ($Current_Dir1.$themes_file, "r");
		 while (!@feof ($fd)) {
			$buffer .= @fgets($fd, 4096);
	 	}
 		@fclose ($fd);
		$design = explode('<?php#htmlshow#?>',$buffer);
	 }
	 }

   // Calendra Config Categories
	 $a=array();
	$query_calg = $db->query("SELECT * FROM cal_config WHERE BID='$BID' ");
	if($db->db_num_rows($query_calg)>0){
		   $data = $db->db_fetch_array($query_calg);
		   if($data[cal_group]!=""){
			  $a=explode(',',$data[cal_group]);
			  $wh_cat=" AND (cat_id= '$a[0]' ";
			  for($k=1;$k<sizeof($a)-1;$k++){ 
				  $wh_cat.=" OR cat_id= '$a[$k]' ";
			  }
			   $wh_cat.=" )";
		   }
	}
	 
?>
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
					<table width="100%" border="0" cellpadding="3" cellspacing="0" bgcolor="<?php echo $body_color;?>" background="<?php echo $Current_Dir1.$body_bg_img;?>">
                      <tr >
                        <td width="74%"><span class="text_head"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>"><span style="font-size:<?php echo $body_font_size;?>">หัวข้อกิจกรรม</span></font></span></span></td>
                        <td width="26%" align="center"><span class="text_head"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>"><span style="font-size:<?php echo $body_font_size;?>">ระยะเวลา</span></font></span></span></td>
                      </tr>
                      <tr >
                        <td colspan="2"><hr ></td>
                      </tr>
					  <?php
					  if($_GET[Blockid] == '1'){
					  $wh = "and event_registor ='1'";
					  }else  if($_GET[Blockid] == '2'){
					  $wh = "and event_registor <>'1'";
					  }
					 	 if($_GET[row]==''){
						 $limit = 5;
						 }else{
						 $limit = $_GET[row];
						 }
						 if (empty($offset) || $offset < 0) { 
							$offset=0; 
						} 
 
					  		$today = date('Y').'-'.date('m').'-'.(date('d'));   //2007-10-26
							$cond = " and ((event_show_start <= '".$today."' OR event_show_start = '0000-00-00' ) and  (event_show_end >='".$today."' OR event_show_end = '0000-00-00' ))";
					  		$sql_d="select * from cal_event where 1=1  $wh $wh_cat $cond order by cal_event.event_time_start desc, cal_event.event_time_end desc ";
							$query_search = $db->query($sql_d);
							$totalrows = $db->db_num_rows($query_search);
							$sql_dis = $sql_d." limit $offset,$limit";
							$query_dis = mysql_query($sql_dis);
							$num_dis = mysql_num_rows($query_dis );
							if($num_dis >0){
							while($fetch_dis = mysql_fetch_array($query_dis)){
	$html = "";
	if($fetch_dis['event_date_start'] != $fetch_dis['event_date_end']) {
		$start_date = explode('-', $fetch_dis['event_date_start']);
		$end_date = explode('-', $fetch_dis['event_date_end']);
		$html .= date('j', mktime(0, 0, 0, $start_date[1], $start_date[2], $start_date[0])).'&nbsp;';
		switch($start_date[1]) {
			case 1:  $html .= "มกราคม"; break;
			case 2:  $html .= "กุมภาพันธ์"; break;
			case 3:  $html .= "มีนาคม"; break;
			case 4:  $html .= "เมษายน"; break;
			case 5:  $html .= "พฤษภาคม"; break;
			case 6:  $html .= "มิถุนายน"; break;
			case 7:  $html .= "กรกฏาคม"; break;
			case 8:  $html .= "สิงหาคม"; break;
			case 9:  $html .= "กันยายน"; break;
			case 10:  $html .= "ตุลาคม"; break;
			case 11:  $html .= "พฤศจิกายน"; break;
			case 12:  $html .= "ธันวาคม"; break;
		}
		$html .= '&nbsp;'.(date('Y', mktime(0, 0, 0, $start_date[1], $start_date[2], $start_date[0]))+543);
		//$html .= date('M j ', mktime(0, 0, 0, substr($fetch_dis['event_date_start'], 5, 2), substr($fetch_dis['event_date_start'], 8, 2), substr($fetch_dis['event_date_start'], 0, 4)))."";
		$html .= "&nbsp;-&nbsp;";
		$html .= date('j', mktime(0, 0, 0, $end_date[1], $end_date[2], $end_date[0])).'&nbsp;';
		switch($end_date[1]) {
			case 1:  $html .= "มกราคม"; break;
			case 2:  $html .= "กุมภาพันธ์"; break;
			case 3:  $html .= "มีนาคม"; break;
			case 4:  $html .= "เมษายน"; break;
			case 5:  $html .= "พฤษภาคม"; break;
			case 6:  $html .= "มิถุนายน"; break;
			case 7:  $html .= "กรกฏาคม"; break;
			case 8:  $html .= "สิงหาคม"; break;
			case 9:  $html .= "กันยายน"; break;
			case 10:  $html .= "ตุลาคม"; break;
			case 11:  $html .= "พฤศจิกายน"; break;
			case 12:  $html .= "ธันวาคม"; break;
		}
		$html .= '&nbsp;'.(date('Y', mktime(0, 0, 0, $end_date[1], $end_date[2], $end_date[0]))+543);
	} else {
		$start_date = explode('-', $fetch_dis['event_date_start']);
		$end_date = explode('-', $fetch_dis['event_date_end']);
		$html .= date('j', mktime(0, 0, 0, $start_date[1], $start_date[2], $start_date[0])).'&nbsp;';
		switch($start_date[1]) {
			case 1:  $html .= "มกราคม"; break;
			case 2:  $html .= "กุมภาพันธ์"; break;
			case 3:  $html .= "มีนาคม"; break;
			case 4:  $html .= "เมษายน"; break;
			case 5:  $html .= "พฤษภาคม"; break;
			case 6:  $html .= "มิถุนายน"; break;
			case 7:  $html .= "กรกฏาคม"; break;
			case 8:  $html .= "สิงหาคม"; break;
			case 9:  $html .= "กันยายน"; break;
			case 10:  $html .= "ตุลาคม"; break;
			case 11:  $html .= "พฤศจิกายน"; break;
			case 12:  $html .= "ธันวาคม"; break;
		}
		$html .= '&nbsp;'.(date('Y', mktime(0, 0, 0, $start_date[1], $start_date[2], $start_date[0]))+543);
	}
	$html .= '<br>';
	$start_time = explode(':', $fetch_dis['event_time_start']);
	$end_time = explode(':', $fetch_dis['event_time_end']);
	$end_ampm = " น.";
	$start_ampm = " น.";
	if(($fetch_dis['event_date_start'] != $fetch_dis['event_date_end']) && ($fetch_dis['event_date_end'] != '0000-00-00') && ($fetch_dis['event_all_day'] != '1')) {
		//$html .= date('M j ', mktime(0, 0, 0, substr($fetch_dis['event_date_end'], 5, 2), substr($fetch_dis['event_date_end'], 8, 2), substr($fetch_dis['event_date_end'], 0, 4)));
		$html .= sprintf('%02d', $start_time[0]).':'.sprintf('%02d', $start_time[1]).$start_ampm;
		$html .= '&nbsp;-&nbsp;'.sprintf('%02d', $end_time[0]).':'.sprintf('%02d', $end_time[1]).$end_ampm;
	} else {
		if($fetch_dis['event_time_start'] == '00:00:00' && $fetch_dis['event_time_start'] == '00:00:00') {
			$html .= "ไม่ระบุเวลา";
		} else {
			if(($fetch_dis['event_all_day'] != '1')) {
				$html .= sprintf('%02d', $start_time[0]).':'.sprintf('%02d', $start_time[1]).$start_ampm.' - '.sprintf('%02d', $end_time[0]).':'.sprintf('%02d', $end_time[1]).$end_ampm;
			} else {
				$html .= "ตลอดวัน";
			}
		}
	}
					  ?>
                      <tr>
                        <td valign="top" ><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>"><span style="font-size:<?php echo $body_font_size;?>"><a href="#RG" onClick="window.open('activity_view.php?event_id=<?php echo $fetch_dis['event_id'];?>','registor','width=800 , height=750, scrollbars=1,resizable = 0');"><?php print $fetch_dis['event_title'];?></a></span></font></span></span></td>
                        <td align="center" valign="top"><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>"><span style="font-size:<?php echo $body_font_size;?>"><?php print $html;?></span></font></span></span></td>
                      </tr>
                     
					  <?php 
								}
								if($_GET[row]!=''){
								?>
								 <tr>
									<td colspan="2" align="right" valign="top" ><span class="text_normal"><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>"><span style="font-size:<?php echo $body_font_size;?>">หน้าที่ 
									<?php if ($offset !=0) {   
									$prevoffset=$offset-$limit; 
									echo   "<a href='##cal' onclick='ajax_calendarMGTother(2,". $prevoffset.");'>
									<<</a> ";
									}
										 ?>
									
									<?php

									// Calculate total number of pages in result 
								   $pages = intval($totalrows/$limit); 
									 
									// $pages now contains total number of pages needed unless there is a remainder from division  
									if ($totalrows%$limit) { 
										// has remainder so add one page  
										$pages++; 
									} 
									 $current = ($offset/$limit) - 1;
									 $start = $current - 10;
									 if($start < 1){
									 $start = 1;
									 }
									 $end = $current + 10;
										 if($end > $pages){
									 $end = $pages;
									 }
									// Now loop through the pages to create numbered links 
									// ex. 1 2 3 4 5 NEXT 
									for ($i=$start;$i<=$end;$i++) { 
										// Check if on current page 
										if (($offset/$limit) == ($i-1)) { 
											// $i is equal to current page, so don't display a link 
											echo "&nbsp;&nbsp;<font size=\"2\" face=\"MS Sans Serif\"><b>$i</b></font>&nbsp;&nbsp;"; 
										} else { 
											// $i is NOT the current page, so display a link to page $i 
											$newoffset=$limit * ($i-1); 
												  echo  "<a href='##cal' onclick='ajax_calendarMGTother(2,".$newoffset.");'><font size=\"2\" face=\"MS Sans Serif\">$i</font></a>"; 
										} 
									} 
								
								?>
									
									  <?php 
											if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
										// Not on the last page yet, so display a NEXT Link 
										$newoffset=$offset+$limit; 
										echo   "<a href='##cal' onclick='ajax_calendarMGTother(2,".$newoffset.");'>>></a>"; 
									}  ?>
									
									
									</span></font></span></span>
									 </td>
								  </tr>
								<?php
								}
							}else{
					  	?>
                      <tr>
                        <td colspan="2" align="center" valign="top" ><font color="<?php echo $body_font_color;?>"  face="<?php echo $body_font_face;?>"><span style="font-size:<?php echo $body_font_size;?>"><span class="style1">ไม่มีข้อมูลกิจกรรม</span></span></font></span></td>
                      </tr>
					  <?php 
							}
					  ?>
                    </table>
<?php $db->db_close(); ?>
