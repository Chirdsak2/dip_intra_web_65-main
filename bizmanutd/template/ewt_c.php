<?php
session_start();
/*
user ที่ กำลัง online
ewt_c.php

counter ของ website
ewt_c.php?id=1

counter ของหน้านั้นๆ
ewt_c.php?id=2&filename=[$filename]

counter แบบละเอียด ของหน้านั้นๆ
ewt_c.php?id=3&filename=[$filename]&align=[center/right]
*/
if($_GET["n"]){
		$n=$_GET["n"];
}else{
		include("lib/function.php");
		include("lib/user_config.php");
		include("lib/connect.php");

		$id=$_GET["id"];
		$filename=$_GET["filename"];
		$count = 0;

		if($id == ""){ // user ที่ online
				$newTime = date ("YmdHis", mktime(date(H), date(i), date(s)-3600, date(m), date(d), date(Y)));

				$sql ="SELECT COUNT(*) FROM stat_visitor WHERE sv_url = 'page' AND sv_visitor = 'Y' AND sv_timestamp >= '".$newTime."' ";
				$query = $db->query($sql);
				$rec = $db->db_fetch_row($query);
				if(!session_is_registered("EWT_VISITOR_STAT")){
						$rec[0] ++;
				}
				if($rec[0]==0){
						$rec[0] = "1";
				}
				$n=base64_encode($rec[0]);
		}else if($id == "1"){ //counter ของ website
					$sql ="SELECT COUNT(*) FROM stat_visitor WHERE sv_url = 'page' AND sv_visitor = 'Y'  ";
					$query = $db->query($sql);
					$rec = $db->db_fetch_row($query);
		
		$sql = 'SELECT * FROM site_info';
		$query = $db->query($sql);
		$site_info = $db->db_fetch_array($query);
		$m_counter = $site_info['set_countor'];
		
					if(!session_is_registered("EWT_VISITOR_STAT")){
							$rec[0] ++;
					}
					//chk counter hits
					$sql_hits = "select set_countor from site_info";
					$query_hits = $db->query($sql_hits);
					$rec_hits = $db->db_fetch_array($query_hits);
					$counter_hits = $rec_hits[set_countor];
					if($rec[0]==0){
						$rec[0] = "1";
					}
					$n=base64_encode($m_counter+$rec[0]);
		}else if($id == "2"){ //counter ของหน้านั้นๆ
					$sql ="select COUNT(*) from stat_visitor where sv_menu = '$filename'  ";
					$query = $db->query($sql);
					$rec = $db->db_fetch_row($query);
					if(!session_is_registered("EWT_VISITOR_STAT")){
						$rec[0] ++;
					}
					if($rec[0]==0){
						$rec[0] = "0";
					}
					$n=base64_encode($rec[0]);
		}else if($id == "3"){ //counter แบบละเอียด

				// All Total of file
				$sql ="select COUNT(*) from stat_visitor where sv_menu = '$filename'  ";
				$query = $db->query($sql);
				$rec = $db->db_fetch_row($query);
				$total=$rec[0];

				// Total of Today
				$sql ="select COUNT(*) from stat_visitor where sv_menu = '$filename' and sv_date like '".date('Y-m-d')."' ";
				$query = $db->query($sql);
				$rec = $db->db_fetch_row($query);
				$today=$rec[0];

				// Total of Yesterday
				$yd=date("Y-m-d", mktime (0,0,0,date('m'),date('d')-1,date('Y')));
				$sql ="select COUNT(*) from stat_visitor where sv_menu = '$filename' and sv_date = '$yd' ";
				$query = $db->query($sql);
				$rec = $db->db_fetch_row($query);
				$yesterday=$rec[0];

				// Total of Last month
				$lm=date('m');
				$sql ="select COUNT(*) from stat_visitor where sv_menu = '$filename' and sv_date like '%-".$lm."-%' ";
				$query = $db->query($sql);
				$rec = $db->db_fetch_row($query);
				$lastmonth=$rec[0];
		}
}

if($id==3){
	if($_GET[align]!=''){
		$align=$_GET[align];
	}else{
		$align='left';
	}
    ?>
	<table cellpadding="0" cellspacing="0">
	<tr>
	    <td align="<?php echo $align?>">
				ผู้เข้าใช้งานวันนี้ <?php echo number_format($today);?> คน<br>
				ผู้เข้าใช้งานเมือวาน <?php echo number_format($yesterday);?> คน<br>
				ผู้เข้าใช้งานเดือนนี้ <?php echo number_format($lastmonth);?> คน<br>
				รวม <?php echo number_format($total);?> คน 
		</td>
	</tr>
	</table>
	<?php
}else{
	gen_image();
}

function gen_image(){
	    global $n;
		Header("Content-type: image/png"); 
		$num = base64_decode($n);
		$cs = sprintf("%08d",$num);
		$len = strlen($cs)*10;
		$im=ImageCreate($len,18);
		$white = ImageColorAllocate($im,255,255,255);
		$black = ImageColorAllocate($im,0,0,0);
		$orange = ImageColorAllocate($im,196,104,5);
		$bg = $white;
		$fg = $orange;
		ImageFill($im,0,0,$bg);
		ImageString($im,5,5,1,$cs,$fg);
		ImagePNG($im);
		ImageDestroy($im);
}

?>
