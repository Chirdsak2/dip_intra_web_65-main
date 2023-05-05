<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";
function DiffToText_new($diff)
            {
          /*  if (floor($diff/31536000))
                        {
                        $x = floor($diff / 31536000);
                        echo " $x ปี ";
                        $diff = $diff - ($x * 31536000);
                        return DiffToText_new($diff);
                        }
            elseif (floor($diff/2678400))
                        {
                        $x = floor($diff / 2678400);
                        echo " $x เดือน ";
                        $diff = $diff - ($x * 2678400);
                        return DiffToText_new($diff);
                        }
            else*/if ($diff>=86400)
                        {
                        $x = floor($diff / 86400);
						//if($x  > 0){
                        echo " $x วัน";
                        $diff = $diff - ($x * 86400);
                        return DiffToText_new($diff);
						//}
                        }
            elseif ($diff>=3600)
                        {
                        $x = floor($diff / 3600);
                        echo " $x ชั่วโมง";
                        $diff = $diff - ($x * 3600);
                        return DiffToText_new($diff);
                        }

            elseif ($diff>=60)
                        {
                        $x = floor($diff / 60);
                        echo " $x นาที ";
                        $diff = $diff - ($x * 60);
                        return DiffToText_new($diff);
                        }
            else if ($diff)
						if($diff > 0){
                        echo " $diff วินาที ";
						}
            }
if(empty($start_date) && $Flag ==''){
$start_date = date("d/m/").(date("Y")+543);
}
if(empty($end_date) && $Flag ==''){
$end_date = date("d/m/").(date("Y")+543);
}
 if (empty($offset) || $offset < 0) { 
        $offset=0; 
    } 
//    Set $limit,  $limit = Max number of results per 'page' 

$limit = $CO[c_number];
if(empty($limit)){
$limit =10;
}
	$begin =($offset+1); 
    $end = ($begin+($limit-1)); 
    if ($end > $totalrows) { 
        $end = $totalrows; 
    } 
