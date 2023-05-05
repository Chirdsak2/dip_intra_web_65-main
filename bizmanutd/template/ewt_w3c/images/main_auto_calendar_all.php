<?php
$path = "../";
	session_start();
	if($_GET["SSMID"]!=''){
	$_SESSION["EWT_MID"] = $_GET["SSMID"];
	}
	$_SESSION["EWT_MAIL"] = $_GET["SSMAIL"];
	$_SESSION["EWT_ORG"] = $_GET["SSorg"];
	$start_time_counter = date("YmdHis");
	include($path."lib/function.php");
	include($path."lib/user_config.php");
	include($path."lib/connect.php");
	include("include/ewt_block_function.php");
	include("include/ewt_menu_preview.php");
	include("include/ewt_article_preview.php");
	include("ewt_template.php");
$db->access=200;
$mont_th_short = array ("","ม.ค.","ก.พ.","มี.ค","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
	$sql_calconfig = "select cal_type from site_info ";
	$query_calconfig = $db->query($sql_calconfig);
	$rec_calconfig = $db->db_fetch_row($query_calconfig);
	$onsetting_cal = $rec_calconfig[0];
?>
<?php echo $template_design[0];?>
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
        <td rowspan="2" align="right">&nbsp;</td>
        <td height="15" ><img src="../mainpic/icon_news.gif" border="0"   alt="ปฏิทินกิจกรรม"><h1>ปฏิทินกิจกรรมประจำ<?php   if($_GET["cur_month"] != ''){ echo 'เดือน &nbsp;'.$mont_th_short[$_GET["cur_month"]];}else{ echo "ปี";}?> <?php echo ($cur_year+543);?> </h1></td>
        <td align="right" ><?php if($_GET["sessmid"] && $_GET["ssorg"] != 0) { ?><a href="calendar_add.php?filename=<?php echo $filename;?>" accesskey=<?php echo $db->genaccesskey();?>>เพิ่มกิจกรรม</a><?php } ?></td>
        <td rowspan="2">&nbsp;</td>
      </tr>
      <tr>
        <td height="15" ></td>
        <td align="right" >&nbsp;</td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td colspan="2" align="right">
		<a href="calendar_all.php?cur_year=<?php echo (($cur_year)-1);?>&amp;filename=<?php echo $_GET[filename];?>" accesskey=<?php echo $db->genaccesskey();?>>ปีก่อนหน้า (<?php echo (($cur_year+543)-1);?> )</a>  | <a href="calendar_all.php?cur_year=<?php echo (($cur_year)+1);?>&amp;filename=<?php echo $_GET[filename];?>" accesskey=<?php echo $db->genaccesskey();?>> ปีถัดไป (<?php echo (($cur_year+543)+1);?>)</a></td>
        <td>&nbsp;</td>
      </tr>
	  <tr>
        <td>&nbsp;</td>
        <td colspan="2" align="right"><a href="calendar_all.php?cur_year=<?php echo ($cur_year);?>&amp;cur_month=1&amp;filename=<?php echo $_GET[filename];?>">ม.ค. <?php echo ($cur_year+543);?></a> | <a href="calendar_all.php?cur_year=<?php echo ($cur_year);?>&amp;cur_month=2&amp;filename=<?php echo $_GET[filename];?>">ก.พ. <?php echo ($cur_year+543);?></a> | <a href="calendar_all.php?cur_year=<?php echo ($cur_year);?>&amp;cur_month=3&amp;filename=<?php echo $_GET[filename];?>">มี.ค. <?php echo ($cur_year+543);?></a> | <a href="calendar_all.php?cur_year=<?php echo ($cur_year);?>&amp;cur_month=4&amp;filename=<?php echo $_GET[filename];?>">เม.ย. <?php echo ($cur_year+543);?></a> | <a href="calendar_all.php?cur_year=<?php echo ($cur_year);?>&amp;cur_month=5&amp;filename=<?php echo $_GET[filename];?>">พ.ค. <?php echo ($cur_year+543);?></a> | <a href="calendar_all.php?cur_year=<?php echo ($cur_year);?>&amp;cur_month=6&amp;filename=<?php echo $_GET[filename];?>">มิ.ย. <?php echo ($cur_year+543);?></a><br /> 
       <a href="calendar_all.php?cur_year=<?php echo ($cur_year);?>&amp;cur_month=7&amp;filename=<?php echo $_GET[filename];?>"> ก.ค. <?php echo ($cur_year+543);?></a> | <a href="calendar_all.php?cur_year=<?php echo ($cur_year);?>&amp;cur_month=8&amp;filename=<?php echo $_GET[filename];?>">ส.ค. <?php echo ($cur_year+543);?></a> | <a href="calendar_all.php?cur_year=<?php echo ($cur_year);?>&amp;cur_month=9&amp;filename=<?php echo $_GET[filename];?>">ก.ย. <?php echo ($cur_year+543);?></a> | <a href="calendar_all.php?cur_year=<?php echo ($cur_year);?>&amp;cur_month=10&amp;filename=<?php echo $_GET[filename];?>">ต.ค. <?php echo ($cur_year+543);?></a> | <a href="calendar_all.php?cur_year=<?php echo ($cur_year);?>&amp;cur_month=11&amp;filename=<?php echo $_GET[filename];?>">พ.ย. <?php echo ($cur_year+543);?></a> | <a href="calendar_all.php?cur_year=<?php echo ($cur_year);?>&amp;cur_month=12&amp;filename=<?php echo $_GET[filename];?>">ธ.ค. <?php echo ($cur_year+543);?></a></td>
        <td>&nbsp;</td>
      </tr>
	   <tr>
        <td>&nbsp;</td>
        <td colspan="2" align="right"><hr></td>
        <td>&nbsp;</td>
      </tr>
      <?php 
	  	if($_GET["sessmid"]) {
		$where1 = " AND (((cal_event.event_user_id = '".$_GET["sessmid"]."' OR cal_invite.person_id = '".$_GET["sessmid"]."' OR cal_invite.division_id = '".$_GET["ssorg"]."')) OR (cal_event.event_private = '2'))";
		$where2 = " AND (cal_event.event_user_id = '".$_GET["sessmid"]."') ";
	} else {
		$where1 = " AND (cal_event.event_private = '2')";
	}
	  if($_GET["cur_month"] != ''){
	  $ms = $_GET["cur_month"];
	  $me = $_GET["cur_month"];
	  }else{
	  $ms = '1';
	  $me = '12';
	  }
	  $start_ampm ='น.';
	  $sql_event  ="
		select *
		from 
			cal_event inner join cal_show_event on cal_event.event_id = cal_show_event.event_id 
			inner join cal_category on cal_category.cat_id = cal_event.cat_id 
			left join cal_invite on cal_event.event_id = cal_invite.event_id 
		where ";
		 if($_GET["cur_month"] != ''){
	 $sql_event  .="(( '".date('Y-m-d', mktime(0, 0, 0, $ms, 1, $cur_year))."' between cal_event.event_date_start  and cal_event.event_date_end ) or  ( '".date('Y-m-d', mktime(0, 0, 0, $me, 31, $cur_year))."' between cal_event.event_date_start  and cal_event.event_date_end ) or (cal_event.event_date_start between '".date('Y-m-d', mktime(0, 0, 0, $ms, 1, $cur_year))."' and '".date('Y-m-d', mktime(0, 0, 0, $me, 31, $cur_year))."') or (cal_event.event_date_end between '".date('Y-m-d', mktime(0, 0, 0, $ms, 1, $cur_year))."' and '".date('Y-m-d', mktime(0, 0, 0, $me, 31, $cur_year))."')) $where1
		group by cal_show_event.event_id,cal_show_event.event_date_start, cal_show_event.event_date_end  
		order by cal_event.event_date_start desc, cal_event.event_date_end desc";
		 }else{
		$sql_event  .="((cal_event.event_date_start between '".date('Y-m-d', mktime(0, 0, 0, $ms, 1, $cur_year))."' and '".date('Y-m-d', mktime(0, 0, 0, $me, 31, $cur_year))."') or (cal_event.event_date_end between '".date('Y-m-d', mktime(0, 0, 0, $ms, 1, $cur_year))."' and '".date('Y-m-d', mktime(0, 0, 0, $me, 31, $cur_year))."')) $where1
		group by cal_show_event.event_id,cal_show_event.event_date_start, cal_show_event.event_date_end   
		order by cal_event.event_date_start desc, cal_event.event_date_end desc";
		}
		//echo $sql_event;
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
                <td valign="top">                  <?php $name_staff = ereg_replace(',',"<br>",$name_staff); echo $name_staff;?>                </td>
              </tr>
			  <tr>
                <td valign="top" nowrap>หน่วยงานที่เกี่ยวข้อง  : </td>
                <td valign="top"><?php echo $name_division;?></td>
			  </tr>
			    <?php if($R[event_link]) { ?>
	    <tr>
	      <td valign="top" nowrap>เอกสารแนบ : </td>
	      <td valign="top"><img src="../mainpic/document_view.gif"  alt="ดู" onClick="window.open('calendar_view_link.php?flag=link&amp;img_name=<?=$R[event_link]?>','calendar_view_link','width=500 , height=400,scrollbars=1,resizable = 1'); " style="cursor:hand"></td>
	    </tr>
		  	<?php } ?>
          </table>
            <hr></td>
        <td>&nbsp;</td>
      </tr>
	  <? } 
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
    </table>
<?php include("include_logo_w3c_template.php");?>
<?php $db->db_close(); ?>