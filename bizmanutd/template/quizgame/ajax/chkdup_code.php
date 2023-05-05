<?php
	header ("Content-Type:text/plain;Charset=UTF-8");
	
	$path = "../";
	include($path."include/config.inc.php");
	include($path."include/class_db.php");
	include($path."include/class_display.php");
	include($path."include/class_application.php");
	
   $CLASS['db']   = new db();
   $CLASS['db']->connect ();
   $CLASS['disp'] = new display();
   $CLASS['app'] = new application();   
		   
	$db   = $CLASS['db'];
    $disp = $CLASS['disp'];
	$app = $CLASS['app'];
	
	$sqlChk = " SELECT topic_code FROM topic WHERE topic_code = '".$disp->convert_qoute_to_db($topic_code)."' ";
	$execChk = $db->query($sqlChk);
	$numChk = $db->num_rows($execChk);
	if($numChk==0)  
	echo "<span id='OK' style='color:green' ><strong>OK</strong></span>";
	else 
	echo "<span id='Duplicated' style='color:red'><strong>Duplicated</strong></span>";
?>