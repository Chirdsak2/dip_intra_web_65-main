<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");

					if($_POST["Flag"] == "GraphData"){
//Set Y
for($i=0;$i<$_POST["ally"];$i++){

	$y_title = $_POST["y_title".$i];
	$y_title = stripslashes(htmlspecialchars($y_title,ENT_QUOTES));
	$bgcolor = $_POST["bgcolor".$i];
	$y_id = $_POST["y_id".$i];

	$db->query("UPDATE graph_y SET y_title = '$y_title',y_color ='$bgcolor' WHERE y_id = '$y_id'");

}
//End Y
for($x=0;$x<$_POST["allx"];$x++){
	$x_title = $_POST["x_title".$x];
	$x_title = stripslashes(htmlspecialchars($x_title,ENT_QUOTES));
	$x_id = $_POST["x_id".$x];

	$db->query("UPDATE graph_x SET x_title = '$x_title' WHERE x_id = '$x_id'");

			for($y=0;$y<$_POST["ally"];$y++){

				$value_id = $_POST["ix".$x."y".$y];
				$value_value = $_POST["vx".$x."y".$y];
				$db->query("UPDATE graph_value SET value_value = '$value_value' WHERE value_id = '$value_id'");

			}
}

if($_POST["todo"] == "InsCol"){
	$db->query("INSERT INTO graph_x (graph_id,x_title) VALUES ('".$_POST["graph_id"]."','') ");
	$sql_max = $db->query("SELECT MAX(x_id) FROM graph_x WHERE graph_id = '".$_POST["graph_id"]."' ");
	$MX = $db->db_fetch_row($sql_max);
		$sql_row = $db->query("SELECT y_id FROM graph_y WHERE graph_id = '".$_POST["graph_id"]."' ");
		while($Y = $db->db_fetch_row($sql_row)){
			$db->query("INSERT INTO graph_value (graph_id,graph_x,graph_y,value_value) VALUES ('".$_POST["graph_id"]."','$MX[0]','$Y[0]','0')");
		}
}

if($_POST["todo"] == "InsRow"){ 
$colorarray=array("F6BD0F","AFD8F8","1941A5","8BBA00","A66EDD","F984A1","CCCC00","999999","0099CC","FF0000","006F00","0099FF","FF66CC","669966","7C7CB4","FF9933","9900FF","99FFCC","CCCCFF","669900","AFD8F8","8BBA00","FF8E46","008E8E","D64646","8E468E","588526","B3AA00","008ED6","9D080D","A186BE","F6BD0F","AFD8F8","1941A5","8BBA00","A66EDD","F984A1","CCCC00","999999","0099CC","FF0000","006F00","0099FF","FF66CC","669966","7C7CB4","FF9933","9900FF","99FFCC","CCCCFF","669900","AFD8F8","8BBA00","FF8E46","008E8E","D64646","8E468E","588526","B3AA00","008ED6","9D080D","A186BE","F6BD0F","AFD8F8","1941A5","8BBA00","A66EDD","F984A1","CCCC00","999999","0099CC","FF0000","006F00","0099FF","FF66CC","669966","7C7CB4","FF9933","9900FF","99FFCC","CCCCFF","669900","AFD8F8","8BBA00","FF8E46","008E8E","D64646","8E468E","588526","B3AA00","008ED6","9D080D","A186BE","F6BD0F","AFD8F8","1941A5","8BBA00","A66EDD","F984A1","CCCC00","999999","0099CC","FF0000","006F00","0099FF","FF66CC","669966","7C7CB4","FF9933","9900FF","99FFCC","CCCCFF","669900","AFD8F8","8BBA00","FF8E46","008E8E","D64646","8E468E","588526","B3AA00","008ED6","9D080D","A186BE","F6BD0F","AFD8F8","1941A5","8BBA00","A66EDD","F984A1","CCCC00","999999","0099CC","FF0000","006F00","0099FF","FF66CC","669966","7C7CB4","FF9933","9900FF","99FFCC","CCCCFF","669900","AFD8F8","8BBA00","FF8E46","008E8E","D64646","8E468E","588526","B3AA00","008ED6","9D080D","A186BE","F6BD0F","AFD8F8","1941A5","8BBA00","A66EDD","F984A1","CCCC00","999999","0099CC","FF0000","006F00","0099FF","FF66CC","669966","7C7CB4","FF9933","9900FF","99FFCC","CCCCFF","669900","AFD8F8","8BBA00","FF8E46","008E8E","D64646","8E468E","588526","B3AA00","008ED6","9D080D","A186BE","F6BD0F","AFD8F8","1941A5","8BBA00","A66EDD","F984A1","CCCC00","999999","0099CC","FF0000","006F00","0099FF","FF66CC","669966","7C7CB4","FF9933","9900FF","99FFCC","CCCCFF","669900","AFD8F8","8BBA00","FF8E46","008E8E","D64646","8E468E","588526","B3AA00","008ED6","9D080D","A186BE","F6BD0F","AFD8F8","1941A5","8BBA00","A66EDD","F984A1","CCCC00","999999","0099CC","FF0000","006F00","0099FF","FF66CC","669966","7C7CB4","FF9933","9900FF","99FFCC","CCCCFF","669900","AFD8F8","8BBA00","FF8E46","008E8E","D64646","8E468E","588526","B3AA00","008ED6","9D080D","A186BE");
		$g_color = $colorarray[$_POST["ally"]];

	$db->query("INSERT INTO graph_y (graph_id,y_title,y_color) VALUES ('".$_POST["graph_id"]."','','$g_color') ");
	$sql_max = $db->query("SELECT MAX(y_id) FROM graph_y WHERE graph_id = '".$_POST["graph_id"]."' ");
	$MX = $db->db_fetch_row($sql_max);
		$sql_col = $db->query("SELECT x_id FROM graph_x WHERE graph_id = '".$_POST["graph_id"]."' ");
		while($X = $db->db_fetch_row($sql_col)){
			$db->query("INSERT INTO graph_value (graph_id,graph_x,graph_y,value_value) VALUES ('".$_POST["graph_id"]."','$X[0]','$MX[0]','0')");
		}
}

if($_POST["todo"] == "DelCol"){

	$db->query("DELETE FROM graph_x WHERE x_id = '".$_POST["tododata"]."' ");
	$db->query("DELETE FROM graph_value WHERE graph_x = '".$_POST["tododata"]."' ");

}

if($_POST["todo"] == "DelRow"){

	$db->query("DELETE FROM graph_y WHERE y_id = '".$_POST["tododata"]."' ");
	$db->query("DELETE FROM graph_value WHERE graph_y = '".$_POST["tododata"]."' ");

}

		?>
		<script language="JavaScript">
			<?php if($_POST["todo"] == "OnSubmit"){ ?>
			self.top.linkForm.submit();
			<?php  }else{ ?>
			//self.top.window.opener.location.reload();
			self.location.href ="content_graph_data.php?graph_id=<?php echo $_POST["graph_id"]; ?>";
			<?php } ?>
		</script>
	<?php
		}
			if($_POST["Flag"] == "SaveGraph"){
				$subject = stripslashes(htmlspecialchars($_POST["g_subject"],ENT_QUOTES));
				$desc = stripslashes(htmlspecialchars($_POST["g_desc"],ENT_QUOTES));
				if($_POST["nopic"] == "Y"){
				$pic_name = "";
				}else{
				if($file_size > 0){
					if(!file_exists("../ewt/".$_SESSION["EWT_SUSER"]."/graph")){
						@mkdir ("../ewt/".$_SESSION["EWT_SUSER"]."/graph", 0777);
					}
					copy($file,"../ewt/".$_SESSION["EWT_SUSER"]."/graph/".$file_name);
					$pic_name = $file_name;
				}else{
				$pic_name = $oldpic;
				}}
				$db->query("UPDATE graph_index SET graph_subject = '".$subject."',graph_description = '".$desc."',graph_type = '".$_POST["g_type"]."',graph_bgcolor = '".$_POST["g_bgcolor"]."',graph_width='".$_POST["g_width"]."',graph_height = '".$_POST["g_height"]."',graph_align = '".$_POST["g_align"]."',graph_bgpic = '$pic_name' WHERE graph_id = '".$_POST["graph_id"]."'  ");
				$db->write_log("create","main","สร้างกราฟ ".$subject);


	

    $graph_sql="select * from graph_index where graph_id = '".$_POST["graph_id"]."'";
    $graph_query=$db->query($graph_sql);
	$data = $db->db_fetch_array($graph_query);
	if($data['graph_bgcolor']!=''){
	 $graph_bgcolor=ereg_replace("#","",$data['graph_bgcolor']);
	}else{
	 $graph_bgcolor="FFFFFF";
	}
	if($data['graph_bgpic']!=''){
	   $graph_img='bgSWF=\'graph/'.$data['graph_bgpic'].'\'';
	}else{
	   $graph_img='';
	}

	$txt = '<graph '.$graph_img.' caption=\''.stripslashes(ereg_replace("'",'`',$data['graph_subject'])).'\'  subcaption=\''.stripslashes(ereg_replace("'",'`',$data['graph_description'])).'\' xAxisName=\'\' yAxisName=\'\' numberPrefix=\'\' showValues=\'0\' numVDivLines=\'10\' showAlternateVGridColor=\'1\' AlternateVGridColor=\'e1f5ff\' divLineColor=\'e1f5ff\' vdivLineColor=\'e1f5ff\'  canvasBorderThickness=\'0\' decimalPrecision=\'0\' baseFont=\'Tahoma\'  baseFontSize=\'11\'  outCnvBaseFontSize=\'11\' outCnvBaseFont=\'Tahoma\'  rotateNames=\'0\' bgcolor=\''.$graph_bgcolor.'\'><categories>';

    $graph_sql="select * from graph_x  where graph_id = '".$_POST["graph_id"]."' order by x_id";
    $graph_query=$db->query($graph_sql);
	while($catdata = $db->db_fetch_array($graph_query)){
			$txt .= '<category name=\''.trim($catdata['x_title']).'\'  />';
			$pie_data_array[]=trim($catdata['x_title']);
			$pie_id_array[]=trim($catdata['x_id']);
	}
	$txt .= '</categories>';

	$graph_sql2="select * from graph_y  where graph_id = '".$_POST["graph_id"]."' order by y_id";
    $graph_query2=$db->query($graph_sql2);
	while($catdata2 = $db->db_fetch_array($graph_query2)){
			$txt .= '<dataset seriesName=\''.trim($catdata2['y_title']).'\' color=\''.$catdata2['y_color'].'\' areaAlpha=\'60\' showAreaborder=\'1\' areaBorderThickness=\'1\' areaBorderColor=\''.$catdata2['y_color'].'\' >';

			$graph_sql3="select * from graph_value where graph_id = '".$_POST["graph_id"]."' and graph_y='".$catdata2['y_id']."' order by graph_x";
			$graph_query3=$db->query($graph_sql3);
			while($catdata3 = $db->db_fetch_array($graph_query3)){
				if(trim($catdata3['value_value'])!='-'){
					$txt .= '<set value=\''.trim($catdata3['value_value']).'\' />';
				}
			}
			$txt .= '</dataset>';
	}
	$txt .= '</graph>';
	//echo $txt;
	
  $fileGraph="../ewt/".$_SESSION["EWT_SUSER"]."/graph/graph_".$_POST["graph_id"].'.xml';
   $fp = @fopen($fileGraph, 'w');
  @fwrite($fp, $txt);
   @fclose($fp);

//	$txt =  '<graph showNames=\''.$pie_data_array[0].'\' decimalPrecision=\'0\'>';

$txt = '<graph  '.$graph_img.' caption=\''.stripslashes(ereg_replace("'",'`',$data['graph_subject'])).'\'  subcaption=\''.stripslashes(ereg_replace("'",'`',$data['graph_description'])).'\'  xAxisName=\'XXX\' yAxisName=\'YYY\' decimalPrecision=\'0\' formatNumberScale=\'0\' showNames=\'1\'  baseFont=\'Tahoma\'  baseFontSize=\'11\'  outCnvBaseFontSize=\'11\' outCnvBaseFont=\'Tahoma\' bgcolor=\''.$graph_bgcolor.'\'>';


	$graph_sql3="select * from graph_value inner join graph_y on y_id = graph_y  where graph_value.graph_id = '".$_POST["graph_id"]."' and graph_x='".$pie_id_array[0]."' order by graph_y";
	
	$graph_query3=$db->query($graph_sql3);
	while($catdata3 = $db->db_fetch_array($graph_query3)){
		if(trim($catdata3['value_value'])!='-'){
			$txt .= '<set name=\''.trim($catdata3['y_title']).'\'  value=\''.trim($catdata3['value_value']).'\'  color=\''.trim($catdata3['y_color']).'\' />' ;
		}
	}
	$txt .= '</graph>';
	$fileGraph="../ewt/".$_SESSION["EWT_SUSER"]."/graph/gpie_".$_POST["graph_id"].'.xml';
	$fp = @fopen($fileGraph, 'w');
	@fwrite($fp, $txt);
	@fclose($fp);


						?>
		<script language="JavaScript">
			//window.opener.location.reload();
		    self.location.href ="graph_preview.php?graph_id=<?php echo $_POST["graph_id"]; ?>&B=<?php echo $_POST["B"]; ?>";
		</script>
	<?php
		}
$db->db_close(); ?>
