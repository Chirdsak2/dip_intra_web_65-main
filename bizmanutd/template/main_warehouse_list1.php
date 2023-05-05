<?php
	session_start();
	if($_GET[seach]=='Y'){
	$name = iconv('UTF-8', 'UTF-8', $_REQUEST["keyword"]); 
	}
	header ("Content-Type:text/plain;charset=UTF-8");
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	$db->query("USE datawarehouse");
	if($_GET['session_name'] != ''){
	$_GET['session_name'] = urldecode ($_GET['session_name']);
	}
	if($_GET[seach]=='Y'){
	$_REQUEST["keyword"] = $name;
	}else{
	$_REQUEST["keyword"]  = urldecode ($_REQUEST["keyword"]);
	}
		if($_GET['session_name']=='MY'){
	$_GET['session_name'] = 'การประชุมสภาร่างรัฐธรรมนูญ ';
	}
	$thai_number = array('๑','๒','๓','๔','๕','๖','๗','๘','๙','๐');
	$eng_number = array('1','2','3','4','5','6','7','8','9','0');
  	$get_year_no = str_replace($eng_number,$thai_number,$_GET[yearno]);
	$get_year = str_replace($eng_number,$thai_number,$_GET[year]);
	$get_num = str_replace($eng_number,$thai_number,$_GET[num]);
	$get_session_name = str_replace($eng_number,$thai_number,$_GET['session_name']);
?>
<table width="98%" border="0">

<?php
//link  list
if($_GET["id"]==1){
$main = "<a href=\"#G\" onClick=\"show_datawarehouse_list('','','');\" >หน้าหลัก</a>&nbsp;";
}else if($_GET["id"]==2){
$main = "<a href=\"#G\" onClick=\"change_value(5,0,0,'MY','','');\" >หน้าหลัก</a>&nbsp;";
}else if($_GET["id"]==3){
$main = "<a href=\"#G\" onClick=\"change_value(2,'1','','','','');\" >หน้าหลัก</a>&nbsp;";
}else{
$main = "<a href=\"#G\" onClick=\"show_datawarehouse_list('','','');\" >หน้าหลัก</a>&nbsp;";
}
if($get_year_no != "" AND $get_year_no != "๐"){
$link_yearno = "<a href=\"#G\" onClick=\"change_value(2,'".$_GET[yearno]."','','','','');\"  > ชุดที่".$get_year_no."</a>&nbsp;";
}
if($get_year != "" AND $get_year != "๐"){
$link_year = "<a href=\"#G\" onClick=\"change_value(3,'".$_GET[yearno]."','".$_GET[year]."','','','');\"  > ปีที่ ".$get_year."</a>&nbsp;";
}
if($get_session_name != "" AND $get_session_name != "๐"){
$link_session_name = "<a href=\"#G\" onClick=\"change_value(5,'".$_GET[yearno]."','".$_GET[year]."','".urlencode($_GET['session_name'])."','','');\"  > ".$get_session_name."</a>&nbsp;";
}
if($get_num != "" AND $get_num != "๐"){
$link_num = "<a href=\"#G\" onClick=\"change_value(5,'".$_GET[yearno]."','".$_GET[year]."','".urlencode($_GET['session_name'])."','".$_GET[num]."','');\"  > ครั้งที่ ".$get_num."</a>&nbsp;";
}
if($_GET["id"]==1){//เงื่อนไขแสดงตามประของการประชุม
$show_typeid = 'and name_type like "ข้อมูลการประชุมสภาผู้แทนราษฏร"';
}else if($_GET["id"]==2){//เงื่อนไขแสดงตามประของการประชุม
$show_typeid = 'and name_type like "การประชุมสภาร่างรัฐธรรมนูญ"';
}else if($_GET["id"]==3){//เงื่อนไขแสดงตามประของการประชุม
$show_typeid = 'and name_type like "ข้อมูลการประชุมร่วมกันของรัฐสภา"';
}else if($_GET["id"]==4){//เงื่อนไขแสดงตามประของการประชุม
$show_typeid = 'and name_type like "สรุปเหตุการณ์"';
}else{
$show_typeid = 'and name_type like "ข้อมูลการประชุมสภาผู้แทนราษฏร"';
}
if($_GET[level]=='1'){
$sql = "select yearno from data_wh where status = 'U' $show_typeid group by yearno order by  yearno DESC";
$query = $db->query($sql);
while($R = $db->db_fetch_array($query)){
	$sql_yname = $db->query("SELECT year_yname FROM year_no WHERE yearno_id = '".$R[yearno]."' ");
	$Y = $db->db_fetch_row($sql_yname);
?>
  <tr>
    <td width="5%"><img src="mainpic/plus.gif" width="21" height="21"></td>
    <td><a href="#G" onClick="change_value(2,'<?php echo $R[yearno];?>','','','','');" >ชุดที่ <?php echo str_replace($eng_number,$thai_number,$R[yearno]);?> <?php if($Y[0] != ""){ echo "( พ.ศ. ".str_replace($eng_number,$thai_number,$Y[0])." )"; } ?></a></td>
  </tr>
 <?php } 
 }?>
