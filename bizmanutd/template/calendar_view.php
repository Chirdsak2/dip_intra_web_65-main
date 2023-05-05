<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
$path_cal = "";
//print $_GET[current];
$display_date = $_GET[current];

if(!isset($display_date)) {
	$display_date = date('Y-m-d');
	$cur_date = date('d');
	$cur_month = date('m');
	$cur_year = date('Y');
} else {
	$cur_date = substr($display_date, 8, 2);
	$cur_month = substr($display_date, 5, 2);
	$cur_year = substr($display_date, 0, 4);
}
$next_date = date('Y-m-d', mktime(0, 0, 0, $cur_month, $cur_date+1, $cur_year));
$prev_date = date('Y-m-d', mktime(0, 0, 0, $cur_month, $cur_date-1, $cur_year));
$next_month = date('Y-m-d', mktime(0, 0, 0, $cur_month+1, $cur_date, $cur_year));
$prev_month = date('Y-m-d', mktime(0, 0, 0, $cur_month-1, $cur_date, $cur_year));

?>
<html>
<head>
<title><?php echo $EWT_title ?></title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="css/style.css" rel="stylesheet" type="text/css">
</head>
<body leftmargin="0" topmargin="0">
<form name="frm1" action="" method="post">
<input type="hidden" name="deasc" value="<?php echo $deasc?>">
<input type="hidden" name="orderby" value="<?php echo $orderby?>">
<table width="800" border="0" cellpadding="0" cellspacing="2" align="center">
  <tr>
    <td width="100%"><table width="100%" border="1" cellpadding="0" cellspacing="0" bordercolor="#FB9D15">
      
      <tr>
        <td valign="middle" bgcolor="#FEDD52" height="30"><div align="center">&nbsp;&nbsp;<span class="head_calendar">
          <?php echo date('l, M j, Y', mktime(0, 0, 0, $cur_month, $cur_date, $cur_year));?>
        </span>&nbsp;&nbsp;<a href="index_calendar.php?display_date=<?php echo $next_date;?>"></a></div></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top">		<?php
					$page = $_POST[page];
					if(!$limit) $limit = 5;
					if($page == '' || $page < 1)$page =1;
					$page1=$page-1;
					if($page1 == '' || $page1 < 0)$page1 =0;
					
					if(!$orderby){
					   $orderby="event_id";
					}else{
					  $orderby=$orderby;
					}
					
					if($deasc=='DESC'){
					    $deasc='ASC';
					}else{
					   $deasc='DESC';
					}

					//$sql_event  = "select *,cal_show_event.event_date_start,cal_show_event.event_date_end from cal_event  inner join cal_show_event on cal_event.event_id = cal_show_event.event_id  where (cal_show_event.event_date_start <= '".$display_date."' and  cal_show_event.event_date_end >= '".$display_date."')  group by cal_event.event_id  order by cal_show_event.event_date_start,event_all_day,event_time_start,event_title,cal_show_event.event_id";
					
                    /*$sql_event  ="select cal_event.*,cal_show_event.event_date_start,cal_show_event.event_date_end ,cal_category.cat_name,cal_category.cat_color
                           from cal_event inner join cal_show_event on cal_event.event_id = cal_show_event.event_id 
									 inner join cal_category on cal_category.cat_id = cal_event.cat_id 
                          where (cal_show_event.event_date_start <= '".$display_date."' and  cal_show_event.event_date_end >= '".$display_date."')  
						  group by cal_event.event_id  
						  order by $orderby $deasc";*/
						   if($_SESSION["EWT_MID"]) 
						 $aaaa = " OR cal_event.event_user_id = '".$_SESSION["EWT_MID"]."' 
						                 OR cal_invite.person_id = '".$_SESSION["EWT_MID"]."' 
										 OR cal_invite.division_id = '".$_SESSION["EWT_ORG"]."' 
						 ";
						 
						 $sql_event  ="select cal_event.*,cal_show_event.event_date_start,cal_show_event.event_date_end ,cal_category.cat_name,cal_category.cat_color
                           from cal_event inner join cal_show_event on cal_event.event_id = cal_show_event.event_id 
									 inner join cal_category on cal_category.cat_id = cal_event.cat_id 
									 left join cal_invite on cal_event.event_id = cal_invite.event_id 
                          where (cal_show_event.event_date_start <= '".$display_date."' and  cal_show_event.event_date_end >= '".$display_date."')  
						  and  ((cal_show_event.event_show_start <= '".$display_date."' OR cal_show_event.event_show_start = '0000-00-00') and  (cal_show_event.event_show_end >= '".$display_date."' OR cal_show_event.event_show_end = '0000-00-00'))  
						   and (cal_event.event_private = '2' $aaaa ) 
						  group by cal_event.event_id  
						  order by $orderby $deasc";
						  //order  by cal_show_event.event_date_start,event_all_day,event_time_start,event_title,cal_show_event.event_id";
					
					$result_event = $db->query($sql_event);
					
					$num_all = $db->db_num_rows($result_event);
					//$num_all = $num_rows;
					if($num_all%$limit==0){
						@$page_all = $num_all/$limit;
					}else{
						@$page_all = (int)($num_all/$limit)+1;
					}
					if($page_all==0) $page_all = 1;
					if($page>=$page_all){$page1 = $page_all-1;$page=$page_all;}
					//$sql_select_main = "select cal_event.event_id,cal_event.color_id from cal_event inner join cal_show_event on cal_event.event_id = cal_show_event.event_id";


