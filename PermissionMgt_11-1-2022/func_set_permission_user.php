<?php
include("../EWT_ADMIN/comtop_pop.php");

$db->query("USE ".$EWT_DB_USER);

$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
$s_data = array();	

if($a_data['proc']=='Add'){
	
	for($i=0;$i<$_POST["alli"];$i++){
		$chk = $_POST["chk".$i];
		$uid = $_POST["uid".$i];
		if($chk == "Y"){
		 $sqlchk = $db->query("SELECT COUNT(ugm_id) FROM web_group_member WHERE ug_id = '".$_POST["ug"]."' AND ugm_type = 'U' AND ugm_tid = '".$uid."' ");
 		 $C = $db->db_fetch_row($sqlchk);
		 		if($C[0] == 0){
						$db->query("INSERT INTO web_group_member (ug_id,ugm_type,ugm_tid) VALUES ('".$_POST["ug"]."','U','".$uid."') ");
				}
		//}else{
				//$sqlchk = $db->query("DELETE FROM web_group_member WHERE ug_id = '".$_POST["ug"]."' AND ugm_type = 'U' AND ugm_tid = '".$uid."' ");
				//$sqlchk = $db->query("DELETE FROM permission WHERE UID = '".$_POST["ug"]."' AND p_type = 'U' AND pu_id = '".$uid."' ");
		//}
	
		$s_uid  = $uid;
	}
}
//del('m_complain_form_element','com_ele_fid='.$a_data['com_fid']);	

//$s_data = array();

//$a_data['page_id_array'];
//for($i=0; $i<count($a_data['page_id_array_form']); $i++){
	
//$s_data['com_ele_fid']  = $a_data['com_fid'];
//$s_data['com_ele_id']  = $a_data['page_id_array_form'][$i];
//$s_data['com_ele_order']  = $i+1;
	
//update('faq_category',$s_data,array('faq_cate_id'=>$a_data['page_id_array'][$i]));

//insert('m_complain_form_element',$s_data);	
//}
							   
//print_r($s_data);	
echo url_encode($s_uid);	
unset($a_data);
unset($s_data);

exit;
	} 
?>