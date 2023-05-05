<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

$column_text = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z");
$array_color = array("F6BD0F","AFD8F8","1941A5","8BBA00","A66EDD","F984A1","CCCC00","999999","0099CC","FF0000","006F00","0099FF","FF66CC","669966","7C7CB4","FF9933","9900FF","99FFCC","CCCCFF","669900","AFD8F8","8BBA00","FF8E46","008E8E","D64646","8E468E","588526","B3AA00","008ED6","9D080D","A186BE","F6BD0F","AFD8F8","1941A5","8BBA00","A66EDD","F984A1","CCCC00","999999","0099CC","FF0000","006F00","0099FF","FF66CC","669966","7C7CB4","FF9933","9900FF","99FFCC","CCCCFF","669900","AFD8F8","8BBA00","FF8E46","008E8E","D64646","8E468E","588526","B3AA00","008ED6","9D080D","A186BE",);


$graph_id=$_POST['graph_id'];
if ($_FILES["csvFile"]["error"] > 0)
  {
  echo "Error: " . $_FILES["csvFile"]["error"] . "<br>";
  }
else
  {
	$objFopen = fopen($_FILES["csvFile"]["tmp_name"], 'r');
		if ($objFopen) {
			$db->query('DELETE FROM graph_value WHERE graph_id=\''.$graph_id.'\'');
			$db->query('DELETE FROM graph_x WHERE graph_id=\''.$graph_id.'\'');
			$db->query('DELETE FROM graph_y WHERE graph_id=\''.$graph_id.'\'');
			
			$numRow=0; $arrX=array(0,);
			while (($values = fgetcsv($objFopen, 1000)) !== FALSE) {
				if($numRow==0) {	// insert into graph_x
					$numCol=sizeof($values);
					for($i=1; $i<$numCol; $i++) {
						$strInsGX='INSERT INTO graph_x	(graph_id, x_title) VALUES	(\''.$graph_id.'\', \''.str_replace(',', '', $values[$i]).'\')';
						//echo $strInsGX.'<br/><br/>';
						$db->query($strInsGX);
						$qID=$db->query('SELECT MAX(x_id) AS x_id FROM graph_x WHERE graph_id=\''.$graph_id.'\' ORDER BY x_id DESC LIMIT 1');
						$rID=$db->db_fetch_array($qID);
						array_push($arrX, $rID[0]);
					}
				} else {	// insert into graph_y and graph_value
					$numCol=sizeof($values);
					for($i=0; $i<$numCol; $i++) {
						if($i==0 && $values[1]!='') {
							$strInsGY='INSERT INTO graph_y (graph_id, y_title, y_color) VALUES (\''.$graph_id.'\', \''.str_replace(',', '', $values[$i]).'\', \'#'.$array_color[($runningColor%62)].'\')';
							$db->query($strInsGY);
							$qYID=$db->query('SELECT MAX(y_id) AS y_id FROM graph_y WHERE graph_id=\''.$graph_id.'\' ORDER BY y_id DESC LIMIT 1');
							$rYID=$db->db_fetch_array($qYID);
							$yID=$rYID[0];
							$runningColor++;
							//echo $strInsGY.'<br/><br/>';
						} else if($values[1]!='') {
							$strInsV='INSERT INTO graph_value (graph_id, graph_x, graph_y, value_value) '.
							'VALUES (\''.$graph_id.'\', \''.$arrX[$i].'\', \''.$yID.'\', \''.str_replace(',', '', $values[$i]).'\')';
							$db->query($strInsV);
							//echo $strInsV.'<br/><br/>';
						}
					}
				}
				$numRow++;
			}
			fclose($objFopen);
		}
  }
//	print "Col ".$values[0]." col ".$values[1].".col ".$values[2]."<br>"; 
	$db->db_close();
	echo '<script language="javascript"> window.location.href="content_graph_data.php?graph_id='.$graph_id.'&tb_show=03"; </script>';
?>
