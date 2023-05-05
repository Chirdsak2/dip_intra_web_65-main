<?php
include("../EWT_ADMIN/comtop_pop.php");


//$date = new DateTime();

$a_data = array_merge($_POST, $_FILES);
$s_data = array();	

if($a_data['proc']=='DelAns'){
	
del('poll_ans','a_id='.$a_data['id']);
//del('cal_show_event','event_id='.$a_data['id']);
/*$s_data = array();
$_sql = $db->query("SELECT *
					FROM permission 
					WHERE 
					pu_id = '{$a_data['mid']}' 
					AND p_type = '{$a_data['mtype']}'  
					AND UID = '{$a_data['UID']}'
					AND s_type = 'suser'
					");
$a_rows = $db->db_num_rows($_sql);	
$a_data_permission = $db->db_fetch_array($_sql);
//$a_data['page_id_array'];
for($i=0; $i < count($a_data['page_id_array_form']); $i++){
		
$c = explode("#",$a_data['page_id_array_form'][$i]);

if(!empty($c[0])){
if($c[0] != 'suser'){
	if($a_rows){
		del('permission','p_id='.$a_data_permission['p_id']);
	}
}else{
	
	del('permission',"pu_id='".$a_data['mid']."' AND UID='".$a_data['UID']."' AND p_type='".$a_data['mtype']."' ");
}
	
$s_data['p_type']  		 = $a_data['mtype'];	
$s_data['pu_id']  		 = $a_data['mid'];
$s_data['UID']  		 = $a_data['UID'];
$s_data['s_type']  		 = $c[0];
$s_data['s_id']  		 = '0';
$s_data['s_name']  		 = '';
$s_data['s_permission']  = $c[1];
//$s_data['com_ele_id']  = $a_data['page_id_array_form'][$i];
//$s_data['com_ele_order']  = $i+1;
	
//update('faq_category',$s_data,array('faq_cate_id'=>$a_data['page_id_array'][$i]));

insert('permission',$s_data);	

}
}*/	

//$db->write_log("create","banner","เพิ่มหมวด banner".$a_data['banner_name']);							   
//print_r($s_data);	
echo json_encode($s_data);	
unset($a_data);
unset($s_data);

exit;
	}
	
?>