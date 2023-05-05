<?php
exit;
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");

include("../lib/connect.php");

$db->query("USE ".$EWT_DB_NAME);

/*
$sql = $db->query("SELECT * FROM temp_import ");
while($R=$db->db_fetch_array($sql)){
$tname = eregi_replace("'","",trim($R[t_name]));
$tname = eregi_replace("     "," ",$tname);
$tname = eregi_replace("    "," ",$tname);
$tname = eregi_replace("   "," ",$tname);
$tname = eregi_replace("  "," ",$tname);
$tname = eregi_replace("นาย","นาย ",$tname);
$tname = eregi_replace("นาง","นาง ",$tname);
$tname = eregi_replace("นาง สาว","นางสาว ",$tname);
$db->query("UPDATE temp_import SET t_name = '$tname' WHERE t_id = '$R[t_id]' ");

}
*/
$sql = $db->query("SELECT * FROM temp_import2 ");
while($R=$db->db_fetch_array($sql)){
$tname = eregi_replace("'","",trim($R[t_name]));
$tname = eregi_replace("     "," ",$tname);
$tname = eregi_replace("    "," ",$tname);
$tname = eregi_replace("   "," ",$tname);
$tname = eregi_replace("  "," ",$tname);
$tname = eregi_replace("นาย","นาย",$tname);
$tname = eregi_replace("นาง","นาง",$tname);
$tname = eregi_replace("นาง สาว","นางสาว ",$tname);
$tname = eregi_replace("น.ส.","นางสาว ",$tname);
$db->query("UPDATE temp_import2 SET t_name = '$tname' WHERE t_id = '$R[t_id]' ");
}
echo "Done!";
$db->db_close();
?>
