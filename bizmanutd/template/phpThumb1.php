<?php
function thumb_jpg($source, $maxwidth, $maxheight)
{
$orig["dirimage"] = $source;
$orig["res"] = imagecreatefromjpeg($source);

$orig["x"] = imagesx($orig["res"]);
$orig["y"] = imagesy($orig["res"]);

$new["x"] = $maxwidth;
$new["y"] = $maxheight;

if($orig["x"] > $orig["y"]){
$fixed = $orig["y"];
$perc = ($orig["x"]/$orig["y"]);
$xto = ($maxwidth * $perc) - $maxwidth;
$x = number_format(($xto/2),0);
$y = 0;
}else{
$fixed = $orig["x"];
$perc = ($orig["y"]/$orig["x"]);
$yto = ($maxheight * $perc) - $maxheight;
$y = number_format(($yto/2),0);
$x = 0;
}

$new["res"] = imagecreatetruecolor($new["x"],$new["y"]);

//set background to white
$fill = imagecolorallocate($new["res"], 255, 255, 255);
imagefill($new["res"], 0, 0, $fill);
imagecopyresampled($new["res"], $orig["res"], 0, 0, $x, $y, $new["x"], $new["y"], $fixed, $fixed);

header ("Content-type: image/jpeg");
imagejpeg($new["res"]);

imagedestroy($orig["res"]);
imagedestroy($new["res"]);

return true;
} 
function thumb_gif($source, $maxwidth, $maxheight)
{

$orig["dirimage"] = $source;
$orig["res"] = @imagecreatefromgif($source);

$orig["x"] = imagesx($orig["res"]);
$orig["y"] = imagesy($orig["res"]);

$new["x"] = $maxwidth;
$new["y"] = $maxheight;

if($orig["x"] > $orig["y"]){
$fixed = $orig["y"];
$perc = ($orig["x"]/$orig["y"]);
$xto = ($maxwidth * $perc) - $maxwidth;
$x = number_format(($xto/2),0);
$y = 0;
}else{
$fixed = $orig["x"];
$perc = ($orig["y"]/$orig["x"]);
$yto = ($maxheight * $perc) - $maxheight;
$y = number_format(($yto/2),0);
$x = 0;
}

$new["res"] = imagecreatetruecolor($new["x"],$new["y"]);

//set background to white
$fill = imagecolorallocate($new["res"], 255, 255, 255);
imagefill($new["res"], 0, 0, $fill);
imagecopyresampled($new["res"], $orig["res"], 0, 0, $x, $y, $new["x"], $new["y"], $fixed, $fixed);

//$new["dirimage"] = $target;

imagegif($new["res"]);

imagedestroy($orig["res"]);
imagedestroy($new["res"]);

return true;
} 
function thumb_png($source, $maxwidth, $maxheight)
{

$orig["dirimage"] = $source;
$orig["res"] = @imagecreatefrompng($source);

$orig["x"] = imagesx($orig["res"]);
$orig["y"] = imagesy($orig["res"]);

$new["x"] = $maxwidth;
$new["y"] = $maxheight;

if($orig["x"] > $orig["y"]){
$fixed = $orig["y"];
$perc = ($orig["x"]/$orig["y"]);
$xto = ($maxwidth * $perc) - $maxwidth;
$x = number_format(($xto/2),0);
$y = 0;
}else{
$fixed = $orig["x"];
$perc = ($orig["y"]/$orig["x"]);
$yto = ($maxheight * $perc) - $maxheight;
$y = number_format(($yto/2),0);
$x = 0;
}

$new["res"] = imagecreatetruecolor($new["x"],$new["y"]);

//set background to white
$fill = imagecolorallocate($new["res"], 255, 255, 255);
imagefill($new["res"], 0, 0, $fill);
imagecopyresampled($new["res"], $orig["res"], 0, 0, $x, $y, $new["x"], $new["y"], $fixed, $fixed);

//$new["dirimage"] = $target;

imagepng($new["res"]);

imagedestroy($orig["res"]);
imagedestroy($new["res"]);

return true;
} 
							if(file_exists($_GET["src"]) AND trim($_GET["src"]) != "") {
							$size = getimagesize ($_GET["src"]);
							$type = $size['mime'];

												if($type == "image/jpeg"){
													@thumb_jpg($_GET["src"], $_GET["w"], $_GET["h"]);
												}
												if($type == "image/gif"){
													@thumb_gif($_GET["src"], $_GET["w"], $_GET["h"]);
												}
												if($type == "image/png"){
													@thumb_png($_GET["src"], $_GET["w"], $_GET["h"]);
												}
							}
?>
