<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
// table stat_visitor หา จำนวน record ที่ เข้ามาภายใน 1 นาที ในหน้า index
$filename ='index';
$count = 0;
$sql ="select COUNT(*) from stat_visitor where sv_menu = '$filename' AND sv_date = '".date("Y-m-d")."'  AND sv_time LIKE '".date("H:i:")."%' ";
$query = $db->query($sql);
$rec = $db->db_fetch_row($query);
if($rec[0]==0){
$rec[0] = "1";
}
echo "ขณะนี้มีผู้ Online อยู่  " . $rec[0] ."  คน";

?>
<?php $db->db_close(); ?>
