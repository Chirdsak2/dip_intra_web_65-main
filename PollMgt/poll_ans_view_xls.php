<?php 
include("../EWT_ADMIN/comtop_pop.php");
header('Content-Type: text/csv; charset=utf-8');  
header('Content-Disposition: attachment; filename=export_poll_'.date("YmdHis").'.csv'); 
echo "\xEF\xBB\xBF";
$output = fopen("php://output", "w");  

$q_quest = $db->query("select c_name, c_detail from poll_cat where c_id = '".$_GET['c_id']."'");
$r_quest = $db->db_fetch_array($q_quest);
fputcsv($output, array($r_quest['c_name']));  

$q_ans = $db->query("select * from poll_ans where c_id = '".$_GET['c_id']."' order by a_position asc");
while($r_ans = $db->db_fetch_array($q_ans)){
   fputcsv($output, array($r_ans['a_name'],$r_ans['a_counter']));  
}  
fclose($output);  

$db->db_close(); 	
?>