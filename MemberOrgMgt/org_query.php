<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
$sql = "SELECT * FROM `gen_user`";
  $query = $db->query($sql);
  while($rec = $db->db_fetch_array($query)){
  
  $sql_pos = "select * from user_position,position_name 
  where user_position.pos_id = position_name.pos_id and user_position.org_id = '".$rec[org_id]."' and user_position.up_id = '".$rec[posittion]."'";
  $query_pos = $db->query($sql_pos);
  $rec_pos = $db->db_fetch_array($query_pos);
  echo $rec[gen_user_id].'---'.$rec[name_thai].'---'.$rec[surname_thai].'---'.$rec[org_id].'---'.$rec[posittion].'---'.$rec_pos[pos_name].'<br>';
 $update = "update gen_user set position_person = '".$rec_pos[pos_name]."',posittion='' where gen_user_id = '".$rec[gen_user_id]."'";
 $db->query($update);
  }

echo  "complete";


?>