?>
<html>
<head>
<title>Stat</title>
<META HTTP-EQUIV="Content-Language" content="th">
<META HTTP-EQUIV="Content-Type" content="text/html; charset=UTF-8">
<script language="JavaScript"  type="text/javascript" src="../StatMgt/lib_carendar/calendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../StatMgt/lib_carendar/loadcalendar.js"></script>
<script language="JavaScript"  type="text/javascript" src="../StatMgt/lib_carendar/calendar-th.js"></script>
<link href="../StatMgt/lib_carendar/style_calendar.css" rel="stylesheet" type="text/css">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.style1 {color: #FF0000}
-->
</style>
</head>
<body bgcolor="#FFFFFF" leftmargin="0" topmargin="0" >
<?php include("../FavoritesMgt/favorites_include.php");?>
<table width="80%" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr> 
    <td><img src="../theme/main_theme/logo.gif" width="32" height="32" align="absmiddle"> 
      <span class="ewtfunction">รายงานการใช้งานเว็บบอร์ด</span> </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="0" cellspacing="0" class="ewtfunctionmenu">
  <tr>
    <td align="right"><a href="javascript:void(0);" onClick="load_divForm('../FavoritesMgt/favorites_add.php?name=<?php echo urlencode("รายงานการใช้งานเว็บบอร์ด");?>&module=webboard&url=<?php echo urlencode("report_webboard.php");?>', 'divForm', 300, 80, -1,433, 1);"><img src="../images/star_yellow_add.gif" width="16" height="16" border="0" align="middle">&nbsp;Add to favorites </a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<hr>
    </td>
  </tr>
</table>
<table width="94%" border="0" align="center" cellpadding="3" cellspacing="0" class="ewtfunctionmenu">
  <tr> 
    <form name="form1" method="post" action=""> 
      <td> <table width="100%" border="0" align="center" cellpadding="5" cellspacing="1" class="ewttableuse">
         <tr>
           <td colspan="2" bgcolor="#FFFFFF" class="ewttablehead">ค้นหา</td>
          </tr>
         <tr>
           <td width="27%" bgcolor="#FFFFFF">วันที่ :<span class="style1">*</span> </td>
           <td width="73%" bgcolor="#FFFFFF">
        <input type="text" name="start_date" size="15" value="<?php print  $start_date; ?>" id="start_date">
      <img src="../images/calendar.gif" alt="..เปิดปฎิทิน." width="20" height="20" border="0" align="absmiddle" onClick="return showCalendar('start_date', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';"> 
      ถึง 
      <input type="text" name="end_date" size="15" value="<?php print  $end_date;  ?>" id="end_date">
      <img src="../images/calendar.gif" alt="..เปิดปฎิทิน." width="20" height="20" border="0" align="absmiddle" onClick="return showCalendar('end_date', 'dd-mm-y');" onMouseOver="this.style.cursor='hand';">      </td>
         </tr>
         <tr>
           <td bgcolor="#FFFFFF">แสดง : </td>
           <td width="73%" bgcolor="#FFFFFF"><select name="query_show">
		   <option value="" <?php if($_POST[query_show]==''){ echo "selected";}?>>--ทั้งหมด--</option>
		   <option value="1" <?php if($_POST[query_show]=='1'){ echo "selected";}?> >ที่ตอบกลับแล้ว</option>
		   <option value="2" <?php if($_POST[query_show]=='2'){ echo "selected";}?>>ที่ยังไม่ได้ตอบกลับ</option>
           </select>
           </td>
         </tr>
         <tr>
           <td colspan="2" align="center" bgcolor="#FFFFFF"><input type="submit" name="Submit" value="แสดงข้อมูล">
            <input name="Flag" type="hidden" id="Flag" value="View"></td>
          </tr>
       </table>
      <br>
</td>
    </form>
  </tr>
</table>

<?php
if($Flag == "View"){
if($start_date == "" AND $end_date == ""){
$con = "";
$date_name = "";
}elseif($start_date != "" AND $end_date == ""){
$st = explode("/",$start_date);
$con = " AND (t_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
$date_name = "วันที่".$start_date;
}elseif($start_date == "" AND $end_date != ""){
$st = explode("/",$end_date);
$con = " AND (t_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
$date_name = "วันที่".$end_date;
}else{
$st = explode("/",$start_date);
$en = explode("/",$end_date);
$con = " AND (t_date BETWEEN '".($st[2] -543)."-".$st[1]."-".$st[0]."' AND '".($en[2] - 543)."-".$en[1]."-".$en[0]."') ";
$date_name = "วันที่".$start_date."ถึง วันที่".$end_date;
}

$db->write_log("view","webboard","ดูรายงานการใช้งาน webboard");
if($query_show == ''){
$sql = mysql_query("select w_question.*,w_cate.c_name from  w_question,w_cate where 1=1 and  w_question.c_id =w_cate.c_id ".$con."  order by t_date DESC,t_time DESC  ");
}else{
$sql = mysql_query("select w_question.*,w_cate.c_name from  w_question,w_cate where 1=1 and  w_question.c_id =w_cate.c_id  ".$con." order by t_date DESC,t_time DESC ");
}
//$A = mysql_fetch_row($sql_ct);

?>
<table width="100%" border="0" cellspacing="0" cellpadding="1">
  <tr> 
    <td align="center"><table width="94%" border="0" cellpadding="2" cellspacing="1" class="ewtsubmenu">
     <tr>
        <td colspan="5" align="center" class="MemberHead"><strong>รายชื่อกลุ่มเป้าหมายในการให้บริการ</strong></td>
        </tr> 
      <tr>
        <td colspan="5" align="center" class="MemberHead"><?php echo $date_name;?> </td>
        </tr>
      <tr>
        <td colspan="5"><span class="cellcal">การให้บริการด้าน</span> การให้บริการข้อมูลอิเล็กทรอนิกส์ผ่านทางระบบอินเตอร์เน็ต </td>
        </tr>
     <tr>
        <td colspan="5" align="right" class="MemberHead"><img src="../images/checked_n2.gif" width="15" height="15" align="absmiddle" style="background-color: #66FF66" >&nbsp;มาใหม่&nbsp;<img src="../images/checked_n2.gif" width="15" height="15" align="absmiddle" style="background-color: #FF0000" >&nbsp;รอคำตอบ&nbsp;<img src="../images/checked_n2.gif" width="15" height="15" align="absmiddle" style="background-color: #FFFFFF" >&nbsp;ตอบแล้ว&nbsp;</td>
        </tr>
    </table></td>
  </tr>
  <tr> 
    <td width="47%" align="center"><table width="94%" border="0" cellpadding="2" cellspacing="1" bgcolor="#000000" class="ewttableuse">
      <tr>
        <td width="4%" align="center" class="ewttablehead"><strong>ลำดับ</strong></td>
        <td width="11%" align="center" class="ewttablehead"><strong>ข้อมูลที่โพส</strong></td>
        <td width="5%" align="center" class="ewttablehead">หมวด</td>
        <td width="9%" align="center" class="ewttablehead"><strong>ชื่อผู้โพสข้อมูล</strong></td>
        <td width="7%" align="center" class="ewttablehead"><strong>e-mail address </strong></td>
        <td width="4%" align="center" class="ewttablehead"><strong>เลขที่</strong></td>
        <td width="9%" align="center" class="ewttablehead"><strong>วัน/เดือน/ปี<br>
          ที่ติดต่อ</strong></td>
        <td width="7%" align="center" class="ewttablehead"><strong>เวลาติดต่อ</strong></td>
        <td width="9%" align="center" class="ewttablehead"><strong>วัน/เดือน/ปี <br>  
          ที่ตอบกลับ </strong></td>
        <td width="9%" align="center" class="ewttablehead"><strong>เวลาตอบกลับ</strong></td>
        <td width="7%" align="center" class="ewttablehead"><strong>หน่วยงาน</strong></td>
        <td width="19%" align="center" class="ewttablehead"><strong>ระยะเวลาการให้บริการ(นาที)</strong></td>
        </tr>
	  <?php
	  $i=1;
	  while($R=$db->db_fetch_array($sql)){
	  	 $date = explode("-",$R[t_date]);
	 	 $time = explode(":",$R[t_time]);
	 	 $d2 = mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);
      	$d_df = mktime(0, 0, 0, date(m), date(d), date(Y));
		
		if($R[user_id] != '0'){
					$db->query("USE ".$EWT_DB_USER);
					$sql_img = "select * from gen_user,emp_type where gen_user.emp_type_id = emp_type.emp_type_id and gen_user_id = '".$R[user_id]."'";
					$query = $db->query($sql_img);
					$rec_img = $db->db_fetch_array($query);
					$db->query("USE ".$EWT_DB_NAME);
						$name_a = stripslashes($rec_img[name_thai].'   '.$rec_img[surname_thai]); 
						$mail = $rec_img[email_person];
						$emp_type  = $rec_img[emp_type_name];
						$user_id = $rec_img[emp_id];
		}else{
						$name_a = $R[q_name]; 
						$mail = $R[q_email];
						$emp_type  = 'ประชาชนทั่วไป';
						$user_id = $R[t_id];
		}
		
		$sql_an = "select * from w_answer where t_id = '".$R[t_id]."' order by a_id ASC";
		$query_an = $db->query($sql_an);
		$rec = $db->db_fetch_array($query_an);
		$date_an = explode("-",$rec[a_date]);
		$time_an = explode(":",$rec[a_time]);
		if($db->db_num_rows($query_an)>0){
		$d1 = mktime($time_an[0], $time_an[1], $time_an[2], $date_an[1], $date_an[2], $date_an[0]);
		$color = "#FFFFFF";
		}else{
		$d1 = 0;
		
			if(($d_df-$d2 ) >86400){
				$color = "#FF0000";
			}else if(($d_df-$d2 ) < 86400){
				$color = "#66FF66";
			}
		}
		$diff = $d1-$d2;
			


if($query_show == '1'){
	if($db->db_num_rows($query_an)>0){
	
	  ?>
      <tr bgcolor="<?php echo $color;?>">
        <td align="center" ><?php echo $i+$offset; ?></td>
        <td ><?php echo $R[t_name]; ?></td>
        <td ><?php echo $R[c_name]; ?></td>
        <td ><?php echo $name_a; ?></td>
        <td ><?php echo $mail; ?></td>
        <td ><?php echo $user_id; ?></td>
        <td ><?php echo $R[t_date]; ?></td>
        <td ><?php echo $R[t_time]; ?></td>
        <td ><?php echo $rec[a_date];?></td>
        <td ><?php echo $rec[a_time];?></td>
        <td align="center" ><?php echo $emp_type;?></td>
        <td ><?php echo DiffToText_new($diff);?></td>
        </tr>
	  <?php 
	   $i++;
	  }
	 }else if($query_show == '2'){
	 if($db->db_num_rows($query_an)==0){
	
	  ?>
      <tr bgcolor="<?php echo $color;?>">
        <td align="center" ><?php echo $i+$offset; ?></td>
         <td ><?php echo $R[t_name]; ?></td>
         <td ><?php echo $R[c_name]; ?></td>
         <td ><?php echo $name_a; ?></td>
        <td ><?php echo $mail; ?></td>
        <td ><?php echo $user_id; ?></td>
        <td ><?php echo $R[t_date]; ?></td>
        <td ><?php echo $R[t_time]; ?></td>
        <td ><?php echo $rec[a_date];?></td>
        <td ><?php echo $rec[a_time];?></td>
        <td align="center" ><?php echo $emp_type;?></td>
        <td ><?php echo DiffToText_new($diff);?></td>
        </tr>
	  <?php 
	   $i++;
	  }
	 }else{
	 ?>
      <tr bgcolor="<?php echo $color;?>">
        <td align="center" ><?php echo $i+$offset; ?></td>
         <td ><?php echo $R[t_name]; ?></td>
         <td ><?php echo $R[c_name]; ?></td>
         <td ><?php echo $name_a; ?></td>
        <td ><?php echo $mail; ?></td>
        <td ><?php echo $user_id; ?></td>
        <td ><?php echo $R[t_date]; ?></td>
        <td ><?php echo $R[t_time]; ?></td>
        <td ><?php echo $rec[a_date];?></td>
        <td ><?php echo $rec[a_time];?></td>
        <td align="center" ><?php echo $emp_type;?></td>
        <td ><?php echo DiffToText_new($diff);?></td>
        </tr>
	  <?php 
	   $i++;
	 }
	 
  } 
	  
	  ?>
      <!--<tr>
        <td colspan="11" bgcolor="#FFFFFF">&nbsp;</td>
        </tr>-->
    </table></td>
  </tr>
</table>
<center><br><br><a href="pop_report_webboard.php?start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>" target="_blank">Print</a>&nbsp;|&nbsp;<a href="print1.php?start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>" target="_blank">Export to PDF</a>&nbsp;|&nbsp;<a  href="report_webboard_excel.php?start_date=<?php echo $start_date;?>&end_date=<?php echo $end_date;?>&query_show=<?php echo $_POST["query_show"];?>&FlagE=excel&Flag=View" target="_blank">Export to Excel</a></center>
<?php } ?>

</body>
</html>
<?php
$db->db_close(); ?>
