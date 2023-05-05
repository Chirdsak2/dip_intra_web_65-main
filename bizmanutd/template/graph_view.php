<?php
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");

$bplotdata = array();
		function th2unifix($sti) {
			$th2unimap = array( 
			'ก' => "&#3585;", 'ข' => "&#3586;", 'ฃ' => "&#3587;", 'ค' => "&#3588;", 'ฅ' => "&#3589;", 'ฆ' => "&#3590;", 'ง' => "&#3591;",
			'จ' => "&#3592;", 'ฉ' => "&#3593;", 'ช' => "&#3594;", 'ซ' => "&#3595;", 'ฌ' => "&#3596;", 'ญ' => "&#3597;", 'ฎ' => "&#3598;",
			'ฏ' => "&#3599;", 'ฐ' => "&#3600;", 'ฑ' => "&#3601;", 'ฒ' => "&#3602;", 'ณ' => "&#3603;", 'ด' => "&#3604;", 'ต' => "&#3605;",
			'ถ' => "&#3606;", 'ท' => "&#3607;", 'ธ' => "&#3608;", 'น' => "&#3609;", 'บ' => "&#3610;", 'ป' => "&#3611;", 'ผ' => "&#3612;",
			'ฝ' => "&#3613;", 'พ' => "&#3614;", 'ฟ' => "&#3615;", 'ภ' => "&#3616;", 'ม' => "&#3617;", 'ย' => "&#3618;", 'ร' => "&#3619;",
			'ฤ' => "&#3620;", 'ล' => "&#3621;", 'ฦ' => "&#3622;", 'ว' => "&#3623;", 'ศ' => "&#3624;", 'ษ' => "&#3625;", 'ส' => "&#3626;",
			'ห' => "&#3627;", 'ฬ' => "&#3628;", 'อ' => "&#3629;", 'ฮ' => "&#3630;", 'ฯ' => "&#3631;", 'ะ' => "&#3632;", 'ั' => "&#3633;",
			'า' => "&#3634;", 'ำ' => "&#3635;", 'ิ' => "&#3636;", 'ี' => "&#3637;", 'ึ' => "&#3638;", 'ื' => "&#3639;", 'ุ' => "&#3640;",
			'ู' => "&#3641;", 'ฺ' => "&#3642;", '฿' => "&#3647;", 'เ' => "&#3648;", 'แ' => "&#3649;", 'โ' => "&#3650;", 'ใ' => "&#3651;",
			'ไ' => "&#3652;", 'ๅ' => "&#3653;", 'ๆ' => "&#3654;", '็' => "&#3655;", '่' => "&#3656;", '้' => "&#3657;", '๊' => "&#3658;",
			'๋' => "&#3659;", '์' => "&#3660;", 'ํ' => "&#3661;", '๎' => "&#3662;", '๏' => "&#3663;", '๐' => "&#3664;", '๑' => "&#3665;",
			'๒' => "&#3666;", '๓' => "&#3667;", '๔' => "&#3668;", '๕' => "&#3669;", '๖' => "&#3670;", '๗' => "&#3671;", '๘' => "&#3672;",
			'๙' => "&#3673;", '๚' => "&#3674;", '๛' => "&#3675;");
		
			$th2unimap2 = array( // สำหรับไม่มีสระอยู่ข้างหน้า
			'่' => "&#63242;", 
			'้' => "&#63243;", 
			'๊' => "&#63244;",
			'๋' => "&#63245;", 
			'์' => "&#63246;"
			);
		
			$th2unimap3 = array( // สำหรับมี อักษรมีหางอยู่ข้างหน้า
			'ิ' => "&#63233;",
			'ี' => "&#63234;", 
			'ึ' => "&#63235;", 
			'ื' => "&#63236;",
			'่' => "&#63237;", 
			'้' => "&#63238;", 
			'๊' => "&#63239;",
			'๋' => "&#63240;", 
			'์' => "&#63241;",
			'ั' => "&#63248;",
			'ํ' => "&#63249;",
			'็' => "&#63250;"
			);
		
			$th2unimap4 = array( // สำหรับมี 2 อักษรมีหางอยู่ข้างหน้า และ 1 ตัวอักษรข้างหน้าเป็นสระบน
			'่' => "&#63251;", 
			'้' => "&#63252;", 
			'๊' => "&#63253;",
			'๋' => "&#63254;", 
			'์' => "&#63255;"
			);
		
			$th2unimap5 = array( // สำหรับ ญ ฐ ร่วมกับ สระอุ อู และ อฺ
			'ญ' => "&#63247;", 
			'ฐ' => "&#63232;", 
			);
			
			$sto = '';
			$len = strlen($sti);
			for ($i = 0; $i < $len; $i++) {
				if ($th2unimap[$sti{$i}]) {
					if ($i < $len && in_array($sti{$i}, Array('ญ','ฐ')) && in_array($sti{$i+1}, Array('ู','ุ','ฺ'))) {
						$sto .= $th2unimap5[$sti{$i}];
					}
					elseif ($i > 1 && in_array($sti{$i-2}, Array('ป','ฝ','ฟ')) && 
						($sti{$i-1} == 'ั'  || ($sti{$i-1} >= 'ิ' && $sti{$i-1} <= 'ื')) &&
						$th2unimap4[$sti{$i}]) {
						$sto .= $th2unimap4[$sti{$i}];
					}
					elseif ($i > 0) {
						if (in_array($sti{$i-1}, Array('ป','ฝ','ฟ')) && $th2unimap3[$sti{$i}])
							$sto .= $th2unimap3[$sti{$i}];
						elseif (!($sti{$i-1} == 'ั'  || ($sti{$i-1} >= 'ิ' && $sti{$i-1} <= 'ื')) && $th2unimap2[$sti{$i}])
							$sto .= $th2unimap2[$sti{$i}];
						else
							$sto .= $th2unimap[$sti{$i}];
					}
					else
						$sto .= $th2unimap[$sti{$i}];
					}
					else
						$sto .= $sti{$i};
				}
			return $sto;
		}
