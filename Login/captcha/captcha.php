<?php
session_start();

function random_code($len) {
    //$alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
	$alphabet = 'abcdefghijklmnopqrstuvwxyz1234567890';
    $pass = array(); //remember to declare $pass as an array
    $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
    for ($i = 0; $i < $len; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
}
function session_is_regis($s_sess)
	{ 
		if (isset($_SESSION['$s_sess'])){
		return true;
		}else{ 
		return false;
		}
}

if(!session_is_regis('captchacode')){	
$_SESSION['captchacode'] = random_code(6);
}

$code = $_SESSION['captchacode'];
$imgX = 360;
$imgY = 60;
$image = imagecreatefrompng("images/captchabg.png");

$textcolor = imagecolorallocate($image, 46,40,31);

$font = "February 2 - Initials (Personal use).otf"; 
$font1 = "cts.ttf"; 
$font2 = "Breathe Fire II.otf"; 
$font3 = "Heart Warming.otf";
$font4 = "Grande October Four.otf";
$font5 = "ToxicPowers.ttf";

$fontsize = 36;
$angle = 1;
$angle1 = 10;
$box = imagettfbbox($fontsize, $angle, $font3, $_SESSION['captchacode']);
$x = (int)($imgX - $box[4]) / 2;
$y = (int)($imgY - $box[5]) / 2;
imagettftext($image, $fontsize, $angle, $x, $y, $textcolor, $font3, $code);
//imagettftext($image, $fontsize, $angle, $x+0, $y, $textcolor, $font, substr($code, 0, 1));
//imagettftext($image, $fontsize, $angle, $x+40, $y, $textcolor, $font4, substr($code, 1, 1));
//imagettftext($image, $fontsize, $angle, $x+80, $y, $textcolor, $font3,  substr($code, 2, 1));
//imagettftext($image, $fontsize, $angle, $x+120,$y, $textcolor, $font2, substr($code, 3, 1));
//imagettftext($image, $fontsize, $angle, $x+150,$y, $textcolor, $font3,  substr($code, 4, 1));
//imagettftext($image, $fontsize, $angle, $x+200,$y, $textcolor, $font2, substr($code, 5, 1));
header("Content-type: image/png");
imagepng($image);
imagedestroy ($image);
?>