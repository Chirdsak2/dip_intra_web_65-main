<?php
session_start();
if($_GET["text"] != ""){
Header("Content-type: image/jpeg"); 

$cs = $_GET["text"];
$len = strlen($cs)*14;
$im=ImageCreate($len,18);
$white = ImageColorAllocate($im,255,255,255);
$black = ImageColorAllocate($im,0,0,0);
$blue = ImageColorAllocate($im,0,0,255);
$green = ImageColorAllocate($im,0,255,0);
$red = ImageColorAllocate($im,255,0,0);
$bg = $black;
$fr = $black;
$fg = $green;
$sh = $black;
ImageFill($im,0,0,$bg);
ImageString($im,5,5,1,$cs,$fg);
ImageJPEG($im);
ImageDestroy($im);
}
?>
