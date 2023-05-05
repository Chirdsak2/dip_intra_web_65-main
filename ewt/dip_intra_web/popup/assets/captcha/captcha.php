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

function createImage($text)
 {
     if (!is_string($text) || trim($text) == '') {
         $text = 'ERROR';
     }
	$imgX = 360;
	$imgY = 60;
	$font_ttf  = "Heart Warming.otf";
	$font = "February 2 - Initials (Personal use).otf"; 
	$font1 = "cts.ttf"; 
	$font2 = "Breathe Fire II.otf"; 
	$font3 = "Heart Warming.otf";
	$font4 = "Grande October Four.otf";
	$font5 = "ToxicPowers.ttf";
	$font_size    = 34;
	$text_angle   = 1;
     // Create an image from captchaBackground.png
     $image = imagecreatefrompng(realpath('images/captchabg.png'));
     // Set the font colour
     $colour = imagecolorallocate($image, 183, 178, 152);
     // Set the font
     $font = realpath($font4); 
     // Set a random integer for the rotation between -15 and 15 degrees
     $rotate = rand(-10, 10);
	 $box = imagettfbbox($font_size, $rotate, $font, $text);
		$x = (int)($imgX - $box[4]) / 2;
		$y = (int)($imgY - $box[5]) / 2; 
     // Create an image using our original image and adding the detail
     imagettftext($image, $font_size, $rotate, $x , $y, $colour, $font, $text);
     // Output the image as a png
     //imagepng($image);
     /*return new Response(
           $captchaText,
           200,
           array(
               'Content-Type' => 'image/png',
               'Cache-Control' => 'no-cache'
           )
       );*/
     return $image;
 }
if(!session_is_regis('captchacode')){	
$_SESSION['captchacode'] = random_code(6);
}


header('Content-Type: image/png');

$img = createImage($_SESSION['captchacode']);

imagepng($img);
imagedestroy($img);
?>