<?php
	header('Content-Type: text/html; charset=utf-8');	
	
	header("Expires: ".gmdate("D, d M Y H:i:s")."GMT");
    header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");
	
	$path = "";
	include($path."include/config.inc.php");
	include($path."include/class_db.php");
	include($path."include/class_display.php");
	//include($path."include/class_application.php");
	
   $CLASS['db']   = new db();
   $CLASS['db']->connect ();
   $CLASS['disp'] = new display();
   //$CLASS['app'] = new application();   
		   
	$db   = $CLASS['db'];
    $disp = $CLASS['disp'];
	//$app = $CLASS['app'];	
		/*	
			mysql_query("SET Character_set_results=utf8") or die("Query Character Error<br>");
			mysql_query("SET Character_set_client=utf8");
			mysql_query("SET Character_set_cennection=utf8");
			mysql_query("SET Collation_connection=utf8_general_ci");
			mysql_query("SET Character_database=utf8_general_ci");
			mysql_query("SET Character_server=utf8_general_ci");
					*/
	$sql_topic = " SELECT *  FROM  topic  WHERE  topic_use = '1'  ORDER BY  RAND()  ASC  ";  // ORDER BY  topic_id
	$exec_topic = $db->query($sql_topic);
	$i=0;
	
	$output = "";
	while($rec_topic = $db->fetch_array($exec_topic)) {
			
			//${"topic_id".$i} = $rec_topic[topic_id];
			${"topic_name".$i} = $disp->convert_qoute_to_show($rec_topic[topic_name]); //urlencode($rec_topic[topic_name]);
			${"topic_icon".$i} = urlencode($rec_topic[icon_path]);
			${"topic_code".$i} = $rec_topic[topic_code];
			
			$output .= "topic_code".$i."=".${"topic_code".$i}."&topic_name".$i."=".${"topic_name".$i}."&topic_icon".$i."=".${"topic_icon".$i}."&";									
		
			$i++;
	}
	
	$total_topics = $i;
	$output .= "total_topics=".$total_topics."&sql=".$sql_topic;
	
	echo $output; // เธชเนเธเธเนเธฒเนเธซเน Flash 
?>