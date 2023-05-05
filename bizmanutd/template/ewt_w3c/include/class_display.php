<?php
class display
{
	var $db='';
	var $tb_display='';
	var $str_field_id = '';
	var $mont= array ();
	var $page='';
	var $error='';
	var $lang='';
	 var $SID='';
	var $DATE_FORMAT='';
	var $YEAR_FORMAT='';
	var 	$bahttext_reading=array(
			1=>array('','เอ็ด','สอง','สาม','สี่','ห้า','หก','เจ็ด','แปด','เก้า'),
			2=>array('','สิบ','ยี่สิบ','สามสิบ','สี่สิบ','ห้าสิบ','หกสิบ','เจ็ดสิบ','แปดสิบ','เก้าสิบ'),
			3=>array('','หนึ่งร้อย','สองร้อย','สามร้อย','สี่ร้อย','ห้าร้อย','หกร้อย','เจ็ดร้อย','แปดร้อย','เก้าร้อย'),
			4=>array('','หนึ่งพัน','สองพัน','สามพัน','สี่พัน','ห้าพัน','หกพัน','เจ็ดพัน','แปดพัน','เก้าพัน'),
			5=>array('','หนึ่งหมื่น','สองหมื่น','สามหมื่น','สี่หมื่น','ห้าหมื่น','หกหมื่น','เจ็ดหมื่น','แปดหมื่น','เก้าหมื่น'),
			6=>array('','หนึ่งแสน','สองแสน','สามแสน','สี่แสน','ห้าแสน','หกแสน','เจ็ดแสน','แปดแสน','เก้าแสน')
			);
  function display ()
	{
		    global $CLASS,$PAGE,$SID;
		    $this->db = $CLASS["db"];
		    $this->tb_display = "disp_tb";
              if (isset($CLASS["error"]))
		        $this->error = $CLASS["error"];
             isset ($CLASS["lang"]) ? $this->lang = $CLASS["lang"] : '';
	        $this->mont_en =  array ("January","February","March","April","May","June","July","August","September","October","November","December"); 
			$this->mont_en_short =  array ("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"); 
			$this->mont_th = array ("มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม");
            $this->mont_th_short = array ("ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย.","ก.ค.","ส.ค.","ก.ย.","ต.ค.","พ.ย.","ธ.ค.");
			$this->str_field_id = "type_page_id";
		    $this->page = $PAGE;
			$this->SID = $SID;
				if (empty($this->page)){
		              $this->page=1;
	           }
			$this->DATE_FORMAT =  'dd/mm/yyyy';
			$this->YEAR_FORMAT = 2; // เก็บเป็น ค.ศ.    

		
    }

  function ddw_list_selected ($sql_str,$f_name,$f_value,$select_value)
  {
	  $this->db->query ($sql_str);
	   while ($this->db->fetch_array($this->db->result))
	  {
          if ($this->db->record[$f_value] == $select_value)
			   $str_selected = "selected";
		  else
               $str_selected = ""; 
		  print "<option value='".$this->db->record[$f_value]."'".$str_selected.">".$this->db->record[$f_name]."</option>";
	  }
  }


  function delay_goto ($url,$time,$mode) { // Time secound unit
       print   "<script>";
	   print   "       function delay_goto () {";
	   print    "                setTimeout(\"goto()\",$time)";
       print    "       }";
       print    "       function goto() {";
	  if ($mode=="_self")
		    print    "         self.mainFrame.location.href='$url';";
	   if ($mode=="_self1")
		    print    "         self.location.href='$url';";
		   if ($mode=="_parent")
		    print    "         parent.mainFrame.location.href='$url';";
	    if ($mode=="_parent1")
		    print    "         parent.location.href='$url';";
		  if ($mode=="_blank")
		    print    "         opener.parent.location.href='$url';";
	   print    "       }";
	   print    "</script>";
   }

 function ddw_list_date ($selected)
  {
	  for ($date=1;$date<32;$date++)
	  {
		   if (strlen($date) < 2)
			   $date_value = "0".$date;
		   else
			   $date_value = $date;
			   
			if ($date==$selected)
			   $dSelected = 'selected';
			 else
			   $dSelected ='';
			   
		    print "<option value='$date_value' $dSelected >$date</option>";
	  }
   }

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
				
				 	 if ($mont_value==$selected)
			             $mSelected = 'selected';
			        else
			             $mSelected ='';

                  set_option ($mont_value,$i,$mSelected);
			   }//end for
		  }		 		
	} // end function ddw_list_month

	

	function ddw_list_year_se_vth ($y_start,$y_end,$lang,$selected,$lang_show='th')
	{
		if ($lang == "th")
			$dif_year = 543;
		else
			$dif_year = 0;

		if ($lang_show == "th")
			$dif_year_show = 543;
		else
			$dif_year_show = 0;
			
		 $c_year = $y_start;

		 for ($yy=$y_start;$yy<=$y_end;$yy++)
		{  			 			 
		   if ($selected== $yy)	
			    $ySelected = 'selected';
		  else
			   $ySelected ='';
			   
			  print "<option value=\"".($yy + $dif_year)."\" $ySelected >".($yy + $dif_year_show)."</option>";
		} 
	}

	
function ctrl_page_design ($sql,$page_size,$txt_colr,$link_colr,$char_sub,$link_value) {
      $totalpage= $this->find_totalpage ($sql,$page_size);
				if ($totalpage > 1) {
					for($i=1 ; $i<$this->page ; $i++) 
						{
							echo "<a href='$PHP_SELF?page_size=$page_size&PAGE=$i$link_value'><font color=$link_colr>$i</font></a> $char_sub ";
						}

					        echo "<font color=$txt_colr><b>".$this->page."</b></font> $char_sub ";
					for($i=$this->page+1 ; $i<=$totalpage ; $i++) 
						{
							echo "<a href='$PHP_SELF?page_size=$page_size&PAGE=$i$link_value'><font color=$link_colr>$i</font></a> $char_sub ";
						} 
						  if (($this->page != $totalpage) && ($totalpage !=0)){
						    $next_page = $this->page+1;
						    print "<a href='$PHP_SELF?page_size=$page_size&PAGE=$next_page$link_value'><font color='$link_colr'> หน้าต่อไป&gt; </font></a>";
						   }
					    }
					}

function ctrl_page_design_limit_show ($sql,$page_show,$page_size,$txt_colr,$link_colr,$char_sub,$link_value) {
	global $startPage,$endPage;
     $totalpage= $this->find_totalpage ($sql,$page_size);
	  if ($page_show >= $totalpage)
		    $page_show=$totalpage;
		   if ($this->page==1){
                $startPage = 1;
			    $endPage = $page_show;
		   }else if ($this->page == $endPage && $this->page != $totalpage)  {
              $startPage = $this->page;
			  $endPage  +=($page_show-1); 
			  if ($endPage > $totalpage)
				      $endPage = $totalpage;
			}else if ($this->page < $startPage) {
				$endPage = $startPage;
				$startPage = ($endPage-$page_show)+1;
			}

     $link_value .="&startPage=$startPage&endPage=$endPage";
      if ($this->page != 1){ // Prvious
						    $prev_page = $this->page-1;
						    $ctrlPage.= "<a href='$PHP_SELF?page_size=$page_size&PAGE=$prev_page$link_value'><font color='$link_colr'>&lt;&lt;  </font></a>";
						   }
				if ($totalpage > 1) {
					for($i=$startPage ; $i<$this->page ; $i++) 
						{
							$ctrlPage.= "<a href='$PHP_SELF?page_size=$page_size&PAGE=$i$link_value'><font color=$link_colr>$i</font></a> $char_sub ";
						}

					        $ctrlPage.= "<font color=$txt_colr><b>".$this->page."</b></font> $char_sub ";
				
					for($i=$this->page+1 ; $i<=$endPage ; $i++) 
						{
							$ctrlPage.= "<a href='$PHP_SELF?page_size=$page_size&PAGE=$i$link_value'><font color=$link_colr>$i</font></a> $char_sub ";
						} 
						  if (($this->page != $totalpage) && ($totalpage !=0)){
						    $next_page = $this->page+1;
						    $ctrlPage.= "<a href='$PHP_SELF?page_size=$page_size&PAGE=$next_page$link_value'><font color='$link_colr'>&gt;&gt;</font></a>";
						   }
					    }
						return $ctrlPage;
					}

