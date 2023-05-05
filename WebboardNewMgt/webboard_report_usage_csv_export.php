<?php

$today = date("Y-m-d H:i:s");

include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");


$Globals_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/";
function DiffToText_new($diff)
            {
                global $a;
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
                        $a .= " $x วัน";
                        $diff = $diff - ($x * 86400);
                        return DiffToText_new($diff);
                        //}
                        }
            elseif ($diff>=3600)
                        {
                        $x = floor($diff / 3600);
                        $a .= " $x ชั่วโมง";
                        $diff = $diff - ($x * 3600);
                        return DiffToText_new($diff);
                        }

            elseif ($diff>=60)
                        {
                        $x = floor($diff / 60);
                        $a .= " $x นาที ";
                        $diff = $diff - ($x * 60);
                        return DiffToText_new($diff);
                        }
            else if ($diff)
                        if($diff > 0){
                        $a .= " $diff วินาที ";

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


$start_date = str_replace("-","/",$start_date);
$end_date   = str_replace("-","/",$end_date);

if($start_date == "" AND $end_date == ""){
    $con = "";
    $con_a = "";
    $date_name = "";
    }elseif($start_date != "" AND $end_date == ""){
    $st = explode("/",$start_date);
    $con = " AND (t_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
    $con_a = " AND (a_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
    $date_name = "วันที่".$start_date;
    }elseif($start_date == "" AND $end_date != ""){
    $st = explode("/",$end_date);
    $con = " AND (t_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
    $con_a = " AND (a_date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
    $date_name = "วันที่".$end_date;
    }else{
    $st = explode("/",$start_date);
    $en = explode("/",$end_date);
    $con = " AND (t_date BETWEEN '".($st[2] -543)."-".$st[1]."-".$st[0]."' AND '".($en[2] - 543)."-".$en[1]."-".$en[0]."') ";
    $con_a = " AND (a_date BETWEEN '".($st[2] -543)."-".$st[1]."-".$st[0]."' AND '".($en[2] - 543)."-".$en[1]."-".$en[0]."') ";
    $date_name = "วันที่".$start_date."ถึง วันที่".$end_date;
}

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="Report Usage ['.$start_date.' - '.$end_date.'].csv"');


//===================
// CSV category bar
//===================

$fp = fopen('php://output', 'wb');
fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));
//===================
// CSV File 
//===================

fputcsv($fp, array('สถิติการเข้าใช้งานเว็บบอร์ด'));
fputcsv($fp, array("ลำดับ", "ข้อมูลที่โพส", "หมวด", "ชื่อผู้โพสข้อมูล", "e-mail address", "เลขที่", "วัน/เดือน/ปี ที่ติดต่อ", "เวลาติดต่อ", "วัน/เดือน/ปี ที่ตอบกลับ", "เวลาตอบกลับ", "หน่วยงาน", "ระยะเวลาการให้บริการ(นาที)"));


	//===================
	//   SQL
	//===================
    
    
        if($query_show == ''){
            $sql = $db->query("select w_question.*,w_cate.c_name from  w_question,w_cate where 1=1 and  w_question.c_id =w_cate.c_id ".$con."  order by t_date DESC,t_time DESC  ");
        }else{
            $sql = $db->query("select w_question.*,w_cate.c_name from  w_question,w_cate where 1=1 and  w_question.c_id =w_cate.c_id  ".$con." order by t_date DESC,t_time DESC ");
        }
    
        $i =1;
        
        while($R=$db->db_fetch_array($sql)){
            $date = explode("-",$R[t_date]);
            $time = explode(":",$R[t_time]);
            $d2 = mktime($time[0], $time[1], $time[2], $date[1], $date[2], $date[0]);
            $d_df = mktime(0, 0, 0, date(m), date(d), date(Y));
            
            if($R[user_id] != '0'){
                        $db->query("USE ".$EWT_DB_USER);
                        $sql_img = "SELECT * from gen_user,emp_type where gen_user.emp_type_id = emp_type.emp_type_id and gen_user_id = '".$R[user_id]."'";
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
            
            $sql_an = "SELECT * from w_answer where t_id = '".$R[t_id]."' order by a_id ASC";
            $query_an = $db->query($sql_an);
            $rec = $db->db_fetch_array($query_an);
            $date_an = explode("-",$rec[a_date]);
            $time_an = explode(":",$rec[a_time]);
    
            if($db->db_num_rows($query_an)>0){
            $d1 = mktime($time_an[0], $time_an[1], $time_an[2], $date_an[1], $date_an[2], $date_an[0]);
            $color = "ffffff";
            }else{
            $d1 = 0;
            
                if(($d_df-$d2 ) >86400){
                    $color = "ec4848";
                }else if(($d_df-$d2 ) < 86400){
                    $color = "20e658";
                }
            }
            $diff = $d1-$d2;
                
            $a = "";
    
            //echo $color."<br>";
    
            if($query_show == '1'){
                if($db->db_num_rows($query_an)>0){
    
                    fputcsv($fp, array($i.'. ',$R[t_name], $R[c_name], $name_a, $mail, $user_id, $R[t_date], $R[t_time], $rec[a_date], $rec[a_time], $emp_type));
                    $i++;
                }
            }else if($query_show == '2'){
                if($db->db_num_rows($query_an)==0){
                    
                    fputcsv($fp, array($i.'. ',$R[t_name], $R[c_name], $name_a, $mail, $user_id, $R[t_date], $R[t_time], $rec[a_date], $rec[a_time], $emp_type));
                    $i++;
                }
            }else{
                
                    fputcsv($fp, array($i.'. ',$R[t_name], $R[c_name], $name_a, $mail, $user_id, $R[t_date], $R[t_time], $rec[a_date], $rec[a_time], $emp_type));
                    $i++;
            }
                
        } 

fclose($fp);


?>