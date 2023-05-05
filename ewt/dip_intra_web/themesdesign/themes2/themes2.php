<?php   
$themes_id='2';
$themes_group='';
$themes_type='';
$themes_file='';
$themes_namethems='themes2';
$themes_name='calendar';
$themes_modulename='';
$bg_img='';
$bg_color='#0da3cd';
$bg_width='25';
$head_img='head_img20131105232543.jpg';
$head_color='';
$head_font_face='Tahoma';
$head_font_face2='Tahoma';
$head_font_size='13px';
$head_font_size2='13px';
$head_font_color='#ffffff';
$head_font_color2='#000000';
$head_height='27';
$body_bg_img='';
$body_color='#ffffff';
$body_font_face='Tahoma';
$body_font_face2='Tahoma';
$body_font_face3='';
$body_font_size='13px';
$body_font_size2='13px';
$body_font_size3='13px';
$body_font_color='#000000';
$body_font_color2='#000000';
$body_font_color3='#000000';
$bottom_img='';
$bottom_color='#0da3cd';
$bottom_height='0';
$bg_span='0';
$head_font_bold='';
$head_font_italic='';
$head_font_bold2='';
$head_font_italic2='';
$body_font_bold='';
$body_font_italic='';
$body_font_bold2='';
$body_font_italic2='';
$body_font_bold3='';
$body_font_italic3='';
$Current_Dir1 = "themesdesign/themes2/";
$bg_height = number_format(($bg_width/2), 0);
if (eregi("%", $mainwidth)) {
 //ok
 $bg_width = (100 - $bg_width).'%';
}else{
//no ok
 $bg_width = ($mainwidth - $bg_width);
}    ?>