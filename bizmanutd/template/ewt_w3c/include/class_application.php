<?php 
  class application {
  		
	  var $db;
	  var $disp;
	  var $th_today;
	  function application () {
          global $CLASS;
         $this->db     = $CLASS['db'];
		 $this->disp  = $CLASS['disp'];
		 //$this->th_today = $this->disp->get_date_time_patn (date("Y-m-d"),"d_th");
	  }

      function getTitileName ($tID) {
	      switch ($tID) {
		     case '1'; {
			      return 'นาง';
			 }
			 case '2'; {
			      return 'นางสาว';
			 }
			 case '3'; {
			      return 'นาย';
			 }
		  }//case
	  }	//End Function
	  

	  function getProvinceName ($pID) {
         return $this->db->get_data_field ("select province_name from province where province_id like '$pID'","province_name");
	  }
	    function getAmphurName ($pID,$aID) {
         return $this->db->get_data_field ("select amphur_name from amphur where province_id like '$pID' and amphur_id like '$aID'","amphur_name");
	  }
	   function getTambonName ($pID,$aID,$tID) {
         return $this->db->get_data_field ("select tambon_name from tambon where province_id like '$pID' and amphur_id like '$aID' and tambon_id like'$tID'","tambon_name");
	  }
	  function num_format($amount){
	  	return number_format($amount,2,'.',',');
	  }
	  function date_calendar_thai($date){
		$mdate=$this->disp->convert_date_to_show($date,0);
		if($mdate=='01/01/2443' || $mdate==NULL){ $mdate='';}
		return $mdate;
	  }
	  function next_pri_id($table,$pri_id_name){
	  		$sql_max="Select Max($pri_id_name) As max_pri_id From $table";
			$rec_max=$this->db->get_data_rec($sql_max);
			return $next_pri_id=$rec_max[max_pri_id]+1;
	  }
	  function next_step_id($table,$id_name,$where_next,$num_step){
	  		$sql_max="Select Max($id_name) As max_id From $table  $where_next";
			$rec_max=$this->db->get_data_rec($sql_max);
			return $next_id=$rec_max[max_id]+$num_step;
	  }
	function cal_age($month,$year){
		$age_year=$age_year1=date('Y')+543-$year;
		if($month<=date('m')){
			$age_month=date('m')-$month;
		}else{
			$age_month=12-$month+date('m');
			$age_year=$age_year1-1;
		}
	return  $age_year.'/'.$age_month;
	}

	function create_pk($t_name,$f_name,$year,$p_code, $f_name2="", $f_value2="" ){
		if(strlen($year)==4){
				$year=substr($year,2);
		}
		
		$filter = "";

		if($f_name2) {
				$filter .= " $f_name2 = '$f_value2' ";
		}

		if($filter) {
			$filter = " AND ".$filter;
		}

		$sql="SELECT MAX($f_name) AS MXCODE FROM $t_name WHERE ($f_name LIKE '$year$p_code%') $filter ";
		$exc_mxcode=$this->db->query($sql);
		$num_maxcode=$this->db->num_rows($exc_mxcode);

		if($num_maxcode>0){   // ถ้าเคยมีรหัสแล้ว ให้นับเลขต่อไป
				$mxcode=$this->db->fetch_array($exc_mxcode);

				$pkcode=$mxcode['MXCODE'];

				$pkcode=(substr($pkcode,4)*1)+1;  // เอาปีกับจังหวัดออก แล้วทำให้เป็นจำนวน +1
				
				if(strlen($pkcode)==1){
						$newcode="00000".$pkcode;
				}
				if(strlen($pkcode)==2){
						$newcode="0000".$pkcode;
				}
				if(strlen($pkcode)==3){
						$newcode="000".$pkcode;
				}
				if(strlen($pkcode)==4){
						$newcode="00".$pkcode;
				}
				if(strlen($pkcode)==5){
						$newcode="0".$pkcode;
				}

				$newcode=$year.$p_code.$newcode;
		}else{  // ยังไม่เคยมีรหัสนี้ เลยให้ เริ่มต้นเป็น 1
				$newcode=$year.$p_code."000001";
		} 

		return  $newcode;
	}
	
	function DelFileBeginName($TMPdir,$beginfname, $today_format="d-m-Y")
	{
			$today = date($today_format);
			$dir = opendir($TMPdir);

			while($file = readdir($dir))
			{
				 if(ereg($beginfname,$file))
				 {
					if(ereg($today,$file)==false)
						unlink($TMPdir.$file);
				 }
			}
	}
	
	function is_tag($tag_temp) {
			$tag_temp = ereg_replace("/","",trim($tag_temp));

			$sql_chk = " SELECT  tag_id, tag_name FROM  tag_info  WHERE  tag_name = '$tag_temp' ";
			$exec_chk = $this->db->query($sql_chk);
			$num_chk = $this->db->num_rows($exec_chk);
			if($num_chk) {
				return true;
			} else {
				return false;
			}

	}

	function tag_info($tag_name) {

			$tag_name = eregi_replace("/","",trim($tag_name));

			$sql_info = " SELECT  *  FROM  tag_info  WHERE  tag_name = '".trim($tag_name)."'  ";
			$exec_info = $this->db->query($sql_info);
			$rec_info = $this->db->fetch_array($exec_info);
			
			if(!$rec_info[section_id]) {
				$rec_info[section_id]=4;
			}
			return $rec_info;
	}
	
	function attr_info($attr_name) {
			$sql_info = " SELECT  *  FROM  attribute  WHERE  attribute_name = '".trim($attr_name)."'  ";
			$exec_info = $this->db->query($sql_info);
			$rec_info = $this->db->fetch_array($exec_info);
			return $rec_info;
	}
	
	function show_tag_attribute($text_id) {
				 // show รายละเอียด tag  และ attribute ของมัน
				 
				$sql_tag = " SELECT  *  FROM  web_tag  WHERE text_id = '$text_id'  ";
				$exec_tag = $this->db->query($sql_tag);
				$rec_tag=$this->db->fetch_array($exec_tag);

				$sql_atb = " SELECT  *  FROM  web_attr  WHERE text_id = '$text_id' 
																									ORDER BY text_attr_id ";
				$exec_atb = $this->db->query($sql_atb);
				$text_up_attr = "";
				while($rec_atb=$this->db->fetch_array($exec_atb)) {
						if($rec_atb[text_edit_value]) {
								$edit_attr = $rec_atb[text_edit_value];
						} else {
								$edit_attr = $rec_atb[text_attr_value];
						}
						if(trim($rec_atb[text_attr_name])) {
							$text_up_attr .= $rec_atb[text_attr_name]."=".$edit_attr." ";
						}
				}
			
			if($rec_tag[text_tag]) { 
					$tag_show ="<".$this->disp->convert_specials_char($rec_tag[text_tag])." ".$this->disp->convert_specials_char($text_up_attr).">".$rec_tag[text_value];
			} else {
					$tag_show = $rec_tag[text_value];
			}
			
			return $tag_show;
	}
	function convert_text_chars($text_value) {

			/*  ไม่ work เพราะ database อาจเป็น UTF-8 ทำให้ load character พิเศษมาเพี้ยนไป

			$sqlChar = " SELECT  *  FROM convert_special_char  ";																				
			$execChar = $this->db->query($sqlChar);
			while($recChar = $this->db->fetch_array($execChar)) {
					
					if(eregi("[".$recChar[special_char]."]",$text_value)) { 

						// เครื่องหมาย  มันไม่ใช่ - ทำให้งงว่าทำไม replace ไม่ได้อยู่ตั้งนาน
						echo "eregi_replace([".$recChar[special_char]."],".$recChar[w3c_char].",".$text_value.");"."<br>";
						$text_value = eregi_replace("[".$recChar[special_char]."]", $recChar[w3c_char], $text_value);
						echo "=> $text_value<br>";
					}
			}
			*/
			$text_value = eregi_replace("[“]", "&quot;", $text_value);
			$text_value = eregi_replace("[–]", "&ndash;", $text_value);

			return $text_value;
	}
} // End Class


?>
