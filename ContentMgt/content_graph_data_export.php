<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

	$sql_graph = $db->query("SELECT * FROM graph_index WHERE graph_id = '".$graph_id."'");
	$R = $db->db_fetch_array($sql_graph);

	$sql_x = $db->query("SELECT * FROM graph_x WHERE graph_id = '".$graph_id."' ORDER BY x_id ASC");
	$row_x = $db->db_num_rows($sql_x);
	$width = 200 + (74 * $row_x);
	
	$sql_y = $db->query("SELECT * FROM graph_y WHERE graph_id = '".$graph_id."' ORDER BY y_id ASC");
	$row_y = $db->db_num_rows($sql_y);
	
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition:  filename=form_excel.xls");
header( 'Content-Description: Download Data' );
header( 'Pragma: no-cache' );
header( 'Expires: 0' );

echo '<table><tr><td></td>';
	$value_x = array(); $j = 0;
	while($X = $db->db_fetch_array($sql_x)){
		$value_x[$j] = $X["x_id"];
		echo '<td>'.$X['x_title'].'</td>';
		$j++;
	}
	echo '</tr>';
	while($Y = $db->db_fetch_array($sql_y)){
		echo '<tr><td>'.$Y["y_title"].'</td>';
		for($i=0;$i<$row_x;$i++){
			$sql_value = $db->query("SELECT value_value FROM graph_value WHERE graph_id = '".$graph_id."' AND graph_x = '".$value_x[$i]."' AND graph_y = '".$Y["y_id"]."' ");
			$V = $db->db_fetch_row($sql_value);
			echo '<td>'.$V[0],'</td>';
		}
		echo '</tr>';
		$k++;
	}
	echo '</table>';
?>