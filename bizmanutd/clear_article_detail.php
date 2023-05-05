<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");

$db_list = mysql_list_dbs($connectdb);

$i = 0;
$cnt = mysql_num_rows($db_list);
while ($i < $cnt) {
		//echo mysql_db_name($db_list, $i) . '</a> - ';
		
		$db->query("USE ".mysql_db_name($db_list, $i));
		$db->query('DELETE FROM article_detail WHERE n_id NOT IN (SELECT n_id FROM article_list)');
		$i++;
}


$db->db_close();
?>
