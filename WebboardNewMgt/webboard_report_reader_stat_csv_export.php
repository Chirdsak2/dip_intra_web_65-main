<?php

$today = date("Y-m-d");

include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$depth = 0;

function list_room($c_id,$depth){
    
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
        


        $sql_q = $db->query("  SELECT * 
                                from  w_question 
                                where 1=1 AND s_id='1' and c_id = '".$subcate[c_id]."'  ");
        $num_q = $db->db_num_rows($sql_q);

        $list_q = 1;

        while($rec_q = $db->db_fetch_array($sql_q)){

            fputcsv($fp, array($list_q.'.',$rec_q[t_name],$rec_q[t_count]));

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
            list_room($subcate[c_id],$depth);
            
        }
        else{
        
        }
        
        $order_subcate++;
    } 
    $depth--;
}

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="Report Reader Stat ['.$today.'].csv"');


//===================
// CSV category bar
//===================

$fp = fopen('php://output', 'wb');
fprintf($fp, chr(0xEF).chr(0xBB).chr(0xBF));
//===================
// CSV File 
//===================

fputcsv($fp, array('สถิติการเข้าเว็บบอร์ดจำนวนผู้อ่าน'));
fputcsv($fp, array('รายการ','จำนวนผู้อ่าน'));


list_room(0, 1); 


fclose($fp);


?>