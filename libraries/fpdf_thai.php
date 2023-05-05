<?php
/********************************************************************************
* Software	:	FPDF Version Thai															*
* Version		:	1.20																					*
* Date			:	2005-12-24																		*
* Referen		:   www.fpdf.org																	*
* License		:  Freeware																			*
*																												*
* You may use, modify and redistribute this software as you wish.			*
*********************************************************************************/

require('fpdf.php');

class FPDF_TH extends FPDF
{
var $txt_error;	
var $pointX;
var $pointY;
function FPDF_TH($orientation='P',$unit='mm',$format='A4')
{	
	$this->FPDF($orientation,$unit,$format);
}

function MultiTCell($w,$h,$txt,$border=0,$align='J',$fill=0)
{
	//Output text with automatic or explicit line breaks
	$cw=&$this->CurrentFont['cw'];
	if($w==0)
		$w=$this->w-$this->rMargin-$this->x;
	$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
	$s=str_replace("\r",'',$txt);
	$nb=strlen($s);
	if($nb>0 && $s[$nb-1]=="\n")
		$nb--;
	$b=0;
	if($border)
	{
		if($border==1)
		{
			$border='LTRB';
			$b='LRT';
			$b2='LR';
		}
		else
		{
			$b2='';
			if(strpos($border,'L')!==false)
				$b2.='L';
			if(strpos($border,'R')!==false)
				$b2.='R';
			$b=(strpos($border,'T')!==false) ? $b2.'T' : $b2;
		}
	}
	$sep=-1;
	$i=0;
	$j=0;
	$l=0;
	$ns=0;
	$nl=1;
	while($i<$nb)
	{
		//Get next character
		$c=$s{$i};
		if($c=="\n")
		{
			//Explicit line break
			if($this->ws>0)
			{
				$this->ws=0;
				$this->_out('0 Tw');
			}
			$this->TCell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
			$i++;
			$sep=-1;
			$j=$i;
			$l=0;
			$ns=0;
			$nl++;
			if($border && $nl==2)
				$b=$b2;
			continue;
		}
		if($c==' ')
		{
			$sep=$i;
			$ls=$l;
			$ns++;
		}
		$l+=$cw[$c];
		if($l>$wmax)
		{
			//Automatic line break
			if($sep==-1)
			{
				if($i==$j)
					$i++;
				if($this->ws>0)
				{
					$this->ws=0;
					$this->_out('0 Tw');
				}
				$this->TCell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
			}
			else
			{
				if($align=='J')
				{
					$this->ws=($ns>1) ? ($wmax-$ls)/1000*$this->FontSize/($ns-1) : 0;
					$this->_out(sprintf('%.3f Tw',$this->ws*$this->k));
				}
				$this->TCell($w,$h,substr($s,$j,$sep-$j),$b,2,$align,$fill);
				$i=$sep+1;
			}
			$sep=-1;
			$j=$i;
			$l=0;
			$ns=0;
			$nl++;
			if($border && $nl==2)
				$b=$b2;
		}
		else
			$i++;
	}
	//Last chunk
	if($this->ws>0)
	{
		$this->ws=0;
		$this->_out('0 Tw');
	}
	if($border && strpos($border,'B')!==false)
		$b.='B';
	$this->TCell($w,$h,substr($s,$j,$i-$j),$b,2,$align,$fill);
	$this->x=$this->lMargin;
}

function TCell($w,$h=0,$txt='',$border=0,$ln=0,$align='',$fill=0,$link='')
{
	//Output a cell					//ผลลัพธ์เซลล์
	$tWidth=$this->GetStringWidth($txt);
	$k=$this->k;
	if($this->y+$h>$this->PageBreakTrigger && !$this->InFooter && $this->AcceptPageBreak())
	{
		//Automatic page break			//หยุดหน้าอัตโนมัต
		$x=$this->x;
		$ws=$this->ws;
		if($ws>0)
		{
			$this->ws=0;
			$this->_out('0 Tw');
		}
		$this->AddPage($this->CurOrientation);
		$this->x=$x;
		if($ws>0)
		{
			$this->ws=$ws;
			$this->_out(sprintf('%.3f Tw',$ws*$k));
		}
	}
	if($w==0)
		$w=$this->w-$this->rMargin-$this->x;
	$s='';
	if($fill==1 || $border==1)
	{
		if($fill==1)
			$op=($border==1) ? 'B' : 'f';
		else
			$op='S';
		$s=sprintf('%.2f %.2f %.2f %.2f re %s ',$this->x*$k,($this->h-$this->y)*$k,$w*$k,-$h*$k,$op);
	}
	
	if(is_string($border))
	{
		$x=$this->x;
		$y=$this->y;
		if(strpos($border,'L')!==false)
			$s.=sprintf('%.2f %.2f m %.2f %.2f l S ',$x*$k,($this->h-$y)*$k,$x*$k,($this->h-($y+$h))*$k);
		if(strpos($border,'T')!==false)
			$s.=sprintf('%.2f %.2f m %.2f %.2f l S ',$x*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-$y)*$k);
		if(strpos($border,'R')!==false)
			$s.=sprintf('%.2f %.2f m %.2f %.2f l S ',($x+$w)*$k,($this->h-$y)*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
		if(strpos($border,'B')!==false)
			$s.=sprintf('%.2f %.2f m %.2f %.2f l S ',$x*$k,($this->h-($y+$h))*$k,($x+$w)*$k,($this->h-($y+$h))*$k);
	}

	if($s)
		$this->_out($s);
	$s='';

	if($txt!=='')
	{			
		//ตัดอักษรออกจากข้อความ ทีละตัว
		$x=$this->x;
		$y=$this->y;
		$array_th=substr($txt,0);
		$i=0;

		while($i<=strlen($txt))
		{	//กำหนดตำแหน่งข้อความในเซลล์
			if(strpos($align,'R')!==false)
				$dx=$w-$this->cMargin-$this->GetStringWidth($txt);
			elseif(strpos($align,'C')!==false)
				$dx=($w-$this->GetStringWidth($txt))/2;
			else
				$dx=$this->cMargin;

			if(strpos($align,'T')!==false)
				$dy=$h-(.7*$this->k*$this->FontSize);
			elseif(strpos($align,'B')!==false)
				$dy=$h-(.3*$this->k*$this->FontSize);
			else
				$dy=.5*$h;

			$this->pointX=($x+$dx+.02*$this->GetStringWidth($array_th[$i-1]))*$k;
			$this->pointY=($this->h-($y+$dy+.3*$this->FontSize))*$k;
	
			$this->_checkT($array_th,$i,$s);

			if($array_th[$i]=='{'&&$array_th[$i+1]=='n'&&$array_th[$i+2]=='b'&&$array_th[$i+3]=='}')
				$i=$i+3;
			$x=$x+$this->GetStringWidth($array_th[$i]);		//เลื่อนตำแหน่ง x ไปที่ตัวที่จะพิมพ์ถัดไป
			$i++;
		}

	}
	else
		$this->_out($s);

	$this->lasth=$h;
	if($ln>0)
	{
		//ขึ้นบรรทัดใหม่
		$this->y+=$h;
		if($ln==1)
			$this->x=$this->lMargin;
	}
	else
		$this->x+=$w;
}

function TText($txt_th,$s)
{	//พิมพ์อักษรตามตำแหน่งที่ถูกแก้ไขแล้ว
	if($this->ColorFlag)
		$s.='q '.$this->TextColor.' ';
	$txt_th2=str_replace(')','\\)',str_replace('(','\\(',str_replace('\\','\\\\',$txt_th)));
	$s.=sprintf('BT %.2f %.2f Td (%s) Tj ET',$this->pointX,$this->pointY,$txt_th2);
	if($this->underline)
		$s.=' '.$this->_dounderline($this->pointX,$this->pointY,$txt_th);
	if($this->ColorFlag)
		$s.=' Q';
	if($link)
		$this->Link($this->pointX,$this->pointY,$this->GetStringWidth($txt_th),$this->FontSize,$link);
	if($s)
		$this->_out($s);
}

function _checkT($array_th,$i,$s)
{   //ตรวจสอบความผิดพลาดการแสดงผลภาษาไทย
		if($this->_errorTh($array_th[$i])==1)							//การแสดงผลอักขระเหนือสระบน
		{
			if(($this->_errorTh($array_th[$i-1])!=2)&&($array_th[$i+1]!="ำ"))					//ตัวก่อนหน้านั้นไม่ใช่สระบน	
				if($array_th[$i]=="์")												//ตัวนั้นเป็นการันต์
					$this->pointY=$this->pointY-.17*$this->FontSize*$this->k;
				elseif($array_th[$i]=="่"||$array_th[$i]=="๋")						//ตัวนั้นเป็นการันต์
					$this->pointY=$this->pointY-.2*$this->FontSize*$this->k;
				else
					$this->pointY=$this->pointY-.23*$this->FontSize*$this->k;
			
			if($this->_errorTh($array_th[$i-1])==3)						//ตัวก่อนหน้านั้นเป็นอักขระหางยาวบน
				if($array_th[$i]=="์")												//ตัวนั้นเป็นการันต์
					$this->pointX=$this->pointX-.4*$this->GetStringWidth($array_th[$i-1])*$this->k;
				elseif($array_th[$i]=="่"||$array_th[$i]=="๋")
					$this->pointX=$this->pointX-.17*$this->GetStringWidth($array_th[$i-1])*$this->k;
				else
					$this->pointX=$this->pointX-.25*$this->GetStringWidth($array_th[$i-1])*$this->k;

				if($this->_errorTh($array_th[$i-2])==3)					//ตัวก่อนหน้านั้นไปอีกเป็นอักขระหางยาวบน	
				{
					if($array_th[$i]=="์")											//ตัวนั้นเป็นการันต์
						$this->pointX=$this->pointX-.4*$this->GetStringWidth($array_th[$i-2])*$this->k;
					elseif($array_th[$i]=="่"||$array_th[$i]=="๋")
						$this->pointX=$this->pointX-.17*$this->GetStringWidth($array_th[$i-2])*$this->k;
					else
						$this->pointX=$this->pointX-.25*$this->GetStringWidth($array_th[$i-2])*$this->k;
				}
		}																						//จบการแสดงผลอักขระเหนือสระบน

		elseif($this->_errorTh($array_th[$i])==2)					//การแสดงผลอักขระสระบน
		{
			if($this->_errorTh($array_th[$i-1])==3)						//ตัวก่อนหน้านั้นไปอีกเป็นอักขระหางยาวบน
				$this->pointX=$this->pointX-.17*$this->GetStringWidth($array_th[$i-1])*$this->k;
			if($array_th[$i]=="ำ")													//ตัวนั้นเป็นสระอำ
				if($this->_errorTh($array_th[$i-2])==3)					//ตัวก่อนหน้านั้นเป็นอักขระหางยาวบน
					$this->pointX=$this->pointX-.17*$this->GetStringWidth($array_th[$i-2])*$this->k;
		}																						//จบการแสดงผลอักขระสระบน

		elseif($this->_errorTh($array_th[$i])==6)					//การแสดงผลอักขระสระล่าง
		{
			if($this->_errorTh($array_th[$i-1])==4)							//ตัวก่อนหน้านั้นเป็นอักขระ ฏ. กับ ฎ.
				$this->pointY=$this->pointY-.25*$this->FontSize*$this->k;

			elseif($this->_errorTh($array_th[$i-1])==5)						//ตัวก่อนหน้านั้นเป็นอักขระ ญ. กับ ฐ.
			{	
				$this->FillColor=sprintf('%.3f %.3f %.3f rg',255,255,255);
				$this->_out($this->FillColor);
				$z.=$s.sprintf('%.2f %.2f %.2f %.2f re f ',$this->pointX-$this->GetStringWidth($array_th[$i-1])*$this->k,$this->pointY-.27*$this->FontSize*$this->k,.9*$this->GetStringWidth($array_th[$i-1])*$this->k,.25*$this->FontSize*$this->k);
				$this->TText($array_th[$i],$z);

				$this->FillColor=sprintf('%.3f %.3f %.3f rg',0,0,0);
				$this->_out($this->FillColor);
				//$this->pointY=$curl;
				//$this->TText($array_th[$i],$s);
			}

		}																						//จบการแสดงผลอักขระสระล่าง
		
		//กรณีที่เป็นการแสดงหน้าทั้งหมด
		if($array_th[$i]=='{'&&$array_th[$i+1]=='n'&&$array_th[$i+2]=='b'&&$array_th[$i+3]=='}')
			$this->TText('{nb}',$s);
		else
			$this->TText($array_th[$i],$s);
		//$this->x=$this->pointX;
}

function _errorTh($char_th)
{	//เช็คอักขระที่อาจจะทำให้เกิดการผิดพลาด
	$txt_error=0;
	if(($char_th=='่')||($char_th=='้')||($char_th=='๊')||($char_th=='๋')||($char_th=='์'))
		$txt_error=1;
	elseif(($char_th=='ิ')||($char_th=='ี')||($char_th=='ึ')||($char_th=='ื')||($char_th=='็')||($char_th=='ั')||($char_th=='ำ'))
		$txt_error=2;
	elseif(($char_th=='ป')||($char_th=='ฟ')||($char_th=='ฝ'))
		$txt_error=3;
	elseif(($char_th=='ฎ')||($char_th=='ฏ'))
		$txt_error=4;
	elseif(($char_th=='ญ')||($char_th=='ฐ'))
		$txt_error=5;
	elseif(($char_th=='ุ')||($char_th=='ู'))
		$txt_error=6;
	else
		$txt_error=0;
	return $txt_error;
}

function SetThaiFont(){
			$this->AddFont('AngsanaNew','','angsa.php');
			$this->AddFont('AngsanaNew','B','angsab.php');
			$this->AddFont('AngsanaNew','I','angsai.php');
			$this->AddFont('AngsanaNew','IB','angsaz.php');
			$this->AddFont('CordiaNew','','cordia.php');
			$this->AddFont('CordiaNew','B','cordiab.php');
			$this->AddFont('CordiaNew','I','cordiai.php');
			$this->AddFont('CordiaNew','IB','cordiaz.php');
			$this->AddFont('Tahoma','','tahoma.php');
			$this->AddFont('Tahoma','B','tahomab.php');
			$this->AddFont('BrowalliaNew','','browa.php');
			$this->AddFont('BrowalliaNew','B','browab.php');
			$this->AddFont('BrowalliaNew','I','browai.php');
			$this->AddFont('BrowalliaNew','IB','browaz.php');
			$this->AddFont('KoHmu','','kohmu.php');
			$this->AddFont('KoHmu2','','kohmu2.php');
			$this->AddFont('KoHmu3','','kohmu3.php');
			$this->AddFont('MicrosoftSansSerif','','micross.php');
			$this->AddFont('PLE_Cara','','plecara.php');
			$this->AddFont('PLE_Care','','plecare.php');
			$this->AddFont('PLE_Care','B','plecareb.php');
			$this->AddFont('PLE_Joy','','plejoy.php');
			$this->AddFont('PLE_Tom','','pletom.php');
			$this->AddFont('PLE_Tom','B','pletomb.php');
			$this->AddFont('PLE_TomOutline','','pletomo.php');
			$this->AddFont('PLE_TomWide','','pletomw.php');
			$this->AddFont('DilleniaUPC','','dill.php');
			$this->AddFont('DilleniaUPC','B','dillb.php');
			$this->AddFont('DilleniaUPC','I','dilli.php');
			$this->AddFont('DilleniaUPC','IB','dillz.php');
			$this->AddFont('EucrosiaUPC','','eucro.php');
			$this->AddFont('EucrosiaUPC','B','eucrob.php');
			$this->AddFont('EucrosiaUPC','I','eucroi.php');
			$this->AddFont('EucrosiaUPC','IB','eucroz.php');
			$this->AddFont('FreesiaUPC','','free.php');
			$this->AddFont('FreesiaUPC','B','freeb.php');
			$this->AddFont('FreesiaUPC','I','freei.php');
			$this->AddFont('FreesiaUPC','IB','freez.php');
			$this->AddFont('IrisUPC','','iris.php');
			$this->AddFont('IrisUPC','B','irisb.php');
			$this->AddFont('IrisUPC','I','irisi.php');
			$this->AddFont('IrisUPC','IB','irisz.php');
			$this->AddFont('JasmineUPC','','jasm.php');
			$this->AddFont('JasmineUPC','B','jasmb.php');
			$this->AddFont('JasmineUPC','I','jasmi.php');
			$this->AddFont('JasmineUPC','IB','jasmz.php');
			$this->AddFont('KodchiangUPC','','kodc.php');
			$this->AddFont('KodchiangUPC','B','kodc.php');
			$this->AddFont('KodchiangUPC','I','kodci.php');
			$this->AddFont('KodchiangUPC','IB','kodcz.php');
			$this->AddFont('LilyUPC','','lily.php');
			$this->AddFont('LilyUPC','B','lilyb.php');
			$this->AddFont('LilyUPC','I','lilyi.php');
			$this->AddFont('LilyUPC','IB','lilyz.php');
		}

function WriteHTML($html)
	{
		//HTML parser
		$html=str_replace("\n",' ',$html);
		$a=preg_split('/<(.*)>/U',$html,-1,PREG_SPLIT_DELIM_CAPTURE);
		foreach($a as $i=>$e)
		{
			if($i%2==0)
			{
				//Text
				if($this->HREF)
					$this->PutLink($this->HREF,$e);
				else
					$this->Write(5,$e);
			}
			else
			{
				//Tag
				if($e{0}=='/')
					$this->CloseTag(strtoupper(substr($e,1)));
				else
				{
					//Extract attributes
					$a2=explode(' ',$e);
					$tag=strtoupper(array_shift($a2));
					$attr=array();
					foreach($a2 as $v)
						if(ereg('^([^=]*)=["\']?([^"\']*)["\']?$',$v,$a3))
							$attr[strtoupper($a3[1])]=$a3[2];
					$this->OpenTag($tag,$attr);
				}
			}
		}
	}

	function OpenTag($tag,$attr)
	{
		//Opening tag
		if($tag=='B' or $tag=='I' or $tag=='U')
			$this->SetStyle($tag,true);
		if($tag=='A')
			$this->HREF=$attr['HREF'];
		if($tag=='BR')
			$this->Ln(5);
	}

	function CloseTag($tag)
	{
		//Closing tag
		if($tag=='B' or $tag=='I' or $tag=='U')
			$this->SetStyle($tag,false);
		if($tag=='A')
			$this->HREF='';
	}

	function SetStyle($tag,$enable)
	{
		//Modify style and select corresponding font
		$this->$tag+=($enable ? 1 : -1);
		$style='';
		foreach(array('B','I','U') as $s)
			if($this->$s>0)
				$style.=$s;
		$this->SetFont('',$style);
	}

//End of class
}


?>
