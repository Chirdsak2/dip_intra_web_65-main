<?		function newfilename($dir) {
						//$dir = "/etc/php5/";
						$file_list = array();

						// Open a known directory, and proceed to read its contents
						if (is_dir($dir)) {
							if ($dh = opendir($dir)) {

								$i=0;
								while (($file = readdir($dh)) !== false) {
									//	echo "filename: $file : filetype: " . filetype($dir . $file) . "\n";
									if(is_file($file)) {
											$file_list[$i] = $file;
											$i++;
									}
								}
								closedir($dh);
							}
						}	
					if(count($file_list)>0) {
						$newfilename =	(max($file_list)*1)+1;
					} else {
						$newfilename = 1;
					}	
					return $newfilename;
			}
			function reversechar($str){
				$start =array("'", "\\", "\"");
				$end = array("&#039;", "", "");
				$value = str_replace($start,$end,$str);
				return $value;
			}
			function copyobject($size, $name, $temp, $prefix='', $url, $oldimage='', $specialfiletype=''){
				if($size>0){
					$arr = explode(".",$name);
					$number = count($arr);
					if($specialfiletype){
						$upper = strtoupper($specialfiletype);
						$lower = strtolower($specialfiletype);
						if($arr[$number-1]==$upper || $arr[$number-1]==$lower){
							$destination = $prefix.date('Ymdhis').".".$arr[$number-1];
							copy($temp, $url.$destination);
							@unlink($url.$oldimage);
						}else{
							$destination = $oldimage;
						}
					}else{
						$destination = $prefix.date('Ymdhis').".".$arr[$number-1];
						copy($temp, $url.$destination);
						@unlink($url.$oldimage);
					}
				}else{
					$destination = $oldimage;
				}
				return $destination;
			}
			function convert_month($month,$language){
				if($language=='longthai'){
					if($month=='01' || $month=='1'){
						$month = "มกราคม";
					}elseif($month=='02' || $month=='2'){
						$month = "กุมภาพันธ์";
					}elseif($month=='03' || $month=='3'){
						$month = "มีนาคม";
					}elseif($month=='04' || $month=='4'){
						$month = "เมษายน";
					}elseif($month=='05' || $month=='5'){
						$month = "พฤษภาคม";
					}elseif($month=='06' || $month=='6'){
						$month = "มิถุนายน";
					}elseif($month=='07' || $month=='7'){
						$month = "กรกฎาคม";
					}elseif($month=='08' || $month=='8'){
						$month = "สิงหาคม";
					}elseif($month=='09' || $month=='9'){
						$month = "กันยายน";
					}elseif($month=='10'){
						$month = "ตุลาคม";
					}elseif($month=='11'){
						$month = "พฤศจิกายน";
					}elseif($month=='12'){
						$month = "ธันวาคม";
					}
					return $month;
				}elseif($language=='shortthai'){
					if($month=='01' || $month=='1'){
						$month = "ม.ค.";
					}elseif($month=='02' || $month=='2'){
						$month = "ก.พ.";
					}elseif($month=='03' || $month=='3'){
						$month = "มี.ค.";
					}elseif($month=='04' || $month=='4'){
						$month = "เม.ย.";
					}elseif($month=='05' || $month=='5'){
						$month = "พ.ค.";
					}elseif($month=='06' || $month=='6'){
						$month = "มิ.ย.";
					}elseif($month=='07' || $month=='7'){
						$month = "ก.ค.";
					}elseif($month=='08' || $month=='8'){
						$month = "ส.ค.";
					}elseif($month=='09' || $month=='9'){
						$month = "ก.ย.";
					}elseif($month=='10'){
						$month = "ต.ค.";
					}elseif($month=='11'){
						$month = "พ.ย.";
					}elseif($month=='12'){
						$month = "ธ.ค.";
					}
					return $month;
				}elseif($language=='shorteng'){
					if($month=='01' || $month=='1'){
						$month = "Jan";
					}elseif($month=='02' || $month=='2'){
						$month = "Feb";
					}elseif($month=='03' || $month=='3'){
						$month = "Mar";
					}elseif($month=='04' || $month=='4'){
						$month = "Apr";
					}elseif($month=='05' || $month=='5'){
						$month = "May";
					}elseif($data[1]=='06' || $month=='6'){
						$month = "Jun";
					}elseif($month=='07' || $month=='7'){
						$month = "Jul";
					}elseif($month=='08' || $month=='8'){
						$month = "Aug";
					}elseif($month=='09' || $month=='9'){
						$month = "Sep";
					}elseif($month=='10'){
						$month = "Oct";
					}elseif($month=='11'){
						$month = "Nov";
					}elseif($month=='12'){
						$month = "Dec";
					}
					return $month;
				}elseif($language=='longeng'){
					if($month=='01'  || $month=='1'){
						$month = "January";
					}elseif($month=='02' || $month=='2'){
						$month = "February";
					}elseif($month=='03' || $month=='3'){
						$month = "March";
					}elseif($month=='04' || $month=='4'){
						$month = "April";
					}elseif($month=='05' || $month=='5'){
						$month = "May";
					}elseif($month=='06' || $month=='6'){
						$month = "June";
					}elseif($month=='07' || $month=='7'){
						$month = "July";
					}elseif($month=='08' || $month=='8'){
						$month = "August";
					}elseif($month=='09' || $month=='9'){
						$month = "September";
					}elseif($month=='10'){
						$month = "October";
					}elseif($month=='11'){
						$month = "November";
					}elseif($month=='12'){
						$month = "December";
					}
					return $month;
				}
				
		}
			
		function convert_date_int($date){
			$arr = explode("/",$date);
			$date = $arr[2].$arr[1].$arr[0];
			return $date;
		}
		function convert_int_date($integer){
			$year = substr($integer,0,4);
			$month = substr($integer,4,2);
			$day = substr($integer,6,2);
			$date = $day." ".convert_month($month,"shortthai")." ".$year;
			return $date;
		}
		function convert_int_date_texbox($integer){
			if($integer){
				$year = substr($integer,0,4);
				$month = substr($integer,4,2);
				$day = substr($integer,6,2);
				$date = $day."/".$month."/".$year;
			}
			return $date;
		}
		function convert_docflow_thai($integer){
			$year = substr($integer,0,4);
			$month = substr($integer,5,2);
			$day = substr($integer,8,2);
			$date = $day." ".convert_month($month,"shortthai")." ".$year;
			return $date;
		}
		function convert_thaifull($integer){
			if($integer!=''){
			$year = substr($integer,0,4);
			$month = substr($integer,4,2);
			$day = substr($integer,6,2)+0;
			$date = $day." ".convert_month($month,"longthai")." ".$year;
			}else{
			$date = "";
			}
			return $date;
		}
		function thAlpNum($str){   
			$a = explode('.',$str);
			// count_number
			$exp_n = explode(',',$a[0]);
			$num_n = count($exp_n); 
			for($i=0;$i<$num_n;$i++){ $n .= $exp_n[$i]; }    //for
			$count_alp = makeThAlpCount($n);
			// decimal
			$d = $a[1];  
			$dec_alp = thAlpDec($d);  
			return $result = $count_alp.$dec_alp;
		}  
		function thAlpCurrency2($str){  
			$a = explode('.',$str); 
			// count_number
			$exp_n = explode(',',$a[0]);
			$num_n = count($exp_n); 
			for($i=0;$i<$num_n;$i++){ $n .= $exp_n[$i]; }    //for 
			$count_alp = makeThAlpCount($n);
			// decimal
			$d = substr($a[1],0,2);  
			$d = substr($d+100,1,2);
			if($d=='00'){ $dec_alp = 'ถ้วน' ; } 
			else { $dec_alp  = thAlpNum($d).'สตางค์'; }  
			return $result = $count_alp.'บาท'.$dec_alp;
		}
		function makeThAlpCount($n){
			$len_n = strlen($n); 
			$rest = $len_n%6;
			$loop_n = (($len_n - $rest)/6 )+1;
			$str_start = 0;
			$sub_cut =  $rest;
			for($i=0;$i<$loop_n;$i++){  
				$sub_n = substr($n,$str_start,$sub_cut); 
				$str_start = ($i*6)+$sub_cut ;
				$sub_cut =  6;
				$count_alp_temp = thAlpCount($sub_n);
				if($i < $loop_n-1){ $count_alp_temp = $count_alp_temp ."ล้าน"; }
				$count_alp .= $count_alp_temp;
			}//for  
			return $count_alp;
		}
		function thAlpCount($n){
			$numTh  = array ("ศูนย์","หนึ่ง","สอง","สาม","สี่","ห้า","หก","เจ็ด","แปด","เก้า") ;
			$unit      = array ("หน่วย","สิบ","ร้อย","พัน","หมื่น","แสน","ล้าน"); 
			$len_n = strlen($n); 
			$thC=$result=$digit="";
			$pos = $len_n;
			for ($i=0;$i<$len_n;$i++)  {     
				$pos--;
				 $digit = substr($n,$i,1);
				if ($digit>0) { 
					if ($pos==0){
						if ($len_n >=2 &&  $digit==1) // ไม่อ่าน สิบหนึ่ง
							$numTh[$digit] = "เอ็ด";
						$thC = $numTh[$digit]; 
					}else{
						if ($pos ==1 && $digit ==2) // ไม่มี สองสิบ
							$numTh[$digit] = "ยี่";
						if ($pos ==1 && $digit ==1) // ไม่มี หนึ่งสิบ
							$numTh[$digit] = "";
					 $thC = $numTh[$digit].$unit[$pos];
					}
				} else{
					 $thC='';
				  }
				  $result .=$thC;
			   }//for
			   return $result;
		}
		function thAlpDec($d){
			$numTh  = array ("ศูนย์","หนึ่ง","สอง","สาม","สี่","ห้า","หก","เจ็ด","แปด","เก้า") ;
			$unit      = array ("หน่วย","สิบ","ร้อย","พัน","หมื่น","แสน","ล้าน"); 
			$len_d = strlen($d); 
			for($i=0;$i<$len_d;$i++){
				$dec_val = substr($d,$i,1);
				if($dec_alp){ $dec_alp .= $numTh[$dec_val];
				} else { $dec_alp = "จุด".$numTh[$dec_val]; 
				}// if_else
			}//for
			return $dec_alp;
		} 
		function convert_cle2ora($date){
			$arr = explode("/",$date);
			$date = $arr[2].'-'.$arr[1].'-'.$arr[0];
			return $date;
		}
		function convert_ora2cle($date){	
			$arr = explode("-",trim($date));
			$date = $arr[2].'/'.$arr[1].'/'.$arr[0];
			if($date=='//')$date='';
			return $date;		
		}
		function convert_ora2show($date){
			$date_f = explode(" ",trim($date));
			$arr = explode("-",trim($date_f[0]));
			$date = $arr[2].' '.convert_month($arr[1],"shortthai").' '.$arr[0];
			if($date=='//')$date='';
			return $date;		
		}
			function show_time($date){
			$date_f = explode(" ",trim($date));
			return $date_f[1];		
		}
		function convent_date_emp_to_int($date){
			$dateemp=explode(" ",$date);
            $this->mont_th_short = array ("ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
			$num = count($this->mont_th_short);
			for($i = 0 ; $i< $num;$i++){
				if($dateemp[1] == $this->mont_th_short[$i]){ 
					 $mont  = substr(101+$i,1); 
				}
			}// End For 
			$cdate=count($dateemp);
			$cdate=$cdate-1;
			$dateemp[$cdate]=$dateemp[$cdate]+543;
			return $dateemp[$cdate].$mont.$dateemp[0];
		}
		function show_date_emp_shortthai($date){
			$dateemp=explode(" ",$date);
			$cdate=count($dateemp);
			$cdate=$cdate-1;
			$dateemp[$cdate]=$dateemp[$cdate]+543;
			return number_format($dateemp[0])." ".trim($dateemp[1])." ".trim($dateemp[$cdate]);
		}
		function cal_emp_age($date){ //input date int 25501231
			$year = substr($date,0,4);
			$month = substr($date,4,2);
			$day = substr($date,6,2);
			$year=$year-543;
			$chkyear=date('Y');
			$chkmonth=date('m');
			$age=$chkyear-$year;
			if($chkmonth>=$day){$age = $age;}
			if($chkmonth<$day){$age = $age-1;}
			return $age;
		}
		function calculate_between_date($datestart, $dateend){
			$yearS = substr($datestart,0,4);
			$monthS = substr($datestart,4,2);
			$dayS = substr($datestart,6,2);

			$yearE = substr($dateend,0,4);
			$monthE = substr($dateend,4,2);
			$dayE = substr($dateend,6,2);
			
			for($y=$yearS;$y<=$yearE;$y++){
				if($y==$yearE){
					$str = $count+($monthE-1);
				}else{
					if($y==$yearS){
						$ms = $monthS;
					}else{
						$ms = "1";
					}
					if($y==$yearE){
						$me = $monthE;
					}else{
						$me = "12";
					}
					for($m=$ms;$m<=$me;$m++){
						$count = $count+1;
					}
				}
			}
			$number_Y = floor(($str/12));
			$number_M = ($str%12);
			$str = $number_Y."/".$number_M;
			return $str;
		}
//----------------------------------------------//
		function display_status($status){
			if($status=='1' || $status=='Y'){
				$txtstatus = "ใช้งาน";
			}elseif($status=='0' || $status=='N' || $status=='2'){
				$txtstatus = "<span class='alertred'>ไม่ใช้งาน</span>";
			}
			return $txtstatus;
		}

		function display_type($type){
			if($type=='1'){
				$txttype = "ส่วนกลาง";
			}elseif($type=='2'){
				$txttype= "ส่วนจังหวัด";
			}else{
				$txttype= "-";
			}
			return $txttype;
		}
		function display_type_car($type){
			if($type=='0'){
				$show_type = "รถบรรทุก (ดีเซล)";
			}else{
				$show_type = "รถจักรยานยนต์";
			}
			return $show_type;
		}
		function display_status_car($status){
			if($status=='1'){
				$show_status = "ใช้งาน";
			}else{
				$show_status = "ไม่ใช้งาน";
			}
			return $show_status;
		}

		function display_status_position_car($status){
			if($status=='1'){
				$show_status = "ใช้งาน";
			}else{
				$show_status = "ไม่ใช้งาน";
			}
			return $show_status;
		}
		

//---------------SaLary--------------------
		function salaryshow_status_ratedetail($sr){
			$ratedetail[0]="คงที่";
			$ratedetail[1]="ไม่คงที่ ปรับทุก 6 เดือน";
			return $ratedetail[$sr];
		}
		function display_status_carloan($status){
			if($status=='0'){
				$data = "ไม่อนุมัติ";
			}elseif($status=='1'){
				$data = "อนุมัติ";
			}elseif($status=='2'){
				$data = "รอส่ง";
			}elseif($status=='3'){
				$data = "รออนุมัติ";
			}
			return $data;
		}
		function display_status_insurranceloan($status){
			if($status=='0'){
				$data = "ไม่อนุมัติ";
			}elseif($status=='1'){
				$data = "อนุมัติ";
			}elseif($status=='2'){
				$data = "รอส่ง";
			}elseif($status=='3'){
				$data = "รออนุมัติ";
			}
			return $data;
		}
		function display_vehicle($id){
			if($id=='2'){
				$typedata = "รถจักรยานยนต์";
			}elseif($id=='1'){
				$typedata = "รถยนต์";
			}
			return $typedata;
		}
		function cut_date_month($date)
		{
			$day_month=substr($date,4,4);
			return $day_month;
		}
		function display_approve_loan($status){
			if($status==1){
				$approve="อนุมัติให้ยืม";
			}else{
				$approve="ไม่อนุมัติให้ยืม";
			}
			return $approve;
		}
		 function display_status_income_by_statusid($statusid){
			if($statusid=='1'){
				$text = "เงินเดือน";
			}elseif($statusid=='2'){
				$text = "ค่าเช่าบ้าน";
			}elseif($statusid=='3'){
				$text = "ค่าเบี้ยประชุม";
			}elseif($statusid=='4'){
				$text = "ค่า OT";
			}elseif($statusid=='5'){
				$text = "ค่าตอบแทนกรรมการ";
			}elseif($statusid=='6'){
				$text = "ค่าตอบแทนการใช้รถประจำตำแหน่ง";
			}elseif($statusid=='7'){
				$text = "ตกเบิก";
			}
			return $text;
		}
		function display_status_charity_by_statusid($statusid){
			if($statusid=='0'){
				$text = "ลาออก";
			}elseif($statusid=='1'){
				$text = "อนุมัติ";
			}elseif($statusid=='2'){
				$text = "รออนุมัติ";
			}elseif($statusid=='3'){
				$text = "รอส่ง";
			}
			return $text;
		}
		function display_spouse_by_spouseid($spouseid){
			if($spouseid=='1'){
				$text = "โสด";
			}elseif($spouseid=='2'){
				$text = "สมรส";
			}elseif($spouseid=='3'){
				$text = "หย่า";
			}
			return $text;
		}
		function display_typechangecharity_by_typeid($typeid){
			if($typeid=='1'){
				$text = "เปลี่ยนคำนำหน้า";
			}elseif($typeid=='2'){
				$text = "เปลี่ยนชื่อตัว";
			}elseif($typeid=='3'){
				$text = "เปลี่ยนนามสกุล";
			}elseif($typeid=='4'){
				$text = "เปลี่ยนอัตราเงินสะสม";
			}elseif($typeid=='5'){
				$text = "เปลี่ยนสถานภาพ";
			}elseif($typeid=='6'){
				$text = "เปลี่ยนผู้รับผลประโยชน์";
			}
			return $text;
		}
		function display_statuschangecharity_by_statusid($statusid){
			if($statusid=='0'){
				$text = "รออนุมัติ";
			}elseif($statusid=='1'){
				$text = "อนุมัติ";
			}
			return $text;
		}
		function display_staustransfer_by_wayid($wayid){
			if($wayid=='1'){
				$text = "เช็ค";
			}elseif($wayid=='2'){
				$text = "Direct Credit";
			}elseif($wayid=='3'){
				$text = "Smart Credit หรือ Media";
			}
			return $text;
		}
		function display_statushelpson_by_statusid($statusid){
			if($statusid=='0'){
				$text = "รอส่ง";
			}elseif($statusid=='1'){
				$text = "รออนุมัติ";
			}elseif($statusid=='2'){
				$text = "อนุมัติ";
			}elseif($statusid=='3'){
				$text = "ไม่อนุมัติ";
			}
			return $text;
		}
		function display_status_way_by_statusid($statusid){
			if($statusid=='1'){
				$text = "รับเงินสด";
			}elseif($statusid=='2'){
				$text = "ฝากออมสิน";
			}elseif($statusid=='3'){
				$text = "ATM - กรุงไทย";
			}
			return $text;
		}
		function display_doc_tax_by_docid($docid){
			if($docid=='1'){
				$text = "ค่าเบี้ยประชุม";
			}elseif($docid=='2'){
				$text = "ค่าตอบแทน";
			}
			return $text;
		}
//---------------SaLary--------------------
	 function set_option ($value,$name,$s)  {
			   $option_str = "<option value=\"".$value."\" $s>".$name."</option>";
			   print $option_str;
	  }
	 function ddw_list_month ($lang,$selected)	{
	     //print '<option>'.$selected;
		 $arr_mont_th = array ("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
		 $arr_mont_en =  array ("January","February","March","April","May","June","July","August","September","October","November","December"); 

          if ($lang=="th" || $lang=="en") {			    
				($lang=="th")?$mont=$arr_mont_th:$mont=$arr_mont_en;

				 for ($i=0;$i < sizeof($mont);$i++)
		       {       
			          $mont_value = $i+1;
			          if (strlen($mont_value) < 2)
				              $mont_value = "0".$mont_value;
							  
					 if ($mont_value==$selected)
			             $mSelected = 'selected';
			        else
			             $mSelected ='';
			   		  
                     set_option($mont_value,$mont[$i],$mSelected); 
		       }//end for
       	  }else { // number patern
               for ($i=1;$i <=12;$i++)
			  {
                  if (strlen($i) < 2)
					  $mont_value="0".$i;
				  else
                      $mont_value= $i;

                  set_option ($mont_value,$i,'');
			   }//end for
		  }		 		
	} // end function month

	function ddw_list_edulevel($selected) {
				  ?>				  
				  <option value="1" <? if($selected==1) echo "selected";?>>ปริญญาตรี</option>
				  <option value="2" <? if($selected==2) echo "selected";?>>ปริญญาโท</option>
				  <option value="3" <? if($selected==3) echo "selected";?>>ปริญญาเอก</option>
				  <option value="4" <? if($selected==4) echo "selected";?>>อนุบาล</option>
				  <option value="5" <? if($selected==5) echo "selected";?>>ประถม</option>
				  <option value="6" <? if($selected==6) echo "selected";?>>มัธยม</option>
				  <option value="7" <? if($selected==7) echo "selected";?>>ปวช-ปวส</option>
				  <option value="8" <? if($selected==8) echo "selected";?>>อุดมศึกษา</option>
				  <?
	 }
	function edulevel_name($selected) {
				 if($selected==1) $edulevel_name= "ปริญญาตรี";
				 if($selected==2) $edulevel_name= "ปริญญาโท";
				 if($selected==3) $edulevel_name= "ปริญญาเอก";
				 if($selected==4) $edulevel_name= "อนุบาล";
				 if($selected==5) $edulevel_name= "ประถม";
				 if($selected==6) $edulevel_name= "มัธยม";
				 if($selected==7) $edulevel_name= "ปวช-ปวส";
				 if($selected==8) $edulevel_name= "อุดมศึกษา";
				 return $edulevel_name;
	 }
	function not_number_format($value) {
			$out_value  = eregi_replace("(,)|( )","",$value);
			return $out_value; 
	}
	function retiredate($date_input){  //format yyyy-mm-dd 
		   $date_output=explode ("-",$date_input); 
		   $month=$date_output[1];
		   $date=$date_output[2];
		   $year=$date_output[0]+543;
		  // $date>1
		   if($month >10   ){
			$year=$year+61;
		   }else if($month==10 &&  $date>1 ){
			$year=$year+ 61 ;
		   }else {
			$year=$year+60;
			}   
			return $year;
  }
  function convert_qoute_to_db($str) {		
		return	htmlspecialchars($str, ENT_QUOTES);	 // แปลง ' ให้เป็น &#039;
  }
  function convert_qoute_to_show($str) {
		return html_entity_decode($str, ENT_QUOTES);	 // แปลง &#039; กลับมาเป็น ' 
  }
  function convert_to_float($number){
		return number_format($number, 2, '.', '');
  }
  function id_card_to_array($idcardno) {
		  $arr_idcard = array();
		  if(eregi("-",$idcardno)) {
				$arr_idcard = explode("-",$idcardno);
		  } else {
				$arr_idcard[0] = substr($idcardno,0,1);
				$arr_idcard[1] = substr($idcardno,1,4);
				$arr_idcard[2] = substr($idcardno,5,5);
				$arr_idcard[3] = substr($idcardno,10,2);
				$arr_idcard[4] = substr($idcardno,12,1);
		 }
		return $arr_idcard;
  }
  function create_address($arr_address, $outputType='', $text_pdf='') {  // outputType ถ้าเป็น 1 เอาแค่ ตำบล อำเภอ จังหวัด																									
		if($text_pdf) {
			$space_bar = ' ';
		} else {
			$space_bar = '&nbsp;&nbsp;';
		}
		if(!$outputType) {
				if($arr_address["add_no"]) {
					if(!eregi("เลขที่^",$arr_address["add_no"]) && !eregi("บ้านเลขที่^",$arr_address["add_no"]) ) {
							$address_text .= "เลขที่ ".$arr_address["add_no"];
					} else {
							$address_text .= $space_bar.$arr_address["add_no"];
					}
				}
				if($arr_address["moo"]) {
					if(!eregi("หมู่^",$arr_address["moo"]) ) {
							$address_text .= $space_bar."หมู่".$arr_address["moo"];
					} else {
							$address_text .= $space_bar.$arr_address["moo"];
					}
				}
				if($arr_address["soi"]) {
					if(!eregi("ซอย^",$arr_address["soi"]) && !eregi("ซ.^",$arr_address["soi"])  ) {
							$address_text .= $space_bar."ซ.".$arr_address["soi"];
					} else {
							$address_text .= $space_bar.$arr_address["soi"];
					}
				}
				if($arr_address["road"]) {
					if(!eregi("ถนน^",$arr_address["road"]) && !eregi("ถ.^",$arr_address["road"])  ) {
							$address_text .= $space_bar."ถ.".$arr_address["road"];
					} else {
							$address_text .= $space_bar.$arr_address["road"];
					}
				}
		} // end if !$outputType													
			if(eregi("(กรุงเทพ)|(กทม)", $arr_address["province_name"]) ) {	// ถ้าเป็น  กทม.
					if($arr_address["tambon_name"]) {
							if(!eregi("แขวง^",$arr_address["tambon_name"]) && !eregi("ตำบล^",$arr_address["tambon_name"]) && !eregi("ต.^",$arr_address["tambon_name"]) ) {
								$address_text .= $space_bar."แขวง".$arr_address["tambon_name"];
							} else {
								$address_text .= $space_bar.$arr_address["tambon_name"];
							}
					}
					if($arr_address["amphur_name"]) {
							if(!eregi("เขต^",$arr_address["amphur_name"]) && !eregi("อำเภอ^",$arr_address["amphur_name"]) && !eregi("อ.^",$arr_address["amphur_name"]) ) {
								$address_text .= $space_bar."เขต".$arr_address["amphur_name"];
							} else {
								$address_text .= $space_bar.$arr_address["amphur_name"];
							}
					}
					if($arr_address["province_name"]) {						
							$address_text .= $space_bar.$arr_address["province_name"];							
					}										
			} else { 			
					if($arr_address["tambon_name"]) {
							if(!eregi("ตำบล^",$arr_address["tambon_name"]) && !eregi("ต.^",$arr_address["tambon_name"]) ) {
								$address_text .= $space_bar."ต.".$arr_address["tambon_name"];
							} else {
								$address_text .= $space_bar.$arr_address["tambon_name"];
							}
					}
					if($arr_address["amphur_name"]) {
							if(!eregi("อำเภอ^",$arr_address["amphur_name"]) && !eregi("อ.^",$arr_address["amphur_name"]) ) {
								$address_text .= $space_bar."อ.".$arr_address["amphur_name"];
							} else {
								$address_text .= $space_bar.$arr_address["amphur_name"];
							}
					}		
					if($arr_address["province_name"]) {
						if( !eregi("จังหวัด^",$arr_address["province_name"]) && !eregi("จ.^",$arr_address["province_name"]) ) {				
							$address_text .= $space_bar."จ. ".$arr_address["province_name"];	
						} else {
							$address_text .= $space_bar.$arr_address["province_name"];
						}
					}
			}
			if(!$outputType) {
				if($arr_address["zipcode"]) {
						$address_text .= $space_bar.$arr_address["zipcode"];
				}
			}
			return $address_text;
  }
  function ddw_list_year($start_year, $end_year, $type_value=0, $type_show=1, $selected_value=0 ) { // 0 คือ ค.ศ. 1 คือ พ.ศ.
		 for($yy=$start_year;$yy<=$end_year;$yy++) { 
				if($type_value) {
					$value = $yy+543;
				} else {
					$value = $yy;
				}
				if($type_show) {
					$show = $yy+543;
				} else {
					$show = $yy;
				}
				if($value==$selected_value) {
						$set_selected = "selected";
				} else {
						$set_selected = "";
				}
				echo "<option value=\"".$value."\" ".$set_selected." >".$show."</option>";
					
		 }
  }

function DateDiff($date1,$date2,$interval='d', $noHoliday=0) { // require  date input as dd/mm/yyyy  พ.ศ.	 
			//$date_format = $this->DATE_FORMAT;
			//$date_type = $this->YEAR_FORMAT;
						
			if(!empty($date1)) {
				if( strlen($date1) >= 8 && eregi("[0-9]", $date1) ) {
									
						$arr_date1 = explode("/",$date1);							
						$dd1 = $arr_date1[0];
						$mm1 = $arr_date1[1];
						$yy1 = $arr_date1[2];							
					$yy1-=543; //  ปรับปีจาก พ.ศ. -> ค.ศ.
				}
			}
			if(!empty($date2)) {
				if( strlen($date2) >= 8 && eregi("[0-9]", $date2) ) {
									
						$arr_date2 = explode("/",$date2);							
						$dd2 = $arr_date2[0];
						$mm2 = $arr_date2[1];
						$yy2 = $arr_date2[2];							
					$yy2-=543; //  ปรับปีจาก พ.ศ. -> ค.ศ.
				}
			}
				//  ************ถ้าปี ค.ศ. เกิน 2500 มันจะ error
				
				//echo "$dd2,$mm2,$yy2 - $dd1,$mm1,$yy1<br>";
				//exit;
			   if($arr_date1 && $arr_date2) {
			   		// get the number of seconds between the two dates 
					$timedifference = mktime(0,0,0,$mm2,$dd2,$yy2)-mktime(0,0,0,$mm1,$dd1,$yy1);
					//echo "$date2 - $date1 ห่างกัน $timedifference วินาที<BR>";
					switch ($interval) {
						case 'w':
							$retval = bcdiv($timedifference,604800); //week
							break;
						case 'd':						
							$retval = floor($timedifference/86400);											
							break;
						case 'h':
							$retval =bcdiv($timedifference,3600); //hour
							break;
						case 'n':
							$retval = bcdiv($timedifference,60); //minute
							break;
						case 's':
							$retval = $timedifference; //second
							break;							
					}
				}				
				if(!$retval) $retval=0;				
				return $retval;
		
}


  /*
* written by Piti Ongmongkolkul
* January 15, 2006
* Copyright 2006 Piti Ongmongkolkul. All rights reserved.
*/

//helper function takes in a positive integer and return
//Thai text for that number
$bahttext_reading=array(
1=>array('','เอ็ด','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า'),
2=>array('','สิบ','ยี่สิบ','สามสิบ','สี่สิบ','ห้าสิบ','หกสิบ','เจ็ดสิบ','แปดสิบ','เก้าสิบ'),
3=>array('','หนึ่งร้อย','สองร้อย','สามร้อย','สี่ร้อย','ห้าร้อย','หกร้อย','เจ็ดร้อย','แปดร้อย','เก้าร้อย'),
4=>array('','หนึ่งพัน','สองพัน','สามพัน','สี่พัน','ห้าพัน','หกพัน','เจ็ดพัน','แปดพัน','เก้าพัน'),
5=>array('','หนึ่งหมื่น','สองหมื่น','สามหมื่น','สี่หมื่น','ห้าหมื่น','หกหมื่น','เจ็ดหมื่น','แปดหมื่น','เก้าหมื่น'),
6=>array('','หนึ่งแสน','สองแสน','สามแสน','สี่แสน','ห้าแสน','หกแสน','เจ็ดแสน','แปดแสน','เก้าแสน')
);

function integerToThai($number){
//trail off all the zero at the beginning
$number=ltrim($number,' 0');
if($number==''){
return 'ศูนย์';
}
if($number=='1'){
return 'หนึ่ง';
}
//it is easier to work in an inverted one
$number=strrev($number);
return millionToThaiHelper($number,'',true);
}

//a helper function that takes care of > million number
function millionToThaiHelper($rnumber,$sofar,$first){
if(strcmp($rnumber,'1')==0){
if($first){return 'หนึ่ง'.$sofar;}
else{return 'หนึ่งล้าน'.$sofar;}
}
else{
if(strlen($rnumber)>6){
if($first){
return millionToThaiHelper(substr($rnumber,6),integerToThaiHelper($rnumber,1,'').$sofar,false);
}
else{
return millionToThaiHelper(substr($rnumber,6),integerToThaiHelper($rnumber,1,'').'ล้าน'.$sofar,false);
}
}
else{
if($first){
return integerToThaiHelper($rnumber,1,'').$sofar;
}
else{
return integerToThaiHelper($rnumber,1,'').'ล้าน'.$sofar;
} 
}
}
}

// the same as integer to Thai but this guy can do only up to 10^6-1
// this function takes in an reversed number that is
// one hundred is represented by 001
// digit represents current working digit.
// tail recursion implementation
// if the number is more than million it will return แค่หลักแสน
function integerToThaiHelper($rnumber,$digit,$sofar){

if($digit>6){
return $sofar;
}
if($rnumber==''){
return '';
}
else{
global $bahttext_reading;
//echo $rnumber.' '.$sofar.' '.substr($rnumber,0,1).' '.$reading[$digit][$rnumber[0]].'<br>';
if(strlen($rnumber)==1){
return $bahttext_reading[$digit][$rnumber].$sofar;
}
else{
return integerToThaiHelper(substr($rnumber,1),($digit+1),$bahttext_reading[$digit][substr($rnumber,0,1)].$sofar);
}
}
}

//convert numeric string to thai reading in baht
//warning bahtText('2345678234234273784723894.234324342') (with quotes)
//is not the same as bahtText(2345678234234273784723894.234324342) because
//php round the number.
//If you wish to use this function with a large number call it with quotes
function thAlpCurrency($number){
//echo	$number;
/*if(!is_numeric($number) || $number < 0){
die('bahtText error: the argument is not a valid positive number');
}*/
if(is_float($number)){//for weird formats such as 2E5
//echo 'float';
$whole = floor($number);
$decimal = round(($number-$whole)*100);
}
else{
$temp = explode('.',$number);
if(count($temp)==1){
$whole=$temp[0];
$decimal=0;
}
else{
$whole=$temp[0];
$length=strlen($temp[1]);
if($length>2){
$decimal.='0';
$decimal=substr($temp[1],0,3);
$decimal=round($decimal/(10.0));
}
else if($length==2){
$decimal=$temp[1]; 
}//0.5 ==> ห้าสิบสตางค์
else{
$decimal=$temp[1].'0';
}
}
}
if($decimal==0){
return integerToThai($whole).'บาทถ้วน';
}
else{
if($whole!=0){
return integerToThai($whole).'บาท'.integerToThai($decimal).'สตางค์';}
else{
return integerToThai($decimal).'สตางค์';
}
}
}

function day_of_month($christ_year,$due_month) { // จำนวนวันในเดือน นั้น ปี นั้น 
		if($due_month==4  ||  $due_month==6  ||  $due_month==9  ||  $due_month==11){
											$day_end=30;
		}else if($due_month==2){
				if(($christ_year%4)==0){
						$day_end=29;
				}else{
						$day_end=28;
				}
		}else{
				$day_end=31;
		}
		return $day_end;
}
function day_of_year($christ_year) {
	if(($christ_year%4)==0){
				$day_year=366;
	} else {
				$day_year=365;
	}
	return $day_year;
}
function testvar_infile($var, $filename,$wtype='w'){

			$handle = fopen($filename,$wtype);
			$pass_result = fwrite($handle,$var); // ,65535
			fclose($handle);

			return $pass_result;
}

function show_icon_pass($result, $strpath="") {
		 if($result) { echo "<img src=\"".$strpath."images/pass.gif\" border=\"0\" alt=\"สำเร็จ\" align=\"absmiddle\" >"; }
		 else {  // echo "ต้องแก้โดย Editor"; 
		 echo "<img src=\"".$strpath."images/notpass.gif\" border=\"0\" alt=\"ไม่สำเร็จ\" align=\"absmiddle\" >"; } 
}
function convert_specials_char($str_in) {
			$str_in = ereg_replace("&quot;",'"',$str_in);
			$str_in = ereg_replace("&#039;","'",$str_in);
			$str_in = ereg_replace("&amp;",'&',$str_in);
			$str_in = ereg_replace("&lt;",'<',$str_in);
			$str_in = ereg_replace("&gt;",'>',$str_in);

			return $str_in;
}
?>