function ctrl_page_design_limit_show_mssql ($tbName,$page_show,$page_size,$txt_colr,$link_colr,$char_sub,$link_value) {
   $sql = "select * from $tbName ";
   return $this->ctrl_page_design_limit_show ($sql,$page_show,$page_size,$txt_colr,$link_colr,$char_sub,$link_value);
}

function ctrl_page_design_limit_show_mssql_cond ($tbName,$join,$cond,$page_show,$page_size,$txt_colr,$link_colr,$char_sub,$link_value) {
   $sql = "select * from $tbName $join where $cond";
   return $this->ctrl_page_design_limit_show ($sql,$page_show,$page_size,$txt_colr,$link_colr,$char_sub,$link_value);
}

function find_totalpage ($sql_str,$page_size) {
 $rows = $this->db->num_rows($this->db->query($sql_str));
  $rt = $rows%$page_size;	// หาจำนวนหน้าทั้งหมด
     if($rt!=0) 
		{ 
			$totalpage = floor($rows/$page_size)+1; 
		}
	else 
		{
			$totalpage = floor($rows/$page_size); 
		}
		return $totalpage;
	}

	function get_current_time_th ()
    {
		   $date = (date ("d")*1);
		   $mont_num = (date("n")-1);
		   $mont = $this->mont_th[$mont_num];
		   $year = (date("Y")+543);

		   return $date." ".$mont." ".$year;
	}
	function get_current_time_en ()
    {
		   $date = (date ("d")*1);
		   $mont_num = (date("n")-1);
		   $mont = $this->mont_en_sh[$mont_num];
		   $year = (date("Y"));
		   $time = (date(" H:i "));

		   return $date."-".$mont."-".$year."  ".$time;
	}
  function get_current_th ()
    {
		   $date = (date ("d"));
		   $mont= (date("m"));
		   $year = (date("Y")+543);

		   return $date."/".$mont."/".$year;
	}
	function substr_disp ($str,$limit_str)
	{
         if (strlen($str) > $limit_str)
		          return  substr($str,0,$limit_str)."..."; 
		 else
			     return $str;
	}

	function set_tag_script ($commd)
    {
		  print "<script>";
          print $commd;
		  print "</script>";
	}

	
function date_patn() {
 $date = date ("Y-m-d");
  return $date; 
}
	function get_date_th ($date_input)
    {
		   $date=substr($date_input,8,2);
		   $mont_num=(substr($date_input,5,2)-1);
		   $mont = $this->mont_th_short[$mont_num];
		   $year_en=substr($date_input,0,4);
           $year=$year_en+543;

		   return $date." ".$mont." ".$year;
	}

	function get_date_en ($date_input)
    {
		   $date=substr($date_input,8,2);
		   $mont_num=(substr($date_input,5,2)-1);
		   $mont = $this->mont_en_sh[$mont_num];
		   $year=substr($date_input,0,4);

		   return $date." ".$mont." ".$year;
	}

function chg_date ($date_input)
    {
	 $arr_date = explode ("/",$date_input); 
     $date = $arr_date[0];
	 $mont = $arr_date[1];
	 $year_th = $arr_date[2];
	 $year = $year_th-543;
		   return $year."-".$mont."-".$date;
	}	
	function ConvertDate($date_in, $srver="mysql" ) {
		if(strlen($date_in) >= 8 && ereg("/", $date_in) ) {
			if($srver!='N') {
				$date_out = explode ("/", $date_in);
				if($srver=="mssql") 
					$date_out = ($date_out[2]-543)."/".$date_out[0]."/".$date_out[1];		
				else if($srver=="mysql")
					$date_out = $date_out[2]."/".$date_out[1]."/".$date_out[0];		
			} else 
			$date_out = $date_in;
		} else {
			if($srver=="mssql") 
				$date_out = '';
			else if($srver=="mysql")
				$date_out = '0000-00-00';
			else 
				$date_out = $date_in;
		}
		return $date_out;
	}
	function ShowDate($date_in) { // mysql format
	
		if(strlen($date_in) == 10 && ereg("-", $date_in) && $date_in != "0000-00-00" ) {
			$date_out = explode ("-", $date_in);
			$date_out = $date_out[2]."/".$date_out[1]."/".$date_out[0];
		} else {
			$date_out = '-';
		}
			return $date_out;
	}
	 function chg_date_th ($date_input)
    {
		   $date = substr($date_input,8,2);
		   $mont= substr($date_input,5,2);
		   $year_en = substr($date_input,0,4);
		   $year=$year_en+543;

		   return $date."/".$mont."/".$year;
	}
	function chg_int($num) { 
		     // Exe. $num = 200.30 
       $decimal=strchr($num,'.');  //$decimal = .30
     //  $decimal = substr($decimal_1,1,2);
      if ($decimal != "") {
              $num = strrev($num); //$num 03.002
              $num=strchr($num,'.');//$num .002
              $num=strrev($num);
	      }

     $numleng = strlen($num);
     $i = 0;
      while ($i < $numleng) {
            $str = substr($num,$i,1);
	    if (ereg("[0-9]",$str)) {
                 $newnum =$newnum.$str;              
	      }
	        $i++;
	     }
	     if ($decimal !=""){
	            $newnum = $newnum.$decimal;
		 }
	      return $newnum;
	}
	
