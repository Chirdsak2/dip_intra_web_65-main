<?php
include("../EWT_ADMIN/comtop_pop.php"); 

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	

if($a_data['proc']=='EDIT_ITEM'){
	
$s_data = array();

$mp_name = stripslashes(htmlspecialchars($a_data['menu_title'],ENT_QUOTES));

	if($a_data['menu_icon'] == 'fa iconpicker-component')
	{
		$menu_icon = $a_data['menu_icon_old'];
	}
	else
	{
		$menu_icon = $a_data['menu_icon'];
	}

	if(!empty($a_data['item_align']))
	{
		$item_align = $a_data['item_align'];
	}
	else
	{
		$item_align = $a_data['item_align_old'];
	}
	
	if(!empty($a_data['item_bold'])){$item_bold = $a_data['item_bold'];}else{$item_bold = $a_data['item_bold_old'];}
	if(!empty($a_data['item_italic'])){$item_italic = $a_data['item_italic'];}else{$item_italic = $a_data['item_italic_old'];}
	if(!empty($a_data['item_underline'])){$item_underline = $a_data['item_underline'];}else{$item_underline = $a_data['item_underline_old'];}

	$s_data['mp_name']  = $mp_name;
	$s_data['Glink']    = $a_data['menu_link'];
	$s_data['Oubgpic']  = $menu_icon;
	$s_data['mp_show']  = $a_data['menu_show'];
	$s_data['Gtarget']  		= $a_data['item_traget'];
	$s_data['Oufont']   		= $item_align;
	$s_data['Oubold']   		= $a_data['item_bold'];
	$s_data['Ouitalic']   		= $a_data['item_italic'];
	$s_data['Oubordercolor']   	= $a_data['item_underline'];
	//$a_data['page_id_array'];
	//for($i=0; $i<count($a_data['page_id_array']); $i++){

	if($a_data['popup_use']=='Y'){
		$s_data['popup_use']  = $a_data['popup_use'];
		$s_data['popup_info'] = $a_data['popup_info'];
	}
			 
	//$s_data['faq_cate_order']  = $i+1;
	
	update('menu_properties',$s_data,array('m_id'=>$a_data['m_id'],'mp_pid'=>$a_data['mp_pid']));
	
	//}

	//insert('menu_properties',$s_data);
	$db->write_log("update","menu","แก้ไขเมนูย่อย  ".$mp_name);	
	//$_max = countmax('m_complain_form','com_form_id');	
						   
echo json_encode($s_data);	

unset($a_data);
unset($s_data);

exit;
	} 
?>