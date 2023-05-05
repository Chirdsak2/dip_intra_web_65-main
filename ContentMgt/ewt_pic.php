<?php
session_start();
Header("Content-type: image/jpeg"); 

function random_code($len){
			srand((double)microtime()*10000000);
			$chars = "0123456789";
			$ret_str = "";
			$num = strlen($chars);
			for($i=0;$i<$len;$i++){
				$ret_str .= $chars[rand()%$num];
			}
			return $ret_str;
	}


			if(!session_is_registered("gen_pic_verify")){
			session_register("gen_pic_verify");
			}
			$_SESSION["gen_pic_verify"] = random_code(5);

	$im = imagecreate(180, 60); 
    $lcolor1 = imagecolorallocate($im, 0,0,0); 
    $lcolor2 = imagecolorallocate($im, rand(0,70),rand(0, 70),rand(0, 70)); 
    $bgcolor2 = imagecolorallocate($im, rand(200, 255),rand(200, 255),rand(200, 255)); 

    $id = $_SESSION["gen_pic_verify"];
    imagefill($im, 0, 0, $bgcolor2); 
    $end1 = rand(0, 100); 
    imagefilledrectangle($im, 0, 0, $end1, 70, ImageColorAllocate($im, rand(235, 255),rand(235, 255),rand(235, 255))); 
    $end2 = $end1+rand(0, 100); 
    imagefilledrectangle($im, $end1, 0, $end2, 70, ImageColorAllocate($im, rand(235, 255),rand(235, 255),rand(235, 255))); 
    $end3 = $end2+rand(0, 100); 
    imagefilledrectangle($im, $end2, 0, $end3, 70, ImageColorAllocate($im, rand(235, 255),rand(235, 255),rand(235, 255))); 
    imagefilledrectangle($im, $end3, 0, 180, 70, ImageColorAllocate($im, rand(235, 255),rand(235, 255),rand(235, 255))); 
    $y1 = rand(25, 50); 
    ImageTTFText ($im, rand(17, 20), rand(-30, 30), rand(10, 20), $y1, $lcolor1, '../fonts/verdana.ttf', substr($id, 0, 1)); 
    $y2 = rand(25, 50); 
    ImageTTFText ($im, rand(17, 20), rand(0, 30), rand(45, 55), $y2, $lcolor2, '../fonts/trebuc.ttf', substr($id, 1, 1)); 
    $y3 = rand(25, 50); 
    ImageTTFText ($im, rand(17, 25), rand(-20, 0), rand(80, 90), $y3, $lcolor1, '../fonts/trebuc.ttf', substr($id, 2, 1)); 
    $y4 = rand(25, 50); 
    ImageTTFText ($im, rand(16, 25), rand(0, 30), rand(115, 125), $y4, $lcolor1, '../fonts/verdana.ttf', substr($id, 3, 1)); 
    $y5 = rand(25, 50); 
    ImageTTFText ($im, rand(18, 20), rand(-25, 0), rand(150, 160), $y5, $lcolor2, '../fonts/trebuc.ttf', substr($id, 4, 1)); 
    $x = rand(0, 50); 
    $y = rand(0, 50); 
     imagepng($im); 
?>