<?php
if($_GET[level]=='2'){
?>
  <tr>
    <td colspan="2"><?php echo $main;?>><?php echo $link_yearno;?><hr width="100%"></td>
  </tr>
<?php
$sql = "select year from data_wh where yearno ='".$_GET[yearno]."' and status = 'U' group by year  order by year DESC";
$query = $db->query($sql);
while($R = $db->db_fetch_array($query)){
?>
  <tr>
    <td width="5%"><img src="mainpic/plus.gif" width="21" height="21"></td>
    <td><a href="#G" onClick="change_value(3,'<?php echo $_GET[yearno];?>','<?php echo $R[year];?>','','','');" >ปีที่ <?php echo str_replace($eng_number,$thai_number,$R[year]);?></a></td>
  </tr>
 <?php 
 }
 }
 ?>
<?php
if($_GET[level]=='4'){

?>
  <tr>
    <td colspan="2"><?php echo $main;?>><?php echo $link_yearno;?>><?php echo $link_year;?>><?php echo $link_session_name;?><hr width="100%"></td>
  </tr>
<?php
$sql = "select num from data_wh where yearno ='".$_GET[yearno]."' and year='".$_GET[year]."' and session_name = '".urldecode($_GET['session_name'])."' and status = 'U' group by session_name ";
$query = $db->query($sql);
while($R = $db->db_fetch_array($query)){
?>
  <tr>
    <td width="5%"><img src="mainpic/plus.gif" width="21" height="21"></td>
    <td><a href="#G" onClick="change_value(5,'<?php echo $_GET[yearno];?>','<?php echo $_GET[year];?>','<?php echo urlencode($R[session_name]);?>','<?php echo $R[num];?>','');" >ครั้งที่ <?php echo str_replace($eng_number,$thai_number,$R[num]);?></a></td>
  </tr>
 <?php 
 }
 }
 ?>
 <?php
if($_GET[level]=='3'){
?>
  <tr>
    <td colspan="2"><?php echo $main;?>><?php echo $link_yearno;?>><?php echo $link_year;?><hr width="100%"></td>
  </tr>
<?php
$sql = "select session_name from data_wh where yearno ='".$_GET[yearno]."' and year='".$_GET[year]."'  and status = 'U'  group by session_name ";
$query = $db->query($sql);
while($R = $db->db_fetch_array($query)){
?>
  <tr>
    <td width="5%"><img src="mainpic/plus.gif" width="21" height="21"></td>
    <td><a href="#G" onClick="change_value(5,'<?php echo $_GET[yearno];?>','<?php echo $_GET[year];?>','<?php echo urlencode($R["session_name"]);?>','','');" > <?php echo str_replace($eng_number,$thai_number,$R[session_name]);?></a></td>
  </tr>
 <?php 
 }
 }
 ?>
 <?php