function del_slashes ($str) {
$char="\\";
$result = strchr ($str,$char);
while ($result != "") {
      $str=stripslashes($str);
      $result = strchr ($str,$char); 
         }
return $str;
}
 	function get_date_time_patn ($date_time,$str_patn) // Specail $str_patn "d_th_short"= 21 ก.ย. 2456,"dt_th_short"= 21 ก.ย. 2456 11:59:59
    {   
       
		 $dtm = split (" ",$date_time,2);
		 $sub_date = split ("-",$dtm[0],3);
      
	       // ---------------------------------------
		   $pdate = $dtm[0];
		   $ptime = $dtm[1];
           // ---------------------------------------
            $date =  ($sub_date[2])*1;
		    $mont = ($sub_date[1])*1;
		    $year =  ($sub_date[0])*1;
		    //-----------------------------------------
	
		switch ($str_patn) {
				case 'd_th_short' ; {
				       return $date." ".$this->mont_th_short[$mont-1]." ".substr(($year+543),2,2);
					   break;
				}
               case 'dt_th_short'; {
                       return $date." ".$this->mont_th_short[$mont-1]." ".($year+543)." ".$ptime;
					   break;
			   }
			   case 'd_th' ; {
				       return $date." ".$this->mont_th[$mont-1]." ".($year+543);
					   break;
				}
               case 'dt_th'; {
                       return $date." ".$this->mont_th[$mont-1]." ".($year+543)." ".$ptime;
					   break;
			   }
			   case 'd_en_short' ; {
				       return $date." ".$this->mont_en_short[$mont-1]." ".($year);
					   break;
				}
               case 'dt_en_short'; {
                       return $date." ".$this->mont_en_short[$mont-1]." ".($year)." ".$ptime;
					   break;
			   }
			   default ;{
				      if (!empty($dtm[1]))
					{  
							$sub_time = split (":",$dtm[1],3);
							return date ($str_patn,mktime($sub_time[0],$sub_time[1],$sub_time[2],$sub_date[1],$sub_date[2],$sub_date[0]));
					}
					 else
					 {
							return date ($str_patn,mktime(23,59,59,$sub_date[1],$sub_date[2],$sub_date[0]));
					  }
			   }// Case default 
		  }//Switch
	}// function

	 function include_js_file ($js_file) {
		 print "<script language=\"JavaScript\" src=\"".$js_file."\" type=\"text/JavaScript\"></script>";
	}
   function limit_img_size ($img_file,$width_limit,$height_limit) {
        $img_size = getimagesize ($img_file);
         
		if (!empty($width_limit)) {
			 if ($img_size[0] > $width_limit)
				    $img_size[0] = $width_limit;
		}

		if (!empty($height_limit)) {
			 if ($img_size[1] > $height_limit)
				    $img_size[1] = $height_limit;
		}

		return $img_size;
   }

   function get_img_prop ($imgFile,$path_img) {
     
	   $imgSize = getimagesize ($path_img.$imgFile);

	   $sizeX = $imgSize[0];
	   $sizeY = $imgSize[1];	
       if(strval($sizeX != "" OR $sizeY != "")) 
			$dimesion = "$sizeX x $sizeY"; 
		else 
			$dimesion = "Unknown"; 

		$fsize = filesize($path_img.$imgFile);

		         if(strval($fsize >= "1024"))  {
			          $fsize = round($fsize/1024); 
					  $fsize = $fsize. "Kb"; 
				 }else
				     $fsize = $fsize. " "; 

				 $prop[0] = $dimesion;
				 $prop[1] = $fsize;

				 return $prop;
   }

   function resizeImg ($imgFile,$widthLimit,$heightLimit,$path_img) {

	      $imgSize = getimagesize ($path_img.$imgFile);
          if ($imgSize[0] > $imgSize[1]) // Width > Height
		       $mul = $widthLimit/$imgSize[0];
          else 
               $mul = $heightLimit/$imgSize[1];
         
		  $imgSize[0] = $imgSize[0]*$mul;
		  $imgSize[1] = $imgSize[1]*$mul;

		 return $imgSize;  
   }

function thCurrency_basic ($str) { // version is limit less than num=9999999,ไม่มี สตางค์
	    $numTh = array ("ศูยน์","หนึ่ง","สอง","สาม","สี่","ห้า","หก","เจ็ด","แปด","เก้า");
		$unit      = array ("หน่วย","สิบ","ร้อย","พัน","หมื่น","แสน","ล้าน"); 
		$strlen = strlen($str);
		$thC=$result=$digit="";
		$pos = $strlen;
		  for ($i=0;$i<$strlen;$i++)
          {     $pos--;
		         $digit = substr($str,$i,1);
				 if ($digit>0) {
				      if ($pos==0){
						if ($strlen>=2 &&  $digit==1) // ไม่อ่าน สิบหนึ่ง
							$numTh[$digit] = "เอ็ด";
						    $thC = $numTh[$digit]; 
                      }else{
					     if ($pos==1 && $digit==2) // ไม่มี สองสิบ
						   $numTh[$digit] = "ยี่";
                         if ($pos==1 && $digit==1) // ไม่มี หนึ่งสิบ
                           $numTh[$digit] = "";
					       $thC = $numTh[$digit].$unit[$pos];
					 }
			  }else{
			     $thC='';
			  }
			  $result .=$thC;
	       }//for
		   return $result;
    }

	function thCurrency_decimal ($str) { // Require thCurrency_basic มีสตางค์
	  $str = number_format($str,2,'.','');
	  $strlen     = strlen ($str);
	  $decimal = strstr($str,".");// Find decimal

        if (!empty($decimal)){  // found decimal
				 $strlen -= strlen($decimal); 
				 if (strlen($decimal) <=2)
                     $footerString = "สิบสตางค์";
				 else
                     $footerString = "สตางค์";
				 $thDecimal = $this->thCurrency_basic (substr($decimal,1,2)).$footerString;
        }
          if (empty($decimal) || $decimal==".00")   
               $thDecimal="ถ้วน";
		
				return $this->thCurrency_basic (substr($str,0,$strlen)).'บาท'.$thDecimal;
  }

function  genjava_ddwlist1call2 ($sql,$fieldGrp,$fieldTxt,$fieldValue,$ddwlistNum,$showFunc,$firstField) {
		 //Use in page : onchange="selectChange(this, form1.sale_id, arrItemsTxt,arrItemsValue ,arrItemsGrp);"
		 $nl = "\n"; // New line
         echo '<SCRIPT LANGUAGE="JavaScript">'.$nl;
         echo '<!-- Begin '.$nl;
		 echo 'var arrItemsTxt'.$ddwlistNum.' = new Array();'.$nl;
		 echo 'var arrItemsValue'.$ddwlistNum.' = new Array();'.$nl;
		 echo 'var arrItemsGrp'.$ddwlistNum.' = new Array();'.$nl.$nl;
         //Create variable
		  $query         = $this->db->query ($sql);
		  $numRows  = $this->db->num_rows ($query);
          for ($i=0;$i < $numRows;$i++) {
          $result = $this->db->fetch_array ($query);
          echo 'arrItemsGrp'.$ddwlistNum.'['.$i.'] = "'.$result[$fieldGrp].'";'.$nl;
          echo 'arrItemsTxt'.$ddwlistNum.'['.$i.'] = "'.$result[$fieldTxt].'";'.$nl;
          echo 'arrItemsValue'.$ddwlistNum.'['.$i.'] = "'.$result[$fieldValue].'";'.$nl;
		  }//for
		 // Java function
		 if ($showFunc=='Y') {
         echo $nl.'function selectChange(control, controlToPopulate, ItemArrayTxt,ItemArrayValue, GroupArray,selectedValue)'.$nl;
         echo '{'.$nl;
         echo 'var myEle ;'.$nl;
         echo 'var x ;'.$nl;
         echo '// Empty the second drop down box of any choices'.$nl;
		 echo 'for (var q=controlToPopulate.options.length;q>=0;q--) controlToPopulate.options[q]=null;'.$nl;
         echo '// ADD Default Choice - in case there are no values'.$nl;
         echo 'myEle = document.createElement("option") ;'.$nl;
		
		 if (!empty($firstField)) {
			  echo 'myEle.value="";'.$nl;
			  echo 'myEle.text="'.$firstField.'";'.$nl;
			  echo 'controlToPopulate.add(myEle) ;'.$nl;
		 }
		 echo 'for ( x = 0 ; x < ItemArrayTxt.length  ; x++ )'.$nl;
         echo   '{'.$nl;
         echo '    if ( GroupArray[x] == control.value)'.$nl;
         echo '   {'.$nl;
         echo 'myEle = document.createElement("option") ;'.$nl;
         echo ' myEle.text = ItemArrayTxt[x] ;'.$nl;
		 echo ' myEle.value= ItemArrayValue[x] ;'.$nl;

		 echo 'if (ItemArrayValue[x]==selectedValue)'.$nl;
		 echo '   myEle.selected=true;'.$nl;
         echo '   controlToPopulate.add(myEle) ;'.$nl;
         echo '   }'.$nl;
         echo ' }'.$nl;
         echo '}'.$nl;
		 }
		 echo '//  End -->'.$nl;
		 echo '</SCRIPT>';
	 }

