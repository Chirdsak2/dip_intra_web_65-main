<?php
	session_start();
	
	## Check subject info (aka page and purpose)
	if($_GET["subject"]){
		$subject_info = $_GET["subject"];
	}

	/*if($_GET['ckp']!=null){
		echo $_SESSION["gen_pic_".$subject_info];	
	}*/

?>