if($_GET[level]=='5'){
						$limit = "20";
					  if (empty($offset) || $offset < 0) { 
							$offset=0; 
						} 
						 if (empty($pages) || $pages < 0) { 
							$pages=1; 
						} 
?>
  <tr>
       <td colspan="2"><?php echo $main;?>><?php echo $link_yearno;?>><?php echo $link_year;?>><?php echo $link_session_name;?><hr width="100%"></td>
  </tr>
<?php

	$sql = "select meeting_id,name,num from data_wh where yearno ='".$_GET[yearno]."' and year='".$_GET[year]."'  and session_name ='".urldecode ($_GET['session_name'])."'  and status = 'U' group by meeting_id order by num DESC ";
 $query_search = $db->query($sql);
 $sql .= " LIMIT $offset, $limit ";
 $totalrows = $db->db_num_rows($query_search);
$query = $db->query($sql);
while($R = $db->db_fetch_array($query)){
?>
  <tr>
    <td width="5%" align="right" valign="top"><img src="mainpic/bb1.jpg"></td>
    <td><a href="#G" onClick="show_detail('<?php echo $R[meeting_id];?>');" >ครั้งที่ <?php echo str_replace($eng_number,$thai_number,$R[num]);?>  เรื่อง <?php echo $R[name];?></a></td>
  </tr>
 <?php 
 }
 ?>
  <tr>
    <td colspan="2"><hr width="100%">หน้าที่ :
    <?php if ($offset !=0) {   
$prevoffset=$offset-$limit; 
echo   "<a href=\"##F\" onClick=\"change_value(5,'$_GET[yearno]','$_GET[year]','$_GET[session_name]','$_GET[num]','$prevoffset');\" >ย้อนกลับ</a> ";
}


    // Calculate total number of pages in result 
   $pages = intval($totalrows/$limit); 
     
    // $pages now contains total number of pages needed unless there is a remainder from division  
    if ($totalrows%$limit) { 
        // has remainder so add one page  
        $pages++; 
    } 
     $current = ($offset/$limit) - 1;
	 $start = $current - 10;
	 if($start < 1){
	 $start = 1;
	 }
	 $end = $current + 10;
	 	 if($end > $pages){
	 $end = $pages;
	 }
    // Now loop through the pages to create numbered links 
    // ex. 1 2 3 4 5 NEXT 
    for ($i=$start;$i<=$end;$i++) { 
        // Check if on current page 
        if (($offset/$limit) == ($i-1)) { 
            // $i is equal to current page, so don't display a link 
            echo " <font size=\"2\" face=\"MS Sans Serif\"><b>".str_replace($eng_number,$thai_number,$i)."</b></font>"; 
        } else { 
            // $i is NOT the current page, so display a link to page $i 
            $newoffset=$limit * ($i-1); 
                  echo  " <a href=\"##D\" onClick=\"change_value(5,'$_GET[yearno]','$_GET[year]','$_GET[session_name]','$_GET[num]','$newoffset');\" ><font size=\"2\" face=\"MS Sans Serif\">".str_replace($eng_number,$thai_number,$i)."</font></a>"; 
        } 
    } 

?>      <?php 
			if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   " <a href=\"##S\" onClick=\"change_value(5,'$_GET[yearno]','$_GET[year]','$_GET[session_name]','$_GET[num]','$newoffset');\" >ถัดไป</a>"; 
    }  ?></td>
  </tr>
 <?php
 }
 ?>
  <?php
