<?php
include("../EWT_ADMIN/comtop_pop.php");

$json_flag = array("add","edit","check_date");
if(in_array($flag,$json_flag)){
	header('Content-type: application/json; charset=utf-8');
}

$flag        = $_POST["flag"];
$error_array = array();
$return_to   = "intro_index.php?flag=intro_page";

##=====================================================================================================##


##=====================================================================================================##

if(trim($_SESSION['EWT_SMID']) != ""){
	$intro_owner = ready($_SESSION['EWT_SMID']);
	$owner_cond  = " AND intro_owner = '$intro_owner' ";
}
else if($_SESSION['EWT_SMTYPE'] == "Y"){
	$intro_owner = "0";
}

if($flag=="add"||$flag=="edit"){

	$intro_name 		= trim($_POST["intro_name"]);
	$intro_image 		= trim($_POST["intro_image"]);
	$intro_background 	= trim($_POST["intro_background"]);
	$link_button 		= trim($_POST["link_button"]);
	$link_url 			= trim($_POST["link_url"]);
	$link_target 		= trim($_POST["link_target"]);
	$date_start 		= trim($_POST["date_start"]);
	$date_end 			= trim($_POST["date_end"]);
	$intro_id 			= trim($_POST["intro_id"]);
	$intro_type         = trim($_POST["intro_type"]);

	$banner_use         = $_POST["banner_use"];

	
	
	## >> Check intro name
	if($intro_name==""){
		return_data("error",array("title"=>'ไม่มีชื่อ Intro',"content"=>'กรุณาใส่ชื่อ Intro',"focus"=>"intro_name"));
	}

	## >> Check intro type
	if($flag=="add"){
		if($intro_type==""){
			return_data("error",array("title"=>'ไม่มีประเภท Intro',"content"=>'กรุณาเลือกประเภท Intro',"focus"=>"intro_type_1"));
		}
		else{
			if(!in_array($intro_type,array("page","popup"))){
				return_data("error",array("title"=>'ประเภท Intro ไม่ถูกต้อง',"content"=>'กรุณาเลือกประเภท Intro ที่ถูกต้อง',"focus"=>"intro_type_1"));
			}
		}
	}
	else if($flag=="edit"){
		$intro_id = ready($intro_id);
		## >> Select intro type
		$intro_data = $db->query("SELECT intro_type FROM intro_list WHERE intro_id = '$intro_id'");
		$intro_info = $db->db_fetch_array($intro_data);
		$intro_type = $intro_info["intro_type"];
	}

	##====================================================================================================================##
	if($intro_type=="page"){

		## >> Check main image
		if($intro_image==""){
			return_data("error",array("title"=>'ไม่มีภาพหลัก',"content"=>'กรุณาเลือกภาพหลัก',"focus"=>"intro_image"));
		}
		else{
			$intro_image = str_replace("../","",$intro_image);
			$position    = (string)strpos($intro_image,"images/");
			if($position!="0"){
				return_data("error",array("title"=>'ภาพไม่ใช่ของเว็บไซต์',"content"=>'กรุณาใช้ภาพที่อยู่บนเว็บ server',"focus"=>"intro_image"));
			}

			$extension = explode(".",$intro_image);
			$extension = $extension[count($extension)-1];
			if(!in_array($extension,array("jpg","jpeg","png"))){
				return_data("error",array("title"=>'นามสกุลไฟล์ไม่ถูกต้อง',"content"=>'กรุณาใช้ไฟล์นามสกุล jpg,jpeg,png',"focus"=>"intro_image"));
			}
		}

		## >> Check background
		if($intro_background==""){
			return_data("error",array("title"=>'ไม่มีภาพพื้นหลัง',"content"=>'กรุณาเลือกภาพพื้นหลัง',"focus"=>"intro_background"));
		}
		else{
			$intro_background = str_replace("../","",$intro_background);
			$position    = (string)strpos($intro_background,"images/");
			if($position!="0"){
				return_data("error",array("title"=>'ภาพไม่ใช่ของเว็บไซต์',"content"=>'กรุณาใช้ภาพที่อยู่บนเว็บ server',"focus"=>"intro_background"));
			}

			$extension = explode(".",$intro_background);
			$extension = $extension[count($extension)-1];
			if(!in_array($extension,array("jpg","jpeg","png"))){
				return_data("error",array("title"=>'นามสกุลไฟล์ไม่ถูกต้อง',"content"=>'กรุณาใช้ไฟล์นามสกุล jpg,jpeg,png',"focus"=>"intro_background"));
			}
		}

		for($i=1;$i<=$_POST["current_button"];$i++){
			$button = trim($_POST["link_button_".$i]); 
			$url    = trim($_POST["link_url_".$i]); 
			$target = trim($_POST["link_target_".$i]); 
			
			if(isset($_POST["link_button_".$i])==true && isset($_POST["link_url_".$i])==true){
				if($button==""){
					return_data("error",array("title"=>'ไม่มีภาพปุ่ม',"content"=>'กรุณาเลือกภาพปุ่ม',"focus"=>"link_button_".$i));
				} 
				else{
					$button = str_replace("../","",$button);
					$position    = (string)strpos($button,"images/");
					if($position!="0"){
						return_data("error",array("title"=>'ภาพไม่ใช่ของเว็บไซต์',"content"=>'กรุณาใช้ภาพที่อยู่บนเว็บ server',"focus"=>"link_button_".$i));
					}
		
					$extension = explode(".",$button);
					$extension = $extension[count($extension)-1];
					if(!in_array($extension,array("jpg","jpeg","png"))){
						return_data("error",array("title"=>'นามสกุลไฟล์ไม่ถูกต้อง',"content"=>'กรุณาใช้ไฟล์นามสกุล jpg,jpeg,png',"focus"=>"link_button_".$i));
					}
				}
				
				if($url==""){
					return_data("error",array("title"=>'ไม่มี link',"content"=>'กรุณาเลือกหรือใส่ link',"focus"=>"link_url_".$i));
				}

				if(!in_array($target,array("","_self","_blank"))){
					$_POST["link_target_".$i] = "";
				}
			}
		}

	}
	else if($intro_type=="popup"){
		if(count($banner_use)==0){
			return_data("error",array("title"=>'ไม่มี banner',"content"=>'กรุณาเลือกอย่างน้อย 1 banner สำหรับ Pop-up',"focus"=>""));
			return_data("error",$error_array[0]);
			exit();
		}
	}

	##====================================================================================================================##

	## >> Check date start-end
	if($date_start==""){
		return_data("error",array("title"=>'ไม่มีวันที่เริ่มต้น',"content"=>'กรุณาเลือกวันที่เริ่มต้น',"focus"=>"date_start"));
	}
	else{
		$date_start = explode("/",$date_start);
		$date_start = $date_start[2]."-".$date_start[1]."-".$date_start[0];
		if(filter_date("-",$date_start)==""){
			$date_start = "";
			return_data("error",array("title"=>'รูปแบบไม่ถูกต้อง',"content"=>'รูปแบบวันที่ไม่ถูกต้อง',"focus"=>"date_start"));
		}
	}
	
	if($date_end==""){
		return_data("error",array("title"=>'ไม่มีวันที่สิ้นสุด',"content"=>'กรุณาเลือกวันที่สิ้นสุด',"focus"=>"date_end"));
	}
	else{
		$date_end = explode("/",$date_end);
		$date_end = $date_end[2]."-".$date_end[1]."-".$date_end[0];
		if(filter_date("-",$date_end)==""){
			$date_end = "";
			return_data("error",array("title"=>'รูปแบบไม่ถูกต้อง',"content"=>'รูปแบบวันที่ไม่ถูกต้อง',"focus"=>"date_end"));
		}
	}

	/*$intro_array      = array();
	$intro_data       = $db->query("SELECT   * 
	                                FROM     intro_list 
									WHERE    intro_type = '$intro_type' AND intro_id != '$intro_id'
									ORDER BY intro_show_start, intro_show_end");
	while($intro_info = $db->db_fetch_array($intro_data)){

		$c_date_start = trim($intro_info["intro_show_start"]);
		$c_date_start = explode("-",$c_date_start);
		$c_date_start = $c_date_start[2]."/".$c_date_start[1]."/".$c_date_start[0];
	
		$c_date_end   = trim($intro_info["intro_show_end"]);
		$c_date_end   = explode("-",$c_date_end);
		$c_date_end   = $c_date_end[2]."/".$c_date_end[1]."/".$c_date_end[0];

		array_push($intro_array,array("intro_name"=>$intro_info["intro_name"],
									  "intro_id"=>$intro_info["intro_id"],
									  "totime_show_start"=>strtotime($intro_info["intro_show_start"]),
									  "totime_show_end"=>strtotime($intro_info["intro_show_end"]),
									  "intro_show_start"=>$c_date_start,
									  "intro_show_end"=>$c_date_end));
	}*/
	
	$totime_date_start = strtotime($date_start);
	$totime_date_end   = strtotime($date_end);
	
	if($totime_date_start>$totime_date_end){
		return_data("error",array("title"=>'วันที่แสดงไม่ถูกต้อง',"content"=>'วันที่เริ่มต้นต้องน้อยกว่าวันที่สิ้นสุด',"focus"=>"date_start"));
	}
	

	/*$error         = 0;
	$collect_intro = array("name"=>array(),"id"=>array());

	foreach($intro_array AS $check){

		if($totime_date_start!=""){
			if($check["totime_show_start"]<=$totime_date_start && $totime_date_start<=$check["totime_show_end"]){
				if(!in_array($check["intro_id"],$collect_intro["id"])){
					array_push($collect_intro["id"],$check["intro_id"]);
					array_push($collect_intro["name"],$check["intro_name"]." [".$check["intro_show_start"]." ถึง ".$check["intro_show_end"]."]");
				}
				$error++;
			}
		}

		if($totime_date_end!=""){
			if($check["totime_show_start"]<=$totime_date_end && $totime_date_end<=$check["totime_show_end"]){
				if(!in_array($check["intro_id"],$collect_intro["id"])){
					array_push($collect_intro["id"],$check["intro_id"]);
					array_push($collect_intro["name"],$check["intro_name"]." [".$check["intro_show_start"]." ถึง ".$check["intro_show_end"]."]");
				}
				$error++;
			}
		}

		if($totime_date_start!="" && $totime_date_end!=""){
			if($totime_date_start<=$check["totime_show_start"] && $check["totime_show_start"]<=$totime_date_end){
				if(!in_array($check["intro_id"],$collect_intro["id"])){
					array_push($collect_intro["id"],$check["intro_id"]);
					array_push($collect_intro["name"],$check["intro_name"]." [".$check["intro_show_start"]." ถึง ".$check["intro_show_end"]."]");
				}
				$error++;
			}
			if($totime_date_start<=$check["totime_show_end"] && $check["totime_show_end"]<=$totime_date_end){
				if(!in_array($check["intro_id"],$collect_intro["id"])){
					array_push($collect_intro["id"],$check["intro_id"]);
					array_push($collect_intro["name"],$check["intro_name"]." [".$check["intro_show_start"]." ถึง ".$check["intro_show_end"]."]");
				}
				$error++;
			}
		}
	}

	if($error>0){
		$intro_type_name = array("page"=>"Intro Page","popup"=>"Pop-Up");

		$list_interval = "<div><b>รายการ ".$intro_type_name[$intro_type]." ที่มีการทับซ้อน :</b></div><ul>";
		foreach($collect_intro["name"] AS $e){
			$list_interval .= "<li> * ".$e."</li>";
		}
		$list_interval .= "</ul>";

		return_data("interval_error",array("title"=>'วันที่แสดงมีการทับซ้อน',
							   		       "content"=>'กรุณาแก้ไขวันที่แสดง',
									       "list"=>$list_interval));
	}*/


	##=============================================================================================================##
	/*if(count($error_array)>0){
		return_data("error",$error_array[0]);
		exit();
	}*/
	##=============================================================================================================##
	$intro_name 		= ready($intro_name);
	$intro_image 		= ready($intro_image);
	$intro_background 	= ready($intro_background);
	$link_button 		= ready($link_button);
	$link_url 			= ready($link_url);
	$link_target 		= ready($link_target);
	$date_start 		= ready($date_start);
	$date_end 			= ready($date_end);
	$intro_id 			= ready($intro_id);
	
	if($flag=="add"){
		if($intro_type=="page"){
		    $db->query("INSERT INTO intro_list (intro_name,intro_image,intro_background,
								            intro_show_start,intro_show_end,intro_create,intro_owner,
											intro_type)
					    VALUES ('$intro_name','$intro_image','$intro_background','$date_start','$date_end',NOW(),'$intro_owner',
								'$intro_type')");
			$db->write_log("create","intro","สร้าง intro   ".$intro_name);
		}
		else{
		    $db->query("INSERT INTO intro_list (intro_name,intro_show_start,intro_show_end,intro_create,intro_owner,
											    intro_type)
					    VALUES ('$intro_name','$date_start','$date_end',NOW(),'$intro_owner',
							    '$intro_type')");
			$db->write_log("create","intro","สร้าง pop-up   ".$intro_name);
		}
	}
	else if($flag=="edit"){
		if($intro_type=="page"){
			$db->query("UPDATE intro_list
						SET    intro_name       = '$intro_name',
							   intro_image      = '$intro_image',
							   intro_background = '$intro_background',
							   intro_show_start = '$date_start',
							   intro_show_end   = '$date_end',
							   intro_update     = NOW()
						WHERE  intro_id         = '$intro_id' $owner_cond");
			$db->write_log("update","intro"," intro   ".$intro_name);
		}
		else{
			$db->query("UPDATE intro_list
						SET    intro_name       = '$intro_name',
							   intro_show_start = '$date_start',
							   intro_show_end   = '$date_end',
							   intro_update     = NOW()
						WHERE  intro_id         = '$intro_id' $owner_cond");
			$db->write_log("update","intro"," pop-up   ".$intro_name);
		}
	}

	if($flag=="add"){
		$intro_data = $db->query("SELECT MAX(intro_id) AS intro_id FROM intro_list");
		$intro_info = $db->db_fetch_array($intro_data);
		$intro_id   = $intro_info["intro_id"];
	}
	
	## >> Adding button
	if($intro_type=="page"){
		$db->query("DELETE FROM intro_button_list WHERE intro_id = '$intro_id' $owner_cond");

		for($i=1;$i<=$_POST["current_button"];$i++){
			$button   = trim($_POST["link_button_".$i]); 
			$url      = trim($_POST["link_url_".$i]); 
			$target   = trim($_POST["link_target_".$i]); 
			$alt      = trim($_POST["link_alt_".$i]); 
			$language = trim($_POST["link_language_".$i]); 

			if($button!="" && isset($_POST["link_button_".$i])==true &&
			    $url!=""    && isset($_POST["link_url_".$i])==true){
				$button   = ready($_POST["link_button_".$i]); 
				$url      = ready($_POST["link_url_".$i]); 
				$target   = ready($_POST["link_target_".$i]); 
				$alt      = ready($_POST["link_alt_".$i]); 
				$language = ready($_POST["link_language_".$i]); 

				if(!in_array($language,array("TH","EN"))){
					$language = "TH";
				}

				$db->query("INSERT INTO intro_button_list (intro_id,intro_button,intro_link,intro_target,
				                                           intro_alt,intro_language,intro_owner)
							VALUES ('$intro_id','$button','$url','$target',
							        '$alt','$language','$intro_owner')");
			}
		}
	}
	## >> Adding banner
	else if($intro_type=="popup"){
		$db->query("DELETE FROM intro_banner_list WHERE intro_id = '$intro_id' $owner_cond");

		$n_order    = 1;

		## >> Prevent duplicate banner_id
		$used_banner = array();

		foreach($banner_use AS $banner_use_e){
			if(!in_array($banner_use_e,$used_banner)){
				$banner_use_e = ready($banner_use_e);
				$db->query("INSERT INTO intro_banner_list (intro_id,banner_id,banner_order,intro_owner)
							VALUES ('$intro_id','$banner_use_e','$n_order','$intro_owner')");

				array_push($used_banner,$banner_use_e);
				$n_order++;
			}
		}
	}

	if($intro_type=="page"){
		$return_to   = "intro_index.php?flag=intro_page";
	}
	else if($intro_type=="popup"){
		$return_to   = "intro_index.php?flag=popup";
	}

	return_data("success",array("return"=>$return_to));
	exit();
	##================================================================================##
}
else if($flag=="approve"){
	$intro_type = $_POST["type"];

	if($intro_type=="intro_page"){
		$intro_id   = filter_number($_POST["intro_use"]);

		$introname_array = array();
		$intro_data = $db->query("SELECT intro_id,intro_name,intro_type,intro_use 
								  FROM   intro_list 
								  WHERE  intro_id = '$intro_id' AND intro_type='page' $owner_cond");
		while($intro_info = $db->db_fetch_array($intro_data)){
			$introname_array[$intro_info["intro_id"]] = array("name"=>$intro_info["intro_name"],
															  "type"=>$intro_info["intro_type"],
															  "use" =>$intro_info["intro_use"]);
		}

		if($introname_array[$intro_id]["use"]=="N"){
			$db->query("UPDATE intro_list
						SET    intro_use  = 'N'
						WHERE  intro_type='page'");

			$db->query("UPDATE intro_list
						SET    intro_use  = 'Y'
						WHERE  intro_id   = '$intro_id' AND intro_type='page' $owner_cond");
			$db->write_log("approve","intro","อนุมัติ intro page   ".$introname_array[$intro_id]["name"]);
		}

		$return_to   = "intro_index.php?flag=intro_page";
	}
	else if($intro_type=="popup"){
		$intro_use    = $_POST["intro_use"];
		$intro_notuse = $_POST["intro_notuse"];

		if(!is_array($intro_use)){$intro_use=array();}
		if(!is_array($intro_notuse)){$intro_notuse=array();}

		if(count($intro_use)>0){
			$intro_use_line = "'".implode("','",$intro_use)."'";

			$introname_array = array();
			$intro_data = $db->query("SELECT intro_id,intro_name,intro_type,intro_use 
									FROM intro_list WHERE intro_id IN ($intro_use_line) AND intro_type='popup' $owner_cond");
			while($intro_info = $db->db_fetch_array($intro_data)){
				$introname_array[$intro_info["intro_id"]] = array("name"=>$intro_info["intro_name"],
																"type"=>$intro_info["intro_type"],
																"use" =>$intro_info["intro_use"]);
			}
		}


		foreach($intro_notuse AS $intro_notuse_e){
			if(!in_array($intro_notuse_e,$intro_use)){
				$intro_id = ready($intro_notuse_e);

				$db->query("UPDATE intro_list
							SET    intro_use  = 'N'
							WHERE  intro_id   = '$intro_id' AND intro_type='popup' $owner_cond");
			}
		}

		foreach($intro_use AS $intro_use_e){
			$intro_id = ready($intro_use_e);

			if($introname_array[$intro_id]["use"]=="N"){
				$db->query("UPDATE intro_list
							SET    intro_use  = 'Y'
							WHERE  intro_id   = '$intro_id' AND intro_type='popup' $owner_cond");
				$db->write_log("approve","intro","อนุมัติ pop-up   ".$introname_array[$intro_id]["name"]);
			}
		}

		$return_to   = "intro_index.php?flag=popup";
	}
}
else if($flag=="delete"){
	$intro_delete = $_POST["intro_delete"];
	$intro_type   = $_POST["type"];

	if($intro_type=="intro_page"){
		$return_to   = "intro_index.php?flag=intro_page";
	}
	else if($intro_type=="popup"){
		$return_to   = "intro_index.php?flag=popup";
	}

	$type_array = array("page"=>"intro page","popup"=>"pop-up");
	if(count($intro_delete)>0){
		$intro_delete_line = "'".implode("','",$intro_delete)."'";

		$introname_array = array();
		$intro_data = $db->query("SELECT intro_id,intro_name,intro_type
		                          FROM intro_list WHERE intro_id IN ($intro_delete_line)");
		while($intro_info = $db->db_fetch_array($intro_data)){
			$introname_array[$intro_info["intro_id"]] = array("name"=>$intro_info["intro_name"],
															  "type"=>$intro_info["intro_type"]);
		}
	}
	
	foreach($intro_delete AS $intro_delete_e){
		$intro_id = ready($intro_delete_e);

		if(count($introname_array[$intro_id])!=0){
			$db->query("DELETE FROM intro_list
						WHERE       intro_id   = '$intro_id'");
			$db->query("DELETE FROM intro_button_list WHERE intro_id = '$intro_id' $owner_cond");
			$db->write_log("delete","intro","ลบ ".$type_array[$introname_array[$intro_id]["type"]]."   ".$introname_array[$intro_id]["name"]);
		}
	}
}
else if($flag=="check_date"){
	/*$date_start = trim($_POST["date_start"]);
	$date_start = explode("/",$date_start);
	$date_start = filter_date("-",$date_start[2]."-".$date_start[1]."-".$date_start[0]);

	$date_end   = trim($_POST["date_end"]);
	$date_end   = explode("/",$date_end);
	$date_end   = filter_date("-",$date_end[2]."-".$date_end[1]."-".$date_end[0]);

	$intro_type = trim($_POST["intro_type"]);
	$intro_id   = trim($_POST["intro_id"]);

	if(!in_array($intro_type,array("page","popup"))){
		$intro_type = "";
	}

	##=======================================================================================================##
	$intro_array      = array();
	$intro_data       = $db->query("SELECT   * 
	                                FROM     intro_list 
									WHERE    intro_type = '$intro_type' AND intro_id != '$intro_id'
									ORDER BY intro_show_start, intro_show_end");
	while($intro_info = $db->db_fetch_array($intro_data)){

		$c_date_start = trim($intro_info["intro_show_start"]);
		$c_date_start = explode("-",$c_date_start);
		$c_date_start = $c_date_start[2]."/".$c_date_start[1]."/".$c_date_start[0];
	
		$c_date_end   = trim($intro_info["intro_show_end"]);
		$c_date_end   = explode("-",$c_date_end);
		$c_date_end   = $c_date_end[2]."/".$c_date_end[1]."/".$c_date_end[0];

		array_push($intro_array,array("intro_name"=>$intro_info["intro_name"],
									  "intro_id"=>$intro_info["intro_id"],
									  "totime_show_start"=>strtotime($intro_info["intro_show_start"]),
									  "totime_show_end"=>strtotime($intro_info["intro_show_end"]),
									  "intro_show_start"=>$c_date_start,
									  "intro_show_end"=>$c_date_end));
	}
	##=======================================================================================================##
	if($date_start!=""){
		$totime_date_start = strtotime($date_start);
	}

	if($date_end!=""){
		$totime_date_end   = strtotime($date_end);
	}

	if($totime_date_start!="" && $totime_date_end!=""){
		if($totime_date_start>$totime_date_end){
			return_data("date_error",array("title"=>'วันที่แสดงไม่ถูกต้อง',"content"=>'วันที่เริ่มต้นต้องน้อยกว่าวันที่สิ้นสุด'));
			exit();
		}
	}

	$error         = 0;
	$collect_intro = array("name"=>array(),"id"=>array());

	foreach($intro_array AS $check){

		if($totime_date_start!=""){
			if($check["totime_show_start"]<=$totime_date_start && $totime_date_start<=$check["totime_show_end"]){
				if(!in_array($check["intro_id"],$collect_intro["id"])){
					array_push($collect_intro["id"],$check["intro_id"]);
					array_push($collect_intro["name"],$check["intro_name"]." [".$check["intro_show_start"]." ถึง ".$check["intro_show_end"]."]");
				}
				$error++;
			}
		}

		if($totime_date_end!=""){
			if($check["totime_show_start"]<=$totime_date_end && $totime_date_end<=$check["totime_show_end"]){
				if(!in_array($check["intro_id"],$collect_intro["id"])){
					array_push($collect_intro["id"],$check["intro_id"]);
					array_push($collect_intro["name"],$check["intro_name"]." [".$check["intro_show_start"]." ถึง ".$check["intro_show_end"]."]");
				}
				$error++;
			}
		}

		if($totime_date_start!="" && $totime_date_end!=""){
			if($totime_date_start<=$check["totime_show_start"] && $check["totime_show_start"]<=$totime_date_end){
				if(!in_array($check["intro_id"],$collect_intro["id"])){
					array_push($collect_intro["id"],$check["intro_id"]);
					array_push($collect_intro["name"],$check["intro_name"]." [".$check["intro_show_start"]." ถึง ".$check["intro_show_end"]."]");
				}
				$error++;
			}
			if($totime_date_start<=$check["totime_show_end"] && $check["totime_show_end"]<=$totime_date_end){
				if(!in_array($check["intro_id"],$collect_intro["id"])){
					array_push($collect_intro["id"],$check["intro_id"]);
					array_push($collect_intro["name"],$check["intro_name"]." [".$check["intro_show_start"]." ถึง ".$check["intro_show_end"]."]");
				}
				$error++;
			}
		}
	}

	if($error>0){
		$intro_type_name = array("page"=>"Intro Page","popup"=>"Pop-Up");

		$list_interval = "<div><b>รายการ ".$intro_type_name[$intro_type]." ที่มีการทับซ้อน :</b></div><ul>";
		foreach($collect_intro["name"] AS $e){
			$list_interval .= "<li> * ".$e."</li>";
		}
		$list_interval .= "</ul>";

		return_data("interval_error",array("title"=>'วันที่แสดงมีการทับซ้อน',
							   		       "content"=>'กรุณาแก้ไขวันที่แสดง',
									       "list"=>$list_interval));
	}
	*/
	exit();
}
else if($flag=="add_button"){
	$i = filter_number($_POST["current"]);
	?>
	
	<tr class="productCategoryLevel1-td" id="buttonset_row_<?php echo $i; ?>"> 
		<td class="text-center">
			<span class="buttonset_no"><?php echo $i; ?></span>.
		</td>

		<td class="text-left"> 
			<div class="form-group row">
				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px;">    
					<div>
						<label for="link_button_<?php echo $i; ?>"><b>ปุ่ม <span class="text-danger"><code>*</code></span> : </b></label>           
						<div>
							<code>ขนาดภาพที่เหมาะสม 160 x 45 px นามสกุล png,jpg</code>
						</div>         
					</div>
					<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">     
						<input type="text" class="form-control" placeholder="" id="link_button_<?php echo $i; ?>" name="link_button_<?php echo $i; ?>" value="">
					</div>
					<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-4">     
						<a href="#browse" onclick="win2 = window.open('../FileMgt/gallery_main.php?stype=link&amp;Flag=Link&amp;o_value=window.opener.document.intro_form.link_button_<?php echo $i; ?>.value','Gallery Image','top=100,left=100,width=800,height=600,resizable=1,status=0');document.intro_form.browsefile[0].checked=true;win2.focus();">
							<button type="button" class="btn btn-info  btn-sm" style="width:100%;">
							<i class="fas fa-folder-open"></i>&nbsp;เลือกไฟล์
							</button>
						</a>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px;">
							
					<div>
						<label for="link_url_<?php echo $i; ?>"><b>Link URL <span class="text-danger"><code>*</code></span> : </b></label>      
					</div>
					<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">     
						<input type="text" class="form-control" placeholder="" id="link_url_<?php echo $i; ?>" name="link_url_<?php echo $i; ?>" value="">
					</div>
					<div class="col-xl-2 col-lg-2 col-md-2 col-sm-2 col-xs-4">     
						<a href="#browse" onclick="win2 = window.open('../FileMgt/article_main.php?stype=link&amp;Flag=Link&amp;o_value=window.opener.document.intro_form.link_url_<?php echo $i; ?>.value','Link','top=100,left=100,width=800,height=600,resizable=1,status=0');document.intro_form.browsefile[0].checked=true;win2.focus();">
							<button type="button" class="btn btn-info  btn-sm" style="width:100%;">
							<i class="fas fa-folder-open"></i>&nbsp;เลือก url
							</button>
						</a>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px;">
							
					<div>
						<label for="link_target_<?php echo $i; ?>"><b> Target <span class="text-danger"></span> : </b></label>    
					</div>
					<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">   
						<select class="form-control" id="link_target_<?php echo $i; ?>" name="link_target_<?php echo $i; ?>">
							<option value="">ไม่ใช้งาน</option>
							<option value="_self">_self</option>
							<option value="_blank">_blank</option>
						</select>
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px;">
							
					<div>
						<label for="link_alt_<?php echo $i; ?>"><b> Alt <span class="text-danger"></span> : </b></label>    
					</div>
					<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">     
						<input type="text" class="form-control" placeholder="" id="link_alt_<?php echo $i; ?>" name="link_alt_<?php echo $i; ?>" value="">
					</div>
				</div>
				<div class="col-md-12 col-sm-12 col-xs-12" style="margin-bottom:20px;">
							
					<div>
						<label for="link_language_<?php echo $i; ?>"><b> Language <span class="text-danger"><code>*</code></span> : </b></label>    
					</div>
					<div class="col-xl-10 col-lg-10 col-md-10 col-sm-10 col-xs-8">   
						<select class="form-control" id="link_language_<?php echo $i; ?>" name="link_language_<?php echo $i; ?>">
							<option value="TH">TH</option>
							<option value="EN">EN</option>
						</select>
					</div>
				</div>
				<div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-xs-12" align="right" style="margin-top:20px;">
					<button type="button" class="btn btn-danger btn-sm" onclick="remove_buttonset('buttonset_row_<?php echo $i; ?>');">
						ลบปุ่ม
					</button>
				</div>
			</div>

			
			
		</td>
	</tr>
	<?php
	exit();
}
else if($flag=="load_bannerlist"){
	$banner_gid = filter_number($_POST["banner_gid"]);
	$bannerlist_data  = $db->query("SELECT * FROM banner 
									WHERE banner_gid = '$banner_gid' ORDER BY banner_position ASC");
	?>
	<div class="col-md-12 col-sm-12 col-xs-12" id="table-view"><div class="col-md-12 d-flex flex-center flex-wrap">
		<?php
		while($bannerlist = $db->db_fetch_array($bannerlist_data)){
		?>
			<div class="col-md-2 col-sm-2 col-xs-6 m-b-sm">
				<div class="card m-b-sm DivCategoryLevel1" style="width:100%;height:200px;max-height:200px;">
					<div class="card-body">
					<img src="../ewt/<?php echo $EWT_FOLDER_USER; ?>/<?php echo $bannerlist["banner_pic"]; ?>" style="width:100%;height:auto;max-height:160px;background-color:#b4b4b4;" class=" m-b-sm">
					</div>
				</div>
			</div>
		<?php
		}
		?>
	</div></div>
	<?php
	exit();
}
else if($flag=="add_banneruse"){
	$bannerlistuse = ready($_POST["banner_id"]);
	
	$banner_data = $db->query("SELECT banner_pic FROM banner WHERE banner_id = '$bannerlistuse'");

	if($db->db_num_rows($banner_data)>0){
		$this_banner = $db->db_fetch_array($banner_data);
		?>
		<div class="col-md-2 col-sm-2 col-xs-6 m-b-sm move ui-sortable-handle" id="banner_use_<?php echo $bannerlistuse; ?>" >
			<div class="card m-b-sm DivBannerUse" id="<?php echo $bannerlistuse; ?>" style="width:100%;height:240px;max-height:240px;">
				<div class="card-body" style="height:200px;max-height:200px;">
					<img src="../ewt/<?php echo $EWT_FOLDER_USER; ?>/<?php echo $this_banner["banner_pic"]; ?>" style="width:100%;height:auto;max-height:160px;background-color:#b4b4b4;" class=" m-b-sm">
				</div>
				<div align="center">
					<input class="banner_order input-inline-sm text-center" name="banner_order[]" type="text" value=""="">
					<input type="hidden" name="banner_use[]" value="<?php echo $bannerlistuse; ?>">
					<nobr>
						<button type="button" class="btn btn-danger  btn-circle  btn-xs " onclick="remove_usebanner('<?php echo $bannerlistuse; ?>');">
						<i class="far fa-trash-alt" aria-hidden="true"></i>
						</button>
					</nobr>
				</div>
			</div>
		</div>
		<?php
	}
	exit();
}

header("location:".$return_to);
?>
