<?php 
include("../EWT_ADMIN/comtop_pop.php");
header('Content-Type: text/csv; charset=utf-8');  
header('Content-Disposition: attachment; filename=export_enews_'.date("YmdHis").'.csv'); 
echo "\xEF\xBB\xBF";
$output = fopen("php://output", "w");  
fputcsv($output, array('ลำดับ', 'อีเมล์ของสมาชิก', 'วันที่/เวลา', 'สถานะ'));  
$Sel= "select * from n_member where m_active = 'Y' order by m_id desc";
$_sql = $db->query($Sel);
$a_rows = $db->db_num_rows($_sql);

$i = 1;
while($a_data = $db->db_fetch_array($_sql))  
{  
   fputcsv($output, array($i,$a_data['m_email'],$a_data['m_date'],($a_data['m_active']=="Y"?'ใช้งาน':'ยกเลิก')));  
   $i++;
}  
fclose($output);  

$db->db_close(); 	
?>