<?php
exit;
session_start();
include("../lib/include_bizadmin.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/ewt_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_NAME);
$db->query("USE ".$EWT_DB_NAME);
$sql = $db->query("SELECT * FROM dictionary WHERE DICT_SEARCH != '' ORDER BY DICT_SEARCH");
while($D=$db->db_fetch_array($sql)){

$S = explode(",",$D[DICT_SEARCH]);
$c = count($S);
for($i=0;$i<$c;$i++){
$ds = stripslashes(htmlspecialchars(trim($S[$i]),ENT_QUOTES));
$db->query("INSERT INTO dictionary (DICT_ID,DICT_WORD,DICT_SEARCH,DICT_SYNONYM) VALUES ('','$ds','$D[DICT_WORD]','$D[DICT_SYNONYM]')");
}

}
echo "Done!";
$db->db_close();
?>