if($_GET[level]=='6'){
?>
  <tr>
    <td colspan="2"><strong><?php echo $main;?></strong></td>
  </tr>
   <tr>
    <td width="5%">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
<?php

					$limit = "20";
					  if (empty($offset) || $offset < 0) { 
							$offset=0; 
						} 
						 if (empty($pages) || $pages < 0) { 
							$pages=1; 
						} 
//case shearch
if(trim($_REQUEST["keyword"]) != '' ){
		include('query_search.php');
//search
$sqlS = "select data_wh.meeting_id,data_wh.name,data_wh.detail,data_wh.session_name,data_wh.yearno,data_wh.year,data_wh.num,data_wh.fulltextt from data_wh $wh where  $seld and data_wh.status = 'U' group by data_wh.meeting_id";
//echo $sqlS;
 $query_search = $db->query($sqlS);
 $sqlS .= " LIMIT $offset, $limit ";
 $totalrows = $db->db_num_rows($query_search);
 ?>
 <?php if($totalrows > 0){ ?>
  <tr> 
    <td colspan="2" align="left" >รายการที่ <strong><?php echo str_replace($eng_number,$thai_number,$offset + 1); ?> 
      - <?php if($totalrows < ($offset + $limit)  ){ echo str_replace($eng_number,$thai_number,number_format($totalrows,0)); }else{ echo str_replace($eng_number,$thai_number,$offset + $limit); } ?></strong> จากผลการค้นหาทั้งหมด <strong><?php echo str_replace($eng_number,$thai_number,number_format($totalrows,0)); ?></strong> 
      รายการของคำค้น <strong><?php echo $data_default; ?></strong></td>
  </tr>
  <?php 
				}
 
$querS = $db->query($sqlS);
?>
<tr><td colspan="2">   <?php
		if($word_b != ""){
			$txtn = "";
			$countnext = explode(" ",$word_b);
			$cn = count($countnext);
			for($n=0;$n<$cn;$n++){
				if(trim($countnext[$n]) != ""){
					if($n < $cn && $n != 0){
					$txtn .= ',';
					}
					$txtn .= " <a href=\"javascript:ajax_search_word('".trim($countnext[$n])."')\"><font color=red>".trim($countnext[$n])."</a></font>  ";
				}
			
			}
			echo "<div>คำใกล้เคียง : ".$txtn."</div>";
		}
		if($word_n != ""){
			$txtn = "";
			$countnext = explode(",",$word_n);
			$cn = count($countnext);
			for($n=0;$n<$cn;$n++){
				if(trim($countnext[$n]) != ""){
					if($n < $cn && $n != 1){
					$txtn .= ',';
					}
					$txtn .= " <a href=\"javascript:ajax_search_word('".trim($countnext[$n])."')\">".trim($countnext[$n])."</a> ";
				}
			}
			if($txtn != ""){
				echo "<div>คำคล้าย : ".$txtn."</div>";
			}
		}
		if($word_d != ""){
			$txtd = "";
			$countnext = explode(",",$word_d);
			$cn = count($countnext);
			for($n=0;$n<$cn;$n++){
				if(trim($countnext[$n]) != ""){
					if($n < $cn && $n != 1){
					$txtn .= ',';
					}
					$txtd .= " <a href=\"javascript:ajax_search_word('".trim($countnext[$n])."')\">".trim($countnext[$n])."</a> ";
				}
			}
			if($txtd != ""){
				echo "<div>คำตรงข้าม : ".$txtd."</div>";
			}
		}
				?><hr width="100%"></td></tr>
<?php
					$search = array ("'<script[^>]*?>.*?</script>'si",  // Strip out javascript
                 "'<[\/\!]*?[^<>]*?>'si",           // Strip out html tags
                 "'([\r\n])[\s]+'",                 // Strip out white space
                 "'&(quot|#34);'i",                 // Replace html entities
                 "'&(amp|#38);'i",
                 "'&(lt|#60);'i",
                 "'&(gt|#62);'i",
                 "'&(nbsp|#160);'i",
                 "'&(iexcl|#161);'i",
                 "'&(cent|#162);'i",
                 "'&(pound|#163);'i",
                 "'&(copy|#169);'i",
                 "'&#(\d+);'e");                    // evaluate as php

$replace = array ("",
                  "",
                  "\\1",
                  "\"",
                  "&",
                  "<",
                  ">",
                  " ",
                  chr(161),
                  chr(162),
                  chr(163),
                  chr(169),
                  "chr(\\1)");


if($totalrows > 0){

while($RS = $db->db_fetch_array($querS)){
				 $topic = $RS[name].$RS[detail].$RS[fulltextt];
				 $topic = preg_replace ($search, $replace, $topic);
				 $mid = $RS[meeting_id];
				 $filename1 = $RS[name];
				 $dt = $type_n;
				
				 for($q = 0;$q<count($dt);$q++){
				 $posR = strpos($dt[$q], "-");
					if ($posR === false and $dt[$q] != ''){
						$pos1 = strpos($topic, $dt[$q]);
							if (!($pos1 === false)) {
								$pos = $pos1;
							}
				  		}
					}
					
					if ($pos != false) { // note: three equal signs
							$pos1 = $pos - 100;
							if($pos1 < 0){
							$pos1 = 0;
							}
								 $rest = cuttag(substr( $topic, $pos1, 200));
								 $atf_array = array();
									for($q = 0;$q<count($dt);$q++){
																		if($dt[$q] != ""){
																		$query_wh2 = '';
																		$rest = ereg_replace($dt[$q],"<font color=\"#FF0000\">".$dt[$q]."</font>", $rest);
																		$filename1 = ereg_replace($dt[$q],"<font color=\"#FF0000\">".$dt[$q]."</font>", $filename1);
																		
																		$sql_attf = "select attach_file_id from attach_file where meeting_id ='".$RS[meeting_id]."' and attach_fulltext like '%".$dt[$q]."%'";
  																			$query_attf = $db->query($sql_attf);
																			while($AF = $db->db_fetch_array($query_attf)){
																				array_push($atf_array,$AF[attach_file_id]);
																			}
																		}
										}
							}else{
					$notype_pos = 'Y';//กรณีที่มัคำค้น										
					$rest = cuttag(substr( $RS[detail],0, 200));
					 $atf_array = array();
					$sql_attf = "select attach_file_id from attach_file where meeting_id ='".$RS[meeting_id]."' ";
  																			$query_attf = $db->query($sql_attf);
																			while($AF = $db->db_fetch_array($query_attf)){
																				array_push($atf_array,$AF[attach_file_id]);
																			}
					}
					$rest .= "...";
?>
  <tr>
    <td align="right" valign="top"><img src="mainpic/bb1.jpg" ></td>
    <td><a href="#G" onClick="show_detail('<?php echo $RS[meeting_id];?>');"><strong><?php echo $filename1;?></strong></a>
	<br><br>
	หมวด: ชุดที่ <?php echo str_replace($eng_number,$thai_number,$RS[yearno]);?>> ปีที่ <?php echo str_replace($eng_number,$thai_number,$RS[year]);?>> <?php echo str_replace($eng_number,$thai_number,$RS["session_name"]);?>> ครั้งที่ <?php echo str_replace($eng_number,$thai_number,$RS[num]);?><br ><br ></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td><?php echo $rest;?><br></td>
  </tr>
  <?php 
  $dt = $type_n;
for($q = 0;$q<count($dt);$q++){
	$posfiletype = strpos($dt[$q], "filetype:");
	$posdoctype = strpos($dt[$q], "doctype:");
	if(!($posfiletype === false) ){
			$FT = explode(':',$dt[$q]);
			$query_wh2 .= " and meeting_id = $mid and  attach_filetype = '".$FT[1]."'";
	}
	if(!($posdoctype === false) ){
			$DT = explode(':',$dt[$q]);
			$query_wh2 .= " and meeting_id = $mid and  status = '".$DT[1]."'";
	}
}
  if($atf_array != ''){
   $afid = implode(",", $atf_array);
 
   if($afid != ""){
  // $query_wh2 .= " and meeting_id = $mid";

$sql_attf = "select * from attach_file where  attach_file_id in  (".$afid.") $query_wh2 ";
  $query_attf = $db->query($sql_attf);
  if($db->db_num_rows($query_attf)>0){

  ?>
  <style type="text/css">
<!--
.styleText {color: #333333; font-family:tahoma; font-size:14px;}
.styleTextlink {color: #333333; font-family:tahoma; font-size:12px;}
-->
</style>
  <tr> <td>&nbsp;</td><td><font color="#666666"><u>เอกสารที่พบ :</u>
  <?php 
  $CT_Word = $type_n;
  while($AFF = $db->db_fetch_array($query_attf)){ 
   if($AFF[status]=='0'){
	 $typereport =  "รายงานการประชุม";
	 }else if($AFF[status]=='1'){
	 $typereport = "บันทึกการประชุม";
	  }else if($AFF[status]=='2'){
	$typereport =  "บันทึกการออกเสียงและลงคะแนน";
	  }else if($AFF[status]=='3'){
	$typereport = "สรุปเหตุการณ์";
	 }
//  print_r($type_n);
$count_num = 0;
  for($CT = 0;$CT<count($CT_Word);$CT++){
  if($CT_Word[$CT] != ''){
  	$explode_word_count = explode($CT_Word[$CT],$AFF[attach_fulltext]);
	//print_r($explode_word_count);
	//$explode_word_count2 = array_intersect (array($CT_Word[$CT]),$explode_word_count);
	//print_r($explode_word_count);
  	$count_num += (count($explode_word_count)-1);
	}
	if($count_num == '0'){
	$notype_pos = 'Y';//กรณีที่มัคำค้น		
	}
  }
  echo "<div><span class=\"styleText\">".$typereport."</span><span class=\"styleTextlink\">- <a href=\"##F\" onclick=\"download('".$AFF[attach_file_id]."','".$RS[meeting_id]."');\" >คลิกเพื่อดูเอกสาร</a> </span>";
  if($notype_pos !='Y'){
  echo "<span class=\"styleTextlink\"> -<a href=\"##F\" onClick=\"window.open('main_warehouse_view.php?attach_file_id=".$AFF[attach_file_id]."&keyword=".urlencode(base64_encode (implode(",", $CT_Word)))."', 'select_org', 'status=yes, menubar=no, scrollbars=yes, resizable=yes, height=450, width=600, left=150,top=100');\"> ค้นพบ &nbsp;(".$count_num.")</a></span>";
  }
  echo "</div>";   }//for?></td></tr>
   <?php
  }//while
   }//if
   }//if 
  }

?>
  <tr>
    <td colspan="2"><hr width="100%">ผลการค้นหาหน้าที่:
      <?php if ($offset !=0) {   
$prevoffset=$offset-$limit; 
echo   " <a href=\"##F\" onclick=\"show_datawarehouse_list('6','".urlencode ($keyword)."','$prevoffset');\">ย้อนกลับ</a> ";
}


    // Calculate total number of pages in result 
   $pages = intval($totalrows/$limit); 
     
    // $pages now contains total number of pages needed unless there is a remainder from division  
    if ($totalrows%$limit) { 
        // has remainder so add one page  
        $pages++; 
    } 
     $current = ($offset/$limit) - 1;
	 $start = $current - 10;
	 if($start < 1){
	 $start = 1;
	 }
	 $end = $current + 10;
	 	 if($end > $pages){
	 $end = $pages;
	 }
    // Now loop through the pages to create numbered links 
    // ex. 1 2 3 4 5 NEXT 
    for ($i=$start;$i<=$end;$i++) { 
        // Check if on current page 
        if (($offset/$limit) == ($i-1)) { 
            // $i is equal to current page, so don't display a link 
            echo " <font size=\"2\" face=\"MS Sans Serif\"><b>".str_replace($eng_number,$thai_number,$i)."</b></font> "; 
        } else { 
            // $i is NOT the current page, so display a link to page $i 
            $newoffset=$limit * ($i-1); 
                  echo  " <a href=\"##D\" onclick=\"show_datawarehouse_list('6','".urlencode ($keyword)."','$newoffset');\"><font size=\"2\" face=\"MS Sans Serif\">".str_replace($eng_number,$thai_number,$i)."</font></a> "; 
        } 
    } 

?>
      <?php 
			if (!((($offset/$limit)+1)==$pages) && $pages!=1) { 
        // Not on the last page yet, so display a NEXT Link 
        $newoffset=$offset+$limit; 
        echo   " <a href=\"##S\" onclick=\"show_datawarehouse_list('6','".urlencode ($keyword)."','$newoffset');\">ถัดไป</a> "; 
    }  ?></td>
  </tr>
  <?php }else{ ?>
  <tr>
    <td>&nbsp;</td>
    <td><br> <font size="2" face="MS Sans Serif">ผลการค้นหา - <?php echo $keyword; ?> 
      - ไม่ตรงกับเอกสารใดเลย <br>
      คำแนะนำ:<br>

      - ขอให้แน่ใจว่าสะกดทุกคำอย่างถูกต้อง<br>
      - ลองคำหลักที่ต่างจากนี้<br>
      - ลองใช้คำหลักทั่วๆไป<br>
      - ลองใช้คำให้น้อยลง</font><br> <br></td>
  </tr>
  <?php } ?>
  	  <?php 
	   } else{
	   ?>
	    <tr>
    <td>&nbsp;</td>
    <td><br> <font size="2" face="MS Sans Serif">ผลการค้นหา - <?php echo $keyword; ?> 
      - ไม่ตรงกับเอกสารใดเลย <br>
      คำแนะนำ:<br>

      - ขอให้แน่ใจว่าสะกดทุกคำอย่างถูกต้อง<br>
      - ลองคำหลักที่ต่างจากนี้<br>
      - ลองใช้คำหลักทั่วๆไป<br>
      - ลองใช้คำให้น้อยลง</font><br> <br></td>
  </tr>
	   <?php
	   }
	   }
 ?>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<?php $db->db_close(); ?>
