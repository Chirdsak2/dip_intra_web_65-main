<?php
include("../EWT_ADMIN/comtop_pop.php");
$a_data = array_merge($_POST, $_FILES);
$proc = $a_data['proc'];
//print_r($a_data);
//exit;
switch($proc) 
{ 
	case "Add_OrgUser":		

	
$db->query("USE ".$EWT_DB_USER);

		
if(!empty($_FILES['txt_org_list_image']['tmp_name']))
{	
$db->query("USE ".$EWT_DB_NAME);	
$MAXIMUM_FILESIZE_IMG = sizeMB2byte(EwtMaxfile('img')); 
$rEFileTypes_IMG = "/^\.(".ValidfileType('img')."){1}$/i"; 

$Current_Dir = "../ewt/pic_upload/";
$isFile = is_uploaded_file($_FILES['txt_org_list_image']['tmp_name']); 
if($isFile)
{   
	$safe_filename = preg_replace( 
                     array("/\s+/", "/[^-\.\w]+/"), 
                     array("_", ""), 
                     trim($_FILES['txt_org_list_image']['name']));					 
	$type_file 	=  strrchr(strtolower($safe_filename), '.');				 
	$newfile 	= 'image_file_'.date("YmdHis").$type_file;
	 
    if ($_FILES['txt_org_list_image']['size'] <= $MAXIMUM_FILESIZE_IMG && preg_match($rEFileTypes_IMG, strrchr(strtolower($safe_filename), '.'))) 
	{	
		$isMove = move_uploaded_file($_FILES['txt_org_list_image']['tmp_name'],$Current_Dir.$newfile);		  
	} 
		$image_file = $newfile;
}
else
	{
		$image_file = "";		  	  
	}
}

$db->query("USE ".$EWT_DB_USER);

	
$s_data = array();
$s_data['emp_type_name']       =  $a_data['txt_org_list_type'];
$s_data['emp_img']  		=  $image_file;
$s_data['emp_type_date']    	=  date("Y-m-d"); 


insert('emp_type',$s_data);

$db->query("USE ".$EWT_DB_NAME);	
					   
sys::save_log('create','org','เพิ่มประเภทบุคลากร'.' '.$a_data['txt_org_list_type'].'');

//unset($a_data);
//unset($s_data);
			
$a_array['status'] 	= true;
$a_array['message'] = "success";

$a_data['url'] = "../MemberOrgMgt/org_type_list.php";

	echo json_encode($a_data);	
	exit;	
break;
}