/////////////////////////////////  in put data  ////////////////////////////////////////////


$sqlgraph="SELECT * FROM graph_index WHERE graph_id = '".$_GET["graph_id"]."' ";
$graphquery=$db->query($sqlgraph);
$graph=$db->db_fetch_array($graphquery);	
	
$type=$graph["graph_type"];

$size_y=$graph["graph_width"] ;
$size_x=$graph["graph_height"] ;
$graph_color=$graph["graph_bgcolor"] ;

$topic=th2unifix($graph["graph_subject"]) ;

$sub_title =th2unifix($graph["graph_description"]) ;
if($graph["graph_bgpic"] != ""){
$graph_pic = "graph/".$graph["graph_bgpic"];
}else{
$graph_pic = "";
}

$sqly="SELECT * FROM graph_y  WHERE graph_id = '".$_GET["graph_id"]."' ORDER BY y_id ASC";
$yquery=$db->query($sqly);
$numrow_y=$db->db_num_rows($yquery);


$y_titlepie = array();
$y_datapie = array();
$y_colorpie = array();
	/*
for($i=1;$i<($numrow_y+1);$i++){
	$y=mysql_fetch_array($yquery);
	${datay.$i}=explode(',',$y[y_value]);
	${y_title.$i}= th2unifix($y[y_title]);
	${topbg.$i} = $y[color];
	array_push($y_datapie,th2unifix($y[y_value]));
	array_push($y_titlepie,th2unifix($y[y_title]));
	array_push($y_colorpie,$y[color]);
	

	echo "datay.$i =";
	print_r(${datay.$i});
	echo "<br>";
	echo "y_title.$i =".${y_title.$i}."<br>";
	echo "topbg.$i =".${topbg.$i}."<br>";
	
}	*/
$i = 1;

while($Y = $db->db_fetch_array($yquery)){
$sql_value = $db->query("SELECT value_value FROM graph_value WHERE graph_y = '$Y[y_id]' ORDER BY graph_x ASC");
		${datay.$i} = array();
		$y = 0;
	while($V = $db->db_fetch_row($sql_value)){
		array_push(${datay.$i},$V[0]);
		if($y == 0){
		array_push($y_datapie,$V[0]);
		}
	$y++; }
		${y_title.$i}= th2unifix($Y[y_title]);
		${topbg.$i} = $Y[y_color];
		//	if($i == "1"){
			array_push($y_titlepie,th2unifix($Y[y_title]));
			array_push($y_colorpie,$Y[y_color]);
		//	}
$i++;
}

