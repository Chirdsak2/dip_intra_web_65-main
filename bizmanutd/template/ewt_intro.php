<?php
session_start();
if(file_exists("intro/intro_".$_GET["id"].".html")){
				$buffer = "";
				$fd = @fopen ("intro/intro_".$_GET["id"].".html", "r");
				while (!@feof ($fd)) { $buffer .= @fgets($fd, 4096); }
				@fclose ($fd);
}
echo $buffer;
?>