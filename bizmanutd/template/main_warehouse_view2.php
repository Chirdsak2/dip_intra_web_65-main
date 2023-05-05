<?php
	session_start();
	header ("Content-Type:text/plain;charset=UTF-8");
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	$db->query("USE datawarehouse");

	$color = array("F6BD0F","AFD8F8","1941A5","8BBA00","A66EDD","F984A1","CCCC00","999999","0099CC","FF0000","006F00","0099FF","FF66CC","669966","7C7CB4","FF9933","9900FF","99FFCC","CCCCFF","669900","AFD8F8","8BBA00","FF8E46","008E8E","D64646","8E468E","588526","B3AA00","008ED6","9D080D","A186BE","F6BD0F","AFD8F8","1941A5","8BBA00","A66EDD","F984A1","CCCC00","999999","0099CC","FF0000","006F00","0099FF","FF66CC","669966","7C7CB4","FF9933","9900FF","99FFCC","CCCCFF","669900","AFD8F8","8BBA00","FF8E46","008E8E","D64646","8E468E","588526","B3AA00","008ED6","9D080D","A186BE");
	//$attach_file_id = "1"; //สมมติให้ id ไฟล์ = 1
$attach_file_id =  $_GET[attach_file_id];
	
$word = urldecode(base64_decode ($_GET["keyword"]));
//$word = ereg_replace(','," ", $word);
	if($word != ""){
	$sql = "";
	$text_result = "";
	$key = explode(",",trim($word));
	$count = count($key);
		for($i=0;$i<$count;$i++){
		if(trim($key[$i]) != ""){
		$posfiletype = strpos($key[$i], "filetype:");
		$posdoctype = strpos($key[$i], "doctype:");
		if(!($posfiletype === false) ){
		$dfi = explode(':',$key[$i]);
			if($dfi[1] =='application/pdf' ){
			$key[$i] = 'filetype:pdf';
			}else if($dfi[1] ==  'application/vnd.ms-excel'){
			$key[$i] ='filetype:xls';
			}else if($dfi[1] == 'application/vnd.ms-powerpoint'){
			$key[$i]= 'filetype:ppt';
			}else if($dfi[1] == 'application/msword'){
			$key[$i]=  'filetype:doc';
			}else if($dfi[1] ==  'text/html'){
			$key[$i]= 'filetype:html';
			}else if($dfi[1] =='message/rfc822'){
			$key[$i] = 'filetype:mht' ;
			}else if($dfi[1] == 'text/plain'){
			$key[$i] = 'filetype:txt';
			}
		}
		if(!($posdoctype === false) ){
		$dfi = explode(':',$key[$i]);
			if($dfi[1] =='0'){
			$key[$i]= 'doctype:รายงานการประชุม';
			}else if($dfi[1] =='1'){
			$key[$i] = 'doctype:บันทึกการประชุม';
			}else if($dfi[1] =='2'){
			$key[$i] = 'doctype:บันทึกการออกเสียงลงคะแนน';
			}else if($dfi[1] =='3'){
			$key[$i] = 'doctype:สรุปเหตุการณ์';
			}
		}
		$sql .= "OR attach_file_index_detail REGEXP '".$key[$i]."' ";
		$text_result .= " <span style=background-color:".$color[$i].">".$key[$i]."</span> &nbsp;";
		}
		}
		if($sql != ""){
		$sql = substr($sql, 3); 
		$sql = " AND ( ".$sql." )";
		}
		//echo $sql;
		$query = $db->query("SELECT attach_file_index_page,attach_file_index_detail,attach_file FROM attach_file_index inner join  attach_file on attach_file_index.attach_file_id= attach_file.attach_file_id WHERE attach_file_index.attach_file_id = '".$attach_file_id."' ".$sql." GROUP BY attach_file_index_page,attach_file_index_detail,attach_file ORDER BY attach_file_index_page ASC");
		
	}
	//ค้นหาชื่อเอกสาร
	$query_head = $db->query("select meeting_name,status from attach_file inner join  meeting on attach_file.meeting_id = meeting.meeting_id WHERE attach_file_id = '".$attach_file_id."' ");
	$RR =  $db->db_fetch_row($query_head);
	$name_head = $RR["0"];
	 if($RR[1]=='0'){
	 $typereport =  "รายงานการประชุม";
	 }else if($RR[1]=='1'){
	 $typereport = "บันทึกการประชุม";
	  }else if($RR[1]=='2'){
	$typereport =  "บันทึกการออกเสียงและลงคะแนน";
	  }else if($RR[1]=='3'){
	$typereport = "สรุปเหตุการณ์";
	 }
	 
	function replace_word($text){
	global $key;
	global $color;
	$text = ereg_replace("   "," ",$text);
	$text = ereg_replace("  "," ",$text);
		if($text != ""){
		
			$total = strlen($text);
			$mmin = array();
			$mmax = array();
			
				$count = count($key);
			for($i=0;$i<$count;$i++){
			if(trim($key[$i]) != ""){
					$minpos = strpos($text, $key[$i]);
					$maxpos = strrpos($text, $key[$i]);
						if($minpos != ""){ //หาค่าต่ำสุดที่เจอ
							array_push ($mmin,$minpos);
						}
						if($maxpos != ""){ //หาค่าสูงสุดที่เจอ
							$maxpos = strlen($key[$i]) + $maxpos;
							array_push ($mmax,$maxpos);
						}
				}
				}
				$min = @min($mmin); //หาค่าต่ำสุดที่เจอทั้งหมด
				$max = @max($mmax); //หาค่าสูงสุดที่เจอทั้งหมด
				if($min > 50){
				$min = $min - 50;
				$before = "...";
				}else{
				$min = 0;
				$before = "";
				}
				if($max < $total){
				$max = $max + 50;
				$after = "...";
				}else{
				$max = $total;
				$after = "";
				} 
				$max1 = $max - $min;
				$summary = $before.substr($text, $min, $max1).$after;

				//$summary = $text;
					for($i=0;$i<$count;$i++){
					if(trim($key[$i]) != ""){
					$summary = ereg_replace($key[$i],"<span style=background-color:".$color[$i].">".$key[$i]."</span>",$summary);
					}
					}
					return $summary;
		}
	}
	function toThaiNum($num){
		$thaiNum=array('๐','๑','๒','๓','๔','๕','๖','๗','๘','๙');
		$len=strlen($num);
		$tmp=$num;
		for($i=0; $i<$len; $i++) {
			$tmp = str_replace($num[$i], $thaiNum[$num[$i]], $tmp);
		}
		return $tmp;
	}


