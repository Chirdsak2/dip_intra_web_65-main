<?php
if($_GET["FlagE"] == "excel"){
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition:  filename=form_excel.xls");
header( 'Content-Description: Download Data' );
header( 'Pragma: no-cache' );
header( 'Expires: 0' );



}
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
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
</head>
<body leftmargin="0" topmargin="0" >
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
	<table width="100%" border="1" cellpadding="2" cellspacing="1" bgcolor="#000000" >
	     <tr bgcolor="FFFFFF"align="center" >
        <td colspan="12" >รายชื่อกลุ่มเป้าหมายในการให้บริการ</td>
        </tr> 
     <tr bgcolor="FFFFFF" align="center" >
        <td colspan="12" ><?php echo $date_name;?> </td>
      </tr>
     <tr bgcolor="FFFFFF">
        <td colspan="12"><span class="cellcal">การให้บริการด้าน</span> การให้บริการข้อมูลอิเล็กทรอนิกส์ผ่านทางระบบอินเตอร์เน็ต </td>
      </tr>
      <tr bgcolor="FFFFFF">
        <td  >ลำดับ</td>
        <td  >ข้อมูลที่โพส</td>
        <td >หมวด</td>
        <td  >ชื่อผู้โพสข้อมูล</td>
        <td  >e-mail address </td>
        <td  >เลขที่</td>
        <td  >วัน/เดือน/ปีที่ติดต่อ</td>
        <td >เวลาติดต่อ</td>
        <td  >วัน/เดือน/ปี ที่ตอบกลับ </td>
        <td  >เวลาตอบกลับ</td>
        <td   >หน่วยงาน</td>
        <td   >ระยะเวลาการให้บริการ(นาที)</td>
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
      <tr bgcolor="FFFFFF">
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
      <tr bgcolor="FFFFFF">
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
      <tr bgcolor="FFFFFF">
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
</table>
<?php } ?>

</body>
</html>
<?php
$db->db_close(); ?>
