<?php
session_start();
include("lib/function.php");
include("lib/user_config.php");
include("lib/connect.php");
$path_cal = "";
if($_POST[Flag] == 'Add') {
	if($_POST[all_day] != "1") $all_day = 2;
	else $all_day = 1;
	if($_POST[event_private] != "1") $event_private = 2;
	else $event_private = 1;
	if($_POST[add_register] != "1") $add_register = "";
	else $add_register = 1;
	$date_start = explode("/",$_POST[event_date_start]);
	$show_date_start = explode("/",$_POST[event_date_start]);
	 $date_start = ($date_start[2]-543)."-".$date_start[1]."-".$date_start[0];

	$time_start = $_POST[event_start_hour].":".$_POST[event_start_min].":00";
	$time_start;
	
	$date_end = explode("/",$_POST[event_date_end]);
	$show_date_end = explode("/",$_POST[event_date_end]);
	$date_end = ($date_end[2]-543)."-".$date_end[1]."-".$date_end[0];

	$event_end_hour;$event_end_min;
	$time_end = $_POST[event_end_hour].":".$_POST[event_end_min].":00";
	$time_end;
	
	if($_POST[event_show_start]) {
		$date_sh_start = explode("/",$_POST[event_show_start]);
		$show_date_sh_start = explode("/",$_POST[event_show_start]);
		$date_sh_start = ($date_sh_start[2]-543)."-".$date_sh_start[1]."-".$date_sh_start[0];
	} 
	if($_POST[event_show_end]){
		$date_sh_end = explode("/",$_POST[event_show_end]);
		$show_date_sh_end = explode("/",$_POST[event_show_end]);
		$date_sh_end = ($date_sh_end[2]-543)."-".$date_sh_end[1]."-".$date_sh_end[0];
	}	

	if($_POST[typeFiles] == 'web') { $link = $_POST[event_link];
	} else if($_POST[typeFiles] == 'fy') {
		$Current_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/calendar";
		if (!file_exists($Current_Dir)){  mkdir($Current_Dir,0777);  }
		if($_FILES["fileupload"]['size'] > 0 ) {
			$F = explode(".",$_FILES["fileupload"]["name"]);
			$C = count($F);
			$CT = $C-1;
			$dir = strtolower($F[$CT]);
			$nfile = "calendar_".date("YmdHis");
			$picname = $nfile.".".$dir;
			copy($_FILES["fileupload"]["tmp_name"],$Current_Dir."/".$picname);
			@chmod ($Current_Dir."/".$picname, 0777);
			$link = "calendar/".$picname;
		}
	}

	$sql_insert = "
		INSERT INTO cal_event (
			event_title, cat_id, color_id, event_detail, event_all_day, 
			event_date_start, event_time_start, event_date_end, event_time_end, event_user_id, 
			event_repeat, event_repeat_time, event_show_start, event_show_end, event_private,event_link,event_registor,event_registor_num,event_registor_type) 
		VALUES(
			'".$_POST[event_title]."', '".$_POST[cat_id]."', '".$_POST[col_id]."', '".addslashes($_POST[event_detail])."', '".$all_day."', 
			'".$date_start."', '".$time_start."', '".$date_end."', '".$time_end."',' ".$_SESSION["EWT_SMID"]."', 
			'".$_POST[repeat_chk]."', '".$_POST[repeat_time]."', '".$date_sh_start."', '".$date_sh_end."', '".$event_private."','".$link."','".$add_register."', '".$_POST[num_register]."', '".$_POST[type_register]."')";
									
	$db->query($sql_insert);
	$sql_event_id = "select max(event_id) as max_event_id from cal_event";
	$sql_event_id = $db->query($sql_event_id);
	$event_id_max= $db->db_fetch_array($sql_event_id);
	$main_event_id_repeat = $event_id_max[max_event_id];
	
	$sql_repeat_first = "INSERT INTO cal_show_event (event_id,event_date_start,event_date_end,event_show_start,event_show_end) VALUES ('".$event_id_max[max_event_id]."','".$date_start."','".$date_end."','".$date_sh_start."','".$date_sh_end."')";
	$db->query($sql_repeat_first);
	
	if($_POST[invite_id]) { // ส่ง E-mail ให้เป็นรายคน
		$invite_id_explode = explode(",",$_POST[invite_id]);
		//print_r($invite_id_explode);
		for($i=0; $i<count($invite_id_explode); $i++) {
			$sql_insert_invite = "INSERT INTO cal_invite (event_id,person_id) VALUES ('".$event_id_max[max_event_id]."','".$invite_id_explode[$i]."')";
			$db->query($sql_insert_invite);
			$db->query("USE ".$EWT_DB_USER);
			$sql = "SELECT * FROM gen_user WHERE gen_user_id = '".$invite_id_explode[$i]."' ";
			$query = $db->query($sql);
			$rs = $db->db_fetch_array($query);
			$email = $rs[email_person];
			$subject = $_POST[event_title]; 
			$sql1 = "SELECT * FROM gen_user WHERE gen_user_id = '".$_SESSION["EWT_SMID"]."' ";
			$query1 = $db->query($sql1);
			$rs1 = $db->db_fetch_array($query1);
			//print $rs1[email_person];
			$from =$rs1[email_person]; 
			$msg .= $text_gencalendar_nameactivity." :".$_POST[event_title]."<br>"; 
			$msg .=$text_gencalendar_detail.":".$_POST[event_detail]."<br>"; 
			$date_send = $text_general_datestart.":".$show_date_start[0]."/".$show_date_start[1]."/".$show_date_start[2].$text_general_dateend." :".$show_date_end[0]."/".$show_date_end[1]."/".$show_date_end[2];
			$msg .= $date_send."<br>"; print "<br>";
			$header = "From:$from "; 
			$header .= "Content-Type: text/html; charset='UTF-8' "; 
			//@mail($email,$subject,$msg,$header);
			@mail($email,$subject,$msg);
			$db->query("USE ".$EWT_DB_NAME);
		}
	}
	if($_POST[invite_divid]){ // ส่ง E-mail เป็นรายหน่วยงาน
		$invite_id_explode = explode(",",$_POST[invite_divid]);
		//print_r($invite_id_explode);
		for($i=0; $i<count($invite_id_explode); $i++){
			$sql_insert_invite = "INSERT INTO cal_invite (event_id,division_id) VALUES ('".$event_id_max[max_event_id]."','".$invite_id_explode[$i]."')";
			$db->query($sql_insert_invite);
			$db->query("USE ".$EWT_DB_USER);
			$sql = "SELECT * FROM gen_user WHERE org_id = '".$invite_id_explode[$i]."' ";
			$query = $db->query($sql);
			$rs = $db->db_fetch_array($query);
			$email = $rs[email_person];
			$subject= $_POST[event_title]; 
			$sql1 = "SELECT * FROM gen_user WHERE gen_user_id = '".$_SESSION["EWT_SMID"]."' ";
			$query1 = $db->query($sql1);
			$rs1 = $db->db_fetch_array($query1);
			//print $rs1[email_person];
			$from =$rs1[email_person]; 
			$msg .= $text_gencalendar_nameactivity." :".$_POST[event_title]."<br>"; 
			$msg .=$text_gencalendar_detail.":".$_POST[event_detail]."<br>"; 
			$date_send = $text_general_datestart.":".$show_date_start[0]."/".$show_date_start[1]."/".$show_date_start[2].$text_general_dateend." :".$show_date_end[0]."/".$show_date_end[1]."/".$show_date_end[2];
			$msg .= $date_send."<br>"; print "<br>";
			$header = "From:$from "; 
			$header .= "Content-Type: text/html; charset='UTF-8' "; 
			//@mail($email,$subject,$msg,$header);
			@mail($email,$subject,$msg);
			$db->query("USE ".$EWT_DB_NAME);
		}
	}
	if($_POST[repeat_chk]) {
		if(is_numeric($_POST[repeat_time]) && $_POST[repeat_time] > 0) $repeat_time = $_POST[repeat_time];
		else $repeat_time = 1;
		//print $repeat_time;
		if($_POST[repeat_chk] == '1'){
			for($i=1; $i<$repeat_time; $i++){
			
				$date_start_week =  date('Y-m-d',mktime(0, 0, 0, $show_date_start[1], $show_date_start[0]+($i*7), ($show_date_start[2]-543)));
				$date_end_week =  date('Y-m-d',mktime(0, 0, 0, $show_date_end[1], $show_date_end[0]+($i*7), ($show_date_end[2]-543)));
				if(count($show_date_sh_start) > 0)
					$date_sh_start_week =  date('Y-m-d',mktime(0, 0, 0, $show_date_sh_start[1], $show_date_sh_start[0], ($show_date_sh_start[2]-543)));//+($i*7)
				if(count($show_date_sh_end) > 0)
					$date_sh_end_week =  date('Y-m-d',mktime(0, 0, 0, $show_date_sh_end[1], $show_date_sh_end[0], ($show_date_sh_end[2]-543)));//+($i*7)
				
				$sql_insert = "INSERT INTO cal_event (event_title,cat_id,color_id,event_detail,event_all_day,event_date_start,event_time_start,event_date_end,event_time_end,event_user_id,event_repeat,event_repeat_time,event_show_start,event_show_end,main_event_id_repeat,event_private,event_link,event_registor,event_registor_num,event_registor_type) 
				VALUES('".$_POST[event_title]."','".$_POST[cat_id]."','".$_POST[col_id]."','".$_POST[event_detail]."','".$all_day."','".$date_start_week."','".$time_start."','".$date_end_week."','".$time_end."','".$_SESSION["EWT_SMID"]."','','','".$date_sh_start_week."','".$date_sh_end_week."','".$main_event_id_repeat."','".$event_private."','".$_POST[event_link]."','".$add_register."', '".$_POST[num_register]."', '".$_POST[type_register]."')";
				$db->query($sql_insert);
				$sql_event_id = "select max(event_id) as max_event_id from cal_event";
				$sql_event_id = $db->query($sql_event_id);
				$event_id_max= $db->db_fetch_array($sql_event_id);	
				$sql_repeat = "INSERT INTO cal_show_event (event_id,event_date_start,event_date_end,event_show_start,event_show_end,main_event_id_repeat) VALUES ('".$event_id_max[max_event_id]."','".$date_start_week."','".$date_end_week."','".$date_sh_start_week."','".$date_sh_end_week."','".$main_event_id_repeat."')";
				$db->query($sql_repeat);
				
				if($_POST[invite_id]){ // ส่ง E-mail
					$invite_id_explode = explode(",",$_POST[invite_id]);
					for($ii=0;$ii<count($invite_id_explode);$ii++){
						$sql_insert_invite = "INSERT INTO cal_invite (event_id,person_id,main_event_id_repeat) VALUES ('".$event_id_max[max_event_id]."','".$invite_id_explode[$ii]."','".$main_event_id_repeat."')";
						$db->query($sql_insert_invite);
					}
				}

			}
		}elseif($_POST[repeat_chk] == '2'){
			for($i=1;$i<$repeat_time;$i++){
				
				$show_date_start1 =  date('Y-m-d',mktime(0, 0, 0, $show_date_start[1]+$i, $show_date_start[0], ($show_date_start[2]-543)));
				$show_date_end1 =  date('Y-m-d',mktime(0, 0, 0, $show_date_end[1]+$i, $show_date_end[0], ($show_date_end[2]-543)));
				if(count($show_date_sh_start) > 0)
					$show_date_sh_start1 =  date('Y-m-d',mktime(0, 0, 0, $show_date_sh_start[1], $show_date_sh_start[0], ($show_date_sh_start[2]-543)));//+$i
				if(count($show_date_sh_end) > 0)
					$show_date_sh_end1 =  date('Y-m-d',mktime(0, 0, 0, $show_date_sh_end[1], $show_date_sh_end[0], ($show_date_sh_end[2]-543)));//+$i

				//$sql_repeat = "INSERT INTO cal_show_event (event_id,event_date_start,event_date_end,event_show_start,event_show_end) VALUES ('".$event_id_max[max_event_id]."','".$show_date_start1."','".$show_date_end1."','".$show_date_sh_start1."','".$show_date_sh_end1."')";
				//$db->query($sql_repeat);
				$sql_insert = "INSERT INTO cal_event (event_title,cat_id,color_id,event_detail,event_all_day,event_date_start,event_time_start,event_date_end,event_time_end,event_user_id,event_repeat,event_repeat_time,event_show_start,event_show_end,main_event_id_repeat,event_private,event_link,event_registor,event_registor_num,event_registor_type) 
				VALUES('".$_POST[event_title]."','".$_POST[cat_id]."','".$_POST[col_id]."','".$_POST[event_detail]."','".$all_day."','".$show_date_start1."','".$time_start."','".$show_date_end1."','".$time_end."','".$_SESSION["EWT_SMID"]."','','','".$show_date_sh_start1."','".$show_date_sh_end1."','".$main_event_id_repeat."','".$event_private."','".$_POST[event_link]."','".$add_register."', '".$_POST[num_register]."', '".$_POST[type_register]."')";
				$db->query($sql_insert);
				$sql_event_id = "select max(event_id) as max_event_id from cal_event";
				$sql_event_id = $db->query($sql_event_id);
				$event_id_max= $db->db_fetch_array($sql_event_id);	
				$sql_repeat = "INSERT INTO cal_show_event (event_id,event_date_start,event_date_end,event_show_start,event_show_end,main_event_id_repeat) VALUES ('".$event_id_max[max_event_id]."','".$show_date_start1."','".$show_date_end1."','".$show_date_sh_start1."','".$show_date_sh_end1."','".$main_event_id_repeat."')";
				$db->query($sql_repeat);
				
				if($_POST[invite_id]){ // ส่ง E-mail
					$invite_id_explode = explode(",",$_POST[invite_id]);
					for($ii=0;$ii<count($invite_id_explode);$ii++){
						$sql_insert_invite = "INSERT INTO cal_invite (event_id,person_id,main_event_id_repeat) VALUES ('".$event_id_max[max_event_id]."','".$invite_id_explode[$ii]."','".$main_event_id_repeat."')";
						$db->query($sql_insert_invite);
					}
				}
				
			}
			//exit;
		}elseif($_POST[repeat_chk] == '3'){
			for($i=1;$i<$repeat_time;$i++){
				$show_date_start1 = ($show_date_start[2]-543+$i)."-".$show_date_start[1]."-".$show_date_start[0];
				$show_date_end1 = ($show_date_end[2]-543+$i)."-".$show_date_end[1]."-".$show_date_end[0];
				if(count($show_date_sh_start) > 0){
					$show_date_sh_start1 = ($show_date_sh_start[2]-543)."-".$show_date_sh_start[1]."-".$show_date_sh_start[0];//+$i
				}
				if(count($show_date_sh_end) > 0){
					$show_date_sh_end1 = ($show_date_sh_end[2]-543)."-".$show_date_sh_end[1]."-".$show_date_sh_end[0];//+$i
				}
				$sql_insert = "INSERT INTO cal_event (event_title,cat_id,color_id,event_detail,event_all_day,event_date_start,event_time_start,event_date_end,event_time_end,event_user_id,event_repeat,event_repeat_time,event_show_start,event_show_end,main_event_id_repeat,event_private,event_link,event_registor,event_registor_num,event_registor_type) 
								VALUES('".$_POST[event_title]."','".$_POST[cat_id]."','".$_POST[col_id]."','".$_POST[event_detail]."','".$all_day."','".$show_date_start1."','".$time_start."','".$show_date_end1."','".$time_end."','".$_SESSION["EWT_SMID"]."','','','".$show_date_sh_start1."','".$show_date_sh_end1."','".$main_event_id_repeat."','".$event_private."','".$_POST[event_link]."','".$add_register."', '".$_POST[num_register]."', '".$_POST[type_register]."')";
				$db->query($sql_insert);
				$sql_event_id = "select max(event_id) as max_event_id from cal_event";
				$sql_event_id = $db->query($sql_event_id);
				$event_id_max= $db->db_fetch_array($sql_event_id);	
				$sql_repeat = "INSERT INTO cal_show_event (event_id,event_date_start,event_date_end,event_show_start,event_show_end,main_event_id_repeat) VALUES ('".$event_id_max[max_event_id]."','".$show_date_start1."','".$show_date_end1."','".$show_date_sh_start1."','".$show_date_sh_end1."','".$main_event_id_repeat."')";
				$db->query($sql_repeat);
				
				if($_POST[invite_id]){ // ส่ง E-mail
					$invite_id_explode = explode(",",$_POST[invite_id]);
					for($ii=0;$ii<count($invite_id_explode);$ii++){
						$sql_insert_invite = "INSERT INTO cal_invite (event_id,person_id,main_event_id_repeat) VALUES ('".$event_id_max[max_event_id]."','".$invite_id_explode[$ii]."','".$main_event_id_repeat."')";
						$db->query($sql_insert_invite);
					}
				}
				
			}
		}
	}
	$db->write_log("create","calendar","สร้างกิจกรรม calendar   ".$_POST["event_title"]);
	//exit;
	print "<script>";
	print "alert('".$text_general_alertadd."');";
	//window.opener.location.reload();
	print "window.location.href = \"calendar_manage.php\";";
			//window.opener.frm1.submit();
			// window.close();";
	print "</script>";
	$person_id;
	$repest;
}

