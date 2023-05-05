<?php

	if($temp_html == 'w3c'){
	$logo = file_get_contents("bottom_401.html"); 
	}
	if($temp_wai == 'w3c'){
	$logo .= file_get_contents("bottom_wcag.html"); 
	}
	if($temp_css == 'w3c'){
	$logo .= file_get_contents("bottom_css.html"); 
	}
echo eregi_replace("#htmlw3c_spliter#",$logo,$template_design[1]); 
?>