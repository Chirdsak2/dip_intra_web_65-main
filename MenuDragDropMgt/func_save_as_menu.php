<?php
include("../EWT_ADMIN/comtop_pop.php"); 

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
	
if($a_data['proc']=='Save_as_Menu'){  
	
$s_data = array();  

$_sql 	= $db->query("SELECT * FROM menu_list WHERE m_id = '{$a_data['m_id']}' "); 
$a_list = $db->db_fetch_array($_sql);

$s_data['m_name']	=	$a_data['menu_title'];
$s_data['m_show']	=	$a_data['menu_show']; 

insert('menu_list',$s_data); 

$db->write_log("create","menu","เพิ่มเมนู ".$a_data['menu_title']);  
	
$_max = countmax('menu_list','m_id');   
	
	$s_prop = $db->query("SELECT * FROM menu_properties WHERE m_id = '{$a_data['m_id']}' ORDER BY mp_id ASC");
	$a_rows = $db->db_num_rows($s_prop); 
	if($a_rows)
	{
		while($a_prop = $db->db_fetch_array($s_prop)) 
		{			
			$mp_id 		=	$a_prop['mp_id']; 
			$gen_menu 	=	sprintf("%04d",$_max); 
			$m = explode("_",$mp_id);
				
			for($x = 1; $x < count($m); $x++) 
			{
				$gen_menu .="_".$m[$x]; 
			}						
					$s_datasub = array();					
					$s_datasub['mp_id']   	 	=	$gen_menu;	 				
					$s_datasub['m_id']     		= 	sprintf("%04d",$_max); 
					$s_datasub['mp_name'] 		= 	$a_prop['mp_name'];
					$s_datasub['Glink']    		= 	$a_prop['Glink'];
					$s_datasub['Oubgpic']  		= 	$a_prop['Oubgpic'];
					$s_datasub['mp_show']  		= 	$a_prop['mp_show'];
					$s_datasub['mp_pid']   		= 	$a_prop['mp_pid']; 
					
					$s_datasub['mp_sub'] 		= 	$a_prop['mp_sub'];  
					$s_datasub['mp_pos'] 		= 	$a_prop['mp_pos'];

					$s_datasub['Gtarget']  		= 	$a_prop['Gtarget'];
					$s_datasub['Oufont']   		= 	$a_prop['Oufont'];
					$s_datasub['Oubold']   		= 	$a_prop['Oubold'];
					$s_datasub['Ouitalic']   	= 	$a_prop['Ouitalic'];
					$s_datasub['Oubordercolor'] = 	$a_prop['Oubordercolor'];
					$s_datasub['popup_use']  	= 	$a_prop['popup_use'];
					$s_datasub['popup_info'] 	= 	$a_prop['popup_info'];  
		
					insert('menu_properties',$s_datasub); 
					unset($s_datasub);  
		}
	}	
	
echo($_max);	

unset($a_data);
unset($s_data);

exit;
	} 
?>