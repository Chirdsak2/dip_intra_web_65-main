<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
$path_cal = "";
if($_GET[event_id]){
	$event_id = $_GET[event_id];
}
?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<table width="100%" border="0" cellpadding="0" cellspacing="1">
  <tr bgcolor="#CCCCCC">
    <td valign="top" bgcolor="#d5d5d5" ><?php
																$sql_event  = "select * from cal_event  inner join cal_category on cal_event.cat_id = cal_category.cat_id  where event_id = '$event_id' group by cal_event.event_id order by event_date_start,event_all_day,event_time_start,event_title";
																$result_event = $db->query($sql_event);
																if($db->db_num_rows($result_event) > 0) {
																	while($row_event = $db->db_fetch_array($result_event)) {
																		$sql_cate  = "select * from cal_color where color_id = '".$row_event['color_id']."'";
																		$result_cate = $db->query($sql_cate);
																		$row_cate = $db->db_fetch_array($result_cate);
															?>
        <table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#006699">
          <tr>
            <td style="color:#FFFFFF"><?php
				$start_time = explode(':', $row_event['event_time_start']);
				/*if($start_time[0] > 12) {
					$start_hour = $start_time[0] -12;
					$start_ampm = 'pm';
				} else {
					$start_hour = $start_time[0];
					$start_ampm = 'am';
				}*/
				$end_time = explode(':', $row_event['event_time_end']);
				/*if($end_time[0] > 12) {
					$end_hour = $end_time[0] -12;
					$end_ampm = 'pm';
				} else {
					$end_hour = $end_time[0];
					$end_ampm = 'am';
				}*/
				$start_ampm = $end_ampm = ' น.';
				if(($row_event['event_date_start'] != $row_event['event_date_end']) && ($row_event['event_date_end'] != '0000-00-00')  && ($row_event['event_all_day'] != '1')) {
						$html .= date('M j', mktime(0, 0, 0, substr($row_event['event_date_start'], 5, 2), substr($row_event['event_date_start'], 8, 2), substr($row_event['event_date_start'], 0, 4)))."&nbsp;";
						//if($row_event['event_time_type'] == 'N') {
							//$html .= sprintf('%02d', $start_hour).':'.sprintf('%02d', $start_time[1]).$start_ampm;
							$html .= sprintf('%02d', $start_time[0]).':'.sprintf('%02d', $start_time[1]).$start_ampm;
						//}
						$html .= "&nbsp;-&nbsp;";
						$html .= date('M j', mktime(0, 0, 0, substr($row_event['event_date_end'], 5, 2), substr($row_event['event_date_end'], 8, 2), substr($row_event['event_date_end'], 0, 4)));
						//if($row_event['event_time_type'] == 'N') {
							//$html .= '&nbsp;'.sprintf('%02d', $end_hour).':'.sprintf('%02d', $end_time[1]).$end_ampm;
							$html .= '&nbsp;'.sprintf('%02d', $end_time[0]).':'.sprintf('%02d', $end_time[1]).$end_ampm;
						//}
				} else {
					//if($row_event['event_time_start'] != $row_event['event_time_end']  && ($row_event['event_all_day'] != '1')) {
					if( ($row_event['event_all_day'] != '1')) {
						$html .= date('M j', mktime(0, 0, 0, substr($row_event['event_date_start'], 5, 2), substr($row_event['event_date_start'], 8, 2), substr($row_event['event_date_start'], 0, 4)))."&nbsp;";
						//$html .= sprintf('%02d', $start_hour).':'.sprintf('%02d', $start_time[1]).$start_ampm.' - '.sprintf('%02d', $end_hour).':'.sprintf('%02d', $end_time[1]).$end_ampm;
						$html .= sprintf('%02d', $start_time[0]).':'.sprintf('%02d', $start_time[1]).$start_ampm.' - '.sprintf('%02d', $end_time[0]).':'.sprintf('%02d', $end_time[1]).$end_ampm;
					} else {
						$html .= date('M j ', mktime(0, 0, 0, substr($row_event['event_date_start'], 5, 2), substr($row_event['event_date_start'], 8, 2), substr($row_event['event_date_start'], 0, 4)))."";
						if(($row_event['event_date_start'] != $row_event['event_date_end'])) 
						$html .= " - ".date('M j ', mktime(0, 0, 0, substr($row_event['event_date_end'], 5, 2), substr($row_event['event_date_end'], 8, 2), substr($row_event['event_date_end'], 0, 4)));
						$html .= "All Day Event";
					}
				}
				echo $html;
																	?>
              &nbsp;:&nbsp;
              <?php echo nl2br($row_event['event_title']);?>            </td>
          </tr>
          <tr>
            <td bgcolor="#FFFFFF"><table width="100%" border="0" cellspacing="1" cellpadding="3">
                <tr>
                  <td width="10" rowspan="2" bgcolor="<?php echo $row_event['cat_color'];?>">&nbsp;</td>
                  <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                      <tr>
                        <td height="15" valign="top"><strong>หมวดกิจกรรม :</strong></td>
						 <?php
							   		$sql_category = "select cat_name from cal_category where cat_id = '$row_event[cat_id]' ";
									$query_cat = $db->query($sql_category);
									$cat_name = $db->db_fetch_array($query_cat);
							   ?>
                        <td width="825" height="15" valign="top"><?php echo nl2br($cat_name['cat_name']);?></td>
                      </tr>
                      <tr>
                        <td width="119" height="15" valign="top"><strong>รายละเอียด :</strong></td>
                        <td height="15" valign="top"><textarea cols="60" rows="5"><?php echo $row_event['event_detail'];?></textarea></td>
                      </tr>
					  <?php
					$name_staff = "";
					$name_division="";
					$sql_invite  = "select * from cal_invite where event_id = '".$row_event[event_id]."' ";
					$query_invite = $db->query($sql_invite);
					while($rs_invite = $db->db_fetch_array($query_invite)){
						$db->query("USE ".$EWT_DB_USER);
						$sql_staff = "select title.title_thai,name_thai,surname_thai from gen_user inner join title on gen_user.title_thai = title.title_id where gen_user_id = '$rs_invite[person_id]'";
						$query_staff = $db->query($sql_staff);
						$fetch_staff = $db->db_fetch_array($query_staff);
						//$name_staff.=$fetch_staff[title_thai]." ".$fetch_staff[name_thai]." ".$fetch_staff[surname_thai].",";
						if($fetch_staff[name_thai]){ 
						     if($name_staff==""){
							   $name_staff.=$fetch_staff[title_thai]." ".$fetch_staff[name_thai]." ".$fetch_staff[surname_thai];
							 }else{
							   $name_staff.=",".$fetch_staff[title_thai]." ".$fetch_staff[name_thai]." ".$fetch_staff[surname_thai];
							 }
						}
						//กรณีเป็นหน่วยงาน
						$sql_division = "select * from org_name where org_id = '$rs_invite[division_id]' ";
						$query_division = $db->query($sql_division);
						$fetch_division = $db->db_fetch_array($query_division);
						if($fetch_division[name_org]){ 
						     if($name_division==""){ 
								$name_division.=$fetch_division[name_org];
							 }else{
							   $name_division.=",".$fetch_division[name_org];
							 }
						}
						$db->query("USE ".$EWT_DB_NAME);
					}
					//$name_staff = substr($name_staff,0,-1);
					 ?>
					  <tr>
                        <td width="119" height="15" valign="top" nowrap="nowrap"><strong>บุคคลที่เกี่ยวข้อง :</strong></td>
                        <td height="15" valign="top"><?php if($name_staff != ""){echo $name_staff;}else{echo "ไม่ระบุ";}?></td>
                      </tr>
					  <tr>
                        <td width="119" height="15" valign="top"><strong>หน่วยงานที่เกี่ยวข้อง :</strong></td>
                        <td height="15" valign="top"><?php if($name_division != ""){echo $name_division;}else{echo "ไม่ระบุ";}?></td>
                      </tr>
                      <?php	if(false){
																						if($row_event['event_originalid'] != 0) {
																							$sql_invite = "select * from event_invite, staff where event_invite_attendeeid = staff_id and event_invite_eventid = '".$row_event['event_originalid']."'";
																						} else {
																							$sql_invite = "select * from event_invite, staff where event_invite_attendeeid = staff_id and event_invite_eventid = '".$event_id."'";
																						}
																						$result_invite = $db->query($sql_invite);
																						$count_invite = $db->num_rows($result_invite);
																					?>
                      
                      <?php } // end if false?>
					  
					<tr>
					    <td height="15" valign="top" nowrap="nowrap"><strong>หน้าเว็ป / เอกสาร ที่เกี่ยวข้อง :</strong></td>
					    <td height="15" valign="top">
				        <?php if($row_event[event_link]){?><img src="mainpic/document_view.gif" height="16" width="16" align="absmiddle" alt="ดูภาพ" onClick="window.open('calendar_view_link.php?flag=link&img_name=<?php echo $row_event[event_link]?>','calendar_view_link','width=500 , height=400,scrollbars=1,resizable = 1'); " style="cursor:hand"><?php }else{    echo "ไม่ระบุ";  }?>
					    </td>
					</tr>
					  
					  <tr>
					    <td height="15" valign="top"><strong>วันที่แสดง :</strong></td>
					    <td height="15" valign="top"><?php if($row_event[event_show_start]!='0000-00-00'){echo $row_event[event_show_start];}else{echo "ไม่ระบุ";}?></td>
				    </tr>
					  <tr>
					    <td height="15" valign="top"><strong>วันที่สิ้นสุดการแสดง  :</strong></td>
					    <td height="15" valign="top"><?php if($row_event[event_show_end]!='0000-00-00'){echo $row_event[event_show_end];}else{echo "ไม่ระบุ";}?></td>
				    </tr>
                  </table></td>
                </tr>
				<?php
				if($row_event[event_user_id] == $_SESSION["EWT_MID"]){
				?>
                <tr>
                  <td><?php if($row_event['event_originalid'] == 0) {?>
                      <a href="calendar_editevent.php?event_id=<?php echo $row_event['event_id'];?>&ref=yes"><img src="<?php echo $path_cal?>mainpic/calendar_edit.gif" alt="Edit Event" width="16" height="16" border="0" align="absmiddle">&nbsp; แก้ไข </a>&nbsp; <a href="javascript:if(confirm('คุณต้องการจะลบ Event นี้')) {
																					window.location.href = 'calendar_process.php?event_id=<?php echo $row_event['event_id'];?>&Flag=Del&ref=yes';
																					}"><img src="<?php echo $path_cal?>mainpic/calendar_delete.gif" alt="Delete Event" width="16" height="16" border="0" align="absmiddle">&nbsp;ลบ</a>
                      <?php
																					}
																					?></td>
                </tr>
				<?php }?>
            </table></td>
          </tr>
        </table>
      <?php
																	}
																}
															?></td>
  </tr>
  <tr bgcolor="#E5E5E5"  >
    <td height="1%" bgcolor="#E5E5E5"><div align="right">
      <input type="button" name="Submit2" value="    ปิด   " class="BUTTON2" onClick="window.close();">
    </div></td>
  </tr>
</table>
</body>
</html>
<?php
$db->db_close(); ?>
