<?php
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
include_once ("../../src_jpgraph/jpgraph.php");
include_once ("../../src_jpgraph/jpgraph_line.php");
include ("../../src_jpgraph/jpgraph_canvas.php");
##create grate
$color = array("","#CC9933","#CCCC00","#66CCFF","#00CC66","#FF99CC","#FF9933");
$i=0;
$y_datapie=array();
$data=array();
$data1=array();
$data2=array();
$data3=array();
$data4=array();
$data5=array();
$data6=array();
$data7=array();$data8=array();
$data9=array();
$data10=array();
$count_to=array();
$x=1;
for($i=1;$i<=$total;$i++){
$count_to[] .= $i;
}
$i=1;
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

array_push($data,0);

while($rec = $db->db_fetch_array($query)){

array_push($y_datapie,$color[$x]);
$sql_aws = "select count(*) as num from poll_log where c_id = '".$_GET["c_id"]."' and a_id = '".$rec[a_id]."' $con ";
$rec_aws = $db->db_fetch_array($db->query($sql_aws));

if($_GET["total"] == 0){ $b='';}else{
array_push($data,$rec_aws[num]);
	/*for($v=1;$v<=$total;$v++){
	
		if($v == $rec_aws[num]){
		array_push(${"data".$i},($rec_aws[num]*100)/$_GET["total"]);
		}else if($v > $rec_aws[num]){
		array_push(${"data".$i},'');
		}else{
		array_push(${"data".$i},0);
		}
	}*/
}
$a[$i] = $rec[a_name];
//$data[$i] = $b;
$num[$i] = $rec_aws[num];
$i++;
$x++;
}