$sql_2 = $sql_event."  limit ".$page1*$limit.",$limit";
//echo  $sql_2;
$query = $db->query($sql_2);
$num_rows_2 = $db->db_num_rows($query);
?>					
	<table width="100%" border="0" cellpadding="3" cellspacing="1" bgcolor="#FB9D15">
      <tr style="color:#000000">
        <?php 


if($orderby=='event_id'){$ordfield=1;}
if($orderby=='cat_color'){$ordfield=2;}
if($orderby=='event_time_start'){$ordfield=3;}
if($orderby=='event_title'){$ordfield=4;}
if($orderby=='cat_name'){$ordfield=5;}
if($orderby=='event_detail'){$ordfield=6;}

if($deasc=='DESC'){
   $pic_order='> ';
}else{
   $pic_order='< ';
}
$pict="";
$pict[$ordfield]=$pic_order;

?>
        <td width="50" align="center" bgcolor="#E3CC6C" nowrap="nowrap"><?php echo $pict[1];?><a href="#" onClick="order_field('<?php echo $deasc?>','event_id')"><font color="#000000"><b>ลำดับ</b></font></a></td>
        <td width="17" align="center" bgcolor="#E3CC6C"><?php echo $pict[2];?><a href="#" onClick="order_field('<?php echo $deasc?>','cat_color')"><font color="#000000"><b>สี</b></font></a></td>
        <td  align="center" bgcolor="#E3CC6C" nowrap="nowrap"><?php echo $pict[3];?><a href="#" onClick="order_field('<?php echo $deasc?>','event_time_start')"><font color="#000000"><b>เวลา</b></font></a></td>
        <td width="94" align="center" bgcolor="#E3CC6C"><?php echo $pict[4];?><a href="#" onClick="order_field('<?php echo $deasc?>','event_title')"><font color="#000000"><b>หัวข้อ</b></font></a></td>
        <td   align="center" bgcolor="#E3CC6C"><?php echo $pict[5];?><a href="#" onClick="order_field('<?php echo $deasc?>','cat_name')"><font color="#000000"><b>หมวดกิจกรรม</b></font></a></td>
        <td width="102" align="center" bgcolor="#E3CC6C"><?php echo $pict[6];?><a href="#" onClick="order_field('<?php echo $deasc?>','event_detail')"><font color="#000000"><b>รายละเอียด</b></font></a></td>
        <td width="84" align="center" bgcolor="#E3CC6C" style="color:#000000"><b>บุคคลที่เกี่ยวข้อง</b></td>
		<td width="84" align="center" bgcolor="#E3CC6C" style="color:#000000"><b>หน่วยงานที่เกี่ยวข้อง</b></td>
        <td width="92" align="center" bgcolor="#E3CC6C" style="color:#000000" nowrap="nowrap"><b>หน้าเว็บ / แฟ้มเอกสาร<br>ที่เกี่ยวข้อง</b></td>
        </tr>
      <?php