if($_POST[Flag] == 'Edit') {
	if($_POST[all_day] != "1") $all_day = 2;
	else $all_day = 1;

	if($_POST[event_private] != "1") $event_private = 2;
	else $event_private = 1;
	if($_POST[add_register] != "1") $add_register = "";
	else $add_register = 1;
	
	$date_start = explode("/",$_POST[event_date_start]);
	$show_date_start = explode("/",$_POST[event_date_start]);
	$date_start = ($date_start[2]-543)."-".$date_start[1]."-".$date_start[0];

	$time_start = $_POST[event_start_hour].":".$_POST[event_start_min].":00";
	$time_start;
	
	$date_end = explode("/",$_POST[event_date_end]);
	$show_date_end = explode("/",$_POST[event_date_end]);
	$date_end = ($date_end[2]-543)."-".$date_end[1]."-".$date_end[0];

	$event_end_hour;$event_end_min;
	$time_end = $_POST[event_end_hour].":".$_POST[event_end_min].":00";
	$time_end;
	
	if($_POST[event_show_start]) {
		$date_sh_start = explode("/",$_POST[event_show_start]);
		$show_date_sh_start = explode("/",$_POST[event_show_start]);
		$date_sh_start = ($date_sh_start[2]-543)."-".$date_sh_start[1]."-".$date_sh_start[0];
	}
	if($_POST[event_show_end]) {
		$date_sh_end = explode("/",$_POST[event_show_end]);
		$show_date_sh_end = explode("/",$_POST[event_show_end]);
		$date_sh_end = ($date_sh_end[2]-543)."-".$date_sh_end[1]."-".$date_sh_end[0];
	}	

	if($_POST[typeFiles] == 'web') {
		$link=$_POST[event_link];
	}else if($_POST[typeFiles] == 'fy') {
		//$Current_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/calendar";
		$Current_Dir = "../ewt/".$_SESSION["EWT_SUSER"]."/calendar";
		if (!file_exists($Current_Dir)) {  mkdir($Current_Dir,0777);  }
		if($_FILES["fileupload"]['size'] > 0) {
				$F = explode(".",$_FILES["fileupload"]["name"]);
				$C = count($F);
				$CT = $C-1;
				$dir = strtolower($F[$CT]);
				$nfile = "calendar_".date("YmdHis");
				$picname = $nfile.".".$dir;
				copy($_FILES["fileupload"]["tmp_name"],$Current_Dir."/".$picname);
				@chmod ($Current_Dir."/".$picname, 0777);
				$link = "calendar/".$picname;
		}else{
			$link=$_POST[oldFile];
		}
	}

	$sql_update = "UPDATE cal_event SET event_title = '".$_POST[event_title]."',cat_id = '".$_POST[cat_id]."' ,color_id = '".$_POST[col_id]."'
	,event_detail = '".$_POST[event_detail]."',event_all_day = '".$all_day."',event_date_start = '".$date_start."'
	,event_time_start = '".$time_start."',event_date_end = '".$date_end."',event_time_end = '".$time_end."'
	,event_user_id = '".$_SESSION["EWT_SMID"]."' , event_repeat = '".$_POST[repeat_chk]."' , event_repeat_time = '".$_POST[repeat_time]."',event_show_start = '".$date_sh_start."', event_show_end = '".$date_sh_end."' , event_private = '".$event_private."'
	,event_link = '".$link."',event_registor='".$add_register."',event_registor_num= '".$_POST[num_register]."',event_registor_type='".$_POST[type_register]."'   WHERE event_id = '".$_POST[event_id]."' ";print "<br>";print "<br>";print "<br>";
	
	$db->query($sql_update);
	
	$sql_del_event = "DELETE FROM cal_event WHERE main_event_id_repeat = '".$_POST[event_id]."' ";
	$db->query($sql_del_event);
	/*$sql_del3 = "DELETE FROM cal_show_event WHERE event_id = '".$_POST[event_id]."' ";
	$db->query($sql_del3);*/
	$sql_del_show = "DELETE FROM cal_show_event WHERE main_event_id_repeat = '".$_POST[event_id]."' ";
	$db->query($sql_del_show);
	$sql_del_invite = "DELETE FROM cal_invite WHERE event_id = '".$_POST[event_id]."' ";
	$db->query($sql_del_invite);
	$sql_del_show = "DELETE FROM cal_invite WHERE main_event_id_repeat = '".$_POST[event_id]."' ";
	$db->query($sql_del_show);
	//$sql_repeat_first = "INSERT INTO cal_show_event (event_id,event_date_start,event_date_end,event_show_start,event_show_end) VALUES ('".$_POST[event_id]."','".$date_start."','".$date_end."','".$date_sh_start."','".$date_sh_end."')";
	$sql_repeat_first = "UPDATE cal_show_event SET event_date_start = '".$date_start."',event_date_end = '".$date_end."'
	,event_show_start = '".$date_sh_start."', event_show_end = '".$date_sh_end."' 
	WHERE event_id = '".$_POST[event_id]."' ";
	$db->query($sql_repeat_first);
	//exit;
	
	if($_POST[invite_id]){ // ส่ง รายคน
		$invite_id_explode = explode(",",$_POST[invite_id]);
		for($i=0;$i<count($invite_id_explode);$i++){
			$sql_insert_invite = "INSERT INTO cal_invite (event_id,person_id) VALUES ('".$_POST[event_id]."','".$invite_id_explode[$i]."')";
			$db->query($sql_insert_invite);
		}
	}

	if($_POST[invite_divid]){ //หน่วยงาน
		$invite_id_explode = explode(",",$_POST[invite_divid]);
		for($i=0;$i<count($invite_id_explode);$i++){
			$sql_insert_invite = "INSERT INTO cal_invite (event_id,division_id) VALUES ('".$_POST[event_id]."','".$invite_id_explode[$i]."')";
			$db->query($sql_insert_invite);
		}
	}

	if($_POST[repeat_chk]){
		if(is_numeric($_POST[repeat_time]) && $_POST[repeat_time] > 0) $repeat_time = $_POST[repeat_time];
		else $repeat_time = 1;
		//print $repeat_time;
		if($_POST[repeat_chk] == '1'){
			for($i=1;$i<$repeat_time;$i++){
				$date_start_week =  date('Y-m-d',mktime(0, 0, 0, $show_date_start[1], $show_date_start[0]+($i*7), ($show_date_start[2]-543)));
				$date_end_week =  date('Y-m-d',mktime(0, 0, 0, $show_date_end[1], $show_date_end[0]+($i*7), ($show_date_end[2]-543)));
				if(count($show_date_sh_start) > 0)
					$date_sh_start_week =  date('Y-m-d',mktime(0, 0, 0, $show_date_sh_start[1], $show_date_sh_start[0], ($show_date_sh_start[2]-543)));//+($i*7)
				if(count($show_date_sh_end) > 0)
					$date_sh_end_week =  date('Y-m-d',mktime(0, 0, 0, $show_date_sh_end[1], $show_date_sh_end[0], ($show_date_sh_end[2]-543)));//+($i*7)
				
				$sql_insert = "INSERT INTO cal_event (event_title,cat_id,color_id,event_detail,event_all_day,event_date_start,event_time_start,event_date_end,event_time_end,event_user_id,event_repeat,event_repeat_time,event_show_start,event_show_end,main_event_id_repeat,event_private,event_link,event_registor,event_registor_num,event_registor_type) 
				VALUES('".$_POST[event_title]."','".$_POST[cat_id]."','".$_POST[col_id]."','".$_POST[event_detail]."','".$all_day."','".$date_start_week."','".$time_start."','".$date_end_week."','".$time_end."','".$_SESSION["EWT_SMID"]."','','','".$date_sh_start_week."','".$date_sh_end_week."','".$_POST[event_id]."','".$event_private."','".$_POST[event_link]."','".$add_register."', '".$_POST[num_register]."', '".$_POST[type_register]."')";
				$db->query($sql_insert);
				
				$sql_event_id = "select max(event_id) as max_event_id from cal_event";
				$sql_event_id = $db->query($sql_event_id);
				$event_id_max= $db->db_fetch_array($sql_event_id);	

				$sql_repeat = "INSERT INTO cal_show_event (event_id,event_date_start,event_date_end,event_show_start,event_show_end,main_event_id_repeat) VALUES ('".$event_id_max[max_event_id]."','".$date_start_week."','".$date_end_week."','".$date_sh_start_week."','".$date_sh_end_week."','".$_POST[event_id]."')";
				$db->query($sql_repeat);
				
				if($_POST[invite_id]){ // ส่ง E-mail
					$invite_id_explode = explode(",",$_POST[invite_id]);
					for($ii=0;$ii<count($invite_id_explode);$ii++){
						$sql_insert_invite1 = "INSERT INTO cal_invite (event_id,person_id,main_event_id_repeat) VALUES ('".$event_id_max[max_event_id]."','".$invite_id_explode[$ii]."','".$_POST[event_id]."')";
						$db->query($sql_insert_invite1);	
					}
				}
			}
		}elseif($_POST[repeat_chk] == '2'){
			for($i=1;$i<$repeat_time;$i++){
				$show_date_start1 =  date('Y-m-d',mktime(0, 0, 0, $show_date_start[1]+$i, $show_date_start[0], ($show_date_start[2]-543)));
				$show_date_end1 =  date('Y-m-d',mktime(0, 0, 0, $show_date_end[1]+$i, $show_date_end[0], ($show_date_end[2]-543)));
				if(count($show_date_sh_start) > 0)
					$show_date_sh_start1 =  date('Y-m-d',mktime(0, 0, 0, $show_date_sh_start[1], $show_date_sh_start[0], ($show_date_sh_start[2]-543)));//+$i
				if(count($show_date_sh_end) > 0)
					$show_date_sh_end1 =  date('Y-m-d',mktime(0, 0, 0, $show_date_sh_end[1], $show_date_sh_end[0], ($show_date_sh_end[2]-543)));//+$i

				
				//$sql_repeat = "INSERT INTO cal_show_event (event_id,event_date_start,event_date_end,event_show_start,event_show_end) VALUES ('".$_POST[event_id]."','".$show_date_start1."','".$show_date_end1."','".$show_date_sh_start1."','".$show_date_sh_end1."')";
				//$db->query($sql_repeat);
				$sql_insert = "INSERT INTO cal_event (event_title,cat_id,color_id,event_detail,event_all_day,event_date_start,event_time_start,event_date_end,event_time_end,event_user_id,event_repeat,event_repeat_time,event_show_start,event_show_end,main_event_id_repeat,event_private,event_link,event_registor,event_registor_num,event_registor_type) 
				VALUES('".$_POST[event_title]."','".$_POST[cat_id]."','".$_POST[col_id]."','".$_POST[event_detail]."','".$all_day."','".$show_date_start1."','".$time_start."','".$show_date_end1."','".$time_end."','".$_SESSION["EWT_SMID"]."','','','".$show_date_sh_start1."','".$show_date_sh_end1."','".$_POST[event_id]."','".$event_private."','".$_POST[event_link]."','".$add_register."', '".$_POST[num_register]."', '".$_POST[type_register]."')";
				$db->query($sql_insert);
				
				$sql_event_id = "select max(event_id) as max_event_id from cal_event";
				$sql_event_id = $db->query($sql_event_id);
				$event_id_max= $db->db_fetch_array($sql_event_id);	

				$sql_repeat = "INSERT INTO cal_show_event (event_id,event_date_start,event_date_end,event_show_start,event_show_end,main_event_id_repeat) VALUES ('".$event_id_max[max_event_id]."','".$show_date_start1."','".$show_date_end1."','".$show_date_sh_start1."','".$show_date_sh_end1."','".$_POST[event_id]."')";
				$db->query($sql_repeat);

				if($_POST[invite_id]){ // ส่ง E-mail
					$invite_id_explode = explode(",",$_POST[invite_id]);
					for($ii=0;$ii<count($invite_id_explode);$ii++){
						$sql_insert_invite = "INSERT INTO cal_invite (event_id,person_id,main_event_id_repeat) VALUES ('".$event_id_max[max_event_id]."','".$invite_id_explode[$ii]."','".$_POST[event_id]."')";
						$db->query($sql_insert_invite);
					}
				}
			}

		}elseif($_POST[repeat_chk] == '3'){
			for($i=1;$i<$repeat_time;$i++){
				$show_date_start1 = ($show_date_start[2]-543+$i)."-".$show_date_start[1]."-".$show_date_start[0];
				$show_date_end1 = ($show_date_end[2]-543+$i)."-".$show_date_end[1]."-".$show_date_end[0];
				if(count($show_date_sh_start) > 0){
					$show_date_sh_start1 = ($show_date_sh_start[2]-543)."-".$show_date_sh_start[1]."-".$show_date_sh_start[0];
				}//+$i
				if(count($show_date_sh_end) > 0){
					$show_date_sh_end1 = ($show_date_sh_end[2]-543)."-".$show_date_sh_end[1]."-".$show_date_sh_end[0];
				}
				//+$i
				$sql_insert = "INSERT INTO cal_event (event_title,cat_id,color_id,event_detail,event_all_day,event_date_start,event_time_start,event_date_end,event_time_end,event_user_id,event_repeat,event_repeat_time,event_show_start,event_show_end,main_event_id_repeat,event_private,event_link,event_registor,event_registor_num,event_registor_type) 
				VALUES('".$_POST[event_title]."','".$_POST[cat_id]."','".$_POST[col_id]."','".$_POST[event_detail]."','".$all_day."','".$show_date_start1."','".$time_start."','".$show_date_end1."','".$time_end."','".$_SESSION["EWT_SMID"]."','','','".$show_date_sh_start1."','".$show_date_sh_end1."','".$_POST[event_id]."','".event_private."','".$_POST[event_link]."','".$add_register."', '".$_POST[num_register]."', '".$_POST[type_register]."')";
				$db->query($sql_insert);
				
				$sql_event_id = "select max(event_id) as max_event_id from cal_event";
				$sql_event_id = $db->query($sql_event_id);
				$event_id_max= $db->db_fetch_array($sql_event_id);	

				$sql_repeat = "INSERT INTO cal_show_event (event_id,event_date_start,event_date_end,event_show_start,event_show_end,main_event_id_repeat) VALUES ('".$event_id_max[max_event_id]."','".$show_date_start1."','".$show_date_end1."','".$show_date_sh_start1."','".$show_date_sh_end1."','".$_POST[event_id]."')";
				$db->query($sql_repeat);
				
				if($_POST[invite_id]){ // ส่ง E-mail
					$invite_id_explode = explode(",",$_POST[invite_id]);
					for($ii=0;$ii<count($invite_id_explode);$ii++){
						$sql_insert_invite = "INSERT INTO cal_invite (event_id,person_id,main_event_id_repeat) VALUES ('".$event_id_max[max_event_id]."','".$invite_id_explode[$ii]."','".$_POST[event_id]."')";
						$db->query($sql_insert_invite);
					}
				}
				
			}
		}
	}
	$db->write_log("update","calendar","แก้ไขกิจกรรม calendar   ".$_POST["event_title"]);
	print "<script>";
	print "alert('".$text_general_alertedit."');";
	print "window.location.href = \"calendar_manage.php\";";
	print "</script>";
}
if($_GET[Flag] == "Del"){
	$sql = $db->query("select * from cal_event where main_event_id_repeat  = '".$_GET[event_id]."' ");
	while($rec = $db->db_fetch_array($sql)){
		$sql_del1 = "DELETE FROM cal_event WHERE event_id = '".$rec[event_id]."' ";
		$sql_del2 = "DELETE FROM cal_invite WHERE event_id = '".$rec[event_id]."' ";
		$sql_del3 = "DELETE FROM cal_show_event WHERE event_id = '".$rec[event_id]."' ";
		$db->query($sql_del1);
		$db->query($sql_del2);
		$db->query($sql_del3);
	}
	$sql_del1 = "DELETE FROM cal_event WHERE event_id = '".$_GET[event_id]."' ";
	$sql_del2 = "DELETE FROM cal_invite WHERE event_id = '".$_GET[event_id]."' ";
	$sql_del3 = "DELETE FROM cal_show_event WHERE event_id = '".$_GET[event_id]."' ";
	$db->query($sql_del1);
	$db->query($sql_del2);
	$db->query($sql_del3);
	
	print "<script>";
	print "alert('".$text_general_alertdel."');";
	print "window.location.href = \"calendar_manage.php\";";
	print "</script>";
}
$db->db_close(); ?>

