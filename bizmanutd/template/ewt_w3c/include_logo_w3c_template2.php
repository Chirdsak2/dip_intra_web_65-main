<?php
	
	$logo = file_get_contents("bottom_401.html"); 


	$logo .= file_get_contents("bottom_wcag.html"); 
	
	
	$logo .= file_get_contents("bottom_css.html"); 
	echo $logo;
		?>