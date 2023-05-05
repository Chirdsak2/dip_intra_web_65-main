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
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html lang="th">
<head>
<title><?php echo $ewt_mytitle; ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<meta name="Keywords" content="<?php echo $ewt_mykeyword; ?>" >
<meta name="Description" content="<?php echo $ewt_mydescription; ?>">
<?php include("ewt_script.php");?>
</head>

<body <?php if($F["d_site_bg_c"] != ""){ echo "bgcolor=\"".$F["d_site_bg_c"]."\""; } ?> <?php if($F["d_site_bg_p"] != ""){ echo "background=\"".$F["d_site_bg_p"]."\""; } ?>>
<table <?php if($F["d_site_width"] != ""){ echo "width=\"".$F["d_site_width"]."\""; } ?> border="0" cellpadding="0" cellspacing="0" <?php if($F["d_site_align"] != ""){ echo "align=\"".$F["d_site_align"]."\""; } ?>>
  <tr>
    <td  <?php if($F["d_top_height"] != ""){ echo "height=\"".$F["d_top_height"]."\""; } ?> <?php  if($F["d_top_bg_c"] != ""){ echo "bgcolor=\"".$F["d_top_bg_c"]."\""; } ?>  colspan="3" >
	  <?php
			$mainwidth = $F["d_site_width"];
			?><?php
		  $sql_top = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '3' AND design_block.d_id = '".$design_id."' ORDER BY design_block.position ASC");
		  while($TB = $db->db_fetch_row($sql_top)){
		  ?>
<DIV ><?php echo show_block($TB[0]); ?></DIV>
		<?php } ?></td>
  </tr>
  <tr>
    <td  valign="top"  <?php if($F["d_site_left"] != ""){ echo "width=\"".$F["d_site_left"]."\""; } ?> <?php  if($F["d_left_bg_c"] != ""){ echo "bgcolor=\"".$F["d_left_bg_c"]."\""; } ?>>
	  <?php
			$mainwidth = $F["d_site_left"];
			?><?php
		  $sql_left = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '1' AND design_block.d_id = '".$design_id."' ORDER BY design_block.position ASC");
		  while($LB = $db->db_fetch_row($sql_left)){
		  ?>
<DIV><?php echo show_block($LB[0]); ?></DIV>
		<?php } ?>
	</td>
    <td height="160"  valign="top"  <?php if($F["d_site_content"] != ""){ echo "width=\"".$F["d_site_content"]."\""; } ?> <?php  if($F["d_body_bg_c"] != ""){ echo "bgcolor=\"".$F["d_body_bg_c"]."\""; } ?>>
	<?php
			$mainwidth = $F["d_site_content"];
			if($_GET['cur_year'] == ''){ $cur_year = date('Y');}
			?>
	<!-- เริ่มต้นกิจกรรมทั้งหมด-->
	<table width="100%" border="0" cellpadding="0" cellspacing="0">
      <tr>
        <td align="right"></td>
        <td height="5" colspan="2"></td>
        <td></td>
      </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td height="30" ><img src="../mainpic/icon_news.gif" border="0"   alt="ปฏิทินกิจกรรม">ปฏิทินกิจกรรมประจำปี <?php echo ($cur_year+543);?> </td>
        <td align="right" ><a href="calendar_add.php">เพิ่มกิจกรรม</a></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2" align="right">
		<a href="calendar_all.php?cur_year=<?php echo (($cur_year)-1);?>&amp;filename=<?php echo $_GET[filename];?>">ปีก่อนหน้า (<?php echo (($cur_year+543)-1);?> )</a>  | <a href="calendar_all.php?cur_year=<?php echo (($cur_year)+1);?>&amp;filename=<?php echo $_GET[filename];?>"> ปีถัดไป (<?php echo (($cur_year+543)+1);?>)</a><hr></td>
        <td>&nbsp;</td>
      </tr>
      <?php 
	  $start_ampm ='น.';
	  $sql_event  ="
		select *
		from 
			cal_event inner join cal_show_event on cal_event.event_id = cal_show_event.event_id 
			inner join cal_category on cal_category.cat_id = cal_event.cat_id 
			left join cal_invite on cal_event.event_id = cal_invite.event_id 
		where ";
		$sql_event  .="(cal_event.event_date_start between '".date('Y-m-d', mktime(0, 0, 0, 1, 1, $cur_year))."' and '".date('Y-m-d', mktime(0, 0, 0, 12, 31, $cur_year))."') or (cal_event.event_date_end between '".date('Y-m-d', mktime(0, 0, 0, 1, 1, $cur_year))."' and '".date('Y-m-d', mktime(0, 0, 0, 12, 31, $cur_year))."')
		group by cal_show_event.event_id,cal_show_event.event_date_start, cal_show_event.event_date_end  
		order by cal_event.event_date_start desc, cal_event.event_date_end desc";
		$query  = $db->query($sql_event);
		if($db->db_num_rows($query)>0){
		while($R = $db->db_fetch_array($query)){
						if($R['event_date_start'] == '0000-00-00' && $R['event_date_end'] == '0000-00-00') {
							$html_show = 'ไม่ระบุเวลา' ;
						} else {
							$html_show = '';
							$data_show1 = explode("-", $R['event_date_start']);
							$data_show2 = explode("-", $R['event_date_end']);
							if($R['event_date_start'] == '0000-00-00') {
							} else {
								$html_show .= date('j', mktime(0, 0, 0, $data_show1[1], $data_show1[2], $data_show1[0])).'&nbsp;';
								$html_show .= switch_mcalendar($data_show1[1]).'&nbsp;';
								$html_show .= (date('Y', mktime(0, 0, 0, $data_show1[1], $data_show1[2], $data_show1[0]))+543).'&nbsp;';
								if($R['event_time_start'] != '00:00:00') {
									$start_time = explode(':', $R['event_time_start']);
									$html_show .= sprintf('%02d', $start_time[0]).':'.sprintf('%02d', $start_time[1]).$start_ampm;
								}
								if($R['event_date_end'] == '0000-00-00') {
								} else {
									
									$html_show .= '&nbsp;-&nbsp;';
								}
							}
							if($R['event_date_end'] == '0000-00-00') {
							} else {
								$html_show .= date('j', mktime(0, 0, 0, $data_show2[1], $data_show2[2], $data_show2[0])).'&nbsp;';
								$html_show .= switch_mcalendar($data_show2[1]).'&nbsp;';
								$html_show .= (date('Y', mktime(0, 0, 0, $data_show2[1], $data_show2[2], $data_show2[0]))+543).'&nbsp;';
								if($R['event_time_end'] != '00:00:00') {
								$end_time = explode(':', $R['event_time_end']);
								$html_show .= sprintf('%02d', $end_time[0]).':'.sprintf('%02d', $end_time[1]).$start_ampm;
								}
							}
						}
						
							$name_staff = "";
							$name_division = "";
							$sql_invite2  = "select * from cal_invite where event_id = '".$R[event_id]."' ";
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
      <tr>
        <td>&nbsp;</td>
        <td colspan="2">
            <table width="100%" border="0" cellpadding="3" cellspacing="0">
              <tr>
                <td width="30%" valign="top" nowrap>หัวข้อกิจกรรม : </td>
                <td width="70%" valign="top"><?php print $R['event_title'];?></td>
              </tr>
			  <tr>
                <td valign="top" nowrap>หมวดกิจกรรม : </td>
                <td valign="top"><img src="../mainpic/colorrange.gif" border="0" width="8" alt="<?php print $R['cat_name'];?>" height="8" style="padding: 0; border-style:solid; border-color:#000000; background:<?php echo $R['cat_color'] ?>">&nbsp;<?php print $R['cat_name'];?></td>
              </tr>
              <tr>
                <td valign="top" nowrap>วัน-เวลา : </td>
                <td valign="top"><?php print $html_show;?> </td>
              </tr>
              <tr>
                <td valign="top" nowrap>รายละอียด : </td>
                <td valign="top"><?php print $R['event_detail'];?></td>
              </tr>
              <tr>
                <td valign="top" nowrap>ผู้ที่เกี่ยวข้อง  : </td>
                <td valign="top"><?php $name_staff = ereg_replace(',',"<br>",$name_staff); echo $name_staff;?></td>
              </tr>
			  <tr>
                <td valign="top" nowrap>หน่วยงานที่เกี่ยวข้อง  : </td>
                <td valign="top"><?php echo $name_division;?></td>
              </tr>
			    <?php if($R[event_link]) { ?>
	    <tr>
	      <td valign="top" nowrap>เอกสารแนบ : </td>
	      <td valign="top"><img src="../mainpic/document_view.gif"  alt="ดู" onClick="window.open('calendar_view_link.php?flag=link&amp;img_name=<?php echo $R[event_link]?>','calendar_view_link','width=500 , height=400,scrollbars=1,resizable = 1'); " style="cursor:hand"></td>
	      </tr>
		  	<?php } ?>
          </table><hr></td>
        <td>&nbsp;</td>
      </tr>
	  <?php } 
	  }
	  if($db->db_num_rows($query) == 0){ ?>
      <tr>
	  <td>&nbsp;</td>
        <td height="44" colspan="2" align="center" valign="bottom">--ไม่พบกิจกรรมในปีปฎิทินนี้--</td>
		<td>&nbsp;</td>
      </tr>
	  <?php } ?>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2" align="center" valign="bottom"><?php echo $txt_website_of_name1;?></td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td  valign="top"  <?php if($F["d_site_right"] != ""){ echo "width=\"".$F["d_site_right"]."\""; } ?> <?php  if($F["d_right_bg_c"] != ""){ echo "bgcolor=\"".$F["d_right_bg_c"]."\""; } ?>>	 
	 <?php
			$mainwidth =  $F["d_site_right"];
			?><?php
		  $sql_right = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '2' AND design_block.d_id = '".$design_id."' ORDER BY design_block.position ASC");
		  while($RB = $db->db_fetch_row($sql_right)){
		  ?>
<DIV><?php echo show_block($RB[0]); ?></DIV>
		<?php } ?></td>
  </tr>
  <tr valign="top" > 
          <td  colspan="3"  valign="top"  <?php if($F["d_bottom_height"] != ""){ echo "height=\"".$F["d_bottom_height"]."\""; } ?> <?php  if($F["d_bottom_bg_c"] != ""){ echo "bgcolor=\"".$F["d_bottom_bg_c"]."\""; } ?> <?php if($F["d_bottom_bg_p"] != ""){ echo "background=\"".$F["d_bottom_bg_p"]."\""; } ?>>	 
		  <?php
			$mainwidth = $RR["d_site_width"];
			?><?php
		  $sql_bottom = $db->query("SELECT block.BID FROM block INNER JOIN design_block ON design_block.BID = block.BID WHERE design_block.side = '4' AND design_block.d_id = '".$design_id."' ORDER BY design_block.position ASC");
		  while($BB = $db->db_fetch_row($sql_bottom)){
		  ?>
<DIV><?php echo show_block($BB[0]); ?></DIV>
		<?php } ?></td>
        </tr>
</table>
<a href="http://validator.w3.org/check?uri=referer"><img src="../w3c/checked/images/w3c_gold.bmp" alt="Valid HTML 4.01 Transitional" height="31" width="88" border="0"></a><?php  include("ewt_span.php");?>
</body>
</html>
<?php $db->db_close(); ?>