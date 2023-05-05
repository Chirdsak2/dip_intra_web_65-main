<?php

class PDF_MC_Table extends ThaiPDF
{
var $widths;
var $aligns;

var $str_date;

function SetWidths($w)
{
	//Set the array of column widths
	$this->widths=$w;
}

function SetAligns($a)
{
	//Set the array of column alignments
	$this->aligns=$a; 
}

function RowH($data,$h)
{
	//Calculate the height of the row
	$nb=0;
	for($i=0;$i<count($data);$i++)
		$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
	//$h=5*$nb;
	//Issue a page break first if needed
	$this->CheckPageBreak($h);
	//Draw the cells of the row
	for($i=0;$i<count($data);$i++)
	{
		$w=$this->widths[$i];
		$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
		//Save the current position
		$x=$this->GetX();
		$y=$this->GetY();
		//Draw the border
		$this->Rect($x,$y,$w,$h);
		//Print the text
		$this->MultiCell($w,5,$data[$i],0,$a);
		//Put the position to the right of the cell
		$this->SetXY($x+$w,$y);
	}
	//Go to the next line
	$this->Ln($h);
}

function Height($data)
{
	//Calculate the height of the row
	$nb=0;
	for($i=0;$i<count($data);$i++)
		$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
	$h=5*$nb;
	//Issue a page break first if needed
	$this->CheckPageBreak($h);
	//Draw the cells of the row
	for($i=0;$i<count($data);$i++)
	{
		//$w=$this->widths[$i];
		$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
		//Save the current position
		$x=$this->GetX();
		$y=$this->GetY();
		//Draw the border
		$this->Rect($x,$y,$w,$h);
		//Print the text
		//$this->MultiCell($w,5,$data[$i],0,$a);
		//Put the position to the right of the cell
		$this->SetXY($x+$w,$y);
	}
	//Go to the next line
	//$this->Ln($h);
	return $h;
}

function Row($data)
{
	//Calculate the height of the row
	$nb=0;
	for($i=0;$i<count($data);$i++)
		$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
	$h=9*$nb;
	//Issue a page break first if needed
	$this->CheckPageBreak($h);
	//Draw the cells of the row
	for($i=0;$i<count($data);$i++)
	{
		$w=$this->widths[$i];
		$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
		//Save the current position
		$x=$this->GetX();
		$y=$this->GetY();
		//Draw the border
		$this->Rect($x,$y,$w,$h);
		//Print the text
		$this->MultiCell($w,8,$data[$i],0,$a);
		//Put the position to the right of the cell
		$this->SetXY($x+$w,$y);
	}
	//Go to the next line
	$this->Ln($h);
}

function CheckPageBreak($h)
{
	//If the height h would cause an overflow, add a new page immediately
	if($this->GetY()+$h>$this->PageBreakTrigger){
		//$this->AddPage($this->CurOrientation);
		//$this->report_wb_header();
	}
}

function NbLines($w,$txt)
{
	//Computes the number of lines a MultiCell of width w will take
	$cw=&$this->CurrentFont['cw'];
	if($w==0)
		$w=$this->w-$this->rMargin-$this->x;
	$wmax=($w-2*$this->cMargin)*750/$this->FontSize;
	$s=str_replace("\r",'',$txt);
	$nb=strlen($s);
	if($nb>0 and $s[$nb-1]=="\n")
		$nb--;
	$sep=-1;
	$i=0;
	$j=0;
	$l=0;
	$nl=1;
	while($i<$nb)
	{
		$c=$s[$i];
		if($c=="\n")
		{
			$i++;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
			continue;
		}
		if($c==' ')
			$sep=$i;
		$l+=$cw[$c];
		if($l>$wmax)
		{
			if($sep==-1)
			{
				if($i==$j)
					$i++;
			}
			else
				$i=$sep+1;
			$sep=-1;
			$j=$i;
			$l=0;
			$nl++;
		}
		else
			$i++;
	}
	return $nl;
}



function report_wb_header(){
	global $start_date,$end_date,$group,$date_name;
	$tops=0;
	$h_top=20;
	$h_vspace=8;
	$h_size=14;
	$this->AddPage();
	$this->SetFont('CordiaNew','B',$h_size);
    $this->SetXY(150,$h_top);  $this->Cell('','',('รายงานจำนวนคำถามเพิ่มเติม หมวด :'.$group));
	
	$h_top+=$h_vspace;
	$this->SetFont('CordiaNew','',$h_size);
    $this->SetXY(200,$h_top);  $this->Cell('','',($this->str_date));


	$h_top+=$h_vspace;
	$this->SetFont('CordiaNew','B',$h_size);
    $this->SetXY(20,$h_top);  $this->Cell('','',('หน่วยงานที่รับผิดชอบ คือ '));
	$this->SetFont('CordiaNew','',$h_size);
    $this->SetXY(70,$h_top);  $this->Cell('','',('ศูนย์สารสนเทศ'));
	
	$h_top+=$h_vspace;
	$this->SetFont('CordiaNew','B',$h_size);
    $this->SetXY(20,$h_top);  $this->Cell('','',($date_name));

    $h_top+=$h_vspace;
	$this->SetXY(20,$h_top);
	$this->SetWidths(array(15,199,35));
	$this->SetAligns(array('C','C','C'));
	$this->Row(array("(1)\nลำดับที่","\nเรื่อง","(2)\nจำนวนคำถามเพิ่มเติม"));
	$this->x=20;
	$this->y=$h_top+27;
	
	$this->SetFont('CordiaNew','',12);
	$this->SetAligns(array('C','L','C'));
	//return $h_top+27;
}


}
?>
