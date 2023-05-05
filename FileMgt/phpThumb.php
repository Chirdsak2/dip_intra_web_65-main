<?php
function thumb_jpg($source, $maxwidth, $maxheight)
{
$orig["dirimage"] = $source;
$orig["res"] = imagecreatefromjpeg($source);

$orig["x"] = imagesx($orig["res"]);
$orig["y"] = imagesy($orig["res"]);
	if($maxwidth == "" OR $maxwidth == 0 OR $maxwidth >= $orig["x"]){
		$maxwidth = $orig["x"];
	}
	if($maxheight == "" OR $maxheight == 0 OR $maxheight >= $orig["y"]){
		$maxheight = $orig["y"];
	}
if($orig["x"] > $orig["y"])
{
$new["x"] = $maxwidth;
$new["y"] = ($maxwidth / $orig["x"]) * $orig["y"];
}
else
{
$new["y"] = $maxheight;
$new["x"] = ($maxheight / $orig["y"] ) * $orig["x"];
}
if($new["y"] == "" OR $new["y"] < 1){
$new["y"] = "1";
}
if($new["x"] == "" OR $new["x"] < 1){
$new["x"] = "1";
}
//echo $maxwidth."-".$new["y"]."-".$new["x"] ."<br>";
//switch out imagecreatetruecolor with imagecreate if using gd version 1
$new["res"] = imagecreate($new["x"],$new["y"]);
//$new["res"] = imagecreatetruecolor($new["x"],$new["y"]);

//set background to white
$fill = imagecolorallocate($new["res"], 255, 255, 255);
imagefill($new["res"], 0, 0, $fill);
imagecopyresampled($new["res"], $orig["res"], 0, 0, 0, 0, $new["x"], $new["y"], $orig["x"], $orig["y"]);

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

	if($maxwidth == "" OR $maxwidth == 0 OR $maxwidth >= $orig["x"]){
		$maxwidth = $orig["x"];
	}
	if($maxheight == "" OR $maxheight == 0 OR $maxheight >= $orig["y"]){
		$maxheight = $orig["y"];
	}

if($orig["x"] > $orig["y"])
{
$new["x"] = $maxwidth;
$new["y"] = ($maxwidth / $orig["x"]) * $orig["y"];
}
else
{
$new["y"] = $maxheight;
$new["x"] = ($maxheight / $orig["y"] ) * $orig["x"];
}
if($new["y"] == "" OR $new["y"] < 1){
$new["y"] = "1";
}
if($new["x"] == "" OR $new["x"] < 1){
$new["x"] = "1";
}
//switch out imagecreatetruecolor with imagecreate if using gd version 1
$new["res"] = imagecreate($new["x"],$new["y"]);
//$new["res"] = imagecreatetruecolor($new["x"],$new["y"]);

//set background to white
$fill = imagecolorallocate($new["res"], 255, 255, 255);
imagefill($new["res"], 0, 0, $fill);
imagecopyresampled($new["res"], $orig["res"], 0, 0, 0, 0, $new["x"], $new["y"], $orig["x"], $orig["y"]);

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

	if($maxwidth == "" OR $maxwidth == 0 OR $maxwidth >= $orig["x"]){
		$maxwidth = $orig["x"];
	}
	if($maxheight == "" OR $maxheight == 0 OR $maxheight >= $orig["y"]){
		$maxheight = $orig["y"];
	}

if($orig["x"] > $orig["y"])
{
$new["x"] = $maxwidth;
$new["y"] = ($maxwidth / $orig["x"]) * $orig["y"];
}
else
{
$new["y"] = $maxheight;
$new["x"] = ($maxheight / $orig["y"] ) * $orig["x"];
}
if($new["y"] == "" OR $new["y"] < 1){
$new["y"] = "1";
}
if($new["x"] == "" OR $new["x"] < 1){
$new["x"] = "1";
}
//switch out imagecreatetruecolor with imagecreate if using gd version 1
$new["res"] = imagecreate($new["x"],$new["y"]);
//$new["res"] = imagecreatetruecolor($new["x"],$new["y"]);

//set background to white
$fill = imagecolorallocate($new["res"], 255, 255, 255);
imagefill($new["res"], 0, 0, $fill);
imagecopyresampled($new["res"], $orig["res"], 0, 0, 0, 0, $new["x"], $new["y"], $orig["x"], $orig["y"]);

//$new["dirimage"] = $target;

imagepng($new["res"]);

imagedestroy($orig["res"]);
imagedestroy($new["res"]);

return true;
} 
							if(file_exists($_GET["src"]) AND trim($_GET["src"]) != "") {

							$pic = basename($_GET["src"]);
							$F = explode(".",$pic);
							$C = count($F);
							$CT = $C-1;
							$dir = strtolower($F[$CT]);
								if($dir == "jpeg"){
									$dir = "jpg";
								}
							if($dir == "jpg" OR $dir == "png" OR $dir == "gif"){
												if($dir == "jpg"){
													thumb_jpg($_GET["src"], $_GET["w"], $_GET["h"]);
												}
												if($dir == "gif"){
													thumb_gif($_GET["src"], $_GET["w"], $_GET["h"]);
												}
												if($dir == "png"){
													thumb_png($_GET["src"], $_GET["w"], $_GET["h"]);
												}
							}
							}
?>
