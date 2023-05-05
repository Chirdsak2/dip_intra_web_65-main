<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include_once ("../src_jpgraph/jpgraph.php");
include_once ("../src_jpgraph/jpgraph_pie.php");
include_once ("../src_jpgraph/jpgraph_pie3d.php");
include ("../src_jpgraph/jpgraph_canvas.php");
$data = array();
$monthname = array();
if($flag=='month'){
	for($i=1;$i<13;$i++){ 
		$sql_month = mysql_query("SELECT COUNT(sv_id) AS cmonth FROM stat_visitor WHERE sv_date LIKE '".$thisyear."-".sprintf("%02d",$i)."-%' ");
		$ccount = mysql_fetch_row($sql_month);
		array_push($data,$ccount[0]);
		
	}
	$monthname = array('jan','fab','mar','april','may','june','july','aug','set','oct','nov','dec');
}else if($flag=='day'){
		if($thismonth == "01" OR $thismonth == "03" OR $thismonth == "05" OR $thismonth == "07" OR $thismonth == "08" OR $thismonth == "10" OR $thismonth == "12" ){
		$endmonth = "31";
		}
		if($thismonth == "04" OR $thismonth == "06" OR $thismonth == "09" OR $thismonth == "11" ){
		$endmonth = "30";
		}
		if($thismonth == "02"){
		if($thisyear % 4 == 0){
				$endmonth = "29";
		}else{
				$endmonth = "28";
		}
		}
		 for($d=1;$d<=$endmonth;$d++){ 
		 $todate = $thisyear."-".$thismonth."-".sprintf("%02d",$d);
		 $sql_date = mysql_query("SELECT COUNT(sv_id) AS cmonth FROM stat_visitor WHERE sv_date = '$todate'  ");
		$ccount = mysql_fetch_row($sql_date);
		array_push($data,$ccount[0]);
		array_push($monthname,$d);
		}
		
}else if($flag=='time'){
for($m=0;$m<24;$m++){ 
		$mstart = sprintf("%02d",$m).":00";
		$mend = sprintf("%02d",$m).":59";
		$sql_time = mysql_query("SELECT COUNT(sv_id) AS cmonth FROM stat_visitor WHERE sv_date = '".$thisyear."-".$thismonth."-".$thisday."'  AND (sv_time BETWEEN '".$mstart.":00"."' AND '".$mend.":59"."')");
		$ccount = mysql_fetch_row($sql_time);
		array_push($data,$ccount[0]);
		array_push($monthname,$mstart.'  -  '.$mend);
}
}
//print_r($data);
if(count($data) > 0 && array_sum($data) > 0){
		$graph = new PieGraph(750,355,"middle");
		$p1 = new PiePlot3d($data);
		$p1->SetTheme("earth");
		$p1->SetCenter(0.3);
		$p1->SetAngle(60);
		$p1->value->HideZero();
		$p1->value->SetFont(FF_ANGSANA,FS_NORMAL,12);
		$p1->value->SetFormat("%01.2f%%");
		
		//$a=array("yes","no");
		$graph->legend->Pos(0.850,0.02,"center","top");
		$graph->legend->SetFont(FF_ANGSANA,FS_NORMAL,12);
		$graph->legend->SetFillColor('gray');
		$p1->SetLegends($monthname);
		
		$graph->Add($p1);
		
		// Output the chart
		$graph->Stroke();
}else{
// Create the Text Error. 
		$graph = new CanvasGraph(750,355);
		
		$t1 = new Text("                  NO DATA                 ");
		$t1->SetPos(0.1,0.25);
		$t1->SetOrientation("h");
		$t1->SetFont(FF_ANGSANA,FS_BOLD,14);
		$t1->SetBox("white","black",'gray');
		$t1->SetColor("black");
		$t1->ParagraphAlign("center");
		$graph->AddText($t1);
		
		$graph->Stroke();
}

?>
