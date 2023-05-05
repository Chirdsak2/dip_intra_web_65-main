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
	var $GENDER=array();
	var $bahttext_reading=array(1=>array('','เน€เธญเนเธ”','เธชเธญเธ','เธชเธฒเธก','เธชเธตเน','เธซเนเธฒ','เธซเธ','เน€เธเนเธ”','เนเธเธ”','เน€เธเนเธฒ'),
2=>array('','เธชเธดเธ','เธขเธตเนเธชเธดเธ','เธชเธฒเธกเธชเธดเธ','เธชเธตเนเธชเธดเธ','เธซเนเธฒเธชเธดเธ','เธซเธเธชเธดเธ','เน€เธเนเธ”เธชเธดเธ','เนเธเธ”เธชเธดเธ','เน€เธเนเธฒเธชเธดเธ'),
3=>array('','เธซเธเธถเนเธเธฃเนเธญเธข','เธชเธญเธเธฃเนเธญเธข','เธชเธฒเธกเธฃเนเธญเธข','เธชเธตเนเธฃเนเธญเธข','เธซเนเธฒเธฃเนเธญเธข','เธซเธเธฃเนเธญเธข','เน€เธเนเธ”เธฃเนเธญเธข','เนเธเธ”เธฃเนเธญเธข','เน€เธเนเธฒเธฃเนเธญเธข'),
4=>array('','เธซเธเธถเนเธเธเธฑเธ','เธชเธญเธเธเธฑเธ','เธชเธฒเธกเธเธฑเธ','เธชเธตเนเธเธฑเธ','เธซเนเธฒเธเธฑเธ','เธซเธเธเธฑเธ','เน€เธเนเธ”เธเธฑเธ','เนเธเธ”เธเธฑเธ','เน€เธเนเธฒเธเธฑเธ'),
5=>array('','เธซเธเธถเนเธเธซเธกเธทเนเธ','เธชเธญเธเธซเธกเธทเนเธ','เธชเธฒเธกเธซเธกเธทเนเธ','เธชเธตเนเธซเธกเธทเนเธ','เธซเนเธฒเธซเธกเธทเนเธ','เธซเธเธซเธกเธทเนเธ','เน€เธเนเธ”เธซเธกเธทเนเธ','เนเธเธ”เธซเธกเธทเนเธ','เน€เธเนเธฒเธซเธกเธทเนเธ'),
6=>array('','เธซเธเธถเนเธเนเธชเธ','เธชเธญเธเนเธชเธ','เธชเธฒเธกเนเธชเธ','เธชเธตเนเนเธชเธ','เธซเนเธฒเนเธชเธ','เธซเธเนเธชเธ','เน€เธเนเธ”เนเธชเธ','เนเธเธ”เนเธชเธ','เน€เธเนเธฒเนเธชเธ')
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
			$this->mont_th = array ("เธกเธเธฃเธฒเธเธก","เธเธธเธกเธ เธฒเธเธฑเธเธเน","เธกเธตเธเธฒเธเธก","เน€เธกเธฉเธฒเธขเธ","เธเธคเธฉเธ เธฒเธเธก","เธกเธดเธ–เธธเธเธฒเธขเธ","เธเธฃเธเธเธฒเธเธก","เธชเธดเธเธซเธฒเธเธก","เธเธฑเธเธขเธฒเธขเธ","เธ•เธธเธฅเธฒเธเธก","เธเธคเธจเธเธดเธเธฒเธขเธ","เธเธฑเธเธงเธฒเธเธก");
            $this->mont_th_short = array ("เธก.เธ.","เธ.เธ.","เธกเธต.เธ.","เน€เธก.เธข.","เธ.เธ.","เธกเธด.เธข.","เธ.เธ.","เธช.เธ.","เธ.เธข.","เธ•.เธ.","เธ.เธข.","เธ.เธ.");
			$this->str_field_id = "type_page_id";
		    $this->page = $PAGE;
			$this->SID = $SID;
				if (empty($this->page)){
		              $this->page=1;
	           }
			$this->DATE_FORMAT =  'dd/mm/yyyy';
			$this->YEAR_FORMAT = 2; // เน€เธเนเธเน€เธเนเธ เธ.เธจ.    

			$this->GENDER[1] = "เธเธฒเธข";
			$this->GENDER[2] = "เธซเธเธดเธ";
			$this->GENDER[3] = "เน€เธ”เนเธเธเธฒเธข";
			$this->GENDER[4] = "เน€เธ”เนเธเธซเธเธดเธ";


    }
	
	function getchinesedate($year,$month,$day)	{
		
		/* This function can return the date of the Chinese lunar calendar corresponding to the Gregorian calendar. It ranges from Jan 1st, 1901 to Feb 11th, 2021 */
	
		$cdate_monthdata=array(
		0=>array(8,0,0,0,0,0,0,0,0,0,0,0,29,30,7,1),
		1=>array(0,29,30,29,29,30,29,30,29,30,30,30,29,0,8,2),
		2=>array(0,30,29,30,29,29,30,29,30,29,30,30,30,0,9,3),
		3=>array(5,29,30,29,30,29,29,30,29,29,30,30,29,30,10,4),
		4=>array(0,30,30,29,30,29,29,30,29,29,30,30,29,0,1,5),
		5=>array(0,30,30,29,30,30,29,29,30,29,30,29,30,0,2,6),
		6=>array(4,29,30,30,29,30,29,30,29,30,29,30,29,30,3,7),
		7=>array(0,29,30,29,30,29,30,30,29,30,29,30,29,0,4,8),
		8=>array(0,30,29,29,30,30,29,30,29,30,30,29,30,0,5,9),
		9=>array(2,29,30,29,29,30,29,30,29,30,30,30,29,30,6,10),
		10=>array(0,29,30,29,29,30,29,30,29,30,30,30,29,0,7,11),
		11=>array(6,30,29,30,29,29,30,29,29,30,30,29,30,30,8,12),
		12=>array(0,30,29,30,29,29,30,29,29,30,30,29,30,0,9,1),
		13=>array(0,30,30,29,30,29,29,30,29,29,30,29,30,0,10,2),
		14=>array(5,30,30,29,30,29,30,29,30,29,30,29,29,30,1,3),
		15=>array(0,30,29,30,30,29,30,29,30,29,30,29,30,0,2,4),
		16=>array(0,29,30,29,30,29,30,30,29,30,29,30,29,0,3,5),
		17=>array(2,30,29,29,30,29,30,30,29,30,30,29,30,29,4,6),
		18=>array(0,30,29,29,30,29,30,29,30,30,29,30,30,0,5,7),
		19=>array(7,29,30,29,29,30,29,29,30,30,29,30,30,30,6,8),
		20=>array(0,29,30,29,29,30,29,29,30,30,29,30,30,0,7,9),
		21=>array(0,30,29,30,29,29,30,29,29,30,29,30,30,0,8,10),
		22=>array(5,30,29,30,30,29,29,30,29,29,30,29,30,30,9,11),
		23=>array(0,29,30,30,29,30,29,30,29,29,30,29,30,0,10,12),
		24=>array(0,29,30,30,29,30,30,29,30,29,30,29,29,0,1,1),
		25=>array(4,30,29,30,29,30,30,29,30,30,29,30,29,30,2,2),
		26=>array(0,29,29,30,29,30,29,30,30,29,30,30,29,0,3,3),
		27=>array(0,30,29,29,30,29,30,29,30,29,30,30,30,0,4,4),
		28=>array(2,29,30,29,29,30,29,29,30,29,30,30,30,30,5,5),
		29=>array(0,29,30,29,29,30,29,29,30,29,30,30,30,0,6,6),
		30=>array(6,29,30,30,29,29,30,29,29,30,29,30,30,29,7,7),
		31=>array(0,30,30,29,30,29,30,29,29,30,29,30,29,0,8,8),
		32=>array(0,30,30,30,29,30,29,30,29,29,30,29,30,0,9,9),
		33=>array(5,29,30,30,29,30,30,29,30,29,30,29,29,30,10,10),
		34=>array(0,29,30,29,30,30,29,30,29,30,30,29,30,0,1,11),
		35=>array(0,29,29,30,29,30,29,30,30,29,30,30,29,0,2,12),
		36=>array(3,30,29,29,30,29,29,30,30,29,30,30,30,29,3,1),
		37=>array(0,30,29,29,30,29,29,30,29,30,30,30,29,0,4,2),
		38=>array(7,30,30,29,29,30,29,29,30,29,30,30,29,30,5,3),
		39=>array(0,30,30,29,29,30,29,29,30,29,30,29,30,0,6,4),
		40=>array(0,30,30,29,30,29,30,29,29,30,29,30,29,0,7,5),
		41=>array(6,30,30,29,30,30,29,30,29,29,30,29,30,29,8,6),
		42=>array(0,30,29,30,30,29,30,29,30,29,30,29,30,0,9,7),
		43=>array(0,29,30,29,30,29,30,30,29,30,29,30,29,0,10,8),
		44=>array(4,30,29,30,29,30,29,30,29,30,30,29,30,30,1,9),
		45=>array(0,29,29,30,29,29,30,29,30,30,30,29,30,0,2,10),
		46=>array(0,30,29,29,30,29,29,30,29,30,30,29,30,0,3,11),
		47=>array(2,30,30,29,29,30,29,29,30,29,30,29,30,30,4,12),
		48=>array(0,30,29,30,29,30,29,29,30,29,30,29,30,0,5,1),
		49=>array(7,30,29,30,30,29,30,29,29,30,29,30,29,30,6,2),
		50=>array(0,29,30,30,29,30,30,29,29,30,29,30,29,0,7,3),
		51=>array(0,30,29,30,30,29,30,29,30,29,30,29,30,0,8,4),
		52=>array(5,29,30,29,30,29,30,29,30,30,29,30,29,30,9,5),
		53=>array(0,29,30,29,29,30,30,29,30,30,29,30,29,0,10,6),
		54=>array(0,30,29,30,29,29,30,29,30,30,29,30,30,0,1,7),
		55=>array(3,29,30,29,30,29,29,30,29,30,29,30,30,30,2,8),
		56=>array(0,29,30,29,30,29,29,30,29,30,29,30,30,0,3,9),
		57=>array(8,30,29,30,29,30,29,29,30,29,30,29,30,29,4,10),
		58=>array(0,30,30,30,29,30,29,29,30,29,30,29,30,0,5,11),
		59=>array(0,29,30,30,29,30,29,30,29,30,29,30,29,0,6,12),
		60=>array(6,30,29,30,29,30,30,29,30,29,30,29,30,29,7,1),
		61=>array(0,30,29,30,29,30,29,30,30,29,30,29,30,0,8,2),
		62=>array(0,29,30,29,29,30,29,30,30,29,30,30,29,0,9,3),
		63=>array(4,30,29,30,29,29,30,29,30,29,30,30,30,29,10,4),
		64=>array(0,30,29,30,29,29,30,29,30,29,30,30,30,0,1,5),
		65=>array(0,29,30,29,30,29,29,30,29,29,30,30,29,0,2,6),
		66=>array(3,30,30,30,29,30,29,29,30,29,29,30,30,29,3,7),
		67=>array(0,30,30,29,30,30,29,29,30,29,30,29,30,0,4,8),
		68=>array(7,29,30,29,30,30,29,30,29,30,29,30,29,30,5,9),
		69=>array(0,29,30,29,30,29,30,30,29,30,29,30,29,0,6,10),
		70=>array(0,30,29,29,30,29,30,30,29,30,30,29,30,0,7,11),
		71=>array(5,29,30,29,29,30,29,30,29,30,30,30,29,30,8,12),
		72=>array(0,29,30,29,29,30,29,30,29,30,30,29,30,0,9,1),
		73=>array(0,30,29,30,29,29,30,29,29,30,30,29,30,0,10,2),
		74=>array(4,30,30,29,30,29,29,30,29,29,30,30,29,30,1,3),
		75=>array(0,30,30,29,30,29,29,30,29,29,30,29,30,0,2,4),
		76=>array(8,30,30,29,30,29,30,29,30,29,29,30,29,30,3,5),
		77=>array(0,30,29,30,30,29,30,29,30,29,30,29,29,0,4,6),
		78=>array(0,30,29,30,30,29,30,30,29,30,29,30,29,0,5,7),
		79=>array(6,30,29,29,30,29,30,30,29,30,30,29,30,29,6,8),
		80=>array(0,30,29,29,30,29,30,29,30,30,29,30,30,0,7,9),
		81=>array(0,29,30,29,29,30,29,29,30,30,29,30,30,0,8,10),
		82=>array(4,30,29,30,29,29,30,29,29,30,29,30,30,30,9,11),
		83=>array(0,30,29,30,29,29,30,29,29,30,29,30,30,0,10,12),
		84=>array(10,30,29,30,30,29,29,30,29,29,30,29,30,30,1,1),
		85=>array(0,29,30,30,29,30,29,30,29,29,30,29,30,0,2,2),
		86=>array(0,29,30,30,29,30,30,29,30,29,30,29,29,0,3,3),
		87=>array(6,30,29,30,29,30,30,29,30,30,29,30,29,29,4,4),
		88=>array(0,30,29,30,29,30,29,30,30,29,30,30,29,0,5,5),
		89=>array(0,30,29,29,30,29,29,30,30,29,30,30,30,0,6,6),
		90=>array(5,29,30,29,29,30,29,29,30,29,30,30,30,30,7,7),
		91=>array(0,29,30,29,29,30,29,29,30,29,30,30,30,0,8,8),
		92=>array(0,29,30,30,29,29,30,29,29,30,29,30,30,0,9,9),
		93=>array(3,29,30,30,29,30,29,30,29,29,30,29,30,29,10,10),
		94=>array(0,30,30,30,29,30,29,30,29,29,30,29,30,0,1,11),
		95=>array(8,29,30,30,29,30,29,30,30,29,29,30,29,30,2,12),
		96=>array(0,29,30,29,30,30,29,30,29,30,30,29,29,0,3,1),
		97=>array(0,30,29,30,29,30,29,30,30,29,30,30,29,0,4,2),
		98=>array(5,30,29,29,30,29,29,30,30,29,30,30,29,30,5,3),
		99=>array(0,30,29,29,30,29,29,30,29,30,30,30,29,0,6,4),
		100=>array(0,30,30,29,29,30,29,29,30,29,30,30,29,0,7,5),
		101=>array(4,30,30,29,30,29,30,29,29,30,29,30,29,30,8,6),
		102=>array(0,30,30,29,30,29,30,29,29,30,29,30,29,0,9,7),
		103=>array(0,30,30,29,30,30,29,30,29,29,30,29,30,0,10,8),
		104=>array(2,29,30,29,30,30,29,30,29,30,29,30,29,30,1,9),
		105=>array(0,29,30,29,30,29,30,30,29,30,29,30,29,0,2,10),
		106=>array(7,30,29,30,29,30,29,30,29,30,30,29,30,30,3,11),
		107=>array(0,29,29,30,29,29,30,29,30,30,30,29,30,0,4,12),
		108=>array(0,30,29,29,30,29,29,30,29,30,30,29,30,0,5,1),
		109=>array(5,30,30,29,29,30,29,29,30,29,30,29,30,30,6,2),
		110=>array(0,30,29,30,29,30,29,29,30,29,30,29,30,0,7,3),
		111=>array(0,30,29,30,30,29,30,29,29,30,29,30,29,0,8,4),
		112=>array(4,30,29,30,30,29,30,29,30,29,30,29,30,29,9,5),
		113=>array(0,30,29,30,29,30,30,29,30,29,30,29,30,0,10,6),
		114=>array(9,29,30,29,30,29,30,29,30,30,29,30,29,30,1,7),
		115=>array(0,29,30,29,29,30,29,30,30,30,29,30,29,0,2,8),
		116=>array(0,30,29,30,29,29,30,29,30,30,29,30,30,0,3,9),
		117=>array(6,29,30,29,30,29,29,30,29,30,29,30,30,30,4,10),
		118=>array(0,29,30,29,30,29,29,30,29,30,29,30,30,0,5,11),
		119=>array(0,30,29,30,29,30,29,29,30,29,29,30,30,0,6,12),
		120=>array(4,29,30,30,30,29,30,29,29,30,29,30,29,30,7,1)
		);
		
		$cdate_tianganarray=array("null","Jia","Yi","Bing","Ding","Wu","Ji","Geng","Xin","Ren","Kui");
		
		$cdate_dizhiarray=array("null","Zi","Chou","Yin","Mao","Chen","Si","Wu","Wei","Shen","You","Xu","Hai");
					   
		$cdate_zodiacarray=array("null","Rat","Ox","Tiger","Rabbit","Dragon","Snake","Horse","Sheep","Monkey","Rooster","Dog","Pig");
				 
		$cdate_total=11;
		$cdate_cntotal=0;
		
		
		
		for ($y=1901;$y<$year;$y++){
			  $cdate_total+=365;
			  if ($y%4==0) $cdate_total ++;
		}
		
		switch ($month){
				 case 12:
					  $cdate_total+=30;
				 case 11:
					  $cdate_total+=31;
				 case 10:
					  $cdate_total+=30;
				 case 9:
					  $cdate_total+=31;
				 case 8:
					  $cdate_total+=31;
				 case 7:
					  $cdate_total+=30;
				 case 6:
					  $cdate_total+=31;
				 case 5:
					  $cdate_total+=30;
				 case 4:
					  $cdate_total+=31;
				 case 3:
					  $cdate_total+=28;              
				 case 2:
					  $cdate_total+=31;              
		}  
		
		if ($year%4==0 and $month>2){
			 $cdate_total++;
		}
		
		$cdate_total = $cdate_total+($day-1);
		
		$myeardiff = $year-1900;
		
		for ($x=0;$x<=$myeardiff;$x++){
			for ($y=1;$y<=13;$y++){
				if ($cdate_cntotal<$cdate_total){
				$cdate_cntotal+=$cdate_monthdata[$x][$y];
				$cdate_cnyear = $x;
				$cdate_cnmonth = $y;
				}
			}
		}
		
		if (($cdate_cnmonth==$cdate_monthdata[$cdate_cnyear][0]+1)&&($cdate_monthdata[$cdate_cnyear][0]>0)) {
		$cdate_leap=1;
		}else{
		$cdate_leap=0;
		}
		
		$cdate_cnday=$cdate_monthdata[$cdate_cnyear][$cdate_cnmonth]-($cdate_cntotal-$cdate_total);
		
		if (($cdate_monthdata[$cdate_cnyear][0]>0)&&($cdate_monthdata[$cdate_cnyear][0]<$cdate_cnmonth)) {
		$cdate_cnmonth = $cdate_cnmonth-1;
		}
		
		$cdate_tiangan = $cdate_tianganarray[$cdate_monthdata[$cdate_cnyear][14]];
		$cdate_dizhi = $cdate_dizhiarray[$cdate_monthdata[$cdate_cnyear][15]];
		$cdate_zodiac = $cdate_zodiacarray[$cdate_monthdata[$cdate_cnyear][15]];
		$cdate_cnyear += 1900;
		
		$cdate_result = array($cdate_cnyear,$cdate_cnmonth,$cdate_cnday,$cdate_leap,$cdate_tiangan,$cdate_dizhi);
		
		return $cdate_result;
	
	}

    function get_disp_html ($disp_name)
	{
		$this->db->fetch_array($this->db->query("SELECT * FROM ".$this->tb_display." WHERE disp_name LIKE '$disp_name' "));
		if ($this->db->record['disp_html']) {
		        $this->db->record['disp_html'] = ereg_replace("\"", "\\\"", $this->db->record['disp_html']);
		}else{
			 return false;
		}
        return $this->db->record['disp_html'];
	}