if(count($data) > 0 && array_sum($data) > 0) {
		$graph = new Graph(400,200);
		$graph->SetMarginColor('white');
		$graph->SetScale("textlin",0,$total);
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
		$graph->xaxis->SetTickLabels($a);
		$graph->xaxis->SetLabelMargin(12);
		$graph->xaxis->SetFont(FF_ANGSANA,FS_NORMAL,10);
		$graph->xaxis->SetLabelAngle(20);//ตัวอักษรเอียง
		$graph->yaxis->SetFont(FF_ANGSANA,FS_NORMAL,10);
		$graph->yaxis->SetLabelFormat('%0.0f');
		$graph->SetAxisStyle(AXSTYLE_YBOXOUT);
		//$graph->xaxis->SetTitle("data");
		$graph->xaxis->title->SetFont(FF_ANGSANA,FS_BOLD,16);
		$graph->xaxis->title->SetMargin(20,5,5,5);
		// Create the first line
		$p1 = new LinePlot($data);
	$p1->SetColor($y_datapie[0]);
	$p1->value->Show();
	$p1->value->SetFormat('%0.0f');
	$p1->SetWeight(2);
	$p1->mark->SetType(MARK_DIAMOND);
	$p1->mark->SetSize(3);
	$p1->mark->SetFillColor('gray');
	$p1->mark->Show();
	//$p1->SetLegend($a[0]);
	$p1->value->SetFont(FF_ANGSANA,FS_NORMAL, 12);
	$graph->Add($p1);
	/*if(count($data1) > 0){
	$p1 = new LinePlot($data1);
	$p1->SetColor($y_datapie[0]);
	$p1->value->Show();
	$p1->value->SetFormat('%0.0f');
	$p1->SetWeight(2);
	$p1->mark->SetType(MARK_DIAMOND);
	$p1->mark->SetSize(3);
	$p1->mark->SetFillColor('gray');
	$p1->mark->Show();
	//$p1->SetLegend($a[0]);
	$p1->value->SetFont(FF_ANGSANA,FS_NORMAL, 12);
	$graph->Add($p1);
	}
	if(count($data2) > 0){
	$p2 = new LinePlot($data2);
	$p2->SetColor($y_datapie[1]);
	$p2->value->Show();
	$p2->value->SetFormat('%0.0f');
	$p2->SetWeight(2);
	$p2->mark->SetType(MARK_DIAMOND);
	$p2->mark->SetSize(3);
	$p2->mark->SetFillColor('gray');
	$p2->mark->Show();
	//$p1->SetLegend($a[0]);
	$p2->value->SetFont(FF_ANGSANA,FS_NORMAL, 12);
	$graph->Add($p2);
	}if(count($data3) > 0){
	$p3 = new LinePlot($data3);
	$p3->SetColor($y_datapie[2]);
	$p3->value->Show();
	$p3->value->SetFormat('%0.0f');
	$p3->SetWeight(2);
	$p3->mark->SetType(MARK_DIAMOND);
	$p3->mark->SetSize(3);
	$p3->mark->SetFillColor('gray');
	$p3->mark->Show();
	//$p1->SetLegend($a[0]);
	$p3->value->SetFont(FF_ANGSANA,FS_NORMAL, 12);
	$graph->Add($p3);
	}if(count($data4) > 0){
	$p4 = new LinePlot($data4);
	$p4->SetColor($y_datapie[3]);
	$p4->value->Show();
	$p4->value->SetFormat('%0.0f');
	$p4->SetWeight(2);
	$p4->mark->SetType(MARK_DIAMOND);
	$p4->mark->SetSize(3);
	$p4->mark->SetFillColor('gray');
	$p4->mark->Show();
	//$p1->SetLegend($a[0]);
	$p4->value->SetFont(FF_ANGSANA,FS_NORMAL, 12);
	$graph->Add($p4);
	}
	if(count($data5) > 0){
	$p5 = new LinePlot($data5);
	$p5->SetColor($y_datapie[4]);
	$p5->value->Show();
	$p5->value->SetFormat('%0.0f');
	$p5->SetWeight(2);
	$p5->mark->SetType(MARK_DIAMOND);
	$p5->mark->SetSize(3);
	$p5->mark->SetFillColor('gray');
	$p5->mark->Show();
	//$p1->SetLegend($a[0]);
	$p5->value->SetFont(FF_ANGSANA,FS_NORMAL, 12);
	$graph->Add($p5);
	}
	if(count($data6) > 0){
	$p6 = new LinePlot($data6);
	$p6->SetColor($y_datapie[5]);
	$p6->value->Show();
	$p6->value->SetFormat('%0.0f');
	$p6->SetWeight(2);
	$p6->mark->SetType(MARK_DIAMOND);
	$p6->mark->SetSize(3);
	$p6->mark->SetFillColor('gray');
	$p6->mark->Show();
	//$p1->SetLegend($a[0]);
	$p6->value->SetFont(FF_ANGSANA,FS_NORMAL, 12);
	$graph->Add($p6);
	}if(count($data7) > 0){
	$p7 = new LinePlot($data7);
	$p7->SetColor($y_datapie[6]);
	$p7->value->Show();
	$p7->value->SetFormat('%0.0f');
	$p7->SetWeight(2);
	$p7->mark->SetType(MARK_DIAMOND);
	$p7->mark->SetSize(3);
	$p7->mark->SetFillColor('gray');
	$p7->mark->Show();
	//$p1->SetLegend($a[0]);
	$p7->value->SetFont(FF_ANGSANA,FS_NORMAL, 12);
	$graph->Add($p7);
	}if(count($data8) > 0){
	$p8 = new LinePlot($data8);
	$p8->SetColor($y_datapie[7]);
	$p8->value->Show();
	$p8->value->SetFormat('%0.0f');
	$p8->SetWeight(2);
	$p8->mark->SetType(MARK_DIAMOND);
	$p8->mark->SetSize(3);
	$p8->mark->SetFillColor('gray');
	$p8->mark->Show();
	//$p1->SetLegend($a[0]);
	$p8->value->SetFont(FF_ANGSANA,FS_NORMAL, 12);
	$graph->Add($p8);
	}if(count($data9) > 0){
	$p9 = new LinePlot($data9);
	$p9->SetColor($y_datapie[8]);
	$p9->value->Show();
	$p9->value->SetFormat('%0.0f');
	$p9->SetWeight(2);
	$p9->mark->SetType(MARK_DIAMOND);
	$p9->mark->SetSize(3);
	$p9->mark->SetFillColor('gray');
	$p9->mark->Show();
	//$p1->SetLegend($a[0]);
	$p9->value->SetFont(FF_ANGSANA,FS_NORMAL, 12);
	$graph->Add($p9);
	}if(count($data10) > 0){
	$p10 = new LinePlot($data10);
	$p10->SetColor($y_datapie[9]);
	$p10->value->Show();
	$p10->value->SetFormat('%0.0f');
	$p10->SetWeight(2);
	$p10->mark->SetType(MARK_DIAMOND);
	$p10->mark->SetSize(3);
	$p10->mark->SetFillColor('gray');
	$p10->mark->Show();
	//$p1->SetLegend($a[0]);
	$p10->value->SetFont(FF_ANGSANA,FS_NORMAL, 12);
	$graph->Add($p10);
	}*/
	//$graph->legend->SetShadow('gray@0.4',5);
	$graph->legend->SetPos(0.15,0.1,'right','top');
	$graph->legend->SetFont(FF_ANGSANA,FS_BOLD,10);
	// Output line
	$graph->Stroke();
	}
	else {
		// Create the Text Error. 
		$graph = new CanvasGraph(300,120);	
		
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
