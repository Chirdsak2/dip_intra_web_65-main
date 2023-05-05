<?php 
  $path_parts = pathinfo($_SERVER["SCRIPT_FILENAME"]);
  $currentDir = $path_parts['dirname'].'/';
 
  $command = $currentDir.'pdftoimage -i "'.$currentDir.'Coop_Eng1-8.pdf" -o "'.$currentDir.'output_pdf" -q 60 -z 60';
  exec ($command);
?>
