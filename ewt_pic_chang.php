<?php
	session_start();
	if($_GET['ckp']!=null){
		echo $_SESSION["gen_pic_login"];	
	}
	
?>