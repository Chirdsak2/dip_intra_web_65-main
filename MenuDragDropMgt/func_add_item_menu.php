<?php
include("../lib/include.php");
include("../lib/function.php");
include("../lib/user_config.php");
include("../lib/connect.php");
include("../lib/set_lang.php");

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	

if($a_data['proc']=='Add_ITEM'){
	
$s_data = array();

$mp_name = stripslashes(htmlspecialchars($a_data['menu_title'],ENT_QUOTES));

$exec = $db->query("SELECT mp_id FROM menu_properties WHERE m_id = '{$a_data['m_id']}' ORDER BY mp_id DESC");
		if($row = $db->db_num_rows($exec)){
			$R = $db->db_fetch_array($exec);
			$m = explode("_",$R['mp_id']);
			$Nmenu = $m[1]+1;
			$gen_menu = sprintf("%04d",$a_data['m_id'])."_".sprintf("%04d",$Nmenu);			
		}else{
			$gen_menu = sprintf("%04d",$a_data['m_id'])."_0001";
		}

$_max = countmax_wh('menu_properties','mp_pid','m_id='.$a_data['m_id']);
		
$s_data['mp_id']    = $gen_menu;
$s_data['m_id']     = $a_data['m_id'];
$s_data['mp_name']  = $mp_name;
$s_data['Glink']    = $a_data['menu_link'];
$s_data['Oubgpic']  = $a_data['menu_icon'];
$s_data['mp_show']  = $a_data['menu_show'];
$s_data['mp_pid']   = $_max+1;  

	$s_data['Gtarget']  		= $a_data['item_traget'];
	$s_data['Oufont']   		= $a_data['item_align'];
	$s_data['Oubold']   		= $a_data['item_bold'];
	$s_data['Ouitalic']   		= $a_data['item_italic'];
	$s_data['Oubordercolor']   	= $a_data['item_underline'];
	
if($a_data['popup_use']=='Y'){
	$s_data['popup_use']  = $a_data['popup_use'];
	$s_data['popup_info'] = $a_data['popup_info'];
}
	

//$a_data['page_id_array'];
//for($i=0; $i<count($a_data['page_id_array']); $i++){
	
//$s_data['faq_cate_order']  = $i+1;
	
//update('faq_category',$s_data,array('faq_cate_id'=>$a_data['page_id_array'][$i]));
	
//}

insert('menu_properties',$s_data);
$db->write_log("create","menu","เพิ่ม submenu ".$mp_name);	
//$_max = countmax('m_complain_form','com_form_id');	
						   
echo json_encode($s_data);	

unset($a_data);
unset($s_data);

exit;
	} 
?>