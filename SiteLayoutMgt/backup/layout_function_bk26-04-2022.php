<?php
include("../EWT_ADMIN/comtop_pop.php");

$json_flag = array("add","edit","check_date");
if(in_array($flag,$json_flag)){
	//header('Content-type: application/json; charset=utf-8');
}

$flag        = $_POST["flag"];
$error_array = array();
$return_to   = "layout_index.php";

##=====================================================================================================##

if($db->check_permission("layout","w","")){
	$has_pass_w='Y';	
}

if($db->check_permission("layout","a","")){
	$has_pass_a='Y';	
}

if($has_pass_w=="Y"){
	$pass_w = "Y";
}
if($has_pass_a=="Y"){
	$pass_a = "Y";
}

##=====================================================================================================##

if($flag=="add" && $pass_w=="Y"){

	$site_logo 		= trim($_POST["site_logo"]);
    $site_mainmenu  = trim($_POST["site_mainmenu"]);
    $site_mainbanner= trim($_POST["site_mainbanner"]);
	
    $site_address 	= trim($_POST["site_address"]);
    $site_tel 		= trim($_POST["site_tel"]);
    $site_fax 		= trim($_POST["site_fax"]);
    $site_email 	= trim($_POST["site_email"]);
    $site_twitter 	= trim($_POST["site_twitter"]);
    $site_facebook 	= trim($_POST["site_facebook"]);
    $site_instagram = trim($_POST["site_instagram"]);
    $site_youtube 	= trim($_POST["site_youtube"]);
    $site_sitemap 	= trim($_POST["site_sitemap"]);
	$site_infobanner= trim($_POST["site_infobanner"]);
	
	$site_policy 	= trim($_POST["site_policy"]);

	//$section_order    = $_POST["section_order"];
	$section_no       = $_POST["section_no"];
	$section_title    = $_POST["section_title"];
	$section_subtitle = $_POST["section_subtitle"];
	$section_data     = $_POST["section_data"];
	
    $template_id 	= trim($_POST["template_id"]);
	$lang_id     	= trim($_POST["lang_id"]);
	##===============================================================================================##
	$site_logo 		= ready($_POST["site_logo"]);
    $site_mainmenu  = ready($_POST["site_mainmenu"]);
    $site_mainbanner= ready($_POST["site_mainbanner"]);
	
    $site_address 	= ready($_POST["site_address"]);
    $site_tel 		= ready($_POST["site_tel"]);
    $site_fax 		= ready($_POST["site_fax"]);
    $site_email 	= ready($_POST["site_email"]);
    $site_twitter 	= ready($_POST["site_twitter"]);
    $site_facebook 	= ready($_POST["site_facebook"]);
    $site_instagram = ready($_POST["site_instagram"]);
    $site_youtube 	= ready($_POST["site_youtube"]);
    $site_sitemap 	= ready($_POST["site_sitemap"]);
	$site_infobanner= ready($_POST["site_infobanner"]);
	
	$site_policy 	= ready($_POST["site_policy"]);
	
    $template_id 	= ready($_POST["template_id"]);
	$lang_id     	= ready($_POST["lang_id"]);

	$template_data   = $db->query("SELECT * FROM site_management_template 
								   WHERE template_id = '$template_id'");
	$template_info   = $db->db_fetch_array($template_data);

	## >> Insert manage
	$db->query("INSERT INTO site_management (template_id,lang_id,site_logo,site_mainmenu,
	                                         site_mainbanner,site_address,site_tel,site_fax,
											 site_email,site_twitter,site_facebook,site_instagram,
											 site_youtube,site_sitemap,site_infobanner,site_policy)
		   		VALUES ('$template_id','$lang_id','$site_logo','$site_mainbanner',
				        '$site_mainbanner','$site_address','$site_tel','$site_fax',
						'$site_email','$site_twitter','$site_facebook','$site_instagram',
						'$site_youtube','$site_sitemap','$site_infobanner','$site_policy')");

	## >> Insert section
	$section_order = 1;
		
	$section_get   = $db->query("SELECT * FROM site_management_tsection_config 
	                             WHERE template_id = '$template_id' AND section_use = 'Y' 
								 ORDER BY section_id ASC");
	while($section_info = $db->db_fetch_array($section_get)){

		$section_use  = $section_info["section_use"];
		$use_no       = $section_info["use_no"];
		$use_subtitle = $section_info["use_subtitle"];
		$section_file = $section_info["section_file"];
		$module_name  = $section_info["module_name"];
		$use_upscroll = $section_info["use_upscroll"];
			
		$this_section_no       = ready($section_no[$section_order-1]);
		$this_section_title    = ready($section_title[$section_order-1]);
		$this_section_subtitle = ready($section_subtitle[$section_order-1]);
		$this_section_data     = ready($section_data[$section_order-1]);
			
		if($section_info["use_no"]!="Y"){
			$this_section_no 		= "";
		}
		if($section_info["use_subtitle"]!="Y"){
			$this_section_subtitle   = "";
		}

		$db->query("INSERT INTO site_management_section (template_id,lang_id,section_use,section_no,
														 use_no,section_title,section_subtitle,use_subtitle,
														 section_file,module_name,section_data,section_order,
														 use_upscroll) 
		            VALUES ('$template_id','$lang_id','$section_use','',
					        '$use_no','$this_section_title','$this_section_subtitle','$use_subtitle',
							'$section_file','$module_name','$this_section_data','$section_order',
							'$use_upscroll')");
	
		$section_order++;
	}
	
	/*echo "<pre>";
	print_r($_POST);
	print_r($template_info);
	echo "</pre>";*/

	$thistemplate_data = $db->query("SELECT template_name FROM site_management_template WHERE template_id = '$template_id'");
	$thistemplate = $db->db_fetch_array($thistemplate_data);
	$thislang_data = $db->query("SELECT lang_config_suffix FROM lang_config WHERE lang_config_id = '$lang_id'");
	$thislang = $db->db_fetch_array($thislang_data);

	//exit();
	$db->write_log("create","layout","สร้าง ".$thistemplate["template_name"]." ภาษา ".$thislang["lang_config_suffix"]);
}
else if($flag=="edit" && $pass_w=="Y"){
	/*echo "<pre>";
	print_r($_POST);
	echo "</pre>";*/

	$site_logo 		= trim($_POST["site_logo"]);
    $site_mainmenu  = trim($_POST["site_mainmenu"]);
    $site_mainbanner= trim($_POST["site_mainbanner"]);
	
    $site_address 	= trim($_POST["site_address"]);
    $site_tel 		= trim($_POST["site_tel"]);
    $site_fax 		= trim($_POST["site_fax"]);
    $site_email 	= trim($_POST["site_email"]);
    $site_twitter 	= trim($_POST["site_twitter"]);
    $site_facebook 	= trim($_POST["site_facebook"]);
    $site_instagram = trim($_POST["site_instagram"]);
    $site_youtube 	= trim($_POST["site_youtube"]);
    $site_sitemap 	= trim($_POST["site_sitemap"]);
	$site_infobanner= trim($_POST["site_infobanner"]);
	
	$site_policy 	= trim($_POST["site_policy"]);
	
    $template_id 	= trim($_POST["template_id"]);
	$lang_id     	= trim($_POST["lang_id"]);
	##===============================================================================================##
	$site_logo 		= ready($_POST["site_logo"]);
    $site_mainmenu  = ready($_POST["site_mainmenu"]);
    $site_mainbanner= ready($_POST["site_mainbanner"]);
	
    $site_address 	= ready($_POST["site_address"]);
    $site_tel 		= ready($_POST["site_tel"]);
    $site_fax 		= ready($_POST["site_fax"]);
    $site_email 	= ready($_POST["site_email"]);
    $site_twitter 	= ready($_POST["site_twitter"]);
    $site_facebook 	= ready($_POST["site_facebook"]);
    $site_instagram = ready($_POST["site_instagram"]);
    $site_youtube 	= ready($_POST["site_youtube"]);
    $site_sitemap 	= ready($_POST["site_sitemap"]);
	$site_icon 		= ready($_POST["site_icon"]);
	$site_infobanner= ready($_POST["site_infobanner"]);
	$site_policy 	= ready($_POST["site_policy"]);
    $template_id 	= ready($_POST["template_id"]);
	$lang_id     	= ready($_POST["lang_id"]);

	$db->query("UPDATE site_management
				SET    site_logo 		= '$site_logo',
					   site_mainmenu    = '$site_mainmenu',
					   site_mainbanner 	= '$site_mainbanner',
					   site_address 	= '$site_address',
					   site_tel 		= '$site_tel',
					   site_fax 		= '$site_fax',
					   site_email 		= '$site_email',
					   site_twitter 	= '$site_twitter',
					   site_facebook 	= '$site_facebook',
					   site_instagram 	= '$site_instagram',
					   site_youtube 	= '$site_youtube',
					   site_sitemap 	= '$site_sitemap',
					   site_infobanner 	= '$site_infobanner',
					   site_icon        = '$site_icon',
					   site_policy 		= '$site_policy'
				WHERE  template_id 		= '$template_id' AND lang_id = '$lang_id'");
	
	//exit();

	$thistemplate_data = $db->query("SELECT template_name FROM site_management_template WHERE template_id = '$template_id'");
	$thistemplate = $db->db_fetch_array($thistemplate_data);
	$thislang_data = $db->query("SELECT lang_config_suffix FROM lang_config WHERE lang_config_id = '$lang_id'");
	$thislang = $db->db_fetch_array($thislang_data);

	$db->write_log("edit","layout","แก้ไข ".$thistemplate["template_name"]." ภาษา ".$thislang["lang_config_suffix"]);
}
else if($flag=="section_reorder" && $pass_w=="Y"){
	$page_id_array  = $_POST["page_id_array"];
    $template_id 	= ready($_POST["template_id"]);
	$lang_id     	= ready($_POST["lang_id"]);

	$order = 1;
	foreach($page_id_array AS $section_id){
		$section_id = ready($section_id);
		$db->query("UPDATE site_management_section SET section_order = '$order' WHERE section_id = '$section_id'");
		$order++;
	}
	exit();
}
else if($flag=="calendar_reorder" && $pass_w=="Y"){
	$page_id_array  = $_POST["page_id_array"];

	$order = 1;
	foreach($page_id_array AS $section_id){
		$section_id = ready($section_id);
		$db->query("UPDATE cal_manager SET m_order = '$order' WHERE m_id = '$section_id'");
		$order++;
	}
	exit();
}
else if($flag=="edit_section" && $pass_w=="Y"){
	$section_id 		= trim($_POST["section_id"]);
	$section_no 		= trim($_POST["section_no"]);
	$section_title 		= trim($_POST["section_title"]);
	$section_subtitle   = trim($_POST["section_subtitle"]);
	$section_data 		= trim($_POST["section_data"]);
	$section_data2 		= trim($_POST["section_data2"]);
	$section_data3 		= trim($_POST["section_data3"]);

	$section_dat  = $db->query("SELECT * FROM site_management_section WHERE section_id = '$section_id'");
	$section_info = $db->db_fetch_array($section_dat);		

	if($section_info["use_no"]!="Y"){
		$section_no 		= "";
	}
	if($section_info["use_subtitle"]!="Y"){
		$section_subtitle   = "";
	}
	
	##===============================================================================================##
	$section_id 		= ready($section_id);
	$section_no 		= ready($section_no);
	$section_title 		= ready($section_title);
	$section_subtitle   = ready($section_subtitle);

	if($section_info["module_name"]=="text"){
		$section_data 		= esc($section_data);
	}else{
		$section_data 		= ready($section_data);
	}

	if(!empty($section_data2) && !empty($section_data3)){
		$section_data = "$section_data,$section_data2,$section_data3";
	}

	$db->query("UPDATE site_management_section 
				SET    section_no       = '$section_no',
				       section_title    = '$section_title',
				       section_subtitle = '$section_subtitle',
				       section_data     = '$section_data'
			    WHERE  section_id       = '$section_id'");
	
	$thistemplate_data = $db->query("SELECT template_name FROM site_management_template WHERE template_id = '$template_id'");
	$thistemplate = $db->db_fetch_array($thistemplate_data);
	$thislang_data = $db->query("SELECT lang_config_suffix FROM lang_config WHERE lang_config_id = '$lang_id'");
	$thislang = $db->db_fetch_array($thislang_data);

	$db->write_log("edit","layout","แก้ไข ".$thistemplate["template_name"]." ภาษา ".$thislang["lang_config_suffix"]);
	exit();
}
else if($flag=="approve" && $pass_a=="Y"){
	$template_use  = ready($_POST["template_use"]);

	$db->query("UPDATE site_management_template SET template_use = 'N'");
	$db->query("UPDATE site_management_template SET template_use = 'Y' WHERE template_id = '$template_use'");
	
	$thistemplate_data = $db->query("SELECT template_name FROM site_management_template WHERE template_id = '$template_use'");
	$thistemplate = $db->db_fetch_array($thistemplate_data);
	$db->write_log("approve","layout","ใช้งาน ".$thistemplate["template_name"]);
}

header("location:".$return_to);
?>
