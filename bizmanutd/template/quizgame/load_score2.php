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
	
	$output = "";
	
	// $sqlMe = " SELECT *  FROM  history_save  WHERE uname = '".$_GET["uname"]."' AND building = '".$_GET["building"]."'  AND  last_update LIKE '%'+CURDATE()+'%' ";
	// DATE_FORMAT(last_update,'%Y-%m-%d') LIKE CURDATE()
	$sql = " SELECT *  FROM  history_save  WHERE  DATEDIFF(last_update, NOW())  >=  -1  
								 ORDER BY  last_score DESC, begin_date "; 
							//  เธกเธฑเธเน€เธญเธฒ last_update เธ•เธฑเนเธ เธฅเธเธ”เนเธงเธข NOW()  เธ–เนเธฒ>= -1 เธซเธกเธฒเธขเธ–เธถเธ เน€เธญเธฒ record เนเธชเธ”เธเธเธฐเนเธเธเธเธนเนเน€เธฅเนเธ เธ เธฒเธขเนเธ 2 เธงเธฑเธเธเธตเน
	$exec	= $db->query($sql);	 
				 
	$i=0;
	while($rec = $db->fetch_array($exec)) {
		$output .= "player_name".$i."=".$rec[uname]."&";
		$output .= "player_score".$i."=".$rec[last_score]."&";
		$i++;
	}
	
	if($output) {
			$output = substr($output,0,-1);
			//$output = "&".$output;
	}
	
	echo $output."&total_players=".$i."&sql=".$sql; // เธชเนเธเธเนเธฒเนเธซเน Flash 
?>