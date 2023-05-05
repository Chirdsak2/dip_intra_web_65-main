<?php   
$themes_id='1';
$themes_group='';
$themes_type='';
$themes_file='';
$themes_namethems='themes1';
$themes_name='webboard';
$themes_modulename='';
$bg_img='';
$bg_color='#CCCCCC';
$bg_width='0';
$head_img='';
$head_color='#178fee';
$head_font_face='Tahoma';
$head_font_face2='Tahoma';
$head_font_size='13px';
$head_font_size2='13px';
$head_font_color='#ffffff';
$head_font_color2='#ffffff';
$head_height='30';
$body_bg_img='';
$body_color='#FFFFFF';
$body_font_face='Tahoma';
$body_font_face2='Tahoma';
$body_font_face3='';
$body_font_size='13px';
$body_font_size2='13px';
$body_font_size3='13px';
$body_font_color='';
$body_font_color2='';
$body_font_color3='';
$bottom_img='';
$bottom_color='#FFFFFF';
$bottom_height='0';
$bg_span='0';
$head_font_bold='Y';
$head_font_italic='';
$head_font_bold2='Y';
$head_font_italic2='';
$body_font_bold='';
$body_font_italic='';
$body_font_bold2='';
$body_font_italic2='';
$body_font_bold3='';
$body_font_italic3='';
$Current_Dir1 = "themesdesign/themes1/";
$bg_height = number_format(($bg_width/2), 0);
if (eregi("%", $mainwidth)) {
 //ok
 $bg_width = (100 - $bg_width).'%';
}else{
//no ok
 $bg_width = ($mainwidth - $bg_width);
}    ?>