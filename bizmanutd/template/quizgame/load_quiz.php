<?php
	//header('Content-Type: text/html; charset=utf-8');	
	
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

			
			/* query เธเธตเนเธ—เธ”เธชเธญเธเนเธฅเนเธงเนเธเนเนเธ”เน work   เธ”เธถเธเธเธณเธ–เธฒเธกเน€เธเธเธฒเธฐ เธเนเธญเธ—เธตเนเธขเธฑเธเนเธกเนเน€เธเธขเน€เธฅเนเธ เธซเธฃเธทเธญเน€เธฅเนเธเนเธฅเนเธงเนเธกเนเน€เธเธดเธ 1 เธเธฃเธฑเนเธ   limit 1 
				SELECT questions.question_id AS q_id, COUNT(history_play.question_id) AS freq_play , history_play.question_id AS q_play_id, history_play.uname, questions.*
									FROM questions LEFT JOIN history_play ON questions.question_id = history_play.question_id
									WHERE  topic_id = '1' AND ( (history_play.question_id is null) OR ( history_play.uname = 'pinn' ) )
									GROUP BY q_id
									HAVING   freq_play < 2 OR freq_play is null 
									ORDER BY  RAND()  ASC 
									 LIMIT 0,1 */
									 
for($i=0;$i<3;$i++) {  // เธ”เธถเธเธเธณเธ–เธฒเธกเน€เธเธเธฒเธฐ เธซเธกเธงเธ”เธ—เธตเน flash เธชเนเธเธเนเธฒเธกเธฒ  3 เธซเธกเธงเธ” = 3 เธเธณเธ–เธฒเธก เธชเนเธเธเนเธญเธกเธนเธฅเธเธณเธ–เธฒเธก-เธเธณเธ•เธญเธ เธเธฐเนเธเธเธเธญเธเธเนเธญเธเธฑเนเธ เธเธฅเธฑเธเนเธเนเธซเน flash

		 ${"sql_quiz".$i} = $sql_quiz = " SELECT questions.question_id AS q_id, COUNT(history_play.question_id) AS freq_play , history_play.uname, questions.*, get_score

									FROM questions INNER JOIN history_play ON questions.question_id = history_play.question_id
									WHERE  topic_code = '".$_GET["topic_code".$i]."' AND history_play.uname = '".$_GET["uname"]."' 
									GROUP BY q_id
									HAVING   freq_play < 2 AND get_score <= 0
									ORDER BY  RAND()  ASC 
									 LIMIT 0,1	 ";  // เธ”เธถเธเธเธณเธ–เธฒเธก เธ—เธตเนเน€เธเธขเธ•เธญเธเธเธดเธ” เธกเธฒเนเธซเนเนเธเนเธญเธตเธเธเธฃเธฑเนเธเน€เธ”เธตเธขเธง
		$exec_quiz = $db->query($sql_quiz);
		$num_quiz = $db->num_rows($exec_quiz);
						
		if($num_quiz==0) {   //  เธ–เนเธฒเนเธกเนเธกเธตเธเธณเธ–เธฒเธกเธ—เธตเนเน€เธเธขเธ•เธญเธเธเธดเธ” เนเธซเนเธ”เธถเธเธเธณเธ–เธฒเธกเธ—เธตเนเธขเธฑเธเนเธกเนเน€เธเธขเน€เธฅเนเธ เนเธ”เธข $_GET["uname"] เธเธเธเธตเน
		
		
				${"sql_quiz".$i} =	$sql_quiz = " SELECT questions.*
											FROM questions 
											WHERE  topic_code = '".$_GET["topic_code".$i]."' AND questions.question_id NOT IN (
																		 SELECT	history_play.question_id
																		  FROM	history_play 
																		  WHERE  history_play.uname = '".$_GET["uname"]."' 											  
																	  ) 																						
											ORDER BY  RAND()  ASC 
											 LIMIT 0,1																				 
											";
									//echo "$sql_quiz<br>";
					
				$exec_quiz = $db->query($sql_quiz);
		}			
					while($rec_quiz = $db->fetch_array($exec_quiz)) {
					
							${"question_id".$i} = $rec_quiz[question_id];
							${"question_name".$i} = $disp->convert_qoute_to_show($rec_quiz[question_name]); //urlencode($rec_quiz[question_name]);
							${"question_rank".$i} = $rec_quiz[question_rank];
							${"question_score".$i} = $rec_quiz[question_score];
							${"correct_choice".$i} = $rec_quiz[correct_choice];
							$output .= "question_id".$_GET["topic_code".$i]."=".${"question_id".$i}."&";
							$output .= "question_name".$_GET["topic_code".$i]."=".${"question_name".$i}."&";
							$output .= "question_rank".$_GET["topic_code".$i]."=".${"question_rank".$i}."&";
							$output .= "question_score".$_GET["topic_code".$i]."=".${"question_score".$i}."&";
							$output .= "correct_choice".$_GET["topic_code".$i]."=".${"correct_choice".$i}."&";
							
							${"c_id".$i} = $rec_quiz[c_id];
							$sql_compo = " SELECT * FROM q_component WHERE c_id = '".${"c_id".$i}."' ";
							$exec_compo = $db->query($sql_compo);
							$rec_compo = $db->fetch_array($exec_compo);
							${"c_text".$i} = $rec_compo[c_text];
							
							$output .= "c_id".$_GET["topic_code".$i]."=".${"c_id".$i}."&";
							$output .= "c_text".$_GET["topic_code".$i]."=".${"c_text".$i}."&";
							
								$sql_choice = " SELECT *	  FROM	choices
																  WHERE
																	  question_id = '".$rec_quiz[question_id]."' 
																  ORDER BY  choice_no  ASC 
																  LIMIT 0,4 ";
												
								$exec_choice = $db->query($sql_choice);
								$j=0;
								while($rec_choice = $db->fetch_array($exec_choice)) {
								
										${"choice_no".$i."_".$j} = $rec_choice[choice_no];
										${"choice_text".$i."_".$j} = $disp->convert_qoute_to_show($rec_choice[choice_text]);  
										// $rec_choice[choice_text]; เนเธกเนเนเธเธฅเธ เนเธฅเนเธงเนเธ—เธข ok เนเธ•เน & เธกเธตเธเธฑเธเธซเธฒ
										// urlencode($rec_choice[choice_text]); เนเธเนเนเธฅเนเธง เนเธ—เธข utf8 เน€เธเธตเนเธขเธ										
										$output .= "choice_text".$_GET["topic_code".$i]."_".$j."=".${"choice_text".$i."_".$j}."&";	
										$output .= "choice_no".$_GET["topic_code".$i]."_".$j."=".${"choice_no".$i."_".$j}."&";																					
										$j++;
								}
					 } // end while  ( เธเธฃเธดเธเนเธกเธฑเธเนเธเน record เน€เธ”เธตเธขเธง เนเธ•เนเน€เธเธทเนเธญเนเธงเน เนเธกเนเธญเธขเธฒเธเน€เธญเธฒ while เธญเธญเธ )
							
} // end for
			

	
	$total_topic = $i;
	$output .= "total_topic=".$total_topic."&sql0=".$sql_quiz0."&sql1=".$sql_quiz1."&sql2=".$sql_quiz2."&sql_choice=".$sql_choice;
	
	echo $output; // เธชเนเธเธเนเธฒเนเธซเน Flash 
?>