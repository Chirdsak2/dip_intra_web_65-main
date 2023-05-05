<?php
include("admin.php");
include_once ("../src_jpgraph/jpgraph.php");
include_once ("../src_jpgraph/jpgraph_pie.php");
include_once ("../src_jpgraph/jpgraph_pie3d.php");
include ("../src_jpgraph/jpgraph_canvas.php");
##create grate
$color = array("","#CC9933","#CCCC00","#66CCFF","#00CC66","#FF99CC","#FF9933");
$i=0;
$y_datapie=array();
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

array_push($y_datapie,$color[$x]);
$sql_aws = "select count(*) as num from poll_log where c_id = '".$_GET["c_id"]."' and a_id = '".$rec[a_id]."' $con ";
$rec_aws = $db->db_fetch_array($db->query($sql_aws));
if($_GET["total"] == 0){ $b='';}else{
$b = ($rec_aws[num]*100)/$_GET["total"];
}
$a[$i] = $rec[a_name];
$data[$i] = $b;
$i++;
$x++;
}
		if(count($data) > 0 && array_sum($data) > 0) {
		// Create the Pie Graph.
		$graph = new PieGraph(500,170,"auto");
		
		// Set A title for the plot
		//$graph->title->Set("แผนภูมิงบประมาณ จำแนกตามประเภทงบประมาณ");
		//$graph->title->SetFont(FF_ANGSANA,FS_BOLD,18); 
		//$graph->title->SetColor("black");
		//$graph->title->Set("งบประมาณทั้งหมด : ".number_format(array_sum($data), 2, '.', ',')." บาท");
		//$graph->title->SetFont(FF_ANGSANA,FS_BOLD,"12");
		
		// Create pie plot
		$p1 = new PiePlot3d($data);
		$p1->SetSliceColors($y_datapie);
		$p1->SetTheme("earth");
		$p1->SetCenter(0.3);
		$p1->SetAngle(50);
		$p1->value->HideZero();
		$p1->value->SetFont(FF_ANGSANA,FS_NORMAL,12);
		$p1->value->SetFormat("%01.2f%%");
		
		//$a=array("yes","no");
		$graph->legend->Pos(0.850,0.3,"center","top");
		$graph->legend->SetFont(FF_ANGSANA,FS_NORMAL,10);
		$graph->legend->SetFillColor('gray');
		//$p1->SetLegends($a);
		
		$graph->Add($p1);
		
		// Output the chart
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
