<?php
$path = "../";
	session_start();
	$start_time_counter = date("YmdHis");
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");
	include("include/ewt_block_function.php");
	include("include/ewt_menu_preview.php");
	include("include/ewt_article_preview.php");
	include("ewt_template.php");
	$db->access=200;
?>
<?php echo $template_design[0];?>
	<?php
			$mainwidth = $F["d_site_content"];
			?>
	<!-- เริ่มต้นรายละเอียดกิจกรรม-->
	<?php
	$start_ampm ='น.';
	$sql_dis="select * from cal_event where  event_id='".$event_id."' ";
	$query_dis = mysql_query($sql_dis);
	$fetch_dis = mysql_fetch_array($query_dis);
	$html = "";
	if($fetch_dis['event_date_start'] == '0000-00-00' && $fetch_dis['event_date_end'] == '0000-00-00') {
							$html_show = 'ไม่ระบุเวลา' ;
						} else {
							$html_show = '';
							$data_show1 = explode("-", $fetch_dis['event_date_start']);
							$data_show2 = explode("-", $fetch_dis['event_date_end']);
							if($fetch_dis['event_date_start'] == '0000-00-00') {
							} else {
								$html_show .= date('j', mktime(0, 0, 0, $data_show1[1], $data_show1[2], $data_show1[0])).'&nbsp;';
								$html_show .= switch_mcalendar($data_show1[1]);
								$html_show .= (date('Y', mktime(0, 0, 0, $data_show1[1], $data_show1[2], $data_show1[0]))+543).'&nbsp;';
								if($fetch_dis['event_time_start'] != '00:00:00') {
									$start_time = explode(':', $fetch_dis['event_time_start']);
									$html_show .= sprintf('%02d', $start_time[0]).':'.sprintf('%02d', $start_time[1]).$start_ampm;
								}
								if($fetch_dis['event_date_end'] == '0000-00-00') {
								} else {
									
									$html_show .= '&nbsp;-&nbsp;';
								}
							}
							if($fetch_dis['event_date_end'] == '0000-00-00') {
							} else {
								$html_show .= date('j', mktime(0, 0, 0, $data_show2[1], $data_show2[2], $data_show2[0])).'&nbsp;';
								$html_show .= switch_mcalendar($data_show2[1]);
								$html_show .= (date('Y', mktime(0, 0, 0, $data_show2[1], $data_show2[2], $data_show2[0]))+543).'&nbsp;';
								if($fetch_dis['event_time_end'] != '00:00:00') {
								$end_time = explode(':', $fetch_dis['event_time_end']);
								$html_show .= sprintf('%02d', $end_time[0]).':'.sprintf('%02d', $end_time[1]).$start_ampm;
								}
							}
						}
	$name_staff = "";
	$name_division = "";
	$sql_invite2  = "select * from cal_invite where event_id = '".$fetch_dis[event_id]."' ";
	$query_invite2 = $db->query($sql_invite2);
	while($rs_invite2 = $db->db_fetch_array($query_invite2)){
		$db->query("USE ".$EWT_DB_USER);
		$sql_staff = "select title.title_thai,name_thai,surname_thai from gen_user inner join title on gen_user.title_thai = title.title_id where gen_user_id = '$rs_invite2[person_id]' ";
		$query_staff = $db->query($sql_staff);
		$fetch_staff = $db->db_fetch_array($query_staff);
		if($fetch_staff[name_thai]){ $name_staff .= $fetch_staff[title_thai]." ".$fetch_staff[name_thai]." ".$fetch_staff[surname_thai].","; }

		//กรณีเป็นหน่วยงาน
		$sql_division = "select * from org_name where org_id = '$rs_invite2[division_id]' ";
		$query_division = $db->query($sql_division);
		$fetch_division = $db->db_fetch_array($query_division);
		if($fetch_division[name_org]){ $name_division .= $fetch_division[name_org].",";}
		$db->query("USE ".$EWT_DB_NAME);
	}
	$name_staff = substr($name_staff,0,-1);
	if(trim($name_staff) == ''){ $name_staff =' -'; }
	if(trim($name_division)==''){ $name_division = '-';}
	?>

<table width="100%" border="0" cellpadding="0" cellspacing="0">
<tr>
    <td align="right"></td>
    <td height="5"></td>
    <td></td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td height="30" ><img src="../mainpic/icon_news.gif" border="0"   alt="รายละเอียดกิจกรรม"><h1>รายละเอียดกิจกรรม</h1></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><table width="100%" border="0" cellpadding="3" cellspacing="0">
      <tr>
        <td width="30%" valign="top" nowrap>หัวข้อกิจกรรม : </td>
        <td width="70%" valign="top"><?php print $fetch_dis['event_title'];?></td>
      </tr>
      <tr>
        <td valign="top" nowrap>วัน-เวลา : </td>
        <td valign="top"><?php print $html_show;?> </td>
      </tr>
      <tr>
        <td valign="top" nowrap>รายละอียด : </td>
        <td valign="top"><?php print $fetch_dis['event_detail'];?></td>
      </tr>
      <tr>
        <td valign="top" nowrap>ผู้ที่เกี่ยวข้อง  : </td>
        <td valign="top"><?php $name_staff = ereg_replace(',',"<br>",$name_staff); echo $name_staff;?></td>
      </tr>
	    <tr>
                <td valign="top" nowrap>หน่วยงานที่เกี่ยวข้อง  : </td>
                <td valign="top"><?php echo $name_division;?></td>
              </tr>
			  <?php if($fetch_dis[event_link]) { ?>
	    <tr>
	      <td valign="top" nowrap>เอกสารแนบ : </td>
	      <td valign="top"><img src="../mainpic/document_view.gif" alt="ดู" onClick="window.open('calendar_view_link.php?flag=link&amp;img_name=<?=$fetch_dis[event_link]?>','calendar_view_link','width=500 , height=400,scrollbars=1,resizable = 1'); " style="cursor:hand"></td>
	      </tr>
		  	<?php } ?>
	  <!--
      <tr>
        <td valign="top" nowrap><? if($fetch_dis[event_registor] == '1'){ ?>สมัครเข้าร่วมกิจกรรม<? } ?></td>
        <td valign="top"><? if($fetch_dis[event_registor] == '1'){ ?><a href="#RG" onClick="window.open('calendar_registor.php?event_id=<?=$_GET['event_id'];?>','registor','width=800 , height=750, scrollbars=1,resizable = 0');"><img src="../mainpic/icon_news.gif" alt="สมัครเข้าร่วมสัมมนา" width="21" height="21" border="0" ></a><? } ?></td>
      </tr>
-->
    </table></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td rowspan="2">&nbsp;</td>
    <td height="44" ><a href="calendar_all.php?filename=<?php echo $filename;?>" accesskey=<?php echo $db->genaccesskey();?>>ปฏิทินกิจกรรมทั้งหมด</a></td>
    <td rowspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td height="44" align="center" valign="bottom">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="bottom"><hr></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="center" valign="bottom"><?php echo $txt_website_of_name1;?></td>
    <td>&nbsp;</td>
  </tr>
</table>
<?php include("include_logo_w3c_template.php");?>
<?php $db->db_close(); ?>