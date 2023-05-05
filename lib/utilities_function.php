<?php
function date_display($datestr,$OldFormat,$NewFormat){
		if($datestr!=''){
				  $month_FEN=",January,February,March,April,May,June,July,August,September,October,November,Dectember";
				  $month_SEN=",Jan,Feb,Mar,Apr,May,Jun,Jul,Aug,Sep,Oct,Nov,Dec";
				  $month_FTH=",มกราคม,กุมภาพันธ์,มีนาคม,เมษายน,พฤษภาคม,มิถุนายน,กรกฎาคม,สิงหาคม,กันยายน,ตุลาคม,พฤศจิกายน,ธันวาคม";
				  $month_STH=",ม.ค.,ก.พ.,มี.ค.,เม.ย.,พ.ค.,มิ.ย.,ก.ค.,ส.ค.,ก.ย.,ต.ค.,พ.ย.,ธ.ค.";
				  
				   if($OldFormat=='YmdHis'){
					   $y=substr($datestr,0,4);
					   $m=substr($datestr,4,2);
					   $d=substr($datestr,6,2);
					   $h=substr($datestr,8,2);
					   $i=substr($datestr,10,2);
					   $s=substr($datestr,12,2);
				   }
				   
				   switch($NewFormat){
				      case 'DT1Eng' :   // 31-01-2009 (12:40:59)
						     return $d.'-'.$m.'-'.$y.' ('.$h.':'.$i.':'.$s.')';
				      case 'DT2Eng' :   // 31/01/2009 (12:40:59)
						     return $d.'/'.$m.'/'.$y.' ('.$h.':'.$i.':'.$s.')';
				      case 'DT3Eng' :   // 31 Jan 2009 (12:40:59)
						     $month=explode(',',$month_SEN);
					         return $d.' '.$month[$m*1].' '.$y.' ('.$h.':'.$i.':'.$s.')';
				      case 'DT4Eng' :   // 31 January 2009 (12:40:59)
						     $month=explode(',',$month_FEN);
					         return $d.' '.$month[$m*1].'. '.$y.' ('.$h.':'.$i.':'.$s.')';

                      case 'DT1Th' :   // 31-01-2009 (12:40:59)
						     return $d.'-'.$m.'-'.($y+543).' ('.$h.':'.$i.':'.$s.')';
				      case 'DT2Th' :   // 31/01/2009 (12:40:59)
						     return $d.'/'.$m.'/'.($y+543).' ('.$h.':'.$i.':'.$s.')';
				      case 'DT3Th' :   // 31 ม.ค. 2552 (12:40:59)
						     $month=explode(',',$month_STH);
					         return $d.' '.$month[$m*1].' '.($y+543).' ('.$h.':'.$i.':'.$s.')';
				      case 'DT4Th' :   // 31 มกราคม 2552 (12:40:59)
						     $month=explode(',',$month_FTH);
					         return $d.' '.$month[$m*1].' '.($y+543).' ('.$h.':'.$i.':'.$s.')';

				      case 'D1Eng' :   // 31-01-2009
						     return $d.'-'.$m.'-'.$y;
				      case 'D2Eng' :   // 31/01/2009
						     return $d.'/'.$m.'/'.$y;
				      case 'D3Eng' :   // 31 Jan 2009
						     $month=explode(',',$month_SEN);
					         return $d.' '.$month[$m*1].' '.$y;
				      case 'D4Eng' :   // 31 January 2009
						     $month=explode(',',$month_FEN);
					         return $d.' '.$month[$m*1].' '.$y;

                      case 'D1Th' :   // 31-01-2009
						     return $d.'-'.$m.'-'.($y+543);
				      case 'D2Th' :   // 31/01/2009
						     return $d.'/'.$m.'/'.($y+543);
				      case 'D3Th' :   // 31 ม.ค. 2552
						     $month=explode(',',$month_STH);
					         return $d.' '.$month[$m*1].' '.($y+543);
				      case 'D4Th' :   // 31 มกราคม 2552
						     $month=explode(',',$month_FTH);
					         return $d.' '.$month[$m*1].' '.($y+543);
					   

				   }
		   }else{
		      return '-';
		   }
}
?>
