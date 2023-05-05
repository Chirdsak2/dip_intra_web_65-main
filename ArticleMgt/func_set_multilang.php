<?php
include("../EWT_ADMIN/comtop_pop.php");

$_host = $_SERVER['HTTP_HOST'];	
$_name = $_SERVER['SCRIPT_NAME'];
$_url = $_SERVER['REQUEST_URI'];	
$_protocal = (isset($_SERVER['HTTPS']))?'https':'http';
	
	function getEwt1($_url){
	
   $s_method = strtok($_url, '?');
    if($s_method)
    {
      $a_method = explode('/', $s_method);

		$chk_site = "/".$a_method[1]."/";
		
		return  $chk_site;
	}
}
$_directory = getEwt1($_url);


$a_data = array_merge($_POST, $_FILES);

if($a_data['proc']=='set_lang'){
	/*for($i=0;$i<$a_data['num'];$i++){
		if($a_data['lang_detail'][$i] != ''){
			$a_data['lang_detail'][4] .= $a_data['lang_detail'][$i];
		}
	}*/
		
	$MAXIMUM_FILESIZE = sizeMB2byte(EwtMaxfile('file')); 
	$rEFileTypes = "/^\.(".ValidfileType('file')."){1}$/i"; 	
	
	if($a_data['news_use'] == '1'){		
		if($a_data['browsefile']=='1'){			
			$a_data['lang_detail'][9] = $a_data['link'];
			$a_data['lang_detail'][10] = $a_data['browsefile'];			
		}
		else{
			$Current_Dir2 = "../ewt/".$_SESSION["EWT_SUSER"]."/download/article/";				
			$Current_Dir3 = "download/article/";
			
			
			/*@mkdir ($Current_Dir2, 0777);
				if($_FILES["filebrowse"]['size'] > 0 ){
				$F = explode(".",$_FILES["filebrowse"]["name"]);
				$C = count($F);
				$CT = $C-1;
				$dir = strtolower($F[$CT]);
				$nfile = "article_".date("YmdHis");
				$picname = $nfile.".".$dir;
				//copy($_FILES['filebrowse']['tmp_name'],$Current_Dir2."/".$picname);
				move_uploaded_file ($_FILES['filebrowse']['tmp_name'],$Current_Dir2."/".$picname);
				@chmod ($Current_Dir2."/".$picname, 0777);
				$a_data['lang_detail'][9] = $Current_Dir3."/".$picname;
				$a_data['lang_detail'][10] = $a_data['browsefile'];	*/
						

			//$dir_base = "files/"; 
			$isFile = is_uploaded_file($_FILES['filebrowse']['tmp_name']); 
			if ($isFile){    //  do we have a file? 
			//  sanatize file name 
			//     - remove extra spaces/convert to _, 
			//     - remove non 0-9a-Z._- characters, 
			//     - remove leading/trailing spaces 
			//  check if under 5MB, 
			//  check file extension for legal file types 
			$safe_filename = preg_replace( 
							array("/\s+/", "/[^-\.\w]+/"), 
							array("_", ""), 
							trim($_FILES['filebrowse']['name']));
							
			$type_file =  strrchr($safe_filename, '.');				 
			$newfile = "article_".date("YmdHis")."_".$a_data['lang_name'].$type_file;	 
			if ($_FILES['filebrowse']['size'] <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename, '.'))) {		
				$isMove = move_uploaded_file ($_FILES['filebrowse']['tmp_name'],$Current_Dir2.$newfile);		  
				} 
			$a_data['lang_detail'][9] = $Current_Dir3.$newfile;
			}	
			
			$a_data['lang_detail'][10] = $a_data['browsefile'];	
				
		}
	}

	for($i=0;$i<$a_data['num'];$i++){
		if($a_data['lang_field'][$i]){
			if($a_data['lang_datack'][$i]){				
				$newContent = str_replace($_protocal."://".$_host.$_directory."js/","../js/",$a_data['lang_datack'][$i]);			
				$a_data['lang_detail'][$i] =  $newContent;			
			}			
			set_lang($a_data['c_id'],$a_data['lang_name'],$a_data['lang_field'][$i],esc($a_data['lang_detail'][$i]),$a_data['module']);
		}
	}	


	for($n=0;$n<$a_data['num_attach'];$n++){	
	
	$dir_base = "../ewt/".$_SESSION['EWT_SUSER']."/article_attach/";
	
		$isFile = is_uploaded_file($_FILES['lang_attach']['tmp_name'][$n]); 	
		if($isFile){    //  do we have a file? 
		$safe_filename = preg_replace( 
						array("/\s+/", "/[^-\.\w]+/"), 
						array("_", ""), 
						trim($_FILES['lang_attach']['name'][$n]));
						
		$type_file =  strrchr($safe_filename, '.');				 
		$newfile   = "article_".date("YmdHis")."_attach_".$a_data['lang_attach_field'][$n]."_".$a_data['lang_name'].$type_file;	 
		if ($_FILES['lang_attach']['size'][$n] <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename , '.'))) {		
			$isMove = move_uploaded_file ($_FILES['lang_attach']['tmp_name'][$n],$dir_base.$newfile);		  
			} 
		$a_attach = $newfile;	
		if(file_exists($dir_base.$a_data['lang_attach_old'][$n]) && $a_data['lang_attach_old'][$n] != ''){			
			unlink($dir_base.$dir_file_old);			
			}	
			}else{					
				$a_attach = $a_data['lang_attach_old'][$n];
			}
				
				set_lang($a_data['c_id'],$a_data['lang_name'],$a_data['lang_attach_field'][$n],esc($a_attach),$a_data['module']);	
				set_lang($a_data['c_id'],$a_data['lang_name'],$a_data['lang_name_attach_field'][$n],esc($a_data['lang_name_attach'][$n]),$a_data['module']);									
	}

	## >> Set tag - lang Article tag
	$nid     = ready($a_data['c_id']);
	$lang_id = ready($a_data['lang_name']);

	$article_tag = trim($_POST["article_tag"]);
	$db->query("DELETE FROM article_taglist WHERE n_id = '$nid' AND lang_id = '$lang_id'");

	if($article_tag!=""){
		$article_tag = explode(",",$article_tag);
		$unique_tag  = array();

		foreach($article_tag AS $tag_e){
			if(!in_array($tag_e,$unique_tag)){
				array_push($unique_tag,ready($tag_e));
			}
		}

		foreach($unique_tag AS $tag_e){
			## >> Insert
			$db->query("INSERT INTO article_taglist (n_id,lang_id,tag_name) VALUES ('$nid','$lang_id','$tag_e')");

			## >> Count and update
			$check_tag  = strtolower($tag_e);
			$check_list = $db->query("SELECT tag_id FROM article_tagcount WHERE tag_name = '$check_tag' COLLATE utf8_bin AND lang_id = '$lang_id'");

			if($db->db_num_rows($check_list)==0){
				$db->query("INSERT INTO article_tagcount (tag_name,lang_id,tag_count) VALUES ('$check_tag','$lang_id','1')");
			}
			else{
				$list_info = $db->db_fetch_array($check_list);
				$tag_id    = $list_info["tag_id"];
				
				$count = $db->query("SELECT COUNT(taglist_id) AS total FROM article_taglist WHERE tag_name = '$tag_e' COLLATE utf8_bin AND lang_id = '$lang_id'");
				$count = $db->db_fetch_array($count);
				$total = $count["total"];

				$db->query("UPDATE article_tagcount SET tag_count = '$total' WHERE tag_id = '$tag_id' AND lang_id = '$lang_id'");
			}
		}
	}

	print_r($a_data);	
	//echo $a_data['lang_detail'][9];
	exit;
   
}else if($a_data['proc']=='set_lang_group'){
	
	for($i=0;$i<$a_data['num'];$i++){
		if($a_data['lang_field'][$i]){
		set_lang($a_data['c_id'],$a_data['lang_name'],$a_data['lang_field'][$i],$a_data['lang_detail'][$i],$a_data['module']);
		}
	}
	
print_r($a_data); 
	exit;
} 

?>