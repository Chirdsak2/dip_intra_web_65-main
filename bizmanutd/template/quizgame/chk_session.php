<?php	
	header("Expires: ".gmdate("D, d M Y H:i:s")."GMT");
    header("Cache-Control: no-cache, must-revalidate");
	header("Pragma: no-cache");
	
	@session_start();
	/*
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
	//session_register("EWT_MID");
    //session_register("EWT_USERNAME");
	*/
	
	if(!empty($_GET["player_name"]) && $_SESSION["EWT_USERNAME"]==$_GET["player_name"]) {
		$passLogin = 1;
	} else {
		$passLogin = 0;
	}
	echo "passLogin=".$passLogin."&EWT_USERNAME=".$_SESSION["EWT_USERNAME"]."&g_player_name=".$_GET["player_name"];
?>