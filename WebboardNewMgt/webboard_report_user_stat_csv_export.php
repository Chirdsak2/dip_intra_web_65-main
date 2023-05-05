<?php

$today = date("Y-m-d H:i:s");

include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");


$depth = 0;

function list_room($c_id,$depth,$con_a){
    
    global $db;
    global $depth;
    global $fp;
    
    
    $sql_subcate = "SELECT * FROM w_cate 
                    WHERE c_parentid = '$c_id' AND c_use = 'Y'";
    
    $result_subcate = $db->query($sql_subcate);
    
    $order_subcate = 1;
    
    while($subcate = $db->db_fetch_array($result_subcate)){
    
        $level_indicator = "";

        for($e=0;$e<($depth+1);$e++){ $level_indicator.=">"; } 
        
        fputcsv($fp, array( $level_indicator." ".$subcate[c_name]));
        

        $sql_q = $db->query("SELECT * 
                                from  w_question 
                                where 1=1 AND s_id='1' and c_id = '".$subcate[c_id]."'  ");
        $num_q = $db->db_num_rows($sql_q);

        $list_q = 1;

        while($rec_q = $db->db_fetch_array($sql_q)){

            $sql_a = $db->query("SELECT count(*) as num 
                        from w_answer 
                        where 1=1 and t_id = '".$rec_q[t_id]."' ".$con_a." ");
            $rec_a = $db->db_fetch_array($sql_a);
            
            fputcsv($fp, array($list_q.'.',$rec_q[t_name],$rec_a[num]));

            $list_q++;
        
        }
    
        if($num_q == 0){

            
            fputcsv($fp, array("ไม่พบหัวข้อกระทู้"));
            
        }

    
        $sql_subcate1 = "SELECT * FROM w_cate 
                        WHERE c_parentid = '$subcate[c_id]' AND c_use = 'Y'";

        $result_subcate1 = $db->query($sql_subcate1);
        $subcate1_row    = $db->db_num_rows($result_subcate1);

        
        if($subcate1_row>0){
            $depth++;
            list_room($subcate[c_id],$depth,$con_a);
            
        }
        else{
        
        }
        
        $order_subcate++;
    } 
    $depth--;
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
header('Content-Disposition: attachment; filename="Report User Stat ['.$start_date.' - '.$end_date.'].csv"');




//===================
// CSV category bar
//===================

$t_bar = array('No.','Language','Email','Active Status','Date');

$fp = fopen('php://output', 'wb');
fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));
$n  = 1;

//===================
// CSV File 
//===================

fputcsv($fp, array('สถิติการตอบคำถามเว็บบอร์ด'));
fputcsv($fp, array('รายการ','จำนวนผู้อ่าน'));


list_room(0, 1,$con_a); 


fclose($fp);


?>