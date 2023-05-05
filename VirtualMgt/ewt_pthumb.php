<?php

function thumb_jpg($source,$target,$w,$h)
{
$orig["dirimage"] = $source;
$orig["res"] = imagecreatefromjpeg($source);
$new["res"] =  imagecreatetruecolor($w,$h);

imagecopyresampled($new["res"], $orig["res"], 0, 0, 0, 0, $w,$h,$w,$h);

$new["dirimage"] = $target;

imagejpeg($new["res"], $new["dirimage"],15);
imagedestroy($new["res"]);
imagedestroy($orig["res"]);

return true;
} 
function thumb_gif($source,$target,$w,$h)
{

$orig["dirimage"] = $source;
$orig["res"] = imagecreatefromgif($source);

$new["res"] =  imagecreatetruecolor($w,$h);

imagecopyresampled($new["res"], $orig["res"], 0, 0, 0, 0, $w,$h,$w,$h);

$new["dirimage"] = $target;

imagegif($new["res"], $new["dirimage"],15);

imagedestroy($orig["res"]);
imagedestroy($new["res"]);

return true;
} 
function thumb_png($source,$target,$w,$h)
{

$orig["dirimage"] = $source;
$orig["res"] = @imagecreatefrompng($source);

$new["res"] =  imagecreatetruecolor($w,$h);

imagecopyresampled($new["res"], $orig["res"], 0, 0, 0, 0, $w,$h,$w,$h);

$new["dirimage"] = $target;

imagepng($new["res"], $new["dirimage"],15);

imagedestroy($orig["res"]);
imagedestroy($new["res"]);

return true;
} 
?>
