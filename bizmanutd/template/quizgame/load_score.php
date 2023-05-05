<?php

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
	if($_GET["action"]=="save") {
	
				$sql_play = $INSERT = " INSERT INTO history_play(uname, question_id, get_score, savetime) VALUES ( '".$_GET["uname"]."', '".$_GET["question_id"]."', '".$_GET["get_score"]."', NOW() ) ";
				//echo "$INSERT<br>";
				$pass1 = $db->query($INSERT);
						
				$sql_chk = " SELECT * FROM  history_save  WHERE uname = '".$_GET["uname"]."' ";
				$exec_chk = $db->query($sql_chk);
				$num_chk = $db->num_rows($exec_chk);
				
				if($num_chk==0) {
				
						$sql_save = $INSERT = " INSERT INTO history_save(uname,  last_score, begin_date, last_update) VALUES ( '".$_GET["uname"]."',  '".$_GET["score"]."', NOW(), NOW() ) ";
						//echo "$INSERT<br>";
						$pass2 = $db->query($INSERT);
				} else {
						
						$sql_save = $UPDATE = " UPDATE  history_save  SET  last_score = '".$_GET["score"]."', last_update = NOW()  WHERE  uname = '".$_GET["uname"]."' ";
						$pass2 =  $db->query($UPDATE);
					
				}
				
	}
				
	$sql_chk = " SELECT * FROM  history_save  WHERE uname = '".$_GET["uname"]."' ";
	$exec_chk = $db->query($sql_chk);
	//$num_chk = $db->num_rows($exec_chk);
	$rec_chk = $db->fetch_array($exec_chk);
	$last_score = $rec_chk[last_score]*1;
	
	//if(!$_GET["building"])
	//$bg_id=1;	
	
	$output="";
	
	$sql_slevel = " SELECT * FROM  score_level  WHERE  '".$last_score."'  >= score_min  AND '".$last_score."'  <= score_max  ";
	// ORDER BY score_max DESC LIMIT 0,1
	$exec_slevel = $db->query($sql_slevel);
	$num_slevel = $db->num_rows($exec_slevel);
	
	$status_end = "";
	
	if($num_slevel > 0 ) {
		$rec_slevel = $db->fetch_array($exec_slevel);
		
		$output .= "slevel_id=".$rec_slevel["slevel_id"]."&";
		$output .= "slevel_name=".$rec_slevel["slevel_name"]."&";
		$output .= "next_levelscore=".($rec_slevel["score_max"]+1)."&";
		$output .= "bg_path1=".$rec_slevel["bg_path1"]."&";
	//	$output .= "bg_path2=".$rec_slevel["bg_path2"]."&";
		$output .= "gauge_path1=".$rec_slevel["gauge_path1"]."&";
	//	$output .= "gauge_path2=".$rec_slevel["gauge_path2"]."&";
		
		$score_min = $rec_slevel["score_min"];  // urlencode
		$score_max = $rec_slevel["score_max"];
		$status_end = $rec_slevel["status_end"];
		
	} else if($last_score>0) {
		
		$output .= "slevel_name=Master&";
		$output .= "next_levelscore=&";
		
		$score_min = 0;
		$score_max = 0;
	
	} else {
		$output .= "slevel_name=&";		
		$output .= "next_levelscore=&";
		
		$score_min = 0;
		$score_max = 0;
	}
	
	$output .= "last_score=".$last_score."&score_min=".$score_min."&score_max=".$score_max."&status_end=".$status_end."&";
	
	if($output) {
			$output = substr($output,0,-1);
			//$output = "&".$output;
	}
	
	
	echo $output."&sql=".$sql_slevel."&sql_save_q_id=".$sql_play; // เธชเนเธเธเนเธฒเนเธซเน Flash 
?>