function show_tb_data ($sql_str,$header,$data,$footer) 
{  
	$sql_query = $sql_str;
	$query = $this->db->query ($sql_str); 
	$i=0;
	$num_rows = mysql_num_rows ($query);

	 eval("\$display_html = \"".$this->get_disp_html ($header)."\";");// Header
	    while ($i < $num_rows) {
			$fields_data = $db->db_fetch_array($query);
			
			if ($class_td =="DataTD"){ //เธชเธฅเธฑเธเธชเธต
                  $class_td ="AltDataTD";
			}else{
				  $class_td ="DataTD";
			}
         // Get data name from system
		   while(list($key, $val) = each($fields_data))
           {
			    if (eregi("_id",$key) && eregi ($key,$this->str_field_id))
               {
					   $key_name = eregi_replace ("_id","_name",$key);
					   $fields_data[$key_name]=$this->get_data_sys_name ($key,$val);
			   }

			   //---------------------  Change number patern ---------------------- 
					$fields_type = $this->db->get_field_type_f_sql ($key,$sql_str);
					 if ($fields_type == "int")
						  $fields_num[$key] = number_format($fields_data[$key],0,'.',',');
					 if ($fields_type == "real")
						 $fields_num[$key] = number_format($fields_data[$key],2,'.',',');
		   }

			eval("\$display_html .= \"".$this->get_disp_html ($data)."\";");// Data
			$i++;
        }
    eval("\$display_html .= \"".$this->get_disp_html ($footer)."\";");// footer
   print $display_html;
  }

   function source_auto_close () 
  { 
	   print   "<script>";
	   print   "       function auto_close () {";
	   print    "                setTimeout(\"closeWin()\",2000)";
       print    "       }";
       print    "       function closeWin() {";
       print    "         self.close();";
       print    "       }";
	   print    "</script>";
   }
  function user_fucn_java ($func_name)
	{
	   print "<script>";
	   print    $func_name.";";
	   print "</script>";
	}

	function print_result ($msg_result) 
	{
		  eval("\$display_html=\"".$this->get_disp_html ("print_result")."\";");
		  print $display_html;
	}

		function button_back () 
	{
		  eval("\$display_html=\"".$this->get_disp_html ("button_back")."\";");
		  print $display_html;
	}

    function show_disp_html ($disp_name){
	
		  eval("\$display_html=\"".$this->get_disp_html ($disp_name)."\";");
		  print $display_html;

	}
	function first_value_list ($f_name,$f_value,$f_str)
    {
           if (empty($f_value) || $f_value == "%"){
			   print "<option value=\"\">".$f_str."</option>";
		   }else{
			   print "<option value=\"$f_value\">".$f_name."</option>";
		   }
	}
 function ddw_list ($sql_str,$f_name,$f_value)
  {
	  $this->db->query ($sql_str);
	   while ($this->db->fetch_array($this->db->result))
	  {
		  print "<option value='".$this->db->record[$f_value]."'>".$this->db->record[$f_name]."</option>";
	  }
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

   function ddw_list_selected_re ($sql_str,$f_name,$f_value,$select_value)
  {
	  $this->db->query ($sql_str);
	   while ($this->db->fetch_array($this->db->result))
	  {
          if ($this->db->record[$f_value] == $select_value)
			   $str_selected = "selected";
		  else
               $str_selected = ""; 
		  $option .= "<option value='".$this->db->record[$f_value]."'".$str_selected.">".$this->db->record[$f_name]."</option>";
	  }
       return $option;
  }

function ddw_list_sys ($field_id) 
{
	  if (eregi ($field_id,$this->str_field_id))
	{
		     $tb_name = eregi_replace ("_id","_tb",$field_id);
	         $field_name = eregi_replace ("_id","_name",$field_id);
             $this->ddw_list ("select * from $tb_name",$field_name,$field_id);
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

function get_data_sys_name ($field_id,$field_value)
  {
	//Get data name  form sys data 
     if (eregi ($field_id,$this->str_field_id) && !empty($field_value)) {
	      $tb_name = eregi_replace ("_id","_tb",$field_id);
	      $field_name = eregi_replace ("_id","_name",$field_id);
		  $this->db->fetch_array($this->db->query("SELECT * FROM ".$tb_name." WHERE $field_id LIKE '$field_value' "));
          return $this->db->record[$field_name];
	 }else{
		 return '';
	 }
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

   function ddw_list_month ($lang,$selected)
	{
	     //print '<option>'.$selected;
          if ($lang=="th" || $lang=="en") {
			    
				($lang=="th")?$mont=$this->mont_th:$mont=$this->mont_en;

				 for ($i=0;$i < sizeof($mont);$i++)
		       {       
			          $mont_value = $i+1;
			          if (strlen($mont_value) < 2)
				              $mont_value = "0".$mont_value;
							  
					 if ($mont_value==$selected)
			             $mSelected = 'selected';
			        else
			             $mSelected ='';
			   		  
                     $this->set_option ($mont_value,$mont[$i],$mSelected); 
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

                  $this->set_option ($mont_value,$i,$mSelected);
			   }//end for
		  }

		 
	}

	function ddw_list_year_next ($amt_next,$lang,$selected)
	{
		if ($lang == "th")
			$dif_year = 543;
		else
			$dif_year = 0;
		 $c_year = date ("Y");
		 for ($i=0;$i<$amt_next;$i++)
		{  
			 $year = $c_year + $i;
			 
		   if ($selected== $year)	
			    $ySelected = 'selected';
		  else
			   $ySelected ='';
			   
						 
			  print "<option value=\"".$year."\" $ySelected >".($year + $dif_year)."</option>";
		}
	}
	function ddw_list_year_last ($amt_last,$lang,$selected)
	{
		if ($lang == "th")
			$dif_year = 543;
		else
			$dif_year = 0;

		 $c_year = date ("Y") ;

		 for ($i=0;$i<$amt_last;$i++)
		{  
			 $year = ($c_year - $i);
			  if ($selected== $year)	
			    $ySelected = 'selected';
		  else
			   $ySelected ='';
			   
			  
			  print "<option value=\"".$year."\" $ySelected>".($year + $dif_year)."</option>";
		}
	}
	
	function ddw_list_year_se ($y_start,$y_end,$lang,$selected)
	{
		if ($lang == "th")
			$dif_year = 543;
		else
			$dif_year = 0;
			
		 $c_year = $y_start;
		 for ($i=0;$i<($y_end - $y_start);$i++)
		{  
			 $year = $c_year + $i;
			 
		   if ($selected== $year)	
			    $ySelected = 'selected';
		  else
			   $ySelected ='';
			   
			  print "<option value=\"".$year."\" $ySelected >".($year + $dif_year)."</option>";
		}
	}

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
		/* for ($i=0;$i<($y_end - $y_start);$i++)
		{  
			 $year = $c_year + $i;
			 
		   if ($selected== $year)	
			    $ySelected = 'selected';
		  else
			   $ySelected ='';
			   
			  print "<option value=\"".($year + $dif_year)."\" $ySelected >".($year + $dif_year)."</option>";
		} */
		 for ($yy=$y_start;$yy<=$y_end;$yy++)
		{  			 			 
		   if ($selected== $yy)	
			    $ySelected = 'selected';
		  else
			   $ySelected ='';
			   
			  print "<option value=\"".($yy + $dif_year)."\" $ySelected >".($yy + $dif_year_show)."</option>";
		} 
	}

	function get_mont_name ($mont_value,$lang)
	{
		   if ($lang=="th") {
			    $mont = $this->mont_th;
          }else{
               $mont = $this->mont_en;
		  }
		 return $mont[$mont_value-1];
	}

	function get_year_name ($year_value,$lang)
    {
		  if ($lang == "th")
			$dif_year = 543;
		else
			$dif_year = 0;

		return ($year_value + $dif_year);
	}

 function set_option ($value,$name,$s) 
 {
           $option_str = "<option value=\"".$value."\" $s>".$name."</option>";
		   print $option_str;
  }

  function chk_box_name($sql,$field_show,$field_save,$chkbox_data,$chkbox_name,$amt_chkbox_per_row){ // $chkbox_data is string array
 if ($amt_chkbox_per_row == "") { //Default value
        $amt_chkbox_per_row=4;
 }
 if ($chkbox_data != "") { // case edit data
     $arr_data = explode (":",$chkbox_data); 
     $cnt_data = count ($arr_data);
     $i = 0;
     while ($i < $cnt_data) {
           $num_arr = $arr_data[$i];
           $arr_chk[$num_arr]  = "checked";
          $i++;
     }
 }
       $query = $this->db->query($sql);
	   $num_rows=mysql_num_rows($query);
	   print "<table><tr>";
	      $i=0;
  while($i<$num_rows)
     { 
                $fields_data =$db->db_fetch_array($query);
				eval ("\$data_save=\"".$field_save."\";");
				eval ("\$data_show=\"".$field_show."\";");
                $name=$chkbox_name."[".$i."]";
                $str_chkbox="<input type='checkbox' name='$name' value='$data_save' $arr_chk[$data_save]>";  
     if (($i % $amt_chkbox_per_row == 0) && ($i != 0)) {
        print "</tr><tr><td valign='top'>".$str_chkbox."</td><td valign='top'><font color='#000000'>".$data_show."</font></td>";
     }else{
        print "<td valign='top'>".$str_chkbox."</td><td valign='top'><font color='#000000'>".$data_show."</font></td>";
     }
  
             $i++;
	  } 
	
	  print"</table>";
	  $amt_chkbox_name = "amt_".$chkbox_name;
	  print "<input type=\"hidden\" name=\"$amt_chkbox_name\" value=\"$num_rows\">";
}
 function chk_box_name1($sql,$field_show,$field_save,$chkbox_data,$chkbox_name,$amt_chkbox_per_row){ // $chkbox_data is string array
 if ($amt_chkbox_per_row == "") { //Default value
        $amt_chkbox_per_row=4;
 }
 if ($chkbox_data != "") { // case edit data
     $arr_data = explode (":",$chkbox_data); 
     $cnt_data = count ($arr_data);
     $i = 0;
     while ($i < $cnt_data) {
           $num_arr = $arr_data[$i];
           $arr_chk[$num_arr]  = "checked";
          $i++;
     }
     }
       $query = $this->db->query($sql);
	   $num_rows=mysql_num_rows($query);
	   print "<table><tr>";
	      $i=0;
  while($i<$num_rows)
     { 
                $fields_data =$db->db_fetch_array($query);
				eval ("\$data_save=\"".$field_save."\";");
				eval ("\$data_show=\"".$field_show."\";");
				$i1 = $i.substr($data_save,"0","2");
                $name=$chkbox_name."[".$i1."]";
                $str_chkbox="<input type='checkbox' name='$name' value='$data_save' $arr_chk[$data_save]>";  
     if (($i % $amt_chkbox_per_row == 0) && ($i != 0)) {
        print "</tr><tr><td valign='top'>".$str_chkbox."</td><td valign='top'><font color='#000000'>".$data_show."</font></td>";
     }else{
        print "<td valign='top'>".$str_chkbox."</td><td valign='top'><font color='#000000'>".$data_show."</font></td>";
     }
             $i++;
	  } 
	
	  print"</table>";
}
  function get_data_f_chkbox ($sql_str,$chkbox)
  {
	  $str_acc_member = "";
	  $amt_chkbox = $this->db->num_rows($this->db->query(stripslashes($sql_str)));
			
	        for ($i=0;$i<$amt_chkbox;$i++)
			{ 
			   $result = $db->db_fetch_array ($this->db->result);
			   if (!empty($chkbox[$i])) {   
				  if (empty($str_acc_member))
				        $str_acc_member = $chkbox[$i];
				  else
				        $str_acc_member	 .= ":".$chkbox[$i];	 
				}		
			}//for
			return $str_acc_member;
   }

     function get_data_f_chkbox2 ($chkbox_name)
  {
	  $arr_chkbox = $this->lang->http_value ($chkbox_name);
	  $amt_chkbox = $this->lang->http_value ("amt_".$chkbox_name);

	        for ($i=0;$i<$amt_chkbox;$i++)
			{ 
			   if (!empty($arr_chkbox[$i])) {   
				  if (empty($str_acc_member))
				        $str_acc_member = $arr_chkbox[$i];
				  else
				        $str_acc_member	 .= ":".$arr_chkbox[$i];	 
				}		
			}//for
			return $str_acc_member;
   }
   
function show_tb_data_split_page ($sql_str,$header,$data,$footer,$page_size) 
{  
	$sql_query = $sql_str;
	$all_rows = $this->db->num_rows($this->db->query ($sql_str));

	$rt = $all_rows%$page_size;	// เธซเธฒเธเธณเธเธงเธเธซเธเนเธฒเธ—เธฑเนเธเธซเธกเธ”

	if($rt!=0) 
		{ 
			$totalpage = floor($all_rows/$page_size)+1; 
		}
	else 
		{
			$totalpage = floor($all_rows/$page_size); 
		}

	$goto = ($this->page-1)*$page_size;	// เธซเธฒเธซเธเนเธฒเธ—เธตเนเธเธฐเธเธฃเธฐเนเธ”เธ”เนเธ

   $sql_limit = $sql_str." LIMIT $goto, $page_size";
   $query = $this->db->query ($sql_limit); 

	$i=0;
	$num_rows = mysql_num_rows ($query);

	 eval("\$display_html = \"".$this->get_disp_html ($header)."\";");// Header
	    while ($i < $num_rows) {
			$fields_data = $db->db_fetch_array($query);
			
			if ($class_td =="DataTD"){ //เธชเธฅเธฑเธเธชเธต
                  $class_td ="AltDataTD";
			}else{
				  $class_td ="DataTD";
			}
         // Get data name from system
		   while(list($key, $val) = each($fields_data))
           {
			    if (eregi("_id",$key) && eregi ($key,$this->str_field_id))
               {
					   $key_name = eregi_replace ("_id","_name",$key);
					   $fields_data[$key_name]=$this->get_data_sys_name ($key,$val);
			   }
					$fields_type = $this->db->get_field_type_f_sql ($key,$sql_limit);
					 if ($fields_type == "int")
						  $fields_num[$key] = number_format($fields_data[$key],0,'.',',');
					 if ($fields_type == "real")
						 $fields_num[$key] = number_format($fields_data[$key],2,'.',',');

		   }

			eval("\$display_html .= \"".$this->get_disp_html ($data)."\";");// Data
			$i++;
        }
    eval("\$display_html .= \"".$this->get_disp_html ($footer)."\";");// footer
   print $display_html;
  }
  
  function show_tb_data_split_page_comm ($sql_str,$header,$data,$footer,$page_size) 
{  
	$all_rows = $this->db->num_rows($this->db->query ($sql_str));

	$rt = $all_rows%$page_size;	// เธซเธฒเธเธณเธเธงเธเธซเธเนเธฒเธ—เธฑเนเธเธซเธกเธ”

	if($rt!=0) 
		{ 
			$totalpage = floor($all_rows/$page_size)+1; 
		}
	else 
		{
			$totalpage = floor($all_rows/$page_size); 
		}

	$goto = ($this->page-1)*$page_size;	// เธซเธฒเธซเธเนเธฒเธ—เธตเนเธเธฐเธเธฃเธฐเนเธ”เธ”เนเธ

   $sql_limit = $sql_str." LIMIT $goto, $page_size";
   $query = $this->db->query ($sql_limit); 

	$i=0;
	$num_rows = mysql_num_rows ($query);

	 eval("\$display_html = \"".$this->get_disp_html ($header)."\";");// Header
	    while ($i < $num_rows) {
			$fields_data = $db->db_fetch_array($query);
			
			if ($class_td =="DataTD"){ //เธชเธฅเธฑเธเธชเธต
                  $class_td ="AltDataTD";
			}else{
				  $class_td ="DataTD";
			}
         // Get data name from system
		   while(list($key, $val) = each($fields_data))
           {
			    if (eregi("_id",$key) && eregi ($key,$this->str_field_id))
               {
					   $key_name = eregi_replace ("_id","_name",$key);
					   $fields_data[$key_name]=$this->get_data_sys_name ($key,$val);
			   }
		   }

			eval("\$display_html .= \"".$this->get_disp_html ($data)."\";");// Data
			$i++;
        }
	if($all_rows > $page_size){
    eval("\$display_html .= \"".$this->get_disp_html ($footer)."\";");// footer
	}
   print $display_html;
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
						    print "<a href='$PHP_SELF?page_size=$page_size&PAGE=$next_page$link_value'><font color='$link_colr'> เธซเธเนเธฒเธ•เนเธญเนเธ&gt; </font></a>";
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
  $rt = $rows%$page_size;	// เธซเธฒเธเธณเธเธงเธเธซเธเนเธฒเธ—เธฑเนเธเธซเธกเธ”
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
 	function get_date_time_patn ($date_time,$str_patn) // Specail $str_patn "d_th_short"= 21 เธ.เธข. 2456,"dt_th_short"= 21 เธ.เธข. 2456 11:59:59
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

function thCurrency_basic ($str) { // version is limit less than num=9999999,เนเธกเนเธกเธต เธชเธ•เธฒเธเธเน
	    $numTh = array ("เธจเธนเธขเธเน","เธซเธเธถเนเธ","เธชเธญเธ","เธชเธฒเธก","เธชเธตเน","เธซเนเธฒ","เธซเธ","เน€เธเนเธ”","เนเธเธ”","เน€เธเนเธฒ");
		$unit      = array ("เธซเธเนเธงเธข","เธชเธดเธ","เธฃเนเธญเธข","เธเธฑเธ","เธซเธกเธทเนเธ","เนเธชเธ","เธฅเนเธฒเธ"); 
		$strlen = strlen($str);
		$thC=$result=$digit="";
		$pos = $strlen;
		  for ($i=0;$i<$strlen;$i++)
          {     $pos--;
		         $digit = substr($str,$i,1);
				 if ($digit>0) {
				      if ($pos==0){
						if ($strlen>=2 &&  $digit==1) // เนเธกเนเธญเนเธฒเธ เธชเธดเธเธซเธเธถเนเธ
							$numTh[$digit] = "เน€เธญเนเธ”";
						    $thC = $numTh[$digit]; 
                      }else{
					     if ($pos==1 && $digit==2) // เนเธกเนเธกเธต เธชเธญเธเธชเธดเธ
						   $numTh[$digit] = "เธขเธตเน";
                         if ($pos==1 && $digit==1) // เนเธกเนเธกเธต เธซเธเธถเนเธเธชเธดเธ
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

	function thCurrency_decimal ($str) { // Require thCurrency_basic เธกเธตเธชเธ•เธฒเธเธเน
	  $str = number_format($str,2,'.','');
	  $strlen     = strlen ($str);
	  $decimal = strstr($str,".");// Find decimal

        if (!empty($decimal)){  // found decimal
				 $strlen -= strlen($decimal); 
				 if (strlen($decimal) <=2)
                     $footerString = "เธชเธดเธเธชเธ•เธฒเธเธเน";
				 else
                     $footerString = "เธชเธ•เธฒเธเธเน";
				 $thDecimal = $this->thCurrency_basic (substr($decimal,1,2)).$footerString;
        }
          if (empty($decimal) || $decimal==".00")   
               $thDecimal="เธ–เนเธงเธ";
		
				return $this->thCurrency_basic (substr($str,0,$strlen)).'เธเธฒเธ—'.$thDecimal;
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
							$yy-=543; //  เธเธฃเธฑเธเธเธตเธเธฒเธ เธ.เธจ. -> เธ.เธจ.
							
							$x = $workdays = 0;
							$day_name = '99';
							$holidays = 0;
							
							// เธ–เนเธฒเธกเธตเธเธณเธเธงเธเธงเธฑเธ numdays เธเธถเธเธเธฐเน€เธเนเธฒเธกเธฒ เธเธงเธ/เธฅเธ เธงเธฑเธ 							
							while( $x < $numdays ) { // เธ–เนเธฒเธขเธฑเธเนเธกเนเธเธฃเธเธเธณเธเธงเธเธงเธฑเธ
							
								$date_buffer = date("d/m/Y",strtotime($inc_dec."1 days", mktime(0,0,0,$mm,$dd,$yy)));	 // เธเธงเธ/เธฅเธ เธงเธฑเธ เนเธฅเนเธงเน€เธเนเธเธงเธฑเธเธ—เธตเนเนเธงเนเนเธ $date_buffer								
																
								$arr_date2 = explode("/", $date_buffer);	
								$dd = $arr_date2[0];
								$mm = $arr_date2[1];
								$yy = $arr_date2[2];
								$day_name = date("w", mktime(0,0,0,$mm,$dd,$yy)); // check เธงเนเธฒเธงเธฑเธเธญเธฐเนเธฃ
								
								$sqlChk = " SELECT * FROM  HOLIDAY  WHERE HOLIDAY_DATE = '$date_buffer' "; // เธเนเธเธซเธฒเธงเนเธฒ $date_buffer เนเธเนเธงเธฑเธเธซเธขเธธเธ”เธกเธฑเนเธข
								$execChk = $this->db->query($sqlChk);
								$chk_holiday = $this->db->num_rows($execChk);  // $chk_holiday เนเธกเนเน€เธเธดเธ 1
								//echo " $date_buffer เธเธทเธญเธงเธฑเธ [$day_name] เนเธฅเนเธง เธชเธ–เธฒเธเธฐเธงเธฑเธเธซเธขเธธเธ” = $chk_holiday ";		
								
								if(	$day_name == '6' || $day_name == '0' || $chk_holiday > 0 ) { // เธ–เนเธฒเน€เธเนเธเธงเธฑเธเธซเธขเธธเธ” เธเนเธขเธฑเธเนเธกเนเธ•เนเธญเธเธเธฑเธเธงเธฑเธเธ—เธณเธเธฒเธ ( x )									
									$holidays++; // เธเธฑเธเธเธณเธเธงเธเธงเธฑเธเธซเธขเธธเธ”เธเนเธเธญ
								} else { 					 									
									$x++; // เนเธเน concept เธ–เนเธฒเนเธกเนเนเธเนเธงเธฑเธเธซเธขเธธเธ” เธเธถเธเธเธฐเธเธฑเธเธงเธฑเธเธ—เธณเธเธฒเธ เธ”เธตเธเธงเนเธฒ
								}	
							} 
							 //echo " เธกเธตเธงเธฑเธเธซเธขเธธเธ” $holidays เธงเธฑเธ ";										
							$yy+=543; //  เธเธฃเธฑเธเธเธตเธเธฒเธ เธ.เธจ. -> เธ.เธจ.
						$date_out = $dd."/".$mm."/".$yy;	// output เธเธทเธญ เธงเธฑเธเธ—เธตเนเธ—เธตเนเนเธกเนเนเธเนเธซเธขเธธเธ”เนเธฅเนเธง							
				} else {
					$date_out = 'NULL';
				}								
			} else {
				$date_out = 'NULL';
			}
			return $date_out;
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
							$yy-=543; //  เธเธฃเธฑเธเธเธตเธเธฒเธ เธ.เธจ. -> เธ.เธจ.
							
							$date_buffer = date("d/m/Y",strtotime($strtotime, mktime(0,0,0,$mm,$dd,$yy)));	
							
							$arr_date2 = explode("/", $date_buffer);	
							$dd = $arr_date2[0];
							$mm = $arr_date2[1];
							$yy = $arr_date2[2];
														
							$yy+=543; //  เธเธฃเธฑเธเธเธตเธเธฒเธ เธ.เธจ. -> เธ.เธจ.
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
							$yy-=543; //  เธเธฃเธฑเธเธเธตเธเธฒเธ เธ.เธจ. -> เธ.เธจ.
							
							$day_name = date("w", mktime(0,0,0,$mm,$dd,$yy));	
							echo " เธงเธฑเธ $day_name";
																											
				} else {
					$day_name = NULL;
				}								
			} else {
				$day_name = NULL;
			}
			return $day_name;
	 }
	 function convert_date_to_db ($date_in, $DBMS="", $calendar_type="", $year_type=0 ) {
	 		$date_format = $this->DATE_FORMAT;
			
			if($year_type==1) { // เนเธงเนเน€เธเนเธเธงเธฑเธเธ—เธตเนเธเธตเธ เน€เธงเธฅเธฒเธเธฃเธญเธเธงเธฑเธเธ—เธตเนเธเธตเธเธกเธฒ ( เนเธกเนเนเธ”เนเนเธเธฅเธเธเธฒเธเธงเธฑเธเธ—เธตเนเธชเธฒเธเธฅ )
				$date_type = 1;
			} else {
				$date_type = $this->YEAR_FORMAT;
			}
			
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
							if($calendar_type=='CH') {	
								// เธ–เนเธฒเธ•เนเธญเธเธเธฒเธฃเนเธเธฅเธเน€เธเนเธเธงเธฑเธเธ—เธตเนเธเธตเธ เน€เธงเธฅเธฒ input เน€เธเนเธเธงเธฑเธเธ—เธตเนเนเธ—เธข เธซเธฃเธทเธญเธชเธฒเธเธฅ
													
								$arr_china_date = $this->getchinesedate($yy,$mm,$dd);
								
								$fraction = $arr_china_date[0]%4; // เน€เธจเธฉเธเธต เธ–เนเธฒ=0 เธเธทเธญ เธเธตเธ—เธตเน เธ.เธ. เธกเธต 29 เธงเธฑเธ
								
								$ch_month = $arr_china_date[1]*1;
								$ch_day = $arr_china_date[2]*1;
																
								if( $ch_month == 2 && ( ( $fraction != 0 && $ch_day > 28) || ( $fraction == 0 && $ch_day > 29 ) ) )  {									
									$date_out = 'NULL';
								} else if( ( ( $ch_month == 4 || $ch_month == 6 || $ch_month == 9 || $ch_month == 11 ) && ( $ch_day > 30 ) ) || ( $ch_day > 31 ) ) {									
									$date_out = 'NULL';
								} else {
								
									$date_out = $arr_china_date[0]."-".$arr_china_date[1]."-".$arr_china_date[2];				
								}
								
							} else {
								$date_out = $yy."-".$mm."-".$dd; // output
							}
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
		
	
		if($date_out!='NULL') $date_out = "'".$date_out."'";
		
		return $date_out;
	}	
	function convert_year_to_db($yy, $date_type=0) {
		if($date_type==2) {  // $date_type เธเธทเธญ เธฃเธนเธเนเธเธเธเธตเธ•เธญเธเน€เธเนเธ เธฅเธ db
			$yy-=543; // เน€เธเธฅเธตเนเธขเธเธเธฒเธ เธ.เธจ เน€เธเนเธ เธ.เธจ
		} else {
			$yy=$yy;  // เธ–เนเธฒ $date_type == 1 เธเธทเธญ เธ.เธจ. เธญเธขเธนเนเนเธฅเนเธง เธเนเนเธกเนเธ•เนเธญเธ เน€เธเธดเนเธก/เธฅเธ เน€เธเธฃเธฒเธฐเธเธเธดเธ—เธดเธเน€เธฃเธฒเน€เธเนเธ เธ.เธจ. เธญเธขเธนเนเนเธฅเนเธง
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
	 function convert_date_to_show ($date_in, $wantTime, $LongDate=0, $DBMS="", $calendar_type="" ) {
			if(empty($DBMS)) $DBMS = strtoupper($this->db->typeConn);  // MYSQL

			$fromDBMS = "MSSQL";		
			
			$date_format = $this->DATE_FORMAT;
			
			if($calendar_type=='CH') {
				$date_type = 1; // เนเธเธ—เธตเนเธเธตเนเนเธกเนเธ•เนเธญเธเธเธฒเธฃเนเธซเนเธกเธตเธเธฒเธฃเธเธฃเธฑเธเธเธตเน€เธเนเธเธ.เธจ. เธ–เนเธฒเธเธตเธกเธฒเน€เธเนเธ เธ.เธจ. เธเนเธเธฐเธญเธญเธ เธ.เธจ. เน€เธเนเธเธเธฑเธ
			} else {
				$date_type = $this->YEAR_FORMAT; 
				// เนเธ”เธขเธเธเธ•เธด เธ–เนเธฒเน€เธเนเธเน€เธเนเธ เธ.เธจ. เนเธฅเธฐ $date_type = 2 เธเธฐเนเธ”เธเนเธเธฅเธเน€เธเนเธ เธ.เธจ.
			}
			//echo "db_type: ".$this->db;
			if(!empty($date_in)) {
				if( strlen($date_in) >= 8 && eregi("[0-9]", $date_in) ) {
				//echo $date_format."<br>";
						if( $DBMS == "MSSQL") { 							
																	
							if($date_format == 'mm/dd/yyyy') {	
									
									$arrDateTime = explode(" ", $date_in); // separate Time								
									$last_index = count($arrDateTime)-1;
									$timepart = $arrDateTime[$last_index]; // time
										
									if($fromDBMS=="MSSQL") { // เธญเนเธฒเธเธงเธฑเธเธ—เธตเนเธเธฒเธเธ—เธตเนเน€เธเนเธเนเธ MSSQL เนเธ”เธขเธ•เธฃเธ							
										
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
										
										if( $dd < 10 ) {
											$dd = "0".$dd;
										} 
										if( $mm < 10 ) {
											$mm = "0".$mm;
										}	

									} else { // เธญเนเธฒเธเธงเธฑเธเธ—เธตเนเธเธฒเธเธ—เธตเนเน€เธเนเธเนเธ MYSQL เนเธ•เนเน€เธเนเธเธฃเธนเธเนเธเธเธเธญเธ DBMS เธญเธทเนเธ ( เน€เธเนเธ MSSQL )
										$datepart = $arrDateTime[0];																	
										
										$arr_date = explode("/",$datepart);
										$dd = $arr_date[1];
										$mm = $arr_date[0];
										$yy = $arr_date[2];
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
									$yy = $arr_date[2];
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
											} // 2 เธช.เธ. 2006
																	
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
								
								// $date_out = $dd."/".$mm."/".$yy; // output
								
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
			if($date_type==2) {  // $date_type เธเธทเธญ เธฃเธนเธเนเธเธเธเธตเธ•เธญเธเน€เธเนเธ เธฅเธ db 
				$yy+=543; // เน€เธเธฅเธตเนเธขเธเธเธฒเธ เธ.เธจ. เน€เธเนเธ เธ.เธจ
			} else {
				$yy=$yy; // เธ–เนเธฒ $date_type == 1 เธเธทเธญ เธ.เธจ. เธญเธขเธนเนเนเธฅเนเธง เธเนเนเธกเนเธ•เนเธญเธ เน€เธเธดเนเธก/เธฅเธ เน€เธเธฃเธฒเธฐเธเธเธดเธ—เธดเธเน€เธฃเธฒเน€เธเนเธ เธ.เธจ. เธญเธขเธนเนเนเธฅเนเธง
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
			if( $Array[2] > 1900 ) { // เนเธเนเธเธฑเธเธซเธฒ เธงเธฑเธเธ—เธตเน default เธเธญเธ mssql
						$Array[0] = sprintf("%02d",$Array[0]);
						if($lang=='TH') {
							$Array[2]+=543;
						}
						
					if($FM=='mm/dd/YY') {
						switch(trim($Array[1])){
							case "เธก.เธ." : $forMat="01/".$Array[0]."/".$Array[2];break;
							case "เธ.เธ." : $forMat="02/".$Array[0]."/".$Array[2];break;
							case "เธกเธต.เธ." : $forMat="03/".$Array[0]."/".$Array[2];break;
							case "เน€เธก.เธข." : $forMat="04/".$Array[0]."/".$Array[2];break;
							case "เธ.เธ." : $forMat="05/".$Array[0]."/".$Array[2];break;
							case "เธกเธด.เธข." : $forMat="06/".$Array[0]."/".$Array[2];break;
							case "เธ.เธ." : $forMat="07/".$Array[0]."/".$Array[2];break;
							case "เธช.เธ." : $forMat="08/".$Array[0]."/".$Array[2];break;
							case "เธ.เธข." : $forMat="09/".$Array[0]."/".$Array[2];break;
							case "เธ•.เธ." : $forMat="10/".$Array[0]."/".$Array[2];break;
							case "เธ.เธข." : $forMat="11/".$Array[0]."/".$Array[2];break;
							case "เธ.เธ." : $forMat="12/".$Array[0]."/".$Array[2];break;
						 }
					}
					else if($FM=='dd/mm/YY') {
						switch(trim($Array[1])){
							case "เธก.เธ." : $forMat=$Array[0]."/"."01/".$Array[2];break;
							case "เธ.เธ." : $forMat=$Array[0]."/"."02/".$Array[2];break;
							case "เธกเธต.เธ." : $forMat=$Array[0]."/"."03/".$Array[2];break;
							case "เน€เธก.เธข." : $forMat=$Array[0]."/"."04/".$Array[2];break;
							case "เธ.เธ." : $forMat=$Array[0]."/"."05/".$Array[2];break;
							case "เธกเธด.เธข." : $forMat=$Array[0]."/"."06/".$Array[2];break;
							case "เธ.เธ." : $forMat=$Array[0]."/"."07/".$Array[2];break;
							case "เธช.เธ." : $forMat=$Array[0]."/"."08/".$Array[2];break;
							case "เธ.เธข." : $forMat=$Array[0]."/"."09/".$Array[2];break;
							case "เธ•.เธ." : $forMat=$Array[0]."/"."10/".$Array[2];break;
							case "เธ.เธข." : $forMat=$Array[0]."/"."11/".$Array[2];break;
							case "เธ.เธ." : $forMat=$Array[0]."/"."12/".$Array[2];break;
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
			case "เธก.เธ." : $Array[2]."-01-".$Array[0];break;
					case "เธก.เธ." : $forMat=$Array[2]."-01-".$Array[0];break;
					case "เธ.เธ." : $forMat=$Array[2]."-02-".$Array[0];break;
					case "เธกเธต.เธ." : $forMat=$Array[2]."-03-".$Array[0];break;
					case "เน€เธก.เธข." : $forMat=$Array[2]."-04-".$Array[0];break;
					case "เธ.เธ." : $forMat=$Array[2]."-05-".$Array[0];break;
					case "เธกเธด.เธข." : $forMat=$Array[2]."-06-".$Array[0];break;
					case "เธ.เธ." : $forMat=$Array[2]."-07-".$Array[0];break;
					case "เธช.เธ." : $forMat=$Array[2]."-08-".$Array[0];break;
					case "เธ.เธข." : $forMat=$Array[2]."-09-".$Array[0];break;
					case "เธ•.เธ." : $forMat=$Array[2]."-10-".$Array[0];break;
					case "เธ.เธข." : $forMat=$Array[2]."-11-".$Array[0];break;
					case "เธ.เธ." : $forMat=$Array[2]."-12-".$Array[0];break;
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
			'เธ' => "&#3585;", 'เธ' => "&#3586;", 'เธ' => "&#3587;", 'เธ' => "&#3588;", 'เธ…' => "&#3589;", 'เธ' => "&#3590;", 'เธ' => "&#3591;",
			'เธ' => "&#3592;", 'เธ' => "&#3593;", 'เธ' => "&#3594;", 'เธ' => "&#3595;", 'เธ' => "&#3596;", 'เธ' => "&#3597;", 'เธ' => "&#3598;",
			'เธ' => "&#3599;", 'เธ' => "&#3600;", 'เธ‘' => "&#3601;", 'เธ’' => "&#3602;", 'เธ“' => "&#3603;", 'เธ”' => "&#3604;", 'เธ•' => "&#3605;",
			'เธ–' => "&#3606;", 'เธ—' => "&#3607;", 'เธ' => "&#3608;", 'เธ' => "&#3609;", 'เธ' => "&#3610;", 'เธ' => "&#3611;", 'เธ' => "&#3612;",
			'เธ' => "&#3613;", 'เธ' => "&#3614;", 'เธ' => "&#3615;", 'เธ ' => "&#3616;", 'เธก' => "&#3617;", 'เธข' => "&#3618;", 'เธฃ' => "&#3619;",
			'เธค' => "&#3620;", 'เธฅ' => "&#3621;", 'เธฆ' => "&#3622;", 'เธง' => "&#3623;", 'เธจ' => "&#3624;", 'เธฉ' => "&#3625;", 'เธช' => "&#3626;",
			'เธซ' => "&#3627;", 'เธฌ' => "&#3628;", 'เธญ' => "&#3629;", 'เธฎ' => "&#3630;", 'เธฏ' => "&#3631;", 'เธฐ' => "&#3632;", 'เธฑ' => "&#3633;",
			'เธฒ' => "&#3634;", 'เธณ' => "&#3635;", 'เธด' => "&#3636;", 'เธต' => "&#3637;", 'เธถ' => "&#3638;", 'เธท' => "&#3639;", 'เธธ' => "&#3640;",
			'เธน' => "&#3641;", 'เธบ' => "&#3642;", 'เธฟ' => "&#3647;", 'เน€' => "&#3648;", 'เน' => "&#3649;", 'เน' => "&#3650;", 'เน' => "&#3651;",
			'เน' => "&#3652;", 'เน…' => "&#3653;", 'เน' => "&#3654;", 'เน' => "&#3655;", 'เน' => "&#3656;", 'เน' => "&#3657;", 'เน' => "&#3658;",
			'เน' => "&#3659;", 'เน' => "&#3660;", 'เน' => "&#3661;", 'เน' => "&#3662;", 'เน' => "&#3663;", 'เน' => "&#3664;", 'เน‘' => "&#3665;",
			'เน’' => "&#3666;", 'เน“' => "&#3667;", 'เน”' => "&#3668;", 'เน•' => "&#3669;", 'เน–' => "&#3670;", 'เน—' => "&#3671;", 'เน' => "&#3672;",
			'เน' => "&#3673;", 'เน' => "&#3674;", 'เน' => "&#3675;");
		
			$th2unimap2 = array( // เธชเธณเธซเธฃเธฑเธเนเธกเนเธกเธตเธชเธฃเธฐเธญเธขเธนเนเธเนเธฒเธเธซเธเนเธฒ
			'เน' => "&#3656;", 
			'เน' => "&#3657;", 
			'เน' => "&#3658;",
			'เน' => "&#3659;", 
			'เน' => "&#3660;"
			);
		
			$th2unimap3 = array( // เธชเธณเธซเธฃเธฑเธเธกเธต เธญเธฑเธเธฉเธฃเธกเธตเธซเธฒเธเธญเธขเธนเนเธเนเธฒเธเธซเธเนเธฒ
			'เธด' => "&#3636;",
			'เธต' => "&#3637;", 
			'เธถ' => "&#3638;", 
			'เธท' => "&#3639;",
			'เน' => "&#3656;", 
			'เน' => "&#3657;", 
			'เน' => "&#3658;",
			'เน' => "&#3659;", 
			'เน' => "&#3660;",
			'เธฑ' => "&#3633;",
			'เน' => "&#3661;",
			'เน' => "&#3662;"
			);
		
			$th2unimap4 = array( // เธชเธณเธซเธฃเธฑเธเธกเธต 2 เธญเธฑเธเธฉเธฃเธกเธตเธซเธฒเธเธญเธขเธนเนเธเนเธฒเธเธซเธเนเธฒ เนเธฅเธฐ 1 เธ•เธฑเธงเธญเธฑเธเธฉเธฃเธเนเธฒเธเธซเธเนเธฒเน€เธเนเธเธชเธฃเธฐเธเธ
			'เน' => "&#3656;", 
			'เน' => "&#3657;", 
			'เน' => "&#3658;",
			'เน' => "&#3659;", 
			'เน' => "&#3660;"
			);
		
			$th2unimap5 = array( // เธชเธณเธซเธฃเธฑเธ เธ เธ เธฃเนเธงเธกเธเธฑเธ เธชเธฃเธฐเธญเธธ เธญเธน เนเธฅเธฐ เธญเธบ
			'เธ' => "&#3597;", 
			'เธ' => "&#3600;", 
			);
			
			$sto = '';
			$len = strlen($sti);
			for ($i = 0; $i < $len; $i++) {
				if ($th2unimap[$sti{$i}]) {
					if ($i < $len && in_array($sti{$i}, Array('เธ','เธ')) && in_array($sti{$i+1}, Array('เธน','เธธ','เธบ'))) {
						$sto .= $th2unimap5[$sti{$i}];
					}
					elseif ($i > 1 && in_array($sti{$i-2}, Array('เธ','เธ','เธ')) && 
						($sti{$i-1} == 'เธฑ'  || ($sti{$i-1} >= 'เธด' && $sti{$i-1} <= 'เธท')) &&
						$th2unimap4[$sti{$i}]) {
						$sto .= $th2unimap4[$sti{$i}];
					}
					elseif ($i > 0) {
						if (in_array($sti{$i-1}, Array('เธ','เธ','เธ')) && $th2unimap3[$sti{$i}])
							$sto .= $th2unimap3[$sti{$i}];
						elseif (!($sti{$i-1} == 'เธฑ'  || ($sti{$i-1} >= 'เธด' && $sti{$i-1} <= 'เธท')) && $th2unimap2[$sti{$i}])
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
		$sign="<div align='center'>$sign</div>";
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

	function add_dad($value) {  // เธ•เธฃเธงเธเธชเธญเธเธงเนเธฒเธเนเธฒ เน€เธเนเธ 0.00 เนเธซเนเนเธชเนเน€เธเธฃเธทเนเธญเธเธซเธกเธฒเธข - (เธฅเธ)
			if ($value<0) {		
					$out_value = "(".number_format(abs($value),2).")";	
			} else if ($value>0){
					$out_value = number_format(abs($value),2);	
			} else {
					$out_value ="<div align=\"center\">-</div>";
			}		//end els

			return $out_value; 
	}
	
	function passgen($len){
		$code="abcdefghijkmnopqrstuvwxyABCDEFGHIJKLMNPQRSTUVWXYZ123456789";
		srand((double)microtime()*1000000);
		for($i=0;$i<$len;$i++){
		 $password .= $code[rand()%strlen($code)];
		}
		return $password ;
	}

	function convert_qoute_to_db($str) {		
		return	htmlspecialchars($str, ENT_QUOTES);	 // เนเธเธฅเธ ' เนเธซเนเน€เธเนเธ &#039;
	}
	function convert_qoute_to_show($str_in) {
			$str_in = ereg_replace("&quot;",'"',$str_in);
			$str_in = ereg_replace("&#039;","'",$str_in);
			$str_in = ereg_replace("&amp;",'&',$str_in);
			$str_in = ereg_replace("&lt;",'<',$str_in);
			$str_in = ereg_replace("&gt;",'>',$str_in);
			$str_in = ereg_replace("&",'%26',$str_in);
			return $str_in;
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
	  function create_address($arr_address, $outputType='', $text_pdf='') {  // outputType เธ–เนเธฒเน€เธเนเธ 1 เน€เธญเธฒเนเธเน เธ•เธณเธเธฅ เธญเธณเน€เธ เธญ เธเธฑเธเธซเธงเธฑเธ”																									
			if($text_pdf) {
				$space_bar = ' ';
			} else {
				$space_bar = '&nbsp;&nbsp;';
			}
			if(!$outputType) {
					if($arr_address["add_no"]) {
						if(!eregi("เน€เธฅเธเธ—เธตเน^",$arr_address["add_no"]) && !eregi("เธเนเธฒเธเน€เธฅเธเธ—เธตเน^",$arr_address["add_no"]) ) {
								$address_text .= "เน€เธฅเธเธ—เธตเน ".$arr_address["add_no"];
						} else {
								$address_text .= $space_bar.$arr_address["add_no"];
						}
					}
					if($arr_address["moo"]) {
						if(!eregi("เธซเธกเธนเน^",$arr_address["moo"]) ) {
								$address_text .= $space_bar."เธซเธกเธนเน".$arr_address["moo"];
						} else {
								$address_text .= $space_bar.$arr_address["moo"];
						}
					}
					if($arr_address["soi"]) {
						if(!eregi("เธเธญเธข^",$arr_address["soi"]) && !eregi("เธ.^",$arr_address["soi"])  ) {
								$address_text .= $space_bar."เธ.".$arr_address["soi"];
						} else {
								$address_text .= $space_bar.$arr_address["soi"];
						}
					}
					if($arr_address["road"]) {
						if(!eregi("เธ–เธเธ^",$arr_address["road"]) && !eregi("เธ–.^",$arr_address["road"])  ) {
								$address_text .= $space_bar."เธ–.".$arr_address["road"];
						} else {
								$address_text .= $space_bar.$arr_address["road"];
						}
					}
			} // end if !$outputType													
				if(eregi("(เธเธฃเธธเธเน€เธ—เธ)|(เธเธ—เธก)", $arr_address["province_name"]) ) {	// เธ–เนเธฒเน€เธเนเธ  เธเธ—เธก.
						if($arr_address["tambon_name"]) {
								if(!eregi("เนเธเธงเธ^",$arr_address["tambon_name"]) && !eregi("เธ•เธณเธเธฅ^",$arr_address["tambon_name"]) && !eregi("เธ•.^",$arr_address["tambon_name"]) ) {
									$address_text .= $space_bar."เนเธเธงเธ".$arr_address["tambon_name"];
								} else {
									$address_text .= $space_bar.$arr_address["tambon_name"];
								}
						}
						if($arr_address["amphur_name"]) {
								if(!eregi("เน€เธเธ•^",$arr_address["amphur_name"]) && !eregi("เธญเธณเน€เธ เธญ^",$arr_address["amphur_name"]) && !eregi("เธญ.^",$arr_address["amphur_name"]) ) {
									$address_text .= $space_bar."เน€เธเธ•".$arr_address["amphur_name"];
								} else {
									$address_text .= $space_bar.$arr_address["amphur_name"];
								}
						}
						if($arr_address["province_name"]) {						
								$address_text .= $space_bar.$arr_address["province_name"];							
						}										
				} else { 			
						if($arr_address["tambon_name"]) {
								if(!eregi("เธ•เธณเธเธฅ^",$arr_address["tambon_name"]) && !eregi("เธ•.^",$arr_address["tambon_name"]) ) {
									$address_text .= $space_bar."เธ•.".$arr_address["tambon_name"];
								} else {
									$address_text .= $space_bar.$arr_address["tambon_name"];
								}
						}
						if($arr_address["amphur_name"]) {
								if(!eregi("เธญเธณเน€เธ เธญ^",$arr_address["amphur_name"]) && !eregi("เธญ.^",$arr_address["amphur_name"]) ) {
									$address_text .= $space_bar."เธญ.".$arr_address["amphur_name"];
								} else {
									$address_text .= $space_bar.$arr_address["amphur_name"];
								}
						}		
						if($arr_address["province_name"]) {
							if( !eregi("เธเธฑเธเธซเธงเธฑเธ”^",$arr_address["province_name"]) && !eregi("เธ.^",$arr_address["province_name"]) ) {				
								$address_text .= $space_bar."เธ. ".$arr_address["province_name"];	
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
	  function ddw_list_year($start_year, $end_year, $type_value=0, $type_show=1, $selected_value=0 ) { // 0 เธเธทเธญ เธ.เธจ. 1 เธเธทเธญ เธ.เธจ.
			if($start_year > $end_year) {
						// เธงเธ loop เธเธต เนเธเธเธฅเธ”เธเธต					
					for($yy=$start_year;$yy>=$end_year;$yy--) { 
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
			} else{  // เธงเธ loop เธเธต เนเธเธเน€เธเธดเนเธกเธเธต
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
			
	  }

	function DateDiff($date1,$date2,$interval='d', $noHoliday=0) { // require  date input as dd/mm/yyyy  เธ.เธจ.	 
				//$date_format = $this->DATE_FORMAT;
				//$date_type = $this->YEAR_FORMAT;
							
				if(!empty($date1)) {
					if( strlen($date1) >= 8 && eregi("[0-9]", $date1) ) {
										
							$arr_date1 = explode("/",$date1);							
							$dd1 = $arr_date1[0];
							$mm1 = $arr_date1[1];
							$yy1 = $arr_date1[2];							
						$yy1-=543; //  เธเธฃเธฑเธเธเธตเธเธฒเธ เธ.เธจ. -> เธ.เธจ.
					}
				}
				if(!empty($date2)) {
					if( strlen($date2) >= 8 && eregi("[0-9]", $date2) ) {
										
							$arr_date2 = explode("/",$date2);							
							$dd2 = $arr_date2[0];
							$mm2 = $arr_date2[1];
							$yy2 = $arr_date2[2];							
						$yy2-=543; //  เธเธฃเธฑเธเธเธตเธเธฒเธ เธ.เธจ. -> เธ.เธจ.
					}
				}
					//  ************เธ–เนเธฒเธเธต เธ.เธจ. เน€เธเธดเธ 2500 เธกเธฑเธเธเธฐ error
					
					//echo "$dd2,$mm2,$yy2 - $dd1,$mm1,$yy1<br>";
					//exit;
				   if($arr_date1 && $arr_date2) {
						// get the number of seconds between the two dates 
						$timedifference = mktime(0,0,0,$mm2,$dd2,$yy2)-mktime(0,0,0,$mm1,$dd1,$yy1);
						//echo "$date2 - $date1 เธซเนเธฒเธเธเธฑเธ $timedifference เธงเธดเธเธฒเธ—เธต<BR>";
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

	 

	function integerToThai($number){
	//trail off all the zero at the beginning
	$number=ltrim($number,' 0');
	if($number==''){
	return 'เธจเธนเธเธขเน';
	}
	if($number=='1'){
	return 'เธซเธเธถเนเธ';
	}
	//it is easier to work in an inverted one
	$number=strrev($number);
	return millionToThaiHelper($number,'',true);
	}

	//a helper function that takes care of > million number
	function millionToThaiHelper($rnumber,$sofar,$first){
	if(strcmp($rnumber,'1')==0){
	if($first){return 'เธซเธเธถเนเธ'.$sofar;}
	else{return 'เธซเธเธถเนเธเธฅเนเธฒเธ'.$sofar;}
	}
	else{
	if(strlen($rnumber)>6){
	if($first){
	return millionToThaiHelper(substr($rnumber,6),integerToThaiHelper($rnumber,1,'').$sofar,false);
	}
	else{
	return millionToThaiHelper(substr($rnumber,6),integerToThaiHelper($rnumber,1,'').'เธฅเนเธฒเธ'.$sofar,false);
	}
	}
	else{
	if($first){
	return integerToThaiHelper($rnumber,1,'').$sofar;
	}
	else{
	return integerToThaiHelper($rnumber,1,'').'เธฅเนเธฒเธ'.$sofar;
	} 
	}
	}
	}

	// the same as integer to Thai but this guy can do only up to 10^6-1
	// this function takes in an reversed number that is
	// one hundred is represented by 001
	// digit represents current working digit.
	// tail recursion implementation
	// if the number is more than million it will return เนเธเนเธซเธฅเธฑเธเนเธชเธ
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
	}//0.5 ==> เธซเนเธฒเธชเธดเธเธชเธ•เธฒเธเธเน
	else{
	$decimal=$temp[1].'0';
	}
	}
	}
	if($decimal==0){
	return integerToThai($whole).'เธเธฒเธ—เธ–เนเธงเธ';
	}
	else{
	if($whole!=0){
	return integerToThai($whole).'เธเธฒเธ—'.integerToThai($decimal).'เธชเธ•เธฒเธเธเน';}
	else{
	return integerToThai($decimal).'เธชเธ•เธฒเธเธเน';
	}
	}
	}

	function day_of_month($christ_year,$due_month) { // เธเธณเธเธงเธเธงเธฑเธเนเธเน€เธ”เธทเธญเธ เธเธฑเนเธ เธเธต เธเธฑเนเธ 
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
				fwrite($handle,$var,65535);
				fclose($handle);
	}
	function convert_ddw_date_db($yyyy="",$mm="",$dd="",$hr="",$min="",$sec="") {
			/*if(strlen($yyyy)<4) {
		
			}*/
		if($yyyy*1 >0 && $mm*1 > 0 && $dd*1 > 0 ) {
			$db_date = "'".$yyyy."-".$mm."-".$dd."'";
		} else {
			$db_date = 'NULL';
		}			
			
			return $db_date;
	}
	function convert_date_to_array($input_date) {
		$arr_date = array();
		if(strlen($input_date)>=8) {
			$arr_date = explode("-",$input_date);
		}		
		return $arr_date;
	}	
	function encoding($str) {
		//$arrStr = explode("",$str);		
		$encoded = "";
		for($c=0;$c<strlen($str);$c++) {
			
			$encoded .= ord($str[$c]);		
		}		
		return $encoded;
	}
}// Class
?>