function  genjava_ddwlist1call3 ($sql,$fieldGrp,$fieldTxt,$fieldValue,$ddwlistNum,$showFunc,$first2Field) {
		 //Use in page : onchange="selectChange(this, form1.sale_id, arrItemsTxt,arrItemsValue ,arrItemsGrp);"
		 $nl = "\n"; // New line
         echo '<SCRIPT LANGUAGE="JavaScript">'.$nl;
         echo '<!-- Begin '.$nl;
		 echo 'var arrItemsTxt'.$ddwlistNum.' = new Array();'.$nl;
		 echo 'var arrItemsValue'.$ddwlistNum.' = new Array();'.$nl;
		 echo 'var arrItemsGrp'.$ddwlistNum.' = new Array();'.$nl.$nl;
         //Create variable
		  $query         = $this->db->query ($sql);
		  $numRows  = $this->db->num_rows ($query);
          for ($i=0;$i < $numRows;$i++) {
          $result = $this->db->fetch_array ($query);
          echo 'arrItemsGrp'.$ddwlistNum.'['.$i.'] = "'.$result[$fieldGrp].'";'.$nl;
          echo 'arrItemsTxt'.$ddwlistNum.'['.$i.'] = "'.$result[$fieldTxt].'";'.$nl;
          echo 'arrItemsValue'.$ddwlistNum.'['.$i.'] = "'.$result[$fieldValue].'";'.$nl;
		  }//for
		 // Java function
		 if ($showFunc=='Y') {
         echo $nl.'function selectChange2(control, controlToPopulate, ItemArrayTxt,ItemArrayValue, GroupArray,selectedValue)'.$nl;
         echo '{'.$nl;
         echo 'var myEle ;'.$nl;
         echo 'var x ;'.$nl;
         echo '// Empty the second drop down box of any choices'.$nl;
		 echo 'for (var q=controlToPopulate.options.length;q>=0;q--) controlToPopulate.options[q]=null;'.$nl;
         echo '// ADD Default Choice - in case there are no values'.$nl;
         echo 'myEle = document.createElement("option") ;'.$nl;
		
		 if (!empty($first2Field)) {
			  echo 'myEle.value="";'.$nl;
			  echo 'myEle.text="'.$first2Field.'";'.$nl;
			  echo 'controlToPopulate.add(myEle) ;'.$nl;
		 }
		 echo 'for ( x = 0 ; x < ItemArrayTxt.length  ; x++ )'.$nl;
         echo   '{'.$nl;
         echo '    if ( GroupArray[x] == control.value)'.$nl;
         echo '   {'.$nl;
         echo 'myEle = document.createElement("option") ;'.$nl;
         echo ' myEle.text = ItemArrayTxt[x] ;'.$nl;
		 echo ' myEle.value= ItemArrayValue[x] ;'.$nl;

		 echo 'if (ItemArrayValue[x]==selectedValue)'.$nl;
		 echo '   myEle.selected=true;'.$nl;
         echo '   controlToPopulate.add(myEle) ;'.$nl;
         echo '   }'.$nl;
         echo ' }'.$nl;
         echo '}'.$nl;
		 }
		 echo '//  End -->'.$nl;
		 echo '</SCRIPT>';
	 }

      function gen_code_f_id ($tbName,$fieldID)
	  {	
			  $max = $this->db->find_max ($tbName,$fieldID);
			  $max++;
			  return substr(($max+10000),1,4);
	  }
	  function incre_decre_day($start_date, $numdays=0, $inc_dec='+') {
	 		$date_format = $this->DATE_FORMAT;
			$date_type = $this->YEAR_FORMAT;
						
			if(!empty($start_date)) {
				if( strlen($start_date) >= 8 && eregi("[0-9]", $start_date) ) {
									
								$arr_date = explode("/",$start_date);							
								$dd = $arr_date[0];
								$mm = $arr_date[1];
								$yy = $arr_date[2];							
							$yy-=543; //  ปรับปีจาก พ.ศ. -> ค.ศ.
							
							$x = $workdays = 0;
							$day_name = '99';
							$holidays = 0;
							
							// ถ้ามีจำนวนวัน numdays จึงจะเข้ามา บวก/ลบ วัน 							
							while( $x < $numdays ) { // ถ้ายังไม่ครบจำนวนวัน
							
								$date_buffer = date("d/m/Y",strtotime($inc_dec."1 days", mktime(0,0,0,$mm,$dd,$yy)));	 // บวก/ลบ วัน แล้วเก็บวันที่ไว้ใน $date_buffer								
																
								$arr_date2 = explode("/", $date_buffer);	
								$dd = $arr_date2[0];
								$mm = $arr_date2[1];
								$yy = $arr_date2[2];
								$day_name = date("w", mktime(0,0,0,$mm,$dd,$yy)); // check ว่าวันอะไร
								
								$sqlChk = " SELECT * FROM  HOLIDAY  WHERE HOLIDAY_DATE = '$date_buffer' "; // ค้นหาว่า $date_buffer ใช่วันหยุดมั้ย
								$execChk = $this->db->query($sqlChk);
								$chk_holiday = $this->db->num_rows($execChk);  // $chk_holiday ไม่เกิน 1
								//echo " $date_buffer คือวัน [$day_name] แล้ว สถานะวันหยุด = $chk_holiday ";		
								
								if(	$day_name == '6' || $day_name == '0' || $chk_holiday > 0 ) { // ถ้าเป็นวันหยุด ก็ยังไม่ต้องนับวันทำงาน ( x )									
									$holidays++; // นับจำนวนวันหยุดก็พอ
								} else { 					 									
									$x++; // ใช้ concept ถ้าไม่ใช่วันหยุด จึงจะนับวันทำงาน ดีกว่า
								}	
							} 
							 //echo " มีวันหยุด $holidays วัน ";										
							$yy+=543; //  ปรับปีจาก ค.ศ. -> พ.ศ.
						$date_out = $dd."/".$mm."/".$yy;	// output คือ วันที่ที่ไม่ใช่หยุดแล้ว							
				} else {
					$date_out = 'NULL';
				}								
			} else {
				$date_out = 'NULL';
			}
			return $date_out;
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
	 function incre_decre_date($start_date, $strtotime) {
	 		$date_format = $this->DATE_FORMAT;
			$date_type = $this->YEAR_FORMAT;
						
			if(!empty($start_date)) {
				if( strlen($start_date) >= 8 && eregi("[0-9]", $start_date) ) {
									
								$arr_date = explode("/",$start_date);							
								$dd = $arr_date[0];
								$mm = $arr_date[1];
								$yy = $arr_date[2];							
							$yy-=543; //  ปรับปีจาก พ.ศ. -> ค.ศ.
							
							$date_buffer = date("d/m/Y",strtotime($strtotime, mktime(0,0,0,$mm,$dd,$yy)));	
							
							$arr_date2 = explode("/", $date_buffer);	
							$dd = $arr_date2[0];
							$mm = $arr_date2[1];
							$yy = $arr_date2[2];
														
							$yy+=543; //  ปรับปีจาก ค.ศ. -> พ.ศ.
						$date_out = $dd."/".$mm."/".$yy;								
				} else {
					$date_out = 'NULL';
				}								
			} else {
				$date_out = 'NULL';
			}
			return $date_out;
	 } 	 
	 function whatday($date_in) {	 		
	 		$date_format = $this->DATE_FORMAT;
			$date_type = $this->YEAR_FORMAT;
						
			if(!empty($date_in)) {
				if( strlen($date_in) >= 8 && eregi("[0-9]", $date_in) ) {
									
								$arr_date = explode("/",$date_in);							
								$dd = $arr_date[0];
								$mm = $arr_date[1];
								$yy = $arr_date[2];							
							$yy-=543; //  ปรับปีจาก พ.ศ. -> ค.ศ.
							
							$day_name = date("w", mktime(0,0,0,$mm,$dd,$yy));	
							echo " วัน $day_name";
																											
				} else {
					$day_name = NULL;
				}								
			} else {
				$day_name = NULL;
			}
			return $day_name;
	 }
	 function convert_date_to_db ($date_in, $DBMS="", $wantTime=0 ) {
	 		$date_format = $this->DATE_FORMAT;
			$date_type = $this->YEAR_FORMAT;
	/*		
			if(empty($DBMS)) $DBMS = strtoupper($this->db->typeConn);
			
			if(!empty($date_in)) {
				if( strlen($date_in) >= 8 && eregi("[0-9]", $date_in) ) {
									
								$arr_date = explode("/",$date_in);							
								$dd = $arr_date[0];
								$mm = $arr_date[1];
								$yy = $arr_date[2];							
							$yy = $this->convert_year_to_db($yy, $date_type);							
							
						if( $DBMS == "MSSQL" ) { 
							if($date_format == 'mm/dd/yyyy') {
								$date_out = $mm."/".$dd."/".$yy; // output
							} 
							else if($date_format == 'yyyy-mm-dd') {
								$date_out = $yy."-".$mm."-".$dd; // output
							}
							else if($date_format == 'dd/mm/yyyy') {
								$date_out = $dd."/".$mm."/".$yy; // output
							} 
							else {
								//$date_out = $date_in;
								$date_out = 'NULL';
							}								
								
						} else if($DBMS == "MYSQL" || $DBMS == "ACCESS" ) { // mysql							
							$date_out = $yy."-".$mm."-".$dd; // output
						} else {
							//$date_out = $date_in;
							$date_out = 'NULL';
						}
				} else {
					  //$date_out = "Invalid format";
					  $date_out = 'NULL';
				}
			} else {
					//$date_out = $date_in;
					$date_out = 'NULL';
			}
			return $date_out;
			*/
				if(empty($DBMS)) $DBMS = "MYSQL"; //  "MYSQL";
				
				if(!empty($date_in)) { 

					//echo $date_format.", $DBMS<br>";
					//echo "date from input : $date_in<br>";

					if( strlen($date_in) >= 8 && eregi("[0-9]", $date_in) ) {
									
									$arrDateTime = explode(" ", $date_in); // separate Time															
									$last_index = count($arrDateTime)-1;

								if($last_index>=1) {
									$timepart = $arrDateTime[$last_index]; // time	
								} else {
									$timepart = "";
								}

									$arr_date = explode("/",$arrDateTime[0]);							
									$dd = $arr_date[0];
									$mm = $arr_date[1];
									$yy = $arr_date[2];							
									$yy = $this->convert_year_to_db($yy, $date_type);							
								
							if( $DBMS == "MSSQL" ) { 
									if($date_format == 'mm/dd/yyyy') {
										$date_out = $mm."/".$dd."/".$yy; // output
									} 
									else if($date_format == 'yyyy-mm-dd') {
										$date_out = $yy."-".$mm."-".$dd; // output
									}
									else if($date_format == 'dd/mm/yyyy') {
										$date_out = $dd."/".$mm."/".$yy; // output
									} 
									else {
										$date_out = $date_in;
									}								
									
							} else if( $DBMS == "ORACLE" ) { 
									/* if($date_format == 'mm/dd/yyyy') {
										$date_out = $mm."/".$dd."/".$yy; // output
									} 
									else if($date_format == 'yyyy-mm-dd') {
										$date_out = $yy."-".$mm."-".$dd; // output
									}
									else if($date_format == 'dd/mm/yyyy') {
										$date_out = $dd."/".$mm."/".$yy; // output
									} 
									else {
										$date_out = $date_in;
									}	*/
									$date_out = " TO_DATE( '".$dd."/".$mm."/".$yy."', 'dd/mm/YYYY' ) ";
									
							} else if($DBMS == "MYSQL" || $DBMS == "ACCESS" ) { // mysql							
									$date_out = $yy."-".$mm."-".$dd; // output
							} else {
									$date_out = $date_in;
							}
							
							if($wantTime && $timepart) {
									$date_out.=" ".$timepart;
							}
							
							//echo "date out to db : $date_out<br>";
					} else {
						  $date_out = 'NULL';
					}
				} else {
						 $date_out = 'NULL';
				}
				return $date_out;
		}	
		function convert_year_to_db($yy, $date_type=0) {
			if($date_type==2) {  // $date_type คือ รูปแบบปีตอนเก็บ ลง db
				$yy-=543; // เปลี่ยนจาก พ.ศ เป็น ค.ศ
			} else {
				$yy=$yy;  // ถ้า $date_type == 1 คือ พ.ศ. อยู่แล้ว ก็ไม่ต้อง เพิ่ม/ลบ เพราะปฏิทินเราเป็น พ.ศ. อยู่แล้ว
			}			
			return $yy;
		} 
	 function time_to_db($hr, $min, $sec=0) {
	 			$excess_min = $min-60;
				if( $excess_min >= 0 ) {
					$min = $excess_min; 
					$hr++;
				}
				if( $hr > 23 ) $hr = 0;

				if(!$hr) $hr=0;
				if(!$min) $min=0;
				if(!$sec) $sec=0;
				
				$db_time = $hr.":".$min.":".$sec;
				 
		  	return $db_time;
	 }
	 function datetime_to_db($date_in, $hr, $min, $sec=0) {
	 	 if($date_in && $date_in != 'NULL') {	
				/*if( ($hr >= 0 && $hr <=23) && ( $min >=0 && $min <= 59 ) ) {
					if(!$hr) $hr=0;
					if(!$min) $min=0;
					$datetime = $date_in." ".$hr.":".$min.":".$sec;
				}*/
				$datetime = $date_in." ".$this->time_to_db($hr, $min, $sec);
		  } else {
		  		$datetime = $date_in;
		  }
		  return $datetime;
	 }	 
	 function convert_date_to_show ($date_in, $wantTime, $LongDate=0, $DBMS="" ) {
			if(empty($DBMS)) $DBMS = strtoupper($this->db->typeConn); //"MSSQL";  $this->$db->dbms;
			$fromDBMS = "MSSQL";
			
			$date_format = $this->DATE_FORMAT;
			$date_type = $this->YEAR_FORMAT;
			
			//echo "db_type: ".$this->db;
			if(!empty($date_in)) {
				if( strlen($date_in) >= 8 && eregi("[0-9]", $date_in) ) {
				//echo $date_format."<br>";
						if( $DBMS == "MSSQL") { 							
																	
							if($date_format == 'mm/dd/yyyy') {	
									
									$arrDateTime = explode(" ", $date_in); // separate Time								
									$last_index = count($arrDateTime)-1;
									$timepart = $arrDateTime[$last_index]; // time
										
									if($fromDBMS=="MSSQL") { // อ่านวันที่จากที่เก็บใน MSSQL โดยตรง							
										
										$datepart = "";									
										for($i=0;$i<($last_index-1);$i++) {
											$datepart .= $arrDateTime[$i]." ";  // re-implode date only
										}
										if($datepart) {
											$datepart = substr($datepart,0,-1);
										}
										$arr_date = explode(" ",$datepart);	// for mssql 	
										$dd = $arr_date[0];
										$mm = $arr_date[1];
										$yy = $arr_date[2];
										$mm = array_search($mm, $this->mont_th_short)+1;	 // get month number from key of array
									
									} else { // อ่านวันที่จากที่เก็บใน MYSQL แต่เป็นรูปแบบของ DBMS อื่น ( เช่น MSSQL )
										$datepart = $arrDateTime[0];																	
										
										$arr_date = explode("/",$datepart);
										$dd = $arr_date[1];
										$mm = $arr_date[0];
										$yy = $arr_date[2];
									}	
																												
									if( $dd < 10 ) {
										$dd = "0".$dd;
									} 
									if( $mm < 10 ) {
										$mm = "0".$mm;
									}														
									$yy = $this->convert_year_to_show($yy, $date_type);		
														
									$date_out = $dd."/".$mm."/".$yy; // output
							} 
							else if($date_format == 'yyyy-mm-dd') {

								$arr_date = explode("-",$date_in);														
								$dd = $arr_date[2];							
								$mm = $arr_date[1];
								$yy = $arr_date[0];								
								$yy = $this->convert_year_to_show($yy, $date_type);							
								$date_out = $dd."/".$mm."/".$yy; // output
							}
							else if($date_format == 'dd/mm/yyyy') {
								$arrDateTime = explode(" ", $date_in); // separate Time								
								$last_index = count($arrDateTime)-1;
								$timepart = $arrDateTime[$last_index]; // time	
								//echo "time : $timepart<br>";
								$datepart = "";		

								for($i=0;$i<($last_index);$i++) {
									$datepart .= $arrDateTime[$i]." ";  // re-implode date only
								}
								if($datepart) {
									$datepart = substr($datepart,0,-1);
								}
								//echo "date : $datepart<br>";
									$arr_date = explode(" ",$datepart);														
									$dd = $arr_date[0];
									$mm = $arr_date[1];
									$yy = $arr_date[2];//543
									//print_r($arr_date);
									$yy = $this->convert_year_to_show($yy, $date_type);	

									if($LongDate==1) {
											$month_name = $this->mont_th[array_search($mm, $this->mont_th_short)];
											$date_out = $dd." ".$month_name." ".$yy; // output	
									} else {		
											$mm = array_search($mm, $this->mont_th_short)+1;	 // get month number from key of array
											
											if( $dd < 10 ) {
												$dd = "0".$dd;
											} 
											if( $mm < 10 ) {
												$mm = "0".$mm;
											} // 2 ส.ค. 2006
																	
											$date_out = $dd."/".$mm."/".$yy; // output					
									}

									if($wantTime==1) { // have time
										$date_out.=" ".$arrDateTime[1];
									}
							} 
							else {
								$date_out = $date_in;
							}								
								
						} else if($DBMS == "MYSQL" || ( $DBMS == "ACCESS") ) { // && $date_format == 'yyyy-mm-dd'
							 
								$arrDateTime = explode(" ", $date_in); // separate Time								
								$arr_date = explode("-",$arrDateTime[0]);	// separate Date														
								$dd = $arr_date[2];							
								$mm = $arr_date[1];
								$yy = $arr_date[0];								
								$yy = $this->convert_year_to_show($yy, $date_type);							
								
								//$date_out = $dd."/".$mm."/".$yy; // output
								
								if($LongDate==1) {
										$month_name = $this->mont_th[$mm-1];
										$date_out = ($dd*1)." ".$month_name." ".$yy; // output	
								} else {																											
										$date_out = $dd."/".$mm."/".$yy; // output					
								}

								if($wantTime==1) { // have time
									$date_out.=" ".$arrDateTime[1];
								}
						} else if( $DBMS == "ORACLE" ) {
							$date_out = $date_in;
						} else {
							$date_out = $date_in;
						}						
				} else {
					  $date_out = "Invalid format";
				}			
			} else {
					$date_out = $date_in;
			}
			return $date_out;
		}					
		function convert_year_to_show($yy, $date_type=0) {
			if($date_type==2) {  // $date_type คือ รูปแบบปีตอนเก็บ ลง db 
				$yy+=543; // เปลี่ยนจาก ค.ศ. เป็น พ.ศ
			} else {
				$yy=$yy; // ถ้า $date_type == 1 คือ พ.ศ. อยู่แล้ว ก็ไม่ต้อง เพิ่ม/ลบ เพราะปฏิทินเราเป็น พ.ศ. อยู่แล้ว
			}			
			return $yy;
		} 
		function show_time($datetime, $specify="" ) {
			 $arrDateTime = explode(" ", $datetime); // separate Time								
			 $last_index = count($arrDateTime)-1;
			 $timepart = $arrDateTime[$last_index]; // time	
			 
			 if($specify=='h') {
			 	$arrTime = explode(":", $timepart);
				$show_out =  $arrTime[0];
			 } else if($specify=='m') {
				$arrTime = explode(":", $timepart);
				$show_out =  $arrTime[1];				
			 } else {
			 	$show_out =  $timepart;	
			 }			 
			 return $show_out;
		}
	function mssql_datefomat($date, $FM='mm/dd/YY', $lang='EN', $sign="")
	{ 
		
		if(strlen($date) >= 8 && ereg("[0-9]", $date) ) 
		{
			$Array=split(' ',$date);
			if( $Array[2] > 1900 ) { // แก้ปัญหา วันที่ default ของ mssql
						$Array[0] = sprintf("%02d",$Array[0]);
						if($lang=='TH') {
							$Array[2]+=543;
						}
						
					if($FM=='mm/dd/YY') {
						switch(trim($Array[1])){
							case "ม.ค." : $forMat="01/".$Array[0]."/".$Array[2];break;
							case "ก.พ." : $forMat="02/".$Array[0]."/".$Array[2];break;
							case "มี.ค." : $forMat="03/".$Array[0]."/".$Array[2];break;
							case "เม.ย." : $forMat="04/".$Array[0]."/".$Array[2];break;
							case "พ.ค." : $forMat="05/".$Array[0]."/".$Array[2];break;
							case "มิ.ย." : $forMat="06/".$Array[0]."/".$Array[2];break;
							case "ก.ค." : $forMat="07/".$Array[0]."/".$Array[2];break;
							case "ส.ค." : $forMat="08/".$Array[0]."/".$Array[2];break;
							case "ก.ย." : $forMat="09/".$Array[0]."/".$Array[2];break;
							case "ต.ค." : $forMat="10/".$Array[0]."/".$Array[2];break;
							case "พ.ย." : $forMat="11/".$Array[0]."/".$Array[2];break;
							case "ธ.ค." : $forMat="12/".$Array[0]."/".$Array[2];break;
						 }
					}
					else if($FM=='dd/mm/YY') {
						switch(trim($Array[1])){
							case "ม.ค." : $forMat=$Array[0]."/"."01/".$Array[2];break;
							case "ก.พ." : $forMat=$Array[0]."/"."02/".$Array[2];break;
							case "มี.ค." : $forMat=$Array[0]."/"."03/".$Array[2];break;
							case "เม.ย." : $forMat=$Array[0]."/"."04/".$Array[2];break;
							case "พ.ค." : $forMat=$Array[0]."/"."05/".$Array[2];break;
							case "มิ.ย." : $forMat=$Array[0]."/"."06/".$Array[2];break;
							case "ก.ค." : $forMat=$Array[0]."/"."07/".$Array[2];break;
							case "ส.ค." : $forMat=$Array[0]."/"."08/".$Array[2];break;
							case "ก.ย." : $forMat=$Array[0]."/"."09/".$Array[2];break;
							case "ต.ค." : $forMat=$Array[0]."/"."10/".$Array[2];break;
							case "พ.ย." : $forMat=$Array[0]."/"."11/".$Array[2];break;
							case "ธ.ค." : $forMat=$Array[0]."/"."12/".$Array[2];break;
						 }
					}
					else {
						 $forMat=$sign;
					}
			} else {
						 $forMat=$sign;
			}
		}else{
			 $forMat=$sign;
		}
		return $forMat;
	}
	
	function ms2my_datefomat($date)
	{
		if($date!="")
		{
			$Array=split(' ',$date);
				$Array[0] = sprintf("%02d",$Array[0]);
			switch(trim($Array[1])){
			case "ม.ค." : $Array[2]."-01-".$Array[0];break;
					case "ม.ค." : $forMat=$Array[2]."-01-".$Array[0];break;
					case "ก.พ." : $forMat=$Array[2]."-02-".$Array[0];break;
					case "มี.ค." : $forMat=$Array[2]."-03-".$Array[0];break;
					case "เม.ย." : $forMat=$Array[2]."-04-".$Array[0];break;
					case "พ.ค." : $forMat=$Array[2]."-05-".$Array[0];break;
					case "มิ.ย." : $forMat=$Array[2]."-06-".$Array[0];break;
					case "ก.ค." : $forMat=$Array[2]."-07-".$Array[0];break;
					case "ส.ค." : $forMat=$Array[2]."-08-".$Array[0];break;
					case "ก.ย." : $forMat=$Array[2]."-09-".$Array[0];break;
					case "ต.ค." : $forMat=$Array[2]."-10-".$Array[0];break;
					case "พ.ย." : $forMat=$Array[2]."-11-".$Array[0];break;
					case "ธ.ค." : $forMat=$Array[2]."-12-".$Array[0];break;
				 }
		}else{
			 $forMat="";
		}
		return $forMat;
	}
	
	function my2ms_datefomat($date)
	{ 
		$Array=split(' ',$date);
		$mydate = explode('/',$Array[0]);
		$forMat=$mydate[1].'/'.$mydate[0].'/'.$mydate[2];//Doae
		//$forMat=$mydate[1].'/'.$mydate[2].'/'.$mydate[0];//Biz
		if($mydate[1]=='00'&&$mydate[2]=='00'&&$mydate[0]=='00'){
			 $forMat="";
		}
		return $forMat;
	}
	
		function CheckTag($temp){
		global $url;
		$temp = stripslashes(htmlspecialchars($temp));
		$temp = eregi_replace ( chr(13), "<br>" , $temp ) ;
		$temp = eregi_replace ( "\[b\]", "<b>" , $temp ) ;
		$temp = eregi_replace ( "\[/b\]", "</b>" , $temp ) ;
		$temp = eregi_replace ( "\[i\]", "<i>" , $temp ) ;
		$temp = eregi_replace ( "\[/i\]", "</i>" , $temp ) ;
		$temp = eregi_replace ( "\[u\]", "<u>" , $temp ) ;
		$temp = eregi_replace ( "\[/u\]", "</u>" , $temp ) ;
		$temp = eregi_replace ( "\[\-\-\-\]", "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;" , $temp ) ;
		$temp = eregi_replace ( "\[color=red\]", "<font color=red>" , $temp ) ;
		$temp = eregi_replace ( "\[color=green\]", "<font color=green>" , $temp ) ;
		$temp = eregi_replace ( "\[color=blue\]", "<font color=blue>" , $temp ) ;
		$temp = eregi_replace ( "\[color=orange\]", "<font color=FF6600>" , $temp ) ;
		$temp = eregi_replace ( "\[color=pink\]", "<font color=FF00FF>" , $temp ) ;
		$temp = eregi_replace ( "\[color=gray\]", "<font color=999999>" , $temp ) ;
		$temp = eregi_replace ( "\[/color\]", "</font>" , $temp ) ;
		$temp = eregi_replace ("\[img\]([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]])\[/img\]", "<img src=\"\\1://\\2\\3\">",$temp ) ;
		$temp = eregi_replace ("\[url\]([[:alnum:]]+)://([^[:space:]]*)([[:alnum:]#?/&=])\[/url\]","<a href=\"\\1://\\2\\3\" target=\"_blank\">\\1://\\2\\3</a>",$temp ) ;
		$temp = eregi_replace ("([^[:space:]]*)@([^[:space:]]*)([[:alnum:]])","<a href=\"./mail2me/mail2me.php?wemail=\\1@\\2\\3&name=\\1@\\2\\3\" target=\"_blank\">\\1@\\2\\3</a>",$temp ) ;
		return ( $temp ) ;
	}
	
	function CheckSmile($temp){
		global $url;
		$text = array(
		":sad:",":red:", ":big:", ":ent:", ":shy:", ":sleepy:", ":sun:", ":sg:", ":embarass:", 
		":dead:", ":cool:", ":clown:", ":pukey:", ":eek:", ":roll:", ":smoke:", ":angry:", ":confused:", ":cry:", 
		":lol:", ":yawn:", ":devil:", ":tongue:", ":alien:",":tasty:",":crazy:",":agree:",":disagree:",":bawling:", 
		":crap:",":crying1:",":dunce:",":error:",":evil:",":lookaroundb:",":laugh:",":pimp:",":spiny:",":wavey:",":smash:",":angry:",
		":brain:",":phone:",":zip:",":download:",":beer:",":censore:",":nolove:",":cranium:");

		$pic =array(
		"frown.gif","redface.gif","biggrin.gif","blue.gif","shy.gif","sleepy.gif","sunglasses.gif", "supergrin.gif","embarass.gif",
		"dead.gif","cool.gif","clown.gif","pukey.gif","eek.gif","sarcblink.gif","smokin.gif","reallymad.gif","confused.gif","crying.gif",
		"lol.gif","yawn.gif","devil.gif","tongue.gif","aysmile.gif","tasty.gif","grazy.gif","agree.gif","disagree.gif","bawling.gif",
		"crap.gif","crying1.gif","dunce.gif","error.gif","evil.gif","lookaroundb.gif","laugh.gif","pimp.gif","spiny.gif","wavey.gif","smash.gif","angry.gif",
		"brain.gif","phone.gif","zip.gif","download.gif","beer.gif","censore.gif","nolove.gif","cranium.gif");

		for ($i=0 ; $i<sizeof($text) ; $i++) {
			$temp = eregi_replace($text[$i],"<img src=\"./pic/$pic[$i]\">",$temp);
		}
		return($temp);
	}

	function CheckRude($temp){
		$wordrude = array(
		"ashole","a s h o l e","a.s.h.o.l.e","bitch","b i t c h","b.i.t.c.h","shit","s h i t","s.h.i.t","fuck",
		"dick","f u c k","d i c k","f.u.c.k","d.i.c.k","???","?? ?","??","???","? ? ?","?.?.?",
		"?? ?? ??","??-??-??","???","?????","?????","???????","??????","? ? ? ? ? ?","?.?.?.?.?.?","? ? ?? ? ? ?",
		"?.?.??.?.?.?","???","??????","???","????","??","??????","????","????","??????","???") ;
		$wordchange = ("<font color=red>***</font>") ;

		for ( $i=0 ; $i<sizeof($wordrude) ; $i++ ){
			$temp = eregi_replace($text[$i],"<img src=\"./pic/$pic[$i]\">",$temp);
			//$temp = eregi_replace ($wordrude[$i] ,$wordchange ,$temp);
		}
		return ( $temp ) ;
	}
	function generate_code($intial="user",$next_id){	 	
		 if($next_id < 10 ) $intial.="00".$next_id;
		 else if($next_id < 100 ) $intial.="0".$next_id;
		 else if($next_id < 1000 ) $intial.="".$next_id;			
		 
		 return $intial;
	}
	
		function th2uni($sti) {
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
			'่' => "&#3656;", 
			'้' => "&#3657;", 
			'๊' => "&#3658;",
			'๋' => "&#3659;", 
			'์' => "&#3660;"
			);
		
			$th2unimap3 = array( // สำหรับมี อักษรมีหางอยู่ข้างหน้า
			'ิ' => "&#3636;",
			'ี' => "&#3637;", 
			'ึ' => "&#3638;", 
			'ื' => "&#3639;",
			'่' => "&#3656;", 
			'้' => "&#3657;", 
			'๊' => "&#3658;",
			'๋' => "&#3659;", 
			'์' => "&#3660;",
			'ั' => "&#3633;",
			'ํ' => "&#3661;",
			'็' => "&#3662;"
			);
		
			$th2unimap4 = array( // สำหรับมี 2 อักษรมีหางอยู่ข้างหน้า และ 1 ตัวอักษรข้างหน้าเป็นสระบน
			'่' => "&#3656;", 
			'้' => "&#3657;", 
			'๊' => "&#3658;",
			'๋' => "&#3659;", 
			'์' => "&#3660;"
			);
		
			$th2unimap5 = array( // สำหรับ ญ ฐ ร่วมกับ สระอุ อู และ อฺ
			'ญ' => "&#3597;", 
			'ฐ' => "&#3600;", 
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
		  function ddw_list_selected_thai ($sql_str,$f_name,$f_value,$select_value)
  {
	  $this->db->query ($sql_str);
	   while ($this->db->fetch_array($this->db->result))
	  {
          if ($this->db->record[$f_value] == $select_value)
			   $str_selected = "selected";
		  else
               $str_selected = ""; 
		  print "<option value='".$this->db->record[$f_value]."'".$str_selected.">".$this->th2uni($this->db->record[$f_name])."</option>";
	  }
  }
  function two_decimal($val, $comma=',') {
  			if(!empty($val)) {				
				$dec_val = strrchr($val,".")+0;
				$digit = ($dec_val<0.005)? 0:2;				
				return number_format($val, $digit ,'.', $comma);
			} else {
				//$digit = 2;
				return '';
			}
			
	}
	function show_though_empty($value, $sign='&nbsp;') {
		// $sign="<span align='center'>$sign</span>";
		$output=(!empty($value))? $value:$sign;
		return $output;
	}
	function find_mid_value($buffer) {
	   sort($buffer);
	   reset($buffer);
	   //print_r($buffer);
		$cc = count($buffer)/2;
								
		if( ( count($buffer)%2 ) > 0 ) {
			$mid_area = $buffer[floor($cc)];
		} else {
			$mid_area = ($buffer[$cc-1]+$buffer[$cc])/2;									
		}
		return $mid_area;
	}
	function zerofill($value, $decimal=0){
			$zerofill = "";
			 $mod = round($value,$decimal) - round($value); // check fraction
		 
			if( $decimal>0  &&  $mod == 0) {  // if have decimal and fraction = 0 			 
					for($i=1;$i<=$decimal;$i++) {
						$zerofill .= '0';
					}
					$value = $value.".$zerofill"; // fill zero until = qty of decimal							 
			}
			return $value;
	}
	function not_number_format($value) {
			$out_value  = eregi_replace("(,)|( )","",$value);
			return $out_value; 
	}
	  function convert_qoute_to_db($str) {		
		return	htmlspecialchars($str, ENT_QUOTES);	 // แปลง ' ให้เป็น &#039;
	  }
	  function convert_qoute_to_show($str) {
			return html_entity_decode($str, ENT_QUOTES);	 // แปลง &#039; กลับมาเป็น ' 
	  }
	function add_dad($value) {  // ตรวจสอบว่าค่า เป็น 0.00 ให้ใส่เครื่องหมาย - (ลบ)
			if ($value<0) {		
					$out_value = "(".number_format(abs($value),2).")";	
			} else if ($value>0){
					$out_value = number_format(abs($value),2);	
			} else {
					$out_value ="<div align=\"center\">-</div>";
			}		//end els

			return $out_value; 
	}
	function show_print2full($date_input) {// Format -> 2 พฤษภาคม  2549 
		if(!$date_input){return false;}
			$arr_date = explode ("-",$date_input); 
			$date= $arr_date[2]*1;
			$mont_num= ($arr_date[1]*1) - 1;
			$mont = $this->mont_th[$mont_num];
			$year_en= $arr_date[0];
			$year= $year_en+543 ; 
		return $date." ".$mont." ".$year;
	} 
	function cld_my2date($date_input) 
	{  // Edit $this->timeFormat; // 02/06/2550
		if(!$date_input){return false;}
		 $arr_date = explode ("-",$date_input); 
		 $d= substr($arr_date[2]+100,1);
		 $m= substr($arr_date[1]+100,1);
		 $year_en = $arr_date[0];
		 $year_th = $arr_date[0] +543; 
		 return $d."/".$m."/".$year_th;
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

   
		function newfilename($dir) {
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
		
		//echo $rnumber.' '.$sofar.' '.substr($rnumber,0,1).' '.$reading[$digit][$rnumber[0]].'<br>';
		if(strlen($rnumber)==1){
		return $this->bahttext_reading[$digit][$rnumber].$sofar;
		}
		else{
		return integerToThaiHelper(substr($rnumber,1),($digit+1),$this->bahttext_reading[$digit][substr($rnumber,0,1)].$sofar);
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
		function convert_specials_char($str_in, $cond="") {
			$str_in = ereg_replace("&quot;",'"',$str_in);
			$str_in = ereg_replace("&#039;","'",$str_in);
			if($cond!="url") {
				$str_in = ereg_replace("&amp;",'&',$str_in);
			}
			$str_in = ereg_replace("&lt;",'<',$str_in);
			$str_in = ereg_replace("&gt;",'>',$str_in);

			return $str_in;
		}
}// Class
?>
