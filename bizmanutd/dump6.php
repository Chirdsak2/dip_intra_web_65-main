<?php
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);
$sql = $db->query("SELECT * FROM user_temp1 ORDER BY id");
while($R=$db->db_fetch_array($sql)){

$db->query("INSERT INTO gen_user (emp_id,title_thai,name_thai,surname_thai,posittion,tel_convenient,tel_in,org_id,officeaddress) VALUES ('$R[tid]','$R[ttitle]','$R[tname]','$R[tsur]','$R[tpos]','$R[tel]','$R[texp]','$R[tdiv]','$R[tadd]')");

}
echo "Done!";
$db->db_close();
?>
