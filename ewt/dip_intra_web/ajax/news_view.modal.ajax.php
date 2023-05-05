<?php 
$image = $_GET["image"];
$output .= '<figure>';
$output .= '<img src="' . $image . '" alt="' . $_itemDetail['ad_pic_b'] . '" / onclick="setEventNewsView('.$image.')">';
$output .= '<figcaption><small>'.$_itemDetail['ad_des'].'</small></figcaption>';
$output .= '</figure>';

echo $output;
?>