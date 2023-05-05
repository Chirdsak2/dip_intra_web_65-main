<?php
	session_start();
	header ("Content-Type:text/plain;charset=UTF-8");
	include("lib/function.php");
	include("lib/user_config.php");
	include("lib/connect.php");
	$db->query("USE datawarehouse");
	
	$color = array("F6BD0F","AFD8F8","1941A5","8BBA00","A66EDD","F984A1","CCCC00","999999","0099CC","FF0000","006F00","0099FF","FF66CC","669966","7C7CB4","FF9933","9900FF","99FFCC","CCCCFF","669900","AFD8F8","8BBA00","FF8E46","008E8E","D64646","8E468E","588526","B3AA00","008ED6","9D080D","A186BE","F6BD0F","AFD8F8","1941A5","8BBA00","A66EDD","F984A1","CCCC00","999999","0099CC","FF0000","006F00","0099FF","FF66CC","669966","7C7CB4","FF9933","9900FF","99FFCC","CCCCFF","669900","AFD8F8","8BBA00","FF8E46","008E8E","D64646","8E468E","588526","B3AA00","008ED6","9D080D","A186BE");
	$attach_file_id = "1"; //สมมติให้ id ไฟล์ = 1

	if($_GET["keyword"] != ""){
	$sql = "";
	$text_result = "";
	$key = explode(" ",trim($_GET["keyword"]));
	$count = count($key);
		for($i=0;$i<$count;$i++){
		$sql .= "OR attach_file_index_detail LIKE '%".$key[$i]."%' ";
		$text_result .= " <span style=background-color:".$color[$i].">".$key[$i]."</span> &nbsp;";
		}
		if($sql != ""){
		$sql = substr($sql, 3); 
		$sql = " AND ( ".$sql." )";
		}
		//echo $sql;
		$query = $db->query("SELECT attach_file_index_page,attach_file_index_detail FROM attach_file_test WHERE attach_file_id = '".$attach_file_id."' ".$sql." ORDER BY attach_file_index_page ASC");
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
				$min = min($mmin); //หาค่าต่ำสุดที่เจอทั้งหมด
				$max = max($mmax); //หาค่าสูงสุดที่เจอทั้งหมด
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
					$summary = ereg_replace($key[$i],"<span style=background-color:".$color[$i].">".$key[$i]."</span>",$summary);
					}
					return $summary;
		}
	}
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
  <tr>
    <td><form name="form1" method="get" action="main_warehouse_view_ex.php">ค้นหา 
      
        <input name="keyword" type="text" id="keyword" value="<?php echo $_GET["keyword"]; ?>">
        <input type="submit" name="Submit" value="Submit">
    </form>
    </td>
  </tr>
  <?php if($_GET["keyword"] != ""){ ?>
  <tr>
    <td bgcolor="#CCCCCC" class="styleHead1"><img src="mainpic/document_view.gif" width="24" height="24" align="absmiddle"> ผลการค้นหา "<?php echo $text_result; ?>" ในเอกสารบันทึกการประชุม ครั้งที่ xxxxxx </td>
  </tr>
  <?php
  if($db->db_num_rows($query) > 0){
  while($R = $db->db_fetch_row($query)){
  
  ?>
  <tr>
    <td><span class="styleHead"><img src="mainpic/bb1.jpg" align="absmiddle"> หน้าที่ <?php echo $R[0]; ?></span> <a href="data_warehouse/test.pdf#page=<?php echo $R[0]; ?>" target="_blank"><span class="styleClick"><img src="mainpic/webboard_bullet.gif"   border="0" align="absmiddle"> (คลิกเพื่อดูเอกสาร)</span></a><br>
    <span class="styleText"><?php echo replace_word(trim($R[1])); ?></span></td>
  </tr>
  <?php }}} ?>
</table>
</body>
</html>
	<?php
	$db->db_close();
?>