<?php
	if(file_exists("template/".$_GET["filename"].".php")) {  
			include("template/".$_GET["filename"].".php");
	}
?>