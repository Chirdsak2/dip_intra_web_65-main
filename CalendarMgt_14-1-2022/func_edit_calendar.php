<?php
include("../EWT_ADMIN/comtop_pop.php");


$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	

if($a_data['proc']=='Edit_calendar'){
	
$s_data = array();

$MAXIMUM_FILESIZE = sizeMB2byte(EwtMaxfile('file')); 
$rEFileTypes = "/^\.(".ValidfileType('file')."){1}$/i"; 

$dir_base = "../ewt/".$_SESSION['EWT_SUSER']."/download/";
$dir_base1 = "download/";	

	$isFile = is_uploaded_file($_FILES['event_link']['tmp_name']); 	
	if($isFile){    //  do we have a file? 
    $safe_filename = preg_replace( 
                     array("/\s+/", "/[^-\.\w]+/"), 
                     array("_", ""), 
                     trim($_FILES['event_link']['name']));
					 
	$type_file =  strrchr($safe_filename, '.');				 
	$newfile   = "calendar_attach_".date("YmdHis").$type_file;	 
    if ($_FILES['event_link']['size'] <= $MAXIMUM_FILESIZE && preg_match($rEFileTypes, strrchr($safe_filename , '.'))) {		
		  $isMove = move_uploaded_file ($_FILES['event_link']['tmp_name'],$dir_base.$newfile);		  
		  } 
			$a_attach = $dir_base1.$newfile;	
			if(file_exists($dir_base.$a_data['event_link_old']) && $a_data['event_link_old'] != ''){			
				unlink($dir_base.$dir_file_old);			
				}	
				}else{					
					$a_attach = $a_data['event_link_old'];
				}

if($a_data['event_date_start'] AND $a_data['event_date_end']){
	
$s = explode("/",$a_data['event_date_start']);
$e = explode("/",$a_data['event_date_end']);

//$event_date_start  = $s[2].'-'.$s[1].'-'.$s[0];
//$event_date_end    = $e[2].'-'.$e[1].'-'.$e[0];
$event_date_start  = $a_data['event_date_start'];
$event_date_end    = $a_data['event_date_end'];

}

if($a_data['start_date'] AND $a_data['end_date']){
	
$start = explode("/",$a_data['start_date']);
$end   = explode("/",$a_data['end_date']);

//$event_show_start  = $start[2].'-'.$start[1].'-'.$start[0];
//$event_show_end    = $end[2].'-'.$end[1].'-'.$end[0];
$event_show_start  = $a_data['start_date'];
$event_show_end    = $a_data['end_date'];

}
if($a_data['gen_user_id']){	
	$gen_user = $a_data['gen_user_id'];
}else{	
	$gen_user = $a_data['gen_user_id_old'];
}


$s_data['event_title']   	    =  $a_data['calendar_title'];
$s_data['cat_id']	        	=  $a_data['calendar_category'];
$s_data['event_detail']      	=  $a_data['calendar_detail'];
$s_data['event_date_start']     =  $event_date_start;
$s_data['event_time_start']     =  '';
$s_data['event_date_end']      	=  $event_date_end;
$s_data['event_time_end']      	=  '';
$s_data['event_user_id']      	=  $_SESSION['EWT_SMID'];
$s_data['event_show_start']     =  $event_show_start;
$s_data['event_show_end']      	=  $event_show_end;
$s_data['event_link']      		=  $a_attach;
$s_data['event_registor']      	=  $a_data['calendar_setregis'];
$s_data['event_registor_num']   =  $a_data['calendar_num'];
$s_data['event_location']      	=  $a_data['calendar_location'];
$s_data['event_link_registor']  =  $a_data['calendar_link_to'];
$s_data['event_relatelink']     =  $a_data['event_relatelink'];

//insert('cal_event',$s_data);
update('cal_event',$s_data,array('event_id'=>$a_data['event_id']));


update('cal_show_event',array('event_date_start'=>$event_date_start,'event_date_end'=>$event_date_end,'event_show_start'=>$event_show_start,'event_show_end'=>$event_show_end),array('event_id'=>$a_data['event_id']));



	if($a_data['gen_user_id']){	
				del('cal_invite','event_id='.$a_data['event_id']);
				$sql_insert_invite = "INSERT INTO cal_invite (event_id,person_id) VALUES ('{$a_data['event_id']}','{$a_data['gen_user_id']}')";
				$db->query($sql_insert_invite);
			}

$db->write_log("update","calendar","แก้ไขปฏิทินกิจกรรม ".$a_data['calendar_title']);					
				
//$db->write_log("create","banner","เพิ่มหมวด banner".$a_data['banner_name']);							   
//print_r($a_data);	

echo json_encode($s_data);		
//print_r($s_data);
unset($a_data);
unset($s_data);	
//echo $a_data['lang_detail'][9];
	exit;   
}else{ 
  $a_error['message'] = 'กรุณาใส่ให้ถูกต้อง';
  echo json_encode($a_error);
	unset($a_data);
	unset($s_data);
  exit;   
  } 
?>