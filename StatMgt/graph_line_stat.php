<?php
include("../lib/permission1.php");
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include_once ("../src_jpgraph/jpgraph.php");
include ("../src_jpgraph/jpgraph_line.php");
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
		$graph = new Graph(750,355);
		$graph->SetMarginColor('white');
		$graph->SetScale("textlin",0,array_sum($data));
		$graph->SetFrame(false);
		$graph->SetMargin(62,35,45,65);
		$graph->SetBox();
		$graph->yaxis->scale->SetGrace(5);
		$graph->SetFrame(false);
		$graph->ygrid->SetFill(true,'#43A8FD@0.5','#A3D5FF@0.8');
		$graph->ygrid->SetLineStyle('dashed');
		$graph->ygrid->SetColor('gray');
		
		$graph->xgrid->Show();
		$graph->xgrid->SetLineStyle('dashed');
		$graph->xgrid->SetColor('gray');
		$graph->xaxis->SetTickLabels($monthname);
		$graph->xaxis->SetLabelMargin(10);
		$graph->xaxis->SetFont(FF_ANGSANA,FS_NORMAL,10);
		$graph->xaxis->SetLabelAngle(20);//ตัวอักษรเอียง
		$graph->yaxis->SetFont(FF_ANGSANA,FS_NORMAL,10);
		//$graph->yaxis->SetLabelFormat('%3d%%');
		$graph->SetAxisStyle(AXSTYLE_YBOXOUT);
		$graph->xaxis->SetTitle($flag);
		$graph->xaxis->title->SetFont(FF_ANGSANA,FS_BOLD,16);
		$graph->xaxis->title->SetMargin(20,5,5,5);
		// Create the first line
	$p1 = new LinePlot($data);
	$p1->SetColor("blue");
	$p1->value->Show();
	$p1->value->SetFormat('%0.0f');
	$p1->SetWeight(2);
	$p1->mark->SetType(MARK_DIAMOND);
	$p1->mark->SetSize(3);
	$p1->mark->SetFillColor("blue");
	$p1->mark->Show();
	$p1->SetLegend('counting number');
	$p1->value->SetFont(FF_ANGSANA,FS_NORMAL, 12);
	$graph->Add($p1);
	
	
	//$graph->legend->SetShadow('gray@0.4',5);
	$graph->legend->SetPos(0.15,0.1,'right','top');
	$graph->legend->SetFont(FF_ANGSANA,FS_BOLD,10);
	// Output line
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