$sqlx="SELECT * FROM graph_x  WHERE graph_id='".$_GET["graph_id"]."' ORDER BY  x_id ASC";
$xquery=$db->query($sqlx);
$numrow_x=$db->db_num_rows($xquery);
$x_title = array();
while($X = $db->db_fetch_array($xquery)){
	array_push($x_title,th2unifix($X[x_title]));
}


///////////////////////////////////////////////////////////////////////////////////////////////
include ("../../src_jpgraph/jpgraph.php");


if($type=="Column" OR $type=="Column3d"){
	include ("../../src_jpgraph/jpgraph_bar.php");

	$graph = new Graph($size_y,$size_x,'auto');
	$graph->SetMarginColor($graph_color);
	$graph->SetScale("textlin");
	$graph->img->SetMargin(40,80,30,40);
	$graph->legend->Pos(0.01,0.01);
	$graph->legend->SetShadow('darkgray@0.5');
	$graph->legend->SetFillColor('lightblue@0.3');
	$graph->legend->SetFont(FF_ANGSANA,FS_NORMAL,18);
	$graph->xaxis->SetTickLabels($x_title);
	
	$graph->xaxis->title->SetFont(FF_ANGSANA,FS_NORMAL,18);
	$graph->xaxis->title->SetColor('black');
	$graph->xaxis->SetFont(FF_ANGSANA,FS_BOLD,18);
	$graph->xaxis->SetColor('black');
	//$graph->yaxis->SetFont(FF_ANGSANA,FS_BOLD);
	$graph->yaxis->SetColor('black');
	$graph->ygrid->SetColor('orange@0.5');

	$graph->title->Set($topic);

	$graph->title->SetMargin(3);
	$graph->title->SetFont(FF_ANGSANA,FS_BOLD,18);
	$graph->subtitle->SetFont(FF_ANGSANA,FS_NORMAL,18);
	$graph->subtitle->Set($sub_title);
		if($graph_pic != ""){
	$graph->SetBackgroundImage($graph_pic,BGIMG_FILLFRAME);
	}
	// Create the three var series we will combine
	
		for($i=1;$i<($numrow_y+1);$i++){
			${bplot.$i} = new BarPlot(${datay.$i});
			${bplot.$i}->SetFillColor(${topbg.$i});
			${bplot.$i}->SetLegend(${y_title.$i});
			if($type=="Column3d"){
			${bplot.$i}->SetShadow("black",5,5);
			}
			//${bplot.$i}->value->Show();
			//${bplot.$i}->value->SetFormat('0.0f');
			${bplot.$i}->value->SetFont(FF_ANGSANA,FS_NORMAL,18);
			${bplot.$i}->value->SetAngle(40);
			${bplot.$i}->value->SetColor("black","darkred");
			array_push($bplotdata,${bplot.$i});
		}
			
	$gbarplot = new GroupBarPlot($bplotdata);
	$gbarplot->SetWidth(0.6);
	$graph->Add($gbarplot);

}elseif($type=="Bar" OR $type=="Bar3d"){
	include ("../../src_jpgraph/jpgraph_bar.php");
	$graph = new Graph($size_y,$size_x,'auto');
	$graph->SetMarginColor($graph_color);
	$graph->SetScale("textlin");
	$graph->img->SetMargin(40,80,30,40);
	$graph->legend->Pos(0.01,0.01);
	$graph->legend->SetShadow('darkgray@0.5');
	$graph->legend->SetFillColor('lightblue@0.3');
	$graph->legend->SetFont(FF_ANGSANA,FS_NORMAL,18);
	$graph->xaxis->SetTickLabels($x_title);
	
	$graph->xaxis->title->SetFont(FF_ANGSANA,FS_BOLD,18);
	$graph->xaxis->title->SetColor('black');
	$graph->xaxis->SetFont(FF_ANGSANA,FS_BOLD,18);
	$graph->xaxis->SetColor('black');
	//$graph->yaxis->SetFont(FF_ANGSANA,FS_BOLD);
	$graph->yaxis->SetColor('black');
	$graph->ygrid->SetColor('orange@0.5');
	$graph->title->Set($topic);
	$graph->subtitle->Set($sub_title);
	$graph->title->SetMargin(3);
	$graph->title->SetFont(FF_ANGSANA,FS_BOLD,18);
	$graph->subtitle->SetFont(FF_ANGSANA,FS_NORMAL,18);
		if($graph_pic != ""){
	$graph->SetBackgroundImage($graph_pic,BGIMG_FILLFRAME);
	}
	$top = 80;
	$bottom = 30;
	$left = 50;
	$right = 30;
	$graph->Set90AndMargin($left,$right,$top,$bottom);
	// Create the three var series we will combine
	
		for($i=1;$i<($numrow_y+1);$i++){
			${bplot.$i} = new BarPlot(${datay.$i});
			${bplot.$i}->SetFillColor(${topbg.$i});
			${bplot.$i}->SetLegend(${y_title.$i});
			//${bplot.$i}->SetShadow('black@0.4');
			//${bplot.$i}->value->Show();
			//${bplot.$i}->value->SetFormat('0.0f');
			${bplot.$i}->value->SetFont(FF_ANGSANA,FS_NORMAL,18);
			${bplot.$i}->value->SetAngle(40);
			${bplot.$i}->value->SetColor("black","darkred");
			if($type=="Bar3d"){
			${bplot.$i}->SetShadow("black",5,5);
			}
			array_push($bplotdata,${bplot.$i});
		}
		
		
		
		
	$gbarplot = new GroupBarPlot($bplotdata);
	$gbarplot->SetWidth(0.6);
	$graph->Add($gbarplot);

}elseif($type=="Line" OR $type=="Line3d"){
	include ("../../src_jpgraph/jpgraph_line.php");
	$graph = new Graph($size_y,$size_x,'auto');
	$graph->SetMarginColor($graph_color);
	$graph->SetScale("textlin");
	$graph->SetFrame(true);
	$graph->SetMargin(30,50,30,30);
	$graph->img->SetMargin(40,80,30,40);
	$graph->legend->Pos(0.01,0.01);
	$graph->legend->SetShadow('darkgray@0.5');
	$graph->legend->SetFillColor('lightblue@0.3');
	$graph->legend->SetFont(FF_ANGSANA,FS_NORMAL,18);
	$graph->title->Set($topic);
	$graph->subtitle->Set($sub_title);
		if($graph_pic != ""){
	$graph->SetBackgroundImage($graph_pic,BGIMG_FILLFRAME);
	}
	
	$graph->yaxis->HideZeroLabel();
	$graph->ygrid->SetFill(true,'#EFEFEF@0.5','#BBCCFF@0.5');
	$graph->xgrid->Show();
	
	$graph->xaxis->SetTickLabels($x_title);
	$graph->xaxis->SetFont(FF_ANGSANA,FS_BOLD,18);


	$graph->title->SetMargin(3);
	$graph->title->SetFont(FF_ANGSANA,FS_BOLD,18);
	$graph->subtitle->SetFont(FF_ANGSANA,FS_NORMAL,18);
	
	for($i=1;$i<($numrow_y+1);$i++){
			${p.$i} = new LinePlot(${datay.$i});

			${p.$i}->SetColor(${topbg.$i});
		//	${p.$i}->SetFillGradient(${topbg.$i}.'@0.1','white@0.1');
		if($type=="Line"){
			${p.$i}->SetWeight(1);   
		}elseif($type=="Line3d"){
			${p.$i}->SetWeight(5);   
		}
			${p.$i}->SetLegend(${y_title.$i});
			${p.$i}->mark->SetType(MARK_FILLEDCIRCLE);
			${p.$i}->mark->SetFillColor(${topbg.$i});
			if($type=="Line"){
			${p.$i}->mark->SetWidth(3);
			}elseif($type=="Line3d"){
			${p.$i}->mark->SetWidth(5);
			}
			${p.$i}->SetCenter();

			$graph->Add(${p.$i});
	}
	$graph->legend->SetShadow('gray@0.4',5);
	$graph->legend->SetPos(0.1,0.1,'right','top');
$graph->SetShadow();

}elseif($type=="Area"){
	include ("../../src_jpgraph/jpgraph_line.php");
	$graph = new Graph($size_y,$size_x,'auto');
	$graph->SetMarginColor($graph_color);
	$graph->SetScale("textlin");
	$graph->SetFrame(true);
	$graph->SetMargin(30,50,30,30);
	$graph->img->SetMargin(40,80,30,40);
	if($graph_pic != ""){
	$graph->SetBackgroundImage($graph_pic,BGIMG_FILLFRAME);
	}
	$graph->legend->Pos(0.01,0.01);
	
	$graph->legend->SetFillColor('lightblue@0.3');
	$graph->legend->SetFont(FF_ANGSANA,FS_NORMAL,18);
	$graph->title->Set($topic);
	$graph->subtitle->Set($sub_title);
	
	
	
	$graph->yaxis->HideZeroLabel();
	$graph->ygrid->SetFill(true,'#EFEFEF@0.5','#BBCCFF@0.5');
	$graph->xgrid->Show();
	$graph->xaxis->SetFont(FF_ANGSANA,FS_BOLD,18);
	$graph->xaxis->SetTickLabels($x_title);
	$graph->title->SetFont(FF_ANGSANA,FS_BOLD,18);
	$graph->subtitle->SetFont(FF_ANGSANA,FS_NORMAL,18);



	
	for($i=1;$i<($numrow_y+1);$i++){
			${p.$i} = new LinePlot(${datay.$i});
			${p.$i}->SetColor(${topbg.$i});
			${p.$i}->SetLegend(${y_title.$i});
			${p.$i}->mark->SetType(MARK_FILLEDCIRCLE);
			${p.$i}->mark->SetFillColor(${topbg.$i});
			${p.$i}->mark->SetWidth(3);
			${p.$i}->SetCenter();
			//${p.$i}->SetFillColor(${topbg.$i});
			${p.$i}->SetFillGradient(${topbg.$i},'white');
			$graph->Add(${p.$i});
	}
	$graph->legend->SetShadow('gray@0.4',5);
	$graph->legend->SetPos(0.1,0.1,'right','top');



}elseif($type=="Pie" || $type=="Pie3d"){

	include ("../../src_jpgraph/jpgraph_pie.php");
	include ("../../src_jpgraph/jpgraph_pie3d.php");
	$graph = new PieGraph($size_y,$size_x,'auto');
	$graph->SetMarginColor($graph_color);
	$graph->title->Set($topic);
	$graph->subtitle->Set($sub_title);
	$graph->legend->Pos(0.05,0.05);
	$graph->legend->SetShadow('darkgray@0.5');
	$graph->legend->SetFillColor('lightblue@0.3');
	$graph->legend->SetFont(FF_ANGSANA,FS_NORMAL,18);
		if($graph_pic != ""){
	$graph->SetBackgroundImage($graph_pic,BGIMG_FILLFRAME);
	}
	$graph->title->SetFont(FF_ANGSANA,FS_BOLD,18);
	$graph->subtitle->SetFont(FF_ANGSANA,FS_NORMAL,18);
	
	//for($i=1;$i<($numrow_y+1);$i++){
			if($type=="Pie"){
				$y_colorpie = array_reverse($y_colorpie);
				$p1 = new PiePlot($y_datapie);
				
			}else if($type=="Pie3d"){
				$p1 = new PiePlot3d($y_datapie);
				$p1->SetAngle(30);
			}
			//$p1->SetTheme("sand");
			$p1->SetCenter(0.4);
			$p1->SetSliceColors($y_colorpie);
			
			$p1->value->SetFont(FF_ANGSANA,FS_NORMAL,18);
			$p1->SetLegends($y_titlepie);
			$p1->title->Set($x_title[0]);
			$p1->title->SetFont(FF_ANGSANA,FS_NORMAL,18);
			
			$graph->Add($p1);
			
			//print_r($y_datapie);
			//echo "<br>";
			//print_r($y_titlepie);
//	}
	
}
$graph->Stroke();

$db->db_close(); ?>
