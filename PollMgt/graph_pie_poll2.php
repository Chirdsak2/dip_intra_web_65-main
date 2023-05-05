<?php
include("admin.php");
require( "../include/SwiffChart.php" );
  

##create grate
$i=0;
$x=1;
	if($start_date == "" AND $end_date == ""){
			$con = "";
			}elseif($start_date != "" AND $end_date == ""){
			$st = explode("/",$start_date);
			$con = " AND (date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
			}elseif($start_date == "" AND $end_date != ""){
			$st = explode("/",$end_date);
			$con = " AND (date = '".($st[2] -543)."-".$st[1]."-".$st[0]."') ";
			}else{
			$st = explode("/",$start_date);
			$en = explode("/",$end_date);
			$con = " AND (date BETWEEN '".($st[2] -543)."-".$st[1]."-".$st[0]."' AND '".($en[2] - 543)."-".$en[1]."-".$en[0]."') ";
			}
		
$sql = "select * from poll_ans where c_id = '".$_GET["c_id"]."'";
$query = $db->query($sql);
while($rec = $db->db_fetch_array($query)){

$sql_aws = "select count(*) as num from poll_log where c_id = '".$_GET["c_id"]."' and a_id = '".$rec[a_id]."' $con ";
$rec_aws = $db->db_fetch_array($db->query($sql_aws));
if($_GET["total"] == 0){ $b='';}else{
$b = ($rec_aws[num]*100)/$_GET["total"];
}
if(empty($a)){
$a .= $rec[a_name];
}else{
$a .= ";".$rec[a_name];
}
if(empty($data)){
$data .= $b;
}else{
$data .= ";".$b;
}
$i++;
$x++;
}
echo $data;





  $chart= new SwiffChart;
   // Fill the series and categories
  $categories= "".$a."";
  $chart->SetCategoriesFromString($categories);

  $chart->SetSeriesValuesFromString( 0, "".$data."" );

  // Set the chart title
 $chart->SetTitle("Geographical Distribution");

  // Apply a Pie style
  // The chart type is stored in the style file (*.scs)
  // Here the selected style is the predefined pie style "Honolulu"
  $chart->LoadStyle( "pie/pie_graph_show" );
      
  $chart->SetLooping( false );

  $chart_res= $chart->GetHTMLTag();
?>
