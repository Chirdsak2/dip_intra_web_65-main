<?php
function thumb_jpg($source,$target, $maxwidth, $maxheight)
{

$orig["dirimage"] = $source;
$orig["res"] = imagecreatefromjpeg($source);

$orig["x"] = imagesx($orig["res"]);
$orig["y"] = imagesy($orig["res"]);

	if($maxwidth == "" OR $maxwidth == 0){
		$maxwidth = $orig["x"];
	}
	if($maxheight == "" OR $maxheight == 0){
		$maxheight = $orig["y"];
	}

$new["x"] = $maxwidth;
$new["y"] = $maxheight;

$x = 0;
$y = 0;
if($new["x"] == $new["y"]){
		if($orig["x"] > $orig["y"]){
			$xto = $orig["x"] - $orig["y"];
			$x = number_format(($xto/2),0,'','');
			$y = 0;
				$orig["x"] = $orig["y"];
		}elseif($orig["x"] < $orig["y"]){
			$yto = $orig["y"] - $orig["x"];
			$y = number_format(($yto/2),0,'','');
			$x = 0;
				$orig["y"] = $orig["x"];
		}else{
			$x = 0;
			$y = 0;
		}
}else{

		if($orig["x"] > $orig["y"]){
		$new["x"] = $maxwidth;
		$new["y"] = number_format((($maxwidth / $orig["x"]) * $orig["y"]),0,'','');
		}else{
		$new["y"] = $maxheight;
		$new["x"] = number_format((($maxheight / $orig["y"] ) * $orig["x"]),0,'','');
		}
}

$new["res"] = imagecreatetruecolor($new["x"],$new["y"]);

imagecopyresampled($new["res"], $orig["res"], 0, 0, $x, $y, $new["x"], $new["y"], $orig["x"], $orig["y"]);

$new["dirimage"] = $target;

imagejpeg($new["res"], $new["dirimage"]);

imagedestroy($orig["res"]);
imagedestroy($new["res"]);

return true;
} 
function thumb_gif($source,$target, $maxwidth, $maxheight)
{

$orig["dirimage"] = $source;
$orig["res"] = imagecreatefromgif($source);

$orig["x"] = imagesx($orig["res"]);
$orig["y"] = imagesy($orig["res"]);

	if($maxwidth == "" OR $maxwidth == 0){
		$maxwidth = $orig["x"];
	}
	if($maxheight == "" OR $maxheight == 0){
		$maxheight = $orig["y"];
	}
$new["x"] = $maxwidth;
$new["y"] = $maxheight;

$x = 0;
$y = 0;
if($new["x"] == $new["y"]){
		if($orig["x"] > $orig["y"]){
			$xto = $orig["x"] - $orig["y"];
			$x = number_format(($xto/2),0,'','');
			$y = 0;
				$orig["x"] = $orig["y"];
		}elseif($orig["x"] < $orig["y"]){
			$yto = $orig["y"] - $orig["x"];
			$y = number_format(($yto/2),0,'','');
			$x = 0;
				$orig["y"] = $orig["x"];
		}else{
			$x = 0;
			$y = 0;
		}
}else{

		if($orig["x"] > $orig["y"]){
		$new["x"] = $maxwidth;
		$new["y"] = number_format((($maxwidth / $orig["x"]) * $orig["y"]),0,'','');
		}else{
		$new["y"] = $maxheight;
		$new["x"] = number_format((($maxheight / $orig["y"] ) * $orig["x"]),0,'','');
		}
}

$new["res"] = imagecreatetruecolor($new["x"],$new["y"]);

imagecopyresampled($new["res"], $orig["res"], 0, 0, $x, $y, $new["x"], $new["y"], $orig["x"], $orig["y"]);

$new["dirimage"] = $target;

imagegif($new["res"], $new["dirimage"]);

imagedestroy($orig["res"]);
imagedestroy($new["res"]);

return true;
} 



function thumb_png($source,$target, $maxwidth, $maxheight)
{

$orig["dirimage"] = $source;
$orig["res"] = @imagecreatefrompng($source);

$orig["x"] = imagesx($orig["res"]);
$orig["y"] = imagesy($orig["res"]);

	if($maxwidth == "" OR $maxwidth == 0){
		$maxwidth = $orig["x"];
	}
	if($maxheight == "" OR $maxheight == 0){
		$maxheight = $orig["y"];
	}

$new["x"] = $maxwidth;
$new["y"] = $maxheight;

$x = 0;
$y = 0;
if($new["x"] == $new["y"]){
		if($orig["x"] > $orig["y"]){
			$xto = $orig["x"] - $orig["y"];
			$x = number_format(($xto/2),0,'','');
			$y = 0;
				$orig["x"] = $orig["y"];
		}elseif($orig["x"] < $orig["y"]){
			$yto = $orig["y"] - $orig["x"];
			$y = number_format(($yto/2),0,'','');
			$x = 0;
				$orig["y"] = $orig["x"];
		}else{
			$x = 0;
			$y = 0;
		}
}else{

		if($orig["x"] > $orig["y"]){
		$new["x"] = $maxwidth;
		$new["y"] = number_format((($maxwidth / $orig["x"]) * $orig["y"]),0,'','');
		}else{
		$new["y"] = $maxheight;
		$new["x"] = number_format((($maxheight / $orig["y"] ) * $orig["x"]),0,'','');
		}
}

$new["res"] = imagecreatetruecolor($new["x"],$new["y"]);


imageSaveAlpha($new["res"], true);
ImageAlphaBlending($new["res"], false);
$transparentColor = imagecolorallocatealpha($new["res"], 255, 255, 255, 127);
imagefill($new["res"], 0, 0, $transparentColor);

imagecopyresampled($new["res"], $orig["res"], 0, 0, $x, $y, $new["x"], $new["y"], $orig["x"], $orig["y"]);

$new["dirimage"] = $target;

imagepng($new["res"], $new["dirimage"]);
imagedestroy($orig["res"]);
imagedestroy($new["res"]);

return true;
}
	
?>