//n = toThaiNum(125000);
//trace(n);
?>
	<html>
<head>
<title>ระบบฐานข้อมูลรายงานและบันทึกการประชุม</title>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<style type="text/css">
<!--
.styleHead1 {color: #003300; font-family:tahoma; font-size:17px;}
.styleHead {color: #990000; font-family:tahoma; font-size:14px; font-weight:bold}
.styleText {color: #333333; font-family:tahoma; font-size:12px;}
.styleClick {color: #336699; font-family:tahoma; font-size:13px;}
A:link {
	COLOR: #000000; TEXT-DECORATION: none;
}
A:visited {
	COLOR: #000000; TEXT-DECORATION: none;
}
A:active {
	COLOR: #000000; TEXT-DECORATION: none;
}
A:hover {
	COLOR: #000000; TEXT-DECORATION: none;
}
-->
</style>
</head>
<body topmargin="0" leftmargin="0"><table width="100%" border="0" cellspacing="0" cellpadding="10">
  <tr style="display:none">
    <td><form name="form1" method="get" action="main_warehouse_view_ex.php">ค้นหา 
      
        <input name="keyword" type="text" id="keyword" value="<?php echo $_GET["keyword"]; ?>">
        <input type="submit" name="Submit" value="Submit">
    </form>
    </td>
  </tr>
  <tr>
    <td bgcolor="#CCCCCC" class="styleHead1"><img src="mainpic/document_view.gif" width="24" height="24" align="absmiddle"> ผลการค้นหา "<?php echo $text_result; ?>" ในเอกสาร<?php echo $typereport.'  '.$name_head;?></td>
  </tr>
  <?php
  	if($word != ""){
  if($db->db_num_rows($query) > 0){
  while($R = $db->db_fetch_row($query)){
  
  ?>
  <tr>
    <td><span class="styleHead"><img src="mainpic/bb1.jpg" align="absmiddle"> หน้าที่ <?php echo $R[0].' == '.toThaiNum($R[0]); ?></span> <a href="../../data_warehouse/file/<?php echo $R[2]; ?>#page=<?php echo $R[0]; ?>" target="_blank"><span class="styleClick"><img src="mainpic/pdf.gif"   border="0" align="absmiddle"> (คลิกเพื่อดูเอกสาร)</span></a><br>
    <span class="styleText"><?php echo replace_word(trim($R[1])); ?></span></td>
  </tr>
  <?php }}} ?>
</table>
</body>
</html>
	<?php
	$db->db_close();
?>