if($num_rows_2>0){
  $i=($page1*$limit)+1;
  while($row_event = $db->db_fetch_array($query)){
  
    	if($row_event[event_user_id] != $_SESSION["EWT_MID"]){
			$chk_num_rows = false;
		}
		if((($row_event[event_show_end] >= $date) || !isset($row_event[event_show_end]) || $row_event[event_show_end] == "0000-00-00") ){
			if( ( $row_event[event_show_start] <= $date  ||  !isset($row_event[event_show_start]) || $row_event[event_show_start] == "0000-00-00" ) ){
					$chk_num_rows = true;
					$chk_num_rows2++;
			}
		}
		
		if($chk_num_rows || true){

  		
			$html = "";
			
				$start_time = explode(':', $row_event['event_time_start']);
				$end_time = explode(':', $row_event['event_time_end']);
				$end_ampm = " น.";
				$start_ampm = " น.";
				if(($row_event['event_date_start'] != $row_event['event_date_end']) && ($row_event['event_date_end'] != '0000-00-00') && ($row_event['event_all_day'] != '1')) {
						$html .= date('M j ', mktime(0, 0, 0, substr($row_event['event_date_start'], 5, 2), substr($row_event['event_date_start'], 8, 2), substr($row_event['event_date_start'], 0, 4)))."";
						$html .= sprintf('%02d', $start_time[0]).':'.sprintf('%02d', $start_time[1]).$start_ampm;
						$html .= "&nbsp;-&nbsp;";
						$html .= date('M j ', mktime(0, 0, 0, substr($row_event['event_date_end'], 5, 2), substr($row_event['event_date_end'], 8, 2), substr($row_event['event_date_end'], 0, 4)));
						$html .= '&nbsp;'.sprintf('%02d', $end_time[0]).':'.sprintf('%02d', $end_time[1]).$end_ampm;
				} else {
					if(($row_event['event_all_day'] != '1')) {
					    $html .= sprintf('%02d', $start_time[0]).':'.sprintf('%02d', $start_time[1]).$start_ampm.' - '.sprintf('%02d', $end_time[0]).':'.sprintf('%02d', $end_time[1]).$end_ampm;
					} else {
						$html .= "All Day Event";
					}
				}
			$chk_event++;
			?>
      <tr bgcolor="#FFFFFF">
        <td align="center" valign="top" ><?php echo $i; $i++;?></td>
        <td align="left" bgcolor="<?php echo $row_event['cat_color'];?>">&nbsp;</td>
        <td align="left" valign="top" nowrap="nowrap"><?php echo $html;?></td>
        <td align="left" valign="top"><?php echo nl2br($row_event['event_title']);?></td>
        <td align="left" valign="top"><?php echo nl2br($row_event['cat_name']);?></td>
        <td align="left" valign="top"><?php  echo  nl2br($row_event['event_detail']);?></td>
        <?php
			  $name_staff = "";
			  $name_division = "";
					$sql_invite2  = "select * from cal_invite where event_id = '".$row_event[event_id]."' ";
					$query_invite2 = $db->query($sql_invite2);
					while($rs_invite2 = $db->db_fetch_array($query_invite2)){
						$db->query("USE ".$EWT_DB_USER);
						$sql_staff = "select title.title_thai,name_thai,surname_thai from gen_user inner join title on gen_user.title_thai = title.title_id where gen_user_id = '$rs_invite2[person_id]' ";
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
						$sql_division = "select * from org_name where org_id = '$rs_invite2[division_id]' ";
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
					$name_staff = substr($name_staff,0,-1);
					if(trim($name_staff )==''){
					$name_staff='-';
					}
					?>
        <td align="left" valign="top" nowrap="nowrap"><?php $name_staff = ereg_replace(',',"<br>",$name_staff); if($name_staff){echo $name_staff;}else{echo '-';}?></td>
        <td align="left" valign="top" nowrap="nowrap"><?php $name_division = ereg_replace(',',"<br>",$name_division); if($name_division){echo $name_division;}else{echo '-';}?></td>
        <td align="center"><?php if($row_event[event_link]){?>
            <img src="mainpic/document_view.gif" height="16" width="16" align="absmiddle" alt="ดูภาพ" onClick="window.open('calendar_view_link.php?flag=link&img_name=<?php echo $rs_invite[event_link]?>','calendar_view_link','width=500 , height=400,scrollbars=1,resizable = 1'); " style="cursor:hand">
            <?php } else{echo '-';}?>        </td>
        </tr>
      <?php 
	  		}
	  } //end while
}

?>
    </table>
	<?php												
																if($chk_event == 0){
															?>
<table width="100%" border="0" cellpadding="0" cellspacing="1" bgcolor="#C66504">
  <tr>
    <td bgcolor="#FFFFFF"><div align="center" style="color:#FF0000">ไม่มีข้อมูลกิจกรรม</div></td>
  </tr>
</table>

															<?php } ?>
    </td>
  </tr>


</table>
<br>
<?php if($chk_event > 0) {?>
<table width="800" border="0" align="center" cellpadding="3" cellspacing="1">
  <tr>
    <th width="285" height="30" scope="col"><div align="left">
      <div align="left"> จำนวนแสดงต่อหน้า
        <input type="text" name="limit"  size="5" value="<?php echo $limit?>">
          <input name="button" type="button" onClick="document.frm1.submit();" value="เปลี่ยน">
      </div>
    </div></th>
    <th scope="col"><div align="right">หน้าที่
      <select name="page" onChange="document.frm1.submit();">
            <?php
							for($i=1;$i<=$page_all;$i++){
								if($i == $page) $selected = "selected";
								else $selected = "";
								print "<option value=\"$i\" $selected>$i</option>";
							}
						?>
          </select>
      /
  <?php echo $page_all?>
      หน้า</div></th>
    </tr>
</table>
   <?php }?>
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td height="33" align="right">
      <input type="button" name="Submit" value="  ปิด  " onClick="window.close();">    </td>
    </tr>
</table>

</form>
</body>
</html>

<script language="javascript">
		function order_field(deasc,orderby){
		    document.frm1.deasc.value=deasc;
		    document.frm1.orderby.value=orderby;
            document.frm1.submit();
		}
</script>

<?php
$db->db_close(); ?>
