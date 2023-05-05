<?php
session_start();
$searchs = $_GET["searchs"];
$searche = $_GET["searche"];
  ?>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<link href="../theme/main_theme/css/style.css" rel="stylesheet" type="text/css">
<table width="100%"  border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td align="center" valign="middle"><?php 
$content_background_color = "white"; 
$content_font_color = "#000000"; 
$content_font_size = 10; 
$content_font_style = "normal"; 
$content_font_weight = "bold"; 

$today_background_color = "white"; 
$today_font_color = "green"; 
$today_font_size = 10; 
$today_font_style = "normal"; 
$today_font_weight = "bold"; 

$info_background_color = "white"; 
$info_font_color = "#FF66CC"; 
$info_font_size = 10; 
$info_font_style = "normal"; 
$info_font_weight = "bold"; 

$head_background_color = "E7E7E7"; 
$head_font_color = "green"; 
$head_font_size = 11; 
$head_font_style = "normal"; 
$head_font_weight = "bold"; 


$days_head_background_color = "#B0DDFF"; 
$days_head_font_color = "#003399"; 
$days_head_font_size = 11; 
$days_head_font_style = "normal"; 
$days_head_font_weight = "bold"; 

$table_border = 0; 
$table_cellspacing = 1; 
$table_cellpadding = 1; 
$table_width = '100%'; 
$table_height = ''; 

$head_link_color = "green"; 
$font_family = "Tahoma"; 
$dayname = array ("อา.","จ.","อ.","พ.","พฤ.","ศ.","ส.");

$monthname =  array("มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", 
"พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", 
"พฤศจิกายน", "ธันวาคม"); 

if( isset( $_GET['date'] ) ) 
list($month,$year) = explode("-",$_GET['date']); 
else 
{ 
$month = $d[1]; 
$year = $d[0]; 
} 

$date_string = mktime(0,0,0,$month,1,$year); //The date string we need for some info... saves space ^_^ 

$day_start = date("w",$date_string); //The number of the 1st day of the week 



$QUERY_STRING = ereg_replace("&date=".$month."-".$year,"",$_SERVER['QUERY_STRING']); 

if( $month < 12 ) 
{ 
$next_month = $month+1; 
$next_date = $next_month."-".$year; 
} 
else 
{ 
$next_year = $year+1; 
$next_date = "1-".$next_year; 
$next_month = 1; 
} 
if( $month > 1 ) 
{ 
$previous_month = $month-1; 
$next_month = $month+1; 
$previous_date = $previous_month."-".$year; 
} 
else 
{ 
$previous_year = $year-1; 
$previous_date = "12-".$previous_year; 
$previous_month = 12; 
} 

$table_caption_prev = $monthname[$previous_month-1] . " " . ($year+543); 
$table_caption = $monthname[date("n",$date_string)-1] . " " . ($year+543); 
$table_caption_foll = $monthname[$next_month-1] . " " . ($year+543); 


echo " 
<style type=\"text/css\"> 
a.cal_head 
{ 
color: " . $head_link_color . "; 
} 
a.cal_head:hover 
{ 
text-decoration: none; 
} 
.cal_head 
{ 
background-color: " . $head_background_color . "; 
color: " . $head_font_color . "; 
font-weight: " . $head_font_weight . "; 
font-style: " . $head_font_style . "; 
} 
.cal_days 
{ 
background-color: " . $days_head_background_color . "; 
color: " . $days_head_font_color . "; 
font-weight: " . $days_head_font_weight . "; 
font-style: " . $days_head_font_style . "; 
} 
.cal_content 
{ 
background-color: " . $content_background_color . "; 
} 
.cal_content1 
{ 
background-color: FFFF99; 
} 
.cal_today 
{ 
background-color: " . $today_background_color . "; 
} 
.cal_info
{ 
background-color: " . $info_background_color . "; 
color: " . $info_font_color . "; 
font-weight: " . $info_font_weight . "; 
font-style: " . $info_font_style . "; 
} 
</style> 
<table border=\"" . $table_border . "\" cellpadding=\"3\" cellspacing=\"" . $table_cellspacing . "\" style=\"height:" . $table_height . "\" width=\"" . $table_width . "\"  bgcolor=\"#0066FF\"> 
<tr> 
<td align=\"center\" class=\"cal_head\"><a class=\"cal_head\" href=\"" . $_SERVER['PHP_SELF'] . "?db=".$_REQUEST["db"]."&amp;searchs=".$searchs."&amp;searche=".$searche."&amp;date=" . 
$previous_date . "\" title=\"" . $table_caption_prev . "\">&laquo;</a></td> 
<td align=\"center\" class=\"cal_head\" colspan=\"5\">" . $table_caption . "</td> 
<td align=\"center\" class=\"cal_head\"><a class=\"cal_head\" href=\"" . $_SERVER['PHP_SELF'] . "?db=".$_REQUEST["db"]."searchs=".$searchs."&amp;searche=".$searche."&amp;date=" . 
$next_date . "\" title=\"" . $table_caption_foll . "\">&raquo;</a></td> 
</tr> 
<tr> 
<td class=\"cal_days\"  align=center width=14%>".$dayname[0]."</td> 
<td class=\"cal_days\" align=center width=14%>".$dayname[1]."</td> 
<td class=\"cal_days\" align=center width=14%>".$dayname[2]."</td> 
<td class=\"cal_days\" align=center width=14%>".$dayname[3]."</td> 
<td class=\"cal_days\" align=center width=14%>".$dayname[4]."</td> 
<td class=\"cal_days\" align=center width=14%>".$dayname[5]."</td> 
<td class=\"cal_days\" align=center width=14%>".$dayname[6]."</td> 
</tr><tr> 
"; 

for( $i = 0 ; $i < $day_start; $i++ ) 
{ 
echo "<td class=\"cal_content\">&nbsp;</td>"; 
} 

$current_position = $day_start; //The current (column) position of the current day from the loop 

$total_days_in_month = date("t",$date_string); //The total days in the month for the end of the loop 


for( $i = 1; $i <= $total_days_in_month ; $i++) 
{ 
$mystyle = "cursor:hand;";

if( sprintf("%02d",$i) == date("d") && sprintf("%02d",$month) == date("m") && $year == date("Y") ) {
$mystyle .= "color:FF0000;font-weight:bold;";
}
$numdate = JulianToJD($month,$i,$year);
if($numdate >= $searchs AND $numdate <= $searche){
$mystyle .= "background-color:FFFF99;";
}else{
$mystyle .= "background-color:FFFFFF;";
}

$date1 = sprintf("%02d",$i)."/".sprintf("%02d",$month)."/".($year + 543);

   $mytitle = "คลิ๊กเพื่อเลือกวัน";
   $a1 = "onClick=\"parent.location.href='site_index_view4.php?db=".$_REQUEST["db"]."&amp;start_date=".$date1."'\"";



//------------------
$current_position++; 

echo "<td align=\"center\" style=\"".$mystyle."\" title=\"".$mytitle."\" ".$a1.">".$i ."</td>"; 
if( $current_position == 7 ) 
{ 
echo "</tr><tr>\n"; 
$current_position = 0; 
} 
} 


$end_day = 7-$current_position; //There are 


for( $i = 0 ; $i < $end_day ; $i++ ) 
echo "<td class=\"cal_content\"></td>\n"; 


echo "</tr></table>"; 
?></td>
  </tr>
</table>