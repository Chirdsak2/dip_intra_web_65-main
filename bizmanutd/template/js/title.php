<?php
header ("Content-Type:text/plain;charset=UTF-8");
   set_time_limit(180);
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
$db->query("USE ".$EWT_DB_USER);

$sql = "SELECT title_thai,title_id FROM title where title_id = '$title_id'";
$query = $db->query($sql);
$rec = $db->db_fetch_array($query);
$name_thai = $rec[title_thai];

?>
  <select name="title_thai" id="title_thai">
            <option value="" >--โปรดเลือก--</option>
            <?php //$disp->ddw_list_selected ("SELECT * FROM title  ","title_thai","title_id",$title_thai);?>
            <?php 
						$sql_title = "SELECT title_thai,title_id FROM title group by title_thai";
						$query_title = $db->query($sql_title);
						while($rs_title = $db->db_fetch_array($query_title)){
							if($rs_title[title_thai] == $name_thai) $selected_title = "selected";
							else $selected_title = "";
							print '<option value="'.$rs_title[title_id].'" '.$selected_title.'>'.$rs_title[title_thai].'</option>';
						}
					?>
          </select>
<?php
$db->db_close(); ?>