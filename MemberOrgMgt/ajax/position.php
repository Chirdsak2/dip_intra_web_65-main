<?php
	header ("Content-Type:text/plain;charset=UTF-8");

   set_time_limit(180);
include("../../lib/permission2.php");
include("../../lib/include.php");
include("../../lib/function.php");
include("../../lib/user_config.php");
include("../../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);
?>
<select name="posittion"  id="posittion"    >
                    <option value="">--โปรดเลือก--</option>
					<?php 
					//pos_name
					echo $sql_position = $db->query("select * from position_name where org_id = '".$org_id."'");
					
					 while($rec_position = $db->db_fetch_array($sql_position)){
					  if($rec_position[pos_id] == $pos_id) $selected_position= "selected";
							else $selected_position = "";
							print '<option value="'.$rec_position[pos_id].'" '.$selected_position.'>'.$rec_position[pos_name].'</option>';
					  }
					?>
					</select>
<?php
 
$db->db_close(); ?>